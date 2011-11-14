<?php
require_once 'includes/config/globals.php';
require_once 'exceptions/CacheException.php';
require_once 'includes/services/file_services/caching_services.php';
require_once 'models/BaseObject.php';
require_once 'caching/Page_File.php';
require_once 'caching/Page_Edit.php';
require_once 'includes/models/page/page.php';

/**
 * Description of CacheManager
 *
 * @author Goodwin Ogbuehi
 */
class CacheManager extends BaseObject {
    protected $pf;
    protected $allPe;
    protected $currentPe;

    protected $cs;
    public $user;
    function __construct(Page_File $pf=null) {
        parent::__construct();
        $this->user = Page_File::NULL;
        $this->cs = new CachingServices();
        if (is_null($pf)) {
            $cacheArgs = Page_File::setArgs();
            $pf = new Page_File($cacheArgs);
        }
        $this->setPageFile($pf);
        
    }

    function setPageFile(Page_File $pf) {
        $this->pf = $pf;
        $this->updateEditInfo();
        
    }
    function updateEditInfo() {
        if ($this->pf->isPersistent) {
            $this->currentPe = new Page_Edit();

            $idArray = $this->pf->getId();
            //$this->allPe = $this->currentPe->get(key('page_file'),current($idArray));
            $fieldsAndValues = array(
                'page_file' => $idArray['page_name'],
                'domain' => $idArray['domain']
            );
            $this->allPe = $this->currentPe->getComplex($fieldsAndValues);
            if (!$this->hasCache()) {
                //Create a cache
                $this->info("{$this->pf} does not have a cache. It needs to be created.");

            }
            else {
                //Assign currentPe to the most recent edit
                //$this->debug("{$this->pf} does have a cache. Getting the most recent edit.");
                if (usort($this->allPe,array(get_class($this),"page_edit_comparison"))) {
                    $currentPe = current($this->allPe);
                    //$this->debug("Page_Edits sorted. Current Page_Edit is: $currentPe");
                    $this->currentPe = $currentPe;
                }
                else {
                    $this->warn("Page_Edits sort failed.");
                }
            }
        }
        else {
            $this->info('This uri does not have an associated page_file.');
        }
    }

    static function page_edit_comparison(Page_Edit $a,Page_Edit $b) {
        if ($a->getTimestamp() == $b->getTimestamp()) {
            return 0;
        }
        return ($a->getTimestamp() > $b->getTimestamp()) ? -1 : 1;
    }
    function generateFileName($name,$timestamp) {
        
        switch($_SERVER['SERVER_NAME']) {
            case SUBDOMAIN_901:
                $domain = '_901_';
                break;
            case SUBDOMAIN_999:
                $domain = '_999_';
                break;
            default:
                $domain = '_www_';
        }
        return 'cache'.$domain.$name.'_'.$timestamp.'.html';
    }
    function createCache($contentSource,$hasDynamicContent=false) {
        //Read in contents from the ContentSource
        //For now, this will just be a string coming into the function
        $contents = $contentSource;

        $contents = $this->cleanContents($contents);

        //Determine what file the contents need to go into
        $timestamp = $_SERVER['REQUEST_TIME'];
        $filename = $this->generateFileName($this->pf->getName(), $timestamp);
        //$filename = 'cache_'.$this->pf->getName().'_'.$timestamp.'.html';
        //$this->debug('Creating cache for filename: '.$filename);
        //Save the contents to the file
        $this->cs->saveDataToFile($filename, $contents);

        //Test that the contents are valid
        $testData = $this->cs->getDataFromFile($filename);
        if ($testData === $contents) {
            //If the contents are valid, then update the current cache
            $this->currentPe->setDefaultValues($this->pf);
            $this->currentPe->d_has_dynamic_content = $hasDynamicContent;
            $this->currentPe->d_o_user = $this->user;
            $this->currentPe->save();
            array_unshift($this->allPe, $this->currentPe);
            $revInfo = $this->getRevInfo();
            $contents = str_replace("</body>", $revInfo."</body>", $contents);
            $this->cs->saveDataToFile($filename, $contents);
            
        }
        else {
            //If the contents are not valid, revert to the last cached version
            $this->warn("Contents did not match if File($filename). Needs to revert to last cache.");
            $revInfo = "<span>Rev. ERROR: Cache Creation Failed</span>";
            $contents = str_replace("</body>", $revInfo."</body>", $contents);
        }

        return $contents;
    }
    /**
     * Method to update the cache using page contents provided from an external
     * source
     * Note: This currently does not work with pages that have dynamic content
     * @param <String> $uri
     * @param <String> $contents
     * @param <boolean> $hasDynamicContent
     */
    function updateCacheFromService($uri,$contents,$hasDynamicContent=false) {
        $msg = 'No action taken.';
        $pf = new Page_File(array('uri' => $uri,'domain' => $_SERVER['SERVER_NAME']));
        if ($pf->isPersistent) {
            $this->setPageFile($pf);
            $pageClass = $this->pf->getName();
            $pageTimestamp = $this->currentPe->getTimestamp();
            if ($this->hasCache()) {
                $filename = $this->generateFileName($pageClass, $pageTimestamp);
                $fileContents = $this->cs->getDataFromFile($filename);
                $fileContents = str_replace($this->getRevInfo(), '', $fileContents);
            }

            else {
                $fileContents = '';
            }
            if ($contents !== $fileContents) {
                if ($this->currentPe->d_has_dynamic_content) {
                    $hasDynamicContent = true;
                }
                $this->createCache($contents,$hasDynamicContent);
                $msg = "New Cache created for $pageClass.";

            }
            else {
                $msg = $this->pf->getName().'\'s content is the same as the current cache.';
                $this->info($msg);
                throw new CacheException($msg,CacheException::CODE_CACHE_CONTENT_UNCHANGED);
            }
        }
        else {
            $msg = "Cannot update because current {$pf} is not persistent.";
            $this->error($msg);
            throw new CacheException($msg,CacheException::CODE_NO_CACHE_RECORD);
        }
        return $msg;
    }
    function updateHeadersAndFooters() {
         if ($this->pf->isPersistent) {
            if ($this->hasCache()) {
                $pageClass = $this->pf->getName();
                $filename = $this->generateFileName($pageClass, $this->currentPe->getTimestamp());
                $fileContents = $this->cs->getDataFromFile($filename);
                $fileContents = str_replace($this->getRevInfo(), '', $fileContents);
                $page = $this->getPageClassInstance($this->pf->getUri());
                $dynamicHtml = $page->getHtml();
                require_once 'pages/PageTemplate.php';
                $updatedFileContents = PageTemplate::insertDynamicConent(PageTemplate::SPECIAL_UPDATE_ALL_PAGES, $fileContents, $dynamicHtml);
                $this->createCache($updatedFileContents,$this->currentPe->d_has_dynamic_content);
                return 'Header and Footer replaced for '.$pageClass;
                //return $updatedFileContents;
            }
         }
    }
    function updateCache() {
        $msg = 'No action taken.';
        if ($this->pf->isPersistent) {
            //$this->debug("Page_File is persistent, so we'll go ahead and update it's cache...");
            $pageClass = $this->pf->getName();
            $pageTimestamp = $this->currentPe->getTimestamp();
            if ($this->hasCache()) {
                $filename = $this->generateFileName($pageClass, $pageTimestamp);
                $fileContents = $this->cs->getDataFromFile($filename);
                $fileContents = str_replace($this->getRevInfo(), '', $fileContents);
            }
            else {
                $fileContents = '';
            }
            $page = $this->getPageClassInstance($this->pf->getUri());
            $contents = $this->getPageContents($page);
            $placeholdArray = null;
            if ($this->currentPe->d_has_dynamic_content) {
                require_once 'pages/PageTemplate.php';
                $placeholdArray = PageTemplate::getPlaceholdArray($pageClass);
                $fileContents = PageTemplate::getPlaceheldHtml($placeholdArray,$fileContents);
            }
            if ($page->hasDynamicContent) {
                require_once 'pages/PageTemplate.php';
                if (is_null($placeholdArray)) {
                    $placeholdArray = PageTemplate::getPlaceholdArray($pageClass);
                }
                $contents = PageTemplate::getPlaceheldHtml($placeholdArray,$contents);
            }

            if ($contents !== $fileContents) {
                $this->createCache($contents,$page->hasDynamicContent);
                $msg = "New Cache created for $pageClass.";
                /*
                $conLen = strlen($contents);
                $filConLen = strlen($fileContents);

                $maxLen = ($conLen > $filConLen ? $filConLen : $conLen);
                $len = 30;
                for ($i = 0; $i < $maxLen; $i=$i+$len) {
                    $str1 = substr($contents, $i, $len);
                    $str2 = substr($fileContents,$i, $len);
                    if ($str1 !== $str2) {
                        $msg .= "There was a mismatch between version for {$pageClass}.\nCHAR($i):[$str1][$str2]";
                        $this->debug($msg);
                        break;
                    }
                }
                 */
            }
            else {
                $msg = $this->pf->getName().'\'s content is the same as the current cache.';
                $this->info($msg);
            }
        }
        else {
            $msg = "Cannot update because current {$this->pf} is not persistent.";
            $this->warn($msg);
        }
        return $msg;
    }

    function getCurrenCache() {
        if ($this->pf->isPersistent) {
            if ($this->hasCache()) {
                $pageClass = $this->pf->getName();
                $filename = $this->generateFileName($pageClass, $this->currentPe->getTimestamp());
                if ($this->currentPe->d_has_dynamic_content) {
                    $this->tLog->debug("Getting contents of File($filename)");
                    $fileContents = $this->cs->getDataFromFile($filename);
                    require_once 'pages/PageTemplate.php';
                    //$pageContent = new PageTemplate($pageClass);
                    //$dynamicHtml = $pageContent->getHtml();
                    $page = $this->getPageClassInstance();
                    $dynamicHtml = $page->getHtml();
                    return PageTemplate::insertDynamicConent($pageClass, $fileContents, $dynamicHtml);
                    //return $dynamicHtml;
                }
                include_once $filename;
                //return $this->updateHeadersAndFooters();
            }
            else {
                //A cache needs to be created from the class provided
                //This will need to be refactored, so that it allows a content source
                //to be provided.

                $page = $this->getPageClassInstance();
                $contents = $page->getHtml();
                return $this->createCache($contents,$page->hasDynamicContent);
                //return $contents;
            }
        }
        else {
            return '';
        }
    }
    /**
     * Get's an instance of the page building class
     * @return <Page>
     */
    function getPageClassInstance($uri=null) {
        $pageClass = $this->pf->getName();
        require_once 'pages/'.$pageClass.'.php';
        return new $pageClass($uri);
    }

    function getPageContents(Page $page = null) {
        if (is_null($page)) {
            $page = $this->getPageClassInstance();
        }
        $contents = $page->getHtml();
        
        return $this->cleanContents($contents);
    }

    function getDynamicElements() {
        
    }

    function cleanContents($contents) {
        //Get rid of any unnecessary "<?xml..." as this will cause some PHP
        //parsers to try to read the file as PHP code
        return str_replace(
            array(
                "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n",
                "<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>"

            ),
            "", $contents);
    }

    function getPriorCaches() {
        return $this->allPe;
    }

    function revertToCache() {
        
    }

    function hasCache() {
        return (count($this->allPe) > 0);
    }

    function getRevInfo() {
        return "<span>Rev. ".current($this->currentPe->getId())."</span>";
    }
}
?>
<?php
require_once 'includes/models/page/bmcd/bmcd_901_page.php';

/**
 * Description of PageTemplate
 *
 * @author Goodwin Ogbuehi
 */
class PageTemplate extends Bmcd901Page {
    const DYNAMIC_PAGE_TEMPLATE='TEMPLATE';
    const DYNAMIC_PAGE_HOME='HomePage';
    const DYNAMIC_PAGE_INVENTORY='InventoryPage';
    const DYNAMIC_PAGE_MODEL_INFO='ModelLineupPage';
    const DYNAMIC_PAGE_STORE='StorePage';
    const DYNAMIC_PAGE_CALENDAR='CalendarPage';

    const SPECIAL_UPDATE_ALL_PAGES='AllPages';
    
    const PLACEHOLDER='[CONTENT GOES HERE]';

    const INVENTORY_IDENTIFIER='_901_inventory_';
    const MODEL_LINEUP_IDENTIFIER='_901_model_lineup_';

    function __construct($dynamicPage='TEMPLATE') {
        //parent::__construct('',($dynamicPage !== self::DYNAMIC_PAGE_TEMPLATE));
        //$this->makeContent($dynamicPage);
    }
    //Constants for static functions
    const HTML_STRING = 'htmlString';
    const START_POS = 'startPos';
    const END_POS = 'endPos';
    const HTML_PLACEHOLDER = 'placeholder';
    const HTML_COUNT = 'htmlCount';
    const SUPPLEMENTAL_INFO = 'supplementalInfo';

    const PLACEHOLDER_TYPE_INVENTORIES='inventories';
    const PLACEHOLDER_TYPE_INVENTORY_HEADER='inventoryHeader';
    const PLACEHOLDER_TYPE_PAGE_TITLE='pageTitle';
    const PLACEHOLDER_TYPE_MODEL_LINEUP='modelLineup';
    const PLACEHOLDER_TYPE_STORE='store';
    const PLACEHOLDER_TYPE_CALENDAR='calendar';
    const PLACEHOLDER_TYPE_HEADER='pageHeader';
    const PLACEHOLDER_TYPE_FOOTER='pageFooter';

    static function requireInventory() {
        require_once 'includes/models/page/module_node.php';
        require_once 'includes/models/page/bmcd/modules/media_highlights_module.php';
        require_once 'includes/services/file_services/external_data_services.php';
        require_once 'includes/models/page/inventory.php';
        require_once 'includes/models/filter.php';
    }
    static function requireModelLineup() {
        require_once 'includes/models/page/module_node.php';
        require_once 'includes/services/file_services/external_data_services.php';
        require_once 'includes/models/page/bmcd/modules/model_lineup_data_manager.php';
        require_once 'includes/models/filter.php';
    }
    static function requireStore() {
        require_once 'includes/services/file_services/external_data_services.php';
        require_once 'includes/models/page/store.php';
        require_once 'includes/models/filter.php';
    }

    static function getInnerHtmlString($html) {
        global $tLog;
        $startChar = '>';
        $endChar = '<';

        $startPos = strpos($html, $startChar);
        $endPos = strrpos($html, $endChar);

        if ($startPos === FALSE || $endPos === FALSE) {
            $msg = "There was a problem getting the inner HTML of [[$html]].\n\n".
                    "StartPos is: ".($startPos ? $startPos : "FALSE")."\n".
                    "EndPos is: ".($endPos ? $endPos : "FALSE");
            $tLog->warn($msg);
            return '';
        }
    }
    static function getHtmlString($type,$html,$uniqueValue) {
        global $tLog;
        switch($type) {
            case self::PLACEHOLDER_TYPE_INVENTORIES:
                $tag = 'table';
                $attributeArray = array('id' => Inventory::IDENTIFIER.$uniqueValue);
                //return self::getHtmlString($type,$html, 'table', array('id' => Inventory::IDENTIFIER.$uniqueValue));
                break;
            case self::PLACEHOLDER_TYPE_MODEL_LINEUP:
                $tag = 'div';
                $attributeArray = array('class="ModModelInfo" id' => ModelLineupDataManager::IDENTIFIER.$uniqueValue);
                //return self::getHtmlString($type,$html, 'div', array('class="ModModelInfo" id' => ModelLineupDataManager::IDENTIFIER.$uniqueValue));
                break;
            case self::PLACEHOLDER_TYPE_INVENTORY_HEADER:
                if ($uniqueValue > 0) {
                    return false;
                }
                $tag = 'h1';
                $attributeArray = array('class="Title" id' => Inventory::IDENTIFIER.'_header');
                $htmlPlaceholder = "<$tag class=\"Title\" id=\"".Inventory::IDENTIFIER."_header\">Inventory: All</h1>";
                break;
            case self::PLACEHOLDER_TYPE_PAGE_TITLE:
                if ($uniqueValue > 0) {
                    return false;
                }
                $tag = 'title';
                $attributeArray = '';
                $htmlPlaceholder = "<title>British Motor Car Distributors</title>";
                break;
            case self::PLACEHOLDER_TYPE_STORE:
                $tag = 'table';
                $attributeArray = array('id' => Store::IDENTIFIER.$uniqueValue);
                break;
            case self::PLACEHOLDER_TYPE_CALENDAR:
                $tag = 'table';
                $attributeArray = array('id' => Calendar::IDENTIFIER.$uniqueValue);
                break;
            case self::PLACEHOLDER_TYPE_HEADER:
                if ($uniqueValue > 0) {
                    return false;
                }
                $tag = 'div';
                $attributeArray = array('class' => 'ModBMCD901Header');
                break;
            case self::PLACEHOLDER_TYPE_FOOTER:
                if ($uniqueValue > 0) {
                    return false;
                }
                $tag = 'div';
                $attributeArray = array('class' => 'ModBMCD901Footer');
                break;
            default:
                $msg = "Cannot getHtmlString for type($type).";
                $tLog->error($msg);
                throw new Exception($msg);
        }
        $startString = "<$tag".((is_array($attributeArray)) ? ' '.key($attributeArray)."=\"".current($attributeArray)."\"" : '');
        //Check for same tag within this tag
        $checkString = "<$tag";
        $endString = "</$tag>";

        //"is..." is short for "Internal String"
        $isS = 0;
        $isE = 0;

        $isS = strpos($html, $startString, $isS);
        $isE = strpos($html, $endString, $isS)  + strlen($endString);
        
        //$isC = $isE;
        $doCheck = true;
        $safeCount = 0;
        

        if ($isS == 0 || $isS == -1 || $isS === FALSE) {
            $info = false;
        }
        else {
            $isC = $isS + 1;
            while ($doCheck && ($isC !== FALSE)) {
                //FIGURE THIS OUT!
                $isC = strpos($html, $checkString,$isC);
                if ($isC === FALSE || $isC >=    $isE) {
                    $doCheck = false;
                }
                else {
                    $rS = $isS - $isS;
                    $rC = $isC-$isS;
                    $rE = $isE - $isS;
                    //$tLog->debug("$isS|$rS-$rC-$rE\nINNER TAG: ".substr($html, $isC, 30)."\nEND TAG: ".substr($html,$isE,30));
                    $isE = strpos($html,$endString,$isE) + strlen($endString);
                    $isC++;
                }
                if ($safeCount++ > 15) {
                    $tLog->warn("This loop is taking too long...");
                    break;
                }
            }


            $htmlString = substr($html, $isS, $isE-$isS);
            if ($type == self::PLACEHOLDER_TYPE_PAGE_TITLE) {
                $tLog->debug("TITLE FOUND: ".$htmlString);
            }
            if (!isset($htmlPlaceholder))
                $htmlPlaceholder = $startString.'>'.$endString;

            $info = array(
                self::HTML_STRING => $htmlString,
                self::START_POS => $isS,
                self::END_POS => $isE,
                self::HTML_COUNT => 1,
                self::HTML_PLACEHOLDER => $htmlPlaceholder,
                self::SUPPLEMENTAL_INFO => self::getSupplementalInfo($type,$html, $uniqueValue + 1)
            );
            //$tLog->debug("PLACEHOLDER IS: $htmlPlaceholder");
            $info[self::HTML_COUNT] = self::addInfoCounts($info, $info[self::SUPPLEMENTAL_INFO]);
        }
        return $info;

    }
    static function getSupplementalInfo($type,$html,$intCount) {
        switch($type) {
            case self::PLACEHOLDER_TYPE_INVENTORIES:
                $info = self::getHtmlString($type,$html, $intCount);
                if (is_array($info)) {
                    //Check that the Inventory has the "Supplemental" class
                    $classString = "class=\"".Inventory::SUPPLEMENTAL_CLASS."\"";
                    $classPos = strpos($info[self::HTML_STRING], $classString);
                    $bracketPos = strpos($info[self::HTML_STRING], '>');
                    if ($classPos !== FALSE && $bracketPos !== FALSE && $classPos < $bracketPos) {
                        return $info;
                    }
                }
                break;
            case self::PLACEHOLDER_TYPE_STORE:
                $info = self::getHtmlString($type,$html, $intCount);
                if (is_array($info)) {
                    //Check that the Inventory has the "Supplemental" class
                    $classString = "class=\"".Store::SUPPLEMENTAL_CLASS."\"";
                    $classPos = strpos($info[self::HTML_STRING], $classString);
                    $bracketPos = strpos($info[self::HTML_STRING], '>');
                    if ($classPos !== FALSE && $bracketPos !== FALSE && $classPos < $bracketPos) {
                        return $info;
                    }
                }
                break;
        }
        return false;
    }
    static function getAllDynamicModules($html,$placeholdArray) {
        global $tLog;
        $infos = array();
        foreach ($placeholdArray as $key => $value) {
            if ($value) {
                $info = true;
                $i = 0;
                for(
                    $info = self::getHtmlString($key, $html, $i);
                    $info !== false;
                    $info = self::getHtmlString($key, $html, $i)
                ) {
                    if ($i > 10) {
                        $tLog->warn("Loop taking to long trying to get infos for: ".$key);
                        break;
                    }
                    if (is_array($info)) {
                        //$info[self::SUPPLEMENTAL_INFO] = self::getSupplementalInfo($key, $html, $i);
                        array_push($infos,$info);
                        $i += $info[self::HTML_COUNT];
                    }
                }
            }
        }
        return $infos;
    }
    static function getPlaceheldHtml($placeholdArray,$html) {
        $infos = self::getAllDynamicModules($html, $placeholdArray);
        $html = self::placeholdInfos($html, $infos);
        return $html;
    }
    static function placeholdInfos($html,$infos) {
        foreach ($infos as $key => $value) {
            //$html = str_replace(self::getHtmlFromInfo($value), self::getInventoryPlaceholder($key), $html);
            $html = str_replace(self::getHtmlFromInfo($value),$value[self::HTML_PLACEHOLDER], $html);
        }
        return $html;
    }
    static function getPlaceholdArray($pageClass) {
        global $tLog;
        $placeholdArray = array(
            self::PLACEHOLDER_TYPE_INVENTORIES => false,
            self::PLACEHOLDER_TYPE_INVENTORY_HEADER => false,
            self::PLACEHOLDER_TYPE_PAGE_TITLE => false,
            self::PLACEHOLDER_TYPE_MODEL_LINEUP => false,
            self::PLACEHOLDER_TYPE_STORE => false,
            self::PLACEHOLDER_TYPE_CALENDAR => false,
            self::PLACEHOLDER_TYPE_FOOTER => false,
            self::PLACEHOLDER_TYPE_HEADER => false
        );
        switch($pageClass) {
            case self::DYNAMIC_PAGE_HOME:
                $placeholdArray[self::PLACEHOLDER_TYPE_INVENTORIES] = true;
                break;
            case self::DYNAMIC_PAGE_INVENTORY:
                $placeholdArray[self::PLACEHOLDER_TYPE_INVENTORIES] = true;
                $placeholdArray[self::PLACEHOLDER_TYPE_INVENTORY_HEADER] = true;
                $placeholdArray[self::PLACEHOLDER_TYPE_PAGE_TITLE] = true;
                break;
            case self::DYNAMIC_PAGE_MODEL_INFO:
                $placeholdArray[self::PLACEHOLDER_TYPE_MODEL_LINEUP] = true;
                $placeholdArray[self::PLACEHOLDER_TYPE_PAGE_TITLE] = true;
                break;
            case self::DYNAMIC_PAGE_STORE:
                $placeholdArray[self::PLACEHOLDER_TYPE_STORE] = true;
                $placeholdArray[self::PLACEHOLDER_TYPE_PAGE_TITLE] = true;
                break;
            case self::DYNAMIC_PAGE_CALENDAR:
                $placeholdArray[self::PLACEHOLDER_TYPE_CALENDAR] = true;
                $placeholdArray[self::PLACEHOLDER_TYPE_PAGE_TITLE] = true;
                break;
            case self::SPECIAL_UPDATE_ALL_PAGES:
                $placeholdArray[self::PLACEHOLDER_TYPE_HEADER] = true;
                $placeholdArray[self::PLACEHOLDER_TYPE_FOOTER] = true;
                break;
            default:
                $msg = "This PageClass($pageClass) does not have any designated content types to placehold.";
                $tLog->warn($msg);
                //throw new Exception($msg);
        }
        return $placeholdArray;
    }
    static function insertDynamicConent($pageClass,$html,$dynamicHtml) {
        global $tLog;
        $placeholdArray = self::getPlaceholdArray($pageClass);
        $html = self::getPlaceheldHtml($placeholdArray, $html);
        $infos = self::getAllDynamicModules($dynamicHtml, $placeholdArray);
        $tLog->debug(count($infos)." Infos found in Dynamic content page...");
        foreach($infos as $key => $value) {
            $replaceValue = self::getHtmlFromInfo($value);
            $tLog->debug("Inserting Dynamic Content with the Placeholder: \n".$value[self::HTML_PLACEHOLDER]);
            //$tLog->debug("Here is the Dynamic Content: \n$replaceValue");
            $html = str_replace($value[self::HTML_PLACEHOLDER], $replaceValue, $html);
        }
        return $html;
    }
    static function getHtmlFromInfo($info) {
        $supplementalInfo = $info[self::SUPPLEMENTAL_INFO];
        if (is_array($supplementalInfo)) {
            return $info[self::HTML_STRING].self::getHtmlFromInfo($supplementalInfo);
        }
        else {
            return $info[self::HTML_STRING];
        }
    }
    static function addInfoCounts($info1,$info2=null) {
        return  (
            (is_array($info1) ? $info1[self::HTML_COUNT]:0) +
            (is_array($info2) ? $info2[self::HTML_COUNT]:0)
        );
    }
}
?>
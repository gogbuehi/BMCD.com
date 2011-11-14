<?php
	require_once 'includes/models/page/data_manager.php';
	require_once 'includes/utils/url_manager.php';
	require_once 'models/Data_Name_Reference.php';
	class ModelLineupDataManager extends DataManager {
    	const DEFAULT_CLASS='ModModelInfo';
		const HEADER_CLASS='header';
		const BODY_ROW_CLASS='row';
        const IDENTIFIER='Model_Info_';

        const USE_DEFAULT='___USE_DEFAULT___';
		
		protected $makeFilter;
		protected $modelFilter;
		protected $submodelFilter;
		
		protected $distinctMakes;
		protected $distinctModels;
        protected $distinctSubmodels;
		
		protected $reference;

        static $intCount = 0;

        private $referenceArray;
		function __construct(&$doc,$makeFilter,$modelFilter,$submodelFilter) {
			parent::__construct($doc,'div');
            $this->setAttribute('id', self::IDENTIFIER.(self::$intCount++));
			$this->distinctMakes = array();
			$this->distinctModels = array();
            $this->distinctSubmodels = array();
			
			$record = new Data_Name_Reference(false);
        	$requiredParams = array(
				'blnvalid' => true,
				'domain' => $_SERVER['SERVER_NAME']
			);
			$records = $record->getComplex($requiredParams);
			$rRecords = array();
			foreach ($records as $key => $value) {
				array_push($rRecords,$value->getFields());
			}
	
			$this->reference = $rRecords;
			$this->makeFilter=$makeFilter;
			$this->modelFilter=$modelFilter;
			$this->submodelFilter=$submodelFilter;
            $this->referenceArray = array();
		}
		
		//function processReferenceData($data) {
		//	return $this->reference->processData($data);
		//}
		
		/**
		 * Process Data
		 * The data is expected to be a tab-delimited
		 * columns, with newline delimited rows
		 * @return 
		 * @param $data Object
		 */
		function processData($data) {
			//$lines = explode("\n",$data);
			//$this->tLog->debug("DATA ROWS: ".count($lines));
			$fields = null;
			$recordsets = array();
			
			$this->setReferenceNameString($this->makeFilter);
			$this->setReferenceNameString($this->modelFilter);
			$this->setReferenceNameString($this->submodelFilter);
			
			$filter = new Filter('make',$this->makeFilter);
            if (!is_null($this->modelFilter)) {
                $filter->andFilter('model',$this->modelFilter);
            }
            if (!is_null($this->submodelFilter)) {
                $filter->andFilter('submodel',$this->submodelFilter);
            }
			
			$this->addFilter($filter);
			
			//Go line by line, exploding by tab
			//Also, add any dynamically generated columns
			foreach ($data as $key => $value) {
				
						$aRecord = $this->processRecord($value);
					
						//Assess record for new makes and models
						
						if (isset($aRecord['make']) && isset($aRecord['model'])) {
							if (!isset($this->distinctMakes[$aRecord['make']]))
								$this->distinctMakes[$aRecord['make']] = array(
									'MAKE_URL'	=> $aRecord['MAKE_URL'],
									'make'		=> $aRecord['make']
								);
							if (!isset($this->distinctModels[$aRecord['model']]) && $this->makeFilter == $aRecord['make'])	
								$this->distinctModels[$aRecord['model']] = array(
									'MODEL_URL' => $aRecord['MODEL_URL'],
									'model'		=> $aRecord['model']
								);
                            $makeName = $aRecord['make'];
                            $submodelName = $aRecord['model'].(
                                (!is_null($aRecord['submodel']) && $aRecord['submodel'] != '')
                                    ? ' '.$aRecord['submodel']
                                    : ''
                                );
                                //$this->tLog->debug("MAKE_FILTER: ".$this->makeFilter." | SUBMODEL NAME: ($makeName) $submodelName");
                            if (!isset($this->distinctSubmodels[$submodelName]) && $this->makeFilter == $makeName) {
                                $this->distinctSubmodels[$submodelName] = array(
                                    'URL'       => $aRecord['SUBMODEL_URL'],
                                    'name'      => $submodelName
                                );
                            }
						$recordsets[$key] = $aRecord;
				}
			}
			ksort($this->distinctSubmodels,SORT_STRING);
			return $recordsets;
		}
		function filterRecords($recordset){
			$filtered = parent::filterRecords($recordset);
			return (count($filtered)==0) ? $recordset : $filtered;
		}
		function getReferenceRecord($name=null) {
			$records = $this->reference;
            $vdump = '';

			foreach ($records as $key => $value) {
				//$this->tLog->debug("--NAME_STRING: ".$value['name_string']);
				if ($value['name']==$name || $value['name_string']==$name) {
					
					return $value;
				}
                else {
                    $vdump .= "-NAME($name):REF_NAME({$value['name']}):REF_NAME_STRING({$value['name_string']})\n";
                }
			}
            //$this->tLog->debug("No reference record found for ($name)\nDUMP: $vdump");
			return null;
		}
		function setReferenceName(&$name) {
			$record = $this->getReferenceRecord($name);
			if (!is_null($record)) {
                
				$name = $record['name_string'];
			}
				
		}
		function setReferenceNameString(&$nameString) {
			$record = $this->getReferenceRecord($nameString);
			if (!is_null($record)) {
                $this->tLog->debug("Setting Name($nameString) to {$record['name']}");
				$nameString = $record['name'];
			}
            else {
                $this->tLog->warn("No reference found for ($nameString)");
            }
		}
		function createReferenceLogo($name) {
			$record = $this->getReferenceRecord($name);
			
			$module = $this->createNode('img');
			$module->setAttribute('width','90');
			$module->setAttribute('height','46');
			if (!is_null($record)) {
				$module->setAttribute('alt',$record['name']);
				$module->setAttribute('src',(isset($record['logo']) ? $record['logo'] : ''));
			}
			return $module;
		}
		function processRecord($record) {
			$recordset = array(); //parent::processRecord($fields,$values);
			foreach($record as $key => $value){
				$recordset[$key] = $value; 
			}
			$referenceRecords = $this->reference;
			$make = $recordset['make'];
			$model = $recordset['model'];
			$submodel = $recordset['submodel'];
			//$this->tLog->debug("MAKE: $make\nMODEL: $model\nSUBMODEL: $submodel");

			$this->setReferenceName($make);
			$this->setReferenceName($model);
			$this->setReferenceName($submodel);
			//$this->tLog->debug("--MAKE: $make\nMODEL: $model\nSUBMODEL: $submodel");
            $this->referenceArray[$make] = $recordset['make'];
            $this->referenceArray[$model] = $recordset['model'];
            $this->referenceArray[$submodel] = $recordset['submodel'];
			$recordset['SUBMODEL_URL']=URL_SEPARATOR.'research'.URL_SEPARATOR.'model_lineup'.URL_SEPARATOR.$make.URL_SEPARATOR.$model.URL_SEPARATOR.$submodel;
			$recordset['MODEL_URL']=URL_SEPARATOR.'research'.URL_SEPARATOR.'model_lineup'.URL_SEPARATOR.$make.URL_SEPARATOR.$model.URL_SEPARATOR.$submodel;
			$recordset['MAKE_URL']=URL_SEPARATOR.'research'.URL_SEPARATOR.'model_lineup'.URL_SEPARATOR.$make.URL_SEPARATOR.$model.URL_SEPARATOR.$submodel;

            $this->addUrlFieldsToRecord($recordset);

			return $recordset;
		}
        /**
         * Special method that puts in record fields to match the URI against
         */
        function addUrlFieldsToRecord($recordArray) {
            if (!isset($this->referenceArray['make'])) {
                $this->referenceArray['make'] = $recordArray['make'];
            }
            if (!isset($this->referenceArray['model'])) {
                $this->referenceArray['model'] = $recordArray['model'];
            }
            if (!isset($this->referenceArray['submodel'])) {
                $this->referenceArray['submodel'] = $recordArray['submodel'];
            }
        }
        function getProperName($uriVersion) {
            $properName = (isset($this->referenceArray[$uriVersion])) ? $this->referenceArray[$uriVersion] : $uriVersion;
            return $properName;
        }
		function processFields($rowString) {
			$fields = explode("\t",$rowString);
			//array_unshift($fields,'SUBMODEL_URL');
			//array_unshift($fields,'MODEL_URL');
			//array_unshift($fields,'MAKE_URL');
            
			return $fields;
		}
		function processValues($rowString) {
			$values = explode("\t",$rowString);
			return $values;
		}
		
		function build($record) {
			
			
			$currentUrl = new UrlManager();
			
			//Makes
			$this->addMenu('makes');
			$dm = $this->distinctMakes;
			foreach ($dm as $key => $value) {
				$menuHref = new UrlManager($value['MAKE_URL']);
				$isSelected = $currentUrl->isDecendentUrl($menuHref) || ($this->makeFilter == $value['make']);
				$ref = $value['make'];
				
				$this->addMenuItem('make',$value['MAKE_URL'],$this->createReferenceLogo($ref),$isSelected);
			}
			
			$this->appendChild($this->menu);
			
			//Models
			$this->addMenu('models');
			$dm = $this->distinctSubmodels;
			foreach ($dm as $key => $value) {
				$menuHref = new UrlManager($value['URL']);
                $submodelString =  $this->modelFilter.(
                                (!is_null($this->submodelFilter) && $this->submodelFilter != '')
                                    ? ' '.$this->submodelFilter
                                    : ''
                                );

				$isSelected = $currentUrl->isDecendentUrl($menuHref) || ($submodelString == $value['name']);
                $this->tLog->debug('Submodel Filter is: [' . $submodelString. '] and Value[name] is: ['. $value['name'].']');
                $this->tLog->debug("This entry is selected: ".($isSelected ? 'TRUE' : 'FALSE'));
				$this->addMenuItem('model',$value['URL'],$this->createTextNode($value['name']),$isSelected);
			}
			$this->appendChild($this->menu);
			
			//Videos
			$srcList = explode(',',$record['videos']);
			$this->addList('videos');
			foreach ($srcList as $key => $value) {
				$this->addVideo($value);
			}
			$this->appendChild($this->ul);
			
			//Images
			$srcList = explode(',',$record['images']);
			$this->addList('images');
			foreach ($srcList as $key => $value) {
				$this->addImage($value);
			}
			$this->appendChild($this->ul);
			
			//Description
            //$this->tLog->debug('Model Lineup Description: '.$record['description']);
			$this->appendChild($this->createDescription($record['description']));
			
			//Highlights
			$this->appendChild($this->createHighlights($record));
			
			//Static elements
			$this->appendStaticElements($this);
			
			//Title + Subtitle
			$p = $this->createNode('p');
			$p->setClass('title');
			$p->addText($record['make']);
			$this->appendChild($p);
			
			$p = $this->createNode('p');
			$p->setClass('subtitle');
			$p->addText($record['model'].((!is_null($record['submodel']) && $record['submodel'] != '' ? ' '.$record['submodel'] : '')));
			$this->appendChild($p);
			
			//Configurator Link
			$a = $this->createNode('a');
			$a->setAttribute('id','configurator');
			$a->setAttribute('target','_blank');
			$a->setAttribute('href',$record['configurator']);
			$a->addText('Configurator');
			$this->appendChild($a);
			
			//Brochure Link
			$a = $this->createNode('a');
			$a->setAttribute('id','brochure');
			$a->setAttribute('target','_blank');
			$a->setAttribute('href',$record['brochure']);
			$a->addText('Download Brochure');
			$this->appendChild($a);
			
			//Manufacture Link
            /*
			$a = $this->createNode('a');
			$a->setAttribute('id','manufacture');
			$a->setAttribute('target','_blank');
			$a->setAttribute('href',$record['manufacture']);
			$a->addText('Manufacturer Site');
             *
             */
            $a = $this->makeSpecialLink('manufacture', $record, 'Manufacturer Site');
            if (!is_null($a)) {
                $this->appendChild($a);
            }
	
			//Disclaimer
			$this->appendChild($this->createDisclaimer($record['make']));
	
			//$this->appendChild($module);
		}

        function makeSpecialLink($name,$record,$text) {
            if (isset($record[$name])) {
                $a = $this->createNode('a');
                $a->setAttribute('id',$name);
                $a->setAttribute('target','_blank');
                $a->setAttribute('href',$record[$name]);
                $a->addText($text);
            }
            else {
                //$msg = "No value found for ($name) in Record(".self::recordToString($record).")";
               // $this->tLog->warn($msg);
            }
            return $a;
        }
		
		function addMenu($nClass) {
			$module = new Menu($this->getDOMDocument());
			$module->setClass($nClass);
			$this->menu = &$module;
			$this->appendChild($module);
			
			return $module;
		}
		function addList($nClass) {
			$this->ul = $this->createNode('ul');
			$this->ul->setClass($nClass);
			
		}
		function addListItem($nClass,$cNode) {
			$li = $this->createNode('li');
			$li->setClass($nClass);
			$li->appendChild($cNode);
			$this->ul->appendChild($li);
		}
		function addVideo($src) {
			$video = $this->createNode('embed');
			$video->setAttribute('pluginspage','http://www.apple.com/quicktime/download/');
			$video->setAttribute('type','video/quicktime');
			$video->setAttribute('src',$src);
			
			$this->addListItem('Video',$video);
		}
		function addImage($src) {
			$image = $this->createNode('img');
			$image->setAttribute('src',$src);
			
			$this->addListItem('image',$image);
		}
		function addMenuItem($nClass,$href,$label,$isSelected=false) {
			$currentUrl = new UrlManager();
			$menuHref = new UrlManager($href);
			$isSelected = ($currentUrl->isDecendentUrl($menuHref) || $isSelected);
			$this->menu->addMenuItem(new MenuItem($this->getDOMDocument(),$nClass,$href,$label,$isSelected));
			//if ($isSelected) {
				//$this->menu->setSelectedItem($href);
			//}
		}
		function createDescription($desc) {
			$module = $this->createNode('div',$desc);
			$module->setClass('Description');
			return $module;
		}
		function createHighlights($record) {
			$module = $this->createNode('div');
			$module->setClass('highlights');
			
			$p = $this->createNode('p');
			$p->setClass('label');
			$p->addText('Model Highlights');
			$module->appendChild($p);
			
			$table = $this->createNode('table');
			$module->appendChild($table);
			
			$tbody = $this->createNode('tbody');
			$table->appendChild($tbody);
			
			$referenceArray = array(
				'engine'			=> 'Engine',
				'displacement'		=> 'Displacement',
				'horsepower'		=> 'Horsepower',
				'acceleration'	    => '0-60',
				'topSpeed'			=> 'Top Speed',
				'msrp'				=> 'MSRP'
			);
			
			foreach ($referenceArray as $key => $value) {
				$tr = $this->createNode('tr');
				
				$td = $this->createNode('td');
				$td->addText($value);
				$tr->appendChild($td);
				
				$td = $this->createNode('td');
				$td->addText($record[$key]);
				$tr->appendChild($td);
                //$this->tLog->debug($value.': '.$record[$key]);
				
				$tbody->appendChild($tr);
			}
			
			
			return $module;
		}
		function appendStaticElements($module) {
			$a = $this->createNode('a');
			$a->setAttribute('id','testdrive');
			$a->setAttribute('target','_blank');
			$a->setAttribute('href','#');
			$a->addText('Test Drive');
			$module->appendChild($a);
			
			$a = $this->createNode('a');
			$a->setAttribute('id','quote');
			$a->setAttribute('target','_blank');
			$a->setAttribute('href','#');
			$a->addText('Request a Quote');
			$module->appendChild($a);
			
			$a = $this->createNode('a');
			$a->setAttribute('id','email');
			$a->setAttribute('target','_blank');
			$a->setAttribute('href','#');
			$a->addText('Email Friend');
			$module->appendChild($a);
		}
		
		function createDisclaimer($makeName){
			$p = $this->createNode('p');
			$p->setAttribute('class','disclaimer');
			$p->addText('While we strive to keep this website current, certain changes in standard equipment, options, prices, availability or delays may occur that may not be immediately reflected on this site. Your '.$makeName.' Retailer is your best source for up-to-date information. '.$makeName.' reserves the right to change product specifications at any time without incurring obligations. Options shown or described are available at an extra cost and may be offered only in combination with other options or subject to additional ordering requirements or limitations.','p');
			return $p;
		}
		
	}
?>
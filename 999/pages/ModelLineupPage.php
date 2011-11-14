<?php
	require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
	//require_once 'includes/services/file_services/external_data_services.php';
	require_once 'models/Data_Model_Info.php';
	require_once 'includes/models/page/bmcd/modules/model_lineup_data_manager.php';
	require_once 'includes/models/filter.php';
	
    class ModelLineupPage extends Bmcd999Page {
    	const IDENTIFIER='_999_model_lineup_';
		protected $modelLineup;
		protected $eds;

        protected $filterElements;
    	function __construct($url=null) {
    		parent::__construct('Model Line-Up',$url);
            $this->hasDynamicContent = true;
			//$this->eds = new ExternalDataServices();
			$this->makeContent();


            $this->filterElements = array();
    	}
		
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
			// Retreive all records from DB
			$record = new Data_Model_Info(false);
        	$requiredParams = array(
				'blnvalid' => true,
				'visible' => true,
				'domain' => $_SERVER['SERVER_NAME']
			);
			$records = $record->getComplex($requiredParams);
			$eData = array();
			foreach ($records as $key => $value) {
				array_push($eData,$value->getFields());
			}
			//$eData = $this->eds->getExternalData($url,self::IDENTIFIER);
			
			$uArray = $this->evaluateUri($eData);
			$this->modelLineup = new ModelLineupDataManager($this->doc,$uArray['MAKE'],$uArray['MODEL'],$uArray['SUBMODEL']);
			
			
			
			
			$records = $this->modelLineup->processData($eData);
			//$records = $eData;
			$records2 = $this->modelLineup->filterRecords($records);
			$record = array_shift($records2);
            $uArray['MAKE'] = $record['make'];
            $uArray['MODEL'] = $record['model'];
            $uArray['SUBMODEL'] = $record['submodel'];
			$this->modelLineup->build($record);
            $this->filterElements['make'] = $this->modelLineup->getProperName($uArray['MAKE']);
            $this->filterElements['model'] = $this->modelLineup->getProperName($uArray['MODEL']);
            $this->filterElements['submodel'] = $this->modelLineup->getProperName($uArray['SUBMODEL']);
            $this->setTitle($this->getFilterElements());
					
					
			//Add the module to the Floor.	
			$floor->appendChild($this->modelLineup);	
			//Add the floor to the page.	
			$this->appendContent($floor);
			
			
			/**
			 * Note the difference between "appendChild" and "appendContent"
			 * "appendChild" is for adding a node as a child of another node
			 * "appendContent" is for adding a node as a child of the Page's body
			 */	
			 
		}
        function getFilterElements() {
            $aMake =  $this->modelLineup->getProperName($this->filterElements['make']);
            $aModel =  $this->modelLineup->getProperName($this->filterElements['model']);
            $aSubmodel = $this->modelLineup->getProperName($this->filterElements['submodel']);
            //$aTitle = $this->filterElements['title'];
            return "$aModel $aSubmodel | Model Info | $aMake San Francisco";
        }
		
		function evaluateUri($records) {
			$url = new UrlManager();
			$components = $url->getUriComponents();
			
			$uriArray = array();
			if (isset($components[2])) {
				$make = $components[2]; //Make
			}
			else {
				//Get first Make record for this site (901)
                $firstRecord = $records[0];
				$make = $firstRecord['make'];
			}
			if (isset($components[3])) {
				$model = $components[3];
			}
			else {
				if (!is_null($firstRecord)) {
                    $model = $firstRecord['model'];
                }
                else {
                    $model= ModelLineupDataManager::USE_DEFAULT;
                }
			}
			if (isset($components[4])) {
				$submodel = $components[4];
			}
			else {
				if (!is_null($firstRecord)) {
                    $submodel = $firstRecord['submodel'];
                }
                else {
                    $submodel = ModelLineupDataManager::USE_DEFAULT;
                }

                $this->tLog->debug('Eval - Make: ' . $make .' - Model: '.$model.' - Submodel: '.$submodel);
			}
			
			$uriArray['MAKE'] = $make;
			$uriArray['MODEL'] = $model;
			$uriArray['SUBMODEL'] = $submodel;
			return $uriArray;
		}
    }
?>
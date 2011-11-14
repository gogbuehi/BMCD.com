<?php
    require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
	//require_once 'includes/services/file_services/external_data_services.php';
	require_once 'models/Data_Calendar.php';
	require_once 'includes/models/page/calendar.php';
	require_once 'includes/models/page/calendar_filter.php';
	require_once 'includes/models/filter.php';
    class CalendarPage extends Bmcd999Page {
    	const IDENTIFIER='_999_calendar_';
		protected $calendar;
		protected $calendarHeader;
		protected $eds;

        protected $filterElements;
    	function __construct($url=null) {
    		parent::__construct('Events',$url);
            $this->hasDynamicContent = true;
			//$this->eds = new ExternalDataServices();
			$this->makeContent();
            $this->filterElements = array();
    	}
		function createCalendarHeader() {
			$this->calendarHeader = $this->createNode('div');
			$this->calendarHeader->setClass('MAEventsCalendarHeader');
			$this->calendarHeader->addImage('/temp/images/calendarheader.png');
			$this->calendarHeader->addTitleText('Events Calendar');
			return $this->calendarHeader;
		}
		function makeContent() {
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModEventsCalendar');
			$module->appendChild($this->createCalendarHeader());	
					
			//$url = CALENDAR_999_URL;
			//$eData = $this->eds->getExternalData($url,self::IDENTIFIER);
			
			// Retreive all records from DB
			$record = new Data_Calendar(false);
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
	
			//$this->tLog->debug("External data for URL($url): $eData");
			
			$this->calendar = new Calendar($this->doc);
			$this->determineFilters();
			$recordCount = $this->calendar->buildCalendar($eData);
            
			if ($recordCount == 1) {
                //add the year to the filter
                $this->tLog->debug('Getting filtered records...');
                $fRecords = $this->calendar->getFilteredRecords();
                $record = $fRecords[0];
                $this->filterElements['title'] = $record['title'];
                $this->filterElements['city'] = ' | '.$record['city'];
                $this->filterElements['state'] = ', '.$record['state'];
            }
            $this->setTitle($this->getFilterElements());
			$urlDiv = &$this->calendar->getUrlTemplates();
			
			$module->appendChild($this->calendar);
			$module->appendChild($urlDiv);
			$floor->appendChild($module);
			
			$this->appendContent($floor);
	
			$module->setAttribute('count',$recordCount);
			//if($recordCount==0)
				//$this->addNoItemsText();
		}
		
		function addNoItemsText(){
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModArticle');
			$module->addBodyText('There are no events to dispaly at this time.');
			$floor->appendChild($module);
			$this->appendContent($floor);
		}
        function getFilterElements() {
            $aYear =  $this->calendar->getProperName($this->filterElements['year']);
            $aMonth =  $this->calendar->getProperName($this->filterElements['month']);
            $aDay = $this->calendar->getProperName($this->filterElements['day']);
            $aTitle = $this->filterElements['title'];
            $aCity = $this->filterElements['city'];
            $aState = $this->filterElements['state'];
            return "$aTitle | Special Event | Lamborgini , Lotus, Bentley$aCity$aState";
        }
		function determineFilters($url=null) {
			$url = new UrlManager($url);
			$components = $url->getUriComponents();
			$this->filterElements = array(
                    'year' => '',
                    'month' => '',
                    'day' => '',
                    'title' => 'All Events',
                    'city' => '',
                    'state' => ''

                );
			//Break down the URI and determine what filters to use
			if (isset($components[0]) && $components[0] == '') {
				array_shift($components);
			}
			if (count($components) == 1) {
				$this->calendar->setAttribute('year',date('Y'));
				$this->calendar->setAttribute('month',date('m'));
			}
			foreach($components as $key => $value) {
				
				switch($key) {
					case 0:
						//This should always be "events"
						if ($value != 'events') {
							$this->tLog->warn("CALENDAR URI element($key) failed with value($value)");
							return;
						}
						$this->calendar->addFilter(new CalendarFilter('date',date('Y'),date('m'),3));
						$this->filterElements['year'] = date('Y');
                        $this->filterElements['month'] = date('m');
						break;
					case 1:
						/**
						 * Possible elements:
						 *  - Year
						 *  - Event ID
						 */
						// Assume Year
						$this->calendar->clearFilters();
						$this->calendar->setAttribute('year',$value);
						$this->calendar->addFilter(new CalendarFilter('date',$value,'01',3));
                        $this->filterElements['year'] = $value;
                        $this->filterElements['month'] = '1';
						break;
					case 2:
						//Month
						$this->calendar->clearFilters();
						$this->calendar->setAttribute('month',$value);
						$this->calendar->addFilter(new CalendarFilter('date',$components[1],$components[2],3));
                        $this->filterElements['year'] = $components[1];
                        $this->filterElements['month'] = $components[2];
						break;
					case 3:
						//Day
                        $this->filterElements['year'] = $components[1];
                        $this->filterElements['month'] = $components[2];
                        $this->filterElements['day'] = $components[3];
                        break;
					case 4:
						//Event
                        $this->filterElements['year'] = $components[1];
                        $this->filterElements['month'] = $components[2];
                        $this->filterElements['day'] = $components[3];
						$this->calendar->clearFilters();
						$this->calendar->addFilter(new Filter('id',$components[4]));
                        break;
					default:
						//Assume no filters
				}
			}
		}
	}
	//$page = new CalendarPage();
	//echo $page->getHtml();
?>
<?php
    require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
	require_once 'includes/services/file_services/external_data_services.php';
	require_once 'includes/models/page/calendar.php';
	require_once 'includes/models/page/calendar_filter.php';
	require_once 'includes/models/filter.php';
    class CalendarPage extends Bmcd999Page {
    	const IDENTIFIER='_999_calendar_';
		protected $calendar;
		protected $calendarHeader;
		protected $eds;
    	function __construct() {
    		parent::__construct();
			$this->eds = new ExternalDataServices();
			$this->makeContent();
    	}
		function createCalendarHeader() {
			$this->calendarHeader = $this->createNode('div');
			$this->calendarHeader->setClass('MAEventsCalendarHeader');
			$this->calendarHeader->addImage('/temp/images/calendarheader.png');
			$this->calendarHeader->addTitleText('This is the Title');
			return $this->calendarHeader;
		}
		function makeContent() {
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModEventsCalendar');
			$module->appendChild($this->createCalendarHeader());	
					
			$url = CALENDAR_999_URL;
			$eData = $this->eds->getExternalData($url,self::IDENTIFIER);
			//$this->tLog->debug("External data for URL($url): $eData");
			
			$this->calendar = new Calendar($this->doc);
			$this->determineFilters();
			$recordCount = $this->calendar->buildCalendar($eData);
			
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
		function determineFilters($url=null) {
			$url = new UrlManager($url);
			$components = $url->getUriComponents();
			
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
						$this->calendar->addFilter(new CalendarFilter('Date',date('Y'),date('m'),3));
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
						$this->calendar->addFilter(new CalendarFilter('Date',$value,'01',3));
						break;
					case 2:
						//Month
						$this->calendar->clearFilters();
						$this->calendar->setAttribute('month',$value);
						$this->calendar->addFilter(new CalendarFilter('Date',$components[1],$components[2],3));
						break;
					case 3:
						//Day
					default:
						//Assume no filters
				}
			}
		}
	}
	$page = new CalendarPage();
	echo $page->getHtml();
?>

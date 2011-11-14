<?php
	require_once 'includes/config/globals.php';
	require_once 'services/vo/Master.php';
	require_once 'services/MastersService.php';
	/*
	 * Class to test Master Services
	 *  - addMaster
	 *  - updateMaster
	 *  - getMaster
	 *  - getAllMasters
	 */
    class MasterServiceTest {
    	protected $ms;
		
		function __construct() {
			$this->ms = new MastersService();
		}
		
		function processPost() {
			$fields = Master::getDBFields();
			$do = isset($_GET['do']) ? $_GET['do'] : '';
			$master = new Master();
			$master->loadData($_POST);
			$sessionKey = $_POST['session_key'];
			switch($do) {
				case 'addMaster':
					$result = $this->ms->addMaster($sessionKey,$master);
					break;
				default:
					//Do nothing
					$result = -1;
			}
			return $this->ms->getMasterById($sessionKey,$result);
			
		}
		
		function validate($do,$fields,$values) {
			$ignoreArray = array();
			switch($do) {
				case 'addMaster':
					//Ignore the following fields
					$ignoreArray = array('id');
					break;
				default:
					//Do nothing
			}
			foreach($fields as $key => $value) {
				$blnCheck = true;
				foreach($ignoreArray as $iKey => $iValue) {
					if ($value == $iValue) {
						$blnCheck = false;
					}
				}
				if ($blnCheck) {
					if ($values[$value]==$value || $values[$value] == '') {
						return false;
					}
				}
			}
			return true;
		}
    	
    }
	
	$serviceTest = new MasterServiceTest();
	if(isset($_GET['do'])) {
		$master = $serviceTest->processPost();
		$response = json_encode($master->getFields());
	}
	else {
		//$masterForm = $serviceTest->addMaster();
		//echo $serviceTest->display();
		$temp = new Master();	
		$response = json_encode($temp->getFields());
		
	}
	
?><?php echo $response; ?>
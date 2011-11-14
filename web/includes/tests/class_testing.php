<?php
	require_once 'includes/models/db_model.php';
	class ClassTesting extends DBModel {
		const TEST='Test Constant';
		function __construct() {
			parent::__construct();
			$this->tLog->debug("ClassTesting::TEST = ".$this->getConstant('TEST'));
		}
		function secondTest() {
			$this->tLog->debug("ClassTesting::TEST = ".$this->getConstant('TEST'));
		}
	}
	$cT = new ClassTesting();
	$cT->secondTest();
?>
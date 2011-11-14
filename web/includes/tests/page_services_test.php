<?php
    require_once 'includes/config/globals.php';
	require_once 'includes/services/sql_services/page_services.php';
	require_once 'includes/services/sql_services/content_node_services.php';
	require_once 'includes/models/page/page.php';
	require_once 'includes/models/page/content_node.php';
	$sessionKey = session_id();
	$tLog->debug("--PageServicesTest Page--");
	$xml = new XmlWriter();
	$xml->openMemory();
	$xml->startDocument('1.0','UTF-8');
	$xml->startElement('response');
	
	function write(XMLWriter $xml,$data,$tLog) {
		foreach($data as $key => $value) {
			//$tLog->debug("TO XML: $key <:> $value");
			$xml->writeElement($key,"$value");
		}
	}
	
	//$pageService = new PageServices();
	$page = new Page();
	
	$contentService = new ContentNodeServices();
	$contentNode = new ContentNode();
	$doAction = isset($_GET['do']) ? $_GET['do'] : '';
	$error = "";
	$value = $page->getFields();
	switch($doAction) {
		case 'addContentNode':
			$contentNode->loadData($_POST);
			try {
				$contentId = $contentService->add($sessionKey,$contentNode);
				$contentNode->setData('id',$contentId);
				$value = $contentNode->getFields();
			}
			catch (Exception $e) {
				$error = $e->getMessage();
			}
			break;
		case 'addContentNodes':
			$jsonData = $_POST['json_data'];
			$dataArray = json_decode($jsonData);
			break;
		case 'addPage':
			$page->loadData($_POST);
			//$pageId = $pageService->addPage($sessionKey,$page);
			break;
		case 'loadPage':
			$pageId = $_POST['id'];
			//$page = $pageService->getPageById($sessionKey,$pageId);
			break;
		default:
			$error = 'nothing happening';
	}
	$xml->writeElement('error',$error);
	$xml->startElement('value');
	write($xml,$value,$tLog);
	$xml->endElement();
	$xml->endElement();
	$xmlResponse = str_replace('<?xml version="1.0" encoding="UTF-8"?>','',$xml->outputMemory(true));
	//$tLog->info("Sending response: $xmlResponse");
	echo $xmlResponse;
?>
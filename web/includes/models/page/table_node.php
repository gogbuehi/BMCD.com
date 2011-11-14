<?php
	require_once 'includes/models/page/content_node.php';
    class TableNode extends ContentNode {
		public $bodyNode;
		public $headerNode;
		protected $headerRow;
		protected $currentRow;
	
		function __construct(&$doc) {
			parent::__construct('table',$doc);
			$this->bodyNode = $this->createNode('tbody');
		
			$this->headerNode = $this->createNode('thead');
			$this->headerRow = $this->createNode('tr');
			$this->headerRow->setClass('header');
			$this->headerNode->appendChild($this->headerRow);
			$this->appendChild($this->headerNode);
			$this->appendChild($this->bodyNode);
		}
		function addRow(){
			$this->currentRow = $this->createNode('tr');
			$this->bodyNode->appendChild($this->currentRow);
		}
		function addColumnHeader($text){
			$this->headerRow->appendChild($this->createNode('td',$text));
		}
		function addColumnData($data){
			$this->currentRow->appendChild($this->createNode('td',$data));
		}
	
		
		
	}
?>
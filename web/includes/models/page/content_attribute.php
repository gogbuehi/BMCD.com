<?php
	require_once 'includes/models/db_model.php';
	require_once 'includes/models/page/content_node.php';
	/**
	 * Class to maintain required attributes for ContentNodes
	 */
	class ContentAttribute extends DBModel {
		public $src;
		public $href;
		public $width;
		public $height;
		public $selected;
		
		function __construct() {
			parent::__construct();
			//All fields set to NULL by default
			$fields = $this->getFields();
			foreach($fields as $key => &$value) {
				$value = null;
			}
		}
		function getFields() {
			return array_merge(
				parent::getFields(),
				array(
					'src'		=> &$this->src,
					'href'		=> &$this->href,
					'width' 	=> &$this->width,
					'height' 	=> &$this->height,
					'selected' 	=> &$this->selected
				)
			);
		}
		function setAttribute(&$domNode,$field,$value=null) {
			$fields = $this->getFields();
			if (isset($fields[$field])) {
				$fields[$field] = $value;
			}
			if ($domNode->hasAttribute($field)) {
				$domNode->removeAttribute($field);
			}
			if (!is_null($value)) {
				$domNode->setAttribute($field,$value);
			}
		}
		function getAttribute(&$domNode,$field) {
			if ($domNode->hasAttribute($field)) {
				return $domNode->getAttribute($field);
			}
			return null;
		}
		/**
		 * Extract attributes from a DOMNode
		 * @return void
		 * @param $domNode DOMNode		The DOMNode to look for attributes in
		 */
		function getNodesAttributes($domNode) {
			$fields = $this->getFields();
			unset(
				$fields['id'],
				$fields['dt'],
				$fields['blnvalid']
			);
			foreach ($fields as $key => &$value) {
				if ($domNode->hasAttribute($key)) {
					$value = $domNode->getAttribute($key);
				}
				else {
					$value = null;
				}
			}
		}
		/**
		 * Inject attributes into a DOMNode
		 * Remove attributes that are no longer set
		 * @return 
		 * @param $domNode DOMNode	The DOMNode to receive new attributes
		 */
		function setNodesAttributes(&$domNode) {
			$fields = $this->getFields();
			unset(
				$fields['id'],
				$fields['dt'],
				$fields['blnvalid']
			);
			foreach ($fields as $key => $value) {
				if (!is_null($value)) {
					$domNode->setAttribute($key,$value);
				}
				else {
					if ($domNode->hasAttribute($key)) {
						$domNode->removeAttribute($key);
					}
				}
			}
		}
	}
?>
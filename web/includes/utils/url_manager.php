<?php
    require_once 'includes/config/globals.php';
	class UrlManager {
		protected $protocol;
		protected $domain;
		protected $uri;
		protected $querystring;
		protected $hash;
		
		protected $tLog;
		function __construct($url=null) {
			global $tLog;
			$this->tLog = &$tLog;
		
			//GET THIS WORKING
			if (is_null($url)) {
				$this->protocol = $this->getCurrentProtocol();
				$this->domain = $_SERVER['SERVER_NAME'];
				$uriArray = explode('?',$_SERVER['REQUEST_URI']);
				$this->uri = array_shift($uriArray);
				$querystring = $_SERVER['QUERY_STRING'];
                if (isset($_SERVER['QUERY_STRING'])) {
                    if ($_SERVER['QUERY_STRING']!='') {
                        $this->querystring = $_SERVER['QUERY_STRING'];
                    }
                }
			}
			else {
				//Remove unnecessary "/?", if it exists
				$url = str_replace("/?","?",$url);
				//First, try to parse as though it is a complete URL
				$result = parse_url($url);
				if ($result === false || !isset($result['host'])) {
					//This is not a complete URL; Parse manually
					$protocolArray = explode('://',$url);
					if (count($protocolArray)==1) {
						//Assume current protocol
						$this->protocol = $this->getCurrentProtocol();
					}
					else {
						$this->protocol = array_shift($protocolArray);
					}
					$url = array_shift($protocolArray);
					//Check if there is a domain
					$firstSlash = strpos($url,URL_SEPARATOR);
					//$this->tLog->debug('Is firstSlash false? '.($firstSlash === false ? 'Yes' : 'No'));
					//$this->tLog->debug('Is firstSlash at Pos(0)? '.($firstSlash === 0 ? 'Yes' : 'No'));
					if ($firstSlash === false || $firstSlash !== 0) {
						
						//There is a domain
						$domainArray = explode(URL_SEPARATOR,$url,1);
						
						if (count($domainArray) == 1) {
							//There is no URI
							$this->uri = URL_SEPARATOR;
							//Check for querystring
							$querystringArray = explode('?',array_shift($domainArray));
							$this->domain = array_shift($querystringArray);
							if (count($querystringArray)==1) {
								$this->querystring = array_shift($querystringArray);
							}
							else {
								//There is no querystring
								$this->querystring = null;
							}
						}
						else {
							//There is a URI
							$this->domain = array_shift($domainArray);
							
							//Check for querystring
							$querystringArray = explode('?',array_shift($domainArray));
							$this->uri = URL_SEPARATOR.array_shift($querystringArray);
							if (count($querystringArray)==1) {
								$this->querystring = array_shift($querystringArray);
							}
							else {
								//There is no querystring
								$this->querystring = null;
							}
						}
						
					}
					else {
						//No domain in url
						$this->domain = $_SERVER['SERVER_NAME'];
						//Need to check for URI and querystring
						$querystringArray = explode('?',$url);
					
						$this->uri = array_shift($querystringArray);
						if (count($querystringArray) == 1) {
							$this->querystring = array_shift($querystringArray);
						}
					}
					
				}
				else {
					//$this->tLog->debug("PHP Parsed Url: ".print_r($result,true));
					$this->protocol = $result['scheme'];
					$this->domain = $result['host'];
					$this->uri = (isset($result['path']) ? $result['path'] : URL_SEPARATOR);
					$this->querystring = ($result['query']=='' ? null : $result['query']);
				}
			}
			//$this->tLog->debug('URL provided: '.(is_null($url) ? 'NULL' : $url));
			//$this->tLog->debug("URL components:\n - Protocol: ".$this->protocol."\n - Domain: ".$this->domain."\n - URI: ".$this->uri."\n - Querystring: ".(is_null($this->querystring) ? 'NULL' : $this->querystring));
			//$this->tLog->debug('Rendered URL: '.$this->renderUrl());
		}
		function getCurrentProtocol() {
			return (isset($_SERVER['HTTPS'])) ? 'https' : 'http';
		}
		function renderUrl() {
			return $this->protocol."://".$this->domain.$this->uri.(is_null($this->querystring)? '' : '?'.$this->querystring);
		}
		function getUriComponents() {
			$comp = explode(URL_SEPARATOR,$this->uri);
			$result = array();
			foreach ($comp as $key => $value) {
				if ($value == '') {
					unset($comp[$key]);
				}
				else {
					array_push($result,$value);
				}
			}
			return $result;
		}
		function isDecendentUrl($baseUrl) {
			$decComponentes = $this->getUriComponents();
			 $components = $baseUrl->getUriComponents();
			
			if (count($decComponentes) < count($components)) {
				//$this->tLog->debug("Decendant Count: ".count($decComponentes)."\nComp Count: ".count($components));
				return false;
			}
			for ($i = 0; $i < count($components); $i++) {
				//$this->tLog->debug("Dec: ".$decComponentes[$i]." | Comp: ".$components[$i]);
				if ($decComponentes[$i] != $components[$i]) {
					//$this->tLog->debug("\"".$this->renderUrl()."\" is NOT a decendent of \"".$baseUrl->renderUrl()."\"");
					return false;
				}
			}
			//$this->tLog->debug("\"".$this->renderUrl()."\" is a decendent of \"".$baseUrl->renderUrl()."\"");
			return true;
			
		}
	}
?>
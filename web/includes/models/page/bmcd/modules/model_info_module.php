<?php
	require_once 'includes/models/page/module_node.php';
    class ModelInfoModule extends ModuleNode {
    	protected $modelList;
		protected $makesList;
		protected $videoList;
		protected $imageList;
		protected $configuratorNode;
		protected $manufactureNode;
		protected $disclaimerNode;
		protected $modelUri;
		protected $makeUri;
		function __construct(&$doc,$make=null,$model=null) {
			parent::__construct($doc);
			$this->modelUri = $model;
			$this->makeUri = $make;
		}
		
		//-----------
		//
		//  START  Model_Lineup Functions
		//
		//-----------
		function makeModelInfo(){
			$this->setClass('ModModelInfo');
	
			// VAR makesList Node
			$this->makesList = $this->appendChild( $this->createNode('ul'));
				$this->setMoreClass('makes');
			// VAR modelsList Node
			$this->modelsList =$this->appendChild($this->createNode('ul'));
				$this->setMoreClass('models');
				
			// VAR videoList		
			$this->videoList=$this->appendChild( $this->createNode('ul'));
				$this->setMoreClass('videos');
			// VAR imageList	
			$this->imageList=$this->appendChild( $this->createNode('ul'));
				$this->setMoreClass('images');
			
			// VAR descriptionNode
			$this->descriptionNode=$this->appendChild( $this->createNode() );		
			$this->setMoreClass('description');
			
			
			// create Model Highlights Table	
					// <div class="highlights">
			$this->appendChild( $this->createNode() );
			$this->setMoreClass('highlights');
							// <p class="label">Model Highlights</p>
			$this->child->addText('Model Hightlights','p');
			$this->child->setMoreClass('label');
			// VAR highlightsTable
			$this->highlightsTable=$this->addMore( $this->createNode('table'));
			
			// VAR brochureNode
			//$this->brochureNode=$this->addAnchoredText('Download Brochure','#','_blank');
			//$this->setMoreAttribute('id','brochure');
		
			// VAR configuratorNode
			//$this->configuratorNode=$this->addAnchoredText('Configurator','#','_blank');
			//$this->setMoreAttribute('id','configurator');

			$this->addAnchoredText('Test Drive','#','_blank');
			$this->setMoreAttribute('id','testdrive');

			$this->addAnchoredText('Request a Quote','#','_blank');
			$this->setMoreAttribute('id','quote');
			
			$this->addAnchoredText('Email Friend','#','_blank');
			$this->setMoreAttribute('id','email');
		}
		
		function setBrochureNode($link,$domain=CONTENT){
			$this->brochureNode=$this->addAnchoredText('Download Brochure',$domain.$link,'_blank');
			$this->setMoreAttribute('id','brochure');
			//$this->brochureNode->setAttribute('href',$domain.$link);
		}
		
		function setConfiguratorLink($link,$domain=CONTENT){
			$this->configuratorNode=$this->addAnchoredText('Configurator',$domain.$link,'_blank');
			$this->setMoreAttribute('id','configurator');
			//$this->configuratorNode->setAttribute('href',$domain.$link);
		}
		
		function setManufactureLink($link,$domain=CONTENT){
			$this->manufactureNode=$this->addAnchoredText('Manufacturer Site',$domain.$link,'_blank');
			$this->setMoreAttribute('id','manufacture');
			//$this->configuratorNode->setAttribute('href',$domain.$link);
		}
		
		function setDisclaimer($makeName){
			$this->disclaimerNode=$this->addText('While we strive to keep this website current, certain changes in standard equipment, options, prices, availability or delays may occur that may not be immediately reflected on this site. Your '.$makeName.' Retailer is your best source for up-to-date information. '.$makeName.' reserves the right to change product specifications at any time without incurring obligations. Options shown or described are available at an extra cost and may be offered only in combination with other options or subject to additional ordering requirements or limitations.','p');
			$this->setMoreAttribute('class','disclaimer');
		}	
	
		function makeMakes($store){
			$section = '/research/model_lineup';
			switch($store)
			{
				case '901':
					$this->addMakesItem('/temp/images/jaguarlogo.png', $section.'/jaguar', 'Jaguar','100','50');
					$this->addMakesItem('/temp/images/landroverlogo.png', $section.'/land_rover', 'Land Rover','100','50');
					break;
				case '999':
					$this->addMakesItem('/temp/images/beltleylogo.png', $section.'/bentley', 'Bentley','100','50');
					$this->addMakesItem('/temp/images/lambologo.png', $section.'/lambo', 'Lamborghini','100','50');
					$this->addMakesItem('/temp/images/jaguarlogo.png', $section.'/lotus', 'Lotus','100','50');
					break;
				default:
						// TODO
					break;	
			}
		}

		function makeModels($make){
			$section = '/research/model_lineup';
			switch($make)
			{
				
				// LAND ROVER
				case '/land_rover':
						$section .= $make;
						$this->addModelItem('LR2',$section.'/lr2');
						$this->addModelItem('LR3',$section.'/lr3');
						//$this->addModelItem('Range Rover HSE',$section.'/range_rover/hse');
						//$this->addModelItem('Range Rover Supercharged',$section.'/range_rover/supercharged');
						//$this->addModelItem('Range Rover Sport HSE',$section.'/range_rover/sport_hse');
						//$this->addModelItem('Range Rover Sport Supercharged',$section.'/range_rover/sport_supercharged');
					break;
					
				// JAGUAR
				case '/jaguar':
						$section .= $make;
						// XK
						$this->addModelItem('XK 4.2',$section.'/xk/42');
						//$this->addModelItem('XKR 4.2L',$section.'/xk/r_42l');
						// XJ
						//$this->addModelItem('XJ8',$section.'/xj/8');
						//$this->addModelItem('XJ VDP',$section.'/xj/vdp');
						//$this->addModelItem('XJR',$section.'/xj/r');
						//$this->addModelItem('XJ Super V8',$section.'/xj/super_v8');
						// XF
						$this->addModelItem('XF LUX',$section.'/xf/lux');
						$this->addModelItem('XF PREM LUX',$section.'/xf/prem_lux');
						//$this->addModelItem('XF S/C',$section.'/xf/sc');
					break;
				// BENTLEY
				case '/bentley':
					    $section .= $make;
						$this->addModelItem('Continental Flying Spur',$section.'/continental_flying_spur');
						$this->addModelItem('Continental GT',$section.'/continental_gt');
						$this->addModelItem('GTC',$section.'/gtc');
						$this->addModelItem('Brooklands',$section.'/brooklands');
						$this->addModelItem('Arnage',$section.'/arnage');
						//Check spelling
						$this->addModelItem('Arzure',$section.'/arzure');
								// TODO
					break;
				// LOTUS
				case '/lotus':
						$section .= $make;
						$this->addModelItem('Elise',$section.'/elise');
						$this->addModelItem('Exige',$section.'/exige');
								// TODO
					break;					
				// LAMBO
				case '/lambo':
						$section .= $make;
						$this->addModelItem('Murcielago LP640 Coupe',$section.'/murcielago_lp640_coupe');
						$this->addModelItem('Murcielago LP640 Roadster',$section.'/murcielago_lp640_roadster');
						$this->addModelItem('Gallardo LP560-4',$section.'/gallardo_lp560_4');
						$this->addModelItem('Gallardo Superleggera',$section.'/gallardo_superleggera');
						$this->addModelItem('Gallardo Spyder',$section.'/gallardo_spyder');			
								// TODO
					break;
					
				// DEFAULT	
				default:
								// TODO
					break;
					
			}
		}
		
		function createMakesItem($src, $urlLink='#', $altText='',$width=null,$height=null){
				$liNode = $this->createNode('li');
				if($urlLink==$this->makeUri){
					$liNode->setAttribute('selected','selected');
				}
				
				$liNode->appendChild( $this->createAnchoredText('',$urlLink) );
				//$liNode->appendChild($this->createLinkNode($urlLink));
				$imgNode = $this->createImageNode($src);
				$imgNode->setAttribute('alt',$altText);
				if(!is_null($height)){
					$imgNode->setAttribute('height',$height);
				}
				if(!is_null($width)){
					$imgNode->setAttribute('width',$width);
				}
				$liNode->addMore($imgNode);
				return $liNode;
		}
		function addMakesItem($src, $urlLink='#', $altText='',$width=null,$height=null){
				return $this->makesList->appendChild( $this->createMakesItem($src, $urlLink, $altText,$width,$height) );
		}
		function addModelDescription($nodeIn){
			$this->descriptionNode->appendChild($nodeIn);
		}
		
		
		function addHighlight($attribute,$value){
			$trNode=$this->createNode('tr');
			$trNode->addText($attribute,'td');
			$trNode->addText($value,'td');
			
			$this->highlightsTable->appendChild($trNode);
		}
		
		function setTitles($title='',$subtitle=''){
			$this->addText($title,'p');
			$this->setMoreClass('title');
			$this->addText($subtitle,'p');
			$this->setMoreClass('subtitle');
		}
		
		function setHighlights($array)
		{
			$this->addHighlight('Engine', $array[ 0]);
			$this->addHighlight('Displacement',$array[ 1]);
			$this->addHighlight('Horsepower',$array[ 2]);
			$this->addHighlight('0-60', $array[ 3]);
			$this->addHighlight('Top Speed',$array[ 4]);
			$this->addHighlight('MSRP',$array[ 5]);
		}
		/**
		 * function for model lineup pages adds item to models list
		 * @return 
		 * @param object $text
		 * @param object $link
		 * @param object $selected[optional]
		 */		
		function createModelItem($text,$link,$selected=null){
				if($link==$this->modelUri){
					$selected = 'selected';
				}
				$liNode = $this->createNode('li');
				$liNode->setAttribute('selected',$selected);
				$liNode->appendChild( $this->createAnchoredText($text,$link) );
				return $liNode;
		}
		
		function addModelItem($text,$link,$selected=null){
				return $this->modelsList->appendChild( $this->createModelItem($text,$link,$selected) );
		}
		
		//----
		//  END  Model_Lineup Functions
		//----
    }
?>
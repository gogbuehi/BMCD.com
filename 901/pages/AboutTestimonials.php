<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class AboutTestimonials extends Bmcd901Page {	
    	function __construct($url=null) {
    		parent::__construct('Testimonials',$url);
			$this->makeContent();
    	}
		
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				
				//
				//  Note: Refactored to take out any extranious information. 
				//        Now there is only a UL node inside the main Module Node.
				//		  All text assoctiated with videos is stored in List items as a group of <p> tags.
				//
				$module = new ModuleNode($this->doc);
				$module->makeModVideoShowcase();
				$module->appendChild( $this->createNode('ul') );
				// David Mast Testimonial
				$module->addMore( $module->createImageSelectorItem('/temp/images/testamonials_2.png', CONTENT, 'selected', '/temp/video/testamonials/xf-david_bmcd_lr_420x560_pad.flv'));
				$module->child->addMoreText('David Mast drives a portfolio XK. Here is some additional information about David’s approach to design and style:','p');
				$module->child->addMoreText('','p');
				$module->child->child->addMoreText('DAVID MAST DESIGN','b');
				$module->child->addMoreText('','p');
				$module->child->child->addMoreText('Living the Contemporary Lifestyle','i');
				$module->child->addMoreText('The team at david mast design presents uniquely creative concepts that bring clients\' dreams to life. Owner David Mast adds his passion and artistic flair to transform clients\' visions into one-of-a-kind showpieces of artful living. It is his goal to bring about cutting edge, 21st century designs that afford comfortable living and sanctuary from the demanding pace of the outside world.','p');
				//$module->child->addMoreText('With broad experience in residential and commercial projects, david mast design excels at discovering those facets of modern design that resonate with clients\' innermost needs for emotional, physical, intellectual, and spiritual well-being.  david mast design combines quality materials, dramatic lighting, and simplicity of form to create stunning interiors and elegant landscapes.  Fusing subtle nuances with bold accents, david mast design creates custom works of art. Whether a client is striving for livability, beauty, elegance, or tranquility, david mast design is committed to assisting individuals and businesses achieve dreams beyond what they had thought possible.','p');
				//$module->child->addMoreText('With offices in San Francisco and Cupertino and an international portfolio ranging from remodels to innovative new construction, david mast design has the expertise to tailor the scope of the project to the needs of each client while still achieving a unique and transformative creation.','p');
				$module->child->addMoreText('','p');
				$module->child->child->addMoreText('For more information on david mast design:','b');
				$module->child->addMoreText('','p');
				$module->child->child->addMoreLink('','www.davidmastdesign.com');
				$module->child->child->addMoreText('www.davidmastdesign.com');
				$module->child->addMoreText('415 595-5420 or 408 973-1822','p');
				// Tom’s Testimonial
				$module->addMore( $module->createImageSelectorItem('/temp/images/testamonials_3.png', CONTENT, null, '/temp/video/testamonials/xf-toms_v1_bmcd_lr_420x560_pad.flv'));
				$module->child->addMoreText('Ruby and Gary Tom are driving the New Jaguar XF Sedan, black on black. They live in Almo, CA and after test driving a number of other brands, where impressed by the individuality and drivability of the XF. Even through it is Ruby’s car, Gary likes to drive it as well. But they say that, for now, their 16 year old son is only allowed to wash it.','p');
				// Shawn’s Testimonial
				$module->addMore( $module->createImageSelectorItem('/temp/images/testamonials_4.png', CONTENT, null, '/temp/video/testamonials/xf-shawn_bmcd_lr_420x560_pad.flv'));
				$module->child->addMoreText('Shawn drives the New XF Jaguar with a black exterior and a cinnabar interior and lives in San Francisco. He has driven a number of luxury vehicles but prefers the sporty practicality of the the Jaguar Sedan.','p');
				// Darren’s Testimonial
				$module->addMore( $module->createImageSelectorItem('/temp/images/testamonials_1.png', CONTENT, null, '/temp/video/testamonials/xf-darren_bmcd_lr_420x560_pad.flv'));
				$module->child->addMoreText('Derren looked at a number of premium luxury cars before he purchased the new XF Jaguar. He felt that the XF was a better value because of all of the great amenities included in the car. His favorite features include the new pop up shifter and the roomy back seats. He lives in Millbrae and likes the way the Jag purrs.','p');
				// Eliz’s Testimonial
				$module->addMore( $module->createImageSelectorItem('/temp/images/testamonials_eliz.png', CONTENT, null, '/temp/video/testamonials/xf-elizabeth_bmcd_lr_420x560_pad.flv'));
				$module->child->addMoreText('','p');
				
	
				//Add the module to the Floor.	
			$floor->appendChild($module);	
			//Add the floor to the page.	
			$this->appendContent($floor);
	
				//Start COMMENT		
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);	
				$module->makeModArticle();	
				$module->addBodyText('Clay has always been so helpful, he explains everything about what is needed for my Jag and what’s not.');
				$module->addBodyText('');
				$module->addMoreText('-Mable Pierce','b' );
				$module->addBodyText('');
				$module->addBodyText('');
				$module->addBodyText('I just wanted to say thank you for having such a wonderful staff at British Motors, I always feel so welcome whenever I bring my vehicle in.');
				$module->addBodyText('');
				$module->addMoreText('-Janna Don','b' );
			//Add the module to the Floor.		
			$floor->appendChild($module);		
			//Add the Floor to the page.
			$this->appendContent($floor);
	
		//Start COMMENT		
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);	
				$module->makeModArticle();	
				$module->addBodyText('Troy, you are the best. Thank you for understanding how valuable my time.');
				$module->addBodyText('');
				$module->addMoreText('-Richard Willams','b' );
				$module->addBodyText('');
				$module->addBodyText('');
				$module->addBodyText('Dear John,');
				$module->addBodyText('....I always feel better knowing my wife is Safaring in that car, thanks to you and your team. ');
				$module->addBodyText('');
				$module->addMoreText( '-Alex F.','b' );
			//Add the module to the Floor.		
			$floor->appendChild($module);		
			//Add the Floor to the page.
			$this->appendContent($floor);
				//Start COMMENT
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();
				$module->addBodyText('Gentlemen:');
				$module->addBodyText('My very sincere thanks to each of you for your kind, though, and professional way that you addressed and resolved the concerns that I had with the Jaguar I recently purchased. You restored my comfort with Jaguar, and you made me a zealous advocate for British Motors.');
				$module->addBodyText('');
				$module->addMoreText('-Gretta C. M.D.','b' );
				$module->addBodyText('');
				$module->addBodyText('');
				$module->addBodyText('...I know you are aware of AAA\'s commitment to its members and the brand equity they have both earned and enjoy. I drove over 200 miles to have my vehicle cared for by your dealership, and I simply refuse to go elsewhere. I do this because of your entire service team...thanks for surrounding yourself with professionals.');
				$module->addBodyText('');
				$module->addMoreText('-David W.','b' );
			//Add the module to the Floor.		
			$floor->appendChild($module);		
			//Add the Floor to the page.
			$this->appendContent($floor);
				//Start COMMENT	
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();			
				$module->addBodyText('I am writing to thank you for the excellent treatment I received at British Motor Car. Clay Pollard, in particular, is a great asset to your organization. He was patient and communicative, even when my warranty company was being difficult. He helped me to hopefully resolve my Land Rover issues, while staying friendly and professional. Clay went above and beyond for me, and I appreciated his excellent customer service. I will return to British Motor Car, and will recommend you to my friends. Its rare to find such great service like what I was given by your company, and by Clay. I really appreciate it.');
				$module->addBodyText('');
				$module->addMoreText('-Jeff C.','b' );
				$module->addBodyText('');
				$module->addBodyText('');
				$module->addBodyText('...I\'ve seen Clay constantly at BMC and he has always been extremely courteous, prompt and attentive. This time, though, he really went above and beyond to make sure that I received exceptional service. I needed some work done quickly and with out much notice, and Clay really went the extra mile to get the work done...Clay could have easily told me it wasn\'t possible. Instead, he tried over and over again until he found a way to get it done.  I really appreciated the hard work and dedication, and left feeling more satisfied than ever with BMC service.');
				$module->addBodyText('');
				$module->addMoreText('-Chris C.','b');
			//Add the module to the Floor.		
			$floor->appendChild($module);		
			//Add the Floor to the page.
			$this->appendContent($floor);
				//Start COMMENT	
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();			
				$module->addBodyText('Dear Joe:');
				$module->addBodyText('We wanted to thank you for taking such diligent care of us during the extended repair of our 2004 Range Rover HSE. Your attention to detail and impeccable follow through eased much of our worry through the arduous process...your explanation of the issue and all our options eased our apprehensions tremendously. We appreciate your professionalism in dealing with our extended warranty company and following up with us.  Thank you for your dedication to customer service and providing us with a level of quality service that is hard to come by these days. We will be sure to bring our vehicles back to British Motor for all our service needs. ');
				$module->addBodyText('');
				$module->addMoreText('-Kenneth G & Daniel K.','b');
				$module->addBodyText('');
				$module->addBodyText('');
				$module->addBodyText('Mr. Pollard not only performed the service in a timely manor, but got us an LR3 to use while my car was in service provided a great need (I had promised my five-year-old daughter a visit to Disneyland). My kids also like him very much as well!');
				$module->addBodyText('');
				$module->addMoreText('-Herbert B.','b');
			//Add the module to the Floor.		
			$floor->appendChild($module);		
			//Add the Floor to the page.
			$this->appendContent($floor);
				//Start COMMENT	
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();			
				$module->addBodyText('Norman:');
				$module->addBodyText('Picked up the cable I needed for my Walkman/MP3 player and the Leaper is really rockin\' now. Thanks to you and your team for a great job on the install yesterday! It was definitely worth the drive to get the job done right. Look forward to working with you in the future.');
				$module->addBodyText('');
				$module->addMoreText('-Kevin K.','b' );
			//Add the module to the Floor.		
			$floor->appendChild($module);		
			//Add the Floor to the page.
			$this->appendContent($floor);
				
			/**
			 * Note the difference between "appendChild" and "appendContent"
			 * "appendChild" is for adding a node as a child of another node
			 * "appendContent" is for adding a node as a child of the Page's body
			 */	
			 
		}
    }
?>
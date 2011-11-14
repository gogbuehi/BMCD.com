<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class FinancePrivacyPolicy extends Bmcd901Page {
    	
		
    	function __construct($url=null) {
    		parent::__construct('Privacy Policy',$url);
			$this->makeContent();
		
    	}
		
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();
				$module->addTitleText('Privacy Policy');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('1. General Statement','b');
				$module->addBodyText('This privacy statement explains our on-line policies and practices pertaining to customer information. It is through this disclosure that we intend to provide you with a level of comfort and confidence in how we collect and use information through this website, and how you can contact us if you have any questions or concerns. It is our sincere hope that through this communication of our data handling practices we will help facilitate a trusting and long-lasting relationship with you.');
				$module->addBodyText('This site integrates other web sites and may be integrated into other web sites. We urge you to review the privacy policy on each site requesting information from you before providing your information, especially those that require personal or financial data. For instance, this site integrates an on-line financing application to provide you with specific financial services that you may request, so be sure to review that privacy statement.');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('2. Information About Our Organization and Website','b');
				$module->addBodyText('This Privacy Statement describes the way that this website collects and uses the personal and non-personal information about you that we collect or that you provide through this website. This website is provided for British Motor Car Distrs Ltd., 901 Van Ness Avenue  San Francisco,  CA  94109.');
				$module->addBodyText('The business purpose of this website is to provide you on-line information about our dealership and our products and services. This On-Line Privacy Statement outlines the information we may collect and how we may use that information in the course of conducting our business. This statement describes the protections in place against collecting and using children\’s data.');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('3. Personally Identifiable Information We Collect From You and Methods of Collection','b');
				$module->addBodyText('During a normal visit to our site, no personally identifiable information about you is collected through any means or data flow channels. We do not collect any personal information about you such as your name, address, telephone number, email address, and credit card number (if you place an order with us) unless you provide it to us voluntarily. If you opt not to provide us with personal information, you can still access our websites; however you may be unable to participate in certain promotions, have a purchase order fulfilled or receive product information (such as a quote on a product) or qualify for a credit application.');
				$module->addBodyText('Our primary goal in collecting personal information from you when you visit British Motor Car Distrs Ltd. is to provide you the functionality and services that you need to have a meaningful and customized experience while using the site features. Personal data includes information that is particular to you such as street address, phone number, and e-mail address. We collect personal information in order to fulfill your request for services and products. For instance, when you indicate the wish to have us contact you, personal information such as name, mailing address, email address, type of request and possibly additional information, is collected and stored in a manner appropriate to the nature of the data and is used to fulfill the request. In some of your requests, an email notification may be generated to inform you of receipt of the request. This is the case when you choose email as the method of communication for fulfilling the request. The notification does not include personal information.');
				$module->addBodyText('British Motor Car Distrs Ltd. collects different types of customer information from a number of sources in meeting your products and services needs. We collect information to: identify you; learn about your situation; help us assess requests for products and services, confirm facts about you and help us deliver requested products and services. We may obtain customer information from a variety of sources.');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('4. How We Use the Personally Identifiable Information We Collect','b');
				$module->addBodyText('Personally identifiable information collected on British Motor Car Distrs Ltd. or other integrated sites may be used to:');
				$module->addMoreText('Fulfill a site user request such as send marketing or promotional materials, including e-mails, or other information','li');
				$module->addMoreText('Fulfill and deliver an order for goods or services such as a request for quote','li');
				$module->addMoreText('Respond to your comments or requests for information','li');
				$module->addMoreText('Meet a request for or to develop new products or services','li');
				$module->addMoreText('Contact you if necessary in the course of processing or shipping an order for products or services','li');
				$module->addMoreText('Generate site analytics to help improve our site layout, content, product offerings and services','li');
				$module->addMoreText('Compile user data that is stored in our or other corporate databases and that may be used for marketing and other permissible and appropriate purposes','li');
				$module->addMoreText('Match personal data collected here with data about you collected offline','li');
				$module->addMoreText('Comply with legal requirements','li');
				$module->addMoreText('Other permissible business uses','li');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('5. Aggregate (Non-Personally Identifiable) Information We Collect From You and Methods of Collection','b');
				$module->addBodyText('During a normal visit to our site, no personally identifiable information about you is collected. All information on our site is free to browse at your leisure without the need for you to provide us with any personal information. British Motor Car Distrs Ltd. does collect “aggregate” information, which is non-personally identifiable information. This means that we do not track these items on an individual basis that identifies you, but rather accumulate this info on an aggregate basis that includes all site visitors. Non-personal information includes tracking the site pages visited or the amount of time spent on our site.');			
				$module->addBodyText('Our primary goal in collecting aggregate information is to be able to perform site metrics that allow us to improve the functionality of the website. We need to collect aggregate information in order to track page visits, recognize peak usage times and analyze potential site redesign.');
				$module->addBodyText('When you visit our website a server housing the pages automatically generates a “session log.” We use session logs to help us determine w people travel through our site. In this way, we can structure our pages so that the information most frequently visited is easier to find. By tracking page visits, we can also determine if the information we’re providing is being used. The data generally gathered is the Internet Protocol (IP) address from which you came (which contains no personal information), the web site that referred you, the pages you visited and the date and time of those visits.');
				$module->addBodyText('When you view one of our websites or interactive advertisements, we may use “cookies” to collect aggregate data. A “cookie” is a small text file that helps us in many ways to make your visit to our website more enjoyable and meaningful to you. For example, cookies avoid you having to log in every time you come back to one of our websites. They also allow us to tailor a website or advertisement to better match your interests and preferences. There are a couple different types of cookies. A “session” cookie is stored only in your computer’s working memory (RAM) and only lasts for your browsing session. When you close all your browser’s windows, or when you shut down your computer, the session cookie disappears forever. A “persistent” cookie is stored on your computer’s hard drive until a specified date, which could be tomorrow, next week, or 10 years from now. Persistent cookies stay on your computer until either a) they expire, b) they are overwritten with newer cookies, c) you manually remove them. Most browsers can be configured not to accept cookies, however, this may prevent you from having access to some site functions or features.');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('6. How We Use the Aggregate (Non-Personally Identifiable) Information We Collect','b');
				$module->addBodyText('Non-Personally identifiable information collected on British Motor Car Distrs Ltd. or other integrated sites may be used to:');
				$module->addMore($this->createNode('ul'));
				$module->child->addMoreText('Compile aggregate and statistical data to help in website design and to identify popular features','li');
				$module->child->addMoreText('Measure site activity to allow us to update our site to better meet user wants and needs','li');
				$module->addBodyText('British Motor Car Distrs Ltd. utilizes session log data and your personal and non-personal data for the purpose of performing analytics on the users’ experience while visiting this site. This analysis:');
				$module->addMore($this->createNode('ul'));
				$module->child->addMoreText('Is performed on an aggregate level and does not identify you or your information personally','li');
				$module->child->addMoreText('Involves the use of a third party vendor acting on behalf of British Motor Car Distrs Ltd.','li');
				$module->child->addMoreText('Is performed in order to improve our website and the user experience','li');
				$module->child->addMoreText('May include the use of session and/or persistent cookies to track user movement across this and other websites or to track other events within or across this and other websites','li');
				$module->child->addMoreText('May be shared with other entities where deemed appropriate','li');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('7. Sharing Your Information','b');
				$module->addMoreText('Personal information you provide to us in the course of requesting a product or service through this website may be gathered and stored in our database and subject to applicable legal restrictions in one or more other associated corporate databases and be used for purposes of contacting you for things like promotional offers, marketing programs, or other communications from this website or other associated websites.');
				$module->addBodyText('British Motor Car Distrs Ltd. does not sell, rent, share or otherwise provide your personally identifiable information to others except as stated and as otherwise permitted by law.');
				$module->addBodyText('We may share personal information that we collect about you with other companies within our family of companies or subsidiaries. Our “family of companies” is the group of companies related to us by common control or ownership. We share information within this “family” as a normal part of conducting business and offering products and services to our customers. We may also share personal information with Ford Motor Company and its subsidiaries and affiliates who in turn may share personal information that you provide to British Motor Car Distrs Ltd. as permitted by applicable federal or state personal information sharing restrictions. This sharing may be desirable in order to honor your request for a price quote on a vehicle, to provide information for purposes of contacting you in the regular course of business and for other permissible uses.');
				$module->addBodyText('British Motor Car Distrs Ltd. will disclose your personal information, without notice, if required to do so by law or in the good faith belief that such action is necessary to: (a) conform to the edicts of the law or comply with legal process served on our dealership, our family of companies, Ford Motor Company including its subsidiaries and affiliates or the site; (b) protect and defend the rights or property of our dealership, our family of companies, Ford Motor Company including its subsidiaries and affiliates and this site; and, (c) act under exigent circumstances to protect the personal safety of users of our dealership, our family of companies, Ford Motor Company including its subsidiaries and affiliates, its web sites, or the public.');
				$module->addBodyText('Site metrics for British Motor Car Distrs Ltd. may be shared within our family of companies and within Ford Motor Company including its subsidiaries or affiliates. The information shared will be aggregate data and will not include any of your personally identifiable information.');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('8. Links to Other Sites','b');
				$module->addBodyText('British Motor Car Distrs Ltd. provides links to other websites. We encourage you to review the privacy statements of sites to which you are linked so that you can understand how those sites collect, use and share your information. British Motor Car Distrs Ltd., 901 Van Ness Avenue  San Francisco,  CA  94109 is not responsible for the privacy statements or other content or data handling practices on other websites.');
				$module->addBodyText('For instance, this site integrates an on-line financing application to provide you with specific financial services that you may request. Be sure to review their privacy statement prior to providing personal or financial data.');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('9. Children\'s Privacy','b');
				$module->addBodyText('British Motor Car Distrs Ltd. does not intend to collect personal information from children under 13 years of age.');
				$module->addBodyText('If a child has provided us with personal information a parent or guardian of that child may contact us (contact information shown below) if the parent or guardian wants the child’s information deleted from our records. We will then make reasonable efforts to delete the child’s information from the database that stores information for British Motor Car Distrs Ltd..');
				$module->addBodyText('');
				$module->addMore($this->createNode('u'));
				$module->child->addMoreText('10. Contacting Us','b');	
				$module->addBodyText('If you have any questions or comments concerning this privacy statement for British Motor Car Distrs Ltd. or have any questions regarding the contents of this website please contact us at (415) 776-7700.');
				$module->addBodyText('Non-Personally identifiable information collected on British Motor Car Distrs Ltd. or other integrated sites may be used to:');
				//Add the module to the Floor.	
				$floor->appendChild($module);	
				//Add the floor to the page.	
				$this->appendContent($floor);
				
			/**
			 * Note the difference between "appendChild" and "appendContent"
			 * "appendChild" is for adding a node as a child of another node
			 * "appendContent" is for adding a node as a child of the Page's body
			 */	
			 
		}
    }
?>
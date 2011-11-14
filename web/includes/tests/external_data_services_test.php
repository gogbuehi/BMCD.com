<?php
	require_once 'includes/config/globals.php';
	require_once 'includes/services/file_services/external_data_services.php';
	require_once 'includes/models/page/page.php';
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/page/content_attribute.php';
	require_once 'includes/models/page/inventory.php';
	require_once 'includes/models/filter.php';
	
    class ExternalDataServicesTest {
    	protected $eds;
		protected $tLog;
		protected $page;
		function __construct() {
			global $tLog;
			$this->tLog = &$tLog;
			$this->eds = new ExternalDataServices();
			$this->page = new Page();
			$this->page->setTitle('External Data Service Test');
		}
		function testInventoryData() {
			$url = INVENTORY_901_URL;
			$eData = $this->eds->getExternalData($url);
			//$this->tLog->debug("External data for URL($url): $eData");
			
			$inventory = new Inventory($this->page->doc);
			$inventory->addFilter(new Filter('Make','Jaguar',3,true));
			$inventory->addFilter(new Filter('Make','Land Rover',3,true));
			$inventory->buildInventory($eData);
			
			$this->page->appendContent($inventory);
			$urlDiv = &$inventory->getUrlTemplates();
			$this->page->appendContent($urlDiv);
			
			$this->tLog->debug('Done processing nodes...');
			$html = $this->page->getBodyInnerHtml();
			//$this->tLog->debug($html);
			return $html;
		}
    }
	
	$edsTest = new ExternalDataServicesTest();
?><html>
			<head>
				<title>British Motor Car Distributors - About Us - Our Team</title>
				<script src="/js/url_manager.js" type="text/javascript" language="javascript"></script>
				<script type="text/javascript">
					redirect_hash('<?php echo $_SERVER["REQUEST_URI"];?>');
				</script>
			</head>
			<body>
				<div class="ModBMCD901Header">
					<div class="BMCDLogo" >
						<a href="/home">
							<img src="http://<?php echo CONTENT; ?>/temp/images/bmcdlogo.png" width="90" height="70" title="To BMCDHome" />
						</a>
					</div>
					<div class="JagLogo" >
						<a href="www.jaguar.com">
							<img src="http://<?php echo CONTENT; ?>/temp/images/jaguarlogo.png" width="90" height="70" title="To Jag" />
						</a>
					</div>
					<div class="LandroverLogo" >
						<a href="www.landrover.com">
							<img src="http://<?php echo CONTENT; ?>/temp/images/landroverlogo.png" width="90" height="70" title="To Landrover" />
						</a>
					</div>
					<h1 class="Title">British Motor Car Distributors</h1>
					<h2 class="SubTitle">Homepage</h2>
					<h3 class="Address">901Van Ness Ave. San Francisco, CA 94109</h3>
					<ul class="MAHeaderMenu">
						<li class="Section" selected="selected">
							<a href="/home">
								<p>Home</p>
							</a>
						</li>
						<li class="Section" selected="">
							<a href="/about" >
								<p>About Us</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/about/general">
										<p>General</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/about/history">
										<p>History</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/about/ourteam">
										<p>Our Team</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/about/testimonials">
										<p>Testimonials</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="selected">
							<a href="/inventory" >
								<p>Inventory</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/inventory/jaguar">
										<p>Jaguar</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/inventory/landrover">
										<p>Land Rover</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="">
							<a href="/community" >
								<p>Research</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/community/newcarinfo">
										<p>New Car Info</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/community/forum">
										<p>Forum</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/community/newsandreviews">
										<p>News / Reviews</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="">
							<a href="/finance" >
								<p>Finance</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/finance/privacypolicy">
										<p>Privacy Policy</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/finance/taxbenifits">
										<p>Tax Benefits</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/finance/bankvendors">
										<p>Bank Vendors</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/finance/quickquote">
										<p>Quick Quote</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="">
							<a href="/parts" >
								<p>Parts / Services</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/parts/apointmentscheduler">
										<p>Appointment Scheduler</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/parts/bmcdstore">
										<p>BMCD Store</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/parts/orderparts">
										<p>Order Parts</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="">
							<a href="/events" >
								<p>Events</p>
							</a>
						</li>
					</ul>
				</div>
<!-- Place Floors Below Here  -->
				<div class="floor">
					<div class="ModInventory" sequence="sequence">
						<div class="MAInventoryHeader" >
							<h1 class="Title">New Inventory: Jaguar/Land Rover</h1>
							<p class="Types">Models:</p>
							<ul class="Sorts">
							<li seleced="">
								<a href="inventory/new/stype">Range Rover (26)</a>
							</li>
							<li seleced="">
								<a href="inventory/new/stype">Range Rover Sport (3)</a>
							</li>
							<li seleced="">
								<a href="inventory/new/stype">LR2 (3)</a>
							</li><li seleced="">
								<a href="inventory/new/stype">xf (4)</a>
							</li>
							<li seleced="selected">
								<a href="inventory/new/stype">s-type (3)</a>
							</li>
							<li seleced="">
								<a href="inventory/new/stype">t-type (4)</a>
							</li>
							</ul>
						</div>
						<?php echo $edsTest->testInventoryData(); ?>
					</div>
				</div>	
<!-- Place Floors Above Here  -->				
				<div class="ModBMCD901Footer" >
					<ul class="MAFooterMenu">
						<li class="Section" selected="">
							<a href="/home">
								<p>Home</p>
							</a>
						</li>
						<li class="Section" selected="">
							<a href="/about" >
								<p>About Us</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/about/general">
										<p>General</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/about/history">
										<p>History</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/about/ourteam">
										<p>Our Team</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/about/testimonials">
										<p>Testimonials</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="selected">
							<a href="/inventory" >
								<p>Inventory</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/inventory/jaguar">
										<p>Jaguar</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/inventory/landrover">
										<p>Land Rover</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="">
							<a href="/community" >
								<p>Research</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/community/newcarinfo">
										<p>New Car Info</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/community/forum">
										<p>Forum</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/community/newsandreviews">
										<p>News / Reviews</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="">
							<a href="/finance" >
								<p>Finance</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/finance/privacypolicy">
										<p>Privacy Policy</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/finance/taxbenifits">
										<p>Tax Benefits</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/finance/bankvendors">
										<p>Bank Vendors</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/finance/quickquote">
										<p>Quick Quote</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="">
							<a href="/parts" >
								<p>Parts / Services</p>
							</a>
							<ul>
								<li class="Subsection" selected="">
									<a href="/parts/apointmentscheduler">
										<p>Appointment Scheduler</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/parts/bmcdstore">
										<p>BMCD Store</p>
									</a>
								</li>
								<li class="Subsection" selected="">
									<a href="/parts/orderparts">
										<p>Order Parts</p>
									</a>
								</li>
							</ul>
						</li>
						<li class="Section" selected="">
							<a href="/events" >
								<p>Events</p>
							</a>
						</li>
					</ul>
					<!--<p class="CreatedBy"><h1>Site developed by </h1><h1><a href="http://hphant.com">Hierophant Media</a></h1></p>-->
				</div>
			</body>
		</html>
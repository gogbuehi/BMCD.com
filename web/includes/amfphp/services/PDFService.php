<?php
/**
 *	PDFService
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/PDF.php';
require_once 'models/Content_Library_Pdf.php';

class PDFService
{

	protected $fileService;
	public function __construct() 
	{
		$this->fileService = new FileServices();
	}
	
	/*
	 * This is for use within this class only.
	 * Use "addPDF" for public access
	 */
	protected function createRecord(PDF $object) {
		//return $this->createObjectRecord(self::TABLE,$object);
        $dbPDF = new Content_Library_Pdf($object);
        return $dbPDF->getIdValue();
	}


	public function addPDF($sessionKey,PDF $PDFObject) {
		$id = $this->createRecord($PDFObject);
		$PDFObject = $this->getPDFById($sessionKey,$id);
		$this->updatePDF($sessionKey,$PDFObject);
		return $id;		
	}
	
	public function updatePDF($sessionKey,PDF $PDFObject) {
		//Todo: Make sure PDF has the following method
		if (!$PDFObject->hasProperPDFName()) {
			$this->fileService->moveContentUrl($PDFObject->location,$PDFObject->generatePDFFileName());
		}
		$PDFObject->setProperNames();
		
		//$this->updateObjectByField(self::TABLE,$PDFObject,'id');

        $PDF = new Content_Library_Pdf($PDFObject);
        //$PDF->save();

	}
    

	public function getPDFById($sessionKey,$id) {
        $PDF = new Content_Library_Pdf($id);
        if ($PDF->isPersistent) {
            $PDFObject = $PDF->getAmfPhpInstance();
        }
        return $PDFObject;
            //$PDFObject = $PDF->;

        	//return $this->loadObjectByField(self::TABLE,'id',$id,$PDFObject);
	}
	
	public function getAllPDFs($sessionKey) {
		$PDF = new Content_Library_Pdf(false);
        $requiredParams = array(
            'blnvalid' => true,
            'domain' => $_SERVER['SERVER_NAME']
        );
        //$PDFs =$PDF->get('blnvalid', true);
        $PDFs = $PDF->getComplex($requiredParams);
        $PDFArray = array();
        foreach ($PDFs as $key => $value) {
            array_push($PDFArray,$value->getAmfPhpInstance());
        }
		//return $this->loadObjectsByField(self::TABLE,'blnvalid',1,$PDFObject);
        return $PDFArray;
	}
	
	
	function recordExists($PDFLocation) {

        $PDF = new Content_Library_Pdf($PDFLocation,'location');
        $PDF->match();
        return $PDF->isPersistent;
	}
	
	public function removePDF($sessionKey,PDF $PDFObject) {
		$PDFObject->blnvalid = FALSE;
        $PDF = new Content_Library_Pdf($PDFObject);
        $PDF->save();
		//$this->updateObjectByField(self::TABLE,$PDFObject,'id');
	}
	
	public function cleanupContents($sessionKey) {
        $PDF = new Content_Library_Pdf(false);
        $PDFs =$PDF->get('blnvalid', false);
        foreach ($PDFs as $key => $value) {
            $PDFObject = $value->getAmfPhpInstance();

			$this->fileService->deleteContentUrl($PDFObject->location);
            $value->delete();
        }
	}
    //SERVICE TEST FUNCTIONS
    public function testAddPDF() {
        $sessionKey = 'test_key';
        $PDF = new PDF(
            DBObject::NULL,
            'PDF LOCATION',
            1,
            2,
            'A PDF OBJECT',
            3,
            4,
            5,
            6,
            2
        );
        return $this->createRecord($PDF);
    }
}
?>

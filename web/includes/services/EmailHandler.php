<?php
require_once 'includes/config/globals.php';
require_once 'models/session.php';
require_once 'includes/services/file_services.php';
require_once 'includes/utils/url_manager.php';
require_once 'models/email.php';

/**
 * Description of email_handler
 *
 * @author Goodwin Ogbuehi
 */
class EmailHandler {
    const DEFAULT_TO='Contact@britishmotorcar.com';
    const SERVICE_TO='serviceappointments@britishmotorcar.com';
    const PARTS_TO='parts@britishmotorcar.com';
    const TEST_DRIVE_TO='TestDrive@britishmotorcar.com';
    const QUOTE_REQUEST_TO='QuoteRequest@britishmotorcar.com';
    const SALES_TO='vgolde@britishmotorcar.com';
    const BOUTIQUE_TO='parts@britishmotorcar.com';
    const DEFAULT_CC='';
    const DEFAULT_BCC='s.smith@hphant.com';
    const DEFAULT_FROM='BMCD_Site.no-reply@bmcd.com';
    const ORDERS_FROM='Orders.no-reply@bmcd.com';
    const DEFAULT_SUBJECT='British Motor Car Distributors - Web Email';
    const ADMIN_FROM='admin.no-reply@britishmotorcar.com';
    protected $tLog;
    protected $to;
    protected $cc;
    protected $bcc;
    protected $from;
    protected $subject;
    protected $template;
    protected $templateFile;
    protected $attributes;
    protected $message;

    protected $sendOtherAttributes;

    protected $emailRecord;
    function __construct($params=null) {
        global $tLog;
        $this->tLog = &$tLog;
        $this->init();
        $noEcho = false;
        if (is_null($params)) {
            $formName = $_REQUEST['formName'];
            $uri = $_REQUEST['d_uri'];
        }
        else {
            $formName = $params['formName'];
            $uri = $params['d_uri'];
            $this->attributes = $params;
            $noEcho = true;
        }
        $this->determineEmailAttributes($formName,$uri);
        $this->determineOtherAttributes();
        $this->populateTemplate();
        $this->storeEmailRecord($this->send($noEcho));
    }
    function init() {
        $this->cc = self::DEFAULT_CC;
        $this->bcc = self::DEFAULT_BCC;
        $this->attributes=array();
        $this->sendOtherAttributes = false;
        $this->templateFile = null;
    }
    const EMAIL_DEALER_FORM='EmailDealerForm';
    const TEST_DRIVE_FORM='TestDriveEmailForm';
    const QUOTE_REQUEST_FORM='QuoteRequestEmailForm';
    const QUICK_QUOTE_FORM='QuickQuoteForm';
    const SERVICE_REQUEST_FORM='ServiceRequestForm';
    const PARTS_REQUEST_FORM='PartsRequestForm';
    const EMAIL_FRIEND_FORM='EmailFriendForm';
    const BOUTIQUE_EMAIL_DEALER_FORM='StoreEmailDealerForm';
    const BOUTIQUE_EMAIL_FRIEND_FORM='StoreEmailFriendForm';
    const BOUTIQUE_SHOPPING_CART_SUBMISSION_FORM='ShoppingCartSubmitForm';
    const EVENTS_EMAIL_FRIEND_FORM='CalendarEmailFriendForm';
    const EVENTS_EMAIL_DEALER_FORM='CalendarEmailDealerForm';
    //Forgot Password email needs to be set up
    const FORGOT_PASSWORD_FORM='ForgotPasswordForm';
    function determineEmailAttributes($formName,$uri) {
        //$formName = $_REQUEST['formName'];
        //$uri = $_REQUEST['d_uri'];
        $this->attributes['request_url'] = 'http://'.$_SERVER['SERVER_NAME'].$uri;
        $this->tLog->debug('FormName: '.$formName);
        switch($formName) {
            case self::EMAIL_DEALER_FORM:
                if ($_SERVER['SERVER_NAME'] == SUBDOMAIN_999) {
                    $this->to = self::SALES_TO;
                }
                else {
                    $this->to = self::DEFAULT_TO;
                }

                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Customer Request for Information';
                //What email are we sending?
                $emailTemplateFileName = 'bmcd_901_999_emaildealer.htm';
                $this->sendOtherAttributes = true;
                break;
            case self::EVENTS_EMAIL_DEALER_FORM:
                if ($_SERVER['SERVER_NAME'] == SUBDOMAIN_999) {
                    $this->to = self::SALES_TO;
                }
                else {
                    $this->to = self::DEFAULT_TO;
                }

                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Customer Request for Information';
                //What email are we sending?
                $emailTemplateFileName = 'bmcd_901_999_events_emaildealer.htm';
                $this->sendOtherAttributes = true;
                break;
            case self::TEST_DRIVE_FORM:
                if ($_SERVER['SERVER_NAME'] == SUBDOMAIN_999) {
                    $this->to = self::SALES_TO;
                }
                else {
                    $this->to = self::TEST_DRIVE_TO;
                }
                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Customer Request for a Test Drive';
                //What email are we sending?
                $emailTemplateFileName = 'bmcd_901_999_testdrive_quote.htm';
                $this->sendOtherAttributes = true;
                break;
            case self::QUOTE_REQUEST_FORM:
                if ($_SERVER['SERVER_NAME'] == SUBDOMAIN_999) {
                    $this->to = self::SALES_TO;
                }
                else {
                    $this->to = self::QUOTE_REQUEST_TO;
                }
                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Customer Request for a Test Drive';
                //What email are we sending?
                $emailTemplateFileName = 'bmcd_901_999_testdrive_quote.htm';
                $this->sendOtherAttributes = true;
                break;
            case self::QUICK_QUOTE_FORM:
                if ($_SERVER['SERVER_NAME'] == SUBDOMAIN_999) {
                    $this->to = self::SALES_TO;
                }
                else {
                    $this->to = self::DEFAULT_TO;
                }
                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Customer Request for a Quote';
                //What email are we sending?
                $emailTemplateFileName = 'bmcd_901_999_quickquote.htm';
                $this->sendOtherAttributes = true;
                break;
            case self::SERVICE_REQUEST_FORM:
                $this->to = self::SERVICE_TO;
                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Customer Service Request';
                $emailTemplateFileName = 'bmcd_901_999_servicerequest.htm';
                $this->sendOtherAttributes = true;
                break;
            case self::PARTS_REQUEST_FORM:
                $this->to = self::PARTS_TO;
                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Customer Parts Request';
                $emailTemplateFileName = 'bmcd_901_999_partsrequest.htm';
                $this->sendOtherAttributes = true;
                break;
            case self::BOUTIQUE_EMAIL_DEALER_FORM:
                $this->to = self::BOUTIQUE_TO;
                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Boutique Product Request';
                $emailTemplateFileName = 'bmcd_901_999_boutique_emaildealer.htm';
                $this->sendOtherAttributes = true;
                break;
            case self::EMAIL_FRIEND_FORM:
                $this->sendEmailToFriend('British Motor Car Distributors: A Page Has Been Sent to You.');
                $emailTemplateFileName = 'bmcd_901_999_emailfriend.htm';
                break;
            case self::EVENTS_EMAIL_FRIEND_FORM:
                $this->sendEmailToFriend('British Motor Car Distributors: A Page Has Been Sent to You.');
                $emailTemplateFileName = 'bmcd_901_999_event_emailfriend.htm';
                break;
            case self::BOUTIQUE_EMAIL_FRIEND_FORM:
                $this->sendEmailToFriend('British Motor Car Distributors: A Page Has Been Sent to You.');
                $emailTemplateFileName = 'bmcd_901_999_boutique_emailfriend.htm';
                break;
            case self::BOUTIQUE_SHOPPING_CART_SUBMISSION_FORM:
                //There are 2 emails to send
                //One that goes to BMCD; Using the standard send fields:
                $this->to = self::BOUTIQUE_TO;
                $this->from = self::DEFAULT_FROM;
                $this->subject = 'Boutique Product Request';
                $emailTemplateFileName = 'bmcd_901_999_order_confirmation_emaildealer.htm';
                $this->sendOtherAttributes = true;

                //Get the email template
                $this->getTemplate($emailTemplateFileName);
                //list out the fields to expect
                $this->setAttributesFromRequest();

                //Finish the process to send out this email
                $this->determineOtherAttributes();
                $this->populateTemplate();
                $orderId = $this->storeEmailRecord();
                $this->message = str_replace('{orderID}', $orderId, $this->message);

                $this->send();

                //Another email goes to the customer
                //Reset the email handler
                $this->init();
                $this->attributes['orderID'] = $orderId;
                $this->sendOrderConfirmation('British Motor Car Distributors: Boutique Item Request Confirmation');
                $emailTemplateFileName = 'bmcd_901_999_order_confirmation_customer.htm';
                break;
            case self::FORGOT_PASSWORD_FORM:
                $this->to = $this->attributes['userName'];
                $this->from = self::ADMIN_FROM;
                $this->subject = 'BMCD Admin Request';
                $emailTemplateFileName = 'bmcd_901_999_loginregistration.htm';
                break;
            default:
                $msg = 'Unknown Form Name('.$formName.'). DATA SUBMISSION DUMP: '.$this->__toString();
                $this->tLog->warn($msg);
                throw new Exception($msg);
        }

        //Get the email template
        $this->getTemplate($emailTemplateFileName);
        //list out the fields to expect
        $this->setAttributesFromRequest();


    }

    function getTemplate($emailTemplateFileName) {
        $this->templateFile = $emailTemplateFileName;
        $fs = new FileServices();
        $this->template = $fs->getTemplateEmailFromFile($emailTemplateFileName);
    }
    function setAttributesFromRequest() {
        foreach ($_REQUEST as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }
    function sendOrderConfirmation($subject) {
        //billing_email
        //formName
        //d_uri
        //shipping_email
        //vehicleMake
        $this->to = $_REQUEST['billing_email'];
        $this->from = self::ORDERS_FROM;
        $this->subject = $subject;

        $site = $_SERVER['SERVER_NAME'];
        switch($site) {
            case SUBDOMAIN_901:
            case 'http://'.SUBDOMAIN_901:
                //Use 901 header
                $this->attributes['header']='http://'.CONTENT.'/emails/images/'.'bmcd_901_header.gif';
                $this->attributes['make']='Jaguar/Land Rover';
                break;
            case SUBDOMAIN_999:
            case 'http://'.SUBDOMAIN_999:
                $make = $_REQUEST['vehicleMake'];
                $this->attributes['make']=$make;
                switch ($make) {
                    case 'Lamborghini':
                        $this->attributes['header']='http://'.CONTENT.'/emails/images/'.'bmcd_999_lambo_header.gif';
                        break;
                    case 'Lotus':
                        $this->attributes['header']='http://'.CONTENT.'/emails/images/'.'bmcd_999_lotus_header.gif';
                        break;
                    case 'Bentley':
                        $this->attributes['header']='http://'.CONTENT.'/emails/images/'.'bmcd_999_bentley_header.gif';
                        break;
                    default:
                        $this->tLog->warn('There is no header image for store('.$site.') and make('.$make.').');

                }
                break;
            default:
                $this->tLog->warn("There is no email template for this Site($site).");
        }
        $this->sendOtherAttributes = false;
    }
    function sendEmailToFriend($subject) {
        $this->to = $_REQUEST['friendsEmail'];
        $this->from = $_REQUEST['yourEmail'];
        $this->subject = $subject;

        //Add a few aesthetic attributes
        $site = $_REQUEST['homepageLink'];
        switch($site) {
            case 'http://'.SUBDOMAIN_901:
                //Use 901 header
                $this->attributes['header']='http://'.CONTENT.'/emails/images/'.'bmcd_901_header.gif';
                $this->attributes['make']='Jaguar/Land Rover';
                break;
            case 'http://'.SUBDOMAIN_999:
                $make = $_REQUEST['vehicleMake'];
                $this->attributes['make']=$make;
                switch ($make) {
                    case 'Lamborghini':
                        $this->attributes['header']='http://'.CONTENT.'/emails/images/'.'bmcd_999_lambo_header.gif';
                        break;
                    case 'Lotus':
                        $this->attributes['header']='http://'.CONTENT.'/emails/images/'.'bmcd_999_lotus_header.gif';
                        break;
                    case 'Bentley':
                        $this->attributes['header']='http://'.CONTENT.'/emails/images/'.'bmcd_999_bentley_header.gif';
                        break;
                    default:
                        $this->tLog->warn('There is no header image for store('.$site.') and make('.$make.').');

                }
                break;
            default:
                $this->tLog->warn("There is no email template for this Site($site).");
        }
        $this->sendOtherAttributes = false;
    }
    function determineOtherAttributes() {
        if ($this->sendOtherAttributes) {
            $s = new Session();
            $this->attributes['ipAddress']=$s->d_ip;
            $this->attributes['session_key']=$s->d_key;

            //Get the page events
            $pe = $s->getRecentEvents(20);
            $eventString = '';
            $count = 0;
            $remove = array();
            foreach ($pe as $key => $value) {
                array_push($remove, $value->__toString());

                if ($count++ >= 20) {
                    array_pop($remove);
                }
            }
            foreach ($remove as $key => $value) {
                $eventString .= $value;
            }
            $this->attributes['link 20'] = $eventString;
        }
    }
    function populateTemplate() {
        $result = $this->template;
        foreach($this->attributes as $key => $value) {
            $result = str_replace('{'.$key.'}', $value, $result);
        }
        $this->message = $result;
    }
    function addCC($emailAddress) {
        $delimiter = '';
        if ($this->cc != '') {
            $delimiter = ',';
        }
        $this->cc .= $delimiter.$emailAddress;
    }

    function addBCC($emailAddress) {
        $delimiter = '';
        if ($this->bcc != '') {
            $delimiter = ',';
        }
        $this->bcc .= $delimiter.$emailAddress;
    }

    function storeEmailRecord($mail_sent = false) {
        if (is_null($this->emailRecord)) {
            $this->emailRecord = new Email();
            $this->emailRecord->d_to = $this->to;
            $this->emailRecord->d_cc = $this->cc;
            $this->emailRecord->d_from = $this->from;
            $this->emailRecord->d_subject = $this->subject;
            $this->emailRecord->d_template = $this->templateFile;
            $this->emailRecord->setAttributes($this->attributes);
            $this->emailRecord->d_email_sent = $mail_sent;
        }
        else {

            if (($this->emailRecord->d_email_sent === TRUE) && ($mail_sent === FALSE)) {
                $emailRecord = new Email();
                $emailRecord->d_to = $this->to;
                $emailRecord->d_cc = $this->cc;
                $emailRecord->d_from = $this->from;
                $emailRecord->d_subject = $this->subject;
                //Add the email record from the originating record
                $emailRecord->d_template = $this->emailRecord->id.",".$this->templateFile;
                $emailRecord->setAttributes($this->attributes);
                $emailRecord->d_email_sent = $mail_sent;
                $emailRecord->save();

                $this->emailRecord->d_template .= ",".$emailRecord->id;
            }
            else {
                $this->emailRecord->d_template .= ",$this->templateFile";
            }
        }
        $this->emailRecord->save();
        return $this->emailRecord->id;
    }

    function send($noEcho=false) {
        $mail_sent = false;
        $mail_sent2 = false;
        $headers = 'From: '.$this->from."\r\nContent-Type: text/html;\r\n";
        if ($this->cc !== '') {
            $headers .= "Cc: ".self::DEFAULT_CC."\r\n";
        }
        if ($this->bcc !== '') {
            $headers .= "Bcc: ".self::DEFAULT_BCC."\r\n";
        }
        if ($this->message != '' && !is_null($this->message)) {
            $mail_sent = true;
            if (ALLOW_EMAILS) {
                $mail_sent = mail($this->to, $this->subject, $this->message,$headers);

                $this->tLog->debug("$this");
            }
            else {
                //Don't send an email
                $this->tLog->info("$this");
            }
        }
        else {
            $this->tLog->warn('Mail message is null or blank for email data('.$this->__toString().')');
        }
        if(!$noEcho) {
            echo ($mail_sent ? 'success' : 'failure');
        }

        if (!$mail_sent) {
            $this->tLog->error('Email failed to send for: '.$this->emailRecord->__toString());
        }

        return $mail_sent;
    }
    function __toString() {
        $result = 'To: '.$this->to."\n".
            'From: '.$this->from."\n".
            'Subject: '.$this->subject."\n".
            'Attributes: [';
        foreach ($this->attributes as $key => $value) {
            $result .= "\n\t".$key.' => '.$value;
        }
        $result .= "\n]";
        return $result;

    }
}
?>
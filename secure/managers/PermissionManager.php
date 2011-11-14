<?php
require_once 'managers/BaseManager.php';
require_once 'exceptions/PermissionException.php';
require_once 'models/database_object.php';
require_once 'models/session.php';
require_once 'models/user.php';
/**
 * Description of PermissionManager
 *
 * Manages permissions for viewers and users of the site
 *
 * @author Goodwin
 */
class PermissionManager extends BaseManager {
    const LOGIN_SERVICE_NAME='LoginService';
    const LOGIN_SERVICE_PARAM_USERNAME='username';
    const LOGIN_SERVICE_PARAM_PASSWORD='password';
    const LOGIN_SERVICE_PARAM_DOMAIN='domain';

    const LOGOUT_SERVICE_NAME='LogoutService';

    const CHANGE_PASSWORD_SERVICE_NAME='ChangePasswordService';
    const CHANGE_PASSWORD_SERVICE_PARAM_PASSWORD='password';
    const CHANGE_PASSWORD_SERVICE_PARAM_NEW_PASSWORD='newPassword';
    const CHANGE_PASSWORD_SERVICE_PARAM_NEW_PASSWORD_CONFIRM='newPasswordConfirm';
    const CHANGE_PASSWORD_SERVICE_PARAM_DOMAIN='domain';

    const FORGOT_PASSWORD_SERVICE_NAME='ForgotPasswordService';
    const FORGOT_PASSWORD_SERVICE_PARAM_USERNAME='username';
    
    public $services = array(
        self::LOGIN_SERVICE_NAME => array(
            self::LOGIN_SERVICE_PARAM_USERNAME => self::PARAM_TYPE_STRING,
            self::LOGIN_SERVICE_PARAM_PASSWORD => self::PARAM_TYPE_STRING,
            self::LOGIN_SERVICE_PARAM_DOMAIN => self::PARAM_TYPE_STRING
        ),
        self::LOGOUT_SERVICE_NAME => array(),
        self::CHANGE_PASSWORD_SERVICE_NAME => array(
            self::CHANGE_PASSWORD_SERVICE_PARAM_PASSWORD => self::PARAM_TYPE_STRING,
            self::CHANGE_PASSWORD_SERVICE_PARAM_NEW_PASSWORD => self::PARAM_TYPE_STRING,
            self::CHANGE_PASSWORD_SERVICE_PARAM_NEW_PASSWORD_CONFIRM => self::PARAM_TYPE_STRING
        ),
        self::FORGOT_PASSWORD_SERVICE_NAME => array(
            self::FORGOT_PASSWORD_SERVICE_PARAM_USERNAME => self::PARAM_TYPE_STRING
        )
    );
    protected $tLog;
    protected $session;

    function __construct() {
        global $tLog;
        $this->tLog = &$tLog;
        //Get the current session
        $this->session = new Session();
    }
    function handleRequest(ServiceRequest $request,$params) {
        $serviceName = $request->getServiceName();
        $response = new ServiceResponse($serviceName,$request->getType());
        switch($serviceName) {
            case self::LOGIN_SERVICE_NAME:
                return $this->loginRequest($response,$params);
                break;
            case self::CHANGE_PASSWORD_SERVICE_NAME:
                return $this->changePasswordRequest($response, $params);
                break;
            case self::LOGOUT_SERVICE_NAME:
                return $this->logoutRequest($response);
                break;
            case self::FORGOT_PASSWORD_SERVICE_NAME:
                return $this->forgotPasswordRequest($response, $params);
                break;
            default:
                $msg = 'Unkown Service: '.$serviceName;
                throw new ServiceException($msg,ServiceException::CODE_INVALID_SERVICE);
        }
    }
    function loginRequest(ServiceResponse &$response,$params) {
        try {
            $this->login($params[self::LOGIN_SERVICE_PARAM_USERNAME], $params[self::LOGIN_SERVICE_PARAM_PASSWORD]);
            $msg = 'Logged In';
            $this->tLog->debug('Logged In');
            $response->addMessage('action', $msg);
        }
        catch (PermissionException $e) {
            return new ErrorResponse($response->getServiceName(),$response->getType(),$e);
        }
        return $response;
    }
    public function login($username,$password) {
        
        //Load user by username
        //$user = new User($username,'username');
        $user = new User(false);
        $user->d_username = $username;

        if ($user->match() === FALSE) {
            $msg = 'User with username('.$username.') does not exist.';
            $this->tLog->warn($msg);
            throw new PermissionException($msg,PermissionException::CODE_UNKNOWN_USER);
        }

        //Check the password
        if(!$user->isCorrectPassword($password)) {
            $msg = 'Incorrect password for User('.$username.')';
            $this->tLog->warn($msg);
            throw new PermissionException($msg,PermissionException::CODE_INCORRECT_PASSWORD);;
        }

        //Associate the user with the session
        $this->session->setCurrentUser($user);
    }
    function logoutRequest(ServiceResponse &$response) {
        $this->logout();
        $response->addMessage('action', 'Logged out');
        return $response;
    }
    public function logout() {
        $this->session->setCurrentUser();
    }
    function changePasswordRequest(ServiceResponse &$response,$params) {
        try {
            $this->changePassword($params[self::CHANGE_PASSWORD_SERVICE_PARAM_PASSWORD], $params[self::CHANGE_PASSWORD_SERVICE_PARAM_NEW_PASSWORD],$params[self::CHANGE_PASSWORD_SERVICE_PARAM_NEW_PASSWORD_CONFIRM]);
            $msg = 'Password Successfully Changed.';
            $this->tLog->debug($msg);
            $response->addMessage('action', $msg);
        }
        catch (PermissionException $e) {
            return new ErrorResponse($response->getServiceName(),$response->getType(),$e);
        }
        return $response;
    }

    public function changePassword($password,$newPassword,$newPasswordConfirm) {
        if ($this->isLoggedIn()) {
            $user = $this->session->getCurrentUser();
            $msg = $user->setPassword($password, $newPassword, $newPasswordConfirm);
            if ($msg !== "") {
                throw new PermissionException($msg,PermissionException::CODE_PASSWORD_CHANGE_ERROR);
            }
            $user->save();
        }
        else {
            $msg = 'Not logged in. Please login before updating the password.';
            throw new PermissionException($msg,PermissionException::CODE_PERMISSION_DENIED);
        }
    }
    function forgotPasswordRequest(ServiceResponse &$response,$params) {
        try {
            $this->forgotPassword($params[self::FORGOT_PASSWORD_SERVICE_PARAM_USERNAME]);
            $msg = 'Change Password Request sent to: '.$params[self::FORGOT_PASSWORD_SERVICE_PARAM_USERNAME];
            $this->tLog->debug($msg);
            $response->addMessage('action', $msg);
        }
        catch (PermissionException $e) {
            return new ErrorResponse($response->getServiceName(),$response->getType(),$e);
        }
        return $response;
    }
    function forgotPassword($username) {
        try {
            $user = new User(false);
            $user->d_username = $username;
            if ($user->match() == FALSE) {
                $msg = 'User with username('.$username.') does not exist.';
                $this->tLog->warn($msg);
                throw new PermissionException($msg,PermissionException::CODE_UNKNOWN_USER);
            }
            else {
                //User exists. Email them a new password
                $randString = md5('salt'.$_SERVER['REQUEST_TIME']);
                //Get the first few characters of the hash
                $newPassword = substr($randString, 0, 8);
                $user->resetPassword($newPassword);
                //Email the user their new password
                /**
                 * Post a request to the email service
                 * Fields:
                 * - userName
                 * - password
                 */
                require_once 'includes/services/EmailHandler.php';
                $params = array(
                    'formName' => EmailHandler::FORGOT_PASSWORD_FORM,
                    'd_uri' => '_ADMIN_FORGOT_PASSWORD_',
                    'userName' => $user->d_username,
                    'password' => $newPassword
                );
                $emailHandler = new EmailHandler($params);
                $user->save();
            }
        }
        catch (PermissionException $e) {
            return new ErrorResponse($response->getServiceName(),$response->getType(),$e);
        }
    }
    /**
     * Method to generate a random password
     * Note: This is currently not being used.
     */
    function generateRandomPassword() {
        $aNumber = time();
        $randomString = md5($aNumber.'_'.rand());
    }
    public function isLoggedIn() {
        return !DBObject::isNull($this->session->getCurrentUser());
    }

    public function isAdmin() {
        return $this->isLoggedIn() && $this->session->d_o_user->isAdmin();
    }
    public function getLoggedInUser() {
        
        return $this->session->d_o_user;
        
    }

    public function requiresAdmin() {
        if (!$this->isLoggedIn()) {
            $msg = 'Permission Denied. Not logged in.';
            throw new PermissionException($msg,PermissionException::CODE_PERMISSION_DENIED);
        }
        else {
            return true;
        }
    }
}
?>
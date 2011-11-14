<?php
require_once 'models/database_object.php';
/**
 * Description of User
 *
 * @author Goodwin Ogbuehi
 */
class User extends DBObject {
    const DEFAULT_PASSWORD='jop-scol34..aa$'; //Todo: Needs an MD5 HASH
    const PASSWORD_MIN_LENGTH=6;
    const PASSWORD_MAX_LENGTH=32;
    const STANDARD_USER=1;
    const ADMIN_USER=2;
    
    /**
     * A unique identifier for a user
     *  - This may be an alias, full name,
     *      or an email address
     * @var <String>
     */
    public $d_username;
    /**
     * Determines access rights for a user
     *
     * @var <int>
     */
    public $d_permission;
    /**
     * An MD5 hash of the user's password
     * Note: This shouldn't be stored in the instance of the user
     * @var <String> 
     */
    protected $d_password;
    private $password;

    function __construct($value,$field='id') {
        parent::__construct($value, $field);
    }
    /**
     * Inserts the values from a database recordset into the member variables
     * of this object, to make this object match its persistent data
     * @param <array> $rs   The associative array that represents a record
     *                      in this object's corresponding database table;
     *                      Or, if false, loads default data, as no record was
     *                      retrieved
     */
    function loadData($rs) {
        parent::loadData($rs);
        if ($this->isPersistent==FALSE) {
            //Put Default values in
            $this->id = self::NULL;
            $this->d_permission=self::STANDARD_USER;
            $this->d_password=md5(self::DEFAULT_PASSWORD);
        }
        $this->protectPassword();
        return $this->isPersistent;
        
    }
    /**
     * Updates or creates a persistent instances of this object in the database
     * Also, ensure any password changes are updated in the database
     */
    function save() {
        //$this->resurfacePassword();
        parent::save();
        //$this->protectPassword();
    }
    /**
     * Puts the password word into an inacessible (private) member variable,
     * so that the user's password is not ordinarily available in the object
     */
    private function protectPassword() {
        $this->password=$this->d_password;
        $this->d_password = md5($this->d_password);
    }
    /**
     * Determines if the provided password matches the user's stored password
     * @param <String> $plainPassword   The provided password
     * @return <boolean>                True, if the password matches the
     *                                  stored password
     *                                  False, otherwise
     */
    public function isCorrectPassword($plainPassword) {
        $this->tLog->debug("PASSWORD: [$plainPassword] - HASH: [".md5($plainPassword)."]");
        return ($this->password == md5($plainPassword));
    }
    /**
     * Restores the user's true password, so that it may be used for saving
     * in the database.
     */
    private function resurfacePassword() {
        $this->d_password = $this->password;
        $this->password = null;
    }
    /**
     * Verifies the user has authority to change the password, and changes
     * the password, if the new password passes validation
     * @param <String> $oldPassword         The user's current password
     * @param <String> $newPassword         The new password to use
     * @param <String> $newPasswordConfirm  The same string as $newPassword
     * @return <String>                     Returns a message, indicating any
     *                                      problems that may have occurred with
     *                                      attempting to set a new password
     *                                      for the user
     */
    function setPassword($oldPassword,$newPassword,$newPasswordConfirm) {
        $msg = '';
        if ($this->isCorrectPassword($oldPassword)) {
            if ($newPassword != $newPasswordConfirm) {
                $msg .= 'New password does not match confirmation password.\n';
            }
            else {
                $msg .= self::validatePassword($newPassword);
            }
        }
        else {
            $msg .= 'Old password is incorrect.\n';
        }
        if ($msg != '') {
            $this->tLog->info($msg);
        }
        else {
            //Set the new password
            $this->d_password = $newPassword;
            $this->protectPassword();
        }
        return $msg;
    }
    public function resetPassword($newPassword) {
        $this->d_password = md5($newPassword);
    }

    function isAdmin() {
        return $this->d_permission === self::ADMIN_USER;
    }
    /**
     * Ensures a provided password meets certain base criteria
     * @param <String> $password    The password to validate
     * @return <String>             An empty string, if the password
     *                              successfully validated.
     *                              Otherwise, it will passback messaging
     *                              indicating which aspects of validation
     *                              failed
     */
    static function validatePassword($password) {
        $msg = '';
        if ($password == '') {
            $msg .= 'Password is blank.\n';
        }
        if (strlen($password) < self::PASSWORD_MIN_LENGTH) {
            $msg .= 'Password must be at least '.self::PASSWORD_MIN_LENGTH.' characters.\n';
        }
        if (strlen($password) > self::PASSWORD_MAX_LENGTH) {
            $msg .= 'Password cannot be longer than '.self::PASSWORD_MAX_LENGTH.' characters.\n';
        }
        return $msg;
    }
}
?>

<?php
class Auth {
    protected $authPolicies;
    protected static $instance;
    
    public function __construct() {
        $this->authPolicies = [];
    }
    
    public static function getInstance() {
        if(self::$instance == null)
            self::$instance = new Auth();
        return self::$instance;
    }
    
    public function addAuthPolicy($policyName, $callback) {
        $this->authPolicies[] = [
            'name' => strtolower($policyName),
            'callback' => $callback
        ];
    }
    
    public function hasPolicy($policyName) {
        foreach($this->authPolicies as $ap) {
            if($ap['name'] == strtolower($policyName))
                return true;
        }
        return false;
    }
    
    public function isAuthorized($user, $policyName) {
        $ap = $this->getPolicy($policyName);
        $authorized = false;
        
        if($ap != null) {
            $authorized = call_user_func_array($ap['callback'], $user);
        }
        
        return $authorized;
    }
    
    public function getLoggedInUser() {
        if(isset($_SESSION['logged_in_user'])) {
            $id = $_SESSION['logged_in_user'];
            return User::findById($id);
        }
        return null;
    }
    
    public function login($username, $password) {
        if(!$this->isNullOrEmpty($username) && !$this->isNullOrEmpty($password)) {
            $user = User::getUserByName($username);
            $pass = sha1($username . $password);
            
            if($user->password == $pass) {
                $_SESSION['logged_in_user'] = $user->id;
                $_SESSION['login_update_time'] = time();
                return true;
            }
        }
        return false;
    }
    
    public function logout() {
        if(isset($_SESSION['logged_in_user'])) {
            $_SESSION['logged_in_user'] = null;
            $_SESSION['login_update_time'] = 0;
            session_destroy();
        }
    }
    
    public function checkIdleTime() {
        if(isset($_SESSION['login_update_time'])) {
            $now = time();
            $lut = $_SESSION['login_update_time'];
            
            if(($now - $lut) > 600) //10 minutes
                $this->logout();
        }
    }
    
    protected function getPolicy($policyName) {
        foreach($this->authPolicy as $ap) {
            if($ap['name'] == strtolower($policyName))
                return $ap;
        }
        return null;
    }
    
    protected function isNullOrEmpty($item) {
        if(is_null($item) || empty($item) ||
        is_string($item) && strlent($item) == 0)
            return true;
        return false;
    }
}
?>
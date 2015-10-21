<?php
session_start();
class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('user');

        $this->load->model('Users_model', 'users');
    }

    public function index() {
        $user = get_current_user();

        if($user == null)
            redirect('/auth/login');
        redirect('/jobs/index');
    }

    public function login() {
        //var_dump($this->input);
        if($this->input->method(true) == 'POST') {
            if($this->input->post('submit') == 'Login') {
                $user = $this->input->post('username');
                $pass = $this->input->post('password');
                $hPass = sha1($pass);

                if($this->users->userExists($user)) {
                    if($this->users->credentialsValid($user, $hPass)) {
                        $uid = $this->users->getUserId($user);
                        $_SESSION['user_logged_in'] = true;
                        $_SESSION['active_user_id'] = $uid;
                        $this->users->updateLogin($uid);
                        redirect('/jobs/index');
                    }
                    else {
                        redirect('/auth/login/invalid');
                    }
                }
                else {
                    redirect('/auth/login/nouser');
                }
                /*else {
                    try {
                        $conn = ldap_connect('mail.nationalpcpro.com');

                        if($conn) {
                            $bind = ldap_bind($conn, $user, $pass);

                            if($bind) {
                                $ud = array();
                                $ud['username'] = $user;
                                $ud['password'] = $hPass;
                                $ud['last_login'] = time();
                                $ud['created'] = time();
                                $ud['email'] = $user . '@nationalpcpro.com';
                                $ud['display_name'] = $user;

                                $uid = $this->users->add($ud);
                                $_SESSION['user_logged_in'] = true;
                                $_SESSION['active_user_id'] = $id;
                                redirect('/jobs/index');
                            }
                            else
                                redirect('/auth/login/invalid');
                            ldap_unbind($conn);
                        }
                    }
                    catch(Exception $ex) {
                        redirect('/auth/login/error');
                    }
                }*/
            }
        }
        $data['title'] = 'Worklogs Login';
        $this->load->view('auth_login', $data);
    }

    public function logout() {
        $_SESSION['active_user_id'] = null;
        $_SESSION['user_logged_in'] = null;
        session_decode();

        redirect('/auth/login');
    }
}
?>

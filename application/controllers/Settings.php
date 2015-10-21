<?php
class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('status');
        $this->load->helper('store');
    }

    public function index() {
        $data['title'] = 'Settings';
        $this->load->view('settings_index', $data);
    }

    public function save() {
        if($this->input->method(true) == 'POST') {
            if($this->input->post('addstatus') == 'Add Status') {
                $status = $this->input->post('status');
                status_add($status);
            }
            else if($this->input->post('addstore') == 'Add Store') {
                $store = $this->input->post('store');
                store_add($store);
            }
        }
        redirect('settings');
    }
}
?>

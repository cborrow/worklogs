<?php
session_start();
class Jobs extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('status');
        $this->load->helper('store');
        $this->load->helper('user');
        user_login_check();

        $this->load->model('Jobs_model', 'jobs');
    }

    public function index() {
        redirect('/jobs/page/1');
    }

    public function page($pageNum) {
        $pageNum = $pageNum - 1;
        $total = $this->jobs->getJobCount();
        if($pageNum == -1)
            redirect('/jobs/page/1');
        if(($pageNum * 25) >= $total && $total > 0)
            redirect('/jobs/page/' . ($pageNum - 1));

        $data['title'] = 'Jobs > Page ' . ($pageNum + 1);
        $data['jobs'] = $this->jobs->getJobsByPage($pageNum, 25);
        $data['curPage'] = $pageNum + 1;
        $data['totalPages'] = floor($total / 25) + 1;
        $this->load->view('jobs_index', $data);
    }

    public function add() {
        if(get_current_store()->id == 0) {
            $_SESSION['GoBackTo'] = 'jobs/add';
            redirect('/jobs/changestore');
        }

        if($this->input->method(true) == 'POST') {
            if($this->input->post('submit') == 'Save') {
                $dd['workorder'] = $this->input->post('workorder');
                $dd['customer'] = $this->input->post('customer');
                $dd['serial'] = $this->input->post('serial');
                $dd['notes'] = $this->input->post('notes');
                $dd['user_id'] = 1;
                $dd['store_id'] = get_current_store()->id;
                $dd['status_id'] = 2;
                $dd['created'] = time();
                $dd['modified'] = 0;

                $this->jobs->insert($dd);
                //redirect('/jobs');
            }
        }

        $data['title'] = 'Add Job';
        $this->load->view('jobs_add', $data);
    }

    public function edit($id) {
        if($this->input->method(true) == 'POST') {
            if($this->input->post('submit') == 'Save') {
                $dd['workorder'] = $this->input->post('workorder');
                $dd['customer'] = $this->input->post('customer');
                $dd['serial'] = $this->input->post('serial');
                $dd['notes'] = $this->input->post('notes');
                $dd['modified'] = time();
                $dd['status_id'] = $this->input->post('status');
                $dd['store_id'] = $this->input->post('store');

                $this->jobs->update($id, $dd);
                //redirect('/jobs/edit/' . $id);
            }
        }
        $data['title'] = 'Edit Job';
        $data['status'] = get_status_list();
        $data['stores'] = get_store_list();
        $data['job'] = $this->jobs->getJobById($id);
        $this->load->view('jobs_edit', $data);
    }

    public function delete($id) {
        if($this->input->method(true) == 'POST') {
            if($this->input->post('submit') == 'Delete') {
                if($this->input->post('delete') == 'yes') {
                    $this->jobs->delete($id);
                    redirect('/jobs');
                }
            }
            redirect('/jobs');
        }
        $data['title'] = 'Delete Job';
        $this->load->view('jobs_delete', $data);
    }

    public function close($id) {
        $this->jobs->close($id);
        redirect('/jobs');
    }

    public function printjob($id) {
        $data['title'] = "Print Job";
        $data['job'] = $this->jobs->getJobById($id);
        $this->load->view('jobs_print', $data);
    }

    public function search() {
        $data['title'] = 'Search Jobs';

        if($this->input->method(true) == 'POST') {
            if($this->input->post('query') != '') {
                $q = $this->input->post('query');

                $data['jobs'] = $this->jobs->search($q);
                $this->load->view('jobs_search', $data);
            }
            else {
                redirect('/jobs');
            }
        }
        else {
            redirect('/jobs');
        }
    }

    public function changestore($id = null) {
        $data['title'] = 'Change Active Store';

        if($id != null) {
            set_current_store($id);

            if(isset($_SESSION['GoBackTo'])) {
                $path = $_SESSION['GoBackTo'];
                $_SESSION['GoBackTo'] = null;
                redirect($path);
            }

            redirect('jobs/index');
        }
        $this->load->view('jobs_choosestore', $data);
    }
}
?>

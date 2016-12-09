<?php
session_start();
class Jobs extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->helper(['url', 'status', 'store', 'user', 'asset']);
        user_login_check();

        $this->load->model('Jobs_model', 'jobs');
    }

    public function index() {
        if(isset($_SERVER['HTTP_REFERER']) && strstr($_SERVER['HTTP_REFERER'], 'nationalpcpro.com'))
            redirect('/jobs/page/1');
        redirect('/dashboard');
    }

    public function page($pageNum) {
        set_current_store(2);
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
                $dd['phone'] = $this->input->post('phone');
                $dd['password'] = $this->input->post('password');
                $dd['serial'] = $this->input->post('serial');
                $dd['notes'] = $this->input->post('notes');
                $dd['user_id'] = 1;
                $dd['store_id'] = get_current_store()->id;
                $dd['status_id'] = 2;
                $dd['created'] = time();
                $dd['modified'] = 0;
                
                $hc = $this->input->post('has_case');
                $hp = $this->input->post('has_power');
                
                $dd['has_case'] = ($hc == true) ? 1 : 0;
                $dd['has_power'] = ($hp == true) ? 1 : 0;

                $this->jobs->insert($dd);
                redirect('/jobs');
            }
        }

        $data['title'] = 'Add Job';
        $this->load->view('jobs_add', $data);
    }

    public function edit($id) {
		$fnames = array("Chuck", "Larry", "John", "Mike", "Jane", "Joe", "Samantha", "William");
		$lnames = array("Norris", "Byrd", "Smith", "Wazowski", "Doe", "Meyer", "Colla", "Wallace");
        if($this->input->method(true) == 'POST') {
            if($this->input->post('submit') == 'Save') {
                $dd['workorder'] = $this->input->post('workorder');
                $dd['customer'] = $this->input->post('customer');
                $dd['phone'] = $this->input->post('phone');
                $dd['password'] = $this->input->post('password');
                $dd['serial'] = $this->input->post('serial');
                $dd['notes'] = $this->input->post('notes');
                $dd['modified'] = time();
                $dd['status_id'] = $this->input->post('status');
                $dd['store_id'] = $this->input->post('store');
				//$dd['modified_by'] = (isset($_SESSION['user_initals'])) ? $_SESSION['user_initals'] : 'Chuck Norris';
				$name = $fnames[mt_rand(0, count($fnames) - 1)] . " ";
				$name .= $lnames[mt_rand(0, count($lnames) - 1)] . " ";
				$dd['modified_by'] = $name;
                
                $hc = false;
                $hp = false;
                
                if($this->input->post('has_case') != null)
                    $hc = $this->input->post('has_case');
                if($this->input->post('has_power') != null)
                    $hp = $this->input->post('has_power');
                
                $dd['has_case'] = ($hc == true) ? 1 : 0;
                $dd['has_power'] = ($hp == true) ? 1 : 0;

                $this->jobs->update($id, $dd);
                //redirect('/jobs/page/1');
            }
        }
		
		/*if(!isset($_SESSION['user_initals']))
			redirect('/jobs/initals/' . $id);*/
		
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
            //set_current_store($id);
            set_current_store(2);

            if(isset($_SESSION['GoBackTo'])) {
                $path = $_SESSION['GoBackTo'];
                $_SESSION['GoBackTo'] = null;
                redirect($path);
            }

            redirect('jobs/index');
        }
        $this->load->view('jobs_choosestore', $data);
    }
	
	public function initals($id) {
		if($id == null || !is_numeric($id))
			redirect('/jobs');
		if(isset($_POST['submit'])) {
			$initals = $_POST['name'];
			$_SESSION['user_initals'] = $initals;
			redirect('/jobs/edit/' . $id);
		}
		$data['title'] = 'Who\'s editing this?';
		$data['id'] = $id;
		$this->load->view('jobs_select_name', $data);
	}
	
	public function setstatus() {
		$job = $_POST['id'];
		$name = $_POST['name'];
		$status = get_status_by_name($name);
		
		if(is_numeric($job)) {
			$this->jobs->update($job, ['status_id' => $status->id]);
		}
	}
}
?>

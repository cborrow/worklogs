<?php
class Jobs extends AuthController {
	protected $jobs;

	public function __construct() {
		parent::__construct();

		$this->jobs = new JobsModel();
		View::addHelper('uri');
		View::addHelper('string');
	}

	public function index() {
		$this->redirect('/jobs/view', true);
	}

	public function dashboard() {
		$data = array();
		$data['jobs'] = $this->jobs->getAllJobs();
		$data['openJobs'] = $this->jobs->getOpenJobs();
		$data['openJobsCount'] = count($data['openJobs']);
		$data['recentlyModified'] = $this->jobs->getRecentlyModified(2);
		$data['recentlyAdded'] = $this->jobs->getRecentlyAdded(10);
		$data['recentlyAddedCount'] = count($data['recentlyAdded']);
		$data['recentlyModifiedCount'] = count($data['recentlyModified']);

		View::render('jobs.dashboard', $data);
	}

	public function add() {
		View::render('jobs.add');
	}

	public function add_process() {
		if(isset($_POST['submit'])) {
			$data = array();
			$data['workorder'] = intval($_POST['workorder']);
			$data['client'] = $_POST['client'];
			$data['notes'] = $_POST['notes'];

			$this->jobs->add($data);
		}

		$this->redirect('/jobs/view', true);
	}

	public function edit($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('jobs/view', true);

		$data = array();
		$data['job'] = $this->jobs->getJobById($id);

		View::render('jobs.edit', $data);
	}

	public function edit_process($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('jobs/view', true);

		if(isset($_POST['submit'])) {
			$data = array();
			$data['status'] = $_POST['status'];
			$data['workorder'] = intval($_POST['workorder']);
			$data['client'] = $_POST['client'];
			$data['notes'] = $_POST['notes'];

			$this->jobs->edit($id, $data);
		}

		$this->redirect('/jobs/view', true);
	}

	public function delete($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('jobs/view', true);

		$data = array();
		$data['job'] = $this->jobs->getJobById($id);

		View::render('jobs.delete', $data);
	}

	public function delete_process($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('jobs/view', true);

		if(isset($_POST['submit'])) {
			$this->jobs->delete($id);
		}

		$this->redirect('jobs/view', true);
	}

	public function complete($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('jobs/view', true);

		$this->jobs->markJobComplete($id);
		$this->redirect('/jobs/view', true);
	}

	public function view($id = null) {
		$data = array();
		
		if(is_null($id) || empty($id)) {
			$data['jobs'] = $this->jobs->getAllJobs();
			View::render('jobs.viewall', $data);
		}
		else {
			$data['job'] = $this->jobs->getJobById(intval($id));
			View::render('jobs.view', $data);
		}
	}

	public function printview($id = null) {
		if(is_null($id) || empty($id) || !is_numeric($id))
			$this->redirect('jobs/view', true);

		$data = array();
		$data['job'] = $this->jobs->getJobById($id);
		View::render('jobs.print', $data);
	}

	public function search() {
		if(isset($_POST['submit'])) {
			$q = $_POST['query'];

			$data = array();
			$data['jobs'] = $this->jobs->getJobsByQuery($q);
			View::render('jobs.viewall', $data);
		}
		else
			$this->redirect('/jobs/view', true);
	}
}
?>
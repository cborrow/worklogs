<?php
session_start();
class Dashboard extends CI_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->helper('status');
        $this->load->helper('store');
        $this->load->helper('asset');

        $this->load->model('Jobs_model', 'jobs');
    }

    public function index() {
        $data = array();
        $data['title'] = 'Dashboard';
        $data['pastDueJobs'] = $this->jobs->getOpenJobsOlderThan(5);
        $data['average'] = $this->jobs->avgJobCloseTime();

        $days = floor($data['average'] / 86400);

        $hs = $data['average'] % 86400;
        $hours = floor($hs / 1440);

        $ms = $hs % 1440;
        $minutes = floor($ms / 60);

        $rs = $ms % 60;
        $seconds = ceil($rs);

        $data['avg_days'] = $days;
        $data['avg_hours'] = $hours;
        $data['avg_minutes'] = $minutes;
        $data['avg_seconds'] = $seconds;

        $this->load->view('Dashboard_index', $data);
    }
}
?>

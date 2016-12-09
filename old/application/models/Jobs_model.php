<?php
class Jobs_model extends CI_Model {
    public function __construct() {
        parent::__construct();

        $this->load->library('SQLiteDatabase');
        $this->db = new SQLiteDatabase('Worklogs.db');
        //$this->db->EnableDebugging = true;
    }

    public function getAllJobs() {
        $store = $this->getStore();

        if($store == 0 || $store == null)
            $this->db->orderBy('id')->select('jobs');
        else
            $this->db->where('store_id', $store)->orderBy('id')->select('jobs');
        return $this->db->fetchAll();
    }

    public function getJobCount() {
        $store = $this->getStore();

        if($store == 0 || $store == null) {
            $this->db->query("SELECT COUNT(id) AS total FROM jobs");
        }
        else {
            $this->db->query("SELECT COUNT(id) AS total FROM jobs WHERE store_id='{$store}'");
        }
        $row = $this->db->fetch();

        if($row != null)
            return $row->total;
        return 0;
    }

    public function getJobsByPage($page, $resultsPerPage = 50) {
        if(($page * $resultsPerPage) > $this->getJobCount())
            return null;
        $store = $this->getStore();

        if($store == 0 || $store == null)
            $this->db->orderBy('status_id')->orderBy('id')->limit(($page * $resultsPerPage), $resultsPerPage)->select('jobs');
        else
            $this->db->where('store_id', $store)->orderBy('status_id')->orderBy('id')->limit(($page * $resultsPerPage), $resultsPerPage)->select('jobs');
        //return $this->db->fetchAll();
        $jobs = $this->db->fetchAll();
        $jobs = $this->sortByFields($jobs);
        return $jobs;
    }

    public function getJobById($id) {
        $this->db->where('id', $id)->limit(1)->select('jobs');
        return $this->db->fetch();
    }

    public function getJobsByCustomer($customer) {
        $this->db->where('customer', $customer)->select('jobs');
        return $this->db->fetchAll();
    }

    public function getJobsByDate($start, $end = 0) {
        if($end > 0)
            $this->db->where('created', $start, '>=')->where('created', $start, '<=')->select('jobs');
        else
            $this->db->where('created', $start)->select('jobs');

        return $this->db->fetchAll();
    }

    public function getOpenJobsOlderThan($days = 3) {
        if(!is_numeric($days))
            return;

        $openedBefore = time() - (86400 * $days);
        $this->db->where('created', $openedBefore, '<')->where('status_id', '1', '<>')->select('jobs');
        return $this->db->fetchAll();
    }

    public function avgJobCloseTime() {
        $this->db->query("SELECT AVG(jobs.modified - jobs.created) AS average FROM jobs WHERE status_id='1'");
        return $this->db->fetch()->average;
    }

    public function search($query) {
        $this->db->where('customer', "%{$query}%", 'LIKE')
            ->orWhere('notes', "%{$query}%", 'LIKE')
            ->select('jobs');
        return $this->db->fetchAll();
    }

    public function insert($data) {
        $this->db->insert('jobs', $data);
    }

    public function update($id, $data) {
        $this->db->where('id', $id)->update('jobs', $data);
    }

    public function delete($id) {
        $this->db->where('id', $id)->delete('jobs');
    }

    public function close($id) {
        $this->db->where('id', $id)->update('jobs', array('modified' => time(), 'status_id' => '1'));
    }

    protected function getStore() {
        if(isset($_SESSION['active_store_id']))
            $store = $_SESSION['active_store_id'];
        else
            $store = 0;
        return $store;
    }
    
    protected function sortByFields($jobs) {
        //$statusList = get_ordered_status_list();
        
        usort($jobs, function($x, $y) {
            $xsid = $x->status_id;
            $ysid = $y->status_id;

            $xso = get_status_priority($xsid);
            $yso = get_status_priority($ysid);

            if($xso > $yso)
                return 1;
            else if($xso < $yso)
                return -1;
            else if($xso == $yso) {
                if($x->created > $y->created)
                    return -1;
                else if($x->created < $y->created)
                    return 1;
                else
                    return 0;
            }
            return 0;
        });
        return $jobs;
    }
}
?>

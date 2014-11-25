<?php
class JobsModel extends Model {
	public function __construct() {
		parent::__construct();
	}

	public function add($data) {
		if(!is_array($data))
			throw new Exception("Argument must be an array. Non array given.");

		$data['status'] = "Open";
		$data['created'] = time();
		$data['modified'] = 0;
		$data['user_id'] = User::getCurrentUser()->id;

		$this->db->insert('jobs', $data);
	}

	public function edit($id, $data) {
		if(!is_array($data))
			throw new Exception("Argument must be an array. Non array given.");

		$data['modified'] = time();

		$this->db->where('id', $id)->update('jobs', $data);
	}

	public function delete($id) {
		$this->db->where('id', $id)->limit(1)->select('jobs');
		$row = $this->db->fetch();

		$base = Config::get('application.paths.base');
		$file = $base . "site\\backups\\workorder_{$row->workorder}.backup";

		$fp = fopen($file, 'x');
		flock($fp, LOCK_EX);

		fwrite($fp, $row->created . "\r\n");
		fwrite($fp, $row->modified . "\r\n");
		fwrite($fp, $row->workorder . "\r\n");
		fwrite($fp, $row->client . "\r\n");
		fwrite($fp, $row->notes . "\r\n");

		flock($fp, LOCK_UN);
		fclose($fp);

		$this->db->where('id', $id)->delete('jobs');
	}

	public function markJobComplete($id) {
		$data = array();
		$data['status'] = 'Closed';

		$this->db->where('id', $id)->update('jobs', $data);
	}

	public function getAllJobs() {
		$this->db->orderBy('id', 'desc')->select('jobs');
		$rows = $this->db->fetchAll();

		return $rows;
	}
	
	public function getAllJobsByOrder($field, $desending) {
		if($field == null)
			return;
		if($desending == null)
			$desending = true;
		
		if($desending)
			$this->db->orderBy($field, 'desc');
		else
			$this->db->orderBy($field, 'asc');
		
		$rows = $this->db->fetchAll();
		return $rows;
	}

	public function getOpenJobs() {
		$this->db->where('status', 'Open')->select('jobs');
		$rows = $this->db->fetchAll();

		return $rows;
	}

	public function getClosedjobs() {
		$this->db->where('status', 'Closed')->select('jobs');
		$rows = $this->db->fetchAll();

		return $rows;
	}

	public function getJobsByQuery($query) {
		$this->db->where('workorder', "%{$query}%", 'LIKE')->
		orWhere('client', "%{$query}%", 'LIKE')->
		orWhere('notes', "%{$query}%", 'LIKE')->select('jobs');
		$rows = $this->db->fetchAll();

		return $rows;
	}

	public function getJobById($id) {
		$this->db->where('id', $id)->limit(1)->select('jobs');
		$row = $this->db->fetch();

		return $row;
	}

	public function getRecentlyModified($days) {
		$t = time();
		$seconds = $days * 86400;
		$min = $t - $seconds;

		$this->db->where('modified', $min, '>=')->select('jobs');
		$rows = $this->db->fetchAll();

		return $rows;
	}

	public function getRecentlyAdded($days) {
		$seconds = $days * 86400;
		$this->db->where('created', $seconds, '>=')->select('jobs');
		$rows = $this->db->fetchAll();

		return $rows;
	}
}
?>
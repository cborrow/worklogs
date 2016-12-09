<?php
class SQLiteDatabase {
	public $LastQueryString;
	public $LastQueryResult;
	public $LastErrorString;
	public $LastErrorCode;
	public $NewDatabase;

	public $EnableDebugging;

	protected $databasePath;
	protected $conn;

	protected $databasePass;

	protected $where;
	protected $limit;
	protected $group;
	protected $order;

	protected $allowedOperators;

	public function __construct($path = null, $pass = null) {
		if($path != null) {
			if(!file_exists($path))
				$this->NewDatabase = true;

			if($pass != null)
				$this->conn = new SQLite3($path, $pass);
			else
				$this->conn = new SQLite3($path);

			$this->databasePath = $path;
			$this->databasePass = $pass;
		}

		$this->EnableDebugging = false;

		$this->where = array();
		$this->order = array();
		$this->limit = null;
		$this->group = null;
		$this->allowedOperators = array(
			'=', '<', '>', '<=', '>=', '<>', 'EQUAL', 'NOT EQUAL', 'BETWEEN', 'NOT BETWEEN', 'CONTAINS', 'NOT CONTAINS',
			'LIKE', 'NOT LIKE');
	}

	public function lastInsertId() {
		if($this->conn != null)
			return $this->conn->lastInsertRowID();
		return 0;
	}

	public function where($field, $value, $operator = '=') {
		$operator = strtoupper($operator);
		$value = $this->escapeString($value);

		if(!in_array($operator, $this->allowedOperators))
			throw new Exception('Invalid / Non-allowed where operator given');

		if(count($this->where) > 0)
			$this->where[] = "AND {$field} {$operator} '{$value}'";
		else
			$this->where[] = "{$field} {$operator} '{$value}'";
		return $this;
	}

	public function orWhere($field, $value, $operator = '=') {
		$operator = strtoupper($operator);
		$value = $this->escapeString($value);

		if(!in_array($operator, $this->allowedOperators))
			throw new Exception('Invalid / Non-allowed where operator given');

		if(count($this->where) > 0)
			$this->where[] = "OR {$field} {$operator} '{$value}'";
		else
			$this->where[] = "{$field} {$operator} '{$value}'";
		return $this;
	}

	public function limit($start, $length = 0) {
		if($start < 0)
			throw new Exception('Cannot limit to negative number');

		if($length >= 1)
			$this->limit = "LIMIT {$start}, {$length}";
		else
			$this->limit = "LIMIT {$start}";
		return $this;
	}

	public function groupBy($field) {
		$this->groupBy = "GROUP BY {$field}";
		return $this;
	}

	public function orderBy($field, $dir = 'DESC') {
		$dir = strtoupper($dir);

		if($dir != 'ASC' && $dir != 'DESC')
			throw new Exception('Invalid orderby direction given');

		$this->order[] = "{$field} {$dir}";
		return $this;
	}

	public function fetchArray() {
		if($this->LastQueryResult != null) {
			return $this->LastQueryResult->fetchArray();
		}
		return null;
	}

	public function fetchArrayAll() {
		if($this->LastQueryResult != null) {
			$rows = array();

			while($row = $this->LastQueryResult->fetchArray()) {
				$rows[] = $row;
			}
			return $rows;
		}
		return null;
	}

	public function fetch() {
		if($this->LastQueryResult != null) {
			return (object)$this->fetchArray();
		}
	}

	public function fetchAll() {
		if($this->LastQueryResult != null) {
			$rows = array();

			while($row = $this->LastQueryResult->fetchArray()) {
				$rows[] = (object)$row;
			}
			return $rows;
		}
		return [];
	}
	
	public function all($table) {
        if(is_null($table) || empty($table))
            return [];
        
        $this->select($table);
        return $this->fetchAll();
	}
	
	public function first($table) {
        if(is_null($table) || empty($table))
            return null;
         
        $this->limit(1)->select($table);
        return $this->fetch();
    }
    
    public function range($table, $offset, $length) {
        if(is_null($table) || empty($table))
            return null;
        if(is_null($offset) || !is_numeric($offset))
            $offset = 0;
        if(is_null($length) || !is_numeric($length))
            $length = 25;
        
        $this->limit($offset, $length)->select($table);
        return $this->fetchAll();
    }
    
    public function count($table) {
        if(is_null($table) || empty($table))
            return false;
            
        //$this->query("SELECT COUNT(id) AS total FROM {$table}");
        //$this->select($table, "COUNT(id) AS total");
        
        $sql = "SELECT COUNT(id) AS total FROM {$table}";
        
        if($this->where != null && count($this->where) > 0) {
            for($i = 0; $i < count($this->where); $i++) {
                $w = $this->where[$i];
                
                if($i == 0)
                    $sql .= " WHERE {$w}";
                else {
                    if(substr($w, 0, 2) == 'OR')
                        $sql .= " {$w}";
                    else
                        $sql .= " AND {$w}";
                }
            }
        }
        
        $this->query($sql);
        $row = $this->fetch();
        
        if($row != null && isset($row->total))
            return $row->total;
        return false;
    }

	public function select($tableName, $fields = null) {
		$sql = "";

		if($fields == null)
			$sql = "SELECT * FROM {$tableName}";
		else {
			$sql = "SELECT ";
            
            if(is_array($fields)) {
                for($i = 0; $i < count($fields); $i++) {
                    if($i > 0)
                        $sql .= ", ";
                    $sql .= "{$fields[$i]}";
                }
            }
            else if(is_string($fields) && strlen($fields) > 0) {
                $sql .= " {$fields}";
            }
			$sql .= " FROM {$tableName}";
		}

		if($this->where != null && count($this->where) > 0) {
			for($i = 0; $i < count($this->where); $i++) {
				if($i == 0)
					$sql .= " WHERE {$this->where[$i]}";
				else {
					/*if(substr($this->where[$i], 0, 2) == "OR")
						$sql .= " {$this->where[$i]}";
					else
						$sql .= " AND {$this->where[$i]}";*/
					$sql .= " {$this->where[$i]}";
				}
			}
		}

		if($this->group != null) {
			$sql .= " {$this->group}";
		}
		if(count($this->order) > 0) {
			$sql .= " ORDER BY";
			for($i = 0; $i < count($this->order); $i++) {
				if($i > 0)
					$sql .= ", ";
				$sql .= " {$this->order[$i]}";
			}
		}
		if($this->limit != null) {
			$sql .= " {$this->limit}";
		}

		$this->query($sql);
	}

	public function insert($tableName, $data) {
		$data = $this->escapeArray($data);
		$sql = "INSERT INTO {$tableName}";

		$keys = array_keys($data);

		$sql .= " (";
		for($i = 0; $i < count($keys); $i++) {
			if($i > 0)
				$sql .= ", ";
			$sql .= "{$keys[$i]}";
		}
		$sql .= ") VALUES (";

		for($i = 0; $i < count($keys); $i++) {
			$k = $keys[$i];
			if($i > 0)
				$sql .= ", ";
			$sql .= "'{$data[$k]}'";
		}
		$sql .= ")";

		$this->query($sql);
	}

	public function update($tableName, $data) {
		$data = $this->escapeArray($data);
		$sql = "UPDATE {$tableName} SET";
		$index = 0;

		foreach($data as $key => $value) {
			if($index == 0)
				$sql .= " {$key}='{$value}'";
			else
				$sql .= ", {$key}='{$value}'";
			$index++;
		}

		if($this->where != null && count($this->where) > 0) {
			for($i = 0; $i < count($this->where); $i++) {
				if($i == 0)
					$sql .= "WHERE {$this->where[$i]}";
				else {
					if(substr($this->where[$i], 0, 2) == "OR")
						$sql .= " {$this->where[$i]}";
					else
						$sql .= " AND {$this->where[$i]}";
				}
			}
		}

		$this->query($sql);
	}

	public function delete($tableName) {
		$sql = "DELETE FROM {$tableName}";

		if($this->where != null && count($this->where) > 0) {
			for($i = 0; $i < count($this->where); $i++) {
				if($i == 0)
					$sql .= " WHERE {$this->where[$i]}";
				else {
					if(substr($this->where[$i], 0, 2) == "OR")
						$sql .= " {$this->where[$i]}";
					else
						$sql .= " AND {$this->where[$i]}";
				}
			}
		}

		$this->query($sql);
	}

	public function query($sql) {
		if($this->conn != null) {
			if($this->EnableDebugging)
				var_dump($sql);

			$this->LastQueryString = $sql;
			$this->LastQueryResult = $this->conn->query($sql);

			if($this->EnableDebugging)
				var_dump($this->LastQueryResult);

			$this->LastErrorCode = $this->conn->lastErrorCode();
			if($this->LastErrorCode != 0) {
				$this->LastErrorString = $this->conn->lastErrorMsg();
			}

			$this->where = array();
			$this->order = array();
			$this->group = null;
			$this->limit = null;
		}
	}

	protected function escapeString($str) {
		if($this->conn == null)
			return;

		return $this->conn->escapeString($str);
	}

	protected function escapeArray($data) {
		if($this->conn == null || !is_array($data))
			return null;

		$temp = array();

		foreach($data as $key => $value) {
			$temp[$key] = $this->conn->escapeString($value);
		}

		return $temp;
	}
}
?>

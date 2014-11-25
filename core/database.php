<?php
/**
* Copyright (c) 2012 Cory Borrow
*
* This file add's a simple and effective way of accessing/querying a MySQL database
* 
*/
class Database
{
    /**
    * MySQL database host name
    * @access public
    * @var string
    */
    public $Host;

    /**
    * MySQL datbase username
    * @access public
    * @var string
    */
    public $User;

    /**
    * MySQL database password
    * @access public
    * @var string
    */
    public $Pass;

    /**
    * MySQL database name
    * @access public
    * @var string
    */
    public $Name;

    /**
    * Last preformed SQL query string
    * @access public
    * @var string
    */
    public $LastQuery;

    /**
    * Last MySQL error
    * $access public
    * @var string
    */
    public $LastError;

    /**
    * Enables DEBUG mode to output results and error messages.
    * @access public
    * @var boolean
    */
    public $EnableDebugging;

    /**
    * Enable logging of any errors that occur.
    * @access public
    * @var boolean
    */
    public $LogErrors;

    /**
    * Path to the error log file.
    * @access public
    * @var string
    */
    public $ErrorLogPath;

    /**
    * Where and or-where statements
    * @access protected
    * @var array
    */
    protected $where;

    /**
    * Order by statement
    * @access protected
    * @var string
    */
    protected $orderBy;

    /**
    * Group by statement
    * @access protected
    * @var string
    */
    protected $groupBy;

    /**
    * Limit statement
    * @access protected
    * @var string
    */
    protected $limit;

    /**
    * Database connection handle
    * @access protected
    * @var resource
    */
    protected $conn;

    /**
    * MySQL result handle
    * @access protected
    * @var resource
    */
    protected $result;

    /**
    * Array of operator keywords allowed in the where and orWhere methods
    * @access protected
    * @var array
    */
    protected $allowedOperators;

    protected static $instance;

    public static function getInstance() {
        if(!isset(self::$instance) || is_null(self::$instance)) {
            $host = Config::get("application.database.host");
            $user = Config::get("application.database.user");
            $pass = Config::get("application.database.pass");
            $name = Config::get("application.database.name");

            self::$instance = new Database($host, $user, $pass, $name);
        }
        self::$instance->connect();
        return self::$instance;
    }

    /**
    * Constructor, set's host, username, password, and db name
    */
    public function __construct($host, $user, $pass, $name)
    {
        if(!empty($host))
            $this->Host = $host;
        else
            $this->Host = "localhost";

        if(!empty($user) && !is_null($pass) && !empty($name))
        {
            $this->User = $user;
            $this->Pass = $pass;
            $this->Name = $name;
        }

        $this->allowedOperators = array(
            "<", ">", "=", "!=", "<=", ">=", "<>", "LESS THAN",
            "MORE THAN", "EQUAL", "NOT EQUAL", "CONTAINS",
            "NOT CONTAINS", "BEWTEEN", "NOT BEWTEEN", "STARTS WITH",
            "LIKE");

        $this->EnableDebugging = false;
        $this->LogErrors = true;
        $this->ErrorLogPath = realpath("./Database.log");

        if($this->ErrorLogPath == null)
            $this->ErrorLogPath = "Database.log";
        self::$instance = $this;
    }

    public function toggleDebugging() {
        $this->EnableDebugging = !$this->EnableDebugging;
    }

    /**
    * Connect's to mysql database
    * @access public
    */
    public function connect()
    {
        if(!$this->conn)
        {
            $this->conn = mysql_connect($this->Host, $this->User, $this->Pass);

            if($this->conn)
                mysql_select_db($this->Name, $this->conn);
        }
    }

    /**
    * Fetch's first row from MySQL result
    * @return resource|null MySQL Result or null on faliure
    * @access public
    */
    public function fetch()
    {
        if($this->conn && $this->result)
        {
            return mysql_fetch_object($this->result);
        }
        return null;
    }

    /**
    * Fetch's all MySQL row's from MySQL result
    * @return array|null MySQL rows or null on faliure
    * @access public
    */
    public function fetchAll()
    {
        if($this->conn && $this->result)
        {
            $rows = array();

            while($row = $this->fetch())
                $rows[] = $row;

            return $rows;
        }
        return null;
    }

    /**
    * Gets the number of rows affected by the last query
    * @return interger Number of rows affected
    * @access public
    */
    public function affectedRows()
    {
        if($this->conn)
        {
            return mysql_affected_rows($this->conn);
        }
    }

    /**
    * Gets the number of rows returned by the last query
    * @return integer Number of rows returned
    * @access public
    */
    public function returnedRows()
    {
        if($this->conn && $this->result)
        {
            return mysql_num_rows($this->result);
        }
    }

    /**
    * Add's a where statement to the sql query
    * @param string $key The field key to match against
    * @param mixed $value The value to match against the database field
    * @param interger $op A WhereOperator value of the type of match
    * @return Instance of Database class
    * @access public
    */
    public function where($key, $value, $op = "=")
    {
        if($this->conn && is_string($value))
        {
            $value = mysql_real_escape_string($value, $this->conn);
        }

        $op = strtoupper($op);
        if(in_array($op, $this->allowedOperators))
            $this->where[] = "{$key} {$op} '{$value}'";
        return $this;
    }

    /**
    * Add's an or-where statement to the sql query
    * @param string $key The field key to match against
    * @param mixed $value The value to match against the database field
    * @param integer $op A WhereOperator value of the type of match
    * @return Instance of Database class
    * @access public
    */
    public function orWhere($key, $value, $op = "=")
    {
        return $this->where("OR {$key}", $value, $op);
    }

    /**
    * Add's an order by statement to the sql query
    * @param string $key The mysql field key to order by
    * @param boolean $desc A boolean value to order the results in descending order
    * @return Instance of Database class
    * @access public
    */
    public function orderBy($key, $dir = "desc")
    {
        $dir = strtoupper($dir);
        $this->orderBy = "ORDER BY {$key}";
        $this->orderBy .= ($dir == "DESC") ? " DESC " : " ASC ";
        return $this;
    }

    /**
    * Add's a group by statement to the sql query
    * @param string $key The mysql field key to group by
    * @return Instance of Database class
    * @access public
    */
    public function groupBy($key)
    {
        $this->groupBy = "GROUP BY {$key} ";
        return $this;
    }

    /**
    * Add's a limit statement to the sql query
    * @param integer $start The number of rows to limit or the row to start from
    * @param integer $length The number of rows to return [optional]
    * @return Instance of Database class
    * @access public
    */
    public function limit($start, $length = 0)
    {
        $this->limit = "LIMIT {$start}";
        $this->limit .= ($length > 0) ? ", {$length} " : " ";
        return $this;
    }

    /**
    * Builds a SQL select statement and preforms query
    * @param string $table The table to preform a query against
    * @param array $keys The field keys to return [optional]
    * @access public
    */
    public function select($table, $keys = array())
    {
        if($this->conn)
        {
            if(is_array($keys) && count($keys) > 0)
                $keys = implode(", ", $keys);
            else
                $keys = "*";

            $sql = "";
            $sql .= "SELECT {$keys} FROM {$table} ";
            $sql = $this->appendWhere($sql);

            $sql .= $this->groupBy;
            $sql .= $this->orderBy;
            $sql .= $this->limit;

            $this->query($sql);
        }
    }

    /**
    * Builds a SQL update statement and preforms query
    * @param string $table The table to preform a query against
    * @param array $values The field key's and there $values to update
    * @access public
    */
    public function update($table, array $values)
    {
        if($this->conn)
        {
            $sql = "";
            $sql .= "UPDATE {$table} SET ";
            $counter = 0;
            $values = $this->cleanArray($values);

            foreach($values as $key => $value)
            {
                if($counter < count($values) - 1)
                    $sql .= "{$key} = '{$value}', ";
                else
                    $sql .= "{$key} = '{$value}' ";
                $counter++;
            }

            $sql = $this->appendWhere($sql);
            $this->query($sql);
        }
    }

    /**
    * Builds a SQL insert statement and preforms query
    * @param string $table The table to preform a query against
    * @param array $values An array of key's and value's to insert into the table.
    * @access public
    */
    public function insert($table, array $values)
    {
        if($this->conn)
        {
            $keys = array_keys($values);
            $keysStr = implode(", ", $keys);
            $valuesStr = implode("', '", $this->cleanArray($values));

            $sql = "";
            $sql .= "INSERT INTO {$table} ";
            $sql .= "({$keysStr}) VALUES ('{$valuesStr}')";
            $this->query($sql);
        }
    }

    /**
    * Builds a SQL delete statement and preforms query
    * @param string $table The table to preform a query against
    * @access public
    */
    public function delete($table)
    {
        if($this->conn)
        {
            $sql = "";
            $sql .= "DELETE FROM {$table} ";
            $sql = $this->appendWhere($sql);
            $this->query($sql);
        }
    }

    /**
    * Gets the last id inserted
    * @return interger
    * @access public
    */
    public function lastInsertId()
    {
        if($this->conn)
        {
            return mysql_insert_id($this->conn);
        }
    }

    /**
    * Preforms a SQL query
    * @param string $sql A sql string to query against a database with
    * @access public
    */
    public function query($sql)
    {
        if($this->conn)
        {
            $this->LastQuery = $sql;
            $this->result = mysql_query($sql, $this->conn);
            $this->LastError = mysql_error($this->conn);
            $this->where = array();
            $this->orderBy = "";
            $this->groupBy = "";
            $this->limit = "";

            if($this->EnableDebugging) {
                echo "<pre>";
                echo "Query String : {$sql}\r\n";
                echo "Errors : {$this->LastError}\r\n";
                echo "Results : ";
                var_dump($this->fetchAll());
                echo "</pre>";
            }

            if($this->LogErrors) {
                if(mysql_errno($this->conn) > 0) {
                    $errorCode = mysql_errno($this->conn);
                    $errorStr = mysql_error($this->conn);

                    $this->logError($errorCode, $errorStr);
                }
            }
        }
        else {
            if($this->LogErrors) {
                $this->logError(0, "No open database connection!");
            }
        }
    }

    /**
    * Builds and appends the where statements to a sql query
    * @param string $sql A sql query string
    * @return string The complete query string
    * @access private
    */
    private function appendWhere($sql)
    {
        for($i = 0; $i < count($this->where); $i++)
        {
            if($i == 0)
            {
                $sql .= "WHERE {$this->where[$i]} ";
            }
            else
            {
                if(substr($this->where[$i], 0, 2) == "OR")
                    $sql .= "{$this->where[$i]} ";
                else
                    $sql .= "AND {$this->where[$i]} ";
            }
        }
        return $sql;
    }

    /**
    * Preforms mysql_real_escape_string on all strings in an array
    * @param array $arr An array to clean
    * @return array The cleaned array.
    * @access private
    */
    private function cleanArray(array $arr)
    {
        if(!$this->isAssoc($arr)) {
            for($i = 0; $i < count($arr); $i++)
            {
    			if(is_string($arr[$i]))
    				$arr[$i] = mysql_real_escape_string($arr[$i]);
            }
        }
        else {
            $keys = array_keys($arr);

            for($i = 0; $i < count($keys); $i++) {
                if(is_string($arr[$keys[$i]]))
                    $arr[$keys[$i]] = mysql_real_escape_string($arr[$keys[$i]]);
            }
        }
        return $arr;
    }

    /**
    * Logs an error to the error log file definied in 'ErrorLogPath'
    * @param int Error number
    * @param string Error string
    * @access private
    */
    private function logError($errorCode, $errorStr)
    {
        $str = date("j M, Y h:i:s a", time()) . " [{$errorCode}] " . $errorStr . "\r\n";

        $f = fopen($this->ErrorLogPath, "a");
        flock($f, LOCK_EX);
        fwrite($f, $str);
        flock($f, LOCK_UN);
        fclose($f);
    }

    private function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
?>
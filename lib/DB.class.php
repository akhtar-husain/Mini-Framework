<?php

/*
 * @author 	: 	Akhtar Husain <akhtar4660@gmail.com>
 * @package : 	Admin Panel
 * @version : 	1.0
 */

class DB
{
	private $dbh;
	public $query;
	public $fieldList; 		// @Array in key=>pair format
	public $offset; 		// @integer
	public $limit; 			// @integer
	public $orderBy; 		// @Array as ['ID', 'ASC']
	public $where; 		// WHERE Query
	public $whereVal;
	public $arrValues = array();		// @Array to bind with @params
	
	/*public $innerJoin; 		// Array as ['table'=>{tabl_name}, 'ON'=>'id']	
	public $outerJoin;
	public $leftJoin;
	public $rightJoin;*/ 	// Will	use later.

	function __construct(){		
		$dsn = "mysql:host=".HOSTNAME.";dbname=".DBNAME;
		try
		{
			$this->dbh = new PDO($dsn, USERNAME, PASSWORD);
			if( ENVIRONMENT == 'development' ){
				$this->dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
			}
		}
		catch(PDO_Exception $e){
			echo $e->getMessage();
		}
	}
	
	/*
	 *
	 * =============  D A T A B A S E   R E L A T E D   F U N C T I O N S  ============
	 *
	 */

	public function getResult($table, $fields)
	{
		if( empty($table) )
			return;
		
		$field = is_array($fields) ? implode(', ', $fields) : "*";
		
		$sql = "SELECT ".$field." FROM `".$table."` ";
		$this->query = self::buildQuery($sql);

		$stmt = $this->dbh->prepare($this->query);
		$stmt->execute( $this->arrValues );		// ? '' : "ERROR ".$this->dbh->errorInfo();
		$data =  $stmt->fetchAll(PDO::FETCH_OBJ);
		//print_r($data);
		self::reset();
		return $data;
	}
	
	public function getRow($table, $fields)
	{
		if( empty($table) )
			return;
		
		$field = is_array($fields) ? implode(', ', $fields) : "*";
		
		$sql = "SELECT ".$field." FROM `".$table."` ";
		$this->query = self::buildQuery($sql);

		$stmt = $this->dbh->prepare($this->query);
		$stmt->execute( $this->arrValues );		// ? '' : "ERROR ".$this->dbh->errorInfo();
		$data =  $stmt->fetch(PDO::FETCH_OBJ);		

		self::reset();
		return $data;
	}

	/************************  E N D  ********************************/
	public function insert($table, $fieldVal)
	{
		/*
		 * $fieldVal is an associative array containing as 
		 * $key=>$val , Where key = column name of table 
		 */

		if( !is_array($fieldVal) || empty($table) )
			return;

		$arrValues = array();
		$fields = array();
		$sql = "INSERT INTO `".$table."` SET ";
		foreach( $fieldVal as $key=>$val){
			$fields[] = $key."=?";
			$arrValues[] = $val;
		}
		
		$sql .= implode(", ", $fields);
		$stmt = $this->dbh->prepare($sql);
		return $stmt->execute($arrValues) ? $this->dbh->lastInsertId() : FALSE;
	}

	public function update($table, $fieldVal)
	{
		/*
		 * $fieldVal is an associative array containing as 
		 * $key=>$val , Where key = column name of table 
		 */
		if( !is_array($fieldVal) || empty($table) )
			return;

		$fields = array();
		$sql = "UPDATE `".$table."` SET ";
		foreach( $fieldVal as $key=>$val){
			$fields[] = $key."=?";
			$this->arrValues[] = $val;
		}
		
		$sql .= implode(", ", $fields);
		$this->query = self::buildQuery($sql);

		$stmt = $this->dbh->prepare($this->query);
		$res = $stmt->execute($this->arrValues);
		
		self::reset();
		return $res;
	}
	
	public function delete( $table )
	{
		if( empty($table) )
			return;

		$sql = "DELETE FROM `".$table."`";
		$this->query = self::buildQuery($sql);

		$stmt = $this->dbh->prepare($this->query);
		$res = $stmt->execute($this->arrValues);

		self::reset();
		return $res;
	}
	
	public function getCount( $table, $field )
	{
		if( empty($table) )
			return;

		if( empty($field) )
			$field = "*";

		$sql = "SELECT COUNT(".$field.") FROM `".$table."` ";
		$this->query = self::buildQuery($sql);

		$stmt = $this->dbh->prepare($this->query);
		$stmt->execute($this->arrValues);
		$res = $stmt->fetch(PDO::FETCH_NUM);

		self::reset();
		return $res[0];
	}

	public function where( $whereQuery = array(), $beforeOpr = 'AND', $afterOpr = "AND" ){
		if( empty($this->where) ){
			$this->where = "WHERE "; 
		}
		else{
			$this->where .= " ".$beforeOpr." ";
		}
		$param = array();
		if( count($whereQuery) >= 1 ){
			foreach($whereQuery as $key => $val){
				$param[] = $key."=?";
				$this->whereVal[] = $val;
			}
		}

		$this->where .= implode(" ".$afterOpr." ", $param);
	}

	public function likeWhere( $whereQuery = array(), $beforeOpr = 'AND', $afterOpr = "AND" ){
		if( empty($this->where) ){
			$this->where = "WHERE "; 
		}
		else{
			$this->where .= " ".$beforeOpr." ";
		}
		$param = array();
		if( count($whereQuery) >= 1 ){
			foreach($whereQuery as $key => $val){
				$param[] = $key." LIKE '%?%'";
				$this->whereVal[] = $val;
			}
		}

		$this->where .= implode(" ".$afterOpr." ", $param);
	}
	public function inWhere( $whereQuery = array(), $beforeOpr = 'AND' ){
		if( empty($this->where) ){
			$this->where = "WHERE "; 
		}
		else{
			$this->where .= " ".$beforeOpr." ";
		}
		//$ar = [ 'id' => [1,2,3,4,5] ];
		$param = array();
		if( count($whereQuery) == 1 ){
			foreach($whereQuery as $key => $val){
				$param[] = $key." IN '%?%'";
				$this->whereVal[] = "(".implode(',', $val).")";
			}
		}

		$this->where .= implode(" ".$afterOpr." ", $param);
	}

	private function buildQuery( $sql )
	{
		if( empty($sql) )
			return FALSE;
		
		$query = $sql;
		if( $this->where ){
			$query .= " ".$this->where." ";
			$this->arrValues = array_merge($this->arrValues, $this->whereVal);
		}
		$query .= !empty($this->orderBy) ? implode(' ', $this->orderBy)." " : "";
		$query .= !empty($this->limit) ? " LIMIT ".$this->limit." " : "";
		$query .= !empty($this->offset) ? " OFFSET ".$this->offset." " : "";
		
		showQuery($query,$this->arrValues);		
		return $query;
	}

	private function reset()
	{
		unset($this->query);
		unset($this->fieldList);
		unset($this->arrValues);
		unset($this->limit);
		unset($this->orderBy);
		unset($this->where);
		unset($this->whereVal);
		unset($this->innerJoin);
		/*unset($this->outerJoin);
		unset($this->leftJoin);
		unset($this->rightJoin);*/
	}
}
<?php
class Database
{
	public $conn;
	private $Q;
	private $commit;
	private $affectedRows;
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| MAGIC FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
	function __construct()
	{
		global $database;
		$this->commit = $database['trans'];
		
		// CONNECT to database
		if(!$this->conn = self::connect())
		{
			return false;
		}
	}
	
	function __destruct()
	{
	
	}
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PUBLIC FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
	
	public function connect()
	{
		global $database;
		
		$this->conn	= mysqli_connect($database['host'],$database['user'],$database['password'],$database['db_name']);

		if (mysqli_connect_errno()) {
			//die('Failed to connect to MySQL: ' . mysqli_connect_error());
			return FALSE;
		}

		// Return name of current default database
		if(!mysqli_query($this->conn, "SELECT DATABASE()"))
		{
			//die('Database select failed.');
			return FALSE;
		}
		return $this->conn;
	}
	
	public function query($sql,$escape=TRUE)
	{
		$this->Q = @mysqli_query($this->conn, $sql);
		$this->affectedRows	= @mysqli_affected_rows($this->conn);
		$this->insertId		= @mysqli_insert_id($this->conn);
		
		return $this;
	}
	
	public function affected_row()
	{
		return $this->affectedRows;
	}
	
	public function insert_id()
	{
		return $this->insertId;
	}
	
	public function num_rows()
	{
		return @mysqli_num_rows($this->Q);
	}
	
	public function result()
	{
		$a_Rtn  = array();
		$a_Row  = @mysqli_fetch_array($this->Q);
		$ctr    = 0;
		
		foreach($a_Row as $a_Row_k_i => $a_Row_i)
		{
			if($ctr % 2 > 0)
			{
				$a_Rtn += array($a_Row_k_i=>$a_Row_i);
			}
			$ctr++;
		}
		
		return $a_Rtn;
	}
	
	public function list_field()
	{
		return @mysqli_list_fields($this->Q);
	}
	
	public function result_array()
	{
		$a_Rtn  = array();
		while($a_Row = @mysqli_fetch_array($this->Q))
		{
			$a_Temp = array();
			$ctr    = 0;
			foreach($a_Row as $a_Row_k_i => $a_Row_i)
			{
				if($ctr % 2 > 0)
				{
					$a_Temp += array($a_Row_k_i=>$a_Row_i);
				}
				$ctr++;
			}
			array_push($a_Rtn,$a_Temp);
		}
		unset($a_Temp);
		
		return $a_Rtn;
	}
	
	public function free_result()
	{
		unset($this->Q);
	}
	
	public function trans_on()
	{
		$this->commit = 'COMMIT';
	}
	
	public function trans_off()
	{
		$this->commit = 'ROLLBACK';
	}
	
	public function trans_start()
	{
		// CONNECT to database
		if(!$this->conn = self::connect())
		{
			return false;
		}
		// SEND query
		@mysqli_query("BEGIN",$this->conn);
	}
	
	public function trans_complete()
	{
		if(isset($this->conn))
		{
			@mysqli_query($this->commit,$this->conn);
		}
	}
	
	public function trans_commit()
	{
		if(isset($this->conn))
		{
			@mysqli_query('COMMIT',$this->conn);
		}
	}
	
	public function trans_rollback()
	{
		if(isset($this->conn))
		{
			@mysqli_query('ROLLBACK',$this->conn);
		}
	}
/* 
| ------------------------------------------------------------------------------------------------------------------------------------------
| PRIVATE FUNCTIONS
| ------------------------------------------------------------------------------------------------------------------------------------------
*/
	
}
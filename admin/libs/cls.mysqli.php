<?php
class CLS_MYSQL{
	private $pro=array(	
		'HOSTNAME'=>'localhost',
		'USERNAME'=>'root',
		'PASSWORD'=>'',
		'DATANAME'=>''
	);
	private $conn=NULL;
	private $rs;
	private $lastid;
	function __construct(){
		$this->HOSTNAME=HOSTNAME;
		$this->USERNAME=DB_USERNAME;
		$this->PASSWORD=DB_PASSWORD;
		$this->DATANAME=DB_DATANAME;
	}
	private function connect(){
		$conn=@mysqli_connect($this->HOSTNAME,$this->USERNAME,$this->PASSWORD,$this->DATANAME);
		mysqli_set_charset($conn,"utf8");
		if(!$conn){
			echo "Can't connect MySQL Server!";
			return false;
		}
		$this->conn=$conn;
		if(@!mysqli_select_db($this->conn, $this->DATANAME))
			return false;
		return true;
	}
	private function disconnect(){
		if(isset($this->conn))
			return @mysqli_close($this->conn);
	}
	
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo "$proname isn't member of MySQL Class ";
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			$this->callmess("$proname isn't member of MySQL Class" );
			return;
		}
		return $this->pro[$proname];
	}
	// function query
	public function Query($sql){
		if($this->connect()){
			@mysqli_query('SET names=utf8');
			@mysqli_query('SET character_set_client=utf8');
			@mysqli_query('SET character_set_connection=utf8');
			@mysqli_query('SET character_set_results=utf8');
			@mysqli_query('SET collation_connection=utf8_unicode_ci');
			$rs=mysqli_query($this->conn,$sql);
			$this->disconnect();
			if($rs){
				$this->rs=$rs;
				$rs=null;
				return true;
			}
		}
		return false;
	}
	public function Exec($sql){
		if($this->connect()){
			@mysqli_query('SET names=utf8');
			@mysqli_query('SET character_set_client=utf8');
			@mysqli_query('SET character_set_connection=utf8');
			@mysqli_query('SET character_set_results=utf8');
			@mysqli_query('SET collation_connection=utf8_unicode_ci');
			$result=mysqli_query($this->conn,$sql);
			@$this->lastid=$this->conn->insert_id;
			$this->disconnect();
			return $result;
		}
		return false;
	}
	public function Fetch_Assoc(){
		return (@mysqli_fetch_assoc($this->rs));
	}
	public function Num_rows() { 
		return(@mysqli_num_rows($this->rs));
	}
	public function LastInsertID(){
		return $this->lastid;
	}
	public function Seek($num) { 
		@mysqli_data_seek($this->rs,$num);
	}
}
?>
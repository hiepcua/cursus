<?php
class CLS_TAG{
	private $pro=array( 'ID'=>'-1',
						'Name'=>'',
						'Code'=>'',
						'MTitle'=>'',
						'MDesc'=>''
						);
	private $objmysql=NULL;
	function __construct(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ('Can not found $proname member');
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ("Can not found $proname member");
			return;
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_tags` where 1=1 ".$where.' ORDER BY `name` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
		/*end change -------------------------------------------------------------------------*/
	
	function Add_new(){
		$sql="INSERT INTO `tbl_tags`(`name`,`code`,`meta_title`,`meta_desc`) VALUES ";
		$sql.=" ('".$this->Name."','".$this->Code."','".$this->MTitle."','".$this->MDesc."') ";
		//die($sql);
		return $this->objmysql->Exec($sql);	
	}
	function Update(){
		$sql = "UPDATE tbl_tags SET name='".$this->Name."',`code`='".$this->Code."',`meta_title`='".$this->MTitle."',`meta_desc`='".$this->MDesc."' WHERE id='".$this->ID."'";
		return $this->objmysql->Exec($sql);
	}
	function getTagByConId($id) {
		$sql = "SELECT * FROM tbl_tags WHERE pids like '$id,%' OR pids LIKE '%,$id,%'"; 
		return $this->objmysql->Query($sql);
	}
	function Delete($id){
		$sql="DELETE FROM `tbl_tags` WHERE `id` in ('$id')";
		return $this->objmysql->Exec($sql);
	}
}
?>
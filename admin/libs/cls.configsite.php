<?php
class CLS_CONFIG{
	private $pro=array(
		'ID'=>'-1',			
		'Title'=>'',
		'CompanyName'=>'',	
		'Intro'=>'',
		'Address'=>'',		
		'Phone'=>'',
		'Tel'=>'',			
		'Fax'=>'',			
		'Email'=>'',
		'Meta_keyword'=>'',	
		'Meta_descript'=>'',
		'Langid'=>'',			
		'Website'=>'',
		'Banner'=>'',			
		'Logo'=>'',
		'Contact'=>'',		
		'Footer'=>'',
		'Temid'=>'',			
		'Nickyahoo'=>'',
		'Facebook'=>'',    
		'Twitter'=>'',
		'Gplus'=>'',    
		'Youtube'=>'',
		'Nameyahoo'=>'');
	private $objmysql=null;
	function __construct(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_USERS Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_USERS Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList(){
		$sql="SELECT * FROM `tbl_configsite` WHERE `config_id`=1";
		return $this->objmysql->Query($sql); 
	}
	public function Num_rows() { 
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
}
?>
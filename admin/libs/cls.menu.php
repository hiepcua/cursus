<?php
class CLS_MENU{
	private $pro=array(
		'ID'=>'-1',
		'Code'=>'',
		'Name'=>'',
		'Desc'=>'',
		'LangID'=>'0',
		'isActive'=>1
		);
	private $objmysql=NULL;
	function __construct(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_MENU class ' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_MENU Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	function getList($where='',$limit=''){
		$sql='SELECT * FROM `tbl_menus` '.$where.' ORDER BY `name` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getListmenu($type){
		$this->getList(' WHERE isactive=1','');
		$str='';
		while($rows=$this->Fetch_Assoc()){
			if($type=='list')
				$str.="<li><a href=\"".ROOTHOST_ADMIN."mnuitem/".$rows["id"]."\"><i class=\"fa fa-bars\" aria-hidden=\"true\"></i>".$rows["name"]."</a></li>";
			else if($type=="option")
				$str.="<option value=\"".$rows["id"]."\">".$rows["name"]."</option>";
			else 
				$str.=$rows['name'];
		}
		return $str;
	}}
?>
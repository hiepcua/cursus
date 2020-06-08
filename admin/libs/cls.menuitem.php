<?php
//ini_set('display_error',1);
class CLS_MENUITEM{
	private $pro=array(
		'ID'=>'-1',
		'Par_ID'=>'0',
		'Code'=>'',
		'Name'=>'',
		'Intro'=>'',
		'Mnu_ID'=>'0',
		'Viewtype'=>'block',
		'Cate_ID'=>'0',
		'Con_ID'=>'0',
		'Link'=>'',
		'Icon'=>'',
		'Class'=>'',
		'Order'=>'',
		'LangID'=>'0',
		'isActive'=>1
		);
	private $rowcount=0;
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
		$sql="SELECT * FROM `tbl_mnuitems` ".$where.' ORDER BY `order` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}
	public function getListMenuItem($mnuid,$par_id,$level){
		$sql="SELECT * FROM `tbl_mnuitems` WHERE `par_id`='$par_id' AND `menu_id`='$mnuid' AND`isactive`='1' ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		if($objdata->Num_rows()<=0)
			return;
		$strspace="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$strspace.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$strspace.="|---";
		}
		$str="";
		while($rows=$objdata->Fetch_Assoc()){
			$str.="<option onclick=\"getIDs();\" value=\"".$rows["id"]."\" >".$strspace.$rows["name"]."</option>";
			$nextlevel=$level+1;
			$str.=$this->getListMenuItem($mnuid,$rows["id"],$nextlevel);
		}
		return $str;
	}
	public function getLevelChild($parid,$level=1){
		$sql=" SELECT * FROM tbl_mnuitems WHERE id= $parid AND isactive=1 ";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql); 
		if($objdata->Num_rows()>0){
			$number = $level++;
			$rows = $objdata->Fetch_Assoc();
			$this->getLevelChild($rows['par_id'],$number);
		}
		return $level;
	}
	public function listTableItemMenu($strwhere="", $par_id, $level, $rowcount){
		$sql="SELECT * FROM `tbl_mnuitems` WHERE `par_id`='$par_id' ".$strwhere." ORDER BY `order` ASC, id ASC";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$str_space="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$str_space.="&nbsp;&nbsp;&nbsp;";
			$str_space.="|---";
		}
		while($rows=$objdata->Fetch_Assoc()){
			if($level == 0) $rowcount++; 
            else $rowcount = '';
            
			$mnuids=$rows['id'];
			$par_id=$rows['par_id'];
			$code=$rows['code'];
			$order=$rows['order'];
			$name=Substring($rows['name'],0,10);
			$type=$rows['viewtype'];
			if($rows['isactive']==1) 
				$icon_active="<i class='fa fa-check cgreen' aria-hidden='true'></i>";
			else $icon_active='<i class="fa fa-times-circle-o cred" aria-hidden="true"></i>';

			echo "<tr name='trow'>";
			echo "<td width='30' align='center'>".$rowcount."<label>";
			echo "<td width='30' align='center'><label>";
			echo "<input type='checkbox' name='chk' onclick=\"docheckonce('chk');\" value='$mnuids' />";
			echo "</label></td>";

			echo "<td width='50' align='center'>";
			echo "<a href='".ROOTHOST_ADMIN.COMS."/".$rows['menu_id']."/delete/$mnuids' onclick=\"return confirm('Do you want to delete this record?');\">";
			echo "<i class='fa fa-times-circle cred' aria-hidden='true'></i>";
			echo "</a>";
			echo "</td>";

			echo "<td>$str_space $name</td>";
			echo "<td align='left'>$str_space $code</td>";
			echo "<td width='100' align='center'>$type &nbsp;</td>";
			echo "<td width='50' align='center'><input type='text' name='txt_order' value='$order' size='4' class='order'></td>";

			echo "<td>";
			echo "<a href='".ROOTHOST_ADMIN.COMS."/".$rows['menu_id']."/active/$mnuids'>";
			echo $icon_active;
			echo "</a>";
			echo "</td>";

			echo "<td>";
			echo "<a href='".ROOTHOST_ADMIN.COMS."/".$rows['menu_id']."/edit/$mnuids'>";
			echo "<i class='fa fa-edit' aria-hidden='true'></i>";
			echo "</a>";			
			echo "</td>";
			
			echo "</tr>";
			$nextlevel=$level+1;
			$this->listTableItemMenu($strwhere, $mnuids, $nextlevel, $rowcount);
		}
	}
	public function getChildID($parid) {
		$sql = "SELECT id FROM tbl_mnuitems WHERE par_id IN ('$parid')"; 
		$this->objmysql->Query($sql);
		$ids='';
		if($this->objmysql->Num_rows()>0) {
			while($r = $this->objmysql->Fetch_Assoc()) {
				$ids.=$r[0]."','";
				$ids.=$this->getChildID($r[0]);
			}
		}
		return $ids;
	}
	public function Add_new(){
		$sql="INSERT INTO `tbl_mnuitems`(`par_id`,`name`,`code`,`menu_id`,`viewtype`,`category_id`,`content_id`,`link`,`icon`,`class`,`isactive`) VALUES ";
		$sql.=" ('".$this->Par_ID."','".$this->Name."','".$this->Code."','".$this->Mnu_ID."','".$this->Viewtype."','";
		$sql.=$this->Cate_ID."','".$this->Con_ID."','".$this->Link."','";
		$sql.=$this->Icon."','".$this->Class."','".$this->isActive."') ";
		return $this->objmysql->Exec($sql);
	}
	function Update(){
		$sql="UPDATE `tbl_mnuitems` SET  `par_id`='".$this->Par_ID."',
		`code`='".$this->Code."',
		`intro`='".$this->Intro."',
		`name`='".$this->Name."',
		`menu_id`='".$this->Mnu_ID."',
		`viewtype`='".$this->Viewtype."',
		`category_id`='".$this->Cate_ID."',
		`content_id`='".$this->Con_ID."',
		`link`='".$this->Link."',
		`icon`='".$this->Icon."',
		`class`='".$this->Class."',
		`isactive`='".$this->isActive."'";
		$sql.=" WHERE `id`='".$this->ID."'";
		//echo $sql;
		return $this->objmysql->Exec($sql);
	}
}
?>
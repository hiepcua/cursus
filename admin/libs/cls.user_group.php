<?php
class CLS_USER_GROUP{
	private $pro=array(
		'ID'=>'-1',
		'Name'=>'',
		'Intro'=>'',
		'isActive'=>1
		);
	private $objmysql=NULL;
	function __construct(){
		$this->objmysql=new CLS_MYSQL;
	}
	// property set value
	public function __set($proname,$value){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_USER_GROUP Class' );
			return;
		}
		$this->pro[$proname]=$value;
	}
	public function __get($proname){
		if(!isset($this->pro[$proname])){
			echo ($proname.' is not member of CLS_USER_GROUP Class' );
			return '';
		}
		return $this->pro[$proname];
	}
	public function getList($where='',$limit=''){
		$sql='SELECT * FROM `tbl_user_group` '.$where.' ORDER BY `name` '.$limit;
		return $this->objmysql->Query($sql);
	}
	public function Num_rows(){
		return $this->objmysql->Num_rows();
	}
	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}

	public function getOption($parid=0,$level=0){
        $sql="SELECT * FROM tbl_user_group WHERE `par_id`='$parid' AND `isactive`='1' ";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $char="";
        if($level!=0){
            for($i=0;$i<$level;$i++)
                $char.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
            $char.="|---";
        }
        if($objdata->Num_rows()<=0) return;
        while($rows=$objdata->Fetch_Assoc()){
            $id=$rows['id'];
            $parid=$rows['par_id'];
            $title=$rows['name'];
            echo "<option value='$id'>$char $title</option>";
            $nextlevel=$level+1;
            $this->getOption($id,$nextlevel);
        }
    }

    // Paging
	public function listTable2($strwhere="",$page){
		$star=($page-1)*MAX_ROWS;
		$leng=MAX_ROWS;
		$sql="SELECT * FROM `tbl_user_group` WHERE 1=1 ".$strwhere ." LIMIT $star,$leng";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['id'];
			$name=$rows['name'];
			$intro= stripslashes($rows['intro']);
			echo "<tr name=\"trow\">";
			echo "<td width=\"30\" align=\"center\"><label>";
			echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" onclick=\"docheckonce('chk');\" value=\"$id\" />";
			echo "</label></td>";
			echo "<td nowrap=\"nowrap\"><a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$id\">$name</a></td>";
			echo "<td nowrap=\"nowrap\">$intro &nbsp;</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$id\">";
			showIconFun('publish',$rows["isactive"]);
			echo "</a>";

			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";			
			echo "<a href=\"index.php?com=".COMS."&amp;task=edit&amp;id=$id\">";
			showIconFun('edit','');
			echo "</a>";
			echo "</td>";
			echo "<td width=\"50\" align=\"center\">";
			echo "<a href=\"javascript:detele_field('index.php?com=".COMS."&amp;task=delete&amp;id=$id')\">";
			showIconFun('delete','');
			echo "</a>";			
			echo "</td>";
			echo "</tr>";
		}
	}

	// No paging
	public function listTable($strwhere="", $parid=0, $level=0, $rowcount){
        $sql="SELECT * FROM tbl_user_group WHERE 1=1 $strwhere AND par_id=$parid ORDER BY `name` ASC";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $str_space="";
        if($level!=0){  
			$str_space.="|";
            for($i=0;$i<$level;$i++)
                $str_space.="--- "; 
        }
        while($rows=$objdata->Fetch_Assoc()){
            $rowcount++;
            $ids=$rows['id'];
            $title=Substring(stripslashes($rows['name']),0,10);
            $intro=Substring(stripslashes($rows['intro']),0,20);
			if($rows['isactive']==1) 
                $icon_active="<i class='fa fa-check cgreen' aria-hidden='true'></i>";
            else $icon_active='<i class="fa fa-times-circle-o cred" aria-hidden="true"></i>';
			
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$rowcount</td>";
            echo "<td width=\"30\" align=\"center\"><label>";
            echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\"   onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            echo "</label></td>";
			echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-trash cgray red' aria-hidden='true'></i></a></td>";
            echo "<td title=''>$str_space$title</td>";
            echo "<td title=''>$intro</td>";
            echo "<td align=\"center\">";
            echo "<a href=\"".ROOTHOST_ADMIN.COMS."/active/$ids\">";
            echo $icon_active;
            echo "</a></td>";
            echo "<td align=\"center\">";
            echo "<a href=\"".ROOTHOST_ADMIN.COMS."/edit/$ids\">";
            echo "<i class='fa fa-edit' aria-hidden='true'></i>";
            echo "</a></td>";
            echo "</tr>";
            $nextlevel=$level+1;
            $this->listTable($strwhere,$ids,$nextlevel,$rowcount);
        }
    }

	public function getNameById($id){
		$objdata=new CLS_MYSQL;
		$sql="SELECT `name` FROM `tbl_user_group`  WHERE isactive=1 AND `id` = '$id'"; 
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['name'];
	}
}
?>
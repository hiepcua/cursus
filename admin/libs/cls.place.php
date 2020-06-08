<?php
class CLS_PLACE{
    private $pro=array( 'ID'=>'-1',
        'Par_Id'=>"",
        'Name'=>'',
        'Thumb'=>'',
        'Intro'=>'',
        'Code'=>'',
        'Type'=>'',
        'Order'=>'',
        'isActive'=>1);
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

    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }

    public function getListCate($parid=0, $level=0){
        $sql="SELECT * FROM tbl_place WHERE `par_id`='$parid' AND `isactive`='1' ";
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
            $this->getListCate($id,$nextlevel);
        }
    }

    public function listTable($strwhere="",$parid=0,$level=0,$rowcount, $search=0){
        if($search == 0){
            $sql="SELECT * FROM tbl_place WHERE 1=1 $strwhere AND `par_id` = $parid ORDER BY `order` ASC";    
        }else{
            $sql="SELECT * FROM tbl_place WHERE 1=1 $strwhere ORDER BY `order` ASC";
        }
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $str_space="";
        $clsChild="";
        if($level!=0){  
			$clsChild = 'child-'.$level;
            for($i=0;$i<$level;$i++){
                $str_space.="&nbsp;&nbsp;&nbsp;";
                $str_space.="|----";
            }
        }
        while($rows=$objdata->Fetch_Assoc()){
            $rowcount++;
            $ids=$rows['id'];
            $title=Substring(stripslashes($rows['name']),0,10);
			if($rows['isactive']==1) 
                $icon_active="<i class='fa fa-check cgreen' aria-hidden='true'></i>";
            else $icon_active='<i class="fa fa-times-circle-o cred" aria-hidden="true"></i>';
			
            echo "<tr name='trow' class='".$clsChild."'>";
            echo "<td width=\"30\" align=\"center\">$rowcount</td>";
            echo "<td width=\"30\" align=\"center\"><label>";
            echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\"   onclick=\"docheckonce('chk');\" value=\"$ids\" />";
            echo "</label></td>";
			echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-trash cgray red' aria-hidden='true'></i></a></td>";
            echo "<td title=''>$str_space$title</td>";
            $order=$rows['order'];
            echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" id=\"txt_order\" value=\"$order\" size=\"4\" class=\"order\"></td>";
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
}
?>
<?php
class CLS_PROFILE{
    private $pro=array( 'ID'=>'-1',
        'Fullname'=>"",
        'CMTND'=>'',
        'Birthday'=>'',
        'Gender'=>'',
        'HouseHold'=>'','Address'=>'',
        'Email'=>'','Tel'=>'',
        'Year'=>'','Branch'=>'',
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
    public function getList($where=''){
        $sql="SELECT * FROM `tbl_profile` WHERE 1=1 ".$where;
        return $this->objmysql->Query($sql);
    }
    public function getInfo($where=''){
        $sql="SELECT * FROM `tbl_profile` WHERE 1=1 ".$where;
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
        $row = $objdata->Fetch_Assoc();
        return $row;
    }
    public function Num_rows(){
        return $this->objmysql->Num_rows();
    }
    public function Fetch_Assoc(){
        return $this->objmysql->Fetch_Assoc();
    }
    public function listTable($strwhere="",$cur_page=1){
		$start = 0;
		if($cur_page>1) $start=($cur_page-1)*MAX_ROWS_ADMIN;
        $leng=MAX_ROWS_ADMIN;
        $sql="SELECT * FROM tbl_profile WHERE 1=1 $strwhere LIMIT $start,$leng";
        $objdata=new CLS_MYSQL();
        $objdata->Query($sql);
		$i=0;
        while($rows=$objdata->Fetch_Assoc()){
            $i++;
            $id=$rows['id'];
			$fullname = stripslashes($rows['fullname']);
			$address = stripslashes($rows['address']);
			$email = stripslashes($rows['email']);
			$tel = stripslashes($rows['tel']);
			$nganh = stripslashes($rows['branch']);
			$cmt = stripslashes($rows['cmtnd']);
			$birthday = stripslashes($rows['birthday']);
			$gender = stripslashes($rows['gender']);
			$date = date("d/m/Y H:i A",strtotime($rows['cdate']));
			$take = $rows['take_care']==0?"<i class='fa fa-refresh fa-lg text-danger'></i>":"<i class='fa fa-lg fa-check text-success'></i>";
			$pass = $rows['pass']==0?"<i class='fa fa-refresh fa-lg text-danger'></i>":"<i class='fa fa-lg fa-check text-success'></i>";
            echo "<tr name=\"trow\">";
            echo "<td width=\"30\" align=\"center\">$i</td>";
            echo "<td><h4 style='margin:0 0 5px; padding:0'>$fullname</h4><div><small>Date: $date</small></div></td>";
            echo "<td>$address</td>";
            echo "<td>$email</td>";
            echo "<td>$tel</td>";
            echo "<td>$nganh</td>";
            echo "<td>$cmt</td>";
            echo "<td>$birthday</td>";
            echo "<td>$gender</td>";
            echo "<td align='center'><a href='".ROOTHOST_ADMIN.COMS."/take/$id'>$take</a></td>";
            echo "<td align='center'><a href='".ROOTHOST_ADMIN.COMS."/pass/$id'>$pass</a></td>";
            echo "<td align=\"center\">";
            echo "<a href=\"".ROOTHOST_ADMIN.COMS."/edit/$id\">";
            echo "<i class='fa fa-edit' aria-hidden='true'></i>";
            echo "</a></td>";
            echo "</tr>";
        }
    }
    public function Add_new(){
        $sql=" INSERT INTO `tbl_profile`(`fullname`,`cmtnd`,`birthday`,`gender`,
		`household`,`email`,`tel`,`year`,`address`,`branch`) VALUES";
        $sql.="('".$this->Fullname."','".$this->CMTND."','".$this->Birthday."',
		'".$this->Gender."','".$this->HouseHold."','".$this->Email."',
		'".$this->Tel."','".$this->Year."','".$this->Address."','".$this->Branch."')";
        //echo $sql;die;
		return $this->objmysql->Exec($sql);
    }
    public function Update(){
        $sql = "UPDATE tbl_profile SET 
        `fullname`='".$this->Fullname."',
        `cmtnd`='".$this->CMTND."',
        `birthday`='".$this->Birthday."',
        `gender`='".$this->Gender."',
        `household`='".$this->HouseHold."',
        `email`='".$this->Email."',
        `tel`='".$this->Tel."',
        `year`='".$this->Year."',
        `address`='".$this->Address."',
        `branch`='".$this->Branch."'
        WHERE id='".$this->ID."'";
		//echo $sql;die;
        return $this->objmysql->Exec($sql);
    }
    public function Delete($id){
        $sql="DELETE FROM `tbl_profile` WHERE `id` in ('$id')";
        return $this->objmysql->Exec($sql);
    }
    public function setActive($id,$status=''){
        $sql="UPDATE `tbl_profile` SET `isactive`='$status' WHERE `id` in ('$id')";
        if($status=='')
            $sql="UPDATE `tbl_profile` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$id')";
        return $this->objmysql->Exec($sql);
    }
	public function setTakeCare($id,$status=''){
        $sql="UPDATE `tbl_profile` SET `take_care`='$status' WHERE `id` in ('$id')";
        if($status=='')
            $sql="UPDATE `tbl_profile` SET `take_care`=if(`take_care`=1,0,1) WHERE `id` in ('$id')";
        return $this->objmysql->Exec($sql);
    }
	public function setPass($id,$status=''){
        $sql="UPDATE `tbl_profile` SET `pass`='$status' WHERE `id` in ('$id')";
        if($status=='')
            $sql="UPDATE `tbl_profile` SET `pass`=if(`pass`=1,0,1) WHERE `id` in ('$id')";
        return $this->objmysql->Exec($sql);
    }
}
?>
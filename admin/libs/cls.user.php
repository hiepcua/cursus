<?php
class CLS_USER{
	private $objmysql=NULL;
	
	function __construct(){
		$this->objmysql = new CLS_MYSQL;
	}
	
	public function LOGIN($user, $pass){
		$flag=true;
		$user=str_replace("'",'',$user);
		$pass=md5(sha1(trim($pass)));
		if($user=='' || $pass=='')
			$flag=false;
		$sql="SELECT * FROM `tbl_user` WHERE `username`='$user' AND isactive=1";
		$this->objmysql->Query($sql);
		if($this->objmysql->Num_rows()>0){
			$rows=$this->objmysql->Fetch_Assoc();
			if($rows['password']!=$pass){
				$flag=false;
			}
		}
		else{
			$flag=false;
		}
		if($flag==true){
			$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']=$rows;
			$this->UpdateLogin($user,1);
		}
		return $flag;
	}

	public function isLogin(){
		$user=$this->getInfo('username');
		if(isset($_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']) && $user!='N/A'){
			$this->AutoLogout($user);
		}
		if(isset($_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']) && $user!='N/A'){
			$this->UpdateLogin($user,1);
			return true;
		}
		return false;
	}

	public function LOGOUT(){
		$user=$this->getInfo('username');
		$this->UpdateLogin($user,0);
		unset($_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']);
	}

	public function UpdateLogin($user,$flag){
		$value='';
		if($flag==1)
			$value=date('Y-m-d h:i:s');
		$sql="UPDATE `tbl_user` SET `lastLogin`='$value' WHERE `username`='$user'";
		return $this->objmysql->Query($sql);
	}

	public function AutoLogout($user){
		/* if(!isset($user)||$user=='')
			return;
		$sql="SELECT `lastlogin` FROM `tbl_user` WHERE `username`='$user' ";
		$this->objmysql->Query($sql);
		$rows=$this->objmysql->Fetch_Assoc();
		if($rows['lastlogin']=='')
			return;
		$s=date('i')-date('i',strtotime($rows['lastlogin']));
		if($s>=60 || $s<(-1*60)){
			$this->LOGOUT();
			echo "<p align='center'>Hệ thống tự động đăng xuất sau 60 phút. Bạn vui lòng đăng nhập lại.</p>";
		}
		return; */
	}

	public function isAccess($com,$task='') {
		$gid=$this->getInfo('gid');
		$per=$this->getInfo('permiss');
		if($task!=''){
			$per=json_decode($per);
			if(isset($per[$com]) && $per[$com]['$task']==true) return true;
		}else{
			if(isset($per[$com])) return true;
		}
	}

	public function getList($where='',$limit=''){
		$sql="SELECT * FROM `tbl_user` WHERE 1=1 ".$where.$limit;
		$this->objmysql->Query($sql);
	}

	public function getListGroup($where=''){
		$sql="SELECT * FROM `tbl_user_group` WHERE 1=1 ".$where;
		$this->objmysql->Query($sql);
	}

	public function Num_rows() { 
		return $this->objmysql->Num_rows();
	}

	public function Fetch_Assoc(){
		return $this->objmysql->Fetch_Assoc();
	}

	public function checkUserExists($user){
		$sql = "SELECT `username` FROM `tbl_user` WHERE `username` ='$user'";
		$this->objmysql->Query($sql);
		if($this->objmysql->Num_rows()>0) return true;
		return false;
	}

	public function ChangePass_User($user,$newpass) {
		$sql="UPDATE `tbl_user` SET `password`='".md5(sha1(trim($newpass)))."'";
		$sql.=" WHERE username='$user'"; 
		return $this->objmysql->Exec($sql);
	}

	public function getInfo($name){
		if(isset($_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN'][$name])) return $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN'][$name];
		else return 'N/A';
	}

	public function getGroupUser($par_id,$level=0){
		$sql="SELECT * FROM `tbl_user_group` WHERE par_id=$par_id AND `isactive`=1";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
        if($level!=0){
            for($i=0;$i<$level;$i++)
                $char.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"; 
            $char.="|---";
        }
        if($objdata->Num_rows()<=0) return;
		if($objdata->Num_rows()){
			echo "<ul class='menu'>";
			while($r=$objdata->Fetch_Assoc()){
				$id=$r["id"];
				$name=$r["name"];
				if($r["isroot"]==0)
					echo "<li><a href='javascript:void(0);' onclick='user_group_select(this);' dataid='$id'>$char $name</a>";
				else
					echo "<li class='disable' disabled><a href='javascript:void(0);'>$char $name</a>";
				$next_level=$level+1;
				$this->getGroupUser($id,$next_level);
				echo "</li>";
			}
			echo "</ul>";
		}
	}

	public function getUserInGroup($gid){
		$sql="SELECT * FROM `tbl_user` WHERE `isactive`=1 AND `gid`=$gid";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()){
			echo "<ul class='menu'>";
			while($r=$objdata->Fetch_Assoc()){
				$id=$r["id"];
				$name=$r["lastname"].' '.$r["firstname"];
				echo "<li><a href='javascript:void(0);' onclick='user_group_select(this);' dataid='$id'>$name</a></li>";
			}
			echo "</ul>";
		}
	}

	public function getUserID($uid){
		$sql="SELECT * FROM `tbl_user` WHERE `isactive`=1 AND `id`=$uid";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		if($objdata->Num_rows()){
			echo "<ul class='menu'>";
			while($r=$objdata->Fetch_Assoc()){
				$id=$r["id"];
				$name=$r["lastname"].' '.$r["firstname"];
				echo "<li><a href='javascript:void(0);' onclick='user_group_select(this);' dataid='$id'>$name</a></li>";
			}
			echo "</ul>";
		}
	}

	public function getListCombo($parid,$thisid,$level){
		$sql="SELECT * FROM `tbl_user_group` WHERE `par_id`=$parid AND `isactive`=1";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
		if($level>0){
			for($i=0;$i<$level;$i++)
				$char.="&nbsp;&nbsp;&nbsp;";
			$char.='|---';
		}
		while($r=$objdata->Fetch_Assoc()){
			if($r["id"]==$thisid) continue;
			$id=$r["id"];
			$name=$r["name"];
			echo "<option value='$id'>$char$name</option>";
			$next_level=$level+1;
			$this->getListCombo($id,$thisid,$next_level);
		}
	}

	public function getCurrentLastId() {
		$sql="SELECT max(id) as max FROM `tbl_user`";
		$objdata=new CLS_MYSQL;
		$objdata->Query($sql);
		$row=$objdata->Fetch_Assoc();
		return $row['max']+0;
	}

	public function getNameById($id){
        $objdata=new CLS_MYSQL;
        $sql="SELECT CONCAT(`firstname`,' ',`lastname`) AS 'fullname' FROM `tbl_user`  WHERE isactive=1 AND `user_id` = '$id'";
        $objdata->Query($sql);
        $row=$objdata->Fetch_Assoc();
        return $row['fullname'];
    }

	public function Permission($com='') {
		if(isset($_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN'])){
			$gid=$_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['gid'];
			$sql="SELECT `permission` FROM tbl_user_group WHERE id=$gid"; 
			$this->objmysql->Query($sql);
			if($this->objmysql->Num_rows()==0) return false;
			$row=$this->objmysql->Fetch_Assoc();
			$permission=$row['permission'];
			$flag=false; 
			if($permission & $GLOBALS['ARR_COM']["$com"]) {
				$flag=true; 
			}
			return $flag;
		}
		return false;
	}
}
?>
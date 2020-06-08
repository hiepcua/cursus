<?php
function isLogin(){
	if(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN']['islogin']){
		$user=getInfo('username');
		if(checkExpires($user)===true) return false;
		return true;
	}
	return false;
}
function getInfo($field){
	$info=isset($_SESSION['USER_LOGIN'][$field])?$_SESSION['USER_LOGIN'][$field]:'N/a';
	return $info;
}
function setInfo($field,$val){
	if(isset($_SESSION['USER_LOGIN'][$field])) $_SESSION['USER_LOGIN'][$field]=$val;
}
function updateInfo($field,$val){
	if(isLogin()) $_SESSION['USER_LOGIN'][$field]=$val;
}
function checkExpires($user){
	// sau 1 phút sẽ check lại hệ thống, nếu thấy user có đăng nhập từ một ip mới, sẽ tiến hành logout user hiện tại
	// get session login
	$now=time();
	if(isset($_SESSION['USER_LOGIN']) && $now-$_SESSION['USER_LOGIN']['action_time']>=ACTION_TIMEOUT){
		$obj=new CLS_MYSQL;
		$sql="SELECT session FROM tbl_user_login WHERE username='$user' AND isactive=1 ORDER BY id DESC";
		$obj->Query($sql);
		if($obj->Num_rows()>0){
			$r=$obj->Fetch_Assoc();
			if($_SESSION['USER_LOGIN']['session']!=$r['session']){
				LogOut($user);
				return true;
			}
		}else{
			LogOut($user);
			die('Check Expire error. Please contact administrator!');
		}
	}
	/* // check time out login
	if(isset($_SESSION['USER_LOGIN']) && $now-$_SESSION['USER_LOGIN']['action_time']>=MEMBER_TIMEOUT){
		LogOut();
	}
	*/
	return false;
}
function LogIn($user,$pass){ 
	if($user==''||$pass=='') return false;
	$pass=hash('sha256', $user).'|'.hash('sha256', $pass);
	$fields=array();
	$obj=new CLS_MYSQL;
	if(MemberCountList(" AND `isactive`=1 AND `username`='$user'")!=1) return false;
	$r=MemberGetList($fields," AND `isactive`=1 AND `username`='$user'");
	if($r[0]['password']!=$pass) return false;
	$session=$cdate=time();
	$_SESSION['USER_LOGIN']=$r[0];
	$_SESSION['USER_LOGIN']['session']=$session;
	$_SESSION['USER_LOGIN']['action_time']=$cdate;
	$_SESSION['USER_LOGIN']['islogin']=true;
	$sql="INSERT INTO tbl_user_login(`username`,`session`,`cdate`) VALUES ('$user','$session','$cdate')";
	$obj->Exec($sql);
	return true;
}
function LogOut($user){
	if(isset($_SESSION['USER_LOGIN'])){
		unset($_SESSION['USER_LOGIN']);
		$sql="UPDATE tbl_user_login SET `isactive`=0 WHERE username='$user'";
		$obj=new CLS_MYSQL;
		$obj->Exec($sql);
	}
}
function MemberCountList($where){
	$sql="SELECT COUNT(*) as num FROM tbl_user WHERE 1=1 $where";
	$obj=new CLS_MYSQL;
	$obj->Query($sql);
	$r=$obj->Fetch_Assoc();
	return $r['num']+0;
}
function MemberGetList($fields=array(),$where='',$flag=true){
	if(count($fields)==0){
		$sql="SELECT * FROM tbl_user WHERE 1=1 $where";
	}else{
		$sql="SELECT ";
		foreach($fields as $field){
			$sql.="`$field`,";
		}
		$sql=substr($sql,0,-1)." FROM tbl_user WHERE 1=1 $where ";
	}
	$obj=new CLS_MYSQL;
	$obj->Query($sql);
	if($flag){
		$arr=array();
		while($r=$obj->Fetch_Assoc()){
			$arr[]=$r;
		}
		return $arr;
	}
	return $obj;
}
function MemberAdd($arr){
	if(!is_array($arr) || count($arr)==0) return false;
	$fields=$values='';
	foreach($arr as $key=>$val){
		$fields.="`$key`,";
		$values.="'$val',";
	}
	$sql="INSERT INTO tbl_user(".substr($fields,0,-1).") VALUES(".substr($values,0,-1).")";
	$obj=new CLS_MYSQL;
	$obj->Exec($sql);
}
function MemberEdit($arr){
	$fields='';
	foreach($arr as $key=>$val){
		$fields.="`$key`='$val',";
	}
	$sql="UPDATE tbl_user_login SET ".substr($fields,0,-1)." WHERE username='$user'";
	$obj=new CLS_MYSQL;
	$obj->Exec($sql);
}
function MemberActive($user,$status=0){
	$sql="UPDATE tbl_user SET `isactive`=$status WHERE username='$user'";
	$obj=new CLS_MYSQL;
	$obj->Exec($sql);
}

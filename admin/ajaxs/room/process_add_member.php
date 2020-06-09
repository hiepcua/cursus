<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
if(isLogin()){
	$user=getInfo('username');
	$arr=array();
	$arr['class_code']=antiData($_POST['class_code']);
	$arr['cuser']=$user;
	$user=getInfo('username');
	$type=antiData($_POST['type']);
	if($type=='room'){
		$from_room=antiData($_POST['from_room']);
		$objMember=SysGetList('tbl_class_member',array()," AND class_code='$from_room'",false);
		while($r=$objMember->Fetch_Assoc()){
			$arr['username']=$r['username'];
			$arr['mtype']=$r['mtype'];
			SysAdd('tbl_class_member',$arr);
		}
		die('success');
	}else{
		$members=$_POST['members'];
		foreach($members as $mem){
			if($mem!=''){
				$arr['username']=$mem;
				SysAdd('tbl_class_member',$arr);
			}
		}
		die('success');
	}
}else{
	die('Session expired! Please login to continue');
}
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
	$room=antiData($_POST['room']);
	$gmember=antiData($_POST['gmember']);
	$arr['username']=antiData($_POST['user']);
	$arr['email']=antiData($_POST['user']);
	$arr['phone']=antiData($_POST['phone']);
	$arr['fullname']=antiData($_POST['fullname']);
	$arr['cdate']=time();
	$arr['gmember']=$gmember;
	$pass="123456";
	if($arr['username']!='' && $pass!=''){
		$arr['password']=hash('sha256',$arr['username']).'|'.hash('sha256',md5($pass));
		SysAdd('tbl_member',$arr);
		// add to class_member
		if($room!=''){
			$arr_member=array();
			$arr_member['class_code']=$room;
			$arr_member['username']=$arr['username'];
			$arr_member['cuser']=$user;
			SysAdd('tbl_class_member',$arr_member);
		}
		die('success');
	}else{ die("System don't see data");}

}else{
	die("<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>");
}
?>
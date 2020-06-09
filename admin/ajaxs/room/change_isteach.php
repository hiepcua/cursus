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
	$thisUser=getInfo('username');
	$isAdmin=getInfo('isadmin');
	$user=antiData($_POST['user']);
	$code=antiData($_POST['code']);
	$ischeck=antiData($_POST['ischeck']);
	if($user!=''){
		$value=$ischeck=='yes'?"teach":"";
		$arr=array('mtype'=>$value);
		SysEdit('tbl_class_member',$arr,"username='$user' AND class_code='$code'");
		setInfo('mtype',$value);
		die('success');
	}else{ die("System don't see data");}

}else{
	die("<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>");
}
?>
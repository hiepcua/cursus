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
	$arr=array();
	$username = antiData($_POST['user']);
	$arr['email'] = antiData($_POST['email']);
	$arr['phone'] = antiData($_POST['phone']);
	$arr['fullname'] = antiData($_POST['fullname']);
	$arr['gmember'] = isset($_POST['cbo_gmember']) ? (int)antiData($_POST['cbo_gmember']) : NULL;
	
	if($username!=''){
		SysEdit('tbl_member', $arr, ' username="'.$username.'"');
		die('success');
	}else{ die("System don't see data");}

}else{
	die("<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>");
}
?>
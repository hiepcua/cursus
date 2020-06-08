<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');

$arr = array();
$arr['username'] = antiData($_POST['email']);
$arr['lastname'] = antiData($_POST['name']);
$pass = antiData($_POST['pass']);

if($arr['username'] !== '' && $pass!=''){
	/*Check username exit*/
	$number = SysCountList('tbl_member', " AND username='".$arr['username']."'");
	if($number > 0) die("Email already exits.");

	$arr['password'] = hash('sha256', $arr['username']).'|'.hash('sha256', md5($pass));
	$last_ID = SysAdd('tbl_member', $arr);

	if(!$last_ID){
		die("SignUp Failse!");
	}
	die('success');
}else{ die("Data is empty");}
?>
<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
$user=antiData($_POST['user']);

if($user!=''){
	$number = SysCountList('tbl_member', " AND username='".$user."'");
	if($number > 0){
		die("Exit");
	}
	die('success');
}else{ die("Data is empty");}
die('');

?>
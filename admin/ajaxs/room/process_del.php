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
	$code=isset($_POST['code'])?antiData($_POST['code']):'';
	if($code!=''){
		SysDel('tbl_class'," code='$code'");
		SysDel('tbl_class_member'," class_code='$code'");
		SysDel('tbl_schedule'," class_code='$code'");
		die('success');
	}else{ die("System don't see data");}
}else{
	die("<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>");
}
?>
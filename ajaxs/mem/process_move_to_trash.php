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
	$arr = array();
	$users = antiData($_POST['user']);

	if($users !== ''){
		$users = substr($users, 0, (strlen($users) -1));

		$arr['is_trash'] = 1;
		$arr_users = explode(',', $users);

		for ($i=0; $i < count($arr_users); $i++) { 
			SysEdit('tbl_member', $arr, " username = '".$arr_users[$i]."'");
		}
		die('success');
	}else{
		die('Data is empty!');
	}
}else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
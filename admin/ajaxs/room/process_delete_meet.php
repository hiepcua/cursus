<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
define('root_path','../../');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
if(isLogin()){
	$id=isset($_GET['id'])?antiData($_GET['id'],'int'):0;
	if($id!=''){
		$results = SysGetList('tbl_schedule', array(), " AND id='$id' ", true);
		$res = $results[0];

		SysDel('tbl_schedule'," id='$id' ");

		// Process delete schedule inside json_invite.json file
		$current_data = file_get_contents(root_path.'json_invite.json');
		$arr_current_data = json_decode($current_data, true);
		if(!is_array($arr_current_data)) $arr_current_data = array();

		$res_code = un_unicode($res['title']);

		if(isset($arr_current_data[$res_code])){
			unset($arr_current_data[$res_code]);
			$json_data = json_encode($arr_current_data);
			file_put_contents(root_path.'json_invite.json', $json_data);
		}

		die('success');
	}else{ die("System don't see data");}
}else{
	die("<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>");
}
?>
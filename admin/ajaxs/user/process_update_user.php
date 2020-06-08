<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../includes/gfconfig.php");
require_once("../../includes/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
} 
$check_permission = $objuser->Permission('user');
if($check_permission==false) die('E02');

$gid = $_POST['txt_gid'];
$userid=isset($_POST['txt_user_id'])?(int)$_POST['txt_user_id']:0;
$first_name = addslashes($_POST['txt_firstname']);
$last_name = addslashes($_POST['txt_lastname']);
$birthday = isset($_POST['txt_birthday'])?$_POST['txt_birthday']:'';
$gender = (int)$_POST['opt_gender'];
$username = isset($_POST['txt_username'])?$_POST['txt_username']:'';
$password = isset($_POST['txt_password'])?md5(sha1($_POST['txt_password'])):'';
$phone = (int)$_POST['txt_phone'];
$email = isset($_POST['txt_email'])? addslashes($_POST['txt_email']):'';
$address = isset($_POST['txt_address']) ? addslashes($_POST['txt_address']):'';
$date = date('Y-m-d H:i:s');
$cmtnd = (int)$_POST['txt_cmtnd'];
$organ = addslashes($_POST['txt_organ']);
if(isset($_POST['cmd_update_user'])) {
	$sql="UPDATE tbl_user SET 
	`firstname`='$first_name',
	`lastname`='$last_name',
	`birthday`='$birthday',
	`gender`='$gender',
	`phone`='$phone',
	`email`='$email',
	`address`='$address',
	`identify`='$cmtnd',
	`organ`='$organ',
	`lastlogin`='$date'
	WHERE id=$userid";
	echo $sql;die();
	// if($objdata->Query($sql)){}
	// 	else{echo 'E04';}
}else{
	$sql="INSERT INTO tbl_user(`username`,`password`,`firstname`,`lastname`,`birthday`,`gender`,`phone`,`email`,`address`,`identify`,`organ`,`joindate`,`gid`,`isactive`) VALUES('$username','$password','$first_name','$last_name','$birthday','$gender','$phone','$email','$address','$cmtnd','$organ','$date','$gid',1)";
	
	if($objdata->Query($sql)){}
		else{echo 'E04';}
}
?>
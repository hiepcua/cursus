<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
require_once(libs_path.'PHPMailer/mail.php');
if(isLogin()){
	$subject = antiData($_POST['subject']);
	$content = antiData($_POST['content']);
	$emails = antiData($_POST['emails']);

	if($emails != ''){
		$emails = substr($emails, 0, (strlen($emails) -1));
		$arr_email = explode(',', $emails);

		for ($i=0; $i < count($arr_email); $i++) { 
			sendMail($subject, $content, $arr_email[$i]);
		}
		die('success');
	}else{ 
		die("System don't see data");
	}
}else{
	die("<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>");
}
?>
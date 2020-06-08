<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
require_once(libs_path.'SpeedSMSAPI_PHP/index.php');
function un_vietnamese($str){
	$marTViet=array(
	'à','á','ạ','ả','ã','â','ầ','ấ','ậ','ẩ','ẫ','ă',
	'ằ','ắ','ặ','ẳ','ẵ','è','é','ẹ','ẻ','ẽ','ê','ề'
	,'ế','ệ','ể','ễ',
	'ì','í','ị','ỉ','ĩ',
	'ò','ó','ọ','ỏ','õ','ô','ồ','ố','ộ','ổ','ỗ','ơ'
	,'ờ','ớ','ợ','ở','ỡ',
	'ù','ú','ụ','ủ','ũ','ư','ừ','ứ','ự','ử','ữ',
	'ỳ','ý','ỵ','ỷ','ỹ',
	'đ',
	'A','B','C','D','E','F','J','G','H','I','K','L','M',
	'N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
	'À','Á','Ạ','Ả','Ã','Â','Ầ','Ấ','Ậ','Ẩ','Ẫ','Ă'
	,'Ằ','Ắ','Ặ','Ẳ','Ẵ',
	'È','É','Ẹ','Ẻ','Ẽ','Ê','Ề','Ế','Ệ','Ể','Ễ',
	'Ì','Í','Ị','Ỉ','Ĩ',
	'Ò','Ó','Ọ','Ỏ','Õ','Ô','Ồ','Ố','Ộ','Ổ','Ỗ','Ơ'
	,'Ờ','Ớ','Ợ','Ở','Ỡ',
	'Ù','Ú','Ụ','Ủ','Ũ','Ư','Ừ','Ứ','Ự','Ử','Ữ',
	'Ỳ','Ý','Ỵ','Ỷ','Ỹ',
	'Đ',":",",",".","?","`","~","!","@","#","$","%","^","&","*","(",")","'",'"','&','/','|','   ','  ');

	$marKoDau=array('a','a','a','a','a','a','a','a','a','a','a',
	'a','a','a','a','a','a',
	'e','e','e','e','e','e','e','e','e','e','e',
	'i','i','i','i','i',
	'o','o','o','o','o','o','o','o','o','o','o','o'
	,'o','o','o','o','o',
	'u','u','u','u','u','u','u','u','u','u','u',
	'y','y','y','y','y',
	'd',
	'a','b','c','d','e','f','j','g','h','i','k','l','m',
	'n','o','p','q','r','s','t','u','v','w','x','y','z',
	'a','a','a','a','a','a','a','a','a','a','a','a'
	,'a','a','a','a','a',
	'e','e','e','e','e','e','e','e','e','e','e',
	'i','i','i','i','i',
	'o','o','o','o','o','o','o','o','o','o','o','o'
	,'o','o','o','o','o',
	'u','u','u','u','u','u','u','u','u','u','u',
	'y','y','y','y','y',
	'd',"","","","","","","","","","","","","","",'','','','','','','',' ',' ');

	$str = str_replace($marTViet, $marKoDau, $str);
	return $str;
}

if(isLogin()){
	$content = antiData($_POST['content']);
	$emails = antiData($_POST['emails']);
	$sms_content = un_vietnamese($content);

	if($emails != ''){
		$emails = substr($emails, 0, (strlen($emails) -1));
		$arr_email = explode(',', $emails);

		for ($i=0; $i < count($arr_email); $i++) {
			$rows = SysGetList('tbl_member', array('phone'), " AND username='".$arr_email[$i]."' ");
			
			if(count($rows) > 0){
				$row = $rows[0];
				if($row['phone'] !== '' && (int)$row['phone'] !== 0){
					sendSMS($row['phone'], $sms_content);
				}
			}
		}
		die('success');
	}else{ 
		die("System don't see data");
	}
}else{
	die("<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>");
}
?>
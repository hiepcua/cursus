<?php 
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");

$objmysql =  new CLS_MYSQL;
if(isset($_POST['username'])) {
	$username = addslashes(trim($_POST['username']));
	$sql = "SELECT * FROM tbl_user  WHERE username='$username'";
	$objmysql->Query($sql);
	if($objmysql->Num_rows() > 0){
		echo '1';
	}else{
		echo '0';
	}
} else if (isset($_POST['userID'])) {
	$userID = $_POST['userID'];
	$sql = "SELECT * FROM tbl_user  WHERE id=$userID";
	$objmysql->Query($sql);	
	$r=$objmysql->Fetch_Assoc();
	$id=$r['id'];
	
	if($r['avatar']!='') $avatar=$r['avatar'];
	else $avatar = ROOTHOST.'uploads/user.png';
	
	$name=$r['fullname'];
	$identify=$r['identify'];
	$gender=$r['gender']==0 ? 'Nữ' : 'Nam';
	$phone=$r['phone'];
	$address=$r['address'];

	$json = "[";
	if ($objmysql->Num_rows() > 0)  {
		$json.= "{\"rep\":\"yes\", 
		\"id\": \"$id\",
		\"avatar\": \"$avatar\",
		\"name\": \"$name\",
		\"identify\": \"$identify\",
		\"gender\": \"$gender\",
		\"phone\": \"$phone\",
		\"address\": \"$address\"}";
	} 
	else {
		$json.= "{\"rep\":\"no\", \"id\": \"\"}";
	}
	echo $json."]";

} else {
	$json = "[";
	$json.= "{\"rep\":\"no\", \"id\": \"\"}]";
	echo $json."]";
}

?>
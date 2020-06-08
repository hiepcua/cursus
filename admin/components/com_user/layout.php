<?php
defined("ISHOME") or die("Can not acess this page, please come back!");
define("COMS","user");
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
require_once('libs/cls.user_group.php');
require_once('extensions/cls.upload.php');

$objmysql 	= new CLS_MYSQL();
$obj 		= new CLS_USER();
$obj_guser 	= new CLS_USER_GROUP();
$obj_upload = new CLS_UPLOAD();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

if(isset($_POST["cmd_save"])){
	$username 		= isset($_POST['txt_username']) ? addslashes(trim($_POST['txt_username'])) : '';
	$password 		= isset($_POST['txt_password']) ? md5(sha1(trim($_POST['txt_password']))) : '';
	$gid 			= isset($_POST['cbo_gid']) ? (int)$_POST['cbo_gid'] : '';
	$first_name 	= isset($_POST['txt_firstname']) ? addslashes($_POST['txt_firstname']) : '';
	$last_name 		= isset($_POST['txt_lastname']) ? addslashes($_POST['txt_lastname']) : '';
	$birthday 		= isset($_POST['txt_birthday']) ? $_POST['txt_birthday']:'';
	$gender 		= (int)$_POST['opt_gender'];
	$phone 			= addslashes(trim($_POST['txt_phone']));
	$email 			= isset($_POST['txt_email']) ? addslashes($_POST['txt_email']):'';
	$organ 			= addslashes($_POST['txt_organ']);
	$address 		= isset($_POST['txt_address']) ? addslashes($_POST['txt_address']):'';
	$date 			= date('Y-m-d H:i:s');
	$isactive 		= isset($_POST['opt_isactive']) ? (int)$_POST['opt_isactive'] : 0;
	$date			= date('Y-m-d H:i:s');

	if(isset($_POST['txtid'])){
		$ID = (int)$_POST['txtid'];
		$mdate = $date;
		$id = (int)$_POST['txtid'];
		$sql="UPDATE `tbl_user` SET `firstname`='".$first_name."',
		`lastname`='".$last_name."',
		`birthday`='".$birthday."',
		`gender`='".$gender."',
		`address`='".$address."',
		`phone`='".$phone."',
		`email`='".$email."',
		`gid`='".$gid."'";
		$sql.=" WHERE `id`='".$ID."'";
		$result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}else{
		$cdate = $date;
		$sql="INSERT INTO `tbl_user` (`username`,`password`,`firstname`,`lastname`,`birthday`,`gender`,`address`,`phone`,`email`,`joindate`,`gid`,`isactive`) VALUES ('".$username."','".md5(sha1(trim($password)))."','".$first_name."','".$last_name."','".$birthday."','".$gender."','".$address."','".$phone."','".$email."','".$cdate."','".$gid."','".$isactive."') ";
		$result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}
	// echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=$_POST["txtids"];
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 		$obj->setActive($ids,1); 		break;
		case "unpublic": 	$obj->setActive($ids,0); 		break;
		case "delete": 		$obj->Delete($ids); 		break;
		case "edit": 	
		$id=explode("','",$ids);
		echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."/edit/id=".$id[0]."'</script>";
		break;
		case 'order':
		$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
		$obj->Order($ids,$sls); 	break;
	}
	echo "<script language=\"javascript\">window.location.href='".ROOTHOST_ADMIN.COMS."'</script>";
}

if($UserLogin->isLogin()) {
	$task=isset($_GET['task'])?$_GET['task']:'list';
	if(is_file(THIS_COM_PATH.'task/'.$task.'.php')){
		include_once(THIS_COM_PATH.'task/'.$task.'.php');
	}
}
unset($task); unset($ids);
?>
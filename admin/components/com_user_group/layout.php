<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','user_group');
require_once('libs/cls.user_group.php');
$objmysql = new CLS_MYSQL();
$obj = new CLS_USER_GROUP();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

if(isset($_POST['cmdsave'])){
	$Par_Id = 	addslashes($_POST['cbo_parent']);
	$Name 	=	addslashes($_POST['txt_name']);
	$Intro 	= 	addslashes($_POST['txtintro']);

	if(isset($_POST['txtid'])){
		$ID=(int)$_POST['txtid'];

		$sql = "UPDATE tbl_user_group SET 
        `par_id`='".$Par_Id."',
        `name`='".$Name."',
        `intro`='".$Intro."'
        WHERE id='".$ID."'";
        $result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}else{
		$sql="INSERT INTO `tbl_user_group`(`par_id`,`name`,`intro`) VALUES ('".$Par_Id."','".$Name."','".$Intro."')";
		$result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}
	// echo "<script language=\"javascript\">window.location.href='".ROOTHOST_ADMIN.COMS."'</script>";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 
			$sql_active = "UPDATE `tbl_user_group` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_user_group` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_user_group` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_user_group` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
				$objmysql->Exec($sql_order);
			}
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');$task='';
if(isset($_GET['task']))
	$task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($task); unset($ids); unset($obj); unset($objlang);
?>
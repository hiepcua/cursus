<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','feedback');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');

include_once(EXT_PATH.'cls.upload.php');
$objUpload = new CLS_UPLOAD();
$objmysql = new CLS_MYSQL();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

if(isset($_POST["cmdsave"])){		
	$Name 		= addslashes($_POST['txt_name']);
	$Comment 	= addslashes($_POST['txt_comment']);
	$Career 	= addslashes($_POST['txt_career']);
	$isActive 	= '1';

    if(isset($_POST["txtthumb"]))
        $Avatar=addslashes($_POST["txtthumb"]);

    if(isset($_POST['txtid'])){
		$ID=$_POST['txtid'];
		$sql="UPDATE `tbl_feedback` SET  
		`name`='".$Name."',
		`comment`='".$Comment."',
		`career`='".$Career."',
		`avatar`='".$Avatar."'
		WHERE `id`='".$ID."'";
		$result = $objmysql->Exec($sql);
		if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}else{
		$sql="INSERT INTO `tbl_feedback` ( `name`, `comment`, `career`, `avatar`, `isactive`) VALUES ";
		$sql.="('".$Name."', '".$Comment."','".$Career."', '".$Avatar."', '".$isActive."')";
		$result = $objmysql->Exec($sql);
		if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}
	// echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 
			$sql_active = "UPDATE `tbl_feedback` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_feedback` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_feedback` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_feedback` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
				$objmysql->Exec($sql_order);
			}
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}


$task='';
if(isset($_GET['task'])) $task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($obj); unset($task);	unset($objlang); unset($ids);
?>
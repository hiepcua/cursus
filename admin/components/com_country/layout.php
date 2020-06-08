<?php 
defined("ISHOME") or die("Can not acess this page, please come back!");
define('COMS','country');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');

$objmysql 	= new CLS_MYSQL();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

if(isset($_POST["cmdsave"])){
	$isActive 		= isset($_POST['opt_isactive']) ? (int)$_POST['opt_isactive'] : 0;
	$Title 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$Code 			= un_unicode($_POST['txt_name']);

	if(isset($_POST['txtid'])){
		$ID = $_POST['txtid'];
		$sql = "UPDATE tbl_country SET 
		`name` 		= '".$Title."', 
		`code` 		= '".$Code."',
		`isactive` 	= '".$isActive."'
		WHERE `id` 	= '".$ID."'";
		$result = $objmysql->Exec($sql);
		if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}else{
		$sql = "INSERT INTO tbl_country (`name`,`code`,`isactive`) VALUES ('".$Title."','".$Code."','".$isActive."')";
		$result = $objmysql->Exec($sql);
		if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 
			$sql_active = "UPDATE `tbl_country` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_country` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_country` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_country` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
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
unset($obj); unset($task); unset($ids);
?>

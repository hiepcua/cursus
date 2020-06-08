<?php 
defined("ISHOME") or die("Can not acess this page, please come back!");
define('COMS','city');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');

$objmysql 	= new CLS_MYSQL();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

if(isset($_POST["cmdsave"])){
	$Type 			= isset($_POST['cbo_type']) ? (int)$_POST['cbo_type'] : 0;
	$Country 		= isset($_POST['cbo_country']) ? (int)$_POST['cbo_country'] : 0;
	$isActive 		= isset($_POST['opt_isactive']) ? (int)$_POST['opt_isactive'] : 0;
	$Title 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';

	if(isset($_POST['txtid'])){
		$ID = $_POST['txtid'];
		$sql = "UPDATE tbl_city SET 
		`name` 		= '".$Title."', 
		`type` 		= '".$Type."',
		`country` 	= '".$Country."',
		`isactive` 	= '".$isActive."'
		WHERE `id` 	= '".$ID."'";
		$result = $objmysql->Exec($sql);
		if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}else{
		$sql = "INSERT INTO tbl_city (`name`,`type`,`country`,`isactive`) VALUES ('".$Title."','".$Type."','".$Country."','".$isActive."')";
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
			$sql_active = "UPDATE `tbl_city` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_city` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_city` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_city` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
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

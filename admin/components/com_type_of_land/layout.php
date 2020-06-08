<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','type_of_land');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
$objmysql = new CLS_MYSQL();

if(isset($_POST["cmdsave"])){
	$Intro 			= isset($_POST['txt_comment']) ? addslashes($_POST['txt_comment']) : '';
	$Title 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$Thumb 			= isset($_POST['txtthumb']) ? addslashes($_POST['txtthumb']) : '';
	$Code 			= un_unicode($Title);
	$isActive 		= '1';

    if(isset($_POST["txtthumb"]))
        $Avatar=addslashes($_POST["txtthumb"]);

    if(isset($_POST['txtid'])){
		$ID=$_POST['txtid'];
		$sql = "UPDATE `tbl_type_of_land` SET  
		`title` 	= '".$Title."',
		`code` 		= '".$Code."',
		`intro` 	= '".$Intro."'
		WHERE `id` 	= '".$ID."'";
		$objmysql->Exec($sql);
	}else{
		$sql="INSERT INTO `tbl_type_of_land` ( `title`, `code`, `intro`, `isactive`) VALUES ";
		$sql.="('".$Title."', '".$Code."','".$Intro."', '".$isActive."')";
		$objmysql->Exec($sql);
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 
			$sql_active = "UPDATE `tbl_type_of_land` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_type_of_land` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_type_of_land` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_type_of_land` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
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
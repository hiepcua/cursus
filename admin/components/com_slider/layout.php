<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','slider');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');

// Begin Toolbar
include_once(EXT_PATH.'cls.upload.php');
$objmysql = new CLS_MYSQL();
$objUpload = new CLS_UPLOAD();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

// End toolbar
if(isset($_POST["cmdsave"])){		
	$Slogan= addslashes($_POST['txt_slogan']);
	$Intro=addslashes($_POST['txt_intro']);
	$Link=addslashes($_POST['txt_link']);
	$isActive='1';
    if(isset($_POST["txtthumb"]))
        $Thumb=addslashes($_POST["txtthumb"]);
    if(isset($_POST['txtid'])){
		$ID = $_POST['txtid'];
		$sql = "UPDATE `tbl_slider` SET  
		`slogan`='".$Slogan."',
		`intro`='".$Intro."',
		`thumb`='".$Thumb."',
		`link`='".$Link."'
		WHERE `id`='".$ID."'";
		$result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}else{
		$sql="INSERT INTO `tbl_slider` ( `slogan`, `intro`, `thumb`,`link`, `isactive`) VALUES ('".$Slogan."','".$Intro."','".$Thumb."','".$Link."','".$isActive."')";
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
			$sql_active = "UPDATE `tbl_slider` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_slider` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_slider` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_slider` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
				$objmysql->Exec($sql_order);
			}
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

$task='';
if(isset($_GET['task']))
	$task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($obj); unset($task);	unset($objlang); unset($ids);
?>
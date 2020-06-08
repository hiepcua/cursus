<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','profile');
require_once('libs/cls.profile.php');
$obj=new CLS_PROFILE();
if(isset($_POST['cmdsave'])){
	$obj->Fullname = addslashes(strip_tags($_POST['fullname']));
	$obj->CMTND = addslashes(strip_tags($_POST['CMTND']));
	$sn = addslashes(strip_tags($_POST['birthday']));
	$sn = str_replace("-","/",$sn);
	$obj->Birthday = $sn;
	$obj->Gender = addslashes(strip_tags($_POST['gender']));
	$obj->HouseHold = addslashes(strip_tags($_POST['Hokhau']));
	$obj->Email = addslashes(strip_tags($_POST['Email']));
	$obj->Tel = addslashes(strip_tags($_POST['Dienthoai']));
	$obj->Year = (int)$_POST['year'];
	$obj->Address = addslashes(strip_tags($_POST['address']));
	$obj->Branch = addslashes(strip_tags($_POST['nganh']));
	
	if(isset($_POST['txtid'])){
		$obj->ID=(int)$_POST['txtid'];
		$obj->Update();
	}else{
		$obj->Add_new();
	}
	echo "<script language=\"javascript\">window.location.href='".ROOTHOST_ADMIN.COMS."'</script>";
}
if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 		$obj->setActive($ids,1); 		break;
		case "unpublic": 	$obj->setActive($ids,0); 		break;
		case "delete": 		$obj->Delete($ids); 			break;
		case 'order':
		$sls=explode(',',$_POST['txtorders']); $ids=explode(',',$_POST['txtids']);
		$obj->Order($ids,$sls); 	break;
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
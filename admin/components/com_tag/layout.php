<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','tag');
include_once(LIB_PATH."cls.tag.php");
$obj=new CLS_TAG();
if(isset($_POST['cmdsave'])){
	$obj->Name=addslashes($_POST['txtname']);
	$obj->Code=addslashes(un_unicode($_POST['txtcode']));
	$obj->MTitle=addslashes(strip_tags($_POST['txt_metatitle']));
	$obj->MDesc=addslashes(strip_tags($_POST['txt_metadesc']));
	if(isset($_POST['txtid'])){
		$obj->ID=(int)$_POST['txtid'];
		$obj->Update();
	}else{
		$obj->Add_new();
	}
	echo "<script language='javascript'>window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}
if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 		$obj->setActive($ids,1); 		break;
		case "unpublic": 	$obj->setActive($ids,0); 		break;
		case "edit": 	
			$id=explode("','",$ids);
			echo "<script language='javascript'>window.location='".ROOTHOST_ADMIN.COMS."/edit/".$id[0]."'</script>";
			break;
		case "delete": 		$obj->Delete($ids); 			break;
	}
	echo "<script language='javascript'>window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}
$task='';
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
if(isset($_GET['task']))
	$task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($task); unset($ids); unset($obj); unset($objlang);
?>
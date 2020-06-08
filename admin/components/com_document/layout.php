<?php 
defined("ISHOME") or die("Can not acess this page, please come back!");
define("COMS","document");
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
require_once('libs/cls.document_group.php');
$objmysql = new CLS_MYSQL();
$obj_gdoc = new CLS_DOCUMENT_TYPE();
global $UserLogin;
$username = $UserLogin->getInfo('username');
if(isset($_POST["cmdsave"])){
	$G_ID		= (int)$_POST["cbo_group"];
	$Name		= addslashes($_POST["txttitle"]);
	$Code		= un_unicode($Name);
	$Intro		= addslashes($_POST["txtintro"]);
	$Content	= addslashes($_POST['txtdesc']);
	$Author		= $username;

	if(isset($_POST["txturl"])){
		$file 		= addslashes($_POST["txturl"]);
		$pathinfo 	= pathinfo($file); 
		$Url 		= $pathinfo['basename'];
		$Fullurl 	= $file;
		$Filetype 	= $pathinfo['extension'];
	}

	$Filesize 		= $_POST["filesize"];
	$Cdate 			= time();
	$Date_issued 	= strtotime($_POST['txtdate_issued']);

	$Mtitle		= addslashes($_POST['txtmetatitle']);
	$Mkey		= addslashes($_POST['txtmetakey']);
	$Mdesc		= addslashes($_POST['textmetadesc']);
	$isHot	    = (int)$_POST["opthot"];
	$IsActive	= (int)$_POST["optactive"];

	if(isset($_POST["txtid"])){
		$ID	=(int)$_POST["txtid"];
		$Mdate	= date("Y/m/d H:i:s");
		$Date_issued =$_POST['txtdate_issued'];
		$sql="UPDATE `tbl_document` SET  
		`g_id`='".$G_ID."',
		`name`='".$Name."',
		`intro`='".$Intro."',									
		`content`='".$Content."',
		`url`='".$Url."',
		`fullurl`='".$Fullurl."',
		`author`='".$Author."',
		`filetype`='".$Filetype."',
		`filesize`='".$Filesize."',
		`mdate`='".$Mdate."',
		`date_issued`='".$Date_issued."',
		`meta_title`='".$Mtitle."',	
		`meta_key`='".$Mkey."',	
		`meta_desc`='".$Mdesc."',	
		`ishot`='".$isHot."',
		`isactive`='".$IsActive."' 
		WHERE `id`='".$ID."'";
		$objmysql->Exec($sql);
	}else{
		$sql="INSERT INTO `tbl_document` (`g_id`,`name`,`code`,`intro`,`content`,
		`url`,`fullurl`,`author`,`filetype`,`filesize`,`cdate`,`date_issued`,`meta_title`,`meta_key`,`meta_desc`,`ishot`,`isactive`) VALUES ";
		$sql.="('".$G_ID."','".$Name."','".$Code."','".$Intro."','";
		$sql.=$Content."','".$Url."','".$Fullurl."','".$Author."','".$Filetype."','".$Filesize."','";
		$sql.=$Cdate."','".$Date_issued."','".$Mtitle."','".$Mkey."','".$Mdesc."','".$isHot."','".$IsActive."')";
		$objmysql->Exec($sql);
	}
	echo "<script language=\"javascript\">window.location='index.php?com=".COMS."'</script>";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 
		$sql_active = "UPDATE `tbl_document` SET `isactive`='1' WHERE `id` in ('$ids')";
		$objmysql->Exec($sql_active);
		break;
		case "unpublic":
		$sql_unactive = "UPDATE `tbl_document` SET `isactive`='0' WHERE `id` in ('$ids')";
		$objmysql->Exec($sql_unactive);
		break;
		case "delete":
		$sql_del = "DELETE FROM `tbl_document` WHERE `id` in ('$ids')";
		$objmysql->Exec($sql_del);
		break;
		case 'order':
		$sls = explode(',',$_POST['txtorders']); 
		$ids = explode(',',$_POST['txtids']);
		$n = count($ids);
		for($i=0;$i<$n;$i++){
			$sql_order = "UPDATE `tbl_document` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
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
unset($obj); unset($task); unset($ids);
?>
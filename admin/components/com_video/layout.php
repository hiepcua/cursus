<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','video');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');

require_once('libs/cls.video.php');
$obj = new CLS_VIDEO();
$objmysql = new CLS_MYSQL();

if(isset($_POST['cmdsave'])){
	$Thumb 		= isset($_POST['txtthumb']) ? addslashes($_POST['txtthumb']) : '';
	$Link 		= isset($_POST['txt_link']) ? addslashes($_POST['txt_link']) : '';
	$Name 		= isset($_POST['txt_name']) ? addslashes(htmlentities($_POST['txt_name'])) : '';
	$Intro 		= isset($_POST['txt_intro']) ? addslashes(htmlentities($_POST['txt_intro'])) : '';
	$Content 	= isset($_POST['txt_content']) ? addslashes(htmlentities($_POST['txt_content'])) : '';
	$Code 		= un_unicode($_POST['txt_name']);
	$video_id 	= explode("?v=",$Link);
	$VideoID 	= $video_id[1];
	$isActive 	= 1;

	if(isset($_POST['txtid'])){
		$ID = (int)$_POST['txtid'];
		$sql = "UPDATE tbl_video SET `name`='".$Name."',
		`code`='".$Code."',
		`video_id`='".$VideoID."',
		`link`='".$Link."',
		`thumb`='".$Thumb."',
		`intro`='".$Intro."',
		`content`='".$Content."',
		`mdate`='".date('Y/m/d H:i:s')."'
		WHERE id='".$ID."'";
		$objmysql->Exec($sql);
	}else{
		$sql=" INSERT INTO `tbl_video` (`name`,`code`,`video_id`,`link`,`thumb`,`intro`,`content`,`cdate`,`isactive`) VALUES";
		$sql.="('".$Name."','".$Code."','".$VideoID."','".$Link."','".$Thumb."','".$Intro."','".$Content."','".date('Y/m/d H:i:s')."','".$isActive."')";
		$objmysql->Exec($sql);
	}
	echo "<script language=\"javascript\">window.location.href='".ROOTHOST_ADMIN.COMS."'</script>";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 
			$sql_active = "UPDATE `tbl_video` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_video` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_video` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_video` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
				$objmysql->Exec($sql_order);
			}
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

$task = '';
if(isset($_GET['task']))
	$task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($task); unset($ids); unset($obj); unset($objlang);
?>
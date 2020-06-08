<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','category');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');

require_once('libs/cls.category.php');
$objmysql 	= new CLS_MYSQL();
$obj 		= new CLS_CATEGORY();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

if(isset($_POST['cmdsave'])){
	$Par_Id 		= isset($_POST['cbo_cate']) ? (int)$_POST['cbo_cate'] : 0;
	$Intro 			= isset($_POST['txtintro']) ? addslashes($_POST['txtintro']) : '';
	$Name 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$Code 			= un_unicode(addslashes($_POST['txt_name']));
	$Thumb 			= isset($_POST['txtthumb']) ? addslashes($_POST['txtthumb']) : '';
	$isActive 		= 1;

	$Meta_title 	= isset($_POST['txt_metatitle']) ? addslashes(htmlentities($_POST['txt_metatitle'])) : '';
	$Meta_key 		= isset($_POST['txt_metakey']) ? addslashes(htmlentities($_POST['txt_metakey'])) : '';
	$Meta_desc 		= isset($_POST['txt_metadesc']) ? addslashes(htmlentities($_POST['txt_metadesc'])) : '';
	$seo_link 		= isset($_POST['txt_seo_link']) ? $_POST['txt_seo_link'] : '';
	$Link 			= ROOTHOST.$Code;

	if(isset($_POST['txtid'])){
		$ID = (int)$_POST['txtid'];

		$objmysql->Query("BEGIN");
		$sql = "UPDATE tbl_categories SET 
        `par_id`='".$Par_Id."',
        `name`='".$Name."',
        `code`='".$Code."',
        `thumb`='".$Thumb."',
        `intro`='".$Intro."'
        WHERE id='".$ID."'";
        $result = $objmysql->Exec($sql);

        $sql2 = "UPDATE tbl_seo SET 
		`title` = '".$Name."', 
		`link` = '".$Link."',
		`image` = '".$Thumb."',
		`meta_title` = '".$Meta_title."',
		`meta_key` = '".$Meta_key."',
		`meta_desc` = '".$Meta_desc."'
		WHERE `link` = '".$seo_link."'";
		$result2 = $objmysql->Exec($sql2);

		if($result && $result2){
			$objmysql->Exec('COMMIT');
			$_SESSION['flash'.'com_'.COMS] = 1;
		}else{
			$objmysql->Exec('ROLLBACK');
			$_SESSION['flash'.'com_'.COMS] = 0;
		}
	}else{
		$objmysql->Exec("BEGIN");
		$sql="INSERT INTO `tbl_categories`(`par_id`,`name`,`code`,`thumb`,`intro`,`isactive`) VALUES ('".$Par_Id."','".$Name."','".$Code."','".$Thumb."','".$Intro."','".$isActive."')";
		$result = $objmysql->Exec($sql);

		$sql2 = "INSERT INTO tbl_seo (`title`,`link`,`image`,`meta_title`,`meta_key`,`meta_desc`) VALUES ('".$Name."','".$Link."','".$Thumb."','".$Meta_title."','".$Meta_key."','".$Meta_desc."')";
		$result2 = $objmysql->Exec($sql2);

		if($result && $result2){
			$objmysql->Exec('COMMIT');
			$_SESSION['flash'.'com_'.COMS] = 1;
		}else{
			$objmysql->Exec('ROLLBACK');
			$_SESSION['flash'.'com_'.COMS] = 0;
		}
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
			$sql_active = "UPDATE `tbl_categories` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_categories` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_categories` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_categories` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
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
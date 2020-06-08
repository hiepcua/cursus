<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','mnuitem');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');

$flag = false;
if(!isset($UserLogin)) $UserLogin = new CLS_USERS();
if($UserLogin->isLogin() == true){
	$flag = true;
}
if($flag == false){
	echo ('<div id="action" style="background-color:#fff"><h4>Bạn không có quyền truy cập. <a href="index.php">Vui lòng quay lại trang chính</a></h4></div>');
	return false;
}

// Begin Toolbar
require_once('libs/cls.menuitem.php');
require_once('libs/cls.category.php');
$objmysql = new CLS_MYSQL();
$obj_cate = new CLS_CATEGORY();
$obj = new CLS_MENUITEM();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

$mnuid = isset($_GET['mnuid']) ? (int)$_GET['mnuid'] : 0;
if(isset($_POST['cmdsave'])){ 
	$Cate_ID 	= '';
	$Con_ID 	= '';
	$Link 		= '';
	$Mnu_ID 	= (int)$mnuid;
	$Code 		= addslashes(un_unicode($_POST['txtname']));
	$Par_ID		= isset($_POST['cbo_parid']) ? (int)$_POST['cbo_parid'] : 0;
	$Name 		= isset($_POST['txtname']) ? addslashes($_POST['txtname']) : '';
	$Intro 		= isset($_POST['txtdesc']) ? addslashes($_POST['txtdesc']) : '';
	$Viewtype 	= isset($_POST['cbo_viewtype']) ? addslashes($_POST['cbo_viewtype']) : '';
	$Icon 		= isset($_POST['txticon']) ? addslashes($_POST['txticon']) : '';
	$Class 		= isset($_POST['txtclass']) ? addslashes($_POST['txtclass']) : '';
	$isActive 	= isset($_POST['optactive']) ? (int)$_POST['optactive'] : 0;

	if($Viewtype == 'block'){
		$Cate_ID = (int)$_POST['cbo_cate'];
	}
	else if($Viewtype == 'article'){		
		$Con_ID = (int)$_POST['cbo_article'];
	}
	else{
		$Link = addslashes($_POST['txtlink']);
	}

	if(isset($_POST['txtid'])){
		$ID = (int)$_POST['txtid'];

		$sql="UPDATE `tbl_mnuitems` SET  
		`par_id`='".$Par_ID."',
		`code`='".$Code."',
		`intro`='".$Intro."',
		`name`='".$Name."',
		`menu_id`='".$Mnu_ID."',
		`viewtype`='".$Viewtype."',
		`category_id`='".$Cate_ID."',
		`content_id`='".$Con_ID."',
		`link`='".$Link."',
		`icon`='".$Icon."',
		`class`='".$Class."',
		`isactive`='".$isActive."'";
		$sql.=" WHERE `id`='".$ID."'";
		$result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}else{
		$sql="INSERT INTO `tbl_mnuitems`(`par_id`,`name`,`code`,`menu_id`,`viewtype`,`category_id`,`content_id`,`link`,`icon`,`class`,`intro`,`isactive`) VALUES ";
		$sql.="('".$Par_ID."','".$Name."','".$Code."','".$Mnu_ID."','".$Viewtype."','".$Cate_ID."','".$Con_ID."','".$Link."','".$Icon."','".$Class."','".$Intro."','".$isActive."') ";
		$result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
	}
	// echo '<script language="javascript">window.location="'.ROOTHOST_ADMIN.COMS.'/'.$mnuid.'"</script>';
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 
			$sql_active = "UPDATE `tbl_mnuitems` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_mnuitems` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql_del = "DELETE FROM `tbl_mnuitems` WHERE `id` in ('$ids')";
	        $objmysql->Exec($sql_del);
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_mnuitems` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
				$objmysql->Exec($sql_order);
			}
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS.'/'.$mnuid."'</script>";
}

$task='';
if(isset($_GET['task']))
	$task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($task); unset($ids); unset($obj); unset($objlang);
?>
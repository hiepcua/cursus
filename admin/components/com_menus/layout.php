<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','menus');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
$objmysql = new CLS_MYSQL();

$check_permission = $UserLogin->Permission(COMS);
if($check_permission==false) die($GLOBALS['MSG_PERMIS']);
$msg        = new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

$flag=false;
if(!isset($UserLogin)) $UserLogin=new CLS_USERS;
if($UserLogin->isLogin()==true)
    $flag=true;
if($flag==false){
    echo ('<div id="action" style="background-color:#fff"><h4>Bạn không có quyền truy cập. <a href="index.php">Vui lòng quay lại trang chính</a></h4></div>');
    return false;
}

if(isset($_POST['cmdsave'])){
    $Name       = addslashes($_POST['txtname']);
    $Code       = un_unicode($Name);
    $Desc       = addslashes($_POST['txtdesc']);
    $isActive   = (int)$_POST['optactive'];

    if(isset($_POST['txtid'])){
        $ID=(int)$_POST['txtid'];
        $sql="UPDATE `tbl_menus` SET `code`='".$Code."',`desc`='".$Desc."',`name`='".$Name."',`isactive`='".$isActive."' WHERE `id`='".$ID."'";
        $result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
    }else{
        $sql="INSERT INTO `tbl_menus`(`name`,`code`,`desc`,`isactive`) VALUES ('".$Name."','".$Code."','".$Desc."','".$isActive."') ";
        $result = $objmysql->Exec($sql);
        if($result) $_SESSION['flash'.'com_'.COMS] = 1;
        else $_SESSION['flash'.'com_'.COMS] = 0;
    }
    // echo '<script language="javascript">window.location="'.ROOTHOST_ADMIN.COMS.'"</script>';
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
    $ids=trim($_POST["txtids"]);
    if($ids!='')
        $ids = substr($ids,0,strlen($ids)-1);
    $ids=str_replace(",","','",$ids);
    switch ($_POST["txtaction"]){
        case "public": 
            $sql_active = "UPDATE `tbl_menus` SET `isactive`='1' WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_active);
            break;
        case "unpublic":
            $sql_unactive = "UPDATE `tbl_menus` SET `isactive`='0' WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_unactive);
            break;
        case "delete":
            $sql_del = "DELETE FROM `tbl_menus` WHERE `id` in ('$ids')";
            $objmysql->Exec($sql_del);
            break;
        case 'order':
            $sls = explode(',',$_POST['txtorders']); 
            $ids = explode(',',$_POST['txtids']);
            $n = count($ids);
            for($i=0;$i<$n;$i++){
                $sql_order = "UPDATE `tbl_menus` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
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
unset($obj); unset($task);  unset($objlang); unset($ids);

?>
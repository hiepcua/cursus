<?php
defined('ISHOME') or die("Can't access this page!");
$COM='member';

require_once libs_path."cls.upload.php";
$obj_upload = new CLS_UPLOAD();
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.$COM])) $_SESSION['flash'.'com_'.$COM] = 2;

$viewtype=isset($_GET['viewtype'])?addslashes($_GET['viewtype']):'list';
if(is_file(COM_PATH.'com_'.$COM.'/tem/'.$viewtype.'.php'))
include_once('tem/'.$viewtype.'.php');
unset($viewtype); unset($obj); unset($COM);
?>
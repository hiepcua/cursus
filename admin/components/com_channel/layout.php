<?php
defined('ISHOME') or die("Can't access this page!");
define('COMS','channel');
$COM='channel';
$viewtype='list';

if(isset($_GET['viewtype'])){
	$viewtype=addslashes($_GET['viewtype']);
}

if(is_file(COM_PATH.'com_'.$COM.'/tem/'.$viewtype.'.php'))
	include_once('tem/'.$viewtype.'.php');	
unset($viewtype); unset($obj); unset($COM);
?>
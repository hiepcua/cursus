<?php
defined('ISHOME') or die("Can't access this page!");
define('COMS','member');
define('OBJ_PAGE',';MEMBER');
$viewtype=isset($_GET['viewtype'])?addslashes($_GET['viewtype']):'list';

if(is_file(COM_PATH.'com_'.COMS.'/tem/'.$viewtype.'.php')){
	include_once('tem/'.$viewtype.'.php');
}
unset($viewtype); unset($obj);
?>
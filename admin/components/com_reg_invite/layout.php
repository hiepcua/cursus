<?php
defined('ISHOME') or die("Can't access this page!");
define('COMS','reg_invite');
$COM='reg_invite';

$viewtype=isset($_GET['viewtype'])?addslashes($_GET['viewtype']):'list';

$user=getInfo('username');
$isAdmin=getInfo('isadmin');
if($isAdmin==1){
	if(is_file(COM_PATH.'com_'.$COM.'/tem/'.$viewtype.'.php'))
		include_once('tem/'.$viewtype.'.php');
	unset($viewtype); unset($obj); unset($COM);
}else{
	echo "<h3 class='text-center'>You haven't permission</h3>";
}
?>
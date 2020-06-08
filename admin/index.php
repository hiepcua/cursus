<?php
session_start();
define("ISHOME",true);
define('incl_path','../global/libs/');
define('libs_path','../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once('global/libs/gffunc_user.php');
require_once(libs_path."cls.mysql.php");

include_once 'layouts/header.php';
if(!isLogin()){
	include_once('layouts/login.php');
}else{
	include_once('layouts/home.php');
	include_once('layouts/footer.php');
}
?>
<script src="<?php echo ROOTHOST;?>admin/global/dist/js/adminlte.js"></script>
<script src="<?php echo ROOTHOST;?>admin/global/js/script.min.js"></script>
<?php
session_start();
define("ISHOME",true);
if(!isset($_SESSION['LANGUAGE_ADMIN'])) $_SESSION['LANGUAGE_ADMIN']='0';
require_once("../global/libs//gfinit.php");
require_once("../global/libs/gfconfig.php");
require_once("../global/libs/gffunc.php");
require_once("includes/gfconfig.php");
require_once("libs/cls.mysqli.php");
require_once("libs/cls.user.php");
require_once("libs/cls.category.php");
require_once("libs/FlashMessages.php"); 	// Flash message
$UserLogin = new CLS_USER();
global $UserLogin;

include_once('modules/layouts/header.php');
include_once('modules/layouts/home.php');
include_once('modules/layouts/footer.php');
?>

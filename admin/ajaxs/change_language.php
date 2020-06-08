<?php
session_start();
define("isHOME",true);
$flag = isset($_POST['language']) ? (int)$_POST['language'] : '';

if($flag=='1'){
	$_SESSION['LANGUAGE_ADMIN']='1';
}else{
	$_SESSION['LANGUAGE_ADMIN']='0';
}
?>

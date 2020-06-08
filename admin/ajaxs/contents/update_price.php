<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysql.php");

$objdata = new CLS_MYSQL;
$id = isset($_POST['id']) ? (float)$_POST['id'] : 0;
$price = isset($_POST['price']) ? (float)$_POST['price'] : 0;

$sql="UPDATE tbl_contents SET price = $price WHERE id = $id";
$objdata->Exec($sql);
?>
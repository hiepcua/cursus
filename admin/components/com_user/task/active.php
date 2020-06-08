<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$objmysql = new CLS_MYSQL();
$id='';
if(isset($_GET['id'])){
	$id=$_GET['id'];
}
$sql="UPDATE `tbl_user` SET `isactive`=if(`isactive`=1,0,1) WHERE `id` in ('$id')";
$objmysql->Exec($sql);
echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
?>
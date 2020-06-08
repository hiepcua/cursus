<?php
	defined('ISHOME') or die('Can not acess this page, please come back!');
	$id='';
	if(isset($_GET['id']))
		$id=(int)$_GET['id'];

	$sql = "SELECT * FROM tbl_place WHERE id = ".$id;
	$objmysql->Query($sql);
	$row = $objmysql->Fetch_Assoc();
	$seo_link   = ROOTHOST.'diem-den/'.$row['code'];
	
	$objmysql->Query("BEGIN");
	$sql_del1 	= "DELETE FROM `tbl_seo` WHERE `link` = '".$seo_link."'";
	$result 	= $objmysql->Exec($sql_del1);

	$sql_del 	= "DELETE FROM `tbl_place` WHERE `id` in ('$id')";
	$result2 	= $objmysql->Exec($sql_del);

	if($result && $result2){
		$objmysql->Exec('COMMIT');
	}
	else
		$objmysql->Exec('ROLLBACK');

	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
?>
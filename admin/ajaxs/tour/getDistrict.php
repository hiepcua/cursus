<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../libs/cls.mysqli.php");
require_once("../../libs/cls.user.php");

$objuser=new CLS_USER;
$objdata=new CLS_MYSQL;
if(!$objuser->isLogin()){
	die("E01");
}

// $id=isset($_GET['id'])?(int)$_GET['id']:0;
$ids = isset($_GET['ids'])? $_GET['ids'] : 0;
$arr_id = json_decode($ids);
$idsArray = "'" .implode("','", $arr_id  ) . "'"; 

$sql="SELECT * FROM tbl_district WHERE isactive=1 AND city_id IN ($idsArray)";
$objdata->Query($sql);
echo '<option value="0">-- Chọn một --</option>';
while ($row = $objdata->Fetch_Assoc()) {
	echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}
?>
<script type="text/javascript">
	$("#cbo_district").select2();
</script>
<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','tour');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');
require_once('libs/cls.place.php');
require_once('extensions/cls.upload.php');
$obj_place 	= new CLS_PLACE();
$objmysql 	= new CLS_MYSQL();
$objdata 	= new CLS_MYSQL();
$objmedia 	= new CLS_UPLOAD();
$cur_dir 	= '../images/';
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;


function createFolder($path){
    if(!is_dir($path)){
		mkdir($path, 0777);
	}
}

$sort = array();
if(isset($_POST["cmdsave"])){
	$obj_images = array();
	$obj_fileImages = array();
	$txt_images = isset($_POST['txt_images']) ? $_POST['txt_images'] : '';
	$file_images = isset($_FILES['file_images']) ? $_FILES['file_images'] : '';
	$Images = '';
	$firstImage = '';
	
	if(isset($_POST['txtid'])){
		if($txt_images !== ''){
			foreach ($_POST['txt_images'] as $k => $val) {
				$n = count($obj_images);
				$obj_images[$n]['url'] = addslashes($val);
				$obj_images[$n]['alt'] = $_POST['txt_alt'][$k];
				$obj_images[$n]['order'] = isset($_POST['image_order'][$k]) ? (int)$_POST['image_order'][$k] : 0;
			}
		}

		// Re-sort an array's element by one of their element
		usort(
		    $obj_images,
		    function ($a, $b) {
		        if ($a['order'] == $b['order']) {
		            return 0;
		        }
		        return ($a['order'] < $b['order']) ? -1 : 1;
		    }
		);

		$firstImage = isset($obj_images[0]['url']) ? $obj_images[0]['url'] : '';
		$Images = json_encode($obj_images, JSON_UNESCAPED_UNICODE);
	}else{
		$total = count($_FILES['file_images']['name']);
		if($total > 0){
			/* Create folder inside images folder */
			$un_name = un_unicode($_POST['txt_name']);
			$folder_image_path = $cur_dir.$un_name;
			createFolder($folder_image_path);

			for( $i=0 ; $i < $total ; $i++ ) {
				$tmpFilePath = $_FILES['file_images']['tmp_name'][$i];
				if ($tmpFilePath != ""){
					$newFilePath = $folder_image_path.'/';
					$objmedia->setPath($newFilePath);
					$image_name = $objmedia->UploadFiles("file_images", $i, $newFilePath);

					/* Add image path to object */
					$obj_fileImages[$i]['url'] = ROOTHOST.'images/'.$un_name.'/'.$image_name;
					$obj_fileImages[$i]['alt'] = '';
					$obj_fileImages[$i]['order'] = '';
				}
			}
		}

		$firstImage = isset($obj_fileImages[0]['url']) ? $obj_fileImages[0]['url'] : '';
		$Images = json_encode($obj_fileImages, JSON_UNESCAPED_UNICODE);
	}

	$Title 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$UnCode 		= un_unicode($_POST['txt_name']);
	$Intro 			= isset($_POST['txt_intro']) ? addslashes($_POST['txt_intro']) : '';
	$Content 		= isset($_POST['txt_content']) ? addslashes($_POST['txt_content']) : '';
	$Schedule 		= isset($_POST['txt_schedule']) ? addslashes($_POST['txt_schedule']) : '';
	$Policy 		= isset($_POST['txt_policy']) ? addslashes($_POST['txt_policy']) : '';
	
	$Code 			= isset($_POST['txt_code']) ? addslashes($_POST['txt_code']) : '';
	$Price1 		= isset($_POST['txt_price1']) ? (int)str_replace(',','', $_POST['txt_price1']) : 0;
	$Price2 		= isset($_POST['txt_price2']) ? (int)str_replace(',','', $_POST['txt_price2']) : 0;
	$PlaceId 		= isset($_POST['cbo_place']) ? (int)$_POST['cbo_place'] : 0;
	$Days 			= isset($_POST['cbo_days']) ? addslashes($_POST['cbo_days']) : '';
	$Vehicle		= isset($_POST['txt_vehicle']) ? addslashes($_POST['txt_vehicle']) : '';
	$NumberOfHoles	= isset($_POST['txt_number_of_holes']) ? (int)$_POST['txt_number_of_holes'] : 0;
	$StartingGate	= isset($_POST['txt_starting_gate']) ? addslashes($_POST['txt_starting_gate']) : '';
	$Departure 		= isset($_POST['txt_departure']) ? strtotime($_POST['txt_departure']) : '';
	$Author 		= $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['username'];
	$isActive 		= isset($_POST['opt_isactive']) ? (int)$_POST['opt_isactive'] : 0;
	$isHot 			= isset($_POST['opt_ishot']) ? (int)$_POST['opt_ishot'] : 0;
	$isHot 			= isset($_POST['opt_ishot']) ? (int)$_POST['opt_ishot'] : 0;
	$tour_price 	= isset($_POST['txt_tour_price']) ? (int)$_POST['txt_tour_price'] : 0;
	$hobby 			= isset($_POST['txt_hobby']) ? (int)$_POST['txt_hobby'] : 0;

	$Cdate 			= time();
	$Meta_title 	= isset($_POST['txt_metatitle']) ? addslashes(htmlentities($_POST['txt_metatitle'])) : '';
	$Meta_key 		= isset($_POST['txt_metakey']) ? addslashes(htmlentities($_POST['txt_metakey'])) : '';
	$Meta_desc 		= isset($_POST['txt_metadesc']) ? addslashes(htmlentities($_POST['txt_metadesc'])) : '';
	$seo_link 		= isset($_POST['txt_seo_link']) ? $_POST['txt_seo_link'] : '';
	$Link 			= ROOTHOST.'tour/'.$UnCode;

	if(isset($_POST['txtid'])){
		$Mdate = time();
		$ID = $_POST['txtid'];

		$objmysql->Query("BEGIN");
		$sql = "UPDATE tbl_tour SET 
		`name` 		= '".$Title."', 
		`un_name` 	= '".$UnCode."',
		`code` 		= '".$Code."',
		`place_id` 	= '".$PlaceId."',
		`intro` 	= '".$Intro."',
		`content` 	= '".$Content."',
		`schedule` 	= '".$Schedule."',
		`policy` 	= '".$Policy."',
		`images` 	= '".$Images."',
		`price1` 	= '".$Price1."',
		`price2` 	= '".$Price2."',

		`starting_gate` 	= '".$StartingGate."',
		`departure` 		= '".$Departure."',
		`days` 				= '".$Days."',
		`vehicle`			= '".$Vehicle."',
		`number_of_holes` 	= '".$NumberOfHoles."',

		`mdate` 	= '".$Mdate."',
		`author` 	= '".$Author."',
		`ishot` 	= '".$isHot."',
		`isactive` 	= '".$isActive."',

		`price_range` = '".$tour_price."',
		`hobby` 	= '".$hobby."'
		WHERE `id` 	= '".$ID."'";
		$result = $objmysql->Exec($sql); 

		$sql2 = "UPDATE tbl_seo SET 
		`title` = '".$Title."', 
		`link` = '".$Link."',
		`image` = '".$firstImage."',
		`meta_title` = '".$Meta_title."',
		`meta_key` = '".$Meta_key."',
		`meta_desc` = '".$Meta_desc."'
		WHERE `link` = '".$seo_link."'";
		$result2 = $objmysql->Exec($sql2);  

		if($result && $result2){
			$objmysql->Exec('COMMIT');
			$_SESSION['flash'.'com_'.COMS] = 1;
		}
		else{
			$objmysql->Exec('ROLLBACK');
			$_SESSION['flash'.'com_'.COMS] = 0;
		}
	}else{
		$objmysql->Exec("BEGIN");
		$sql = "INSERT INTO tbl_tour (`name`, `un_name`, `code`, `place_id`, `intro`, `content`, `schedule`, `policy`, `images`, `price1`, `price2`, `starting_gate`, `departure`, `days`, `vehicle`, `number_of_holes`, `cdate`, `author`, `ishot`, `isactive`, `price_range`, `hobby`) 
		VALUES ('".$Title."', '".$UnCode."', '".$Code."', '".$PlaceId."', '".$Intro."', '".$Content."', 
		'".$Schedule."', '".$Policy."', '$Images', '".$Price1."','".$Price2."'
		, '".$StartingGate."', '".$Departure."', '".$Days."', '".$Vehicle."', '".$NumberOfHoles."', '".$Cdate."', '".$Author."', '".$isHot."', '".$isActive."', '".$tour_price."', '".$hobby."')";
		$result = $objmysql->Exec($sql); 

		$sql2 = "INSERT INTO tbl_seo (`title`,`link`,`image`,`meta_title`,`meta_key`,`meta_desc`) 
		VALUES ('".$Title."','".$Link."','".$firstImage."','".$Meta_title."','".$Meta_key."','".$Meta_desc."')";
		$result2 = $objmysql->Exec($sql2); 

		if($result && $result2){
			$objmysql->Exec('COMMIT');
			$_SESSION['flash'.'com_'.COMS] = 1;
		}else{
			$objmysql->Exec('ROLLBACK');
			$_SESSION['flash'.'com_'.COMS] = 0;
		}
	}
	// echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

if(isset($_POST["txtaction"]) && $_POST["txtaction"]!=""){
	$ids=trim($_POST["txtids"]);
	if($ids!='')
		$ids = substr($ids,0,strlen($ids)-1);
	$ids=str_replace(",","','",$ids);
	switch ($_POST["txtaction"]){
		case "public": 
			$sql_active = "UPDATE `tbl_tour` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_tour` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
			$sql = "SELECT * FROM tbl_tour WHERE id in ('$ids')";
			$objmysql->Query($sql);
			$seo_links = array();

			while ( $row = $objmysql->Fetch_Assoc() ) {
				$seo_link = ROOTHOST.'tour/'.$row['code'];
				array_push($seo_links, $seo_link);

				$sql_del = "DELETE FROM `tbl_tour` WHERE `id` in ('$ids')";
				$objdata->Exec($sql_del);
			}

			foreach ($seo_links as $key => $value) {
				$sql_del1 = "DELETE FROM `tbl_seo` WHERE `link` = '".$value."'";
				$objmysql->Exec($sql_del1);
			}
	        break;
		case 'order':
			$sls = explode(',',$_POST['txtorders']); 
			$ids = explode(',',$_POST['txtids']);
			$n = count($ids);
			for($i=0;$i<$n;$i++){
				$sql_order = "UPDATE `tbl_tour` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
				$objmysql->Exec($sql_order);
			}
	}
	echo "<script language=\"javascript\">window.location='".ROOTHOST_ADMIN.COMS."'</script>";
}

$task='';
if(isset($_GET['task'])) $task=$_GET['task'];
if(!is_file(THIS_COM_PATH.'task/'.$task.'.php')){
	$task='list';
}
include_once(THIS_COM_PATH.'task/'.$task.'.php');
unset($obj); unset($task);	unset($objlang); unset($ids);
?>

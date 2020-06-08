<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('COMS','contents');
define('THIS_COM_PATH',COM_PATH.'com_'.COMS.'/');

require_once('libs/cls.category.php');
require_once('libs/cls.place.php');
require_once('extensions/cls.upload.php');
$obj_cate 	= new CLS_CATEGORY();
$obj_place 	= new CLS_PLACE();
$objmysql 	= new CLS_MYSQL();
$objmedia 	= new CLS_UPLOAD();
$cur_dir 	= '../images/';
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

function createFolder($path){
    if(!is_dir($path)){
		mkdir($path, 0777);
	}
}

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

	$CategoryID 	= isset($_POST['cbo_cata']) ? (int)$_POST['cbo_cata'] : 0;
	$isActive 		= isset($_POST['opt_isactive']) ? (int)$_POST['opt_isactive'] : 0;
	$isHot 			= isset($_POST['opt_ishot']) ? (int)$_POST['opt_ishot'] : 0;
	$Title 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$Code 			= un_unicode($_POST['txt_name']);
	$Author 		= $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['username'];
	$Sapo 			= isset($_POST['txt_sapo']) ? addslashes(htmlentities($_POST['txt_sapo'])) : '';
	$Intro 			= isset($_POST['txt_intro']) ? addslashes($_POST['txt_intro']) : '';
	$Fulltext 		= isset($_POST['txt_fulltext']) ? addslashes($_POST['txt_fulltext']) : '';
	$Thumb 			= isset($_POST['txtthumb']) ? addslashes($_POST['txtthumb']) : '';
	$date 			= time();
	$Cbo_tour 		= isset($_POST['cbo_tour']) ? $_POST['cbo_tour'] : array();
	$Cbo_place 		= isset($_POST['cbo_place']) ? $_POST['cbo_place'] : array();

	// var_dump($_POST);

	$Meta_title 	= isset($_POST['txt_metatitle']) ? addslashes(htmlentities($_POST['txt_metatitle'])) : '';
	$Meta_key 		= isset($_POST['txt_metakey']) ? addslashes(htmlentities($_POST['txt_metakey'])) : '';
	$Meta_desc 		= isset($_POST['txt_metadesc']) ? addslashes(htmlentities($_POST['txt_metadesc'])) : '';
	$seo_link 		= isset($_POST['txt_seo_link']) ? $_POST['txt_seo_link'] : '';

	$sql_cate 		= "SELECT * FROM tbl_categories WHERE id = ".$CategoryID;
	$objmysql->Query($sql_cate);
	$r_cate 		= $objmysql->Fetch_Assoc();
	$Link 			= ROOTHOST.'bai-viet/'.$Code;

	if(isset($_POST['txtid'])){
		$Mdate = $date;
		$ID = $_POST['txtid'];

		$objmysql->Query("BEGIN");
		$sql = "UPDATE tbl_contents SET 
		`category_id` = '".$CategoryID."', 
		`code` 		= '".$Code."',
		`thumb` 	= '".$Thumb."',
		`images` 	= '".$Images."',
		`mdate` 	= '".$Mdate."',
		`author` 	= '".$Author."',
		`ishot` 	= '".$isHot."',
		`isactive` 	= '".$isActive."',
		`title` 	= '".$Title."',
		`intro` 	= '".$Intro."',
		`sapo` 		= '".$Sapo."',
		`fulltext` 	= '".$Fulltext."'
		WHERE `id` 	= '".$ID."'";
		$result = $objmysql->Exec($sql);
		$last_content = $ID;

		$sql2 = "UPDATE tbl_seo SET 
		`title` = '".$Title."', 
		`link` = '".$Link."',
		`image` = '".$Thumb."',
		`meta_title` = '".$Meta_title."',
		`meta_key` = '".$Meta_key."',
		`meta_desc` = '".$Meta_desc."'
		WHERE `link` = '".$seo_link."'";
		$result2 = $objmysql->Exec($sql2);

		$n_tour 	= count($Cbo_tour);
		$n_place 	= count($Cbo_place);
		// Update tbl_tour_content
		if($n_tour > 0){
			// Delete all record with con_id equal last insert content
			$objmysql->Exec("DELETE FROM tbl_tour_content WHERE con_id =".$last_content);

			// Loop array tour id to insert to tbl_tour_content
			for ($i=0; $i < $n_tour; $i++) { 
				$objmysql->Exec("INSERT INTO tbl_tour_content (`con_id`, `tour_id`) VALUES (".$last_content.", ".$Cbo_tour[$i].")");
			}
		}
		// Update tbl_place_content
		if($n_place > 0){
			// Delete all record with con_id equal last insert content
			$objmysql->Exec("DELETE FROM tbl_place_content WHERE con_id =".$last_content);

			// Loop array tour id to insert to tbl_place_content
			for ($i=0; $i < $n_place; $i++) { 
				$objmysql->Exec("INSERT INTO tbl_place_content (`con_id`, `place_id`) VALUES (".$last_content.", ".$Cbo_place[$i].")");
			}
		}

		if($result && $result2){
			$objmysql->Exec('COMMIT');
			$_SESSION['flash'.'com_'.COMS] = 1;
		}else{
			$objmysql->Exec('ROLLBACK');
			$_SESSION['flash'.'com_'.COMS] = 0;
		}
	}else{
		$Cdate = $date;

		$objmysql->Exec("BEGIN");
		$sql = "INSERT INTO tbl_contents (`category_id`,`code`,`thumb`,`images`,`cdate`,`author`,`ishot`,`isactive`,`title`,`sapo`,`intro`,`fulltext`) VALUES ('".$CategoryID."','".$Code."','".$Thumb."','$Images','".$Cdate."','".$Author."','".$isHot."','".$isActive."','".$Title."','".$Sapo."', '".$Intro."', '".$Fulltext."')";
		$result = $objmysql->Exec($sql);
		$last_content = $objmysql->LastInsertID();

		$sql2 = "INSERT INTO tbl_seo (`title`,`link`,`image`,`meta_title`,`meta_key`,`meta_desc`) VALUES ('".$Title."','".$Link."','".$Thumb."','".$Meta_title."','".$Meta_key."','".$Meta_desc."')";
		$result2 = $objmysql->Exec($sql2);

		$n_tour 	= count($Cbo_tour);
		$n_place 	= count($Cbo_place);

		// Update tbl_tour_content
		if($n_tour > 0){
			// Delete all record with con_id equal last insert content
			$objmysql->Exec("DELETE * FROM tbl_tour_content WHERE con_id =".$last_content);

			// Loop array tour id to insert to tbl_tour_content
			for ($i=0; $i < $n_tour; $i++) { 
				$objmysql->Exec("INSERT INTO tbl_tour_content (`con_id`, `tour_id`) VALUES (".$last_content.", ".$Cbo_tour[$i].")");
			}
		}

		// Update tbl_place_content
		if($n_place > 0){
			// Delete all record with con_id equal last insert content
			$objmysql->Exec("DELETE * FROM tbl_place_content WHERE con_id =".$last_content);

			// Loop array tour id to insert to tbl_place_content
			for ($i=0; $i < $n_place; $i++) { 
				$objmysql->Exec("INSERT INTO tbl_place_content (`con_id`, `place_id`) VALUES (".$last_content.", ".$Cbo_place[$i].")");
			}
		}

		if($result && $result2){
			$_SESSION['flash'.'com_'.COMS] = 1;
			// $objmysql->Exec('COMMIT');
			$objmysql->Exec('ROLLBACK');
		}else{
			$_SESSION['flash'.'com_'.COMS] = 0;
			$objmysql->Exec('ROLLBACK');
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
			$sql_active = "UPDATE `tbl_contents` SET `isactive`='1' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_active);
			break;
		case "unpublic":
			$sql_unactive = "UPDATE `tbl_contents` SET `isactive`='0' WHERE `id` in ('$ids')";
			$objmysql->Exec($sql_unactive);
			break;
		case "delete":
	        $sql = "SELECT * FROM tbl_contents WHERE id in ('$ids')";
			$objmysql->Query($sql);
			$seo_links = array();

			while ( $row = $objmysql->Fetch_Assoc() ) {
				$seo_link = ROOTHOST.'bai-viet/'.$row['code'];
				array_push($seo_links, $seo_link);

				$sql_del = "DELETE FROM `tbl_contents` WHERE `id` in ('$ids')";
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
				$sql_order = "UPDATE `tbl_contents` SET `order`='".$sls[$i]."' WHERE `id` = '".$ids[$i]."' ";
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
unset($obj); unset($task); unset($ids);
?>

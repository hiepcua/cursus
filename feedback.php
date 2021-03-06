<?php
ob_start();
session_start();
ini_set('display_errors',1);
define('incl_path','global/libs/');
define('libs_path','libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
require_once libs_path."cls.upload.php";
$obj_upload = new CLS_UPLOAD();

if(isset($_POST['emailaddress']) && $_POST['emailaddress']!==''){
	$arr = array();
	if(isset($_FILES['file_image']) && $_FILES['file_image']['size'] > 0){
		$save_path 	= "images/feedback/";
		$obj_upload->setPath($save_path);
		$file = $obj_upload->UploadFile("file_image", $save_path);
	}else{
		$file = '';
	}
	$arr['email'] = antiData($_POST['emailaddress']);
	$arr['comment'] = isset($_POST['description']) ? antiData($_POST['description']) : '';
	$arr['image'] = $file;
	SysAdd('tbl_feedback', $arr);
	echo "<script>alert('Send feedback success!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">	
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=9">
		<meta name="description" content="Gambolthemes">
		<meta name="author" content="Gambolthemes">		
		<title>Ecohub - Feedback</title>
		
		<!-- Favicon Icon -->
		<link rel="icon" type="image/png" href="images/fav.png">
		
		<!-- Stylesheets -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,500' rel='stylesheet'>
		<link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
		<link href="css/vertical-responsive-menu.min.css" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet">
		<link href="css/responsive.css" rel="stylesheet">
		<link href="css/night-mode.css" rel="stylesheet">
		
		<!-- Vendor Stylesheets -->
		<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
		<link href="vendor/OwlCarousel/assets/owl.carousel.css" rel="stylesheet">
		<link href="vendor/OwlCarousel/assets/owl.theme.default.min.css" rel="stylesheet">
		<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="vendor/semantic/semantic.min.css">		
		
	</head>

<body>
	<!-- Header Start -->
	<?php include_once 'layouts/header.php'; ?>
	<!-- Header End -->
	<!-- Left Sidebar Start -->
	<?php include_once 'layouts/left_sidebar.php'; ?>
	<!-- Left Sidebar End -->
	<!-- Body Start -->
	<div class="wrapper">
		<div class="sa4d25">
			<div class="container-fluid">
				<form id="frm_feedback" method="post" action="" enctype="multipart/form-data">
					<div class="row">
						<div class="col-lg-12">
							<h2 class="st_title"><i class="uil uil-comment-info-alt"></i> Send Feedback</h2>
							<div class="row">
								<div class="col-lg-6 col-md-8">
									<div class="ui search focus">
										<div class="ui left icon input swdh11 swdh19">
											<input class="prompt srch_explore" type="email" name="emailaddress" value="" id="id_email" required="" maxlength="64" placeholder="Email address">															
										</div>
									</div>
									<div class="ui search focus mt-30">																
										<div class="ui form swdh30">
											<div class="field">
												<textarea rows="6" name="description" id="id_about" placeholder="Describe your issue or share your ideas" required=""></textarea>
											</div>
										</div>
									</div>
									<div class="form-group1 mt-30">
										<label for="file5">Add Screenshots</label>
										<div class="image-upload-wrap">
											<input class="file-upload-input" id="file5" name="file_image" type="file" onchange="readURL(this);" accept="image/*">
											<div class="drag-text">
											  <i class="fas fa-cloud-upload-alt"></i>
											  <h4>Select screenshots to upload</h4>
											  <p>or drag and drop screenshots</p>
											</div>
										</div>															
									</div>
									<button class="save_btn" onclick="validFrmFeeback()" type="submit">Send Feedback</button>
								</div>
							</div>						
						</div>						
					</div>
				</form>
			</div>
		</div>
		<?php include_once 'layouts/footer.php'; ?>
	</div>
	<!-- Body End -->

	<script src="js/vertical-responsive-menu.min.js"></script>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/OwlCarousel/owl.carousel.js"></script>
	<script src="vendor/semantic/semantic.min.js"></script>
	<script src="js/custom.js"></script>
	<script src="js/night-mode.js"></script>
	<script type="text/javascript">
		function validFrmFeeback(){
			var flag = true;
			var email = $('#id_email').val();
			var about = $('#id_about').val();

			if(email=='' || about ==''){
				flag=false;
				alert('Email address or description your issue may not be blank.');
			}
			return flag;
		}
	</script>
</body>
</html>
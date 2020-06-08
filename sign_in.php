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
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">		
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, shrink-to-fit=9">
		<meta name="description" content="Gambolthemes">
		<meta name="author" content="Gambolthemes">
		<title>Cursus - Sign In</title>
		
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
	<!-- Signup Start -->
	<div class="sign_in_up_bg">
		<div class="container">
			<div class="row justify-content-lg-center justify-content-md-center">
				<div class="col-lg-12">
					<div class="main_logo25" id="logo">
						<a href="home"><img src="images/logo.svg" alt=""></a>
						<a href="home"><img class="logo-inverse" src="images/ct_logo.svg" alt=""></a>
					</div>
				</div>
			
				<div class="col-lg-6 col-md-8">
					<div class="sign_form">
						<h2>Welcome Back</h2>
						<p>Log In to Your Account!</p>
						<div class="mess" style="color: red"></div>
						<!-- <button class="social_lnk_btn color_btn_fb"><i class="uil uil-facebook-f"></i>Continue with Facebook</button>
						<button class="social_lnk_btn mt-15 color_btn_tw"><i class="uil uil-twitter"></i>Continue with Twitter</button>
						<button class="social_lnk_btn mt-15 color_btn_go"><i class="uil uil-google"></i>Continue with Google</button> -->
						<form id="frm_sign_in" onsubmit="return ajax_login()" method="post" action="">
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh95">
									<input class="prompt srch_explore" type="email" name="txt_email" value="" id="txt_email" required="" maxlength="64" placeholder="Email Address">
									<i class="uil uil-envelope icon icon2"></i>
								</div>
							</div>
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh95">
									<input class="prompt srch_explore" type="password" name="txt_pass" value="" id="txt_pass" required="" maxlength="64" placeholder="Password">
									<i class="uil uil-key-skeleton-alt icon icon2"></i>
								</div>
							</div>
							<div class="ui form mt-30 checkbox_sign">
								<div class="inline field">
									<div class="ui checkbox mncheck">
										<input type="checkbox" name="" id="remember" tabindex="0" class="hidden">
										<label>Remember Me</label>
									</div>
								</div>
							</div>
							<button class="login-btn" onclick="return validFromSignIn()" type="submit">Sign In</button>
						</form>
						<p class="sgntrm145">Or <a href="forgot_password">Forgot Password</a>.</p>
						<p class="mb-0 mt-30 hvsng145">Don't have an account? <a href="sign_up">Sign Up</a></p>
					</div>
					<div class="sign_footer"><img src="images/sign_logo.png" alt="">© 2020 <strong>Cursus</strong>. All Rights Reserved.</div>
				</div>				
			</div>				
		</div>				
	</div>
	<!-- Signup End -->	

	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="vendor/OwlCarousel/owl.carousel.js"></script>
	<script src="vendor/semantic/semantic.min.js"></script>
	<script src="js/custom.js"></script>	
	<script src="js/night-mode.js"></script>	
	<script type="text/javascript">
		function validFromSignIn(){
			var flag = true;
			var email = $('#txt_email').val();
			var pass = $('#txt_pass').val();

			if(email == '' || pass == '' || email == undefined || pass == undefined){
				flag = false;
				$('.mess').html('Email address or password is empty!');
			}
			return flag;
		};

		function ajax_login(){
            var checked=$('#remember').is(':checked')?"yes":"no";
            var _url='<?php echo ROOTHOST;?>ajaxs/mem/login.php';
            var _data={'user':$('#txt_email').val(),'pass':$('#txt_pass').val(),'remember':checked}
            $.post(_url,_data,function(req){
                if(req=='success') window.location.href="<?php echo ROOTHOST;?>";
                else $('.mess').html(req);
            });
            return false;
        }
	</script>
</body>
</html>
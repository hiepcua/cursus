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
	<title>Cursus - Sign Up</title>

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
						<h2>Welcome to Edututs+</h2>
						<p>Sign Up and Start Learning!</p>
						<div class="mess" style="color: red"></div>
						<form onsubmit="return ajax_signUp();">
							<div class="ui search focus">
								<div class="ui left icon input swdh11 swdh19">
									<input class="prompt srch_explore" type="text" name="fullname" value="" id="id_fullname" required="" maxlength="64" placeholder="Full Name">															
								</div>
							</div>
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh11 swdh19">
									<input class="prompt srch_explore" type="email" name="emailaddress" value="" id="id_email" required="" maxlength="64" placeholder="Email Address">															
								</div>
							</div>
							<div class="ui search focus mt-15">
								<div class="ui left icon input swdh11 swdh19">
									<input class="prompt srch_explore" type="password" name="password" value="" id="id_password" required="" maxlength="64" placeholder="Password">															
								</div>
							</div>
							<div class="ui form mt-30 checkbox_sign">
								<div class="inline field">
									<div class="ui checkbox mncheck">
										<input type="checkbox" tabindex="0" class="hidden">
										<label>I’m in for emails with exciting discounts and personalized recommendations</label>
									</div>
								</div>
							</div>
							<button class="login-btn" onclick="return validFromSignUp()" type="submit">Next</button>
						</form>
						<p class="sgntrm145">By signing up, you agree to our <a href="terms_of_use.html">Terms of Use</a> and <a href="terms_of_use.html">Privacy Policy</a>.</p>
						<p class="mb-0 mt-30">Already have an account? <a href="sign_in">Log In</a></p>
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
		function validFromSignUp(){
			var flag = true;
			var email = $('#id_email').val();
			var pass = $('#id_password').val();
			var fullname = $('#id_fullname').val();

			if(email == '' || pass == '' || fullname == '' || email == undefined || pass == undefined || fullname == undefined){
				flag = false;
				$('.mess').html('Fullname, Email address and password is empty!');
			}
			return flag;
		};

		function ajax_signUp(){
			var name = $('#id_fullname').val();
			var email = $('#id_email').val();
			var pass = $('#id_password').val();

			var _url='<?php echo ROOTHOST;?>ajaxs/mem/sign_up.php';
			var _data={
				'name': name,
				'email': email,
				'pass':pass,
			}

			$.post(_url, _data, function(req){
				console.log(req);
				if(req=='success'){
					alert('Sign up success!');
				}else{
					$('.mess').html(req);
				}
			});
			return false;
		};
	</script>
</body>
</html>
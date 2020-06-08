<?php
defined('ISHOME') or die("Can't acess this page, please come back!");
$err=$username=$password='';
if(isset($_POST['txtuser'])){
	$user=addslashes($_POST['txtuser']);
	$pass=addslashes($_POST['txtpass']);
	// $serc=addslashes($_POST['txt_sercurity']); 
	// if($_SESSION['SERCURITY_CODE']!=$serc)
	// 	$err='<font color="red">Mã bảo mật không chính xác</font>';
	// else{
	global $UserLogin;
	if($UserLogin->LOGIN($user, $pass)==true){
		if(!empty($_POST["remember"])) {
			setcookie ("member_login", $_POST["txtuser"], time()+ (1 * 24 * 60 * 60));
		} else {
			if(isset($_COOKIE["member_login"])) {
				setcookie ("member_login","");
			}
		}
		echo '<script language="javascript">window.location.href="index.php"</script>';
	}else{
		$err='<font color="red">Đăng nhập không thành công.</font>';
	}
}
?>
<style type="text/css">
	@import url("//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css");
	.login-block{
		background: #DE6262;  /* fallback for old browsers */
		background: -webkit-linear-gradient(to bottom, #FFB88C, #DE6262);  /* Chrome 10-25, Safari 5.1-6 */
		background: linear-gradient(to bottom, #FFB88C, #DE6262); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
		float:left;
		width:100%;
		padding : 50px 0;
	}
	.banner-sec{background:url(https://static.pexels.com/photos/33972/pexels-photo.jpg)  no-repeat left bottom; background-size:cover; min-height:500px; border-radius: 0 10px 10px 0; padding:0;}
	.container{background:#fff; border-radius: 10px; box-shadow:15px 20px 0px rgba(0,0,0,0.1);}
	.carousel-inner{border-radius:0 10px 10px 0;}
	.carousel-caption{text-align:left; left:5%;}
	.login-sec{padding: 50px 30px; position:relative;}
	.login-sec .copy-text{position:absolute; width:80%; bottom:20px; font-size:13px; text-align:center;}
	.login-sec .copy-text i{color:#FEB58A;}
	.login-sec .copy-text a{color:#E36262;}
	.login-sec h2{margin-bottom:30px; font-weight:800; font-size:30px; color: #DE6262;}
	.login-sec h2:after{content:" "; width:100px; height:5px; background:#FEB58A; display:block; margin-top:20px; border-radius:3px; margin-left:auto;margin-right:auto}
	.btn-login{background: #DE6262; color:#fff; font-weight:600;}
	.banner-text{width:70%; position:absolute; bottom:40px; padding-left:20px;}
	.banner-text h2{color:#fff; font-weight:600;}
	.banner-text h2:after{content:" "; width:100px; height:5px; background:#FFF; display:block; margin-top:20px; border-radius:3px;}
	.banner-text p{color:#fff;}
</style>

<!------ Include the above in your HEAD tag ---------->
<section class="login-block">
	<div class="container">
		<div class="row">
			<div class="col-md-4 login-sec">
				<h2 class="text-center">Đăng nhập</h2>
				<div class="form-group text-center" style="color:red"><b><?php echo $err;?></b></div>
				<form id="frmlogin" class="login-form" method="post" action="" autocomplete="off">
					<div class="form-group">
						<label class="text-uppercase">Tên đăng nhập</label>
						<input type="text" name="txtuser" class="form-control" required>
					</div>
					<div class="form-group">
						<label class="text-uppercase">Mật khẩu</label>
						<input type="password" name="txtpass" class="form-control" required>
					</div>
					<div class="form-check">
						<!-- <label class="form-check-label">
							<input type="checkbox" class="form-check-input" name="remember">
							<small>Giữ đăng nhập</small>
						</label> -->
						<button type="submit" class="btn btn-login float-right">Đăng nhập</button>
					</div>
				</form>
			</div>
			<div class="col-md-8 banner-sec">
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
					<div class="carousel-inner" role="listbox">
						<div class="carousel-item active">
							<img class="d-block img-fluid" src="https://static.pexels.com/photos/33972/pexels-photo.jpg" alt="First slide">
							<div class="carousel-caption d-none d-md-block">
								<div class="banner-text">
									<h2>CMS - Admin</h2>
									<p>Hệ thống quản trị nội dung nhằm mục đích giúp dễ dàng quản lý, chỉnh sửa nội dung</p>
								</div>	
							</div>
						</div>
					</div>	   
				</div>
			</div>
		</div>
	</div>
</section>
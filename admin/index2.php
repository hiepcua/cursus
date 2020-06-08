<?php
session_start();
define("ISHOME",true);
if(!isset($_SESSION['LANGUAGE_ADMIN'])) $_SESSION['LANGUAGE_ADMIN']='0';
require_once("../global/libs//gfinit.php");
require_once("../global/libs/gfconfig.php");
require_once("../global/libs/gffunc.php");
require_once("includes/gfconfig.php");
require_once("libs/cls.mysqli.php");
require_once("libs/cls.user.php");
// require_once("libs/cls.menu.php");
require_once("libs/cls.category.php");
$UserLogin = new CLS_USER();
global $UserLogin;
?>
<!DOCTYPE html>
<html language='vi'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="robots" content="noindex,nofollow" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ADMIN CMS</title>
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/bootstrap.min.css" type="text/css" media="all" />
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/font-awesome.min.css" type="text/css" media="all" >
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/select2.min.css" type="text/css" media="all" >
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/bootstrap-multiselect.css" type="text/css" media="all" >
	<link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/bootstrap-datetimepicker.min.css" type="text/css" media="all" >
	<!-- <link href="<?php echo ROOTHOST_ADMIN;?>css/AdminLTE.min.css" type="text/css" rel="stylesheet"> -->
	<link rel="stylesheet" href="<?php echo ROOTHOST_ADMIN;?>css/style.min.css?v=1" type="text/css" />
	<link rel="stylesheet" href="<?php echo ROOTHOST_ADMIN;?>css/style.responsive.min.css?v=1" type="text/css" />
	<script src="<?php echo ROOTHOST;?>global/js/jquery-1.11.2.min.js"></script>
	<script src="<?php echo ROOTHOST;?>global/js/bootstrap.min.js"></script>
	<script src="<?php echo ROOTHOST;?>global/js/select2.min.js"></script>
	<script src="<?php echo ROOTHOST;?>global/js/bootstrap-multiselect.js"></script>
	<script src="<?php echo ROOTHOST;?>global/js/moment.js"></script>
	<script src="<?php echo ROOTHOST;?>global/js/bootstrap-datetimepicker.min.js"></script>
	<script src="<?php echo ROOTHOST_ADMIN;?>js/script.min.js"></script>
	<script src="https://cdn.tiny.cloud/1/tyij6tzxb68u5hiflnrk17fl3zubd73o6ks0bi9noofyypiy/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

	<script>	
		var _w=0;
		$(document).ready(function(){
			_h1=$('#left_sidebar').height();
			_h2=$('#list_content').height();
			var _h=_h1;
			if(_h1<_h2) _h=_h2;
			$('.body_body').css({'min-height':(_h)+'px'})
			$('#left_sidebar').css({'min-height':(_h)+'px'})
		})
		function showMess(mess,type){
			var _title='';var _html="";
			switch(type){
				case 'error': 
				_title="<span>Lỗi</span>"; 
				_html="<p class='alert alert-danger'>"+mess+"</p>";
				break;
				case 'alert': 
				_title="<span>Cảnh báo</span>"; 
				_html="<p class='alert alert-warning'>"+mess+"</p>";
				break;
				default:  
				_title="<span>Thông báo</span>"; 
				_html="<p class='alert alert-info'>"+mess+"</p>";	
				break;
			}
			$('#myModalPopup .modal-dialog').addClass('modal-sm');
			$('#myModalPopup .modal-header .modal-title').html(_title);
			$('#myModalPopup .modal-body').html(_html);
			$('#myModalPopup').modal('show');
		}
	</script>
</head>
<body id="wapper_body" class="wapper_body">
	<div class="wrapper">
		<div id="notification" style="display: none;"></div>
		<?php
		if(!$UserLogin->isLogin()){
			if(isset($_GET['com'])) echo "<script>window.location='".ROOTHOST_ADMIN."'</script>";
			include_once(COM_PATH."com_user/task/login.php");
		}else{
			?>
			<div id="site_header">
				<?php include_once('modules/mod_main_nav/layout.php');?>
				<div class="clearfix"></div>
			</div>
			<div id="wapper">
				<div id="site_body">
					<div class="clearfix"></div>
					<!-- <div class="body_top"></div> -->
					<div class="body_body">
						<?php 
						$com=isset($_GET['com'])?$_GET['com']:'frontpage';
						if(!is_file(COM_PATH.'com_'.$com.'/layout.php')){$com='frontpage';}
						?>
						<div class="component">
							<div class="page-content-wrapper">
								<div class="page-content">
									<?php
									include_once(COM_PATH.'com_'.$com.'/layout.php');
									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
			<div id="myModalPopup" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h3 class="modal-title" id="myModalLabel"></h3>
						</div>
						<div class="modal-body" id="data-frm">
						</div>
					</div>
				</div>
			</div>
			<?php include_once('modules/mod_left_sidebar/layout.php');?>
			<?php 
		} ?>
	</div>
</body>
</html>
<script type="text/javascript">
	$('#language_vi').click(function(){
		var val = $(this).attr('data');
		var url = '<?php echo ROOTHOST_ADMIN;?>ajaxs/change_language.php'
		$.post(url,{'language':val},function(req){})
		window.location='<?php echo ROOTHOST_ADMIN ?>';
	})
	$('#language_en').click(function(){
		var val = $(this).attr('data');
		var url = '<?php echo ROOTHOST_ADMIN;?>ajaxs/change_language.php'
		$.post(url,{'language':val},function(req){})
		window.location='<?php echo ROOTHOST_ADMIN ?>';
	})

	$(document).ready(function(){
		$('#main-sidebar').click(function(){
			$('#wapper_body').toggleClass('slidebar-open');
		})
	})
</script>
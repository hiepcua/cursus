<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../includes/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.user.php");
$objuser=new CLS_USER;
$gid=isset($_GET['id'])?(int)$_GET['id']:0;
if(!$objuser->isLogin()){
	die("E01");
}
$check_permission = $objuser->Permission('user');
if($check_permission==false) die('E02');
?>
<script type="text/javascript" src="<?php echo ROOTHOST_ADMIN;?>js/webcam.js"></script>
<style type="text/css">
	hr{margin-top: 0;margin-bottom: 15px;}
	label.title{font-size: 16px;font-weight: 500;}
	#results,#my_camera {
		margin: auto;
		margin-bottom: 10px;
	}
	#results img {
		width: 350px;
		height: 263px;
	}
	.must {
		color: red !important;
	}
	#dt_basic thead th {
		text-align: center;
	}
</style>
<form id="frm-register" class="form-horizontal"  name="frm-register" method="" action="" enctype="multipart/form-data">
	<input type="hidden" class="form-control" id="txt_gid" value="<?php echo $gid;?>">
	<label class="title">Thông tin cá nhân</label><hr/>
	<div class="form-group">
		<div class="col-md-6">
			<label>Họ đệm<small class="cred"> (*)</small></label>
			<input type="text" id="txt_lastname" name="txt_lastname" class="form-control" value="" placeholder="Họ đệm">
			<small id="er0" class="cred"></small>
		</div>
		<div class="col-md-6">
			<label>Tên<small class="cred"> (*)</small></label>
			<input type="text" id="txt_firstname" name="txt_firstname" class="form-control" value="" placeholder="Tên">
			<small id="er1" class="cred"></small>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<label>CMTND<small class="cred"> (*)</small></label>
			<input type="text" id="txt_cmtnd" name="txt_cmtnd" class="form-control" value="" placeholder="Chứng minh thư nhân dân">
			<small id="er7" class="cred"></small>
		</div>
		<div class="col-md-6">
			<label>Ngày sinh</label>
			<input type="date" id="txt_birthday" name="txt_birthday" class="form-control" value="" placeholder="Ngày sinh">
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-6">
			<label>Giới tính</label>
			<div class="radio">
				<label class="radio-inline"><input type="radio" value="0" name="opt_gender" checked>Nam</label>
				<label class="radio-inline"><input type="radio" value="1" name="opt_gender">Nữ</label>
			</div>
		</div>
	</div>
	<br>
	<label class="title">Thông tin tài khoản</label><hr/>
	<div class="form-group">
		<div class="has-success has-feedback col-md-6">
			<label>Username<small class="cred"> (*)</small></label>
			<input type="text" id="txt_username" name="txt_username" class="form-control" value="" placeholder="Tên đăng nhập">
			<span id="user_success"></span>
			<small id="er2" class="cred"></small>
		</div>
		<div class="col-md-6">
			<label>Password<small class="cred"> (*)</small></label>
			<input type="password" id="txt_password" name="txt_password" class="form-control" value="" placeholder="Mật khẩu">
			<small id="er3" class="cred"></small>
		</div>
	</div>
	<br>
	<label class="title">Thông tin liên hệ</label><hr/>
	<div class="form-group">
		<div class="col-md-6">
			<label>Phone<small class="cred"> (*)</small></label>
			<input type="number" id="txt_phone" name="txt_phone" class="form-control" value="" placeholder="Số điện thoại">
			<small id="er5" class="cred"></small>
		</div>
		<div class="col-md-6">
			<label>Email<small class="cred"> (*)</small></label>
			<input type="email" id="txt_email" name="txt_email" class="form-control" value="" placeholder="Email">
			<small id="er6" class="cred"></small>
		</div>
	</div>
	<label>Cơ quan</label>
	<textarea class="form-control" rows="1" id="txt_organ" name="txt_organ" placeholder="Cơ quan công tác"></textarea><br>
	<label>Địa chỉ</label>
	<textarea class="form-control" rows="3" id="txt_address" name="txt_address" placeholder="Địa chỉ của bạn"></textarea>
	<br>
	<div class="clearfix"></div><br>
	<button type="button" class="btn btn-primary" id="cmd_save"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</button>
	<button type="button" class="btn btn-default" id="cmd_cancel"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</button>
</form>
<div class="clearfix"></div>
<script type="text/javascript">
	$(document).ready(function(){
		var flag=1;
		$('#cmd_save').click(function(){
			if(flag==1){
				if(check_validate()==true && checkUserRegisExist()==true) {
					var gid=$('#txt_gid').val()!='undefined'?$('#txt_gid').val():0;
					var data = $('#frm-register').serializeArray();
					data.push( {name:'txt_gid', value:gid} );
					var url='ajaxs/user/process_update_user.php';
					$.post(url,data,function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
						if(req=='E03'){showMess('Không có quyền thêm người dùng cho nhóm này!','error');}
						if(req=='E04'){showMess('Có lỗi trong quá trình thực hiện!','error');}
						else {
							getUserByGroup(gid);
							showMess('Success!','success');
						}
					});
				}
			}else{
				showMess('Tên đăng nhập đã tồn tại!','error');
			}
		});
		$('#cmd_cancel').click(function(){
			$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin người dùng');
			$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
			$('#myModalPopup').modal('hide');
		});
		$('#txt_username').change(function(){
			var username = $(this).val();
			var url ='ajaxs/user/check_isset_username.php';
			$.post(url,{'username':username},function(req){
				if(req=="ERR") {
					flag=0;
					$('#er2').text('Tên đăng nhập đã tồn tại');
				}
				if(req=="SUCCESS"){
					$('#er2').text('');
					$('#user_success').addClass('glyphicon glyphicon-ok form-control-feedback');
					flag=1;
				}
			});
		})
	})
	function getUserByGroup($gid){
		var url='ajaxs/user/getUserByGroup.php';
		$.post(url,{'gid':$gid},function(req){
			$('.user_list .list').html(req);
		});
	}
	function check_validate(){
		if ($('#txt_lastname').val() =='') {
			$('#er0').text('Không được bỏ trống');
			return false;
		}else{
			$('#er0').text('');
		}
		if ($('#txt_firstname').val() =='') {
			$('#er1').text('Không được bỏ trống');
			return false;
		}else{
			$('#er1').text('');
		}
		if ($('#txt_username').val() =='') {
			$('#er2').text('Tên đăng nhập là bắt buộc');
			return false;
		}else{
			$('#er2').text('');
		}
		if ($('#txt_password').val() =='') {
			$('#er3').text('Mật khẩu là bắt buộc');
			return false;
		}
		else{
			$('#er3').text('');
		}
		if ($('#txt_phone').val() =='') {
			$('#er5').text('Không được bỏ trống');
			return false;
		}else{
			$('#er5').text('');
		}
		if ($('#txt_email').val() =='') {
			$('#er6').text('Không được bỏ trống');
			return false;
		}else{
			$('#er6').text('');
		}
		var cmtnd = $('#txt_cmtnd').val().length;
		if (cmtnd<9 || cmtnd>12) {
			$('#er7').text('CMND chỉ cho phép nhập số và có độ dài từ 9 đến 12 số.');
			return false;
		}else{
			$('#er7').text('');
		}
		return true;
	}
	$('#txt_cmtnd').focusout(function(){
		checkUserRegisExist();
	})

	function checkUserRegisExist() {
		var identify = $('#txt_cmtnd').val();
		if(identify) {
			url='ajaxs/user/getUser.php';
			$.post(url,{identify:identify},function($rep){
				var obj = jQuery.parseJSON($rep);		
				if(obj[0]['rep']=='yes') {	
					// user exist 
					$('#er7').html('Số chứng minh nhân dân đã tồn tại.');
					return false;
				} else {
					$('#er7').html("");					
					return true;
				}
			})	
		} else {
			$('#er7').html('CMND chỉ cho phép nhập số và có độ dài từ 9 đến 12 số.');
			$('#txt_cmtnd').val("");
			return false;
		}
		return true;
	}
</script>
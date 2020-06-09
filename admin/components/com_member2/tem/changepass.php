<?php
$user=getInfo('username');
$isAdmin=getInfo('isadmin');
$sql="SELECT * FROM tbl_member WHERE username='".$user."'";
$objmysql = new CLS_MYSQL;
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();
$avatar = getAvatar($row['avatar'], 'avatar mg-thumbnail', '');

if(isset($_POST['cmdsave_tab2'])){
	$Cur_password 	= isset($_POST['current_password']) ? trim(addslashes($_POST['current_password'])) : '';
	$New_password 	= isset($_POST['new_password']) ? trim(addslashes($_POST['new_password'])) : '';
	$Re_password 	= isset($_POST['re_password']) ? trim(addslashes($_POST['re_password'])) : '';

	$pass 			= antiData($Cur_password);
	$pass 			= md5($pass);
	$pass 			= hash('sha256', $user).'|'.hash('sha256', $pass);

	$sql="SELECT `password` FROM tbl_member WHERE username ='".$user."'";
	$objmysql = new CLS_MYSQL;
	$objmysql->Query($sql);
	$r_user = $objmysql->Fetch_Assoc();

	if($pass == $r_user['password']){
		$newPass = hash('sha256',$user).'|'.hash('sha256',md5($New_password));
		$sql="UPDATE `tbl_member` SET `password`='".$newPass."' WHERE `username`='".$user."'";
		$result = $objmysql->Query($sql);
		if($result) $_SESSION['flash'.'com_'.$COM] = 1;
        else $_SESSION['flash'.'com_'.$COM] = 0;
	}else{
		$_SESSION['flash'.'com_'.$COM] = 0;
	}
}
?>
<script type="text/javascript">
	function validate_data(){
		var pass1 = $('#new_password').val();
		var pass1_1 = $('#re_password').val();

		if(pass1 === pass1_1) $('#frm_action').submit();
		else $('.mess').text('Gõ lại mật khẩu không trùng nhau.');
	}
</script>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">CHANGE PASSWORD</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Home</a></li>
					<li class="breadcrumb-item active">Change password</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class='container-fluid'>
		<!-- Main content -->
		<section id="profile" class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-sm-4 col-lg-3">
						<div class="text-center">
							<div class="wrap-avatar">
								<?php echo $avatar;?>
							</div>
						</div>

						<ul class="list-group">
							<li class="list-group-item"><strong>Username:</strong> <div><?php echo $row['username'];?></div></li>
							<li class="list-group-item"><span class="pull-left"><strong>Join:</strong></span> <?php echo date('d-m-Y', $row['cdate']);?></li>
						</ul>
					</div>

					<div class="col-sm-8 col-lg-9">
						<div class="tab-content card">
							<div class="tab-pane container-fluid active" id="seo">
								<form id="frm_action" class="form" action="" method="post">
									<p>
										<?php
										if (isset($_SESSION['flash'.'com_'.$COM])) {
											if($_SESSION['flash'.'com_'.$COM] == 1){
												$msg->success('Cập nhật thành công.');
												echo $msg->display();
											}else if($_SESSION['flash'.'com_'.$COM] == 0){
												$msg->error('Có lỗi trong quá trình cập nhật.');
												echo $msg->display();
											}
											unset($_SESSION['flash'.'com_'.$COM]);
										}
										?>
									</p>
									<div class="mess" style="color: red"></div>
									<div class="form-group">
										<div class="col-xs-6">
											<label>Mật khẩu hiện tại</label>
											<input type="password" class="form-control" name="current_password" id="current_password" placeholder="Mật khẩu hiện tại" title="Mật khẩu hiện tại">
										</div>
									</div>

									<div class="form-group">
										<div class="col-xs-6">
											<label>Mật khẩu mới</label>
											<input type="password" class="form-control" name="new_password" id="new_password" placeholder="Mật khẩu mới" title="Mật khẩu mới">
										</div>
									</div>

									<div class="form-group">
										<div class="col-xs-6">
											<label>Gõ lại mật khẩu mới</label>
											<input type="password" class="form-control" name="re_password" id="re_password" placeholder="Gõ lại mật khẩu mới" title="Gõ lại mật khẩu mới">
										</div>
									</div>

									<div class="text-center toolbar">
										<input type="button" name="cmdsave_tab2" id="cmdsave_tab2" onclick="return validate_data();" class="save btn btn-success" value="Lưu mật khẩu" class="btn btn-primary">
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</section>
<script>
	$(document).ready(function(){
		$('.chk').click(function(){
			var flag=true;
			$('.chk').each(function(){
				if(!$(this).is(':checked')){flag=false; return;}
			});
			if(flag) $('.chk_all').attr('checked',true);
			else $('.chk_all').attr('checked',false);
		});
		$('.chk_all').click(function(){
			var ischeck=$(this).is(':checked');
			$('.chk').attr('checked',ischeck);
		});
		$('.chk_isadmin').click(function(){
			var ischeck=$(this).is(':checked')?'yes':'no';
			if(confirm('You are sure change permission this member?')){
				var _url="<?php echo ROOTHOST;?>ajaxs/mem/change_isadmin.php";
				var _data={
					'user':$(this).val(),
					'ischeck':ischeck
				}
				$.post(_url,_data,function(req){
					/*alert('Change permission success!');*/
					console.log(req);
					window.location.reload();
				})
			}
		});
		$('#btn_add_member').click(function(){
			var _url="<?php echo ROOTHOST;?>ajaxs/mem/frm_add.php";
			$.get(_url,function(req){
				$('#popup_modal .modal-body').html(req);
				$('#popup_modal').modal('show')
			});
		});
	});
</script>

<?php
$user=getInfo('username');
$isAdmin=getInfo('isadmin');
$sql="SELECT * FROM tbl_member WHERE username='".$user."'";
$objmysql = new CLS_MYSQL;
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();
$avatar = getAvatar($row['avatar'], 'avatar img-thumbnail', '');

$file='';
if(isset($_POST['cmdsave_tab1'])){
	if(isset($_FILES['files'])){
		$save_path 	= "global/img/avatar/";
		$obj_upload->setPath($save_path);
		$file = $obj_upload->UploadFile("txt_avatar", $save_path);
		
	}else{
		$file = isset($_POST['txt_avatar2']) ? trim(addslashes($_POST['txt_avatar2'])) : '';
	}

	$Fullname 	= isset($_POST['txtfullname']) ? trim(addslashes($_POST['txtfullname'])) : '';
	$Mobile 	= isset($_POST['txtmobile']) ? trim(addslashes($_POST['txtmobile'])) : '';
	$Email 		= isset($_POST['txtemail']) ? trim(addslashes($_POST['txtemail'])) : '';
	$Cdate 		= time();

	$arr=array('fullname'=>$Fullname, 'phone'=>$Mobile, 'email'=>$Email, 'avatar'=>$file);
	$result = SysEdit('tbl_member', $arr, "username='$user'");
	if($result) $_SESSION['flash'.'com_'.$COM] = 1;
	else $_SESSION['flash'.'com_'.$COM] = 0;
}?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">UPDATE INFOMATION</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Home</a></li>
					<li class="breadcrumb-item active">Update infomation</li>
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
						<div class="box-tabs">
							<!-- Nav tabs -->
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link active" data-toggle="tab" href="#info">Thông tin cá nhân</a>
								</li>
							</ul>
						</div>

						<div class="tab-content card">
							<div class="tab-pane container-fluid active" id="info">
								<form id="frm_action" class="form" action="" method="post" enctype="multipart/form-data">
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
									<div class="row">
										<div class="col-sm-6">
											<div class="form-group">
												<label>Name<small class="cred"> (*)</small><span id="err_firstname" class="mes-error"></span></label>
												<input class="form-control" id="txtfullname" name="txtfullname" value="<?php echo $row['fullname'];?>" type="text" required>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Phone</label>
												<input class="form-control" name="txtmobile" type="tel" id="txtmobile" value="<?php echo $row['phone'];?>"/>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<label>Email</label>
												<input class="form-control" name="txtemail" type="email" id="txtemail" value="<?php echo $row['email'];?>"/>
											</div>
										</div>

										<div class="col-sm-6">
											<div class="form-group">
												<h6>Upload a different photo...</h6>
												<input type="file" name="txt_avatar" value="" class="file-upload">
												<input type="hidden" name="txt_avatar2" value="<?php echo $row['avatar'];?>">
											</div>
										</div>
									</div>

									<div class="text-center toolbar">
										<input type="submit" name="cmdsave_tab1" id="cmdsave_tab1" class="save btn btn-success" value="Lưu thông tin" class="btn btn-primary">
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

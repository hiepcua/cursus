<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$msg=''; $msg2=''; $file='';
$check_permission = $UserLogin->Permission('user');
$id=$obj->getInfo('id');
if(isset($_GET['memid'])) $id=(int)$_GET['memid'];

function base64_to_jpeg($base64_string, $output_file) {
    // open the output file for writing
    $ifp = fopen( $output_file, 'wb' ); 

    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );

    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[ 1 ] ) );

    // clean up the file resource
    fclose( $ifp ); 

    return $output_file; 
}

if(isset($_POST['cmdsave_tab1'])){
	$ID = $id;
	$FirstName 	= isset($_POST['txtfirstname']) ? trim(addslashes($_POST['txtfirstname'])) : '';
	$LastName 	= isset($_POST['txtlastname']) ? trim(addslashes($_POST['txtlastname'])) : '';
	$Address 	= isset($_POST['txtaddress']) ? trim(addslashes($_POST['txtaddress'])) : '';
	$Mobile 	= isset($_POST['txtmobile']) ? trim(addslashes($_POST['txtmobile'])) : '';
	$Email 		= isset($_POST['txtemail']) ? trim(addslashes($_POST['txtemail'])) : '';
	$Gender 	= isset($_POST['optgender']) ? (int)$_POST['txtlastname'] : 0;
	$Gid 		= isset($_POST['cbo_gmember']) ? (int)$_POST['cbo_gmember'] : '';
	$Birthday 	= strtotime($_POST['txtbirthday']);

	if(isset($_FILES)){
		$save_path 	= "images/avatar/";
		$obj_upload->setPath($save_path);
		$file = $obj_upload->UploadFile("txt_avatar", $save_path);
	}

	$sql="UPDATE `tbl_user` SET `firstname`='".$FirstName."',
	`lastname`='".$LastName."',
	`birthday`='".$Birthday."',
	`gender`='".$Gender."',
	`address`='".$Address."',
	`phone`='".$Mobile."',
	`email`='".$Email."',
	`avatar`='".ROOTHOST_ADMIN.$file."',
	`gid`='".$Gid."'";
	$sql.=" WHERE `id`='".$ID."'";
	if($objmysql->Query($sql)) {
		$msg="Cập nhật thành công";
	}
	else $msg="Cập nhật lỗi!";
}

if(isset($_POST['cmdsave_tab2'])){	
	$ID = $id;
	$Cur_password 	= isset($_POST['current_password']) ? trim(addslashes($_POST['current_password'])) : '';
	$New_password 	= isset($_POST['new_password']) ? trim(addslashes($_POST['new_password'])) : '';
	$Re_password 	= isset($_POST['re_password']) ? trim(addslashes($_POST['re_password'])) : '';
	$pass 			= md5(sha1(trim($Cur_password)));

	$sql="SELECT `password` FROM tbl_user WHERE id =".$ID;
	$objmysql->Query($sql);
	$r_user = $objmysql->Fetch_Assoc();
	
	if($pass == $r_user['password']){
		$sql="UPDATE `tbl_user` SET `password`='".md5(sha1(trim($New_password)))."' WHERE `id`='".$ID."'";
		if($objmysql->Query($sql)) $msg="Cập nhật thành công";
		else $msg2="Cập nhật thành công!";
	}else{
		$msg2="Cập nhật lỗi!";
	}
}

$obj->getList(' AND id='.$id);
$row = $obj->Fetch_Assoc();
$avatar = getThumb($row['avatar'], 'avatar img-circle img-thumbnail', '');

// Get info group user
$permistion_name = $obj_guser->getNameById($row['gid']);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">CẬP NHẬT THÔNG TIN CÁ NHÂN</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item active">Cập nhật thông tin cá nhân</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section id="profile" class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-lg-2">
				<div class="text-center">
					<div class="wrap-avatar">
						<?php echo $avatar;?>
					</div>
				</div>

				<ul class="list-group">
					<li class="list-group-item"><strong>Username:</strong> <?php echo $row['username'];?></li>
					<li class="list-group-item"><span class="pull-left"><strong>Permistion:</strong></span> <?php echo $permistion_name;?></li>
					<li class="list-group-item"><span class="pull-left"><strong>Join:</strong></span> <?php echo date('d-m-Y', $row['joindate']);?></li>
				</ul>
			</div>

			<div class="col-sm-9 col-lg-10">
				<div class="box-tabs">
					<!-- Nav tabs -->
					<ul class="nav nav-tabs">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="#info">Thông tin cá nhân</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" data-toggle="tab" href="#seo">Đổi mật khẩu</a>
						</li>
					</ul>
				</div>

				<div class="tab-content card">
					<div class="tab-pane container-fluid active" id="info">
						<form id="frm_action" class="form" action="" method="post" enctype="multipart/form-data">
							<p><span class='msg'><?php echo $msg;?></span></p>
							<div class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label>Họ & đệm<small class="cred"> (*)</small><span id="err_firstname" class="mes-error"></span></label>
										<input class="form-control" id="txtfirstname" name="txtfirstname" value="<?php echo $row['firstname'];?>" type="text" required>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label>Tên<small class="cred"> (*)</small><span id="err_firstname" class="mes-error"></span></label>
										<input class="form-control" id="txtlastname" name="txtlastname" value="<?php echo $row['lastname'];?>" type="text" required>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label>Ngày sinh</label>
										<input class="form-control" name="txtbirthday" type="date" id="txtbirthday" value="<?php echo date('Y-m-d', $row['birthday']);?>"/>
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<h6>Upload a different photo...</h6>
										<input type="file" name="txt_avatar" value="<?php echo $row['avatar'];?>" class="file-upload">
									</div>
								</div>

								<div class="col-sm-6">
									<div class="form-group">
										<label>Điện thoại</label>
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
										<label>Giới tính</label>
										<div>
											<ul class="list-inline">
												<li class="list-inline-item">
													<input name="optgender" type="radio" value="0" <?php if($row['gender']==0) echo'checked';?>/> Nam
												</li>
												<li class="list-inline-item">
													<input name="optgender" type="radio" value="1" <?php if($row['gender']==1) echo'checked';?>/> Nữ
												</li>
											</ul>
										</div>
									</div>
								</div>
							</div>

							<div class="text-center toolbar">
								<input type="submit" name="cmdsave_tab1" id="cmdsave_tab1" class="save btn btn-success" value="Lưu thông tin" class="btn btn-primary">
							</div>
						</form>
					</div>

					<div class="tab-pane container-fluid fade" id="seo">
						<form class="form" action="" method="post">
							<p><span class='msg'><?php echo $msg2;?></span></p>
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
								<input type="submit" name="cmdsave_tab2" id="cmdsave_tab2" class="save btn btn-success" value="Lưu mật khẩu" class="btn btn-primary">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
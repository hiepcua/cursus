<?php
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
require_once('libs/cls.upload.php');
$obj_upload = new CLS_UPLOAD();
$file='';
$GetID = isset($_GET['id']) ? (int)$_GET["id"] : 0;

$number = SysCount('tbl_member', " AND id=".$GetID);
if($number == 0){
	echo 'Không có dữ liệu.'; 
	return;
}

if(isset($_POST['cmdsave_tab1']) && $_POST['txt_name']!='') {
	$arr=array();
	$arr['fullname'] = isset($_POST['txt_fullname']) ? addslashes($_POST['txt_fullname']) : '';
	$arr['email'] = isset($_POST['txt_email']) ? addslashes($_POST['txt_email']) : '';
	$arr['phone'] = isset($_POST['txt_phone']) ? addslashes($_POST['txt_phone']) : '';
	$result = SysEdit('tbl_member', $arr, " id=".$GetID);

	if($result) $_SESSION['flash'.'com_'.COMS] = 1;
	else $_SESSION['flash'.'com_'.COMS] = 0;
}

$res_Member = SysGetList('tbl_member', array(), ' AND id='. $GetID);
if(count($res_Member) <= 0){
	echo 'Không có dữ liệu.'; 
	return;
}
$row = $res_Member[0];
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Chi tiết thông tin thành viên</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST.COMS;?>">Members</a></li>
					<li class="breadcrumb-item active">Chi tiết thông tin thành viên</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<?php
		if (isset($_SESSION['flash'.'com_'.COMS])) {
			if($_SESSION['flash'.'com_'.COMS] == 1){
				$msg->success('Cập nhật thành công.');
				echo $msg->display();
			}else if($_SESSION['flash'.'com_'.COMS] == 0){
				$msg->error('Có lỗi trong quá trình cập nhật.');
				echo $msg->display();
			}
			unset($_SESSION['flash'.'com_'.COMS]);
		}
		?>
		<div id='action'>
			<div class="card">
				<form name="frm_action" id="frm_action" action="" method="post" enctype="multipart/form-data">
					<div class="mess"></div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label>Username<font color="red">*</font></label>
								<input type="text" id="txt_name" name="txt_name" class="form-control" value="<?php echo $row['username'];?>" placeholder="Tên đăng nhập" readonly>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>Fullname</label>
								<input type="text" name="txt_fullname" class="form-control" value="<?php echo $row['fullname'];?>">
							</div>
						</div>
					</div>

					<div class='form-group'>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label>Email</label>
									<input type="email" name="txt_email" class="form-control" value="<?php echo $row['email'];?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Phone</label>
									<input type="text" name="txt_phone" class="form-control" value="<?php echo $row['phone'];?>">
								</div>
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
</section>
<!-- /.row -->
<!-- /.content-header -->
<script type="text/javascript">
	$(document).ready(function(){
		$('#frm_action').submit(function(){
			return validForm();
		})
	});

	function validForm(){
		var flag = true;
		var title = $('#txt_name').val();
		var par_id = parseInt($('#cbo_par').val());

		if(title==''){
			alert('Các mục đánh dấu * không được để trống');
			flag = false;
		}
		return flag;
	}
</script>
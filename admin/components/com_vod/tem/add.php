<?php
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;
require_once('libs/cls.upload.php');
$obj_upload = new CLS_UPLOAD();
$file='';

if(isset($_POST['cmdsave_tab1']) && $_POST['txt_name']!='') {
	$Title 			= isset($_POST['txt_name']) ? addslashes($_POST['txt_name']) : '';
	$Sapo 			= isset($_POST['txt_sapo']) ? addslashes($_POST['txt_sapo']) : '';
	$Fulltext 		= isset($_POST['txt_fulltext']) ? addslashes($_POST['txt_fulltext']) : '';
	$Note 			= isset($_POST['txt_note']) ? addslashes($_POST['txt_note']) : '';
	$Cate 			= isset($_POST['cbo_cate']) ? (int)$_POST['cbo_cate'] : 0;
	$Album 			= isset($_POST['cbo_album']) ? (int)$_POST['cbo_album'] : 0;
	$Chanel 		= isset($_POST['cbo_chanel']) ? (int)$_POST['cbo_chanel'] : 0;
	$Type 			= isset($_POST['cbo_type']) ? (int)$_POST['cbo_type'] : 0;

	if(isset($_FILES['txt_thumb']) && $_FILES['txt_thumb']['size'] > 0){
		$save_path 	= "medias/vods/videos/";
		$obj_upload->setPath($save_path);
		$file = $save_path.$obj_upload->UploadFile("txt_thumb", $save_path);
	}

	$arr=array();
	$arr['title'] = $Title;
	$arr['alias'] = un_unicode($Title);
	$arr['sapo'] = $Sapo;
	$arr['fulltext'] = $Fulltext;
	$arr['note'] = $Note;
	$arr['cat_id'] = $Cate;
	$arr['album_id'] = $Album;
	$arr['chanel_id'] = $Chanel;
	$arr['type'] = $Type;
	$arr['images'] = $file;
	$arr['cdate'] = time();

	$result = SysAdd('tbl_vods', $arr);
	if($result) $_SESSION['flash'.'com_'.COMS] = 1;
	else $_SESSION['flash'.'com_'.COMS] = 0;
}
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Thêm mới VOD</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>vod">Danh sách VOD</a></li>
					<li class="breadcrumb-item active">Thêm mới VOD</li>
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
						<div class="col-md-9">
							<div  class="form-group">
								<label>Tiêu đề<font color="red"><font color="red">*</font></font></label>
								<input type="text" id="txt_name" name="txt_name" class="form-control" value="" placeholder="Tiêu đề VOD">
							</div>

							<div class='form-group'>
								<label>Ảnh đại diện </label><small> (Dung lượng < 10MB)</small>
								<div id="response_img">
									<input type="file" name="txt_thumb" accept="image/jpg, image/jpeg">
								</div>
							</div>

							<div class="form-group">
								<label>Sapo</label>
								<textarea class="form-control" id="txt_sapo" name="txt_sapo" placeholder="Sapo..." rows="3"></textarea>
							</div>

							<div class="form-group">
								<label>Note</label>
								<textarea class="form-control" id="txt_note" name="txt_note" placeholder="Note..." rows="3"></textarea>
							</div>

							<div class="form-group">
								<label>Nội dung</label>
								<textarea class="form-control" id="txt_fulltext" name="txt_fulltext" placeholder="Nội dung chính..." rows="5"></textarea>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>Nhóm<font color="red"><font color="red">*</font></font></label>
								<select class="form-control" name="cbo_cate" id="cbo_cate">
									<option value="0">-- Chọn một --</option>
									<?php getListComboboxCategories(0, 0); ?>
								</select>
							</div>

							<div class="form-group">
								<label>Album<font color="red"><font color="red">*</font></font></label>
								<select class="form-control" name="cbo_album" id="cbo_album">
									<option value="0">-- Chọn một --</option>
									<option value="1">Album 1</option>
									<option value="2">Album 2</option>
									<option value="3">Album 3</option>
									<option value="4">Album 4</option>
								</select>
							</div>

							<div class="form-group">
								<label>Chanel<font color="red"><font color="red">*</font></font></label>
								<select class="form-control" name="cbo_chanel" id="cbo_chanel">
									<option value="0">-- Chọn một --</option>
									<?php
									$rschanels = SysGetList('tbl_channels', array(), ' AND isactive=1');
									$n_chanel = count($rschanels);
									for ($i=0; $i < $n_chanel; $i++) { 
										echo '<option value="'.$rschanels[$i]['id'].'">'.$rschanels[$i]['title'].'</option>';
									}
									?>
								</select>
							</div>

							<div class="form-group">
								<label>Type</label>
								<select class="form-control" name="cbo_type" id="cbo_type">
									<option value="0">-- Chọn một --</option>
									<option value="1">Video</option>
									<option value="2">Audio</option>
									<option value="3">Text</option>
								</select>
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
		// Hidden left sidebar
		$('#body').addClass('sidebar-collapse');
		$('#frm_action').submit(function(){
			return validForm();
		})

		$('#txt_sapo').summernote({
			placeholder: 'Mô tả ...',
			height: 200,
			toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
			['fontname', ['fontname']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['table', ['table']],
			['insert', ['link', 'picture', 'video', 'hr']],
			['view', ['fullscreen', 'codeview', 'help']],
			],
		});

		$('#txt_fulltext').summernote({
			placeholder: 'Mô tả ...',
			height: 500,
			toolbar: [
			['style', ['style']],
			['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
			['fontname', ['fontname']],
			['fontsize', ['fontsize']],
			['color', ['color']],
			['para', ['ul', 'ol', 'paragraph']],
			['height', ['height']],
			['table', ['table']],
			['insert', ['link', 'picture', 'video', 'hr']],
			['view', ['fullscreen', 'codeview', 'help']],
			],
		});
	});

	function validForm(){
		var flag = true;
		var title = $('#txt_name').val();
		var cate = parseInt($('#cbo_cate').val());
		var album = parseInt($('#cbo_album').val());
		var chanel = parseInt($('#cbo_chanel').val());

		if(title=='' || cate==0 || album==0 || chanel==0){
			alert('Các mục đánh dấu * không được để trống');
			flag = false;
		}
		return flag;
	}
</script>
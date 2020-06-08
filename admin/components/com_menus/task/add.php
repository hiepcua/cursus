<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<script language="javascript">
	function checkinput(){	
		if($("#txtname").val()==""){
			$("#txtname_err").fadeTo(200,0.1,function(){
				$(this).html('Yêu cầu nhập tên').fadeTo(900,1);
			});
			return false;
		}
		return true;
	}
</script>

<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">THÊM MỚI MENU</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách menu</a></li>
					<li class="breadcrumb-item active">Thêm mới menu</li>
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
                $msg->success('Thêm mới thành công.');
                echo $msg->display();
            }else if($_SESSION['flash'.'com_'.COMS] == 0){
                $msg->error('Có lỗi trong quá trình thêm.');
                echo $msg->display();
            }
            unset($_SESSION['flash'.'com_'.COMS]);
        }
        ?>
		<form id="frm_action" class="form-horizontal" name="frm_action" method="post" action="">
			<p>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</p>
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Tên Menu<small class="cred"> (*)</small><span id="txtname_err" class="mes-error"></span></label>
						<input type="text" class="form-control" name="txtname" id="txtname">
					</div>
				</div>

				<div class="col-md-6">
					<div class="form-group">
						<label>Hiển thị</label>
						<div>
							<label class="radio-inline"><input name="optactive" type="radio" id="radio" value="1" checked>Có</label>
							<label class="radio-inline"><input type="radio" value="0" name="optactive">Không</label>
						</div>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="form-group">
						<textarea name="txtdesc" id="txtdesc" rows="5"></textarea>
					</div>
				</div>
			</div>
			<input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
			<div class="text-center toolbar">
				<a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i> Lưu thông tin</a>
			</div>
		</form>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$('#txtdesc').summernote({
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
	});
</script>
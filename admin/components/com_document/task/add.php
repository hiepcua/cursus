<?php
defined("ISHOME") or die("Can't acess this page, please come back!")
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">THÊM MỚI TÀI LIỆU</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách tài liệu</a></li>
					<li class="breadcrumb-item active">Thêm mới tài liệu</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="box-tabs">
			<!-- Nav tabs -->
			<ul class="nav nav-tabs">
				<li class="nav-item">
					<a class="nav-link active" data-toggle="tab" href="#info">Thông tin</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" data-toggle="tab" href="#seo">Meta SEO</a>
				</li>
			</ul>
		</div>

		<form id="frm_action" name="frm_action" method="post" action="">
			<div class="tab-content card">
				<div class="tab-pane container-fluid active" id="info">
					<div class="row">
						<div class="col-md-9 col-sm-8">
							<div class="form-group">
								<label>Tên<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
								<input name="txttitle" type="text" id="txttitle" size="50" class="form-control"/>
								<input name="txttask" type="hidden" id="txttask" value="1" />
								<input name="filetype" type="hidden" id="filetype"/>
								<!--File size-->
								<input name="filesize" type="hidden" id="filesize"/>
							</div>

							<div class="form-group">
								<label>File upload</label>
								<div id="response_img">
									<input type="file" name="txt_file">
								</div>
							</div>

							<div class="form-group">
								<label>Mô tả</label>
								<textarea class="form-control" name="txtintro" id="txtintro" rows="5"></textarea>
							</div>

							<div class="form-group">
								<label>Nội dung</label>
								<textarea name="txtdesc" id="txtdesc"rows="5"></textarea>
							</div>
						</div>

						<div class="col-md-3 col-sm-4">
							<div class="form-group">
								<label>Nhóm tài liệu<small class="cred"> (*)</small><span id="err_group" class="mes-error"></span></label>
								<select name="cbo_group" id="cbo_group" class="form-control">
									<option value="0">-- Chọn một --</option>
									<?php $obj_gdoc->ListDocumentType(0,0,0,1); ?>
								</select>
							</div>

							<div class="form-group">
								<label>Ngày ban hành</label>
								<input id="txtdate_issued" name="txtdate_issued" type="date" class="form-control"/>
							</div>

							<div class="form-group">
								<label>Hiển thị</label>
								<div>
									<label class="radio-inline"><input type="radio" value="1" name="optactive" checked>Có</label>
									<label class="radio-inline"><input type="radio" value="0" name="optactive">Không</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="tab-pane container-fluid fade" id="seo">
					<div class="row">
						<div class='col-md-12 form-group'>
							<label>Meta Title</label>
							<input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control'/>
						</div>

						<div class='col-md-12 form-group'>
							<label>Meta Keyword</label>
							<textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="3"></textarea>
						</div>

						<div class='col-md-12 form-group'>
							<label>Meta Description</label>
							<textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="5"></textarea>
						</div>
					</div>
				</div>
			</div>

			<div class="clearfix"></div>
			<div class="text-center toolbar">
				<a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i> Lưu thông tin</a>
			</div>
		</form>
	</div>
</section>
<script language="javascript">
	$(document).ready(function(){
		$('#txtdesc').summernote({
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

		$("#cbo_group").select2();
	});

	function checkinput(){
		if($("#txttitle").val()==""){
			$("#err_name").fadeTo(200,0.1,function()
			{ 
				$(this).html('Vui lòng nhập tên tài liệu').fadeTo(900,1);
			});
			$("#txttitle").focus();
			return false;
		}
		return true;
	}
</script>
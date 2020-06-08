<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"])) $id=(int)$_GET["id"];
$obj->getList(' AND `id`='.$id);
$row=$obj->Fetch_Assoc();
$id=$row['id'];
$g_id=$row['g_id'];
$name=$row['name'];
$code=$row['code'];
$intro=$row['intro'];
$content=$row['content'];
$url=$row['url'];
$fullurl=$row['fullurl'];
$author=$row['author'];
$filetype=$row['filetype'];
$filesize=$row['filesize'];
$cdate=date("d-m-Y ",$row['cdate']);
$meta_title=$row['meta_title'];
$meta_key=$row['meta_key'];
$meta_desc=$row['meta_desc'];
$ishot = $row['ishot'];
$link=ROOTHOST.'tai-lieu/'.$code.'/'.$id.'.html';
?>
<script language="javascript">
	function checkinput(){
		if($("#txttitle").val()==""){
			$("#txttitle_err").fadeTo(200,0.1,function()
			{ 
				$(this).html('Vui lòng nhập tên tài liệu').fadeTo(900,1);
			});
			$("#txttitle").focus();
			return false;
		}
		return true;
	}
	$(document).ready(function() {
		$('#txtdate_issued').datepicker({
			changeMonth: true,
			changeYear: true,
			yearRange: '1900:<?php echo date("Y");?>'
		});
		$("#txttitle").blur(function(){
			if ($("#txttitle").val()=="") {
				$("#txttitle_err").fadeTo(200,0.1,function()
				{ 
					$(this).html('Vui lòng nhập tên tài liệu').fadeTo(900,1);
				});
			}
		});
		$('#mnu_tb1').click(function(){
			$(this).addClass('active');
			$('#mnu_tb2').removeClass('active');
			$('#tab1').show();
			$('#tab2').hide();
		});
		$('#mnu_tb2').click(function(){
			$(this).addClass('active');
			$('#mnu_tb1').removeClass('active');
			$('#tab1').hide();
			$('#tab2').show();
		});
	});
</script>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">CẬP NHẬT TÀI LIỆU</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách tài liệu</a></li>
					<li class="breadcrumb-item active">Cập nhật tài liệu</li>
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
			Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.
			<div class="tab-content card">
				<div class="tab-pane container-fluid active" id="info">
					<div class="row">
						<div id='tab1'>
							<fieldset>
								<legend><strong><?php echo CDETAIL;?>&nbsp;</strong>
								</legend>
								<table width="100%" border="0" cellspacing="1" cellpadding="3">
									<tr>
										<td align="right" bgcolor="#EEEEEE">
											<strong>Nhóm tài liệu<font color="red">*</font></strong>
										</td>
										<td>
											<select name="cbo_group" id="cbo_group">
												<option value="0" selected="selected" style="background-color:#eeeeee; font-weight:bold">Root</option>
												<?php
												if(!isset($objdoctype))
													$objdoctype=new CLS_DOCUMENT_TYPE();
												$objdoctype->ListDocumentType(0,0,0,1);
												?>
												<script language="javascript">
													cbo_Selected('cbo_group',<?php echo $g_id;?>);
												</script>
											</select>
										</td>
										<td width="245" align="right" bgcolor="#EEEEEE">
											<strong><?php echo CAUTHOR;?>&nbsp;</strong>
										</td>
										<td width="308">
											<input name="txtauthor" type="text" id="txtauthor" value="<?php echo $author; ?>" readonly/>
										</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#EEEEEE">
											<strong>Tên tài liệu<font color="red">*</font></strong>
										</td>
										<td>
											<input name="txttitle" type="text" id="txttitle" size="50" value="<?php echo $name;?>" />
											<label id="txttitle_err" class="check_error"></label>
											<input name="txttask" type="hidden" id="txttask" value="1" />
										</td>
										<td align="right" bgcolor="#EEEEEE">
											<strong>Ngày ban hành&nbsp;</strong>
										</td>
										<td>
											<input id="txtdate_issued" name="txtdate_issued" type="text" value="<?php echo $row['date_issued']?>" />
										</td>
									</tr>
									<tr>
										<!-- File upload -->
										<td align="right" bgcolor="#EEEEEE">
											<strong>File upload </strong>
										</td>
										<td>
											<input size="35" name="txturl" value="<?php echo $fullurl;?>" type="text" required><a href="#" onclick="OpenPopup('extensions/upload_document.php');">Chọn</a>
										</td>
										<!--File type-->
										<input name="filetype" type="hidden" id="filetype" value="<?php echo $filetype;?>" size="50"/>
										<input name="txtid" type="hidden" id="txtid" value="<?php echo $id;?>" />
										<!--File size-->
										<input name="filesize" type="hidden" id="filesize" value="<?php echo $filesize;?>" size="50"/>
										<!-- Hien thi -->
										<td align="right" bgcolor="#EEEEEE">
											<strong><?php echo CPUBLIC;?>&nbsp;</strong>
										</td>
										<td>
											<input name="optactive" type="radio" id="radio" value="1" checked />
											<?php echo CYES;?>
											<input name="optactive" type="radio" id="radio2" value="0" />
											<?php echo CNO;?>
										</td>
									</tr>
									<tr>
										<td align="right" bgcolor="#EEEEEE">
											<strong>Link</strong>
										</td>
										<td>
											<input type="text" name="txtlink" value="<?php echo $link; ?>" size="50">
										</td>
										<td align="right" bgcolor="#EEEEEE">
											<strong><?php echo 'isHot';?>&nbsp;</strong>
										</td>
										<td>
											<input name="opthot" type="radio" id="opthot1" value="1" <?php echo ($ishot==1) ? "checked" : "" ?> />
											<?php echo CYES;?>
											<input name="opthot" type="radio" id="opthot2" value="0" <?php echo ($ishot==0) ? "checked" : "" ?> />
											<?php echo CNO;?>
										</td>
									</tr>
								</table>
							</fieldset>
							<br style="clear:both" />
							<strong><?php echo CINTRO;?></strong>
							<textarea name="txtintro" id="txtintro" cols="45" rows="5"><?php echo $intro;?></textarea>
							<script language="javascript">
								var oEdit2=new InnovaEditor("oEdit2");
								oEdit2.width="100%";
								oEdit2.height="100";
								oEdit2.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
								oEdit2.REPLACE("txtintro");
								document.getElementById("idContentoEdit2").style.height="100px";
							</script>
							<br style="clear:both" />
							<strong><?php echo CFULLTEXT;?>&nbsp;</strong>
							<textarea name="txtdesc" id="txtdesc" cols="45" rows="5"><?php echo $content;?></textarea>
							<script language="javascript">
								var oEdit1=new InnovaEditor("oEdit1");
								oEdit1.width="100%";
								oEdit1.height="100";
								oEdit1.cmdAssetManager ="modalDialogShow('<?php echo ROOTHOST;?>admincp/extensions/editor/innovar/assetmanager/assetmanager.php',640,465)";
								oEdit1.REPLACE("txtdesc");
								document.getElementById("idContentoEdit1").style.height="450px";
							</script>
						</div> 
					</div>
				</div>

				<div class="tab-pane container-fluid fade" id="seo">
                    <div class="row">
                        <div class='col-md-12 form-group'>
                            <label>Meta Title</label>
                            <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="<?php echo $row_seo['meta_title'];?>" placeholder='' />
                        </div>

                        <div class='col-md-12 form-group'>
                            <label>Meta Keyword</label>
                            <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="3"><?php echo $row_seo['meta_key'];?></textarea>
                        </div>

                        <div class='col-md-12 form-group'>
                            <label>Meta Description</label>
                            <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="5"><?php echo $row_seo['meta_desc'];?></textarea>
                        </div>
                    </div>
                </div>
				<div class="clearfix"></div>
				<div class="text-center toolbar">
					<a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i> Lưu thông tin</a>
				</div>
				<input type='hidden' name='txt_action' id='txt_action'/>
			</form>
		</div>
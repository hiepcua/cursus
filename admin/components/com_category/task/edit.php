<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))  $id=trim($_GET["id"]);
$sql = "SELECT * FROM `tbl_categories` WHERE id=".$id." ORDER BY `name`";
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();

$seo_link   = ROOTHOST.$row['code'];
$sql_seo    = "SELECT * FROM tbl_seo WHERE link = '".$seo_link."'";
$objmysql->Query($sql_seo);
$row_seo    = $objmysql->Fetch_Assoc();

?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#txt_name_err").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tên bài viết').fadeTo(900,1);
            });
            $("#txt_name").focus();
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
                <h1 class="m-0 text-dark">CẬP NHẬT CHUYÊN MỤC</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách chuyên mục</a></li>
                    <li class="breadcrumb-item active">Cập nhật chuyên mục</li>
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

        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
            <div class="tab-content card">
                <div class="tab-pane container-fluid active" id="info">
                    <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
                    <input type="hidden" name="txt_seo_link" value="<?php echo $seo_link;?>">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Tên nhóm<small class="cred"> (*)</small><span id="txt_name_err" class="mes-error"></span></label>
                            <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="Tên chuyên mục" value="<?php echo $row['name'];?>" required>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Nhóm cha</label>
                            <select name="cbo_cate" class="form-control" id="cbo_cate" style="width: 100%;">
                                <option value="0" title="Top">Root</option>
                                <?php $obj->getListCate(0,0); ?>
                            </select>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    cbo_Selected('cbo_cate','<?php echo $row['par_id'];?>');
                                });
                            </script>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class='form-group'>
                            <label>Ảnh đại diện</label>
                            <div class="row">
                                <div class="col-sm-9 col-md-10">
                                    <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="<?php echo $row['thumb'];?>" placeholder='' />
                                </div>
                                <div class="col-sm-3 col-md-2">
                                    <a class="btn btn-success" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                                </div>
                                <div id="txt_thumb_err" class="mes-error"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-control-label">Sapo</label>
                            <textarea name="txtintro" id="txtintro" rows="5"><?php echo $row['intro'];?></textarea>
                        </div>
                    </div>
                </div>

                <div class="tab-pane container-fluid fade" id="seo">
                    <div class="col-xs-12">
                        <div class='form-group'>
                            <label>Meta Title</label>
                            <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="<?php echo $row_seo['meta_title'];?>" placeholder='' />
                        </div>

                        <div class='form-group'>
                            <label>Meta Keyword</label>
                            <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="3"><?php echo $row_seo['meta_key'];?></textarea>
                        </div>

                        <div class='form-group'>
                            <label>Meta Description</label>
                            <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="5"><?php echo $row_seo['meta_desc'];?></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            <div class="text-center toolbar">
                <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i> Lưu thông tin</a>
            </div>
        </form>
    </div>
</section>


<script type="text/javascript">
    $(document).ready(function(){
        $("#cbo_cate").select2();
        $('#txtintro').summernote({
            placeholder: 'Mô tả ...',
            height: 300,
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
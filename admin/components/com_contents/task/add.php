<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#err_name").fadeTo(200,0.1,function(){
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
                <h1 class="m-0 text-dark">THÊM MỚI BÀI TIN</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách bài tin</a></li>
                    <li class="breadcrumb-item active">Thêm mới bài tin</li>
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

        <!-- Tab panes -->
        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
            <div class="tab-content card">
                <div class="tab-pane container-fluid active" id="info">
                    <div class="row">
                        <div class="col-md-9 col-sm-8">
                            <div class="form-group">
                                <label>Tiêu đề<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
                                <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="" required>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label>Tour liên quan</label>
                                <select class="form-control" id="cbo_tour" name="cbo_tour[]" multiple="multiple">
                                    <option value="0">-- Tour liên quan --</option>
                                    <?php
                                    $sql_tour="SELECT `id`, `name` FROM tbl_tour WHERE isactive=1";
                                    $objmysql->Query($sql_tour);
                                    while ($row_tour = $objmysql->Fetch_Assoc()) {
                                        echo '<option value="'.$row_tour['id'].'">'.$row_tour['name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Địa điểm</label>
                                <select class="form-control" id="cbo_place" name="cbo_place[]" multiple="multiple">
                                    <option value="0">-- Địa điểm --</option>
                                    <?php $obj_place->getListCate(0,0); ?>
                                </select>
                            </div>

                            <div class='form-group'>
                                <label>Ảnh đại diện</label>
                                <div class="row">
                                    <div class="col-sm-9 col-md-10">
                                        <input name="txtthumb" type="text" id="file-thumb" class='form-control'/>
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <a class="btn btn-primary" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                                    </div>
                                    <div id="txt_thumb_err" class="mes-error"></div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class='form-group'>
                                <label>Danh sách ảnh:<span id="err_images" class="mes-error"></span></label>
                                <div id="response_img">
                                    <input type="file" multiple="multiple" name="file_images[]" accept="image/jpg, image/jpeg">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Sapo</label>
                                <textarea name="txt_sapo" class="form-control" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="txt_intro" id="txt_intro" class="form-control" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="txt_fulltext" id="txt_fulltext" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4">
                            <div class="form-group">
                                <label>Chuyên mục<small class="cred"> (*)</small><span id="err_cate" class="mes-error"></span></label>
                                <select class="form-control" id="cbo_cata" name="cbo_cata"required>
                                    <option value="0">Root</option>
                                    <?php $obj_cate->getListCate(0,0); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tác giả <span class="cred">*</span></label>
                                <input type="text" name="txt_author" value="<?php echo $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']['username']; ?>" class="form-control" id="txt_author" readonly placeholder="">
                            </div>

                            <div class="form-group">
                                <label>Hiển thị</label>
                                <div>
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_isactive" checked>Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_isactive">Không</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nổi bật</label>
                                <div>
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_ishot">Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_ishot" checked>Không</label>
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
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
                <div class="clearfix"></div>
                <div class="text-center toolbar">
                    <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i> Lưu thông tin</a>
                </div>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $('#txt_intro').summernote({
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

        $("#cbo_cata").select2();
        $("#cbo_tour").select2();
        $("#cbo_place").select2();
    });

    function images_delete_item(attr){
        var del=confirm("Bạn có chắc muốn xóa ảnh này?");
        if (del==true){
            var parent = attr.parentElement.parentElement;
            parent.remove();
        }
    }
</script>
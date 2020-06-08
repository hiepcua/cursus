<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id = isset($_GET['id']) ? (int)$_GET["id"] : 0;

$sql = "SELECT * FROM tbl_contents WHERE id = ".$id;
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();

$sql2 = "SELECT * FROM tbl_categories WHERE id = ".$row['category_id'];
$objmysql->Query($sql2);
$row2 = $objmysql->Fetch_Assoc();

$seo_link   = ROOTHOST.$row2['code'].'/'.$row['code'].'.html';
$sql_seo    = "SELECT * FROM tbl_seo WHERE link = '".$seo_link."'";
$objmysql->Query($sql_seo);
$row_seo    = $objmysql->Fetch_Assoc();
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
                <h1 class="m-0 text-dark">CẬP NHẬT BÀI TIN</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách bài tin</a></li>
                    <li class="breadcrumb-item active">Cập nhật bài tin</li>
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
            <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
            <input type="hidden" name="txt_seo_link" value="<?php echo $seo_link;?>">
            <div class="tab-content card">
                <div class="tab-pane container-fluid active" id="info">
                    <div class="row">
                        <div class="col-md-9 col-sm-8">
                            <div class='form-group'>
                                <label>Tiêu đề<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
                                <input type="text" name="txt_name" class="form-control" id="txt_name" value="<?php echo $row['title'];?>" placeholder="Tiêu đề bài viết" required>
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

                                    $sql_tour_con="SELECT `tour_id` FROM tbl_tour_content WHERE con_id=".$row['id'];
                                    $objmysql->Query($sql_tour_con);
                                    $arr_tour_con = array();
                                    while ($row_tour_con = $objmysql->Fetch_Assoc()) {
                                        $arr_tour_con[] = $row_tour_con['tour_id'];
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        var json_encode_arr_tour = '<?php echo json_encode($arr_tour_con);?>';
                                        cbo_SelectedInArray('cbo_tour', json_encode_arr_tour);
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Địa điểm</label>
                                <select class="form-control" id="cbo_place" name="cbo_place[]" multiple="multiple">
                                    <option value="0">-- Địa điểm --</option>
                                    <?php
                                    $obj_place->getListCate(0,0);

                                    $sql_place_con="SELECT `place_id` FROM tbl_place_content WHERE con_id=".$row['id'];
                                    $objmysql->Query($sql_place_con);
                                    $arr_place_con = array();
                                    while ($row_place_con = $objmysql->Fetch_Assoc()) {
                                        $arr_place_con[] = $row_place_con['place_id'];
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        var json_encode_arr_place='<?php echo json_encode($arr_place_con);?>';
                                        cbo_SelectedInArray('cbo_place', json_encode_arr_place);
                                    });
                                </script>
                            </div>

                            <div class='form-group'>
                                <label>Ảnh đại diện</label>
                                <div class="row">
                                    <div class="col-sm-9 col-md-10">
                                        <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="<?php echo $row['thumb'];?>" placeholder='' />
                                    </div>
                                    <div class="col-sm-3 col-md-2">
                                        <a class="btn btn-primary" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                                    </div>
                                    <div id="txt_thumb_err" class="mes-error"></div>
                                </div>
                            </div>

                            <div class='form-group'>
                                <label>Chọn thêm ảnh<span id="err_images" class="mes-error"></span></label>
                                <div id="response_img">
                                    <?php
                                    $images = $row['images'];
                                    if($images !== '[]' || $images !== '' || $images !== null){
                                        $images = json_decode($images);
                                        foreach ($images as $k => $val) {
                                            echo '<div class="info-item" data-number="'. $k .'">
                                            <input type="hidden" name="txt_images[]" value="'.$val->url.'"/>
                                            <input type="hidden" name="txt_alt[]" value="'.$val->alt.'"/>
                                            <img class="thumb" src="'.$val->url.'" width="150px">
                                            <div class="name">'.$val->alt.'</div>
                                            <div class="wrap-item-info">
                                            <div class="del-item" onclick="images_delete_item(this);" title="Xóa"></div>
                                            <div class="edit-item" data-number="'. $k .'" data-url="'.$val->url.'" data-alt="'.$val->alt.'" onclick="images_edit_item(this);" title="Đổi tên"></div>
                                            </div>
                                            </div>';
                                        }
                                    }else{
                                        echo '<input type="hidden" name="txt_images[]" value=""/>';
                                    }
                                    ?>
                                    <div class="default">
                                        <img src="<?php echo ROOTHOST_ADMIN;?>images/images.png" class="thumb-default" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_images.php');">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Sapo</label>
                                <textarea name="txt_sapo" class="form-control" rows="5"><?php echo $row['sapo'];?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="txt_intro" id="txt_intro" class="form-control" rows="5"><?php echo $row['intro'];?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="txt_fulltext" id="txt_fulltext" class="form-control"><?php echo $row['fulltext'];?></textarea>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4">
                            <div class='form-group'>
                                <label>Chuyên mục<small class="cred"> (*)</small><span id="err_cate" class="mes-error"></span></label>
                                <select class="form-control" id="cbo_cata" name="cbo_cata" style="width: 100%" required>
                                    <option value="">Root</option>
                                    <?php $obj_cate->getListCate(0,0); ?>
                                </select>
                                <script type="text/javascript">
                                    cbo_Selected('cbo_cata','<?php echo $row['category_id'];?>');
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Tác giả <span class="cred">*</span></label>
                                <input type="text" name="txt_author" value="<?php echo $row['author'];?>" class="form-control" id="txt_author" readonly placeholder="">
                            </div>

                            <div class="form-group">
                                <label>Hiển thị</label>
                                <div>
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_isactive" <?php if($row['isactive']==1) echo 'checked';?>>Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_isactive" <?php if($row['isactive']==0) echo 'checked';?>>Không</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label>Nổi bật</label>
                                <div>
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_ishot" <?php if($row['ishot']==1) echo 'checked';?>>Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_ishot" <?php if($row['ishot']==0) echo 'checked';?>>Không</label>
                                </div>
                                <div class="clearfix"></div>
                            </div>
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
                <input type="submit" name="cmdsave" id="cmdsave" style="display:none;"/>
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

    function images_edit_item(attr){
        var url = attr.getAttribute('data-url');
        var alt = attr.getAttribute('data-alt');
        var number = attr.getAttribute('data-number');

        $('#myModalPopup').modal('show');
        $('#myModalLabel').html('Rename');

        var html = '<div class="form-group">';

        html+= '<div class="form-group">';
        html+= '<input type="text" id="txt_image_alt" name="txt_image_alt" value="'+ alt +'" class="form-control" placeholder="Nhập tên ảnh"/>';
        html+= '</div>';

        html+= '<div class="form-group">';
        html+= '<input type="text" id="txt_image_url" name="txt_image_url" value="'+ url +'" class="form-control" placeholder="Nhập đường dẫn ảnh"/>';
        html+= '</div>';

        html+= '<div class="text-center">';
        html+= '<input onclick="save_info_images_item('+ number +')" type="button" class="btn btn-success" value="Lưu lại"/>';
        html+= '</div>';

        html+= '<div class="clearfix"></div>';
        html+= '</div>';
        $('#data-frm').html(html);
    }

    function save_info_images_item(number){
        var alt = $('#txt_image_alt').val();
        var url = $('#txt_image_url').val();
        var items = $('.info-item');
        var length = items.length;
        for(var i = 0; i < length; i++){
            var num = $('.info-item')[i].getAttribute('data-number');
            if(num == number){
                $('.info-item')[i].querySelector('input[name="txt_images[]"]').value = url;
                $('.info-item')[i].querySelector('input[name="txt_alt[]"]').value = alt;
                $('.info-item')[i].querySelector('.name').textContent = alt;
                $('.info-item')[i].querySelector('.thumb').src = url;
                $('.info-item')[i].querySelector('.edit-item').setAttribute('data-url', url);
                $('.info-item')[i].querySelector('.edit-item').setAttribute('data-alt', alt);
            }
        }
        $('#myModalPopup').modal('hide');
    }
</script>
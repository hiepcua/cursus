<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
define("BASE_PATH","../../images/");
$id = isset($_GET['id']) ? (int)$_GET["id"] : 0;

$sql = "SELECT * FROM tbl_tour WHERE id = ".$id;
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();

$seo_link   = ROOTHOST.'tour/'.$row['un_name'];
$sql_seo    = "SELECT * FROM tbl_seo WHERE link = '".$seo_link."'";
$objmysql->Query($sql_seo);
$row_seo    = $objmysql->Fetch_Assoc();

if(is_dir('../images/'.$row['code'])){
    $_SESSION["CUR_DIR"] = BASE_PATH.$row['code'].'/';
}else{
    $_SESSION["CUR_DIR"] = "../../images/";
}
?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#err_name").fadeTo(200,0.1,function(){
                $(this).html('Trường này là bắt buộc').fadeTo(900,1);
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
                <h1 class="m-0 text-dark">THÊM MỚI TOUR</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách tour</a></li>
                    <li class="breadcrumb-item active">Cập nhật tour</li>
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
                            <div class="form-group">
                                <label>Tên Tour<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
                                <input type="text" name="txt_name" class="form-control" id="txt_name" value="<?php echo $row['name'];?>" placeholder="Tên tour" required>
                            </div>

                            <div class='form-group'>
                                <label>Danh sách ảnh:<span id="err_images" class="mes-error"></span></label>
                                <div id="response_img">
                                    <?php
                                    $images = $row['images']; 
                                    if($images !== '[]' || $images !== ''){
                                        $images = json_decode($images,true);
                                        if(count($images)>0) {
                                            foreach ($images as $k => $val) {
                                                $order = isset($val['order']) ? (int)$val['order'] : 0;
                                                echo '<div class="info-item" data-number="'. $k .'">
                                                <input type="hidden" name="txt_images[]" value="'.$val['url'].'"/>
                                                <input type="hidden" name="txt_alt[]" value="'.$val['alt'].'"/>
                                                <img class="thumb" src="'.$val['url'].'" width="150px">
                                                <div class="name">'.$val['alt'].'</div>
                                                <div class="wrap-item-info">
                                                <div class="del-item" onclick="images_delete_item(this);" title="Xóa"></div>
                                                <div class="edit-item" data-number="'. $k .'" data-url="'.$val['url'].'" data-alt="'.$val['alt'].'" onclick="images_edit_item(this);" title="Đổi tên"></div>
                                                <input type="text" name="image_order[]" class="image_order" value="'.$order.'" size="4" class="order">
                                                </div>
                                                </div>';
                                            } 
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
                                <label>Mô tả</label>
                                <textarea name="txt_intro" id="txt_intro" class="form-control" rows="5"><?php echo $row['intro'];?></textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="txt_content" id="txt_content" class="form-control"><?php echo $row['content'];?></textarea>
                                <script language="javascript">
                                    $(document).ready(function(){
                                        $('#txt_content').summernote({
                                            placeholder: 'Nội dung bài viết',
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
                                            ['view', ['codeview']]
                                            ],
                                        });
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Lộ trình</label>
                                <textarea name="txt_schedule" id="txt_schedule" class="form-control"><?php echo $row['schedule'];?></textarea>
                                <script language="javascript">
                                    $(document).ready(function(){
                                        $('#txt_schedule').summernote({
                                            placeholder: 'Nội dung bài viết',
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
                                            ['view', ['codeview']]
                                            ],
                                        });
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Chính sách</label>
                                <textarea name="txt_policy" id="txt_policy" class="form-control"><?php echo $row['policy'];?></textarea>
                                <script language="javascript">
                                    $(document).ready(function(){
                                        $('#txt_policy').summernote({
                                            placeholder: 'Nội dung bài viết',
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
                                            ['view', ['codeview']]
                                            ],
                                        });
                                    });
                                </script>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4">
                            <div class="form-group">
                                <label>Mã<small class="cred"> (*)</small><span id="err_code" class="mes-error"></span></label>
                                <input type="text" name="txt_code" class="form-control" id="txt_code" value="<?php echo $row['code']; ?>" required>
                            </div>

                            <div class="form-group">
                                <label>Giá ban đầu</label>
                                <input type="text" name="txt_price1" id="txt_price1" class="form-control" min="0" placeholder="Giá chưa khuyến mãi" value="<?php echo $row['price1']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Giá khuyến mãi</label>
                                <input type="text" name="txt_price2" id="txt_price2" class="form-control" min="0" placeholder="Giá khuyến mãi" value="<?php echo $row['price2']; ?>">
                            </div>

                            <div class='form-group'>
                                <label>Địa điểm<span id="err_place" class="mes-error"></span></label>
                                <select class="form-control" id="cbo_place" name="cbo_place" style="width: 100%">
                                    <option value="">-- Điểm đến --</option>
                                    <?php $obj_place->getListCate(); ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        cbo_Selected('cbo_place','<?php echo $row['place_id'];?>');
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Thời gian <small class="cred"> (*)</small><span id="err_code" class="mes-error"></span></label>
                                <select class="form-control" id="cbo_days" name="cbo_days" style="width: 100%" required>
                                    <option>-- Chọn một --</option>
                                    <?php
                                    $days = unserialize(TOUR_TIME);
                                    foreach ($days as $key => $value) {
                                        echo '<option value="'.$value.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        cbo_Selected('cbo_days','<?php echo $row['days'];?>');
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Phương tiện</label>
                                <select class="form-control" id="txt_vehicle" name="txt_vehicle" style="width: 100%" required>
                                    <?php
                                    $vehicle = unserialize(TOUR_VEHICLE);
                                    foreach ($vehicle as $key => $value) {
                                        echo '<option value="'.$value.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        cbo_Selected('txt_vehicle','<?php echo $row['vehicle'];?>');
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Khoảng giá</label>
                                <select class="form-control" id="txt_tour_price" name="txt_tour_price" style="width: 100%" required>
                                    <?php
                                    $tour_price = unserialize(TOUR_PRICE);
                                    foreach ($tour_price as $key => $value) {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        cbo_Selected('txt_tour_price','<?php echo $row['price_range'];?>');
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Sở thích</label>
                                <select class="form-control" id="txt_hobby" name="txt_hobby" style="width: 100%" required>
                                    <?php
                                    $hobby = unserialize(TOUR_HOBBIT);
                                    foreach ($hobby as $key => $value) {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        cbo_Selected('txt_hobby','<?php echo $row['hobby'];?>');
                                    });
                                </script>
                            </div>

                            <div class="form-group">
                                <label>Số trỗ</label>
                                <input type="number" name="txt_number_of_holes" min="1" class="form-control" value="<?php echo $row['number_of_holes']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Nơi khởi hành</label>
                                <input type="text" name="txt_starting_gate" class="form-control" value="<?php echo $row['starting_gate']; ?>">
                            </div>

                            <div class="form-group">
                                <label>Ngày khởi hành<small class="mes-error">(Không chọn thì mặc định là hàng ngày)</small></label>
                                <input type="date" name="txt_departure" class="form-control" value="<?php echo date('Y-m-d', $row['departure']); ?>">
                            </div>

                            <div class="form-group">
                                <label>Tác giả <span class="cred">*</span></label>
                                <input type="text" name="txt_author" value="<?php echo $row['author'];?>" class="form-control" id="txt_author" readonly>
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
                    <div class="col-xs-12">
                        <div class='form-group'>
                            <label><strong>Meta Title</strong></label>
                            <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="<?php echo $row_seo['meta_title'];?>" placeholder='' />
                        </div>

                        <div class='form-group'>
                            <label><strong>Meta Keyword</strong></label>
                            <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="3"><?php echo $row_seo['meta_key'];?></textarea>
                        </div>

                        <div class='form-group'>
                            <label><strong>Meta Description</strong></label>
                            <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="5"><?php echo $row_seo['meta_desc'];?></textarea>
                        </div>
                    </div>
                </div>
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
                <div class="clearfix"></div>
                <div class="text-center toolbar">
                    <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</a>
                </div>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){      
        $("#cbo_cata").select2();
        $("#cbo_place").select2();
        $("#cbo_days").select2();
        $("#txt_tour_price").select2();
        $("#txt_hobby").select2();

        // Change price
        $('#txt_price1, #txt_price2').change(function(){
            var val = addCommas($(this).val());
            $(this).val(val);
        })
    });

    function addCommas(nStr){
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

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
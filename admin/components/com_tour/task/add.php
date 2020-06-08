<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
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
                    <li class="breadcrumb-item active">Thêm mới tour</li>
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

                            <div class='form-group'>
                                <label>Danh sách ảnh:<span id="err_images" class="mes-error"></span></label>
                                <div id="response_img">
                                    <input type="file" multiple="multiple" name="file_images[]" accept="image/jpg, image/jpeg">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <textarea name="txt_intro" id="txt_intro" class="form-control" rows="5"></textarea>
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="txt_content" id="txt_content" class="form-control"></textarea>
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
                                <textarea name="txt_schedule" id="txt_schedule" class="form-control"></textarea>
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
                                <textarea name="txt_policy" id="txt_policy" class="form-control"></textarea>
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
                                <input type="text" name="txt_code" class="form-control" id="txt_code" placeholder="" required>
                            </div>

                            <div class="form-group">
                                <label>Giá ban đầu</label>
                                <input type="text" name="txt_price1" id="txt_price1" class="form-control" min="0" placeholder="Giá chưa khuyến mãi">
                            </div>

                            <div class="form-group">
                                <label>Giá khuyến mãi</label>
                                <input type="text" name="txt_price2" id="txt_price2" class="form-control" min="0" placeholder="Giá khuyến mãi">
                            </div>

                            <div class='form-group'>
                                <label>Địa điểm<span id="err_place" class="mes-error"></span></label>
                                <select class="form-control" id="cbo_place" name="cbo_place" style="width: 100%">
                                    <option value="">-- Điểm đến --</option>
                                    <?php $obj_place->getListCate(); ?>
                                </select>
                                <div class="clearfix"></div>
                            </div>

                            <div class="form-group">
                                <label>Thời gian <small class="cred"> (*)</small><span id="err_code" class="mes-error"></span></label>
                                <select class="form-control" id="cbo_days" name="cbo_days" style="width: 100%" required>
                                    <option>-- Chọn một --</option>
                                    <?php
                                    $days = unserialize(TOUR_TIME);
                                    foreach ($days as $key => $value) {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Phương tiện</label>
                                <select class="form-control" id="txt_vehicle" name="txt_vehicle" style="width: 100%" required>
                                    <?php
                                    $vehicle = unserialize(TOUR_VEHICLE);
                                    foreach ($vehicle as $key => $value) {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                                    ?>
                                </select>
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
                            </div>

                            <div class="form-group">
                                <label>Số trỗ</label>
                                <input type="number" name="txt_number_of_holes" min="1" class="form-control" value="1">
                            </div>

                            <div class="form-group">
                                <label>Nơi khởi hành</label>
                                <input type="text" name="txt_starting_gate" class="form-control" value="Hà Nội">
                            </div>

                            <div class="form-group">
                                <label>Ngày khởi hành<small class="mes-error">(Không chọn thì mặc định là hàng ngày)</small></label>
                                <input type="date" name="txt_departure" class="form-control">
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
                    <div class='form-group'>
                        <label><strong>Meta Title</strong></label>
                        <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="" placeholder='' />
                    </div>

                    <div class='form-group'>
                        <label><strong>Meta Keyword</strong></label>
                        <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="3"></textarea>
                    </div>

                    <div class='form-group'>
                        <label><strong>Meta Description</strong></label>
                        <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="5"></textarea>
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
</script>
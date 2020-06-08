<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#txt_name_err").fadeTo(200,0.1,function(){
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
                <h1 class="m-0 text-dark">THÊM MỚI ĐỊA ĐIỂM</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách địa điểm</a></li>
                    <li class="breadcrumb-item active">Thêm mới địa điểm</li>
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
                                <label>Tên<small class="cred"> (*)</small><span id="txt_name_err" class="mes-error"></span></label>
                                <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="Tên nhóm địa điểm" required>
                            </div>

                            <div class="form-group">
                                <label>Chọn ảnh banner <small>(Có thể chọn nhiều)</small><span id="err_images" class="mes-error"></span></label>
                                <div id="response_img">
                                    <input type="file" multiple="multiple" name="file_images[]" accept="image/jpg, image/jpeg">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Intro</label>
                                <textarea name="txtintro" id="txtintro" rows="5"></textarea>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4">
                            <div class="form-group">
                                <label>Cha</label>
                                <select name="cbo_par" class="form-control" id="cbo_par">
                                    <option value="0">Root</option>
                                    <?php $obj->getListCate(0,0); ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quốc gia</label>
                                <select name="cbo_country" class="form-control" onchange="change_country(this)">
                                    <option value="0">-- Chọn một --</option>
                                    <?php
                                    $sql_country="SELECT * FROM tbl_country WHERE isactive=1";
                                    $objmysql->Query($sql_country);
                                    while ($row_country = $objmysql->Fetch_Assoc()) {
                                        echo '<option value="'.$row_country['id'].'">'.$row_country['name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Tỉnh/ Thành phố</label>
                                <select name="cbo_city" class="form-control" id="cbo_city" onchange="change_city(this)">
                                    <option value="0">Chọn quốc gia trước</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Quận/ Huyện</label>
                                <select name="cbo_district" class="form-control" id="cbo_district">
                                    <option value="0">Chọn tỉnh/ thành phố trước</option>
                                </select>
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
            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            <div class="text-center toolbar">
                <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</a>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    function images_delete_item(attr){
        var del=confirm("Bạn có chắc muốn xóa ảnh này?");
        if (del==true){
            var parent = attr.parentElement.parentElement;
            parent.remove();
        }
    }
    $(document).ready(function(){
        $("#cbo_par").select2();
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
            ['view', ['codeview']]
            ],
        });
    });

    function change_country(selectObject){
        var id = selectObject.value;
        $.ajax({
            url : '<?php echo ROOTHOST_ADMIN.'ajaxs/tour/getCity.php' ?>',
            type : 'GET',
            data : {
                'id' : id,
            },
            cache: false,
            success: function (res) {
                $('#cbo_city').empty();
                $('#cbo_city').append(res);
            }
        })
    }

    function change_city(selectObject){
        var id = selectObject.value;
        $.ajax({
            url : '<?php echo ROOTHOST_ADMIN.'ajaxs/tour/getDistrict.php' ?>',
            type : 'GET',
            data : {
                'id' : id,
            },
            cache: false,
            success: function (res) {
                $('#cbo_district').empty();
                $('#cbo_district').append(res);
            }
        })
    }
</script>
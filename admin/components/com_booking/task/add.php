<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#txt_name_err").fadeTo(200,0.1,function(){
                $(this).html('Trường này là yêu cầu bắt buộc').fadeTo(900,1);
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
                <h1 class="m-0 text-dark">ĐẶT TOUR MỚI</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách đặt tour</a></li>
                    <li class="breadcrumb-item active">Đặt tour mới</li>
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
        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
            <div class="tab-content card">
                <div class="tab-pane container-fluid active" id="info">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <label>Tour</label>
                                <select name="tour" class="form-control" id="tour" style="width: 100%;">
                                    <option value="0" title="Top">Chọn một tour</option>
                                    <?php
                                    $sql="SELECT * FROM tbl_tour WHERE isactive=1";
                                    $objmysql->QuerY($sql);
                                    while ($row_tour = $objmysql->Fetch_Assoc()) {
                                        echo '<option value="'.$row_tour['id'].'">'.$row_tour['name'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h4>Thông tin khách hàng</h4>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="book-dskh">
                                <div class="form reset-select">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Số người lớn:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" name="adult">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Số trẻ em:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" name="child">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Số em bé:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" name="baby">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Chọn ngày đi</label>
                                        <div class="col-md-9">
                                            <div class="start-date">
                                                <input class="form-control" data-toggle="datepicker" name="start_date">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="book-dskh">
                                <div class="form reset-select">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Họ và tên:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" name="name" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Điện thoại:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" name="tel" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Email:</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" name="email" required="">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Địa chỉ</label>
                                        <div class="col-md-9">
                                            <input class="form-control" name="address" type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
                <div class="text-center toolbar">
                    <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i>Lưu thông tin</a>
                </div>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function(){
        $("#tour").select2();
    });
</script>
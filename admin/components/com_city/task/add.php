<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#err_name").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tên').fadeTo(900,1);
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
                <h1 class="m-0 text-dark">THÊM MỚI TỈNH/ THÀNH PHỐ</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách tỉnh, thành phố</a></li>
                    <li class="breadcrumb-item active">Thêm mới tỉnh, thành phố</li>
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

        <!-- Tab panes -->
        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
            <div class="tab-content card">
                <div class="tab-pane container-fluid active" id="info">
                    <div class="row">
                        <div class="col-md-9 col-sm-8">
                            <div class="form-group">
                                <label>Tên tỉnh/ thành phố<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
                                <input type="text" name="txt_name" class="form-control" id="txt_name" required>
                            </div>
                            <div class='form-group'>
                                <label>Phân loại</label>
                                <select class="form-control" name="cbo_type" id="cbo_type">
                                    <option value="Tỉnh">Tỉnh</option>
                                    <option value="Thành phố Trung ương">Thành phố Trung ương</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-4">
                            <div class='form-group'>
                                <label>Quốc gia</label>
                                <select class="form-control" name="cbo_country" id="cbo_country">
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
                                <label>Hiển thị</label>
                                <div>
                                    <label class="radio-inline"><input type="radio" value="1" name="opt_isactive" checked>Có</label>
                                    <label class="radio-inline"><input type="radio" value="0" name="opt_isactive">Không</label>
                                </div>
                            </div>
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
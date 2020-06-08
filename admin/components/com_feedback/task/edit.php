<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id = trim($_GET["id"]);

$sql = "SELECT * FROM tbl_feedback WHERE id = ".$id;
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();
?>

<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#txt_name_err").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tên nhóm tin').fadeTo(900,1);
            });
            $("#txt_name").focus();
            return false;
        }

        if($("#txtthumb").val()==""){
            $("#txt_thumb_err").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng chọn hình ảnh').fadeTo(900,1);
            });
            $("#txtthumb").focus();
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
                $msg->success('Cập nhật thành công.');
                echo $msg->display();
            }else if($_SESSION['flash'.'com_'.COMS] == 0){
                $msg->error('Có lỗi trong quá trình cập nhật.');
                echo $msg->display();
            }
            unset($_SESSION['flash'.'com_'.COMS]);
        }
        ?>
        <form id="frm_action" name="frm_action" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
            <div class="tab-content card">
                <div class="tab-pane container-fluid active" id="info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tên khách hàng<small class="cred"> (*)</small><span id="txt_name_err" class="mes-error"></span></label>
                                <input type="text" name="txt_name" class="form-control" placeholder="Tên khách hàng" value="<?php echo $row['name'];?>" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Avatar<small class="cred"> (*)</small><span id="txt_thumb_err" class="mes-error"></span></label>
                                <div class="row">
                                    <div class="col-sm-10">
                                        <input name="txtthumb" type="text" id="file-thumb" class='form-control' value="<?php echo $row['avatar'];?>" placeholder='Avatar' />
                                    </div>
                                    <div class="col-sm-2">
                                        <a class="btn btn-primary" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Chức vụ</label>
                                <input type="text" name="txt_career" class="form-control" id="txt_career" placeholder="Chức vụ" value="<?= $row['career'];?>">
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Comment</label>
                                <textarea class="form-control" name="txt_comment" placeholder="Nội dung comment"><?= $row['comment'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
                <div class="text-center toolbar">
                    <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i>Lưu thông tin</a>
                </div>
            </div>
        </form>
    </div>
</section>

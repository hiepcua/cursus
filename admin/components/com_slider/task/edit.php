<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
if(!isset($UserLogin)) $UserLogin=new CLS_USERS;
$id="";
if(isset($_GET["id"])) $id=trim($_GET["id"]);
$sql = "SELECT * FROM `tbl_slider` WHERE id=".$id." ORDER BY `slogan`";
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();
?>

<script language="javascript">
    function checkinput(){
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
                <h1 class="m-0 text-dark">CẬP NHẬT BANNER</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách banner</a></li>
                    <li class="breadcrumb-item active">Cập nhật banner</li>
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
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Hình ảnh*</label>
                        <div class="row">
                            <div class="col-sm-10">
                                <input id="txtthumb" name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="<?php echo $row['thumb'];?>" placeholder='' />
                            </div>
                            <div class="col-sm-2">
                                <a class="btn btn-primary" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                            </div>
                            <div id="txt_thumb_err" class="mes-error"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>link</label>
                        <input type="text" name="txt_link" class="form-control" id="txt_link" placeholder="" value="<?php echo $row['link'];?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Slogan</label>
                        <input type="text" name="txt_slogan" class="form-control" id="txt_slogan" value="<?php echo $row['slogan'];?>">
                    </div>
                </div>

                <div class="col-md-12">
                    <label>Mô tả</label>
                    <textarea name="txt_intro" id="txt_intro" class="form-control"><?php echo $row['intro'];?></textarea>
                </div>
            </div>

            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            <div class="text-center toolbar" style="margin-top: 30px;">
                <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</a>
            </div>
        </form>
    </div>
</section>

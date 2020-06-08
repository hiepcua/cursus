<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))  $id=trim($_GET["id"]);
$sql = "SELECT * FROM `tbl_seo` WHERE id=".$id." ORDER BY `title`";
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();
?>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#err_name").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tiêu đề').fadeTo(900,1);
            });
            return false;
        }

        if($("#txt_link").val()==""){
            $("#err_link").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập liên kết').fadeTo(900,1);
            });
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
                <h1 class="m-0 text-dark">CẬP NHẬT META SEO</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách Meta SEO</a></li>
                    <li class="breadcrumb-item active">Cập nhật Meta SEO</li>
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
        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
            <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label>Tiêu đề<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
                        <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="Tên Meta SEO" value="<?php echo stripslashes($row['title']);?>" required>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label>Link<small class="cred"> (*)</small><span id="err_link" class="mes-error"></span></label>
                        <input type="text" name="txt_link" class="form-control" id="txt_link" placeholder="link" value="<?php echo stripslashes($row['link']);?>" required>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <div class="row">
                            <div class="col-sm-9 col-md-10">
                                <input name="txtthumb" type="text" id="file-thumb" class='form-control' value="<?php echo stripslashes($row['image']);?>" placeholder='' />
                            </div>
                            <div class="col-sm-3 col-md-2">
                                <a class="btn btn-success" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                            </div>
                            <div id="txt_thumb_err" class="mes-error"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class='form-group'>
                <label><strong>Meta Title</strong></label>
                <input name="txt_metatitle" type="text" id="txt_metatitle" class='form-control' value="<?php echo stripslashes(html_entity_decode($row['meta_title']));?>" placeholder='' />
            </div>

            <div class='form-group'>
                <label><strong>Meta Keyword</strong></label>
                <textarea class="form-control" name="txt_metakey" id="txt_metakey" rows="3"><?php echo stripslashes(html_entity_decode($row['meta_key']));?></textarea>
            </div>

            <div class='form-group'>
                <label><strong>Meta Description</strong></label>
                <textarea class="form-control" name="txt_metadesc" id="txt_metadesc" rows="5"><?php echo stripslashes(html_entity_decode($row['meta_desc']));?></textarea>
            </div>

            <input type="submit" name="cmdsave" id="cmdsave" style="display:none;" />
            <div class="text-center toolbar">
                <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i> Lưu thông tin</a>
            </div>
        </form>
    </div>
</section>
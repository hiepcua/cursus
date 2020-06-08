<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))  $id=trim($_GET["id"]);
$sql = "SELECT * FROM `tbl_partner` WHERE id=".$id." ORDER BY `name`";
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();
?>
<style type="text/css">
    .form-horizontal .control-label{text-align: left;}
</style>
<script language="javascript">
    function checkinput(){
        if($("#txt_name").val()==""){
            $("#txt_name_err").fadeTo(200,0.1,function(){
                $(this).html('Vui lòng nhập tên đối tác').fadeTo(900,1);
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
                <h1 class="m-0 text-dark">CẬP NHẬT ĐỐI TÁC</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách đối tác</a></li>
                    <li class="breadcrumb-item active">Cập nhật đối tác</li>
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
        <form id="frm_action" name="frm_action" method="post" action=""  enctype="multipart/form-data">
            <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tên đối tác:<small class="cred"> (*)</small><span id="err_name" class="mes-error"></span></label>
                        <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="" value="<?php echo stripslashes($row['name']);?>">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class='form-group'>
                        <label class="control-label">Hình ảnh*</label>
                        <div class="row">
                            <div class="col-sm-9">
                                <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="<?php echo stripslashes($row['images']);?>" placeholder='' />
                            </div>
                            <div class="col-sm-3">
                                <a class="btn btn-success" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
                            </div>
                            <div id="txt_thumb_err" class="mes-error"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-control-label">Link</label>
                        <input type="text" name="txt_link" class="form-control" id="txt_link" placeholder="" value="<?php echo stripslashes($row['link']);?>">
                    </div>
                </div>
            </div>
            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;"/>
            <div class="text-center toolbar">
                <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i>Lưu thông tin</a>
            </div>
        </form>
    </div>
</section>

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

<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))  $id=trim($_GET["id"]);
$sql = "SELECT * FROM `tbl_user_group` WHERE id=".$id." ORDER BY `name`";
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
                $(this).html('Vui lòng nhập tên nhóm người dùng').fadeTo(900,1);
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
                <h1 class="m-0 text-dark">CẬP NHẬT NHÓM USER</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách nhóm user</a></li>
                    <li class="breadcrumb-item active">Cập nhật nhóm user</li>
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
                        <label>Tên nhóm<small class="cred"> (*)</small><span id="txt_name_err" class="mes-error"></span></label>
                        <input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="Tên nhóm người dùng" value="<?php echo $row['name'];?>" required>
                    </div>
                </div>

                <div class="col-md-6 col-sm-6">
                    <div class="form-group">
                        <label>Nhóm cha</label>
                        <select name="cbo_parent" class="form-control" id="cbo_parent" style="width: 100%;">
                            <option value="0" title="Top">Root</option>
                            <?php $obj->getOption(0,0); ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="form-control-label">Mô tả</label>
                <textarea name="txtintro" class="form-control" id="txtintro" rows="5"><?php echo $row['intro'];?></textarea>
            </div>
            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
            <div class="text-center toolbar">
                <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i> Lưu thông tin</a>
            </div>
        </form>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        cbo_Selected('cbo_parent','<?php echo $row['par_id'];?>');
        $("#cbo_parent").select2();
    });
</script>

<?php
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../../global/libs/gffunc.php");
include_once('../../../libs/cls.mysql.php');
$obj    = new CLS_MYSQL();
$id     = isset($_POST['id'])? $_POST['id']: '';
$sql    = "SELECT * FROM `tbl_gallery` WHERE `id`='$id'";
$obj->Query($sql);
$obj->Num_rows();
$row = $obj->Fetch_Assoc();
?>
<form action="" method="post" id="frm-edit">
    <input type="hidden" name="txtid" value="<?php echo $row['id'] ?>"/>
    <input type="hidden" name="txtparid" value="<?php echo $row['album_id'];?>"/>
    <div class="form-group">
        <div class="row">
            <div class="col-md-9">
                <input type="text" name="txt_image" value="<?php echo $row['name'] ?>" class="form-control" placeholder="Nhập tên ảnh"/>
            </div>
            <div class="col-md-3">
                <input id="btn-submit" type="submit" class="btn btn-success" value="Lưu lại"/>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</form>
<?php
unset($obj);
?>
<script type="text/javascript">
    $('#btn-submit').click(function(){
        var form = $('#frm-edit');
        var postData = form.serializeArray();
        $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/editImage.php',postData, function(response_data){
            $('#respon-img').html(response_data);
            $('#myModalPopup').modal('hide');
        });
        return false;
    });
</script>


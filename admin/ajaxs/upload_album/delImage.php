<?php
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../../global/libs/gffunc.php");
include_once('../../libs/cls.mysql.php');
$objmysql = new CLS_MYSQL();

$id = isset($_POST['imgId'])? $_POST['imgId']: '';
$sql = "SELECT link FROM `tbl_gallery` WHERE `id`='$id'";

$objmysql->Query($sql);
$objmysql->Num_rows();
$row = $objmysql->Fetch_Assoc();
$sls = explode('/', $row['link']);
$link = end($sls);
$file = UPLOAD_PATH.PATH_GALLERY_REVIEW.$link;

if(is_file($file)){
    unlink($file);
}

$sql_GA = "DELETE FROM `tbl_gallery` WHERE `id` in ('$id')";
$objmysql->Exec($sql_GA);

unset($objmysql);
?>
<script type="text/javascript">
    /*del image*/
    $('#respon-img .del-item').click(function(){
        if(confirm("Bạn có muốn chắc xóa ảnh này")){
            var imgId=$(this).attr('value');
            var par_id=$('#par_id').val();
            $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/delImage.php',{imgId, par_id},function(response_data){
            });
            var parent= $(this).parent().parent();
            parent.remove();
        }
        else return false;
    });
    $('#file-img').val("");

    /*edit name image*/
    $('.edit-item').click(function(){
        var id=$(this).attr('value');
        var par_id=$('#par_id').val();
        $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/frm_edit.php',{id, par_id},function(response_data){
            $('#myModal').modal('show');
            $('#myModalLabel').html('Đổi tên ảnh');
            $('#data-frm').html(response_data);
        });
    });

</script>
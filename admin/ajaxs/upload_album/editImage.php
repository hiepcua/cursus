<?php
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../../global/libs/gffunc.php");
include_once('../../../libs/cls.mysql.php');
$objmysql = new CLS_MYSQL();

if(isset($_POST['txtid'])){
    $id         = (int)$_POST['txtid'];
    $par_id     = (int)$_POST['txtparid'];
    $image      = addslashes($_POST['txt_image']);

    $sql = "UPDATE tbl_gallery set name = '$image' WHERE id='$id'";
    $objmysql->Query($sql);
    
    $sql_GA = "SELECT * FROM `tbl_gallery` WHERE album_id = ".$par_id;
    $objmysql->Query($sql_GA);
    while($rows = $objmysql->Fetch_Assoc()){
        $id     = $rows['id'];
        $path   = $rows['link'];
        $name   = Substring(stripslashes($rows['name']),0,4);
        $url    = "index.php?com=gallery&task=delete&id='$id'";
        ?>
        <div class="info-item">
            <img src="<?php echo $path;?>" width="150px">
            <div class="name"><?php echo $name;?></div>
            <div class="wrap-item-info">
                <div class="del-item" value="<?php echo $id;?>" title="Xóa"></div>
                <div class="edit-item" value="<?php echo $id;?>" title="Đổi tên"></div>
            </div>
        </div>
        <?php
    }
}
?>
<script type="text/javascript">
    /*del image*/
    $('#respon-img .del-item').click(function(){
        if(confirm("Bạn có muốn chắc xóa ảnh này")){
            var imgId   = $(this).attr('value');
            $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/delImage.php',{imgId}, function(response_data){
                // console.log(response_data);
            });
            var parent= $(this).parent().parent();
            parent.remove();
        }
        else return false;
    });

    /*edit name image*/
    $('#respon-img .edit-item').click(function(){
        var id=$(this).attr('value');
        $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/frm_edit.php',{id},function(response_data){
            $('#myModalPopup').modal('show');
            $('#myModalLabel').html('Rename');
            $('#data-frm').html(response_data);
        });
    });
</script>


<?php
if(isset($_FILES['fileImg']) && $_FILES['fileImg']['name'][0]!=NULL):
    require_once("../../../global/libs/gfinit.php");
    require_once("../../../global/libs/gfconfig.php");
    require_once("../../../global/libs/gffunc.php");
    include_once('../../../libs/cls.mysql.php');
    include_once('../../extensions/cls.upload.php');

    $album_id       = addslashes($_POST['album_id']);
    $name_image     = addslashes($_POST['txt_image']);
    $name           = $_FILES['fileImg']['name'][0];
    $tmp_name       = $_FILES['fileImg']['tmp_name'][0];
    $size           = $_FILES['fileImg']['size'][0];
    $fileType       = $_FILES['fileImg']['type'][0];
    $path           = UPLOAD_PATH.PATH_GALLERY;

    $objmysql  = new CLS_MYSQL();
    $objUpload = new CLS_UPLOAD();

    if($objUpload->UploadFiles('fileImg', $path)):
        $GAlbumID   = $album_id;
        $Name       = $name_image;
        $GLink      = ROOTHOST.PATH_GALLERY_REVIEW.$name;

        $id = '';
        $sql = " INSERT INTO `tbl_gallery`(`album_id`,`name`,`link`) VALUES";
        $sql.="('".$GAlbumID."','".$Name."','".$GLink."')";

        if($objmysql->Exec($sql) == true){
            $sql_GA = "SELECT * FROM `tbl_gallery` WHERE album_id = ".$album_id;
            $objmysql->Query($sql_GA);
            while($rows = $objmysql->Fetch_Assoc()){
                $id     = $rows['id'];
                $path   = $rows['link'];
                $name   = Substring(stripslashes($rows['name']),0,4);
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
        }else{
            echo "Có lỗi xảy ra, vui lòng thử lại!";
        }
    endif;
endif;
unset($objmysql);
?>

<script type="text/javascript">
    /*del image*/
    $('#respon-img .del-item').click(function(){
        if(confirm("Bạn có muốn chắc xóa ảnh này")){
            var id=$(this).attr('value');
            $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/delImage.php',{id},function(response_data){
            });
            var parent= $(this).parent().parent();
            parent.remove();
        }
        else return false;
    });
    $('#file-img').val("");
    $('#txt_image').val("");

    /*edit name image*/
    $('.edit-item').click(function(){
        var id=$(this).attr('value');
        var par_id=$('#par_id').val();
        $.post('<?php echo ROOTHOST_ADMIN;?>ajaxs/upload_album/frm_edit.php',{id, par_id},function(response_data){
            $('#myModalPopup').modal('show');
            $('#myModalLabel').html('Rename');
            $('#data-frm').html(response_data);
        });
    });

</script>


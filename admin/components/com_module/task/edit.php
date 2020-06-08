<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$id='';
if(isset($_GET['id'])) $id=(int)$_GET['id'];

$sql = "SELECT * FROM `tbl_modules` WHERE id = ".$id;
$objmysql->Query($sql);
$row = $objmysql->Fetch_Assoc();
$viewtype = $row['type'];
if(isset($_POST["txt_type"])){
    $viewtype = addslashes($_POST["txt_type"]);
}
?>

<script language="javascript">
    function checkinput(){
        if($('#txttitle').val()=="") {
            $("#err2").fadeTo(200,0.1,function(){ 
                $(this).html('Mời bạn nhập tiêu đề Module').fadeTo(900,1);
            });
            $('#txttitle').focus();
            return false;
        }
        if( $('#cbo_type').val()=="mainmenu") {
            if($('#cbo_menutype').val()=="") {
                $("#err3").fadeTo(200,0.1,function(){ 
                    $(this).html('Mời chọn kiểu Menu cần hiển thị').fadeTo(900,1);
                });
                $('#cbo_menutype').focus();
                return false;
            }
        }
        return true;
    }
    function select_type(){
        var txt_viewtype=document.getElementById("txt_type");
        var cbo_viewtype=document.getElementById("cbo_type");
        for(i=0;i<cbo_viewtype.length;i++){
            if(cbo_viewtype[i].selected==true)
                txt_viewtype.value=cbo_viewtype[i].value;
        }
        document.frm_type.submit();
    }

    $(document).ready(function() {
        $('#txttitle').blur(function(){
            if($(this).val()=="") {
                $("#err2").fadeTo(200,0.1,function(){ 
                    $(this).html('Mời bạn nhập tiêu đề Module').fadeTo(900,1);
                });
            }
        })
    });
</script>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">CẬP NHẬT MODULE</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách module</a></li>
                    <li class="breadcrumb-item active">Cập nhật module</li>
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
        <form id="frm_type" name="frm_type" method="post" action="" style="display:none;">
            <label>
                <input type="text" name="txt_type" id="txt_type" />
            </label>
        </form>

        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" action="">
            <input type="hidden" name="txtid" id="txtid" value="<?php echo $row['id'];?>" />
            <p>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</p>
            <div class="row">
                <div class="col-md-9 col-sm-8">
                    <div class="form-group">
                        <label>Kiểu hiển thị<small class="cred"> (*)</small><span id="err1" class="mes-error"></span></label>
                        <select name="cbo_type" class="form-control" id="cbo_type" onchange="select_type();" style="width: 100%;">
                            <?php 
                            $obj->LoadModType();?>
                            <script language="javascript">
                                cbo_Selected('cbo_type','<?php echo $viewtype;?>');
                                $(document).ready(function() {
                                    $("#cbo_type").select2();
                                });
                            </script>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tiêu đề<small class="cred"> (*)</small><span id="err2" class="mes-error"></span></label>
                        <input name="txttitle" type="text" id="txttitle" class="form-control" value="<?php echo stripslashes($row['title']);?>">
                    </div>

                    <?php 
                    $arr_type = array('mainmenu','html','news','slide', 'partner', 'content');
                    if(in_array($viewtype,$arr_type)){ 
                        if($viewtype == "mainmenu"){ ?>
                            <div class="form-group">
                                <label>Menu<small class="cred"> (*)</small><span id="err3" class="mes-error"></span></label>
                                <select name="cbo_menutype" class="form-control" id="cbo_menutype">
                                    <option value="all">Chọn một kiểu menu</option>
                                    <?php echo $objmenu->getListmenu("option"); ?>
                                    <script language="javascript">
                                        cbo_Selected('cbo_menutype','<?php echo $row['menu_id'];?>');
                                    </script>
                                </select>

                                <span id="menutype_err" class="check_error"></span>
                            </div>

                        <?php }else if($viewtype=="news"){ ?>
                            <div class="form-group">
                                <label>Nhóm tin</label>
                                <select name="cbo_cate" class="form-control" id="cbo_cate" style="width: 100%;">
                                    <option value="0">Chọn một nhóm tin</option>
                                    <?php
                                    if(!isset($objCate)) $objCate = new CLS_CATEGORY();
                                    $objCate->getListCate(0,0);
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        cbo_Selected('cbo_cate','<?php echo $row['category_id'];?>');
                                        $("#cbo_cate").select2();

                                    });
                                </script>
                            </div>

                        <?php }else if($viewtype=="content"){ ?>
                            <div class="form-group">
                                <label>Bài tin</label>
                                <select name="cbo_content" class="form-control" id="cbo_content" style="width: 100%;">
                                    <option value="0">Chọn một bài tin</option>
                                    <?php
                                    $sql_con = "SELECT * FROM tbl_contents WHERE isactive = 1";
                                    $objmysql->Query($sql_con);

                                    while ($r = $objmysql->Fetch_Assoc()) {
                                        if($r['id'] == $row['content_id']){
                                            echo '<option value="'.$r['id'].'" selected>'.$r['title'].'</option>';
                                        }else{
                                            echo '<option value="'.$r['id'].'">'.$r['title'].'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $("#cbo_content").select2();
                                    });
                                </script>
                            </div>

                        <?php }else if($viewtype=="html"){?>
                            <div class="form-group">
                                <label>Nội dung html</label>
                                <textarea name="txtcontent" id="txtcontent" class="form-control"><?php echo stripslashes($row['content']);?></textarea>
                            </div>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $('#txtcontent').summernote({
                                        placeholder: 'Mô tả ...',
                                        height: 300,
                                        toolbar: [
                                        ['style', ['style']],
                                        ['font', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
                                        ['fontname', ['fontname']],
                                        ['fontsize', ['fontsize']],
                                        ['color', ['color']],
                                        ['para', ['ul', 'ol', 'paragraph']],
                                        ['height', ['height']],
                                        ['table', ['table']],
                                        ['insert', ['link', 'picture', 'video', 'hr']],
                                        ['view', ['fullscreen', 'codeview', 'help']],
                                        ],
                                    });
                                });
                            </script>
                        <?php } ?>
                    <?php }?>

                    <div class="form-group">
                        <label>Giao diện</label>
                        <select name="cbo_theme" class="form-control" id="cbo_theme" style="width: 100%;">
                            <option value="">Chọn một giao diện</option>
                            <?php LoadModBrow("mod_".$viewtype);?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                cbo_Selected('cbo_theme','<?php echo $row['theme'];?>');
                                $("#cbo_theme").select2();
                            });
                        </script>
                    </div>
                </div>

                <div class="col-md-3 col-sm-4">
                    <div class="form-group">
                        <label>Vị trí</label>
                        <select name="cbo_position" class="form-control" id="cbo_position" style="width: 100%;">
                            <?php LoadPosition();?>
                        </select>
                        <script type="text/javascript">
                            $(document).ready(function() {
                                $("#cbo_position").select2();
                                cbo_Selected('cbo_position','<?php echo $row['position'];?>');
                            });
                        </script>
                    </div>

                    <div class="form-group">
                        <label>Class</label>
                        <input type="text" name="txtclass" id="txtclass" class="form-control" value="<?php echo $row['class'];?>" />
                    </div>

                    <div class="form-group">
                        <label>Hiển thị tiêu đề</label>
                        <div>
                            <label class="radio-inline"><input type="radio" name="optviewtitle" value="1" <?php if($row['viewtitle']==1) echo "checked";?>>Có</label>
                            <label class="radio-inline"><input type="radio" name="optviewtitle" value="0" <?php if($row['viewtitle']==0) echo "checked";?>>Không</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Hiển thị</label>
                        <div>
                            <label class="radio-inline"><input type="radio" name="optactive" value="1" <?php if($row['isactive']==1) echo "checked";?>>Có</label>
                            <label class="radio-inline"><input type="radio" name="optactive" value="0" <?php if($row['isactive']==0) echo "checked";?>>Không</label>
                        </div>
                    </div>
                </div>
            </div>

            <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;">
            <div class="text-center toolbar">
                <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fas fa-save"></i>Lưu thông tin</a>
            </div>
        </form>
    </div>
</section>
<?php
defined("ISHOME") or die("Can not acess this page, please come back!")
?>
<script language="javascript">
    function checkinput(){
        if($('#chk_user').val()=="0") {
            alert("Tên đăng nhập đã có trong hệ thống. Vui lòng nhập tên khác");
            $('#username_result').html('Tên đăng nhập không hợp lệ.');
            return false;
        }
        return true;
    }
    $(document).ready(function(){
        $('#frm_action').submit(function(){
            return checkinput();
        });

        $("#txt_username").blur(function() {
            var username = $('#txt_username').val();
            $.post("<?php echo ROOTHOST_ADMIN;?>"+"ajaxs/user/getuser.php", {username: username },function(result){
                if(result=='0'){
                    $('#username_result').html('<img src="<?php echo ROOTHOST_ADMIN;?>images/icon_true.png" width="20" align="middle"/> Tên có thể sử dụng');  
                    $('#chk_user').val('1');
                    return true;
                }else{
                    $('#username_result').html('<img src="<?php echo ROOTHOST_ADMIN;?>images/icon_false.png" width="20" align="middle"/> Tên đã tồn tại. Vui lòng nhập tên khác');  
                    $('#chk_user').val('0');
                    return false;
                }  
            });  
        })
    });
</script>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">THÊM MỚI USER</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách user</a></li>
                    <li class="breadcrumb-item active">Thêm mới user</li>
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
                $msg->success('Thêm mới thành công.');
                echo $msg->display();
            }else if($_SESSION['flash'.'com_'.COMS] == 0){
                $msg->error('Có lỗi trong quá trình thêm.');
                echo $msg->display();
            }
            unset($_SESSION['flash'.'com_'.COMS]);
        }
        ?>
        <form id="frm_action" class="form-horizontal" name="frm_action" method="post" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="has-success has-feedback form-group">
                        <label>Username<small class="cred"> (*)</small></label>
                        <input type="text" id="txt_username" name="txt_username" class="form-control" value="" placeholder="Tên đăng nhập">
                        <input type="hidden" name="chk_user" id="chk_user" value="0"/>
                        <span id="username_result" class="cred"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password<small class="cred"> (*)</small></label>
                        <input type="password" id="txt_password" name="txt_password" class="form-control" value="" placeholder="Mật khẩu">
                        <small id="er3" class="cred"></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nhóm người dùng<small class="cred"> (*)</small></label>
                        <select name="cbo_gid" id="cbo_gid" class="form-control" required>
                            <option value="0" style="font-weight:bold; background-color:#cccccc">Chọn nhóm quyền</option>
                            <?php
                            $sql="SELECT * FROM tbl_user_group WHERE `isactive`='1' ";
                            $objmysql = new CLS_MYSQL();
                            $objmysql->Query($sql);
                            if($objmysql->Num_rows()<=0) return;
                            while($rows = $objmysql->Fetch_Assoc()){
                                $id=$rows['id'];
                                $title=$rows['name'];
                                echo "<option value='$id'>$title</option>";
                            }
                            ?>
                        </select>
                        <small id="er4" class="cred"></small>
                    </div>
                </div>
                <br>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Họ đệm<small class="cred"> (*)</small></label>
                        <input type="text" id="txt_lastname" name="txt_lastname" class="form-control" value="" placeholder="Họ đệm">
                        <small id="er0" class="cred"></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tên<small class="cred"> (*)</small></label>
                        <input type="text" id="txt_firstname" name="txt_firstname" class="form-control" value="" placeholder="Tên">
                        <small id="er1" class="cred"></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Ngày sinh</label>
                        <input type="date" id="txt_birthday" name="txt_birthday" class="form-control" value="" placeholder="Ngày sinh">
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Giới tính</label>
                        <div class="radio">
                            <label class="radio-inline"><input type="radio" value="0" name="opt_gender" checked="">Nam</label>
                            <label class="radio-inline"><input type="radio" value="1" name="opt_gender">Nữ</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rows">
                <h4 class="title">Thông tin liên hệ</h4><hr>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Phone<small class="cred"> (*)</small></label>
                        <input type="number" id="txt_phone" name="txt_phone" class="form-control" value="" placeholder="Số điện thoại">
                        <small id="er5" class="cred"></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email<small class="cred"> (*)</small></label>
                        <input type="email" id="txt_email" name="txt_email" class="form-control" value="" placeholder="Email">
                        <small id="er6" class="cred"></small>
                    </div>
                </div>
            </div>

            <label>Cơ quan</label>
            <textarea class="form-control" rows="1" id="txt_organ" name="txt_organ" placeholder="Cơ quan công tác"></textarea><br>
            <label>Địa chỉ</label>
            <textarea class="form-control" rows="3" id="txt_address" name="txt_address" placeholder="Địa chỉ của bạn"></textarea>
            <br>

            <div class="text-center toolbar">
                <input type="hidden" name="cmd_save">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                <a href="<?php echo ROOTHOST_ADMIN.'user';?>" class="btn btn-default"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</a>
            </div>
        </form>
    </div>
</section>
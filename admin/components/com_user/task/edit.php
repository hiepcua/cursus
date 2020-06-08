<?php
defined("ISHOME") or die("Can not acess this page, please come back!");
$objmysql = new CLS_MYSQL();
$_ID = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$sql="SELECT * FROM `tbl_user` WHERE id=".$_ID;
$objmysql->Query($sql);
$num_row = $objmysql->Num_rows();
$row = $objmysql->Fetch_Assoc();
?>

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">CẬP NHẬT USER</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách user</a></li>
                    <li class="breadcrumb-item active">Cập nhật user</li>
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
        <?php if($num_row >0){ ?>
            <form id="frm_action" class="form-horizontal" name="frm_action" method="post" action="">
                <input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="has-success has-feedback form-group">
                            <label>Username<small class="cred"> (*)</small></label>
                            <input type="text" id="txt_username" name="txt_username" class="form-control" value="<?php echo $row['username'];?>" placeholder="Tên đăng nhập" readonly>
                            <input type="hidden" name="chk_user" id="chk_user" value="0"/>
                            <span id="username_result" class="cred"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nhóm người dùng<small class="cred"> (*)</small></label>
                            <select name="cbo_gid" id="cbo_gid" class="form-control" required>
                                <option value="0" style="font-weight:bold; background-color:#cccccc">Chọn nhóm quyền</option>
                                <?php
                                $sql1="SELECT * FROM tbl_user_group WHERE `isactive`='1' ";
                                $objmysql->Query($sql1);
                                if($objmysql->Num_rows()<=0) return;
                                while($rows = $objmysql->Fetch_Assoc()){
                                    $id=$rows['id'];
                                    $title=$rows['name'];
                                    echo "<option value='$id'>$title</option>";
                                }
                                ?>
                                <script language="javascript">
                                    cbo_Selected('cbo_gid','<?php echo $row['gid'];?>');
                                </script>
                            </select>
                            <small id="er4" class="cred"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Họ đệm<small class="cred"> (*)</small></label>
                            <input type="text" id="txt_lastname" name="txt_lastname" class="form-control" value="<?php echo $row['lastname'];?>" placeholder="Họ đệm">
                            <small id="er0" class="cred"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tên<small class="cred"> (*)</small></label>
                            <input type="text" id="txt_firstname" name="txt_firstname" class="form-control" value="<?php echo $row['firstname'];?>" placeholder="Tên">
                            <small id="er1" class="cred"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ngày sinh</label>
                            <input type="date" id="txt_birthday" name="txt_birthday" class="form-control" value="<?php echo date('Y-m-d', strtotime($row['birthday']));?>">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Giới tính</label>
                            <div class="radio">
                                <label class="radio-inline"><input type="radio" value="0" name="opt_gender" <?php if($row['gender'] == '0') echo 'checked';?>>Nam</label>
                                <label class="radio-inline"><input type="radio" value="1" name="opt_gender" <?php if($row['gender'] == '1') echo 'checked';?>>Nữ</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rows">
                    <h4 class="title">Thông tin liên hệ</h4><hr>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Phone<small class="cred"> (*)</small></label>
                            <input type="number" id="txt_phone" name="txt_phone" class="form-control" value="<?php echo $row['phone'];?>" placeholder="Số điện thoại">
                            <small id="er5" class="cred"></small>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email<small class="cred"> (*)</small></label>
                            <input type="email" id="txt_email" name="txt_email" class="form-control" value="<?php echo $row['email'];?>" placeholder="Email">
                            <small id="er6" class="cred"></small>
                        </div>
                    </div>
                </div>

                <label>Cơ quan</label>
                <textarea class="form-control" rows="1" id="txt_organ" name="txt_organ" placeholder="Cơ quan công tác"><?php echo $row['organ'];?></textarea><br>
                <label>Địa chỉ</label>
                <textarea class="form-control" rows="3" id="txt_address" name="txt_address" placeholder="Địa chỉ của bạn"><?php echo $row['address'];?></textarea>
                <br>

                <div class="text-center toolbar">
                    <input type="hidden" name="cmd_save">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                    <a href="<?php echo ROOTHOST_ADMIN.'user';?>" class="btn btn-default"><i class="fa fa-undo" aria-hidden="true"></i> Hủy</a>
                </div>
            </form>
        <?php }else{ ?>
            <p>Không tìm thấy thông tin người dùng</p>
        <?php } ?>
    </div>
</section>
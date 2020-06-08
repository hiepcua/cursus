<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
$id="";
if(isset($_GET["id"]))
    $id=(int)$_GET["id"];
$obj->getList(" AND `id`='".$id."'");
$row=$obj->Fetch_Assoc();
?>
<div class="body">
	<div class="com_header color">
		<i class="fa fa-list" aria-hidden="true"></i> Thông tin đăng ký xét tuyển
		<div class="pull-right">
			<div id="menus" class="toolbars">
				<form id="frm_menu" name="frm_menu" method="post" action="">
					<input type="hidden" name="txtorders" id="txtorders" />
					<input type="hidden" name="txtids" id="txtids" />
					<input type="hidden" name="txtaction" id="txtaction" />

					<ul class="list-inline">
						<li><a class="save btn btn-default" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</a></li>

						<li><a class="btn btn-default"  href="<?php echo ROOTHOST_ADMIN.COMS;?>" title="Đóng"><i class="fa fa-sign-out" aria-hidden="true"></i> Đóng</a></li>
					</ul>
				</form>
			</div>
		</div>
	</div>
    <div class="container">
		<form id="frm_action" class="form-horizontal" name="frm_action" method="post" enctype="multipart/form-data">
		<input type="hidden" name="txtid" value="<?php echo $row['id'];?>">
		<div class="colmain col-xs-12">
			<div class="col-md-8 col-lg-offset-2">
				<div class="col-md-12">
					<div class="col-md-12">
						<strong>Họ và tên</strong>
						<div class="form-group">
							<input class="form-control" id="fullname" name="fullname" placeholder="Nhập đầy đủ họ và tên" type="text" value="<?php echo stripslashes($row['fullname']);?>" required>
							<span class="msg_fullname text-danger"></span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-4">
						<strong>CMTND/CCCD</strong>
						<div class="form-group">
							<input class="form-control" id="CMTND" name="CMTND" placeholder="Nhập số CMTND hoặc thẻ căn cước" type="text" value="<?php echo stripslashes($row['cmtnd']);?>">
							<span class="msg_cmt text-danger"></span>
						</div>
					</div>
					<div class="col-md-4">
						<strong>Ngày sinh</strong>
						<div class="form-group">
							<input class="form-control" id="birthday" name="birthday" placeholder="Ngày/tháng/năm" type="text" value="<?php echo stripslashes($row['birthday']);?>">
							<span class="msg_birthday text-danger"></span>
						</div>
					</div>
					<div class="col-md-4">
						<strong>Giới tính</strong>
						<div class="form-group">
							<select class="form-control" name="gender" required>
								<option value="">-- Chọn giới tính -- </option>
								<option value="Nam" <?php if($row['gender']=="Nam") echo 'selected';?>>Nam</option>
								<option value="Nữ" <?php if($row['gender']=="Nữ") echo 'selected';?>>Nữ</option>
							</select>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-12">
						<strong>Hộ khẩu thường trú: </strong>
						<div class="form-group">
							<input class="form-control" id="Hokhau" name="Hokhau" placeholder="Nhập địa chỉ theo hộ khẩu thường trú" type="text" value="<?php echo stripslashes($row['household']);?>">
							<span class="msg_hokhau text-danger"></span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-4">
						<strong>Email</strong>
						<div class="form-group">
							<input class="form-control" id="Email" name="Email" placeholder="VD: email@gmail.com" type="email" value="<?php echo stripslashes($row['email']);?>">
							<span class="msg_email text-danger"></span>
						</div>
					</div>
					<div class="col-md-4">
						<strong>Điện thoại</strong>
						<div class="form-group">
							<input class="form-control" id="Dienthoai" name="Dienthoai" placeholder="VD: 0983 282 282" type="text" value="<?php echo stripslashes($row['tel']);?>" required>
							<span class="msg_tel text-danger"></span>
						</div>
					</div>
					<div class="col-md-4">
						<strong>Năm tốt nghiệp THPT:</strong>
						<div class="form-group">
							<input class="form-control" id="year" name="year" placeholder="Nhập năm bạn tốt nghiệp" type="text" value="<?php echo (int)$row['year'];?>" required>
							<span class="msg_year text-danger"></span>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="col-md-12">
						<strong>Địa chỉ: </strong><i>(Ghi rõ địa chỉ của bạn)</i>
						<div class="form-group">
							<input class="form-control" id="address" name="address" placeholder="Nhập đầy đủ họ tên và địa chỉ nơi bạn nhận hồ sơ thông báo" type="text" value="<?php echo stripslashes($row['address']);?>" required>
							<span class="msg_address text-danger"></span>
						</div>
					</div>
				</div>
				<div class="col-md-12 margin-bottom-5">
					<div class="col-md-12 margin-bottom-5">
						<strong>Ngành đăng ký xét tuyển</strong>
						<div class="form-group">
							<select class="form-control" id="nganh" name="nganh" required>
								<option value="">-- Lựa chọn ngành -- </option>
								<option value="Công nghệ kỹ thuật Môi trường">Công nghệ kỹ thuật Môi trường</option>
								<option value="Công nghệ sinh học">Công nghệ sinh học</option>
								<option value="Công nghệ Thông tin">Công nghệ Thông tin</option>
								<option value="Công nghệ Kỹ thuật ô tô">Công nghệ Kỹ thuật ô tô</option>
								<option value="Điều Dưỡng">Điều Dưỡng</option>
								<option value="Luật kinh tế">Luật kinh tế</option>
								<option value="Ngôn ngữ Anh">Ngôn ngữ Anh</option>
								<option value="Ngôn ngữ Anh – Nhật">Ngôn ngữ Anh – Nhật</option>
								<option value="Ngôn ngữ Anh – Hàn">Ngôn ngữ Anh – Hàn</option>
								<option value="Ngôn ngữ Nhật">Ngôn ngữ Nhật</option>
								<option value="Ngôn ngữ Trung">Ngôn ngữ Trung</option>
								<option value="Kế toán">Kế toán</option>
								<option value="Kỹ thuật Xây dựng">Kỹ thuật Xây dựng</option>
								<option value="Kiến Trúc">Kiến Trúc</option>
								<option value="Kỹ thuật điện tử, truyền thông">Kỹ thuật điện tử, truyền thông</option>
								<option value="Quan hệ Quốc tế">Quan hệ Quốc tế</option>
								<option value="Quản trị Kinh doanh">Quản trị Kinh doanh</option>
								<option value="Quản lý nhà nước">Quản lý nhà nước</option>
								<option value="Tài chính Ngân hàng">Tài chính Ngân hàng</option>
								<option value="Việt nam học">Việt nam học (Du lịch)</option>
								<option value="Thông tin - Thư viện">Thông tin - Thư viện</option>
								<option value="Thương mại điện tử">Thương mại điện tử</option>
								<option value="Thú y">Thú y</option>
							</select>
							<span class="msg_nganh text-danger"></span>
							<script type="text/javascript">
								cbo_Selected('nganh','<?php echo $row['branch'];?>');
							</script>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
			<input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
		</div>
		</form>
    </div>
</div>
<script language="javascript">
	function checkinput(){
		return true;
	}
</script>
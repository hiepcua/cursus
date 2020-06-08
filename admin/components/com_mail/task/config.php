<?php 
// check quyền
$obj = new CLS_USER();
$check_permission = $UserLogin->Permission(COMS);
if($check_permission==false) die($GLOBALS['MSG_PERMIS']);

$objdata= new CLS_MYSQL;
$success="";
if(isset($_POST['server_name'])) {				
	$sql="UPDATE tbl_mail_config SET hostname='".addslashes($_POST['server_name'])."',`user`='".addslashes($_POST['server_user']);
	$sql.="',`pass`='".addslashes($_POST['server_pass'])."',`port`='".addslashes($_POST['server_port']);
	$sql.="',`name`='".addslashes($_POST['txtname'])."' WHERE id=1";
	$objdata->Query($sql);
	$success="Cập nhật thành công";

	$sql="SELECT * FROM tbl_mail_config ORDER BY `id` DESC"; 
	$objdata->Query($sql);
	if($objdata->Num_rows()>0) {
		$r=$objdata->Fetch_Assoc();
		$_host = $r['hostname'];
		$_user = $r['user'];
		$_pass = $r['pass'];
		$_port = $r['port'];
		$_name = $r['name'];
	}
}
?>
<div class='row'>
	<div class="com_header color">
		<i class="fa fa-cog" aria-hidden="true"></i>  Cấu hình mail
		<div class="pull-right"></div>
	</div>
</div>
<div class='user_list'><br>
	<form name="frm_config" id="frm_config" action="#" method="POST">
		<div class="row form-group">
			<div class="col-md-2"></div>
			<div class="col-md-6" style="color:red"><?php echo $success;?></div>
		</div>
		<div class="row form-group">
			<div class="col-md-2"><label>Máy chủ</label></div>
			<div class="col-md-6">
				<input type="text" name="server_name" id="server_name" value="<?php echo $_host;?>" placeholder="Host name" class="form-control"/>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-2"><label>Cổng</label></div>
			<div class="col-md-6">
				<input type="number" name="server_port" id="server_port" value="<?php echo $_port;?>" placeholder="Port" class="form-control"/>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-2"><label>Email đăng nhập</label></div>
			<div class="col-md-6">
				<input type="text" name="server_user" id="server_user" value="<?php echo $_user;?>" placeholder="Username" class="form-control"/>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-2"><label>Mật khẩu Email</label></div>
			<div class="col-md-6">
				<input type="password" name="server_pass" id="server_pass" value="<?php echo $_pass;?>" placeholder="Password" class="form-control"/>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-2"><label>Tên hiển thị</label></div>
			<div class="col-md-6">
				<input type="text" name="txtname" id="txtname" value="<?php echo $_name;?>" placeholder="Name" class="form-control"/>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-2"></div>
			<div class="col-md-6">
				<button type="button" class="btn btn-primary pull-left btn_save"> 
					<i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu lại 
				</button>
				<button type="button" class="btn btn-success pull-left check_connect"> 
					<i class="fa fa-gears" aria-hidden="true"></i> Test kết nối 
				</button>
			</div>
		</div>
	</form>
</div>
<script>
$(document).ready(function(){
	$('.btn_save').click(function(){
		$('#frm_config').submit();
	})
	$('.check_connect').click(function(){
		var host = $('#server_name').val();
		var port = $('#server_port').val();
		var user = $('#server_user').val();
		var pass = $('#server_pass').val();
		var url='<?php echo ROOTHOST_ADMIN;?>ajaxs/<?php echo COMS;?>/check_connect.php'; 
		$.post(url,{'host':host,'port':port,'user':user,'pass':pass},function(req){
			showMess(req,'');
		})
		return false;
	})
})
</script>
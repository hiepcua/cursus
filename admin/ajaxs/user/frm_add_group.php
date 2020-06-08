<?php
session_start();
require_once("../../../global/libs/gfinit.php");
require_once("../../../global/libs/gfconfig.php");
require_once("../../includes/gfconfig.php");
require_once("../../libs/cls.mysql.php");
require_once("../../libs/cls.guser.php");
require_once("../../libs/cls.user.php");
$objuser=new CLS_USER;

$gid=isset($_GET['gid'])?(int)$_GET['gid']:0;
// Check quyền
if(!$objuser->isLogin()) die("E01");
$check_permission = $objuser->Permission('user');
$check_permis_group = $objuser->Permission('gusers');
if($check_permission==false || $check_permis_group==false) die('E02');

$name='';$intro=''; $msg=$permission=''; $par_id=0;
if($gid>0){
	$objuser->getListGroup(" AND id=$gid");
	$row=$objuser->Fetch_Assoc();
	$name=$row['name'];
	$intro=$row['intro'];
	$par_id=$row['par_id'];
	$permission=$row['permission'];
}
?>
<form id="frm-add" class="form-horizontal" method="POST" action="" name="frm-add" enctype="multipart/form-data">
	<?php if($gid>0):?>
		<input type="hidden" name="txt_gid" id="txt_gid" value="<?php echo $gid;?>">
		<input type="hidden" name="cmd_update">
	<?php endif; ?>
	<div class="row form-group">
		<label class="col-md-2"></label>
		<div class="col-md-8"><span class='msg'><?php echo $msg;?></span></div>
	</div>
	<div class="row form-group">
		<label class="col-md-2 control-label">Tên nhóm <span class="star">*</span></label>
		<div class="col-md-8">
			<input class="form-control" id="txtname" name="txtname" value="<?php echo $name;?>" type="text" required>
			<label id="txtname_err" class="check_error"></label>
		</div>
	</div>
	<div class="row form-group">
		<label class="col-md-2 control-label">Mô tả </label>
		<div class="col-md-8">
			<input class="form-control" id="txtdesc" name="txtdesc" value="<?php echo $intro;?>" type="text">
			<label id="txtname_err" class="check_error"></label>
		</div>
	</div>
	<div class="row form-group">
		<label class="col-md-2 control-label">Thuộc nhóm <span class="star">*</span></label>
		<div class="col-md-8">
			<select name="cbo_parid" id="cbo_parid" class="form-control">
              <option value="0" selected="selected" style="font-weight:bold"><?php echo "Root";?></option>
              <?php 
			  if(!isset($obju)) $obju = new CLS_GUSER();
			  $obju->getListGmem(0,1); 
			  unset($obju);
			  ?>
			  <script language="javascript">
			  cbo_Selected('cbo_parid',<?php echo $par_id;?>);
			  </script>
            </select>
		</div>
	</div>
	<div class="row form-group">
		<label class="col-md-2 control-label">Phân quyền <span class="star">*</span></label>
		<div class="col-md-10">
			<strong><input type="checkbox" name="permis_all" id="permis_all" value="1" onclick="checkall('permission[]',this.checked);"/> Chọn tất cả</strong>
			<div id='boxcom'>
			<?php
			$str='config';
			foreach($GLOBALS['ARR_COM'] as $key=>$value){
				$com=explode("_",$key);
				$com=$com[0];
				//if($str!=$com) echo "<div class='clearfix'></div>";
				$chk='';
				if($permission & $value) {
					$chk='checked="checked"';
				}
				echo '<div class="com"><input type="checkbox" name="permission[]" value="'.$value.'" onclick="'."checkonce('permission[]','permis_all')".'" '.$chk.'/> '.$GLOBALS['ARR_COM_NAME'][$key].'</div>';
				$str=$com;
			}
			?></div>
		</div>
		<div class="col-md-2"></div>
	</div>
	<div class="row form-group">
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<input type="submit" name="cmd_save" id="cmd_save" value="Lưu lại" class="btn btn-primary">
		</div>
		<div class="col-md-2"></div>
	</div>
</form>
<div class="clearfix"></div>
<script type="text/javascript">
$(document).ready(function(){
	$('#cmd_save').click(function(){
		var data = $('#frm-add').serializeArray();
		var url='ajaxs/user/process_add_group.php'; 
		$.post(url,data,function(req){
			if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
			if(req=='E03'){showMess('Không có quyền thêm danh mục con cho nhóm này!','error');}
			else {
				console.log(req);
				//$('.user_group_list').html(req);
				showMess('Success!','success');
			}
		});
	});
	$('#cmd_cancel').click(function(){
		$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin người dùng');
		$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
		$('#myModalPopup').modal('hide');
	});
	$("#txtname").blur(function() {
		if( $(this).val()=='') {
			$("#txtname_err").fadeTo(200,0.1,function(){ 
			  $(this).html('Vui lòng nhập tên').fadeTo(900,1);
			});
		}
		else {
			$("#txtname_err").fadeTo(200,0.1,function(){ 
			  $(this).html('').fadeTo(900,1);
			});
		}
	})
})
function checkall(name,status){
	var objs=document.getElementsByName(name);
	for(i=0;i<objs.length;i++)
		objs[i].checked=status;
}
function checkonce(name,all){
	var objs=document.getElementsByName(name);
	var flag=true;
	for(i=0;i<objs.length;i++)
		if(objs[i].checked!=true)
		{
			flag=false;
			break;
		}
	document.getElementById(all).checked=flag;
}
function checkinput(){
	if($("#txtname").val()==""){
		$("#txtname_err").fadeTo(200,0.1,function(){ 
		  $(this).html('Vui lòng nhập tên').fadeTo(900,1);
		});
		$("#txtname").focus();
		return false;
	}
	return true;
}
</script>
<style>
.com {float:left; width:200px;height:30px; line-height:30px;}
.clearfix {clear:both}
</style>
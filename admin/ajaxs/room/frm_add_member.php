<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
if(isLogin()){
$code=isset($_GET['class_code'])?antiData($_GET['class_code']):'';
if($code!=''){ 
$obj=SysGetList('tbl_class_member',array('username')," AND class_code='$code'",false);
$mems='';
while($r=$obj->Fetch_Assoc()){
	$mems.="'".$r['username']."',";
}
$strWhere='';
if($mems!=''){ 
	$mems=substr($mems,0,strlen($mems)-1);
	$strWhere=" AND username NOT IN ($mems)";
}
?>
<br/>
<h3 class='text-center'>Add Member to Room</h3><hr/>
<div class='mess' style='color:#f00;'></div>
<div class="form-group">
	<label>Add member</label>
	<select class="form-control" id='cbo_choice_type' data-placeholder="Select one room">
		<option value='room'>From another room</option>
		<option value='member'>From member list</option>
	</select>
</div>
<div class="form-group">
	<div class='from_room'>
		<select class="form-control" id='cbo_room' data-placeholder="Select one room">
			<?php
			$objRoom=SysGetList('tbl_class',array()," AND code!='$code'",false);
			while($r=$objRoom->Fetch_Assoc()){
			?>
			<option value='<?php echo $r['code'];?>'><?php echo $r['name'];?> (#<?php echo $r['code'];?>)</option>
			<?php }?>
		</select>
	</div>
	<div class='from_member'>
		<select class="select2 form-control" id='cbo_member' multiple="multiple" data-placeholder="Select one or more members">
			<?php
			$obj=SysGetList('tbl_member',array(),$strWhere,false);
			while($r=$obj->Fetch_Assoc()){
			?>
			<option value='<?php echo $r['username'];?>'><?php echo $r['fullname'];?></option>
			<?php }?>
		</select>
	</div>
</div>
<div class='form-group text-center' >
	<button class='btn btn-primary' id='btn-add-room'>Add to room >></button>
</div>
<script>
$('.select2').select2();
$('.from_member').hide();
$('#cbo_choice_type').change(function(){
	var _val=$(this).val();
	if(_val=='room'){
		$('.from_room').show();
		$('.from_member').hide();
	}else{
		$('.from_room').hide();
		$('.from_member').show();
	}
})
$('#btn-add-room').click(function(){
	var _url='<?php echo ROOTHOST;?>ajaxs/room/process_add_member.php';
	var _data={
		'class_code':'<?php echo $code;?>',
		'type':$('#cbo_choice_type').val(),
		'from_room':$('#cbo_room').val(),
		'members':$('#cbo_member').val()
	}
	$.post(_url,_data,function(req){
		console.log(req);
		if(req=='success'){
			$('#room-members').load('<?php echo ROOTHOST;?>ajaxs/room/load_member_room.php?code=<?php echo $code;?>');
			$('#popup_modal .modal-body').html('<div class="text-center">Member join success!</div>');
			setTimeout(function(){$('#popup_modal').modal('hide');},1000);
		}else{
			$('.mess').html(req);
		}
	})
})
</script>
<?php }else{
		echo "<div class='red'>No room found! Please select room to continue!</div>";
	}
}else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
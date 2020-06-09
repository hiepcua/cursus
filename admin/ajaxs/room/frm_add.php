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
?>
<br/>
<h3 class='text-center'>Create Room</h3>
<div class='mess' style='color:#f00;'></div>
<div class='form-group'>
	<label>Code</label>
	<input type='text' class='form-control' id='txt_code' placeholder='Room code'/>
</div>
<div class='form-group'>
	<label>Name</label>
	<input type='text' class='form-control' id='txt_name' placeholder='Room name'/>
</div>
<div class='form-group'>
	<label>Join member from:</label>
	<select class="form-control" id='cbo_room'>
		<option value=''>Select once room!</option>
		<?php
		$objRoom=SysGetList('tbl_class',array()," ",false);
		while($r=$objRoom->Fetch_Assoc()){
		?>
		<option value='<?php echo $r['code'];?>'><?php echo $r['name'];?> (#<?php echo $r['code'];?>)</option>
		<?php }?>
	</select>
</div>

<div class='form-group text-center' >
	<button class='btn btn-primary' id='btn-add-room'>Continue >></button>
</div>
<script>
$('#btn-add-room').click(function(){
	if($('#txt_code').val()!='' && $('#txt_name').val()!=''){
		var _url='<?php echo ROOTHOST;?>ajaxs/room/process_add.php';
		var _data={
			'code':$('#txt_code').val(),
			'name':$('#txt_name').val(),
			'from_room':$('#cbo_room').val()
		}
		$.post(_url,_data,function(req){
			console.log(req);
			if(req=='success'){
				window.location.href='<?php echo ROOTHOST;?>class/view?code='+$('#txt_code').val();
			}else{
				$('.mess').html(req);
			}
		})
	}else{
		$('.mess').html('Room code or room name is empty!');
	}
})
</script>
<?php }else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
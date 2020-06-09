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
$code=isset($_POST['code'])?antiData($_POST['code']):'';
$obj=SysGetList('tbl_class',array(),"AND code='$code'");
$r=$obj[0];
?>
<br/>
<h3 class='text-center'>Edit Room</h3>
<div class='mess' style='color:#f00;'></div>
<div class='form-group'>
	<label>Name</label>
	<input type='text' class='form-control' id='txt_name' value='<?php echo $r['name'];?>' placeholder='Room name'/>
</div>
<div class='form-group'>
	<label>Join member from:</label>
	<select class="form-control" id='cbo_room'>
		<option value=''>Select once room!</option>
		<?php
		$objRoom=SysGetList('tbl_class',array()," AND code<>'$code'",false);
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
	var _url='<?php echo ROOTHOST;?>ajaxs/room/process_edit.php';
	var _data={
		'code':'<?php echo $code;?>',
		'name':$('#txt_name').val(),
		'from_room':$('#cbo_room').val()
	}
	$.post(_url,_data,function(req){
		console.log(req);
		if(req=='success'){
			window.location.reload();
		}else{
			$('.mess').html(req);
		}
	})
})
</script>
<?php }else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
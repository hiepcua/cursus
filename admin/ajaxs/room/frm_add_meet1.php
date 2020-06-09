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
?>
<br/>
<h3 class='text-center'>Create a meeting schedule</h3><hr/>
<div class='mess' style='color:#f00;'></div>
<div class="form-group">
	<label>Time range:</label>
	<div class="input-group">
	<div class="input-group-prepend">
	  <span class="input-group-text"><i class="far fa-clock"></i></span>
	</div>
	<input type="text" class="form-control float-right" id="txt_time_range">
	</div>
	<!-- /.input group -->
</div>
<div class='form-group'>
	<label>Title</label>
	<input type='text' class='form-control' id='txt_title' placeholder='Title of the meeting'/>
</div>
<div class='form-group'>
	<label>Intro</label>
	<textarea class='form-control' id='txt_intro' placeholder='Introduction of the meeting'></textarea>
</div>
<div class='form-group text-center' >
	<button class='btn btn-primary' id='btn-add-room'>Continue >></button>
</div>

<script>
$('#txt_time_range').daterangepicker({
	timePicker: true,
	timePickerIncrement: 1,
	locale: {
		format: 'MM/DD/YYYY hh:mm A'
	}
});
$('#btn-add-room').click(function(){
	if($('#txt_title').val()!='' && $('#txt_time_range').val()!=''){
		$(this).hide();
		var _url='<?php echo ROOTHOST;?>ajaxs/room/process_add_meet.php';
		var _data={
			'class_code':'<?php echo $code;?>',
			'time':$('#txt_time_range').val(),
			'title':$('#txt_title').val(),
			'intro':$('#txt_intro').val()
		}
		$.post(_url,_data,function(req){
			if(req=='success'){
				window.location.reload();
			}else{
				$('.mess').html(req);
				$(this).show();
			}
		})
	}else{
		$('.mess').html('Room code or room name is empty!');
	}
})
</script>
<?php }else{
		echo "<div class='red'>No room found! Please select room to continue!</div>";
	}
}else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
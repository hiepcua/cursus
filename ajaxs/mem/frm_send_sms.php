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
	$emails = antiData($_POST['emails']);
?>
<br/>
<h3 class='text-center'><?php echo LANG['COM_MEMBER']['SENDSMS_TITLE'];?></h3>
<div class='mess' style='color:#f00;'></div>

<div class='form-group'>
	<label><?php echo LANG['COM_MEMBER']['SENDSMS_CONTENT'];?></label>
	<textarea class="form-control" id="txt_content" name="txt_content" rows="3"></textarea>
</div>

<div class='form-group text-center' >
	<button class='btn btn-primary' id='btn-add-account'><i class="fa fa-paper-plane" aria-hidden="true"></i> <?php echo LANG['COM_MEMBER']['SENDSMS_SEND'];?></button>
</div>
<script>
$('#btn-add-account').click(function(){
	if($('#txt_content').val()!=''){
		var _url='<?php echo ROOTHOST;?>ajaxs/mem/process_sendsms.php';
		var _data={
			'content': $('#txt_content').val(),
			'emails': '<?php echo $emails; ?>'
		}
		$.post(_url, _data, function(req){
			if(req=='success'){
				window.location.reload();
			}else{
				$('.mess').html(req);
			}
		})
	}else{
		$('.mess').html('<?php echo LANG['COM_MEMBER']['ALERT_REQUIRED_SENDSMS_CONTENT'];?>');
	}
});
</script>
<?php }else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
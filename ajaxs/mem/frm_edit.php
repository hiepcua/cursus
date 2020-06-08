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
	$arr = array();
	$user = antiData($_POST['user']);
	$objMember = SysGetList('tbl_member', array(), " AND username='$user'", true);
	$r = $objMember[0];

	// Check isadmin
	$isadmin=getInfo('isadmin');

	function getListCombobox($parid=0, $level=0){
		$sql="SELECT * FROM tbl_gmember WHERE `par_id`='$parid' AND `isactive`='1' ";
		$objdata=new CLS_MYSQL();
		$objdata->Query($sql);
		$char="";
		if($level!=0){
			for($i=0;$i<$level;$i++)
				$char.="|-----";
		}
		if($objdata->Num_rows()<=0) return;
		while($rows=$objdata->Fetch_Assoc()){
			$id=$rows['id'];
			$parid=$rows['par_id'];
			$title=$rows['name'];
			echo "<option value='$id'>$char $title</option>";
			$nextlevel=$level+1;
			getListCombobox($id,$nextlevel);
		}
	}
	?>
	<br/>
	<h3 class='text-center'><?php echo LANG['COM_MEMBER']['EDIT_TITLE'];?></h3>
	<div class='mess' style='color:#f00;'></div>
	<div class='form-group'>
		<label><?php echo LANG['COM_MEMBER']['FRM_FULLNAME'];?></label>
		<input type='text' class='form-control' id='txt_fullname' value="<?php echo $r['fullname'];?>" placeholder='<label><?php echo LANG['COM_MEMBER']['FRM_PLACEHOLDER_FULLNAME'];?></label>'/>
	</div>
	<?php //if($isadmin == 1){ ?>
		<div class='form-group'>
			<label><?php echo LANG['COM_MEMBER']['FRM_GROUP'];?></label>
			<select id="cbo_gmember" class="form-control" name="cbo_gmember">
				<option value="0">-- <?php echo LANG['COM_MEMBER']['FRM_SELECT_ONCE'];?> --</option>
				<?php getListCombobox(0,0); ?>
			</select>
			<script type="text/javascript">
				$(document).ready(function(){
					cbo_Selected('cbo_gmember', <?php echo $r['gmember']; ?>);
				});
			</script>
		</div>
	<?php //} ?>
	<div class='form-group'>
		<label><i class="fas fa-envelope"></i> <?php echo LANG['COM_MEMBER']['FRM_EMAIL'];?></label>
		<input type='text' class='form-control' id='txt_email' value="<?php echo $r['email'];?>" placeholder='<?php echo LANG['COM_MEMBER']['FRM_PLACEHOLDER_EMAIL'];?>'/>
		<input type='hidden' class='form-control' id='txt_user' value="<?php echo $r['username'];?>"/>
	</div>
	<div class='form-group'>
		<label><i class="fas fa-mobile-alt"></i> <?php echo LANG['COM_MEMBER']['FRM_PHONE'];?></label>
		<input type='text' class='form-control' id='txt_phone' value="<?php echo $r['phone'];?>" placeholder='<?php echo LANG['COM_MEMBER']['FRM_PLACEHOLDER_PHONE'];?>'/>
	</div>
	<div class='form-group text-center' >
		<button class='btn btn-primary' id='btn-add-account'><i class="fas fa-save"></i> <?php echo LANG['COM_MEMBER']['FRM_SAVE'];?> >></button>
	</div>
	<script>
		$('#btn-add-account').click(function(){
			if($('#txt_user').val()!='' && $('#txt_fullname').val()!=''){
				var _url='<?php echo ROOTHOST;?>ajaxs/mem/process_edit.php';
				var _data={
					'user':$('#txt_user').val(),
					'email':$('#txt_email').val(),
					'fullname':$('#txt_fullname').val(),
					'phone':$('#txt_phone').val(),
					'cbo_gmember':$('#cbo_gmember').val(),
				}
				$.post(_url,_data,function(req){
					// console.log(req);
					if(req=='success'){
						window.location.reload();
					}else{
						$('.mess').html(req);
					}
				})
			}else{
				$('.mess').html('<?php echo LANG['COM_MEMBER']['ALERT_REQUIRED_EMAIL'];?>');
			}
		})
	</script>
<?php }else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
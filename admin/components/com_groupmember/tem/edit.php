<?php
$user=getInfo('username');
$isAdmin=getInfo('isadmin');
define('OBJ_PAGE','MEMBER');
if($isAdmin==1){
	$GetID = isset($_GET['id']) ? (int)antiData($_GET['id']) : 0;
	$rows = SysGetList('tbl_gmember', array(), " AND id=$GetID ");
	$row = $rows[0];

	// Get all child by function mysql
	$sql="SELECT GroupMember_GetFamilyTree($GetID) AS 'childs'";
	$objmysql = new CLS_MYSQL();
	$objmysql->Query($sql);
	$childs = $objmysql->Fetch_Assoc();
	$childID = $childs['childs'];
	?>
	<!-- Content Header (Page header) -->
	<div class="widget-tree" style="padding-left: 7px;">
		<header class="header">
			<h2><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp&nbsp<?php echo LANG['COM_GMEMBER']['EDIT_TITLE'];?></h2>
		</header>
	</div>

	<!-- /.content-header -->
	<!-- Main content -->
	<section class="content">
		<div class='container-fluid'>
			<div class="card">
				<form id="frm_add" class="smart-form" method="post" action="" style="padding: 15px 10px;">
					<div class="mess" style="color: red;"></div>
					<div class="row">
						<div class="col-md-6 form-group">
							<label class="label"><?php echo LANG['COM_GMEMBER']['FRM_GROUP'];?><small class="cred">(*)</small></label>
							<select id="cbo_par" name="cbo_par" class="form-control">
								<option value="0"><?php echo LANG['COM_GMEMBER']['FRM_SELECT_ONCE'];?></option>
								<?php getListCombobox(0,0); ?>
							</select>
							<script type="text/javascript">
								$(document).ready(function(){
									cbo_Selected('cbo_par', <?php echo $row['par_id']; ?>);
								});
							</script>
						</div>
						<div class="col-md-6 form-group">
							<label class="label"><?php echo LANG['COM_GMEMBER']['FRM_GROUP_NAME'];?><small class="cred">(*)</small></label>
							<input type="text" name="txt_name" value="<?php echo $row['name'];?>" id="txt_name" class="form-control">
						</div>
					</div>
					<div class="rows">
						<div class="col-md-12 form-group">
							<label class="label"><?php echo LANG['COM_GMEMBER']['FRM_DESC'];?></label>
							<textarea class="form-control" rows="3" id="txt_desc" name="txt_desc"><?php echo $row['intro'];?></textarea>
						</div>
					</div>
					<div class="rows">
						<div class="col-md-12 form_wrap_tool">
							<a href="#" onclick="EditGroupMember()" class="btn btn-primary"><i class="fa fa-plus" aria-hidden="true"></i><?php echo LANG['COM_GMEMBER']['FRM_UPDATE'];?></a>
							<a href="#" onclick="DeleteGroupMember()" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i><?php echo LANG['COM_GMEMBER']['FRM_DEL'];?></a>
							<button type="button" class="btn btn-primary" name="cmd_cancel" id="cmd_cancel" onclick="backPage()"><i class="fa fa-refresh" aria-hidden="true"></i> <?php echo LANG['COM_GMEMBER']['FRM_CANCEL'];?></button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</section>
	<script>
		function EditGroupMember(){
			if(frm_validate()){
				var _url="<?php echo ROOTHOST;?>ajaxs/gmember/process_edit_gmember.php";
				var _data={
					'id': '<?php echo $row["id"];?>',
					'par_id': $('#cbo_par').val(),
					'name': $('#txt_name').val(),
					'intro': $('#txt_desc').val()
				}
				$.post(_url, _data, function(req){
					if(req=='success'){
						window.location.reload();
					}else{
						$('.mess').html(req);
					}
				})
			}
		};

		function frm_validate(){
			var flag=true;
			var par_id = parseInt($('#cbo_par').val());
			var arr_childs = '<?php echo $childID;?>'.split(',');
			var name = $('#txt_name').val();
			if(name == '') {
				flag = false;
				$('.mess').html('<?php echo LANG['COM_GMEMBER']['ALERT_REQUIRED_NAME'];?>');
			}
			if(par_id == 0){
				flag = false;
				$('.mess').html('<?php echo LANG['COM_GMEMBER']['ALERT_REQUIRED_GROUP_NAME'];?>');
			}else if(par_id == '<?php echo $GetID?>'){
				flag = false;
				$('.mess').html('<?php echo LANG['COM_GMEMBER']['ALERT_ERROR_CHILD'];?>');
			}else if(arr_childs.indexOf(par_id) !== -1){
				flag = false;
				$('.mess').html('<?php echo LANG['COM_GMEMBER']['ALERT_ERROR_GROUP_SELECT'];?>');
			}
			return flag;
		};

		function backPage() {
			window.history.back();
		};

		function DeleteGroupMember(){
			var r = confirm("<?php echo LANG['COM_GMEMBER']['ALERT_DELETE'];?>");
			if (r == true) {
				var _url="<?php echo ROOTHOST;?>ajaxs/gmember/process_delete_gmember.php";
				var _data={
					'id': '<?php echo $row["id"];?>',
				}
				$.post(_url, _data, function(req){
					if(req=='success'){
						window.location.href=('<?php echo ROOTHOST;?>groupmember');
					}else{
						$('.mess').html(req);
					}
				})
			}
		}
	</script>
<?php }else{
	echo "<h3 class='text-center'>You haven't permission</h3>";
}?>
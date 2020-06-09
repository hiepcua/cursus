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
	$user=getInfo('username');
	$mType=getInfo('mtype');
	$isAdmin=getInfo('isadmin');
	$code=isset($_GET['code'])?antiData($_GET['code']):'';
	$isTeacher=isTeacher($user,$code);
	?>
	<table class="table">
		<thead>                  
			<tr>
				<th style="width: 10px">
					<div class="custom-control custom-checkbox">
						<input class="custom-control-input chk_all" type="checkbox" id="chk_all" value="option1">
						<label for="chk_all" class="custom-control-label" style='margin-bottom: .5rem;'>&nbsp;</label>
					</div>
				</th>
				<th><div class='col-md-4 col-sm-6'>
					<?php if($isAdmin==1 || $isTeacher==1){?>
					<select id='cbo_action' class='form-control' onchange="onchange_cbo_action();">
						<option value=''>Action</option>
						<option value='send'>Send mail</option>
						<option value='delete'>Reject</option>
					</select>
					<?php }else{?>
					Member Infomation
					<?php }?>
				</div></th>
				<?php if($isAdmin==1 || $isTeacher==1){?>
				<th class='text-center'>isLeader</th>
				<th class='text-right'>
						<button class='btn btn-primary' id='btn_add_room_member'><i class="fas fa-user-plus"></i></button>
				</th>
				<?php }?>
			</tr>
		</thead>
		<tbody>
			<?php
			$strWhere=" AND username in (SELECT username FROM tbl_class_member WHERE class_code='$code')";
			$total=SysCountList('tbl_member',$strWhere);
			if($total>0){
				$sql="SELECT tbl_member.*,tbl_class_member.mtype FROM tbl_member INNER JOIN tbl_class_member ON 
				tbl_member.username=tbl_class_member.username
				WHERE tbl_class_member.class_code='$code' ORDER BY tbl_class_member.mtype DESC";
				$obj=new CLS_MYSQL;
				$obj->Query($sql);
				//$obj=SysGetList('tbl_member',array(),$strWhere,false);
				while($r=$obj->Fetch_Assoc()){
					$avatar = getAvatar($r['avatar'], 'avatar img-circle', '');
					$leader=isTeacher($r['username'],$code)!=1?"":"(Leader)";
					?>
					<tr>
						<td>
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input chk" type="checkbox" id="chk" value="option1">
								<label for="chk" class="custom-control-label" style='margin-bottom: .5rem;'>&nbsp;</label>
							</div>
						</td>
						<td>
							<div style='display:flex;'>
								<div class='wr_avatar pull-right' style='margin-right:15px;'><?php echo $avatar;?></div>
								<div class='info'>
									<h4 class='name'><?php echo $r['fullname'].' '.$leader;?> </h4>
									<div class='user'><?php echo $r['username'];?></div>
									<div class='phone'>Phone: <?php echo $r['phone'];?></div>
									<?php if($r['mtype']!=''){?>
										<div class='teach'>Type:<?php echo $r['mtype'];?></div>
									<?php }?>
								</div>
							</div>
						</td>
						<?php if($isAdmin==1 || $isTeacher==1){?>
						<td class='text-center'>
							<?php $checked=isTeacher($r['username'],$code)!=1?"":"checked=true";?>
							<div class="custom-control custom-checkbox">
								<input class="custom-control-input chk_isteach" <?php echo $checked;?> type="checkbox" id="chk_isteach_<?php echo $r['username'];?>" value="<?php echo $r['username'];?>">
								<label for="chk_isteach_<?php echo $r['username'];?>" class="custom-control-label" style='margin-bottom: .5rem;'>&nbsp;</label>
							</div>
						</td>
						<td class='text-right'>
								<button class='btn btn-danger btn_reject' datauser="<?php echo $r['username'];?>" >Reject</button>
						</td>
						<?php }?>
					</tr>
				<?php }
			}else{
				?>
				<tr>
					<td colspan='4' class='text-center'>No there member yet!</td>
				</tr>
			<?php }?>
		</tbody>
	</table>
	<script>
		$(document).ready(function(){
			$('.chk').click(function(){
				var flag=true;
				$('.chk').each(function(){
					if(!$(this).is(':checked')){flag=false; return;}
				});
				if(flag) $('.chk_all').attr('checked',true);
				else $('.chk_all').attr('checked',false);
			});
			$('.chk_all').click(function(){
				var ischeck=$(this).is(':checked');
				$('.chk').attr('checked',ischeck);
			});
			<?php if($isAdmin==1 || $isTeacher==1){?>
				$('.chk_isteach').click(function(){
					var ischeck=$(this).is(':checked')?'yes':'no';
					if(confirm('You are sure change permission this member?')){
						var _url="<?php echo ROOTHOST;?>ajaxs/room/change_isteach.php";
						var _data={
							'user':$(this).val(),
							'code':'<?php echo $code;?>',
							'ischeck':ischeck
						}
						$.post(_url,_data,function(req){
							$('#room-members').load('<?php echo ROOTHOST;?>ajaxs/room/load_member_room.php?code=<?php echo $code;?>');
						})
					}
				});
				$('.btn_reject').click(function(){
					var ischeck=$(this).is(':checked')?'yes':'no';
					if(confirm('You are sure change permission this member?')){
						var _url="<?php echo ROOTHOST;?>ajaxs/room/reject_member.php";
						var _data={
							'user':$(this).attr('datauser'),
							'code':'<?php echo $code;?>'
						}
						$.post(_url,_data,function(req){
							$('#room-members').load('<?php echo ROOTHOST;?>ajaxs/room/load_member_room.php?code=<?php echo $code;?>');
						})
					}
				});
			<?php }?>
			$('#btn_add_room_member').click(function(){
				var _url="<?php echo ROOTHOST;?>ajaxs/room/frm_add_member.php";
				var _data={'class_code':'<?php echo $code;?>'}
				$.get(_url,_data,function(req){
					$('#popup_modal .modal-body').html(req);
					$('#popup_modal').modal('show')
				})
			});
		});
	</script>
<?php }else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
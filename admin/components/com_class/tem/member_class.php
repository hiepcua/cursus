<?php 
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
				<input type="hidden" id="txtids">
				<select id='cbo_action' class='form-control'>
					<option value=''>Action</option>
					<option value='send_mail'>Send mail</option>
					<option value='send_sms'>Send SMS</option>
					<option value='delete'>Reject</option>
				</select>
			</div></th>
			<th class='text-center'>isLeader</th>
			<th class='text-right'>
				<?php if($isAdmin==1){?>
					<button class='btn btn-primary' id='btn_add_room_member'><i class="fas fa-user-plus"></i></button>
				<?php }?>
			</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$strWhere=" AND username in (SELECT username FROM tbl_class_member WHERE class_code='$code')";
		$total=SysCountList('tbl_member',$strWhere);
		if($total>0){
			$obj=SysGetList('tbl_member',array(),$strWhere,false);
			while($r=$obj->Fetch_Assoc()){
				?>
				<tr>
					<td>
						<div class="custom-control custom-checkbox">
							<input class="custom-control-input chk" type="checkbox" id="chk_<?php echo $r['username'];?>" name="chk" value="<?php echo $r['username'];?>">
							<label for="chk" class="custom-control-label" style='margin-bottom: .5rem;'>&nbsp;</label>
						</div>
					</td>
					<td>
						<div style='display:flex;'>
							<div class='info'>
								<h4 class='name'><?php echo $r['fullname'];?></h4>
								<div class='user'><?php echo $r['username'];?></div>
								<div class='phone'>Phone: <?php echo $r['phone'];?></div>
								<?php if($r['mtype']!=''){?>
									<div class='teach'>Type:<?php echo $r['mtype'];?></div>
								<?php }?>
							</div>
						</div>
					</td>
					<td class='text-center'>
						<?php $checked=isTeacher($r['username'],$code)!=1?"":"checked=true";?>
						<div class="custom-control custom-checkbox">
							<input class="custom-control-input chk_isteach" <?php echo $checked;?> type="checkbox" id="chk_isteach_<?php echo $r['username'];?>" value="<?php echo $r['username'];?>">
							<label for="chk_isteach_<?php echo $r['username'];?>" class="custom-control-label" style='margin-bottom: .5rem;'>&nbsp;</label>
						</div>
					</td>
					<td class='text-right'>
						<?php if($isAdmin==1 || $isTeacher==1){?>
							<button class='btn btn-danger btn_reject' datauser="<?php echo $r['username'];?>" >Reject</button>
						<?php }?>
					</td>
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
						console.log(req);
						window.location.reload();
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
						console.log(req);
						window.location.reload();
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

		$('#cbo_action').change(function(){
			getIDchecked('chk');
			var emails = $('#txtids').val();

			if(emails === ''){
				alert('You have not selected any objects');
				$('#frm_list').submit();
			}
			var action = $(this).val();
			var str_email = emails.split(',').toString();

			if(action === 'trash'){
				/*Move item to trash.*/
				var username = $(this).attr('data-username');
				var _url="<?php echo ROOTHOST;?>ajaxs/mem/process_move_to_trash.php";
				var _data={
					'user': str_email
				}
				if (confirm('Are you sure you want move the marked objects to the trash?')) {
					$.post(_url, _data, function(req){
						if(req == 'success'){
							window.location.reload();
						}else{
							console.log('err');
						}
					});
				}
				$('#frm_list').submit();
			}else if(action === 'send_mail'){
				/*Send mail all item checked.*/
				var _url="<?php echo ROOTHOST;?>ajaxs/mem/frm_send_mail.php";
				var _data = {
					"emails" : emails,
				};

				$.post(_url, _data, function(req){
					$('#popup_modal .modal-body').html(req);
					$('#popup_modal').modal('show')
				});
			}else if(action === 'send_sms'){
				/*Send mail all item checked.*/
				var _url="<?php echo ROOTHOST;?>ajaxs/mem/frm_send_sms.php";
				var _data = {
					"emails" : emails,
				};

				$.post(_url, _data, function(req){
					$('#popup_modal .modal-body').html(req);
					$('#popup_modal').modal('show')
				});
			}else{
				$('#frm_list').submit();
			}
		});
	});
</script>
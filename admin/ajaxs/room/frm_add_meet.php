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
		<div class='form-group'>
			<div class='row'>
				<div class='col-sm-6'>
					<label>From time</label>
					<div class="input-group bootstrap-timepicker timepicker">
						<input id="stime" type="text" class="form-control input-small">
						<span class="input-group-prepend">
							<span class='input-group-text'><i class="far fa-clock"></i></span>
						</span>
					</div>
				</div>
				<div class='col-sm-6'>
					<label>To time</label>
					<div class="input-group bootstrap-timepicker timepicker">
						<input id="ttime" type="text" class="form-control input-small">
						<span class="input-group-prepend">
							<span class='input-group-text'><i class="far fa-clock"></i></span>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class='form-group'>
			<label>Lặp lại:</label>
			<div class='row'>
				<div class='col-sm-5'>
					<select id='cbo_loop_type' class='form-control'>
						<option value='4'>Không lặp lại</option>
						<option value='1'>Hằng ngày</option>
						<option value='2'>Hằng tuần</option>
						<option value='3'>Hằng tháng</option>
					</select>
				</div>
				<div class='col-sm-7'>
					<input type='date' id='txt_day' class='form-control' />
				</div>
			</div>
		</div>
		<div class='form-group config_week'>
			<label>Lặp lại vào thứ</label>
			<span class='day_of_week' dataval='1'>T2</span>
			<span class='day_of_week' dataval='2'>T3</span>
			<span class='day_of_week' dataval='3'>T4</span>
			<span class='day_of_week' dataval='4'>T5</span>
			<span class='day_of_week' dataval='5'>T6</span>
			<span class='day_of_week' dataval='6'>T7</span>
			<span class='day_of_week' dataval='0'>CN</span>
		</div>
		<div class='form-group config_month'>
			<label>Lặp lại mùng</label>
			<input type='text' id='txt_day_list' class='form-control' max=31 min=1 placeholder='1,2,3,4,5' />
		</div>
		<div class='form-group config_finish_loop' >
			<label>Kết thúc</label>
			<div class="form-group clearfix icheck-success">
				<input type="radio" name="r3" class='opt_finish' value='1' checked id="radioSuccess1">
				<label for="radioSuccess1">Không bao giờ</label>
			</div>
			<div class="form-group clearfix icheck-success">
				<input type="radio" name="r3" class='opt_finish' value='2' id="radioSuccess2">
				<label for="radioSuccess2">Đến ngày: </label>
				<div class='' style='width:185px;display: inline-block;'>
					<input type='date' id='txt_finish_date' class='form-control' />
				</div>
			</div>
			<div class="form-group clearfix icheck-success">
				<input type="radio" name="r3" class='opt_finish' value='3' id="radioSuccess3">
				<label for="radioSuccess3">Lặp được: </label>
				<span><div class='' style='width:50px;display: inline-block;'>
					<input type='text' id='txt_finish_loop' class='form-control' value='10' />
				</div> lần</span>
			</div>
		</div>
		<style>
			.day_of_week{
				width:30px;height:30px;display:inline-block;text-align:center;line-height:30px;;border-radius:50%;background:#f1f1f1;
				cursor:pointer;
			}
			.day_of_week.active{
				background:#007bff;color:#fff;
			}
		</style>
		<hr/>
		<div class='form-group'>
			<label>Tiêu đề</label>
			<input type='text' class='form-control' id='txt_title' placeholder='Title of the meeting'/>
		</div>
		<div class='form-group'>
			<label>Giới thiệu</label>
			<textarea class='form-control' id='txt_intro' placeholder='Introduction of the meeting'></textarea>
		</div>
		<div class='form-group text-center' >
			<button class='btn btn-primary' id='btn-add-room'>Continue >></button>
		</div>
		<script>
			$(document).ready(function(){
				$('#check_type').bootstrapSwitch('state');
				$('#stime,#ttime').timepicker();
				$('.config_week').hide();
				$('.config_month').hide();
				$('.config_year').hide();
				$('.config_finish_loop').hide();
				$('#cbo_loop_type').change(function(){
					if($(this).val()!='4'){
						$('#txt_day').hide();
						$('.config_finish_loop').show();
					}else{
						$('#txt_day').show();
						$('.config_finish_loop').hide();
					}
					if($(this).val()=='2'){
						$('.config_week').show();
						$('.config_month').hide();
					}else if($(this).val()=='3'){
						$('.config_week').hide();
						$('.config_month').show();
					}else{
						$('.config_week').hide();
						$('.config_month').hide();
					}
				})
				$('.day_of_week').click(function(){
					if($(this).hasClass("active"))$(this).removeClass('active');
					else $(this).addClass('active');
				});
				$('.opt_finish').each(function(){
					if($(this).is(':checked'));
					//console.log($(this).val());
				});
				$('#btn-add-room').click(function(){
					var thisButton=$(this);
					var loop_type=$('#cbo_loop_type').val();
					var day_of_week='';
					$('.day_of_week').each(function(){
						if($(this).hasClass("active")) day_of_week+=$(this).attr('dataval')+',';
					});
					var opt_finish='';
					$('.opt_finish').each(function(){
						if($(this).is(':checked')) opt_finish=$(this).val();
					});
					if(loop_type=='4'){
						if($('#txt_day').val()==''){
							$('.mess').html('Day meeting is required!');
							return;
						} 
					}else if(loop_type=='2'){
						if(day_of_week==''){
							$('.mess').html('Select day of week for loop meeting!');
							return;
						} 
					}else if(loop_type=='3'){
						if($('#txt_day_list')==''){
							$('.mess').html('Day of month for loop meeting are required!');
							return;
						} 
					}else{
					}	
					if(opt_finish==2){
						if($('#txt_finish_date').val()==''){
							$('.mess').html('Finish date is required!');
							return;
						}
					}
					if(opt_finish==3){
						if($('#txt_finish_loop').val()==''){
							$('.mess').html('Number loop is required!');
							return;
						}
					}
					if($('#txt_title').val()!=''){
						$(thisButton).hide();
						var _url='<?php echo ROOTHOST;?>ajaxs/room/process_add_meet.php';
						var _data={
							'class_code':'<?php echo $code;?>',
							'stime':$('#stime').val(),
							'ttime':$('#ttime').val(),
							'loop_type':$('#cbo_loop_type').val(),
							'day':$('#txt_day').val(),
							'day_list':$('#txt_day_list').val(),
							'day_of_week':day_of_week,
							'opt_finish':opt_finish,
							'finish_date':$('#txt_finish_date').val(),
							'finish_loop':$('#txt_finish_loop').val(),
							'title':$('#txt_title').val(),
							'intro':$('#txt_intro').val()
						}
						$.post(_url,_data,function(req){
							if(req=='success'){
								window.location.reload();
							}else{
								$('.mess').html(req);
								$(thisButton).show();
							}
						})
					}else{
						$('.mess').html('Room code or room name is empty!'); return;
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
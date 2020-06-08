<?php
// Init variables
$inviteToken = $inviteCode = '';
$user=getInfo('username');
$isAdmin=getInfo('isadmin');
if($isAdmin==1){
	$now=time();	
	$strWhere="";
	$status = isset($_GET['s']) ? antiData($_GET['s']) : '';
	$room = isset($_GET['r']) ? antiData($_GET['r']) : '';
	$fdate = isset($_GET['fdate']) ? antiData($_GET['fdate']) : '';
	$tdate = isset($_GET['tdate']) ? antiData($_GET['tdate']) : '';
	if($fdate!='' && $tdate=='') $tdate=date('Y-m-d');
	if($tdate<$fdate) $tdate=$fdate;

// Gán strwhere
	if($status != '' && $status == 'finished' ){
		$strWhere.=" AND status=1 ";
	}else{
		$strWhere.=" AND status!=1 ";
	}
	if($fdate!=''){
		$strWhere.=" AND stime>=".strtotime($fdate)." AND stime< ".strtotime($tdate);
	}
	if($room!=''){
		$strWhere.=" AND class_code='$room' ";
	}
	?>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Schedule Meeting</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Home</a></li>
						<li class="breadcrumb-item active">Schedule</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	<section class="content"><div class='container-fluid'>
		<div class="card">
			<form id='frm_search' method='get' action=''><br/>
				<input type='hidden' id='txt_status' name='s' value='<?php echo $status;?>' />
				<div class='col-sm-12'><div class='row'>
					<div class='col-sm-3'><div class='form-group'>
						<input type='date' id='txt_fdate' name='fdate' value='<?php echo $fdate;?>' class='form-control'/>
					</div></div>
					<div class='col-sm-3'><div class='form-group'>
						<input type='date' id='txt_tdate' name='tdate' value='<?php echo $tdate;?>' class='form-control'/>
					</div></div>
					<div class='col-sm-2'><div class='form-group'>
						<select class='form-control' name='r' id='cbo_room'>
							<option value=''>Tất cả</option>
							<?php 
							$obj=SysGetList('tbl_class',array(),"",false);
							while($r=$obj->Fetch_Assoc()){
								$select=$room==$r['code']?"selected=true":"";
								?>
								<option <?php echo $select;?> value='<?php echo $r['code'];?>'><?php echo $r['name'];?></option>
							<?php }?>
						</select>
					</div></div>
					<div class='col-sm-4 text-right'><div class='form-group'>
						<?php if($status=='finished'){?>
							<button type='button' class='btn btn-default' id='btn_list_meeting' ><i class="fas fa-list"></i> Danh sách </button>
						<?php }else{?>
							<button type='button' class='btn btn-default' id='btn_list_finish_meeting' > Finished</button>
						<?php }?>
					</div></div>
				</div></div>
				<script>
					$('#txt_fdate,#txt_tdate').keyup(function(e){
						if (e.which == 13) {
							$('#frm_search').submit();
							e.preventDefault();
							return false;
						}
					});
					$('#cbo_room').change(function(){
						$('#frm_search').submit();
						return false;
					});
					$('#btn_list_finish_meeting').click(function(){
						$('#txt_status').val('finished');
						$('#frm_search').submit();
					});
					$('#btn_list_meeting').click(function(){
						$('#txt_status').val('');
						$('#frm_search').submit();
					});
				</script>
			</form>
			<div class='table-responsive'>
				<table class="table">
					<thead>                  
						<tr>
							<th style="width: 10px">#</th>
							<th>Infomation</th>
							<th width='200'>Time</th>
							<th width='200'>Get link</th>
							<th width='150' class='text-center'>Status</th>
							<th width='120'>Record</th>
							<th width='30'></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$now=time();
						$total=SysCountList('tbl_schedule',$strWhere);
						if($total>0){
							$strWhere.=" ORDER BY loop_type ASC, stime DESC ";
							$obj=SysGetList('tbl_schedule',array(),$strWhere,false);
							$stt=0;
							$bbb=new BigBlueButton();
							while($r=$obj->Fetch_Assoc()){ $stt++;
								$meetingId=$r['id'];
								try {$resultURL = $bbb->isMeetingRunningWithXmlResponseArray($meetingId);}
								catch (Exception $i) {
									echo 'Caught exception: ', $i->getMessage(), "\n";
								}
								if($resultURL==null) echo "Failed to get any response. Maybe we can't contact the BBB server.";
								$meetStatus=(array)$resultURL['running'];
								$inviteToken=$r['id'];
								$inviteCode = un_unicode($r['title']);
								
								$now=time();
								$status=0;
								$nextDay=0;
								$lenDay=0;
								if((int)$r['loop_type']==4){
									$stime=$r['stime'];
									$ttime=$r['ttime'];
									if($now<$stime) $status=0;
									if($now>=$stime && $now<=$ttime)$status=1; // running
									if($now>$ttime) $status=2; //finish
								}else{
									$stime=strtotime(date('Y-m-d'))+$r['stime'];
									$ttime=strtotime(date('Y-m-d'))+$r['ttime'];
									if((int)$r['loop_finish']==2){
										if($now>$r['loop_finish_day'])$status=2; 
									}
									if((int)$r['loop_finish']==3){
										if($r['loop_num']+1>$r['loop_finish_num']) $status=2; 
									}
									if($status!=2){
										if((int)$r['loop_type']==1){
											if($now<$stime) $status=0;
											if($now>=$stime && $now<=$ttime) $status=1;
											if($now>$ttime){
												$status=4;
											}
										}else{
											$thisDay=date('w');
											if((int)$r['loop_type']==3){
												$thisDay=date('d');
											}
											$day_list=explode(',',$r['loop_day']);
											if(in_array($thisDay,$day_list)){
												if($now<$stime) $status=0;
												if($now>=$stime && $now<=$ttime)$status=1;
												if($now>$ttime){
													$status=4;
												}
											}else{
												$status=4;
												$n=count($day_list);
												$flag=false;
												for($i=0;$i<$n;$i++){
													if($thisDay<$day_list[$i]){
														$flag=true;
														$lenDay=$day_list[$i]-$thisDay+1;
														$nextDay=$day_list[$i];
														break;
													}
												}
												if(!$flag){
													if((int)$r['loop_type']==3)
														$lenDay=$day_list[0]+(date('t')-$thisDay)+1;
													else
														$lenDay=($day_list[0])+(6-$thisDay)+1;
													$nextDay=$day_list[0];
												}
											}
										}
									}
								}
								if($status==2){// update finish for meeting
									SysEdit('tbl_schedule',array('status'=>1)," id='$meetingId'");
								}
								$isTeacher=isTeacher($user,$r['class_code']);
								?>
								<tr>
									<td><?php echo $stt;?></td>
									<td>
										<div style='display:flex;'>
											<div class='avatar pull-left' style='padding-right:15px;'>
												<img class="img-circle" width='75' src="<?php echo ROOTHOST;?>global/img/room.png" alt="User Avatar">
											</div>
											<div class='info'>
												<h4 class='title'><?php echo $r['title'];?></h4>
												<div class='info'><?php echo str_replace("\n",'<br/>',$r['intro']);?></div>
												<div class='cdate'><i class="fas fa-calendar-alt"></i> Create: <?php echo time_ago($r['cdate']);?></div>
												<div class='attach'><i class="fas fa-paperclip"></i> Attach:</div>
											</div>
										</div>
									</td>
									<td>
										<div>Room: <strong class='pull-right'>#<?php echo $r['class_code'];?></strong></div> 
										<div>Start: <strong class='pull-right'><?php echo date("H:i",$stime);?></strong></div> 
										<div>End: <strong class='pull-right'><?php echo date("H:i",$ttime);?></strong></div>
										<?php if((int)$r['loop_type']==4){?>
											<div>Day: <strong class='pull-right'><?php echo date("d-m-Y",$r['ttime']);?></strong></div>
										<?php }else{
											$loop_type='Hàng ngày';
											$day_list='';
											$arr_dayWeek=array('CN','T2','T3','T4','T5','T6');
											if((int)$r['loop_type']==2){
												$loop_type='Hàng tuần';
												$arr_day=explode(',',$r['loop_day']);
												$day_list='<strong>Các thứ:</strong>';
												foreach($arr_day as $val){
													if($val!='' && isset($arr_dayWeek[$val])) $day_list.=$arr_dayWeek[$val].',';
												}
												$day_list=$day_list!=''?substr($day_list,0,strlen($day_list)-1):'';
											}
											if((int)$r['loop_type']==3){
												$loop_type='Hàng tháng';
												$arr_day=explode(',',$r['loop_day']);
												$day_list='<strong>Các ngày:</strong>';
												foreach($arr_day as $val){
													if($val!='' && (int)$val<=31) $day_list.=$val.',';
												}
												$day_list=$day_list!=''?substr($day_list,0,strlen($day_list)-1):'';
											}
											?>
											<div><strong>Nhắc lại:</strong> <?php echo $loop_type;?></div>
											<div><?php echo $day_list;?></div>
										<?php }?>  
									</td>
									<td>
										<?php
										if($status!==2){
											echo "<p><button class='btn btn-primary' dataid='".$inviteCode."' onclick=\"get_reg_link(this)\">Register link</button></p>";
											echo "<div><button class='btn btn-primary' dataid='".$inviteCode."' onclick=\"get_invite_link(this)\">Get link invite</button></div>";
										}
										?>
									</td>
									<td class='text-center'>
										<?php
										$now=time();
										if($status==2){
											echo "Finished";
										}elseif($status==4){
											if($nextDay>0){
												if((int)$r['loop_type']==2){
													echo "<div>T".($nextDay+1)."</div>";
												}else{
													echo "<div>ngày ".$nextDay."</div>";
												}
												echo "<div> ($lenDay ngày nữa)</div>";
											}
										}elseif($status==0){
											?>
											<button class='btn btn-warning btn_timer' datatime='<?php echo $stime; ?>'>00:00:00</button>
											<?php
										}elseif($status==1){ 
											if($meetStatus[0]=="false"){
												$title="";
												$label="Start meeting now";
											}else{
												$title="Meeting is runing";
												$label="Join now";
											}
											?>
											<div><?php echo $title;?></div>
											<div><a href='<?php echo ROOTHOST;?>meeting/<?php echo $inviteCode;?>' target='_blank' class='btn btn-success'><?php echo $label;?></a></div>
											<?php if($isTeacher==1){?>
												<div><a href='javascript:void(0)' dataid='<?php echo $inviteCode;?>' class="btn_invite">Link invite</a></div>
											<?php }?>
										<?php }?>
									</div>
								</td>
								<td>
									<div>Latest video: </div>
									<a href='javascript:void(0)' class='record_list'  dataid='<?php echo $inviteToken;?>'>See all record</a>
								</td>
								<td>
									<a href='javascript:void(0)' class='btn_delete'  dataid='<?php echo $r['id'];?>'><i class="fas fa-trash "></i></a>
								</td>
							</tr>
						<?php }
					}else{
						?>
						<tr>
							<td colspan='6' class='text-center'>No there room yet!</td>
						</tr>
					<?php }?>
				</tbody>
			</table>
			<script>
				$('.btn_delete').click(function(){
					if(confirm('Bạn chắc chắn muốn xóa cuộc họp này?')){
						var thisCode=$(this).attr('dataid');
						var _url="<?php echo ROOTHOST;?>ajaxs/room/process_delete_meet.php?id="+thisCode;
						$.get(_url,function(req){
							// console.log(req);
							window.location.reload();
						})
					}
				})
				$('.record_list').click(function(){
					var thisCode=$(this).attr('dataid');
					var _url="<?php echo ROOTHOST;?>bbb/list_video.php?meet_id="+thisCode;
					$.get(_url,function(req){
						console.log(req);
						$('#popup_modal .modal-body').html(req);
						$('#popup_modal').modal('show')
					})
				});

				$('.btn_invite').click(function(){
					var _url="<?php echo ROOTHOST;?>ajaxs/schedule/frm_social_invite.php";
					var _data={
						'invite_token':$(this).attr('dataid'),
					}
					$.post(_url, _data, function(req){
						$('#popup_modal .modal-body').html(req);
						$('#popup_modal').modal('show')
					});
				});

				function subStr(str){
					nstr=str.substring(str.length-2);
					return nstr;
				}
				function countDown(){
					/*Update the count down every 1 second*/
					var x = setInterval(function() {
						/*Get today's date and time*/
						var now = new Date().getTime();
						/*Find the distance between now and the count down date*/
						$('.btn_timer').each(function(){
							var countDownDate=Math.ceil(parseInt($(this).attr('datatime'))*1000);
							var distance = countDownDate - now;
							/*Time calculations for days, hours, minutes and seconds*/
							var days = Math.floor(distance / (1000 * 60 * 60 * 24));
							var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
							var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
							var seconds = Math.floor((distance % (1000 * 60)) / 1000);
							/*Display the result in the element with id="demo"*/
							strTime='';
							strTime+=days>0?days + "d ":"";
							strTime+=hours>0?subStr('00'+hours) + ":":"00:";
							strTime+=minutes>0?subStr('00'+minutes) + ":":"00:";
							strTime+=seconds>0?subStr('00'+seconds):"00";
							$(this).html(strTime);
							/*If the count down is finished, write some text*/
							if (distance <= 0) {
								clearInterval(x);
								window.location.reload();
							}
						});
					}, 1000);
				}
				countDown();

				function get_invite_link(attr) {
					var thisCode = attr.getAttribute('dataid');
					var text = '<?php echo ROOTHOST."guest/";?>'+thisCode;

					var textArea = document.createElement("textarea");
					textArea.value = text;

					document.body.appendChild(textArea);
					textArea.select();

					try {
						var successful = document.execCommand('copy');
						var msg = successful ? 'successful' : 'unsuccessful';
						alert('Copying invite link ' + msg);
					} catch (err) {
						alert('Oops, unable to copy');
					}

					document.body.removeChild(textArea);
				}
				function get_reg_link(attr) {
					var thisCode = attr.getAttribute('dataid');
					var text = '<?php echo ROOTHOST."reg/";?>'+thisCode;

					var textArea = document.createElement("textarea");
					textArea.value = text;

					document.body.appendChild(textArea);
					textArea.select();

					try {
						var successful = document.execCommand('copy');
						var msg = successful ? 'successful' : 'unsuccessful';
						alert('Copying register link ' + msg);
					} catch (err) {
						alert('Oops, unable to copy');
					}

					document.body.removeChild(textArea);
				}
			</script>
		</div>
	</div>
</div></section>
<?php }else{
	echo "<h3 class='text-center'>You haven't permission</h3>";
}
?>
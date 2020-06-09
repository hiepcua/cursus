<?php
$user=getInfo('username');
$isAdmin=getInfo('isadmin');
define('OBJ_PAGE','MEMBER');
if($isAdmin==1){
	$strWhere="";
	$status = isset($_GET['s']) ? antiData($_GET['s']) : '';
	$room = isset($_GET['r']) ? antiData($_GET['r']) : '';
	$q = isset($_GET['q']) ? antiData($_GET['q']) : '';
	// Gán strwhere
	if($status != '' && $status == 'trash' ){
		$strWhere.=" AND `is_trash` = 1";
	}else{
		$strWhere.=" AND `is_trash` = 0";
	}
	if($q!=''){
		$strWhere.=" AND (`fullname` LIKE '%$q%' OR `email` LIKE '%$q%' OR  `phone` LIKE '%$q%') ";
	}
	if($room!=''){
		$strWhere.=" AND username IN (SELECT username FROM tbl_class_member WHERE class_code='$room') ";
	}
	// Begin pagging
	if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
	}
	if(isset($_POST['txtCurnpage'])){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
	}

	$total = SysCount('tbl_member', $strWhere);
	$total_rows = $total;
	$max_rows = 10;

	if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
	}
	$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
	// End pagging
	?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#cbo_action').change(function(){
				$('#frm_list').submit();
			});
		});

		function cbo_Selected(id, value){
			var obj=document.getElementById(id);
			for(i=0;i<obj.length;i++){
				if(obj[i].value==value)
					obj.selectedIndex=i;
			}
		}
	</script>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Members</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Home</a></li>
						<li class="breadcrumb-item active">Members</li>
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
			<div class='col-sm-12'><div class='row'>
				<div class='col-sm-3'><div class='form-group'>
					<input type='text' id='txt_keyword' name='q' value='<?php echo $q;?>' class='form-control' placeholder='Tên, email hoặc số điện thoại'/>
					<input type='hidden' id='txt_status' name='s' value='<?php echo $status;?>' />
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
				<div class='col-sm-7 text-right'><div class='form-group'>
					<?php if($status=='trash'){?>
					<button type='button' class='btn btn-default' id='btn_list_member' ><i class="fas fa-list"></i> Danh sách </button>
					<?php }else{?>
					<button type='button' class='btn btn-default' id='btn_list_trash_member' ><i class="fas fa-trash"></i> Trash</button>
					<?php }?>
				</div></div>
			</div></div>
			<script>
			$('#txt_keyword').keyup(function(e){
				if (e.which == 13) {
					// Enter key pressed
					$('#frm_search').submit();
					e.preventDefault();
					return false;
				}
			});
			$('#cbo_room').change(function(){
				$('#frm_search').submit();
			})
			$('#btn_list_trash_member').click(function(){
				$('#txt_status').val('trash');
				$('#frm_search').submit();
			});
			$('#btn_list_member').click(function(){
				$('#txt_status').val('');
				$('#frm_search').submit();
			});
			</script>
			</form>
			<div class="table-responsive">
				<table class="table">
					<thead>                  
						<tr>
							<th style="width: 10px">
								<div class="custom-control custom-checkbox">
									<input class="custom-control-input chk_all" type="checkbox" id="chk_all" value="option1">
									<label for="chk_all" class="custom-control-label" style='margin-bottom: .5rem;'>&nbsp;</label>
								</div>
							</th>
							<th>
								<form id="frm_list" method="get" action="<?php echo ROOTHOST.$COM;?>">
									<div class='col-md-4 col-sm-6'>
										<select id='cbo_action' name="cbo_action" class='form-control'>
											<option value=''>Action</option>
											<option value='send'>Send mail</option>
											<option value='trash'>Trash</option>
										</select>
									</div>
								</form>
							</th>
							<th class='text-center'>Admin</th>
							<th class='text-right'>
								<?php if($isAdmin=='1'){?>
									<button class='btn btn-primary' id='btn_add_member'><i class="fas fa-user-plus"></i></button>
								<?php }?>
							</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($total>0){
							$start = ($cur_page - 1) * $max_rows;
							$strWhere.=" LIMIT $start,".$max_rows;
							$obj=SysGetList('tbl_member', array(), $strWhere, false);
							while($r=$obj->Fetch_Assoc()){
								$avatar = getAvatar($r['avatar'], 'avatar img-circle', '');
								?>
								<tr>
									<td>
										<div class="custom-control custom-checkbox">
											<input class="custom-control-input chk" type="checkbox" id="chk_<?php echo $r['username'];?>" value="<?php echo $r['username'];?>">
											<label for="chk_<?php echo $r['username'];?>" class="custom-control-label" style='margin-bottom: .5rem;'>&nbsp;</label>
										</div>
									</td>
									<td>
										<div style='display:flex;'>
											<div class='wr_avatar pull-right' style='margin-right:15px;'><?php echo $avatar;?></div>
											<div class='info'>
												<h4 class='name'><?php echo $r['fullname'];?></h4>
												<div class='user'><?php echo $r['username'];?></div>
												<div class='phone'>Phone: <?php echo $r['phone'];?></div>
											</div>
										</div>
									</td>
									<td class='text-center'>
										<?php $checked=(int)$r['isadmin']!=1?"":"checked=true";?>
										<div class="custom-control custom-checkbox">
											<input class="custom-control-input chk_isadmin" <?php echo $checked;?> type="checkbox" id="chk_isadmin_<?php echo $r['username'];?>" value="<?php echo $r['username'];?>">
											<label for="chk_isadmin_<?php echo $r['username'];?>" class="custom-control-label" style='margin-bottom: .5rem;'>&nbsp;</label>
										</div>
									</td>
									<td class='text-right'>
										<i class="fas fa-edit btn_edit_member" data-username="<?php echo $r['username'];?>"></i>
										<i class="fas fa-trash btn_trash_member" data-username="<?php echo $r['username'];?>"></i>
										
									</td>
								</tr>
							<?php }
						}else{
							?>
							<tr>
								<td colspan='3' class='text-center'>No there member yet!</td>
							</tr>
						<?php }?>
					</tbody>
				</table>
			</div>
			<nav class="d-flex justify-content-center">
				<?php paging($total_rows, $max_rows, $cur_page);?>
			</nav>
		</div>
	</div>
</section>
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
		$('.chk_isadmin').click(function(){
			var ischeck=$(this).is(':checked')?'yes':'no';
			if(confirm('You are sure change permission this member?')){
				var _url="<?php echo ROOTHOST;?>ajaxs/mem/change_isadmin.php";
				var _data={
					'user':$(this).val(),
					'ischeck':ischeck
				}
				$.post(_url,_data,function(req){
					/*alert('Change permission success!');*/
					// console.log(req);
					window.location.reload();
				})
			}
		});
		$('#btn_add_member').click(function(){
			var _url="<?php echo ROOTHOST;?>ajaxs/mem/frm_add.php";
			$.get(_url,function(req){
				$('#popup_modal .modal-body').html(req);
				$('#popup_modal').modal('show')
			});
		});
		$('.btn_edit_member').click(function(){
			var username = $(this).attr('data-username');
			var _url="<?php echo ROOTHOST;?>ajaxs/mem/frm_edit.php";
			var _data={
				'user': username
			}
			$.post(_url, _data, function(req){
				// console.log(req);
				$('#popup_modal .modal-body').html(req);
				$('#popup_modal').modal('show')
			});
		});
		$('.btn_trash_member').click(function(){
			var username = $(this).attr('data-username');
			var _url="<?php echo ROOTHOST;?>ajaxs/mem/process_delete.php";
			var _data={
				'user': username
			}
			if (confirm('Are you sure you want move to trash?')) {
				$.post(_url, _data, function(req){
					console.log(req);
					if(req == 'success'){
						window.location.reload();
					}else{
						console.log('err');
					}
				});
			}
		});
	});
</script>
<?php }else{
	echo "<h3 class='text-center'>You haven't permission</h3>";
}?>
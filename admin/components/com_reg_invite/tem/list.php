<?php
define('OBJ_PAGE','REG_INVITE');
$res_reg = SysGetList('tbl_reg_invite', array());
$__arr_Schedule = array();
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark" style="text-transform: uppercase;"><?php echo LANG['COM_REG_INVITE']['COM_TITLE'];?></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item active"><?php echo LANG['COM_REG_INVITE']['COM_TITLE'];?></li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div id='action'>
			<?php
			$strWhere="";
			$get_c = isset($_GET['c']) ? (int)antiData($_GET['c']) : 0;

			/*Gán strWhere*/
			if($get_c!=''){
				$strWhere.=" AND schedule_id=".$get_c;
			}
			/*Begin pagging*/
			if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
				$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
			}
			if(isset($_POST['txtCurnpage'])){
				$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
			}

			$total = SysCountList('tbl_reg_invite', $strWhere);
			$total_rows = $total;
			$max_rows = 20;

			if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
				$_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
			}
			$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
			/*End pagging*/
			?>
			<div class="widget-frm-search">
				<form id='frm_search' method='get' action=''><br/>
					<div class='row'>
						<div class='col-sm-3'>
							<div class='form-group'>
								<select name="c" class="form-control" id="cbo_schedule">
									<option value="">-- Chọn một --</option>
									<?php
									$res_schedule = SysGetList('tbl_schedule', array());
									if(count($res_schedule)>0){
										foreach ($res_schedule as $k => $v) {
											echo '<option value="'.$v['id'].'">'.$v['title'].'</opntion>';
											$__arr_Schedule[$v['id']] = $v;
										}
									}
									?>
								</select>
								<script type="text/javascript">
									$(document).ready(function(){
										cbo_Selected('cbo_schedule', <?php echo $get_c; ?>);
									});
								</script>
							</div>
						</div>
						<div class="col-sm-1"><input type="submit" name="" class="btn btn-primary" value="Tìm kiếm"></div>
						<div class="col-sm-6"></div>
						<div class="col-sm-2">
							<a href="<?php echo ROOTHOST;?>categories/add" class="btn btn-primary float-sm-right">Thêm mới</a>
						</div>
					</div>
				</form>
			</div>
			<div class="table-responsive card">
				<table class="table">
					<thead>                  
						<tr>
							<th>Họ tên</th>
							<th>Số điện thoại</th>
							<th>Đơn vị</th>
							<th>Online/ Offline</th>
							<th>Schedule</th>
							<th class="text-center">Hiển thị</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($total>0){
							$start = ($cur_page - 1) * $max_rows;
							$strWhere.=" LIMIT $start,".$max_rows;
							$obj=SysGetList('tbl_reg_invite', array(), $strWhere, false);
							while($r=$obj->Fetch_Assoc()){
								$ids = $r['id'];
								if($r['isactive'] == 1) 
									$icon_active    = "<i class='fas fa-toggle-on cgreen'></i>";
								else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';
								$schedule = array_key_exists($r['schedule_id'], $__arr_Schedule) ? $__arr_Schedule[$r['schedule_id']]['title'] : '<i>N/A</i>';

								if($r['type'] == 0) 
									$type = "Online";
								else $type = "Offline";
								?>
								<tr>
									<td><?php echo $schedule;?></td>
									<td><?php echo $r['fullname'];?></td>
									<td><?php echo $r['phone'];?></td>
									<td><?php echo $type;?></td>
									<td><?php echo $r['company'];?></td>
									<td align='center'><a href="<?php echo ROOTHOST.COMS.'/active/'.$ids;?>"><?php echo $icon_active;?></a></td>
								</tr>
							<?php }
						}else{
							?>
							<tr>
								<td colspan='3' class='text-center'>Không có dữ liệu.</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
			<nav class="d-flex justify-content-center">
				<?php paging($total_rows, $max_rows, $cur_page);?>
			</nav>
		</div>
	</div>
</section>
<!-- /.row -->
<!-- /.content-header -->
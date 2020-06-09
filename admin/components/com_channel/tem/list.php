<?php
define('OBJ_PAGE','CHANNEL');
// Init variables
$isAdmin=getInfo('isadmin');
if($isAdmin==1){
	$strWhere="";
	$get_q = isset($_GET['q']) ? antiData($_GET['q']) : '';

	/*Gán strWhere*/
	if($get_q!=''){
		$strWhere.=" AND title LIKE '%".$get_q."%'";
	}

	/*Begin pagging*/
	if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
	}
	if(isset($_POST['txtCurnpage'])){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
	}

	$total_rows=SysCount('tbl_channels',$strWhere);
	$max_rows = 20;

	if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
		$_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
	}
	$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
	/*End pagging*/
	?>
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Danh sách kênh</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
						<li class="breadcrumb-item active">Danh sách kênh</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	<section class="content">
		<div class='container-fluid'>
			<div class="widget-frm-search">
				<form id='frm_search' method='get' action=''><br/>
					<input type='hidden' id='txt_status' name='s' value='' />
					<div class='row'>
						<div class='col-sm-3'>
							<div class='form-group'>
								<input type='text' id='txt_title' name='q' value="<?php echo $get_q;?>" class='form-control' placeholder="Tiêu đề..." />
							</div>
						</div>
						<div class="col-sm-7"></div>
						<div class="col-sm-2">
							<a href="<?php echo ROOTHOST.COMS;?>/add" class="btn btn-primary float-sm-right">Thêm mới</a>
						</div>
					</div>
				</form>
			</div>
			<div class="card">
				<div class='table-responsive'>
					<table class="table">
						<thead>                  
							<tr>
								<th style="width: 10px">#</th>
								<th>Tiêu đề</th>
								<th>Mô tả</th>
								<th>Ngày tạo</th>
								<th class="text-center">Hiển thị</th>
								<th width="80px">Chi tiết</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if($total_rows>0){
								$star = ($cur_page - 1) * $max_rows;
								$strWhere.=" LIMIT $star,".$max_rows;
								$obj=SysGetList('tbl_channels',array(), $strWhere, false);
								$stt=0;
								while($r=$obj->Fetch_Assoc()){ 
									$stt++;
									if($r['isactive'] == 1) 
										$icon_active    = "<i class='fas fa-toggle-on cgreen'></i>";
									else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';
									?>
									<tr>
										<td><?php echo $stt;?></td>
										<td><?php echo $r['title'];?></td>
										<td><?php echo $r['link'];?></td>
										<td><?php echo date('d-m-Y H:i A', $r['cdate']);?></td>
										<td align='center'><a href="<?php echo ROOTHOST.COMS.'/active/'.$r['id'];?>"><?php echo $icon_active;?></a></td>
										<td class="text-center"><a href="<?php echo ROOTHOST.COMS.'/edit/'.$r['id'];?>"><i class="fas fa-edit cblue"></i></a></td>
									</tr>
								<?php }
							}else{
								?>
								<tr>
									<td colspan='6' class='text-center'>Dữ liệu trống!</td>
								</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
			</div>
			<nav class="d-flex justify-content-center">
				<?php 
				paging($total_rows,$max_rows,$cur_page);
				?>
			</nav>
		</div>
	</section>
<?php }else{
	echo "<h3 class='text-center'>You haven't permission</h3>";
}
?>
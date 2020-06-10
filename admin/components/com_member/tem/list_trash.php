<?php
$strWhere=" AND is_trash=1 ";
$get_q = isset($_GET['q']) ? antiData($_GET['q']) : '';

/*Gán strWhere*/
if($get_q!=''){
	$strWhere.=" AND firstname LIKE '%".$get_q."%'  OR lastname LIKE '%".$get_q."%' OR username='".$get_q."' ";
}

/*Begin pagging*/
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$total_rows=SysCount('tbl_member',$strWhere);
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
				<h1 class="m-0 text-dark">Members</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Bảng điều khiển</a></li>
					<li class="breadcrumb-item active">Members</li>
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
			<form id='frm_search' method='get' action=''>
				<input type='hidden' id='txt_status' name='s' value='' />
				<div class='row'>
					<div class='col-sm-4'>
						<div class='form-group'>
							<input type='text' id='txt_title' name='q' value="<?php echo $get_q;?>" class='form-control' placeholder="Username, firstname or lastname..." />
						</div>
					</div>
					<div class="col-sm-2"><button type="submit" class="btn btn-primary">Tìm kiếm</button></div>
					<div class="col-sm-4"></div>
					<div class="col-sm-2">
						<a href="<?php echo ROOTHOST.COMS;?>" class="btn btn-primary float-sm-right">Danh sách</a>
					</div>
				</div>
			</form>
		</div>
		<div class="card">
			<div class='table-responsive'>
				<table class="table">
					<thead>                  
						<tr>
							<th width="30" align="center">#</th>
							<!-- <th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th> -->
							<th width="30" align="center">Xóa</th>
							<th width="180">Username</th>
							<th>Fullname</th>
							<th>Phone</th>
							<th>Email</th>
							<th width="80px">Chi tiết</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($total_rows>0){
							$star = ($cur_page - 1) * $max_rows;
							$strWhere.=" LIMIT $star,".$max_rows;
							$obj=SysGetList('tbl_member',array(), $strWhere, false);
							$stt=0;
							while($r=$obj->Fetch_Assoc()){ 
								$stt++;
								$fullname = $r['fullname'];
								$phone = $r['phone'];
								$email = $r['email'];
								?>
								<tr>
									<td><?php echo $stt;?></td>
									<!-- <td width="30" align="center"><input type="checkbox" name="chk" onclick="docheckonce('chk');" value="$ids"/></td> -->
									<td align="center"><a href="<?php echo ROOTHOST.COMS.'/delete/'.$r['id'];?>" onclick="return confirm('Bạn có chắc muốn xóa ?')"><i class="fa fa-trash cred" aria-hidden="true"></i></a></td>
									<td><?php echo $r['username'];?></td>
									<td><?php echo $fullname;?></td>
									<td><?php echo $phone;?></td>
									<td><?php echo $email;?></td>
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
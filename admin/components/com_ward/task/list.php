<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$city=$district=$key=''; $strwhere="";

if(isset($_SESSION['CITYID'])) 		$city = $_SESSION['CITYID'];
if(isset($_SESSION['DISTRICTID'])) 	$district = $_SESSION['DISTRICTID'];

$city=isset($_GET['city'])?(int)$_GET['city']:'';
$district=isset($_GET['district'])?(int)$_GET['district']:'';
$key=isset($_GET['q'])?addslashes(strip_tags($_GET['q'])):'';

if($key!="") {
	$strwhere=" AND name LIKE '%$key%' ";
}
if($city!="") {
	$strwhere=" AND a.city_id=$city ";
	$_SESSION['CITYID']=$city;
}
if($district!="") {
	$strwhere=" AND a.district_id=$district ";
	$_SESSION['DISTRICTID']=$city;
}
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo ROOTHOST_ADMIN;?>">Admin</a></li>
        <li class="active">QUẢN LÝ XÃ/PHƯỜNG</li>
    </ol>
</div>
<div class="container-fluid">
	<div class="form-group">
		<form id="frm_search" name="frm_search" method="get" action="">
			<div class="col-md-3"><div class="row">
				<input type="hidden" class="form-control" name="com" id="com" value="<?php echo $COMS;?>">
				<input type="text" class="form-control" name="q" id="txt_q" placeholder="Tên quận huyện" value="<?php echo $key;?>">
			</div></div>
			<div class="col-md-3"><div class="row">
				<select name="city" id="city" value="" class="form-control">
					<option value="">-- Chọn tỉnh/thành--</option>
					<?php $objcity = new CLS_CITY;
					$objcity->getListCbo($city);?>
				</select>
			</div></div>
			<div class="col-md-3"><div class="row">
				<select name="district" id="district" value="" class="form-control">
					<option value="">-- Chọn quận/huyện--</option>
					<?php $objdist = new CLS_DISTRICT;
					$objdist->getListCbo($district);?>
				</select>
			</div></div>
			<div class="col-md-1">
				<button type="submit" class="btn btn-primary" name="cmdsearch" id="cmdsearch"><i class="fa fa-search"></i> Tìm</button>
			</div>
			<div class="col-md-1">
				<button type="button" class="btn btn-primary" name="filterDebt" id="btn_add"><i class="fa fa-dollar"></i> Thêm mới</button>
			</div>
		</form>
	</div>
	<div class="clearfix"></div>
	<?php $obj=new CLS_MYSQL;
	$sql="SELECT a.*,b.name as city_name,c.name as district_name FROM tbl_ward AS a
		INNER JOIN tbl_city AS b ON b.id=a.city_id 
		INNER JOIN tbl_district AS c ON c.id=a.district_id 
		WHERE 1=1 $strwhere ORDER BY b.`order` DESC,c.`order` DESC,a.city_id ASC,
		a.district_id ASC, a.`order` DESC,a.id ASC"; 
	$obj->Query($sql);
	$total_rows = $obj->Num_rows(); $arr_list=array();
	while($r=$obj->Fetch_Assoc()) $arr_list[]=$r;?>
	<div class="col-md-6 col-xs-12" style="width:49%">
		<div class="row">
			<table class="table table-bordered">
				<thead><tr>
					<th width='30'>STT</th>
					<th width='30'></th>
					<th class='text-left'>Tỉnh/Thành</th>
					<th class='text-left'>Quận/huyện</th>
					<th class='text-left'>Phường/xã</th>
					<th class='text-center'>Sắp xếp</th>
					<th class='text-center'></th>
				</tr></thead>
				<tbody>
				<?php 
				$stt=0;
				for($i=0;$i<round($total_rows/2);$i++){
					$r=$arr_list[$i];
					$id=$r['id']; $stt++;
				?>
				<tr><td class='text-center'><?php echo $stt;?></td>
					<td><i class="fa fa-trash btn_xoa" aria-hidden="true" title='Xóa' dataid='<?php echo $id;?>'></i></td>
					<td><?php echo stripslashes($r['city_name']);?></td>
					<td><?php echo stripslashes($r['district_name']);?></td>
					<td><?php echo stripslashes($r['name']);?></td>
					<td class='text-center'><?php echo  $r['order'];?></div>
					<td class='text-center'>
					<i class="fa fa-pencil-square-o btn_edit" aria-hidden="true" title='Sửa' dataid='<?php echo $id;?>'></i>
					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-md-6 col-xs-12 pull-right" style="width:49%">
		<div class="row">
			<table class="table table-bordered">
				<thead><tr>
					<th width='30'>STT</th>
					<th width='30'></th>
					<th class='text-left'>Tỉnh/Thành</th>
					<th class='text-left'>Quận/Huyện</th>
					<th class='text-left'>Phường/xã</th>
					<th class='text-center'>Sắp xếp</th>
					<th class='text-center'></th>
				</tr></thead>
				<tbody>
				<?php 
				for($i=round($total_rows/2);$i<$total_rows;$i++){
					$stt++;
					$r=$arr_list[$i];
					$id=$r['id']; 
				?>
				<tr><td class='text-center'><?php echo $stt;?></td>
					<td><i class="fa fa-trash btn_xoa" aria-hidden="true" title='Xóa' dataid='<?php echo $id;?>'></i></td>
					<td><?php echo stripslashes($r['city_name']);?></td>
					<td><?php echo stripslashes($r['district_name']);?></td>
					<td><?php echo stripslashes($r['name']);?></td>
					<td class='text-center'><?php echo  $r['order'];?></div>
					<td class='text-center'>
					<i class="fa fa-pencil-square-o btn_edit" aria-hidden="true" title='Sửa' dataid='<?php echo $id;?>'></i>
					</td>
				</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
$('#city').change(function(){
	var city = $("#city option:selected").val();
	var url = 'ajaxs/district/getlist.php';
	$.get(url,{'city':city},function(req){
		$("#district").html(req);
	})
})
$('.btn_xoa').click(function(){
	if(confirm('Bạn có chắc chắn muốn xóa phường/xã này?')){
		var _id=$(this).attr('dataid');
		var _url='ajaxs/ward/process_del.php';
		$.post(_url,{'id':_id},function(req){
			if(req=='success'){
				window.location.reload();
			}else{
				console.log(req);
				alert('Error:'+req);
			}
		});
	}
});
$('.btn_edit').click(function(){
	var _id=$(this).attr('dataid');
	var _url='ajaxs/ward/frm_edit.php';
	$('#myModalPopup .modal-body').html('Loading...');
	$('#myModalPopup .modal-title').html('Cập nhật phường/xã');
	$.post(_url,{'id':_id},function(req){
		$('#myModalPopup .modal-body').html(req);
		$('#myModalPopup').modal('show');
	});
});
$('#btn_add').click(function(){
	var city = $("#city option:selected").val();
	var district = $("#district option:selected").val();
	var city_name = $("#city option:selected").html();
	var district_name = $("#district option:selected").html();
	if(city=="" || district=="") {
		alert("Vui lòng chọn tỉnh/thành & quận/huyện trước khi thêm mới");
		return false;
	}
	var _url='ajaxs/ward/frm_add.php';
	$('#myModalPopup .modal-body').html('Loading...');
	$('#myModalPopup .modal-title').html('Thêm mới phường/xã');
	$.post(_url,{'city':city,'city_name':city_name,'district':district,'district_name':district_name},function(req){
		$('#myModalPopup .modal-body').html(req);
		$('#myModalPopup').modal('show');
	});
});
</script>
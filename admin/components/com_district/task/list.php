<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','DISTRICT');
$strwhere='';

// Khai báo SESSION
$keyword    = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
$action     = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';
$cbo_city   = isset($_GET['cbo_city']) ? addslashes(trim($_GET['cbo_city'])) : '';

// Gán strwhere
if($keyword !== ''){
	$strwhere.=" AND ( `name` like '%$keyword%' )";
}
if($action !== '' && $action !== 'all' ){
	$strwhere.=" AND `isactive` = '$action'";
}
if($cbo_city !== '' && $cbo_city !== 'all' ){
	$strwhere.=" AND `city_id` = '$cbo_city'";
}

// Begin pagging
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$sql_count = "SELECT COUNT(*) AS count FROM tbl_district WHERE 1=1 ".$strwhere;
$objmysql->Query($sql_count);
$row_count = $objmysql->Fetch_Assoc();
$total_rows = $row_count['count'];
$max_rows = 20;

if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/$max_rows)){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/$max_rows);
}
$cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
// End pagging
?>
<script language="javascript">
    function checkinput(){
        var strids=document.getElementById("txtids");
        if(strids.value==""){
            alert('Bạn chưa chọn đối tượng nào.');
            return false;
        }
        return true;
    }
</script>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">DANH SÁCH QUẬN/HUYỆN</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item active">Danh sách quận/huyện</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8">
				<form id="frm_list" method="get" action="<?php echo ROOTHOST_ADMIN.COMS;?>">
					<div class="frm-search-box form-inline pull-left">
						<input class="form-control" type="text" value="<?php echo $keyword?>" name="q" id="txtkeyword" placeholder="Từ khóa"/>

						<select name="cbo_city" class="form-control" id="cbo_city">
							<option value="all">-- Tỉnh/ thành phố --</option>
							<?php
							$sql_city="SELECT * FROM tbl_city WHERE isactive=1";
							$objmysql->Query($sql_city);
							while ($row_city = $objmysql->Fetch_Assoc()) {
								echo '<option value="'.$row_city['id'].'">'.$row_city['name'].'</option>';
							}
							?>
							<script language="javascript">
								cbo_Selected('cbo_city','<?php echo $cbo_city;?>');
							</script>
						</select>

						<select name="cbo_action" class="form-control" id="cbo_action">
							<option value="all">Tất cả</option>
							<option value="1">Hiển thị</option>
							<option value="0">Ẩn</option>
							<script language="javascript">
								cbo_Selected('cbo_action','<?php echo $action;?>');
							</script>
						</select>
						<button type="submit" id="_btnSearch" class="btn btn-success">Tìm kiếm</button>
					</div>
				</form>
			</div>
			<div class="col-md-4">
				<div class="pull-right">
					<div id="menus" class="toolbars">
						<form id="frm_menu" name="frm_menu" method="post" action="">
							<input type="hidden" name="txtorders" id="txtorders" />
							<input type="hidden" name="txtids" id="txtids" />
							<input type="hidden" name="txtaction" id="txtaction" />
							<ul class="list-inline">
								<li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','public');"><i class="fas fa-check cgreen"></i> Hiển thị</button></li>
								<li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','unpublic');"><i class="fas fa-times-circle cred"></i> Ẩn</button></li>
								<li><a class="addnew btn btn-default" href="<?php echo ROOTHOST_ADMIN.COMS;?>/add" title="Thêm mới"><i class="fa fa-plus-circle cgreen" aria-hidden="true"></i> Thêm mới</a></li>
								<li><a class="delete btn btn-default" href="#" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_menu','delete'); }" title="Xóa"><i class="fa fa-times-circle cred" aria-hidden="true"></i> Xóa</a></li>
							</ul>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="table-responsive">
			<table class="table table-bordered">
				<thead>
					<th width="30" align="center">STT</th>
					<th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
					<th class="th-delete">Xóa</th>
					<th>Tên quận/huyện</th>
					<th>Phân loại</th>
					<th>Tỉnh/ thành phố</th>
					<th class="order">Sắp xếp
						<a href="javascript:saveOrder()"><i class="fas fa-save"></i></a>
					</th>
					<th class="th-display">Hiển thị</th>
					<th class="th-edit">Sửa</th>
				</thead>
				<tbody>
					<?php
					$star = ($cur_page - 1) * $max_rows;
					$sql = "SELECT * FROM tbl_district WHERE 1=1 $strwhere ORDER BY `id` ASC, `order` ASC LIMIT $star,".$max_rows;
					$objmysql->Query($sql);
					$i = 0;
					while($rows = $objmysql->Fetch_Assoc()){
						$i++;
						$ids        = $rows['id'];
                        $city_id   	= $rows['city_id'];
						$title      = stripslashes($rows['name']);
						$type      	= stripslashes($rows['type']);
						$order      = number_format($rows['order']);

						if($rows['isactive'] == 1) 
							$icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
						else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

                        // Get city name
                        $sql_cate = "SELECT name FROM tbl_city WHERE id = ".$city_id;
                        $objmysql2 = new CLS_MYSQL();
                        $objmysql2->Query($sql_cate);
                        $r_cate = $objmysql2->Fetch_Assoc();
                        $city   = $r_cate['name'];
                        // End Get city name

						echo "<tr name='trow'>";
						echo "<td width='30' align='center'>$i</td>";
						echo "<td width='30' align='center'><label>";
						echo "<input type='checkbox' name='chk' onclick=\"docheckonce('chk');\" value='$ids'/></label></td>";

						echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

						echo "<td>
                        <div>".$title."</div>
                        <div class='info'>
                        <span>".$city."</span>
                        </div>
                        </td>";

						echo "<td>".$type."</td>";
						echo "<td>Việt Nam</td>";

						echo "<td><input type='text' name='txt_order' value='".$order."' size='4' class='order'></td>";

						echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/active/$ids'>".$icon_active."</a></td>";

						echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/edit/$ids'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";

						echo "</tr>";
					}
					?>
				</tbody>
			</table>
			<nav class="d-flex justify-content-center">
				<?php 
				paging($total_rows,$max_rows,$cur_page);
				?>
			</nav>
		</div>
	</div>
</section>
<?php //----------------------------------------------?>
<script type="text/javascript">
	$(document).ready(function(){
		$('#cbo_city').select2();
	})
</script>
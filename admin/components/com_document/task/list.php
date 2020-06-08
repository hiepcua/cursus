<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','DOCUMENT');
$strwhere='';

// Khai báo SESSION
$keyword    = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
$action     = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';
$cbo_cate   = isset($_GET['cbo_cate']) ? (int)$_GET['cbo_cate'] : 0;

// Gán strwhere
if($keyword !== ''){
	$strwhere.=" AND ( `title` like '%$keyword%' )";
}
if($action !== '' && $action !== 'all' ){
	$strwhere.=" AND `isactive` = '$action'";
}
if($cbo_cate !== 0){
	$strwhere.=" AND `g_id` = $cbo_cate";
}

// Begin pagging
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$sql_count = "SELECT COUNT(*) AS count FROM tbl_document WHERE 1=1 ".$strwhere;
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
	function checkinput()
	{
		var strids=document.getElementById("txtids");
		if(strids.value=="")
		{
			alert('You are select once record to action');
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
				<h1 class="m-0 text-dark">DANH SÁCH TÀI liệu</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item active">Danh sách tài liệu</li>
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
			<div class="col-md-6">
				<form id="frm_list" method="get" action="<?php echo ROOTHOST_ADMIN.COMS;?>">
					<div class="frm-search-box form-inline pull-left">
						<input class="form-control" type="text" value="<?php echo $keyword?>" name="q" id="txtkeyword" placeholder="Từ khóa"/>

						<select name="cbo_action" class="form-control" id="cbo_action">
							<option value="all">Tất cả</option>
							<option value="1">Hiển thị</option>
							<option value="0">Ẩn</option>
							<script language="javascript">
								cbo_Selected('cbo_action','<?php echo $action;?>');
							</script>
						</select>

						<select name="cbo_cate" class="form-control" id="cbo_cate">
							<option value="0">-- Tất cả --</option>
							<?php $obj_gdoc->getListCate(); ?>
							<script language="javascript">
								cbo_Selected('cbo_cate','<?php echo $cbo_cate;?>');
							</script>
						</select>
						<button type="submit" id="_btnSearch" class="btn btn-success">Tìm kiếm</button>
					</div>
				</form>
			</div>
			<div class="col-md-6">
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
				<tr class="header">
					<th width="30" align="center">#</th>
					<th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
					<th class="th-delete">Xóa</th>
					<th align="center">Tên tài liệu</th>
					<th align="center">Link chèn</th>
					<th class="order">Sắp xếp
						<a href="javascript:saveOrder()"><i class="fas fa-save"></i></a>
					</th>
					<th class="th-display">Hiển thị</th>
					<th class="th-edit">Sửa</th>
				</tr>
				<?php 
				$star = 0;
				if($cur_page>1) $star=($cur_page-1)*$max_rows;
				$leng = $max_rows;
				$sql="SELECT * FROM tbl_document WHERE 1=1 $strwhere ORDER BY id DESC LIMIT $star,$leng";
				$objmysql->Query($sql);
				$i=0;
				while($rows = $objmysql->Fetch_Assoc()){
					$i++;
					$ids=$rows['id'];
					$name=stripslashes($rows['name']);
					$doctype_name = $obj_gdoc->getNameById($rows['g_id']);
					$link = ROOTHOST.'tai-lieu/'.$rows['code'].'/'.$rows['id'].'.html';
					$order=$rows['order'];

					if($rows['isactive'] == 1) 
						$icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
					else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

					echo "<tr name=\"trow\">";
					echo "<td width=\"30\" align=\"center\">$i</td>";
					echo "<td width=\"30\" align=\"center\"><label>";
					echo "<input type=\"checkbox\" name=\"chk\" id=\"chk\" 	 onclick=\"docheckonce('chk');\" value=\"$ids\" />";
					echo "</label></td>";
					
					echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

					echo "<td>$name</td>";
					echo "<td>$link</td>";

					echo "<td><input type='text' name='txt_order' value='".$order."' size='4' class='order'></td>";

					echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/active/$ids'>".$icon_active."</a></td>";

					echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/edit/$ids'><i class='fa fa-edit' aria-hidden='true'></i></a></td>";
					echo "</tr>";
				}
				?>
			</table>
		</div>
		<nav class="d-flex justify-content-center">
			<?php 
			paging($total_rows,$max_rows,$cur_page);
			?>
		</nav>
	</div>
</section>
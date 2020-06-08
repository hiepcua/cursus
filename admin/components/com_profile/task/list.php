<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','PROFILE');
$keyword='';$strwhere='';$action='';

// Khai báo SESSION
if(isset($_POST['keyword'])){
  $keyword=trim($_POST['keyword']);
  $_SESSION['KEY_'.OBJ_PAGE]=$keyword;
}
if(isset($_POST['cbo_active']))
    $_SESSION['ACT'.OBJ_PAGE]=addslashes($_POST['cbo_active']);
if(isset($_SESSION['KEY_'.OBJ_PAGE]))
    $keyword=$_SESSION['KEY_'.OBJ_PAGE];
else
    $keyword='';
$action=isset($_SESSION['ACT'.OBJ_PAGE]) ? $_SESSION['ACT'.OBJ_PAGE]:'';

// Gán strwhere
if($keyword!='')
    $strwhere.=" AND ( `fullname` like '%$keyword%' OR `household` like '%$keyword%' OR `address` like '%$keyword%')";
if($action!='' && $action!='all' ){
    $strwhere.=" AND `isactive` = '$action'";
}
$strwhere .= " ORDER BY id DESC ";
$obj->getList($strwhere,'');
$total_rows=$obj->Num_rows();

// Pagging
if(!isset($_SESSION['CUR_PAGE_PROFILE']))
    $_SESSION['CUR_PAGE_PROFILE']=1;
if(isset($_POST['txtCurnpage']))
    $_SESSION['CUR_PAGE_PROFILE']=(int)$_POST['txtCurnpage'];
$cur_page = $_SESSION['CUR_PAGE_PROFILE'];
?>
<script language="javascript">
	function checkinput(){
		var strids=document.getElementById("txtids");
		if(strids.value==""){
			alert('You are select once record to action');
			return false;
		}
		return true;
	}
</script>
 <div class=''>
    <div class="com_header color">
        <i class="fa fa-list" aria-hidden="true"></i> Đăng ký xét tuyển
        <div class="pull-right">
            <div id="menus" class="toolbars">
                <form id="frm_menu" name="frm_menu" method="post" action="">
                    <input type="hidden" name="txtorders" id="txtorders" />
                    <input type="hidden" name="txtids" id="txtids" />
                    <input type="hidden" name="txtaction" id="txtaction" />
                    <ul class="list-inline">
                        <li><a class="addnew btn btn-default" href="<?php echo ROOTHOST_ADMIN.COMS;?>/add" title="Thêm mới"><i class="fa fa-plus-circle cgreen" aria-hidden="true"></i> Thêm mới</a></li>
                        <li><a class="delete btn btn-default" href="#" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_menu','delete'); }" title="Xóa"><i class="fa fa-times-circle cred" aria-hidden="true"></i> Xóa</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div><br>
<div class='col-md-12 user_list'><form name="frmsearch" action="#" method="post">
	<div class="row">
		<div class="col-xs-9 col-sm-5 col-md-5 col-lg-5">   
			<div class="input-group">
				<input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo $keyword;?>" placeholder="Từ khóa tìm kiếm ...">
				<span class="input-group-btn">
					<button class="btn btn-default" type="submit" onclick="checkSearch();">
					<i class="fa fa-search fa-fw"></i></button>
				</span>
			</div>
		</div><div class="pull-right text-right col-xs-3 col-sm-5 col-md-5 col-lg-5">
			<button type="button" class="btn btn-default" id="export">
			<i class="fa fa-file-excel"></i> Xuất File</button>
		</div>
	</div>
	<div class="clearfix"></div><br>
	<div class="table-responsive">
		<table class="table table-bordered">
			<tr class="header">
                <th width="30" align="center">#</th>
				<th>Họ và tên</th>
				<th>Địa chỉ</th>
				<th>Email</th>
				<th>Điện thoại</th>
				<th>Khoa/Ngành</th>
				<th>CMTND</th>
				<th>Ngày sinh</th>
				<th>Giới tính</th>
                <th width="50" align="center">Chăm sóc</th>
                <th width="50" align="center">Đỗ/Trượt</th>
                <th width="50" align="center">Sửa</th>
            </tr>
            <?php
            $obj->listTable($strwhere,$cur_page);
            ?>
        </table>
    </div>
	</form>
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
        <tr>
            <td align="center">
                <?php 
                paging($total_rows,MAX_ROWS_ADMIN,$cur_page);
                ?>
            </td>
        </tr>
    </table>
</div>
<script>
function checkSearch() {
	/* if($("#keyword").val()=="") {
		$("#keyword").focus();
		return false;
	} */
	return true;
}
$("#export").click(function(){
	var key = $("#keyword").val();
	var url = "<?php echo ROOTHOST_ADMIN;?>ajaxs/profile/export.php";
	$.post(url,{'key':key},function(req){
		console.log(req);
		$("body").append("<iframe src='" + req+ "' style='display: none;' ></iframe>");
	})
})
</script>
<?php //----------------------------------------------?>

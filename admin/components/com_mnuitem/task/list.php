<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','MNUITEM');
$strwhere='';

    // Khai báo SESSION
$keyword    = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
$action     = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';
$mnuid      = isset($_GET['mnuid']) ? (int)$_GET['mnuid'] : 0;

    // Get menu info
$sql_menu = "SELECT * FROM tbl_menus WHERE id = ".$mnuid;
$objmysql->Query($sql_menu);
$r_menu = $objmysql->Fetch_Assoc();

    // Gán strwhere
if($keyword !== ''){
    $strwhere.=" AND ( `name` like '%$keyword%' )";
}
if($action !== '' && $action !== 'all' ){
    $strwhere.=" AND `isactive` = '$action'";
}
if($mnuid !== 0){
    $strwhere.=" AND `menu_id` = '$mnuid'";
}

    // Begin pagging
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$sql = "SELECT COUNT(*) AS count FROM tbl_mnuitems WHERE 1=1 ".$strwhere;
$objmysql->Query($sql);
$row_count = $objmysql->Fetch_Assoc();
$total_rows = $row_count['count'];

if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/MAX_ROWS_ADMIN)){
    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/MAX_ROWS_ADMIN);
}
$cur_page = (int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
    // End pagging
?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?php echo $r_menu['name'];?></h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>menus">Danh sách menu</a></li>
                    <li class="breadcrumb-item active">Main menu</li>
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
                <form id="frm_list" method="get" action="<?php echo ROOTHOST_ADMIN.COMS.'/'.$mnuid;?>">
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
                                <li><a class="addnew btn btn-default" href="<?php echo ROOTHOST_ADMIN.COMS.'/'.$mnuid;?>/add" title="Thêm mới"><i class="fa fa-plus-circle cgreen" aria-hidden="true"></i> Thêm mới</a></li>
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
                    <th align="center">Tên</th>
                    <th align="center">Mã</th>
                    <th width="100" align="center">Kiểu hiển thị</th>
                    <th class="order">Sắp xếp
                        <a href="javascript:saveOrder()"><i class="fas fa-save"></i></a>
                    </th>
                    <th class="th-display">Hiển thị</th>
                    <th class="th-edit">Sửa</th>
                </tr>
                <?php $obj->listTableItemMenu($strwhere,0,0,0); ?>
            </table>
        </div>
    </div>
</section>
<?php //----------------------------------------------?>
<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
define('OBJ_PAGE','TOUR');
$strwhere='';

if(isset($_GET['cate'])){
    $cate_id = (int)$_GET['cate'];
    $name_category = $obj_cate->getNameById($cate_id);
    $strwhere.=" AND category_id = $cate_id ";
}

// Khai báo SESSION
$keyword        = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
$cbo_place      = isset($_GET['cbo_place']) ? (int)$_GET['cbo_place'] : 0;

// Gán strwhere
if($keyword !== ''){
    $strwhere.=" AND ( `name` like '%$keyword%' )";
}
if($cbo_place !== 0){
    // Get all childrent
    $sql_childs="SELECT Place_GetFamilyTree(id) as childs FROM tbl_place WHERE id = ".$cbo_place;
    $objmysql->Query($sql_childs);
    $r_childs = $objmysql->Fetch_Assoc();

    if($r_childs['childs'] !== ''){
        $strwhere.=" AND `place_id` IN(".$r_childs['childs'].",".$cbo_place.")";
    }else{
        $strwhere.=" AND `place_id` = $cbo_place";
    }
}

// Begin pagging
if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
}
if(isset($_POST['txtCurnpage'])){
    $_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
}

$sql_count = "SELECT COUNT(*) AS count FROM tbl_tour WHERE 1=1 ".$strwhere;
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
                <h1 class="m-0 text-dark">DANH SÁCH TOUR</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item active">Danh sách tour</li>
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

                        <select name="cbo_place" class="form-control" id="cbo_place">
                            <option value="0">-- Tất cả --</option>
                            <?php $obj_place->getListCate(); ?>
                            <script language="javascript">
                                cbo_Selected('cbo_place','<?php echo $cbo_place;?>');
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
                    <th>Tour</th>
                    <th>Giá</th>
                    <th>Phương tiện</th>
                    <th>Số ngày/đêm</th>
                    <th>Ngày khởi hành</th>
                    <th class="order">Sắp xếp
                        <a href="javascript:saveOrder()"><i class="fas fa-save"></i></a>
                    </th>
                    <th class="th-display">Hiển thị</th>
                    <th class="th-edit">Sửa</th>
                </thead>
                <tbody>
                    <?php
                    $star = ($cur_page - 1) * $max_rows;
                    $sql = "SELECT * FROM tbl_tour WHERE 1=1 $strwhere ORDER BY cdate DESC, `id` DESC LIMIT $star,".$max_rows;
                    $objmysql->Query($sql);
                    $i = 0;
                    while($rows = $objmysql->Fetch_Assoc()){
                        $i++;
                        $ids        = $rows['id'];
                        $title      = Substring(stripslashes($rows['name']),0,10);
                        $vehicle    = stripslashes($rows['vehicle']);
                        $departure  = date("d-m-Y", $rows['departure']);
                        $days       = stripslashes($rows['days']);
                        $cdate      = date('d-m-Y', $rows['cdate']);
                        $visited    = number_format($rows['visited']);
                        $order      = number_format($rows['order']);
                        $price      = number_format($rows['price2']);

                        if($rows['isactive'] == 1) 
                            $icon_active    = "<i class=\"fas fa-toggle-on cgreen\"></i>";
                        else $icon_active   = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';

                        echo "<tr name='trow'>";
                        echo "<td width='30' align='center'>$i</td>";
                        echo "<td width='30' align='center'><label>";
                        echo "<input type='checkbox' name='chk' onclick=\"docheckonce('chk');\" value='$ids'/>";
                        echo "</label></td>";

                        echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\"><i class='fa fa-trash cgray red' aria-hidden='true'></i></a></td>";

                        echo "<td>".$title."</td>";
                        if($rows['price2'] > 0){
                            echo "<td><input class='ajax-price' data-id='".$ids."' onchange=\"ajax_update_price(this)\" type='text' name='txt_price[]' value='".$price."'></td>";
                        }else{
                            echo "<td><div style='text-align:center;'>Liên hệ</div></td>";
                        }

                        echo "<td>".$vehicle."</td>";
                        echo "<td>".$days."</td>";
                        if($rows['departure'] > 0){
                            echo "<td>".$departure."</td>";
                        }else{
                            echo "<td><div style='text-align:center;'>Liên hệ</div></td>";
                        }

                        echo "<td width='50' align='center'><input type='text' name='txt_order' value='$order' size='4' class='order'></td>";

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
<script type="text/javascript">
    $("#cbo_place").select2();
    function ajax_update_price(attr){
        var id = parseInt(attr.getAttribute('data-id'));
        var price = attr.value;
        var _price = parseInt(price.replace(/,/g, ''));
        $.ajax({
            url : '<?php echo ROOTHOST_ADMIN.'ajaxs/tour/update_price.php' ?>',
            type : 'POST',
            data : {
                'id' : id,
                'price' : _price,
            },
            cache: false,
            success: function (res) {
                attr.value = res;
            }
        })
    }
</script>
<?php //----------------------------------------------?>
<?php
    defined('ISHOME') or die('Can not acess this page, please come back!');
    define('OBJ_PAGE','SLIDER');
    $strwhere='';

    // Khai báo SESSION
    $keyword = isset($_GET['q']) ? addslashes(trim($_GET['q'])) : '';
    $action = isset($_GET['cbo_action']) ? addslashes(trim($_GET['cbo_action'])) : '';

    // Gán strwhere
    if($keyword !== ''){
        $strwhere.=" AND ( `slogan` like '%$keyword%' )";
    }
    if($action !== '' && $action !== 'all' ){
        $strwhere.=" AND `isactive` = '$action'";
    }

    // Begin pagging
    if(!isset($_SESSION['CUR_PAGE_'.OBJ_PAGE])){
        $_SESSION['CUR_PAGE_'.OBJ_PAGE] = 1;
    }
    if(isset($_POST['txtCurnpage'])){
        $_SESSION['CUR_PAGE_'.OBJ_PAGE] = (int)$_POST['txtCurnpage'];
    }

    $sql_count = "SELECT COUNT(*) AS count FROM tbl_feedback WHERE 1=1 ".$strwhere;
    $objmysql->Query($sql_count);
    $row_count = $objmysql->Fetch_Assoc();
    $total_rows = $row_count['count'];

    if($_SESSION['CUR_PAGE_'.OBJ_PAGE] > ceil($total_rows/MAX_ROWS_ADMIN)){
        $_SESSION['CUR_PAGE_'.OBJ_PAGE] = ceil($total_rows/MAX_ROWS_ADMIN);
    }
    $cur_page=(int)$_SESSION['CUR_PAGE_'.OBJ_PAGE]>0 ? $_SESSION['CUR_PAGE_'.OBJ_PAGE] : 1;
    // End pagging
?>
<script language="javascript">
    function checkinput(){
        var strids=document.getElementById("txtids");
        if(strids.value==""){
            alert('Bạn chưa chọn đối tượng nào');
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
                <h1 class="m-0 text-dark">DANH SÁCH FEEDBACK</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
                    <li class="breadcrumb-item active">Danh sách feedback</li>
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
                <thead>
                    <th width="30" align="center">#</th>
                    <th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
                    <th class="th-delete">Xóa</th>
                    <th>Avatar</th>
                    <th>Tên</th>
                    <th>Comment</th>
                    <th class="order">Sắp xếp
                        <a href="javascript:saveOrder()"><i class="fas fa-save"></i></a>
                    </th>
                    <th class="th-display">Hiển thị</th>
                    <th class="th-edit">Sửa</th>
                </thead>
                <?php 
                $star = ($cur_page-1) * MAX_ROWS;
                $leng = MAX_ROWS;
                $sql = "SELECT * FROM tbl_feedback ".$strwhere." ORDER BY `order` ASC LIMIT $star,$leng";
                $objmysql->Query($sql);
                $i=0;
                while($rows = $objmysql->Fetch_Assoc()){
                    $i++;
                    $ids=$rows['id'];
                    $name=$rows['name'];
                    $img=$rows['avatar'];
                    $comment=$rows['comment'];
                    $order=$rows['order'];

                    if($rows['isactive'] == 1) 
                        $icon_active = "<i class=\"fas fa-toggle-on cgreen\"></i>";
                    else $icon_active = '<i class="fa fa-toggle-off cgray" aria-hidden="true"></i>';
                    echo "<tr name=\"trow\">";
                    echo "<td width=\"30\" align=\"center\">$i</td>";

                    echo "<td width=\"30\" align=\"center\"><input type=\"checkbox\" name=\"chk\" onclick=\"docheckonce('chk');\" value=\"$ids\"/></td>";

                    echo "<td align='center' width='10'><a href='".ROOTHOST_ADMIN.COMS."/delete/$ids' onclick=\" return confirm('Bạn có chắc muốn xóa ?')\">";
                    echo "<i class='fa fa-times-circle cred' aria-hidden='true'></i></a></td>";

                    echo "<td><img src='".$img."' align='' class='df_thumb'></td>";
                    echo "<td>".$name."</td>";
                    echo "<td>".$comment."</td>";

                    echo "<td width=\"50\" align=\"center\"><input type=\"text\" name=\"txt_order\" value=\"$order\" class=\"order\"></td>";

                    echo "<td align=\"center\">";
                    echo "<a href=\"index.php?com=".COMS."&amp;task=active&amp;id=$ids\">";
                    echo $icon_active;
                    echo "</a>";
                    echo "</td>";

                    echo "<td align=\"center\">";
                    echo "<a href=\"".ROOTHOST_ADMIN.COMS."/edit/$ids\">";
                    echo "<i class='fa fa-edit' aria-hidden='true'></i>";
                    echo "</a>";
                    echo "</td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <nav class="d-flex justify-content-center">
                <?php 
                paging($total_rows,MAX_ROWS,$cur_page);
                ?>
            </nav>
        </div>
    </div>
</section>
<?php //----------------------------------------------?>

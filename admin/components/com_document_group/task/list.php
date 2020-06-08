<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$keyword='Keyword';	$action='';	$catid='';$parid='';$level=0;

if(!isset($_SESSION['EDU_CONTENT_CATID'])) $_SESSION['EDU_CONTENT_CATID']='';
if(!isset($_SESSION['EDU_CONTENT_ACT'])) $_SESSION['EDU_CONTENT_ACT']='';

if(isset($_POST['txtkeyword'])){
  $keyword=$_POST['txtkeyword'];
  $_SESSION['EDU_CONTENT_ACT']=$_POST['cbo_active'];
}
$action = $_SESSION['EDU_CONTENT_ACT'];
$strwhere='';
if($keyword!='' && $keyword!='Keyword')
  $strwhere.="AND ( `name` like '%$keyword%')";
if($action!='' && $action!='all' )
  $strwhere.="AND `isactive` = '$action'";
	// echo $strwhere;
if(!isset($_SESSION['CUR_PAGE_CON']))
  $_SESSION['CUR_PAGE_CON']=1;
if(isset($_POST['txtCurnpage'])){
  $_SESSION['CUR_PAGE_CON']=$_POST['txtCurnpage'];
}
$obj->getList($strwhere,'');
$total_rows=$obj->Num_rows();
if($_SESSION['CUR_PAGE_CON']>ceil($total_rows/MAX_ROWS))
  $_SESSION['CUR_PAGE_CON']=ceil($total_rows/MAX_ROWS);
$cur_page=($_SESSION['CUR_PAGE_CON']<1)?1:$_SESSION['CUR_PAGE_CON'];
?>
<div id="list">
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
    <div class="com_header color">
        <i class="fa fa-list" aria-hidden="true"></i> Quản lý nhóm tài liệu upload
        <div class="pull-right">
            <div id="menus" class="toolbars">
                <form id="frm_menu" name="frm_menu" method="post" action="">
                    <input type="hidden" name="txtorders" id="txtorders" />
                    <input type="hidden" name="txtids" id="txtids" />
                    <input type="hidden" name="txtaction" id="txtaction" />
                    <ul class="list-inline">
                        <li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','public');"><i class="fa fa-check-circle-o cgreen" aria-hidden="true"></i> Hiển thị</button></li>
                        <li><button class="btn btn-default" onclick="dosubmitAction('frm_menu','unpublic');"><i class="fa fa-times-circle-o cred" aria-hidden="true"></i> Ẩn</button></li>
                        <li><a class="addnew btn btn-default" href="<?php echo ROOTHOST_ADMIN.COMS;?>/add" title="Thêm mới"><i class="fa fa-plus-circle cgreen" aria-hidden="true"></i> Thêm mới</a></li>
                        <li><a class="delete btn btn-default" href="#" onclick="javascript:if(confirm('Bạn có chắc chắn muốn xóa thông tin này không?')){dosubmitAction('frm_menu','delete'); }" title="Xóa"><i class="fa fa-times-circle cred" aria-hidden="true"></i> Xóa</a></li>
                    </ul>
                </form>
            </div>
        </div>
    </div><br>
<form id="frm_list" name="frm_list" method="post" action="">
<div class="table-responsive">
	<table class="table table-bordered">
    <tr class="header">
      <th width="30" align="center">#</th>
      <th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
      <th width="50" align="center">Xóa</th>
	  <th align="center">Mã nhóm</th>
      <th align="center">Tên nhóm</th>
      <th width="70" align="center" style="text-align: center;">Sắp xếp
		<a href="javascript:saveOrder()"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
	  </th>
	  <th width="50" align="center">Hiển thị</th>
      <th width="50" align="center">Sửa</th>
    </tr>
    <?php 
    $obj->listTableDocumentType($strwhere,$cur_page,$parid,$level,0);
    ?>
  </table>
</div>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="Footer_list">
  <tr>
    <td align="center">
      <?php 
      paging($total_rows,MAX_ROWS,$cur_page);
      ?>
    </td>
  </tr>
</table>
</div>
<?php //----------------------------------------------?>
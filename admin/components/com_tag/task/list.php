<?php
defined('ISHOME') or die('Can not acess this page, please come back!');
$keyword='Keyword';
$action='';
$parid='';
$level=0;

if(isset($_POST['txtkeyword'])){
	$keyword=$_POST['txtkeyword'];
}
$strwhere='';
if($keyword!='' && $keyword!='Keyword'){
	$strwhere.="AND ( `name` like N'%$keyword%')";
}
$cur_page=isset($_GET['page'])?$_GET['page']:1;
?>
<script type='text/javascript'>
function checkinput(){
  var strids=document.getElementById("txtids");
  if(strids.value==""){
	  alert('You are select once record to action');
	  return false;
  }
  return true;
}
</script>
<div id="list_content">
    <div class="com_header color">
        <i class="fa fa-list" aria-hidden="true"></i> Quản lý Tags
    </div>
</div><br>
<div class='user_list col-sm-12'>
	<form id="frm_list" name="frm_list" method="post" action="">
	<table class="table table-bordered">
	  <tr class="header">
		<td>
			<div class='col-md-6'><div class='row'><input type="text" class='form-control' name="txtkeyword" id="txtkeyword" value="" placeholder="Từ khóa"/></div></div>
			<div class='col-md-4'>
				<input type="submit" class='btn btn-default' name="button" id="button" value="Tìm kiếm"/>
				<input type="button" class='btn btn-primary' name="button" id="btn_add" value="Thêm mới"/>
			</div>
			<script>
			$('#btn_add').click(function(){
				window.location.href='<?php echo ROOTHOST_ADMIN.COMS;?>/add';
			})
			</script>
		</td>
	  </tr>
	</table><br/>
	<table class='table table-striped table-bordered'>
	  <tr class="header">
		<th width="30" align="center">#</th>
		<th width="30" align="center"><input type="checkbox" name="chkall" id="chkall" value="" onclick="docheckall('chk',this.checked);" /></th>
		<th>Tag Name</th>
		<th>Tag Code</th>
		<th>Meta title</th>
		<th width="50" align="center">Sửa</th>
		<th width="50" align="center">Xóa</th>
	  </tr>
	  <?php
		$sql="SELECT * FROM tbl_tags WHERE 1=1 $strwhere";
		$objMySql=new CLS_MYSQL;
		$objMySql->Query($sql);
		$stt=0;
		while($r=$objMySql->Fetch_Assoc()){
		$id=$r['id'];$stt++;
	  ?>
	  <tr class="list">
		<td width="30" align="center"><?php echo $stt;?></td>
		<td width="30" align="center"><input type='checkbox' name='chk' id='chk' onclick='docheckonce("chk");' value='<?php echo $id;?>' /></td>
		<td><?php echo $r['name'];?></td>
		<td><?php echo $r['code'];?></td>
		<td><?php echo $r['meta_title'];?></td>
		<td width="50" align="center">
			<a href='<?php echo ROOTHOST_ADMIN.COMS;?>/edit/<?php echo $id;?>'>
			<i class="fa fa-edit" aria-hidden="true"></i>
			</a>
		</td>
		<td width="50" align="center">
			<a href='<?php echo ROOTHOST_ADMIN.COMS;?>/delete/<?php echo $id;?>'>
			<i class="fa fa-times-circle cred" aria-hidden="true"></i>
			</a>
		</td>
	  </tr>
		<?php }?>
	</table>
	</form>
</div>
<?php //----------------------------------------------?>
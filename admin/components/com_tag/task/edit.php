<?php
	defined("ISHOME") or die("Can't acess this page, please come back!");
	$id="";
	if(isset($_GET["id"]))
		$id=$_GET["id"];
	$obj->getList(' And id='.$id,' limit 0,1');
	$row=$obj->Fetch_Assoc();
?>
<div id="action">
 <script language="javascript">
function checkinput(){
	if($("#txtname").val()==""){
	 	$("#txtname_err").fadeTo(200,0.1,function(){ 
		  $(this).html('Vui lòng nhập tên nhóm tin').fadeTo(900,1);
		});
	 	$("#txtname").focus();
	 	return false;
	}
	return true;
}
$(document).ready(function(){
	$("#txtname").blur(function() {
		if( $(this).val()==''){
			$("#txtname_err").fadeTo(200,0.1,function(){ 
			  $(this).html('Vui lòng nhập tên nhóm tin').fadeTo(900,1);
			});
		}
		else {
			$("#txtname_err").fadeTo(200,0.1,function(){ 
			  $(this).html('').fadeTo(900,1);
			});
		}
	})
})
</script>
<div class="com_header color">
	<i class="fa fa-pencil-square" aria-hidden="true"></i> Sửa Tags
	<div class="pull-right">
		<?php require_once("../global/libs/toolbar.php"); ?>
	</div>
</div><br>
<div class='col-sm-12'>
<form id="frm_action" name="frm_action" method="post" action="">
	<div>Những mục đánh dấu <font color="red">*</font> là yêu cầu bắt buộc.</div>
    <table class='table table-striped table-bordered'>
      <tr>
        <td width="150" align="right" bgcolor="#EEEEEE"><strong>Tag name <font color="red">*</font></strong></td>
        <td><div class="col-md-6">
          <input name="txtname" type="text" id="txtname" value="<?php echo $row['name'];?>" size="40">
          <label id="txtname_err" class="check_error"></label>
	      <input type="hidden" name="txtid" id="txtid" value="<?php echo $row['id'];?>">
		</div></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#EEEEEE"><strong>Tag code &nbsp;</strong></td>
        <td><div class="col-md-6">
		<input name="txtcode" type="text" id="txtcode" value="<?php echo $row['code'];?>" size="40">
        </div></td>
      </tr>
    </table>
    <textarea class='form-control' name="txt_metatitle" id="txt_metatitle" rows="1"><?php echo $row['meta_title'];?></textarea>
	<br style="clear:both" />
   <textarea class='form-control' name="txt_metadesc" id="txt_metadesc" cols="45" rows="5"><?php echo $row['meta_desc'];?></textarea></textarea>
	<br/>
	<input type="submit" name="cmdsave" id="cmdsave" value="Sửa đổi" class='btn btn-primary'>
</form>
</div>
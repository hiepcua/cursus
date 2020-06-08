<?php
	defined("ISHOME") or die("Can't acess this page, please come back!")
?>
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
		if( $(this).val()=='') {
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
	<i class="fa fa-plus-circle" aria-hidden="true"></i> Thêm Tags
	<div class="pull-right">
		<?php require_once("../global/libs/toolbar.php"); ?>
	</div>
</div><br>
<div class='col-sm-12'>
<form id="frm_action" name="frm_action" method="post" action="">
<table class='table table-striped table-bordered'>
  <tr>
	<td width="150" align="right" bgcolor="#EEEEEE"><strong>Tag name <font color="red">*</font></strong></td>
	<td><div class="col-md-6">
	  <input name="txtname" type="text" id="txtname" class="form-control">
	  <label id="txtname_err" class="check_error"></label>
	  <input name="txttask" type="hidden" id="txttask" value="1" />
	</div></td>
  </tr>
  <tr>
	<td align="right" bgcolor="#EEEEEE"><strong>Tag code &nbsp;</strong></td>
	<td><div class="col-md-6">
	<input name="txtcode" type="text" id="txtcode" value=""  class="form-control">
	</div></td> 
  </tr>
</table>
<textarea class='form-control' placeholder='Meta Title' name="txt_metatitle" id="txt_metatitle" style='width:100%' rows="1"></textarea>
<br style="clear:both" />
<textarea class='form-control' placeholder='Meta desc' name="txt_metadesc" id="txt_metadesc" style='width:100%' cols="45" rows="5"></textarea>
<br/>
<input type="submit" name="cmdsave" id="cmdsave" class='btn btn-primary' value="Thêm mới">
</form>
</div>
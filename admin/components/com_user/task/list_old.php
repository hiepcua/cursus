<?php
$strwhere='';
$check_permission = $UserLogin->Permission('user');
if($check_permission==false) die($GLOBALS['MSG_PERMIS']);
// Pagging
if(!isset($_SESSION['CUR_PAGE_USER']))
	$_SESSION['CUR_PAGE_USER']=1;
if(isset($_POST['txtCurnpage'])){
	$_SESSION['CUR_PAGE_USER']=(int)$_POST['txtCurnpage'];
}
?>
<div class="body">
	<div class='col-md-3'>
		<div class='row body_col_left bleft bright'>
			<div class="com_header color">
				<i class="fa fa-sitemap" aria-hidden="true"></i> Nhóm người dùng
			</div>
			<input type='hidden' id='guser_selected' value=''/>
			<div class='user_group_list'>
				<ul class='menu'>
					<?php $UserLogin->getGroupUser(0);?>
				</ul>
			</div>
			<div class='user_group_func'>
				<ul class='menu'>
					<li class='cmd_group_add'><a href='' class='cgreen'><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm mới</a></li>
					<li class="cmd_group_edit"><a href='' ><i class="fa fa-edit" aria-hidden="true"></i> Sửa nhóm</a></li>
					<li class='cmd_group_del'><a href='' class="cred"><i class="fa fa-user-times" aria-hidden="true"></i> Xóa nhóm</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class='col-md-9 body_col_right'>
		<div class='row'>
			<div class="com_header color">
				<i class="fa fa-list" aria-hidden="true"></i>  Danh sách người dùng
				<div class="pull-right">
					<button id="cmd_user_add" class="btn btn-default"><i class="fa fa-user-plus" aria-hidden="true"></i> Thêm mới người dùng</button>
					<button class="btn btn-default"><i class="fa fa-envelope" aria-hidden="true"></i> Send mail</button>
				</div>
			</div>
		</div>
		<div class='list_search'>
			<form method='post'>
				<div class='row'>
					<div class='col-md-6'>
						<div class="input-group">
							<input type='text' class='form-control' placeholder='Typing order id or custommer name'>
							<div class="input-group-btn">
								<button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									Action
								</button>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="#">Action</a></li>
									<li><a class="dropdown-item" href="#">Another action</a></li>
									<li><a class="dropdown-item" href="#">Something else here</a></li>
									<div role="separator" class="dropdown-divider"></div>
									<li><a class="dropdown-item" href="#">Separated link</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class='col-md-6'>
						<input type='date' class='form-control' placeholder='dd/mm/yyyy'>
					</div>
				</div>
			</form>
		</div>
		<div class='user_list'>
			<div class="list">
			</div>
		</div>
	</div>
	<script>
		function user_group_select(_item){
			var _gid=$(_item).attr('dataid');
			$('.user_group_list .menu li').removeClass('checked');
			$(_item).parent().addClass('checked');
			$('#guser_selected').val(_gid);
			getUserByGroup(_gid);
		}
		function getUserByGroup(gid){
			var url='ajaxs/user/getUserByGroup.php';
			$.post(url,{'gid':gid},function(req){
				$('.user_list .list').html(req);
			});
		}
		function changepass_user($this_user){

		}
		function edit_user($this_user){
			var _gid=$('#guser_selected').val();
			var _userid = $($this_user).attr('dataid');
			if(_userid=='' || _userid==0) showMess('Vui lòng chọn thành viên cần sửa','');
			else{
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').addClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Sửa người dùng');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='ajaxs/user/frm_edit_user.php'; 
				$.post(url,{'userid':_userid,'gid':_gid},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E02'){showMess('Không có quyền sửa người dùng ở nhóm này!','error');}
					if(req=='E03'){showMess('Không tồn tại người dùng này!','error');}
					else{
						$('#myModalPopup .modal-body').html(req);
						$('#myModalPopup').modal('show');
					}
				})
			}
			return false;
		}
		function del_user($this_user){
			var _gid=$('#guser_selected').val();
			var _userid = $($this_user).attr('dataid');
			if(_userid=='' || _userid==0) showMess('Vui lòng chọn thành viên cần xóa','');
			else{
			if(confirm("Bạn có chắc muốn xóa?")){
				var _gid=$('#guser_selected').val();
				var _userid = $($this_user).attr('dataid');
				if(_userid=='' || _userid==0) showMess('Chọn một cá nhân để xóa','');
				else{
					var url='ajaxs/user/process_del_user.php'; 
					$.post(url,{'userid':_userid,'gid':_gid},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
						if(req=='E02'){showMess('Không có quyền xóa người dùng ở nhóm này!','error');}
						if(req=='E03'){showMess('Không tồn tại người dùng này!','error');}
						if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
						else{
							getUserByGroup(_gid);
							showMess('Success!','success');
						}
					})
				}
				return false;
			} }
		}
		function active_user($this_user){
			var _gid=$('#guser_selected').val();
			var _userid = $($this_user).attr('dataid');
			if(_userid=='' || _userid==0) showMess('Vui lòng chọn một thành viên','');
			else{
				var url='ajaxs/user/process_active_user.php'; 
				$.post(url,{'userid':_userid,'gid':_gid},function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E02'){showMess('Không có quyền sửa người dùng ở nhóm này!','error');}
					if(req=='E03'){showMess('Không tồn tại người dùng này!','error');}
					if(req=='E04'){showMess('Có lỗi trong quá trình sử lý!','error');}
					else{
						getUserByGroup(_gid);
						showMess('Success!','success');
					}
				})
			}
			return false;
		}
		$(document).ready(function(){
			getUserByGroup(0);
			var body_h=$('.body_body').outerHeight();
			$('.body_body .body_col_left').css({'height':body_h+'px'});
			$('.cmd_group_add a').click(function(){
				$('#myModalPopup .modal-dialog').removeClass('modal-sm');
				$('#myModalPopup .modal-dialog').addClass('modal-lg');
				$('#myModalPopup .modal-header .modal-title').html('Thêm mới nhóm người dùng');
				$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
				var url='ajaxs/user/frm_add_group.php'; 
				$.get(url,function(req){
					if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
					if(req=='E02'){showMess('Không có quyền sửa nhóm này!','error');}
					else{
						$('#myModalPopup .modal-body').html(req);
						$('#myModalPopup').modal('show');
					}
				})
				return false;
			});
			$('.cmd_group_edit a').click(function(){
				var _gid=$('#guser_selected').val();
				if(_gid=='' || _gid==0) showMess('Bạn chưa chọn nhóm để sửa','error');
				else{
					$('#myModalPopup .modal-dialog').removeClass('modal-sm');
					$('#myModalPopup .modal-dialog').addClass('modal-lg');
					$('#myModalPopup .modal-header .modal-title').html('Sửa thông tin nhóm người dùng');
					$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
					var url='ajaxs/user/frm_add_group.php'; 
					$.get(url,{'gid':_gid},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
						if(req=='E02'){showMess('Không có quyền sửa nhóm này!','error');}
						else{
							$('#myModalPopup .modal-body').html(req);
							$('#myModalPopup').modal('show');
						}
					})
				}
				return false;
			});
			$('.cmd_group_del a').click(function(){
				var _gid=$('#guser_selected').val();
				if(_gid=='' || _gid==0) showMess('Bạn chưa chọn nhóm để xóa','error');
				else if(confirm("Bạn có chắc muốn xóa?")){
					var url='ajaxs/user/del_group.php'; 
					$.get(url,{'id':_gid},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
						if(req=='E02'){showMess('Không có quyền xóa nhóm này!','error');}
						$('.user_group_list').html(req);
					});
					return false;
				} 
				return false;
			});
			$('#cmd_user_add').click(function(){
				var _gid=$('#guser_selected').val();
				if(_gid=='undefined' || _gid==0) showMess('Bạn chưa chọn nhóm để thêm','');
				else{
					$('#myModalPopup .modal-dialog').removeClass('modal-sm');
					$('#myModalPopup .modal-dialog').addClass('modal-lg');
					$('#myModalPopup .modal-header .modal-title').html('Đăng ký người dùng');
					$('#myModalPopup .modal-body').html('<p>Loadding...</p>');
					var url='ajaxs/user/frm_add_user.php'; 
					$.get(url,{'id':_gid},function(req){
						if(req=='E01'){showMess('Bạn chưa đăng nhập, xin vui lòng đăng nhập!','error');}
						if(req=='E02'){showMess('Không có quyền thêm người dùng vào nhóm này!','error');}
						else{
							$('#myModalPopup .modal-body').html(req);
							$('#myModalPopup').modal('show');
						}
					})
				}
				return false;
			})
		})
	</script>
</div>
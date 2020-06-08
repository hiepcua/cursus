<?php
	$GLOBALS['ARR_ACTION'] = array(
		'view'		=>1,
		'add'		=>2,
		'edit'		=>4,
		'delete'	=>8
		);
	$GLOBALS['ARR_ACTION_NAME'] = array(
		'view'		=>'Xem',
		'add'		=>'Thêm',
		'edit'		=>'Sửa',
		'delete'	=>'Xóa'
		);
	$GLOBALS['ARR_COM'] = array(
		'config'	=>1,
		'gusers'	=>2,
		'user'		=>4,
		'menus'		=>8,
		'mnuitem'	=>16,
		'category'	=>32,
		'contents'	=>64,
		'gallery'	=>128,
		'ablum'		=>256,
		'video'		=>512,
		'slider'	=>1024,
		'partner'	=>2048,
		'module'	=>4096,
		'mail'		=>8192,
		'document'  =>16384,
		'profile'   =>32768
		);
	$GLOBALS['ARR_COM_ACT'] = array(
		'config'	=>4, // edit
		'gusers'	=>15, 
		'user'		=>15, 
		'menus'		=>15, 
		'mnuitem'	=>15,
		'category'	=>15,
		'contents'	=>15,
		'gallery'	=>15,
		'ablum'		=>15,
		'video'		=>15,
		'slider'	=>15,
		'partner'	=>15,
		'module'	=>15,
		'mail'		=>15,
		'document'	=>15,
		'profile'	=>15
		);
	$GLOBALS['ARR_COM_NAME'] = array(
		'config'	=>'Cấu hình website',
		'gusers'	=>'Nhóm quản trị',
		'user'		=>'Thành viên quản trị',
		'menus'		=>'Menu chính',
		'mnuitem'	=>'Menu con',
		'category'	=>'Nhóm tin',
		'contents'	=>'Bài viết',
		'gallery'	=>'Gallery ảnh',
		'ablum'		=>'Thư viện ảnh',
		'video'		=>'Thư viện Video',
		'slider'	=>'Banner',
		'partner'	=>'Đối tác',
		'module'	=>'Chức năng',
		'mail'		=>'Mail',
		'document'  =>'Mẫu phiếu ĐK xét tuyển',
		'profile'   =>'Đăng ký xét tuyển'
		);
	$GLOBALS['MSG_PERMIS']='<div id="action" style="background-color:#fff; margin:10px 15px;"><h3 align="center">Bạn không có quyền truy cập.</h3></div>';
?>
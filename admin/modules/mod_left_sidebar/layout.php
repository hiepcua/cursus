<?php
if($UserLogin->isLogin()) {
	$PERMISSION = $UserLogin->getInfo('isroot');
}
$objmysql = new CLS_MYSQL();
?>
<div id="left_sidebar">
	<div class="sidebar_top"></div>
	<ul class="sidebar_body">
		<li>
			<a href="<?php echo ROOTHOST_ADMIN;?>" class='toggle' data-toggle="tooltip" data-placement="right" data-original-title="Trang Admin" style="font-weight: bold; border-bottom: 0px;">
				<i class="fa fa-desktop" aria-hidden="true"></i> <span>Bảng điều khiển</span>
			</a>
		</li>

		<li>
			<div class="title"><i class="fa fa-list" aria-hidden="true"></i> <span>Booking tour</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>booking/add" title="Đặt tour"><i class="fa fa-plus" aria-hidden="true"></i> <span>Đặt tour</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>booking" title="Ds đặt tour"><i class="fa fa-bars" aria-hidden="true"></i> <span>Ds đặt tour</span></a></li>
			</ul>
		</li>

		<li>
			<div class="title"><i class="fa fa-list" aria-hidden="true"></i> <span>Quản lý tour</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>tour/add" title="Thêm bài viết"><i class="fa fa-plus" aria-hidden="true"></i> <span>Thêm tour</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>tour" title="Ds bài viết"><i class="fa fa-bars" aria-hidden="true"></i> <span>Ds tour</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>place" title="Ds điểm đến"><i class="fa fa-bars" aria-hidden="true"></i> <span>Ds điểm đến</span></a></li>
			</ul>
		</li>

		<li>
			<div class="title"><i class="fa fa-list" aria-hidden="true"></i> <span>Quản lý tin</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>contents/add" title="Thêm bài viết"><i class="fa fa-plus" aria-hidden="true"></i> <span>Thêm bài viết</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>contents" title="Ds bài viết"><i class="fa fa-bars" aria-hidden="true"></i> <span>Ds bài viết</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>category" title="Ds chuyên mục"><i class="fa fa-bars" aria-hidden="true"></i> <span>Ds chuyên mục</span></a></li>
			</ul>
		</li>

		<li>
			<div class="title"><i class="fa fa-list" aria-hidden="true"></i> <span>Meta SEO</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>seo/add" title="Thêm meta SEO"><i class="fa fa-plus" aria-hidden="true"></i> <span>Thêm Meta SEO</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>seo" title="Ds meta SEO"><i class="fa fa-bars" aria-hidden="true"></i> <span>Danh sách Meta SEO</span></a></li>
			</ul>
		</li>

		<li>
			<div class="title"><i class="fa fa-list" aria-hidden="true"></i> <span>Banner</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>slider/add" title="Thêm banner"><i class="fa fa-plus" aria-hidden="true"></i> <span>Thêm banner</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>slider" title="Banner"><i class="fa fa-bars" aria-hidden="true"></i> <span>Banner</span></a></li>
			</ul>
		</li>

		<!-- <li>
			<div class="title"><i class="fa fa-list" aria-hidden="true"></i> <span>Cảm nhận khách hàng</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>feedback/add" title="Thêm cảm nhận"><i class="fa fa-plus" aria-hidden="true"></i> <span>Thêm cảm nhận</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>feedback" title="Cảm nhận khách hàng"><i class="fa fa-bars" aria-hidden="true"></i> <span>Cảm nhận khách hàng</span></a></li>
			</ul>
		</li> -->

		<li>
			<div class="title"><i class="fa fa-users" aria-hidden="true"></i> <span>Qlý người dùng</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>user/add" title="Thêm mới người dùng"><i class="fa fa-plus" aria-hidden="true"></i> <span>Thêm mới</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>user" title="Danh sách người dùng"><i class="fa fa-bars" aria-hidden="true"></i> <span>Ds người dùng</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>user_group" title="Danh sách nhóm người dùng"><i class="fa fa-bars" aria-hidden="true"></i> <span>Ds nhóm người dùng</span></a></li>
			</ul>
		</li>

		<!-- <li>
			<div class="title"><i class="fa fa-users" aria-hidden="true"></i> <span>Qlý module</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>module/add" title="Thêm mới module"><i class="fa fa-plus" aria-hidden="true"></i> <span>Thêm mới module</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>module" title="Danh sách module"><i class="fa fa-bars" aria-hidden="true"></i> <span>Ds module</span></a></li>
			</ul>
		</li> -->

		<li>
			<div class="title"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Cấu hình</span></div>
			<ul class="sub">
				<li><a href="<?php echo ROOTHOST_ADMIN;?>config/" title="Cấu hình website"><i class="fa fa-bars" aria-hidden="true"></i> <span>Cấu hình website</span></a></li>
				<li><a href="<?php echo ROOTHOST_ADMIN;?>module/" title="QL module"><i class="fa fa-bars" aria-hidden="true"></i> <span>Module chức năng</span></a></li>
			</ul>
		</li>

		<li>
			<a href="javascript:void(0)" onclick="generator_sitemap();" title="Xuất sitemap"><i class="fa fa-cogs" aria-hidden="true"></i><b>Generator sitemap</b></a>
		</li>
	</ul>
</div>
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	})

	function generator_sitemap(){
		$.ajax({
			type: "GET",
			url: "<?php echo ROOTHOST.'sitemap-generator.php';?>" ,
			data: {},
			success : function(res) { 
				showMess('Xuất sitemap thành công!');
			}
		});
	}
</script>
<?php
if($UserLogin->isLogin()) {
	$PERMISSION = $UserLogin->getInfo('isroot');
}
$obj_cate=new CLS_CATEGORY;
$obj_mnu=new CLS_MENU;
?>
<div id="left_sidebar">
	<div class="sidebar_top"></div>
	<ul class="sidebar_body">
		<li><a href="<?php echo ROOTHOST_ADMIN;?>" class='toggle' data-toggle="tooltip" data-placement="right" data-original-title="Trang Admin">
			<i class="fa fa-desktop" aria-hidden="true"></i> <span>Bảng điều khiển</span>
		</a></li>
		<?php if($UserLogin->Permission('category')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>category" title="Nhóm tin" class="dark"><i class="fa fa-list-alt"></i> <span>Nhóm tin</span></a></li>
		<?php } if($UserLogin->Permission('contents')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>contents" title="Bài viết" class="dark"><i class="fa fa-newspaper-o"></i> <span>Bài viết</span> <i class="fa fa-angle-right pull-right"></i></a>
		<?php $obj_cate->getMenuCategory(0,'submenu');?>
		</li>
		<?php } if($UserLogin->Permission('document')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>document" title="Mẫu phiếu đăng ký xét tuyển" class="dark"><i class="fa fa-file"></i> <span>Mẫu phiếu ĐK xét tuyển</span></a></li>
		<?php } if($UserLogin->Permission('profile')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>profile" title="Đăng ký xét tuyển" class="dark"><i class="fa fa-file"></i> <span>Đăng ký xét tuyển</span></a></li>
		<?php } if($UserLogin->Permission('menus')==true){ ?>
		<li><a href="#" title="Menu" class="dark"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Menu</span> <i class="fa fa-angle-right pull-right"></i></a>
		<ul class="submenu"><?php echo $obj_mnu->getListmenu('list');?></ul>
		</li>
		<?php } if($UserLogin->Permission('partner')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>partner" title="Đối tác" class="dark"><i class="fa fa-connectdevelop" aria-hidden="true"></i> <span>Đối tác</span></a></li>
		<?php } if($UserLogin->Permission('gallery')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>gallery" title="gallery" class="dark"><i class="fa fa-picture-o" aria-hidden="true"></i> <span>Thư viện ảnh</span></a></li>
		<?php } if($UserLogin->Permission('video')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>video" title="Video" class="dark"><i class="fa fa-youtube" aria-hidden="true"></i> <span>Thư viên Video</span></a></li>
		<?php } if($UserLogin->Permission('slider')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>slider" title="Slideshow" class="dark"><i class="fa fa-picture-o" aria-hidden="true"></i> <span>SlideShow</span></a></li>
		<?php } if($UserLogin->Permission('user')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>user" title="Quản lý người dùng" class="dark"><i class="fa fa-user" aria-hidden="true"></i> <span>Người dùng</span></a></li>
		<?php } if($UserLogin->Permission('module')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>module" title="Module" class="dark"><i class="fa fa-credit-card" aria-hidden="true"></i> <span>Chức năng</span></a></li>
		<?php } if($UserLogin->Permission('config')==true){ ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>config" title="Cấu hình" class="dark"><i class="fa fa-cog" aria-hidden="true"></i> <span>Cấu hình</span></a></li>
		<?php } ?>
		<li><a href="<?php echo ROOTHOST_ADMIN;?>feedback" title="Cảm nhận khách hàng" class="dark"><i class="fa fa-picture-o" aria-hidden="true"></i> <span>Feedback</span></a></li>
	</ul>
</div>
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip(); 
	})
</script>
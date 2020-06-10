<?php
$isAdmin=getInfo('isadmin');
?>
<nav class="mt-2">
	<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
		<li class="nav-item has-treeview menu-open">
			<a href="<?php echo ROOTHOST;?>" class="nav-link <?php activeMenu('home');?>">
				<i class="nav-icon fas fa-tachometer-alt"></i>
				<p>Dashboard</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo ROOTHOST;?>categories" class="nav-link <?php activeMenu('categories');?>">
				<i class="nav-icon fa fa-server" aria-hidden="true"></i>
				<p>Categories</p>
			</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo ROOTHOST;?>member" class="nav-link <?php activeMenu('member');?>">
				<i class="nav-icon fas fa-users"></i>
				<p>Members </p>
			</a>
		</li>


		<li class="nav-item">
			<a href="<?php echo ROOTHOST;?>feedback" class="nav-link <?php activeMenu('feedback');?>">
				<i class="nav-icon fas fa-comment-dots"></i>
				<p>Feedback</p>
			</a>
		</li>


		<li class="nav-item">
			<a href="<?php echo ROOTHOST;?>user" class="nav-link <?php activeMenu('user');?>">
				<i class="nav-icon fas fa-user"></i>
				<p>User </p>
			</a>
		</li>
		<li class="nav-item">
			<a href="<?php echo ROOTHOST;?>groupuser" class="nav-link <?php activeMenu('groupuser');?>">
				<i class="nav-icon fas fa-users"></i>
				<p>Group user </p>
			</a>
		</li>
		<li class="nav-item has-treeview">
			<a href="<?php echo ROOTHOST;?>setting" class="nav-link <?php activeMenu('setting');?>">
				<i class="nav-icon fas fa-user-cog"></i>
				<p>Setting </p>
			</a>
		</li>
		<li class="nav-item has-treeview">
			<a href="javascript:void(0);" class="nav-link logout">
				<i class="nav-icon fas fa-sign-out-alt"></i>
				<p>Logout </p>
			</a>
		</li>
	</ul>
</nav>
<script>
	$('.logout').click(function(){
		var _url="<?php echo ROOTHOST;?>ajaxs/user/logout.php";
		$.get(_url,function(){
			window.location.reload();
		})
	})
</script>
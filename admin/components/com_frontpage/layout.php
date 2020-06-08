<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">Dashboard</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item active">Dashboard</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-12 col-sm-6 col-md-3">
				<a href="<?php echo ROOTHOST_ADMIN;?>config">
					<div class="info-box">
						<span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Cấu hình website</span>
						</div>
						<!-- /.info-box-content -->
					</div>
				</a>
				<!-- /.info-box -->
			</div>
			<div class="col-12 col-sm-6 col-md-3">
				<a href="<?php echo ROOTHOST_ADMIN;?>module">
					<div class="info-box">
						<span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Quản lý module</span>
						</div>
						<!-- /.info-box-content -->
					</div>
				</a>
				<!-- /.info-box -->
			</div>

			<div class="col-12 col-sm-6 col-md-3">
				<a href="<?php echo ROOTHOST_ADMIN;?>menus">
					<div class="info-box">
						<span class="info-box-icon bg-info elevation-1"><i class="fab fa-elementor"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Quản lý menu</span>
						</div>
						<!-- /.info-box-content -->
					</div>
				</a>
				<!-- /.info-box -->
			</div>

			<!-- fix for small devices only -->
			<div class="clearfix hidden-md-up"></div>

			<div class="col-12 col-sm-6 col-md-3">
				<a href="<?php echo ROOTHOST_ADMIN;?>user">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">Quản lý người dùng</span>
						</div>
						<!-- /.info-box-content -->
					</div>
				</a>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

			<div class="col-12 col-sm-6 col-md-3">
				<a href="<?php echo ROOTHOST_ADMIN;?>user_group">
					<div class="info-box mb-3">
						<span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

						<div class="info-box-content">
							<span class="info-box-text">QL nhóm người dùng</span>
						</div>
						<!-- /.info-box-content -->
					</div>
				</a>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

			<div class="col-12 col-sm-6 col-md-3">
				<a href="javascript:void(0)" onclick="generator_sitemap();">
					<div class="info-box">
						<span class="info-box-icon bg-info elevation-1"><i class="fas fa-sitemap"></i></span>
						<div class="info-box-content">
							<span class="info-box-text">Generator sitemap</span>
						</div>
						<!-- /.info-box-content -->
					</div>
				</a>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			
		</div>
	</div>
</section>
<!-- /.row -->
<!-- /.content-header -->
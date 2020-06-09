<?php
$user=getInfo('username');
$mType=getInfo('mtype');
$isAdmin=getInfo('isadmin');
$code=isset($_GET['code'])?antiData($_GET['code']):'';
$isTeacher=isTeacher($user,$code);
$table='tbl_class';
$strWhere='';
$strWhere.=" AND code ='$code' ";	
$totalRows=SysCountList($table,$strWhere);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark">View a room</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Home</a></li>
					<li class="breadcrumb-item active"><a href="<?php echo ROOTHOST;?>class">Rooms</a></li>
					<li class="breadcrumb-item active">view</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content"><div class='container-fluid'>
	<?php if($totalRows<=0){ ?>
		<!-- Default box -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">No room yet!</h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
						<i class="fas fa-minus"></i>
					</button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
						<i class="fas fa-times"></i>
					</button>
				</div>
			</div>
			<div class="card-body text-center">
				<a href='<?php echo ROOTHOST;?>class' class='btn btn-primary btn-lg'>Back Rooms</a>
			</div>
			<!-- /.card-body -->
			<div class="card-footer"></div>
		</div>
		<?php 
	}else{
		$obj=SysGetList($table,array(),$strWhere);
		$r=$obj[0];
		$numberMeeting=SysCountList('tbl_schedule'," AND class_code='$code'");
		$numberMember=SysCountList('tbl_class_member'," AND class_code='$code'");
		?>
		<!-- Widget: user widget style 1 -->
		<div class="card card-widget widget-user">
			<!-- Add the bg color to the header using any of the bg-* classes -->
			<div class="widget-user-header text-white" style="background: url('<?php echo ROOTHOST;?>global/dist/img/photo1.png') center center;">
				<h3 class="widget-user-username text-right"><?php echo $r['name'];?> </h3>
				<h5 class="widget-user-desc text-right"><?php echo $r['code'];?></h5>
			</div>
			<div class="widget-user-image">
				<img class="img-circle" src="<?php echo ROOTHOST;?>global/img/room.png" alt="User Avatar">
			</div>
			<div class="card-footer">
				<div class="row">
					<div class="col-sm-4 border-right">
						<div class="description-block">
							<h5 class="description-header"><?php echo number_format($numberMeeting);?></h5>
							<span class="description-text">Meeting</span>
						</div>
						<!-- /.description-block -->
					</div>
					<!-- /.col -->
					<div class="col-sm-4 border-right">
						<div class="description-block">
							<h5 class="description-header"><?php echo number_format($numberMember);?></h5>
							<span class="description-text">Members</span>
						</div>
						<!-- /.description-block -->
					</div>
					<!-- /.col -->
					<div class="col-sm-4">
						<div class="description-block">
							<h5 class="description-header">0</h5>
							<span class="description-text">PRODUCTS</span>
						</div>
						<!-- /.description-block -->
					</div>
					<!-- /.col -->
				</div>
				<!-- /.row -->
			</div>
		</div>
		<!------------------------------------------------------------------->
		<div class="card card-tabs">
			<div class="card-header p-0 pt-1">
				<ul class="nav nav-tabs text-center" id="custom-tabs-two-tab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="custom-tabs-two-home-tab" data-toggle="pill" href="#room-schedule" role="tab" aria-controls="custom-tabs-two-home" aria-selected="true">Meeting</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="custom-tabs-two-profile-tab" data-toggle="pill" href="#room-members" role="tab" aria-controls="custom-tabs-two-profile" aria-selected="false">Members</a>
					</li>
				</ul>
			</div>
			<div class="card-body">
				<div class="tab-content" id="custom-tabs-two-tabContent">
					<div class="tab-pane fade active show" id="room-schedule" role="tabpanel">
						<?php include('meeting_class.php');?>
					</div>
					<div class="tab-pane fade" id="room-members" role="tabpanel">
						<?php //include('member_class.php');?>
					</div>
				</div>
			</div>
			<!-- /.card -->
		</div>
	</div>
	<!---------------------------------------------------------------------------->
	<!-- /.widget-user -->
<?php }?>
</div></section>
<script>
	$(document).ready(function(){
		$('#room-members').load('<?php echo ROOTHOST;?>ajaxs/room/load_member_room.php?code=<?php echo $code;?>');
		$('.btn_add_room').click(function(){
			var _url="<?php echo ROOTHOST;?>ajaxs/room/frm_add.php";
			$.get(_url,function(req){
				$('#popup_modal .modal-body').html(req);
				$('#popup_modal').modal('show')
			});
		});
	});
</script>
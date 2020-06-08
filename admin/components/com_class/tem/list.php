<?php
$user=getInfo('username');
$isAdmin=getInfo('isadmin');
$isTeacher=1;
$table='tbl_class';
$strWhere='';
if($isAdmin!=1){
	$strWhere.=" AND code in (SELECT class_code FROM tbl_class_member WHERE username='$user') ";	
}
$totalRows=SysCountList($table,$strWhere);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark"><?php echo LANG['COM_CLASS']['TITLE_LIST'];?></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST;?>">Home</a></li>
					<li class="breadcrumb-item active"><?php echo LANG['COM_CLASS']['BRECUM_SCHEDULE'];?></li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content"><div class='container-fluid'>
	<?php if($totalRows<=0){?>
		<!-- Default box -->
		<div class="card">
			<div class="card-header">
				<h3 class="card-title"><?php echo LANG['COM_CLASS']['NO_DATA'];?></h3>
				<div class="card-tools">
					<button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fas fa-minus"></i></button>
					<button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove"><i class="fas fa-times"></i></button>
				</div>
			</div>
			<div class="card-body text-center">
				<?php if($isAdmin==1){ ?>
					<button class='btn btn-primary btn-lg btn_add_room'><?php echo LANG['COM_CLASS']['ADD_ROOM'];?></button>
				<?php }?>
			</div>
			<!-- /.card-body -->
			<div class="card-footer"></div>
		</div>
		<?php 
	}else{
		?>
		<style>
			.room,.btn_add_room{cursor:pointer;}
		</style>
		<div class='row room_list'>
			<?php if($isAdmin==1){ ?>
				<div class="col-lg-3 col-6">
					<div class='text-right'>
					<i class="fas fa"></i>
					</div>
					<!-- small card -->
					<div class="small-box bg-info btn_add_room">
						<!-- Loading (remove the following to stop the loading)-->
						<div class="overlay">
							<i class="fas fa-3x fa-sync-alt"></i>
						</div>
						<!-- end loading -->
						<div class="inner">
							<h3><?php echo LANG['COM_CLASS']['ADD_NEW'];?></h3>
							<p>&nbsp;</p>
						</div>
						<div class="icon">
							<i class="fas fa-shopping-cart"></i>
						</div>
						<a href="#" class="small-box-footer">
							&nbsp;
						</a>
					</div>
				</div>
			<?php }?>
			<?php 
			$obj=SysGetList($table,array(),$strWhere,false);
			while($r=$obj->Fetch_Assoc()){
				$code=$r['code'];
				$totalMember=SysCountList('tbl_class_member',"AND class_code='$code'");
				$arrTeach=SysGetList('tbl_class_member',array(),"AND class_code='$code' AND mtype='teach'");
				$Teacher=count($arrTeach)>0?'L:'.$arrTeach[0]['username']:'There are no leader!';
				?>
				<div class="col-md-3 col-sm-6 col-6">
					<?php if($isAdmin==1){ ?>
					<div class='text-right'>
					<a href='javascript:void(0);' title='Sửa'><i class="fas fa-edit btn_edit_room" datacode="<?php echo $code;?>"></i></a>
					<a href='javascript:void(0);' title='Xóa'><i class="fas fa-trash btn_trash_room" datacode="<?php echo $code;?>"></i></a>
					</div>
					<?php }?>
					<div class="info-box bg-info room" datacode='<?php echo $r['code'];?>' style='overflow:hidden;'>
						<span class="info-box-icon hidden-xs"><i class="far fa-bookmark"></i></span>
						<div class="info-box-content">
							<span class="info-box-text"><h4><?php echo $r['name'];?></h4></span>
							<span class="info-box-text">Code: <?php echo $r['code'];?></span>
							<span class="info-box-number"><?php echo $totalMember;?> member</span>

							<div class="progress">
								<div class="progress-bar" style="width: 70%"></div>
							</div>
							<span class="progress-description">
								<?php echo $Teacher;?>
							</span>
						</div>
						<!-- /.info-box-content -->
					</div>
					<!-- /.info-box -->
				</div>
			<?php } ?>
		</div>
	<?php }?>
</div></section>
<script>
	$(document).ready(function(){
		<?php if($isAdmin==1){ ?>
		$('.btn_add_room').click(function(){
			var _url="<?php echo ROOTHOST;?>ajaxs/room/frm_add.php";
			$.get(_url,function(req){
				$('#popup_modal .modal-body').html(req);
				$('#popup_modal').modal('show')
			});
		});
		$('.btn_edit_room').click(function(){
			var _url="<?php echo ROOTHOST;?>ajaxs/room/frm_edit.php";
			var _data={'code':$(this).attr('datacode')}
			$.post(_url,_data,function(req){
				$('#popup_modal .modal-body').html(req);
				$('#popup_modal').modal('show')
			});
		});
		$('.btn_trash_room').click(function(){
			if(confirm('Bạn chắc chắn muốn xóa room này?')){
				var _url="<?php echo ROOTHOST;?>ajaxs/room/process_del.php";
				var _data={'code':$(this).attr('datacode')}
				$.post(_url,_data,function(req){
					window.location.reload();
				});
			}
		});
		<?php }?>
		$('.room_list .room').click(function(){
			var _code=$(this).attr('datacode');
			window.location.href='<?php echo ROOTHOST;?>class/view?code='+_code;
		})
	});
</script>
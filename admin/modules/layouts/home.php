<!-- Notify -->
<!-- <div id="notify">
    <div class="wrap-toast">
        <div class="toast" data-autohide="false">
            <div class="toast-header">
                <strong class="mr-auto text-primary">Toast Header</strong>
                <small class="text-muted">5 mins ago</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                Some text inside the toast body
            </div>
        </div>
    </div>
</div> -->
<?php
if(!$UserLogin->isLogin()){
    if(isset($_GET['com'])) echo "<script>window.location='".ROOTHOST_ADMIN."'</script>";
    include_once(COM_PATH."com_user/task/login.php");
}else{ ?>
    <?php include_once('navbar.php'); ?>
    <?php include_once('main_sidebar.php'); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <?php 
        $GLOBALS['LINK'] = '';
        $GLOBALS['COM'] = '';
        $com = isset($_GET['com']) ? $_GET['com']:'frontpage';
        $_task = isset($_GET['task']) ? $_GET['task']:'';

        $GLOBALS['COM'] = $com;
        $GLOBALS['LINK'] = $_task !== '' ? $com.'/'.$_task : $com;

        if(!is_file(COM_PATH.'com_'.$com.'/layout.php')){ $com='frontpage'; }
        include_once(COM_PATH.'com_'.$com.'/layout.php');?>
    </div>
    <!-- /.content-wrapper -->
    <?php include_once('control_sidebar.php'); ?>
    <?php } ?>
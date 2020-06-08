<?php
$bodyClass=isLogin()?'sidebar-mini layout-fixed':'login-page';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo SITE_NAME;?> | <?php echo LANG['LEFT_SIDEBAR']['DASHBOARD'];?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta property="og:url"           content="<?php echo ROOTHOST; ?>" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="<?php echo SITE_NAME;?>" />
    <meta property="og:description"   content="<?php echo SITE_NAME;?>" />
    <meta property="og:image"         content="" />

    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/fontawesome-free/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/bootstrap-datetimepicker.css">
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="<?php echo ROOTHOST;?>global/css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <script src="<?php echo ROOTHOST;?>global/plugins/jquery/jquery.min.js"></script>
    <script src="<?php echo ROOTHOST;?>global/plugins/jquery-ui/jquery-ui.min.js"></script>
</head>
<body id="body" class="hold-transition <?php echo $bodyClass;?>">
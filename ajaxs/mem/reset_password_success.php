<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
?>
<p class="login-box-msg" style="font-size: 16px;"><?php echo LANG['COM_MEMBER']['RESETPASS_TITLE'];?></p>
<div><?php echo LANG['COM_MEMBER']['RESETPASS_CONTENT1'];?></div>
<br/>
<div><?php echo LANG['COM_MEMBER']['RESETPASS_CONTENT2'];?></div>
<div class="row">
    <!-- /.col -->
    <div class="col-4">
        <a href="<?php echo ROOTHOST;?>" class="btn btn-primary btn-block">Login</a>
    </div>
    <!-- /.col -->
    <div class="col-4"></div>
</div>
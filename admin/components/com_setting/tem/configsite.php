<?php
$objmysql 	= new CLS_MYSQL();
$msg 		= new \Plasticbrain\FlashMessages\FlashMessages();
if(!isset($_SESSION['flash'.'com_'.COMS])) $_SESSION['flash'.'com_'.COMS] = 2;

$title =''; $desc=''; $key='';$email_contact=''; $nickyahoo=''; $nameyahoo='';
$footer=''; $contact=''; $banner=''; $gallery=''; $logo='';

if(isset($_POST['web_title']) && $_POST['web_title']!='') {
	$CompanyName 	= isset($_POST['company_name']) ? addslashes($_POST['company_name']) : '';
	$Title 			= isset($_POST['web_title']) ? addslashes($_POST['web_title']) : '';
	$Meta_descript 	= isset($_POST['web_desc']) ? addslashes($_POST['web_desc']) : '';
	$Meta_keyword 	= isset($_POST['web_keywords']) ? addslashes($_POST['web_keywords']) : '';
	$Email 			= isset($_POST['email_contact']) ? addslashes($_POST['email_contact']) : '';
	$Address 		= isset($_POST['address']) ? addslashes($_POST['address']) : '';
	$Phone 			= isset($_POST['txtphone']) ? addslashes($_POST['txtphone']) : '';
	$Tel 			= isset($_POST['txttel']) ? addslashes($_POST['txttel']) : '';
	$Fax 			= isset($_POST['txtfax']) ? addslashes($_POST['txtfax']) : '';
	$Twitter 		= isset($_POST['txttwitter']) ? addslashes($_POST['txttwitter']) : '';
	$Gplus 			= isset($_POST['txtgplus']) ? addslashes($_POST['txtgplus']) : '';
	$Facebook 		= isset($_POST['txtfacebook']) ? addslashes($_POST['txtfacebook']) : '';
	$Youtube 		= isset($_POST['txtyoutube']) ? addslashes($_POST['txtyoutube']) : '';
	$Work_time 		= isset($_POST['txt_work_time']) ? addslashes($_POST['txt_work_time']) : '';

	$Notification	= isset($_POST['time_notification']) ? (int)$_POST['time_notification'] : '';
	$Email_notification	= isset($_POST['email_notification']) ? (int)$_POST['email_notification'] : 0;
	$Sms_notification	= isset($_POST['sms_notification']) ? (int)$_POST['sms_notification'] : 0;

	$arr=array();
	$arr['title'] = $Title;
	$arr['company_name'] = $CompanyName;
	$arr['phone'] = $Phone;
	$arr['tel'] = $Tel;
	$arr['fax'] = $Fax;
	$arr['email'] = $Email;
	$arr['address'] = $Address;
	$arr['work_time'] = $Work_time;
	$arr['meta_keyword'] = $Meta_keyword;
	$arr['twitter'] = $Twitter;
	$arr['gplus'] = $Gplus;
	$arr['facebook'] = $Facebook;
	$arr['youtube'] = $Youtube;
	$arr['notification'] = $Notification;
	$arr['email_notification'] = $Email_notification;
	$arr['sms_notification'] = $Sms_notification;
	$arr['meta_descript'] = $Meta_descript;

	$result = SysEdit('tbl_configsite', $arr, " `config_id`=1 ");
	if($result) $_SESSION['flash'.'com_'.COMS] = 1;
	else $_SESSION['flash'.'com_'.COMS] = 0;
}

$sql="SELECT * FROM `tbl_configsite` WHERE `config_id`=1";
$objmysql->Query($sql);

if($objmysql->Num_rows()<=0) {
	echo 'Dữ liệu trống.';
}else{
	$row = $objmysql->Fetch_Assoc();
	$title          = stripslashes($row['title']);
	$company_name   = stripslashes($row['company_name']);
	$desc           = stripslashes($row['meta_descript']);
	$key            = stripslashes($row['meta_keyword']);
	$email_contact  = stripslashes($row['email']);
	$address        = stripslashes($row['address']);
	$phone          = stripslashes($row['phone']);
	$tel            = stripslashes($row['tel']);
	$fax            = stripslashes($row['fax']);
	$facebook       = stripslashes($row['facebook']);
	$youtube        = stripslashes($row['youtube']);
	$gplus          = stripslashes($row['gplus']);
	$twitter        = stripslashes($row['twitter']);
	$work_time      = stripslashes($row['work_time']);
	$notification   = (int)$row['notification'];
	$email_notification   = (int)$row['email_notification'];
	$sms_notification   = (int)$row['sms_notification'];
}
unset($objmysql);
?>
<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0 text-dark" style="text-transform: uppercase;"><?php echo LANG['COM_SETTING']['COM_TITLE'];?></h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?php echo ROOTHOST_ADMIN;?>">Home</a></li>
					<li class="breadcrumb-item active"><?php echo LANG['COM_SETTING']['COM_TITLE'];?></li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<?php
		if (isset($_SESSION['flash'.'com_'.COMS])) {
			if($_SESSION['flash'.'com_'.COMS] == 1){
				$msg->success('Cập nhật thành công.');
				echo $msg->display();
			}else if($_SESSION['flash'.'com_'.COMS] == 0){
				$msg->error('Có lỗi trong quá trình cập nhật.');
				echo $msg->display();
			}
			unset($_SESSION['flash'.'com_'.COMS]);
		}
		?>
		<div id='action'>
			<div class="wrap_tab_column">
				<div class="tab_column_control">
					<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
						<a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true"><?php echo LANG['COM_SETTING']['TAB_WEBCONFIG'];?></a>
						<a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false"><?php echo LANG['COM_SETTING']['TAB_CONTACT_INFO'];?></a>
						<a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false"><?php echo LANG['COM_SETTING']['TAB_SET_TIME_NOTIFY'];?></a>
						<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false"><?php echo LANG['COM_SETTING']['TAB_SOCIAL'];?></a>
					</div>
				</div>
				<div class="tab_column_container card">
					<form name="frm_action" id="frm_action" action="" method="post">
						<div class="tab-content" id="v-pills-tabContent">
							<div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
								<div class="form-group">
									<label class="col-sm-3 col-md-2 control-label"><?php echo LANG['COM_SETTING']['FRM_NAME'];?><font color="red"><font color="red">*</font></font></label>
									<div class="col-md-12">
										<input type="text" name="web_title" class="form-control" id="web_title" value="<?php echo $title;?>" placeholder="">
										<div id="txt_name_err" class="mes-error"></div>
									</div>
									<div class="clearfix"></div>
								</div>
								<!-- <div class="form-group">
									<label class="col-sm-3 col-md-2 control-label">Tên công ty</label>
									<div class="col-md-12">
										<input type="text" name="company_name" class="form-control" value="<?php echo $company_name;?>" placeholder="">
									</div>
									<div class="clearfix"></div>
								</div> -->
								<div class="form-group">
									<label class="col-sm-3 col-md-2 control-label"><?php echo LANG['COM_SETTING']['FRM_META_DESC'];?><font color="red"><font color="red">*</font></font></label>
									<div class="col-md-12">
										<input type="text" name="web_desc" class="form-control" id="web_desc" value="<?php echo $desc;?>" placeholder="">
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 col-md-2 control-label"><?php echo LANG['COM_SETTING']['FRM_META_KEY'];?><font color="red">*</font></label>
									<div class="col-md-12">
										<input type="text" name="web_keywords" class="form-control" id="web_keywords" value="<?php echo $key;?>" placeholder="">
									</div>
									<div class="clearfix"></div>
								</div>
							</div>

							<div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_EMAIL'];?><font color="red">*</font></label>
											<div>
												<input type="text" name="email_contact" class="form-control" id="email_contact" value="<?php echo $email_contact;?>" placeholder="">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_PHONE'];?></label>
											<div>
												<input type="text" name="txtphone" class="form-control" id="txtphone" value="<?php echo $phone;?>" placeholder="">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_TEL'];?></label>
											<div>
												<input type="text" name="txttel" class="form-control" id="txttel" value="<?php echo $tel;?>" placeholder="Tel number">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_FAX'];?></label>
											<div>
												<input type="text" name="txtfax" class="form-control" id="txtfax" value="<?php echo $fax;?>" placeholder="Fax">
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_WORKING_HOURS'];?></label>
											<div>
												<input type="text" name="txt_work_time" class="form-control" value="<?php echo $work_time;?>" placeholder="Working hours">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-sm-3 col-md-2 control-label"><?php echo LANG['COM_SETTING']['FRM_ADDRESS'];?></label>
											<div class="col-md-12">
												<input type="text" name="address" class="form-control" id="address" value="<?php echo $address;?>" placeholder="Address">
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
								<div><?php echo LANG['COM_SETTING']['FRM_DESC_SET_TIME'];?></div><hr size="1" style="margin:10px 0 20px;">

								<?php
								if($email_notification !== 0){
									echo '<div class="checkbox">
									<label><input id="chk_email_notify" type="checkbox" value="" checked>&nbsp&nbsp '.LANG['COM_SETTING']['FRM_TURN_ON_EMAIL_NOTIFY'].'</label>
									</div>';

									echo '<div class="row form-group">
									<div class="col-md-6">
									<input type="number" min="0" name="email_notification" class="form-control" id="email_notification" value="'.$email_notification.'" placeholder="Số phút">
									</div>
									</div>';
								}else{
									echo '<div class="checkbox">
									<label><input id="chk_email_notify" type="checkbox" value="">&nbsp&nbsp '.LANG['COM_SETTING']['FRM_TURN_ON_EMAIL_NOTIFY'].'</label>
									</div>';

									echo '<div class="row form-group">
									<div class="col-md-6">
									<input type="number" min="0" name="email_notification" class="form-control d-none" id="email_notification" value="" placeholder="Số phút">
									</div>
									</div>';
								}

								if($sms_notification !== 0){
									echo '<div class="checkbox">
									<label><input id="chk_sms_notify" type="checkbox" value="" checked>&nbsp&nbsp '.LANG['COM_SETTING']['FRM_TURN_ON_SMS_NOTIFY'].'</label>
									</div>';

									echo '<div class="row form-group">
									<div class="col-md-6">
									<input type="number" min="0" name="sms_notification" class="form-control" id="sms_notification" value="'.$sms_notification.'" placeholder="Số phút">
									</div>
									</div>';
								}else{
									echo '<div class="checkbox">
									<label><input id="chk_sms_notify" type="checkbox" value="">&nbsp&nbsp '.LANG['COM_SETTING']['FRM_TURN_ON_SMS_NOTIFY'].'</label>
									</div>';

									echo '<div class="row form-group">
									<div class="col-md-6">
									<input type="number" min="0" name="sms_notification" class="form-control d-none" id="sms_notification" value="" placeholder="Số phút">
									</div>
									</div>';
								}
								?>
							</div>

							<div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
								<div><?php echo LANG['COM_SETTING']['TAB_SOCIAL'];?></div><hr size="1" style="margin:10px 0 20px;">
								<div class="row form-group">
									<div class="col-md-6">
										<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_FACEBOOK'];?></label>
										<input type="text" name="txtfacebook" class="form-control" id="txtfacebook" value="<?php echo $facebook;?>" placeholder="Facebook link">
									</div>
									<div class="col-md-6">
										<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_GG'];?></label>
										<input type="text" name="txtgplus" class="form-control" id="txtgplus" value="<?php echo $gplus;?>"placeholder="G+ link">
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-6">
										<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_TWITTER'];?></label>
										<input type="text" name="txttwitter" class="form-control" id="txttwitter" value="<?php echo $twitter;?>" placeholder="Twitter link">
									</div>
									<div class="col-md-6">
										<label class="control-label"><?php echo LANG['COM_SETTING']['FRM_YOUTUBE'];?></label>
										<input type="text" name="txtyoutube" class="form-control" id="txtyoutube" value="<?php echo $youtube;?>" placeholder="Youtube link">
									</div>
								</div>
							</div>
						</div>

						<div class="text-center toolbar">
							<input type="submit" name="cmdsave_tab1" id="cmdsave_tab1" class="save btn btn-success" value="<?php echo LANG['COM_SETTING']['FRM_SAVE'];?>" class="btn btn-primary">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(document).ready(function(){
		$('#chk_email_notify').click(function(){
			$('#email_notification').toggleClass('d-none');
			$('#email_notification').val(0);
		});

		$('#chk_sms_notify').click(function(){
			$('#sms_notification').toggleClass('d-none');
			$('#sms_notification').val(0);
		});
	});
</script>
<!-- /.row -->
<!-- /.content-header -->
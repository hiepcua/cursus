<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');

//require_once(libs_path."PHPMailer/src/PHPMailer.php");
//require_once(libs_path."PHPMailer/src/Exception.php");
//require_once(libs_path."PHPMailer/src/OAuth.php");
//require_once(libs_path."PHPMailer/src/POP3.php");
//require_once(libs_path."PHPMailer/src/SMTP.php");

//use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\Exception;
/*
function sendMail($title, $body, $alt_body, $email_to) {
	try {
		$mail = new PHPMailer(true);       
		//Server settings
		$mail->SMTPDebug = 0;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  					  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'classhub.5gmedia@gmail.com';       // SMTP username
		$mail->Password = '5gmedia@123';                      // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 587;                                    // TCP port to connect to
		$mail->CharSet  = 'UTF-8';                            // TCP port to connect to
		$mail->addAddress($email_to);     // Add a recipient
		$mail->addReplyTo('noreply.5gmedia@gmail.com', 'Information');

		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $title;
		$mail->Body    = $body;
		$mail->AltBody = $alt_body;
	 
	 	if($mail->send()){
	 		return 1;
	 	}else{
	 		return 0;
	 	}
		// echo 'Message has been sent<br/>';
	} catch (Exception $e) {
		return 0;
		// echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
}
*/
if(isLogin()){
	$user=getInfo('username');
	$timerange=antiData($_POST['time']);
	$timerange=explode('-',$timerange);
	$stime=strtotime(trim($timerange[0]));
	$ttime=strtotime(trim($timerange[1]));
	if($ttime-$stime>5*60){ //5 minutes
		$arr=array();
		$arr['class_code']=un_unicode(antiData($_POST['class_code']));
		$arr['title']=antiData($_POST['title']);
		$arr['intro']=antiData($_POST['intro']);
		$arr['stime']=$stime;
		$arr['ttime']=$ttime;
		$arr['cdate']=time();
		$arr['cuser']=$user;
		SysAdd('tbl_schedule',$arr);
		
		/* // Get list member by class code
		$arr_email=[];
		$strWhere=" AND class_code='".$arr['class_code']."'";
		$list_members = SysGetList('tbl_class_member',array(),$strWhere,false);
		while($r = $list_members->Fetch_Assoc()){
			//array_push($arr_email, $r['username']);
			// Send mail
			$link_css = ROOTHOST.'global/css/css_email.css';
			$start_time = date("d-m/Y H:i A", $arr['stime']);
			$t_time = date("d-m/Y H:i A", $arr['ttime']);
			$title="ClassHub thông báo Lịch họp!";
			$body='
			<meta charset="utf-8"/>
			<div class="wrapper">
			<div class="body">
				<div>Xin chào '.$r['username'].'</div>
				<div>Chúng tôi xin trân trọng thông báo bạn có lịch họp "<b style="text-transform:uppercase;">'.$arr["title"].'</b>"</div>
				<div>
				<div>Thời gian tham gia cuộc họp: <b>'.$start_time.'</b></div>
				<div>Thời gian kết thúc: <b>'.$t_time.'</b></div>
				</div>
				<div>Nội dung cuộc họp: </div>
				<div>'.$arr['intro'].'</div>
				<br>
			</div>
			<div class="footer"><p>Trân trọng cám ơn.</p></div>';
			$alt_body='';
			$res = sendMail($title, $body, $alt_body, $r['username']);
		} */
		die('success');
	}else{
		die('Meeting time must be greater than 5 minutes');
	}
}else{
	die('Session expired! Please login to continue');
}
<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
define('root_path','../../');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
if(isLogin()){
	$flag=true;$mess='';
	$user=getInfo('username');
	$arr=array();
	//-------------------------------------------------
	$stime=strtotime(antiData($_POST['stime']))-strtotime(date('Y-m-d'));
	$ttime=strtotime(antiData($_POST['ttime']))-strtotime(date('Y-m-d'));
	$loopType=antiData($_POST['loop_type'],'int');
	if($ttime-$stime<5*60){
		$flag=false;
		$mess.="Thời gian họp phải ít nhất 5 phút.<br/>";
	}
	$arr['loop_type']=$loopType;
	if((int)$loopType==4){
		$day=strtotime(antiData($_POST['day']));
		$arr['stime']=$stime+$day;
		$arr['ttime']=$ttime+$day;
		if($_POST['day']==''){
			$flag=false;
			$mess.="Bạn phải nhập ngày cho cuộc họp.<br/>";
		}
	}else{
		$arr['stime']=$stime;
		$arr['ttime']=$ttime;
		if((int)$loopType==2){
			$dayWeek=antiData($_POST['day_of_week']);
			if($dayWeek==''){
				$flag=false;
				$mess.="Bạn phải chọn ít nhất một thứ trong tuần.<br/>";
			}
			$arr['loop_day']=$dayWeek;
		}
		if((int)$loopType==3){
			$dayList=antiData($_POST['day_list']);
			if($dayList==''){
				$flag=false;
				$mess.="Bạn phải chọn ít nhất một ngày trong tháng.<br/>";
			}
			$arr['loop_day']=$dayList;
		}
		//---------------------------------------------------
		$arr['loop_finish']=antiData($_POST['opt_finish'],'int');
		if($arr['loop_finish']==2){
			$arr['loop_finish_day']=strtotime(antiData($_POST['finish_date']));
			if($arr['loop_finish_day']==''){
				$flag=false;
				$mess.="Bạn phải nhập ngày finish cho option này.<br/>";
			}
		}
		if($arr['loop_finish']==3){
			$arr['loop_finish_num']=antiData($_POST['finish_loop'],'int');
			if($arr['loop_finish_num']==''){
				$flag=false;
				$mess.="Bạn phải nhập số lần lặp cho finish.<br/>";
			}
		}
	}
	$arr_current_data = is_file(root_path.'json_invite.json')?json_decode(file_get_contents(root_path.'json_invite.json'),true):array();
	$un_name = un_unicode(antiData($_POST['title']));
	
	if($_POST['title']){
		if($_POST['title'] == ''){
			$flag=false;
			$mess.="Bạn phải nhập tiêu đề cho cuộc họp.<br/>";
		}else{
			if(isset($arr_current_data[$un_name])) $flag = false;
			$mess.="Đã tồn tại cuộc họp với tiêu đề trên.<br/>";
		}
	}
	
	if($flag){ //5 minute
		$arr['class_code']=un_unicode(antiData($_POST['class_code']));
		$arr['title']=antiData($_POST['title']);
		$arr['intro']=antiData($_POST['intro']);
		$arr['cdate']=time();
		$arr['cuser']=$user;
		$rid=SysAdd('tbl_schedule',$arr);
		$arr['id']=$rid;
	
		// Add json file
		$arr_current_data[$un_name] = $arr;
		$json_data = json_encode($arr_current_data);
		file_put_contents(root_path.'json_invite.json', $json_data);

		$current_data = file_get_contents(root_path.'json_invite.json');
		$arr_current_data = json_decode($current_data, true);

		die('success');
	}else{
		die($mess);
	}
}else{
	die('Session expired! Please login to continue');
}
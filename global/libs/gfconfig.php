<?php
if(preg_match("/(iPad)/i", $_SERVER["HTTP_USER_AGENT"])) $device = 'desktop';
elseif(preg_match("/(iPhone|iPod|android|blackberry|Mobile|Lumia)/i", $_SERVER["HTTP_USER_AGENT"])) $device = 'mobile';
else $device = 'desktop';
define('DEVICE', $device);

$isSecure = false;
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') $isSecure = true;
elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') $isSecure = true;
else $isSecure = false;
define('SSL', $isSecure);

$REQUEST_PROTOCOL = $isSecure ? 'https://' : 'http://';
define('ROOTHOST',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/cursus/');
define('ROOTHOST_ADMIN',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/sys/');
define('WEBSITE',$REQUEST_PROTOCOL.$_SERVER['HTTP_HOST'].'/');
define('ROOT_MEDIA','/home/admin/web/openlearn.5gmedia.vn/public_html/uploads/media/');
define('BASEVIRTUAL0','/home/admin/web/openlearn.5gmedia.vn/public_html/uploads/');
define('MEDIA_HOST',ROOTHOST.'uploads/media/');
define('IMAGE_HOST',ROOTHOST.'uploads/media/');
define('AVATAR_DEFAULT',ROOTHOST.'global/img/df_avatar.png');
define('FULL_COURSE',false);

define('APP_ID','1663061363962371');
define('APP_SECRET','dd0b6d3fb803ca2a51601145a74fd9a8');

define('CONFIG_SECURITY_SALT', "DFWBbJOLaway3Z09G3mmJpUHiH46p1SSJ4L3V2ZzY");
define('CONFIG_SERVER_BASE_URL', "https://vcr.5gmedia.vn/bigbluebutton/");

define('ROOT_PATH',''); 
define('TEM_PATH',ROOT_PATH.'templates/');
define('COM_PATH',ROOT_PATH.'components/');
define('MOD_PATH',ROOT_PATH.'modules/');
define('INC_PATH',ROOT_PATH.'includes/');
define('LAG_PATH',ROOT_PATH.'languages/');
define('EXT_PATH',ROOT_PATH.'extensions/');
define('EDI_PATH',EXT_PATH.'editor/');
define('DOC_PATH',ROOT_PATH.'documents/');
define('DAT_PATH',ROOT_PATH.'databases/');
define('IMG_PATH',ROOT_PATH.'images/');
define('MED_PATH',ROOT_PATH.'media/');
define('LIB_PATH',ROOT_PATH.'libs/');
define('JSC_PATH',ROOT_PATH.'js/');
define('LOG_PATH',ROOT_PATH.'logs/');

define('MAX_FRONTEND_ROWS',50);
define('MAX_BACKEND_ROWS',50);
define('ADMIN_LOGIN_TIMEOUT',-1);
define('URL_REWRITE','1');
define('MAX_ROWS_INDEX',40);
define('USER_TIMEOUT',10*60);
define('MEMBER_TIMEOUT',-1);
define('ACTION_TIMEOUT',3*60);
define('MEMBER_STATUS',1);
define('DAY_FREE',30);

define('KEY_AUTHEN_COOKIE','CLASSHUB_260584');

define('SMTP_SERVER','smtp.gmail.com');
define('SMTP_PORT','465');
define('SMTP_USER','hoangtucoc321@gmail.com');
define('SMTP_PASS','nsn2651984');
define('SMTP_MAIL','hoangtucoc321@gmail.com');

define('SITE_CODE','CLASSHUB_');
define('SITE_NAME','ECOHUB.ASIA');
define('SITE_TITLE','ECOHUB.ASIA');
define('SITE_DESC','');
define('SITE_KEY','');
define('SITE_IMAGE','');
define('SITE_LOGO','');
define('COM_NAME','Copyright &copy; IGF.COM.VN');
define('COM_CONTACT','');

$_FILE_TYPE=array('docx','excel','pdf');
$_MEDIA_TYPE=array('mp4','mp3');
$_IMAGE_TYPE=array('jpeg','jpg','gif','png');
$_GMEM=array('admin','studen','teach');
$_CLEVEL=array(
	'L01'=>array('code'=>'L01','name'=>'Cơ bản'),
	'L02'=>array('code'=>'L02','name'=>'Trung cấp'),
	'L03'=>array('code'=>'L03','name'=>'Cao cấp'),
);

?>
<?php ob_start();
session_start();
if(!isset($_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']) || $_SESSION[MD5($_SERVER['HTTP_HOST']).'_USERLOGIN']==false){
	die('');
}
ini_set('upload_max_filesize', '10M'); 
include_once('../../global/libs/gfconfig.php');
if(isset($_SESSION["MMEM_ID"]))
	$gid=$_SESSION["MMEM_ID"];
define("BASE_PATH","../../images/");
define("ROOT_BASE_PATH",ROOTHOST."images/");
$array_type=array('image/gif','image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');
include_once("cls.upload.php");
include_once("cls.resize.php");
include_once("function.php");
$file="";
if(!isset($_SESSION["CUR_DIR"]) || $_SESSION["CUR_DIR"]=="")
	$_SESSION["CUR_DIR"]=BASE_PATH;
if(isset($_POST["cbo_dir"]) && $_POST["cbo_dir"]!=""){
	$_SESSION["CUR_DIR"]=$_POST["cbo_dir"];
}
$cur_dir=$_SESSION["CUR_DIR"];
if(isset($_FILES["txt_video"])){
	$objmedia=new CLS_UPLOAD();
	$objmedia->setPath($cur_dir);
	$file=$objmedia->UploadFile("txt_video",$cur_dir);
}
if(isset($_GET["file"])){
	unlink($cur_dir.$_GET["file"]);
	header("Location: upload_image.php");
}
/*tao thu muc*/
if(isset($_POST["ok"]))
{
	if(!is_dir($cur_dir.$_POST["txtnewdir"])){
		mkdir($cur_dir.$_POST["txtnewdir"],0777);
	}
}
?>
<!DOCTYPE html>
<html language='vi'>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Upload media</title>
	<style type="text/css">
		table.list{
			border-left:#CCC 1px solid;
			border-top:#CCC 1px solid;

		}
		table.list td{
			border-right:#CCC 1px solid;
			border-bottom:#CCC 1px solid;
		}
		body{
			font-family: Arial, Helvetica, sans-serif;
			font-size:12px;
		}
		a{
			color:#333;
		}
		.layouts{
			width:300px;
			height: 300px;
			overflow: auto;
			display:block;
		}
		.list_file {
			width:300px;
			height:300px;
			overflow: auto;
		}
		#dsfile {
			width:100%;
			height:300px;
			overflow:auto;
		}
	</style>
	<script language="javascript">
		function right(current_str,find_str){
			var cL = current_str.length;
			var fL = find_str.length;
			var pos = current_str.lastIndexOf(find_str);
			if(pos+fL>=cL)
				return "";
			else if(pos==-1)
				return current_str;
			else
				return current_str.substring(pos+fL,cL);
		}
		function setlink(url){
			var sHTML="<img src=\""+url+"\" border=\"0\" id=\"curimg\"/>";
			var layout=document.getElementById("layout");
			layout.innerHTML= sHTML;
			var img=document.getElementById("curimg");

			if(img.offsetWidth>=300 || img.offsetHeight>=300 || img.offsetWidth<=0 || img.offsetHeight<=0 ){
				layout.className="layouts";
			}
			else{
				layout.className="";

			};
			selectFile(url);
			document.getElementById("txturl").value=url;
		}
		function showmedia(url){
			document.getElementById("VIDEO").value=url;
		}
		function insetvideo(){
			var url=document.getElementById('txturl');
			window.opener.document.frm_action.txtthumb.value=url.value;
			window.opener.focus();
			window.close();
		}
		function selectFile(url)
		{
			var arrTmp = url.split(".");
			var sFile_Extension = arrTmp[arrTmp.length-1];
			var sHTML="";
			/*Image*/
			if(sFile_Extension.toUpperCase()=="GIF" || sFile_Extension.toUpperCase()=="JPG" || sFile_Extension.toUpperCase()=="PNG" || sFile_Extension.toUpperCase()=="JPEG")
			{
				sHTML = "<img src=\"" + url + "\" >"
			}
			/*SWF*/
			else if(sFile_Extension.toUpperCase()=="SWF" ||sFile_Extension.toUpperCase()=="MOV")
			{
				sHTML = "<object height='250' width='335'"+ 
				"classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' " +
				"codebase='"+url+"'"+
				"	<param name=movie value='"+url+"'>" +
				"   <param value='true' name='allowfullscreen'>"+
				"   <param value='transparent' name='wmode'>"+
				"	<param value='1' name='loop'>"+
				"	<param name=quality value='high'>" +
				"	<embed src='"+url+"' " +
				"		width='335' " +
				"		height='250' " +
				"		quality='high' " +
				"		pluginspage='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'>" +
				"	</embed>"+
				"</object>";
			}
			/*Video*/
			else if(sFile_Extension.toUpperCase()=="WMV"||sFile_Extension.toUpperCase()=="AVI"||sFile_Extension.toUpperCase()=="MPG")
			{
				sHTML = "<embed src='"+url+"' hidden=false autostart='true' type='video/avi' loop='true' height='250' width='335'></embed>";
			}
			else if(sFile_Extension.toUpperCase()=="MP4")
			{
				sHTML = "<embed src='"+url+"' hidden=false autostart='true' loop='true' height='250' width='335'></embed>";
			}
			/*Sound*/
			else if(sFile_Extension.toUpperCase()=="WMA"||sFile_Extension.toUpperCase()=="WAV"||sFile_Extension.toUpperCase()=="MID")
			{
				sHTML = "<embed src='"+url+"' hidden=false autostart='true' type='audio/wav' loop='true' height='250' width='335'></embed>";
			}
			/*Files (Hyperlinks)*/
			else
			{	
				sHTML = "<br><br><br><br><br><br>Not Available"
			}

			document.getElementById("layout").innerHTML = sHTML;
		}
	</script>
</head>

<body onload="setlink('<?php 
	$vitualfile=ROOT_BASE_PATH.str_replace(BASE_PATH,'',$file);
	echo $vitualfile;?>')">
	<table width="700" border="1" align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td width="50%" rowspan="2" valign="top">
				<form id="form2" name="form2" method="post" action="">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td height="300" align="center">
								<div id="layout">&nbsp;</div>
							</td>
						</tr>
						<tr>
							<td align="center"><label><input type="text" name="txturl" id="txturl" style="width:95%;" /></label></td>
						</tr>
					</table>
				</form></td>
				<td style="height:30px;"><form id="frm_filter" name="frm_filter" method="post" action="" style="margin:0px; padding:0px;">
					<strong>List in</strong>
					<select name="cbo_dir" id="cbo_dir" onchange="document.frm_filter.submit();">
						<option value="<?php echo BASE_PATH;?>">images</option>
						<?php listDir(BASE_PATH,2);?>
						<script language="javascript">
							var cbo_dir=document.getElementById("cbo_dir")
							for(i=0;i<cbo_dir.length;i++)
								if(cbo_dir[i].value=='<?php echo $cur_dir; ?>')
							cbo_dir.selectedIndex=i;
						</script>
					</select>
					<label>
						<input name="txtnewdir" type="text" id="txtnewdir" size="15" />
					</label>
					<label>
						<input type="submit" name="ok" id="button3" value="Create" />
					</label>
				</form></td>
			</tr>
			<tr>
				<td valign="top" class="list_file">
					<div id="dsfile"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
						<tr>
							<td width="30" align="center"><strong>STT</strong></td>
							<td align="center"><strong>Name</strong></td>
							<td width="50" align="center"><strong>Delete</strong></td>
						</tr>
						<?php listFile($cur_dir);?>
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<form action="" method="post" enctype="multipart/form-data" name="frm_media" id="frm_media">
					<input type="file" name="txt_video" id="txt_video" />
					<input type="submit" name="button" id="button" value="Upload" />
					<input type="button" name="button2" id="button2" value="Insert" onclick="insetvideo();" />
				</form>
			</td>
		</tr>
	</table>

</body>
</html>
<?php ob_flush(); ?>
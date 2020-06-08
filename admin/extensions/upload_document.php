<?php ob_start();
session_start();
if(!isset($_SESSION[MD5($_SERVER['HTTP_HOST']).'_ISLOGIN']) || $_SESSION[MD5($_SERVER['HTTP_HOST']).'_ISLOGIN']==false){
	die('');
}
ini_set('upload_max_filesize', '10M'); //thiết lập dung lượng file tối đa
include_once('../../global/libs/gfconfig.php');//chèn file config vào
if(isset($_SESSION["MMEM_ID"]))
	$gid=$_SESSION["MMEM_ID"];
	define("BASE_PATH","../../documents/");// đường dẫn tương đối đến thư mục
	define("ROOT_BASE_PATH",ROOTHOST."documents/");// đường dẫn tuyệt đối đến thư mục
	$array_type=array('image/gif','image/jpg','image/jpeg','image/pjpeg','image/png','image/x-png');//cho phép các loại file được upload
	include_once("cls.upload.php");
	include_once("function.php");
	$file="";
	if(!isset($_SESSION["CUR_DIR"]) || $_SESSION["CUR_DIR"]=="");
		$_SESSION["CUR_DIR"]=BASE_PATH;
	// lưu đường dẫn tương đối vào biến session
	//lúc này [CUR_DIR] => ../images/icon/
	//khi có sự thay đổi chọn thư mục thì ../images/tenthumuc_duoc_chon/ rồi lưu vào biến session
	if(isset($_POST["cbo_dir"]) && $_POST["cbo_dir"]!=""){
		$_SESSION["CUR_DIR"]=$_POST["cbo_dir"];
	}
	$cur_dir=$_SESSION["CUR_DIR"];
	if(isset($_FILES["txt_video"])){
		$objmedia=new CLS_UPLOAD();
		$objmedia->setPath($cur_dir);
		// tiến hành upload file
		$file=$objmedia->UploadFile("txt_video",$cur_dir);
		$filesize=$_FILES['txt_video']['size'];
		echo "<input type='hidden' id='filesize' name='filesize' value='".$filesize."'";
	}
	else{
		echo "<input type='hidden' id='filesize' name='filesize' value=''";
	}
	// xóa file sử dụng hàm unlink()
	if(isset($_GET["file"])){
		unlink($cur_dir.$_GET["file"]);
		header("Location: upload_document.php");
	}
	//tao thu muc mới đồng thời thiết lập htaccess cho thư mục đó
	if(isset($_POST["ok"]))
	{
		if(!is_dir($cur_dir.$_POST["txtnewdir"])){
			mkdir($cur_dir.$_POST["txtnewdir"],0777);
			$htaccess="<Files ~ '\.(php|php3|php4|php5|phtml|pl|cgi|aspx|asp|xml)$'>                                                                              
			order deny,allow                                                                                                            
			deny from all                                                                                                               
		</Files>";
		$fp = fopen($cur_dir.$_POST['txtnewdir']."/".'.htaccess', 'w');
		fwrite($fp, $htaccess);
		fclose($fp);
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
			width:200px;
			height: 200px;
			overflow: auto;
			display:block;
		}
		.list_file {
			width:200px;
			height:200px;
			overflow: auto;
		}
		#dsfile {
			width:100%;
			height:200px;
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
    //var newurl = right(dir,"../../");
    //var file= right(url,"/");
    //var file= right(url,"/");
    document.getElementById("txturl").value=url;
	//document.getElementById("txturl").value=newurl+file;
}
function showmedia(url){
	document.getElementById("VIDEO").value=url;
}
function insetvideo(){
	var url=document.getElementById('txturl'); 
	var filesize=document.getElementById('filesize'); 
	//chèn link vào txtthumb ở form frm_action
	window.opener.document.frm_action.txturl.value=url.value;
	window.opener.document.frm_action.filesize.value=filesize.value;
	window.opener.focus();
	window.close();
}
// hàm selectFile(url) sẽ chèn vào thẻ div#layout chuỗi sHTML
// chuỗi sHTML hiển thị tùy đuôi file
function selectFile(url)
{
	var arrTmp = url.split(".");
	var sFile_Extension = arrTmp[arrTmp.length-1];
	var sHTML="";
	//Image
	if(sFile_Extension.toUpperCase()=="GIF" || sFile_Extension.toUpperCase()=="JPG" || sFile_Extension.toUpperCase()=="PNG" || sFile_Extension.toUpperCase()=="JPEG")
	{
		sHTML = "<img src=\"" + url + "\" >"
	}
		//SWF
		else if(sFile_Extension.toUpperCase()=="SWF" ||sFile_Extension.toUpperCase()=="MOV")
		{
			sHTML = "<object height='250' width='335'"+ 
			"classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' " +
			"codebase='"+url+"'"+
			//"   <param value='http://lasta.com.vn/player-viral.swf' name='movie'>"+
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
	//Video
	else if(sFile_Extension.toUpperCase()=="WMV"||sFile_Extension.toUpperCase()=="AVI"||sFile_Extension.toUpperCase()=="MPG")
	{
		sHTML = "<embed src='"+url+"' hidden=false autostart='true' type='video/avi' loop='true' height='250' width='335'></embed>";
		//sHTML = "<IMG DYNSRC="" SRC="filename" height='250' width='335'></embed>";
		
	}
	else if(sFile_Extension.toUpperCase()=="MP4")
	{
		sHTML = "<embed src='"+url+"' hidden=false autostart='true' loop='true' height='250' width='335'></embed>";
		//sHTML = "<embed src='"+url+"' hidden=false autostart='true' loop='true' height='250' width='335'></embed>";
	}
	//Sound
	else if(sFile_Extension.toUpperCase()=="WMA"||sFile_Extension.toUpperCase()=="WAV"||sFile_Extension.toUpperCase()=="MID")
	{
		sHTML = "<embed src='"+url+"' hidden=false autostart='true' type='audio/wav' loop='true' height='250' width='335'></embed>";
	}
	//Files (Hyperlinks)
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
	echo $vitualfile; ?>')">
	<table width="100%" border="1" align="center" cellpadding="5" cellspacing="0">
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
							<!-- txturl chứa đường dẫn ảnh khi chọn ảnh, đường dẫn này sẽ được chèn vào form khác thông qua hàm insertvideo() -->
							<td align="center">
								<label>
									<input type="text" name="txturl" id="txturl" style="width:95%;" />
								</label>
							</td>
						</tr>
					</table>
				</form></td>
				<td style="height:30px;">
					<!-- Begin form frm_filter -->
					<form id="frm_filter" name="frm_filter" method="post" action="" style="margin:0px; padding:0px;">
						<strong>List in</strong>
						<!-- khi thay đổi thư mục list in thì sẽ submit form frm_filter -->
						<select name="cbo_dir" id="cbo_dir" onchange="document.frm_filter.submit();">
							<option value="<?php echo BASE_PATH;?>">documents</option>  <!-- images là thư mục tĩnh-->
							<?php listDir(BASE_PATH,2); ?>
							<!-- duyệt thư mục và hiển thị thư mục con  -->
							<script language="javascript">
					          // sau khi submit form thì option select trở về trạng thái hiện tại => cần lệnh sau để thiết lập index select option.
							  var cbo_dir=document.getElementById("cbo_dir"); // lấy id của select box 
							  // duyệt qua tất cả phần tử của select option, nếu giá trị option bằng với giá trị biến $cur_dir 
							  // thì sẽ hiển thị option hiện tại
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
					</form>
					<!-- End form frm_filter -->
				</td>
			</tr>
			<tr>
				<td valign="top" class="list_file">
					<div id="dsfile"><table width="100%" border="0" cellspacing="0" cellpadding="3" class="list">
						<tr>
							<td width="30" align="center"><strong>STT</strong></td>
							<td align="center"><strong>Name</strong></td>
							<td width="50" align="center"><strong>Delete</strong></td>
						</tr>
						<?php listDocFile($cur_dir);?> 
						<!-- hiển thị danh sách file  -->
					</table>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<!-- form frm_media chứa file cần upload-->
				<form action="" method="post" enctype="multipart/form-data" name="frm_media" id="frm_media">
					<input type="file" name="txt_video" id="txt_video" />
					<input type="submit" name="button" id="button" value="Upload" />
					<input type="button" name="button2" id="button2" value="Insert" onclick="insetvideo();" />
				</form>
				<!-- end form frm_media -->
			</td>
		</tr>
		</table>
</body>
</html>
<?php ob_flush(); ?>
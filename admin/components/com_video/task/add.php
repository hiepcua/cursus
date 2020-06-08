<?php
defined("ISHOME") or die("Can't acess this page, please come back!");
?>
<div id="path">
    <ol class="breadcrumb">
        <li><a href="<?php echo ROOTHOST_ADMIN;?>">Admin</a></li>
        <li><a href="<?php echo ROOTHOST_ADMIN.COMS;?>">Danh sách Video</a></li>
        <li class="active">Thêm mới Video</li>
    </ol>
</div>

<div class="com_header color">
    <h1>Thêm mới Video</h1>
    <div class="pull-right">
        <form id="frm_menu" name="frm_menu" method="post" action="">
            <input type="hidden" name="txtorders" id="txtorders" />
            <input type="hidden" name="txtids" id="txtids" />
            <input type="hidden" name="txtaction" id="txtaction" />

            <ul class="list-inline">
                <li><a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu</a></li>
                <li><a class="btn btn-default"  href="<?php echo ROOTHOST_ADMIN.COMS;?>" title="Đóng"><i class="fa fa-sign-out" aria-hidden="true"></i> Đóng</a></li>
            </ul>
        </form>
    </div>
</div>
<div class="clearfix"></div>

<form id="frm_action" name="frm_action" class="form-horizontal" method="post" action=""  enctype="multipart/form-data">
    <div class="tab-content">
    	<label>Link Video<small class="cred"> (*)</small><span id="txt_name_err" class="mes-error"></span></label>
		<div class='form-group'>
			<div class="col-sm-6">
				<input name="txt_link" type="text" id="txt_link" size="45" class='form-control' value="" placeholder='Url video from youtube.com' />
				<div id="txt_link_err" class="mes-error"></div>
				<span class="msg-notic " id="msg_link"></span>
			</div>
			<div class="col-sm-3">
				<button class="btn btn-primary" id="btn-video">Check Video</button>
			</div>
			<div class="clearfix"></div>
		</div>
		<p>Lưu ý: Sau khi pase link video từ youtube, cần "Check video" để kiểm tra video trả về từ Youtube là chính xác hay không</p>

		<div class='form-group'>
			<div class="col-sm-6">
				<div class="respon" id="respon-video"></div>
				<div class="respon" id="respon-info"></div>
			</div><div class="clearfix"></div>
		</div>

		<div class="form-group">
			<div class="col-sm-6">
				<label>Tên Video</label>
				<input type="text" name="txt_name" class="form-control" id="txt_name" placeholder="">
				<div id="txt_name_err" class="mes-error"></div>
			</div>
		</div>

		<label>Ảnh đại diện</label>
		<div class='form-group'>
            <div class="col-sm-6">
                <input name="txtthumb" type="text" id="file-thumb" size="45" class='form-control' value="" placeholder='' />
            </div>
            <div class="col-sm-3">
                <a class="btn btn-primary" href="#" onclick="OpenPopup('<?php echo ROOTHOST_ADMIN;?>extensions/upload_image.php');"><b style="margin-top: 15px">Chọn</b></a>
            </div>
			<div id="txt_thumb_err" class="mes-error"></div>
            <div class="clearfix"></div>
        </div>

        <div class="form-group">
        	<div class="col-xs-12">
        		<label>Tóm tắt</label>
        		<textarea name="txt_intro" class="form-control" id="txt_intro" rows="3"></textarea>
        	</div>
        </div>

        <div class="form-group">
        	<div class="col-xs-12">
        		<label>Nội dung</label>
        		<textarea name="txt_content" class="form-control" id="txt_content"></textarea>
        	</div>
        </div>
	</div>
    <input type="submit" name="cmdsave" id="cmdsave" value="Submit" style="display:none;" />
    <div class="text-center toolbar">
        <div style="height: 20px;"></div>
        <a class="save btn btn-success" href="#" onclick="dosubmitAction('frm_action','save');" title="Lưu thông tin"><i class="fa fa-floppy-o" aria-hidden="true"></i> Lưu thông tin</a>
    </div>
</form>

<script language="javascript">
	function checkinput(){
        if($("#txt_name").val()==""){
        	$("#txt_name_err").fadeTo(200,0.1,function(){
        		$(this).html('Vui lòng nhập tên video').fadeTo(900,1);
        	});
        	$("#txt_name").focus();
        	return false;
        }
        if($("#txt_link").val()==""){
        	$("#txt_link_err").fadeTo(200,0.1,function(){
        		$(this).html('Vui lòng nhập Url video').fadeTo(900,1);
        	});
        	$("#txt_link").focus();
        	return false;
        }
        return true;
    }

    $('#btn-video').click(function(){
        var url=$('#txt_link').val();
        var formatStrUrlYoutube = url.toLowerCase().indexOf("youtube");
        if (url!="" && formatStrUrlYoutube >= 0){
            getVideo(url);
        } else {
            mes='Vui lòng nhập đường dẫn chính xác';
            $('#msg_link').html(mes);
            return false;
        }
        return false;
    })
	function getVideo(url) {
		var formatStrUrlYoutube = url.toLowerCase().indexOf("youtube");
        var videoId = url.substring(url.indexOf("?v=") + 3);
        $.post('<?php echo ROOTHOST;?>ajaxs/get_info_video.php',{videoId, url},function(response_data){
			//console.log(response_data);	
			var json = JSON.parse(response_data);		
			var info = "<div class='name'>Tên Video: "+json.title+"</div>";
			info += "<div class='img_src'>Ảnh Video: "+json.thumbnail_url+"</div>";
			$('#respon-video').html(json.html);
            $('#respon-video').toggleClass('show');
			$('#respon-info').html(info);
            $('#respon-info').toggleClass('show');
            $('#msg_link').html('');
            $('#txt_link_err').html('');
        });
	}
</script>
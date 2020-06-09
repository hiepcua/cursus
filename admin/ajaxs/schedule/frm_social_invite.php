<?php
session_start();
define('incl_path','../../global/libs/');
define('libs_path','../../libs/');
require_once(incl_path.'gfconfig.php');
require_once(incl_path.'gfinit.php');
require_once(incl_path.'gffunc.php');
require_once(incl_path.'gffunc_member.php');
require_once(libs_path.'cls.mysql.php');
if(isLogin()){
	$invite_token = antiData($_POST['invite_token']);
	$share_url = ROOTHOST.'guest/'.$invite_token;

	function telegramForwardButton($url, $text = '') {
		$share_url = 'https://t.me/share/url?url='.rawurlencode($url).'&text='.rawurlencode($text);
		return "<a href=\"{$share_url}\" target=\"_blank\"><img class='card-img-top' src='".ROOTHOST."global/img/icon-telegram.png'
		alt='Telegram'></a>";
	}
	?>
	<style type="text/css">
		#bar {
			display: inline-block;
			width: 100%;
			overflow: hidden;
			border: 1px solid #ccc;
			background-color: #fafafa;
		}
		#share_url {
			width: calc(100% - 120px);
			float: left;
			background-color: #fafafa;
			border: 0;
			padding-right: 50px;
		}
		.btn_copy_share_link {
			width: 100px;
			color: #007bff;
		}
		.card.mb-2{padding: 3px;}
		.slide_social_icon .item{
			width: 20%;
		}
		.share_zalo{
			cursor: pointer;
		}
	</style>
	<p></p>
	<h3 class='text-center'>Invite</h3>
	<div class='mess' style='color:#f00;'></div>
	<div class='form-group slide_social_icon'>
		<div class="row my-4">
			<div class="col-md-2 clearfix d-md-block item">
				<div class="card mb-2">
					<img class="card-img-top share_facebook" src="<?php echo ROOTHOST;?>global/img/icon-facebook.png"
					alt="Facebook" data-share-url="<?php echo ROOTHOST;?>guest?meet_id=<?php echo $invite_token; ?>">

					<!-- <a href="javascript:fbShare('http://publicise.esy.es', 'Fb Share', 'Facebook share popup', 'http://goo.gl/dS52U')">Share</a> -->
				</div>
			</div>

			<div class="col-md-2 clearfix d-md-block item">
				<div class="card mb-2">
					<img class="card-img-top share_zalo" src="<?php echo ROOTHOST;?>global/img/icon-zalo.png" alt="Zalo">
					<div class="zalo-share-button" data-href="" data-oaid="579745863508352884" data-layout="2" data-color="blue" data-customize=true></div>
				</div>
			</div>

			<div class="col-md-2 clearfix d-md-block item">
				<div class="card mb-2">
					<?php echo telegramForwardButton($share_url, "Mời tham gia classhub"); ?>
				</div>
			</div>

			<div class="col-md-2 clearfix d-md-block item">
				<div class="card mb-2">
					<img class="card-img-top" src="<?php echo ROOTHOST;?>global/img/icon-gmail.png"
					alt="Gmail" onclick="send_mail()">
				</div>
			</div>
		</div>
	</div>
	<div class='form-group' id="bar">
		<input class='form-control' id='share_url' value="<?php echo ROOTHOST;?>guest/<?php echo $invite_token; ?>" readonly/>
		<button class="btn btn_copy_share_link" onclick="copy_share_url()">Copy link</button>
	</div>
	<script>
		$('.share_facebook').click(function(){
			var url = '<?php echo ROOTHOST;?>guest?meet_id=<?php echo $invite_token; ?>';
			var title = 'Tham gia họp online';
			var descr = 'abc';
			var image = 'https://media-cdn.tripadvisor.com/media/photo-s/17/73/e4/0c/meeting-room.jpg';
			fbShare(url, title, descr, image);
		});
		$('.share_zalo').click(function(){
			$('.zalo-share-button').click();
		});

		function share_telegram(data){
			var url = '<?php echo $share_url; ?>';
			var text = 'Mời tham gia đăng nhập ClassHub.';
			teleShare(url, text);
		}

		function copy_share_url(){
			/* Get the text field */
			var copyText = document.getElementById("share_url");

			/* Select the text field */
			copyText.select();
			copyText.setSelectionRange(0, 99999);

			/* Copy the text inside the text field */
			document.execCommand("copy");

			/* Alert the copied text */
			alert("Copied this link to the clipboard");
		};
		
		function send_mail(){
			var subject = 'ClassHub mời theo dõi cuộc họp!';
			var msgbody = '<divXin chào.</div>';
			msgbody+='<div>Chúng tôi xin trân trọng mời bạn tham gia cuộc họp cùng chúng tôi</div>';
			msgbody+='<div>Để tham gia cuộc họp hãy bấm vào đường link sau đây:</div>';
			msgbody+='<?php echo ROOTHOST;?>guest?meet_id=<?php echo $invite_token; ?>';
			var url = 'https://mail.google.com/mail/?view=cm&fs=1&tf=1&to=&su='+ subject +'&body='+msgbody+'&ui=2&tf=1&pli=1';

			window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
		}

	</script>
<?php }else{
	echo "<h4>Please <a href='".ROOTHOST."'>login</a> to continue!</h4>";
}
?>
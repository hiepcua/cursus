<?php
global $_DATA;
$alphabet=array('A','B','C','D','E','F','J','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
?>
<div class='lib-banner text-center'>
	<div class='inner padding-75'>
		<h1 class='title'>LIBRARY TUTORIAL</h1>
		<h4>100 môn học và 50,000 bài hướng dẫn</h4>
		<div class="library_search">
			<div class="col-md-3"></div>
			<div class="col-md-5">
				<input type="text" list="libraries_name" name="txt_search" id="txt_search" placeholder="Nhập tên thư viện" class="form-control">
				<datalist id="libraries_name">
					<?php for($j=0;$j<count($_DATA);$j++){?>
					<option value="<?php echo $_DATA[$j]['title'];?>">
					<?php } ?>
				</datalist>
			</div>
			<div class="col-md-1"><div class='row'><button class="btn btn-block btn-primary">TÌM KIẾM</button></div></div>
			<div class="col-md-3"></div>
		</div>
	</div>
</div>
<div class='col-md-12'>
	<div class='box box_search'>
		<div class="clearfix"><br></div>
		<div class="row library_alphabet">
			<?php 
			$str_alphabet='';
			for($i=0;$i<count($alphabet);$i++)
				$str_alphabet.='<a href="#'.$alphabet[$i].'_alphabet">'.$alphabet[$i].'</a>';
			echo $str_alphabet; ?>
		</div>
	</div>
	<div class="clearfix"></div>
	<div id='lib_wrapper' class='box'>
		<div class="alphabet_quick"><?php echo $str_alphabet;?></div>
		<?php for($i=0;$i<count($alphabet);$i++){?>
		<div class="row">
			<div class='library_title'><a name="<?php echo $alphabet[$i];?>_alphabet">
				<strong><?php echo $alphabet[$i];?></strong></a></div>
			<div class='library_list'>
				<?php
				for($j=0;$j<count($_DATA);$j++){
					if(strtolower($alphabet[$i])==strtolower(substr($_DATA[$j]['title'],0,1))){
						$img = ROOTHOST."images/logo/no-logo.png";
						if($_DATA[$j]['thumb']!='') $img = ROOTHOST.$_DATA[$j]['thumb'];
						echo "<a href='".ROOTHOST.$_DATA[$j]['code']."-tutorial' name='".$_DATA[$j]['title']."'>
						<img src='$img'/>
						<span class='lib_item'>".$_DATA[$j]['title']."</span></a>";
					}
				} 
				?>
			</div>
		</div>
		<?php }?>
	</div>
</div>
<script>

$(function() {
	// scroll
	var h = $('.main_banner').height()+$('.box_search').height()+50; 
	$(window).scroll(function () {
		if($(this).scrollTop() > h) 
			$('#lib_wrapper .alphabet_quick').css({"display":"block"});
		else  $('#lib_wrapper .alphabet_quick').css({"display":"none"});
	})
	//# function hash tag
	$('a[href*="#"]:not([href="#"])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		  var target = $(this.hash);
		  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		  if (target.length) {
			$('html, body').animate({
			  scrollTop: target.offset().top-80
			}, 1000);
			return false;
		  }
		} 
	});
	$("#txt_search").keydown(function (e) {
		if (e.keyCode == 13) {
			LibFocus();	
		}
	})
	$('.library_search button').click(function() {
		LibFocus();		
	})
});
function LibFocus() {
	var txt = $('#txt_search').val();
	var target = $("a[name='"+txt+"']"); 
	if (target.length) {
		$('html, body').animate({
		  scrollTop: target.offset().top-80
		}, 1000);
		$('#lib_wrapper .library_list a').css({"border":"1px solid #eee"});
		target.css({"border":"1px solid #bbb"});
		return false;
	}
}
</script>
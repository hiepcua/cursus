<div id="notification" style="display: none;"></div>
<div class="modal fade" id='myModal' role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Sing in</h4>
			</div>
			<div class="modal-body" id="data-frm">
				<p>One fine body&hellip;</p>
			</div>
		</div>
	</div>
</div>

<!-- Main Footer -->
<footer class="main-footer" style="display: none;">
	<strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
	All rights reserved.
	<div class="float-right d-none d-sm-inline-block">
		<b>Version</b> 3.0.1
	</div>
</footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<!-- <script src="plugins/jquery/jquery.min.js"></script> -->
<!-- Bootstrap -->
<script src="<?php echo ROOTHOST_ADMIN;?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?php echo ROOTHOST_ADMIN;?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo ROOTHOST_ADMIN;?>dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo ROOTHOST_ADMIN;?>dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?php echo ROOTHOST_ADMIN;?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?php echo ROOTHOST_ADMIN;?>plugins/raphael/raphael.min.js"></script>
<script src="<?php echo ROOTHOST_ADMIN;?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?php echo ROOTHOST_ADMIN;?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo ROOTHOST_ADMIN;?>plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="<?php echo ROOTHOST_ADMIN;?>dist/js/pages/dashboard2.js"></script>
<script type="text/javascript">
	var _gl_com = '<?php echo $GLOBALS['COM']; ?>';
	var _gl_link = '<?php echo $GLOBALS['LINK']; ?>';

	$('#sidebar-menu .nav-link').each(function(){
		var com = $(this).attr('data-com');
		var link = $(this).attr('data-link');
		if(com === _gl_com){
			$(this).addClass(' active');
		}
		if(link === _gl_link){
			$(this).addClass(' active');
		}
    });

	window.setTimeout(function() {
		$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 2500);

	function showMess(mess,type){
		var _title='';var _html="";
		switch(type){
			case 'error': 
			_title="<span>Lỗi</span>"; 
			_html="<p class='alert alert-danger'>"+mess+"</p>";
			break;
			case 'alert': 
			_title="<span>Cảnh báo</span>"; 
			_html="<p class='alert alert-warning'>"+mess+"</p>";
			break;
			default:  
			_title="<span>Thông báo</span>"; 
			_html="<p class='alert alert-info'>"+mess+"</p>";	
			break;
		}
		$('#myModal .modal-dialog').addClass('modal-sm');
		$('#myModal .modal-header .modal-title').html(_title);
		$('#myModal .modal-body').html(_html);
		$('#myModal').modal('show');
	}
	
	function generator_sitemap(){
        $.ajax({
            type: "GET",
            url: "<?php echo ROOTHOST.'sitemap-generator.php';?>" ,
            data: {},
            success : function(res) { 
                showMess('Xuất sitemap thành công!');
            }
        });
    }

    /* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
	var prevScrollpos = window.pageYOffset;
	window.onscroll = function() {
		var currentScrollPos = window.pageYOffset;
		if (prevScrollpos > currentScrollPos) {
			document.getElementById("body").classList.add("layout-navbar-fixed");
    		// document.getElementById("navbar").style.top = "0";
    	} else {
    		document.getElementById("body").classList.remove("layout-navbar-fixed");
    		// document.getElementById("navbar").style.top = "-50px";
    	}
    	prevScrollpos = currentScrollPos;
    }
</script>
</body>
</html>

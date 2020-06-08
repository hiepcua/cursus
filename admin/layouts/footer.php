
<footer class="main-footer">
	<strong>Copyright &copy; 2019-<?php echo date('Y');?> <a href="#"><?php echo SITE_NAME;?></a>.</strong>
	All rights reserved.
	<div class="float-right d-none d-sm-inline-block">
		<b>Version</b> 1.0-pre
	</div>
</footer>
<div class="modal fade" id='popup_modal' role="dialog">
	<div class="modal-dialog modal-border ">
		<div class="modal-content">
			<div class="modal-body" id="data-frm">
				<p>One fine body&hellip;</p>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">

	window.setTimeout(function() {
		$(".alert").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove(); 
		});
	}, 2500);
	/* When the user scrolls down, hide the navbar. When the user scrolls up, show the navbar */
	var prevScrollpos = window.pageYOffset;
	window.onscroll = function() {
		var currentScrollPos = window.pageYOffset;
		if (prevScrollpos > currentScrollPos) {
			document.getElementById("body").classList.add("layout-navbar-fixed");
		} else {
			document.getElementById("body").classList.remove("layout-navbar-fixed");
		}
		prevScrollpos = currentScrollPos;
	}
</script>
<!-- Bootstrap 4 -->
<script src="<?php echo ROOTHOST;?>global/plugins/moment/moment.min.js"></script>
<script src="<?php echo ROOTHOST;?>global/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo ROOTHOST;?>global/js/bootstrap-timepicker.js"></script>
<script src="<?php echo ROOTHOST;?>global/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo ROOTHOST;?>global/plugins/select2/js/select2.full.min.js"></script>
<script src="<?php echo ROOTHOST;?>global/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo ROOTHOST;?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="<?php echo ROOTHOST;?>global/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="<?php echo ROOTHOST;?>global/plugins/summernote/summernote-bs4.min.js"></script>
<script src="<?php echo ROOTHOST;?>global/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
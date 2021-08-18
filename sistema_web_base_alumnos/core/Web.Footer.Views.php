		<!--Otros archivos javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/screenfull/screenfull.js"></script> 
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-ui-1.10.3.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/main.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.js"></script>
		<script>
			//ocultar el loader
			$(document).ready(function() {
				setTimeout(function(){
					$('body').addClass('loaded');
				}, 1000);
			});
			//ajustar tamaño de todos los textarea
			autosize(document.querySelectorAll('textarea'));
		</script>
	</body>
</html>


					</div>
				</div>
			</div> 
		</div>
		<footer id="footer">
			<p><?php echo ano_actual();?> &copy; <?php echo DB_EMPRESA_NAME ?> Todos los derechos reservados.</p>
		</footer>
		
		<!-- Animacion carga pagina -->
		<script>
			//ocultar el loader
			$(document).ready(function() {
				setTimeout(function(){
					$('body').addClass('loaded');
				}, 1000);
			});
			//ajustar tamaño de todos los textarea
			autosize(document.querySelectorAll('textarea'));
			//se toma raiz
			var domain_val = "<?php echo DB_SITE_REPO ?>";
		</script>
				
		<!--Otros archivos javascript -->
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/bootstrap3/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/lib/screenfull/screenfull.js"></script> 
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/jquery-ui-1.10.3.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIB_assets/js/main.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/prism/prism.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/country_picker/js/countrypicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
		<script type="text/javascript" src="<?php echo DB_SITE_REPO ?>/LIBS_js/bootstrap_colorpicker/dist/js/bootstrap-colorpicker-plus.min.js"></script>
		
		<?php
		/******************************************************************************************************/
		//cuadro mensajes
		widget_avgrund();
		//tooltip
		widget_tooltipster();
		/******************************************************************************************************/
		/*                                                                                                    */
		/*                                              CIERRE DE LA BASE                                     */
		/*                                                                                                    */
		/******************************************************************************************************/
		mysqli_close($dbConn);

		?>
	</body>
</html>

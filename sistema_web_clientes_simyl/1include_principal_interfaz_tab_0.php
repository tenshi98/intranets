<?php
					
					
/**************************************************************************/
echo '
<div class="tab-pane fade active in" id="Menu_tab_0">

	<div class="col-sm-12 admin-grid">';
			
			
			
							
			/*************************************************************/
			//Panel de notificaciones
			echo '
			<div class="sort-disable">
				
				<div class="panel-heading">
					<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;">Bienvenido '.$_SESSION['usuario']['basic_data']['Nombre'].'</span>
				</div>
								
				<div class="panel-body mnw700 of-a">
					<div class="row">';
						/*************************************************************/
						//Lado izquierdo
						echo '<div class="col-sm-9">';
							/******************************************************/
							//Widget Sociales
							if(isset($_SESSION['usuario']['basic_data']['Social_idUso'])&&$_SESSION['usuario']['basic_data']['Social_idUso']==1){
								echo widget_Social($_SESSION['usuario']['basic_data']['Social_facebook'],
													$_SESSION['usuario']['basic_data']['Social_twitter'],
													$_SESSION['usuario']['basic_data']['Social_instagram'],
													$_SESSION['usuario']['basic_data']['Social_linkedin'],
													$_SESSION['usuario']['basic_data']['Social_rss'],
													$_SESSION['usuario']['basic_data']['Social_youtube'],
													$_SESSION['usuario']['basic_data']['Social_tumblr']
													);
								
							}
						echo '</div>';
						/*************************************************************/
						//Lado Derecho
						echo '<div class="col-sm-3">';
							echo '<div class="row">';
								
								/*************************************************************/
								//meteo
								if(isset($_SESSION['usuario']['basic_data']['Pronostico'])&&$_SESSION['usuario']['basic_data']['Pronostico']!=''){		
									echo '
									<a class="weatherwidget-io" href="'.$_SESSION['usuario']['basic_data']['Pronostico'].'" data-label_1="'.$_SESSION['usuario']['basic_data']['Region'].'" data-label_2="Pronostico" data-theme="pure" >'.$_SESSION['usuario']['basic_data']['Region'].'</a>
									<script>
									!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\'https://weatherwidget.io/js/widget.min.js\';fjs.parentNode.insertBefore(js,fjs);}}(document,\'script\',\'weatherwidget-io-js\');
									</script>
									';
								}
								/*************************************************************/
								//Sismos
								echo '<div class="clearfix" ></div>';	
								echo widget_sismologia();
									
								
									
							echo '</div>';
						echo '</div>';
						
						
					
						
						
						
						
						
						
						


						
					/*************************************************************/
					echo '
					</div>
				</div>
			</div>
			
			
		</div>
	</div>
					
';

?>

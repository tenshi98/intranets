<?php
/**************************************************************************/
//porcentaje de completado del perfil del usuario
$porc_llenado     = 0;
$porc_por_llenar  = 19;

//verifico
if($_SESSION['usuario']['basic_data']['idCliente']!=''&&$_SESSION['usuario']['basic_data']['idCliente']!=0){              $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['password']!=''&&$_SESSION['usuario']['basic_data']['password']!=0){                $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['Nombre']!=''&&$_SESSION['usuario']['basic_data']['Nombre']!=0){                    $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['Rut']!=''&&$_SESSION['usuario']['basic_data']['Rut']!=0){                          $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['idEstado']!=''&&$_SESSION['usuario']['basic_data']['idEstado']!=0){                $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['RazonSocial']!=''&&$_SESSION['usuario']['basic_data']['RazonSocial']!=0){          $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['Config_idTheme']!=''&&$_SESSION['usuario']['basic_data']['Config_idTheme']!=0){    $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['Config_imgLogo']!=''&&$_SESSION['usuario']['basic_data']['Config_imgLogo']!=0){    $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['Config_IDGoogle']!=''&&$_SESSION['usuario']['basic_data']['Config_IDGoogle']!=0){  $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['idNuevo']!=''&&$_SESSION['usuario']['basic_data']['idNuevo']!=0){                  $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['Direccion_img']!=''&&$_SESSION['usuario']['basic_data']['Direccion_img']!=0){      $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['idSistema']!=''&&$_SESSION['usuario']['basic_data']['idSistema']!=0){              $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['GeoLatitud']!=''&&$_SESSION['usuario']['basic_data']['GeoLatitud']!=0){            $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['GeoLongitud']!=''&&$_SESSION['usuario']['basic_data']['GeoLongitud']!=0){          $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['TotalCamaras']!=''&&$_SESSION['usuario']['basic_data']['TotalCamaras']!=0){        $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['TotalEventos']!=''&&$_SESSION['usuario']['basic_data']['TotalEventos']!=0){        $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['TotalPeligros']!=''&&$_SESSION['usuario']['basic_data']['TotalPeligros']!=0){      $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['TotalNegocios']!=''&&$_SESSION['usuario']['basic_data']['TotalNegocios']!=0){      $porc_llenado++;}
if($_SESSION['usuario']['basic_data']['TotalOfertas']!=''&&$_SESSION['usuario']['basic_data']['TotalOfertas']!=0){        $porc_llenado++;}

$porc_completado = cantidades(($porc_llenado / $porc_por_llenar)*100, 0);						
					
/**************************************************************************/
echo '
<div class="tab-pane fade active in" id="Menu_tab_0">

	<div class="col-sm-12 admin-grid">';
			
			/*************************************************************/
			//Notificacion
			echo '<div class="col-xs-12" style="margin-top:15px;">';
				$Alert_Text  = 'Esta plataforma es gratuita y depende unicamente de las donaciones';
				$Alert_Text .= '<a href="view_ayuda.php" title="Ver informacion" class="iframe btn btn-primary btn-sm pull-right margin_width" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Ver como ayudar</a>';
				alert_post_data(2,1,1, $Alert_Text);
			echo '</div>';
			echo '<div class="clearfix" ></div>';
			/*************************************************************/
			//Infracciones
			if($_SESSION['infracciones']){
				echo '
				<div class="">
					<div class="col-sm-12">
						<h5 style="color: #666;font-weight: 600 !important;">Infracciones
							<small class="pull-right fw600 text-primary"></small>
						</h5>
								
						<div class="box">				
							<table class="table mbn covertable">
								<tbody>';
									foreach($_SESSION['infracciones'] as $actual){
										echo '
										<tr>
											<td class="text-muted" style="white-space: normal;">
												<a rel="noopener noreferrer" href="#"><i class="fa fa-exclamation-circle color-blue" aria-hidden="true"></i> '.$actual['Descripcion'].'</a>
											</td>
											<td class="text-right color-red" style="font-weight: 700;">'.fecha_estandar($actual['Fecha']).'</td>
										</tr>';
									}
									echo '
								</tbody>
							</table>
						</div>
					</div>
				</div>';
				echo '<div class="clearfix" ></div>';
			}
			
							
			/*************************************************************/
			//Panel de notificaciones
			echo '
			<div class="sort-disable">
				
				<div class="panel-heading">
					<span class="panel-title pull-left"  style="color: #666;font-weight: 700 !important;">Bienvenido '.$_SESSION['usuario']['basic_data']['Nombre'].'</span>
				</div>
								
				<div class="panel-body mnw700 of-a">
					<div class="row">';
						/**********************************************************************************/
						/**********************************************************************************/
						//Lado izquierdo
						echo '<div class="col-sm-9">';
							echo '<div class="row">';
								/*************************************************************/
								//Notificaciones
								echo '
									<div class="col-sm-6">
										<h5 style="color: #666;font-weight: 600 !important;">Notificaciones
											<small class="pull-right fw600 text-primary"></small>
										</h5>
														
										<table class="table mbn covertable">
											<tbody>';
												/*************************************/
												echo '
												<tr>
													<td class="text-muted">
														<a target="_blank" rel="noopener noreferrer" href="principal_datos.php"><i class="fa fa-user-o color-gray" aria-hidden="true"></i> % Completado del perfil</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$porc_completado.'%</td>
												</tr>';
												/*************************************/
												echo '
												<tr>
													<td class="text-muted">
														<a target="_blank" rel="noopener noreferrer" href="principal_camaras.php?pagina=1"><i class="fa fa-video-camera color-blue" aria-hidden="true"></i> Mis Grupos de Camaras</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['TotalCamaras'].'</td>
												</tr>';
												/*************************************/
												echo '
												<tr>
													<td class="text-muted">
														<a target="_blank" rel="noopener noreferrer" href="principal_eventos.php?pagina=1"><i class="fa fa-flag color-green" aria-hidden="true"></i> Mis Eventos</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['TotalEventos'].'</td>
												</tr>';
												/*************************************/
												echo '
												<tr>
													<td class="text-muted">
														<a target="_blank" rel="noopener noreferrer" href="principal_peligros.php?pagina=1" ><i class="fa fa-ban color-yellow" aria-hidden="true"></i> Mis Zonas Peligrosas</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['TotalPeligros'].'</td>
												</tr>';
												/*************************************/
												/*echo '
												<tr>
													<td class="text-muted">
														<a target="_blank" rel="noopener noreferrer" href="#" ><i class="fa fa-database color-red" aria-hidden="true"></i> Mis Negocios</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['TotalNegocios'].'</td>
												</tr>';
												/*************************************/
												/*echo '
												<tr>
													<td class="text-muted">
														<a target="_blank" rel="noopener noreferrer" href="#"><i class="fa fa-database color-blue" aria-hidden="true"></i> Mis Ofertas</a>
													</td>
													<td class="text-right color-red" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['TotalOfertas'].'</td>
												</tr>';
												
												/*************************************/
												echo '
											</tbody>
										</table>
										
										<h5 style="color: #666;font-weight: 600 !important;">Sitios recomendados
											<small class="pull-right fw600 text-primary"></small>
										</h5>
															
										<table class="table mbn covertable">
											<tbody>';
												/*************************************/
												//cuento las sitios
												$ncount = 0;
												if($_SESSION['sitios']){
													foreach($_SESSION['sitios'] as $sitio){
														$ncount++;
													}	
													//verifico si hay sitios
													if($ncount!=0){
														foreach($_SESSION['sitios'] as $sitio){
															echo '
															<tr>
																<td class="text-muted">
																	<a target="_blank" rel="noopener noreferrer" href="'.$sitio['Direccion'].'"><i class="fa fa-link color-blue" aria-hidden="true"></i> '.$sitio['Nombre'].'</a>
																</td>
															</tr>';
														}	
													//si no hay sitios
													}else{
														echo '
														<tr>
															<td class="text-muted">
																<a href="#"><i class="fa fa-link color-blue" aria-hidden="true"></i> No hay sitios de momento</a>
															</td>
														</tr>
														';
													}
												//si no hay sitios
												}else{
													echo '
													<tr>
														<td class="text-muted">
															<a href="#"><i class="fa fa-link color-blue" aria-hidden="true"></i> No hay sitios de momento</a>
														</td>
													</tr>
													';
												}
												/*************************************/
												echo '
											</tbody>
										</table>
									</div>';
									
									/*************************************************************/
									/*************************************************************/
									//Numeros Telefonicos
									echo '
									<div class="col-sm-6">
										
										<h5 style="color: #666;font-weight: 600 !important;">Mapa
											<small class="pull-right fw600 text-primary"></small>
										</h5>
															
										<table class="table mbn covertable">
											<tbody>';
												/*************************************/
												echo '
												<tr>
													<td class="text-muted word_break">
														<a href="#"><i class="fa fa-cog color-blue" aria-hidden="true"></i> Servicios Cercanos</a>
													</td>
													<td class="text-right color-red word_break" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['total_servicios'].'</td>
												</tr>';
												echo '
												<tr>
													<td class="text-muted word_break">
														<a href="#"><i class="fa fa-user color-blue" aria-hidden="true"></i> Vecinos Cercanos</a>
													</td>
													<td class="text-right color-red word_break" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['total_vecinos'].'</td>
												</tr>';
												echo '
												<tr>
													<td class="text-muted word_break">
														<a href="#"><i class="fa fa-video-camera color-blue" aria-hidden="true"></i> Camaras Habilitadas</a>
													</td>
													<td class="text-right color-red word_break" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['total_camaras'].'</td>
												</tr>';
												echo '
												<tr>
													<td class="text-muted word_break">
														<a href="#"><i class="fa fa-flag color-blue" aria-hidden="true"></i> Eventos Ocurridos en la semana</a>
													</td>
													<td class="text-right color-red word_break" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['total_eventos'].'</td>
												</tr>';
												echo '
												<tr>
													<td class="text-muted word_break">
														<a href="#"><i class="fa fa-ban color-blue" aria-hidden="true"></i> Peligros Cerca</a>
													</td>
													<td class="text-right color-red word_break" style="font-weight: 700;">'.$_SESSION['usuario']['basic_data']['total_peligros'].'</td>
												</tr>';
												
												/*************************************/
												echo '
											</tbody>
										</table>
										
										<h5 style="color: #666;font-weight: 600 !important;">Numeros Telefonicos
											<small class="pull-right fw600 text-primary"></small>
										</h5>
														
										<table class="table mbn covertable">
											<tbody>';
												/*************************************/
												//cuento las servicios
												$ncount = 0;
												if($_SESSION['servicios']){
													foreach ($_SESSION['servicios'] as $key => $servicio){ 
														$ncount++;
													}
													//verifico si hay servicios
													if($ncount!=0){
														foreach ($_SESSION['servicios'] as $key => $servicio){ 
															switch ($servicio['idTipo']) {
																case 1: $s_icon = '<span style="color:#F14D0B;"><i class="fa fa-ambulance" aria-hidden="true"></i></span>';         break;//Hospital
																case 2: $s_icon = '<span style="color:#BC260F;"><i class="fa fa-fire-extinguisher" aria-hidden="true"></i></span>'; break;//Bomberos
																case 3: $s_icon = '<span style="color:#518826;"><i class="fa fa-gavel" aria-hidden="true"></i></span>';             break;//Carabineros
															}
															//numero telefonico
															$numero_tel = '';
															if(isset($servicio['Fono1'])&&$servicio['Fono1']!=''){                   $numero_tel .= $servicio['Fono1'];}
															if(isset($servicio['Fono2'])&&$servicio['Fono2']!=''&&$numero_tel!=''){  $numero_tel .= ' - '.$servicio['Fono2'];}else{$numero_tel .= $servicio['Fono2'];}
															
															echo '
															<tr>
																<td class="text-muted word_break">
																	<a href="#">'.$s_icon.' '.$servicio['Nombre'].'</a>
																</td>
																<td class="text-right color-red word_break" style="font-weight: 700;">'.$numero_tel.'</td>
															</tr>';
														}	
													//si no hay servicios
													}else{
														echo '
														<tr>
															<td class="text-muted" style="white-space: normal;" colspan="2">
																<a href="#"><i class="fa fa-bars color-blue" aria-hidden="true"></i> No hay servicios cercanos de momento</a>
															</td>
														</tr>
														';
													}
												//si no hay servicios
												}else{
													echo '
													<tr>
														<td class="text-muted" style="white-space: normal;" colspan="2">
															<a href="#"><i class="fa fa-bars color-blue" aria-hidden="true"></i> No hay servicios cercanos de momento</a>
														</td>
													</tr>
													';
												}
												/*************************************/
												echo '
											</tbody>
										</table>
										
										
									</div>';
									/*************************************************************/
									//Sitios
									echo '<div class="clearfix" ></div>';
									echo '
									<div class="col-sm-6">
										
									</div>';
									/*************************************************************/
									//Actualizaciones
									echo '<div class="clearfix" ></div>';
									echo '
									<div class="col-sm-12">
										<h5 style="color: #666;font-weight: 600 !important;">Actualizaciones
											<small class="pull-right fw600 text-primary"></small>
										</h5>
										
										<div class="box">				
											<table class="table mbn covertable">
												<tbody>';
													/*************************************/
													//cuento las actualizaciones
													$ncount = 0;
													foreach($_SESSION['actualizaciones'] as $actual){
														$ncount++;
													}
													//verifico si hay actualizaciones
													if($ncount!=0){
														foreach($_SESSION['actualizaciones'] as $actual){
															echo '
															<tr>
																<td class="text-muted" style="white-space: normal;">
																	<a rel="noopener noreferrer" href="#"><i class="fa fa-bars color-blue" aria-hidden="true"></i> '.$actual['Descripcion'].'</a>
																</td>
																<td class="text-right color-red" style="font-weight: 700;">'.fecha_estandar($actual['Fecha']).'</td>
															</tr>
															';
														}
													//si no hay actualizaciones
													}else{
														echo '
														<tr>
															<td class="text-muted" style="white-space: normal;">
																<a href="#"><i class="fa fa-bars color-blue" aria-hidden="true"></i> No hay actualizaciones de momento</a>
															</td>
															<td class="text-right color-red" style="font-weight: 700;">'.fecha_actual().'</td>
														</tr>
														';
													}
													/*************************************/
													echo '
												</tbody>
											</table>
										</div>
									</div>';
							
							echo '</div>';
						echo '</div>';
						/**********************************************************************************/
						/**********************************************************************************/
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
								//Widget de la radio
								echo widget_radio_player();
								
									
							echo '</div>';
						echo '</div>';
						
						
						
						
						/**********************************************************************************/
						/**********************************************************************************/
						//Lado inferior
						echo '<div class="col-sm-12">';
							echo '<div class="row">';
								
								/*************************************************************/
								//Noticias
								echo '<div class="col-sm-5">';
									echo '<div class="box">';
										echo '<header>';
											echo '<div class="icons"><i class="fa fa-newspaper-o" aria-hidden="true"></i></div><h5>Últimas noticias</h5>';
										echo '</header>';
										echo '<div class="">';
											echo widget_feed('https://www.elmostrador.cl/destacado/feed/', 10, 500, 'true', 'true');
										echo '</div> ';
									echo '</div>';
								echo '</div>';
								/*************************************************************/
								//Sismos
								echo '<div class="col-sm-7">';
								echo widget_sismologia();
								echo '</div>';
								/*************************************************************/
								//Feriados
								echo '<div class="clearfix" ></div>';
								echo '<div class="col-sm-12">';
								echo widget_feriados();
								echo '</div>';
								/*************************************************************/	
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

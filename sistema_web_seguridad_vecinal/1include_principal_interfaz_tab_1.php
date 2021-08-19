<?php
/**************************************************************************/
echo '<div class="tab-pane fade" id="Menu_tab_1">';
//variables
$N_int        = 0;
$N_Servicios  = 0;
$N_Vecinos    = 0;
$N_Camaras    = 0;
$N_Eventos    = 0;
$N_Peligros   = 0;

/*************************************************/
//los recorro
if(isset($_SESSION['servicios'])) { 
	foreach ($_SESSION['servicios'] as $key => $servicio){
		$N_Servicios++;
	}
}
if(isset($_SESSION['vecinos'])) { 
	foreach ($_SESSION['vecinos'] as $key => $vecino){
		$N_Vecinos++;
	}
}
if(isset($_SESSION['vecinos_camaras'])) { 
	foreach ($_SESSION['vecinos_camaras'] as $key => $Cameras){
		if(isset($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']])) { 
			foreach ($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']] as $key => $cams){
				$N_Camaras++;
			}
		}
	}
}
if(isset($_SESSION['vecinos_eventos'])) { 
	foreach ($_SESSION['vecinos_eventos'] as $key => $evento){
		$N_Eventos++;
	}
}
if(isset($_SESSION['vecinos_peligros'])) { 
	foreach ($_SESSION['vecinos_peligros'] as $key => $peligros){
		$N_Peligros++;
	}
}
/*************************************************/
//cuento los eventos
$n_Evento     = db_select_nrows (false, 'idEvento', 'seg_vecinal_eventos_listado', '', "idCliente='".$_SESSION['usuario']['basic_data']['idCliente']."' AND FechaCreacion='".fecha_actual()."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_Evento');
$n_max_evento = 3;
//cuento los peligros
$n_Peligro     = db_select_nrows (false, 'idPeligro', 'seg_vecinal_peligros_listado', '', "idCliente='".$_SESSION['usuario']['basic_data']['idCliente']."' AND FechaCreacion='".fecha_actual()."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], basename($_SERVER["REQUEST_URI"], ".php"), 'n_Peligro');
$n_max_peligro = 3;
/*************************************************/
echo '
	<div class="table-responsive">
		<div class="col-sm-4">';
			
			echo '<div class="row">';
				echo '<div class="col-sm-12" style="padding-top:5px;padding-bottom:5px;">';
					if($n_Evento<=$n_max_evento){
						echo '<a href="principal_eventos.php?pagina=1&new=true" class="btn btn-default btn-block" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Evento</a>';
					}
					if($n_Peligro<=$n_max_peligro){
						echo '<a href="principal_peligros.php?pagina=1&new=true" class="btn btn-default btn-block" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Zona Peligrosa</a>';
					}
				echo '</div>';
			echo '</div>';
			
			
			echo '
			<div class="row">			
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading_0">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_0" aria-expanded="true" aria-controls="collapse_0">
									<span class="label label-danger">'.$_SESSION['usuario']['basic_data']['total_servicios'].'</span>
									<i class="fa fa-cog" aria-hidden="true"></i> Servicios
								</a>
							</h4>
						</div>
						<div id="collapse_0" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_0">
							<div class="panel-body" style="padding-top: 0px;padding-bottom: 0px;">';
								//si hay servicios
								if(isset($N_Servicios)&&$N_Servicios!=0){
									echo '
									<div id="clientesContent" class="row">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<tbody role="alert" aria-live="polite" aria-relevant="all">';
												/*************************************************/
												//los recorro
												foreach ($_SESSION['servicios'] as $key => $servicio){ 
													switch ($servicio['idTipo']) {
														case 1: $s_icon = '<span style="color:#F14D0B;"><i class="fa fa-ambulance" aria-hidden="true"></i></span>';         break;//Hospital
														case 2: $s_icon = '<span style="color:#BC260F;"><i class="fa fa-fire-extinguisher" aria-hidden="true"></i></span>'; break;//Bomberos
														case 3: $s_icon = '<span style="color:#518826;"><i class="fa fa-gavel" aria-hidden="true"></i></span>';             break;//Carabineros
													}
													echo '
													<tr class="odd">
														<td style="white-space: initial;">';
															echo $s_icon.' '.$servicio['Nombre'].'<br/>';
															echo '<span style="color:#337ab7;"><i class="fa fa-map-marker" aria-hidden="true"></i></span> ' .$servicio['Direccion'].' (de '.Hora_estandar($servicio['HoraInicio']).' a '.Hora_estandar($servicio['HoraTermino']).' hrs)<br/>';
														echo '						
														</td>
														<td width="10">
															<div class="btn-group" style="width: 70px;" >
																<a href="view_seg_vecinal_servicios.php?view='.simpleEncode($servicio['idServicio'], fecha_actual()).'" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																<button onclick="fncCenterMap('.$servicio['GeoLatitud'].', '.$servicio['GeoLongitud'].')" title="Ver Ubicacion" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
															</div>
														</td>
													</tr>';
													$N_int++;
												}           
												echo '
											</tbody>
										</table>
									</div>';
								//si no hay servicios cerca
								}elseif(isset($N_Servicios)&&$N_Servicios==0){
									//Notificacion
									echo '<div class="col-xs-12" style="margin-top:15px;">';
										$Alert_Text = 'No tienes servicios cerca';
										alert_post_data(4,3,2, $Alert_Text);
									echo '</div>';
								}
								echo '
							</div>
						</div>
					</div>
						
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading_1">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_1" aria-expanded="true" aria-controls="collapse_1">
									<span class="label label-danger">'.$_SESSION['usuario']['basic_data']['total_vecinos'].'</span>
									<i class="fa fa-user" aria-hidden="true"></i> Vecinos
								</a>
							</h4>
						</div>
						<div id="collapse_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_1">
							<div class="panel-body" style="padding-top: 0px;padding-bottom: 0px;">';
								//si hay vecinos
								if(isset($N_Vecinos)&&$N_Vecinos!=0){
									echo '
									<div id="clientesContent" class="row">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<tbody role="alert" aria-live="polite" aria-relevant="all">';
												/*************************************************/
												//los recorro
												foreach ($_SESSION['vecinos'] as $key => $vecino){
													echo '
													<tr class="odd">
														<td style="white-space: initial;">';
														if(isset($vecino['idTipo'])&&$vecino['idTipo']==1){
															echo '<span style="color:#1991CA;"><i class="fa fa-user" aria-hidden="true"></i></span> '.$vecino['RazonSocial'].'<br/>';
														}else{
															echo '<span style="color:#1991CA;"><i class="fa fa-user" aria-hidden="true"></i></span> '.$vecino['Nombre'].'<br/>';
														}
														echo '<span style="color:#337ab7;"><i class="fa fa-map-marker" aria-hidden="true"></i></span> ' .$vecino['Direccion'].'<br/>';
														echo '						
														</td>
														<td width="10">
															<div class="btn-group" style="width: 70px;" >
																<a href="view_seg_vecinal_cliente.php?view='.simpleEncode($vecino['idCliente'], fecha_actual()).'" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																<button onclick="fncCenterMap('.$vecino['GeoLatitud'].', '.$vecino['GeoLongitud'].')" title="Ver Ubicacion" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
															</div>
														</td>
													</tr>';
													$N_int++;
												}            
												echo '
											</tbody>
										</table>
									</div>';
								//si no hay vecinos cerca
								}elseif(isset($N_Vecinos)&&$N_Vecinos==0){
									//Notificacion
									echo '<div class="col-xs-12" style="margin-top:15px;">';
										$Alert_Text = 'No tienes vecinos cerca';
										alert_post_data(4,3,2, $Alert_Text);
									echo '</div>';
								}
								echo '
							</div>
						</div>
					</div>
						
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading_2">
							<h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_2" aria-expanded="false" aria-controls="collapse_2">
									<span class="label label-danger">'.$_SESSION['usuario']['basic_data']['total_camaras'].'</span>
									<i class="fa fa-video-camera" aria-hidden="true"></i> Camaras
								</a>
							</h4>
						</div>
						<div id="collapse_2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_2">
							<div class="panel-body" style="padding-top: 0px;padding-bottom: 0px;">';
								//si hay camaras
								if(isset($N_Camaras)&&$N_Camaras!=0){
									echo '
									<div id="camarasContent" class="row">
										<table id="dataTable" class="table table-bordered table-condensed table-hover dataTable">
											<tbody role="alert" aria-live="polite" aria-relevant="all">';
												/*************************************************/
												//los recorro
												foreach ($_SESSION['vecinos_camaras'] as $key => $Cameras){
													echo '
													<tr class="odd" style="background: #eee;">
														<td style="white-space: initial;">';
															echo '<span style="color:#1991CA;"><i class="fa fa-user" aria-hidden="true"></i></span> '.$Cameras['VecinoNombre'].'<br/>';
															echo '<span style="color:#337ab7;"><i class="fa fa-map-marker" aria-hidden="true"></i></span> ' .$Cameras['VecinoDireccion'].'<br/>';
															echo '						
														</td>
														<td width="10">
															<div class="btn-group" style="width: 35px;" >
																<button onclick="fncCenterMap('.$Cameras['VecinoLatitud'].', '.$Cameras['VecinoLongitud'].')" title="Ver Ubicacion" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
															</div>
														</td>
													</tr>';
														
													//verifico la existencia de vecinos
													if(isset($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']])) { 
														//los recorro
														foreach ($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']] as $key => $cams){
															echo '
															<tr class="odd">
																<td style="white-space: initial;">';
																	echo '<i class="fa fa-video-camera" aria-hidden="true"></i> ' .$cams['Nombre'].'<br/>';
																	echo '						
																</td>
																<td width="10">
																	<div class="btn-group" style="width: 35px;" >
																		<a href="view_camara.php?view='.simpleEncode($cams['idCanal'], fecha_actual()).'&client='.simpleEncode($Cameras['idCliente'], fecha_actual()).'&chanel='.simpleEncode($cams['Chanel'], fecha_actual()).'" title="Ver Camara" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-video-camera" aria-hidden="true"></i></a>
																	</div>
																</td>
															</tr>';
															$N_int++;
														}
													}	
												}          
												echo '
											</tbody>
										</table>
									</div>';	
								//si no hay camaras cerca
								}elseif(isset($N_Camaras)&&$N_Camaras==0){
									//Notificacion
									echo '<div class="col-xs-12" style="margin-top:15px;">';
										$Alert_Text = 'No tienes camaras cerca';
										alert_post_data(4,3,2, $Alert_Text);
									echo '</div>';
								}	
								echo '
							</div>
						</div>
					</div>
						
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading_3">
							<h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_3" aria-expanded="false" aria-controls="collapse_3">
									<span class="label label-danger">'.$_SESSION['usuario']['basic_data']['total_eventos'].'</span>
									<i class="fa fa-flag" aria-hidden="true"></i> Eventos
								</a>
							</h4>
						</div>
						<div id="collapse_3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_3">
							<div class="panel-body" style="padding-top: 0px;padding-bottom: 0px;">';
								//si hay eventos
								if(isset($N_Eventos)&&$N_Eventos!=0){
									echo '
									<div id="clientesContent" class="row">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<tbody role="alert" aria-live="polite" aria-relevant="all">';
												/*************************************************/
												//los recorro
												foreach ($_SESSION['vecinos_eventos'] as $key => $evento){
													//defino el tipo de marcador
													switch ($evento['idTipo']) {
														case 1: $s_icon = '<span style="color:#D0C60C;"><i class="fa fa-flag" aria-hidden="true"></i></span>'; break;//Situacion sospechosa - Persona (o grupo)
														case 2: $s_icon = '<span style="color:#F14D0B;"><i class="fa fa-flag" aria-hidden="true"></i></span>'; break;//Situacion sospechosa - Vehiculo (auto, moto, bicicleta, etc)
														case 3: $s_icon = '<span style="color:#BC260F;"><i class="fa fa-flag" aria-hidden="true"></i></span>'; break;//Robo a Hogar Frustrado
														case 4: $s_icon = '<span style="color:#518826;"><i class="fa fa-flag" aria-hidden="true"></i></span>'; break;//Robo a Hogar Efectuado - Sin presencia de dueños
														case 5: $s_icon = '<span style="color:#1991CA;"><i class="fa fa-flag" aria-hidden="true"></i></span>'; break;//Robo a Hogar Efectuado - Con intimidación o con violencia
														case 6: $s_icon = '<span style="color:#721FB3;"><i class="fa fa-flag" aria-hidden="true"></i></span>'; break;//Asalto
														case 7: $s_icon = '<span style="color:#0CD01A;"><i class="fa fa-flag" aria-hidden="true"></i></span>'; break;//Portonazo
													}
													echo '
													<tr class="odd">
														<td style="white-space: initial;">';
															echo $s_icon.' '.$evento['Tipo'].'<br/>';
															echo '<span style="color:#337ab7;"><i class="fa fa-map-marker" aria-hidden="true"></i></span> ' .$evento['Direccion'].'<br/>';
															echo '						
														</td>
														<td width="10">
															<div class="btn-group" style="width: 70px;" >
																<a href="principal_view_evento.php?view='.simpleEncode($evento['idEvento'], fecha_actual()).'" title="Ver Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																<button onclick="fncCenterMap('.$evento['GeoLatitud'].', '.$evento['GeoLongitud'].')" title="Ver Ubicacion" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
															</div>
														</td>
													</tr>';
													$N_int++;
												}           
												echo '
											</tbody>
										</table>
									</div>
									';
								//si no hay eventos cerca
								}elseif(isset($N_Eventos)&&$N_Eventos==0){
									//Notificacion
									echo '<div class="col-xs-12" style="margin-top:15px;">';
										$Alert_Text = 'No tienes eventos cerca';
										alert_post_data(4,3,2, $Alert_Text);
									echo '</div>';
								}	
								echo '
							</div>
						</div>
					</div>
						
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="heading_4">
							<h4 class="panel-title">
								<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse_4" aria-expanded="false" aria-controls="collapse_4">
									<span class="label label-danger">'.$_SESSION['usuario']['basic_data']['total_peligros'].'</span>
									<i class="fa fa-ban" aria-hidden="true"></i> Peligros
								</a>
							</h4>
						</div>
						<div id="collapse_4" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_4">
							<div class="panel-body" style="padding-top: 0px;padding-bottom: 0px;">';
								//si hay peligros
								if(isset($N_Peligros)&&$N_Peligros!=0){
									echo '
									<div id="clientesContent" class="row">
										<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
											<tbody role="alert" aria-live="polite" aria-relevant="all">';
												/*************************************************/
												//los recorro
												foreach ($_SESSION['vecinos_peligros'] as $key => $peligros){
													//defino el tipo de marcador
													switch ($peligros['idTipo']) {
														case 1: $s_icon = '<span style="color:#D0C60C;"><i class="fa fa-ban" aria-hidden="true"></i></span>'; break;//Desechos peligrosos
														case 2: $s_icon = '<span style="color:#F14D0B;"><i class="fa fa-ban" aria-hidden="true"></i></span>'; break;//Vehiculos abandonados
														case 3: $s_icon = '<span style="color:#BC260F;"><i class="fa fa-ban" aria-hidden="true"></i></span>'; break;//Zonas sin iluminacion
														case 4: $s_icon = '<span style="color:#518826;"><i class="fa fa-ban" aria-hidden="true"></i></span>'; break;//Junta de delincuentes
														case 5: $s_icon = '<span style="color:#1991CA;"><i class="fa fa-ban" aria-hidden="true"></i></span>'; break;//Intercambios de droga
														case 6: $s_icon = '<span style="color:#721FB3;"><i class="fa fa-ban" aria-hidden="true"></i></span>'; break;//
														case 7: $s_icon = '<span style="color:#0CD01A;"><i class="fa fa-ban" aria-hidden="true"></i></span>'; break;//
													}
													echo '
													<tr class="odd">
														<td>';
														echo $s_icon.' '.$peligros['Tipo'].'<br/>';
														echo '<span style="color:#337ab7;"><i class="fa fa-map-marker" aria-hidden="true"></i></span> ' .$peligros['Direccion'].'<br/>';
														echo '						
														</td>
														<td width="10">
															<div class="btn-group" style="width: 70px;" >
																<a href="principal_view_peligro.php?view='.simpleEncode($peligros['idPeligro'], fecha_actual()).'" title="Ver Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																<button onclick="fncCenterMap('.$peligros['GeoLatitud'].', '.$peligros['GeoLongitud'].')" title="Ver Ubicacion" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
															</div>
														</td>
													</tr>';
													$N_int++;	
												}          
												echo '
											</tbody>
										</table>
									</div>
									';
								//si no hay peligros cerca
								}elseif(isset($N_Peligros)&&$N_Peligros==0){
									//Notificacion
									echo '<div class="col-xs-12" style="margin-top:15px;">';
										$Alert_Text = 'No tienes zonas peligrosas cerca';
										alert_post_data(4,3,2, $Alert_Text);
									echo '</div>';
								}	
								echo '
								
							</div>
						</div>
					</div>
						
				</div>
			</div>			
			
			
				
		</div>
		<div class="col-sm-8">
			<div class="row">
				<div id="map_clientes" style="width: 100%; height: 550px;"></div>
			</div>
		</div>
	</div>';

//cierre del tab				
echo '</div>';

/* ************************************************************************** */
?>
	<script>
				
		var mapClient;
		var markersClient = [];
		
		/* ************************************************************************** */
		function fncCenterMap(Latitud, Longitud){
			latlon = new google.maps.LatLng(Latitud, Longitud);
			mapClient.panTo(latlon);
		}

		/* ************************************************************************** */
		function initializeClient() {
			var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

			var myOptions = {
				zoom: 20,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.SATELLITE
			};
			mapClient = new google.maps.Map(document.getElementById("map_clientes"), myOptions);
										
			//Ubicacion de los distintos dispositivos
			var locations = [
				<?php 
				/*************************************************/
				//verifico la existencia de servicios
				if(isset($_SESSION['servicios'])) { 
					//los recorro
					foreach ($_SESSION['servicios'] as $key => $servicio){ 
						
						//defino el tipo de marcador
						switch ($servicio['idTipo']) {
							case 1: $s_icon = 1; break;//Hospital
							case 2: $s_icon = 2; break;//Bomberos
							case 3: $s_icon = 3; break;//Carabineros
						}
																		
						//burbuja
						$explanation  = '<div class="iw-subTitle">'.$servicio['Nombre'].'</div>';
						$explanation .= '<p>';
						$explanation .= 'Tipo: '.$servicio['Tipo'].'<br/>';
						$explanation .= 'Direccion: '.$servicio['Direccion'].' '.$servicio['Comuna'].' '.$servicio['Ciudad'].'<br/>';
						$explanation .= 'Telefono Fijo: '.$servicio['Fono1'].'<br/>';
						$explanation .= 'Telefono Movil: '.$servicio['Fono2'].'<br/>';
						$explanation .= 'Fax: '.$servicio['Fax'].'<br/>';
						$explanation .= 'Email: '.$servicio['email'].'<br/>';
						$explanation .= '<br/>';
						$explanation .= 'Atiende desde las '.$servicio['HoraTermino'];
						$explanation .= ' hasta las '.$servicio['HoraTermino'].'<br/>';
						$explanation .= '</p>';
						
									
						//se arma dato
						$GPS = "[";
							$GPS .= $servicio['GeoLatitud'];
							$GPS .= ", ".$servicio['GeoLongitud'];
							$GPS .= ", '".$explanation."'";
							$GPS .= ", ".$s_icon;//para indicar el tipo de marcador a utilizar
						$GPS .= "], ";
						
						//se imprime dato
						echo $GPS;
					} 
				}
				/*************************************************/
				//verifico la existencia de vecinos
				if(isset($_SESSION['vecinos'])) { 
					//los recorro
					foreach($_SESSION['vecinos_filter'] as $direc=>$direcCat) {
						//variable
						$counter = 0;
						//burbuja
						
						$explanation  = '<p>';
						$explanation .= '<span class="iw-subTitle">Direccion: '.$direc.'</span>';
						$explanation .= '</p>';
						$explanation .= '<hr>';
						foreach($direcCat as $direcList) {
							//linea divisoria
							if($counter>0){$explanation .= '<hr>';}
							//tipo
							if(isset($direcList['idTipo'])&&$direcList['idTipo']==1){
								$x_nombre = $direcList['RazonSocial'];
							}else{
								$x_nombre = $direcList['Nombre'];
							}
							$explanation .= '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
								$explanation .= '<div class="row">';
									if ($direcList['Direccion_img']=='') {
										$explanation .= '<img class="media-object img-thumbnail user-img width100" alt="User Picture" src="'.DB_SITE_REPO.'/LIB_assets/img/usr.png">';
									}else{
										$explanation .= '<img class="media-object img-thumbnail user-img width100" alt="User Picture" src="'.DB_SITE_ALT_1.'/upload/'.$direcList['Direccion_img'].'">';
									}
								$explanation .= '</div>';
							$explanation .= '</div>';
							$explanation .= '<div class="col-lg-9 col-md-9 col-sm-6 col-xs-12">';
								$explanation .= '<p>';
								//nombre del vecino
								$explanation .= '<span class="iw-subTitle">Vecino: '.$x_nombre.'</span><br/>';
								//Si se comparten datos
								if(isset($direcList['idCompartir'])&&$direcList['idCompartir']==1){
									if(isset($direcList['Fono1'])&&$direcList['Fono1']!=''){                                  $explanation .= '<strong>Telefono Fijo:</strong> '.$direcList['Fono1'].'<br/>';}
									if(isset($direcList['Fono2'])&&$direcList['Fono2']!=''){                                  $explanation .= '<strong>Telefono Movil:</strong> '.$direcList['Fono2'].'<br/>';}
									if(isset($direcList['Fax'])&&$direcList['Fax']!=''){                                      $explanation .= '<strong>Fax:</strong> '.$direcList['Fax'].'<br/>';}
									if(isset($direcList['email'])&&$direcList['email']!=''){                                  $explanation .= '<strong>Email:</strong> '.$direcList['email'].'<br/>';}
									if(isset($direcList['PersonaContacto'])&&$direcList['PersonaContacto']!=''){              $explanation .= '<strong>Persona de Contacto:</strong> '.$direcList['PersonaContacto'].'<br/>';}
									if(isset($direcList['PersonaContacto_Fono'])&&$direcList['PersonaContacto_Fono']!=''){    $explanation .= '<strong>Telefono:</strong> '.$direcList['PersonaContacto_Fono'].'<br/>';}
									if(isset($direcList['PersonaContacto_email'])&&$direcList['PersonaContacto_email']!=''){  $explanation .= '<strong>Email:</strong> '.$direcList['PersonaContacto_email'].'<br/>';}
								}
								$explanation .= '</p>';
							$explanation .= '</div>';
							$explanation .= '<div class="clearfix"></div>';
							//sumar
							$counter++;
						}
						
						//verifico la existencia de vecinos
						if(isset($_SESSION['vecinos_camaras'])) { 
							//los recorro
							foreach ($_SESSION['vecinos_camaras'] as $key => $Cameras){ 
								//comparo las direcciones
								if($Cameras['VecinoDireccion']==$direc){
									$explanation .= '<hr>';
									$explanation .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">';
										$explanation .= '<div class="row">';
											$explanation .= '<span class="iw-subTitle">Camaras compartidas</span><br/>';
											$explanation .= '<ul>';
											//verifico la existencia de camaras
											if(isset($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']])) { 
												//los recorro
												foreach ($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']] as $key => $cams){
													$explanation .= '<li><i class="fa fa-video-camera" aria-hidden="true"></i> ' .$cams['Nombre'].'</li>';
												}
											}			
											$explanation .= '</ul>';
										$explanation .= '</div>';
									$explanation .= '</div>';
								}
							}
						}
											
						
						
						//se arma dato
						$GPS = "[";
							$GPS .= $direcCat[0]['GeoLatitud'];
							$GPS .= ", ".$direcCat[0]['GeoLongitud'];
							$GPS .= ", '".$explanation."'";
							$GPS .= ", 4";//para indicar el tipo de marcador a utilizar
						$GPS .= "], ";
						
						//se imprime dato
						echo $GPS;
						
					}
				}
				
				
				/*************************************************/
				//verifico la existencia de vecinos
				if(isset($_SESSION['vecinos_eventos'])) { 
					//los recorro
					foreach ($_SESSION['vecinos_eventos'] as $key => $event){ 
						
						//defino el tipo de marcador
						switch ($event['idTipo']) {
							case 1: $s_icon = 6;  break;//Situacion sospechosa - Persona (o grupo)
							case 2: $s_icon = 7;  break;//Situacion sospechosa - Vehiculo (auto, moto, bicicleta, etc)
							case 3: $s_icon = 8;  break;//Robo a Hogar Frustrado
							case 4: $s_icon = 9;  break;//Robo a Hogar Efectuado - Sin presencia de dueños
							case 5: $s_icon = 10; break;//Robo a Hogar Efectuado - Con intimidación o con violencia
							case 6: $s_icon = 11; break;//Asalto
							case 7: $s_icon = 12; break;//Portonazo
						}
						
						//burbuja
						$explanation  = '<div class="iw-subTitle">'.$event['Tipo'].'</div>';
						$explanation .= '<p>';
						$explanation .= 'Ciudad: '.$event['Ciudad'].'<br/>';
						$explanation .= 'Comuna: '.$event['Comuna'].'<br/>';
						$explanation .= 'Direccion: '.$event['Direccion'].'<br/>';
						$explanation .= 'Fecha: '.fecha_estandar($event['Fecha']).'<br/>';
						$explanation .= 'Hora: '.$event['Hora'].'<br/>';
						$explanation .= '</p>';
								
						//se arma dato
						$GPS = "[";
							$GPS .= $event['GeoLatitud'];
							$GPS .= ", ".$event['GeoLongitud'];
							$GPS .= ", '".$explanation."'";
							$GPS .= ", ".$s_icon;//para indicar el tipo de marcador a utilizar
						$GPS .= "], ";
						
						//se imprime dato
						echo $GPS;
					} 
				}
				/*************************************************/
				//verifico la existencia de vecinos
				if(isset($_SESSION['vecinos_peligros'])) { 
					//los recorro
					foreach ($_SESSION['vecinos_peligros'] as $key => $event){ 
						
						//defino el tipo de marcador
						switch ($event['idTipo']) {
							case 1: $s_icon = 13; break;//Desechos peligrosos
							case 2: $s_icon = 14; break;//Vehiculos abandonados
							case 3: $s_icon = 15; break;//Zonas sin iluminacion
							case 4: $s_icon = 16; break;//Junta de delincuentes
							case 5: $s_icon = 17; break;//Intercambios de droga
							case 6: $s_icon = 18; break;//
							case 7: $s_icon = 19; break;//
						}
						
						//burbuja
						$explanation  = '<div class="iw-subTitle">'.$event['Tipo'].'</div>';
						$explanation .= '<p>';
						$explanation .= 'Ciudad: '.$event['Ciudad'].'<br/>';
						$explanation .= 'Comuna: '.$event['Comuna'].'<br/>';
						$explanation .= 'Direccion: '.$event['Direccion'].'<br/>';
						$explanation .= '</p>';
								
						//se arma dato
						$GPS = "[";
							$GPS .= $event['GeoLatitud'];
							$GPS .= ", ".$event['GeoLongitud'];
							$GPS .= ", '".$explanation."'";
							$GPS .= ", ".$s_icon;//para indicar el tipo de marcador a utilizar
						$GPS .= "], ";
						
						//se imprime dato
						echo $GPS;
					} 
				}
				?>		
			];
					
			//ubicacion inicial
			setMarkers(mapClient, locations, 1);

		}
		/* ************************************************************************** */
		function setMarkers(mapClient, locations, optc) {

			var marker, i, last_latitude, last_longitude;
					
			for (i = 0; i < locations.length; i++) {
						
				//defino ubicacion y datos
				var latitude   = locations[i][0];
				var longitude  = locations[i][1];
				var data       = locations[i][2];
				var icon       = locations[i][3];
				var marcador   = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_estandar.png";	
				var title      = "Informacion";	
				
				//guardo las ultimas ubicaciones
				last_latitude   = locations[i][0];
				last_longitude  = locations[i][1];
				
				//ubicacion mapa		
				latlngset = new google.maps.LatLng(latitude, longitude);
				
				//defino marcador
				switch (icon) {
					case 1:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_ambulancia.png";	 title = "Hospital";                break;//Hospital
					case 2:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_bombero.png";      	 title = "Bomberos";                break;//Bomberos
					case 3:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_carabinero.png";     title = "Carabineros";             break;//Carabineros
					case 4:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_casa.png";   	     title = "Vecinos";                 break;//Vecinos
					case 5:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_casa.png";   	     title = "Grupo Camaras";           break;//Camaras
					case 6:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_1.png";       title = "Persona sospechosa";      break;//Eventos - Situacion sospechosa - Persona (o grupo)
					case 7:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_2.png";       title = "Vehiculo sospechoso";     break;//Eventos - Situacion sospechosa - Vehiculo (auto, moto, bicicleta, etc)
					case 8:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_3.png";       title = "Robo Frustrado";          break;//Eventos - Robo a Hogar Frustrado
					case 9:  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_4.png";       title = "Robo lugar deshabitado";  break;//Eventos - Robo a Hogar Efectuado - Sin presencia de dueños
					case 10: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_5.png";       title = "Robo con violencia";      break;//Eventos - Robo a Hogar Efectuado - Con intimidación o con violencia
					case 11: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_6.png";       title = "Asalto";                  break;//Eventos - Asalto
					case 12: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_7.png";       title = "Portonazo";               break;//Eventos - Portonazo
					case 13: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_1.png";      title = "Desechos peligrosos";     break;//Peligro - Desechos peligrosos
					case 14: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_2.png";      title = "Vehiculos abandonados";   break;//Peligro - Vehiculos abandonados
					case 15: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_3.png";      title = "Zonas sin iluminacion";   break;//Peligro - Zonas sin iluminacion
					case 16: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_4.png";      title = "Junta de delincuentes";   break;//Peligro - Junta de delincuentes
					case 17: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_5.png";      title = "Intercambios de droga";   break;//Peligro - Intercambios de droga
					case 18: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_6.png";      title = "";                        break;//Peligro - 
					case 19: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_7.png";      title = "";                        break;//Peligro - 
				}
		
				//se crea marcador
				var marker = new google.maps.Marker({
					map         : mapClient, 
					position    : latlngset,
					icon      	: marcador
				});
				markersClient.push(marker);

				//se define contenido
				var content = 	"<div id='iw-container'>" +
								"<div class='iw-title'>" + title + "</div>" +
								"<div class='iw-content'>" +
								data +
								"</div>" +
								"<div class='iw-bottom-gradient'></div>" +
								"</div>";

				//se crea infowindow
				var infowindow = new google.maps.InfoWindow();

				//se agrega funcion de click a infowindow
				google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
					return function() {
						infowindow.setContent(content);
						infowindow.open(mapClient,marker);
					};
				})(marker,content,infowindow)); 

			}
			if(optc==1){
				latlon = new google.maps.LatLng(last_latitude, last_longitude);
				mapClient.panTo(latlon);
			}
		}
		/* ************************************************************************** */
		// Sets the map on all markers in the array.
		function setMapOnAll(mapClient) {
			for (let i = 0; i < markersClient.length; i++) {
				markersClient[i].setMap(mapClient);
			}
		}
		/* ************************************************************************** */
		// Removes the markers from the map, but keeps them in the array.
		function clearMarkers() {
			setMapOnAll(null);
		}
		/* ************************************************************************** */
		// Shows any markers currently in the array.
		function showMarkers() {
			setMapOnAll(mapClient);
		}
		/* ************************************************************************** */
		// Deletes all markers in the array by removing references to them.
		function deleteMarkers() {
			clearMarkers();
			markersClient = [];
		}
		/* ************************************************************************** */
		google.maps.event.addDomListener(window, "load", initializeClient());
	</script>



<?php
/**************************************************************************/
echo '<div class="tab-pane fade" id="Menu_tab_2">';
//variable
$N_Vec = 0;
/*************************************************/
//verifico la existencia de vecinos
if(isset($_SESSION['vecinos_camaras'])) { 
	/*************************************************/
	//los recorro
	foreach ($_SESSION['vecinos_camaras'] as $key => $Cameras){
		if(isset($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']])) { 
			//los recorro
			foreach ($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']] as $key => $cams){
				$N_Vec++;
			}
		}
	}
	/*************************************************/
	//si hay datos
	if(isset($N_Vec)&&$N_Vec!=0){
		echo '
		<div class="table-responsive">
			<div class="col-sm-4">
				<div class="row">
					<div id="camarasContent" class="table-wrapper-scroll-y my-custom-scrollbar">
						<table id="dataTable" class="table table-bordered table-condensed table-hover dataTable">
							<tbody role="alert" aria-live="polite" aria-relevant="all">';
								/*************************************************/
								//variable
								$N_int = 0;
								/*************************************************/
								//los recorro
								foreach ($_SESSION['vecinos_camaras'] as $key => $Cameras){
									echo '
									<tr class="odd" style="background: #eee;">
										<td>';
											echo '<span style="color:#1991CA;"><i class="fa fa-user" aria-hidden="true"></i></span> '.$Cameras['VecinoNombre'].'<br/>';
											echo '<span style="color:#337ab7;"><i class="fa fa-map-marker" aria-hidden="true"></i></span> ' .$Cameras['VecinoDireccion'].'<br/>';
											echo '						
										</td>
										<td width="10">
											<div class="btn-group" style="width: 35px;" >
												<button onclick="fncCenterMapCam('.$Cameras['VecinoLatitud'].', '.$Cameras['VecinoLongitud'].', '.$N_int.')" title="Ver Ubicacion" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
											</div>
										</td>
									</tr>';
										
									//verifico la existencia de vecinos
									if(isset($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']])) { 
										//los recorro
										foreach ($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']] as $key => $cams){
											echo '
											<tr class="odd">
												<td>';
													echo '<i class="fa fa-video-camera" aria-hidden="true"></i> ' .$cams['Nombre'].'<br/>';
													echo '						
												</td>
												<td width="10">
													<div class="btn-group" style="width: 35px;" >
														<a href="view_camara.php?view='.simpleEncode($cams['idCanal'], fecha_actual()).'&client='.simpleEncode($Cameras['idCliente'], fecha_actual()).'&chanel='.simpleEncode($cams['Chanel'], fecha_actual()).'" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
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
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="row">
					<div id="map_camaras" style="width: 100%; height: 550px;"></div>
				</div>
			</div>
		</div>';
	}
}	
/*************************************************/
//si no hay datos
if(isset($N_Vec)&&$N_Vec==0){
	/*************************************************************/
	//Notificacion
	echo '<div class="col-xs-12" style="margin-top:15px;">';
		$Alert_Text = 'No tienes camaras cerca';
		alert_post_data(4,3,2, $Alert_Text);
	echo '	
	</div>
	<div class="clearfix" ></div>';
}
	
					
echo '</div>';


/* ************************************************************************** */
if(isset($_SESSION['vecinos_camaras'])) {?>
	<script>
				
		var mapCam;
		var markersCam = [];
		
		/* ************************************************************************** */
		function fncCenterMapCam(Latitud, Longitud, n_icon){
			latlon = new google.maps.LatLng(Latitud, Longitud);
			mapCam.panTo(latlon);
		}

		/* ************************************************************************** */
		function initializeCam() {
			var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

			var myOptions = {
				zoom: 20,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.SATELLITE
			};
			mapCam = new google.maps.Map(document.getElementById("map_camaras"), myOptions);
										
			//Ubicacion de los distintos dispositivos
			var locations = [
				<?php 
				/*************************************************/
				//verifico la existencia de vecinos
				if(isset($_SESSION['vecinos_camaras'])) { 
					//los recorro
					foreach ($_SESSION['vecinos_camaras'] as $key => $Cameras){ 
									
						//burbuja
						$explanation  = '<div class="iw-subTitle">'.$Cameras['VecinoNombre'].'</div>';
						$explanation .= '<p>';
						$explanation .= 'Direccion: '.$Cameras['VecinoDireccion'].'<br/>';
						$explanation .= '</p>';
						$explanation .= '<ul>';
						//verifico la existencia de camaras
						if(isset($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']])) { 
							//los recorro
							foreach ($_SESSION['vecinos_camaras_list'][$Cameras['idCliente']] as $key => $cams){
								$explanation .= '<li><i class="fa fa-video-camera" aria-hidden="true"></i> ' .$cams['Nombre'].'</li>';
							}
						}			
						$explanation .= '</ul>';
								
						//se arma dato
						$GPS = "[";
							$GPS .= $Cameras['VecinoLatitud'];
							$GPS .= ", ".$Cameras['VecinoLongitud'];
							$GPS .= ", '".$explanation."'";
							$GPS .= ", 5";//para indicar el tipo de marcador a utilizar
						$GPS .= "], ";
						
						//se imprime dato
						echo $GPS;
					} 
				}			
				?>		
			];
					
			//ubicacion inicial
			setMarkers(mapCam, locations, 1);

		}
		/* ************************************************************************** */
		function setMarkers(mapCam, locations, optc) {

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
				  case 5: 
					  marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_casa.png";   	    
					  title = "Grupo Camaras";      
					  break;
				}
		
				//se crea marcador
				var marker = new google.maps.Marker({
					map         : mapCam, 
					position    : latlngset,
					icon      	: marcador
				});
				markersCam.push(marker);

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
						infowindow.open(mapCam,marker);
					};
				})(marker,content,infowindow)); 

			}
			if(optc==1){
				latlon = new google.maps.LatLng(last_latitude, last_longitude);
				mapCam.panTo(latlon);
			}
		}
		/* ************************************************************************** */
		// Sets the map on all markers in the array.
		function setMapOnAll(mapCam) {
			for (var i = 0; i < markersCam.length; i++) {
				markersCam[i].setMap(mapCam);
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
			setMapOnAll(mapCam);
		}
		/* ************************************************************************** */
		// Deletes all markers in the array by removing references to them.
		function deleteMarkers() {
			clearMarkers();
			markersCam = [];
		}
		/* ************************************************************************** */
		google.maps.event.addDomListener(window, "load", initializeCam());
	</script>
<?php } ?>	


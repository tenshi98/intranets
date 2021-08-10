<?php
/**************************************************************************/
echo '<div class="tab-pane fade" id="Menu_tab_3">';
//variable
$N_Vec = 0;
/*************************************************/
//verifico la existencia de vecinos
if(isset($_SESSION['vecinos_eventos'])) { 
	/*************************************************/
	//los recorro
	foreach ($_SESSION['vecinos_eventos'] as $key => $evento){
		$N_Vec++;
	}
	/*************************************************/
	//si hay datos
	if(isset($N_Vec)&&$N_Vec!=0){
		echo '
		<div class="table-responsive">
			<div class="col-sm-4">
				<div class="row">
					<div id="clientesContent" class="table-wrapper-scroll-y my-custom-scrollbar">
						<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
							<tbody role="alert" aria-live="polite" aria-relevant="all">';
								/*************************************************/
								//variable
								$N_int = 0;
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
										<td>';
											echo $s_icon.' '.$evento['Tipo'].'<br/>';
											echo '<span style="color:#337ab7;"><i class="fa fa-map-marker" aria-hidden="true"></i></span> ' .$evento['Direccion'].'<br/>';
											echo '						
										</td>
										<td width="10">
											<div class="btn-group" style="width: 70px;" >
												<a href="principal_view_evento.php?view='.simpleEncode($evento['idEvento'], fecha_actual()).'" title="Ver Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
												<button onclick="fncCenterMapEvent('.$evento['GeoLatitud'].', '.$evento['GeoLongitud'].', '.$N_int.')" title="Ver Ubicacion" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
											</div>
										</td>
									</tr>';
									$N_int++;
								}           
								echo '
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-sm-8">
				<div class="row">
					<div id="map_eventos" style="width: 100%; height: 550px;"></div>
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
		$Alert_Text = 'No tienes eventos cerca';
		alert_post_data(4,3,2, $Alert_Text);
	echo '	
	</div>
	<div class="clearfix" ></div>';
}
	
					
echo '</div>';

/* ************************************************************************** */
if(isset($_SESSION['vecinos_eventos'])) {?>
	<script>
				
		var mapEvent;
		var markersEvent = [];
		
		/* ************************************************************************** */
		function fncCenterMapEvent(Latitud, Longitud, n_icon){
			latlon = new google.maps.LatLng(Latitud, Longitud);
			mapEvent.panTo(latlon);
		}

		/* ************************************************************************** */
		function initializeEvent() {
			var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

			var myOptions = {
				zoom: 20,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.SATELLITE
			};
			mapEvent = new google.maps.Map(document.getElementById("map_eventos"), myOptions);
										
			//Ubicacion de los distintos dispositivos
			var locations = [
				<?php 
				/*************************************************/
				//verifico la existencia de vecinos
				if(isset($_SESSION['vecinos_eventos'])) { 
					//los recorro
					foreach ($_SESSION['vecinos_eventos'] as $key => $event){ 
						
						//defino el tipo de marcador
						switch ($event['idTipo']) {
							case 1: $s_icon = 1; break;//Situacion sospechosa - Persona (o grupo)
							case 2: $s_icon = 2; break;//Situacion sospechosa - Vehiculo (auto, moto, bicicleta, etc)
							case 3: $s_icon = 3; break;//Robo a Hogar Frustrado
							case 4: $s_icon = 4; break;//Robo a Hogar Efectuado - Sin presencia de dueños
							case 5: $s_icon = 5; break;//Robo a Hogar Efectuado - Con intimidación o con violencia
							case 6: $s_icon = 6; break;//Asalto
							case 7: $s_icon = 7; break;//Portonazo
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
				?>		
			];
					
			//ubicacion inicial
			setMarkers(mapEvent, locations, 1);

		}
		/* ************************************************************************** */
		function setMarkers(mapEvent, locations, optc) {

			var marker, i, last_latitude, last_longitude;
					
			for (i = 0; i < locations.length; i++) {
						
				//defino ubicacion y datos
				var latitude   = locations[i][0];
				var longitude  = locations[i][1];
				var data       = locations[i][2];
				var icon       = locations[i][3];
				var marcador   = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_0.png";	
				var title      = "Informacion";	
				
				//guardo las ultimas ubicaciones
				last_latitude   = locations[i][0];
				last_longitude  = locations[i][1];
				
				//ubicacion mapa		
				latlngset = new google.maps.LatLng(latitude, longitude);
				
				//defino marcador
				switch (icon) {
					case 1: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_1.png";  title = "Persona sospechosa";      break;//Situacion sospechosa - Persona (o grupo)
					case 2: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_2.png";  title = "Vehiculo sospechoso";     break;//Situacion sospechosa - Vehiculo (auto, moto, bicicleta, etc)
					case 3: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_3.png";  title = "Robo Frustrado";          break;//Robo a Hogar Frustrado
					case 4: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_4.png";  title = "Robo lugar deshabitado";  break;//Robo a Hogar Efectuado - Sin presencia de dueños
					case 5: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_5.png";  title = "Robo con violencia";      break;//Robo a Hogar Efectuado - Con intimidación o con violencia
					case 6: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_6.png";  title = "Asalto";                  break;//Asalto
					case 7: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_evento_7.png";  title = "Portonazo";               break;//Portonazo
				}
		
				//se crea marcador
				var marker = new google.maps.Marker({
					map         : mapEvent, 
					position    : latlngset,
					icon      	: marcador
				});
				markersEvent.push(marker);

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
						infowindow.open(mapEvent,marker);
					};
				})(marker,content,infowindow)); 

			}
			if(optc==1){
				latlon = new google.maps.LatLng(last_latitude, last_longitude);
				mapEvent.panTo(latlon);
			}
		}
		/* ************************************************************************** */
		// Sets the map on all markers in the array.
		function setMapOnAll(mapEvent) {
			for (var i = 0; i < markersEvent.length; i++) {
				markersEvent[i].setMap(mapEvent);
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
			setMapOnAll(mapEvent);
		}
		/* ************************************************************************** */
		// Deletes all markers in the array by removing references to them.
		function deleteMarkers() {
			clearMarkers();
			markersEvent = [];
		}
		/* ************************************************************************** */
		google.maps.event.addDomListener(window, "load", initializeEvent());
	</script>
<?php } ?>	

<?php
/**************************************************************************/
echo '<div class="tab-pane fade" id="Menu_tab_4">';
//variable
$N_Vec = 0;
/*************************************************/
//verifico la existencia de vecinos
if(isset($_SESSION['vecinos_peligros'])) { 
	/*************************************************/
	//los recorro
	foreach ($_SESSION['vecinos_peligros'] as $key => $peligros){
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
												<button onclick="fncCenterMapPeligro('.$peligros['GeoLatitud'].', '.$peligros['GeoLongitud'].', '.$N_int.')" title="Ver Ubicacion" class="btn btn-default btn-sm tooltip"><i class="fa fa-map-marker" aria-hidden="true"></i></button>
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
					<div id="map_peligros" style="width: 100%; height: 550px;"></div>
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
		$Alert_Text = 'No tienes zonas peligrosas cerca';
		alert_post_data(4,3,2, $Alert_Text);
	echo '	
	</div>
	<div class="clearfix" ></div>';
}
	
	
					
echo '</div>';

/* ************************************************************************** */
if(isset($_SESSION['vecinos_peligros'])) {?>
	<script>
				
		var mapPeligro;
		var markersPeligro = [];
		
		/* ************************************************************************** */
		function fncCenterMapPeligro(Latitud, Longitud, n_icon){
			latlon = new google.maps.LatLng(Latitud, Longitud);
			mapPeligro.panTo(latlon);
		}

		/* ************************************************************************** */
		function initializePeligro() {
			var myLatlng = new google.maps.LatLng(-33.477271996598965, -70.65170304882815);

			var myOptions = {
				zoom: 20,
				center: myLatlng,
				mapTypeId: google.maps.MapTypeId.SATELLITE
			};
			mapPeligro = new google.maps.Map(document.getElementById("map_peligros"), myOptions);
										
			//Ubicacion de los distintos dispositivos
			var locations = [
				<?php 
				/*************************************************/
				//verifico la existencia de vecinos
				if(isset($_SESSION['vecinos_peligros'])) { 
					//los recorro
					foreach ($_SESSION['vecinos_peligros'] as $key => $event){ 
						
						//defino el tipo de marcador
						switch ($event['idTipo']) {
							case 1: $s_icon = 1; break;//Desechos peligrosos
							case 2: $s_icon = 2; break;//Vehiculos abandonados
							case 3: $s_icon = 3; break;//Zonas sin iluminacion
							case 4: $s_icon = 4; break;//Junta de delincuentes
							case 5: $s_icon = 5; break;//Intercambios de droga
							case 6: $s_icon = 6; break;//
							case 7: $s_icon = 7; break;//
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
			setMarkers(mapPeligro, locations, 1);

		}
		/* ************************************************************************** */
		function setMarkers(mapPeligro, locations, optc) {

			var marker, i, last_latitude, last_longitude;
					
			for (i = 0; i < locations.length; i++) {
						
				//defino ubicacion y datos
				var latitude   = locations[i][0];
				var longitude  = locations[i][1];
				var data       = locations[i][2];
				var icon       = locations[i][3];
				var marcador   = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_0.png";	
				var title      = "Informacion";	
				
				//guardo las ultimas ubicaciones
				last_latitude   = locations[i][0];
				last_longitude  = locations[i][1];
				
				//ubicacion mapa		
				latlngset = new google.maps.LatLng(latitude, longitude);
				
				//defino marcador
				switch (icon) {
					case 1: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_1.png";  title = "Desechos peligrosos";    break;//Desechos peligrosos
					case 2: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_2.png";  title = "Vehiculos abandonados";  break;//Vehiculos abandonados
					case 3: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_3.png";  title = "Zonas sin iluminacion";  break;//Zonas sin iluminacion
					case 4: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_4.png";  title = "Junta de delincuentes";  break;//Junta de delincuentes
					case 5: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_5.png";  title = "Intercambios de droga";  break;//Intercambios de droga
					case 6: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_6.png";  title = "";                       break;//
					case 7: marcador = "<?php echo DB_SITE_REPO; ?>/LIB_assets/img/map-icons/2_peligro_7.png";  title = "";                       break;//
				}
		
				//se crea marcador
				var marker = new google.maps.Marker({
					map         : mapPeligro, 
					position    : latlngset,
					icon      	: marcador
				});
				markersPeligro.push(marker);

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
						infowindow.open(mapPeligro,marker);
					};
				})(marker,content,infowindow)); 

			}
			if(optc==1){
				latlon = new google.maps.LatLng(last_latitude, last_longitude);
				mapPeligro.panTo(latlon);
			}
		}
		/* ************************************************************************** */
		// Sets the map on all markers in the array.
		function setMapOnAll(mapPeligro) {
			for (var i = 0; i < markersPeligro.length; i++) {
				markersPeligro[i].setMap(mapPeligro);
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
			setMapOnAll(mapPeligro);
		}
		/* ************************************************************************** */
		// Deletes all markers in the array by removing references to them.
		function deleteMarkers() {
			clearMarkers();
			markersPeligro = [];
		}
		/* ************************************************************************** */
		google.maps.event.addDomListener(window, "load", initializePeligro());
	</script>
<?php } ?>	

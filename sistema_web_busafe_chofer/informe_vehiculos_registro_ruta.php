<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion 
$original = "informe_vehiculos_registro_ruta.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Rutas Realizadas';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['submit_filter']) ) { 
//se verifica si se ingreso la hora, es un dato optativo
$z='';
$z='';if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''&&isset($_GET['f_termino'])&&$_GET['f_termino']!=''&&isset($_GET['h_inicio'])&&$_GET['h_inicio']!=''&&isset($_GET['h_termino'])&&$_GET['h_termino']!=''){
	$z.=" WHERE (TimeStamp BETWEEN '".$_GET['f_inicio']." ".$_GET['h_inicio']."' AND '".$_GET['f_termino']." ".$_GET['h_termino']."')";
}elseif(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''&&isset($_GET['f_termino'])&&$_GET['f_termino']!=''){
	$z.=" WHERE (FechaSistema BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."')";
}
//Se traen todos los registros
$arrRutas = array();
$query = "SELECT 
vehiculos_listado.Nombre AS NombreEquipo,
vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".idTabla,
vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".GeoLatitud,
vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".GeoLongitud

FROM `vehiculos_listado_tablarelacionada_".$_GET['idVehiculo']."`
LEFT JOIN `vehiculos_listado` ON vehiculos_listado.idVehiculo = vehiculos_listado_tablarelacionada_".$_GET['idVehiculo'].".idVehiculo

".$z;
  
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
	$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
	$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
}
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrRutas,$row );
}


?>	


<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Ruta</h5>	
		</header>
        <div class="table-responsive">
			
			
			
			<div class="col-sm-12">
				<div class="row">
					<?php
					//Si no existe una ID se utiliza una por defecto
					if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
						echo '<p>No ha ingresado Una API de Google Maps</p>';
					}else{
						$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle']; ?>
						<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&sensor=false"></script>
						
						<div id="map_canvas" style="width: 100%; height: 550px;"></div>
						
						<script>
							
							var map;
							var marker;
							var speed = 500; // km/h
							var delay = 100;
							
							var locations = [ 
								<?php foreach ( $arrRutas as $pos ) { 
									if($pos['GeoLatitud']<0&&$pos['GeoLongitud']<0){?>
									['<?php echo $pos['idTabla']; ?>', <?php echo $pos['GeoLatitud']; ?>, <?php echo $pos['GeoLongitud']; ?>], 					
								<?php } 
								}?>
								];


							/* ************************************************************************** */
							function initialize() {
								
								var myOptions = {
									zoom: 12,
									center: new google.maps.LatLng(locations[0][1], locations[0][2]),
									zoomControl: true,
									scaleControl: false,
									scrollwheel: false,
									disableDoubleClickZoom: true,
									mapTypeId: google.maps.MapTypeId.ROADMAP
								};
								map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
								
								//Se llama a la ruta
								RutasAlternativas();
								//Se llama al marcador y se anima
								 marker = new google.maps.Marker({
									position	: new google.maps.LatLng(locations[0][1], locations[0][2]),
									map			: map,
									animation 	: google.maps.Animation.DROP,
									icon      	: "<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/1_series_orange.png"
								});
								
								google.maps.event.addListenerOnce(map, 'idle', function()
								{
									animateMarker(marker, [
										<?php foreach ( $arrRutas as $pos ) { ?>
											[<?php echo $pos['GeoLatitud']; ?>, <?php echo $pos['GeoLongitud']; ?>], 					
										<?php } ?>
									], speed);
								})
						
							}
							
							/* ************************************************************************** */
							function RutasAlternativas() {
								
								var route=[];
								var tmp;
								
								

								for(var i in locations){
									tmp=new google.maps.LatLng(locations[i][1], locations[i][2]);
									route.push(tmp);
								}
								
								var drawn = new google.maps.Polyline({
									map: map,
									path: route,
									strokeColor: 'blue',
									strokeOpacity: 1,
									strokeWeight: 5
								});
							}
							/* ************************************************************************** */
							function animateMarker(marker, coords, km_h){
								var target = 0;
								var targetx = 0;
								var km_h = km_h || 50;
								coords.push([locations[0][1], locations[0][2]]);
								goToPoint();
								
								function goToPoint(){
									var lat = marker.position.lat();
									var lng = marker.position.lng();
									var step = (km_h * 1000 * delay) / 3600000; // in meters
									
									var dest = new google.maps.LatLng(
									coords[target][0], coords[target][1]);
									
									var distance =
									google.maps.geometry.spherical.computeDistanceBetween(
									dest, marker.position); // in meters
									
									var numStep = distance / step;
									var i = 0;
									var deltaLat = (coords[target][0] - lat) / numStep;
									var deltaLng = (coords[target][1] - lng) / numStep;
									
									function moveMarker(){
										lat += deltaLat;
										lng += deltaLng;
										i += step;
										
										if (i < distance){
											marker.setPosition(new google.maps.LatLng(lat, lng));
											setTimeout(moveMarker, delay);
										}else{   
											if(targetx==0){
												marker.setPosition(dest);
												target++;
												if (target == coords.length){ target = 0; }
												setTimeout(goToPoint, delay);
												targetx=1;
											}
										}
										 
									}
									//centralizo el mapa en base al ultimo dato obtenido
									map.panTo(marker.getPosition());
									//muevo el marcador
									moveMarker();
									
								}
								
							}
							/* ************************************************************************** */
							google.maps.event.addDomListener(window, "load", initialize());
						</script>
			
					<?php } ?>
				</div>
			</div>
			
			
			
		</div>	
	</div>
</div>






<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>
			
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
//Verifico el tipo de usuario que esta ingresando
$w  = "idSistema=".$_SESSION['usuario']['basic_data']['idSistema']." AND idEstado=1";
$w .= " AND idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
?>			
<div class="col-sm-8 fcenter">
	<div class="box dark">	
		<header>		
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>		
			<h5>Filtro de busqueda</h5>	
		</header>	
		<div id="div-1" class="body">	
			<form class="form-horizontal" action="<?php echo $location ?>" id="form1" name="form1" novalidate>
               
				<?php 
				//Se verifican si existen los datos
				if(isset($f_inicio)) {      $x1  = $f_inicio;     }else{$x1  = '';}
				if(isset($f_termino)) {     $x2  = $f_termino;    }else{$x2  = '';}
				if(isset($h_inicio)) {      $x3  = $h_inicio;     }else{$x3  = '';}
				if(isset($h_termino)) {     $x4  = $h_termino;    }else{$x4  = '';}
				if(isset($idVehiculo)) {    $x5  = $idVehiculo;   }else{$x5  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_date('Fecha Inicio','f_inicio', $x1, 2);
				$Form_Inputs->form_date('Fecha Termino','f_termino', $x2, 2);
				$Form_Inputs->form_time('Hora Inicio','h_inicio', $x3, 1, 1);
				$Form_Inputs->form_time('Hora Termino','h_termino', $x4, 1, 1);
				$Form_Inputs->form_select_filter('Vehiculo','idVehiculo', $x5, 2, 'idVehiculo', 'Nombre', 'vehiculos_listado', $w, '', $dbConn);
				
				?>        
	   
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf002; Filtrar" name="submit_filter">	
				</div>
			</form> 
			<?php widget_validator(); ?>
		</div>
	</div>
</div>
<?php } ?>

	

          
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

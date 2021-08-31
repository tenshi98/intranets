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
$original = "principal_peligros.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-ban" aria-hidden="true"></i> Mis Zonas Peligrosas';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_update']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_peligros_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Camara creada correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Camara editada correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Camara borrada correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// consulto los datos
$query = "SELECT 
seg_vecinal_peligros_listado.idTipo,
seg_vecinal_peligros_listado.idCiudad,
seg_vecinal_peligros_listado.idComuna,
seg_vecinal_peligros_listado.Direccion,
seg_vecinal_peligros_listado.GeoLatitud,
seg_vecinal_peligros_listado.GeoLongitud,
seg_vecinal_peligros_listado.Descripcion,
seg_vecinal_peligros_listado.idEstado,

seg_vecinal_peligros_tipos.Nombre AS Tipo

FROM `seg_vecinal_peligros_listado`
LEFT JOIN `seg_vecinal_peligros_tipos`  ON seg_vecinal_peligros_tipos.idTipo  = seg_vecinal_peligros_listado.idTipo

WHERE seg_vecinal_peligros_listado.idPeligro = ".simpleDecode($_GET['id'], fecha_actual());
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
$rowdata = mysqli_fetch_assoc ($resultado);

//se revisa la cantidad de archivos adjuntos
$N_Archivos = db_select_nrows (false, 'Nombre', 'seg_vecinal_peligros_listado_archivos', '', "idPeligro='".simpleDecode($_GET['id'], fecha_actual())."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'N_Archivos');?>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Zona de Peligro', $rowdata['Tipo'], 'Editar Datos de la Zona de Peligro');?>
</div>
<div class="clearfix"></div> 

<?php
echo '<div class="col-sm-12">';
$Alert_Text  = 'Primero selecciona la ciudad, luego la comuna y por ultimo ingresa la direccion, 
en caso de que la ubicacion mostrada no sea correcta, pone el cursor del mouse sobre el marcador  
<img src="'.DB_SITE_REPO.'/LIB_assets/img/map-icons/2_peligro_0.png" alt="marcador" width="33" height="44">  
, hazle click con el boton izquierdo del mouse y arrastralo hasta la posicion correcta para corregirla, 
en algunos casos Google Maps no muestra la direccion correcta (<strong>Direccion Encontrada</strong>).';
alert_post_data(1,3,3, $Alert_Text);
echo '</div>';
?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class=""><a href="<?php echo 'principal_peligros.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-flag" aria-hidden="true"></i> Resumen</a></li>
				<li class="active"><a href="<?php echo 'principal_peligros_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Datos</a></li>
				<li class=""><a href="<?php echo 'principal_peligros_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-file-archive-o" aria-hidden="true"></i> Archivos Adjuntos <span class="label label-danger"><?php echo $N_Archivos; ?></span></a></li>          
			</ul>
		</header>
		<div class="table-responsive">
			
			<div class="col-sm-6">
				<div class="row">
					<?php
					//Si no existe una ID se utiliza una por defecto
					if(!isset($_SESSION['usuario']['basic_data']['Config_IDGoogle']) OR $_SESSION['usuario']['basic_data']['Config_IDGoogle']==''){
						$Alert_Text  = 'No ha ingresado Una API de Google Maps.';
						alert_post_data(4,2,2, $Alert_Text);
					}else{
						$google = $_SESSION['usuario']['basic_data']['Config_IDGoogle'];
						
						if(isset($rowdata['GeoLatitud']) && $rowdata['GeoLatitud']!='' && $rowdata['GeoLatitud']!=0){
							$nlat = $rowdata['GeoLatitud'];
						}else{
							$nlat = $_SESSION['usuario']['basic_data']['GeoLatitud'];
						}
						
						if(isset($rowdata['GeoLongitud']) && $rowdata['GeoLongitud']!='' && $rowdata['GeoLongitud']!=0){
							$nlong = $rowdata['GeoLongitud'];
						}else{
							$nlong = $_SESSION['usuario']['basic_data']['GeoLongitud'];
						}
						
						?>
						<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&sensor=false&libraries=places"></script>
						
						<div id="map_canvas" style="width: 100%; height: 550px;"></div>
						

						<script>

							var map;
							var marker;
							var geocoder = new google.maps.Geocoder();
								
							/* ************************************************************************** */
							function initialize() {
								var myLatlng = new google.maps.LatLng(<?php echo $nlat; ?>, <?php echo $nlong; ?>);

								var myOptions = {
									zoom: 19,
									center: myLatlng,
									mapTypeId: google.maps.MapTypeId.SATELLITE
								};
								map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
								
								marker = new google.maps.Marker({
									draggable	: true,
									position	: myLatlng,
									map			: map,
									title		: "Tu Ubicacion",
									animation 	:google.maps.Animation.DROP,
									icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/2_peligro_0.png"
								});
							
								google.maps.event.addListener(marker, 'dragend', function (event) {

									document.getElementById("GeoLatitud").value = event.latLng.lat();
									document.getElementById("GeoLongitud").value = event.latLng.lng();
									//document.getElementById("Latitud_fake").value = event.latLng.lat();
									//document.getElementById("Longitud_fake").value = event.latLng.lng();
									codeLatLng(event.latLng.lat(),event.latLng.lng(),'Direccion_fake');
									
								});
							}
							/* ************************************************************************** */	
							function codeLatLng(lat,lng, div) {
								geocoder = new google.maps.Geocoder();
								var latlng = new google.maps.LatLng(lat, lng);
								geocoder.geocode({'latLng': latlng}, function(results, status) {
									if (status == google.maps.GeocoderStatus.OK) {
										if (results[0]) {
											document.getElementById(div).value = results[0].formatted_address;
										} else {
											alert('No results found');
										}
									} else {
										alert('Geocoder failed due to: ' + status);
									}
								});
							}
							/* ************************************************************************** */
							google.maps.event.addDomListener(window, "load", initialize());
						</script>
					
					<?php } ?>
				</div>
			</div>
			
			<div class="col-sm-6">
				<div style="margin-top:20px;">
					<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
				
						<?php 
						//Se verifican si existen los datos
						if(isset($idTipo)) {        $x1 = $idTipo;        }else{$x1  = $rowdata['idTipo'];}
						if(isset($idCiudad)) {      $x2 = $idCiudad;      }else{$x2  = $rowdata['idCiudad'];}
						if(isset($idComuna)) {      $x3 = $idComuna;      }else{$x3  = $rowdata['idComuna'];}
						if(isset($Direccion)) {     $x4 = $Direccion;     }else{$x4  = $rowdata['Direccion'];}
						if(isset($Descripcion)) {   $x5 = $Descripcion;   }else{$x5  = $rowdata['Descripcion'];}
						if(isset($idEstado)) {      $x6 = $idEstado;      }else{$x6  = $rowdata['idEstado'];}
						
						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_select('Tipo de Evento','idTipo', $x1, 2, 'idTipo', 'Nombre', 'seg_vecinal_peligros_tipos', 0, '',$dbConn);
						$Form_Inputs->form_select_depend1('Ciudad','idCiudad', $x2, 2, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
														  'Comuna','idComuna', $x3, 2, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0, 
														  $dbConn, 'form1');
						$Form_Inputs->form_input_icon('Direccion', 'Direccion', $x4, 2,'fa fa-map');
						$Form_Inputs->form_input_disabled('Direccion Encontrada', 'Direccion_fake', $x4);
						//$Form_Inputs->form_input_disabled('Latitud', 'Latitud_fake', $nlat);
						//$Form_Inputs->form_input_disabled('Longitud', 'Longitud_fake', $nlong);
						$Form_Inputs->form_textarea('Descripcion', 'Descripcion', $x5, 2);
						$Form_Inputs->form_select('Estado','idEstado', $x6, 1, 'idEstado', 'Nombre', 'core_estados', 0, '',$dbConn);
				
						
						
						$Form_Inputs->form_input_hidden('GeoLatitud', $nlat, 2);
						$Form_Inputs->form_input_hidden('GeoLongitud', $nlong, 2);
						$Form_Inputs->form_input_hidden('idSistema', simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()), 2);		
						$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);		
						$Form_Inputs->form_input_hidden('idPeligro', $_GET['id'], 2);
				
						
						?>
						
						<script>
							/* ************************************************************************** */
							document.getElementById("Direccion").onkeyup = function() {myFunction_Direccion()};
							function myFunction_Direccion() {
								var direccion = document.getElementById("Direccion").value;
								if (direccion != "") {
									var e1 = document.getElementById("idCiudad");
									var e2 = document.getElementById("idComuna");
									
									var Ciudad = e1.options[e1.selectedIndex].text;
									var Comuna = e2.options[e2.selectedIndex].text;
													
									result=direccion+', '+Comuna+', '+Ciudad;
									
									codeAddress(result);
										
								}
							}
							/* ************************************************************************** */
							function codeAddress(x_direccion) {
								
								geocoder.geocode( { 'address': x_direccion}, function(results, status) {
									if (status == google.maps.GeocoderStatus.OK) {
										
										// marker position
										var myLatlng = new google.maps.LatLng(results[0].geometry.location.lat(), results[0].geometry.location.lng());
										marker.setPosition(myLatlng);
										map.panTo(myLatlng);
										
										document.getElementById("GeoLatitud").value     = results[0].geometry.location.lat();
										document.getElementById("GeoLongitud").value    = results[0].geometry.location.lng();
										//document.getElementById("Latitud_fake").value   = results[0].geometry.location.lat();
										//document.getElementById("Longitud_fake").value  = results[0].geometry.location.lng();
										document.getElementById("Direccion_fake").value = x_direccion;
														  
									} else {
										alert('Geocode was not successful for the following reason: ' + status);
									}
								});
							}
						</script>

						<div class="form-group">
							<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Actualizar" name="submit_update"> 
						</div>
							  
					</form>
					<?php widget_validator(); ?>
					
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

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

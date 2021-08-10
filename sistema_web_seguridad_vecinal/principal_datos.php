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
$original = "principal_datos.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos Personales';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit_edit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_clientes_listado.php';
}
//se borra un dato
if ( !empty($_GET['confirm']) )     {
	//Llamamos al formulario
	$form_trabajo= 'confirm';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_clientes_listado.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Perfil creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Perfil editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Perfil borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['mod']) ) {  
// Se traen todos los datos de mi usuario
$query = "SELECT GeoLatitud, GeoLongitud, Direccion
FROM `seg_vecinal_clientes_listado`
WHERE idCliente = '".$_SESSION['usuario']['basic_data']['idCliente']."'";
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

//informacion
echo '<div class="col-sm-12">';
$Alert_Text  = 'Pone el cursor del mouse sobre el marcador  <img src="'.DB_SITE_REPO.'/LIB_assets/img/map-icons/2_casa.png" alt="marcador" width="33" height="44">  y arrastralo hasta la posicion correcta';
alert_post_data(1,3,3, $Alert_Text);
echo '</div>';	 
?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Modificar Posicion</h5>	
		</header>
		<div class="table-responsive">
			
			<div class="col-sm-8">
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
							$nlat = '-33.4372';
						}
						
						if(isset($rowdata['GeoLongitud']) && $rowdata['GeoLongitud']!='' && $rowdata['GeoLongitud']!=0){
							$nlong = $rowdata['GeoLongitud'];
						}else{
							$nlong = '-70.6506';
						}
						
						?>
						<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google; ?>&sensor=false&libraries=places"></script>
						
						<input id="pac-input" class="pac-controls" type="text" placeholder="Buscar Direccion">
						<div id="map_canvas" style="width: 100%; height: 550px;"></div>
						

						<script>

							var map;
							var marker;
							/* ************************************************************************** */
							function initialize() {
								var myLatlng = new google.maps.LatLng(<?php echo $nlat; ?>, <?php echo $nlong; ?>);

								var myOptions = {
									zoom: 18,
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
									icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/2_casa.png"
								});
							
								google.maps.event.addListener(marker, 'dragend', function (event) {

									document.getElementById("GeoLatitud").value = event.latLng.lat();
									document.getElementById("GeoLongitud").value = event.latLng.lng();
									document.getElementById("Latitud_fake").value = event.latLng.lat();
									document.getElementById("Longitud_fake").value = event.latLng.lng();
			

								});
								
								//Se define el cuadro de busqueda
								var searchBox = new google.maps.places.SearchBox(document.getElementById('pac-input'));
								map.controls[google.maps.ControlPosition.TOP_CENTER].push(document.getElementById('pac-input'));
								google.maps.event.addListener(searchBox, 'places_changed', function() {
									searchBox.set('map', null);

									var places = searchBox.getPlaces();

									var bounds = new google.maps.LatLngBounds();
									var i, place;
									for (i = 0; place = places[i]; i++) {
										(function(place) {

											var myLatlng = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());
											marker.setPosition(myLatlng);
													 
											bounds.extend(place.geometry.location);
				
											document.getElementById("GeoLatitud").value = place.geometry.location.lat();
											document.getElementById("GeoLongitud").value = place.geometry.location.lng();
											document.getElementById("Latitud_fake").value = place.geometry.location.lat();
											document.getElementById("Longitud_fake").value = place.geometry.location.lng();
																			

										}(place));	

									}
										 
									map.fitBounds(bounds);
									searchBox.set('map', map);
									map.setZoom(Math.min(map.getZoom(),12));

								});

							}
							/* ************************************************************************** */
							google.maps.event.addDomListener(window, "load", initialize());
						</script>
					
					<?php } ?>
				</div>
			</div>
			
			<div class="col-sm-4">
				<div style="margin-top:20px;">
					<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
				
						<?php 
						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_input_icon('Direccion', 'Direccion_fake', $rowdata['Direccion'], 1,'fa fa-map');
						$Form_Inputs->form_input_disabled('Latitud', 'Latitud_fake', $rowdata['GeoLatitud'], 1);
						$Form_Inputs->form_input_disabled('Longitud', 'Longitud_fake', $rowdata['GeoLongitud'], 1);
						
						
						$Form_Inputs->form_input_hidden('GeoLatitud', $rowdata['GeoLatitud'], 2);
						$Form_Inputs->form_input_hidden('GeoLongitud', $rowdata['GeoLongitud'], 2);
						$Form_Inputs->form_input_hidden('idNuevo', 1, 2);
						$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);		
						?>

						<div class="form-group">
							<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar" name="submit_edit"> 
						</div>
							  
					</form>
					<?php widget_validator(); ?>
					
				</div>
			</div>
			
		</div>	
		
		
   
	</div>
</div>	
	
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
}else{
// Se traen todos los datos de mi usuario
$query = "SELECT  
seg_vecinal_clientes_listado.email, 
seg_vecinal_clientes_listado.Nombre, 
seg_vecinal_clientes_listado.Rut, 
seg_vecinal_clientes_listado.RazonSocial, 
seg_vecinal_clientes_listado.fNacimiento, 
seg_vecinal_clientes_listado.Direccion, 
seg_vecinal_clientes_listado.Fono1, 
seg_vecinal_clientes_listado.Fono2, 
seg_vecinal_clientes_listado.Fax,
seg_vecinal_clientes_listado.PersonaContacto,
seg_vecinal_clientes_listado.PersonaContacto_Fono,
seg_vecinal_clientes_listado.PersonaContacto_email,
seg_vecinal_clientes_listado.Web,
seg_vecinal_clientes_listado.Giro,
seg_vecinal_clientes_listado.idTipo,
seg_vecinal_clientes_listado.GeoLatitud,
seg_vecinal_clientes_listado.GeoLongitud,
seg_vecinal_clientes_listado.Direccion_img,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
core_estados.Nombre AS estado,
core_sistemas.Nombre AS sistema,
seg_vecinal_clientes_tipos.Nombre AS tipoVecino,
core_rubros.Nombre AS Rubro,
seg_vecinal_clientes_listado.idCompartir,
core_seguridad_opciones_comparticion.Nombre AS Compartir

FROM `seg_vecinal_clientes_listado`
LEFT JOIN `core_estados`                           ON core_estados.idEstado                             = seg_vecinal_clientes_listado.idEstado
LEFT JOIN `core_ubicacion_ciudad`                  ON core_ubicacion_ciudad.idCiudad                    = seg_vecinal_clientes_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`                 ON core_ubicacion_comunas.idComuna                   = seg_vecinal_clientes_listado.idComuna
LEFT JOIN `core_sistemas`                          ON core_sistemas.idSistema                           = seg_vecinal_clientes_listado.idSistema
LEFT JOIN `seg_vecinal_clientes_tipos`             ON seg_vecinal_clientes_tipos.idTipo                 = seg_vecinal_clientes_listado.idTipo
LEFT JOIN `core_rubros`                            ON core_rubros.idRubro                               = seg_vecinal_clientes_listado.idRubro
LEFT JOIN `core_seguridad_opciones_comparticion`   ON core_seguridad_opciones_comparticion.idCompartir  = seg_vecinal_clientes_listado.idCompartir
WHERE seg_vecinal_clientes_listado.idCliente = '".$_SESSION['usuario']['basic_data']['idCliente']."'";
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

?>

<style>.tab-content {min-height: 250px !important;}</style>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Vecino', $rowdata['Nombre'], 'Resumen');?>
</div>
<div class="clearfix"></div> 

<?php
/****************************************************************************/
//mensaje en caso de no haber aceptado la ubicacion
if(isset($_SESSION['usuario']['basic_data']['idNuevo'])&&$_SESSION['usuario']['basic_data']['idNuevo']==0){
	echo '<div class="col-sm-12">';
	$Alert_Text  = '<strong>Confirmar la direccion: </strong> ';
	$Alert_Text .= 'si la ubicacion mostrada es correcta presionar <strong>Confirmar Ubicacion</strong>, si no es asi presionar <strong>Modificar Ubicacion</strong>';
	$Alert_Text .= '<a href="principal_datos.php?mod=true" title="Modificar Ubicacion" class="btn btn-primary btn-sm pull-right margin_width" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Modificar Ubicacion</a>';
	$Alert_Text .= '<a href="principal_datos.php?confirm=true" title="Confirmar Ubicacion" class="btn btn-success btn-sm pull-right" ><i class="fa fa-check" aria-hidden="true"></i> Confirmar Ubicacion</a>';
	alert_post_data(2,1,2, $Alert_Text);
	echo '</div>';
} ?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'principal_datos.php';?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php';?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_mapa.php';?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicacion Mapa</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos_contacto.php';?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'principal_datos_datos_imagen.php';?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Imagen Perfil</a></li>
						<li class=""><a href="<?php echo 'principal_datos_datos_persona_contacto.php';?>" ><i class="fa fa-volume-control-phone" aria-hidden="true"></i> Persona Contacto</a></li>
						<?php if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){?>
							<li class=""><a href="<?php echo 'principal_datos_datos_comerciales.php';?>" ><i class="fa fa-usd" aria-hidden="true"></i> Datos Comerciales</a></li>
						<?php } ?>
						<li class=""><a href="<?php echo 'principal_datos_datos_password.php';?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>           
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="col-sm-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-sm-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Imagen de Perfil</h2>
							<div class="row">
								<div class="col-sm-4">
									<?php
									if (isset($rowdata['Direccion_img'])&&$rowdata['Direccion_img']=='') {
										echo '<img alt="User Picture" src="'.DB_SITE_REPO.'/LIB_assets/img/usr.png">';
									}else{
										echo '<img alt="User Picture" src="'.DB_SITE_ALT_1.'/upload/'.$rowdata['Direccion_img'].'" width="100%" class="img-thumbnail" >';
									}
									?>
								</div>
							</div>
							
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Basicos</h2>
							<p class="text-muted word_break">
								<strong>Tipo de Vecino : </strong><?php echo $rowdata['tipoVecino']; ?><br/>
								<?php 
								//Si el cliente es una empresa
								if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){?>
									<strong>Nombre Fantasia: </strong><?php echo $rowdata['Nombre']; ?><br/>
								<?php 
								//si es una persona
								}else{ ?>
									<strong>Nombre: </strong><?php echo $rowdata['Nombre']; ?><br/>
									<strong>Rut : </strong><?php echo $rowdata['Rut']; ?><br/>
								<?php } ?>
								<strong>Fecha de Ingreso Sistema : </strong><?php echo Fecha_completa($rowdata['fNacimiento']); ?><br/>
								<strong>Region : </strong><?php echo $rowdata['nombre_region']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowdata['nombre_comuna']; ?><br/>
								<strong>Direccion : </strong><?php echo $rowdata['Direccion']; ?><br/>
								<strong>Sistema Relacionado : </strong><?php echo $rowdata['sistema']; ?><br/>
								<strong>Estado : </strong><?php echo $rowdata['estado']; ?>
							</p>
									
							<?php 
							//Si el cliente es una empresa
							if(isset($rowdata['idTipo'])&&$rowdata['idTipo']==1){?>
								<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Comerciales</h2>
								<p class="text-muted">
									<strong>Rut : </strong><?php echo $rowdata['Rut']; ?><br/>
									<strong>Razon Social : </strong><?php echo $rowdata['RazonSocial']; ?><br/>
									<strong>Giro de la empresa: </strong><?php echo $rowdata['Giro']; ?><br/>
									<strong>Rubro : </strong><?php echo $rowdata['Rubro']; ?><br/>
								</p>
							<?php } ?>
										
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de Contacto</h2>
							<p class="text-muted">
								<strong>Compartir Datos de Contacto : </strong><label class="label <?php if(isset($rowdata['idCompartir'])&&$rowdata['idCompartir']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $rowdata['Compartir']; ?></label><br/>
								<strong>Telefono Fijo : </strong><?php echo $rowdata['Fono1']; ?><br/>
								<strong>Telefono Movil : </strong><?php echo $rowdata['Fono2']; ?><br/>
								<strong>Fax : </strong><?php echo $rowdata['Fax']; ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowdata['email']; ?>"><?php echo $rowdata['email']; ?></a><br/>
								<strong>Web : </strong><a target="_blank" rel="noopener noreferrer" href="https://<?php echo $rowdata['Web']; ?>"><?php echo $rowdata['Web']; ?></a>
							</p>
									
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Persona de Contacto</h2>
							<p class="text-muted">
								<strong>Persona de Contacto : </strong><?php echo $rowdata['PersonaContacto']; ?><br/>
								<strong>Telefono : </strong><?php echo $rowdata['PersonaContacto_Fono']; ?><br/>
								<strong>Email : </strong><a href="mailto:<?php echo $rowdata['PersonaContacto_email']; ?>"><?php echo $rowdata['PersonaContacto_email']; ?></a><br/>
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<?php 
						//se arma la direccion
						$direccion = "";
						if(isset($rowdata["Direccion"])&&$rowdata["Direccion"]!=''){           $direccion .= $rowdata["Direccion"];}
						if(isset($rowdata["nombre_comuna"])&&$rowdata["nombre_comuna"]!=''){   $direccion .= ', '.$rowdata["nombre_comuna"];}
						if(isset($rowdata["nombre_region"])&&$rowdata["nombre_region"]!=''){   $direccion .= ', '.$rowdata["nombre_region"];}
						//se despliega mensaje en caso de no existir direccion
						if($direccion!=''){
							echo mapa_from_gps($rowdata['GeoLatitud'], $rowdata['GeoLongitud'], 'Direccion', 'Calle', $direccion, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 2);
						}else{
							$Alert_Text = 'No tiene una direccion definida';
							alert_post_data(4,2,2, $Alert_Text);
						}
						?>
					</div>
				</div>
				<div class="clearfix"></div>
			
			</div>
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

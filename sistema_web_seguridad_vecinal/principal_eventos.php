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
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//Cargamos la ubicacion 
$original = "principal_eventos.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-flag" aria-hidden="true"></i> Mis Eventos';
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){                              $location .= "&idTipo=".$_GET['idTipo'];                              $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['DescripcionTipo']) && $_GET['DescripcionTipo'] != ''){            $location .= "&DescripcionTipo=".$_GET['DescripcionTipo'];            $search .= "&DescripcionTipo=".$_GET['DescripcionTipo'];}
if(isset($_GET['idCiudad']) && $_GET['idCiudad'] != ''){                          $location .= "&idCiudad=".$_GET['idCiudad'];                          $search .= "&idCiudad=".$_GET['idCiudad'];}
if(isset($_GET['idComuna']) && $_GET['idComuna'] != ''){                          $location .= "&idComuna=".$_GET['idComuna'];                          $search .= "&idComuna=".$_GET['idComuna'];}
if(isset($_GET['Direccion']) && $_GET['Direccion'] != ''){                        $location .= "&Direccion=".$_GET['Direccion'];                        $search .= "&Direccion=".$_GET['Direccion'];}
if(isset($_GET['Fecha']) && $_GET['Fecha'] != ''){                                $location .= "&Fecha=".$_GET['Fecha'];                                $search .= "&Fecha=".$_GET['Fecha'];}
if(isset($_GET['Hora']) && $_GET['Hora'] != ''){                                  $location .= "&Hora=".$_GET['Hora'];                                  $search .= "&Hora=".$_GET['Hora'];}
if(isset($_GET['DescripcionSituacion']) && $_GET['DescripcionSituacion'] != ''){  $location .= "&DescripcionSituacion=".$_GET['DescripcionSituacion'];  $search .= "&DescripcionSituacion=".$_GET['DescripcionSituacion'];}
/**********************************************************************************************************************************/
/*                                               Ejecucion de los formularios                                                     */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit_new']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/seg_vecinal_eventos_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Evento Creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Evento Modificado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Evento borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['id']) ) { 
// consulto los datos
$query = "SELECT  
seg_vecinal_eventos_listado.Direccion,
seg_vecinal_eventos_listado.GeoLatitud,
seg_vecinal_eventos_listado.GeoLongitud,
seg_vecinal_eventos_listado.Fecha,
seg_vecinal_eventos_listado.Hora,
seg_vecinal_eventos_listado.DescripcionTipo,
seg_vecinal_eventos_listado.DescripcionSituacion,

seg_vecinal_eventos_tipos.Nombre AS Tipo,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna

FROM `seg_vecinal_eventos_listado`
LEFT JOIN `seg_vecinal_eventos_tipos`  ON seg_vecinal_eventos_tipos.idTipo  = seg_vecinal_eventos_listado.idTipo
LEFT JOIN `core_ubicacion_ciudad`      ON core_ubicacion_ciudad.idCiudad    = seg_vecinal_eventos_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`     ON core_ubicacion_comunas.idComuna   = seg_vecinal_eventos_listado.idComuna

WHERE seg_vecinal_eventos_listado.idEvento = ".simpleDecode($_GET['id'], fecha_actual());
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
$N_Archivos = db_select_nrows (false, 'Nombre', 'seg_vecinal_eventos_listado_archivos', '', "idEvento='".simpleDecode($_GET['id'], fecha_actual())."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'N_Archivos');
?>

<style>.tab-content {min-height: 250px !important;}</style>

<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Evento', $rowdata['Tipo'], 'Resumen');?>
</div>
<div class="clearfix"></div> 



<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'principal_eventos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-flag" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_eventos_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar Datos</a></li>
				<li class=""><a href="<?php echo 'principal_eventos_archivos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id'];?>" ><i class="fa fa-file-archive-o" aria-hidden="true"></i> Archivos Adjuntos <span class="label label-danger"><?php echo $N_Archivos; ?></span></a></li>          
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="col-sm-6">
					<div class="row" style="border-right: 1px solid #333;">
						<div class="col-sm-12">
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos del Evento</h2>
							<p class="text-muted word_break">
								<strong>Tipo de Evento : </strong><?php echo $rowdata['Tipo']; ?><br/>
								<strong>Caracteristicas Agresor : </strong><?php echo $rowdata['DescripcionTipo']; ?><br/>
								<strong>Ciudad : </strong><?php echo $rowdata['Ciudad']; ?><br/>
								<strong>Comuna : </strong><?php echo $rowdata['Comuna']; ?><br/>
								<strong>Direccion : </strong><?php echo $rowdata['Direccion']; ?><br/>
								<strong>Fecha : </strong><?php echo fecha_estandar($rowdata['Fecha']); ?><br/>
								<strong>Hora : </strong><?php echo $rowdata['Hora']; ?><br/>
								<strong>Descripcion Situacion : </strong><?php echo $rowdata['DescripcionSituacion']; ?><br/>
							</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="row">
						<?php 
						//se arma la direccion
						$direccion = "";
						if(isset($rowdata["Direccion"])&&$rowdata["Direccion"]!=''){   $direccion .= $rowdata["Direccion"];}
						if(isset($rowdata["Comuna"])&&$rowdata["Comuna"]!=''){         $direccion .= ', '.$rowdata["Comuna"];}
						if(isset($rowdata["Ciudad"])&&$rowdata["Ciudad"]!=''){         $direccion .= ', '.$rowdata["Ciudad"];}
						//se despliega mensaje en caso de no existir direccion
						if($direccion!=''){
							echo mapa_from_gps($rowdata['GeoLatitud'], $rowdata['GeoLongitud'], 'Evento', 'Calle', $direccion, $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 19, 2);
						}else{
							$Alert_Text = 'No tiene una direccion definida';
							alert_post_data(4,2,2, $Alert_Text);
						} ?>
					</div>
				</div>
				<div class="clearfix"></div>
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
 } elseif ( ! empty($_GET['new']) ) { 
//informacion
echo '<div class="col-sm-12">';
$Alert_Text  = 'Primero selecciona la ciudad, luego la comuna y por ultimo ingresa la direccion, 
en caso de que la ubicacion mostrada no sea correcta, pone el cursor del mouse sobre el marcador  
<img src="'.DB_SITE_REPO.'/LIB_assets/img/map-icons/2_evento_0.png" alt="marcador" width="33" height="44">  
, hazle click con el boton izquierdo del mouse y arrastralo hasta la posicion correcta para corregirla, 
en algunos casos Google Maps no muestra la direccion correcta (<strong>Direccion Encontrada</strong>).';
alert_post_data(1,3,3, $Alert_Text);
echo '</div>';	 
?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Crear Nuevo Evento</h5>	
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
						
						if(isset($_SESSION['usuario']['basic_data']['GeoLatitud']) && $_SESSION['usuario']['basic_data']['GeoLatitud']!='' && $_SESSION['usuario']['basic_data']['GeoLatitud']!=0){
							$nlat = $_SESSION['usuario']['basic_data']['GeoLatitud'];
						}else{
							$nlat = '-33.4372';
						}
						
						if(isset($_SESSION['usuario']['basic_data']['GeoLongitud']) && $_SESSION['usuario']['basic_data']['GeoLongitud']!='' && $_SESSION['usuario']['basic_data']['GeoLongitud']!=0){
							$nlong = $_SESSION['usuario']['basic_data']['GeoLongitud'];
						}else{
							$nlong = '-70.6506';
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
									icon      	:"<?php echo DB_SITE_REPO ?>/LIB_assets/img/map-icons/2_evento_0.png"
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
						if(isset($idTipo)) {               $x1 = $idTipo;                }else{$x1  = '';}
						if(isset($DescripcionTipo)) {      $x2 = $DescripcionTipo;       }else{$x2  = '';}
						if(isset($idCiudad)) {             $x3 = $idCiudad;              }else{$x3  = '';}
						if(isset($idComuna)) {             $x4 = $idComuna;              }else{$x4  = '';}
						if(isset($Direccion)) {            $x5 = $Direccion;             }else{$x5  = '';}
						if(isset($Fecha)) {                $x6 = $Fecha;                 }else{$x6  = '';}
						if(isset($Hora)) {                 $x7 = $Hora;                  }else{$x7  = '';}
						if(isset($DescripcionSituacion)) { $x8 = $DescripcionSituacion;  }else{$x8  = '';}
						
						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_select('Tipo de Evento','idTipo', $x1, 2, 'idTipo', 'Nombre', 'seg_vecinal_eventos_tipos', 0, '',$dbConn);
						$Form_Inputs->form_textarea('Caracteristicas Agresor', 'DescripcionTipo', $x2, 2);
						$Form_Inputs->form_select_depend1('Ciudad','idCiudad', $x3, 2, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
														  'Comuna','idComuna', $x4, 2, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0, 
														  $dbConn, 'form1');
						$Form_Inputs->form_input_icon('Direccion', 'Direccion', $x5, 2,'fa fa-map');
						$Form_Inputs->form_input_disabled('Direccion Encontrada', 'Direccion_fake', $x5);
						//$Form_Inputs->form_input_disabled('Latitud', 'Latitud_fake', $nlat);
						//$Form_Inputs->form_input_disabled('Longitud', 'Longitud_fake', $nlong);
						$Form_Inputs->form_date('Fecha','Fecha', $x6, 2);
						$Form_Inputs->form_time('Hora','Hora', $x7, 2, 1);
						$Form_Inputs->form_textarea('Descripcion Situacion', 'DescripcionSituacion', $x8, 2);
						
						$Form_Inputs->form_input_hidden('GeoLatitud', $nlat, 2);
						$Form_Inputs->form_input_hidden('GeoLongitud', $nlong, 2);
						$Form_Inputs->form_input_hidden('idSistema', simpleEncode($_SESSION['usuario']['basic_data']['idSistema'], fecha_actual()), 2);		
						$Form_Inputs->form_input_hidden('idCliente', simpleEncode($_SESSION['usuario']['basic_data']['idCliente'], fecha_actual()), 2);		
						$Form_Inputs->form_input_hidden('idValidado', simpleEncode(1, fecha_actual()), 2);		
						
						
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
							<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar" name="submit_new"> 
							<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>		
						</div>
							  
					</form>
					<?php widget_validator(); ?>
					
				</div>
			</div>
			
		</div>	
		
		
   
	</div>
</div>



<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
//Se inicializa el paginador de resultados
//tomo el numero de la pagina si es que este existe
if(isset($_GET["pagina"])){
	$num_pag = $_GET["pagina"];	
} else {
	$num_pag = 1;	
}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){
	$comienzo = 0 ;
	$num_pag = 1 ;
} else {
	$comienzo = ( $num_pag - 1 ) * $cant_reg ;
}
/**********************************************************/
//Variable de busqueda
$z = "WHERE seg_vecinal_eventos_listado.idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){                              $z .= " AND seg_vecinal_eventos_listado.idTipo='".$_GET['idTipo']."'";}
if(isset($_GET['DescripcionTipo']) && $_GET['DescripcionTipo'] != ''){            $z .= " AND seg_vecinal_eventos_listado.DescripcionTipo LIKE '%".$_GET['DescripcionTipo']."%'";}
if(isset($_GET['idCiudad']) && $_GET['idCiudad'] != ''){                          $z .= " AND seg_vecinal_eventos_listado.idCiudad='".$_GET['idCiudad']."'";}
if(isset($_GET['idComuna']) && $_GET['idComuna'] != ''){                          $z .= " AND seg_vecinal_eventos_listado.idComuna='".$_GET['idComuna']."'";}
if(isset($_GET['Direccion']) && $_GET['Direccion'] != ''){                        $z .= " AND seg_vecinal_eventos_listado.Direccion='".$_GET['Direccion']."'";}
if(isset($_GET['Fecha']) && $_GET['Fecha'] != ''){                                $z .= " AND seg_vecinal_eventos_listado.Fecha='".$_GET['Fecha']."'";}
if(isset($_GET['Hora']) && $_GET['Hora'] != ''){                                  $z .= " AND seg_vecinal_eventos_listado.Hora='".$_GET['Hora']."'";}
if(isset($_GET['DescripcionSituacion']) && $_GET['DescripcionSituacion'] != ''){  $z .= " AND seg_vecinal_eventos_listado.DescripcionSituacion LIKE '%".$_GET['DescripcionSituacion']."%'";}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idEvento FROM `seg_vecinal_eventos_listado` ".$z;
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
$cuenta_registros = mysqli_num_rows($resultado);
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);	
// Se trae un listado con todos los elementos
$arrEventos = array();
$query = "SELECT 
seg_vecinal_eventos_listado.idEvento,
seg_vecinal_eventos_listado.Direccion,
seg_vecinal_eventos_listado.Fecha,
seg_vecinal_eventos_listado.Hora,

seg_vecinal_eventos_tipos.Nombre AS Tipo,
core_ubicacion_ciudad.Nombre AS Ciudad,
core_ubicacion_comunas.Nombre AS Comuna

FROM `seg_vecinal_eventos_listado`
LEFT JOIN `seg_vecinal_eventos_tipos`  ON seg_vecinal_eventos_tipos.idTipo  = seg_vecinal_eventos_listado.idTipo
LEFT JOIN `core_ubicacion_ciudad`      ON core_ubicacion_ciudad.idCiudad    = seg_vecinal_eventos_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`     ON core_ubicacion_comunas.idComuna   = seg_vecinal_eventos_listado.idComuna
".$z."
ORDER BY seg_vecinal_eventos_listado.Fecha DESC, seg_vecinal_eventos_listado.Hora DESC
LIMIT $comienzo, $cant_reg ";
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
array_push( $arrEventos,$row );
}

/*******************************************************************************/
//cuento los eventos
$n_Evento     = db_select_nrows (false, 'idEvento', 'seg_vecinal_eventos_listado', '', "idCliente='".$_SESSION['usuario']['basic_data']['idCliente']."' AND FechaCreacion='".fecha_actual()."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, 'n_Evento');
$n_max_evento = 3;
?>

<div class="col-sm-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Presionar para desplegar Formulario de Busqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente</li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>		
	</ul>
	
	<?php if($n_Evento<=$n_max_evento){ ?>
		<a href="<?php echo $location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Evento</a>
	<?php } ?>	
	
</div>
<div class="clearfix"></div> 
<div class="collapse col-sm-12" id="collapseExample">
	<div class="well">
		<div class="col-sm-8 fcenter" style="min-height:500px;">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
				<?php 
				//Se verifican si existen los datos
				if(isset($idTipo)) {      $x1 = $idTipo;      }else{$x1  = '';}
				if(isset($idCiudad)) {    $x2 = $idCiudad;    }else{$x2  = '';}
				if(isset($idComuna)) {    $x3 = $idComuna;    }else{$x3  = '';}
				if(isset($Direccion)) {   $x4 = $Direccion;   }else{$x4  = '';}
				if(isset($Fecha)) {       $x5 = $Fecha;       }else{$x5  = '';}
				if(isset($Hora)) {        $x6 = $Hora;        }else{$x6  = '';}
						
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Tipo de Evento','idTipo', $x1, 1, 'idTipo', 'Nombre', 'seg_vecinal_eventos_tipos', 0, '',$dbConn);
				$Form_Inputs->form_select_depend1('Ciudad','idCiudad', $x2, 1, 'idCiudad', 'Nombre', 'core_ubicacion_ciudad', 0, 0,
												  'Comuna','idComuna', $x3, 1, 'idComuna', 'Nombre', 'core_ubicacion_comunas', 0, 0, 
												  $dbConn, 'form1');
				$Form_Inputs->form_input_icon('Direccion', 'Direccion', $x4, 1,'fa fa-map');
				$Form_Inputs->form_date('Fecha','Fecha', $x5, 1);
				$Form_Inputs->form_time('Hora','Hora', $x6, 1, 1);
						
				$Form_Inputs->form_input_hidden('pagina', $_GET['pagina'], 1);
				?>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf002; Filtrar" name="filtro_form">
					<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
				</div>
                      
			</form> 
            <?php widget_validator(); ?>
        </div>
	</div>
</div>
<div class="clearfix"></div> 
                                 
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Eventos</h5>
			<div class="toolbar">
				<?php 
				//paginacion
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">    
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Tipo</th>
						<th>Ubicacion</th>
						<th>Fecha</th>
						<th>Hora</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrEventos as $eve) { ?>
						<tr class="odd">
							<td><?php echo $eve['Tipo']; ?></td>
							<td><?php echo $eve['Direccion'].', '.$eve['Comuna'].', '.$eve['Ciudad']; ?></td>
							<td><?php echo fecha_estandar($eve['Fecha']); ?></td>
							<td><?php echo $eve['Hora']; ?></td>
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo 'view_evento_listado.php?view='.simpleEncode($eve['idEvento'], fecha_actual()); ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&id='.simpleEncode($eve['idEvento'], fecha_actual()); ?>" title="Editar Informacion" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php } ?>                    
				</tbody>
			</table>
		</div>
		<div class="pagrow">	
			<?php 
			//paginacion
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
		</div>
	</div>
</div>

<?php widget_modal(80, 95); ?>
<?php } ?>           
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

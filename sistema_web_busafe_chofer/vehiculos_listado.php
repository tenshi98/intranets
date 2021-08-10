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
$original = "vehiculos_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){        $location .= "&Nombre=".$_GET['Nombre'];        $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){        $location .= "&idTipo=".$_GET['idTipo'];        $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Marca']) && $_GET['Marca'] != ''){          $location .= "&Marca=".$_GET['Marca'];          $search .= "&Marca=".$_GET['Marca'];}
if(isset($_GET['Modelo']) && $_GET['Modelo'] != ''){        $location .= "&Modelo=".$_GET['Modelo'];        $search .= "&Modelo=".$_GET['Modelo'];}
if(isset($_GET['Patente']) && $_GET['Patente'] != ''){      $location .= "&Patente=".$_GET['Patente'];      $search .= "&Patente=".$_GET['Patente'];}
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Vehiculos';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_listado.php';
}
//se borra un dato
if ( !empty($_GET['del']) )     {
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/vehiculos_listado.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Vehiculo Creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Vehiculo Modificado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Vehiculo borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['id']) ) { 
// Se traen todos los datos del trabajador
$query = "SELECT 
vehiculos_listado.Direccion_img,

vehiculos_listado.Nombre,
vehiculos_listado.Marca,
vehiculos_listado.Modelo, 
vehiculos_listado.Num_serie, 
vehiculos_listado.AnoFab, 
vehiculos_listado.Patente, 
vehiculos_listado.Password,
vehiculos_listado.idOpciones_4, 
vehiculos_listado.idOpciones_5,
vehiculos_listado.idOpciones_6,
vehiculos_listado.idOpciones_8,
vehiculos_listado.CapacidadPersonas,



vehiculos_listado.doc_mantencion,
vehiculos_listado.doc_padron,
vehiculos_listado.doc_permiso_circulacion,
vehiculos_listado.doc_revision_tecnica,
vehiculos_listado.doc_soap,
vehiculos_listado.doc_cert_trans_personas,
vehiculos_listado.doc_ficha_tecnica,

vehiculos_listado.doc_fecha_mantencion,
vehiculos_listado.doc_fecha_permiso_circulacion,
vehiculos_listado.doc_fecha_revision_tecnica,
vehiculos_listado.doc_fecha_soap,
vehiculos_listado.doc_fecha_cert_trans_personas,


core_estados.Nombre AS Estado,
vehiculos_tipo.Nombre AS Tipo,
trabajadores_listado.Nombre AS TrabajadorNombre,
trabajadores_listado.ApellidoPat AS TrabajadorApellidoPat,
trabajadores_listado.ApellidoMat AS TrabajadorApellidoMat,
core_estado_aprobacion_vehiculos.Nombre AS AprobacionEstado,
vehiculos_listado.Motivo AS AprobacionMotivo,
vehiculos_listado.idProceso

FROM `vehiculos_listado`
LEFT JOIN `core_estados`                       ON core_estados.idEstado                       = vehiculos_listado.idEstado
LEFT JOIN `vehiculos_tipo`                     ON vehiculos_tipo.idTipo                       = vehiculos_listado.idTipo
LEFT JOIN `trabajadores_listado`               ON trabajadores_listado.idTrabajador           = vehiculos_listado.idTrabajador
LEFT JOIN `core_estado_aprobacion_vehiculos`   ON core_estado_aprobacion_vehiculos.idProceso  = vehiculos_listado.idProceso

WHERE vehiculos_listado.idVehiculo = ".$_GET['id'];
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);

if(isset($rowdata['idOpciones_5'])&&$rowdata['idOpciones_5']==1){
	/********************************************************/
	// Se trae un listado con todas las cargas familiares
	$arrPasajerosIda = array();
	$query = "SELECT  
	apoderados_listado_hijos.Nombre, 
	apoderados_listado_hijos.ApellidoPat, 
	apoderados_listado_hijos.ApellidoMat,
	apoderados_listado_hijos.Direccion_img,
	core_sexo.Nombre AS Sexo

	FROM `apoderados_listado_hijos`
	LEFT JOIN `core_sexo`       ON core_sexo.idSexo       = apoderados_listado_hijos.idSexo
	WHERE apoderados_listado_hijos.idVehiculo =  ".$_GET['id']."
	ORDER BY apoderados_listado_hijos.idHijos ASC ";
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
	array_push( $arrPasajerosIda,$row );
	}
	
	/********************************************************/
	// Se trae un listado con todas las cargas familiares
	$arrPasajerosVuelta = array();
	$query = "SELECT  
	apoderados_listado_hijos.Nombre, 
	apoderados_listado_hijos.ApellidoPat, 
	apoderados_listado_hijos.ApellidoMat,
	apoderados_listado_hijos.Direccion_img,
	core_sexo.Nombre AS Sexo

	FROM `apoderados_listado_hijos`
	LEFT JOIN `core_sexo`       ON core_sexo.idSexo       = apoderados_listado_hijos.idSexo
	WHERE apoderados_listado_hijos.idVehiculoVuelta =  ".$_GET['id']."
	ORDER BY apoderados_listado_hijos.idHijos ASC ";
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
	array_push( $arrPasajerosVuelta,$row );
	}
	
}


if(isset($rowdata['idOpciones_8'])&&$rowdata['idOpciones_8']==1){
	// Se trae un listado con todos los colegios
	$arrColegios = array();
	$query = "SELECT 
	colegios_listado.Nombre
	
	FROM `vehiculos_listado_colegios`
	LEFT JOIN `colegios_listado` ON colegios_listado.idColegio = vehiculos_listado_colegios.idColegio
	WHERE vehiculos_listado_colegios.idVehiculo = ".$_GET['id']."
	ORDER BY colegios_listado.Nombre ASC ";
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
	array_push( $arrColegios,$row );
	}
}


?>
<div class="col-sm-12">
	<?php 
	$vehiculo = $rowdata['Nombre'];
	if(isset($rowdata['Patente'])&&$rowdata['Patente']!=''){
		$vehiculo .= ' Patente '.$rowdata['Patente'];
	}
	echo widget_title('bg-aqua', 'fa-cog', 100, 'Vehiculo', $vehiculo, 'Resumen');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'vehiculos_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'vehiculos_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'vehiculos_listado_opc_4.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" >Chofer</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_password.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-key" aria-hidden="true"></i> Password APP</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_colegios.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-graduation-cap" aria-hidden="true"></i> Colegios</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-picture-o" aria-hidden="true"></i>  Foto</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_padron.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Padron</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_permiso_circulacion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Permiso Circulacion</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_soap.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - SOAP</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_revision_tecnica.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Revision Tecnica</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_mantencion.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Mantenciones</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_trans_personas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Cert. Transporte Personas</a></li>
						<li class=""><a href="<?php echo 'vehiculos_listado_doc_ficha.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Ficha Tecnica</a></li>
						
					</ul>
                </li>           
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">
					
					<div class="col-sm-4">
						<?php if ($rowdata['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/car_siluete.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_ALT_1; ?>/upload/<?php echo $rowdata['Direccion_img']; ?>">
						<?php }?>
					</div>
					<div class="col-sm-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Basicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowdata['Nombre']; ?><br/>
							<strong>Tipo : </strong><?php echo $rowdata['Tipo']; ?><br/>
							<strong>Marca : </strong><?php echo $rowdata['Marca']; ?><br/>
							<strong>Modelo : </strong><?php echo $rowdata['Modelo']; ?><br/>
							<strong>Numero de serie : </strong><?php echo $rowdata['Num_serie']; ?><br/>
							<strong>Año de Fabricacion : </strong><?php echo $rowdata['AnoFab']; ?><br/>
							<strong>Patente : </strong><?php echo $rowdata['Patente']; ?><br/>
							<strong>Estado : </strong><?php echo $rowdata['Estado']; ?><br/>
							<strong>Capacidad Pasajeros : </strong><?php echo $rowdata['CapacidadPersonas']; ?>
							<?php
							//se verifica si trabajador esta activo y se muestra
							if(isset($rowdata['idOpciones_4'])&&$rowdata['idOpciones_4']==1){
								echo '<br/><strong>Chofer asignado: </strong>'.$rowdata['TrabajadorNombre'].' '.$rowdata['TrabajadorApellidoPat'].' '.$rowdata['TrabajadorApellidoMat'];
							}
							//se verifica el estado de aprobacion
							if(isset($rowdata['AprobacionEstado'])&&$rowdata['AprobacionEstado']!=''){
								echo '<br/><strong>Proceso Aprobacion: </strong>'.$rowdata['AprobacionEstado'];
								if(isset($rowdata['idProceso'])&&$rowdata['idProceso']==3){echo ' ('.$rowdata['AprobacionMotivo'].')';}
							}?>
						</p>
						
						<?php if(isset($rowdata['idOpciones_6'])&&$rowdata['idOpciones_6']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos de acceso a la APP</h2>
							<p class="text-muted">
								<strong>Usuario : </strong><?php echo $rowdata['Patente']; ?><br/>
								<strong>Password : </strong><?php echo $rowdata['Password']; ?><br/>
							</p>
						<?php } ?>
						
						
						<?php 
						//se verifica si se transportan personas
						if(isset($rowdata['idOpciones_5'])&&$rowdata['idOpciones_5']==1){ 
							/*****************************************/
							//Verifico el total de cargas
							$nn1 = 0;
							$nn2 = 0;
							foreach ($arrPasajerosIda as $carga) { $nn1++; }
							foreach ($arrPasajerosVuelta as $carga) { $nn2++; }
							?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Pasajeros Viaje Ida</h2>
							<div class="row">
								<?php
								/*****************************************/
								//Se existen cargas estas se despliegan
								if($nn1!=0){
									foreach ($arrPasajerosIda as $carga) { ?>
										<div class="col-md-6 col-sm-6 col-xs-12 fleft">
											<div class="info-box" style="box-shadow:none; color:#999 !important;">
												<span class="info-box-icon">
													 <img src="<?php echo DB_SITE_ALT_1; ?>/upload/<?php echo $carga['Direccion_img']; ?>" alt="hijo" height="100%" width="100%"> 
												</span>
												<div class="info-box-content">
													<span class="info-box-text"><?php echo $carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat']; ?></span>
													<span class="info-box-number"><?php echo $carga['Sexo']; ?></span>
												</div>
											</div>
										</div>
									
									<?php 
									}
								//si no existen cargas se muestra mensaje
								}else{
									echo '<p class="text-muted">Sin personas asignadas</p>';
								}
								?>	
							</div>		
							<div class="clearfix"></div>
							
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Pasajeros Viaje Vuelta</h2>
							<div class="row">
								<?php
								/*****************************************/
								//Se existen cargas estas se despliegan
								if($nn2!=0){
									foreach ($arrPasajerosVuelta as $carga) { ?>
										<div class="col-md-6 col-sm-6 col-xs-12 fleft">
											<div class="info-box" style="box-shadow:none; color:#999 !important;">
												<span class="info-box-icon">
													 <img src="<?php echo DB_SITE_ALT_1; ?>/upload/<?php echo $carga['Direccion_img']; ?>" alt="hijo" height="100%" width="100%"> 
												</span>
												<div class="info-box-content">
													<span class="info-box-text"><?php echo $carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat']; ?></span>
													<span class="info-box-number"><?php echo $carga['Sexo']; ?></span>
												</div>
											</div>
										</div>
									
									<?php 
									}
								//si no existen cargas se muestra mensaje
								}else{
									echo '<p class="text-muted">Sin personas asignadas</p>';
								}
								?>	
							</div>		
							<div class="clearfix"></div>
						<?php } ?>
						
						<?php //se verifica si se tiene colegios
						if(isset($rowdata['idOpciones_8'])&&$rowdata['idOpciones_8']==1){ ?>
							<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Colegios Asignados</h2>
							<table id="items" style="margin-bottom: 20px;">
								<tbody>
									<?php foreach ($arrColegios as $colegio) { ?>
										<tr class="item-row">
											<td><?php $colegio['NombreColegio']; ?></td>
										</tr>
									<?php } ?> 	
								</tbody>
							</table>
						<?php } ?>
						
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php 
								//Fecha ultima mantencion
								if(isset($rowdata['doc_mantencion'])&&$rowdata['doc_mantencion']!=''){
									echo '
										<tr class="item-row">
											<td>Fecha ultima mantencion (vence el '.fecha_estandar($rowdata['doc_fecha_mantencion']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_mantencion'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_mantencion'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Padron del Vehiculo
								if(isset($rowdata['doc_padron'])&&$rowdata['doc_padron']!=''){
									echo '
										<tr class="item-row">
											<td>Padron del Vehiculo</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_padron'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_padron'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Permiso de Circulacion
								if(isset($rowdata['doc_permiso_circulacion'])&&$rowdata['doc_permiso_circulacion']!=''){
									echo '
										<tr class="item-row">
											<td>Permiso de Circulacion (vence el '.fecha_estandar($rowdata['doc_fecha_permiso_circulacion']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_permiso_circulacion'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_permiso_circulacion'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Revision tecnica
								if(isset($rowdata['doc_revision_tecnica'])&&$rowdata['doc_revision_tecnica']!=''){
									echo '
										<tr class="item-row">
											<td>Revision tecnica (vence el '.fecha_estandar($rowdata['doc_fecha_revision_tecnica']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_revision_tecnica'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_revision_tecnica'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Seguro SOAP 
								if(isset($rowdata['doc_soap'])&&$rowdata['doc_soap']!=''){
									echo '
										<tr class="item-row">
											<td>Seguro SOAP (vence el '.fecha_estandar($rowdata['doc_fecha_soap']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_soap'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_soap'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Certificado Transporte Personas 
								if(isset($rowdata['doc_cert_trans_personas'])&&$rowdata['doc_cert_trans_personas']!=''){
									echo '
										<tr class="item-row">
											<td>Certificado Transporte Personas (vence el '.fecha_estandar($rowdata['doc_fecha_cert_trans_personas']).')</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_cert_trans_personas'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_cert_trans_personas'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Ficha Tecnica
								if(isset($rowdata['doc_ficha_tecnica'])&&$rowdata['doc_ficha_tecnica']!=''){
									echo '
										<tr class="item-row">
											<td>Ficha Tecnica</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_ficha_tecnica'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_ficha_tecnica'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								?>
							</tbody>
						</table>
						<?php widget_modal(80, 95); ?>	
							
							
										
					</div>	
					<div class="clearfix"></div>
			
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
 } elseif ( ! empty($_GET['new']) ) { ?>
 <div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Vehiculo</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
        	
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {       $x1  = $Nombre;       }else{$x1  = '';}
				if(isset($idTipo)) {       $x2  = $idTipo;       }else{$x2  = '';}
				if(isset($Marca)) {        $x3  = $Marca;        }else{$x3  = '';}
				if(isset($Modelo)) {       $x4  = $Modelo;       }else{$x4  = '';}
				if(isset($Patente)) {      $x5  = $Patente;      }else{$x5  = '';}
				if(isset($idSistema)) {    $x6  = $idSistema;    }else{$x6  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_select('Tipo de Vehiculo','idTipo', $x2, 2, 'idTipo', 'Nombre', 'vehiculos_tipo', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 2);
				$Form_Inputs->form_input_text('Modelo', 'Modelo', $x4, 2);
				$Form_Inputs->form_input_text('Patente', 'Patente', $x5, 2);
				

				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('idOpciones_1', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_2', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_3', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_4', 1, 2);
				$Form_Inputs->form_input_hidden('idOpciones_5', 1, 2);
				$Form_Inputs->form_input_hidden('idOpciones_6', 1, 2);
				$Form_Inputs->form_input_hidden('idOpciones_7', 2, 2);
				$Form_Inputs->form_input_hidden('idOpciones_8', 1, 2);
				$Form_Inputs->form_input_hidden('idProceso', 1, 2);
				$Form_Inputs->form_input_hidden('idTransporte', $_SESSION['usuario']['basic_data']['idTransporte'], 2);
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				
				?>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
                      
			</form> 
            <?php widget_validator(); ?>        
		</div>
	</div>
</div>

 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
/**********************************************************/
//paginador de resultados
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
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'nombre_asc':     $order_by = 'ORDER BY vehiculos_listado.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':    $order_by = 'ORDER BY vehiculos_listado.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'patente_asc':    $order_by = 'ORDER BY vehiculos_listado.Patente ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Patente Ascendente'; break;
		case 'patente_desc':   $order_by = 'ORDER BY vehiculos_listado.Patente DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Patente Descendente';break;
		case 'tipo_asc':       $order_by = 'ORDER BY vehiculos_tipo.Nombre ASC ';                     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente';break;
		case 'tipo_desc':      $order_by = 'ORDER BY vehiculos_tipo.Nombre DESC ';                    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
		case 'estado_asc':     $order_by = 'ORDER BY core_estados.Nombre ASC ';                       $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':    $order_by = 'ORDER BY core_estados.Nombre DESC ';                      $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'proceso_asc':    $order_by = 'ORDER BY core_estado_aprobacion_vehiculos.Nombre ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Proceso Ascendente';break;
		case 'proceso_desc':   $order_by = 'ORDER BY core_estado_aprobacion_vehiculos.Nombre DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Proceso Descendente';break;
		case 'pasajeros_asc':  $order_by = 'ORDER BY Pasajeros ASC ';                                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Capacidad Pasajeros Ascendente'; break;
		case 'pasajeros_desc': $order_by = 'ORDER BY Pasajeros DESC ';                                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Capacidad Pasajeros Descendente';break;
		
		default: $order_by = 'ORDER BY vehiculos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'ORDER BY vehiculos_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$z = "WHERE vehiculos_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
//Verifico el tipo de usuario que esta ingresando
$z.=" AND vehiculos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];	
/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){        $z .= " AND vehiculos_listado.Nombre LIKE '%".$_GET['Nombre']."%'";}
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){        $z .= " AND vehiculos_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['Marca']) && $_GET['Marca'] != ''){          $z .= " AND vehiculos_listado.Marca LIKE '%".$_GET['Marca']."%'";}
if(isset($_GET['Modelo']) && $_GET['Modelo'] != ''){        $z .= " AND vehiculos_listado.Modelo LIKE '%".$_GET['Modelo']."%'";}
if(isset($_GET['Patente']) && $_GET['Patente'] != ''){      $z .= " AND vehiculos_listado.Patente LIKE '%".$_GET['Patente']."%'";}
if(isset($_GET['idProceso']) && $_GET['idProceso'] != ''){  $z .= " AND vehiculos_listado.idProceso=".$_GET['idProceso'];}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idVehiculo FROM `vehiculos_listado` ".$z;
$registros = mysqli_query($dbConn, $query);
$cuenta_registros = mysqli_num_rows($registros);
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);	
// Se trae un listado con todos los usuarios
$arrVehiculo = array();
$query = "SELECT 
vehiculos_listado.idVehiculo,
vehiculos_listado.idVehiculo AS ID,
vehiculos_listado.Nombre, 
vehiculos_listado.Patente, 
vehiculos_tipo.Nombre AS Tipo,
core_sistemas.Nombre AS RazonSocial,
core_estados.Nombre AS Estado,
vehiculos_listado.idEstado,
core_estado_aprobacion_vehiculos.Nombre AS Proceso,
(SELECT  COUNT(idVehiculo) FROM `apoderados_listado_hijos` WHERE idVehiculo = ID LIMIT 1)AS Pasajeros,

 
vehiculos_listado.idTipo,  
vehiculos_listado.Marca,  
vehiculos_listado.Modelo,  
vehiculos_listado.Num_serie,  
vehiculos_listado.AnoFab,  
vehiculos_listado.idZona,  
vehiculos_listado.Capacidad,  
vehiculos_listado.idTrabajador, 
vehiculos_listado.Direccion_img,  
vehiculos_listado.doc_mantencion,  
vehiculos_listado.doc_padron,  
vehiculos_listado.doc_permiso_circulacion,  
vehiculos_listado.doc_resolucion_sanitaria, 
vehiculos_listado.doc_revision_tecnica,  
vehiculos_listado.doc_seguro_carga,  
vehiculos_listado.doc_soap,  
vehiculos_listado.doc_fecha_mantencion,  
vehiculos_listado.doc_fecha_padron, 
vehiculos_listado.doc_fecha_permiso_circulacion,  
vehiculos_listado.doc_fecha_resolucion_sanitaria,  
vehiculos_listado.doc_fecha_revision_tecnica, 
vehiculos_listado.doc_fecha_seguro_carga,  
vehiculos_listado.doc_fecha_soap 

FROM `vehiculos_listado`
LEFT JOIN `vehiculos_tipo`                     ON vehiculos_tipo.idTipo                       = vehiculos_listado.idTipo
LEFT JOIN `core_sistemas`                      ON core_sistemas.idSistema                     = vehiculos_listado.idSistema
LEFT JOIN `core_estados`                       ON core_estados.idEstado                       = vehiculos_listado.idEstado
LEFT JOIN `core_estado_aprobacion_vehiculos`   ON core_estado_aprobacion_vehiculos.idProceso  = vehiculos_listado.idProceso
".$z."
".$order_by."
LIMIT $comienzo, $cant_reg ";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrVehiculo,$row );
}
?>
<div class="col-sm-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Presionar para desplegar Formulario de Busqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>		
	</ul>
	
	<a href="<?php echo $location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Vehiculo</a>

</div>
<div class="clearfix"></div> 
<div class="collapse col-sm-12" id="collapseExample">
	<div class="well">
		<div class="col-sm-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {       $x1  = $Nombre;       }else{$x1  = '';}
				if(isset($idTipo)) {       $x2  = $idTipo;       }else{$x2  = '';}
				if(isset($Marca)) {        $x3  = $Marca;        }else{$x3  = '';}
				if(isset($Modelo)) {       $x4  = $Modelo;       }else{$x4  = '';}
				if(isset($Patente)) {      $x5  = $Patente;      }else{$x5  = '';}
				if(isset($idProceso)) {    $x6  = $idProceso;    }else{$x6  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
				$Form_Inputs->form_select('Tipo de Vehiculo','idTipo', $x2, 1, 'idTipo', 'Nombre', 'vehiculos_tipo', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Marca', 'Marca', $x3, 1);
				$Form_Inputs->form_input_text('Modelo', 'Modelo', $x4, 1);
				$Form_Inputs->form_input_text('Patente', 'Patente', $x5, 1);
				$Form_Inputs->form_select('Proceso','idProceso', $x6, 1, 'idProceso', 'Nombre', 'core_estado_aprobacion_vehiculos', 0, '', $dbConn);
				
				$Form_Inputs->form_input_hidden('pagina', $_GET['pagina'], 2);
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
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Vehiculos</h5>
			<div class="toolbar">
				<?php 
				//se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<div class="pull-left">Nombre</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Patente</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=patente_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=patente_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Capacidad Pasajeros</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=pasajeros_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=pasajeros_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Proceso</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=proceso_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=proceso_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">% Completado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>			  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrVehiculo as $trab) { 
					//variable
					$new_veh     = 0;
					$total_veh   = 25;
					//se verifica la existencia de datos
					if(isset($trab['Nombre'])&&$trab['Nombre']!=''){                                                              $new_veh++;}
					if(isset($trab['idTipo'])&&$trab['idTipo']!=0){                                                               $new_veh++;}
					if(isset($trab['Marca'])&&$trab['Marca']!=''){                                                                $new_veh++;}
					if(isset($trab['Modelo'])&&$trab['Modelo']!=''){                                                              $new_veh++;}
					if(isset($trab['Patente'])&&$trab['Patente']!=''){                                                            $new_veh++;}
					if(isset($trab['Num_serie'])&&$trab['Num_serie']!=''){                                                        $new_veh++;}
					if(isset($trab['AnoFab'])&&$trab['AnoFab']!=''){                                                              $new_veh++;}
					if(isset($trab['idZona'])&&$trab['idZona']!=0){                                                               $new_veh++;}
					if(isset($trab['Capacidad'])&&$trab['Capacidad']!=''){                                                        $new_veh++;}
					if(isset($trab['idTrabajador'])&&$trab['idTrabajador']!=0){                                                   $new_veh++;}
					if(isset($trab['Direccion_img'])&&$trab['Direccion_img']!=''){                                                $new_veh++;}
					if(isset($trab['doc_mantencion'])&&$trab['doc_mantencion']!=''){                                              $new_veh++;}
					if(isset($trab['doc_padron'])&&$trab['doc_padron']!=''){                                                      $new_veh++;}
					if(isset($trab['doc_permiso_circulacion'])&&$trab['doc_permiso_circulacion']!=''){                            $new_veh++;}
					if(isset($trab['doc_resolucion_sanitaria'])&&$trab['doc_resolucion_sanitaria']!=''){                          $new_veh++;}
					if(isset($trab['doc_revision_tecnica'])&&$trab['doc_revision_tecnica']!=''){                                  $new_veh++;}
					if(isset($trab['doc_seguro_carga'])&&$trab['doc_seguro_carga']!=''){                                          $new_veh++;}
					if(isset($trab['doc_soap'])&&$trab['doc_soap']!=''){                                                          $new_veh++;}
					if(isset($trab['doc_fecha_mantencion'])&&$trab['doc_fecha_mantencion']!='0000-00-00'){                        $new_veh++;}
					if(isset($trab['doc_fecha_padron'])&&$trab['doc_fecha_padron']!='0000-00-00'){                                $new_veh++;}
					if(isset($trab['doc_fecha_permiso_circulacion'])&&$trab['doc_fecha_permiso_circulacion']!='0000-00-00'){      $new_veh++;}
					if(isset($trab['doc_fecha_resolucion_sanitaria'])&&$trab['doc_fecha_resolucion_sanitaria']!='0000-00-00'){    $new_veh++;}
					if(isset($trab['doc_fecha_revision_tecnica'])&&$trab['doc_fecha_revision_tecnica']!='0000-00-00'){            $new_veh++;}
					if(isset($trab['doc_fecha_seguro_carga'])&&$trab['doc_fecha_seguro_carga']!='0000-00-00'){                    $new_veh++;}
					if(isset($trab['doc_fecha_soap'])&&$trab['doc_fecha_soap']!='0000-00-00'){                                    $new_veh++;}

					
					?>
					<tr class="odd">
						<td><?php echo $trab['Nombre']; ?></td>
						<td><?php echo $trab['Patente']; ?></td>
						<td><?php echo $trab['Tipo']; ?></td>
						<td><?php echo $trab['Pasajeros']; ?></td>
						<td><label class="label <?php if(isset($trab['idEstado'])&&$trab['idEstado']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $trab['Estado']; ?></label></td>
						<td><?php echo $trab['Proceso']; ?></td>
						<td><?php echo porcentaje($new_veh/$total_veh); ?></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo 'view_vehiculos.php?view='.$trab['idVehiculo']; ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&id='.$trab['idVehiculo']; ?>" title="Editar Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php 
									$ubicacion = $location.'&del='.simpleEncode($trab['idVehiculo'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el vehiculo '.$trab['Nombre'].'?';?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Informacion" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>                    
				</tbody>
			</table>
		</div>
		<div class="pagrow">	
			<?php 
			//se llama al paginador
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

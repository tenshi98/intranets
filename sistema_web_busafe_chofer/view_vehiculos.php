<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim); }else{set_time_limit(2400);}             
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M'); }else{ini_set('memory_limit', '4096M');}  
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
// Se traen todos los datos de mi usuario
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

WHERE vehiculos_listado.idVehiculo = ".$_GET['view'];
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
	WHERE apoderados_listado_hijos.idVehiculo = ".$_GET['view']."
	ORDER BY apoderados_listado_hijos.idHijos ASC ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		
		//variables
		$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
		$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

		//generar log
		php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
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
	WHERE apoderados_listado_hijos.idVehiculoVuelta =  ".$_GET['view']."
	ORDER BY apoderados_listado_hijos.idHijos ASC ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//variables
		$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
		$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

		//generar log
		php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
						
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
	WHERE vehiculos_listado_colegios.idVehiculo = ".$_GET['view']."
	ORDER BY colegios_listado.Nombre ASC ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		
		//variables
		$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
		$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

		//generar log
		php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
	}
	while ( $row = mysqli_fetch_assoc ($resultado)) {
	array_push( $arrColegios,$row );
	}
}

?>
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Datos del vehiculo</h5>
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
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_mantencion'], fecha_actual()).'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_padron'], fecha_actual()).'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_permiso_circulacion'], fecha_actual()).'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_revision_tecnica'], fecha_actual()).'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_soap'], fecha_actual()).'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_cert_trans_personas'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
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
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['doc_ficha_tecnica'], fecha_actual()).'&return='.basename($_SERVER["REQUEST_URI"], ".php").'" title="Ver Documento" class="btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
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

<?php 
//si se entrega la opcion de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){ 
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php 
	//para las versiones nuevas que indican donde volver
	}else{ 
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
		
	<?php }		
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';
?>

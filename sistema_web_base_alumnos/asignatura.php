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
$original = "asignatura.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-dashboard" aria-hidden="true"></i> Asignatura';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_form']) )  { 
	//Llamamos al formulario
	$form_obligatorios = 'idQuizRealizadas';
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_alumnos_evaluaciones_asignar.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['idElearning']) ) {
// consulto los datos
$query = "SELECT  Nombre, Resumen, Objetivos, Requisitos, Descripcion
FROM `alumnos_elearning_listado`
WHERE idElearning = ".$_GET['idElearning'];
//Consulta
$resultado = mysqli_query ($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);	

/*****************************************************/
// Se trae un listado con todos los elementos
$arrContenidos = array();
$query = "SELECT
alumnos_elearning_listado_unidades.idUnidad AS Unidad_ID, 
alumnos_elearning_listado_unidades.N_Unidad AS Unidad_Numero, 
alumnos_elearning_listado_unidades.Nombre AS Unidad_Nombre,
alumnos_elearning_listado_unidades.Duracion AS Unidad_Duracion,
alumnos_elearning_listado_unidades_contenido.idContenido AS Contenido_ID,
alumnos_elearning_listado_unidades_contenido.Nombre AS Contenido_Nombre,
alumnos_elearning_listado_unidades_contenido.Contenido AS Contenido_Texto

FROM `alumnos_elearning_listado_unidades`
LEFT JOIN `alumnos_elearning_listado_unidades_contenido` ON alumnos_elearning_listado_unidades_contenido.idUnidad = alumnos_elearning_listado_unidades.idUnidad
WHERE alumnos_elearning_listado_unidades.idElearning = ".$_GET['idElearning']."
ORDER BY alumnos_elearning_listado_unidades.N_Unidad ASC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrContenidos,$row );
}

/*****************************************************/
// Se trae un listado con todos los elementos
$arrFiles = array();
$query = "SELECT idDocumentacion, idUnidad, idElearning, idContenido, File
FROM `alumnos_elearning_listado_unidades_documentacion`
WHERE idElearning = ".$_GET['idElearning']."
ORDER BY File ASC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrFiles,$row );
}

/*****************************************************/
// Se trae un listado con todos los elementos
$arrCuestionarios = array();
$query = "SELECT 
alumnos_elearning_listado_unidades_cuestionarios.idCuestionario, 
alumnos_elearning_listado_unidades_cuestionarios.idUnidad, 
alumnos_elearning_listado_unidades_cuestionarios.idElearning, 
alumnos_elearning_listado_unidades_cuestionarios.idContenido, 
alumnos_elearning_listado_unidades_cuestionarios.idQuiz,
quiz_listado.Nombre AS Cuestionario
FROM `alumnos_elearning_listado_unidades_cuestionarios`
LEFT JOIN `quiz_listado` ON quiz_listado.idQuiz = alumnos_elearning_listado_unidades_cuestionarios.idQuiz
WHERE alumnos_elearning_listado_unidades_cuestionarios.idElearning = ".$_GET['idElearning']."
ORDER BY quiz_listado.Nombre ASC ";
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
array_push( $arrCuestionarios,$row );
}

/*****************************************************/
//calculo de los dias de duracion
$Dias_Duracion = 0;
filtrar($arrContenidos, 'Unidad_Numero');  
foreach($arrContenidos as $categoria=>$permisos){
	$Dias_Duracion = $Dias_Duracion + $permisos[0]['Unidad_Duracion'];
}
/********************************************************/
//se indica la carpeta de subida de archivos
$sistema_raiz = DB_SITE_ALT_1;

?>

<div class="col-sm-12">
	<div class="box">	
		<header>		
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo $rowdata['Nombre']; ?></h5>
		</header>
		<div class="">
			<div class="table-responsive">    
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr>
							<td class="meta-head">Dias de Duracion</td>
							<td><?php echo $Dias_Duracion.' dias'; ?></td>
						</tr>
						<tr>
							<td class="meta-head">Resumen</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowdata['Resumen']; ?></span></td>
						</tr> 
						<tr>
							<td class="meta-head">Objetivos</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowdata['Objetivos']; ?></span></td>
						</tr> 
						<tr>
							<td class="meta-head">Requisitos</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowdata['Requisitos']; ?></span></td>
						</tr> 
						<tr>
							<td class="meta-head">Descripcion</td>
							<td><span style="word-wrap: break-word;white-space: initial;"><?php echo $rowdata['Descripcion']; ?></span></td>
						</tr>
							
						<?php  
						foreach($arrContenidos as $categoria=>$permisos){?>
							<tr class="odd" >
								<td style="background-color:#DDD" colspan="2"><strong>Unidad <?php echo $categoria; ?></strong> - <?php echo $permisos[0]['Unidad_Nombre'].' ('.$permisos[0]['Unidad_Duracion'].' dias de duracion)'; ?></td>
							</tr>
							<?php foreach ($permisos as $preg) { 
								if(isset($preg['Contenido_Nombre'])&&$preg['Contenido_Nombre']!=''){?>
									<tr class="item-row linea_punteada">
										<td class="item-name" colspan="2">
											<span style="word-wrap: break-word;white-space: initial;"><strong><?php echo $preg['Contenido_Nombre']; ?></strong></span>	
											<span style="word-wrap: break-word;white-space: initial;"><?php echo $preg['Contenido_Texto']; ?></span>	
											
												
											<?php if($arrFiles){  
												//verifico que existan archivos en esta unidad
												$x_n_arch = 0;
												foreach ($arrFiles as $file) {
													if(isset($preg['Unidad_ID'])&&$preg['Unidad_ID']==$file['idUnidad']&&isset($preg['Contenido_ID'])&&$preg['Contenido_ID']==$file['idContenido']){
														$x_n_arch++;
													}
												}
												//si hay archivos se imprime
												if($x_n_arch!=0){
												?>
													<div class="clearfix"></div>
													<hr>
													<strong>Archivos adjuntos del contenido <?php echo $preg['Contenido_Nombre']; ?>:</strong><br/>
													<?php foreach ($arrFiles as $file) {
														//verifico que el archivo sea del contenido
														if(isset($preg['Unidad_ID'])&&$preg['Unidad_ID']==$file['idUnidad']&&isset($preg['Contenido_ID'])&&$preg['Contenido_ID']==$file['idContenido']){ ?>
															<div class="col-sm-12" style="margin-top:2px;">
																<div class="col-sm-11">
																	<?php 
																	$f_file = str_replace('elearning_files_'.$file['idContenido'].'_','',$file['File']);
																	echo $f_file; 
																	?>
																</div>
																<div class="col-sm-1">
																	<div class="btn-group" style="width: 70px;" >
																		<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($file['File'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
																		<a target="_blank" rel="noopener noreferrer" href="<?php echo DB_SITE_ALT_1.'/upload/'.$file['File']; ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>						
																	</div>
																</div>
															</div>
														<?php } ?>
													<?php } ?>
												<?php } ?>
											<?php } ?>
												
											<?php if($arrCuestionarios){ 
												//verifico que existan archivos en esta unidad
												$x_n_Cuest = 0;
												foreach ($arrCuestionarios as $file) {
													if(isset($preg['Unidad_ID'])&&$preg['Unidad_ID']==$file['idUnidad']&&isset($preg['Contenido_ID'])&&$preg['Contenido_ID']==$file['idContenido']){
														$x_n_Cuest++;
													}
												}
												//si hay archivos se imprime
												if($x_n_Cuest!=0){
												 ?>
													<div class="clearfix"></div>
													<hr>
													<strong>Cuestionarios adjuntos del contenido <?php echo $preg['Contenido_Nombre']; ?>:</strong><br/>
													<?php foreach ($arrCuestionarios as $file) {
														//verifico que el archivo sea del contenido
														if(isset($preg['Unidad_ID'])&&$preg['Unidad_ID']==$file['idUnidad']&&isset($preg['Contenido_ID'])&&$preg['Contenido_ID']==$file['idContenido']){ ?>
															<div class="col-sm-12" style="margin-top:2px;">
																<div class="col-sm-11"><?php echo $file['Cuestionario'];  ?></div>
																<div class="col-sm-1">
																	<div class="btn-group" style="width: 35px;" >
																		<a href="<?php echo 'view_quiz.php?view='.simpleEncode($file['idQuiz'], fecha_actual()); ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
																	</div>
																</div>
															</div>
														<?php } ?>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										</td>			
									</tr>
								<?php } ?> 
							<?php } ?> 
						<?php } ?> 			  
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
	<a href="<?php echo $location.'?view='.$_GET['view']; ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
<?php widget_modal(80, 95); ?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
/**********************************************************/
$query = "SELECT 
alumnos_cursos.Nombre AS NombreAsignatura

FROM `cursos_listado_asignaturas`
LEFT JOIN `alumnos_cursos` ON alumnos_cursos.idCurso = cursos_listado_asignaturas.idAsignatura
WHERE cursos_listado_asignaturas.idAsignatura = ".$_GET['view']."
";
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

//Listado con los elearning
$arrElearnng = array();
$query = "SELECT 
alumnos_cursos_elearning.idElearning,
alumnos_elearning_listado.Nombre AS NombreElearning

FROM `alumnos_cursos_elearning`
LEFT JOIN `alumnos_elearning_listado`   ON alumnos_elearning_listado.idElearning     = alumnos_cursos_elearning.idElearning
WHERE alumnos_cursos_elearning.idCurso=".$_GET['view']."
ORDER BY alumnos_elearning_listado.Nombre ASC  ";
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
array_push( $arrElearnng,$row );
}

/********************************************************/
// Se trae un listado con todos los archivos de las asignaturas
$arrArchivosAsignatura = array();
$query = "SELECT 
alumnos_cursos.Nombre AS NombreAsignatura,
alumnos_cursos_documentacion.File AS Archivo

FROM `cursos_listado_asignaturas`
LEFT JOIN `alumnos_cursos`                 ON alumnos_cursos.idCurso                   = cursos_listado_asignaturas.idAsignatura
LEFT JOIN `alumnos_cursos_documentacion`   ON alumnos_cursos_documentacion.idCurso     = cursos_listado_asignaturas.idAsignatura
WHERE cursos_listado_asignaturas.idAsignatura = ".$_GET['view']."
ORDER BY alumnos_cursos.Nombre ASC,  alumnos_cursos_documentacion.File ASC";
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
array_push( $arrArchivosAsignatura,$row );
}

?>
 
 
<div class="col-sm-8">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Elearnings de la asignatura <?php echo $rowdata['NombreAsignatura']; ?></h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre Elearning</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>				  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrElearnng as $curso) { ?>
					<tr class="odd">
						<td><?php echo $curso['NombreElearning']; ?></td>
						<td>
							<div class="btn-group" style="width: 35px;" >
								<a href="<?php echo $location.'?view='.$_GET['view'].'&idElearning='.$curso['idElearning']; ?>" title="Ver Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>					
							</div>
						</td>
					</tr>
				<?php } ?>                    
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="col-sm-4">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Archivos Asignatura</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Nombre Archivo</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>				  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrArchivosAsignatura as $curso) { ?>
							<tr class="odd">
								<td><?php echo $curso['Archivo']; ?></td>
								<td>
									<div class="btn-group" style="width: 70px;" >
										<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($curso['Archivo'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
										<a target="_blank" rel="noopener noreferrer" href="<?php echo DB_SITE_ALT_1.'/upload/'.$curso['Archivo']; ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>						
									</div>
								</td>
							</tr>

					<?php } ?>                    
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
	<a href="principal.php" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
	<div class="clearfix"></div>
</div>
	
<?php widget_modal(80, 95); ?>
	
<?php } ?> 			
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

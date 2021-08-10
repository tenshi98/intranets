<?php 
/*****************************************************************************************************************/
// Se trae un listado con todos los archivos de los cursos
$arrArchivosCursos = array();
$query = "SELECT File, Semana
FROM `cursos_listado_documentacion`
WHERE idCurso = ".$_SESSION['usuario']['basic_data']['idCurso']."
ORDER BY Semana ASC";
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
array_push( $arrArchivosCursos,$row );
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
WHERE cursos_listado_asignaturas.idCurso = ".$_SESSION['usuario']['basic_data']['idCurso']."
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

<?php if ($arrArchivosCursos){ ?>
	<div class="col-sm-3">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Archivos del Curso</h5>
			</header>
			<div class="table-responsive tab-content messaging">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre Archivo</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>				  
					<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php 
							filtrar($arrArchivosCursos, 'Semana');
							foreach($arrArchivosCursos as $Semana=>$Subcat){ 
								echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>Semana '.$Semana.'</strong></td></tr>';
								foreach ($Subcat as $curso) {  ?>
								<tr class="odd">
									<td><?php echo $curso['File']; ?></td>
									<td>
										<div class="btn-group" style="width: 70px;" >
											<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($curso['File'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
											<a target="_blank" rel="noopener noreferrer" href="<?php echo DB_SITE_ALT_1.'/upload/'.$curso['File']; ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>						
										</div>
									</td>
								</tr>
							<?php } ?> 
						<?php } ?>                    
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>

<?php if ($arrArchivosAsignatura){ ?>
	<div class="col-sm-3">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Archivos Asignaturas</h5>
			</header>
			<div class="table-responsive tab-content messaging">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre Archivo</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>				  
					<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php 
							filtrar($arrArchivosAsignatura, 'NombreAsignatura');
							foreach($arrArchivosAsignatura as $NombreAsignatura=>$Subcat){ 
								echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>'.$NombreAsignatura.'</strong></td></tr>';
								foreach ($Subcat as $curso) { ?>
								<tr class="odd">
									<td><?php echo $curso['Archivo']; ?></td>
									<td>
										<div class="btn-group" style="width: 70px;" >
											<a href="<?php echo 'view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($curso['Archivo'], fecha_actual()); ?>" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
											<a target="_blank" rel="noopener noreferrer" href="<?php echo DB_SITE_ALT_1.'/upload/'.$curso['File']; ?>" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>						
										</div>
									</td>
								</tr>
							<?php } ?> 
						<?php } ?>                    
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>
	
	
	
	

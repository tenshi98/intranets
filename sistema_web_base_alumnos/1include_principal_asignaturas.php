<?php 
/********************************************************/
// Se trae un listado con todos los archivos de las asignaturas
$arrAsignatura = array();
$query = "SELECT 
cursos_listado_asignaturas.idAsignatura,
alumnos_cursos.Nombre AS NombreAsignatura

FROM `cursos_listado_asignaturas`
LEFT JOIN `alumnos_cursos` ON alumnos_cursos.idCurso = cursos_listado_asignaturas.idAsignatura
WHERE cursos_listado_asignaturas.idCurso = ".$_SESSION['usuario']['basic_data']['idCurso']."
ORDER BY alumnos_cursos.Nombre ASC";
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
array_push( $arrAsignatura,$row );
}


?>



<?php if ($arrAsignatura){ ?>
	<div class="col-sm-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Asignaturas</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Nombre Asignaturas</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>				  
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrAsignatura as $curso) { ?>
							<tr class="odd">
								<td><?php echo $curso['NombreAsignatura']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<a href="<?php echo 'asignatura.php?view='.simpleEncode($curso['idAsignatura'], fecha_actual()); ?>" title="Ver Asignatura" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php } ?>                    
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php } ?>
	
	
	
	


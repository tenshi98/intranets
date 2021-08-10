<?php 
/********************************************************/
//obtengo el numero del dia de la semana
$idDia = fecha2NDiaSemana(fecha_actual());
//Variable de busqueda
$z = "WHERE cursos_listado_videoconferencia.idVideoConferencia!=0";
//Verifico el tipo de usuario que esta ingresando
//$z.= " AND cursos_listado.idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."'";	
$z.= " AND cursos_listado_videoconferencia.idDia_".$idDia." = 2";
$z.= " AND cursos_listado.idCurso='".$_SESSION['usuario']['basic_data']['idCurso']."'";

// Se trae un listado con todos los archivos de las asignaturas
$arrVideoConferencia = array();
$query = "SELECT 
cursos_listado_videoconferencia.idVideoConferencia,
cursos_listado.Nombre AS Curso,
usuarios_listado.Nombre AS Profesor,
cursos_listado_videoconferencia.Nombre,
cursos_listado_videoconferencia.HoraInicio,
cursos_listado_videoconferencia.HoraTermino,
core_sistemas.Nombre AS RazonSocial

FROM `cursos_listado`
LEFT JOIN `cursos_listado_videoconferencia`  ON cursos_listado_videoconferencia.idCurso  = cursos_listado.idCurso
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                  = cursos_listado.idSistema
LEFT JOIN `usuarios_listado`                 ON usuarios_listado.idUsuario               = cursos_listado_videoconferencia.idUsuario

".$z."
ORDER BY usuarios_listado.Nombre ASC, cursos_listado_videoconferencia.HoraInicio ASC
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
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrVideoConferencia,$row );
}


?>



<?php if ($arrVideoConferencia){ ?>
	<div class="col-sm-6">
		<div class="box">
			<header>
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>VideoConferencias</h5>
			</header>
			<div class="table-responsive">
				<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
					<thead>
						<tr role="row">
							<th>Profesor</th>
							<th>VideoConferencia</th>
							<th>Horario</th>
							<th width="10">Acciones</th>
						</tr>
					</thead>				  
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrVideoConferencia as $vid) { ?>
							<tr class="odd">
								<td><?php echo $vid['Profesor']; ?></td>
								<td><?php echo $vid['Nombre']; ?></td>
								<td><?php echo $vid['HoraInicio'].' - '.$vid['HoraTermino']; ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<a href="<?php echo 'videoconferencia_room.php?view='.simpleEncode($vid['idVideoConferencia'], fecha_actual()); ?>" title="Entrar en la Videoconferencia" class="btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
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
	
	
	
	



<?php
/*****************************************************************************************************************/
// Se trae un listado con todos
$arrEvaluaciones = array();
$query = "SELECT 
quiz_realizadas.idQuizRealizadas, 
quiz_listado.Nombre,
quiz_realizadas.Programada_fecha,
quiz_realizadas.Programada_mes,
quiz_realizadas.Programada_dia,
quiz_realizadas.Semana,
quiz_escala.Nombre AS Aprobado,
quiz_listado.Tiempo,
quiz_realizadas.Ejecucion_fecha, 
quiz_realizadas.Ejecucion_hora, 
quiz_realizadas.Duracion_Max

FROM `quiz_realizadas`
LEFT JOIN `quiz_listado`  ON quiz_listado.idQuiz     = quiz_realizadas.idQuiz
LEFT JOIN `quiz_escala`   ON quiz_escala.idEscala    = quiz_listado.Porcentaje_apro
WHERE quiz_realizadas.idAlumno=".$_SESSION['usuario']['basic_data']['idAlumno']."
AND quiz_realizadas.idEstado=1
ORDER BY quiz_realizadas.Programada_fecha ASC";
$resultado = mysqli_query($dbConn, $query);
$n_Evaluaciones = mysqli_num_rows ($resultado);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrEvaluaciones,$row );
}
/******************************************************/
//variable de comprobacion
$anular = 0;
//elimino las que ya estan fuera de tiempo
foreach ($arrEvaluaciones as $eva) {
	//Verifico si se ejecuto anteriormente
	if(isset($eva['Ejecucion_fecha'])&&$eva['Ejecucion_fecha']!='0000-00-00'&&isset($eva['Ejecucion_hora'])&&$eva['Ejecucion_hora']!='00:00:00'){
		$diaInicio   = $eva['Ejecucion_fecha'];
		$diaTermino  = fecha_actual();
		$tiempo1     = $eva['Ejecucion_hora'];
		$tiempo2     = hora_actual();
		//calculo diferencia de dias
		$dif = dias_transcurridos($diaInicio,$diaTermino);
		//calculo del tiempo transcurrido
		$Tiempo = restahoras($tiempo1, $tiempo2);
		//por cada dia pasado se le suman 24 horas a la variable
		if($dif>1){
			$dif = $dif-1;
			$totalhoras = minutos2horas($dif*1440);
			$Tiempo = sumahoras($Tiempo,$totalhoras);
		}
		//si el tiempo es superior al tiempo limite, se cierra la evaluacion y se redirije a principal
		if($Tiempo>$eva['Duracion_Max']&&$eva['Duracion_Max']!='00:00:00'){
			//calculo de rendimiento
			$idEstadoAprobacion   = 1; //no aprobado
			$Rendimiento          = 0; //como no la dio no se guardan respuestas
				
			//Se actualiza
			$a = "idEstado=2" ;
			$a .= ",idEstadoAprobacion='".$idEstadoAprobacion."'" ;  
			$a .= ",Rendimiento='".$Rendimiento."'" ;  
										
			// inserto los datos de registro en la db
			$query  = "UPDATE `quiz_realizadas` SET ".$a." WHERE idQuizRealizadas = ".$eva['idQuizRealizadas'];
			$result = mysqli_query($dbConn, $query);
				
			//se indica que hay cambios
			$anular++;	
		}
	//verifico si ya esta fuera de fecha de ejecucion
	}elseif(isset($eva['Ejecucion_fecha'])&&$eva['Ejecucion_fecha']=='0000-00-00'){
		$diaInicio   = $eva['Programada_fecha'];
		$diaTermino  = fecha_actual();
		//valido que la fecha actual sea mayor que la fecha de termino
		if ($diaTermino > $diaInicio) {
			//calculo de rendimiento
			$idEstadoAprobacion   = 1; //no aprobado
			$Rendimiento          = 0; //como no la dio no se guardan respuestas
				
			//Se actualiza
			$a = "idEstado=2" ;
			$a .= ",idEstadoAprobacion='".$idEstadoAprobacion."'" ;  
			$a .= ",Rendimiento='".$Rendimiento."'" ;  
										
			// inserto los datos de registro en la db
			$query  = "UPDATE `quiz_realizadas` SET ".$a." WHERE idQuizRealizadas = ".$eva['idQuizRealizadas'];
			$result = mysqli_query($dbConn, $query);
				
			//se indica que hay cambios
			$anular++;	

		}
	}
}
//si hay correcciones se vuelve a hacer un select con los datos
if(isset($anular)&&$anular!=0){
	// Se trae un listado con todos
	$arrEvaluaciones = array();
	$query = "SELECT 
	quiz_realizadas.idQuizRealizadas, 
	quiz_listado.Nombre,
	quiz_realizadas.Programada_fecha,
	quiz_realizadas.Programada_mes,
	quiz_realizadas.Programada_dia,
	quiz_realizadas.Semana,
	quiz_escala.Nombre AS Aprobado,
	quiz_listado.Tiempo,
	quiz_realizadas.Ejecucion_fecha, 
	quiz_realizadas.Ejecucion_hora, 
	quiz_realizadas.Duracion_Max

	FROM `quiz_realizadas`
	LEFT JOIN `quiz_listado`  ON quiz_listado.idQuiz     = quiz_realizadas.idQuiz
	LEFT JOIN `quiz_escala`   ON quiz_escala.idEscala    = quiz_listado.Porcentaje_apro
	WHERE quiz_realizadas.idAlumno=".$_SESSION['usuario']['basic_data']['idAlumno']."
	AND quiz_realizadas.idEstado=1
	ORDER BY quiz_realizadas.Programada_fecha ASC";
	$resultado = mysqli_query($dbConn, $query);
	$n_Evaluaciones = mysqli_num_rows ($resultado);
	while ( $row = mysqli_fetch_assoc ($resultado)) {
	array_push( $arrEvaluaciones,$row );
	}	
}

// Se trae un listado con todos
$arrEvaluadas = array();
$query = "SELECT 
quiz_listado.Nombre,
quiz_realizadas.Programada_fecha,
quiz_realizadas.Semana,
quiz_escala.Nombre AS Porcentaje,
quiz_realizadas.Rendimiento,
core_estado_aprobacion_evaluacion.Nombre AS Estado

FROM `quiz_realizadas`
LEFT JOIN `quiz_listado`                        ON quiz_listado.idQuiz                                     = quiz_realizadas.idQuiz
LEFT JOIN `quiz_escala`                         ON quiz_escala.idEscala                                    = quiz_listado.Porcentaje_apro
LEFT JOIN `core_estado_aprobacion_evaluacion`   ON core_estado_aprobacion_evaluacion.idEstadoAprobacion    = quiz_realizadas.idEstadoAprobacion
WHERE quiz_realizadas.idAlumno=".$_SESSION['usuario']['basic_data']['idAlumno']."
AND quiz_realizadas.idEstado=2
ORDER BY quiz_realizadas.Programada_fecha DESC";
$resultado = mysqli_query($dbConn, $query);
$n_Evaluadas = mysqli_num_rows ($resultado);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrEvaluadas,$row );
}




//Se definen las variables
$Mes  = mes_actual();
$Ano  = ano_actual();
$diaActual = dia_actual();

//calculo de los dias del mes, cuando inicia y cuando termina
$diaSemana      = date("w",mktime(0,0,0,$Mes,1,$Ano))+7; 
$ultimoDiaMes   = date("d",(mktime(0,0,0,$Mes+1,1,$Ano)-1));

//arreglo con los meses
$meses=array(1=>"Enero", 
				"Febrero", 
				"Marzo", 
				"Abril", 
				"Mayo", 
				"Junio", 
				"Julio",
				"Agosto", 
				"Septiembre", 
				"Octubre", 
				"Noviembre", 
				"Diciembre"
			);
?>
<style>
	.calendar_min {
		min-height: 60px;
	}
</style>
	
<div class="col-sm-6">

	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Pruebas Programadas</h5>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#tab_1" data-toggle="tab"><i class="fa fa-calendar" aria-hidden="true"></i> Calendario</a></li>
				<li class=""><a href="#tab_2" data-toggle="tab"><i class="fa fa-calendar-check-o" aria-hidden="true"></i> Pendientes (<?php echo $n_Evaluaciones; ?>)</a></li>
				<li class=""><a href="#tab_3" data-toggle="tab"><i class="fa fa-calendar-minus-o" aria-hidden="true"></i> Hechos (<?php echo $n_Evaluadas; ?>)</a></li>         
			</ul>	
		</header>
		<div id="div-3" class="tab-content">
				
			<div class="tab-pane fade active in" id="tab_1">
				<div id="calendar_content" class="body">
					<div id="calendar" class="fc fc-ltr">

						<table class="fc-header" style="width:100%">
							<tbody>
								<tr>
									<td class="fc-header-left"></td>
									<td class="fc-header-center"><span class="fc-header-title"><h2><?php echo $meses[mes_actual()]." ".ano_actual()?></h2></span></td>
									<td class="fc-header-right"></td>
								</tr>
							</tbody>
						</table>

						<div class="fc-content" style="position: relative;margin-left: -10px;margin-right: -10px;">
							<div class="fc-view fc-view-Mes fc-grid" style="position:relative" unselectable="on">

								<table class="fc-border-separate correct_border" style="width:100%" cellspacing="0"> 
									<thead>
										<tr class="fc-first fc-last"> 
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Lunes</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Martes</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Miercoles</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Jueves</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Viernes</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Sabado</th>
											<th class="fc-day-header fc-sun fc-widget-header" width="14%">Domingo</th>
										</tr>
									</thead>
									<tbody>
										<tr class="fc-week"> 
											<?php
												$last_cell = $diaSemana + $ultimoDiaMes;
												// hacemos un bucle hasta 42, que es el máximo de valores que puede
												// haber... 6 columnas de 7 dias
												for($i=1;$i<=42;$i++){
													// determinamos en que dia empieza
													if($i==$diaSemana){
														$Dia=1;
													}
													// celca vacia
													if($i<$diaSemana || $i>=$last_cell){
														echo "<td class='fc-Dia fc-wed fc-widget-content fc-other-Mes fc-future fc-state-none'> </td>";
													// mostramos el dia
													}else{ ?>  
														<td class="fc-Dia fc-sun fc-widget-content fc-past fc-first <?php if($Dia==$diaActual){ echo 'fc-state-highlight'; }?>">
															<div class="calendar_min">
																<div class="fc-Dia-number"><?php echo $Dia; ?></div>
																<div class="fc-Dia-content">
																	<?php foreach ($arrEvaluaciones as $evento) { 
																		if ($evento['Programada_dia']==$Dia) {
																			$ver = '';
																			echo '<a class="event_calendar evcal_color2 word_break" href="'.$ver.'">'.cortar($evento['Nombre'], 20).'</a>';
													
																		} 
																	} ?>    
																</div>
															</div>
														</td>
														<?php  
														$Dia++;
													}
													// cuando llega al final de la semana, iniciamos una columna nueva
													if($i%7==0){
														echo "</tr><tr class='fc-week'>\n";
													}
												}
											?>
										</tr>
									</tbody>
								</table>

							</div>
						</div>
					</div>
				</div>
					
					
			</div>
			
			<div class="tab-pane fade" id="tab_2">
				<div class="table-responsive messaging">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Fecha</th>
								<th>Evaluacion</th>
								<th>Tiempo</th>
								<th>% Aprobacion</th>
								<th width="10">Acciones</th>
							</tr>
						</thead>				  
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrEvaluaciones as $eva) { ?>
								<tr class="odd">
									<td><?php echo fecha_estandar($eva['Programada_fecha']); ?></td>
									<td><?php echo $eva['Nombre']; ?></td>
									<td><?php echo $eva['Tiempo']; ?></td>
									<td><?php echo $eva['Aprobado']; ?></td>
									<td>
										<div class="btn-group" style="width: 70px;" >
											<?php 
											if(isset($eva['Programada_fecha'])&&$eva['Programada_fecha']==fecha_actual()){	
												$ubicacion = 'pruebas.php?id='.$eva['idQuizRealizadas'];
												$dialogo   = 'Una vez iniciada la evaluacion debe terminarla dentro del tiempo permitido, sino se dara como reprobada';?>
												<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Realizar Evaluacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											<?php } ?>
											
										</div>
									</td>
								</tr>
							<?php } ?>                    
						</tbody>
					</table>
				</div>

			</div>
			<div class="tab-pane fade" id="tab_3">
					
				<div class="table-responsive messaging">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Fecha</th>
								<th>Evaluacion</th>
								<th>Estado</th>
								<th>% Aprobacion</th>
								<th>% Logrado</th>
							</tr>
						</thead>				  
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<?php foreach ($arrEvaluadas as $eva) {?>
								<tr class="odd">
									<td><?php echo fecha_estandar($eva['Programada_fecha']); ?></td>
									<td><?php echo $eva['Nombre']; ?></td>
									<td><?php echo $eva['Estado']; ?></td>
									<td><?php echo $eva['Porcentaje']; ?></td>
									<td><?php echo cantidades($eva['Rendimiento'], 0).' %'; ?></td>
								</tr>
							<?php } ?>                    
						</tbody>
					</table>
				</div>
					
			</div>
				
		</div>	
	</div>

</div>

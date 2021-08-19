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
$original = "pruebas.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-dashboard" aria-hidden="true"></i> Prueba';
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
//Listado de errores no manejables
if (isset($_GET['rendida'])) {$error['rendida'] 	  = 'sucess/Evaluacion Rendida correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['id']) ) { 
//Consulto la evaluacion
$query = "SELECT Programada_fecha, Ejecucion_fecha, Ejecucion_hora, Duracion_Max
FROM `quiz_realizadas`
WHERE idQuizRealizadas=".$_GET['id'];
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);


//Verifico si se ejecuto en un punto anterior
if(isset($rowdata['Ejecucion_fecha'])&&$rowdata['Ejecucion_fecha']!='0000-00-00'&&isset($rowdata['Ejecucion_hora'])&&$rowdata['Ejecucion_hora']!='00:00:00'){
	$diaInicio   = $rowdata['Ejecucion_fecha'];
	$diaTermino  = fecha_actual();
	$tiempo1     = $rowdata['Ejecucion_hora'];
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
	if($Tiempo>$rowdata['Duracion_Max']&&$rowdata['Duracion_Max']!='00:00:00'){
		
		//calculo de rendimiento
		$idEstadoAprobacion   = 1; //no aprobado
		$Rendimiento          = 0; //como no la dio no se guardan respuestas
		
		//Se actualiza
		$a = "idEstado=2" ;
		$a .= ",idEstadoAprobacion='".$idEstadoAprobacion."'" ;  
		$a .= ",Rendimiento='".$Rendimiento."'" ;  
		
											
		// inserto los datos de registro en la db
		$query  = "UPDATE `quiz_realizadas` SET ".$a." WHERE idQuizRealizadas = ".$_GET['id'];
		$result = mysqli_query($dbConn, $query);
		

		//se redirige
		echo '<script type="text/javascript">window.location = "principal.php"</script>';				
	}else{
		//se redirije
		echo '<script type="text/javascript">window.location = "pruebas.php?evaluar='.$_GET['id'].'"</script>';
	}
//Si por el contrario no se ha rendido se actualiza el la fecha de ejecucion y se redirije a la prueba
}elseif(isset($rowdata['Ejecucion_fecha'])&&$rowdata['Ejecucion_fecha']=='0000-00-00'&&isset($rowdata['Ejecucion_hora'])&&$rowdata['Ejecucion_hora']=='00:00:00'){
	//variables
	$dia     = fecha_actual();
	$tiempo  = hora_actual();
	
	//se actualiza
	$a = "Ejecucion_hora='".$tiempo."'" ;
	$a .= ",Ejecucion_fecha='".$dia."'" ;  
	$a .= ",Ejecucion_mes='".fecha2NMes($dia)."'" ;
	$a .= ",Ejecucion_ano='".fecha2Ano($dia)."'" ;  
											
	// inserto los datos de registro en la db
	$query  = "UPDATE `quiz_realizadas` SET ".$a." WHERE idQuizRealizadas = ".$_GET['id'];
	$result = mysqli_query($dbConn, $query);
							
	//se redirije
	echo '<script type="text/javascript">window.location = "pruebas.php?evaluar='.$_GET['id'].'"</script>';
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 }elseif ( ! empty($_GET['evaluar']) ) {

/********************************************/
//Cadena temporal
$cadena = '';
for ($i = 1; $i <= 100; $i++) {
	$cadena .= ',quiz_realizadas.Pregunta_'.$i;
}
				
//Selecciono los datos de las preguntas de la query
$query = "SELECT 
quiz_realizadas.Duracion_Max,
quiz_realizadas.Ejecucion_hora,
quiz_realizadas.idQuiz,
esc_1.Valor AS PuntajeMin,
esc_2.Valor AS PorcentajeMin,
quiz_listado.idTipoEvaluacion,
quiz_listado.idTipoQuiz,
quiz_listado.idLimiteTiempo

".$cadena."

FROM `quiz_realizadas`
LEFT JOIN `quiz_listado`            ON quiz_listado.idQuiz    = quiz_realizadas.idQuiz
LEFT JOIN `quiz_escala`  esc_1      ON esc_1.idEscala         = quiz_listado.idEscala
LEFT JOIN `quiz_escala`  esc_2      ON esc_2.idEscala         = quiz_listado.Porcentaje_apro

WHERE quiz_realizadas.idQuizRealizadas = ".$_GET['evaluar']."
";
$resultado = mysqli_query($dbConn, $query);
$row_data = mysqli_fetch_assoc ($resultado);

// Se trae un listado con todas las preguntas
$arrPreguntas = array();
$query = "SELECT
quiz_listado_preguntas.idPregunta, 
quiz_listado_preguntas.Nombre AS Pregunta,
quiz_listado_preguntas.idTipo,
quiz_listado_preguntas.Opcion_1,
quiz_listado_preguntas.Opcion_2,
quiz_listado_preguntas.Opcion_3,
quiz_listado_preguntas.Opcion_4,
quiz_listado_preguntas.Opcion_5,
quiz_listado_preguntas.Opcion_6,
quiz_listado_preguntas.OpcionCorrecta,
quiz_categorias.Nombre AS Categoria

FROM `quiz_listado_preguntas`
LEFT JOIN `quiz_categorias`  ON quiz_categorias.idCategoria   = quiz_listado_preguntas.idCategoria
WHERE quiz_listado_preguntas.idQuiz = {$row_data['idQuiz']}
ORDER BY quiz_listado_preguntas.idCategoria ASC
";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrPreguntas,$row );
}

/********************************************/

//Obtengo el total de preguntas
$total_preg = 0;
for ($i = 1; $i <= 100; $i++) {
	if(isset($row_data['Pregunta_'.$i])&&$row_data['Pregunta_'.$i]!=0){
		$total_preg++;
	}
}

$arrTemporal = array();
unset( $arrTemporal );

foreach ($arrPreguntas as $preg) {
	$arrTemporal[$preg['idPregunta']]['idPregunta']        = $preg['idPregunta'];
	$arrTemporal[$preg['idPregunta']]['Pregunta']          = $preg['Pregunta'];
	$arrTemporal[$preg['idPregunta']]['idTipo']            = $preg['idTipo'];
	$arrTemporal[$preg['idPregunta']]['Opcion_1']          = $preg['Opcion_1'];
	$arrTemporal[$preg['idPregunta']]['Opcion_2']          = $preg['Opcion_2'];
	$arrTemporal[$preg['idPregunta']]['Opcion_3']          = $preg['Opcion_3'];
	$arrTemporal[$preg['idPregunta']]['Opcion_4']          = $preg['Opcion_4'];
	$arrTemporal[$preg['idPregunta']]['Opcion_5']          = $preg['Opcion_5'];
	$arrTemporal[$preg['idPregunta']]['Opcion_6']          = $preg['Opcion_6'];
	$arrTemporal[$preg['idPregunta']]['OpcionCorrecta']    = $preg['OpcionCorrecta'];
	$arrTemporal[$preg['idPregunta']]['Categoria']         = $preg['Categoria'];
	
}
//Calculo del tiempo restante
$horaini = hora_actual();
$horafin = sumahoras($row_data['Ejecucion_hora'],$row_data['Duracion_Max']);
$hora = restahoras($horaini, $horafin); 

?>
	 
<script>
$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url'],select,textarea"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        $(".field").removeClass("bad");
        for(let i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".field").addClass("bad");
                warning = $('<div class="alert">').html( 'Ingrese dato obligatorio' );
                $(curInputs[i]).closest(".field").append( warning );

            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');
});
</script>


<?php if (isset($row_data['idLimiteTiempo'])&&$row_data['idLimiteTiempo']==1){ ?>
	<div class="col-sm-12">
		<div class="col-sm-3 fright">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<div class="row">
						<div class="col-xs-3">
							<i class="fa fa-bell fa-2x" aria-hidden="true"></i>
						</div>
						<div class="col-xs-9 text-right">
							<div class="timer-time timer-container">
								<div class="timer-time-set timer-box" id="currentTime">
									<span id="hoursValue">00</span><span>:</span><span id="minutesValue">00</span><span>:</span><span id="secondsValue">00</span>
								</div>
								<div class="timer-time-set timer-box" id="nextTime">
									<span id="hoursNext">00</span><span>:</span><span id="minutesNext">00</span><span>:</span><span id="secondsNext">00</span>
								</div>
							</div>
						</div>
					 </div>
				</div>        
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
	<script>
	let gHours          = 0;
	let gMinutes        = 0;
	let gSeconds        = 0;
	let remainingTime   = 0;
	let countdownHandle = 0;

	$(document).ready(function() {
		onPomodoroTimer();
		onStartTimer();
	});

	function onPomodoroTimer(){
		stopTimer();
		gHours = 0;
		gMinutes = <?php echo horas2minutos($hora); ?>;
		gSeconds = 0;
		resetTimer();
	}
	function onStartTimer(){
		stopTimer();
		startTimer();
	};
	function stopTimer() {
		clearInterval(countdownHandle);
	}
	function resetTimer(){
		remainingTime = (gHours*60*60*1000)+
		(gMinutes*60*1000)+
		(gSeconds*1000);
		renderTimer();
	}
	function startTimer() {
		countdownHandle=setInterval(function() {
			decrementTimer();
		},1000);
	}

	function renderTimer(){

		var deltaTime=remainingTime;

		var hoursValue=Math.floor(deltaTime/(1000*60*60));
		deltaTime=deltaTime%(1000*60*60);

		var minutesValue=Math.floor(deltaTime/(1000*60));
		deltaTime=deltaTime%(1000*60);

		var secondsValue=Math.floor(deltaTime/(1000));

		animateTime(hoursValue, minutesValue, secondsValue);
	};


	function animateTime(remainingHours, remainingMinutes, remainingSeconds) {

		// position
		$('#hoursValue').css('top', '0em');
		$('#minutesValue').css('top', '0em');
		$('#secondsValue').css('top', '0em');

		$('#hoursNext').css('top', '0em');
		$('#minutesNext').css('top', '0em');
		$('#secondsNext').css('top', '0em');

		var oldHoursString = $('#hoursNext').text();
		var oldMinutesString = $('#minutesNext').text();
		var oldSecondsString = $('#secondsNext').text();

		var hoursString = formatTime(remainingHours);
		var minutesString = formatTime(remainingMinutes);
		var secondsString = formatTime(remainingSeconds);

		$('#hoursValue').text(oldHoursString);
		$('#minutesValue').text(oldMinutesString);
		$('#secondsValue').text(oldSecondsString);

		$('#hoursNext').text(hoursString);
		$('#minutesNext').text(minutesString);
		$('#secondsNext').text(secondsString);

		// set and animate
		if(oldHoursString !== hoursString) {
			$('#hoursValue').animate({top: '-=1em'});
			$('#hoursNext').animate({top: '-=1em'});
		}

		if(oldMinutesString !== minutesString) {
			$('#minutesValue').animate({top: '-=1em'});
			$('#minutesNext').animate({top: '-=1em'});
		}

		if(oldSecondsString !== secondsString) {
			$('#secondsValue').animate({top: '-=1em'});
			$('#secondsNext').animate({top: '-=1em'});
		}
	}


	function formatTime(intergerValue){

		return intergerValue > 9 ? intergerValue.toString():'0'+intergerValue.toString();

	}

	function decrementTimer(){

		remainingTime-=(1*1000);

		if(remainingTime<1000){
			//ejecuto el formulario
			$("#submitCadastroHidden").click();
			//detengo el reloj
			onStopTimer();
			
		}

		renderTimer();
	}
	</script>
<?php } ?>	

 
<div class="container">
	
	<div class="stepwizard">
		<div class="stepwizard-row setup-panel">
			
			<?php 
			for ($i = 1; $i <= $total_preg; $i++) { 
				
				$in_x = '';
				$in_b = 'primary';
				if($i>1){$in_x = 'disabled="disabled"';$in_b = 'default';}
				
				echo '<div class="stepwizard-step">';
					echo '<a href="#step-'.$i.'" type="button" class="btn btn-'.$in_b.' btn-circle" '.$in_x.'>'.$i.'</a>';
				echo '</div>';
			} 
			//Pantalla de resumen
			echo '<div class="stepwizard-step">';
				echo '<a href="#step-'.$i.'" type="button" class="btn btn-default btn-circle" disabled="disabled">'.$i.'</a>';
			echo '</div>';
			
			?>
		</div>
	</div>

	<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
		
		<?php 
			for ($i = 1; $i <= $total_preg; $i++) { 
				echo '<div class="row setup-content" id="step-'.$i.'">';
					echo '<div class="col-xs-12">';
						echo '<div class="col-md-12">';
							//Categoria y pregunta
							echo '<h3>'.$arrTemporal[$row_data['Pregunta_'.$i]]['Categoria'].'</h3>';
							echo '<h4>'.$arrTemporal[$row_data['Pregunta_'.$i]]['Pregunta'].'</h4>';
							
							$Opcion_1 = $arrTemporal[$row_data['Pregunta_'.$i]]['Opcion_1'];
							$Opcion_2 = $arrTemporal[$row_data['Pregunta_'.$i]]['Opcion_2'];
							$Opcion_3 = $arrTemporal[$row_data['Pregunta_'.$i]]['Opcion_3'];
							$Opcion_4 = $arrTemporal[$row_data['Pregunta_'.$i]]['Opcion_4'];
							$Opcion_5 = $arrTemporal[$row_data['Pregunta_'.$i]]['Opcion_5'];
							$Opcion_6 = $arrTemporal[$row_data['Pregunta_'.$i]]['Opcion_6'];
							
							//selecciono el tipo de pregunta que se esta realizando
							switch ($arrTemporal[$row_data['Pregunta_'.$i]]['idTipo']) {
								
								/**************************************************************************************************/
								//Seleccion Unica
								case 1:
									if($Opcion_1!=''){echo '<div class="radio"><input type="radio" value="1" name="Respuesta_'.$i.'"><label>'.$Opcion_1.'</label></div>';}
									if($Opcion_2!=''){echo '<div class="radio"><input type="radio" value="2" name="Respuesta_'.$i.'"><label>'.$Opcion_2.'</label></div>';}
									if($Opcion_3!=''){echo '<div class="radio"><input type="radio" value="3" name="Respuesta_'.$i.'"><label>'.$Opcion_3.'</label></div>';}
									if($Opcion_4!=''){echo '<div class="radio"><input type="radio" value="4" name="Respuesta_'.$i.'"><label>'.$Opcion_4.'</label></div>';}
									if($Opcion_5!=''){echo '<div class="radio"><input type="radio" value="5" name="Respuesta_'.$i.'"><label>'.$Opcion_5.'</label></div>';}
									if($Opcion_6!=''){echo '<div class="radio"><input type="radio" value="6" name="Respuesta_'.$i.'"><label>'.$Opcion_6.'</label></div>';}
									
									break;
								
								/**************************************************************************************************/
								//Seleccion Multiple
								case 2:
									if($Opcion_1!=''){echo '<div class="checkbox checkbox-primary"><input type="checkbox" value="1" name="Respuesta_'.$i.'"><label>'.$Opcion_1.'</label></div>';}
									if($Opcion_2!=''){echo '<div class="checkbox checkbox-primary"><input type="checkbox" value="2" name="Respuesta_'.$i.'"><label>'.$Opcion_2.'</label></div>';}
									if($Opcion_3!=''){echo '<div class="checkbox checkbox-primary"><input type="checkbox" value="3" name="Respuesta_'.$i.'"><label>'.$Opcion_3.'</label></div>';}
									if($Opcion_4!=''){echo '<div class="checkbox checkbox-primary"><input type="checkbox" value="4" name="Respuesta_'.$i.'"><label>'.$Opcion_4.'</label></div>';}
									if($Opcion_5!=''){echo '<div class="checkbox checkbox-primary"><input type="checkbox" value="5" name="Respuesta_'.$i.'"><label>'.$Opcion_5.'</label></div>';}
									if($Opcion_6!=''){echo '<div class="checkbox checkbox-primary"><input type="checkbox" value="6" name="Respuesta_'.$i.'"><label>'.$Opcion_6.'</label></div>';}
									
									break;
								
								/**************************************************************************************************/
								//Verdadero o Falso
								case 3:
									if($Opcion_1!=''){echo '<div class="radio"><input type="radio" value="1" name="Respuesta_'.$i.'"><label>'.$Opcion_1.'</label></div>';}
									if($Opcion_2!=''){echo '<div class="radio"><input type="radio" value="2" name="Respuesta_'.$i.'"><label>'.$Opcion_2.'</label></div>';}
									
									break;

								/**************************************************************************************************/
								//Observacion
								case 4:
									echo input_textarea_obs('Observacion','Respuesta_'.$i, 1,'margin-bottom:20px;','');
									
									break;
								
								/**************************************************************************************************/
								//Afirmacion
								case 5:
									
									echo '
										<style>
											.m_'.$i.'_fimg1{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/afirmacion_si.png);}
											.m_'.$i.'_fimg2{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/afirmacion_no.png);}
										</style>';

									echo '<div class="cc-selector">';
									
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg1" value="1" /><label class="formimage-cc m_'.$i.'_fimg1" for="m_'.$i.'_fimg1"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg2" value="2" /><label class="formimage-cc m_'.$i.'_fimg2" for="m_'.$i.'_fimg2"></label>';
	
									echo '</div>';
									break;
								
								/**************************************************************************************************/
								//Animo (3 caras)
								case 6:
									echo '
										<style>
											.m_'.$i.'_fimg1{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_1.png);}
											.m_'.$i.'_fimg2{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_3.png);}
											.m_'.$i.'_fimg3{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_5.png);}
										</style>';

									echo '<div class="cc-selector">';
									
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg1" value="1" /><label class="formimage-cc m_'.$i.'_fimg1" for="m_'.$i.'_fimg1"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg2" value="2" /><label class="formimage-cc m_'.$i.'_fimg2" for="m_'.$i.'_fimg2"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg3" value="3" /><label class="formimage-cc m_'.$i.'_fimg3" for="m_'.$i.'_fimg3"></label>';
										
									echo '</div>';
									break;
								
								/**************************************************************************************************/
								//Animo (4 caras)	
								case 7:
									echo '
										<style>
											.m_'.$i.'_fimg1{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_2.png);}
											.m_'.$i.'_fimg2{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_3.png);}
											.m_'.$i.'_fimg3{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_4.png);}
											.m_'.$i.'_fimg4{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_5.png);}
										</style>';

									echo '<div class="cc-selector">';
									
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg1" value="1" /><label class="formimage-cc m_'.$i.'_fimg1" for="m_'.$i.'_fimg1"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg2" value="2" /><label class="formimage-cc m_'.$i.'_fimg2" for="m_'.$i.'_fimg2"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg3" value="3" /><label class="formimage-cc m_'.$i.'_fimg3" for="m_'.$i.'_fimg3"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg4" value="4" /><label class="formimage-cc m_'.$i.'_fimg4" for="m_'.$i.'_fimg4"></label>';
										
									echo '</div>';
									break;
								
								/**************************************************************************************************/
								//Animo (5 caras)	
								case 8:
									echo '
										<style>
											.m_'.$i.'_fimg1{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_1.png);}
											.m_'.$i.'_fimg2{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_2.png);}
											.m_'.$i.'_fimg3{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_3.png);}
											.m_'.$i.'_fimg4{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_4.png);}
											.m_'.$i.'_fimg5{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_5.png);}
										</style>';

									echo '<div class="cc-selector">';
									
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg1" value="1" /><label class="formimage-cc m_'.$i.'_fimg1" for="m_'.$i.'_fimg1"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg2" value="2" /><label class="formimage-cc m_'.$i.'_fimg2" for="m_'.$i.'_fimg2"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg3" value="3" /><label class="formimage-cc m_'.$i.'_fimg3" for="m_'.$i.'_fimg3"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg4" value="4" /><label class="formimage-cc m_'.$i.'_fimg4" for="m_'.$i.'_fimg4"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg5" value="5" /><label class="formimage-cc m_'.$i.'_fimg5" for="m_'.$i.'_fimg5"></label>';
										
									echo '</div>';
									break;
								/**************************************************************************************************/
								//Valor (1 a 3)	
								case 9:
									echo '
										<style>
											.m_'.$i.'_fimg1{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_1.png);}
											.m_'.$i.'_fimg2{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_2.png);}
											.m_'.$i.'_fimg3{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_3.png);}
										</style>';

									echo '<div class="cc-selector">';
									
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg1" value="1" /><label class="formimage-cc m_'.$i.'_fimg1" for="m_'.$i.'_fimg1"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg2" value="2" /><label class="formimage-cc m_'.$i.'_fimg2" for="m_'.$i.'_fimg2"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg3" value="3" /><label class="formimage-cc m_'.$i.'_fimg3" for="m_'.$i.'_fimg3"></label>';
										
									echo '</div>';
									break;
								
								/**************************************************************************************************/
								//Valor (1 a 4)	
								case 10:
									echo '
										<style>
											.m_'.$i.'_fimg1{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_1.png);}
											.m_'.$i.'_fimg2{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_2.png);}
											.m_'.$i.'_fimg3{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_3.png);}
											.m_'.$i.'_fimg4{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_4.png);}
										</style>';

									echo '<div class="cc-selector">';
									
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg1" value="1" /><label class="formimage-cc m_'.$i.'_fimg1" for="m_'.$i.'_fimg1"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg2" value="2" /><label class="formimage-cc m_'.$i.'_fimg2" for="m_'.$i.'_fimg2"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg3" value="3" /><label class="formimage-cc m_'.$i.'_fimg3" for="m_'.$i.'_fimg3"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg4" value="4" /><label class="formimage-cc m_'.$i.'_fimg4" for="m_'.$i.'_fimg4"></label>';
										
									echo '</div>';
									break;
								
								/**************************************************************************************************/
								//Valor (1 a 5)	
								case 11:
									echo '
										<style>
											.m_'.$i.'_fimg1{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_1.png);}
											.m_'.$i.'_fimg2{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_2.png);}
											.m_'.$i.'_fimg3{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_3.png);}
											.m_'.$i.'_fimg4{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_4.png);}
											.m_'.$i.'_fimg5{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_5.png);}
										</style>';

									echo '<div class="cc-selector">';
									
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg1" value="1" /><label class="formimage-cc m_'.$i.'_fimg1" for="m_'.$i.'_fimg1"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg2" value="2" /><label class="formimage-cc m_'.$i.'_fimg2" for="m_'.$i.'_fimg2"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg3" value="3" /><label class="formimage-cc m_'.$i.'_fimg3" for="m_'.$i.'_fimg3"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg4" value="4" /><label class="formimage-cc m_'.$i.'_fimg4" for="m_'.$i.'_fimg4"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg5" value="5" /><label class="formimage-cc m_'.$i.'_fimg5" for="m_'.$i.'_fimg5"></label>';
										
									echo '</div>';
									break;
								
								/**************************************************************************************************/	
								//Voto	
								case 12:
									echo '
										<style>
											.m_'.$i.'_fimg1{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/voto_si.png);}
											.m_'.$i.'_fimg2{background-image:url('.DB_SITE_REPO.'/Legacy/gestion_modular/img/voto_no.png);}
										</style>';

									echo '<div class="cc-selector">';
									
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg1" value="1" /><label class="formimage-cc m_'.$i.'_fimg1" for="m_'.$i.'_fimg1"></label>';
										echo '<input type="radio" name="Respuesta_'.$i.'" id="m_'.$i.'_fimg2" value="2" /><label class="formimage-cc m_'.$i.'_fimg2" for="m_'.$i.'_fimg2"></label>';
	
									echo '</div>';
									break;
									
								
							}
							
							//Envio la respuesta correcta
							echo '<input type="hidden" name="Correcta_'.$i.'"   value="'.$arrTemporal[$row_data['Pregunta_'.$i]]['OpcionCorrecta'].'">';
							//envio los tipos de preguntas para ver si son medibles
							echo '<input type="hidden" name="Tipo_'.$i.'"   value="'.$arrTemporal[$row_data['Pregunta_'.$i]]['idTipo'].'">';
							
							
							echo '<button class="btn btn-primary nextBtn pull-right" type="button" ><i class="fa fa-long-arrow-right" aria-hidden="true"></i> Siguiente</button>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
	
			}
			echo '
			<div class="row setup-content" id="step-'.$i.'">
				<div class="col-xs-12">
				
					<div class="col-md-12">
						<h3> Resumen</h3>';
						
						for ($i = 1; $i <= $total_preg; $i++) {
							echo '<p class="txt_tittle"><strong>Pregunta '.$i.' : '.$arrTemporal[$row_data['Pregunta_'.$i]]['Pregunta'].'</strong></p>';
							echo '<p id="txt_respuesta_'.$i.'"></p>';
						}	
					
					
							
									
					echo '</div>';
					
					//Otros Datos	
					echo '<input type="hidden" name="idQuizRealizadas"  value="'.$_GET['evaluar'].'">';
					//Calculo de evaluacion
					echo '<input type="hidden" name="idTipoEvaluacion"  value="'.$row_data['idTipoEvaluacion'].'">';
					echo '<input type="hidden" name="PorcentajeMin"     value="'.$row_data['PorcentajeMin'].'">';
					echo '<input type="hidden" name="PuntajeMin"        value="'.$row_data['PuntajeMin'].'">';
					
					
					
					/********************************************************************/
					//tipo de quiz
					//Cerrada
					if(isset($rowdata['idTipoQuiz'])&&$rowdata['idTipoQuiz']==1){
						echo '
						<div class="col-md-12" style="margin-top:10px;">
							<input type="submit" id="submitCadastroHidden" style="display: none;" name="submit_form">
							<input type="button" id="submitBtn" data-toggle="modal" data-target="#confirm-submit"  class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Finalizar" name="submit2">
						</div>';
					//Abierta 	
					}else{
						echo '
						<div class="col-md-12" style="margin-top:10px;">
							<input type="submit" id="submitCadastroHidden" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Finalizar" name="submit_form">
						</div>';
					}

						
				echo '
				</div>
			</div>'; 
			?>
			
			<?php 
			//Se muestra cuadro dialogo solo si la quiz esta cerrada
			if (isset($row_data['idTipoQuiz'])&&$row_data['idTipoQuiz']==1){ ?>
				<div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								Confirmar Termino
							</div>
							<div class="modal-body">
								<p id="confirmacion"></p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
								<a href="#" id="submitmodal" class="btn btn-success success">Confirmar</a>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		
	</form>
	<?php widget_validator(); ?> 
</div>

<?php 
//Se comprueban respuestas solo si la quiz esta cerrada
if (isset($row_data['idTipoQuiz'])&&$row_data['idTipoQuiz']==1){ ?>
		
	<script>

		function getRadioValue (myradiobutton) {
			if( $('input[name=' + myradiobutton + ']:radio:checked').length > 0 ) {
				return $('input[name=' + myradiobutton + ']:radio:checked').val();
			}else {
				return 0;
			}
		}
		
		function getCheckboxValue (myradiobutton) {
			if( $('input[name=' + myradiobutton + ']:checkbox:checked').length > 0 ) {
				return $('input[name=' + myradiobutton + ']:checkbox:checked').val();
			}else {
				return 0;
			}
		}

		$(document).ready( function() {
			<?php for ($i = 1; $i <= $total_preg; $i++) { 
				switch ($arrTemporal[$row_data['Pregunta_'.$i]]['idTipo']) { 
					
					/**************************************************************************************************/
					//Seleccion Unica
					case 1:
						if($Opcion_1!=''){echo 'var_'.$i.'_1="'.$Opcion_1.'";';}
						if($Opcion_2!=''){echo 'var_'.$i.'_2="'.$Opcion_2.'";';}
						if($Opcion_3!=''){echo 'var_'.$i.'_3="'.$Opcion_3.'";';}
						if($Opcion_4!=''){echo 'var_'.$i.'_4="'.$Opcion_4.'";';}
						if($Opcion_5!=''){echo 'var_'.$i.'_5="'.$Opcion_5.'";';}
						if($Opcion_6!=''){echo 'var_'.$i.'_6="'.$Opcion_6.'";';}
					
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
								case "3":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_3;
									break;
								case "4":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_4;
									break;
								case "5":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_5;
									break;
								case "6":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_6;
									break;
							}
						});';				
					break;
									
					/**************************************************************************************************/
					//Seleccion Multiple
					case 2:
						if($Opcion_1!=''){echo 'var_'.$i.'_1="'.$Opcion_1.'";';}
						if($Opcion_2!=''){echo 'var_'.$i.'_2="'.$Opcion_2.'";';}
						if($Opcion_3!=''){echo 'var_'.$i.'_3="'.$Opcion_3.'";';}
						if($Opcion_4!=''){echo 'var_'.$i.'_4="'.$Opcion_4.'";';}
						if($Opcion_5!=''){echo 'var_'.$i.'_5="'.$Opcion_5.'";';}
						if($Opcion_6!=''){echo 'var_'.$i.'_6="'.$Opcion_6.'";';}
						
						echo '$("input[name=Respuesta_'.$i.']:checkbox").click( function() {
							switch (getCheckboxValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
								case "3":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_3;
									break;
								case "4":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_4;
									break;
								case "5":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_5;
									break;
								case "6":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_6;
									break;
							}
						});';
					break;
									
					/**************************************************************************************************/
					//Verdadero o Falso
					case 3:
						if($Opcion_1!=''){echo 'var_'.$i.'_1="'.$Opcion_1.'";';}
						if($Opcion_2!=''){echo 'var_'.$i.'_2="'.$Opcion_2.'";';}
					
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
							}
						});';
					break;

					/**************************************************************************************************/
					//Observacion
					case 4:
						/*echo '
							if ($("Respuesta_'.$i.'").val() != "") {
								alert($("Respuesta_'.$i.'").val());
								document.getElementById("txt_respuesta_'.$i.'").innerHTML = $("Respuesta_'.$i.'").val();
							}
						';*/
						//echo 'document.getElementById("txt_respuesta_'.$i.'").innerHTML = document.getElementById("Respuesta_'.$i.'").value';
					break;
									
					/**************************************************************************************************/
					//Afirmacion
					case 5:
						echo 'var_'.$i.'_1="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/afirmacion_si.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_2="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/afirmacion_no.png\' height=\'42\' width=\'42\'>";';
										
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
							}
						});';
					break;
									
					/**************************************************************************************************/
					//Animo (3 caras)
					case 6:
						echo 'var_'.$i.'_1="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_1.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_2="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_3.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_3="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_5.png\' height=\'42\' width=\'42\'>";';
										
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
								case "3":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_3;
									break;
							}
						});';
					break;
									
					/**************************************************************************************************/
					//Animo (4 caras)	
					case 7:
						echo 'var_'.$i.'_1="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_2.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_2="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_3.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_3="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_4.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_4="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_5.png\' height=\'42\' width=\'42\'>";';
										
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
								case "3":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_3;
									break;
								case "4":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_4;
									break;
							}
						});';
					break;
									
					/**************************************************************************************************/
					//Animo (5 caras)	
					case 8:
						echo 'var_'.$i.'_1="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_1.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_2="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_2.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_3="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_3.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_4="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_4.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_5="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/cara_5.png\' height=\'42\' width=\'42\'>";';
										
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
								case "3":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_3;
									break;
								case "4":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_4;
									break;
								case "5":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_5;
									break;
							}
						});';
					break;
					/**************************************************************************************************/
					//Valor (1 a 3)	
					case 9:
						echo 'var_'.$i.'_1="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_1.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_2="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_2.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_3="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_3.png\' height=\'42\' width=\'42\'>";';
										
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
								case "3":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_3;
									break;
							}
						});';
					break;
									
					/**************************************************************************************************/
					//Valor (1 a 4)	
					case 10:
						echo 'var_'.$i.'_1="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_1.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_2="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_2.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_3="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_3.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_4="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_4.png\' height=\'42\' width=\'42\'>";';
										
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
								case "3":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_3;
									break;
								case "4":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_4;
									break;
							}
						});';
					break;
									
					/**************************************************************************************************/
					//Valor (1 a 5)	
					case 11:
						echo 'var_'.$i.'_1="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_1.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_2="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_2.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_3="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_3.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_4="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_4.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_5="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/valor_5.png\' height=\'42\' width=\'42\'>";';
										
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
								case "3":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_3;
									break;
								case "4":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_4;
									break;
								case "5":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_5;
									break;
							}
						});';
					break;
									
					/**************************************************************************************************/	
					//Voto	
					case 12:
						echo 'var_'.$i.'_1="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/voto_si.png\' height=\'42\' width=\'42\'>";';
						echo 'var_'.$i.'_2="<img src=\''.DB_SITE_REPO.'/Legacy/gestion_modular/img/voto_no.png\' height=\'42\' width=\'42\'>";';
										
						echo '$("input[name=Respuesta_'.$i.']:radio").click( function() {
							
							switch (getRadioValue("Respuesta_'.$i.'")) {
								case "1":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_1;
									break;
								case "2":
									document.getElementById("txt_respuesta_'.$i.'").innerHTML = var_'.$i.'_2;
									break;
							}
						});';
					break;
					
					
					
					?>
				
				<?php } ?>
			<?php } ?>
		});

		/*****************************************************************/
		$('#submitBtn').click(function() {
			//variable que cuenta los vacios
			let ninput = 0;
			
			//Se verifica que todos los input tengan valores asignados
			<?php for ($i = 1; $i <= $total_preg; $i++) {
				switch ($arrTemporal[$row_data['Pregunta_'.$i]]['idTipo']) { 
					
					/**************************************************************************************************/
					case 1:   //Seleccion Unica
					case 3:   //Verdadero o Falso
					case 5:   //Afirmacion
					case 6:   //Animo (3 caras)
					case 7:   //Animo (4 caras)	
					case 8:   //Animo (5 caras)	
					case 9:   //Valor (1 a 3)	
					case 10:  //Valor (1 a 4)	
					case 11:  //Valor (1 a 5)	
					case 12:  //Voto	
						
						echo ' if(getRadioValue("Respuesta_'.$i.'") == 0){
							ninput++;
						} ';
					break;				
					/**************************************************************************************************/
					//Seleccion Multiple
					case 2:
						echo ' if(getCheckboxValue("Respuesta_'.$i.'") == 0){
							ninput++;
						} ';
					break;
					/**************************************************************************************************/
					//Observacion
					case 4:
						/*echo '
							if ($("Respuesta_'.$i.'").val() == "") {
								ninput++;
							}
						';*/
					break;
				}
			} ?>

					
			//verifica el valor
			var total_preg = <?php echo $total_preg; ?>;
			if(total_preg!=0&&ninput==0){
				$('#submitmodal').show();
				$('#confirmacion').text('Confirmo que he respondido y he revisado todas las preguntas antes de la entrega');
			}else{
				$('#submitmodal').hide();
				$('#confirmacion').text('Una o mas preguntas no han sido respondidas ('+ninput+' preguntas)');
			}
		});

		$('#submitmodal').click(function(){
			$("#submitCadastroHidden").click(); 
		});

		
	</script>
<?php } ?> 
	 
 


<?php } ?>

		
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

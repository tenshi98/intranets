<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo.');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';	
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if ( !empty($_POST['idAsignar']) )            $idAsignar               = $_POST['idAsignar'];
	if ( !empty($_POST['idCurso']) )              $idCurso                 = $_POST['idCurso'];
	if ( !empty($_POST['idQuiz']) )               $idQuiz                  = $_POST['idQuiz'];
	if ( !empty($_POST['Programada_fecha']) )     $Programada_fecha        = $_POST['Programada_fecha'];
	if ( !empty($_POST['idSistema']) )            $idSistema               = $_POST['idSistema'];
	if ( !empty($_POST['idAsignadas']) )          $idAsignadas             = $_POST['idAsignadas'];
	
	//Categorias
	$categoria   = array();
	$n_categoria = array();
	for ($i = 1; $i <= 30; $i++) {
		if ( !empty($_POST['categoria_'.$i]) )    $categoria[$i]     = $_POST['categoria_'.$i];
		if ( !empty($_POST['n_categoria_'.$i]) )  $n_categoria[$i]   = $_POST['n_categoria_'.$i];
	}
	
	
	//Respuestas
	if ( !empty($_POST['idQuizRealizadas']) )     $idQuizRealizadas     = $_POST['idQuizRealizadas'];
	if ( !empty($_POST['idTipoEvaluacion']) )     $idTipoEvaluacion     = $_POST['idTipoEvaluacion'];
	if ( !empty($_POST['PorcentajeMin']) )        $PorcentajeMin        = $_POST['PorcentajeMin'];
	if ( !empty($_POST['PuntajeMin']) )           $PuntajeMin           = $_POST['PuntajeMin'];
	$Respuesta   = array();
	$Correcta = array();
	for ($i = 1; $i <= 100; $i++) {
		if ( !empty($_POST['Respuesta_'.$i]) ) $Respuesta[$i]     = $_POST['Respuesta_'.$i];
		if ( !empty($_POST['Correcta_'.$i]) )  $Correcta[$i]      = $_POST['Correcta_'.$i];
		if ( !empty($_POST['Tipo_'.$i]) )      $TipoPregunta[$i]  = $_POST['Tipo_'.$i];
	}

	
/*******************************************************************************************************************/
/*                                      Verificacion de los datos obligatorios                                     */
/*******************************************************************************************************************/

	//limpio y separo los datos de la cadena de comprobacion
	$form_obligatorios = str_replace(' ', '', $_SESSION['form_require']);
	$INT_piezas = explode(",", $form_obligatorios);
	//recorro los elementos
	foreach ($INT_piezas as $INT_valor) {
		//veo si existe el dato solicitado y genero el error
		switch ($INT_valor) {
			case 'idAsignar':         if(empty($idAsignar)){         $error['idAsignar']         = 'error/No ha seleccionado el tipo de asignacion';}break;
			case 'idCurso':           if(empty($idCurso)){           $error['idCurso']           = 'error/No ha seleccionado el curso';}break;
			case 'idQuiz':            if(empty($idQuiz)){            $error['idQuiz']            = 'error/No ha seleccionado una evaluacion';}break;
			case 'Programada_fecha':  if(empty($Programada_fecha)){  $error['Programada_fecha']  = 'error/No ha ingresado la fecha de programacion';}break;
			case 'idSistema':         if(empty($idSistema)){         $error['idSistema']         = 'error/No ha seleccionado el sistema';}break;
			case 'idAsignadas':       if(empty($idAsignadas)){       $error['idAsignadas']       = 'error/No ha seleccionado el id';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                           Validacion de respuestas                                              */
/*******************************************************************************************************************/
	for ($i = 1; $i <= 30; $i++) {
		if(isset($categoria[$i])&&isset($n_categoria[$i])&&$categoria[$i]>$n_categoria[$i]){
			$error['n_categoria_'.$i]      = 'error/La cantidad es superior a la permitida';
		}
	}
	

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/		
		case 'update':
		
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//variables
				$idEstadoAprobacion  = 0;
				$Respondido          = 0;
				$Rendimiento         = 0;
				
				$R_Correctas         = 0;
				$R_Respuestas        = 0;
				
				//Filtros
				$a = "idQuizRealizadas='".$idQuizRealizadas."'" ;
				//validaciones
				for ($i = 1; $i <= 100; $i++) {
					//guardo la respuesta
					if(isset($Respuesta[$i]) && $Respuesta[$i] != ''){   
						$a .= ",Respuesta_".$i."='".$Respuesta[$i]."'" ; 
						//sumo la cantidad de respuestas dadas
						$Respondido++;       
					}else{
						$a .= ",Respuesta_".$i."=''";
					}
					//Reviso la cantidad de respuestas correctas
					if(isset($Correcta[$i]) && $Correcta[$i] != ''&&$Correcta[$i] != 0&&isset($Respuesta[$i]) && $Respuesta[$i] != ''){   
						//si la respuesta es correcta
						if($Correcta[$i]==$Respuesta[$i]){
							$R_Correctas++;
						}
					}
					//Reviso la cantidad de respuestas dadas que pedian respuestas
					if(isset($Correcta[$i]) && $Correcta[$i] != ''&&$Correcta[$i] != 0){   
						$R_Respuestas++;
					}
				}
				//Escala
				if(isset($idTipoEvaluacion)&&$idTipoEvaluacion==1){
				//pedir formulas
				
				//Porcentaje	
				}elseif(isset($idTipoEvaluacion)&&$idTipoEvaluacion==2){
					//se realizan calulos de rendimiento
					$Rendimiento = ($R_Correctas*100)/$R_Respuestas;
					if($Rendimiento<$PorcentajeMin){
						$idEstadoAprobacion = 1;//reprobado
					}else{
						$idEstadoAprobacion = 2;//aprobado
					}
					//resto de datos
					$a .= ",idEstado=2" ;
					$a .= ",idEstadoAprobacion='".$idEstadoAprobacion."'" ;  
					$a .= ",Respondido='".$Respondido."'" ;
					$a .= ",Correctas='".$R_Correctas."'" ;
					$a .= ",Rendimiento='".$Rendimiento."'" ;
					
					//se actualizan los datos
					$resultado = db_update_data (false, $a, 'quiz_realizadas', 'idQuizRealizadas = "'.$idQuizRealizadas.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
					header( 'Location: principal.php?rendida=true' );
					die;
				}
				
				
				
			}
		
		break;						
/*******************************************************************************************************************/
	}
?>

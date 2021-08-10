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
	if ( !empty($_POST['idCosto']) )            $idCosto            = $_POST['idCosto'];
	if ( !empty($_POST['idTipo']) )             $idTipo             = $_POST['idTipo'];
	if ( !empty($_POST['idUsuario']) )          $idUsuario          = $_POST['idUsuario'];
	if ( !empty($_POST['idVehiculo']) )         $idVehiculo         = $_POST['idVehiculo'];
	if ( !empty($_POST['Creacion_fecha']) )     $Creacion_fecha     = $_POST['Creacion_fecha'];
	if ( !empty($_POST['Creacion_mes']) )       $Creacion_mes       = $_POST['Creacion_mes'];
	if ( !empty($_POST['Creacion_ano']) )       $Creacion_ano       = $_POST['Creacion_ano'];
	if ( !empty($_POST['Valor']) )              $Valor              = $_POST['Valor'];
	if ( !empty($_POST['Observaciones']) )      $Observaciones      = $_POST['Observaciones'];
	
	
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
			case 'idCosto':         if(empty($idCosto)){           $error['idCosto']            = 'error/No ha ingresado el id';}break;
			case 'idTipo':          if(empty($idTipo)){            $error['idTipo']             = 'error/No ha seleccionado el tipo';}break;
			case 'idUsuario':       if(empty($idUsuario)){         $error['idUsuario']          = 'error/No ha seleccionado el usuario';}break;
			case 'idVehiculo':      if(empty($idVehiculo)){        $error['idVehiculo']         = 'error/No ha seleccionado el vehiculo';}break;
			case 'Creacion_fecha':  if(empty($Creacion_fecha)){    $error['Creacion_fecha']     = 'error/No ha ingresado la fecha de creacion';}break;
			case 'Creacion_mes':    if(empty($Creacion_mes)){      $error['Creacion_mes']       = 'error/No ha ingresado el mes de creacion';}break;
			case 'Creacion_ano':    if(empty($Creacion_ano)){      $error['Creacion_ano']       = 'error/No ha ingresado el año de creacion';}break;
			case 'Valor':           if(empty($Valor)){             $error['Valor']              = 'error/No ha ingresado el valor';}break;
			case 'Observaciones':   if(empty($Observaciones)){     $error['Observaciones']      = 'error/No ha ingresado la observacion';}break;
			
		}
	}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/		
		case 'insert':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//filtros
				if(isset($idTipo) && $idTipo != ''){            $a = "'".$idTipo."'" ;         }else{$a ="''";}
				if(isset($idUsuario) && $idUsuario != ''){      $a .= ",'".$idUsuario."'" ;    }else{$a .=",''";}
				if(isset($idVehiculo) && $idVehiculo != ''){    $a .= ",'".$idVehiculo."'" ;   }else{$a .=",''";}
				if(isset($Creacion_fecha) && $Creacion_fecha != ''){  
					$a .= ",'".$Creacion_fecha."'" ;  
					$a .= ",'".fecha2NMes($Creacion_fecha)."'" ;
					$a .= ",'".fecha2Ano($Creacion_fecha)."'" ;
				}else{
					$a .= ",''";
					$a .= ",''";
					$a .= ",''";
				}
				if(isset($Valor) && $Valor != ''){                    $a .= ",'".$Valor."'" ;           }else{$a .=",''";}
				if(isset($Observaciones) && $Observaciones != ''){    $a .= ",'".$Observaciones."'" ;   }else{$a .=",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `vehiculos_costos` (idTipo, idUsuario, idVehiculo, Creacion_fecha, Creacion_mes,
				Creacion_ano, Valor, Observaciones) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if($resultado){
					
					header( 'Location: '.$location.'&created=true' );
					die;
					
				//si da error, guardar en el log de errores una copia
				}else{
					//Genero numero aleatorio
					$vardata = genera_password(8,'alfanumerico');
					
					//Guardo el error en una variable temporal
					$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
					$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
					$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
				}
			}
	
		break;
/*******************************************************************************************************************/		
		case 'update':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idCosto='".$idCosto."'" ;
				if(isset($idTipo) && $idTipo != ''){                    $a .= ",idTipo='".$idTipo."'" ;}
				if(isset($idUsuario) && $idUsuario != ''){              $a .= ",idUsuario='".$idUsuario."'" ;}
				if(isset($idVehiculo) && $idVehiculo != ''){            $a .= ",idVehiculo='".$idVehiculo."'" ;}
				if(isset($Creacion_fecha) && $Creacion_fecha != ''){    $a .= ",Creacion_fecha='".$Creacion_fecha."'" ;}
				if(isset($Creacion_mes) && $Creacion_mes != ''){        $a .= ",Creacion_mes='".$Creacion_mes."'" ;}
				if(isset($Creacion_ano) && $Creacion_ano != ''){        $a .= ",Creacion_ano='".$Creacion_ano."'" ;}
				if(isset($Valor) && $Valor != ''){                      $a .= ",Valor='".$Valor."'" ;}
				if(isset($Observaciones) && $Observaciones != ''){      $a .= ",Observaciones='".$Observaciones."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'vehiculos_costos', 'idCosto = "'.$idCosto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					
					header( 'Location: '.$location.'&edited=true' );
					die;
					
				//si da error, guardar en el log de errores una copia
				}else{
					//Genero numero aleatorio
					$vardata = genera_password(8,'alfanumerico');
					
					//Guardo el error en una variable temporal
					$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
					$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
					$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
				}
			}
		
	
		break;	
							
/*******************************************************************************************************************/
		case 'del':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Variable
			$errorn = 0;
			
			//verifico si se envia un entero
			if((!validarNumero($_GET['del']) OR !validaEntero($_GET['del']))&&$_GET['del']!=''){
				$indice = simpleDecode($_GET['del'], fecha_actual());
			}else{
				$indice = $_GET['del'];
				//guardo el log
				php_error_log($_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo, '', 'Indice no codificado', '' );
				
			}
			
			//se verifica si es un numero lo que se recibe
			if (!validarNumero($indice)&&$indice!=''){ 
				$error['validarNumero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opcion DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice)&&$indice!=''){ 
				$error['validaEntero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opcion DEL  no es un numero entero';
				$errorn++;
			}
			
			if($errorn==0){
				//se borran los datos
				$resultado = db_delete_data (false, 'vehiculos_costos', 'idCosto = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					
					//redirijo
					header( 'Location: '.$location.'&deleted=true' );
					die;
					
				}
			}else{
				//se valida hackeo
				require_once '0_hacking_1.php';
			}
			
			

		break;							
					
/*******************************************************************************************************************/
	}
?>

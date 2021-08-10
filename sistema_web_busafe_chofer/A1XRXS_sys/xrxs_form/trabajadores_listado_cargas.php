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
	if ( !empty($_POST['idCarga']) )         $idCarga       = $_POST['idCarga'];
	if ( !empty($_POST['idTrabajador']) )    $idTrabajador  = $_POST['idTrabajador'];
	if ( !empty($_POST['Nombre']) )          $Nombre        = $_POST['Nombre'];
	if ( !empty($_POST['ApellidoPat']) )     $ApellidoPat   = $_POST['ApellidoPat'];
	if ( !empty($_POST['ApellidoMat']) )     $ApellidoMat   = $_POST['ApellidoMat'];
	if ( !empty($_POST['idSexo']) )          $idSexo        = $_POST['idSexo'];
	if ( !empty($_POST['FNacimiento']) )     $FNacimiento   = $_POST['FNacimiento'];

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
			case 'idCarga':        if(empty($idCarga)){       $error['idCarga']        = 'error/No ha ingresado el id';}break;
			case 'idTrabajador':   if(empty($idTrabajador)){  $error['idTrabajador']   = 'error/No ha seleccionado el trabajador';}break;
			case 'Nombre':         if(empty($Nombre)){        $error['Nombre']         = 'error/No ha ingresado el nombre';}break;
			case 'ApellidoPat':    if(empty($ApellidoPat)){   $error['ApellidoPat']    = 'error/No ha ingresado el apellido paterno';}break;
			case 'ApellidoMat':    if(empty($ApellidoMat)){   $error['ApellidoMat']    = 'error/No ha ingresado el apellido materno';}break;
			case 'idSexo':         if(empty($idSexo)){        $error['idSexo']         = 'error/No ha seleccionado el sexo';}break;
			case 'FNacimiento':    if(empty($FNacimiento)){   $error['FNacimiento']    = 'error/No ha ingresado la fecha de nacimiento';}break;
			
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
			
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'trabajadores_listado_cargas', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//filtros
				if(isset($idTrabajador) && $idTrabajador != ''){  $a  = "'".$idTrabajador."'" ;   }else{$a  ="''";}
				if(isset($Nombre) && $Nombre != ''){              $a .= ",'".$Nombre."'" ;        }else{$a .=",''";}
				if(isset($ApellidoPat) && $ApellidoPat != ''){    $a .= ",'".$ApellidoPat."'" ;   }else{$a .=",''";}
				if(isset($ApellidoMat) && $ApellidoMat != ''){    $a .= ",'".$ApellidoMat."'" ;   }else{$a .=",''";}
				if(isset($idSexo) && $idSexo != ''){              $a .= ",'".$idSexo."'" ;        }else{$a .=",''";}
				if(isset($FNacimiento) && $FNacimiento != ''){    $a .= ",'".$FNacimiento."'" ;   }else{$a .=",''";}
						
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `trabajadores_listado_cargas` (idTrabajador, Nombre, ApellidoPat, ApellidoMat,
				idSexo, FNacimiento ) 
				VALUES (".$a.")";
				$result = mysqli_query($dbConn, $query);
					
				header( 'Location: '.$location.'&created=true' );
				die;
				
			}
	
		break;
/*******************************************************************************************************************/		
		case 'update':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idCarga)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'trabajadores_listado_cargas', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idCarga!='".$idCarga."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//Filtros
				$a = "idCarga='".$idCarga."'" ;
				if(isset($idTrabajador) && $idTrabajador != ''){    $a .= ",idTrabajador='".$idTrabajador."'" ;}
				if(isset($Nombre) && $Nombre != ''){                $a .= ",Nombre='".$Nombre."'" ;}
				if(isset($ApellidoPat) && $ApellidoPat != ''){      $a .= ",ApellidoPat='".$ApellidoPat."'" ;}
				if(isset($ApellidoMat) && $ApellidoMat != ''){      $a .= ",ApellidoMat='".$ApellidoMat."'" ;}
				if(isset($idSexo) && $idSexo != ''){                $a .= ",idSexo='".$idSexo."'" ;}
				if(isset($FNacimiento) && $FNacimiento != ''){      $a .= ",FNacimiento='".$FNacimiento."'" ;}							
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'trabajadores_listado_cargas', 'idCarga = "'.$idCarga.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'&edited=true' );
					die;
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
				$resultado = db_delete_data (false, 'trabajadores_listado_cargas', 'idCarga = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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

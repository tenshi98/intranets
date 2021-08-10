<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridProspectoad                                                */
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
	if ( !empty($_POST['idProspecto']) )           $idProspecto             = $_POST['idProspecto'];
	if ( !empty($_POST['idSistema']) )             $idSistema               = $_POST['idSistema'];
	if ( !empty($_POST['Nombre']) )                $Nombre 	                = $_POST['Nombre'];
	if ( !empty($_POST['Fono']) )                  $Fono 	                = $_POST['Fono'];
	if ( !empty($_POST['email']) )                 $email                   = $_POST['email'];
	if ( !empty($_POST['email_noti']) )            $email_noti              = $_POST['email_noti'];
	if ( !empty($_POST['F_Ingreso']) )             $F_Ingreso               = $_POST['F_Ingreso'];
	if ( !empty($_POST['idEstadoFidelizacion']) )  $idEstadoFidelizacion    = $_POST['idEstadoFidelizacion'];
	if ( !empty($_POST['idEtapa']) )               $idEtapa                 = $_POST['idEtapa'];
	
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
			case 'idProspecto':            if(empty($idProspecto)){            $error['idProspecto']             = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){              $error['idSistema']               = 'error/No ha seleccionado el sistema';}break;
			case 'Nombre':                 if(empty($Nombre)){                 $error['Nombre']                  = 'error/No ha ingresado el Nombre del chofer';}break;
			case 'Fono':                   if(empty($Fono)){                   $error['Fono']                    = 'error/No ha ingresado el telefono';}break;
			case 'email':                  if(empty($email)){                  $error['email']                   = 'error/No ha ingresado el email';}break;
			case 'email_noti':             if(empty($email_noti)){             $error['email_noti']              = 'error/No ha ingresado el email de notificacion';}break;
			case 'F_Ingreso':              if(empty($F_Ingreso)){              $error['F_Ingreso']               = 'error/No ha ingresado la fecha de ingreso';}break;
			case 'idEstadoFidelizacion':   if(empty($idEstadoFidelizacion)){   $error['idEstadoFidelizacion']    = 'error/No ha seleccionado el estado de la fidelizacion';}break;
			case 'idEtapa':                if(empty($idEtapa)){                $error['idEtapa']                 = 'error/No ha seleccionado la etapa de la fidelizacion';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){           $error['email']      = 'error/El Email ingresado no es valido'; }
	if(isset($email_noti)&&!validarEmail($email_noti)){ $error['email_noti'] = 'error/El Email ingresado no es valido'; }
	if(isset($Fono)&&!validarNumero($Fono)) {           $error['Fono']       = 'error/Ingrese un numero telefonico valido'; }
	
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
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'prospectos_transportistas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'email', 'prospectos_transportistas_listado', '', "email='".$email."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/
			
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//filtros
				if(isset($idSistema) && $idSistema != ''){                           $a  = "'".$idSistema."'" ;               }else{$a ="''";}
				if(isset($Nombre) && $Nombre != ''){                                 $a .= ",'".$Nombre."'" ;                 }else{$a .= ",''";}
				if(isset($Fono) && $Fono != ''){                                     $a .= ",'".$Fono."'" ;                   }else{$a .= ",''";}
				if(isset($email) && $email != ''){                                   $a .= ",'".$email."'" ;                  }else{$a .= ",''";}
				if(isset($email_noti) && $email_noti != ''){                         $a .= ",'".$email_noti."'" ;             }else{$a .= ",''";}
				if(isset($F_Ingreso) && $F_Ingreso != ''){                           $a .= ",'".$F_Ingreso."'" ;              }else{$a .= ",''";}
				if(isset($idEstadoFidelizacion) && $idEstadoFidelizacion != ''){     $a .= ",'".$idEstadoFidelizacion."'" ;   }else{$a .= ",''";}
				if(isset($idEtapa) && $idEtapa != ''){                               $a .= ",'".$idEtapa."'" ;                }else{$a .= ",''";}
				
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `prospectos_transportistas_listado` (idSistema, Nombre, Fono, email, email_noti,
				F_Ingreso, idEstadoFidelizacion, idEtapa) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if($resultado){
					
					/**********************************************/
					//Se envia correo a gonzalo
					
					//datos del sistema
					$rowusr = db_select_data (false, 'Nombre, email_principal, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'core_sistemas', '', 'idSistema=1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					//Se crea cuerpo
					$texto  = '<p>Nuevo prospecto</p>'; 
					$texto .= '<p>';
					if(isset($Nombre) && $Nombre != ''){         $texto .= '<strong>Nombre Transportista: </strong>'.$Nombre.'<br/>';}
					if(isset($Fono) && $Fono != ''){             $texto .= '<strong>Telefono Transportista: </strong>'.$Fono.'<br/>';}
					if(isset($email) && $email != ''){           $texto .= '<strong>Correo Transportista: </strong>'.$email.'<br/>';}
					if(isset($email_noti) && $email_noti != ''){ $texto .= '<strong>Notificar a: </strong>'.$email_noti.'<br/>';}
					if(isset($F_Ingreso) && $F_Ingreso != ''){   $texto .= '<strong>Fecha: </strong>'.$F_Ingreso.'<br/>';}
					$texto .= '</p>';
					
					$rmail = tareas_envio_correo($rowusr['email_principal'], $rowusr['Nombre'], 
												 'gcampos@busafe.cl', 'Receptor', 
												 '', '', 
												 'Nuevo prospecto', 
												 $texto,'', 
												 '', 
												 1, 
												 $rowusr['Gmail_Usuario'], 
												 $rowusr['Gmail_Password']);
					//se guarda el log
					log_response(1, $rmail, 'gcampos@busafe.cl'.' (Asunto:Nuevo prospecto)');						 
											 
					//recibo el último id generado por mi sesion
					$ultimo_id = mysqli_insert_id($dbConn);
						
					header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
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
			
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idProspecto)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'prospectos_transportistas_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idProspecto!='".$idProspecto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idProspecto)){
				$ndata_2 = db_select_nrows (false, 'email', 'prospectos_transportistas_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idProspecto!='".$idProspecto."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idProspecto='".$idProspecto."'" ;
				if(isset($idSistema) && $idSistema != ''){                       $a .= ",idSistema='".$idSistema."'" ;}
				if(isset($Nombre) && $Nombre != ''){                             $a .= ",Nombre='".$Nombre."'" ;}
				if(isset($Fono) && $Fono != ''){                                 $a .= ",Fono='".$Fono."'" ;}
				if(isset($email) && $email != ''){                               $a .= ",email='".$email."'" ;}
				if(isset($email_noti) && $email_noti != ''){                     $a .= ",email_noti='".$email_noti."'" ;}
				if(isset($F_Ingreso) && $F_Ingreso!= ''){                        $a .= ",F_Ingreso='".$F_Ingreso."'" ;}
				if(isset($idEstadoFidelizacion) && $idEstadoFidelizacion!= ''){  $a .= ",idEstadoFidelizacion='".$idEstadoFidelizacion."'" ;}
				if(isset($idEtapa) && $idEtapa!= ''){                            $a .= ",idEtapa='".$idEtapa."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'prospectos_transportistas_listado', 'idProspecto = "'.$idProspecto.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				$resultado = db_delete_data (false, 'prospectos_transportistas_listado', 'idProspecto = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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

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
	if ( !empty($_POST['idApoderado']) )                 $idApoderado                  = $_POST['idApoderado'];
	if ( !empty($_POST['idSistema']) )                   $idSistema                    = $_POST['idSistema'];
	if ( !empty($_POST['idEstado']) )                    $idEstado                     = $_POST['idEstado'];
	if ( !empty($_POST['Nombre']) )                      $Nombre                       = $_POST['Nombre'];
	if ( !empty($_POST['ApellidoPat']) )                 $ApellidoPat                  = $_POST['ApellidoPat'];
	if ( !empty($_POST['ApellidoMat']) )                 $ApellidoMat                  = $_POST['ApellidoMat'];
	if ( !empty($_POST['Fono1']) )                       $Fono1                        = $_POST['Fono1'];
	if ( !empty($_POST['Fono2']) )                       $Fono2                        = $_POST['Fono2'];
	if ( !empty($_POST['FNacimiento']) )                 $FNacimiento                  = $_POST['FNacimiento'];
	if ( !empty($_POST['Rut']) )                         $Rut                          = $_POST['Rut'];
	if ( !empty($_POST['idCiudad']) )                    $idCiudad                     = $_POST['idCiudad'];
	if ( !empty($_POST['idComuna']) )                    $idComuna                     = $_POST['idComuna'];
	if ( !empty($_POST['Direccion']) )                   $Direccion                    = $_POST['Direccion'];
	if ( !empty($_POST['F_Inicio_Contrato']) )           $F_Inicio_Contrato            = $_POST['F_Inicio_Contrato'];
	if ( !empty($_POST['F_Termino_Contrato']) )          $F_Termino_Contrato           = $_POST['F_Termino_Contrato'];
	if ( !empty($_POST['Password']) )                    $Password                     = $_POST['Password'];
	if ( !empty($_POST['dispositivo']) )                 $dispositivo                  = $_POST['dispositivo'];
	if ( !empty($_POST['IMEI']) )                        $IMEI                         = $_POST['IMEI'];
	if ( !empty($_POST['GSM']) )                         $GSM                          = $_POST['GSM'];
	if ( !empty($_POST['GeoLatitud']) )                  $GeoLatitud                   = $_POST['GeoLatitud'];
	if ( !empty($_POST['GeoLongitud']) )                 $GeoLongitud                  = $_POST['GeoLongitud'];
	if ( !empty($_POST['idOpciones_1']) )                $idOpciones_1                 = $_POST['idOpciones_1'];
	if ( !empty($_POST['idOpciones_2']) )                $idOpciones_2                 = $_POST['idOpciones_2'];
	if ( !empty($_POST['idOpciones_3']) )                $idOpciones_3                 = $_POST['idOpciones_3'];
	if ( !empty($_POST['idOpciones_4']) )                $idOpciones_4                 = $_POST['idOpciones_4'];
	if ( !empty($_POST['idOpciones_5']) )                $idOpciones_5                 = $_POST['idOpciones_5'];
	if ( !empty($_POST['Ultimo_acceso']) )               $Ultimo_acceso                = $_POST['Ultimo_acceso'];
	if ( !empty($_POST['IP_Client']) )                   $IP_Client                    = $_POST['IP_Client'];
	if ( !empty($_POST['Agent_Transp']) )                $Agent_Transp                 = $_POST['Agent_Transp'];
	if ( !empty($_POST['email']) )                       $email                        = $_POST['email'];
	if ( !empty($_POST['repassword']) )                  $repassword                   = $_POST['repassword'];
	if ( !empty($_POST['oldpassword']) )                 $oldpassword                  = $_POST['oldpassword'];
	
	if ( !empty($_POST['idPlan']) )                      $idPlan                       = $_POST['idPlan'];
	if ( !empty($_POST['idCobro']) )                     $idCobro                      = $_POST['idCobro'];
	if ( !empty($_POST['idPlanOld']) )                   $idPlanOld                    = $_POST['idPlanOld'];
	if ( !empty($_POST['idCobroOld']) )                  $idCobroOld                   = $_POST['idCobroOld'];
	
		
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
			case 'idApoderado':                 if(empty($idApoderado)){                  $error['idApoderado']                  = 'error/No ha ingresado el id';}break;
			case 'idSistema':                   if(empty($idSistema)){                    $error['idSistema']                    = 'error/No ha seleccionado el sistema al cual pertenece';}break;
			case 'idEstado':                    if(empty($idEstado)){                     $error['idEstado']                     = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':                      if(empty($Nombre)){                       $error['Nombre']                       = 'error/No ha ingresado el nombre de la persona';}break;
			case 'ApellidoPat':                 if(empty($ApellidoPat)){                  $error['ApellidoPat']                  = 'error/No ha ingresado el apellido paterno de la persona';}break;
			case 'ApellidoMat':                 if(empty($ApellidoMat)){                  $error['ApellidoMat']                  = 'error/No ha ingresado el apellido materno de la persona';}break;
			case 'Fono1':                       if(empty($Fono1)){                        $error['Fono1']                        = 'error/No ha ingresado el Fono1 a desempeñar';}break;
			case 'Fono2':                       if(empty($Fono2)){                        $error['Fono2']                        = 'error/No ha ingresado el Fono2';}break;
			case 'FNacimiento':                 if(empty($FNacimiento)){                  $error['FNacimiento']                  = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Rut':                         if(empty($Rut)){                          $error['Rut']                          = 'error/No ha ingresado el rut';}break;
			case 'idCiudad':                    if(empty($idCiudad)){                     $error['idCiudad']                     = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':                    if(empty($idComuna)){                     $error['idComuna']                     = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':                   if(empty($Direccion)){                    $error['Direccion']                    = 'error/No ha ingresado la direccion';}break;
			case 'F_Inicio_Contrato':           if(empty($F_Inicio_Contrato)){            $error['F_Inicio_Contrato']            = 'error/No ha ingresado la fecha de inicio';}break;
			case 'F_Termino_Contrato':          if(empty($F_Termino_Contrato)){           $error['F_Termino_Contrato']           = 'error/No ha ingresado la fecha de termino';}break;
			case 'Password':                    if(empty($Password)){                     $error['Password']                     = 'error/No ha ingresado la password';}break;
			case 'dispositivo':                 if(empty($dispositivo)){                  $error['dispositivo']                  = 'error/No ha ingresado el dispositivo utilizado';}break;
			case 'IMEI':                        if(empty($IMEI)){                         $error['IMEI']                         = 'error/No ha ingresado el imei del equipo';}break;
			case 'GSM':                         if(empty($GSM)){                          $error['GSM']                          = 'error/No ha ingresado el gsm del equipo';}break;
			case 'GeoLatitud':                  if(empty($GeoLatitud)){                   $error['GeoLatitud']                   = 'error/No ha ingresado la latitud del equipo';}break;
			case 'GeoLongitud':                 if(empty($GeoLongitud)){                  $error['GeoLongitud']                  = 'error/No ha ingresado la longitud del equipo';}break;
			case 'idOpciones_1':                if(empty($idOpciones_1)){                 $error['idOpciones_1']                 = 'error/No ha ingresado la opcion 1';}break;
			case 'idOpciones_2':                if(empty($idOpciones_2)){                 $error['idOpciones_2']                 = 'error/No ha ingresado la opcion 2';}break;
			case 'idOpciones_3':                if(empty($idOpciones_3)){                 $error['idOpciones_3']                 = 'error/No ha ingresado la opcion 3';}break;
			case 'idOpciones_4':                if(empty($idOpciones_4)){                 $error['idOpciones_4']                 = 'error/No ha ingresado la opcion 4';}break;
			case 'idOpciones_5':                if(empty($idOpciones_5)){                 $error['idOpciones_5']                 = 'error/No ha ingresado la opcion 5';}break;
			case 'Ultimo_acceso':               if(empty($Ultimo_acceso)){                $error['Ultimo_acceso']                = 'error/No ha ingresado el ultimo acceso';}break;
			case 'IP_Client':                   if(empty($IP_Client)){                    $error['IP_Client']                    = 'error/No ha ingresado el IP del cliente';}break;
			case 'Agent_Transp':                if(empty($Agent_Transp)){                 $error['Agent_Transp']                 = 'error/No ha ingresado el agente de transferencia';}break;
			case 'email':                       if(empty($email)){                        $error['email']                        = 'error/No ha ingresado el email';}break;
			case 'repassword':                  if(empty($repassword)){                   $error['repassword']                   = 'error/No ha ingresado la repeticion de la clave';}break;
			case 'oldpassword':                 if(empty($oldpassword)){                  $error['oldpassword']                  = 'error/No ha ingresado su clave antigua';}break;
			
			case 'idPlan':                      if(empty($idPlan)){                       $error['idPlan']                       = 'error/No ha Seleccionado el plan';}break;
			case 'idCobro':                     if(empty($idCobro)){                      $error['idCobro']                      = 'error/No ha Seleccionado el modo de cobro';}break;
			case 'idPlanOld':                   if(empty($idPlanOld)){                    $error['idPlanOld']                    = 'error/No ha Seleccionado el plan';}break;
			case 'idCobroOld':                  if(empty($idCobroOld)){                   $error['idCobroOld']                   = 'error/No ha Seleccionado el modo de cobro';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
	//Verifica si el mail corresponde
	if(isset($Fono1)&&!validarNumero($Fono1)) { $error['Fono1']   = 'error/Ingrese un numero telefonico valido'; }
	if(isset($Fono2)&&!validarNumero($Fono2)) { $error['Fono2']   = 'error/Ingrese un numero telefonico valido'; }
	if(isset($email)&&!validarEmail($email)){   $error['email']   = 'error/El Email ingresado no es valido'; }	
	if(isset($Rut)&&!validarRut($Rut)){         $error['Rut']     = 'error/El Rut ingresado no es valido'; }
	if(isset($Password)&&isset($repassword)){
		if ( $Password <> $repassword )                  $error['Password']  = 'error/Las contraseñas ingresadas no coinciden'; 
	}
	if(isset($Password)){
		if (strpos($Password, " ")){                     $error['Password1'] = 'error/La contraseña contiene espacios vacios';}
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
			$ndata_2 = 0;
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'apoderados_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'apoderados_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)){
				$ndata_3 = db_select_nrows (false, 'email', 'apoderados_listado', '', "email='".$email."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El apoderado que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//Se genera una password aleatoria
				$Password = genera_password(6,'alfanumerico');
				
				//filtros
				if(isset($idSistema) && $idSistema != ''){                       $a  = "'".$idSistema."'" ;               }else{$a  = "''";}
				if(isset($idEstado) && $idEstado != ''){                         $a .= ",'".$idEstado."'" ;               }else{$a .= ",''";}
				if(isset($Nombre) && $Nombre != ''){                             $a .= ",'".$Nombre."'" ;                 }else{$a .= ",''";}
				if(isset($ApellidoPat) && $ApellidoPat != ''){                   $a .= ",'".$ApellidoPat."'" ;            }else{$a .= ",''";}
				if(isset($ApellidoMat) && $ApellidoMat != ''){                   $a .= ",'".$ApellidoMat."'" ;            }else{$a .= ",''";}
				if(isset($Fono1) && $Fono1 != ''){                               $a .= ",'".$Fono1."'" ;                  }else{$a .= ",''";}
				if(isset($Fono2) && $Fono2 != ''){                               $a .= ",'".$Fono2."'" ;                  }else{$a .= ",''";}
				if(isset($FNacimiento) && $FNacimiento != ''){                   $a .= ",'".$FNacimiento."'" ;            }else{$a .= ",''";}
				if(isset($Rut) && $Rut != ''){                                   $a .= ",'".$Rut."'" ;                    }else{$a .= ",''";}
				if(isset($idCiudad) && $idCiudad != ''){                         $a .= ",'".$idCiudad."'" ;               }else{$a .= ",''";}
				if(isset($idComuna) && $idComuna != ''){                         $a .= ",'".$idComuna."'" ;               }else{$a .= ",''";}
				if(isset($Direccion) && $Direccion != ''){                       $a .= ",'".$Direccion."'" ;              }else{$a .= ",''";}
				if(isset($F_Inicio_Contrato) && $F_Inicio_Contrato != ''){       $a .= ",'".$F_Inicio_Contrato."'" ;      }else{$a .= ",''";}
				if(isset($F_Termino_Contrato) && $F_Termino_Contrato != ''){     $a .= ",'".$F_Termino_Contrato."'" ;     }else{$a .= ",''";}
				if(isset($Password) && $Password != ''){                         $a .= ",'".md5($Password)."'" ;          }else{$a .= ",''";}
				if(isset($dispositivo) && $dispositivo != ''){                   $a .= ",'".$dispositivo."'" ;            }else{$a .= ",''";}
				if(isset($IMEI) && $IMEI != ''){                                 $a .= ",'".$IMEI."'" ;                   }else{$a .= ",''";}
				if(isset($GSM) && $GSM != ''){                                   $a .= ",'".$GSM."'" ;                    }else{$a .= ",''";}
				if(isset($GeoLatitud) && $GeoLatitud != ''){                     $a .= ",'".$GeoLatitud."'" ;             }else{$a .= ",''";}
				if(isset($GeoLongitud) && $GeoLongitud != ''){                   $a .= ",'".$GeoLongitud."'" ;            }else{$a .= ",''";}
				if(isset($idOpciones_1) && $idOpciones_1 != ''){                 $a .= ",'".$idOpciones_1."'" ;           }else{$a .= ",''";}
				if(isset($idOpciones_2) && $idOpciones_2 != ''){                 $a .= ",'".$idOpciones_2."'" ;           }else{$a .= ",''";}
				if(isset($idOpciones_3) && $idOpciones_3 != ''){                 $a .= ",'".$idOpciones_3."'" ;           }else{$a .= ",''";}
				if(isset($idOpciones_4) && $idOpciones_4 != ''){                 $a .= ",'".$idOpciones_4."'" ;           }else{$a .= ",''";}
				if(isset($idOpciones_5) && $idOpciones_5 != ''){                 $a .= ",'".$idOpciones_5."'" ;           }else{$a .= ",''";}
				if(isset($Ultimo_acceso) && $Ultimo_acceso != ''){               $a .= ",'".$Ultimo_acceso."'" ;          }else{$a .= ",''";}
				if(isset($IP_Client) && $IP_Client != ''){                       $a .= ",'".$IP_Client."'" ;              }else{$a .= ",''";}
				if(isset($Agent_Transp) && $Agent_Transp != ''){                 $a .= ",'".$Agent_Transp."'" ;           }else{$a .= ",''";}
				if(isset($email) && $email != ''){                               $a .= ",'".$email."'" ;                  }else{$a .= ",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `apoderados_listado` (idSistema, idEstado, Nombre, ApellidoPat, 
				ApellidoMat, Fono1, Fono2, FNacimiento, Rut, idCiudad, idComuna, Direccion, 
				F_Inicio_Contrato, F_Termino_Contrato, Password, dispositivo, IMEI, GSM, GeoLatitud, GeoLongitud,
				idOpciones_1, idOpciones_2, idOpciones_3, idOpciones_4, idOpciones_5, Ultimo_acceso, IP_Client,
				Agent_Transp, email) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//recibo el último id generado por mi sesion
				$ultimo_id = mysqli_insert_id($dbConn);
				/******************************************************************/
				//Creo una subcuenta
				$xNombre = '';
				if(isset($Nombre) && $Nombre != ''){             $xNombre .= $Nombre;            }else{$xNombre .= '';}
				if(isset($ApellidoPat) && $ApellidoPat != ''){   $xNombre .= ' '.$ApellidoPat;   }else{$xNombre .= '';}
				if(isset($ApellidoMat) && $ApellidoMat != ''){   $xNombre .= ' '.$ApellidoMat;   }else{$xNombre .= '';}
				//filtros
				if(isset($ultimo_id) && $ultimo_id != ''){        $a  = "'".$ultimo_id."'" ;      }else{$a  = "''";}
				if(isset($xNombre) && $xNombre != ''){            $a .= ",'".$xNombre."'" ;       }else{$a .= ",''";}
				if(isset($Rut) && $Rut != ''){                    $a .= ",'".$Rut."'" ;           }else{$a .= ",''";}
				if(isset($Password) && $Password != ''){          $a .= ",'".$Password."'" ;      }else{$a .= ",''";}
				if(isset($email) && $email != ''){                $a .= ",'".$email."'" ;         }else{$a .= ",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `apoderados_subcuentas` (idApoderado, Nombre, Usuario, 
				Password, email) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				
				/******************************************************************/
				//traigo los datos almacenados
				$rowusr = db_select_data (false, 'Nombre, email_principal, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'core_sistemas', '', 'idSistema=1', $dbConn, 'Login-form', $original, $form_trabajo);

				
				//Envio de correo
				$texto  = '<p>Estimado(a) '.$xNombre.'</p>'; 
				$texto .= '<p><strong>¡Te damos la bienvenida a Busafe!</strong></p>'; 
				$texto .= '<p>Desde este momento podrás monitorear el trayecto de tu hijo(a) dentro del transporte escolar. La tranquilidad ha llegado para quedarse, desde tu móvil podrás verificar tiempos de llegada, ruta del transporte escolar y notificaciones ante emergencias.</p>'; 
				$texto .= '<p>Te recordamos tus accesos a la aplicación y administración web (apoderado.busafe.cl):</p>'; 
				$texto .= '<ul>';
				$texto .= '<li><strong>Usuario: '.$Rut.'</strong></li>';
				$texto .= '<li><strong>Contraseña: '.$Password.'</strong></li>';
				$texto .= '</ul>';
				$texto .= '<p>Puedes cambiar tu contraseña <a href="https://apoderado.busafe.cl/principal_datos_password.php" target="_blank" rel="noopener noreferrer" >aqui</a>, o “mis datos”>”ver más”>”Password”</p>'; 
				$texto .= '<p>Si tienes consultas respecto al servicio, no dudes en comunicarte con nosotros al correo <a href="mailto:contacto@busafe.cl" target="_blank">contacto@busafe.cl</a> o al teléfono +56956677290.</p>'; 
				$texto .= '<p>Un cordial saludo</p>'; 
				$texto .= '<p>Equipo de Busafe</p>';
				
				//Se agrega el header
				$BodyMail  = '<img src="https://apoderado.busafe.cl/img/mail_header_logo.jpg" class="CToWUd a6T" tabindex="0" width="800">';
				$BodyMail .= '<br/><br/>';
				$BodyMail .= $texto;
			
				$rmail = tareas_envio_correo($rowusr['email_principal'], $rowusr['Nombre'], 
											 $email, 'Receptor', 
											 '', '', 
											 'Registro de Usuario', 
											 $BodyMail,'', 
											 '', 
											 1, 
											 $rowusr['Gmail_Usuario'], 
											 $rowusr['Gmail_Password']);
                //se guarda el log
				log_response(1, $rmail, $email.' (Asunto:Registro de Usuario)');	
				                         
				//Envio del mensaje
				if ($rmail!=1) {
					$error['email'] 	  = 'error/'.$rmail;
				} else {
					/**************************************************************/
					//envio de correo a gonzalo
					$texto = '<h1>Registro de nuevo apoderado</h1>';
					$texto .= '<p>';
					
					if(isset($Nombre) && $Nombre != '') {            $texto .= 'Nombre: '.$Nombre.'<br/>';}
					if(isset($ApellidoPat) && $ApellidoPat != '') {  $texto .= 'Apellido Paterno: '.$ApellidoPat.'<br/>';}
					if(isset($ApellidoMat) && $ApellidoMat != ''){   $texto .= 'Apellido Materno: '.$ApellidoMat.'<br/>';}
					if(isset($Rut) && $Rut != '') {                  $texto .= 'Rut: '.$Rut.'<br/>';}
					if(isset($email) && $email != '') {              $texto .= 'Email: '.$email.'<br/>';}
					if(isset($Fono1) && $Fono1 != '') {              $texto .= 'Telefono Fijo: '.$Fono1.'<br/>';}
					if(isset($idCiudad) && $idCiudad != '') {         
						$rowCiudad = db_select_data (false, 'Nombre', 'core_ubicacion_ciudad', '', 'idCiudad="'.$idCiudad.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						$texto .= 'Ciudad: '.$rowCiudad['Nombre'].'<br/>';
					}
					if(isset($idComuna) && $idComuna != '') {         
						$rowComuna = db_select_data (false, 'Nombre', 'core_ubicacion_comunas', '', 'idComuna="'.$idComuna.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						$texto .= 'Comuna: '.$rowComuna['Nombre'].'<br/>';
					}
					if(isset($Direccion) && $ApellidoMat != '') {       $texto .= 'Direccion: '.$Direccion.'<br/>';}
					$texto .= '</p>';
					
					//Se agrega el header
					$BodyMail  = '<img src="https://apoderado.busafe.cl/img/mail_header_logo.jpg" class="CToWUd a6T" tabindex="0" width="800">';
					$BodyMail .= '<br/><br/>';
					$BodyMail .= $texto;
						 
					$rmail = tareas_envio_correo($rowusr['email_principal'], $rowusr['Nombre'], 
												 'gcampos@busafe.cl', 'Receptor', 
												 '', '', 
												 'Registro de Usuario', 
												 $BodyMail,'', 
												 '', 
												 1, 
												 $rowusr['Gmail_Usuario'], 
												 $rowusr['Gmail_Password']);
					//se guarda el log
					log_response(1, $rmail, 'gcampos@busafe.cl'.' (Asunto:Registro de Usuario)');	
				 						 
					//Envio del mensaje
					if ($rmail!=1) {
						$error['email'] 	  = 'error/'.$rmail;
					} else {
						/**************************************************************/
						//todo ok
						
						header( 'Location: '.$location.'?created=true' );
						die;
					}
					
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
			$ndata_3 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)&&isset($idApoderado)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'apoderados_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."' AND idApoderado!='".$idApoderado."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idApoderado)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'apoderados_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idApoderado!='".$idApoderado."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idApoderado)){
				$ndata_3 = db_select_nrows (false, 'email', 'apoderados_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idApoderado!='".$idApoderado."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($oldpassword)&&isset($idApoderado)){
				$ndata_4 = db_select_nrows (false, 'Password', 'apoderados_listado', '', "idApoderado='".$idApoderado."' AND Password='".md5($oldpassword)."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El apoderado que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/
			//Consulto la latitud y la longitud
			$address = '';
			if(isset($idCiudad) && $idCiudad != ''){
				$rowdata = db_select_data (false, 'Nombre', 'core_ubicacion_ciudad', '', 'idCiudad = "'.$idCiudad.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$address .= $rowdata['Nombre'].', ';
			}
			if(isset($idComuna) && $idComuna != ''){
				$rowdata = db_select_data (false, 'Nombre', 'core_ubicacion_comunas', '', 'idComuna = "'.$idComuna.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$address .= $rowdata['Nombre'].', ';
			}
			if(isset($Direccion) && $Direccion != ''){
				$address .= $Direccion;
			}
			if($address!=''){
				$geocodeData = getGeocodeData($address, $_SESSION['usuario']['basic_data']['Config_IDGoogle']);
				if($geocodeData) {         
					$GeoLatitud  = $geocodeData[0];
					$GeoLongitud = $geocodeData[1];
			    } else {
					echo "Detalles incorrectos!";
					$error['ndata_1'] = 'error/Detalles de la direccion incorrectos!';
			    }
			}else{
				$error['ndata_1'] = 'error/Sin direccion ingresada';
			}

			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idApoderado='".$idApoderado."'" ;
				if(isset($idSistema) && $idSistema != ''){                     $a .= ",idSistema='".$idSistema."'" ;}
				if(isset($idEstado) && $idEstado != ''){                       $a .= ",idEstado='".$idEstado."'" ;}
				if(isset($Nombre) && $Nombre != ''){                           $a .= ",Nombre='".$Nombre."'" ;}
				if(isset($ApellidoPat) && $ApellidoPat != ''){                 $a .= ",ApellidoPat='".$ApellidoPat."'" ;}
				if(isset($ApellidoMat) && $ApellidoMat != ''){                 $a .= ",ApellidoMat='".$ApellidoMat."'" ;}
				if(isset($Fono1) && $Fono1 != ''){                             $a .= ",Fono1='".$Fono1."'" ;}
				if(isset($Fono2) && $Fono2 != ''){                             $a .= ",Fono2='".$Fono2."'" ;}
				if(isset($FNacimiento) && $FNacimiento != ''){                 $a .= ",FNacimiento='".$FNacimiento."'" ;}
				if(isset($Rut) && $Rut != ''){                                 $a .= ",Rut='".$Rut."'" ;}
				if(isset($idCiudad) && $idCiudad != ''){                       $a .= ",idCiudad='".$idCiudad."'" ;}
				if(isset($idComuna) && $idComuna != ''){                       $a .= ",idComuna='".$idComuna."'" ;}
				if(isset($Direccion) && $Direccion != ''){                     $a .= ",Direccion='".$Direccion."'" ;}
				if(isset($F_Inicio_Contrato) && $F_Inicio_Contrato != ''){     $a .= ",F_Inicio_Contrato='".$F_Inicio_Contrato."'" ;}
				if(isset($F_Termino_Contrato) && $F_Termino_Contrato != ''){   $a .= ",F_Termino_Contrato='".$F_Termino_Contrato."'" ;}
				if(isset($Password) && $Password != ''){                       $a .= ",Password='".md5($Password)."'" ;}
				if(isset($dispositivo) && $dispositivo != ''){                 $a .= ",dispositivo='".$dispositivo."'" ;}
				if(isset($IMEI) && $IMEI != ''){                               $a .= ",IMEI='".$IMEI."'" ;}
				if(isset($GSM) && $GSM != ''){                                 $a .= ",GSM='".$GSM."'" ;}
				if(isset($GeoLatitud) && $GeoLatitud != ''){                   $a .= ",GeoLatitud='".$GeoLatitud."'" ;}
				if(isset($GeoLongitud) && $GeoLongitud != ''){                 $a .= ",GeoLongitud='".$GeoLongitud."'" ;}
				if(isset($idOpciones_1) && $idOpciones_1 != ''){               $a .= ",idOpciones_1='".$idOpciones_1."'" ;}
				if(isset($idOpciones_2) && $idOpciones_2 != ''){               $a .= ",idOpciones_2='".$idOpciones_2."'" ;}
				if(isset($idOpciones_3) && $idOpciones_3 != ''){               $a .= ",idOpciones_3='".$idOpciones_3."'" ;}
				if(isset($idOpciones_4) && $idOpciones_4 != ''){               $a .= ",idOpciones_4='".$idOpciones_4."'" ;}
				if(isset($idOpciones_5) && $idOpciones_5 != ''){               $a .= ",idOpciones_5='".$idOpciones_5."'" ;}
				if(isset($Ultimo_acceso) && $Ultimo_acceso != ''){             $a .= ",Ultimo_acceso='".$Ultimo_acceso."'" ;}
				if(isset($IP_Client) && $IP_Client != ''){                     $a .= ",IP_Client='".$IP_Client."'" ;}
				if(isset($Agent_Transp) && $Agent_Transp != ''){               $a .= ",Agent_Transp='".$Agent_Transp."'" ;}
				if(isset($email) && $email != ''){                             $a .= ",email='".$email."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'apoderados_listado', 'idApoderado = "'.$idApoderado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					
					//redirijo
					header( 'Location: '.$location.'?edited=true' );
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
		//Cambia el nivel del permiso
		case 'submit_img':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			if ($_FILES["Direccion_img"]["error"] > 0){ 
				$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]); 
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 1000;
				//Sufijo
				$sufijo = 'apod_img_'.$idApoderado.'_';
							  
				if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = "upload/".$sufijo.$_FILES['Direccion_img']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						//$resultado = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
						//Muevo el archivo
						$resultado = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], "upload/xxxsxx_".$_FILES['Direccion_img']['name']);
							
						//se selecciona la imagen
						switch ($_FILES['Direccion_img']['type']) {
							case 'image/jpg':
								$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
								break;
							case 'image/jpeg':
								$imgBase = imagecreatefromjpeg('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
								break;
							case 'image/gif':
								$imgBase = imagecreatefromgif('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
								break;
							case 'image/png':
								$imgBase = imagecreatefrompng('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
								break;
						}
							
						//se reescala la imagen en caso de ser necesario
						$imgBase_width = imagesx( $imgBase );
						$imgBase_height = imagesy( $imgBase );
							
						//Se establece el tamaño maximo
						$max_width  = 640;
						$max_height = 640;

						if ($imgBase_width > $imgBase_height) {
							if($imgBase_width < $max_width){
								$newwidth = $imgBase_width;
							}else{
								$newwidth = $max_width;	
							}
							$divisor = $imgBase_width / $newwidth;
							$newheight = floor( $imgBase_height / $divisor);
						}else {
							if($imgBase_height < $max_height){
								$newheight = $imgBase_height;
							}else{
								$newheight =  $max_height;
							} 
							$divisor = $imgBase_height / $newheight;
							$newwidth = floor( $imgBase_width / $divisor );
						}

						$imgBase = imagescale($imgBase, $newwidth, $newheight);

						//se establece la calidad del archivo
						$quality = 75;
							
						//se crea la imagen
						imagejpeg($imgBase, $ruta, $quality);
							
						//se elimina la imagen base
						try {
							if(!is_writable('upload/xxxsxx_'.$_FILES['Direccion_img']['name'])){
								//throw new Exception('File not writable');
							}else{
								unlink('upload/xxxsxx_'.$_FILES['Direccion_img']['name']);
							}
						}catch(Exception $e) { 
							//guardar el dato en un archivo log
						}
						//se eliminan las imagenes de la memoria
						imagedestroy($imgBase);
						
						if ($resultado){
											
							//Filtro para idSistema
							$a = "Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'" ;
							
							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'apoderados_listado', 'idApoderado = "'.$idApoderado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){
								
								header( 'Location: '.$location );
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
											
						} else {
							$error['Direccion_img']     = 'error/Ocurrio un error al mover el archivo'; 
						}
					} else {
						$error['Direccion_img']     = 'error/El archivo '.$_FILES['Direccion_img']['name'].' ya existe'; 
					}
				} else {
					$error['Direccion_img']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'; 
				}
			}


		break;	
/*******************************************************************************************************************/
		case 'del_img':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'Direccion_img', 'apoderados_listado', '', 'idApoderado = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se actualizan los datos
			$a = 'Direccion_img=""';
			$resultado = db_update_data (false, $a, 'apoderados_listado', 'idApoderado = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				
				//se elimina el archivo
				if(isset($rowdata['Direccion_img'])&&$rowdata['Direccion_img']!=''){
					try {
						if(!is_writable('upload/'.$rowdata['Direccion_img'])){
							//throw new Exception('File not writable');
						}else{
							unlink('upload/'.$rowdata['Direccion_img']);
						}
					}catch(Exception $e) { 
						//guardar el dato en un archivo log
					}
				}
				
				//Redirijo			
				header( 'Location: '.$location.'?id_img=true' );
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
			

		break;	
/*******************************************************************************************************************/		
		case 'login': 
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Elimino cualquier dato de un usuario anterior
			unset($_SESSION['usuario']);
			
			//Variables
			$fecha          = fecha_actual();
			$hora           = hora_actual();
			$Time           = time();
			$IP_Client      = obtenerIpCliente();
			$Agent_Transp   = obtenerSistOperativo().' - '.obtenerNavegador();
			$email          = '';
				
			//Saneado de datos ingresados
			$Password = preg_replace("/[^a-zA-Z0-9_\-]+ñÑáéíóúÁÉÍÓÚ-_?¿°()=,.<>:;*@/","",$Password);
				
			//Se verifica si se trata de hacer fuerza bruta en el ingreso
			if (checkbrute($Rut, $email, $IP_Client, 'apoderados_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, usuario bloqueado por 2 horas'; 
			}
			
			//si no hay errores
			if ( empty($error) ) {
						
				//Busco al usuario en el sistema
				$SIS_query = '
				apoderados_listado.idApoderado, 
				apoderados_listado.Password, 
				apoderados_listado.Rut, 
				apoderados_listado.FNacimiento,
				apoderados_listado.Nombre, 
				apoderados_listado.ApellidoPat,
				apoderados_listado.ApellidoMat,
				apoderados_listado.idEstado, 
				apoderados_listado.idSistema,
				apoderados_listado.idPlan,
				apoderados_listado.email, 
				core_sistemas.Config_idTheme,
				core_sistemas.Config_imgLogo,
				core_sistemas.Config_IDGoogle,
				core_sistemas.Nombre AS EmpresaNombre,
				core_sistemas.email_principal AS EmpresaEmail, 
				core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
				core_sistemas.Config_Gmail_Password AS Gmail_Password,
				sistema_planes_transporte.Nombre AS PlanNombre,
				sistema_planes_transporte.Valor_Mensual AS PlanValor_Mensual,
				sistema_planes_transporte.Valor_Anual AS PlanValor_Anual,
				sistema_planes_transporte.N_Hijos AS PlanN_Hijos,
				apoderados_listado.idCobro AS TipoPlan_idCobro,
				core_tipo_cobro.Nombre AS TipoPlanNombre';
				$SIS_join = '
				LEFT JOIN `core_sistemas`               ON core_sistemas.idSistema           = apoderados_listado.idSistema
				LEFT JOIN `sistema_planes_transporte`   ON sistema_planes_transporte.idPlan  = apoderados_listado.idPlan
				LEFT JOIN `core_tipo_cobro`             ON core_tipo_cobro.idCobro           = apoderados_listado.idCobro';
				$SIS_where = 'apoderados_listado.Rut = "'.$Rut.'" AND apoderados_listado.Password = "'.md5($Password).'"';
				$rowUser = db_select_data (false, $SIS_query, 'apoderados_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);


				//Se verifca si los datos ingresados son de un usuario
				if (isset($rowUser['idApoderado'])&&$rowUser['idApoderado']!='') {
					
					//Verifico que el usuario identificado este activo
					if($rowUser['idEstado']==1){
						
						/**************************************************************/
						//Actualizo la tabla de los usuarios
						$a = 'Ultimo_acceso="'.$fecha.'", IP_Client="'.$IP_Client.'", Agent_Transp="'.$Agent_Transp.'"';
						$resultado = db_update_data (false, $a, 'apoderados_listado', 'idApoderado = "'.$rowUser['idApoderado'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
						//busca si la ip del usuario ya existe
						$n_ip = db_select_nrows (false, 'idIpUsuario', 'apoderados_listado_ip', '', "IP_Client='".$IP_Client."' AND idApoderado='".$rowUser['idApoderado']."'", $dbConn, 'Login-form', $original, $form_trabajo);
						//si la ip no existe la guarda
						if(isset($n_ip)&&$n_ip==0){
							if(isset($rowUser['idApoderado']) && $rowUser['idApoderado'] != ''){  $a  = "'".$rowUser['idApoderado']."'" ;  }else{$a  = "''";}
							if(isset($IP_Client) && $IP_Client != ''){                            $a .= ",'".$IP_Client."'" ;              }else{$a .= ",''";}
							if(isset($fecha) && $fecha != ''){                                    $a .= ",'".$fecha."'" ;                  }else{$a .= ",''";}
							if(isset($hora) && $hora != ''){                                      $a .= ",'".$hora."'" ;                   }else{$a .= ",''";}
											
							// inserto los datos de registro en la db
							$query  = "INSERT INTO `apoderados_listado_ip` (idApoderado,IP_Client, Fecha, Hora) 
							VALUES (".$a.")";
							//Consulta
							$resultado = mysqli_query ($dbConn, $query);
						}
						
						/**************************************************************/
						//Inserto la fecha con el ingreso
						if(isset($rowUser['idApoderado']) && $rowUser['idApoderado'] != ''){  $a  = "'".$rowUser['idApoderado']."'" ;  }else{$a  = "''";}
						if(isset($fecha) && $fecha != ''){                                    $a .= ",'".$fecha."'" ;                  }else{$a .= ",''";}
						if(isset($hora) && $hora != ''){                                      $a .= ",'".$hora."'" ;                   }else{$a .= ",''";}
						if(isset($IP_Client) && $IP_Client != ''){                            $a .= ",'".$IP_Client."'" ;              }else{$a .= ",''";}
						if(isset($Agent_Transp) && $Agent_Transp != ''){                      $a .= ",'".$Agent_Transp."'" ;           }else{$a .= ",''";}
										
						// inserto los datos de registro en la db
						$query  = "INSERT INTO `apoderados_accesos` (idApoderado,Fecha, Hora, IP_Client, Agent_Transp) 
						VALUES (".$a.")";
						//Consulta
						$resultado = mysqli_query ($dbConn, $query);
					
						//Se crean las variables con todos los datos
						$_SESSION['usuario']['basic_data']['idApoderado']        = $rowUser['idApoderado'];
						$_SESSION['usuario']['basic_data']['Password']           = $rowUser['Password'];
						$_SESSION['usuario']['basic_data']['Nombre']             = $rowUser['Nombre'].' '.$rowUser['ApellidoPat'].' '.$rowUser['ApellidoMat'];
						$_SESSION['usuario']['basic_data']['Rut']                = $rowUser['Rut'];
						$_SESSION['usuario']['basic_data']['FNacimiento']        = $rowUser['FNacimiento'];
						$_SESSION['usuario']['basic_data']['idEstado']           = $rowUser['idEstado'];
						$_SESSION['usuario']['basic_data']['idSistema']          = $rowUser['idSistema'];
						$_SESSION['usuario']['basic_data']['idPlan']             = $rowUser['idPlan'];
						$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowUser['Config_idTheme'];
						$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowUser['Config_imgLogo'];
						$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowUser['Config_IDGoogle'];
						$_SESSION['usuario']['basic_data']['PlanNombre']         = $rowUser['PlanNombre'];
						$_SESSION['usuario']['basic_data']['PlanValor_Mensual']  = $rowUser['PlanValor_Mensual'];
						$_SESSION['usuario']['basic_data']['PlanValor_Anual']    = $rowUser['PlanValor_Anual'];
						$_SESSION['usuario']['basic_data']['PlanN_Hijos']        = $rowUser['PlanN_Hijos'];
						$_SESSION['usuario']['basic_data']['TipoPlan_idCobro']   = $rowUser['TipoPlan_idCobro'];
						$_SESSION['usuario']['basic_data']['TipoPlanNombre']     = $rowUser['TipoPlanNombre'];
						$_SESSION['usuario']['basic_data']['Email']              = $rowUser['email'];
						$_SESSION['usuario']['basic_data']['EmpresaNombre']      = $rowUser['EmpresaNombre'];
						$_SESSION['usuario']['basic_data']['EmpresaEmail']       = $rowUser['EmpresaEmail'];
						$_SESSION['usuario']['basic_data']['Gmail_Usuario']      = $rowUser['Gmail_Usuario'];
						$_SESSION['usuario']['basic_data']['Gmail_Password']     = $rowUser['Gmail_Password'];
						
				
						//Redirijo a la pagina principal
						header( 'Location: principal.php' );
						die;
						
				
					//Si no esta activo envio error	
					}else{
						$error['idApoderado']   = 'error/Su usuario esta desactivado, Contactese con el administrador';
					}
				
				//Si no se encuentra ningun usuario se envia un error	
				}else{
					$error['idApoderado']   = 'error/El Rut de usuario o contraseña no coinciden';
					
					//filtros
					if(isset($fecha) && $fecha != ''){                $a  = "'".$fecha."'" ;         }else{$a  = "''";}
					if(isset($hora) && $hora != ''){                  $a .= ",'".$hora."'" ;         }else{$a .= ",''";}
					if(isset($Rut) && $Rut != ''){                    $a .= ",'".$Rut."'" ;          }else{$a .= ",''";}
					if(isset($email) && $email != ''){                $a .= ",'".$email."'" ;        }else{$a .= ",''";}
					if(isset($IP_Client) && $IP_Client != ''){        $a .= ",'".$IP_Client."'" ;    }else{$a .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp != ''){  $a .= ",'".$Agent_Transp."'" ; }else{$a .= ",''";}
					if(isset($Time) && $Time != ''){                  $a .= ",'".$Time."'" ;         }else{$a .= ",''";}
									
					// inserto los datos de registro en la db
					$query  = "INSERT INTO `apoderados_checkbrute` (Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time) 
					VALUES (".$a.")";
					//Consulta
					$resultado = mysqli_query ($dbConn, $query);
					
				}
						
			} 
		break;
/*******************************************************************************************************************/		
		case 'getpass':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Variables
			$fecha          = fecha_actual();
			$hora           = hora_actual();
			$Time           = time();
			$IP_Client      = obtenerIpCliente();
			$Agent_Transp   = obtenerSistOperativo().' - '.obtenerNavegador();
			$Rut            = '';
			$Password       = '';
				
			//Saneado de datos ingresados
			$email = preg_replace("/[^a-zA-Z0-9_\-]+ñÑáéíóúÁÉÍÓÚ-_?¿°()=,.<>:;*@/","",$email);
				
			//Se verifica si se trata de hacer fuerza bruta en el ingreso
			if (checkbrute($Rut, $email, $IP_Client, 'apoderados_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, correo bloqueado por 2 horas'; 
			}
			//se verifica que se haya ingresado el correo
			if(!isset($email) or $email==''){
				$error['email']  = 'error/No ha ingresado un correo'; 
			}
			
	
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//traigo los datos almacenados
				$SIS_query = '
				apoderados_listado.email,
				core_sistemas.RazonSocial,
				core_sistemas.email_principal, 
				core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
				core_sistemas.Config_Gmail_Password AS Gmail_Password	';
				$SIS_join = '
				LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = apoderados_listado.idSistema';
				$SIS_where = 'apoderados_listado.email="'.$email.'"';
				$rowusr           = db_select_data (false, $SIS_query, 'apoderados_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);
				$cuenta_registros = db_select_nrows (false, $SIS_query, 'apoderados_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);

				
				//verifico si los datos ingresados son iguales a los almacenados
				if(isset($cuenta_registros)&&$cuenta_registros!=''&&$cuenta_registros!=0){  
					
					//Generacion de nueva clave
					$num_caracteres  = "10"; //cantidad de caracteres de la clave
					$clave           = substr(md5(rand()),0,$num_caracteres); //generador aleatorio de claves 
					$nueva_clave     = md5($clave);//se codifica la clave 
						
					//Actualizacion de la clave en la base de datos
					$a = 'Password="'.$nueva_clave.'"';
					$resultado = db_update_data (false, $a, 'apoderados_listado', 'email = "'.$email.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
					//Envio de correo
					$texto = '<p>Se ha generado una nueva contraseña para el usuario '.$email.', su nueva contraseña es: '.$nueva_clave.'</p>';
					
					//Se agrega el header
					$BodyMail  = '<img src="https://apoderado.busafe.cl/img/mail_header_logo.jpg" class="CToWUd a6T" tabindex="0" width="800">';
					$BodyMail .= '<br/><br/>';
					$BodyMail .= $texto;
					
					$rmail = tareas_envio_correo($rowusr['email_principal'], $rowusr['RazonSocial'], 
												 $email, 'Receptor', 
												 '', '', 
												 'Cambio de password', 
												 $BodyMail,'', 
												 '', 
												 1, 
												 $rowusr['Gmail_Usuario'], 
												 $rowusr['Gmail_Password']);
                    //se guarda el log
					log_response(1, $rmail, $email.' (Asunto:Cambio de password)');	
				 	                     	
					//Envio del mensaje
					if ($rmail!=1) {
						$error['email'] 	  = 'error/'.$rmail;
					} else {
						$error['email'] 	  = 'sucess/La nueva contraseña fue enviada a tu correo';
					}
				
				//Si no se encuentra ningun usuario se envia un error	
				}else{	
					$error['email'] 	  = 'error/El email ingresado no existe';
					
					//filtros
					if(isset($fecha) && $fecha != ''){                $a  = "'".$fecha."'" ;         }else{$a  = "''";}
					if(isset($hora) && $hora != ''){                  $a .= ",'".$hora."'" ;         }else{$a .= ",''";}
					if(isset($Rut) && $Rut != ''){                    $a .= ",'".$Rut."'" ;          }else{$a .= ",''";}
					if(isset($email) && $email != ''){                $a .= ",'".$email."'" ;        }else{$a .= ",''";}
					if(isset($IP_Client) && $IP_Client != ''){        $a .= ",'".$IP_Client."'" ;    }else{$a .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp != ''){  $a .= ",'".$Agent_Transp."'" ; }else{$a .= ",''";}
					if(isset($Time) && $Time != ''){                  $a .= ",'".$Time."'" ;         }else{$a .= ",''";}
									
					// inserto los datos de registro en la db
					$query  = "INSERT INTO `apoderados_checkbrute` (Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time) 
					VALUES (".$a.")";
					//Consulta
					$resultado = mysqli_query ($dbConn, $query);
					
				}
					
			}

		break;	
/*******************************************************************************************************************/		
		case 'updatePlan':
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//verificar antiguedad
				$dInscrito = dias_transcurridos($_SESSION['usuario']['basic_data']['FNacimiento'],fecha_actual());

				//si ya tiene mas de dos meses inscrito
				if($dInscrito>60){
					//calculo normal
					$DiasDisponibles  = 30 - dia_actual() + 1;   //se suma 1 para evitar dias disponibles en 0
					$MesesDisponibles = 12 - mes_actual();       //se calculan los meses
					//si meses disponibles es superior a 10
					if($MesesDisponibles>10){
							$MesesDisponibles = 10;
					}
					
					//guardo temporalmente los datos del formulario
					$_SESSION['plan']['idPlan']       = $idPlan;
					$_SESSION['plan']['idCobro']      = $idCobro;
					$_SESSION['plan']['idApoderado']  = $idApoderado;
					
					//Obtengo los valores del plan seleccionado
					$rowPlan = db_select_data (false, 'Valor_Mensual, Valor_Anual', 'sistema_planes_transporte', '', 'idPlan = "'.$idPlan.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
		
					//Se crea un registro de facturacion ya pagado
					switch ($idCobro) {
						//Mensual
						case 1:
							$montoPago     = ($rowPlan['Valor_Mensual']/30)*$DiasDisponibles;
							break;
						//Anual
						case 2:
							$montoPago     = ($rowPlan['Valor_Anual']/10)*$MesesDisponibles;
							break;
					}
					
					//Elimino los datos previos del form
					unset($_SESSION['form_require']);
		
					/*******************************************************************/
					//Proceso a pago
					$_SESSION['trbnk']['montoPago']    = $montoPago;
					$_SESSION['trbnk']['buyOrder']     = genera_password_unica();
					
					//redireccion a transbank
					header( 'Location: ./transbank/registro_inicio.php' );
					die;
					
				//si tiene menos de dos meses inscrito	
				}else{
					//calculo normal
					$DiasDisponibles  = 0;                      //no se cobra
					$MesesDisponibles = 12 - (mes_actual()+1);  //se descuenta un mes
					//si meses disponibles es superior a 10
					if($MesesDisponibles>10){
							$MesesDisponibles = 10;
					}
					
					//guardo temporalmente los datos del formulario
					$_SESSION['plan']['idPlan']       = $idPlan;
					$_SESSION['plan']['idCobro']      = $idCobro;
					$_SESSION['plan']['idApoderado']  = $idApoderado;
					
					//Obtengo los valores del plan seleccionado
					$rowPlan = db_select_data (false, 'Nombre, Valor_Mensual, Valor_Anual, N_Hijos', 'sistema_planes_transporte', '', 'idPlan = "'.$idPlan.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
		
					//Obtengo el tipo del plan seleccionado
					$rowTipoPlan = db_select_data (false, 'Nombre', 'core_tipo_cobro', '', 'idCobro = "'.$idCobro.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
		
					//Se crea un registro de facturacion ya pagado
					switch ($idCobro) {
						/***************************************************************************/
						//Mensual
						case 1:
							$montoPago     = ($rowPlan['Valor_Mensual']/30)*$DiasDisponibles;
							
							/********************************************************/
							//Actualizo el Plan del apoderado
							$a = "idApoderado='".$idApoderado."'" ;
							if(isset($idPlan) && $idPlan != ''){     $a .= ",idPlan='".$idPlan."'" ;}
							if(isset($idCobro) && $idCobro != ''){   $a .= ",idCobro='".$idCobro."'" ;}
							
							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'apoderados_listado', 'idApoderado = "'.$idApoderado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
							/********************************************************/
							//Variable
							$fCreacion      = fecha_actual();
									
							//Ingreso el dato en el listado de Planes
							if(isset($idApoderado) && $idApoderado != ''){    $a  = "'".$idApoderado."'" ;  }else{$a  ="''";}
							if(isset($idPlan) && $idPlan != ''){              $a .= ",'".$idPlan."'" ;      }else{$a .=",''";}
							if(isset($idCobro) && $idCobro != ''){            $a .= ",'".$idCobro."'" ;     }else{$a .=",''";}
							if(isset($fCreacion) && $fCreacion!= ''){  
								$a .= ",'".$fCreacion."'" ;  
								$a .= ",'".fecha2NMes($fCreacion)."'" ;
								$a .= ",'".fecha2Ano($fCreacion)."'" ;
							}else{
								$a .= ",''";
								$a .= ",''";
								$a .= ",''";
							}
							$a .= ",'1'" ;//Activo									
							// inserto los datos de registro en la db
							$query  = "INSERT INTO `apoderados_listado_planes_contratados` (
							idApoderado, idPlan, idCobro, fCreacion, MesCreacion, AnoCreacion, idEstado ) 
							VALUES (".$a.")";
							//Consulta
							$resultado = mysqli_query ($dbConn, $query);
							
							$_SESSION['usuario']['basic_data']['idPlan']             = $idPlan;
							$_SESSION['usuario']['basic_data']['PlanNombre']         = $rowPlan['Nombre'];
							$_SESSION['usuario']['basic_data']['TipoPlanNombre']     = $rowTipoPlan['Nombre'];
							$_SESSION['usuario']['basic_data']['TipoPlan_idCobro']   = $idCobro;
							$_SESSION['usuario']['basic_data']['PlanValor_Mensual']  = $rowPlan['Valor_Mensual'];
							$_SESSION['usuario']['basic_data']['PlanValor_Anual']    = $rowPlan['Valor_Anual'];
							$_SESSION['usuario']['basic_data']['PlanN_Hijos']        = $rowPlan['N_Hijos'];
									
							//Elimino los datos temporales
							unset($_SESSION['plan']);  //el plan
							
							//redirijo
							//header( 'Location: principal.php' );
							//die;
							
							break;
						/***************************************************************************/
						//Anual
						case 2:
							$montoPago     = ($rowPlan['Valor_Anual']/10)*$MesesDisponibles;
							
							//Elimino los datos previos del form
							unset($_SESSION['form_require']);
				
							/*******************************************************************/
							//Proceso a pago
							$_SESSION['trbnk']['montoPago']    = $montoPago;
							$_SESSION['trbnk']['buyOrder']     = genera_password_unica();
							
							//redireccion a transbank
							header( 'Location: ./transbank/registro_inicio.php' );
							die;
							
							break;
					}
				}	
			}
		break;	
/*******************************************************************************************************************/		
		case 'changePlan':
		
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");	
		
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//Variables
				$PagoOnline = 0;
				
				//Obtengo los valores del plan seleccionado
				$rowPlan = db_select_data (false, 'Nombre, Valor_Mensual, Valor_Anual', 'sistema_planes_transporte', '', 'idPlan = "'.$idPlan.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				//Obtengo el tipo del plan seleccionado
				$rowTipoPlan = db_select_data (false, 'Nombre', 'core_tipo_cobro', '', 'idCobro = "'.$idCobro.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				//calculo meses
				$DiasDisponibles  = 30 - dia_actual() + 1; //se suma 1 para evitar dias disponibles en 0
				$MesesDisponibles = 12 - mes_actual();	
				//si meses disponibles es superior a 10
				if($MesesDisponibles>10){
					$MesesDisponibles = 10;
				}
				
				//Guardo los datos antiguos
				$_SESSION['old_plan']['PlanNombre']      = $_SESSION['usuario']['basic_data']['PlanNombre'];
				$_SESSION['old_plan']['TipoPlanNombre']  = $_SESSION['usuario']['basic_data']['TipoPlanNombre'];
				
				switch ($_SESSION['usuario']['basic_data']['TipoPlan_idCobro']) {
					//Mensual
					case 1:
						$_SESSION['old_plan']['PlanValor'] = $_SESSION['usuario']['basic_data']['PlanValor_Mensual'];
						break;
					//Anual
					case 2:
						$_SESSION['old_plan']['PlanValor'] = $_SESSION['usuario']['basic_data']['PlanValor_Anual'];
						break;
				}
				switch ($_SESSION['usuario']['basic_data']['idPlan']) {
					//1 Hijo
					case 1:
						$_SESSION['old_plan']['hijos'] = "1 Hijo inscrito";	
						break;
					//2 Hijos
					case 2:
						$_SESSION['old_plan']['hijos'] = "2 Hijos inscritos";
						break;
					//3 o mas Hijos
					case 3:
						$_SESSION['old_plan']['hijos'] = "3 o mas Hijos inscritos";
						break;
				}
								
				//Se crea un registro de facturacion ya pagado
				switch ($idCobro) {
					//Mensual
					case 1:
						$MontoPactado  = 0;
						$montoPago     = 0;
						break;
					//Anual
					case 2:
						$MontoPactado  = $rowPlan['Valor_Anual'];
						$montoPago     = ($rowPlan['Valor_Anual']/10)*$MesesDisponibles;
						break;
				}
				
				
				//Calculo lo ya consumido
				switch ($_SESSION['usuario']['basic_data']['TipoPlan_idCobro']) {
					//Mensual
					case 1:
						$Cobrado   = 0;
						$Sobrante  = 0;
					break;
					//Anual
					case 2:
						$Cobrado   = ($_SESSION['usuario']['basic_data']['PlanValor_Anual']/10) * (10-$MesesDisponibles);
						$Sobrante  = $_SESSION['usuario']['basic_data']['PlanValor_Anual'] - $Cobrado;
					break;
				}

				/***********************************************************/
				//Verifico que no se seleccionen los mismos datos
				if($idPlan==$idPlanOld && $idCobro==$idCobroOld){
					//no se hace nada y se redirige a la pagina principal	
					header( 'Location: '.$location.'?edited=true' );
					die;				
				//si alguno de los dos es distinto
				}else{
					//depepndiendo del tipo de cobro se ejecutan procesos
					switch ($idCobro) {
						//Mensual (no se hace facturacion, solo se guardan los cambios)
						case 1:
							//Variable
							$fCreacion      = fecha_actual();
							
							/********************************************************/
							//deshabilito el ultimo plan
							$a  = "idEstado='2'" ;
							$a .= ",fCierre='".$fCreacion."'" ;
							$a .= ",idUsuarioCierre='3'" ;
							$a .= ",Observaciones='Cambio de Plan'" ;
							
							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'apoderados_listado_planes_contratados', 'idApoderado = "'.$idApoderado.'" AND idEstado=1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
							/********************************************************/
							//creo el nuevo contrato plan
							//Ingreso el dato en el listado de Planes
							if(isset($idApoderado) && $idApoderado != ''){    $a  = "'".$idApoderado."'" ;  }else{$a  ="''";}
							if(isset($idPlan) && $idPlan != ''){              $a .= ",'".$idPlan."'" ;      }else{$a .=",''";}
							if(isset($idCobro) && $idCobro != ''){            $a .= ",'".$idCobro."'" ;     }else{$a .=",''";}
							if(isset($fCreacion) && $fCreacion!= ''){  
								$a .= ",'".$fCreacion."'" ;  
								$a .= ",'".fecha2NMes($fCreacion)."'" ;
								$a .= ",'".fecha2Ano($fCreacion)."'" ;
							}else{
								$a .= ",''";
								$a .= ",''";
								$a .= ",''";
							}
							$a .= ",'1'" ;//Activo									
							// inserto los datos de registro en la db
							$query  = "INSERT INTO `apoderados_listado_planes_contratados` (
							idApoderado, idPlan, idCobro, fCreacion, MesCreacion, AnoCreacion, idEstado ) 
							VALUES (".$a.")";
							//Consulta
							$resultado = mysqli_query ($dbConn, $query);
							
							
							/********************************************************/
							//actualizo el plan del cliente
							$a = "idApoderado='".$idApoderado."'" ;
							if(isset($idPlan) && $idPlan != ''){     $a .= ",idPlan='".$idPlan."'" ;}
							if(isset($idCobro) && $idCobro != ''){   $a .= ",idCobro='".$idCobro."'" ;}
							
							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'apoderados_listado', 'idApoderado = "'.$idApoderado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
							/****************************************************************************************************/
							//Reseteo el plan de la sesion
							$_SESSION['usuario']['basic_data']['idPlan']             = $idPlan;
							$_SESSION['usuario']['basic_data']['PlanNombre']         = $rowPlan['Nombre'];
							$_SESSION['usuario']['basic_data']['TipoPlanNombre']     = $rowTipoPlan['Nombre'];
							$_SESSION['usuario']['basic_data']['TipoPlan_idCobro']   = $idCobro;
							$_SESSION['usuario']['basic_data']['PlanValor_Mensual']  = $rowPlan['Valor_Mensual'];
							$_SESSION['usuario']['basic_data']['PlanValor_Anual']    = $rowPlan['Valor_Anual'];
				
							/****************************************************************************************************/
							//realizo el envio de correo en caso de cambio de plan
							switch ($idCobro) {
								//Mensual
								case 1:
									$PlanValor = $rowPlan['Valor_Mensual'];
									break;
								//Anual
								case 2:
									$PlanValor = $rowPlan['Valor_Anual'];
									break;
							}
							switch ($idPlan) {
								//1 Hijo
								case 1:
									$Hijos = "1 Hijo inscrito";	
									break;
								//2 Hijos
								case 2:
									$Hijos = "2 Hijos inscritos";
									break;
								//3 o mas Hijos
								case 3:
									$Hijos = "3 o mas Hijos inscritos";
									break;
							}
							
							//Cuerpo del correo
							$BodyMail  = '<p>';
							$BodyMail .= 'Estimado '.$_SESSION['usuario']['basic_data']['Nombre'].'<br/>';
							$BodyMail .= '<br/>';
							$BodyMail .= 'Junto con saludar, nos dirigimos a usted para entregar la siguiente información. El día de hoy '.fecha_estandar(fecha_actual()).', se ha realizado un cambio de plan Busafe, correspondiente a.<br/>';
							$BodyMail .= '<strong>Plan:</strong> De '.$_SESSION['old_plan']['PlanNombre'].' a '.$rowPlan['Nombre'].'<br/>';
							$BodyMail .= '<strong>Modalidad de Pago:</strong> De '.$_SESSION['old_plan']['TipoPlanNombre'].' a '.$rowTipoPlan['Nombre'].'<br/>';
							$BodyMail .= '<strong>Monto:</strong> De '.valores($_SESSION['old_plan']['PlanValor'], 0).' a '.valores($PlanValor, 0).'<br/>';
							$BodyMail .= '<strong>Cantidad Hijos:</strong> De '.$_SESSION['old_plan']['hijos'].' a '.$Hijos.'<br/>';
							$BodyMail .= '<br/>';
							$BodyMail .= 'Si usted no ha realizado este cambio, favor comunicarse directamente con contacto@busafe.cl<br/>';
							$BodyMail .= 'Sin otro particular, muchas gracias.<br/>';
							$BodyMail .= 'Se despide<br/>';
							$BodyMail .= 'Equipo Busafe<br/>';
							$BodyMail .= '</p>';
								
							//Se verifica que existan datos
							$EmpresaNombre   = $_SESSION['usuario']['basic_data']['EmpresaNombre'];
							$EmpresaEmail    = $_SESSION['usuario']['basic_data']['EmpresaEmail'];
							$ApoderadoEmail  = $_SESSION['usuario']['basic_data']['Email'];
							$Gmail_Usuario   = $_SESSION['usuario']['basic_data']['Gmail_Usuario'];
							$Gmail_Password  = $_SESSION['usuario']['basic_data']['Gmail_Password'];
							
							if(isset($EmpresaEmail)&&$EmpresaEmail!=''&&isset($ApoderadoEmail)&&$ApoderadoEmail!=''&&isset($BodyMail)&&$BodyMail!=''){
								
								//Se agrega el header
								$BodyMail2  = '<img src="https://apoderado.busafe.cl/img/mail_header_logo.jpg" class="CToWUd a6T" tabindex="0" width="800">';
								$BodyMail2 .= '<br/><br/>';
								$BodyMail2 .= $BodyMail;
					
								$rmail = tareas_envio_correo($EmpresaEmail, $EmpresaNombre, 
															$ApoderadoEmail, 'Receptor', 
															'', '', 
															'Cambio de plan Busafe', 
															$BodyMail2,'', 
															'', 
															1, 
															$Gmail_Usuario, 
															$Gmail_Password);
								//se guarda el log
								log_response(1, $rmail, $ApoderadoEmail.' (Asunto:Cambio de plan Busafe)');	
				 						
							}
							/****************************************************************************************************/
							//Elimino variable temporal
							unset($_SESSION['old_plan']);
							/********************************************************/
							//Redirijo
							header( 'Location: '.$location.'?edited=true' );
							die;
							
						break;
						//Anual
						case 2:
							//Se calcula cuanto se debe pagar
							$PagoOnline = $montoPago - $Sobrante;
							
							//Si no hay pago solo se guarda los datos
							if($PagoOnline<0){
								
								/********************************************************/
								//deshabilito el ultimo plan
								$a  = "idEstado='2'" ;
								$a .= ",fCierre='".$fCreacion."'" ;
								$a .= ",idUsuarioCierre='3'" ;
								$a .= ",Observaciones='Cambio de Plan'" ;
								
								//se actualizan los datos
								$resultado = db_update_data (false, $a, 'apoderados_listado_planes_contratados', 'idApoderado = "'.$idApoderado.'" AND idEstado=1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
								/********************************************************/
								//creo el nuevo contrato plan
								//Variable
								$fCreacion      = fecha_actual();
								
								//Ingreso el dato en el listado de Planes
								if(isset($idApoderado) && $idApoderado != ''){    $a  = "'".$idApoderado."'" ;  }else{$a  ="''";}
								if(isset($idPlan) && $idPlan != ''){              $a .= ",'".$idPlan."'" ;      }else{$a .=",''";}
								if(isset($idCobro) && $idCobro != ''){            $a .= ",'".$idCobro."'" ;     }else{$a .=",''";}
								if(isset($fCreacion) && $fCreacion!= ''){  
									$a .= ",'".$fCreacion."'" ;  
									$a .= ",'".fecha2NMes($fCreacion)."'" ;
									$a .= ",'".fecha2Ano($fCreacion)."'" ;
								}else{
									$a .= ",''";
									$a .= ",''";
									$a .= ",''";
								}
								$a .= ",'1'" ;//Activo									
								// inserto los datos de registro en la db
								$query  = "INSERT INTO `apoderados_listado_planes_contratados` (
								idApoderado, idPlan, idCobro, fCreacion, MesCreacion, AnoCreacion, idEstado ) 
								VALUES (".$a.")";
								//Consulta
								$resultado = mysqli_query ($dbConn, $query);
								
								
								/********************************************************/
								//actualizo el plan del cliente
								$a = "idApoderado='".$idApoderado."'" ;
								if(isset($idPlan) && $idPlan != ''){     $a .= ",idPlan='".$idPlan."'" ;}
								if(isset($idCobro) && $idCobro != ''){   $a .= ",idCobro='".$idCobro."'" ;}
								
								//se actualizan los datos
								$resultado = db_update_data (false, $a, 'apoderados_listado', 'idApoderado = "'.$idApoderado.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
								/****************************************************************************************************/
								//Reseteo el plan de la sesion
								$_SESSION['usuario']['basic_data']['idPlan']             = $idPlan;
								$_SESSION['usuario']['basic_data']['PlanNombre']         = $rowPlan['Nombre'];
								$_SESSION['usuario']['basic_data']['TipoPlanNombre']     = $rowTipoPlan['Nombre'];
								$_SESSION['usuario']['basic_data']['TipoPlan_idCobro']   = $idCobro;
								$_SESSION['usuario']['basic_data']['PlanValor_Mensual']  = $rowPlan['Valor_Mensual'];
								$_SESSION['usuario']['basic_data']['PlanValor_Anual']    = $rowPlan['Valor_Anual'];
								
								/****************************************************************************************************/
								//realizo el envio de correo en caso de cambio de plan
								switch ($idCobro) {
									//Mensual
									case 1:
										$PlanValor = $rowPlan['Valor_Mensual'];
										break;
									//Anual
									case 2:
										$PlanValor = $rowPlan['Valor_Anual'];
										break;
								}
								switch ($idPlan) {
									//1 Hijo
									case 1:
										$Hijos = "1 Hijo inscrito";	
										break;
									//2 Hijos
									case 2:
										$Hijos = "2 Hijos inscritos";
										break;
									//3 o mas Hijos
									case 3:
										$Hijos = "3 o mas Hijos inscritos";
										break;
								}
								
								//Cuerpo del correo
								$BodyMail  = '<p>';
								$BodyMail .= 'Estimado '.$_SESSION['usuario']['basic_data']['Nombre'].'<br/>';
								$BodyMail .= '<br/>';
								$BodyMail .= 'Junto con saludar, nos dirigimos a usted para entregar la siguiente información. El día de hoy '.fecha_estandar(fecha_actual()).', se ha realizado un cambio de plan Busafe, correspondiente a.<br/>';
								$BodyMail .= '<strong>Plan:</strong> De '.$_SESSION['old_plan']['PlanNombre'].' a '.$rowPlan['Nombre'].'<br/>';
								$BodyMail .= '<strong>Modalidad de Pago:</strong> De '.$_SESSION['old_plan']['TipoPlanNombre'].' a '.$rowTipoPlan['Nombre'].'<br/>';
								$BodyMail .= '<strong>Monto:</strong> De '.valores($_SESSION['old_plan']['PlanValor'], 0).' a '.valores($PlanValor, 0).'<br/>';
								$BodyMail .= '<strong>Cantidad Hijos:</strong> De '.$_SESSION['old_plan']['hijos'].' a '.$Hijos.'<br/>';
								$BodyMail .= '<br/>';
								$BodyMail .= 'Si usted no ha realizado este cambio, favor comunicarse directamente con contacto@busafe.cl<br/>';
								$BodyMail .= 'Sin otro particular, muchas gracias.<br/>';
								$BodyMail .= 'Se despide<br/>';
								$BodyMail .= 'Equipo Busafe<br/>';
								$BodyMail .= '</p>';
									
								//Se verifica que existan datos
								$EmpresaNombre   = $_SESSION['usuario']['basic_data']['EmpresaNombre'];
								$EmpresaEmail    = $_SESSION['usuario']['basic_data']['EmpresaEmail'];
								$ApoderadoEmail  = $_SESSION['usuario']['basic_data']['Email'];
								$Gmail_Usuario   = $_SESSION['usuario']['basic_data']['Gmail_Usuario'];
								$Gmail_Password  = $_SESSION['usuario']['basic_data']['Gmail_Password'];
								
								if(isset($EmpresaEmail)&&$EmpresaEmail!=''&&isset($ApoderadoEmail)&&$ApoderadoEmail!=''&&isset($BodyMail)&&$BodyMail!=''){
									
									//Se agrega el header
									$BodyMail2  = '<img src="https://apoderado.busafe.cl/img/mail_header_logo.jpg" class="CToWUd a6T" tabindex="0" width="800">';
									$BodyMail2 .= '<br/><br/>';
									$BodyMail2 .= $BodyMail;
								
									$rmail = tareas_envio_correo($EmpresaEmail, $EmpresaNombre, 
																$ApoderadoEmail, 'Receptor', 
																'', '', 
																'Cambio de plan Busafe', 
																$BodyMail2,'', 
																'', 
																1, 
																$Gmail_Usuario, 
																$Gmail_Password);
									//se guarda el log
									log_response(1, $rmail, $ApoderadoEmail.' (Asunto:Cambio de plan Busafe)');	
				 									
								}
								/****************************************************************************************************/
								//Elimino variable temporal
								unset($_SESSION['old_plan']);
								/********************************************************/
								//Redirijo
								header( 'Location: '.$location.'?edited=true' );
								die;
							
							//si hay pago se envia al proceso de pago	
							}else{
								//guardo temporalmente los datos del formulario
								$_SESSION['plan']['idPlan']             = $idPlan;
								$_SESSION['plan']['idCobro']            = $idCobro;
								$_SESSION['plan']['idApoderado']        = $idApoderado;
								$_SESSION['plan']['PagoOnline']         = $PagoOnline;
								$_SESSION['plan']['MontoPactado']       = $MontoPactado;
								$_SESSION['plan']['PlanNombre']         = $rowPlan['Nombre'];
								$_SESSION['plan']['TipoPlanNombre']     = $rowTipoPlan['Nombre'];
								$_SESSION['plan']['PlanValor_Mensual']  = $rowPlan['Valor_Mensual'];
								$_SESSION['plan']['PlanValor_Anual']    = $rowPlan['Valor_Anual'];
								
								//Elimino los datos previos del form
								unset($_SESSION['form_require']);
					
								/*******************************************************************/
								//Proceso a pago
								$_SESSION['trbnk']['montoPago']    = $PagoOnline;
								$_SESSION['trbnk']['buyOrder']     = genera_password_unica();
								
								//redireccion a transbank
								header( 'Location: ./transbank/cambio_plan_inicio.php' );
								die;
								
								
							}
							
						break;
					}
				}

			}
		break;		
/*******************************************************************************************************************/
	}
?>

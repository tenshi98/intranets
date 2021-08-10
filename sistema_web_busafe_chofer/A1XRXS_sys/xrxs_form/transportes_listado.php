<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridTransportead                                                */
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
	if ( !empty($_POST['idTransporte']) )          $idTransporte            = $_POST['idTransporte'];
	if ( !empty($_POST['idSistema']) )             $idSistema               = $_POST['idSistema'];
	if ( !empty($_POST['idEstado']) )              $idEstado                = $_POST['idEstado'];
	if ( !empty($_POST['idTipo']) )                $idTipo                  = $_POST['idTipo'];
	if ( !empty($_POST['idRubro']) )               $idRubro                 = $_POST['idRubro'];
	if ( !empty($_POST['email']) )                 $email                   = $_POST['email'];
	if ( !empty($_POST['Nombre']) )                $Nombre 	                = $_POST['Nombre'];
	if ( !empty($_POST['RazonSocial']) )           $RazonSocial 	        = $_POST['RazonSocial'];
	if ( !empty($_POST['Rut']) )                   $Rut 	                = $_POST['Rut'];
	if ( !empty($_POST['fNacimiento']) )           $fNacimiento 	        = $_POST['fNacimiento'];
	if ( !empty($_POST['Direccion']) )             $Direccion 	            = $_POST['Direccion'];
	if ( !empty($_POST['Fono1']) )                 $Fono1 	                = $_POST['Fono1'];
	if ( !empty($_POST['Fono2']) )                 $Fono2 	                = $_POST['Fono2'];
	if ( !empty($_POST['idCiudad']) )              $idCiudad                = $_POST['idCiudad'];
	if ( !empty($_POST['idComuna']) )              $idComuna                = $_POST['idComuna'];
	if ( !empty($_POST['Fax']) )                   $Fax                     = $_POST['Fax'];
	if ( !empty($_POST['PersonaContacto']) )       $PersonaContacto         = $_POST['PersonaContacto'];
	if ( !empty($_POST['PersonaContacto_Fono']) )  $PersonaContacto_Fono    = $_POST['PersonaContacto_Fono'];
	if ( !empty($_POST['PersonaContacto_email']) ) $PersonaContacto_email   = $_POST['PersonaContacto_email'];
	if ( !empty($_POST['Web']) )                   $Web                     = $_POST['Web'];
	if ( !empty($_POST['Giro']) )                  $Giro                    = $_POST['Giro'];
	if ( !empty($_POST['password']) )              $password                = $_POST['password'];
	if ( !empty($_POST['idBanco']) )               $idBanco                 = $_POST['idBanco'];
	if ( !empty($_POST['NCuentaBanco']) )          $NCuentaBanco            = $_POST['NCuentaBanco'];
	if ( !empty($_POST['MailBanco']) )             $MailBanco               = $_POST['MailBanco'];
	if ( !empty($_POST['password']) )              $password                = $_POST['password'];
	if ( !empty($_POST['repassword']) )            $repassword              = $_POST['repassword'];
	if ( !empty($_POST['oldpassword']) )           $oldpassword             = $_POST['oldpassword'];
	
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
			case 'idTransporte':           if(empty($idTransporte)){           $error['idTransporte']               = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){              $error['idSistema']               = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':               if(empty($idEstado)){               $error['idEstado']                = 'error/No ha seleccionado el Estado';}break;
			case 'idTipo':                 if(empty($idTipo)){                 $error['idTipo']                  = 'error/No ha seleccionado el tipo de transporte';}break;
			case 'idRubro':                if(empty($idRubro)){                $error['idRubro']                 = 'error/No ha seleccionado el rubro';}break;
			case 'email':                  if(empty($email)){                  $error['email']                   = 'error/No ha ingresado el email';}break;
			case 'Nombre':                 if(empty($Nombre)){                 $error['Nombre']                  = 'error/No ha ingresado el Nombre de Fantasia';}break;
			case 'RazonSocial':            if(empty($RazonSocial)){            $error['RazonSocial']             = 'error/No ha ingresado la Razon Social';}break;
			case 'Rut':                    if(empty($Rut)){                    $error['Rut']                     = 'error/No ha ingresado el Rut';}break;	
			case 'fNacimiento':            if(empty($fNacimiento)){            $error['fNacimiento']             = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Direccion':              if(empty($Direccion)){              $error['Direccion']               = 'error/No ha ingresado la direccion';}break;
			case 'Fono1':                  if(empty($Fono1)){                  $error['Fono1']                   = 'error/No ha ingresado el telefono';}break;
			case 'Fono2':                  if(empty($Fono2)){                  $error['Fono2']                   = 'error/No ha ingresado el telefono';}break;
			case 'idCiudad':               if(empty($idCiudad)){               $error['idCiudad']                = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':               if(empty($idComuna)){               $error['idComuna']                = 'error/No ha seleccionado la comuna';}break;
			case 'Fax':                    if(empty($Fax)){                    $error['Fax']                     = 'error/No ha ingresado el fax';}break;
			case 'PersonaContacto':        if(empty($PersonaContacto)){        $error['PersonaContacto']         = 'error/No ha ingresado el nombre de la persona de contacto';}break;
			case 'PersonaContacto_Fono':   if(empty($PersonaContacto_Fono)){   $error['PersonaContacto_Fono']    = 'error/No ha ingresado el nombre de la persona de contacto';}break;
			case 'PersonaContacto_email':  if(empty($PersonaContacto_email)){  $error['PersonaContacto_email']   = 'error/No ha ingresado el nombre de la persona de contacto';}break;
			case 'Web':                    if(empty($Web)){                    $error['Web']                     = 'error/No ha ingresado la pagina web';}break;
			case 'Giro':                   if(empty($Giro)){                   $error['Giro']                    = 'error/No ha ingresado el Giro de la empresa';}break;
			case 'password':               if(empty($password)){               $error['password']                = 'error/No ha ingresado el password';}break;
			case 'idBanco':                if(empty($idBanco)){                $error['idBanco']                 = 'error/No ha seleccionado el banco';}break;
			case 'NCuentaBanco':           if(empty($NCuentaBanco)){           $error['NCuentaBanco']            = 'error/No ha ingresado el numero de cuenta de banco';}break;
			case 'MailBanco':              if(empty($MailBanco)){              $error['MailBanco']               = 'error/No ha ingresado el email de confirmacion';}break;
			case 'repassword':             if(empty($repassword)){             $error['repassword']              = 'error/No ha ingresado la repeticion de la clave';}break;
			case 'oldpassword':            if(empty($oldpassword)){            $error['oldpassword']             = 'error/No ha ingresado su clave antigua';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){                                 $error['email']                = 'error/El Email ingresado no es valido'; }
	if(isset($Fono1)&&!validarNumero($Fono1)) {                               $error['Fono1']                = 'error/Ingrese un numero telefonico valido'; }
	if(isset($Fono2)&&!validarNumero($Fono2)) {                               $error['Fono2']                = 'error/Ingrese un numero telefonico valido'; }
	if(isset($Rut)&&!validarRut($Rut)){                                       $error['Rut']                  = 'error/El Rut ingresado no es valido'; }
	if(isset($PersonaContacto_email)&&!validarEmail($PersonaContacto_email)){ $error['email']                = 'error/El Email ingresado no es valido'; }	
	if(isset($PersonaContacto_Fono)&&!validarNumero($PersonaContacto_Fono)) { $error['PersonaContacto_Fono'] = 'error/Ingrese un numero telefonico valido'; }
	if(isset($MailBanco)&&!validarEmail($MailBanco)){                         $error['MailBanco']            = 'error/El Email ingresado no es valido'; }
	if(isset($password)&&isset($repassword)){
		if ( $password <> $repassword )                  $error['password']  = 'error/Las contraseñas ingresadas no coinciden'; 
	}
	if(isset($password)){
		if (strpos($password, " ")){                     $error['Password1'] = 'error/La contraseña contiene espacios vacios';}
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
			if(isset($Nombre)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'transportes_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'transportes_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)){
				$ndata_3 = db_select_nrows (false, 'email', 'transportes_listado', '', "email='".$email."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/
			
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//se genera password aleatorio
				$password = genera_password(8,'alfanumerico');
				
				//filtros
				if(isset($idSistema) && $idSistema != ''){                           $a  = "'".$idSistema."'" ;               }else{$a ="''";}
				if(isset($idEstado) && $idEstado != ''){                             $a .= ",'".$idEstado."'" ;               }else{$a .= ",''";}
				if(isset($idTipo) && $idTipo != ''){                                 $a .= ",'".$idTipo."'" ;                 }else{$a .= ",''";}
				if(isset($idRubro) && $idRubro != ''){                               $a .= ",'".$idRubro."'" ;                }else{$a .= ",''";}
				if(isset($email) && $email != ''){                                   $a .= ",'".$email."'" ;                  }else{$a .= ",''";}
				if(isset($Nombre) && $Nombre != ''){                                 $a .= ",'".$Nombre."'" ;                 }else{$a .= ",''";}
				if(isset($RazonSocial) && $RazonSocial != ''){                       $a .= ",'".$RazonSocial."'" ;            }else{$a .= ",''";}
				if(isset($Rut) && $Rut != ''){                                       $a .= ",'".$Rut."'" ;                    }else{$a .= ",''";}
				if(isset($fNacimiento) && $fNacimiento != ''){                       $a .= ",'".$fNacimiento."'" ;            }else{$a .= ",''";}
				if(isset($Direccion) && $Direccion != ''){                           $a .= ",'".$Direccion."'" ;              }else{$a .= ",''";}
				if(isset($Fono1) && $Fono1 != ''){                                   $a .= ",'".$Fono1."'" ;                  }else{$a .= ",''";}
				if(isset($Fono2) && $Fono2 != ''){                                   $a .= ",'".$Fono2."'" ;                  }else{$a .= ",''";}
				if(isset($idCiudad) && $idCiudad != ''){                             $a .= ",'".$idCiudad."'" ;               }else{$a .= ",''";}
				if(isset($idComuna) && $idComuna != ''){                             $a .= ",'".$idComuna."'" ;               }else{$a .= ",''";}
				if(isset($Fax) && $Fax != ''){                                       $a .= ",'".$Fax."'" ;                    }else{$a .= ",''";}
				if(isset($PersonaContacto) && $PersonaContacto != ''){               $a .= ",'".$PersonaContacto."'" ;        }else{$a .= ",''";}
				if(isset($PersonaContacto_Fono) && $PersonaContacto_Fono != ''){     $a .= ",'".$PersonaContacto_Fono."'" ;   }else{$a .= ",''";}
				if(isset($PersonaContacto_email) && $PersonaContacto_email != ''){   $a .= ",'".$PersonaContacto_email."'" ;  }else{$a .= ",''";}
				if(isset($Web) && $Web != ''){                                       $a .= ",'".$Web."'" ;                    }else{$a .= ",''";}
				if(isset($Giro) && $Giro != ''){                                     $a .= ",'".$Giro."'" ;                   }else{$a .= ",''";}
				if(isset($password) && $password != ''){                             $a .= ",'".md5($password)."'" ;          }else{$a .= ",''";}
				if(isset($idBanco) && $idBanco != ''){                               $a .= ",'".$idBanco."'" ;                }else{$a .= ",''";}
				if(isset($NCuentaBanco) && $NCuentaBanco != ''){                     $a .= ",'".$NCuentaBanco."'" ;           }else{$a .= ",''";}
				if(isset($MailBanco) && $MailBanco != ''){                           $a .= ",'".$MailBanco."'" ;              }else{$a .= ",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `transportes_listado` (idSistema, idEstado, idTipo, idRubro, email, Nombre,
				RazonSocial, Rut, fNacimiento, Direccion, Fono1, Fono2, idCiudad, idComuna, Fax, PersonaContacto,
				PersonaContacto_Fono, PersonaContacto_email, Web, Giro, password, idBanco, NCuentaBanco, MailBanco) 
				VALUES (".$a.")";
				$result = mysqli_query($dbConn, $query);
				
				/******************************************************************/
				//traigo los datos almacenados
				$rowusr = db_select_data (false, 'Nombre, email_principal, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'core_sistemas', '', 'idSistema=1', $dbConn, 'Login-form', $original, $form_trabajo);
				
				//Envio de correo
				$texto  = '<p>Estimado(a) '.$Nombre.'</p>'; 
				$texto .= '<p><strong>¡Te damos la bienvenida a Busafe!</strong></p>'; 
				$texto .= '<p>Desde este momento agregarás una capa de valor al servicio de transporte escolar. Te recordamos que puedes gestionar y administrar aspectos de tu negocio, como gasto en combustible, tarifas cobradas, rutas, velocidades, kilómetros recorridos, etc.</p>'; 
				$texto .= '<p>Recuerda que para los transportistas es un servicio totalmente gratuito.</p>'; 
				$texto .= '<p>Te recordamos tus accesos a la aplicación y administración web (chofer.busafe.cl):</p>'; 
				$texto .= '<ul>';
				$texto .= '<li><strong>Usuario: '.$Rut.'</strong></li>';
				$texto .= '<li><strong>Contraseña: '.$password.'</strong></li>';
				$texto .= '</ul>';
				$texto .= '<p>Puedes cambiar tu contraseña <a href="https://chofer.busafe.cl/principal_datos_datos_password.php" target="_blank" rel="noopener noreferrer" >aqui</a>, o “mis datos”>”ver más”>”Password”</p>'; 
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
					$error['email'] = 'error/'.$rmail;
				} else {
					header( 'Location: '.$location.'?created=true' );
					die;
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
			$ndata_4 = 1;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idTransporte)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'transportes_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idTransporte!='".$idTransporte."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idTransporte)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'transportes_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idTransporte!='".$idTransporte."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idTransporte)){
				$ndata_3 = db_select_nrows (false, 'email', 'transportes_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idTransporte!='".$idTransporte."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($oldpassword)&&isset($idTransporte)){
				$ndata_4 = db_select_nrows (false, 'password', 'transportes_listado', '', "idTransporte='".$idTransporte."' AND password='".md5($oldpassword)."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			if($ndata_4 == 0) {$error['ndata_4'] = 'error/Las contraseñas ingresadas no coinciden';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idTransporte='".$idTransporte."'" ;
				if(isset($idSistema) && $idSistema != ''){                           $a .= ",idSistema='".$idSistema."'" ;}
				if(isset($idEstado) && $idEstado != ''){                             $a .= ",idEstado='".$idEstado."'" ;}
				if(isset($idTipo) && $idTipo != ''){                                 $a .= ",idTipo='".$idTipo."'" ;}
				if(isset($idRubro) && $idRubro != ''){                               $a .= ",idRubro='".$idRubro."'" ;}
				if(isset($email) && $email != ''){                                   $a .= ",email='".$email."'" ;}
				if(isset($Nombre) && $Nombre != ''){                                 $a .= ",Nombre='".$Nombre."'" ;}
				if(isset($RazonSocial) && $RazonSocial != ''){                       $a .= ",RazonSocial='".$RazonSocial."'" ;}
				if(isset($Rut) && $Rut != ''){                                       $a .= ",Rut='".$Rut."'" ;}
				if(isset($fNacimiento) && $fNacimiento != ''){                       $a .= ",fNacimiento='".$fNacimiento."'" ;}
				if(isset($Direccion) && $Direccion != ''){                           $a .= ",Direccion='".$Direccion."'" ;}
				if(isset($Fono1) && $Fono1 != ''){                                   $a .= ",Fono1='".$Fono1."'" ;}
				if(isset($Fono2) && $Fono2 != ''){                                   $a .= ",Fono2='".$Fono2."'" ;}
				if(isset($idCiudad) && $idCiudad!= ''){                              $a .= ",idCiudad='".$idCiudad."'" ;}
				if(isset($idComuna) && $idComuna!= ''){                              $a .= ",idComuna='".$idComuna."'" ;}
				if(isset($Fax) && $Fax!= ''){                                        $a .= ",Fax='".$Fax."'" ;}
				if(isset($PersonaContacto) && $PersonaContacto!= ''){                $a .= ",PersonaContacto='".$PersonaContacto."'" ;}
				if(isset($PersonaContacto_Fono) && $PersonaContacto_Fono!= ''){      $a .= ",PersonaContacto_Fono='".$PersonaContacto_Fono."'" ;}
				if(isset($PersonaContacto_email) && $PersonaContacto_email!= ''){    $a .= ",PersonaContacto_email='".$PersonaContacto_email."'" ;}
				if(isset($Web) && $Web!= ''){                                        $a .= ",Web='".$Web."'" ;}
				if(isset($Giro) && $Giro!= ''){                                      $a .= ",Giro='".$Giro."'" ;}
				if(isset($password) && $password!= ''){                              $a .= ",password='".md5($password)."'" ;}
				if(isset($idBanco) && $idBanco!= ''){                                $a .= ",idBanco='".$idBanco."'" ;}
				if(isset($NCuentaBanco) && $NCuentaBanco!= ''){                      $a .= ",NCuentaBanco='".$NCuentaBanco."'" ;}
				if(isset($MailBanco) && $MailBanco!= ''){                            $a .= ",MailBanco='".$MailBanco."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'transportes_listado', 'idTransporte = "'.$idTransporte.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					header( 'Location: '.$location.'?edited=true' );
					die;
				}
				
				
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
			$password = preg_replace("/[^a-zA-Z0-9_\-]+ñÑáéíóúÁÉÍÓÚ-_?¿°()=,.<>:;*@/","",$password);
				
			//Se verifica si se trata de hacer fuerza bruta en el ingreso
			if (checkbrute($Rut, $email, $IP_Client, 'transportes_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, usuario bloqueado por 2 horas'; 
			}
			
			//si no hay errores
			if ( empty($error) ) {
						
				//Busco al usuario en el sistema
				$SIS_query = '
				transportes_listado.idTransporte, 
				transportes_listado.password, 
				transportes_listado.Rut, 
				transportes_listado.Nombre, 
				transportes_listado.idEstado, 
				transportes_listado.RazonSocial,
				transportes_listado.idSistema,
				core_sistemas.Config_idTheme,
				core_sistemas.Config_imgLogo,
				core_sistemas.Config_IDGoogle';
				$SIS_join = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = transportes_listado.idSistema';
				$SIS_where = 'transportes_listado.Rut = "'.$Rut.'" AND transportes_listado.password = "'.md5($password).'"';
				$rowUser = db_select_data (false, $SIS_query, 'transportes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);

 
				//Se verifca si los datos ingresados son de un usuario
				if (isset($rowUser['idTransporte'])&&$rowUser['idTransporte']!='') {
					
					//Verifico que el usuario identificado este activo
					if($rowUser['idEstado']==1){
						
						/**************************************************************/
						//Actualizo la tabla de los usuarios
						$a = 'Ultimo_acceso="'.$fecha.'", IP_Client="'.$IP_Client.'", Agent_Transp="'.$Agent_Transp.'"';
						$resultado = db_update_data (false, $a, 'transportes_listado', 'idTransporte = "'.$rowUser['idTransporte'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
						//busca si la ip del usuario ya existe
						$n_ip = db_select_nrows (false, 'idIpUsuario', 'transportes_listado_ip', '', "IP_Client='".$IP_Client."' AND idTransporte='".$rowUser['idTransporte']."'", $dbConn, 'Login-form', $original, $form_trabajo);
						//si la ip no existe la guarda
						if(isset($n_ip)&&$n_ip==0){
							if(isset($rowUser['idTransporte']) && $rowUser['idTransporte'] != ''){  $a  = "'".$rowUser['idTransporte']."'" ;   }else{$a  = "''";}
							if(isset($IP_Client) && $IP_Client != ''){                              $a .= ",'".$IP_Client."'" ;                }else{$a .= ",''";}
							if(isset($fecha) && $fecha != ''){                                      $a .= ",'".$fecha."'" ;                    }else{$a .= ",''";}
							if(isset($hora) && $hora != ''){                                        $a .= ",'".$hora."'" ;                     }else{$a .= ",''";}
											
							// inserto los datos de registro en la db
							$query  = "INSERT INTO `transportes_listado_ip` (idTransporte,IP_Client, Fecha, Hora) 
							VALUES (".$a.")";
							//Consulta
							$resultado = mysqli_query ($dbConn, $query);
						}
						
						/**************************************************************/
						//Inserto la fecha con el ingreso
						if(isset($rowUser['idTransporte']) && $rowUser['idTransporte'] != ''){  $a  = "'".$rowUser['idTransporte']."'" ;   }else{$a  = "''";}
						if(isset($fecha) && $fecha != ''){                                      $a .= ",'".$fecha."'" ;                    }else{$a .= ",''";}
						if(isset($hora) && $hora != ''){                                        $a .= ",'".$hora."'" ;                     }else{$a .= ",''";}
						if(isset($IP_Client) && $IP_Client != ''){                              $a .= ",'".$IP_Client."'" ;                }else{$a .= ",''";}
						if(isset($Agent_Transp) && $Agent_Transp != ''){                        $a .= ",'".$Agent_Transp."'" ;             }else{$a .= ",''";}
										
						// inserto los datos de registro en la db
						$query  = "INSERT INTO `transportes_accesos` (idTransporte,Fecha, Hora, IP_Client, Agent_Transp) 
						VALUES (".$a.")";
						//Consulta
						$resultado = mysqli_query ($dbConn, $query);
					
						//Se crean las variables con todos los datos
						$_SESSION['usuario']['basic_data']['idTransporte']       = $rowUser['idTransporte'];
						$_SESSION['usuario']['basic_data']['password']           = $rowUser['password'];
						$_SESSION['usuario']['basic_data']['Nombre']             = $rowUser['Nombre'];
						$_SESSION['usuario']['basic_data']['Rut']                = $rowUser['Rut'];
						$_SESSION['usuario']['basic_data']['idEstado']           = $rowUser['idEstado'];
						$_SESSION['usuario']['basic_data']['RazonSocial']        = $rowUser['RazonSocial'];
						$_SESSION['usuario']['basic_data']['idSistema']          = $rowUser['idSistema'];
						$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowUser['Config_idTheme'];
						$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowUser['Config_imgLogo'];
						$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowUser['Config_IDGoogle'];
						
						//Redirijo a la pagina principal
						header( 'Location: principal.php' );
						die;
						
				
					//Si no esta activo envio error	
					}else{
						$error['idTransporte']   = 'error/Su usuario esta desactivado, Contactese con el administrador';
					}
				
				//Si no se encuentra ningun usuario se envia un error	
				}else{
					$error['idTransporte']   = 'error/El Rut de usuario o contraseña no coinciden';
					
					//filtros
					if(isset($fecha) && $fecha != ''){                $a  = "'".$fecha."'" ;         }else{$a  = "''";}
					if(isset($hora) && $hora != ''){                  $a .= ",'".$hora."'" ;         }else{$a .= ",''";}
					if(isset($Rut) && $Rut != ''){                    $a .= ",'".$Rut."'" ;          }else{$a .= ",''";}
					if(isset($email) && $email != ''){                $a .= ",'".$email."'" ;        }else{$a .= ",''";}
					if(isset($IP_Client) && $IP_Client != ''){        $a .= ",'".$IP_Client."'" ;    }else{$a .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp != ''){  $a .= ",'".$Agent_Transp."'" ; }else{$a .= ",''";}
					if(isset($Time) && $Time != ''){                  $a .= ",'".$Time."'" ;         }else{$a .= ",''";}
									
					// inserto los datos de registro en la db
					$query  = "INSERT INTO `transportes_checkbrute` (Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time) 
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
			$password       = '';
				
			//Saneado de datos ingresados
			$email = preg_replace("/[^a-zA-Z0-9_\-]+ñÑáéíóúÁÉÍÓÚ-_?¿°()=,.<>:;*@/","",$email);
				
			//Se verifica si se trata de hacer fuerza bruta en el ingreso
			if (checkbrute($Rut, $email, $IP_Client, 'transportes_checkbrute', $dbConn) == true) {
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
				transportes_listado.email,
				core_sistemas.RazonSocial,
				core_sistemas.email_principal, 
				core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
				core_sistemas.Config_Gmail_Password AS Gmail_Password';
				$SIS_join = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = transportes_listado.idSistema';
				$SIS_where = 'transportes_listado.email="'.$email.'"';
				$rowusr           = db_select_data (false, $SIS_query, 'transportes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);
				$cuenta_registros = db_select_nrows (false, $SIS_query, 'transportes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);

				//verifico si los datos ingresados son iguales a los almacenados
				if(isset($cuenta_registros)&&$cuenta_registros!=''&&$cuenta_registros!=0){  
					
					//Generacion de nueva clave
					$num_caracteres = "10"; //cantidad de caracteres de la clave
					$clave = substr(md5(rand()),0,$num_caracteres); //generador aleatorio de claves 
					$nueva_clave = md5($clave);//se codifica la clave 
						
					//Actualizacion de la clave en la base de datos
					$a = 'password="'.$nueva_clave.'"';
					$resultado = db_update_data (false, $a, 'transportes_listado', 'email = "'.$email.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
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
						$error['email'] = 'error/'.$rmail;
					} else {
						$error['email'] = 'sucess/La nueva contraseña fue enviada a tu correo';
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
					$query  = "INSERT INTO `transportes_checkbrute` (Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time) 
					VALUES (".$a.")";
					//Consulta
					$resultado = mysqli_query ($dbConn, $query);
					
				}	
			}

		break;
			
/*******************************************************************************************************************/
	}
?>

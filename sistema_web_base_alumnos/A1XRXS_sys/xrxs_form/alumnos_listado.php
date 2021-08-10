<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridAlumnoad                                                */
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
	if ( !empty($_POST['idAlumno']) )              $idAlumno                = $_POST['idAlumno'];
	if ( !empty($_POST['idSistema']) )             $idSistema               = $_POST['idSistema'];
	if ( !empty($_POST['idEstado']) )              $idEstado                = $_POST['idEstado'];
	if ( !empty($_POST['idCurso']) )               $idCurso                 = $_POST['idCurso'];
	if ( !empty($_POST['email']) )                 $email                   = $_POST['email'];
	if ( !empty($_POST['Nombre']) )                $Nombre 	                = $_POST['Nombre'];
	if ( !empty($_POST['ApellidoPat']) )           $ApellidoPat 	        = $_POST['ApellidoPat'];
	if ( !empty($_POST['ApellidoMat']) )           $ApellidoMat 	        = $_POST['ApellidoMat'];
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
			case 'idAlumno':               if(empty($idAlumno)){               $error['idAlumno']                = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){              $error['idSistema']               = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':               if(empty($idEstado)){               $error['idEstado']                = 'error/No ha seleccionado el Estado';}break;
			case 'idCurso':                if(empty($idCurso)){                $error['idCurso']                 = 'error/No ha seleccionado el tipo de cliente';}break;
			case 'email':                  if(empty($email)){                  $error['email']                   = 'error/No ha ingresado el email';}break;
			case 'Nombre':                 if(empty($Nombre)){                 $error['Nombre']                  = 'error/No ha ingresado el Nombre';}break;
			case 'ApellidoPat':            if(empty($ApellidoPat)){            $error['ApellidoPat']             = 'error/No ha ingresado el Apellido Paterno';}break;
			case 'ApellidoMat':            if(empty($ApellidoMat)){            $error['ApellidoMat']             = 'error/No ha ingresado el Apellido Materno';}break;
			case 'Rut':                    if(empty($Rut)){                    $error['Rut']                     = 'error/No ha ingresado el Rut';}break;	
			case 'fNacimiento':            if(empty($fNacimiento)){            $error['fNacimiento']             = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Direccion':              if(empty($Direccion)){              $error['Direccion']               = 'error/No ha ingresado la direccion';}break;
			case 'Fono1':                  if(empty($Fono1)){                  $error['Fono1']                   = 'error/No ha ingresado el telefono';}break;
			case 'Fono2':                  if(empty($Fono2)){                  $error['Fono2']                   = 'error/No ha ingresado el telefono';}break;
			case 'idCiudad':               if(empty($idCiudad)){               $error['idCiudad']                = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':               if(empty($idComuna)){               $error['idComuna']                = 'error/No ha seleccionado la comuna';}break;
			case 'Fax':                    if(empty($Fax)){                    $error['Fax']                     = 'error/No ha ingresado el fax';}break;
			case 'PersonaContacto':        if(empty($PersonaContacto)){        $error['PersonaContacto']         = 'error/No ha ingresado el nombre de la persona de contacto';}break;
			case 'PersonaContacto_Fono':   if(empty($PersonaContacto_Fono)){   $error['PersonaContacto_Fono']    = 'error/No ha ingresado el Fono de la persona de contacto';}break;
			case 'PersonaContacto_email':  if(empty($PersonaContacto_email)){  $error['PersonaContacto_email']   = 'error/No ha ingresado el Email de la persona de contacto';}break;
			case 'Web':                    if(empty($Web)){                    $error['Web']                     = 'error/No ha ingresado la pagina web';}break;
			case 'password':               if(empty($password)){               $error['password']                = 'error/No ha ingresado el password';}break;
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
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)&&isset($idAlumno)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'alumnos_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."' AND idAlumno!='".$idAlumno."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idAlumno)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'alumnos_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idAlumno!='".$idAlumno."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idAlumno)){
				$ndata_3 = db_select_nrows (false, 'email', 'alumnos_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idAlumno!='".$idAlumno."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($oldpassword)&&isset($idAlumno)){
				$ndata_4 = db_select_nrows (false, 'password', 'alumnos_listado', '', "idAlumno='".$idAlumno."' AND password='".md5($oldpassword)."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {  $error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {  $error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {  $error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			if($ndata_4 == 0) { $error['ndata_4'] = 'error/Las contraseñas ingresadas no coinciden';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idAlumno='".$idAlumno."'" ;
				if(isset($idSistema) && $idSistema != ''){                           $a .= ",idSistema='".$idSistema."'" ;}
				if(isset($idEstado) && $idEstado != ''){                             $a .= ",idEstado='".$idEstado."'" ;}
				if(isset($idCurso) && $idCurso != ''){                               $a .= ",idCurso='".$idCurso."'" ;}
				if(isset($email) && $email != ''){                                   $a .= ",email='".$email."'" ;}
				if(isset($Nombre) && $Nombre != ''){                                 $a .= ",Nombre='".$Nombre."'" ;}
				if(isset($ApellidoPat) && $ApellidoPat != ''){                       $a .= ",ApellidoPat='".$ApellidoPat."'" ;}
				if(isset($ApellidoMat) && $ApellidoMat != ''){                       $a .= ",ApellidoMat='".$ApellidoMat."'" ;}
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
				if(isset($password) && $password!= ''){                              $a .= ",password='".md5($password)."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'alumnos_listado', 'idAlumno = "'.$idAlumno.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				//Actualizo la variable con la password
				if(isset($password) && $password!= ''){ 
					$_SESSION['usuario']['basic_data']['password'] = md5($password);
				}
				
				//redirijo
				header( 'Location: '.$location.'?edited=true' );
				die;
				
			
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
			if (checkbrute($Rut, $email, $IP_Client, 'alumnos_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, usuario bloqueado por 2 horas'; 
			}
			
			//si no hay errores
			if ( empty($error) ) {
						
				//Busco al usuario en el sistema
				$SIS_query = '
				alumnos_listado.idAlumno, 
				alumnos_listado.password, 
				alumnos_listado.Rut, 
				alumnos_listado.Nombre, 
				alumnos_listado.ApellidoPat,
				alumnos_listado.idEstado, 
				alumnos_listado.idCurso, 
				core_sistemas.Config_idTheme,
				core_sistemas.Config_imgLogo,
				core_sistemas.Config_IDGoogle,
				cursos_listado.Nombre AS CursoNombre';
				$SIS_join = '
				LEFT JOIN `core_sistemas`    ON core_sistemas.idSistema      = alumnos_listado.idSistema
				LEFT JOIN `cursos_listado`   ON cursos_listado.idCurso       = alumnos_listado.idCurso';
				$SIS_where = 'alumnos_listado.Rut = "'.$Rut.'" AND alumnos_listado.password = "'.md5($password).'"';
				$rowUser = db_select_data (false, $SIS_query, 'alumnos_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);


				//Se verifca si los datos ingresados son de un usuario
				if (isset($rowUser['idAlumno'])&&$rowUser['idAlumno']!='') {
					
					//Verifico que el usuario identificado este activo
					if($rowUser['idEstado']==1){
						
						/***************************************************************/
						//Actualizo la tabla de los usuarios
						$a = 'Ultimo_acceso="'.$fecha.'", IP_Client="'.$IP_Client.'", Agent_Transp="'.$Agent_Transp.'"';
						$resultado = db_update_data (false, $a, 'alumnos_listado', 'idAlumno = "'.$rowUser['idAlumno'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
						//busca si la ip del usuario ya existe
						$n_ip = db_select_nrows (false, 'idIpUsuario', 'alumnos_listado_ip', '', "IP_Client='".$IP_Client."' AND idCliente='".$rowUser['idCliente']."'", $dbConn, 'Login-form', $original, $form_trabajo);
						//si la ip no existe la guarda
						if(isset($n_ip)&&$n_ip==0){
							$query  = "INSERT INTO `alumnos_listado_ip` (idAlumno,IP_Client, Fecha, Hora) VALUES (".$rowUser['idAlumno'].",'".$IP_Client."','".$fecha."','".$hora."' )";
							$resultado = mysqli_query($dbConn, $query);
						}
						
						/***************************************************************/
						//Inserto la fecha con el ingreso
						$query  = "INSERT INTO `alumnos_accesos` (idAlumno,Fecha, Hora, IP_Client, Agent_Transp) VALUES (".$rowUser['idAlumno'].",'".$fecha."','".$hora."','".$IP_Client."','".$Agent_Transp."' )";
						$resultado = mysqli_query($dbConn, $query);
					
						//Se crean las variables con todos los datos
						$_SESSION['usuario']['basic_data']['idAlumno']           = $rowUser['idAlumno'];
						$_SESSION['usuario']['basic_data']['password']           = $rowUser['password'];
						$_SESSION['usuario']['basic_data']['Nombre']             = $rowUser['Nombre'].' '.$rowUser['ApellidoPat'];
						$_SESSION['usuario']['basic_data']['Rut']                = $rowUser['Rut'];
						$_SESSION['usuario']['basic_data']['idEstado']           = $rowUser['idEstado'];
						$_SESSION['usuario']['basic_data']['idCurso']            = $rowUser['idCurso'];
						$_SESSION['usuario']['basic_data']['CursoNombre']        = $rowUser['CursoNombre'];
						$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowUser['Config_idTheme'];
						$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowUser['Config_imgLogo'];
						$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowUser['Config_IDGoogle'];
						
						//Redirijo a la pagina principal
						header( 'Location: principal.php' );
						die;
						
				
					//Si no esta activo envio error	
					}else{
						$error['idAlumno']   = 'error/Su usuario esta desactivado, Contactese con el administrador';
					}
				
				//Si no se encuentra ningun usuario se envia un error	
				}else{
					$error['idAlumno']   = 'error/El Rut de usuario o contraseña no coinciden';
					
					//filtros
					if(isset($fecha) && $fecha != ''){                $a  = "'".$fecha."'" ;         }else{$a  = "''";}
					if(isset($hora) && $hora != ''){                  $a .= ",'".$hora."'" ;         }else{$a .= ",''";}
					if(isset($Rut) && $Rut != ''){                    $a .= ",'".$Rut."'" ;          }else{$a .= ",''";}
					if(isset($email) && $email != ''){                $a .= ",'".$email."'" ;        }else{$a .= ",''";}
					if(isset($IP_Client) && $IP_Client != ''){        $a .= ",'".$IP_Client."'" ;    }else{$a .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp != ''){  $a .= ",'".$Agent_Transp."'" ; }else{$a .= ",''";}
					if(isset($Time) && $Time != ''){                  $a .= ",'".$Time."'" ;         }else{$a .= ",''";}
									
					// inserto los datos de registro en la db
					$query  = "INSERT INTO `clientes_checkbrute` (Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time) 
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
			if (checkbrute($Rut, $email, $IP_Client, 'alumnos_checkbrute', $dbConn) == true) {
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
				alumnos_listado.email,
				core_sistemas.RazonSocial,
				core_sistemas.email_principal, 
				core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
				core_sistemas.Config_Gmail_Password AS Gmail_Password';
				$SIS_join = '
				LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = alumnos_listado.idSistema';
				$SIS_where = 'alumnos_listado.email="'.$email.'"';
				$rowusr           = db_select_data (false, $SIS_query, 'alumnos_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);
				$cuenta_registros = db_select_nrows (false, $SIS_query, 'alumnos_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);

				//verifico si los datos ingresados son iguales a los almacenados
				if(isset($cuenta_registros)&&$cuenta_registros!=''&&$cuenta_registros!=0){  
					
					//Generacion de nueva clave
					$num_caracteres = "10"; //cantidad de caracteres de la clave
					$clave = substr(md5(rand()),0,$num_caracteres); //generador aleatorio de claves 
					$nueva_clave = md5($clave);//se codifica la clave 
						
					//Actualizacion de la clave en la base de datos
					$a = 'password="'.$nueva_clave.'"';
					$resultado = db_update_data (false, $a, 'alumnos_listado', 'email = "'.$email.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
					//Envio de correo
					$texto = '<p>Se ha generado una nueva contraseña para el usuario '.$email.', su nueva contraseña es: '.$nueva_clave.'</p>';
					$rmail = tareas_envio_correo($rowusr['email_principal'], $rowusr['RazonSocial'], 
												 $email, 'Receptor', 
												 '', '', 
												 'Cambio de password', 
												 $texto,'', 
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
					$query  = "INSERT INTO `clientes_checkbrute` (Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time) 
					VALUES (".$a.")";
					//Consulta
					$resultado = mysqli_query ($dbConn, $query);
					
				}
			

					
			}

		break;			
/*******************************************************************************************************************/
	}
?>

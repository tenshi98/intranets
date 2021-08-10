<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridClientead                                                */
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
	if ( !empty($_POST['idCliente']) )             $idCliente               = simpleDecode($_POST['idCliente'], fecha_actual());
	if ( !empty($_POST['idSistema']) )             $idSistema               = simpleDecode($_POST['idSistema'], fecha_actual());
	if ( !empty($_POST['idEstado']) )              $idEstado                = $_POST['idEstado'];
	if ( !empty($_POST['idTipo']) )                $idTipo                  = $_POST['idTipo'];
	if ( !empty($_POST['idRubro']) )               $idRubro                 = $_POST['idRubro'];
	if ( !empty($_POST['email']) )                 $email                   = $_POST['email'];
	if ( !empty($_POST['Nombre']) )                $Nombre 	                = $_POST['Nombre'];
	if ( !empty($_POST['RazonSocial']) )           $RazonSocial 	        = $_POST['RazonSocial'];
	if ( !empty($_POST['Rut']) )                   $Rut 	                = $_POST['Rut'];
	if ( !empty($_POST['fNacimiento']) )           $fNacimiento 	        = $_POST['fNacimiento'];
	if ( !empty($_POST['Direccion']) )             $Direccion 	            = strtolower($_POST['Direccion']);
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
	if ( !empty($_POST['idCompartir']) )           $idCompartir             = $_POST['idCompartir'];
	if ( !empty($_POST['GeoLatitud']) )            $GeoLatitud              = $_POST['GeoLatitud'];
	if ( !empty($_POST['GeoLongitud']) )           $GeoLongitud             = $_POST['GeoLongitud'];
	if ( !empty($_POST['idNuevo']) )               $idNuevo                 = $_POST['idNuevo'];
	if ( !empty($_POST['idVerificado']) )          $idVerificado            = $_POST['idVerificado'];
	
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
			case 'idCliente':              if(empty($idCliente)){                             $error['idCliente']               = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){                             $error['idSistema']               = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':               if(empty($idEstado)){                              $error['idEstado']                = 'error/No ha seleccionado el Estado';}break;
			case 'idTipo':                 if(empty($idTipo)){                                $error['idTipo']                  = 'error/No ha seleccionado el tipo de cliente';}break;
			case 'idRubro':                if(empty($idRubro)){                               $error['idRubro']                 = 'error/No ha seleccionado el rubro';}break;
			case 'email':                  if(empty($email)){                                 $error['email']                   = 'error/No ha ingresado el email';}break;
			case 'Nombre':                 if(empty($Nombre)){                                $error['Nombre']                  = 'error/No ha ingresado el Nombre de Fantasia';}break;
			case 'RazonSocial':            if(empty($RazonSocial)){                           $error['RazonSocial']             = 'error/No ha ingresado la Razon Social';}break;
			case 'Rut':                    if(empty($Rut)&&$form_trabajo!='getpass'){         $error['Rut']                     = 'error/No ha ingresado el Rut';}break;	
			case 'fNacimiento':            if(empty($fNacimiento)){                           $error['fNacimiento']             = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Direccion':              if(empty($Direccion)){                             $error['Direccion']               = 'error/No ha ingresado la direccion';}break;
			case 'Fono1':                  if(empty($Fono1)){                                 $error['Fono1']                   = 'error/No ha ingresado el telefono';}break;
			case 'Fono2':                  if(empty($Fono2)){                                 $error['Fono2']                   = 'error/No ha ingresado el telefono';}break;
			case 'idCiudad':               if(empty($idCiudad)){                              $error['idCiudad']                = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':               if(empty($idComuna)){                              $error['idComuna']                = 'error/No ha seleccionado la comuna';}break;
			case 'Fax':                    if(empty($Fax)){                                   $error['Fax']                     = 'error/No ha ingresado el fax';}break;
			case 'PersonaContacto':        if(empty($PersonaContacto)){                       $error['PersonaContacto']         = 'error/No ha ingresado el nombre de la persona de contacto';}break;
			case 'PersonaContacto_Fono':   if(empty($PersonaContacto_Fono)){                  $error['PersonaContacto_Fono']    = 'error/No ha ingresado el Fono de la persona de contacto';}break;
			case 'PersonaContacto_email':  if(empty($PersonaContacto_email)){                 $error['PersonaContacto_email']   = 'error/No ha ingresado el Email de la persona de contacto';}break;
			case 'Web':                    if(empty($Web)){                                   $error['Web']                     = 'error/No ha ingresado la pagina web';}break;
			case 'Giro':                   if(empty($Giro)){                                  $error['Giro']                    = 'error/No ha ingresado el Giro de la empresa';}break;
			case 'password':               if(empty($password)&&$form_trabajo!='getpass'){    $error['password']                = 'error/No ha ingresado el password';}break;
			case 'idCompartir':            if(empty($idCompartir)){                           $error['idCompartir']             = 'error/No ha seleccionado la opcion de compartir datos personales';}break;
			case 'GeoLatitud':             if(empty($GeoLatitud)){                            $error['GeoLatitud']              = 'error/No ha ingresado la Latitud';}break;
			case 'GeoLongitud':            if(empty($GeoLongitud)){                           $error['GeoLongitud']             = 'error/No ha ingresado la Longitud';}break;
			case 'idNuevo':                if(empty($idNuevo)){                               $error['idNuevo']                 = 'error/No ha seleccionado si es nuevo';}break;
			case 'idVerificado':           if(empty($idVerificado)){                          $error['idVerificado']            = 'error/No ha seleccionado la verificacion';}break;
			
			case 'repassword':             if(empty($repassword)){                            $error['repassword']              = 'error/No ha ingresado la repeticion del password';}break;
			case 'oldpassword':            if(empty($oldpassword)){                           $error['oldpassword']             = 'error/No ha ingresado el password antiguo';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){                                 $error['email']                  = 'error/El Email ingresado no es valido'; }	
	if(isset($Fono1)&&!validarNumero($Fono1)) {                               $error['Fono1']                  = 'error/Ingrese un numero telefonico valido'; }
	if(isset($Fono2)&&!validarNumero($Fono2)) {                               $error['Fono2']                  = 'error/Ingrese un numero telefonico valido'; }
	if(isset($Rut)&&!validarRut($Rut)){                                       $error['Rut']                    = 'error/El Rut ingresado no es valido'; }
	if(isset($PersonaContacto_email)&&!validarEmail($PersonaContacto_email)){ $error['email']                  = 'error/El Email ingresado no es valido'; }
	if(isset($PersonaContacto_Fono)&&!validarNumero($PersonaContacto_Fono)) { $error['PersonaContacto_Fono']   = 'error/Ingrese un numero telefonico valido'; }
	if(isset($password)&&isset($repassword)){
		if ( $password <> $repassword )                  $error['password']  = 'error/Las contraseñas ingresadas no coinciden'; 
	}
	if(isset($password)){
		if (strpos($password, " ")){                     $error['Password1'] = 'error/La contraseña contiene espacios vacios';}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
if(isset($email)&&contar_palabras_censuradas($email)!=0){                                 $error['email']                  = 'error/Edita el email, contiene palabras no permitidas'; }	
if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                               $error['Nombre']                 = 'error/Edita el nombre, contiene palabras no permitidas'; }	
if(isset($RazonSocial)&&contar_palabras_censuradas($RazonSocial)!=0){                     $error['RazonSocial']            = 'error/Edita la razonSocial, contiene palabras no permitidas'; }	
if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){                         $error['Direccion']              = 'error/Edita la direccion, contiene palabras no permitidas'; }	
if(isset($Fono1)&&contar_palabras_censuradas($Fono1)!=0){                                 $error['Fono1']                  = 'error/Edita el fono1, contiene palabras no permitidas'; }	
if(isset($Fono2)&&contar_palabras_censuradas($Fono2)!=0){                                 $error['Fono2']                  = 'error/Edita el fono2, contiene palabras no permitidas'; }	
if(isset($Fax)&&contar_palabras_censuradas($Fax)!=0){                                     $error['Fax']                    = 'error/Edita el fax, contiene palabras no permitidas'; }	
if(isset($PersonaContacto)&&contar_palabras_censuradas($PersonaContacto)!=0){             $error['PersonaContacto']        = 'error/Edita la persona de contacto, contiene palabras no permitidas'; }	
if(isset($PersonaContacto_Fono)&&contar_palabras_censuradas($PersonaContacto_Fono)!=0){   $error['PersonaContacto_Fono']   = 'error/Edita el fono de persona de contacto, contiene palabras no permitidas'; }	
if(isset($PersonaContacto_email)&&contar_palabras_censuradas($PersonaContacto_email)!=0){ $error['PersonaContacto_email']  = 'error/Edita el email de persona de contacto, contiene palabras no permitidas'; }	
if(isset($Web)&&contar_palabras_censuradas($Web)!=0){                                     $error['Web']                    = 'error/Edita la web, contiene palabras no permitidas'; }	
if(isset($Giro)&&contar_palabras_censuradas($Giro)!=0){                                   $error['Giro']                   = 'error/Edita el giro, contiene palabras no permitidas'; }	
	
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
				$ndata_1 = db_select_nrows (false, 'Nombre', 'seg_vecinal_clientes_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'seg_vecinal_clientes_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)){
				$ndata_3 = db_select_nrows (false, 'email', 'seg_vecinal_clientes_listado', '', "email='".$email."' AND idSistema='".$idSistema."'", $dbConn, 'Login-form', $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {$error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			/*******************************************************************/
			//Consulto la latitud y la longitud
			if(isset($idCiudad) && $idCiudad != ''&&isset($idComuna) && $idComuna != ''&&isset($Direccion) && $Direccion != ''){
				
				//verifico si existe la direccion ingresada
				$rowdata = db_select_data (false, 'GeoLatitud,GeoLongitud', 'seg_vecinal_clientes_listado', '', 'idCiudad = "'.$idCiudad.'" AND idComuna = "'.$idComuna.'" AND Direccion = "'.$Direccion.'" AND idNuevo!=0', $dbConn, 'Login-form', $original, $form_trabajo);
				
				//si existe la direccion se reutiliza los datos	
				if(isset($rowdata['GeoLatitud'])&&isset($rowdata['GeoLongitud'])&&$rowdata['GeoLatitud']!=''&&$rowdata['GeoLongitud']!=''){
					$GeoLatitud  = $rowdata['GeoLatitud'];
					$GeoLongitud = $rowdata['GeoLongitud'];
				//se buscan en base de la direccion entregada
				}else{
					//Variable con el ID de google
					$Config_IDGoogle = 'AIzaSyDWT32ltFroDfzooD8ubj_NeqbZNA5LFz0';
					//variable con la direccion
					$address = '';
					if(isset($idCiudad) && $idCiudad != ''){
						$rowdata = db_select_data (false, 'Nombre', 'core_ubicacion_ciudad', '', 'idCiudad = "'.$idCiudad.'"', $dbConn, 'Login-form', $original, $form_trabajo);
						$address .= $rowdata['Nombre'].', ';
					}
					if(isset($idComuna) && $idComuna != ''){
						$rowdata = db_select_data (false, 'Nombre', 'core_ubicacion_comunas', '', 'idComuna = "'.$idComuna.'"', $dbConn, 'Login-form', $original, $form_trabajo);
						$address .= $rowdata['Nombre'].', ';
					}
					if(isset($Direccion) && $Direccion != ''){
						$address .= $Direccion;
					}
					if($address!=''){
						$geocodeData = getGeocodeData($address, $Config_IDGoogle);
						if($geocodeData) {         
							$GeoLatitud  = $geocodeData[0];
							$GeoLongitud = $geocodeData[1];
						} else {
							$error['ndata_4'] = 'error/Detalles de la direccion incorrectos!';
						}
					}else{
						$error['ndata_4'] = 'error/Sin direccion ingresada';
					}
				}
			}else{
				$error['ndata_4'] = 'error/Sin direccion ingresada';
			}
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
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
				if(isset($idCompartir) && $idCompartir != ''){                       $a .= ",'".$idCompartir."'" ;            }else{$a .= ",''";}
				if(isset($GeoLatitud) && $GeoLatitud != ''){                         $a .= ",'".$GeoLatitud."'" ;             }else{$a .= ",''";}
				if(isset($GeoLongitud) && $GeoLongitud != ''){                       $a .= ",'".$GeoLongitud."'" ;            }else{$a .= ",''";}
				if(isset($idNuevo) && $idNuevo != ''){                               $a .= ",'".$idNuevo."'" ;                }else{$a .= ",''";}
				if(isset($idVerificado) && $idVerificado != ''){                     $a .= ",'".$idVerificado."'" ;           }else{$a .= ",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `seg_vecinal_clientes_listado` (idSistema, idEstado, idTipo, idRubro, email, Nombre,
				RazonSocial, Rut, fNacimiento, Direccion, Fono1, Fono2, idCiudad, idComuna, Fax, PersonaContacto,
				PersonaContacto_Fono, PersonaContacto_email, Web, Giro, password, idCompartir, GeoLatitud, GeoLongitud,
				idNuevo, idVerificado) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if($resultado){
					
					/******************************************************************/
					//traigo los datos almacenados
					$rowusr = db_select_data (false, 'Nombre, email_principal, core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, core_sistemas.Config_Gmail_Password AS Gmail_Password', 'core_sistemas', '', 'idSistema=1', $dbConn, 'Login-form', $original, $form_trabajo);
					
					//Envio de correo
					$texto  = '<p>Estimado(a) '.$Nombre.'</p>'; 
					$texto .= '<p><strong>¡Te damos la bienvenida a '.DB_EMPRESA_NAME.'!</strong></p>'; 
					$texto .= '<p>Desde este momento podrás utilizar nuestra plataforma de seguridad, desde donde podras comunicarte con tus vecinos, compartir eventos y ver las inseguridades.</p>'; 
					$texto .= '<p>Te recordamos tu acceso a la plataforma ('.DB_SITE_MAIN.'):</p>'; 
					$texto .= '<ul>';
					$texto .= '<li><strong>Usuario: '.$Rut.'</strong></li>';
					$texto .= '<li><strong>Contraseña: '.$password.'</strong></li>';
					$texto .= '</ul>';
					$texto .= '<p>Puedes cambiar tu contraseña <a href="'.DB_SITE_MAIN.'/principal_datos_password.php" target="_blank" rel="noopener noreferrer" >aqui</a>, o “mis datos”>”ver más”>”Password”</p>'; 
					$texto .= '<p>Si tienes consultas respecto al servicio, no dudes en comunicarte con nosotros al correo <a href="mailto:contacto@vecinoseguro.cl" target="_blank">contacto@vecinoseguro.cl</a>.</p>'; 
					$texto .= '<p>Un cordial saludo</p>'; 
					$texto .= '<p>Equipo de '.DB_EMPRESA_NAME.'</p>';
					
					//Se agrega el header
					$BodyMail  = '<img src="'.DB_SITE_MAIN.'/img/mail_header_logo.jpg" class="CToWUd a6T" tabindex="0" width="800">';
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
						$error['email'] 	  = 'error/Mail error:'.$rmail;
					}else{
						header( 'Location: '.$location.'?created=true' );
						die;
					}
					
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
			$ndata_3 = 0;
			$ndata_4 = 1;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($idSistema)&&isset($idCliente)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'seg_vecinal_clientes_listado', '', "Nombre='".$Nombre."' AND idSistema='".$idSistema."' AND idCliente!='".$idCliente."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idCliente)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'seg_vecinal_clientes_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idCliente!='".$idCliente."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($email)&&isset($idSistema)&&isset($idCliente)){
				$ndata_3 = db_select_nrows (false, 'email', 'seg_vecinal_clientes_listado', '', "email='".$email."' AND idSistema='".$idSistema."' AND idCliente!='".$idCliente."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($oldpassword)&&isset($idCliente)){
				$ndata_4 = db_select_nrows (false, 'password', 'seg_vecinal_clientes_listado', '', "idCliente='".$idCliente."' AND password='".md5($oldpassword)."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {  $error['ndata_1'] = 'error/El nombre de la persona ya existe en el sistema';}
			if($ndata_2 > 0) {  $error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			if($ndata_3 > 0) {  $error['ndata_3'] = 'error/El correo de ingresado ya existe en el sistema';}
			if($ndata_4 == 0) { $error['ndata_4'] = 'error/Las contraseñas ingresadas no coinciden';}
			/*******************************************************************/
			//Consulto la latitud y la longitud
			if(isset($idCiudad) && $idCiudad != ''&&isset($idComuna) && $idComuna != ''&&isset($Direccion) && $Direccion != ''){
				
				//verifico si existe la direccion ingresada
				$rowdata = db_select_data (false, 'GeoLatitud,GeoLongitud', 'seg_vecinal_clientes_listado', '', 'idCiudad = "'.$idCiudad.'" AND idComuna = "'.$idComuna.'" AND Direccion = "'.$Direccion.'" AND idNuevo!=0', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				//si existe la direccion se reutiliza los datos	
				if(isset($rowdata['GeoLatitud'])&&isset($rowdata['GeoLongitud'])&&$rowdata['GeoLatitud']!=''&&$rowdata['GeoLongitud']!=''){
					$GeoLatitud  = $rowdata['GeoLatitud'];
					$GeoLongitud = $rowdata['GeoLongitud'];
				//se buscan en base de la direccion entregada
				}else{
					//variable con la direccion
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
							$error['ndata_4'] = 'error/Detalles de la direccion incorrectos!';
						}
					}else{
						$error['ndata_4'] = 'error/Sin direccion ingresada';
					}
				}
			}
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idCliente='".$idCliente."'" ;
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
				if(isset($idCompartir) && $idCompartir!= ''){                        $a .= ",idCompartir='".$idCompartir."'" ;}
				if(isset($GeoLatitud) && $GeoLatitud!= ''){                          $a .= ",GeoLatitud='".$GeoLatitud."'" ;}
				if(isset($GeoLongitud) && $GeoLongitud!= ''){                        $a .= ",GeoLongitud='".$GeoLongitud."'" ;}
				if(isset($idNuevo) && $idNuevo!= ''){                                $a .= ",idNuevo='".$idNuevo."'" ;}
				if(isset($idVerificado) && $idVerificado!= ''){                      $a .= ",idVerificado='".$idVerificado."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'seg_vecinal_clientes_listado', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					
					/**********************************************************************/
					//Datos propios
					//si confirma ubicacion o deja de ser nuevo
					if(isset($idNuevo) && $idNuevo!= '' && $idNuevo!= 0){ $_SESSION['usuario']['basic_data']['idNuevo']     = $idNuevo;}
					if(isset($Nombre) && $Nombre != ''){                  $_SESSION['usuario']['basic_data']['Nombre']      = $Nombre;}
					if(isset($Rut) && $Rut != ''){                        $_SESSION['usuario']['basic_data']['Rut']         = $Rut;}
					if(isset($RazonSocial) && $RazonSocial != ''){        $_SESSION['usuario']['basic_data']['RazonSocial'] = $RazonSocial;}
					
					/**********************************************************************/
					//Datos de la variable vecino
					if(isset($idTipo) && $idTipo!= ''){                                $_SESSION['vecinos'][$idCliente]['idTipo']                 = $idTipo;}
					if(isset($idCompartir) && $idCompartir!= ''){                      $_SESSION['vecinos'][$idCliente]['idCompartir']            = $idCompartir;}
					if(isset($Nombre) && $Nombre!= ''){                                $_SESSION['vecinos'][$idCliente]['Nombre']                 = $Nombre;}
					if(isset($RazonSocial) && $RazonSocial!= ''){                      $_SESSION['vecinos'][$idCliente]['RazonSocial']            = $RazonSocial;}
					if(isset($email) && $email!= ''){                                  $_SESSION['vecinos'][$idCliente]['email']                  = $email;}
					if(isset($Direccion) && $Direccion!= ''){                          $_SESSION['vecinos'][$idCliente]['Direccion']              = $Direccion;}
					if(isset($Fono1) && $Fono1!= ''){                                  $_SESSION['vecinos'][$idCliente]['Fono1']                  = $Fono1;}
					if(isset($Fono2) && $Fono2!= ''){                                  $_SESSION['vecinos'][$idCliente]['Fono2']                  = $Fono2;}
					if(isset($Fax) && $Fax!= ''){                                      $_SESSION['vecinos'][$idCliente]['Fax']                    = $Fax;}
					if(isset($PersonaContacto) && $PersonaContacto!= ''){              $_SESSION['vecinos'][$idCliente]['PersonaContacto']        = $PersonaContacto;}
					if(isset($PersonaContacto_Fono) && $PersonaContacto_Fono!= ''){    $_SESSION['vecinos'][$idCliente]['PersonaContacto_Fono']   = $PersonaContacto_Fono;}
					if(isset($PersonaContacto_email) && $PersonaContacto_email!= ''){  $_SESSION['vecinos'][$idCliente]['PersonaContacto_email']  = $PersonaContacto_email;}
					if(isset($GeoLatitud) && $GeoLatitud!= ''){                        $_SESSION['vecinos'][$idCliente]['GeoLatitud']             = $GeoLatitud;}
					if(isset($GeoLongitud) && $GeoLongitud!= ''){                      $_SESSION['vecinos'][$idCliente]['GeoLongitud']            = $GeoLongitud;}
						
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
		case 'confirm':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//cliente
				$idCliente = $_SESSION['usuario']['basic_data']['idCliente'];
				
				//Filtros
				$a = "idCliente='".$idCliente."'" ;
				$a .= ",idNuevo='1'" ;
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'seg_vecinal_clientes_listado', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					
					//si confirma ubicacion o deja de ser nuevo
					$_SESSION['usuario']['basic_data']['idNuevo'] = 1;
					
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
		case 'login': 
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Elimino cualquier dato de un usuario anterior
			unset($_SESSION['usuario']);
			unset($_SESSION['vecinos']);
			unset($_SESSION['vecinos_filter']);
			unset($_SESSION['vecinos_camaras']);
			unset($_SESSION['vecinos_camaras_list']);
			unset($_SESSION['vecinos_eventos']);
			unset($_SESSION['vecinos_eventos_archivos']);
			unset($_SESSION['servicios']);
			unset($_SESSION['vecinos_peligros']);
			unset($_SESSION['vecinos_peligros_archivos']);
			unset($_SESSION['canales']);
			unset($_SESSION['actualizaciones']);
			unset($_SESSION['infracciones']);
			unset($_SESSION['sitios']);
			
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
			if (checkbrute($Rut, $email, $IP_Client, 'seg_vecinal_clientes_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, usuario bloqueado por 2 horas'; 
			}
			
			//si no hay errores
			if ( empty($error) ) {
						
				//Busco al usuario en el sistema
				$SIS_query = '
				seg_vecinal_clientes_listado.idCliente, 
				seg_vecinal_clientes_listado.idCliente AS ID, 
				seg_vecinal_clientes_listado.password, 
				seg_vecinal_clientes_listado.Rut, 
				seg_vecinal_clientes_listado.Nombre, 
				seg_vecinal_clientes_listado.idEstado, 
				seg_vecinal_clientes_listado.RazonSocial,
				seg_vecinal_clientes_listado.GeoLatitud,
				seg_vecinal_clientes_listado.GeoLongitud,
				seg_vecinal_clientes_listado.idNuevo,
				seg_vecinal_clientes_listado.Direccion_img,
				seg_vecinal_clientes_listado.idSistema,
				seg_vecinal_clientes_listado.Direccion,
				core_sistemas.Config_idTheme,
				core_sistemas.Config_imgLogo,
				core_sistemas.Config_IDGoogle,
				core_ubicacion_ciudad.Nombre AS nombre_region,
				core_ubicacion_ciudad.Wheater AS nombre_pronostico,
				core_ubicacion_comunas.Nombre AS nombre_comuna,
				(SELECT COUNT(idCliente) FROM `seg_vecinal_camaras_listado`  WHERE idCliente=ID ) AS TotalCamaras,
				(SELECT COUNT(idCliente) FROM `seg_vecinal_eventos_listado`  WHERE idCliente=ID ) AS TotalEventos,
				(SELECT COUNT(idCliente) FROM `seg_vecinal_peligros_listado` WHERE idCliente=ID ) AS TotalPeligros';
				$SIS_join = '
				LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema          = seg_vecinal_clientes_listado.idSistema
				LEFT JOIN `core_ubicacion_ciudad`     ON core_ubicacion_ciudad.idCiudad   = seg_vecinal_clientes_listado.idCiudad
				LEFT JOIN `core_ubicacion_comunas`    ON core_ubicacion_comunas.idComuna  = seg_vecinal_clientes_listado.idComuna';
				$SIS_where = 'seg_vecinal_clientes_listado.Rut = "'.$Rut.'" AND seg_vecinal_clientes_listado.password = "'.md5($password).'"';
				$rowUser = db_select_data (false, $SIS_query, 'seg_vecinal_clientes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);


				//Se verifca si los datos ingresados son de un usuario
				if (isset($rowUser['idCliente'])&&$rowUser['idCliente']!='') {
					
					//Verifico que el usuario identificado este activo
					if($rowUser['idEstado']==1){
						
						/***************************************************************/
						//Actualizo la tabla de los usuarios
						$a = 'Ultimo_acceso="'.$fecha.'", IP_Client="'.$IP_Client.'", Agent_Transp="'.$Agent_Transp.'"';
						$resultado = db_update_data (false, $a, 'seg_vecinal_clientes_listado', 'idCliente = "'.$rowUser['idCliente'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						//busca si la ip del usuario ya existe
						$n_ip = db_select_nrows (false, 'idIpUsuario', 'seg_vecinal_clientes_listado_ip', '', "IP_Client='".$IP_Client."' AND idCliente='".$rowUser['idCliente']."'", $dbConn, 'Login-form', $original, $form_trabajo);
						//si la ip no existe la guarda
						if(isset($n_ip)&&$n_ip==0){
							$query  = "INSERT INTO `seg_vecinal_clientes_listado_ip` (idCliente,IP_Client, Fecha, Hora) VALUES (".$rowUser['idCliente'].",'".$IP_Client."','".$fecha."','".$hora."' )";
							$resultado = mysqli_query($dbConn, $query);
						}
						
						/**************************************************************/
						//Inserto la fecha con el ingreso
						if(isset($rowUser['idCliente']) && $rowUser['idCliente'] != ''){  $a  = "'".$rowUser['idCliente']."'" ;  }else{$a  = "''";}
						if(isset($fecha) && $fecha != ''){                                $a .= ",'".$fecha."'" ;                }else{$a .= ",''";}
						if(isset($hora) && $hora != ''){                                  $a .= ",'".$hora."'" ;                 }else{$a .= ",''";}
						if(isset($IP_Client) && $IP_Client != ''){                        $a .= ",'".$IP_Client."'" ;            }else{$a .= ",''";}
						if(isset($Agent_Transp) && $Agent_Transp != ''){                  $a .= ",'".$Agent_Transp."'" ;         }else{$a .= ",''";}
										
						// inserto los datos de registro en la db
						$query  = "INSERT INTO `seg_vecinal_clientes_accesos` (idCliente,Fecha, Hora, IP_Client, Agent_Transp) 
						VALUES (".$a.")";
						//Consulta
						$resultado = mysqli_query ($dbConn, $query);
						
					
						//Se crean las variables con todos los datos
						$_SESSION['usuario']['basic_data']['idCliente']          = $rowUser['idCliente'];
						$_SESSION['usuario']['basic_data']['password']           = $rowUser['password'];
						$_SESSION['usuario']['basic_data']['Nombre']             = $rowUser['Nombre'];
						$_SESSION['usuario']['basic_data']['Rut']                = $rowUser['Rut'];
						$_SESSION['usuario']['basic_data']['idEstado']           = $rowUser['idEstado'];
						$_SESSION['usuario']['basic_data']['RazonSocial']        = $rowUser['RazonSocial'];
						$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowUser['Config_idTheme'];
						$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowUser['Config_imgLogo'];
						$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowUser['Config_IDGoogle'];
						$_SESSION['usuario']['basic_data']['idNuevo']            = $rowUser['idNuevo'];
						$_SESSION['usuario']['basic_data']['Direccion_img']      = $rowUser['Direccion_img'];
						$_SESSION['usuario']['basic_data']['idSistema']          = $rowUser['idSistema'];
						$_SESSION['usuario']['basic_data']['GeoLatitud']         = $rowUser['GeoLatitud'];
						$_SESSION['usuario']['basic_data']['GeoLongitud']        = $rowUser['GeoLongitud'];
						$_SESSION['usuario']['basic_data']['TotalCamaras']       = $rowUser['TotalCamaras'];
						$_SESSION['usuario']['basic_data']['TotalEventos']       = $rowUser['TotalEventos'];
						$_SESSION['usuario']['basic_data']['TotalPeligros']      = $rowUser['TotalPeligros'];
						$_SESSION['usuario']['basic_data']['TotalNegocios']      = 0;
						$_SESSION['usuario']['basic_data']['TotalOfertas']       = 0;
						$_SESSION['usuario']['basic_data']['Region']             = $rowUser['nombre_region'];
						$_SESSION['usuario']['basic_data']['Pronostico']         = $rowUser['nombre_pronostico'];
						$_SESSION['usuario']['basic_data']['Comuna']             = $rowUser['nombre_comuna'];
						$_SESSION['usuario']['basic_data']['Direccion']          = $rowUser['Direccion'];
						
				
						/***************************************************************/
						//Se definen las variables de tiempo
						$SemanaAnterior  = restarDias(fecha_actual(),7);
						
						//Busco los datos cerca del usuario
						$var_kil         = 0.00450004500045;   //equivalente de un kilometro en latitud
						
						//calculo de la posicion de los vecinos
						$var_radio             = 500;   //radio de revision (metros)
						$vec_latitud_up        = $rowUser['GeoLatitud']-($var_kil*($var_radio/1000));
						$vec_latitud_down      = $rowUser['GeoLatitud']+($var_kil*($var_radio/1000));
						$vec_longitud_up       = $rowUser['GeoLongitud']-($var_kil*($var_radio/1000));
						$vec_longitud_down     = $rowUser['GeoLongitud']+($var_kil*($var_radio/1000));
						
						//calculo de la posicion de los eventos
						$var_radio             = 5000;   //radio de revision (metros)
						$event_latitud_up      = $rowUser['GeoLatitud']-($var_kil*($var_radio/1000));
						$event_latitud_down    = $rowUser['GeoLatitud']+($var_kil*($var_radio/1000));
						$event_longitud_up     = $rowUser['GeoLongitud']-($var_kil*($var_radio/1000));
						$event_longitud_down   = $rowUser['GeoLongitud']+($var_kil*($var_radio/1000));
						
						//calculo de la posicion de los servicios
						$var_radio             = 5000;   //radio de revision (metros)
						$serv_latitud_up       = $rowUser['GeoLatitud']-($var_kil*($var_radio/1000));
						$serv_latitud_down     = $rowUser['GeoLatitud']+($var_kil*($var_radio/1000));
						$serv_longitud_up      = $rowUser['GeoLongitud']-($var_kil*($var_radio/1000));
						$serv_longitud_down    = $rowUser['GeoLongitud']+($var_kil*($var_radio/1000));
						
						//calculo de la posicion de las zonas peligrosas
						$var_radio             = 5000;   //radio de revision (metros)
						$pel_latitud_up        = $rowUser['GeoLatitud']-($var_kil*($var_radio/1000));
						$pel_latitud_down      = $rowUser['GeoLatitud']+($var_kil*($var_radio/1000));
						$pel_longitud_up       = $rowUser['GeoLongitud']-($var_kil*($var_radio/1000));
						$pel_longitud_down     = $rowUser['GeoLongitud']+($var_kil*($var_radio/1000));
						
						/****************************************************************/
						//consulto
						$SIS_query = '
						seg_vecinal_clientes_listado.idCliente,
						seg_vecinal_clientes_listado.idTipo,
						seg_vecinal_clientes_listado.idCompartir,					
						seg_vecinal_clientes_listado.Nombre, 
						seg_vecinal_clientes_listado.RazonSocial,
						seg_vecinal_clientes_listado.email,
						seg_vecinal_clientes_listado.Direccion,
						seg_vecinal_clientes_listado.Fono1,
						seg_vecinal_clientes_listado.Fono2,
						seg_vecinal_clientes_listado.Fax,
						seg_vecinal_clientes_listado.PersonaContacto,
						seg_vecinal_clientes_listado.PersonaContacto_Fono,
						seg_vecinal_clientes_listado.PersonaContacto_email,
						seg_vecinal_clientes_listado.Direccion_img,
						seg_vecinal_clientes_listado.GeoLatitud,
						seg_vecinal_clientes_listado.GeoLongitud,
						core_ubicacion_ciudad.Nombre AS Ciudad,
						core_ubicacion_comunas.Nombre AS Comuna';
						$SIS_join  = '
						LEFT JOIN `core_ubicacion_ciudad`   ON core_ubicacion_ciudad.idCiudad   = seg_vecinal_clientes_listado.idCiudad
						LEFT JOIN `core_ubicacion_comunas`  ON core_ubicacion_comunas.idComuna  = seg_vecinal_clientes_listado.idComuna';
						$SIS_where = 'seg_vecinal_clientes_listado.idEstado=1 AND seg_vecinal_clientes_listado.GeoLatitud BETWEEN "'.$vec_latitud_up.'" AND "'.$vec_latitud_down.'" AND seg_vecinal_clientes_listado.GeoLongitud BETWEEN "'.$vec_longitud_up.'" AND "'.$vec_longitud_down.'"';
						$SIS_order = 'seg_vecinal_clientes_listado.idCliente ASC';
						$arrVecinos = array();
						$arrVecinos = db_select_array (false, $SIS_query, 'seg_vecinal_clientes_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							
						/****************************************************************/
						//consulto
						$SIS_query = '
						seg_vecinal_clientes_listado.idCliente,
						seg_vecinal_clientes_listado.Nombre AS VecinoNombre,
						seg_vecinal_clientes_listado.Direccion AS VecinoDireccion,
						seg_vecinal_clientes_listado.GeoLatitud AS VecinoLatitud,
						seg_vecinal_clientes_listado.GeoLongitud AS VecinoLongitud,
						seg_vecinal_camaras_listado.idSubconfiguracion,
						seg_vecinal_camaras_listado.idTipoCamara AS Main_idTipoCamara,
						seg_vecinal_camaras_listado.Config_usuario AS Main_Config_usuario,
						seg_vecinal_camaras_listado.Config_Password AS Main_Config_Password,
						seg_vecinal_camaras_listado.Config_IP AS Main_Config_IP,
						seg_vecinal_camaras_listado.Config_Puerto AS Main_Config_Puerto,
						seg_vecinal_camaras_listado_canales.idCanal,
						seg_vecinal_camaras_listado_canales.idCamara,
						seg_vecinal_camaras_listado_canales.Nombre,
						seg_vecinal_camaras_listado_canales.Chanel,
						seg_vecinal_camaras_listado_canales.idTipoCamara AS Cam_idTipoCamara,
						seg_vecinal_camaras_listado_canales.Config_usuario AS Cam_Config_usuario,
						seg_vecinal_camaras_listado_canales.Config_Password AS Cam_Config_Password,
						seg_vecinal_camaras_listado_canales.Config_IP AS Cam_Config_IP,
						seg_vecinal_camaras_listado_canales.Config_Puerto AS Cam_Config_Puerto';
						$SIS_join  = '
						LEFT JOIN `seg_vecinal_camaras_listado`          ON seg_vecinal_camaras_listado.idCliente         = seg_vecinal_clientes_listado.idCliente
						LEFT JOIN `seg_vecinal_camaras_listado_canales`  ON seg_vecinal_camaras_listado_canales.idCamara  = seg_vecinal_camaras_listado.idCamara';
						$SIS_where = 'seg_vecinal_clientes_listado.idEstado=1 AND seg_vecinal_clientes_listado.GeoLatitud BETWEEN "'.$vec_latitud_up.'" AND "'.$vec_latitud_down.'" AND seg_vecinal_clientes_listado.GeoLongitud BETWEEN "'.$vec_longitud_up.'" AND "'.$vec_longitud_down.'" AND seg_vecinal_camaras_listado_canales.idEstado=1';
						$SIS_order = 'seg_vecinal_clientes_listado.idCliente ASC';
						$arrCamaras = array();
						$arrCamaras = db_select_array (false, $SIS_query, 'seg_vecinal_clientes_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//Eventos
						$SIS_query = '
						seg_vecinal_eventos_listado.idEvento,
						seg_vecinal_eventos_listado.idTipo,
						seg_vecinal_eventos_listado.GeoLatitud,
						seg_vecinal_eventos_listado.GeoLongitud,
						seg_vecinal_eventos_listado.Direccion,
						seg_vecinal_eventos_listado.Fecha,
						seg_vecinal_eventos_listado.Hora,
						seg_vecinal_eventos_listado.DescripcionTipo,
						seg_vecinal_eventos_listado.DescripcionSituacion,
						seg_vecinal_eventos_listado.idValidado,
						seg_vecinal_eventos_tipos.Nombre AS Tipo,
						core_ubicacion_ciudad.Nombre AS Ciudad,
						core_ubicacion_comunas.Nombre AS Comuna';
						$SIS_join  = '
						LEFT JOIN `seg_vecinal_eventos_tipos`     ON seg_vecinal_eventos_tipos.idTipo       = seg_vecinal_eventos_listado.idTipo
						LEFT JOIN `core_ubicacion_ciudad`         ON core_ubicacion_ciudad.idCiudad         = seg_vecinal_eventos_listado.idCiudad
						LEFT JOIN `core_ubicacion_comunas`        ON core_ubicacion_comunas.idComuna        = seg_vecinal_eventos_listado.idComuna
						LEFT JOIN `seg_vecinal_clientes_listado`  ON seg_vecinal_clientes_listado.idCliente = seg_vecinal_eventos_listado.idCliente';
						$SIS_where = 'seg_vecinal_clientes_listado.idEstado=1 AND seg_vecinal_eventos_listado.GeoLatitud BETWEEN "'.$event_latitud_up.'" AND "'.$event_latitud_down.'" AND seg_vecinal_eventos_listado.GeoLongitud BETWEEN "'.$event_longitud_up.'" AND "'.$event_longitud_down.'" AND seg_vecinal_eventos_listado.Fecha>="'.$SemanaAnterior.'"';
						$SIS_order = 'seg_vecinal_eventos_listado.Fecha DESC, seg_vecinal_eventos_listado.Hora DESC';
						$arrEventos = array();
						$arrEventos = db_select_array (false, $SIS_query, 'seg_vecinal_eventos_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//Se traen las rutas
						$SIS_query = 'seg_vecinal_eventos_listado_archivos.idArchivo, seg_vecinal_eventos_listado_archivos.Nombre, seg_vecinal_eventos_listado_archivos.idEvento';
						$SIS_join  = '
						LEFT JOIN `seg_vecinal_eventos_listado`   ON seg_vecinal_eventos_listado.idEvento    = seg_vecinal_eventos_listado_archivos.idEvento
						LEFT JOIN `seg_vecinal_clientes_listado`  ON seg_vecinal_clientes_listado.idCliente  = seg_vecinal_eventos_listado.idCliente';
						$SIS_where = 'seg_vecinal_clientes_listado.idEstado=1
						AND seg_vecinal_eventos_listado.GeoLatitud BETWEEN "'.$event_latitud_up.'" AND "'.$event_latitud_down.'"
						AND seg_vecinal_eventos_listado.GeoLongitud BETWEEN "'.$event_longitud_up.'" AND "'.$event_longitud_down.'"
						AND seg_vecinal_eventos_listado.Fecha>="'.$SemanaAnterior.'"';
						$SIS_order = 'seg_vecinal_eventos_listado_archivos.Nombre ASC';
						$arrEventosArchivos = array();
						$arrEventosArchivos = db_select_array (false, $SIS_query, 'seg_vecinal_eventos_listado_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//peligros
						$SIS_query = '
						seg_vecinal_peligros_listado.idPeligro,
						seg_vecinal_peligros_listado.idTipo,
						seg_vecinal_peligros_listado.GeoLatitud,
						seg_vecinal_peligros_listado.GeoLongitud,
						seg_vecinal_peligros_listado.Direccion,
						seg_vecinal_peligros_listado.Descripcion,
						seg_vecinal_peligros_listado.idValidado,
						seg_vecinal_peligros_tipos.Nombre AS Tipo,
						core_ubicacion_ciudad.Nombre AS Ciudad,
						core_ubicacion_comunas.Nombre AS Comuna';
						$SIS_join  = '
						LEFT JOIN `seg_vecinal_peligros_tipos`    ON seg_vecinal_peligros_tipos.idTipo       = seg_vecinal_peligros_listado.idTipo
						LEFT JOIN `core_ubicacion_ciudad`         ON core_ubicacion_ciudad.idCiudad          = seg_vecinal_peligros_listado.idCiudad
						LEFT JOIN `core_ubicacion_comunas`        ON core_ubicacion_comunas.idComuna         = seg_vecinal_peligros_listado.idComuna
						LEFT JOIN `seg_vecinal_clientes_listado`  ON seg_vecinal_clientes_listado.idCliente  = seg_vecinal_peligros_listado.idCliente';
						$SIS_where = 'seg_vecinal_clientes_listado.idEstado=1 AND seg_vecinal_peligros_listado.GeoLatitud BETWEEN "'.$pel_latitud_up.'" AND "'.$pel_latitud_down.'" AND seg_vecinal_peligros_listado.GeoLongitud BETWEEN "'.$pel_longitud_up.'" AND "'.$pel_longitud_down.'" AND seg_vecinal_peligros_listado.idEstado=1';
						$SIS_order = 'seg_vecinal_peligros_listado.Fecha DESC, seg_vecinal_peligros_listado.Hora DESC';
						$arrPeligros = array();
						$arrPeligros = db_select_array (false, $SIS_query, 'seg_vecinal_peligros_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//Se traen las rutas
						$SIS_query = 'seg_vecinal_peligros_listado_archivos.idArchivo, seg_vecinal_peligros_listado_archivos.Nombre,seg_vecinal_peligros_listado_archivos.idPeligro';
						$SIS_join  = '
						LEFT JOIN `seg_vecinal_peligros_listado`  ON seg_vecinal_peligros_listado.idPeligro  = seg_vecinal_peligros_listado_archivos.idPeligro
						LEFT JOIN `seg_vecinal_clientes_listado`  ON seg_vecinal_clientes_listado.idCliente  = seg_vecinal_peligros_listado.idCliente';
						$SIS_where = 'seg_vecinal_clientes_listado.idEstado=1 AND seg_vecinal_peligros_listado.GeoLatitud BETWEEN "'.$pel_latitud_up.'" AND "'.$pel_latitud_down.'" AND seg_vecinal_peligros_listado.GeoLongitud BETWEEN "'.$pel_longitud_up.'" AND "'.$pel_longitud_down.'" AND seg_vecinal_peligros_listado.idEstado=1';
						$SIS_order = 'seg_vecinal_peligros_listado_archivos.Nombre ASC';
						$arrPeligrosArchivos = array();
						$arrPeligrosArchivos = db_select_array (false, $SIS_query, 'seg_vecinal_peligros_listado_archivos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//servicios
						$SIS_query = '
						seg_vecinal_servicios_listado.idServicio, 
						seg_vecinal_servicios_listado.Nombre,
						seg_vecinal_servicios_listado.Fono1,
						seg_vecinal_servicios_listado.Fono2,
						seg_vecinal_servicios_listado.Direccion,
						seg_vecinal_servicios_listado.email,
						seg_vecinal_servicios_listado.Fax,
						seg_vecinal_servicios_listado.Web,
						seg_vecinal_servicios_listado.HoraInicio,
						seg_vecinal_servicios_listado.HoraTermino,
						seg_vecinal_servicios_listado.GeoLatitud,
						seg_vecinal_servicios_listado.GeoLongitud,
						seg_vecinal_servicios_listado.idTipo,
						seg_vecinal_clientes_tipos.Nombre AS Tipo,
						core_ubicacion_ciudad.Nombre AS Ciudad,
						core_ubicacion_comunas.Nombre AS Comuna';
						$SIS_join  = '
						LEFT JOIN `seg_vecinal_clientes_tipos`   ON seg_vecinal_clientes_tipos.idTipo        = seg_vecinal_servicios_listado.idTipo
						LEFT JOIN `core_ubicacion_ciudad`        ON core_ubicacion_ciudad.idCiudad           = seg_vecinal_servicios_listado.idCiudad
						LEFT JOIN `core_ubicacion_comunas`       ON core_ubicacion_comunas.idComuna          = seg_vecinal_servicios_listado.idComuna';
						$SIS_where = 'seg_vecinal_servicios_listado.idServicio!=0 AND seg_vecinal_servicios_listado.GeoLatitud BETWEEN "'.$serv_latitud_up.'" AND "'.$serv_latitud_down.'" AND seg_vecinal_servicios_listado.GeoLongitud BETWEEN "'.$serv_longitud_up.'" AND "'.$serv_longitud_down.'"';
						$SIS_order = 0;
						$arrServicios = array();
						$arrServicios = db_select_array (false, $SIS_query, 'seg_vecinal_servicios_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//Canales de Youtube
						$SIS_query = 'seg_vecinal_canales_listado.Nombre AS CanalNombre,seg_vecinal_canales_listado.Direccion AS CanalDireccion,seg_vecinal_canales_listado.Channel_ID AS CanalChannel_ID,seg_vecinal_canales_categorias.Nombre AS CategoriaNombre';
						$SIS_join  = 'LEFT JOIN `seg_vecinal_canales_categorias` ON seg_vecinal_canales_categorias.idCategoria = seg_vecinal_canales_listado.idCategoria';
						$SIS_where = '';
						$SIS_order = 'seg_vecinal_canales_categorias.Nombre ASC, seg_vecinal_canales_listado.Nombre ASC';
						$arrCanales = array();
						$arrCanales = db_select_array (false, $SIS_query, 'seg_vecinal_canales_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//Actualizaciones de la plataforma
						$SIS_query = 'Fecha, Descripcion';
						$SIS_join  = '';
						$SIS_where = '';
						$SIS_order = 'Fecha ASC LIMIT 10';
						$arrActualizaciones = array();
						$arrActualizaciones = db_select_array (false, $SIS_query, 'seg_vecinal_actualizaciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//Infracciones cometidas por los usuarios
						$SIS_query = 'Fecha, Descripcion';
						$SIS_join  = '';
						$SIS_where = 'idCliente = '.$rowUser['idCliente'];
						$SIS_order = 'Fecha DESC LIMIT 10';
						$arrInfracciones = array();
						$arrInfracciones = db_select_array (false, $SIS_query, 'seg_vecinal_clientes_infracciones', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/*********************************/
						//Infracciones cometidas por los usuarios
						$SIS_query = 'Nombre, Direccion';
						$SIS_join  = '';
						$SIS_where = '';
						$SIS_order = 'Nombre ASC';
						$arrSitios = array();
						$arrSitios = db_select_array (false, $SIS_query, 'seg_vecinal_sitios_listado', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						
						/***************************************************************************************************/
						/***************************************************************************************************/
						/***************************************************************************************************/
						//elimino posibles datos
						unset($_SESSION['vecinos']);
						unset($_SESSION['vecinos_filter']);
						unset($_SESSION['vecinos_camaras']);
						unset($_SESSION['vecinos_camaras_list']);
						unset($_SESSION['vecinos_eventos']);
						unset($_SESSION['vecinos_eventos_archivos']);
						unset($_SESSION['servicios']);
						unset($_SESSION['vecinos_peligros']);
						unset($_SESSION['vecinos_peligros_archivos']);
						unset($_SESSION['canales']);
						unset($_SESSION['actualizaciones']);
						unset($_SESSION['infracciones']);
						unset($_SESSION['sitios']);
						
						/****************************************************************/
						//recorro resultados
						$total_vecinos = 0;
						foreach ($arrVecinos as $vecino) {
							if(isset($vecino['idCliente'])){               $_SESSION['vecinos'][$vecino['idCliente']]['idCliente']               = $vecino['idCliente'];                  }else{$_SESSION['vecinos'][$vecino['idCliente']]['idCliente']               = '';}
							if(isset($vecino['idTipo'])){                  $_SESSION['vecinos'][$vecino['idCliente']]['idTipo']                  = $vecino['idTipo'];                     }else{$_SESSION['vecinos'][$vecino['idCliente']]['idTipo']                  = '';}
							if(isset($vecino['idCompartir'])){             $_SESSION['vecinos'][$vecino['idCliente']]['idCompartir']             = $vecino['idCompartir'];                }else{$_SESSION['vecinos'][$vecino['idCliente']]['idCompartir']             = '';}
							if(isset($vecino['Nombre'])){                  $_SESSION['vecinos'][$vecino['idCliente']]['Nombre']                  = $vecino['Nombre'];                     }else{$_SESSION['vecinos'][$vecino['idCliente']]['Nombre']                  = '';}
							if(isset($vecino['RazonSocial'])){             $_SESSION['vecinos'][$vecino['idCliente']]['RazonSocial']             = $vecino['RazonSocial'];                }else{$_SESSION['vecinos'][$vecino['idCliente']]['RazonSocial']             = '';}
							if(isset($vecino['email'])){                   $_SESSION['vecinos'][$vecino['idCliente']]['email']                   = $vecino['email'];                      }else{$_SESSION['vecinos'][$vecino['idCliente']]['email']                   = '';}
							if(isset($vecino['Ciudad'])){                  $_SESSION['vecinos'][$vecino['idCliente']]['Ciudad']                  = $vecino['Ciudad'];                     }else{$_SESSION['vecinos'][$vecino['idCliente']]['Ciudad']                  = '';}
							if(isset($vecino['Comuna'])){                  $_SESSION['vecinos'][$vecino['idCliente']]['Comuna']                  = $vecino['Comuna'];                     }else{$_SESSION['vecinos'][$vecino['idCliente']]['Comuna']                  = '';}
							if(isset($vecino['Direccion'])){               $_SESSION['vecinos'][$vecino['idCliente']]['Direccion']               = $vecino['Direccion'];                  }else{$_SESSION['vecinos'][$vecino['idCliente']]['Direccion']               = '';}
							if(isset($vecino['Fono1'])){                   $_SESSION['vecinos'][$vecino['idCliente']]['Fono1']                   = $vecino['Fono1'];                      }else{$_SESSION['vecinos'][$vecino['idCliente']]['Fono1']                   = '';}
							if(isset($vecino['Fono2'])){                   $_SESSION['vecinos'][$vecino['idCliente']]['Fono2']                   = $vecino['Fono2'];                      }else{$_SESSION['vecinos'][$vecino['idCliente']]['Fono2']                   = '';}
							if(isset($vecino['Fax'])){                     $_SESSION['vecinos'][$vecino['idCliente']]['Fax']                     = $vecino['Fax'];                        }else{$_SESSION['vecinos'][$vecino['idCliente']]['Fax']                     = '';}
							if(isset($vecino['PersonaContacto'])){         $_SESSION['vecinos'][$vecino['idCliente']]['PersonaContacto']         = $vecino['PersonaContacto'];            }else{$_SESSION['vecinos'][$vecino['idCliente']]['PersonaContacto']         = '';}
							if(isset($vecino['PersonaContacto_Fono'])){    $_SESSION['vecinos'][$vecino['idCliente']]['PersonaContacto_Fono']    = $vecino['PersonaContacto_Fono'];       }else{$_SESSION['vecinos'][$vecino['idCliente']]['PersonaContacto_Fono']    = '';}
							if(isset($vecino['PersonaContacto_email'])){   $_SESSION['vecinos'][$vecino['idCliente']]['PersonaContacto_email']   = $vecino['PersonaContacto_email'];      }else{$_SESSION['vecinos'][$vecino['idCliente']]['PersonaContacto_email']   = '';}
							if(isset($vecino['GeoLatitud'])){              $_SESSION['vecinos'][$vecino['idCliente']]['GeoLatitud']              = $vecino['GeoLatitud'];                 }else{$_SESSION['vecinos'][$vecino['idCliente']]['GeoLatitud']              = '';}
							if(isset($vecino['GeoLongitud'])){             $_SESSION['vecinos'][$vecino['idCliente']]['GeoLongitud']             = $vecino['GeoLongitud'];                }else{$_SESSION['vecinos'][$vecino['idCliente']]['GeoLongitud']             = '';}
							if(isset($vecino['Direccion_img'])){           $_SESSION['vecinos'][$vecino['idCliente']]['Direccion_img']           = $vecino['Direccion_img'];              }else{$_SESSION['vecinos'][$vecino['idCliente']]['Direccion_img']           = '';}
							
							
							//conteo total vecinos mientras no sea el mismo
							if($vecino['idCliente']!=$rowUser['idCliente']){
								$total_vecinos++;
							}
						}
						//arreglo filtrado
						$_SESSION['vecinos_filter'] = $_SESSION['vecinos'];
						filtrar($_SESSION['vecinos_filter'], 'Direccion');
						
						/****************************************************************/
						//recorro resultados
						$total_camaras = 0;
						foreach ($arrCamaras as $cam) {
							//datos del cliente
							if(isset($cam['idCliente'])){        $_SESSION['vecinos_camaras'][$cam['idCliente']]['idCliente']        = $cam['idCliente'];        }else{$_SESSION['vecinos_camaras'][$cam['idCanal']]['idCliente']        = '';}
							if(isset($cam['VecinoDireccion'])){  $_SESSION['vecinos_camaras'][$cam['idCliente']]['VecinoDireccion']  = $cam['VecinoDireccion'];  }else{$_SESSION['vecinos_camaras'][$cam['idCanal']]['VecinoDireccion']  = '';}
							if(isset($cam['VecinoNombre'])){     $_SESSION['vecinos_camaras'][$cam['idCliente']]['VecinoNombre']     = $cam['VecinoNombre'];     }else{$_SESSION['vecinos_camaras'][$cam['idCanal']]['VecinoNombre']     = '';}
							if(isset($cam['VecinoLatitud'])){    $_SESSION['vecinos_camaras'][$cam['idCliente']]['VecinoLatitud']    = $cam['VecinoLatitud'];    }else{$_SESSION['vecinos_camaras'][$cam['idCanal']]['VecinoLatitud']    = '';}
							if(isset($cam['VecinoLongitud'])){   $_SESSION['vecinos_camaras'][$cam['idCliente']]['VecinoLongitud']   = $cam['VecinoLongitud'];   }else{$_SESSION['vecinos_camaras'][$cam['idCanal']]['VecinoLongitud']   = '';}
							
							//datos de la camara
							if(isset($cam['idCanal'])){          $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['idCanal']          = $cam['idCanal'];          }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['idCanal']          = '';}
							if(isset($cam['idCamara'])){         $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['idCamara']         = $cam['idCamara'];         }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['idCamara']         = '';}
							if(isset($cam['Nombre'])){           $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Nombre']           = $cam['Nombre'];           }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Nombre']           = '';}
							if(isset($cam['Chanel'])){           $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Chanel']           = $cam['Chanel'];           }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Chanel']           = '';}
							
							//subconfiguracion si
							if(isset($cam['idSubconfiguracion'])&&$cam['idSubconfiguracion']==1){
								if(isset($cam['Config_usuario'])){    $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_usuario']   = $cam['Cam_Config_usuario'];    }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_usuario']  = '';}
								if(isset($cam['Config_Password'])){   $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_Password']  = $cam['Cam_Config_Password'];   }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_Password'] = '';}
								if(isset($cam['Config_IP'])){         $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_IP']        = $cam['Cam_Config_IP'];         }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_IP']       = '';}
								if(isset($cam['Config_Puerto'])){     $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_Puerto']    = $cam['Cam_Config_Puerto'];     }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_Puerto']   = '';}
								if(isset($cam['idTipoCamara'])){      $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['idTipoCamara']     = $cam['Cam_idTipoCamara'];      }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['idTipoCamara']    = '';}
							//subconfiguracion no
							}else{
								if(isset($cam['Main_Config_usuario'])){    $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_usuario']   = $cam['Main_Config_usuario'];   }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_usuario']  = '';}
								if(isset($cam['Main_Config_Password'])){   $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_Password']  = $cam['Main_Config_Password'];  }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_Password'] = '';}
								if(isset($cam['Main_Config_IP'])){         $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_IP']        = $cam['Main_Config_IP'];        }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_IP']       = '';}
								if(isset($cam['Main_Config_Puerto'])){     $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_Puerto']    = $cam['Main_Config_Puerto'];    }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['Config_Puerto']   = '';}
								if(isset($cam['Main_idTipoCamara'])){      $_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['idTipoCamara']     = $cam['Main_idTipoCamara'];     }else{$_SESSION['vecinos_camaras_list'][$cam['idCliente']][$cam['idCanal']]['idTipoCamara']    = '';}
							}
							//conteo total vecinos
							$total_camaras++;
						}
						
						/****************************************************************/
						//recorro resultados
						$total_eventos = 0;
						foreach ($arrEventos as $event) {
							if(isset($event['idEvento'])){              $_SESSION['vecinos_eventos'][$event['idEvento']]['idEvento']              = $event['idEvento'];              }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['idEvento']              = '';}
							if(isset($event['idTipo'])){                $_SESSION['vecinos_eventos'][$event['idEvento']]['idTipo']                = $event['idTipo'];                }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['idTipo']                = '';}
							if(isset($event['GeoLatitud'])){            $_SESSION['vecinos_eventos'][$event['idEvento']]['GeoLatitud']            = $event['GeoLatitud'];            }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['GeoLatitud']            = '';}
							if(isset($event['GeoLongitud'])){           $_SESSION['vecinos_eventos'][$event['idEvento']]['GeoLongitud']           = $event['GeoLongitud'];           }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['GeoLongitud']           = '';}
							if(isset($event['Direccion'])){             $_SESSION['vecinos_eventos'][$event['idEvento']]['Direccion']             = $event['Direccion'];             }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['Direccion']             = '';}
							if(isset($event['Fecha'])){                 $_SESSION['vecinos_eventos'][$event['idEvento']]['Fecha']                 = $event['Fecha'];                 }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['Fecha']                 = '';}
							if(isset($event['Hora'])){                  $_SESSION['vecinos_eventos'][$event['idEvento']]['Hora']                  = $event['Hora'];                  }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['Hora']                  = '';}
							if(isset($event['Tipo'])){                  $_SESSION['vecinos_eventos'][$event['idEvento']]['Tipo']                  = $event['Tipo'];                  }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['Tipo']                  = '';}
							if(isset($event['Ciudad'])){                $_SESSION['vecinos_eventos'][$event['idEvento']]['Ciudad']                = $event['Ciudad'];                }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['Ciudad']                = '';}
							if(isset($event['Comuna'])){                $_SESSION['vecinos_eventos'][$event['idEvento']]['Comuna']                = $event['Comuna'];                }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['Comuna']                = '';}
							if(isset($event['DescripcionTipo'])){       $_SESSION['vecinos_eventos'][$event['idEvento']]['DescripcionTipo']       = $event['DescripcionTipo'];       }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['DescripcionTipo']       = '';}
							if(isset($event['DescripcionSituacion'])){  $_SESSION['vecinos_eventos'][$event['idEvento']]['DescripcionSituacion']  = $event['DescripcionSituacion'];  }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['DescripcionSituacion']  = '';}
							if(isset($event['idValidado'])){            $_SESSION['vecinos_eventos'][$event['idEvento']]['idValidado']            = $event['idValidado'];            }else{$_SESSION['vecinos_eventos'][$event['idEvento']]['idValidado']            = '';}
							
							//conteo total vecinos
							$total_eventos++;
						}
						/****************************************************************/
						//recorro resultados
						$total_archivos = 0;
						$sub_idEvento   = 0;
						foreach ($arrEventosArchivos as $arch) {
							if(isset($arch['Nombre'])){ $_SESSION['vecinos_eventos_archivos'][$arch['idEvento']][$arch['idArchivo']]['Nombre'] = $arch['Nombre']; }else{$_SESSION['vecinos_eventos_archivos'][$arch['idEvento']][$arch['idArchivo']]['Nombre'] = '';}
							//reinicio variable
							if($sub_idEvento!=$arch['idEvento']){
								$sub_idEvento   = $arch['idEvento'];
								$total_archivos = 0;
							}
							//conteo total vecinos
							$total_archivos++;
							$_SESSION['vecinos_eventos'][$arch['idEvento']]['total_archivos'] = $total_archivos;
						}
						
						/****************************************************************/
						//recorro resultados
						$total_peligros = 0;
						foreach ($arrPeligros as $event) {
							if(isset($event['idPeligro'])){         $_SESSION['vecinos_peligros'][$event['idPeligro']]['idPeligro']         = $event['idPeligro'];         }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['idPeligro']         = '';}
							if(isset($event['idTipo'])){            $_SESSION['vecinos_peligros'][$event['idPeligro']]['idTipo']            = $event['idTipo'];            }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['idTipo']            = '';}
							if(isset($event['GeoLatitud'])){        $_SESSION['vecinos_peligros'][$event['idPeligro']]['GeoLatitud']        = $event['GeoLatitud'];        }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['GeoLatitud']        = '';}
							if(isset($event['GeoLongitud'])){       $_SESSION['vecinos_peligros'][$event['idPeligro']]['GeoLongitud']       = $event['GeoLongitud'];       }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['GeoLongitud']       = '';}
							if(isset($event['Direccion'])){         $_SESSION['vecinos_peligros'][$event['idPeligro']]['Direccion']         = $event['Direccion'];         }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['Direccion']         = '';}
							if(isset($event['Tipo'])){              $_SESSION['vecinos_peligros'][$event['idPeligro']]['Tipo']              = $event['Tipo'];              }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['Tipo']              = '';}
							if(isset($event['Ciudad'])){            $_SESSION['vecinos_peligros'][$event['idPeligro']]['Ciudad']            = $event['Ciudad'];            }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['Ciudad']            = '';}
							if(isset($event['Comuna'])){            $_SESSION['vecinos_peligros'][$event['idPeligro']]['Comuna']            = $event['Comuna'];            }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['Comuna']            = '';}
							if(isset($event['Descripcion'])){       $_SESSION['vecinos_peligros'][$event['idPeligro']]['Descripcion']       = $event['Descripcion'];       }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['Descripcion']       = '';}
							if(isset($event['idValidado'])){        $_SESSION['vecinos_peligros'][$event['idPeligro']]['idValidado']        = $event['idValidado'];        }else{$_SESSION['vecinos_peligros'][$event['idPeligro']]['idValidado']        = '';}
							
							//conteo total vecinos
							$total_peligros++;
						}
						/****************************************************************/
						//recorro resultados
						$total_archivos  = 0;
						$sub_idPeligro   = 0;
						foreach ($arrPeligrosArchivos as $arch) {
							if(isset($arch['Nombre'])){ $_SESSION['vecinos_peligros_archivos'][$arch['idPeligro']][$arch['idArchivo']]['Nombre'] = $arch['Nombre']; }else{$_SESSION['vecinos_peligros_archivos'][$arch['idPeligro']][$arch['idArchivo']]['Nombre'] = '';}
							//reinicio variable
							if($sub_idPeligro!=$arch['idPeligro']){
								$sub_idPeligro   = $arch['idPeligro'];
								$total_archivos  = 0;
							}
							//conteo total vecinos
							$total_archivos++;
							$_SESSION['vecinos_peligros'][$arch['idPeligro']]['total_archivos'] = $total_archivos;
						}
						
						/****************************************************************/
						//recorro resultados
						$total_servicios = 0;
						foreach ($arrServicios as $servicio) {
							if(isset($servicio['idServicio'])){      $_SESSION['servicios'][$servicio['idServicio']]['idServicio']      = $servicio['idServicio'];         }else{$_SESSION['servicios'][$servicio['idServicio']]['idServicio']      = '';}
							if(isset($servicio['idTipo'])){          $_SESSION['servicios'][$servicio['idServicio']]['idTipo']          = $servicio['idTipo'];             }else{$_SESSION['servicios'][$servicio['idServicio']]['idTipo']          = '';}
							if(isset($servicio['Tipo'])){            $_SESSION['servicios'][$servicio['idServicio']]['Tipo']            = $servicio['Tipo'];               }else{$_SESSION['servicios'][$servicio['idServicio']]['Tipo']            = '';}
							if(isset($servicio['Nombre'])){          $_SESSION['servicios'][$servicio['idServicio']]['Nombre']          = $servicio['Nombre'];             }else{$_SESSION['servicios'][$servicio['idServicio']]['Nombre']          = '';}
							if(isset($servicio['Fono1'])){           $_SESSION['servicios'][$servicio['idServicio']]['Fono1']           = $servicio['Fono1'];              }else{$_SESSION['servicios'][$servicio['idServicio']]['Fono1']           = '';}
							if(isset($servicio['Fono2'])){           $_SESSION['servicios'][$servicio['idServicio']]['Fono2']           = $servicio['Fono2'];              }else{$_SESSION['servicios'][$servicio['idServicio']]['Fono2']           = '';}
							if(isset($servicio['Ciudad'])){          $_SESSION['servicios'][$servicio['idServicio']]['Ciudad']          = $servicio['Ciudad'];             }else{$_SESSION['servicios'][$servicio['idServicio']]['Ciudad']          = '';}
							if(isset($servicio['Comuna'])){          $_SESSION['servicios'][$servicio['idServicio']]['Comuna']          = $servicio['Comuna'];             }else{$_SESSION['servicios'][$servicio['idServicio']]['Comuna']          = '';}
							if(isset($servicio['Direccion'])){       $_SESSION['servicios'][$servicio['idServicio']]['Direccion']       = $servicio['Direccion'];          }else{$_SESSION['servicios'][$servicio['idServicio']]['Direccion']       = '';}
							if(isset($servicio['email'])){           $_SESSION['servicios'][$servicio['idServicio']]['email']           = $servicio['email'];              }else{$_SESSION['servicios'][$servicio['idServicio']]['email']           = '';}
							if(isset($servicio['Fax'])){             $_SESSION['servicios'][$servicio['idServicio']]['Fax']             = $servicio['Fax'];                }else{$_SESSION['servicios'][$servicio['idServicio']]['Fax']             = '';}
							if(isset($servicio['Web'])){             $_SESSION['servicios'][$servicio['idServicio']]['Web']             = $servicio['Web'];                }else{$_SESSION['servicios'][$servicio['idServicio']]['Web']             = '';}
							if(isset($servicio['HoraInicio'])){      $_SESSION['servicios'][$servicio['idServicio']]['HoraInicio']      = $servicio['HoraInicio'];         }else{$_SESSION['servicios'][$servicio['idServicio']]['HoraInicio']      = '';}
							if(isset($servicio['HoraTermino'])){     $_SESSION['servicios'][$servicio['idServicio']]['HoraTermino']     = $servicio['HoraTermino'];        }else{$_SESSION['servicios'][$servicio['idServicio']]['HoraTermino']     = '';}
							if(isset($servicio['GeoLatitud'])){      $_SESSION['servicios'][$servicio['idServicio']]['GeoLatitud']      = $servicio['GeoLatitud'];         }else{$_SESSION['servicios'][$servicio['idServicio']]['GeoLatitud']      = '';}
							if(isset($servicio['GeoLongitud'])){     $_SESSION['servicios'][$servicio['idServicio']]['GeoLongitud']     = $servicio['GeoLongitud'];        }else{$_SESSION['servicios'][$servicio['idServicio']]['GeoLongitud']     = '';}
							
							//conteo total vecinos
							$total_servicios++;
						}
						
						
						
						/****************************************************************/
						//recorro resultados
						$total_canales = 0;
						foreach ($arrCanales as $can) {
							//conteo total vecinos
							$total_canales++;
						}
						$_SESSION['canales'] = $arrCanales;
						filtrar($_SESSION['canales'], 'CategoriaNombre');
						/****************************************************************/
						//recorro resultados
						$_SESSION['actualizaciones'] = $arrActualizaciones;
						/****************************************************************/
						//recorro resultados
						$_SESSION['infracciones'] = $arrInfracciones;
						/****************************************************************/
						//recorro resultados
						$_SESSION['sitios'] = $arrSitios;
						
						
						
						
						/****************************************************************/
						//guardo el total de vecinos cerca
						$_SESSION['usuario']['basic_data']['total_servicios']  = $total_servicios;
						$_SESSION['usuario']['basic_data']['total_vecinos']    = $total_vecinos;
						$_SESSION['usuario']['basic_data']['total_camaras']    = $total_camaras;
						$_SESSION['usuario']['basic_data']['total_eventos']    = $total_eventos;
						$_SESSION['usuario']['basic_data']['total_peligros']   = $total_peligros;
						$_SESSION['usuario']['basic_data']['total_canales']    = $total_canales;
						
						/****************************************************************/
						//Redirijo a la pagina principal si ya tiene todo configurado
						if($rowUser['idNuevo']==1){
							header( 'Location: principal.php' );
							die;
						//lo redirijo a su perfil en caso de que acepte su correcta ubicacion	
						}else{
							header( 'Location: principal_datos.php' );
							die;
						}
					//Si no esta activo envio error	
					}else{
						$error['idCliente']   = 'error/Su usuario esta desactivado, Contactese con el administrador';
					}
				
				//Si no se encuentra ningun usuario se envia un error	
				}else{
					$error['idCliente']   = 'error/El Rut de usuario o contraseña no coinciden';
					
					//filtros
					if(isset($fecha) && $fecha != ''){                $a  = "'".$fecha."'" ;         }else{$a  = "''";}
					if(isset($hora) && $hora != ''){                  $a .= ",'".$hora."'" ;         }else{$a .= ",''";}
					if(isset($Rut) && $Rut != ''){                    $a .= ",'".$Rut."'" ;          }else{$a .= ",''";}
					if(isset($email) && $email != ''){                $a .= ",'".$email."'" ;        }else{$a .= ",''";}
					if(isset($IP_Client) && $IP_Client != ''){        $a .= ",'".$IP_Client."'" ;    }else{$a .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp != ''){  $a .= ",'".$Agent_Transp."'" ; }else{$a .= ",''";}
					if(isset($Time) && $Time != ''){                  $a .= ",'".$Time."'" ;         }else{$a .= ",''";}
									
					// inserto los datos de registro en la db
					$query  = "INSERT INTO `seg_vecinal_clientes_checkbrute` (Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time) 
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
			if (checkbrute($Rut, $email, $IP_Client, 'seg_vecinal_clientes_checkbrute', $dbConn) == true) {
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
				seg_vecinal_clientes_listado.email,
				core_sistemas.RazonSocial,
				core_sistemas.email_principal, 
				core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
				core_sistemas.Config_Gmail_Password AS Gmail_Password';
				$SIS_join = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = seg_vecinal_clientes_listado.idSistema';
				$SIS_where = 'seg_vecinal_clientes_listado.email="'.$email.'"';
				$rowusr            = db_select_data (false, $SIS_query, 'seg_vecinal_clientes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);
				$cuenta_registros  = db_select_nrows (false, $SIS_query, 'seg_vecinal_clientes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);

				//verifico si los datos ingresados son iguales a los almacenados
				if(isset($cuenta_registros)&&$cuenta_registros!=''&&$cuenta_registros!=0){  
					
					//Generacion de nueva clave
					$num_caracteres = "10"; //cantidad de caracteres de la clave
					$clave = substr(md5(rand()),0,$num_caracteres); //generador aleatorio de claves 
					$nueva_clave = md5($clave);//se codifica la clave 
						
					//Actualizacion de la clave en la base de datos
					$a = 'password="'.$nueva_clave.'"';
					$result = db_update_data (false, $a, 'seg_vecinal_clientes_listado', 'email = "'.$email.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					
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
					$query  = "INSERT INTO `seg_vecinal_clientes_checkbrute` (Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time) 
					VALUES (".$a.")";
					//Consulta
					$resultado = mysqli_query ($dbConn, $query);
					
				}
			

					
			}

		break;			
/*******************************************************************************************************************/
		case 'del_img':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//cliente
			$idCliente = $_SESSION['usuario']['basic_data']['idCliente'];
				
			// Se obtiene el nombre de la imagen de perfil
			$rowdata = db_select_data (false, 'Direccion_img', 'seg_vecinal_clientes_listado', '', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se borra el dato de la base de datos
			$a = 'Direccion_img=""';
			$result = db_update_data (false, $a, 'seg_vecinal_clientes_listado', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
			//se elimina el archivo
			if(isset($rowdata['Direccion_img'])&&$rowdata['Direccion_img']!=''){
				try {
					if(!is_writable('../'.DB_SITE_ALT_1_PATH.'/upload/'.$rowdata['Direccion_img'])){
						//throw new Exception('File not writable');
					}else{
						unlink('../'.DB_SITE_ALT_1_PATH.'/upload/'.$rowdata['Direccion_img']);
					}
				}catch(Exception $e) { 
					//guardar el dato en un archivo log
				}
			}
			
			//Seteo la variable de sesion si existe
			if(isset($_SESSION['usuario']['basic_data']['Direccion_img'])&&$_SESSION['usuario']['basic_data']['Direccion_img']!=''){
				$_SESSION['usuario']['basic_data']['Direccion_img'] = '';
				//Si se tiene un id se actaliza el listado de imagenes de los vecinos
				if(isset($_SESSION['usuario']['basic_data']['idCliente'])){
					//datos
					$idCliente = $_SESSION['usuario']['basic_data']['idCliente'];
					$Direccion = $_SESSION['usuario']['basic_data']['Direccion'];
					//actualizacion
					$_SESSION['vecinos'][$idCliente]['Direccion_img'] = '';
					$countx = 0;
					foreach($_SESSION['vecinos_filter'][$Direccion] as $direcList) {
						if(isset($direcList['idCliente'])&&$direcList['idCliente']==$idCliente){
							$_SESSION['vecinos_filter'][$Direccion][$countx]['Direccion_img'] = '';
						}
						$countx++;
					}	
				}
			}
			
			//Redirijo			
			header( 'Location: '.$location.'&id_img=true' );
			die;

		break;	
/*******************************************************************************************************************/
	}
?>

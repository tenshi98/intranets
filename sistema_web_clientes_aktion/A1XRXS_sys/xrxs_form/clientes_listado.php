<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridClientead                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-001).');
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
			case 'idCliente':              if(empty($idCliente)){                            $error['idCliente']               = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){                            $error['idSistema']               = 'error/No ha seleccionado el sistema';}break;
			case 'idEstado':               if(empty($idEstado)){                             $error['idEstado']                = 'error/No ha seleccionado el Estado';}break;
			case 'idTipo':                 if(empty($idTipo)){                               $error['idTipo']                  = 'error/No ha seleccionado el tipo de cliente';}break;
			case 'idRubro':                if(empty($idRubro)){                              $error['idRubro']                 = 'error/No ha seleccionado el rubro';}break;
			case 'email':                  if(empty($email)){                                $error['email']                   = 'error/No ha ingresado el email';}break;
			case 'Nombre':                 if(empty($Nombre)){                               $error['Nombre']                  = 'error/No ha ingresado el Nombre de Fantasia';}break;
			case 'RazonSocial':            if(empty($RazonSocial)){                          $error['RazonSocial']             = 'error/No ha ingresado la Razon Social';}break;
			case 'Rut':                    if(empty($Rut)&&$form_trabajo!='getpass'){        $error['Rut']                     = 'error/No ha ingresado el Rut';}break;	
			case 'fNacimiento':            if(empty($fNacimiento)){                          $error['fNacimiento']             = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Direccion':              if(empty($Direccion)){                            $error['Direccion']               = 'error/No ha ingresado la direccion';}break;
			case 'Fono1':                  if(empty($Fono1)){                                $error['Fono1']                   = 'error/No ha ingresado el telefono';}break;
			case 'Fono2':                  if(empty($Fono2)){                                $error['Fono2']                   = 'error/No ha ingresado el telefono';}break;
			case 'idCiudad':               if(empty($idCiudad)){                             $error['idCiudad']                = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':               if(empty($idComuna)){                             $error['idComuna']                = 'error/No ha seleccionado la comuna';}break;
			case 'Fax':                    if(empty($Fax)){                                  $error['Fax']                     = 'error/No ha ingresado el fax';}break;
			case 'PersonaContacto':        if(empty($PersonaContacto)){                      $error['PersonaContacto']         = 'error/No ha ingresado el nombre de la persona de contacto';}break;
			case 'PersonaContacto_Fono':   if(empty($PersonaContacto_Fono)){                 $error['PersonaContacto_Fono']    = 'error/No ha ingresado el Fono de la persona de contacto';}break;
			case 'PersonaContacto_email':  if(empty($PersonaContacto_email)){                $error['PersonaContacto_email']   = 'error/No ha ingresado el Email de la persona de contacto';}break;
			case 'Web':                    if(empty($Web)){                                  $error['Web']                     = 'error/No ha ingresado la pagina web';}break;
			case 'Giro':                   if(empty($Giro)){                                 $error['Giro']                    = 'error/No ha ingresado el Giro de la empresa';}break;
			case 'password':               if(empty($password)&&$form_trabajo!='getpass'){   $error['password']                = 'error/No ha ingresado el password';}break;
			
			case 'repassword':             if(empty($repassword)){                           $error['repassword']              = 'error/No ha ingresado la repeticion del password';}break;
			case 'oldpassword':            if(empty($oldpassword)){                          $error['oldpassword']             = 'error/No ha ingresado el password antiguo';}break;
			
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
			}else{
				//$error['ndata_4'] = 'error/Sin direccion ingresada';
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
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'clientes_listado', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					
					/**********************************************************************/
					//Datos propios
					//si confirma ubicacion o deja de ser nuevo
					if(isset($Nombre) && $Nombre != ''){   $_SESSION['usuario']['basic_data']['Nombre']      = $Nombre;}
					if(isset($Rut) && $Rut != ''){         $_SESSION['usuario']['basic_data']['Rut']         = $Rut;}
					
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
			if (checkbrute($Rut, $email, $IP_Client, 'clientes_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, usuario bloqueado por 2 horas'; 
			}
			
			//si no hay errores
			if ( empty($error) ) {
						
				//Busco al usuario en el sistema
				$SIS_query = '
				clientes_listado.idCliente, 
				clientes_listado.password, 
				clientes_listado.Rut, 
				clientes_listado.Nombre, 
				clientes_listado.idEstado,
				core_sistemas.Config_idTheme,
				core_sistemas.Config_imgLogo,
				core_sistemas.Config_IDGoogle,
				core_ubicacion_ciudad.Nombre AS nombre_region,
				core_ubicacion_ciudad.Wheater AS nombre_pronostico,
				core_ubicacion_comunas.Nombre AS nombre_comuna,
				core_sistemas.Social_idUso,
				core_sistemas.Social_facebook,
				core_sistemas.Social_twitter,
				core_sistemas.Social_instagram,
				core_sistemas.Social_linkedin,
				core_sistemas.Social_rss,
				core_sistemas.Social_youtube,
				core_sistemas.Social_tumblr';
				$SIS_join = '
				LEFT JOIN `core_sistemas`             ON core_sistemas.idSistema          = clientes_listado.idSistema
				LEFT JOIN `core_ubicacion_ciudad`     ON core_ubicacion_ciudad.idCiudad   = clientes_listado.idCiudad
				LEFT JOIN `core_ubicacion_comunas`    ON core_ubicacion_comunas.idComuna  = clientes_listado.idComuna';
				$SIS_where = 'clientes_listado.Rut = "'.$Rut.'" AND clientes_listado.password = "'.md5($password).'"';
				$rowUser = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);


				//Se verifca si los datos ingresados son de un usuario
				if (isset($rowUser['idCliente'])&&$rowUser['idCliente']!='') {
					
					//Verifico que el usuario identificado este activo
					if($rowUser['idEstado']==1){
						
						/***************************************************************/
						//Actualizo la tabla de los usuarios
						$a = 'Ultimo_acceso="'.$fecha.'", IP_Client="'.$IP_Client.'", Agent_Transp="'.$Agent_Transp.'"';
						$resultado = db_update_data (false, $a, 'clientes_listado', 'idCliente = "'.$rowUser['idCliente'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
						//busca si la ip del usuario ya existe
						$n_ip = db_select_nrows (false, 'idIpUsuario', 'clientes_listado_ip', '', "IP_Client='".$IP_Client."' AND idCliente='".$rowUser['idCliente']."'", $dbConn, 'Login-form', $original, $form_trabajo);
						//si la ip no existe la guarda
						if(isset($n_ip)&&$n_ip==0){
							$query  = "INSERT INTO `clientes_listado_ip` (idCliente,IP_Client, Fecha, Hora) VALUES (".$rowUser['idCliente'].",'".$IP_Client."','".$fecha."','".$hora."' )";
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
						$query  = "INSERT INTO `clientes_accesos` (idCliente,Fecha, Hora, IP_Client, Agent_Transp) 
						VALUES (".$a.")";
						//Consulta
						$resultado = mysqli_query ($dbConn, $query);
					
						//Se crean las variables con todos los datos
						$_SESSION['usuario']['basic_data']['idCliente']          = $rowUser['idCliente'];
						$_SESSION['usuario']['basic_data']['password']           = $rowUser['password'];
						$_SESSION['usuario']['basic_data']['Nombre']             = $rowUser['Nombre'];
						$_SESSION['usuario']['basic_data']['Rut']                = $rowUser['Rut'];
						$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowUser['Config_idTheme'];
						$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowUser['Config_imgLogo'];
						$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowUser['Config_IDGoogle'];
						$_SESSION['usuario']['basic_data']['Region']             = $rowUser['nombre_region'];
						$_SESSION['usuario']['basic_data']['Pronostico']         = $rowUser['nombre_pronostico'];
						$_SESSION['usuario']['basic_data']['Comuna']             = $rowUser['nombre_comuna'];
						$_SESSION['usuario']['basic_data']['Social_idUso']       = $rowUser['Social_idUso'];
						$_SESSION['usuario']['basic_data']['Social_facebook']    = $rowUser['Social_facebook'];
						$_SESSION['usuario']['basic_data']['Social_twitter']     = $rowUser['Social_twitter'];
						$_SESSION['usuario']['basic_data']['Social_instagram']   = $rowUser['Social_instagram'];
						$_SESSION['usuario']['basic_data']['Social_linkedin']    = $rowUser['Social_linkedin'];
						$_SESSION['usuario']['basic_data']['Social_rss']         = $rowUser['Social_rss'];
						$_SESSION['usuario']['basic_data']['Social_youtube']     = $rowUser['Social_youtube'];
						$_SESSION['usuario']['basic_data']['Social_tumblr']      = $rowUser['Social_tumblr'];
					
						
						/*********************************/
						//filtro
						$z  = "contabilidad_clientes_previred.idContabPrevired!=0";
						$z .= " AND contabilidad_clientes_previred.idCliente='".$rowUser['idCliente']."'";
						$z .= " AND contabilidad_clientes_previred.idEstado='1'";
			
						//Listado de facturaciones pendientes
						$SIS_query = 'contabilidad_clientes_previred.idContabPrevired, contabilidad_clientes_previred.Creacion_fecha, core_estado_facturacion.Nombre AS Estado, contabilidad_clientes_previred_tipo.Nombre AS Tipo';
						$SIS_join  = '
						LEFT JOIN `core_estado_facturacion`               ON core_estado_facturacion.idEstado              = contabilidad_clientes_previred.idEstado
						LEFT JOIN `contabilidad_clientes_previred_tipo`   ON contabilidad_clientes_previred_tipo.idTipo    = contabilidad_clientes_previred.idTipo';
						$SIS_where = $z;
						$SIS_order = 'contabilidad_clientes_previred.idContabPrevired ASC';
						$arrFacturacion = array();
						$arrFacturacion = db_select_array (false, $SIS_query, 'contabilidad_clientes_previred', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
						
						/***************************************************************************************************/
						/***************************************************************************************************/
						/***************************************************************************************************/
						//elimino posibles datos
						
						unset($_SESSION['Facturacion']);
						
						
						/****************************************************************/
						//recorro resultados
						$_SESSION['Facturacion'] = $arrFacturacion;
						
						
						
						
						
						
						/****************************************************************/
						//Redirijo a la pagina principal si ya tiene todo configurado
						header( 'Location: principal.php' );
						die;
						
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
			if (checkbrute($Rut, $email, $IP_Client, 'clientes_checkbrute', $dbConn) == true) {
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
				clientes_listado.email,
				core_sistemas.Nombre AS RazonSocial,
				core_sistemas.email_principal, 
				core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
				core_sistemas.Config_Gmail_Password AS Gmail_Password';
				$SIS_join = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = clientes_listado.idSistema';
				$SIS_where = 'clientes_listado.email="'.$email.'"';
				$rowusr            = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);
				$cuenta_registros  = db_select_nrows (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, 'Login-form', $original, $form_trabajo);

				//verifico si los datos ingresados son iguales a los almacenados
				if(isset($cuenta_registros)&&$cuenta_registros!=''&&$cuenta_registros!=0){  
					
					//Generacion de nueva clave
					$num_caracteres = "10"; //cantidad de caracteres de la clave
					$clave          = substr(md5(rand()),0,$num_caracteres); //generador aleatorio de claves 
					$nueva_clave    = md5($clave);//se codifica la clave 
						
					//Actualizacion de la clave en la base de datos
					$a = 'password="'.$nueva_clave.'"';
					$result = db_update_data (false, $a, 'clientes_listado', 'email = "'.$email.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
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

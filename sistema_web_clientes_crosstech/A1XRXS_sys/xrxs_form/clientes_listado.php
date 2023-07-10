<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridClientead                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
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
	if (!empty($_POST['idCliente']))             $idCliente               = simpleDecode($_POST['idCliente'], fecha_actual());
	if (!empty($_POST['idSistema']))             $idSistema               = simpleDecode($_POST['idSistema'], fecha_actual());
	if (!empty($_POST['idEstado']))              $idEstado                = $_POST['idEstado'];
	if (!empty($_POST['idTipo']))                $idTipo                  = $_POST['idTipo'];
	if (!empty($_POST['idRubro']))               $idRubro                 = $_POST['idRubro'];
	if (!empty($_POST['email']))                 $email                   = $_POST['email'];
	if (!empty($_POST['Nombre']))                $Nombre 	              = $_POST['Nombre'];
	if (!empty($_POST['RazonSocial']))           $RazonSocial 	          = $_POST['RazonSocial'];
	if (!empty($_POST['Rut']))                   $Rut 	                  = $_POST['Rut'];
	if (!empty($_POST['fNacimiento']))           $fNacimiento 	          = $_POST['fNacimiento'];
	if (!empty($_POST['Direccion']))             $Direccion 	          = $_POST['Direccion'];
	if (!empty($_POST['Fono1']))                 $Fono1 	              = $_POST['Fono1'];
	if (!empty($_POST['Fono2']))                 $Fono2 	              = $_POST['Fono2'];
	if (!empty($_POST['idCiudad']))              $idCiudad                = $_POST['idCiudad'];
	if (!empty($_POST['idComuna']))              $idComuna                = $_POST['idComuna'];
	if (!empty($_POST['Fax']))                   $Fax                     = $_POST['Fax'];
	if (!empty($_POST['PersonaContacto']))       $PersonaContacto         = $_POST['PersonaContacto'];
	if (!empty($_POST['PersonaContacto_Fono']))  $PersonaContacto_Fono    = $_POST['PersonaContacto_Fono'];
	if (!empty($_POST['PersonaContacto_email'])) $PersonaContacto_email   = $_POST['PersonaContacto_email'];
	if (!empty($_POST['Web']))                   $Web                     = $_POST['Web'];
	if (!empty($_POST['Giro']))                  $Giro                    = $_POST['Giro'];
	if (!empty($_POST['password']))              $password                = $_POST['password'];

	if (!empty($_POST['repassword']))            $repassword              = $_POST['repassword'];
	if (!empty($_POST['oldpassword']))           $oldpassword             = $_POST['oldpassword'];

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
			case 'RazonSocial':            if(empty($RazonSocial)){                          $error['RazonSocial']             = 'error/No ha ingresado la Razón Social';}break;
			case 'Rut':                    if(empty($Rut)&&$form_trabajo!='getpass'){        $error['Rut']                     = 'error/No ha ingresado el Rut';}break;
			case 'fNacimiento':            if(empty($fNacimiento)){                          $error['fNacimiento']             = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Direccion':              if(empty($Direccion)){                            $error['Direccion']               = 'error/No ha ingresado la dirección';}break;
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
/*                                          Verificacion de datos erroneos                                         */
/*******************************************************************************************************************/
	if(isset($Nombre) && $Nombre!=''){                 $Nombre         = EstandarizarInput($Nombre);}
	if(isset($RazonSocial) && $RazonSocial!=''){       $RazonSocial    = EstandarizarInput($RazonSocial);}
	if(isset($Direccion) && $Direccion!=''){           $Direccion      = EstandarizarInput($Direccion);}
	if(isset($Giro) && $Giro!=''){                     $Giro           = EstandarizarInput($Giro);}
	//if(isset($email) && $email!=''){                   $email          = EstandarizarInput($email);}
	if(isset($password) && $password!=''){             $password       = EstandarizarInput($password);}
	if(isset($repassword) && $repassword!=''){         $repassword     = EstandarizarInput($repassword);}
	if(isset($oldpassword) && $oldpassword!=''){       $oldpassword    = EstandarizarInput($oldpassword);}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($email)&&contar_palabras_censuradas($email)!=0){                                 $error['email']                  = 'error/Edita el email, contiene palabras no permitidas';}
	if(isset($Nombre)&&contar_palabras_censuradas($Nombre)!=0){                               $error['Nombre']                 = 'error/Edita el Nombre,contiene palabras no permitidas';}
	if(isset($RazonSocial)&&contar_palabras_censuradas($RazonSocial)!=0){                     $error['RazonSocial']            = 'error/Edita la razonSocial, contiene palabras no permitidas';}
	if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){                         $error['Direccion']              = 'error/Edita la dirección, contiene palabras no permitidas';}
	if(isset($Fono1)&&contar_palabras_censuradas($Fono1)!=0){                                 $error['Fono1']                  = 'error/Edita el fono1, contiene palabras no permitidas';}
	if(isset($Fono2)&&contar_palabras_censuradas($Fono2)!=0){                                 $error['Fono2']                  = 'error/Edita el fono2, contiene palabras no permitidas';}
	if(isset($Fax)&&contar_palabras_censuradas($Fax)!=0){                                     $error['Fax']                    = 'error/Edita el fax, contiene palabras no permitidas';}
	if(isset($PersonaContacto)&&contar_palabras_censuradas($PersonaContacto)!=0){             $error['PersonaContacto']        = 'error/Edita la persona de contacto, contiene palabras no permitidas';}
	if(isset($PersonaContacto_Fono)&&contar_palabras_censuradas($PersonaContacto_Fono)!=0){   $error['PersonaContacto_Fono']   = 'error/Edita el fono de persona de contacto, contiene palabras no permitidas';}
	if(isset($PersonaContacto_email)&&contar_palabras_censuradas($PersonaContacto_email)!=0){ $error['PersonaContacto_email']  = 'error/Edita el email de persona de contacto, contiene palabras no permitidas';}
	if(isset($Web)&&contar_palabras_censuradas($Web)!=0){                                     $error['Web']                    = 'error/Edita la web, contiene palabras no permitidas';}
	if(isset($Giro)&&contar_palabras_censuradas($Giro)!=0){                                   $error['Giro']                   = 'error/Edita el giro, contiene palabras no permitidas';}
	if(isset($password)&&contar_palabras_censuradas($password)!=0){                           $error['password']               = 'error/Edita password, contiene palabras no permitidas';}
	if(isset($repassword)&&contar_palabras_censuradas($repassword)!=0){                       $error['repassword']             = 'error/Edita repassword, contiene palabras no permitidas';}
	if(isset($oldpassword)&&contar_palabras_censuradas($oldpassword)!=0){                     $error['oldpassword']            = 'error/Edita oldpassword, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                        Validacion de los datos ingresados                                       */
/*******************************************************************************************************************/
	//Verifica si el mail corresponde
	if(isset($email)&&!validarEmail($email)){                                 $error['email']                  = 'error/El Email ingresado no es valido';}
	if(isset($Fono1)&&!validarNumero($Fono1)){                                $error['Fono1']                  = 'error/Ingrese un numero telefonico valido';}
	if(isset($Fono2)&&!validarNumero($Fono2)){                                $error['Fono2']                  = 'error/Ingrese un numero telefonico valido';}
	if(isset($Rut)&&!validarRut($Rut)){                                       $error['Rut']                    = 'error/El Rut ingresado no es valido';}
	if(isset($PersonaContacto_email)&&!validarEmail($PersonaContacto_email)){ $error['email']                  = 'error/El Email ingresado no es valido';}
	if(isset($PersonaContacto_Fono)&&!validarNumero($PersonaContacto_Fono)){  $error['PersonaContacto_Fono']   = 'error/Ingrese un numero telefonico valido';}
	if(isset($password)&&isset($repassword)){
		if ( $password <> $repassword )           $error['password'] = 'error/Las contraseñas ingresadas no coinciden';
	}
	if(isset($password)){
		if (strpos($password, " ")){              $error['Password1'] = 'error/La contraseña contiene espacios vacios';}
		//if (strtolower($password) != $password){  $error['Password2'] = 'error/La contraseña de usuario contiene mayusculas';}
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
			if(isset($idCiudad) && $idCiudad != ''&&isset($idComuna) && $idComuna != ''&&isset($Direccion) && $Direccion!=''){
				//variable con la dirección
				$address = '';
				if(isset($idCiudad) && $idCiudad!=''){
					$rowdata = db_select_data (false, 'Nombre', 'core_ubicacion_ciudad', '', 'idCiudad = "'.$idCiudad.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$address .= $rowdata['Nombre'].', ';
				}
				if(isset($idComuna) && $idComuna!=''){
					$rowdata = db_select_data (false, 'Nombre', 'core_ubicacion_comunas', '', 'idComuna = "'.$idComuna.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					$address .= $rowdata['Nombre'].', ';
				}
				if(isset($Direccion) && $Direccion!=''){
					$address .= $Direccion;
				}
				if($address!=''){
					$geocodeData = getGeocodeData($address, $_SESSION['usuario']['basic_data']['Config_IDGoogle']);
					if($geocodeData) {
						$GeoLatitud  = $geocodeData[0];
						$GeoLongitud = $geocodeData[1];
					} else {
						$error['ndata_4'] = 'error/Detalles de la dirección incorrectos!';
					}
				}else{
					$error['ndata_4'] = 'error/Sin dirección ingresada';
				}
			}else{
				//$error['ndata_4'] = 'error/Sin dirección ingresada';
			}

			// si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$SIS_data = "idCliente='".$idCliente."'";
				if(isset($idSistema) && $idSistema!=''){                             $SIS_data .= ",idSistema='".$idSistema."'";}
				if(isset($idEstado) && $idEstado!=''){                               $SIS_data .= ",idEstado='".$idEstado."'";}
				if(isset($idTipo) && $idTipo!=''){                                   $SIS_data .= ",idTipo='".$idTipo."'";}
				if(isset($idRubro) && $idRubro!=''){                                 $SIS_data .= ",idRubro='".$idRubro."'";}
				if(isset($email) && $email!=''){                                     $SIS_data .= ",email='".$email."'";}
				if(isset($Nombre) && $Nombre!=''){                                   $SIS_data .= ",Nombre='".$Nombre."'";}
				if(isset($RazonSocial) && $RazonSocial!=''){                         $SIS_data .= ",RazonSocial='".$RazonSocial."'";}
				if(isset($Rut) && $Rut!=''){                                         $SIS_data .= ",Rut='".$Rut."'";}
				if(isset($fNacimiento) && $fNacimiento!=''){                         $SIS_data .= ",fNacimiento='".$fNacimiento."'";}
				if(isset($Direccion) && $Direccion!=''){                             $SIS_data .= ",Direccion='".$Direccion."'";}
				if(isset($Fono1) && $Fono1!=''){                                     $SIS_data .= ",Fono1='".$Fono1."'";}
				if(isset($Fono2) && $Fono2!=''){                                     $SIS_data .= ",Fono2='".$Fono2."'";}
				if(isset($idCiudad) && $idCiudad!= ''){                              $SIS_data .= ",idCiudad='".$idCiudad."'";}
				if(isset($idComuna) && $idComuna!= ''){                              $SIS_data .= ",idComuna='".$idComuna."'";}
				if(isset($Fax) && $Fax!= ''){                                        $SIS_data .= ",Fax='".$Fax."'";}
				if(isset($PersonaContacto) && $PersonaContacto!= ''){                $SIS_data .= ",PersonaContacto='".$PersonaContacto."'";}
				if(isset($PersonaContacto_Fono) && $PersonaContacto_Fono!= ''){      $SIS_data .= ",PersonaContacto_Fono='".$PersonaContacto_Fono."'";}
				if(isset($PersonaContacto_email) && $PersonaContacto_email!= ''){    $SIS_data .= ",PersonaContacto_email='".$PersonaContacto_email."'";}
				if(isset($Web) && $Web!= ''){                                        $SIS_data .= ",Web='".$Web."'";}
				if(isset($Giro) && $Giro!= ''){                                      $SIS_data .= ",Giro='".$Giro."'";}
				if(isset($password) && $password!= ''){                              $SIS_data .= ",password='".md5($password)."'";}

				//se actualizan los datos
				$resultado = db_update_data (false, $SIS_data, 'clientes_listado', 'idCliente = "'.$idCliente.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/**********************************************************************/
					//Datos propios
					//si confirma ubicacion o deja de ser nuevo
					if(isset($Nombre) && $Nombre!=''){   $_SESSION['usuario']['basic_data']['Nombre'] = DeSanitizar($Nombre);}
					if(isset($Rut) && $Rut!=''){         $_SESSION['usuario']['basic_data']['Rut']    = $Rut;}

					//redirijo
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
			//$email          = '';

			//Saneado de datos ingresados
			$password = preg_replace("/[^a-zA-Z0-9_\-]+ñÑáéíóúÁÉÍÓÚ-_?¿°()=,.<>:;*@/","",$password);

			//Se verifica si se trata de hacer fuerza bruta en el ingreso
			if (checkbrute($Rut, $email, $IP_Client, 'clientes_checkbrute', $dbConn) == true) {
				$error['checkbrute']  = 'error/Demasiados accesos fallidos, usuario bloqueado por 2 horas';
			}

			//si no hay errores
			if(empty($error)){

				//Busco al usuario en el sistema
				$SIS_query = '
				clientes_listado.idCliente,
				clientes_listado.password,
				clientes_listado.Rut,
				clientes_listado.Nombre,
				clientes_listado.idEstado,
				clientes_listado.idSistema,
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
				$rowUser = db_select_data (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, 'rowUser', $original, $form_trabajo);

				//Se verifca si los datos ingresados son de un usuario
				if (isset($rowUser['idCliente'])&&$rowUser['idCliente']!='') {

					//Verifico que el usuario identificado este activo
					if($rowUser['idEstado']==1){

						/***************************************************************/
						//Actualizo la tabla de los usuarios
						$a = 'Ultimo_acceso="'.$fecha.'", IP_Client="'.$IP_Client.'", Agent_Transp="'.$Agent_Transp.'"';
						$resultado = db_update_data (false, $a, 'clientes_listado', 'idCliente = "'.$rowUser['idCliente'].'"', $dbConn, 'Ultimo_acceso', $original, $form_trabajo);

						//busca si la ip del usuario ya existe
						$n_ip = db_select_nrows (false, 'idIpUsuario', 'clientes_listado_ip', '', "IP_Client='".$IP_Client."' AND idCliente='".$rowUser['idCliente']."'", $dbConn, 'clientes_listado_ip', $original, $form_trabajo);
						//si la ip no existe la guarda
						if(isset($n_ip)&&$n_ip==0){
							if(isset($rowUser['idCliente']) && $rowUser['idCliente']!=''){  $SIS_data  = "'".$rowUser['idCliente']."'";  }else{$SIS_data  = "''";}
							if(isset($IP_Client) && $IP_Client!=''){                        $SIS_data .= ",'".$IP_Client."'";            }else{$SIS_data .= ",''";}
							if(isset($fecha) && $fecha!=''){                                $SIS_data .= ",'".$fecha."'";                }else{$SIS_data .= ",''";}
							if(isset($hora) && $hora!=''){                                  $SIS_data .= ",'".$hora."'";                 }else{$SIS_data .= ",''";}

							$SIS_columns = 'idCliente,IP_Client, Fecha, Hora';
							$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'clientes_listado_ip', $dbConn, 'clientes_listado_ip', $original, $form_trabajo);

						}

						/**************************************************************/
						//Inserto la fecha con el ingreso
						if(isset($rowUser['idCliente']) && $rowUser['idCliente']!=''){  $SIS_data  = "'".$rowUser['idCliente']."'";  }else{$SIS_data  = "''";}
						if(isset($fecha) && $fecha!=''){                                $SIS_data .= ",'".$fecha."'";                }else{$SIS_data .= ",''";}
						if(isset($hora) && $hora!=''){                                  $SIS_data .= ",'".$hora."'";                 }else{$SIS_data .= ",''";}
						if(isset($IP_Client) && $IP_Client!=''){                        $SIS_data .= ",'".$IP_Client."'";            }else{$SIS_data .= ",''";}
						if(isset($Agent_Transp) && $Agent_Transp!=''){                  $SIS_data .= ",'".$Agent_Transp."'";         }else{$SIS_data .= ",''";}

						// inserto los datos de registro en la db
						$SIS_columns = 'idCliente,Fecha, Hora, IP_Client, Agent_Transp';
						$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'clientes_accesos', $dbConn, 'clientes_accesos', $original, $form_trabajo);

						//Si ejecuto correctamente la consulta
						if($ultimo_id!=0){
							//Se crean las variables con todos los datos
							$_SESSION['usuario']['basic_data']['idCliente']          = $rowUser['idCliente'];
							$_SESSION['usuario']['basic_data']['password']           = $rowUser['password'];
							$_SESSION['usuario']['basic_data']['Nombre']             = DeSanitizar($rowUser['Nombre']);
							$_SESSION['usuario']['basic_data']['Rut']                = $rowUser['Rut'];
							$_SESSION['usuario']['basic_data']['idSistema']          = $rowUser['idSistema'];
							$_SESSION['usuario']['basic_data']['Config_idTheme']     = $rowUser['Config_idTheme'];
							$_SESSION['usuario']['basic_data']['Config_imgLogo']     = $rowUser['Config_imgLogo'];
							$_SESSION['usuario']['basic_data']['Config_IDGoogle']    = $rowUser['Config_IDGoogle'];
							$_SESSION['usuario']['basic_data']['Region']             = DeSanitizar($rowUser['nombre_region']);
							$_SESSION['usuario']['basic_data']['Pronostico']         = $rowUser['nombre_pronostico'];
							$_SESSION['usuario']['basic_data']['Comuna']             = DeSanitizar($rowUser['nombre_comuna']);
							$_SESSION['usuario']['basic_data']['Social_idUso']       = $rowUser['Social_idUso'];
							$_SESSION['usuario']['basic_data']['Social_facebook']    = $rowUser['Social_facebook'];
							$_SESSION['usuario']['basic_data']['Social_twitter']     = $rowUser['Social_twitter'];
							$_SESSION['usuario']['basic_data']['Social_instagram']   = $rowUser['Social_instagram'];
							$_SESSION['usuario']['basic_data']['Social_linkedin']    = $rowUser['Social_linkedin'];
							$_SESSION['usuario']['basic_data']['Social_rss']         = $rowUser['Social_rss'];
							$_SESSION['usuario']['basic_data']['Social_youtube']     = $rowUser['Social_youtube'];
							$_SESSION['usuario']['basic_data']['Social_tumblr']      = $rowUser['Social_tumblr'];

							/****************************************************************/
							//Redirijo a la pagina principal si ya tiene todo configurado
							header( 'Location: principal.php' );
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
					if(isset($fecha) && $fecha!=''){                $SIS_data  = "'".$fecha."'";         }else{$SIS_data  = "''";}
					if(isset($hora) && $hora!=''){                  $SIS_data .= ",'".$hora."'";         }else{$SIS_data .= ",''";}
					if(isset($Rut) && $Rut!=''){                    $SIS_data .= ",'".$Rut."'";          }else{$SIS_data .= ",''";}
					if(isset($email) && $email!=''){                $SIS_data .= ",'".$email."'";        }else{$SIS_data .= ",''";}
					if(isset($IP_Client) && $IP_Client!=''){        $SIS_data .= ",'".$IP_Client."'";    }else{$SIS_data .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp!=''){  $SIS_data .= ",'".$Agent_Transp."'"; }else{$SIS_data .= ",''";}
					if(isset($Time) && $Time!=''){                  $SIS_data .= ",'".$Time."'";         }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'clientes_checkbrute', $dbConn, 'clientes_checkbrute', $original, $form_trabajo);

					//Cuento los accesos erroneos
					$NAccesos = db_select_nrows (false, 'idAcceso', 'clientes_checkbrute', '', "(usuario='".$Rut."' OR email='".$email."' OR IP_Client='".$IP_Client."') AND Fecha='".fecha_actual()."'", $dbConn, 'productores_checkbrute', $original, $form_trabajo);

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
			if(empty($error)){

				//traigo los datos almacenados
				$SIS_query = '
				clientes_listado.idCliente,
				clientes_listado.email,
				clientes_listado.Nombre,
				core_sistemas.Nombre AS RazonSocial,
				core_sistemas.email_principal,
				core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario,
				core_sistemas.Config_Gmail_Password AS Gmail_Password';
				$SIS_join = 'LEFT JOIN `core_sistemas` ON core_sistemas.idSistema = clientes_listado.idSistema';
				$SIS_where = 'clientes_listado.email="'.$email.'"';
				$cuenta_registros  = db_select_nrows (false, $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, 'cuenta_registros', $original, $form_trabajo);

				//verifico si los datos ingresados son iguales a los almacenados
				if(isset($cuenta_registros)&&$cuenta_registros!=''&&$cuenta_registros!=0){

					/*******************************************************/
					//traigo los datos almacenados
					$rowUsr = db_select_data (false,  $SIS_query, 'clientes_listado', $SIS_join, $SIS_where, $dbConn, 'rowUsr', $original, $form_trabajo);

					/*******************************************************/
					//Generacion de nueva clave
					$num_caracteres = "10";                                  //cantidad de caracteres de la clave
					$clave          = substr(md5(rand()),0,$num_caracteres); //generador aleatorio de claves
					$nueva_clave    = md5($clave);                           //se codifica la clave

					/*******************************************************/
					//Actualizacion de la clave en la base de datos
					$SIS_data  = 'password="'.$nueva_clave.'"';
					$resultado = db_update_data (false, $SIS_data, 'clientes_listado', 'idCliente = "'.$rowUsr['idCliente'].'"', $dbConn, 'clientes_listado', $original, $form_trabajo);

					/*******************************************************/
					//Cuerpo del correo
					$Body = '<p>Se ha generado una nueva contraseña para el usuario '.$rowUsr['email'].', su nueva contraseña es: '.$nueva_clave.'</p>';

					/*******************************************************/
					//Envio de correo
					$rmail = tareas_envio_correo($rowusr['email_principal'], $rowusr['RazonSocial'],
												 $rowUsr['email'], $rowUsr['Nombre'],
												 '', '',
												 'Cambio de password',
												 $Body,'',
												 '',
												 1,
												 $rowusr['Gmail_Usuario'],
												 $rowusr['Gmail_Password']);
                    //se guarda el log
					log_response(1, $rmail, $rowUsr['email'].' (Asunto:Cambio de password)');
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
					if(isset($fecha) && $fecha!=''){                $SIS_data  = "'".$fecha."'";         }else{$SIS_data  = "''";}
					if(isset($hora) && $hora!=''){                  $SIS_data .= ",'".$hora."'";         }else{$SIS_data .= ",''";}
					if(isset($Rut) && $Rut!=''){                    $SIS_data .= ",'".$Rut."'";          }else{$SIS_data .= ",''";}
					if(isset($email) && $email!=''){                $SIS_data .= ",'".$email."'";        }else{$SIS_data .= ",''";}
					if(isset($IP_Client) && $IP_Client!=''){        $SIS_data .= ",'".$IP_Client."'";    }else{$SIS_data .= ",''";}
					if(isset($Agent_Transp) && $Agent_Transp!=''){  $SIS_data .= ",'".$Agent_Transp."'"; }else{$SIS_data .= ",''";}
					if(isset($Time) && $Time!=''){                  $SIS_data .= ",'".$Time."'";         }else{$SIS_data .= ",''";}

					// inserto los datos de registro en la db
					$SIS_columns = 'Fecha, Hora, usuario, email, IP_Client, Agent_Transp, Time';
					$ultimo_id = db_insert_data (false, $SIS_columns, $SIS_data, 'clientes_checkbrute', $dbConn, 'clientes_checkbrute', $original, $form_trabajo);

				}

			}

		break;
/*******************************************************************************************************************/
	}

?>

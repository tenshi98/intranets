<?php
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
//variables
$sesion_usuario          = 'Ninguno';
$sesion_password         = 'Ninguna';
$sesion_fecha            = fecha_actual();
$sesion_hora             = hora_actual();
$sesion_IP_Client        = obtenerIpCliente();
$sesion_Agent_Transp     = obtenerSistOperativo().' - '.obtenerNavegador();
$sesion_Empresa          = DB_SOFT_NAME;
$sesion_N_Hacks          = 5;
$sesion_archivo          = 'Ninguno';
$sesion_tarea            = 'Ninguna';
$sesion_Activa           = 0;
$hackeo                  = 0;
//verifico si tiene sesion activa
if(isset($_SESSION['usuario']['basic_data']['Rut'])&&$_SESSION['usuario']['basic_data']['Rut']!=''){
	$sesion_usuario = $_SESSION['usuario']['basic_data']['Rut'];
	$sesion_Activa++;
}
if(isset($_SESSION['usuario']['basic_data']['password'])&&$_SESSION['usuario']['basic_data']['password']!=''){
	$sesion_password = $_SESSION['usuario']['basic_data']['password'];
	$sesion_Activa++;
}
//Verifico desde donde viene si es que existe
if(isset($original)&&$original!=''){         $sesion_archivo  = $original;}
//verifico la tarea si es que existe
if(isset($form_trabajo)&&$form_trabajo!=''){ $sesion_tarea    = $form_trabajo;}

/****************************************************************/
//Verifico la existencia de la ip del atacante
if(isset($sesion_IP_Client)&&$sesion_IP_Client!=''){

	/****************************************/
	//si hay sesion activa
	if($sesion_Activa!=0){
		//se consulta la base de datos
		$rowUserId = db_select_nrows (false, 'idCliente','clientes_listado', '', 'Rut = "'.$sesion_usuario.'" AND password = "'.$sesion_password.'"', $dbConn, 'Ninguno', basename($_SERVER["REQUEST_URI"], ".php"), 'rowUserId');
		//Se verifca si los datos ingresados son de un usuario registrado
		if (isset($rowUserId)&&$rowUserId!=''&&$rowUserId!=0) {
			//Si existe no se hace nada
		//Si no existe es una entrada forzada
		}else{
			$hackeo++;
		}
	//Si no hay sesion activa
	}else{
		//se consulta la base de datos
		$rowUserIP = db_select_nrows (false, 'idIpUsuario','clientes_listado_ip', '', 'IP_Client = "'.$sesion_IP_Client.'"', $dbConn, 'Ninguno', basename($_SERVER["REQUEST_URI"], ".php"), 'rowUserIP');
		//Se verifca si la ip entrante es de un usuario registrado
		if (isset($rowUserIP)&&$rowUserIP!=''&&$rowUserIP!=0) {
			//Si existe no se hace nada
		//Si no existe se verifican datos
		}else{
			//si inicia sesion, solicita contraseña o se esta registrando
			if ( (!empty($_POST['submit_login'])) OR (!empty($_POST['submit_pass'])) OR (!empty($_POST['submit_register']))){
				//No se hace nada
			//es un acceso forzado
			}else{
				$hackeo++;
			}
		}
	}

	/****************************************/
	//si hay hackeo
	if($hackeo!=0){
		//obtengo la cantidad de veces de intento de hackeo
		$n_hackeos = db_select_nrows (false, 'idHacking', 'sistema_seguridad_hacking', '', "IP_Client='".$sesion_IP_Client."' OR usuario='".$sesion_usuario."'", $dbConn, 'Ninguno', basename($_SERVER["REQUEST_URI"], ".php"), 'n_hackeos ');
		//si ya hay demasiados intentos de hackeo
		if($n_hackeos>=$sesion_N_Hacks){
			//Se borra todos los datos relacionados a las sesiones
			session_unset();
			session_destroy();
			//redirijo a la pagina index
			//header( 'Location: index.php' );
			//die;
		//verifico el numero de intentos de hackeo y guardo el dato
		}elseif($n_hackeos<$sesion_N_Hacks){
			//filtros
			if(isset($sesion_fecha) && $sesion_fecha!=''){                $a  = "'".$sesion_fecha."'";           }else{$a  = "''";}
			if(isset($sesion_hora) && $sesion_hora!=''){                  $a .= ",'".$sesion_hora."'";           }else{$a .= ",''";}
			if(isset($sesion_IP_Client) && $sesion_IP_Client!=''){        $a .= ",'".$sesion_IP_Client."'";      }else{$a .= ",''";}
			if(isset($sesion_Agent_Transp) && $sesion_Agent_Transp!=''){  $a .= ",'".$sesion_Agent_Transp."'";   }else{$a .= ",''";}
			if(isset($sesion_usuario) && $sesion_usuario!=''){            $a .= ",'".$sesion_usuario."'";        }else{$a .= ",''";}

			// inserto los datos de registro en la db
			$query  = "INSERT INTO `sistema_seguridad_hacking` (Fecha, Hora, IP_Client, Agent_Transp, usuario) 
			VALUES (".$a.")";
			//Consulta
			$resultado = mysqli_query ($dbConn, $query);
		}

		/****************************************************************/
		//Cuerpo del log
		$rmail         = '';
		$sesion_texto  = '';
		$sesion_texto .= $sesion_IP_Client;
		$sesion_texto .= ' - '.fecha_estandar($sesion_fecha);
		$sesion_texto .= ' - '.$sesion_hora;
		$sesion_texto .= ' - '.$sesion_Empresa;
		$sesion_texto .= ' - '.$sesion_Agent_Transp;
		$sesion_texto .= ' - '.$sesion_usuario;
		$sesion_texto .= ' - '.$sesion_archivo;
		$sesion_texto .= ' - '.$sesion_tarea;

		//se guarda el log
		log_response(4, $rmail, $sesion_texto);

		//Se detiene la ejecucion
		die('No tienes acceso a esta carpeta o archivo (Access Code 1007-001).');
	}
//si no hay IP igual lo saco del sistema
}else{
	//Se borra todos los datos relacionados a las sesiones
	session_unset();
	session_destroy();

	//Se detiene la ejecucion
	die('No tienes acceso a esta carpeta o archivo (Access Code 1007-002).');
}

?>

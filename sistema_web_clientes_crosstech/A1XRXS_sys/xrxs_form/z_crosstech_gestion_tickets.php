<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridTicketad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')){
    die('No tienes acceso a esta carpeta o archivo (Access Code 1009-002).');
}
/*******************************************************************************************************************/
/*                                          Verifica si la Sesion esta activa                                      */
/*******************************************************************************************************************/
require_once '0_validate_user_1.php';
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if (!empty($_POST['idTicket']))                $idTicket                 = $_POST['idTicket'];
	if (!empty($_POST['idSistema']))               $idSistema                = $_POST['idSistema'];
	if (!empty($_POST['idCliente']))               $idCliente                = $_POST['idCliente'];
	if (!empty($_POST['idTipoTicket']))            $idTipoTicket             = $_POST['idTipoTicket'];
	if (!empty($_POST['Titulo']))                  $Titulo                   = $_POST['Titulo'];
	if (!empty($_POST['Descripcion']))             $Descripcion              = $_POST['Descripcion'];
	if (!empty($_POST['idEstado']))                $idEstado                 = $_POST['idEstado'];
	if (!empty($_POST['idPrioridad']))             $idPrioridad              = $_POST['idPrioridad'];
	if (!empty($_POST['FechaCreacion']))           $FechaCreacion            = $_POST['FechaCreacion'];
	if (!empty($_POST['FechaCierre']))             $FechaCierre              = $_POST['FechaCierre'];
	if (!empty($_POST['idUsuarioAsignado']))       $idUsuarioAsignado        = $_POST['idUsuarioAsignado'];
	if (!empty($_POST['idArea']))                  $idArea                   = $_POST['idArea'];
	if (!empty($_POST['DescripcionCierre']))       $DescripcionCierre        = $_POST['DescripcionCierre'];
	if (!empty($_POST['FechaCancelacion']))        $FechaCancelacion         = $_POST['FechaCancelacion'];
	if (!empty($_POST['DescripcionCancelacion']))  $DescripcionCancelacion   = $_POST['DescripcionCancelacion'];

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
			case 'idTicket':                if(empty($idTicket)){                 $error['idTicket']                 = 'error/No ha ingresado el id';}break;
			case 'idSistema':               if(empty($idSistema)){                $error['idSistema']                = 'error/No ha seleccionado el sistema';}break;
			case 'idCliente':               if(empty($idCliente)){                $error['idCliente']                = 'error/No ha seleccionado el cliente';}break;
			case 'idTipoTicket':            if(empty($idTipoTicket)){             $error['idTipoTicket']             = 'error/No ha seleccionado el tipo de ticket';}break;
			case 'Titulo':                  if(empty($Titulo)){                   $error['Titulo']                   = 'error/No ha ingresado el titulo';}break;
			case 'Descripcion':             if(empty($Descripcion)){              $error['Descripcion']              = 'error/No ha ingresado la descripcion del ticket';}break;
			case 'idEstado':                if(empty($idEstado)){                 $error['idEstado']                 = 'error/No ha seleccionado el estado';}break;
			case 'idPrioridad':             if(empty($idPrioridad)){              $error['idPrioridad']              = 'error/No ha seleccionado la prioridad';}break;
			case 'FechaCreacion':           if(empty($FechaCreacion)){            $error['FechaCreacion']            = 'error/No ha ingresado la fecha de creación';}break;
			case 'FechaCierre':             if(empty($FechaCierre)){              $error['FechaCierre']              = 'error/No ha ingresado la fecha de cierre';}break;
			case 'idUsuarioAsignado':       if(empty($idUsuarioAsignado)){        $error['idUsuarioAsignado']        = 'error/No ha seleccionado el usuario asignado';}break;
			case 'idArea':                  if(empty($idArea)){                   $error['idArea']                   = 'error/No ha seleccionado el area';}break;
			case 'DescripcionCierre':       if(empty($DescripcionCierre)){        $error['DescripcionCierre']        = 'error/No ha ingresado la descripcion de cierre del ticket';}break;
			case 'FechaCancelacion':        if(empty($FechaCancelacion)){         $error['FechaCancelacion']         = 'error/No ha ingresado la fecha de cancelacion';}break;
			case 'DescripcionCancelacion':  if(empty($DescripcionCancelacion)){   $error['DescripcionCancelacion']   = 'error/No ha ingresado la descripcion de cancelacion del ticket';}break;

		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/
	if(isset($Titulo)&&contar_palabras_censuradas($Titulo)!=0){                                  $error['Titulo']                  = 'error/Edita Titulo, contiene palabras no permitidas';}
	if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){                        $error['Descripcion']             = 'error/Edita Descripcion, contiene palabras no permitidas';}
	if(isset($DescripcionCierre)&&contar_palabras_censuradas($DescripcionCierre)!=0){            $error['DescripcionCierre']       = 'error/Edita Descripcion Cierre, contiene palabras no permitidas';}
	if(isset($DescripcionCancelacion)&&contar_palabras_censuradas($DescripcionCancelacion)!=0){  $error['DescripcionCancelacion']  = 'error/Edita Descripcion Cancelacion, contiene palabras no permitidas';}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			//Si no hay errores ejecuto el codigo
			if(empty($error)){

				//filtros
				if(isset($idSistema) && $idSistema!=''){           $a  = "'".$idSistema."'";                }else{$a  = "''";}
				if(isset($idCliente) && $idCliente!=''){                             $a .= ",'".$idCliente."'";               }else{$a .= ",''";}
				if(isset($idTipoTicket) && $idTipoTicket!=''){                       $a .= ",'".$idTipoTicket."'";            }else{$a .= ",''";}
				if(isset($Titulo) && $Titulo!=''){                                   $a .= ",'".$Titulo."'";                  }else{$a .= ",''";}
				if(isset($Descripcion) && $Descripcion!=''){                         $a .= ",'".$Descripcion."'";             }else{$a .= ",''";}
				if(isset($idEstado) && $idEstado!=''){                              $a .= ",'".$idEstado."'";                }else{$a .= ",''";}
				if(isset($idPrioridad) && $idPrioridad!=''){                        $a .= ",'".$idPrioridad."'";             }else{$a .= ",''";}
				if(isset($FechaCreacion) && $FechaCreacion!=''){                     $a .= ",'".$FechaCreacion."'";           }else{$a .= ",''";}
				if(isset($FechaCierre) && $FechaCierre!=''){                         $a .= ",'".$FechaCierre."'";             }else{$a .= ",''";}
				if(isset($idUsuarioAsignado) && $idUsuarioAsignado!=''){             $a .= ",'".$idUsuarioAsignado."'";       }else{$a .= ",''";}
				if(isset($idArea) && $idArea!=''){                                   $a .= ",'".$idArea."'";                  }else{$a .= ",''";}
				if(isset($DescripcionCierre) && $DescripcionCierre!=''){             $a .= ",'".$DescripcionCierre."'";       }else{$a .= ",''";}
				if(isset($FechaCancelacion) && $FechaCancelacion!=''){               $a .= ",'".$FechaCancelacion."'";        }else{$a .= ",''";}
				if(isset($DescripcionCancelacion) && $DescripcionCancelacion!=''){   $a .= ",'".$DescripcionCancelacion."'";  }else{$a .= ",''";}

				// inserto los datos de registro en la db
				$query  = "INSERT INTO `crosstech_gestion_tickets` (idSistema, idCliente, 
				idTipoTicket, Titulo, Descripcion, idEstado, idPrioridad, FechaCreacion, 
				FechaCierre, idUsuarioAsignado, idArea, DescripcionCierre, FechaCancelacion,
				DescripcionCancelacion) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if($resultado){
					//solo se envian los tickets
					if(isset($idTipoTicket) && $idTipoTicket == 1){

						//recibo el último id generado por mi sesion
						$ultimo_id = mysqli_insert_id($dbConn);

						/*********************************************************************/
						//receptores
						$SIS_query = 'crosstech_gestion_tickets_area_correos.idUsuario,
						usuarios_listado.Nombre AS UsuarioNombre,
						usuarios_listado.email AS UsuarioEmail';
						$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = crosstech_gestion_tickets_area_correos.idUsuario';
						$SIS_where = 'crosstech_gestion_tickets_area_correos.idArea ='.$idArea;
						$SIS_order = 'crosstech_gestion_tickets_area_correos.idUsuario ASC';
						$arrUsuario = array();
						$arrUsuario = db_select_array (false, $SIS_query, 'crosstech_gestion_tickets_area_correos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//datos empresa
						$SIS_query = '
						core_sistemas.Nombre AS EmpresaNombre,
						core_sistemas.email_principal AS EmpresaEmail,
						core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario,
						core_sistemas.Config_Gmail_Password AS Gmail_Password';
						$SIS_where = 'core_sistemas.idSistema ='.$idSistema;
						$rowEmpresa = db_select_data (false, $SIS_query, 'core_sistemas','', $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Prioridad
						$rowPrioridad = db_select_data (false, 'Nombre', 'core_ot_prioridad', '', 'idPrioridad='.$idPrioridad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Area
						$rowArea = db_select_data (false, 'Nombre', 'crosstech_gestion_tickets_area', '', 'idArea='.$idArea, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//Cliente
						$rowCliente = db_select_data (false, 'Nombre,RazonSocial,email', 'clientes_listado', '', 'idCliente='.$idCliente, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						/*********************************************************************/
						//Se crea el cuerpodel correo al cliente
						$BodyMail_Cliente  = '<div style="background-color: #D9D9D9; padding: 10px;">';
						$BodyMail_Cliente .= '<img src="http://clientes.simplytech.cl/img/login_logo.png" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
						$BodyMail_Cliente .= '<h3 style="text-align: center;font-size: 30px;">';
						$BodyMail_Cliente .= '¡Ticket generado exitosamente!<br/>';
						$BodyMail_Cliente .= 'N° '.n_doc($ultimo_id, 8);
						$BodyMail_Cliente .= '</h3>';
						$BodyMail_Cliente .= '<p style="text-align: center;font-size: 20px;">';
						$BodyMail_Cliente .= '<strong>Fecha: </strong>'.fecha_estandar($FechaCreacion).'<br/>';
						$BodyMail_Cliente .= '<strong>Motivo: </strong>'.$rowArea['Nombre'].'<br/>';
						$BodyMail_Cliente .= '<strong>Prioridad: </strong>'.$rowPrioridad['Nombre'].'<br/>';
						$BodyMail_Cliente .= '</p>';
						$BodyMail_Cliente .= '<a href="'.DB_SITE_MAIN.'/gestion_tickets.php?pagina=1" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Ver Ticket &#8594;</strong></a>';
						$BodyMail_Cliente .= '<br/>';
						$BodyMail_Cliente .= '<br/>';
						$BodyMail_Cliente .= '<br/>';
						$BodyMail_Cliente .= '<p style="text-align: left;font-size: 14px;">Este correo se ha enviado automáticamente, no responder.</p>';
						$BodyMail_Cliente .= '</div>';

						//Se crea el cuerpo del correo al usuario
						$BodyMail_Usuario  = '<div style="background-color: #D9D9D9; padding: 10px;">';
						$BodyMail_Usuario .= '<img src="http://clientes.simplytech.cl/img/login_logo.png" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
						$BodyMail_Usuario .= '<h3 style="text-align: center;font-size: 30px;">';
						$BodyMail_Usuario .= '¡Nuevo ticket de '.$rowCliente['Nombre'].'!<br/>';
						$BodyMail_Usuario .= 'N° '.n_doc($ultimo_id, 8);
						$BodyMail_Usuario .= '</h3>';
						$BodyMail_Usuario .= '<p style="text-align: center;font-size: 20px;">';
						$BodyMail_Usuario .= '<strong>Fecha: </strong>'.fecha_estandar($FechaCreacion).'<br/>';
						$BodyMail_Usuario .= '<strong>Motivo: </strong>'.$rowArea['Nombre'].'<br/>';
						$BodyMail_Usuario .= '<strong>Titulo: </strong>'.$Titulo.'<br/>';
						$BodyMail_Usuario .= '<strong>Prioridad: </strong>'.$rowPrioridad['Nombre'].'<br/>';
						$BodyMail_Usuario .= '</p>';
						$BodyMail_Usuario .= '<a href="'.DB_SITE_ALT_1.'/crosstech_gestion_tickets_abiertos.php?pagina=1" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Ver Ticket &#8594;</strong></a>';
						$BodyMail_Usuario .= '<br/>';
						$BodyMail_Usuario .= '<br/>';
						$BodyMail_Usuario .= '<br/>';
						$BodyMail_Usuario .= '<p style="text-align: left;font-size: 14px;">Este correo se ha enviado automáticamente, no responder.</p>';
						$BodyMail_Usuario .= '</div>';
						//resto de datos
						$Notificacion   = '<div class= "btn-group" ><a href= "view_crosstech_gestion_tickets.php?view='.$ultimo_id.'" title= "Ver Información" class= "iframe btn btn-primary btn-sm tooltip"><i class= "fa fa-list"></i></a></div>';
						$Notificacion  .= ' Nuevo Ticket N°'.n_doc($ultimo_id, 8).' de '.$rowCliente['Nombre'].' generado';
						$Creacion_fecha = fecha_actual();
						$Estado         = '1';

						/*********************************************************************/
						//Se envia mensaje al cliente
						if(isset($rowEmpresa['EmpresaEmail'], $rowCliente['email'])&&$rowEmpresa['EmpresaEmail']!=''&&$rowCliente['email']!=''){
							$rmail = tareas_envio_correo($rowEmpresa['EmpresaEmail'], $rowEmpresa['EmpresaNombre'], 
														$rowCliente['email'], $rowCliente['Nombre'], 
														'', '', 
														'Confirmación de emisión de ticket N°'.n_doc($ultimo_id, 8), 
														$BodyMail_Cliente,'', 
														'', 
														1, 
														$rowEmpresa['Gmail_Usuario'], 
														$rowEmpresa['Gmail_Password']);
							//se guarda el log
							log_response(1, $rmail, $rowCliente['email'].' (Asunto:Confirmación de emisión de ticket N°'.n_doc($ultimo_id, 8).')');

						}

						/*********************************************************************/
						//Se envia mensaje a los usuarios relacionados al area
						if(isset($arrUsuario)){	
							foreach($arrUsuario as $usuario) {

								/***********************************************/
								if(isset($idSistema) && $idSistema!=''){       $a  = "'".$idSistema."'";               }else{$a  = "''";}
								if(isset($usuario['idUsuario']) && $usuario['idUsuario']!=''){   $a .= ",'".$usuario['idUsuario']."'";   }else{$a .= ",''";}
								if(isset($Notificacion) && $Notificacion!=''){                   $a .= ",'".$Notificacion."'";           }else{$a .= ",''";}
								if(isset($Creacion_fecha) && $Creacion_fecha!=''){               $a .= ",'".$Creacion_fecha."'";         }else{$a .= ",''";}
								if(isset($Estado) && $Estado!=''){                               $a .= ",'".$Estado."'";                 }else{$a .= ",''";}
								$a .= ",'".hora_actual()."'";

								// inserto los datos de registro en la db
								$query  = "INSERT INTO `principal_notificaciones_ver` (idSistema,idUsuario,Notificacion, Fecha, idEstado, Hora) 
								VALUES (".$a.")";
								//Consulta
								$resultado = mysqli_query ($dbConn, $query);
								//Si ejecuto correctamente la consulta
								if(!$resultado){
									//Genero numero aleatorio
									$vardata = genera_password(8,'alfanumerico');

									//Guardo el error en una variable temporal
									$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
									$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
									$_SESSION['ErrorListing'][$vardata]['query']        = $query;

								}

								/***********************************************/
								//Se verifica que existan datos
								if(isset($rowEmpresa['EmpresaEmail'])&&$rowEmpresa['EmpresaEmail']!=''&&isset($usuario['UsuarioEmail'])&&$usuario['UsuarioEmail']!=''){
									$rmail = tareas_envio_correo($rowEmpresa['EmpresaEmail'], $rowEmpresa['EmpresaNombre'], 
																$usuario['UsuarioEmail'], $usuario['UsuarioNombre'], 
																'', '', 
																'Nuevo Ticket N°'.n_doc($ultimo_id, 8).' de '.$rowCliente['Nombre'].' generado', 
																$BodyMail_Usuario,'', 
																'', 
																1, 
																$rowEmpresa['Gmail_Usuario'], 
																$rowEmpresa['Gmail_Password']);
									//se guarda el log
									log_response(1, $rmail, $usuario['UsuarioEmail'].' (Asunto:Nuevo Ticket N°'.n_doc($ultimo_id, 8).' de '.$rowCliente['Nombre'].' generado)');
								}
							}
						}
					}

					//se redirecciona
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

			//Si no hay errores ejecuto el codigo
			if(empty($error)){
				//Filtros
				$a = "idTicket='".$idTicket."'";
				if(isset($idSistema) && $idSistema!=''){           $a .= ",idSistema='".$idSistema."'";}
				if(isset($idCliente) && $idCliente!=''){                             $a .= ",idCliente='".$idCliente."'";}
				if(isset($idTipoTicket) && $idTipoTicket!=''){                       $a .= ",idTipoTicket='".$idTipoTicket."'";}
				if(isset($Titulo) && $Titulo!=''){                                   $a .= ",Titulo='".$Titulo."'";}
				if(isset($Descripcion) && $Descripcion!=''){                         $a .= ",Descripcion='".$Descripcion."'";}
				if(isset($idEstado) && $idEstado!=''){                              $a .= ",idEstado='".$idEstado."'";}
				if(isset($idPrioridad) && $idPrioridad!=''){                        $a .= ",idPrioridad='".$idPrioridad."'";}
				if(isset($FechaCreacion) && $FechaCreacion!=''){                     $a .= ",FechaCreacion='".$FechaCreacion."'";}
				if(isset($FechaCierre) && $FechaCierre!=''){                         $a .= ",FechaCierre='".$FechaCierre."'";}
				if(isset($idUsuarioAsignado) && $idUsuarioAsignado!=''){             $a .= ",idUsuarioAsignado='".$idUsuarioAsignado."'";}
				if(isset($idArea) && $idArea!=''){                                   $a .= ",idArea='".$idArea."'";}
				if(isset($DescripcionCierre) && $DescripcionCierre!=''){             $a .= ",DescripcionCierre='".$DescripcionCierre."'";}
				if(isset($FechaCancelacion) && $FechaCancelacion!=''){               $a .= ",FechaCancelacion='".$FechaCancelacion."'";}
				if(isset($DescripcionCancelacion) && $DescripcionCancelacion!=''){   $a .= ",DescripcionCancelacion='".$DescripcionCancelacion."'";}

				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'crosstech_gestion_tickets', 'idTicket = "'.$idTicket.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){

					/*********************************************************************/
					//Ticket
					$SIS_query = '
					crosstech_gestion_tickets.idTipoTicket,
					crosstech_gestion_tickets.idArea,
					crosstech_gestion_tickets.idSistema,
					crosstech_gestion_tickets.idEstado,
					crosstech_gestion_tickets.idCliente,
					crosstech_gestion_tickets.FechaCreacion,
					crosstech_gestion_tickets.Titulo,
					crosstech_gestion_tickets.FechaCierre,
					crosstech_gestion_tickets.DescripcionCierre,
					crosstech_gestion_tickets.FechaCancelacion,
					crosstech_gestion_tickets.DescripcionCancelacion,
					core_ot_prioridad.Nombre AS Prioridad,
					crosstech_gestion_tickets_area.Nombre AS Area,
					clientes_listado.Nombre AS ClienteNombre,
					clientes_listado.email AS ClienteEmail,
					core_sistemas.Nombre AS EmpresaNombre,
					core_sistemas.email_principal AS EmpresaEmail, 
					core_sistemas.Config_Gmail_Usuario AS Gmail_Usuario, 
					core_sistemas.Config_Gmail_Password AS Gmail_Password
					';
					$SIS_join  = '
					LEFT JOIN `core_ot_prioridad`              ON core_ot_prioridad.idPrioridad         = crosstech_gestion_tickets.idPrioridad
					LEFT JOIN `crosstech_gestion_tickets_area` ON crosstech_gestion_tickets_area.idArea = crosstech_gestion_tickets.idArea
					LEFT JOIN `clientes_listado`               ON clientes_listado.idCliente            = crosstech_gestion_tickets.idCliente
					LEFT JOIN `core_sistemas`                  ON core_sistemas.idSistema               = crosstech_gestion_tickets.idSistema';
					$SIS_where = 'crosstech_gestion_tickets.idTicket='.$idTicket;
					$rowTicket = db_select_data (false, $SIS_query, 'crosstech_gestion_tickets', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

					/****************************************/
					//variables
					$idTipoTicket             = $rowTicket['idTipoTicket'];
					$idArea	                  = $rowTicket['idArea'];
					$idSistema                = $rowTicket['idSistema'];
					$idEstado                 = $rowTicket['idEstado'];
					$idCliente                = $rowTicket['idCliente'];
					$FechaCreacion            = $rowTicket['FechaCreacion'];
					$Titulo                   = $rowTicket['Titulo'];
					$FechaCierre              = $rowTicket['FechaCierre'];
					$DescripcionCierre        = $rowTicket['DescripcionCierre'];
					$FechaCancelacion         = $rowTicket['FechaCancelacion'];
					$DescripcionCancelacion   = $rowTicket['DescripcionCancelacion'];
					$Prioridad                = $rowTicket['Prioridad'];
					$Area                     = $rowTicket['Area'];
					$ClienteNombre            = $rowTicket['ClienteNombre'];
					$ClienteEmail             = $rowTicket['ClienteEmail'];
					$EmpresaNombre            = $rowTicket['EmpresaNombre'];
					$EmpresaEmail             = $rowTicket['EmpresaEmail'];
					$Gmail_Usuario            = $rowTicket['Gmail_Usuario'];
					$Gmail_Password           = $rowTicket['Gmail_Password'];

					//solo se envian los tickets
					if(isset($idTipoTicket) && $idTipoTicket == 1){

						/****************************************/
						//receptores
						$SIS_query = 'crosstech_gestion_tickets_area_correos.idUsuario,
						usuarios_listado.Nombre AS UsuarioNombre,
						usuarios_listado.email AS UsuarioEmail';
						$SIS_join  = 'LEFT JOIN `usuarios_listado` ON usuarios_listado.idUsuario = crosstech_gestion_tickets_area_correos.idUsuario';
						$SIS_where = 'crosstech_gestion_tickets_area_correos.idArea ='.$idArea;
						$SIS_order = 'crosstech_gestion_tickets_area_correos.idUsuario ASC';
						$arrUsuario = array();
						$arrUsuario = db_select_array (false, $SIS_query, 'crosstech_gestion_tickets_area_correos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

						//datos
						switch ($idEstado) {
							case 1: $Mensaje = 'Ticket N°'.n_doc($idTicket, 8).' Modificado'; $Detalles = '';                  $fMod = fecha_actual();     break;//Abierto
							case 2: $Mensaje = 'Ticket N°'.n_doc($idTicket, 8).' Cerrado';    $Detalles = $DescripcionCierre;       $fMod = $FechaCierre;       break;//Ejecutado
							case 3: $Mensaje = 'Ticket N°'.n_doc($idTicket, 8).' Cancelado';  $Detalles = $DescripcionCancelacion;  $fMod = $FechaCancelacion;  break;//Cancelado

						}

						/*********************************************************************/
						//Se crea el cuerpodel correo al cliente
						$BodyMail_top     = '<div style="background-color: #D9D9D9; padding: 10px;">';
						$BodyMail_top    .= '<img src="http://clientes.simplytech.cl/img/login_logo.png" style="width: 60%;display:block;margin-left: auto;margin-right: auto;margin-top:30px;margin-bottom:30px;">';
						$BodyMail_top    .= '<h3 style="text-align: center;font-size: 30px;">';
						$BodyMail_top    .= $Mensaje;
						$BodyMail_top    .= '</h3>';
						$BodyMail_top    .= '<p style="text-align: center;font-size: 20px;">';
						$BodyMail_top    .= '<strong>Fecha: </strong>'.fecha_estandar($fMod).'<br/>';
						$BodyMail_top    .= '<strong>Motivo: </strong>'.$Area.'<br/>';
						$BodyMail_top    .= '<strong>Titulo: </strong>'.$Titulo.'<br/>';
						$BodyMail_top    .= '<strong>Prioridad: </strong>'.$Prioridad.'<br/>';
						$BodyMail_top    .= '<strong>Detalles: </strong>'.$Detalles.'<br/>';
						$BodyMail_top    .= '</p>';
						$BodyMail_cliente = '<a href="'.DB_SITE_MAIN.'/gestion_tickets.php?pagina=1" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Ver Ticket &#8594;</strong></a>';
						$BodyMail_user    = '<a href="'.DB_SITE_ALT_1.'/crosstech_gestion_tickets_abiertos.php?pagina=1" style="display:block;width:100%;text-align: center;font-size: 20px;text-decoration: none;color: #004AAD;"><strong>Ver Ticket &#8594;</strong></a>';
						$BodyMail_bottom  = '<br/>';
						$BodyMail_bottom .= '<br/>';
						$BodyMail_bottom .= '<br/>';
						$BodyMail_bottom .= '<p style="text-align: left;font-size: 14px;">Este correo se ha enviado automáticamente, no responder.</p>';
						$BodyMail_bottom .= '</div>';

						//resto de datos
						$Notificacion  = '<div class= "btn-group" ><a href= "view_crosstech_gestion_tickets.php?view='.$ultimo_id.'" title= "Ver Información" class= "iframe btn btn-primary btn-sm tooltip"><i class= "fa fa-list"></i></a></div>';
						$Notificacion .= ' '.$Mensaje;
						$Creacion_fecha = fecha_actual();
						$Estado         = '1';

						/*********************************************************************/
						//Se envia mensaje al cliente
						if(isset($EmpresaEmail, $ClienteEmail)&&$EmpresaEmail!=''&&$ClienteEmail!=''){
							//construccion del cuerpo
							$BodyMail  = $BodyMail_top;
							$BodyMail .= $BodyMail_cliente;
							$BodyMail .= $BodyMail_bottom;
							//envio del correo
							$rmail = tareas_envio_correo($EmpresaEmail, $EmpresaNombre,
														$ClienteEmail, $ClienteNombre,
														'', '', 
														$Mensaje, 
														$BodyMail,'', 
														'', 
														1, 
														$Gmail_Usuario, 
														$Gmail_Password);
							//se guarda el log
							log_response(1, $rmail, $ClienteEmail.' (Asunto:'.$Mensaje.')');

						}

						/*********************************************************************/
						//Se envia mensaje a los usuarios relacionados al area
						if(isset($arrUsuario)){	
							foreach($arrUsuario as $usuario) {

								/***********************************************/
								if(isset($idSistema) && $idSistema!=''){       $a  = "'".$idSistema."'";               }else{$a  = "''";}
								if(isset($usuario['idUsuario']) && $usuario['idUsuario']!=''){   $a .= ",'".$usuario['idUsuario']."'";   }else{$a .= ",''";}
								if(isset($Notificacion) && $Notificacion!=''){                   $a .= ",'".$Notificacion."'";           }else{$a .= ",''";}
								if(isset($Creacion_fecha) && $Creacion_fecha!=''){               $a .= ",'".$Creacion_fecha."'";         }else{$a .= ",''";}
								if(isset($Estado) && $Estado!=''){                               $a .= ",'".$Estado."'";                 }else{$a .= ",''";}
								$a .= ",'".hora_actual()."'";

								// inserto los datos de registro en la db
								$query  = "INSERT INTO `principal_notificaciones_ver` (idSistema,idUsuario,Notificacion, Fecha, idEstado, Hora) 
								VALUES (".$a.")";
								//Consulta
								$resultado = mysqli_query ($dbConn, $query);
								//Si ejecuto correctamente la consulta
								if(!$resultado){
									//Genero numero aleatorio
									$vardata = genera_password(8,'alfanumerico');

									//Guardo el error en una variable temporal
									$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
									$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
									$_SESSION['ErrorListing'][$vardata]['query']        = $query;

								}

								/***********************************************/
								//Se verifica que existan datos
								if(isset($EmpresaEmail)&&$EmpresaEmail!=''&&isset($usuario['UsuarioEmail'])&&$usuario['UsuarioEmail']!=''){
									//construccion del cuerpo
									$BodyMail  = $BodyMail_top;
									$BodyMail .= $BodyMail_user;
									$BodyMail .= $BodyMail_bottom;
									//envio del correo
									$rmail = tareas_envio_correo($EmpresaEmail, $EmpresaNombre,
																$usuario['UsuarioEmail'], $usuario['UsuarioNombre'], 
																'', '', 
																$Mensaje, 
																$BodyMail,'', 
																'', 
																1, 
																$Gmail_Usuario, 
																$Gmail_Password);
									//se guarda el log
									log_response(1, $rmail, $usuario['UsuarioEmail'].' (Asunto:'.$Mensaje.')');
								}
							}
						}
					}

					//se redirecciona
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
				$error['validarNumero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero';
				$errorn++;
			}
			//Verifica si el numero recibido es un entero
			if (!validaEntero($indice)&&$indice!=''){
				$error['validaEntero'] = 'error/El valor ingresado en $indice ('.$indice.') en la opción DEL  no es un numero entero';
				$errorn++;
			}

			if($errorn==0){
				//se borran los datos
				$resultado = db_delete_data (false, 'crosstech_gestion_tickets', 'idTicket = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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

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
	if ( !empty($_POST['idHijos']) )                $idHijos              = $_POST['idHijos'];
	if ( !empty($_POST['idApoderado']) )            $idApoderado          = $_POST['idApoderado'];
	if ( !empty($_POST['Nombre']) )                 $Nombre               = $_POST['Nombre'];
	if ( !empty($_POST['ApellidoPat']) )            $ApellidoPat          = $_POST['ApellidoPat'];
	if ( !empty($_POST['ApellidoMat']) )            $ApellidoMat          = $_POST['ApellidoMat'];
	if ( !empty($_POST['idSexo']) )                 $idSexo               = $_POST['idSexo'];
	if ( !empty($_POST['FNacimiento']) )            $FNacimiento          = $_POST['FNacimiento'];
	if ( !empty($_POST['idPlan']) )                 $idPlan               = $_POST['idPlan'];
	if ( !empty($_POST['idVehiculo']) )             $idVehiculo           = $_POST['idVehiculo'];
	if ( !empty($_POST['idVehiculoTemp']) )         $idVehiculoTemp       = $_POST['idVehiculoTemp'];
	if ( !empty($_POST['idVehiculoVuelta']) )       $idVehiculoVuelta     = $_POST['idVehiculoVuelta'];
	if ( !empty($_POST['idVehiculoVueltaTemp']) )   $idVehiculoVueltaTemp = $_POST['idVehiculoVueltaTemp'];
	if ( !empty($_POST['Patente']) )                $Patente              = $_POST['Patente'];
	if ( !empty($_POST['idEstado']) )               $idEstado             = $_POST['idEstado'];
	
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
			case 'idHijos':               if(empty($idHijos)){              $error['idHijos']               = 'error/No ha ingresado el id';}break;
			case 'idApoderado':           if(empty($idApoderado)){          $error['idApoderado']           = 'error/No ha seleccionado el apoderado';}break;
			case 'Nombre':                if(empty($Nombre)){               $error['Nombre']                = 'error/No ha ingresado el nombre';}break;
			case 'ApellidoPat':           if(empty($ApellidoPat)){          $error['ApellidoPat']           = 'error/No ha ingresado el apellido paterno';}break;
			case 'ApellidoMat':           if(empty($ApellidoMat)){          $error['ApellidoMat']           = 'error/No ha ingresado el apellido materno';}break;
			case 'idSexo':                if(empty($idSexo)){               $error['idSexo']                = 'error/No ha seleccionado el sexo';}break;
			case 'FNacimiento':           if(empty($FNacimiento)){          $error['FNacimiento']           = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'idPlan':                if(empty($idPlan)){               $error['idPlan']                = 'error/No ha seleccionado el plan';}break;
			case 'idVehiculo':            if(empty($idVehiculo)){           $error['idVehiculo']            = 'error/No ha seleccionado el vehiculo ida';}break;
			case 'idVehiculoTemp':        if(empty($idVehiculoTemp)){       $error['idVehiculoTemp']        = 'error/No ha seleccionado el vehiculo';}break;
			case 'idVehiculoVuelta':      if(empty($idVehiculoVuelta)){     $error['idVehiculoVuelta']      = 'error/No ha seleccionado el vehiculo vuelta';}break;
			case 'idVehiculoVueltaTemp':  if(empty($idVehiculoVueltaTemp)){ $error['idVehiculoVueltaTemp']  = 'error/No ha seleccionado el vehiculo';}break;
			case 'Patente':               if(empty($Patente)){              $error['Patente']               = 'error/No ha ingresado la Patente del vehiculo';}break;
			case 'idEstado':              if(empty($idEstado)){             $error['idEstado']              = 'error/No ha seleccionado el estado';}break;
			
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
			
			//Modificacion de datos
			$Patente = str_replace(' ', '', $Patente);   //elimina espacios en blanco
			$Patente = strtolower($Patente);             //cambia a minusculas todo el texto
				
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'apoderados_listado_hijos', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Patente)){
				$ndata_2 = db_select_nrows (false, 'idVehiculo', 'vehiculos_listado', '', "Patente='".$Patente."' AND idEstado='1' AND idProceso='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowveh = db_select_data (false, 'idVehiculo', 'vehiculos_listado', '', "Patente='".$Patente."' AND idEstado='1' AND idProceso='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si existe el dato, obtengo el id del vehiculo
				if($ndata_2 != 0) {$idVehiculo       = $rowveh['idVehiculo'];}
				if($ndata_2 != 0) {$idVehiculoVuelta = $rowveh['idVehiculo'];}
			}
			//generacion de errores
			if($ndata_1 > 0) {  $error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			if($ndata_2 == 0) { $error['ndata_2'] = 'error/La Patente ingresada no corresponde a ningun vehiculo';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//se verifica si la imagen existe
				if (!empty($_FILES['Direccion_img']['name'])){
						
					if ($_FILES["Direccion_img"]["error"] > 0){ 
						$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]); 
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 1000;
						//Sufijo
						$sufijo = 'hijo_img_'.$idApoderado.'_';
									  
						if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['Direccion_img']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$resultado = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
								if ($resultado){
									
									//filtros
									if(isset($idApoderado) && $idApoderado != ''){            $a  = "'".$idApoderado."'" ;        }else{$a  ="''";}
									if(isset($Nombre) && $Nombre != ''){                      $a .= ",'".$Nombre."'" ;            }else{$a .=",''";}
									if(isset($ApellidoPat) && $ApellidoPat != ''){            $a .= ",'".$ApellidoPat."'" ;       }else{$a .=",''";}
									if(isset($ApellidoMat) && $ApellidoMat != ''){            $a .= ",'".$ApellidoMat."'" ;       }else{$a .=",''";}
									if(isset($idSexo) && $idSexo != ''){                      $a .= ",'".$idSexo."'" ;            }else{$a .=",''";}
									if(isset($FNacimiento) && $FNacimiento != ''){            $a .= ",'".$FNacimiento."'" ;       }else{$a .=",''";}
									if(isset($idPlan) && $idPlan != ''){                      $a .= ",'".$idPlan."'" ;            }else{$a .=",''";}
									if(isset($idVehiculo) && $idVehiculo != ''){              $a .= ",'".$idVehiculo."'" ;        }else{$a .=",''";}
									if(isset($idVehiculoVuelta) && $idVehiculoVuelta != ''){  $a .= ",'".$idVehiculoVuelta."'" ;  }else{$a .=",''";}
									if(isset($idEstado) && $idEstado != ''){                  $a .= ",'".$idEstado."'" ;          }else{$a .=",''";}
									$a .= ",'".$sufijo.$_FILES['Direccion_img']['name']."'" ;
											
									// inserto los datos de registro en la db
									$query  = "INSERT INTO `apoderados_listado_hijos` (idApoderado, Nombre, ApellidoPat, ApellidoMat,
									idSexo, FNacimiento, idPlan, idVehiculo, idVehiculoVuelta, idEstado, Direccion_img ) 
									VALUES (".$a.")";
									//Consulta
									$resultado = mysqli_query ($dbConn, $query);
									//Si ejecuto correctamente la consulta
									if($resultado){
										
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
				}else{
					
					//filtros
					if(isset($idApoderado) && $idApoderado != ''){            $a  = "'".$idApoderado."'" ;          }else{$a  ="''";}
					if(isset($Nombre) && $Nombre != ''){                      $a .= ",'".$Nombre."'" ;              }else{$a .=",''";}
					if(isset($ApellidoPat) && $ApellidoPat != ''){            $a .= ",'".$ApellidoPat."'" ;         }else{$a .=",''";}
					if(isset($ApellidoMat) && $ApellidoMat != ''){            $a .= ",'".$ApellidoMat."'" ;         }else{$a .=",''";}
					if(isset($idSexo) && $idSexo != ''){                      $a .= ",'".$idSexo."'" ;              }else{$a .=",''";}
					if(isset($FNacimiento) && $FNacimiento != ''){            $a .= ",'".$FNacimiento."'" ;         }else{$a .=",''";}
					if(isset($idPlan) && $idPlan != ''){                      $a .= ",'".$idPlan."'" ;              }else{$a .=",''";}
					if(isset($idVehiculo) && $idVehiculo != ''){              $a .= ",'".$idVehiculo."'" ;          }else{$a .=",''";}
					if(isset($idVehiculoVuelta) && $idVehiculoVuelta != ''){  $a .= ",'".$idVehiculoVuelta."'" ;    }else{$a .=",''";}
					if(isset($idEstado) && $idEstado != ''){                  $a .= ",'".$idEstado."'" ;            }else{$a .=",''";}
							
					// inserto los datos de registro en la db
					$query  = "INSERT INTO `apoderados_listado_hijos` (idApoderado, Nombre, ApellidoPat, ApellidoMat,
					idSexo, FNacimiento, idPlan, idVehiculo, idVehiculoVuelta, idEstado ) 
					VALUES (".$a.")";
					//Consulta
					$resultado = mysqli_query ($dbConn, $query);
					//Si ejecuto correctamente la consulta
					if($resultado){
						
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
				
			}
	
		break;
/*******************************************************************************************************************/		
		case 'update':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Modificacion de datos
			$Patente = str_replace(' ', '', $Patente);   //elimina espacios en blanco
			$Patente = strtolower($Patente);             //cambia a minusculas todo el texto
				
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			$ndata_2 = 0;
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idHijos)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'apoderados_listado_hijos', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idHijos!='".$idHijos."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Patente)){
				$ndata_2 = db_select_nrows (false, 'idVehiculo', 'vehiculos_listado', '', "Patente='".$Patente."' AND idEstado='1' AND idProceso='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				$rowveh = db_select_data (false, 'idVehiculo', 'vehiculos_listado', '', "Patente='".$Patente."' AND idEstado='1' AND idProceso='2'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si existe el dato, obtengo el id del vehiculo
				if($ndata_2 != 0) {$idVehiculo       = $rowveh['idVehiculo'];}
			}
			//generacion de errores
			if($ndata_1 > 0) {  $error['ndata_1'] = 'error/El Nombre ya existe en el sistema';}
			if($ndata_2 == 0) { $error['ndata_2'] = 'error/La Patente ingresada no corresponde a ningun vehiculo';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				
				//se verifica si la imagen existe
				if (!empty($_FILES['Direccion_img']['name'])){
						
					if ($_FILES["Direccion_img"]["error"] > 0){ 
						$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]); 
					} else {
						//Se verifican las extensiones de los archivos
						$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
						//Se verifica que el archivo subido no exceda los 100 kb
						$limite_kb = 1000;
						//Sufijo
						$sufijo = 'hijo_img_'.$idApoderado.'_';
									  
						if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
							//Se especifica carpeta de destino
							$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['Direccion_img']['name'];
							//Se verifica que el archivo un archivo con el mismo nombre no existe
							if (!file_exists($ruta)){
								//Se mueve el archivo a la carpeta previamente configurada
								$resultado = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
								if ($resultado){
									
									//Filtros
									$a = "idHijos='".$idHijos."'" ;
									if(isset($idApoderado) && $idApoderado != ''){            $a .= ",idApoderado='".$idApoderado."'" ;}
									if(isset($Nombre) && $Nombre != ''){                      $a .= ",Nombre='".$Nombre."'" ;}
									if(isset($ApellidoPat) && $ApellidoPat != ''){            $a .= ",ApellidoPat='".$ApellidoPat."'" ;}
									if(isset($ApellidoMat) && $ApellidoMat != ''){            $a .= ",ApellidoMat='".$ApellidoMat."'" ;}
									if(isset($idSexo) && $idSexo != ''){                      $a .= ",idSexo='".$idSexo."'" ;}
									if(isset($FNacimiento) && $FNacimiento != ''){            $a .= ",FNacimiento='".$FNacimiento."'" ;}	
									if(isset($idPlan) && $idPlan != ''){                      $a .= ",idPlan='".$idPlan."'" ;}						
									if(isset($idVehiculo) && $idVehiculo != ''){              $a .= ",idVehiculo='".$idVehiculo."'" ;}						
									if(isset($idVehiculoVuelta) && $idVehiculoVuelta != ''){  $a .= ",idVehiculoVuelta='".$idVehiculoVuelta."'" ;}						
									if(isset($idEstado) && $idEstado != ''){                  $a .= ",idEstado='".$idEstado."'" ;}						
									$a .= ",Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'" ;
									
									//se actualizan los datos
									$resultado = db_update_data (false, $a, 'apoderados_listado_hijos', 'idHijos = "'.$idHijos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				}else{
					
					//Filtros
					$a = "idHijos='".$idHijos."'" ;
					if(isset($idApoderado) && $idApoderado != ''){             $a .= ",idApoderado='".$idApoderado."'" ;}
					if(isset($Nombre) && $Nombre != ''){                       $a .= ",Nombre='".$Nombre."'" ;}
					if(isset($ApellidoPat) && $ApellidoPat != ''){             $a .= ",ApellidoPat='".$ApellidoPat."'" ;}
					if(isset($ApellidoMat) && $ApellidoMat != ''){             $a .= ",ApellidoMat='".$ApellidoMat."'" ;}
					if(isset($idSexo) && $idSexo != ''){                       $a .= ",idSexo='".$idSexo."'" ;}
					if(isset($FNacimiento) && $FNacimiento != ''){             $a .= ",FNacimiento='".$FNacimiento."'" ;}	
					if(isset($idPlan) && $idPlan != ''){                       $a .= ",idPlan='".$idPlan."'" ;}								
					if(isset($idVehiculo) && $idVehiculo != ''){               $a .= ",idVehiculo='".$idVehiculo."'" ;}						
					if(isset($idVehiculoVuelta) && $idVehiculoVuelta != ''){   $a .= ",idVehiculoVuelta='".$idVehiculoVuelta."'" ;}						
					if(isset($idEstado) && $idEstado != ''){                   $a .= ",idEstado='".$idEstado."'" ;}						
					
					//se actualizan los datos
					$resultado = db_update_data (false, $a, 'apoderados_listado_hijos', 'idHijos = "'.$idHijos.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
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
				// Se obtiene el nombre del logo
				$rowdata = db_select_data (false, 'Direccion_img', 'apoderados_listado_hijos', '', 'idHijos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				//se borran los datos
				$resultado = db_delete_data (false, 'apoderados_listado_hijos', 'idHijos = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					
					//se elimina la foto
					if(isset($rowdata['Direccion_img'])&&$rowdata['Direccion_img']!=''){
						try {
							if(!is_writable(DB_SITE_ALT_1.'/upload/'.$rowdata['Direccion_img'])){
								//throw new Exception('File not writable');
							}else{
								unlink(DB_SITE_ALT_1.'/upload/'.$rowdata['Direccion_img']);
							}
						}catch(Exception $e) { 
							//guardar el dato en un archivo log
						}
					}
					
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
		case 'del_img':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'Direccion_img', 'apoderados_listado_hijos', '', 'idHijos = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se actualizan los datos
			$a = 'Direccion_img=""';
			$resultado = db_update_data (false, $a, 'apoderados_listado_hijos', 'idHijos = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				
				//se elimina el archivo
				if(isset($rowdata['Direccion_img'])&&$rowdata['Direccion_img']!=''){
					try {
						if(!is_writable(DB_SITE_ALT_1.'/upload/'.$rowdata['Direccion_img'])){
							//throw new Exception('File not writable');
						}else{
							unlink(DB_SITE_ALT_1.'/upload/'.$rowdata['Direccion_img']);
						}
					}catch(Exception $e) { 
						//guardar el dato en un archivo log
					}
				}
				
				//Redirijo			
				header( 'Location: '.$location.'&id_img=true' );
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
	}
?>

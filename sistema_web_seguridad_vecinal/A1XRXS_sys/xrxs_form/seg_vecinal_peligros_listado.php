<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridPeligroad                                                */
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
	if ( !empty($_POST['idPeligro']) )        $idPeligro        = simpleDecode($_POST['idPeligro'], fecha_actual());
	if ( !empty($_POST['idSistema']) )        $idSistema        = simpleDecode($_POST['idSistema'], fecha_actual());
	if ( !empty($_POST['idCliente']) )        $idCliente        = simpleDecode($_POST['idCliente'], fecha_actual());
	if ( !empty($_POST['idTipo']) )           $idTipo           = $_POST['idTipo'];
	if ( !empty($_POST['idCiudad']) )         $idCiudad         = $_POST['idCiudad'];
	if ( !empty($_POST['idComuna']) )         $idComuna         = $_POST['idComuna'];
	if ( !empty($_POST['Direccion']) )        $Direccion 	    = $_POST['Direccion'];
	if ( !empty($_POST['GeoLatitud']) )       $GeoLatitud 	    = $_POST['GeoLatitud'];
	if ( !empty($_POST['GeoLongitud']) )      $GeoLongitud 	    = $_POST['GeoLongitud'];
	if ( !empty($_POST['Fecha']) )            $Fecha 	        = $_POST['Fecha'];
	if ( !empty($_POST['Hora']) )             $Hora 	        = $_POST['Hora'];
	if ( !empty($_POST['Descripcion']) )      $Descripcion 	    = $_POST['Descripcion'];
	if ( !empty($_POST['idEstado']) )         $idEstado 	    = $_POST['idEstado'];
	if ( !empty($_POST['idValidado']) )       $idValidado       = simpleDecode($_POST['idValidado'], fecha_actual());
	
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
			case 'idPeligro':      if(empty($idPeligro)){          $error['idPeligro']        = 'error/No ha ingresado el id';}break;
			case 'idSistema':      if(empty($idSistema)){          $error['idSistema']        = 'error/No ha seleccionado el sistema';}break;
			case 'idCliente':      if(empty($idCliente)){          $error['idCliente']        = 'error/No ha seleccionado el cliente';}break;
			case 'idTipo':         if(empty($idTipo)){             $error['idTipo']           = 'error/No ha seleccionado el tipo de la zona de peligro';}break;
			case 'idCiudad':       if(empty($idCiudad)){           $error['idCiudad']         = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':       if(empty($idComuna)){           $error['idComuna']         = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':      if(empty($Direccion)){          $error['Direccion']        = 'error/No ha ingresado el Direccion';}break;
			case 'GeoLatitud':     if(empty($GeoLatitud)){         $error['GeoLatitud']       = 'error/No ha ingresado la latitud';}break;
			case 'GeoLongitud':    if(empty($GeoLongitud)){        $error['GeoLongitud']      = 'error/No ha ingresado la longitud';}break;	
			case 'Fecha':          if(empty($Fecha)){              $error['Fecha']            = 'error/No ha ingresado la fecha de la zona de peligro';}break;
			case 'Hora':           if(empty($Hora)){               $error['Hora']             = 'error/No ha ingresado la hora de la zona de peligro';}break;
			case 'Descripcion':    if(empty($Descripcion)){        $error['Descripcion']      = 'error/No ha ingresado la descripcion';}break;
			case 'idEstado':       if(empty($idEstado)){           $error['idEstado']         = 'error/No ha seleccionado el estado';}break;
			case 'idValidado':     if(empty($idValidado)){         $error['idValidado']       = 'error/No ha seleccionado el estado de validacion';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
if(isset($Direccion)&&contar_palabras_censuradas($Direccion)!=0){     $error['Direccion']   = 'error/Edita la direccion, contiene palabras no permitidas ('.contar_palabras_censuradas($Direccion).' palabras)'; }	
if(isset($Descripcion)&&contar_palabras_censuradas($Descripcion)!=0){ $error['Descripcion'] = 'error/Edita la descripcion, contiene palabras no permitidas ('.contar_palabras_censuradas($Descripcion).' palabras)'; }	
							
/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/		
		case 'insert':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//obtengo fecha actual
			$FechaCreacion = fecha_actual();
			
			/*******************************************************************/
			//generacion de errores
			$dateTimestamp1 = strtotime($Fecha);
			$dateTimestamp2 = strtotime($FechaCreacion);
			if($dateTimestamp1 > $dateTimestamp2) {$error['ndata_1'] = 'error/La fecha del evento no puede ser superior a la fecha actual';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//filtros
				if(isset($idSistema) && $idSistema != ''){          $a  = "'".$idSistema."'" ;              }else{$a  = "''";}
				if(isset($idCliente) && $idCliente != ''){          $a .= ",'".$idCliente."'" ;             }else{$a .= ",''";}
				if(isset($idTipo) && $idTipo != ''){                $a .= ",'".$idTipo."'" ;                }else{$a .= ",''";}
				if(isset($idCiudad) && $idCiudad != ''){            $a .= ",'".$idCiudad."'" ;              }else{$a .= ",''";}
				if(isset($idComuna) && $idComuna != ''){            $a .= ",'".$idComuna."'" ;              }else{$a .= ",''";}
				if(isset($Direccion) && $Direccion != ''){          $a .= ",'".$Direccion."'" ;             }else{$a .= ",''";}
				if(isset($GeoLatitud) && $GeoLatitud != ''){        $a .= ",'".$GeoLatitud."'" ;            }else{$a .= ",''";}
				if(isset($GeoLongitud) && $GeoLongitud != ''){      $a .= ",'".$GeoLongitud."'" ;           }else{$a .= ",''";}
				if(isset($Fecha) && $Fecha != ''){                  
					$a .= ",'".$Fecha."'" ;                  
					$a .= ",'".fecha2NSemana($Fecha)."'" ;
					$a .= ",'".fecha2NdiaMes($Fecha)."'" ; 
					$a .= ",'".fecha2NMes($Fecha)."'" ;
					$a .= ",'".fecha2Ano($Fecha)."'" ;               
				}else{
					$a .= ",''";
					$a .= ",''";
					$a .= ",''";
					$a .= ",''";
					$a .= ",''";
				}
				if(isset($Hora) && $Hora != ''){                    $a .= ",'".$Hora."'" ;                  }else{$a .= ",''";}
				if(isset($Descripcion) && $Descripcion != ''){      $a .= ",'".$Descripcion."'" ;           }else{$a .= ",''";}
				if(isset($idEstado) && $idEstado != ''){            $a .= ",'".$idEstado."'" ;              }else{$a .= ",''";}
				if(isset($FechaCreacion) && $FechaCreacion != ''){  $a .= ",'".$FechaCreacion."'" ;         }else{$a .= ",''";}
				if(isset($idValidado) && $idValidado != ''){        $a .= ",'".$idValidado."'" ;            }else{$a .= ",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `seg_vecinal_peligros_listado` (idSistema, idCliente,
				idTipo, idCiudad, idComuna, Direccion, GeoLatitud, GeoLongitud, Fecha, 
				Semana, Dia, idMes, Ano, Hora, Descripcion, idEstado, FechaCreacion, idValidado) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if($resultado){
					/********************************************************/
					//recibo el último id generado por mi sesion
					$ultimo_id = mysqli_insert_id($dbConn);
					
					//variables
					$Tipo   = '';
					$Ciudad = '';
					$Comuna = '';
					
					// Se buscan los datos
					if(isset($idTipo) && $idTipo != ''){     $rowTipo   = db_select_data (false, 'Nombre', 'seg_vecinal_peligros_tipos', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);  $Tipo   = $rowTipo['Nombre'];}
					if(isset($idCiudad) && $idCiudad != ''){ $rowCiudad = db_select_data (false, 'Nombre', 'core_ubicacion_ciudad', '', 'idCiudad = '.$idCiudad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);   $Ciudad = $rowCiudad['Nombre'];}
					if(isset($idComuna) && $idComuna != ''){ $rowComuna = db_select_data (false, 'Nombre', 'core_ubicacion_comunas', '', 'idComuna = '.$idComuna, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);  $Comuna = $rowComuna['Nombre'];}
					
					//se guarda evento
					if(isset($ultimo_id)&&$ultimo_id!=''){      $_SESSION['vecinos_peligros'][$ultimo_id]['idPeligro']         = $ultimo_id;         }else{$_SESSION['vecinos_peligros'][$ultimo_id]['idPeligro']         = '';}
					if(isset($idTipo)&&$idTipo!=''){            $_SESSION['vecinos_peligros'][$ultimo_id]['idTipo']            = $idTipo;            }else{$_SESSION['vecinos_peligros'][$ultimo_id]['idTipo']            = '';}
					if(isset($GeoLatitud)&&$GeoLatitud!=''){    $_SESSION['vecinos_peligros'][$ultimo_id]['GeoLatitud']        = $GeoLatitud;        }else{$_SESSION['vecinos_peligros'][$ultimo_id]['GeoLatitud']        = '';}
					if(isset($GeoLongitud)&&$GeoLongitud!=''){  $_SESSION['vecinos_peligros'][$ultimo_id]['GeoLongitud']       = $GeoLongitud;       }else{$_SESSION['vecinos_peligros'][$ultimo_id]['GeoLongitud']       = '';}
					if(isset($Direccion)&&$Direccion!=''){      $_SESSION['vecinos_peligros'][$ultimo_id]['Direccion']         = $Direccion;         }else{$_SESSION['vecinos_peligros'][$ultimo_id]['Direccion']         = '';}
					if(isset($Tipo)&&$Tipo!=''){                $_SESSION['vecinos_peligros'][$ultimo_id]['Tipo']              = $Tipo;              }else{$_SESSION['vecinos_peligros'][$ultimo_id]['Tipo']              = '';}
					if(isset($Ciudad)&&$Ciudad!=''){            $_SESSION['vecinos_peligros'][$ultimo_id]['Ciudad']            = $Ciudad;            }else{$_SESSION['vecinos_peligros'][$ultimo_id]['Ciudad']            = '';}
					if(isset($Comuna)&&$Comuna!=''){            $_SESSION['vecinos_peligros'][$ultimo_id]['Comuna']            = $Comuna;            }else{$_SESSION['vecinos_peligros'][$ultimo_id]['Comuna']            = '';}
					if(isset($Descripcion)&&$Descripcion!=''){  $_SESSION['vecinos_peligros'][$ultimo_id]['Descripcion']       = $Descripcion;       }else{$_SESSION['vecinos_peligros'][$ultimo_id]['Descripcion']       = '';}
					if(isset($idValidado)&&$idValidado!=''){    $_SESSION['vecinos_peligros'][$ultimo_id]['idValidado']        = $idValidado;        }else{$_SESSION['vecinos_peligros'][$ultimo_id]['idValidado']        = '';}
						
					//guardo el total de eventos cerca
					$_SESSION['usuario']['basic_data']['total_peligros']  = $_SESSION['usuario']['basic_data']['total_peligros'] + 1 ;
					
					
					/****************************************************************/
					//se redirige
					header( 'Location: '.$location.'&id='.simpleEncode($ultimo_id, fecha_actual()).'&created=true' );
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
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idPeligro='".$idPeligro."'" ;
				if(isset($idSistema) && $idSistema != ''){       $a .= ",idSistema='".$idSistema."'" ;}
				if(isset($idCliente) && $idCliente != ''){       $a .= ",idCliente='".$idCliente."'" ;}
				if(isset($idTipo) && $idTipo != ''){             $a .= ",idTipo='".$idTipo."'" ;}
				if(isset($idCiudad) && $idCiudad != ''){         $a .= ",idCiudad='".$idCiudad."'" ;}
				if(isset($idComuna) && $idComuna != ''){         $a .= ",idComuna='".$idComuna."'" ;}
				if(isset($Direccion) && $Direccion != ''){       $a .= ",Direccion='".$Direccion."'" ;}
				if(isset($GeoLatitud) && $GeoLatitud != ''){     $a .= ",GeoLatitud='".$GeoLatitud."'" ;}
				if(isset($GeoLongitud) && $GeoLongitud != ''){   $a .= ",GeoLongitud='".$GeoLongitud."'" ;}
				if(isset($Fecha) && $Fecha != ''){                               
					$a .= ",Fecha='".$Fecha."'" ;
					$a .= ",Semana='".fecha2NSemana($Fecha)."'" ;
					$a .= ",Dia='".fecha2NdiaMes($Fecha)."'" ;
					$a .= ",idMes='".fecha2NMes($Fecha)."'" ;
					$a .= ",Ano='".fecha2Ano($Fecha)."'" ;
				}
				if(isset($Hora) && $Hora != ''){                 $a .= ",Hora='".$Hora."'" ;}
				if(isset($Descripcion) && $Descripcion != ''){   $a .= ",Descripcion='".$Descripcion."'" ;}
				if(isset($idEstado) && $idEstado != ''){         $a .= ",idEstado='".$idEstado."'" ;}
				if(isset($idValidado) && $idValidado != ''){     $a .= ",idValidado='".$idValidado."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'seg_vecinal_peligros_listado', 'idPeligro = "'.$idPeligro.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					
					//variables
					$Tipo   = '';
					$Ciudad = '';
					$Comuna = '';
					
					// Se buscan los datos
					if(isset($idTipo) && $idTipo != ''){     $rowTipo   = db_select_data (false, 'Nombre', 'seg_vecinal_peligros_tipos', '', 'idTipo = '.$idTipo, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);  $Tipo   = $rowTipo['Nombre'];}
					if(isset($idCiudad) && $idCiudad != ''){ $rowCiudad = db_select_data (false, 'Nombre', 'core_ubicacion_ciudad', '', 'idCiudad = '.$idCiudad, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);   $Ciudad = $rowCiudad['Nombre'];}
					if(isset($idComuna) && $idComuna != ''){ $rowComuna = db_select_data (false, 'Nombre', 'core_ubicacion_comunas', '', 'idComuna = '.$idComuna, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);  $Comuna = $rowComuna['Nombre'];}
					
					//se guarda evento
					if(isset($idPeligro)&&$idPeligro!=''){      $_SESSION['vecinos_peligros'][$idPeligro]['idPeligro']         = $idPeligro;         }else{$_SESSION['vecinos_peligros'][$idPeligro]['idPeligro']         = '';}
					if(isset($idTipo)&&$idTipo!=''){            $_SESSION['vecinos_peligros'][$idPeligro]['idTipo']            = $idTipo;            }else{$_SESSION['vecinos_peligros'][$idPeligro]['idTipo']            = '';}
					if(isset($GeoLatitud)&&$GeoLatitud!=''){    $_SESSION['vecinos_peligros'][$idPeligro]['GeoLatitud']        = $GeoLatitud;        }else{$_SESSION['vecinos_peligros'][$idPeligro]['GeoLatitud']        = '';}
					if(isset($GeoLongitud)&&$GeoLongitud!=''){  $_SESSION['vecinos_peligros'][$idPeligro]['GeoLongitud']       = $GeoLongitud;       }else{$_SESSION['vecinos_peligros'][$idPeligro]['GeoLongitud']       = '';}
					if(isset($Direccion)&&$Direccion!=''){      $_SESSION['vecinos_peligros'][$idPeligro]['Direccion']         = $Direccion;         }else{$_SESSION['vecinos_peligros'][$idPeligro]['Direccion']         = '';}
					if(isset($Tipo)&&$Tipo!=''){                $_SESSION['vecinos_peligros'][$idPeligro]['Tipo']              = $Tipo;              }else{$_SESSION['vecinos_peligros'][$idPeligro]['Tipo']              = '';}
					if(isset($Ciudad)&&$Ciudad!=''){            $_SESSION['vecinos_peligros'][$idPeligro]['Ciudad']            = $Ciudad;            }else{$_SESSION['vecinos_peligros'][$idPeligro]['Ciudad']            = '';}
					if(isset($Comuna)&&$Comuna!=''){            $_SESSION['vecinos_peligros'][$idPeligro]['Comuna']            = $Comuna;            }else{$_SESSION['vecinos_peligros'][$idPeligro]['Comuna']            = '';}
					if(isset($Descripcion)&&$Descripcion!=''){  $_SESSION['vecinos_peligros'][$idPeligro]['Descripcion']       = $Descripcion;       }else{$_SESSION['vecinos_peligros'][$idPeligro]['Descripcion']       = '';}
					if(isset($idValidado)&&$idValidado!=''){    $_SESSION['vecinos_peligros'][$idPeligro]['idValidado']        = $idValidado;        }else{$_SESSION['vecinos_peligros'][$idPeligro]['idValidado']        = '';}
					
					/********************************************************/
					//se redirige
					header( 'Location: '.$location.'&id='.simpleEncode($idPeligro, fecha_actual()).'&edited=true' );
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
	}
?>

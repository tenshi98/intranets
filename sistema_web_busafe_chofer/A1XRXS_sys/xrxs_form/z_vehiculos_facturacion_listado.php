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
	if ( !empty($_POST['idFacturacion']) )         $idFacturacion          = $_POST['idFacturacion'];
	if ( !empty($_POST['idSistema']) )             $idSistema              = $_POST['idSistema'];
	if ( !empty($_POST['idUsuario']) )             $idUsuario              = $_POST['idUsuario'];
	if ( !empty($_POST['Fecha']) )                 $Fecha                  = $_POST['Fecha'];
	if ( !empty($_POST['Dia']) )                   $Dia                    = $_POST['Dia'];
	if ( !empty($_POST['idMes']) )                 $idMes                  = $_POST['idMes'];
	if ( !empty($_POST['Ano']) )                   $Ano                    = $_POST['Ano'];
	if ( !empty($_POST['Observaciones']) )         $Observaciones          = $_POST['Observaciones'];
	if ( !empty($_POST['fCreacion']) )             $fCreacion              = $_POST['fCreacion'];
	if ( !empty($_POST['idFacturacionDetalle']) )  $idFacturacionDetalle   = $_POST['idFacturacionDetalle'];
	if ( !empty($_POST['idCliente']) )             $idCliente              = $_POST['idCliente'];
	if ( !empty($_POST['SII_NDoc']) )              $SII_NDoc               = $_POST['SII_NDoc'];
	if ( !empty($_POST['Pagofecha']) )             $Pagofecha              = $_POST['Pagofecha'];
	if ( !empty($_POST['idTipoPago']) )            $idTipoPago             = $_POST['idTipoPago'];
	if ( !empty($_POST['nDocPago']) )              $nDocPago               = $_POST['nDocPago'];
	if ( !empty($_POST['montoPago']) )             $montoPago              = $_POST['montoPago'];
	if ( !empty($_POST['idUsuarioPago']) )         $idUsuarioPago          = $_POST['idUsuarioPago'];
	if ( !empty($_POST['idApoderado']) )           $idApoderado            = $_POST['idApoderado'];
	if ( !empty($_POST['montoPactado']) )          $montoPactado           = $_POST['montoPactado'];
	if ( !empty($_POST['idTransporte']) )          $idTransporte           = $_POST['idTransporte'];
	


/*******************************************************************************************************************/
/*                                      Verificacion de los datos obligatorios                                     */
/*******************************************************************************************************************/

	//limpio y separo los datos de la cadena de comprobacion
	$form_obligatorios = str_replace(' ', '', $form_obligatorios);
	$INT_piezas = explode(",", $form_obligatorios);
	//recorro los elementos
	foreach ($INT_piezas as $INT_valor) {
		//veo si existe el dato solicitado y genero el error
		switch ($INT_valor) {
			case 'idFacturacion':          if(empty($idFacturacion)){            $error['idFacturacion']          = 'error/No ha ingresado el id';}break;
			case 'idSistema':              if(empty($idSistema)){                $error['idSistema']              = 'error/No ha ingresado el sistema';}break;
			case 'idUsuario':              if(empty($idUsuario)){                $error['idUsuario']              = 'error/No ha ingresado el usuario creador';}break;
			case 'Fecha':                  if(empty($Fecha)){                    $error['Fecha']                  = 'error/No ha ingresado el Fecha';}break;
			case 'Dia':                    if(empty($Dia)){                      $error['Dia']                    = 'error/No ha ingresado la Dia';}break;
			case 'idMes':                  if(empty($idMes)){                    $error['idMes']                  = 'error/No ha ingresado el mes';}break;
			case 'Ano':                    if(empty($Ano)){                      $error['Ano']                    = 'error/No ha seleccionado el Ano';}break;
			case 'Observaciones':          if(empty($Observaciones)){            $error['Observaciones']          = 'error/No ha ingresado la observacion';}break;
			case 'fCreacion':              if(empty($fCreacion)){                $error['fCreacion']              = 'error/No ha ingresado la fecha de creacion';}break;
			case 'idFacturacionDetalle':   if(empty($idFacturacionDetalle)){     $error['idFacturacionDetalle']   = 'error/No ha ingresado la id del detalle';}break;
			case 'idCliente':              if(empty($idCliente)){                $error['idCliente']              = 'error/No ha ingresado el cliente';}break;
			case 'SII_NDoc':               if(empty($SII_NDoc)){                 $error['SII_NDoc']               = 'error/No ha ingresado el numero de documento';}break;
			case 'Pagofecha':              if(empty($Pagofecha)){                $error['Pagofecha']              = 'error/No ha ingresado la fecha de pago';}break;
			case 'idTipoPago':             if(empty($idTipoPago)){               $error['idTipoPago']             = 'error/No ha seleccionado el tipo de pago';}break;
			case 'nDocPago':               if(empty($nDocPago)){                 $error['nDocPago']               = 'error/No ha ingresado el numero de documento de pago';}break;
			case 'montoPago':              if(empty($montoPago)){                $error['montoPago']              = 'error/No ha ingresado el monto de pago';}break;
			case 'idUsuarioPago':          if(empty($idUsuarioPago)){            $error['idUsuarioPago']          = 'error/No ha seleccionado el usuario de pago';}break;
			case 'idApoderado':            if(empty($idApoderado)){              $error['idApoderado']            = 'error/No ha seleccionado el apoderado';}break;
			case 'montoPactado':           if(empty($montoPactado)){             $error['montoPactado']           = 'error/No ha ingresado el monto pagado';}break;
			case 'idTransporte':           if(empty($idTransporte)){             $error['idTransporte']           = 'error/No ha seleccionado el transportista';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {

/*******************************************************************************************************************/		
		case 'create_new':
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idSistema)&&isset($Fecha)){
				$idMes = fecha2NMes($Fecha); 
				$Ano = fecha2Ano($Fecha);
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'vehiculos_facturacion_listado', '', "idSistema='".$idSistema."' AND idMes='".$idMes."' AND Ano='".$Ano."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La facturacion ya existe en el sistema';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//Borro todas las sesiones
				unset($_SESSION['basicos']);
				unset($_SESSION['hijos']);
				
				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Fecha)){          $_SESSION['basicos']['Fecha']         = $Fecha;               }else{$_SESSION['basicos']['Fecha']         = '';}
				if(isset($Observaciones)){  $_SESSION['basicos']['Observaciones'] = $Observaciones;       }else{$_SESSION['basicos']['Observaciones'] = 'Sin Observaciones';}
				if(isset($idSistema)){      $_SESSION['basicos']['idSistema']     = $idSistema;           }else{$_SESSION['basicos']['idSistema']     = '';}
				if(isset($idUsuario)){      $_SESSION['basicos']['idUsuario']     = $idUsuario;           }else{$_SESSION['basicos']['idUsuario']     = '';}
				if(isset($fCreacion)){      $_SESSION['basicos']['fCreacion']     = $fCreacion;           }else{$_SESSION['basicos']['fCreacion']     = '';}
				if(isset($idTransporte)){   $_SESSION['basicos']['idTransporte']  = $idTransporte;        }else{$_SESSION['basicos']['idTransporte']  = '';}
				
				
				
				//redirijo a la vista
				header( 'Location: '.$location.'&view=true' );
				die;
			}
		
		break;
/*******************************************************************************************************************/		
		case 'clear_all':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Borro todas las sesiones
			unset($_SESSION['basicos']);
			unset($_SESSION['hijos']);
			
			header( 'Location: '.$location );
			die;

		break;
/*******************************************************************************************************************/		
		case 'edit_datos':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idSistema)&&isset($Fecha)){
				$idMes = fecha2NMes($Fecha); 
				$Ano = fecha2Ano($Fecha);
				$ndata_1 = db_select_nrows (false, 'idFacturacion', 'vehiculos_facturacion_listado', '', "idSistema='".$idSistema."' AND idMes='".$idMes."' AND Ano='".$Ano."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/La facturacion ya existe en el sistema';}
			/*******************************************************************/
			
			
			if ( empty($error) ) {
		
				//Se guardan los datos basicos del formulario recien llenado
				if(isset($Fecha)){          $_SESSION['basicos']['Fecha']          = $Fecha;            }else{$_SESSION['basicos']['Fecha']          = '';}
				if(isset($Observaciones)){  $_SESSION['basicos']['Observaciones']  = $Observaciones;    }else{$_SESSION['basicos']['Observaciones']  = 'Sin Observaciones';}
				if(isset($idSistema)){      $_SESSION['basicos']['idSistema']      = $idSistema;        }else{$_SESSION['basicos']['idSistema']      = '';}
				if(isset($idTransporte)){   $_SESSION['basicos']['idTransporte']   = $idTransporte;     }else{$_SESSION['basicos']['idTransporte']   = '';}
				
				
				
				//redirijo a la vista
				header( 'Location: '.$location.'&view=true' );
				die;
			}
		
		break;

/*******************************************************************************************************************/		
		case 'add_all_cliente':

			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Borro todas las sesiones
			unset($_SESSION['hijos']);
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//Variables
				$SIS_idSistema      = $_SESSION['basicos']['idSistema'];
				$SIS_idTransporte   = $_SESSION['basicos']['idTransporte'];
			
				//traigo todos los apoderados con hijos
				$SIS_query = 'apoderados_listado_hijos.idHijos';
				$SIS_join  = '
				LEFT JOIN `apoderados_listado` ON apoderados_listado.idApoderado = apoderados_listado_hijos.idApoderado
				LEFT JOIN `vehiculos_listado`  ON vehiculos_listado.idVehiculo   = apoderados_listado_hijos.idVehiculo';
				$SIS_where = 'apoderados_listado.idSistema = "'.$SIS_idSistema.'" AND vehiculos_listado.idTransporte = "'.$SIS_idTransporte.'" AND apoderados_listado.idEstado = 1 AND apoderados_listado_hijos.idVehiculo!=0 GROUP BY apoderados_listado_hijos.idHijos';
				$SIS_order = 'apoderados_listado.idApoderado ASC';
				$arrHijos = array();
				$arrHijos = db_select_array (false, $SIS_query, 'apoderados_listado_hijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

				foreach ($arrHijos as $hijo) {
					$_SESSION['hijos'][$hijo['idHijos']]['idHijos'] = $hijo['idHijos'];
				}

				//redirijo a la vista
				header( 'Location: '.$location.'&view=true' );
				die;
			}

		break;
/*******************************************************************************************************************/		
		case 'del_cliente':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			$idCliente   = $_GET['del_cliente'];

			//$_SESSION['hijos'][$idCliente] = '';
			unset($_SESSION['hijos'][$idCliente]);
			
			//redirijo a la vista
			header( 'Location: '.$location.'&view=true' );
			die;
			
		
		break;
/*******************************************************************************************************************/		
		case 'facturar':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Datos basicos
			if (isset($_SESSION['basicos'])){
				if(!isset($_SESSION['basicos']['idSistema']) or $_SESSION['basicos']['idSistema']=='' ){           $error['idSistema']        = 'error/No ha ingresado el id del sistema';}
				if(!isset($_SESSION['basicos']['idUsuario']) or $_SESSION['basicos']['idUsuario']=='' ){           $error['idUsuario']        = 'error/No ha seleccionado el usuario';}
				if(!isset($_SESSION['basicos']['Fecha']) or $_SESSION['basicos']['Fecha']=='' ){                   $error['Fecha']            = 'error/No ha ingresado una fecha';}
				if(!isset($_SESSION['basicos']['Observaciones']) or $_SESSION['basicos']['Observaciones']=='' ){   $error['Observaciones']    = 'error/No ha ingresado una observacion';}
				if(!isset($_SESSION['basicos']['fCreacion']) or $_SESSION['basicos']['fCreacion']=='' ){           $error['fCreacion']        = 'error/No ha ingresado una fecha de creacion';}
				if(!isset($_SESSION['basicos']['idTransporte']) or $_SESSION['basicos']['idTransporte']=='' ){     $error['idTransporte']     = 'error/No ha seleccionado el transportista';}
			}else{
				$error['basicos'] = 'error/No tiene datos basicos asignados a la facturacion';
			}
			

			// se ejecuta codigo en caso de no haber errores
			if ( empty($error) ) {
				
				//variables
				$SIS_idSistema            = $_SESSION['basicos']['idSistema'];
				$SIS_idUsuario            = $_SESSION['basicos']['idUsuario'];
				$SIS_Fecha                = $_SESSION['basicos']['Fecha'];
				$SIS_Observaciones        = $_SESSION['basicos']['Observaciones'];
				$SIS_fCreacion            = $_SESSION['basicos']['fCreacion'];
				$SIS_idTransporte         = $_SESSION['basicos']['idTransporte'];
				$SIS_Fecha_Ano            = fecha2Ano($_SESSION['basicos']['Fecha']);
				$SIS_Fecha_Mes_anterior   = (fecha2NMes($_SESSION['basicos']['Fecha'])) - 1;
				//En caso de que el mes sea enero, ponerlo como diciembre del año anterior
				if($SIS_Fecha_Mes_anterior == 0){
					$SIS_Fecha_Mes_anterior  = 12;
					$SIS_Fecha_Ano           = $SIS_Fecha_Ano - 1;	
				}
			
				
				//traigo todos los apoderados con hijos
				$SIS_query = '
				apoderados_listado_hijos.idHijos,
				apoderados_listado_hijos.idApoderado,
				apoderados_listado_hijos.idVehiculo,
				sistema_planes.Valor,
				(SELECT MontoTotal FROM `vehiculos_facturacion_listado_detalle` WHERE idApoderado = apoderados_listado_hijos.idApoderado AND idMes='".$SIS_Fecha_Mes_anterior."' AND Ano='".$SIS_Fecha_Ano."' LIMIT 1) AS AnteriorPactado,
				(SELECT montoPago FROM `vehiculos_facturacion_listado_detalle` WHERE idApoderado = apoderados_listado_hijos.idApoderado AND idMes='".$SIS_Fecha_Mes_anterior."' AND Ano='".$SIS_Fecha_Ano."' LIMIT 1) AS AnteriorPagado';
				$SIS_join  = '
				LEFT JOIN `apoderados_listado`    ON apoderados_listado.idApoderado   = apoderados_listado_hijos.idApoderado
				LEFT JOIN `sistema_planes`        ON sistema_planes.idPlan            = apoderados_listado_hijos.idPlan';
				$SIS_where = 'apoderados_listado.idSistema = "'.$SIS_idSistema.'" AND apoderados_listado.idEstado = 1 AND apoderados_listado_hijos.idVehiculo!=0 GROUP BY apoderados_listado_hijos.idHijos';
				$SIS_order = 'apoderados_listado_hijos.idApoderado ASC, apoderados_listado_hijos.Nombre ASC';
				$arrHijos = array();
				$arrHijos = db_select_array (false, $SIS_query, 'apoderados_listado_hijos', $SIS_join, $SIS_where, $SIS_order, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				/************************************************************************************************************************/
				//Se insertan los datos principales

				if(isset($SIS_idSistema) && $SIS_idSistema != ''){    $a  = "'".$SIS_idSistema."'" ;    }else{$a  ="''";}
				if(isset($SIS_idUsuario) && $SIS_idUsuario != ''){    $a .= ",'".$SIS_idUsuario."'" ;   }else{$a .=",''";}
				if(isset($SIS_Fecha) && $SIS_Fecha!= ''){  
					$a .= ",'".$SIS_Fecha."'" ;  
					$a .= ",'".fecha2NMes($SIS_Fecha)."'" ;
					$a .= ",'".fecha2Ano($SIS_Fecha)."'" ;
				}else{
					$a .= ",''";
					$a .= ",''";
					$a .= ",''";
				}
				if(isset($SIS_Observaciones) && $SIS_Observaciones != ''){    $a .= ",'".$SIS_Observaciones."'" ;   }else{$a .=",''";}
				if(isset($SIS_fCreacion) && $SIS_fCreacion != ''){            $a .= ",'".$SIS_fCreacion."'" ;       }else{$a .=",''";}
				if(isset($SIS_idTransporte) && $SIS_idTransporte != ''){      $a .= ",'".$SIS_idTransporte."'" ;    }else{$a .=",''";}
				
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `vehiculos_facturacion_listado` (idSistema, idUsuario, Fecha, idMes, Ano, Observaciones, fCreacion, idTransporte) 
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
				//recibo el último id generado por mi sesion
				$ultimo_id = mysqli_insert_id($dbConn);
				
				/************************************************************************************************************************/
				//Se insertan los detalles
				filtrar($arrHijos, 'idApoderado');  
				foreach($arrHijos as $categoria=>$Hijos){ 
					
					//variables vacias
					$arrCargas = array();
					$nnx       = 1;
					$Subtotal  = 0;
					$Atraso    = 0;
					$Adelanto  = 0;
					$Total     = 0;
					//Recorro los hijos del apoderado
					foreach ($Hijos as $hijo) { 
						$arrCargas[$nnx]['idHijos']      = $hijo['idHijos'];
						$arrCargas[$nnx]['idVehiculo']   = $hijo['idVehiculo'];
						$arrCargas[$nnx]['Valor']        = $hijo['Valor'];
						$dataEx                          = $Adelanto + $hijo['AnteriorPagado'] - $hijo['AnteriorPactado'];
						$Subtotal                        = $Subtotal + $hijo['Valor'];
						$nnx++;	
						
						if($dataEx < 0){
							$Atraso = $dataEx*-1;
						}else{
							$Adelanto = $dataEx;
						}
					
					
						//echo $Atraso.' - '.$Adelanto.'<br/><br/>';
					}
					
					//Si adelanto es negativo reseteo a 0
					
					//Se calculan los totales
					$Total = $Subtotal + $Atraso - $Adelanto;
					
					//Genero la consulta
					if(isset($ultimo_id) && $ultimo_id != ''){            $a  = "'".$ultimo_id."'" ;        }else{$a  ="''";}
					if(isset($SIS_idSistema) && $SIS_idSistema != ''){    $a .= ",'".$SIS_idSistema."'" ;   }else{$a .=",''";}
					if(isset($SIS_idUsuario) && $SIS_idUsuario != ''){    $a .= ",'".$SIS_idUsuario."'" ;   }else{$a .=",''";}
					if(isset($SIS_Fecha) && $SIS_Fecha!= ''){  
						$a .= ",'".$SIS_Fecha."'" ;  
						$a .= ",'".fecha2NMes($SIS_Fecha)."'" ;
						$a .= ",'".fecha2Ano($SIS_Fecha)."'" ;
					}else{
						$a .= ",''";
						$a .= ",''";
						$a .= ",''";
					}
					if(isset($SIS_fCreacion) && $SIS_fCreacion != ''){                               $a .= ",'".$SIS_fCreacion."'" ;                 }else{$a .=",''";}
					if(isset($categoria) && $categoria != ''){                                       $a .= ",'".$categoria."'" ;                     }else{$a .=",''";}
					if(isset($arrCargas[1]['idHijos']) && $arrCargas[1]['idHijos'] != ''){           $a .= ",'".$arrCargas[1]['idHijos']."'" ;       }else{$a .=",''";}
					if(isset($arrCargas[2]['idHijos']) && $arrCargas[2]['idHijos'] != ''){           $a .= ",'".$arrCargas[2]['idHijos']."'" ;       }else{$a .=",''";}
					if(isset($arrCargas[3]['idHijos']) && $arrCargas[3]['idHijos'] != ''){           $a .= ",'".$arrCargas[3]['idHijos']."'" ;       }else{$a .=",''";}
					if(isset($arrCargas[4]['idHijos']) && $arrCargas[4]['idHijos'] != ''){           $a .= ",'".$arrCargas[4]['idHijos']."'" ;       }else{$a .=",''";}
					if(isset($arrCargas[5]['idHijos']) && $arrCargas[5]['idHijos'] != ''){           $a .= ",'".$arrCargas[5]['idHijos']."'" ;       }else{$a .=",''";}
					if(isset($arrCargas[1]['idVehiculo']) && $arrCargas[1]['idVehiculo'] != ''){     $a .= ",'".$arrCargas[1]['idVehiculo']."'" ;    }else{$a .=",''";}
					if(isset($arrCargas[2]['idVehiculo']) && $arrCargas[2]['idVehiculo'] != ''){     $a .= ",'".$arrCargas[2]['idVehiculo']."'" ;    }else{$a .=",''";}
					if(isset($arrCargas[3]['idVehiculo']) && $arrCargas[3]['idVehiculo'] != ''){     $a .= ",'".$arrCargas[3]['idVehiculo']."'" ;    }else{$a .=",''";}
					if(isset($arrCargas[4]['idVehiculo']) && $arrCargas[4]['idVehiculo'] != ''){     $a .= ",'".$arrCargas[4]['idVehiculo']."'" ;    }else{$a .=",''";}
					if(isset($arrCargas[5]['idVehiculo']) && $arrCargas[5]['idVehiculo'] != ''){     $a .= ",'".$arrCargas[5]['idVehiculo']."'" ;    }else{$a .=",''";}
					if(isset($arrCargas[1]['Valor']) && $arrCargas[1]['Valor'] != ''){               $a .= ",'".$arrCargas[1]['Valor']."'" ;         }else{$a .=",''";}
					if(isset($arrCargas[2]['Valor']) && $arrCargas[2]['Valor'] != ''){               $a .= ",'".$arrCargas[2]['Valor']."'" ;         }else{$a .=",''";}
					if(isset($arrCargas[3]['Valor']) && $arrCargas[3]['Valor'] != ''){               $a .= ",'".$arrCargas[3]['Valor']."'" ;         }else{$a .=",''";}
					if(isset($arrCargas[4]['Valor']) && $arrCargas[4]['Valor'] != ''){               $a .= ",'".$arrCargas[4]['Valor']."'" ;         }else{$a .=",''";}
					if(isset($arrCargas[5]['Valor']) && $arrCargas[5]['Valor'] != ''){               $a .= ",'".$arrCargas[5]['Valor']."'" ;         }else{$a .=",''";}
					if(isset($Subtotal) && $Subtotal != ''){                                         $a .= ",'".$Subtotal."'" ;                      }else{$a .=",''";}
					if(isset($Atraso) && $Atraso != ''){                                             $a .= ",'".$Atraso."'" ;                        }else{$a .=",''";}
					if(isset($Adelanto) && $Adelanto != ''){                                         $a .= ",'".$Adelanto."'" ;                      }else{$a .=",''";}
					if(isset($Total) && $Total != ''){                                               $a .= ",'".$Total."'" ;                         }else{$a .=",''";}
					$a .= ",'1'" ;
			
					$query  = "INSERT INTO `vehiculos_facturacion_listado_detalle` (idFacturacion, idSistema, idUsuario, Fecha, idMes, Ano, fCreacion,
					idApoderado,
					idHijos_1, idHijos_2, idHijos_3, idHijos_4, idHijos_5,
					idVehiculo_1, idVehiculo_2, idVehiculo_3, idVehiculo_4, idVehiculo_5,
					Monto_1, Monto_2, Monto_3, Monto_4, Monto_5,
					MontoSubTotal, MontoAtraso, MontoAdelanto, MontoTotal,
					idEstado) 
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
				}
		
				
				//Borro todas las sesiones
				unset($_SESSION['basicos']);
				unset($_SESSION['hijos']);
			
				//redirijo a la vista
				header( 'Location: '.$location.'&created=true' );
				die;
				
				
				
			}
			
			
		break;
/*******************************************************************************************************************/		
		case 'pago':	
		
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");

			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				/****************************************************************************************************/
				//Se Guarda el datyo con el pago realizado
				if(isset($idTipoPago) && $idTipoPago != ''){                      $a  = "'".$idTipoPago."'" ;             }else{$a  ="''";}
				if(isset($nDocPago) && $nDocPago != ''){                          $a .= ",'".$nDocPago."'" ;              }else{$a .=",''";}
				if(isset($Pagofecha) && $Pagofecha != ''){                        
					$a .= ",'".$Pagofecha."'" ;
					$a .= ",'".fecha2NdiaMes($Pagofecha)."'" ; 
					$a .= ",'".fecha2NMes($Pagofecha)."'" ; 
					$a .= ",'".fecha2Ano($Pagofecha)."'" ;             
				}else{
					$a .=",''";
					$a .=",''";
					$a .=",''";
					$a .=",''";
				}
				if(isset($montoPago) && $montoPago != ''){                        $a .= ",'".$montoPago."'" ;             }else{$a .=",''";}
				if(isset($idUsuarioPago) && $idUsuarioPago != ''){                $a .= ",'".$idUsuarioPago."'" ;         }else{$a .=",''";}
				if(isset($idApoderado) && $idApoderado != ''){                    $a .= ",'".$idApoderado."'" ;           }else{$a .=",''";}
				if(isset($idFacturacionDetalle) && $idFacturacionDetalle != ''){  $a .= ",'".$idFacturacionDetalle."'" ;  }else{$a .=",''";}
													
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `vehiculos_facturacion_pago` (idTipoPago, nDocPago, fechaPago, DiaPago, idMesPago, AnoPago, montoPago, idUsuarioPago,
				idApoderado, idFacturacionDetalle ) 
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
				//recibo el último id generado por mi sesion
				$ultimo_id = mysqli_insert_id($dbConn);
				/****************************************************************************************************/
				//Se revisa si ya hay un pago anterior en el mismo id
				$SIS_query = 'montoPago';
				$SIS_join  = '';
				$SIS_where = 'idFacturacionDetalle = "'.$idFacturacionDetalle.'"';
				$rowdataold = db_select_data (false, $SIS_query, 'vehiculos_facturacion_listado_detalle', $SIS_join, $SIS_where, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				//actualizo el estado de la ultima facturacion
				$a = "idFacturacionDetalle = '".$idFacturacionDetalle."'";
				//verifico que el saldo haya alcanzado para pagar
				if($montoPactado>$montoPago){
					$a .= ",idEstado='1'";
				}elseif($ultimo_pago<=$montoPago){
					$a .= ",idEstado='2'";
					//actualizo los registros
					$b = "idEstado = '2'";
					$resultado = db_update_data (false, $b, 'vehiculos_facturacion_listado_detalle', 'idApoderado = "'.$idApoderado.'" AND idEstado=1', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				}
				
				if(isset($idTipoPago) && $idTipoPago != ''){        $a .= ",idTipoPago='".$idTipoPago."'" ;}
				if(isset($nDocPago) && $nDocPago != ''){            $a .= ",nDocPago='".$nDocPago."'" ;}
				if(isset($Pagofecha) && $Pagofecha != ''){          
					$a .= ",Pagofecha='".$Pagofecha."'" ;
					$a .= ",PagoDia='".fecha2NdiaMes($Pagofecha)."'" ; 
					$a .= ",PagoidMes='".fecha2NMes($Pagofecha)."'" ; 
					$a .= ",PagoAno='".fecha2Ano($Pagofecha)."'" ;
				}
				//se verifica si se tiene algun pago anterior, si es asi se suman los montos
				if(isset($montoPago) && $montoPago != ''){ 
					if(isset($rowdataold['montoPago']) && $rowdataold['montoPago'] != ''){ 
						$nuevoMonto = $rowdataold['montoPago'] + $montoPago;
					}else{
						$nuevoMonto = $montoPago;
					}    
					$a .= ",montoPago='".$nuevoMonto."'" ;
				}
				if(isset($idUsuarioPago) && $idUsuarioPago != ''){  $a .= ",idUsuarioPago='".$idUsuarioPago."'" ;}
				if(isset($ultimo_id) && $ultimo_id != ''){          $a .= ",idPago='".$ultimo_id."'" ;}
				//actualizo los registros
				$resultado = db_update_data (false, $a, 'vehiculos_facturacion_listado_detalle', 'idFacturacionDetalle = "'.$idFacturacionDetalle.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				
				//redirijo a la vista
				header( 'Location: '.$location.'&created=true' );
				die;
			}

	
				
		break;		

/*******************************************************************************************************************/
	}
?>

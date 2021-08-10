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
	if ( !empty($_POST['idTrabajador']) )                $idTrabajador                 = $_POST['idTrabajador'];
	if ( !empty($_POST['idSistema']) )                   $idSistema                    = $_POST['idSistema'];
	if ( !empty($_POST['idEstado']) )                    $idEstado                     = $_POST['idEstado'];
	if ( !empty($_POST['Nombre']) )                      $Nombre                       = $_POST['Nombre'];
	if ( !empty($_POST['ApellidoPat']) )                 $ApellidoPat                  = $_POST['ApellidoPat'];
	if ( !empty($_POST['ApellidoMat']) )                 $ApellidoMat                  = $_POST['ApellidoMat'];
	if ( !empty($_POST['idTipo']) )                      $idTipo                       = $_POST['idTipo'];
	if ( !empty($_POST['Cargo']) )                       $Cargo                        = $_POST['Cargo'];
	if ( !empty($_POST['Fono']) )                        $Fono                         = $_POST['Fono'];
	if ( !empty($_POST['Rut']) )                         $Rut                          = $_POST['Rut'];
	if ( !empty($_POST['idCiudad']) )                    $idCiudad                     = $_POST['idCiudad'];
	if ( !empty($_POST['idComuna']) )                    $idComuna                     = $_POST['idComuna'];
	if ( !empty($_POST['Direccion']) )                   $Direccion                    = $_POST['Direccion'];
	if ( !empty($_POST['Observaciones']) )               $Observaciones                = $_POST['Observaciones'];
	if ( !empty($_POST['idLicitacion']) )                $idLicitacion                 = $_POST['idLicitacion'];
	if ( !empty($_POST['F_Inicio_Contrato']) )           $F_Inicio_Contrato            = $_POST['F_Inicio_Contrato'];
	if ( !empty($_POST['F_Termino_Contrato']) )          $F_Termino_Contrato           = $_POST['F_Termino_Contrato'];
	if ( !empty($_POST['idAFP']) )                       $idAFP                        = $_POST['idAFP'];
	if ( !empty($_POST['idSalud']) )                     $idSalud                      = $_POST['idSalud'];
	if ( !empty($_POST['idTipoContrato']) )              $idTipoContrato               = $_POST['idTipoContrato'];
	if ( !empty($_POST['idTipoLicencia']) )              $idTipoLicencia               = $_POST['idTipoLicencia'];
	if ( !empty($_POST['CA_Licencia']) )                 $CA_Licencia                  = $_POST['CA_Licencia'];
	if ( !empty($_POST['LicenciaFechaControl']) )        $LicenciaFechaControl         = $_POST['LicenciaFechaControl'];
	if ( !empty($_POST['LicenciaFechaControlUltimo']) )  $LicenciaFechaControlUltimo   = $_POST['LicenciaFechaControlUltimo'];
	if ( !empty($_POST['ContactoPersona']) )             $ContactoPersona              = $_POST['ContactoPersona'];
	if ( !empty($_POST['ContactoFono']) )                $ContactoFono                 = $_POST['ContactoFono'];
	if ( !empty($_POST['idSexo']) )                      $idSexo                       = $_POST['idSexo'];
	if ( !empty($_POST['FNacimiento']) )                 $FNacimiento                  = $_POST['FNacimiento'];
	if ( !empty($_POST['idEstadoCivil']) )               $idEstadoCivil                = $_POST['idEstadoCivil'];
	if ( !empty($_POST['SueldoLiquido']) )               $SueldoLiquido                = $_POST['SueldoLiquido'];
	if ( !empty($_POST['email']) )                       $email                        = $_POST['email'];
	if ( !empty($_POST['idTransporte']) )                $idTransporte                 = $_POST['idTransporte'];
	if ( !empty($_POST['File_RHTM_Fecha']) )             $File_RHTM_Fecha              = $_POST['File_RHTM_Fecha'];
	
	
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
			case 'idTrabajador':                if(empty($idTrabajador)){                 $error['idTrabajador']                 = 'error/No ha ingresado el id';}break;
			case 'idSistema':                   if(empty($idSistema)){                    $error['idSistema']                    = 'error/No ha seleccionado el sistema al cual pertenece';}break;
			case 'idEstado':                    if(empty($idEstado)){                     $error['idEstado']                     = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':                      if(empty($Nombre)){                       $error['Nombre']                       = 'error/No ha ingresado el nombre de la persona';}break;
			case 'ApellidoPat':                 if(empty($ApellidoPat)){                  $error['ApellidoPat']                  = 'error/No ha ingresado el apellido paterno de la persona';}break;
			case 'ApellidoMat':                 if(empty($ApellidoMat)){                  $error['ApellidoMat']                  = 'error/No ha ingresado el apellido materno de la persona';}break;
			case 'idTipo':                      if(empty($idTipo)){                       $error['idTipo']                       = 'error/No ha seleccionado el tipo de trabajador';}break;
			case 'Cargo':                       if(empty($Cargo)){                        $error['Cargo']                        = 'error/No ha ingresado el cargo a desempeñar';}break;
			case 'Fono':                        if(empty($Fono)){                         $error['Fono']                         = 'error/No ha ingresado el fono';}break;
			case 'Rut':                         if(empty($Rut)){                          $error['Rut']                          = 'error/No ha ingresado el rut';}break;
			case 'idCiudad':                    if(empty($idCiudad)){                     $error['idCiudad']                     = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':                    if(empty($idComuna)){                     $error['idComuna']                     = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':                   if(empty($Direccion)){                    $error['Direccion']                    = 'error/No ha ingresado la direccion';}break;
			case 'Observaciones':               if(empty($Observaciones)){                $error['Observaciones']                = 'error/No ha ingresado la observacion';}break;
			case 'idLicitacion':                if(empty($idLicitacion)){                 $error['idLicitacion']                 = 'error/No ha seleccionado el proyecto';}break;
			case 'F_Inicio_Contrato':           if(empty($F_Inicio_Contrato)){            $error['F_Inicio_Contrato']            = 'error/No ha ingresado la fecha de inicio';}break;
			case 'F_Termino_Contrato':          if(empty($F_Termino_Contrato)){           $error['F_Termino_Contrato']           = 'error/No ha ingresado la fecha de termino';}break;
			case 'idAFP':                       if(empty($idAFP)){                        $error['idAFP']                        = 'error/No ha seleccionado la AFP';}break;
			case 'idSalud':                     if(empty($idSalud)){                      $error['idSalud']                      = 'error/No ha seleccionado el Siste de salud';}break;
			case 'idTipoContrato':              if(empty($idTipoContrato)){               $error['idTipoContrato']               = 'error/No ha Seleccionado el tipo de contrato';}break;
			case 'idTipoLicencia':              if(empty($idTipoLicencia)){               $error['idTipoLicencia']               = 'error/No ha Seleccionado el tipo de licencia';}break;
			case 'CA_Licencia':                 if(empty($CA_Licencia)){                  $error['CA_Licencia']                  = 'error/No ha ingresado el Numero CA de la licencia';}break;
			case 'LicenciaFechaControl':        if(empty($LicenciaFechaControl)){         $error['LicenciaFechaControl']         = 'error/No ha ingresado la fecha de control';}break;
			case 'LicenciaFechaControlUltimo':  if(empty($LicenciaFechaControlUltimo)){   $error['LicenciaFechaControlUltimo']   = 'error/No ha ingresado la ultima fecha de control';}break;
			case 'ContactoPersona':             if(empty($ContactoPersona)){              $error['ContactoPersona']              = 'error/No ha ingresado la persona de contacto';}break;
			case 'ContactoFono':                if(empty($ContactoFono)){                 $error['ContactoFono']                 = 'error/No ha ingresado el fono de la persona de contacto';}break;
			case 'idSexo':                      if(empty($idSexo)){                       $error['idSexo']                       = 'error/No ha seleccionado el sexo';}break;
			case 'FNacimiento':                 if(empty($FNacimiento)){                  $error['FNacimiento']                  = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'idEstadoCivil':               if(empty($idEstadoCivil)){                $error['idEstadoCivil']                = 'error/No ha seleccionado estado civil';}break;
			case 'SueldoLiquido':               if(empty($SueldoLiquido)){                $error['SueldoLiquido']                = 'error/No ha ingresado el sueldo liquido a pago';}break;
			case 'email':                       if(empty($email)){                        $error['email']                        = 'error/No ha ingresado el email del trabajador';}break;
			case 'idTransporte':                if(empty($idTransporte)){                 $error['idTransporte']                 = 'error/No ha seleccionado el transporte';}break;
			case 'File_RHTM_Fecha':             if(empty($File_RHTM_Fecha)){              $error['File_RHTM_Fecha']              = 'error/No ha ingresado una fecha de termino de RHTM';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
	//Verifica si el mail corresponde
	if(isset($Fono)&&!validarNumero($Fono)) {   $error['Fono']    = 'error/Ingrese un numero telefonico valido'; }
	if(isset($Rut)&&!validarRut($Rut)){         $error['Rut']     = 'error/El Rut ingresado no es valido'; }
	if(isset($email)&&!validarEmail($email)){   $error['email']   = 'error/El Email ingresado no es valido'; }
	
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
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'trabajadores_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'trabajadores_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El trabajador que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//filtros
				if(isset($idSistema) && $idSistema != ''){                                      $a  = "'".$idSistema."'" ;                     }else{$a  = "''";}
				if(isset($idEstado) && $idEstado != ''){                                        $a .= ",'".$idEstado."'" ;                     }else{$a .= ",''";}
				if(isset($Nombre) && $Nombre != ''){                                            $a .= ",'".$Nombre."'" ;                       }else{$a .= ",''";}
				if(isset($ApellidoPat) && $ApellidoPat != ''){                                  $a .= ",'".$ApellidoPat."'" ;                  }else{$a .= ",''";}
				if(isset($ApellidoMat) && $ApellidoMat != ''){                                  $a .= ",'".$ApellidoMat."'" ;                  }else{$a .= ",''";}
				if(isset($idTipo) && $idTipo != ''){                                            $a .= ",'".$idTipo."'" ;                       }else{$a .= ",''";}
				if(isset($Cargo) && $Cargo != ''){                                              $a .= ",'".$Cargo."'" ;                        }else{$a .= ",''";}
				if(isset($Fono) && $Fono != ''){                                                $a .= ",'".$Fono."'" ;                         }else{$a .= ",''";}
				if(isset($Rut) && $Rut != ''){                                                  $a .= ",'".$Rut."'" ;                          }else{$a .= ",''";}
				if(isset($idCiudad) && $idCiudad != ''){                                        $a .= ",'".$idCiudad."'" ;                     }else{$a .= ",''";}
				if(isset($idComuna) && $idComuna != ''){                                        $a .= ",'".$idComuna."'" ;                     }else{$a .= ",''";}
				if(isset($Direccion) && $Direccion != ''){                                      $a .= ",'".$Direccion."'" ;                    }else{$a .= ",''";}
				if(isset($Observaciones) && $Observaciones != ''){                              $a .= ",'".$Observaciones."'" ;                }else{$a .= ",''";}
				if(isset($idLicitacion) && $idLicitacion != ''){                                $a .= ",'".$idLicitacion."'" ;                 }else{$a .= ",''";}
				if(isset($F_Inicio_Contrato) && $F_Inicio_Contrato != ''){                      $a .= ",'".$F_Inicio_Contrato."'" ;            }else{$a .= ",''";}
				if(isset($F_Termino_Contrato) && $F_Termino_Contrato != ''){                    $a .= ",'".$F_Termino_Contrato."'" ;           }else{$a .= ",''";}
				if(isset($idAFP) && $idAFP != ''){                                              $a .= ",'".$idAFP."'" ;                        }else{$a .= ",''";}
				if(isset($idSalud) && $idSalud != ''){                                          $a .= ",'".$idSalud."'" ;                      }else{$a .= ",''";}
				if(isset($idTipoContrato) && $idTipoContrato != ''){                            $a .= ",'".$idTipoContrato."'" ;               }else{$a .= ",''";}
				if(isset($idTipoLicencia) && $idTipoLicencia != ''){                            $a .= ",'".$idTipoLicencia."'" ;               }else{$a .= ",''";}
				if(isset($CA_Licencia) && $CA_Licencia != ''){                                  $a .= ",'".$CA_Licencia."'" ;                  }else{$a .= ",''";}
				if(isset($LicenciaFechaControl) && $LicenciaFechaControl != ''){                $a .= ",'".$LicenciaFechaControl."'" ;         }else{$a .= ",''";}
				if(isset($LicenciaFechaControlUltimo) && $LicenciaFechaControlUltimo != ''){    $a .= ",'".$LicenciaFechaControlUltimo."'" ;   }else{$a .= ",''";}
				if(isset($ContactoPersona) && $ContactoPersona != ''){                          $a .= ",'".$ContactoPersona."'" ;              }else{$a .= ",''";}
				if(isset($ContactoFono) && $ContactoFono != ''){                                $a .= ",'".$ContactoFono."'" ;                 }else{$a .= ",''";}
				if(isset($idSexo) && $idSexo != ''){                                            $a .= ",'".$idSexo."'" ;                       }else{$a .= ",''";}
				if(isset($FNacimiento) && $FNacimiento != ''){                                  $a .= ",'".$FNacimiento."'" ;                  }else{$a .= ",''";}
				if(isset($idEstadoCivil) && $idEstadoCivil != ''){                              $a .= ",'".$idEstadoCivil."'" ;                }else{$a .= ",''";}
				if(isset($SueldoLiquido) && $SueldoLiquido != ''){                              $a .= ",'".$SueldoLiquido."'" ;                }else{$a .= ",''";}
				if(isset($SueldoDia) && $SueldoDia != ''){                                      $a .= ",'".$SueldoDia."'" ;                    }else{$a .= ",''";}
				if(isset($SueldoHora) && $SueldoHora != ''){                                    $a .= ",'".$SueldoHora."'" ;                   }else{$a .= ",''";}
				if(isset($idTransporte) && $idTransporte != ''){                                $a .= ",'".$idTransporte."'" ;                 }else{$a .= ",''";}
				if(isset($idTipoContratoTrab) && $idTipoContratoTrab != ''){                    $a .= ",'".$idTipoContratoTrab."'" ;           }else{$a .= ",''";}
				if(isset($horas_pactadas) && $horas_pactadas != ''){                            $a .= ",'".$horas_pactadas."'" ;               }else{$a .= ",''";}
				if(isset($Gratificacion) && $Gratificacion != ''){                              $a .= ",'".$Gratificacion."'" ;                }else{$a .= ",''";}
				if(isset($idTipoTrabajador) && $idTipoTrabajador != ''){                        $a .= ",'".$idTipoTrabajador."'" ;             }else{$a .= ",''";}
				if(isset($idContratista) && $idContratista != ''){                              $a .= ",'".$idContratista."'" ;                }else{$a .= ",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `trabajadores_listado` (idSistema, idEstado, Nombre, ApellidoPat, 
				ApellidoMat, idTipo, Cargo, Fono, Rut, idCiudad, idComuna, Direccion, Observaciones, 
				idLicitacion, F_Inicio_Contrato, F_Termino_Contrato, idAFP, idSalud, idTipoContrato,
				idTipoLicencia,CA_Licencia,LicenciaFechaControl,LicenciaFechaControlUltimo,ContactoPersona,
				ContactoFono, idSexo, FNacimiento, idEstadoCivil, SueldoLiquido, SueldoDia, SueldoHora,
				idTransporte, idTipoContratoTrab, horas_pactadas, Gratificacion, idTipoTrabajador,
				idContratista) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//recibo el último id generado por mi sesion
				$ultimo_id = mysqli_insert_id($dbConn);
						
				header( 'Location: '.$location.'&id='.$ultimo_id.'&created=true' );
				die;
					
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
			//Se verifica si el dato existe
			if(isset($Nombre)&&isset($ApellidoPat)&&isset($ApellidoMat)&&isset($idSistema)&&isset($idTrabajador)){
				$ndata_1 = db_select_nrows (false, 'Nombre', 'trabajadores_listado', '', "Nombre='".$Nombre."' AND ApellidoPat='".$ApellidoPat."' AND ApellidoMat='".$ApellidoMat."' AND idSistema='".$idSistema."' AND idTrabajador!='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			if(isset($Rut)&&isset($idSistema)&&isset($idTrabajador)){
				$ndata_2 = db_select_nrows (false, 'Rut', 'trabajadores_listado', '', "Rut='".$Rut."' AND idSistema='".$idSistema."' AND idTrabajador!='".$idTrabajador."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/El trabajador que intenta ingresar ya existe en el sistema';}
			if($ndata_2 > 0) {$error['ndata_2'] = 'error/El Rut ya existe en el sistema';}
			/*******************************************************************/
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idTrabajador='".$idTrabajador."'" ;
				if(isset($idSistema) && $idSistema != ''){                                      $a .= ",idSistema='".$idSistema."'" ;}
				if(isset($idEstado) && $idEstado != ''){                                        $a .= ",idEstado='".$idEstado."'" ;}
				if(isset($Nombre) && $Nombre != ''){                                            $a .= ",Nombre='".$Nombre."'" ;}
				if(isset($ApellidoPat) && $ApellidoPat != ''){                                  $a .= ",ApellidoPat='".$ApellidoPat."'" ;}
				if(isset($ApellidoMat) && $ApellidoMat != ''){                                  $a .= ",ApellidoMat='".$ApellidoMat."'" ;}
				if(isset($idTipo) && $idTipo != ''){                                            $a .= ",idTipo='".$idTipo."'" ;}
				if(isset($Cargo) && $Cargo != ''){                                              $a .= ",Cargo='".$Cargo."'" ;}
				if(isset($Fono) && $Fono != ''){                                                $a .= ",Fono='".$Fono."'" ;}
				if(isset($Rut) && $Rut != ''){                                                  $a .= ",Rut='".$Rut."'" ;}
				if(isset($idCiudad) && $idCiudad != ''){                                        $a .= ",idCiudad='".$idCiudad."'" ;}
				if(isset($idComuna) && $idComuna != ''){                                        $a .= ",idComuna='".$idComuna."'" ;}
				if(isset($Direccion) && $Direccion != ''){                                      $a .= ",Direccion='".$Direccion."'" ;}
				if(isset($Observaciones) && $Observaciones != ''){                              $a .= ",Observaciones='".$Observaciones."'" ;}
				if(isset($idLicitacion) && $idLicitacion != ''){                                $a .= ",idLicitacion='".$idLicitacion."'" ;}
				if(isset($F_Inicio_Contrato) && $F_Inicio_Contrato != ''){                      $a .= ",F_Inicio_Contrato='".$F_Inicio_Contrato."'" ;}
				if(isset($F_Termino_Contrato) && $F_Termino_Contrato != ''){                    $a .= ",F_Termino_Contrato='".$F_Termino_Contrato."'" ;}
				if(isset($idAFP) && $idAFP != ''){                                              $a .= ",idAFP='".$idAFP."'" ;}
				if(isset($idSalud) && $idSalud != ''){                                          $a .= ",idSalud='".$idSalud."'" ;}
				if(isset($idTipoContrato) && $idTipoContrato != ''){                            $a .= ",idTipoContrato='".$idTipoContrato."'" ;}
				if(isset($idTipoLicencia) && $idTipoLicencia != ''){                            $a .= ",idTipoLicencia='".$idTipoLicencia."'" ;}
				if(isset($CA_Licencia) && $CA_Licencia != ''){                                  $a .= ",CA_Licencia='".$CA_Licencia."'" ;}
				if(isset($LicenciaFechaControl) && $LicenciaFechaControl != ''){                $a .= ",LicenciaFechaControl='".$LicenciaFechaControl."'" ;}
				if(isset($LicenciaFechaControlUltimo) && $LicenciaFechaControlUltimo != ''){    $a .= ",LicenciaFechaControlUltimo='".$LicenciaFechaControlUltimo."'" ;}
				if(isset($ContactoPersona) && $ContactoPersona != ''){                          $a .= ",ContactoPersona='".$ContactoPersona."'" ;}
				if(isset($ContactoFono) && $ContactoFono != ''){                                $a .= ",ContactoFono='".$ContactoFono."'" ;}
				if(isset($idSexo) && $idSexo != ''){                                            $a .= ",idSexo='".$idSexo."'" ;}
				if(isset($FNacimiento) && $FNacimiento != ''){                                  $a .= ",FNacimiento='".$FNacimiento."'" ;}
				if(isset($idEstadoCivil) && $idEstadoCivil != ''){                              $a .= ",idEstadoCivil='".$idEstadoCivil."'" ;}
				if(isset($SueldoLiquido) && $SueldoLiquido != ''){                              $a .= ",SueldoLiquido='".$SueldoLiquido."'" ;}
				if(isset($idTransporte) && $idTransporte != ''){                                $a .= ",idTransporte='".$idTransporte."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				//Si ejecuto correctamente la consulta
				if($resultado==true){
					//redirijo
					header( 'Location: '.$location.'&edited=true' );
					die;
				}
				
				
			}
		
	
		break;	
/*******************************************************************************************************************/
		//Cambio el estado de activo a inactivo
		case 'estado':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			$idTrabajador  = $_GET['id'];
			$idEstado      = $_GET['estado'];
			//se actualizan los datos
			$a = 'idEstado = '.$idEstado;
			$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				header( 'Location: '.$location.'&edited=true' );
				die; 
			}


		break;				
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_img':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			if ($_FILES["Direccion_img"]["error"] > 0){ 
				$error['Direccion_img'] = 'error/'.uploadPHPError($_FILES["Direccion_img"]["error"]); 
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png");
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 1000;
				//Sufijo
				$sufijo = 'trab_img_'.$idTrabajador.'_';
							  
				if (in_array($_FILES['Direccion_img']['type'], $permitidos) && $_FILES['Direccion_img']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['Direccion_img']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$resultado = @move_uploaded_file($_FILES["Direccion_img"]["tmp_name"], $ruta);
						if ($resultado){
											
							//Filtro para idSistema
							$a = "Direccion_img='".$sufijo.$_FILES['Direccion_img']['name']."'" ;

							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							
							//redirijo
							header( 'Location: '.$location );
							die;
											
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


		break;	
/*******************************************************************************************************************/
		case 'del_img':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'Direccion_img', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se actualizan los datos
			$a = 'Direccion_img=""';
			$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_img'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
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

		break;	
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_curriculum':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			if ($_FILES["File_Curriculum"]["error"] > 0){ 
				$error['File_Curriculum'] = 'error/'.uploadPHPError($_FILES["File_Curriculum"]["error"]); 
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
											
									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",
									
									"image/jpg", 
									"image/jpeg", 
									"image/gif", 
									"image/png"

											);
											
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'trab_curriculum_'.$idTrabajador.'_';
			  
				if (in_array($_FILES['File_Curriculum']['type'], $permitidos) && $_FILES['File_Curriculum']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['File_Curriculum']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$resultado = @move_uploaded_file($_FILES["File_Curriculum"]["tmp_name"], $ruta);
						if ($resultado){
					
							//Filtro para idSistema
							$a = "File_Curriculum='".$sufijo.$_FILES['File_Curriculum']['name']."'" ;

							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							
							//redirijo
							header( 'Location: '.$location );
							die;
					
					
						} else {
							$error['File_Curriculum']     = 'error/Ocurrio un error al mover el archivo'; 
						}
					} else {
						$error['File_Curriculum']     = 'error/El archivo '.$_FILES['File_Curriculum']['name'].' ya existe'; 
					}
				} else {
					$error['File_Curriculum']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'; 
				}
			}


		break;	
/*******************************************************************************************************************/
		case 'del_File_Curriculum':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'File_Curriculum', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Curriculum'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);

			//se actualizan los datos
			$a = 'File_Curriculum=""';
			$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Curriculum'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
			//se elimina el archivo
			if(isset($rowdata['File_Curriculum'])&&$rowdata['File_Curriculum']!=''){
				try {
					if(!is_writable(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Curriculum'])){
						//throw new Exception('File not writable');
					}else{
						unlink(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Curriculum']);
					}
				}catch(Exception $e) { 
					//guardar el dato en un archivo log
				}
			}
			
			//Redirijo			
			header( 'Location: '.$location.'&id_img=true' );
			die;

		break;	
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_antecedentes':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			if ($_FILES["File_Antecedentes"]["error"] > 0){ 
				$error['File_Antecedentes'] = 'error/'.uploadPHPError($_FILES["File_Antecedentes"]["error"]); 
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
											
									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",
									
									"image/jpg", 
									"image/jpeg", 
									"image/gif", 
									"image/png"

											);
											
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'trab_antecedentes_'.$idTrabajador.'_';
			  
				if (in_array($_FILES['File_Antecedentes']['type'], $permitidos) && $_FILES['File_Antecedentes']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['File_Antecedentes']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$resultado = @move_uploaded_file($_FILES["File_Antecedentes"]["tmp_name"], $ruta);
						if ($resultado){
					
							//Filtro para idSistema
							$a = "File_Antecedentes='".$sufijo.$_FILES['File_Antecedentes']['name']."'" ;
							
							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
							//redirijo
							header( 'Location: '.$location );
							die;
					
					
						} else {
							$error['File_Antecedentes']     = 'error/Ocurrio un error al mover el archivo'; 
						}
					} else {
						$error['File_Antecedentes']     = 'error/El archivo '.$_FILES['File_Antecedentes']['name'].' ya existe'; 
					}
				} else {
					$error['File_Antecedentes']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'; 
				}
			}


		break;	
/*******************************************************************************************************************/
		case 'del_File_Antecedentes':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'File_Antecedentes', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Antecedentes'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se actualizan los datos
			$a = 'File_Antecedentes=""';
			$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Antecedentes'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
			//se elimina el archivo
			if(isset($rowdata['File_Antecedentes'])&&$rowdata['File_Antecedentes']!=''){
				try {
					if(!is_writable(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Antecedentes'])){
						//throw new Exception('File not writable');
					}else{
						unlink(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Antecedentes']);
					}
				}catch(Exception $e) { 
					//guardar el dato en un archivo log
				}
			}
			
			//Redirijo			
			header( 'Location: '.$location.'&id_img=true' );
			die;

		break;	
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_carnet':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			if ($_FILES["File_Carnet"]["error"] > 0){ 
				$error['File_Carnet'] = 'error/'.uploadPHPError($_FILES["File_Carnet"]["error"]); 
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
											
									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",
									
									"image/jpg", 
									"image/jpeg", 
									"image/gif", 
									"image/png"

											);
											
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'trab_carnet_'.$idTrabajador.'_';
			  
				if (in_array($_FILES['File_Carnet']['type'], $permitidos) && $_FILES['File_Carnet']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['File_Carnet']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$resultado = @move_uploaded_file($_FILES["File_Carnet"]["tmp_name"], $ruta);
						if ($resultado){
					
							//Filtro para idSistema
							$a = "File_Carnet='".$sufijo.$_FILES['File_Carnet']['name']."'" ;
							
							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							
							//redirijo
							header( 'Location: '.$location );
							die;
					
						} else {
							$error['File_Carnet']     = 'error/Ocurrio un error al mover el archivo'; 
						}
					} else {
						$error['File_Carnet']     = 'error/El archivo '.$_FILES['File_Carnet']['name'].' ya existe'; 
					}
				} else {
					$error['File_Carnet']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'; 
				}
			}


		break;	
/*******************************************************************************************************************/
		case 'del_File_Carnet':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'File_Carnet', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Carnet'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se actualizan los datos
			$a = 'File_Carnet=""';
			$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Carnet'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
			//se elimina el archivo
			if(isset($rowdata['File_Carnet'])&&$rowdata['File_Carnet']!=''){
				try {
					if(!is_writable(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Carnet'])){
						//throw new Exception('File not writable');
					}else{
						unlink(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Carnet']);
					}
				}catch(Exception $e) { 
					//guardar el dato en un archivo log
				}
			}
			
			//Redirijo			
			header( 'Location: '.$location.'&id_img=true' );
			die;

		break;	
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_contrato':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			if ($_FILES["File_Contrato"]["error"] > 0){ 
				$error['File_Contrato'] = 'error/'.uploadPHPError($_FILES["File_Contrato"]["error"]); 
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
											
									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",
									
									"image/jpg", 
									"image/jpeg", 
									"image/gif", 
									"image/png"

											);
											
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'trab_contrato_'.$idTrabajador.'_';
			  
				if (in_array($_FILES['File_Contrato']['type'], $permitidos) && $_FILES['File_Contrato']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['File_Contrato']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$resultado = @move_uploaded_file($_FILES["File_Contrato"]["tmp_name"], $ruta);
						if ($resultado){
					
							//Filtro para idSistema
							$a = "File_Contrato='".$sufijo.$_FILES['File_Contrato']['name']."'" ;
							
							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
							//redirijo
							header( 'Location: '.$location );
							die;
					
						} else {
							$error['File_Contrato']     = 'error/Ocurrio un error al mover el archivo'; 
						}
					} else {
						$error['File_Contrato']     = 'error/El archivo '.$_FILES['File_Contrato']['name'].' ya existe'; 
					}
				} else {
					$error['File_Contrato']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'; 
				}
			}


		break;	
/*******************************************************************************************************************/
		case 'del_File_Contrato':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'File_Contrato', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Contrato'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se actualizan los datos
			$a = 'File_Contrato=""';
			$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Contrato'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
			//se elimina el archivo
			if(isset($rowdata['File_Contrato'])&&$rowdata['File_Contrato']!=''){
				try {
					if(!is_writable(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Contrato'])){
						//throw new Exception('File not writable');
					}else{
						unlink(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Contrato']);
					}
				}catch(Exception $e) { 
					//guardar el dato en un archivo log
				}
			}
			
			//Redirijo			
			header( 'Location: '.$location.'&id_img=true' );
			die;

		break;	
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_File_Licencia':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//Filtros
				$a = "idTrabajador='".$idTrabajador."'" ;
				if(isset($idTipoLicencia) && $idTipoLicencia != ''){                            $a .= ",idTipoLicencia='".$idTipoLicencia."'" ;}
				if(isset($CA_Licencia) && $CA_Licencia != ''){                                  $a .= ",CA_Licencia='".$CA_Licencia."'" ;}
				if(isset($LicenciaFechaControl) && $LicenciaFechaControl != ''){                $a .= ",LicenciaFechaControl='".$LicenciaFechaControl."'" ;}
				if(isset($LicenciaFechaControlUltimo) && $LicenciaFechaControlUltimo != ''){    $a .= ",LicenciaFechaControlUltimo='".$LicenciaFechaControlUltimo."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				if ($_FILES["File_Licencia"]["error"] > 0){ 
					$error['File_Licencia'] = 'error/'.uploadPHPError($_FILES["File_Licencia"]["error"]); 
				} else {
					//Se verifican las extensiones de los archivos
					$permitidos = array("application/msword",
										"application/vnd.ms-word",
										"application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
												
										"application/pdf",
										"application/octet-stream",
										"application/x-real",
										"application/vnd.adobe.xfdf",
										"application/vnd.fdf",
										"binary/octet-stream",
										
										"image/jpg", 
										"image/jpeg", 
										"image/gif", 
										"image/png"

												);
												
					//Se verifica que el archivo subido no exceda los 100 kb
					$limite_kb = 10000;
					//Sufijo
					$sufijo = 'trab_licencia_'.$idTrabajador.'_';
				  
					if (in_array($_FILES['File_Licencia']['type'], $permitidos) && $_FILES['File_Licencia']['size'] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['File_Licencia']['name'];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							$resultado = @move_uploaded_file($_FILES["File_Licencia"]["tmp_name"], $ruta);
							if ($resultado){
						
								//Filtro para idSistema
								$a = "File_Licencia='".$sufijo.$_FILES['File_Licencia']['name']."'" ;
								
								//se actualizan los datos
								$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
								//redirijo
								header( 'Location: '.$location );
								die;
						
						
							} else {
								$error['File_Licencia']     = 'error/Ocurrio un error al mover el archivo'; 
							}
						} else {
							$error['File_Licencia']     = 'error/El archivo '.$_FILES['File_Licencia']['name'].' ya existe'; 
						}
					} else {
						$error['File_Licencia']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'; 
					}
				}
			}


		break;	
/*******************************************************************************************************************/
		case 'del_File_Licencia':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'File_Licencia', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_Licencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se actualizan los datos
			$a = 'File_Licencia=""';
			$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_Licencia'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
			//se elimina el archivo
			if(isset($rowdata['File_Licencia'])&&$rowdata['File_Licencia']!=''){
				try {
					if(!is_writable(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Licencia'])){
						//throw new Exception('File not writable');
					}else{
						unlink(DB_SITE_ALT_1.'/upload/'.$rowdata['File_Licencia']);
					}
				}catch(Exception $e) { 
					//guardar el dato en un archivo log
				}
			}
			
			//Redirijo			
			header( 'Location: '.$location.'&id_img=true' );
			die;

		break;	
/*******************************************************************************************************************/
		//Cambia el nivel del permiso
		case 'submit_rhtm':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			if ($_FILES["File_RHTM"]["error"] > 0){ 
				$error['File_RHTM'] = 'error/'.uploadPHPError($_FILES["File_RHTM"]["error"]); 
			} else {
				//Se verifican las extensiones de los archivos
				$permitidos = array("application/msword",
									"application/vnd.ms-word",
									"application/vnd.openxmlformats-officedocument.wordprocessingml.document", 
											
									"application/pdf",
									"application/octet-stream",
									"application/x-real",
									"application/vnd.adobe.xfdf",
									"application/vnd.fdf",
									"binary/octet-stream",
									
									"image/jpg", 
									"image/jpeg", 
									"image/gif", 
									"image/png"

											);
											
				//Se verifica que el archivo subido no exceda los 100 kb
				$limite_kb = 10000;
				//Sufijo
				$sufijo = 'trab_rhtm_'.$idTrabajador.'_';
			  
				if (in_array($_FILES['File_RHTM']['type'], $permitidos) && $_FILES['File_RHTM']['size'] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = DB_SITE_ALT_1.'/upload/'.$sufijo.$_FILES['File_RHTM']['name'];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (!file_exists($ruta)){
						//Se mueve el archivo a la carpeta previamente configurada
						$move_result = @move_uploaded_file($_FILES["File_RHTM"]["tmp_name"], $ruta);
						if ($move_result){
					
							//Filtro para idSistema
							$a = "File_RHTM='".$sufijo.$_FILES['File_RHTM']['name']."'" ;
							if(isset($File_RHTM_Fecha) && $File_RHTM_Fecha != ''){   $a .= ",File_RHTM_Fecha='".$File_RHTM_Fecha."'" ;}
							
							//se actualizan los datos
							$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$idTrabajador.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
							//Si ejecuto correctamente la consulta
							if($resultado==true){
								
								header( 'Location: '.$location );
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
							$error['File_RHTM']     = 'error/Ocurrio un error al mover el archivo'; 
						}
					} else {
						$error['File_RHTM']     = 'error/El archivo '.$_FILES['File_RHTM']['name'].' ya existe'; 
					}
				} else {
					$error['File_RHTM']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'; 
				}
			}


		break;	
/*******************************************************************************************************************/
		case 'del_File_RHTM':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// Se obtiene el nombre del logo
			$rowdata = db_select_data (false, 'File_RHTM', 'trabajadores_listado', '', 'idTrabajador = "'.$_GET['del_File_RHTM'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
			//se actualizan los datos
			$a = 'File_RHTM="", File_RHTM_Fecha=""';
			$resultado = db_update_data (false, $a, 'trabajadores_listado', 'idTrabajador = "'.$_GET['del_File_RHTM'].'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			//Si ejecuto correctamente la consulta
			if($resultado==true){
				
				//se elimina el archivo
				if(isset($rowdata['File_RHTM'])&&$rowdata['File_RHTM']!=''){
					try {
						if(!is_writable(DB_SITE_ALT_1.'/upload/'.$rowdata['File_RHTM'])){
							//throw new Exception('File not writable');
						}else{
							unlink(DB_SITE_ALT_1.'/upload/'.$rowdata['File_RHTM']);
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

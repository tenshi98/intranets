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
	if ( !empty($_POST['idBusqueda']) )   $idBusqueda     = simpleDecode($_POST['idBusqueda'], fecha_actual());
	if ( !empty($_POST['idSistema']) )    $idSistema      = simpleDecode($_POST['idSistema'], fecha_actual());
	if ( !empty($_POST['idCliente']) )    $idCliente      = simpleDecode($_POST['idCliente'], fecha_actual());
	if ( !empty($_POST['Fecha']) )        $Fecha          = $_POST['Fecha'];
	if ( !empty($_POST['Hora']) )         $Hora           = $_POST['Hora'];
	if ( !empty($_POST['Patente']) )      $Patente        = $_POST['Patente'];
	
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
			case 'idBusqueda':    if(empty($idBusqueda)){    $error['idBusqueda']    = 'error/No ha ingresado el id';}break;
			case 'idSistema':     if(empty($idSistema)){     $error['idSistema']     = 'error/No ha seleccionado el sistema';}break;
			case 'idCliente':     if(empty($idCliente)){     $error['idCliente']     = 'error/No ha seleccionado el cliente';}break;
			case 'Fecha':         if(empty($Fecha)){         $error['Fecha']         = 'error/No ha ingresado la fecha';}break;
			case 'Hora':          if(empty($Hora)){          $error['Hora']          = 'error/No ha ingresado la hora';}break;
			case 'Patente':       if(empty($Patente)){       $error['Patente']       = 'error/No ha ingresado la patente';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
	if(isset($Patente)&&contar_palabras_censuradas($Patente)!=0){  $error['Patente'] = 'error/Edita la Patente, contiene palabras no permitidas'; }	

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/		
		case 'search_patente':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				//Variables
				$Fecha = fecha_actual();
				$Hora  = hora_actual();
			
				//filtros
				if(isset($idSistema) && $idSistema != ''){   $a  = "'".$idSistema."'" ;    }else{$a  ="''";}
				if(isset($idCliente) && $idCliente != ''){   $a .= ",'".$idCliente."'" ;   }else{$a .=",''";}
				if(isset($Fecha) && $Fecha != ''){           $a .= ",'".$Fecha."'" ;       }else{$a .=",''";}
				if(isset($Hora) && $Hora != ''){             $a .= ",'".$Hora."'" ;        }else{$a .=",''";}
				if(isset($Patente) && $Patente != ''){       $a .= ",'".$Patente."'" ;     }else{$a .=",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `seg_vecinal_busqueda_patente` (idSistema, idCliente,
				Fecha, Hora, Patente) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if($resultado){
						
					header( 'Location: '.$location.'&search='.$Patente );
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

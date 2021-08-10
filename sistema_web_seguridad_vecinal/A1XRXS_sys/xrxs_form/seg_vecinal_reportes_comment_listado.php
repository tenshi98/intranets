<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridReportesad                                                */
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
	if ( !empty($_POST['idReportes']) )       $idReportes           = simpleDecode($_POST['idReportes'], fecha_actual());
	if ( !empty($_POST['idSistema']) )        $idSistema            = simpleDecode($_POST['idSistema'], fecha_actual());
	if ( !empty($_POST['idEvento']) )         $idEventoPeligro 	    = simpleDecode($_POST['idEvento'], fecha_actual());
	if ( !empty($_POST['idPeligro']) )        $idEventoPeligro 	    = simpleDecode($_POST['idPeligro'], fecha_actual());
	if ( !empty($_POST['idComentario']) )     $idComentario 	    = simpleDecode($_POST['idComentario'], fecha_actual());
	if ( !empty($_POST['idTipo']) )           $idTipo 	            = simpleDecode($_POST['idTipo'], fecha_actual());
	if ( !empty($_POST['idCliente']) )        $idCliente            = simpleDecode($_POST['idCliente'], fecha_actual());
	if ( !empty($_POST['Fecha']) )            $Fecha                = $_POST['Fecha'];
	if ( !empty($_POST['Hora']) )             $Hora 	            = $_POST['Hora'];
	if ( !empty($_POST['Comentario']) )       $Comentario           = $_POST['Comentario'];
	
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
			case 'idReportes':       if(empty($idReportes)){       $error['idReportes']       = 'error/No ha ingresado el id';}break;
			case 'idSistema':        if(empty($idSistema)){        $error['idSistema']        = 'error/No ha seleccionado el sistema';}break;
			case 'idEventoPeligro':  if(empty($idEventoPeligro)){  $error['idEventoPeligro']  = 'error/No ha seleccionado el Post';}break;
			case 'idComentario':     if(empty($idComentario)){     $error['idComentario']     = 'error/No ha seleccionado el comentario';}break;
			case 'idTipo':           if(empty($idTipo)){           $error['idTipo']           = 'error/No ha seleccionado el tipo';}break;
			case 'idCliente':        if(empty($idCliente)){        $error['idCliente']        = 'error/No ha seleccionado el vecino';}break;
			case 'Fecha':            if(empty($Fecha)){            $error['Fecha']            = 'error/No ha ingresado la Fecha';}break;
			case 'Hora':             if(empty($Hora)){             $error['Hora']             = 'error/No ha ingresado la Hora';}break;
			case 'Comentario':       if(empty($Comentario)){       $error['Comentario']       = 'error/No ha ingresado el Comentario';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
if(isset($Comentario)&&contar_palabras_censuradas($Comentario)!=0){     $error['Comentario']   = 'error/Edita el comentario, contiene palabras no permitidas'; }	

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/		
		case 'comment_report':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
									
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//valores
				$Fecha      = fecha_actual();
				$Hora       = hora_actual();
				$idRevisado = 1;
				
				//filtros
				if(isset($idSistema) && $idSistema != ''){              $a  = "'".$idSistema."'" ;         }else{$a  = "''";}
				if(isset($idEventoPeligro) && $idEventoPeligro != ''){  $a .= ",'".$idEventoPeligro."'" ;  }else{$a .= ",''";}
				if(isset($idComentario) && $idComentario != ''){        $a .= ",'".$idComentario."'" ;     }else{$a .= ",''";}
				if(isset($idTipo) && $idTipo != ''){                    $a .= ",'".$idTipo."'" ;           }else{$a .= ",''";}
				if(isset($idCliente) && $idCliente != ''){              $a .= ",'".$idCliente."'" ;        }else{$a .= ",''";}
				if(isset($Fecha) && $Fecha != ''){                      $a .= ",'".$Fecha."'" ;            }else{$a .= ",''";}
				if(isset($Hora) && $Hora != ''){                        $a .= ",'".$Hora."'" ;             }else{$a .= ",''";}
				if(isset($Comentario) && $Comentario != ''){            $a .= ",'".$Comentario."'" ;       }else{$a .= ",''";}
				if(isset($idRevisado) && $idRevisado != ''){            $a .= ",'".$idRevisado."'" ;       }else{$a .= ",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `seg_vecinal_reportes_comment_listado` (idSistema, idEventoPeligro, 
				idComentario, idTipo, idCliente, Fecha, Hora, Comentario, idRevisado) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if($resultado){
					
					
					//se redirige
					header( 'Location: '.$location.'&report_comment=true' );
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

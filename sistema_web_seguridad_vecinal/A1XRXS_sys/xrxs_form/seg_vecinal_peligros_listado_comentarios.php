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
	if ( !empty($_POST['idPeligro']) )    $idPeligro    = simpleDecode($_POST['idPeligro'], fecha_actual());
	if ( !empty($_POST['idCliente']) )    $idCliente    = simpleDecode($_POST['idCliente'], fecha_actual());
	if ( !empty($_POST['Comentario']) )   $Comentario   = $_POST['Comentario'];
	if ( !empty($_POST['idValidado']) )   $idValidado   = simpleDecode($_POST['idValidado'], fecha_actual());
	
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
			case 'idPeligro':   if(empty($idPeligro)){   $error['idPeligro']  = 'error/No ha Seleccionado la zona de peligro';}break;
			case 'idCliente':   if(empty($idCliente)){   $error['idCliente']  = 'error/No ha Seleccionado el cliente';}break;
			case 'Comentario':  if(empty($Comentario)){  $error['Comentario'] = 'error/No ha ingresado el comentario';}break;
			case 'idValidado':  if(empty($idValidado)){  $error['idValidado'] = 'error/No ha seleccionado el estado de validacion';}break;
			
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
		case 'new_comment':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
									
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				//valores
				$Fecha = fecha_actual();
				$Hora  = hora_actual();
				
				//filtros
				if(isset($idPeligro) && $idPeligro != ''){     $a  = "'".$idPeligro."'" ;     }else{$a  = "''";}
				if(isset($idCliente) && $idCliente != ''){     $a .= ",'".$idCliente."'" ;    }else{$a .= ",''";}
				if(isset($Fecha) && $Fecha != ''){             $a .= ",'".$Fecha."'" ;        }else{$a .= ",''";}
				if(isset($Hora) && $Hora != ''){               $a .= ",'".$Hora."'" ;         }else{$a .= ",''";}
				if(isset($Comentario) && $Comentario != ''){   $a .= ",'".$Comentario."'" ;   }else{$a .= ",''";}
				if(isset($idValidado) && $idValidado != ''){   $a .= ",'".$idValidado."'" ;   }else{$a .= ",''";}
				
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `seg_vecinal_peligros_listado_comentarios` (idPeligro, idCliente,
				Fecha, Hora, Comentario, idValidado) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				//Si ejecuto correctamente la consulta
				if($resultado){
					
					
					//se redirige
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
		case 'comment_likes':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//valores
			if(isset($_GET['like'])&&$_GET['like']!=''){        $idComentario = simpleDecode($_GET['like'], fecha_actual());}
			if(isset($_GET['dislike'])&&$_GET['dislike']!=''){  $idComentario = simpleDecode($_GET['dislike'], fecha_actual());}
			$Fecha     = fecha_actual();
			$Hora      = hora_actual();
			$idCliente = $_SESSION['usuario']['basic_data']['idCliente'];
				
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(isset($idCliente)&&isset($idComentario)){
				$ndata_1 = db_select_nrows (false, 'idLikes', 'seg_vecinal_peligros_listado_comentarios_likes', '', "idCliente='".$idCliente."' AND idComentario='".$idComentario."'", $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/Ya ha expresado su opinion en este comentario';}
			/*******************************************************************/
			
										
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
				/**********************************************************************************/
				//se actualiza la opinion
				
				//obtengo los datos actuales
				$rowdata = db_select_data (false, 'nLikes, nDislikes', 'seg_vecinal_peligros_listado_comentarios', '', 'idComentario = "'.$idComentario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				//actualizo segun corresponda
				$nLikes     = $rowdata['nLikes'] + 1;
				$nDislikes  = $rowdata['nDislikes'] + 1;
				
				//Filtros
				$a = "idComentario='".$idComentario."'" ;
				if(isset($_GET['like'])&&$_GET['like']!=''){        $a .= ",nLikes='".$nLikes."'" ;}
				if(isset($_GET['dislike'])&&$_GET['dislike']!=''){  $a .= ",nDislikes='".$nDislikes."'" ;}
				
				//se actualizan los datos
				$resultado = db_update_data (false, $a, 'seg_vecinal_peligros_listado_comentarios', 'idComentario = "'.$idComentario.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				/**********************************************************************************/
				//guardo registro de la opinion para evitar duplicado datos
				
				//filtros
				if(isset($idComentario) && $idComentario != ''){    $a  = "'".$idComentario."'" ;  }else{$a  = "''";}
				if(isset($idCliente) && $idCliente != ''){          $a .= ",'".$idCliente."'" ;    }else{$a .= ",''";}
				if(isset($Fecha) && $Fecha != ''){                  $a .= ",'".$Fecha."'" ;        }else{$a .= ",''";}
				if(isset($Hora) && $Hora != ''){                    $a .= ",'".$Hora."'" ;         }else{$a .= ",''";}
				if(isset($_GET['like'])&&$_GET['like']!=''){        $a .= ",'1'" ;                 }else{$a .= ",''";}
				if(isset($_GET['dislike'])&&$_GET['dislike']!=''){  $a .= ",'1'" ;                 }else{$a .= ",''";}
			
				// inserto los datos de registro en la db
				$query  = "INSERT INTO `seg_vecinal_peligros_listado_comentarios_likes` (idComentario, idCliente,
				Fecha, Hora, Likes, Dislikes) 
				VALUES (".$a.")";
				//Consulta
				$resultado = mysqli_query ($dbConn, $query);
				
				
				//Si ejecuto correctamente la consulta
				if($resultado){
					
					header( 'Location: '.$location.'&liked=true' );
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

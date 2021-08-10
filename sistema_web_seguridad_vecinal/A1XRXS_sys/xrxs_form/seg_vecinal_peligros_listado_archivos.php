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
	if ( !empty($_POST['idPeligro']) )      $idPeligro     = simpleDecode($_POST['idPeligro'], fecha_actual());
	if ( !empty($_POST['idCliente']) )      $idCliente     = simpleDecode($_POST['idCliente'], fecha_actual());
	
	
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
			case 'idPeligro':   if(empty($idPeligro)){   $error['idPeligro'] = 'error/No ha Seleccionado la zona de peligro';}break;
			case 'idCliente':   if(empty($idCliente)){   $error['idCliente'] = 'error/No ha Seleccionado el cliente';}break;
			
		}
	}

/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/		
		case 'upload_files':
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
									
			/*******************************************************************/
			//variables
			$ndata_1 = 0;
			//Se verifica si el dato existe
			if(!isset($idPeligro) OR $idPeligro==''){
				$ndata_1++;
			}
			//generacion de errores
			if($ndata_1 > 0) {$error['ndata_1'] = 'error/No se han identificado los datos basicos';}
			/*******************************************************************/
			
			//Se verifica que el archivo subido no exceda los 100 kb
			$limite_kb = 10000;
			//Sufijo
			$sufijo = 'zona_peligro_'.$idPeligro.'_'.ano_actual().'_'.mes_actual().'_';
			//Se verifican las extensiones de los archivos
			$permitidos = array(
								"image/jpg",
								"image/jpeg", 
								"image/gif", 
								"image/png", 
								"image/bmp"
								);
										
			//Verifico errores en los archivos
			foreach($_FILES["File_Upload"]["tmp_name"] as $key=>$tmp_name){
				if ($_FILES["File_Upload"]["error"][$key] > 0){ 
					$error['File_Upload'] = 'error/'.uploadPHPError($_FILES["File_Upload"]["error"][$key]); 
				}
				if (in_array($_FILES['File_Upload']['type'][$key], $permitidos) && $_FILES['File_Upload']['size'][$key] <= $limite_kb * 1024){
					//Se especifica carpeta de destino
					$ruta = '../'.DB_SITE_ALT_1_PATH.'/upload/'.$sufijo.$_FILES['File_Upload']['name'][$key];
					//Se verifica que el archivo un archivo con el mismo nombre no existe
					if (file_exists($ruta)){
						$error['File_Upload']     = 'error/El archivo '.$_FILES['File_Upload']['name'][$key].' ya existe'; 
					}
					//verifico que el nombre del archivo no sea ofensivo
					if(isset($_FILES['File_Upload']['name'][$key])&&contar_palabras_censuradas($_FILES['File_Upload']['name'][$key])!=0){ 
						$error['Descripcion'] = 'error/Edita el nombre del archivo, contiene palabras no permitidas'; 
					}
				} else {
					$error['File_Upload']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'.$_FILES['File_Upload']['name'][$key]; 
				}
			}
			
			//Se establece el tamaño maximo
			$max_width  = 640;
			$max_height = 640;
			//se establece la calidad del archivo al 75%
			$quality = 75;

			//si no hay errores
			if ( empty($error) ) {
				
				//vaariable
				$idInterno = 0;
									
				//Verifico errores en los archivos
				foreach($_FILES["File_Upload"]["tmp_name"] as $key=>$tmp_name){
					if ($_FILES["File_Upload"]["error"][$key] > 0){ 
						$error['File_Upload'] = 'error/'.uploadPHPError($_FILES["File_Upload"]["error"][$key]); 
					}
					if (in_array($_FILES['File_Upload']['type'][$key], $permitidos) && $_FILES['File_Upload']['size'][$key] <= $limite_kb * 1024){
						//Se especifica carpeta de destino
						$ruta = '../'.DB_SITE_ALT_1_PATH.'/upload/'.$sufijo.$_FILES['File_Upload']['name'][$key];
						//Se verifica que el archivo un archivo con el mismo nombre no existe
						if (!file_exists($ruta)){
							//Se mueve el archivo a la carpeta previamente configurada
							//$move_result = @move_uploaded_file($_FILES["File_Upload"]["tmp_name"][$key], $ruta);
							$move_result = @move_uploaded_file($_FILES["File_Upload"]["tmp_name"][$key], '../'.DB_SITE_ALT_1_PATH.'/upload/xxxsxx_'.$_FILES['File_Upload']['name'][$key]);
							//se verifica la subida
							if ($move_result){
								
								//se selecciona la imagen
								switch ($_FILES['File_Upload']['type'][$key]) {
									case 'image/jpg':
										$imgBase = imagecreatefromjpeg('../'.DB_SITE_ALT_1_PATH.'/upload/xxxsxx_'.$_FILES['File_Upload']['name'][$key]);
										break;
									case 'image/jpeg':
										$imgBase = imagecreatefromjpeg('../'.DB_SITE_ALT_1_PATH.'/upload/xxxsxx_'.$_FILES['File_Upload']['name'][$key]);
										break;
									case 'image/gif':
										$imgBase = imagecreatefromgif('../'.DB_SITE_ALT_1_PATH.'/upload/xxxsxx_'.$_FILES['File_Upload']['name'][$key]);
										break;
									case 'image/png':
										$imgBase = imagecreatefrompng('../'.DB_SITE_ALT_1_PATH.'/upload/xxxsxx_'.$_FILES['File_Upload']['name'][$key]);
										break;
									case 'image/bmp':
										$imgBase = imagecreatefrombmp('../'.DB_SITE_ALT_1_PATH.'/upload/xxxsxx_'.$_FILES['File_Upload']['name'][$key]);
										break;
								}
								
								//Se obtiene la informacion del ancho y alto
								$imgBase_width  = imagesx( $imgBase );
								$imgBase_height = imagesy( $imgBase );
								
								//se reescala
								if ($imgBase_width > $imgBase_height) {
									if($imgBase_width < $max_width){
										$newwidth = $imgBase_width;
									}else{
										$newwidth = $max_width;	
									}
									$divisor = $imgBase_width / $newwidth;
									$newheight = floor( $imgBase_height / $divisor);
								}else {
									if($imgBase_height < $max_height){
										$newheight = $imgBase_height;
									}else{
										$newheight =  $max_height;
									} 
									$divisor = $imgBase_height / $newheight;
									$newwidth = floor( $imgBase_width / $divisor );
								}
								//reescalado
								$imgBase = imagescale($imgBase, $newwidth, $newheight);
	
								//se crea la imagen
								imagejpeg($imgBase, $ruta, $quality);
									
								//se elimina la imagen base
								try {
									if(!is_writable('../'.DB_SITE_ALT_1_PATH.'/upload/xxxsxx_'.$_FILES['File_Upload']['name'][$key])){
										//throw new Exception('File not writable');
									}else{
										unlink('../'.DB_SITE_ALT_1_PATH.'/upload/xxxsxx_'.$_FILES['File_Upload']['name'][$key]);
									}
								}catch(Exception $e) { 
									//guardar el dato en un archivo log
								}
								//se eliminan las imagenes de la memoria
								imagedestroy($imgBase);
								
								//se guarda registro del archivo subido
								//Filtro para idSistema
								$File = $sufijo.$_FILES['File_Upload']['name'][$key];
								
								//filtros
								if(isset($idPeligro) && $idPeligro != ''){  $a  = "'".$idPeligro."'" ;   }else{$a  ="''";}
								if(isset($File) && $File != ''){            $a .= ",'".$File."'" ;       }else{$a .=",''";}
								if(isset($idCliente) && $idCliente != ''){  $a .= ",'".$idCliente."'" ;  }else{$a .=",''";}
								
								// inserto los datos de registro en la db
								$query  = "INSERT INTO `seg_vecinal_peligros_listado_archivos` (idPeligro, Nombre, idCliente) 
								VALUES (".$a.")";
								//Consulta
								$resultado = mysqli_query ($dbConn, $query);
								//Si ejecuto correctamente la consulta
								if($resultado){
									
									//guardo el nombre del archivo
									$_SESSION['vecinos_peligros_archivos'][$idPeligro][$idInterno]['Nombre'] = $File;
									//sumo contador
									$idInterno++;
									
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
								$error['File_Upload']     = 'error/Ocurrio un error al mover el archivo'; 
							}
						}else{
							$error['File_Upload']     = 'error/El archivo '.$_FILES['File_Upload']['name'][$key].' ya existe'; 
						}
					} else {
						$error['File_Upload']     = 'error/Esta tratando de subir un archivo no permitido o que excede el tamaño permitido'; 
					}
				}
				
				//si se subio a lo menos unarchivo
				if($idInterno!=0){
					//defino total archivos en el evento
					$_SESSION['vecinos_peligros'][$idPeligro]['total_archivos'] = $idInterno;
					
					//redirijo
					header( 'Location: '.$location.'&filUp='.$idInterno );
					die;
				}
			}
			
		
			
		break;	
/*******************************************************************************************************************/
		case 'del_files':	
			
			//Se elimina la restriccion del sql 5.7
			mysqli_query($dbConn, "SET SESSION sql_mode = ''");
			
			//Variable
			$errorn = 0;
			
			//verifico si se envia un entero
			if((!validarNumero($_GET['del_Archivo']) OR !validaEntero($_GET['del_Archivo']))&&$_GET['del_Archivo']!=''){
				$indice = simpleDecode($_GET['del_Archivo'], fecha_actual());
			}else{
				$indice = $_GET['del_Archivo'];
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
				
				// Se obtiene el nombre del archivo
				$rowdata = db_select_data (false, 'Nombre', 'seg_vecinal_peligros_listado_archivos', '', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
			
				//se elimina el archivo
				if(isset($rowdata['Nombre'])&&$rowdata['Nombre']!=''){
					try {
						if(!is_writable('../'.DB_SITE_ALT_1_PATH.'/upload/'.$rowdata['Nombre'])){
							//throw new Exception('File not writable');
						}else{
							unlink('../'.DB_SITE_ALT_1_PATH.'/upload/'.$rowdata['Nombre']);
						}
					}catch(Exception $e) { 
						//guardar el dato en un archivo log
					}
				}
				
				//se borran los datos
				$resultado_1 = db_delete_data (false, 'seg_vecinal_peligros_listado_archivos', 'idArchivo = "'.$indice.'"', $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
				
				//defino total archivos en el evento
				$_SESSION['vecinos_peligros'][$indice]['total_archivos'] = $_SESSION['vecinos_peligros'][$indice]['total_archivos'] - 1 ;
					
				//Si ejecuto correctamente la consulta
				if($resultado_1==true){
					
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

<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Web.php';
/**********************************************************************************************************************************/
/*                                                 Ejecucion de codigo                                                            */
/**********************************************************************************************************************************/

if(isset($_POST["image"])){
	
	//Se obtiene la imagen
	$img  = $_POST['image']; // Your data 'data:image/png;base64,AAAFBfj42Pj4';
	$img  = str_replace('data:image/png;base64,', '', $img);
	$img  = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	
	$idCliente  = $_SESSION['usuario']['basic_data']['idCliente'];
	$imageName  = 'usr_img_'.$idCliente.'_'.time().'.png';
	$ruta       = '../'.DB_SITE_ALT_1_PATH.'/upload/'.$imageName;
	
	//Se verifica que el archivo un archivo con el mismo nombre no existe
	if (!file_exists($ruta)){
		//Se mueve el archivo a la carpeta previamente configurada
		//$resultado = @move_uploaded_file($imageName, $ruta);
		$resultado = file_put_contents($ruta, $data)or die("Unable to write file!");
		
		if ($resultado){
										
			//Filtro para idSistema
			$a = "Direccion_img='".$imageName."'" ;

			// inserto los datos de registro en la db
			$query  = "UPDATE `seg_vecinal_clientes_listado` SET ".$a." WHERE idCliente = '".$idCliente."'";
			//Consulta
			$resultado = mysqli_query ($dbConn, $query);
			//Si ejecuto correctamente la consulta
			if($resultado){				
				//Seteo la variable de sesion si existe
				$_SESSION['usuario']['basic_data']['Direccion_img'] = $imageName;
				//Si se tiene un id se actaliza el listado de imagenes de los vecinos
				if(isset($_SESSION['usuario']['basic_data']['idCliente'])){
					//datos
					$idCliente = $_SESSION['usuario']['basic_data']['idCliente'];
					$Direccion = $_SESSION['usuario']['basic_data']['Direccion'];
					//actualizacion
					$_SESSION['vecinos'][$idCliente]['Direccion_img'] = $imageName;
					$countx = 0;
					foreach($_SESSION['vecinos_filter'][$Direccion] as $direcList) {
						if(isset($direcList['idCliente'])&&$direcList['idCliente']==$idCliente){
							$_SESSION['vecinos_filter'][$Direccion][$countx]['Direccion_img'] = $imageName;
						}
						$countx++;
					}	
				}
						
			}else{
				//variables
				$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
				$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

				//generar log
				php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
			}
						
		} else {
			$error['imgLogo']     = 'error/Ocurrio un error al mover el archivo'; 
		}
	} else {
		$error['imgLogo']     = 'error/El archivo '.$imageName.' ya existe'; 
	}
}


?>

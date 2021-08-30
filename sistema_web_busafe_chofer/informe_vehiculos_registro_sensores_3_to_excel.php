<?php session_start();
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../LIBS_php/PHPExcel/PHPExcel.php';
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Excel.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim); }else{set_time_limit(2400);}             
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M'); }else{ini_set('memory_limit', '4096M');}  
/**********************************************************************************************************************************/
/*                                                          Consultas                                                             */
/**********************************************************************************************************************************/
//Calculo del limit
$set_lim = (5000*$_GET['num'])-4999;
/*******************************************************************************/
//Variables
$xx = 1;
$arrData = array();
$arrData[$xx] = "D";$xx++;
$arrData[$xx] = "E";$xx++;
$arrData[$xx] = "F";$xx++;
$arrData[$xx] = "G";$xx++;
$arrData[$xx] = "H";$xx++;
$arrData[$xx] = "I";$xx++;
$arrData[$xx] = "J";$xx++;
$arrData[$xx] = "K";$xx++;
$arrData[$xx] = "L";$xx++;
$arrData[$xx] = "M";$xx++;
$arrData[$xx] = "N";$xx++;
$arrData[$xx] = "O";$xx++;
$arrData[$xx] = "P";$xx++;
$arrData[$xx] = "Q";$xx++;
$arrData[$xx] = "R";$xx++;
$arrData[$xx] = "S";$xx++;
$arrData[$xx] = "T";$xx++;
$arrData[$xx] = "U";$xx++;
$arrData[$xx] = "V";$xx++;
$arrData[$xx] = "W";$xx++;
$arrData[$xx] = "X";$xx++;
$arrData[$xx] = "Y";$xx++;
$arrData[$xx] = "Z";$xx++;
$arrData[$xx] = "AA";$xx++;
$arrData[$xx] = "AB";$xx++;
$arrData[$xx] = "AC";$xx++;
$arrData[$xx] = "AD";$xx++;
$arrData[$xx] = "AE";$xx++;
$arrData[$xx] = "AF";$xx++;
$arrData[$xx] = "AG";$xx++;
$arrData[$xx] = "AH";$xx++;
$arrData[$xx] = "AI";$xx++;
$arrData[$xx] = "AJ";$xx++;
$arrData[$xx] = "AK";$xx++;
$arrData[$xx] = "AL";$xx++;
$arrData[$xx] = "AM";$xx++;
$arrData[$xx] = "AN";$xx++;
$arrData[$xx] = "AO";$xx++;
$arrData[$xx] = "AP";$xx++;
$arrData[$xx] = "AQ";$xx++;
$arrData[$xx] = "AR";$xx++;
$arrData[$xx] = "AS";$xx++;
$arrData[$xx] = "AT";$xx++;
$arrData[$xx] = "AU";$xx++;
$arrData[$xx] = "AV";$xx++;
$arrData[$xx] = "AW";$xx++;
$arrData[$xx] = "AX";$xx++;
$arrData[$xx] = "AY";$xx++;
$arrData[$xx] = "AZ";$xx++;
$arrData[$xx] = "BA";$xx++;
$arrData[$xx] = "BB";$xx++;
$arrData[$xx] = "BC";$xx++;
$arrData[$xx] = "BD";$xx++;
$arrData[$xx] = "BE";$xx++;
$arrData[$xx] = "BF";$xx++;
/*******************************************************************************/
//Funcion para escribir datos
function crear_data($limite, $idVehiculo, $f_inicio, $f_termino, $dbConn ) {
	//Se traen todos los registros
	$arrRutas = array();
	$query = "SELECT 
	vehiculos_listado.Nombre AS NombreEquipo,

	vehiculos_listado_tablarelacionada_".$idVehiculo.".FechaSistema,
	vehiculos_listado_tablarelacionada_".$idVehiculo.".HoraSistema,
	vehiculos_listado_tablarelacionada_".$idVehiculo.".GeoLatitud AS GeoLatitudEquipo,
	vehiculos_listado_tablarelacionada_".$idVehiculo.".GeoLongitud AS GeoLongitudEquipo,
	vehiculos_listado_tablarelacionada_".$idVehiculo.".GeoVelocidad AS GeoVelocidadEquipo,
	vehiculos_listado_tablarelacionada_".$idVehiculo.".GeoDireccion AS GeoDireccionEquipo,
	vehiculos_listado_tablarelacionada_".$idVehiculo.".GeoMovimiento AS GeoMovimientoEquipo
	

	FROM `vehiculos_listado_tablarelacionada_".$idVehiculo."`
	LEFT JOIN `vehiculos_listado`     ON vehiculos_listado.idVehiculo   = vehiculos_listado_tablarelacionada_".$idVehiculo.".idVehiculo
	WHERE (FechaSistema BETWEEN '".$f_inicio."' AND '".$f_termino."') 
	LIMIT ".$limite.", 5000";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//variables
		$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
		$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

		//generar log
		php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
	}
	while ( $row = mysqli_fetch_assoc ($resultado)) {
	array_push( $arrRutas,$row );
	}
	
	return $arrRutas;
	
}


/*******************************************************************/
/*******************************************************************/
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Office 2007")
							 ->setLastModifiedBy("Office 2007")
							 ->setTitle("Office 2007")
							 ->setSubject("Office 2007")
							 ->setDescription("Document for Office 2007")
							 ->setKeywords("office 2007")
							 ->setCategory("office 2007 result file");


/*********************************************************************************/
//Verifico si se selecciono el equipo
if(isset($_GET['idVehiculo'])&&$_GET['idVehiculo']!=''){
	//Variable temporal
	$arrTemporal = array();
	//Llamo a la funcion
	$arrTemporal = crear_data($set_lim, $_GET['idVehiculo'], $_GET['f_inicio'], $_GET['f_termino'] , $dbConn);
	

	 
	/***********************************************************/
	//Titulo columnas
	$objPHPExcel->setActiveSheetIndex(0)

				->setCellValue('A2', 'Equipo')
				->setCellValue('B2', 'Fecha')
				->setCellValue('C2', 'Hora')
				->setCellValue('D2', 'Latitud')
				->setCellValue('E2', 'Longitud')
				->setCellValue('F2', 'Velocidad')
				->setCellValue('G2', 'Direccion')
				->setCellValue('H2', 'Movimiento');
				
			
	/***********************************************************/
	//Datos        
	$nn=3;
	foreach ($arrTemporal as $rutas) {
							
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$nn, $rutas['NombreEquipo'])
					->setCellValue('B'.$nn, fecha_estandar($rutas['FechaSistema']))
					->setCellValue('C'.$nn, $rutas['HoraSistema'])
					->setCellValue('D'.$nn, $rutas['GeoLatitudEquipo'])
					->setCellValue('E'.$nn, $rutas['GeoLongitudEquipo'])
					->setCellValue('F'.$nn, $rutas['GeoVelocidadEquipo'])
					->setCellValue('G'.$nn, $rutas['GeoDireccionEquipo'])
					->setCellValue('H'.$nn, $rutas['GeoMovimientoEquipo']);

				   
		 $nn++;           
	   
	} 
	/***********************************************************/
	// Rename worksheet
	$super_titulo = 'Hoja 1';
	if(isset($arrTemporal[0]['NombreEquipo'])&&$arrTemporal[0]['NombreEquipo']!=''){
		$super_titulo = cortar($arrTemporal[0]['NombreEquipo'], 25);
	}
	$objPHPExcel->getActiveSheet(0)->setTitle($super_titulo);
		
	
//Si no se slecciono se traen todos los equipos a los cuales tiene permiso	
}else{
	//Inicia variable
	$z="WHERE vehiculos_listado.idVehiculo>0"; 

	//Verifico el tipo de usuario que esta ingresando
	if($_GET['idTipoUsuario']==1){
		$z.=" AND vehiculos_listado.idSistema>=0";
	}else{
		$z.= " AND vehiculos_listado.idSistema=".$_GET['idSistema'];
		$z.= " AND vehiculos_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
	}
	
	/*********************************************/
	// Se trae un listado con todos los elementos
	$arrEquipos = array();
	$query = "SELECT 
	vehiculos_listado.idVehiculo, 
	vehiculos_listado.Nombre
	FROM `vehiculos_listado`
	".$z."
	ORDER BY idVehiculo ASC ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	//Si ejecuto correctamente la consulta
	if(!$resultado){
		//variables
		$NombreUsr   = $_SESSION['usuario']['basic_data']['Nombre'];
		$Transaccion = basename($_SERVER["REQUEST_URI"], ".php");

		//generar log
		php_error_log($NombreUsr, $Transaccion, '', mysqli_errno($dbConn), mysqli_error($dbConn), $query );
		
	}
	while ( $row = mysqli_fetch_assoc ($resultado)) {
	array_push( $arrEquipos,$row );
	}

	/*********************************************/
	$sheet = 0;
	foreach ($arrEquipos as $equipo) {
		//Variable temporal
		$arrTemporal = array();
		//Se crea nueva hoja
		$objPHPExcel->createSheet();
		//Llamo a la funcion
		$arrTemporal = crear_data($set_lim, $equipo['idVehiculo'], $_GET['f_inicio'], $_GET['f_termino'] , $dbConn);
		
		 
		/***********************************************************/
		//Titulo columnas
		$objPHPExcel->setActiveSheetIndex($sheet)

					->setCellValue('A2', 'Equipo')
					->setCellValue('B2', 'Fecha')
					->setCellValue('C2', 'Hora')
					->setCellValue('D2', 'Latitud')
					->setCellValue('E2', 'Longitud')
					->setCellValue('F2', 'Velocidad')
					->setCellValue('G2', 'Direccion')
					->setCellValue('H2', 'Movimiento');
					  

		 
		/***********************************************************/
		//Datos        
		$nn=3;
		foreach ($arrTemporal as $rutas) {
								
			$objPHPExcel->setActiveSheetIndex($sheet)
						->setCellValue('A'.$nn, $rutas['NombreEquipo'])
						->setCellValue('B'.$nn, fecha_estandar($rutas['FechaSistema']))
						->setCellValue('C'.$nn, $rutas['HoraSistema'])
						->setCellValue('D'.$nn, $rutas['GeoLatitudEquipo'])
						->setCellValue('E'.$nn, $rutas['GeoLongitudEquipo'])
						->setCellValue('F'.$nn, $rutas['GeoVelocidadEquipo'])
						->setCellValue('G'.$nn, $rutas['GeoDireccionEquipo'])
						->setCellValue('H'.$nn, $rutas['GeoMovimientoEquipo']);
						
					   
			 $nn++;           
		   
		} 
		/***********************************************************/
		// Rename worksheet
		$super_titulo = 'Hoja 1';
		if(isset($arrTemporal[0]['NombreEquipo'])&&$arrTemporal[0]['NombreEquipo']!=''){
			$super_titulo = cortar($arrTemporal[0]['NombreEquipo'], 25);
		}
		$objPHPExcel->getActiveSheet($sheet)->setTitle($super_titulo);
	
		
		$sheet++;
	}


}	

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
//header('Content-Disposition: attachment;filename="Informe Datos.xls"');
header('Content-Disposition: attachment;filename="Informe Datos archivo '.$_GET['num'].'.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

//$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

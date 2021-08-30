<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.PDF.php';
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
//Se buscan la imagen i el tipo de PDF
if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&$_GET['idSistema']!=0){
	//Consulta
	$query = "SELECT Config_imgLogo, idOpcionesGen_5	
	FROM `core_sistemas` 
	WHERE idSistema = '".$_GET['idSistema']."'  ";
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
	$rowEmpresa = mysqli_fetch_array ($resultado);
}
/********************************************************************/
///Inicia variable
$z="WHERE vehiculos_listado_error_detenciones.idDetencion>0";
$zn = ''; 
//verifico si existen los parametros de fecha
if(isset($_GET['f_inicio'])&&$_GET['f_inicio']!=''&&isset($_GET['f_termino'])&&$_GET['f_termino']!=''){
	$z.=" AND vehiculos_listado_error_detenciones.Fecha BETWEEN '".$_GET['f_inicio']."' AND '".$_GET['f_termino']."'";
}
//verifico si se selecciono un equipo
if(isset($_GET['idVehiculo'])&&$_GET['idVehiculo']!=''){
	$z.=" AND vehiculos_listado_error_detenciones.idVehiculo='".$_GET['idVehiculo']."'";
}
//Verifico el tipo de usuario que esta ingresando
if($_GET['idTipoUsuario']==1){
	$z.=" AND vehiculos_listado_error_detenciones.idSistema>=0";	
}else{
	$z.=" AND vehiculos_listado_error_detenciones.idSistema=".$_GET['idSistema'];	
}	
$z.=" AND vehiculos_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];

// Se trae un listado con todos los elementos
$arrErrores = array();
$query = "SELECT 
vehiculos_listado_error_detenciones.idDetencion,
vehiculos_listado_error_detenciones.Fecha, 
vehiculos_listado_error_detenciones.Hora,  
vehiculos_listado_error_detenciones.Tiempo,
vehiculos_listado.Nombre AS NombreEquipo

FROM `vehiculos_listado_error_detenciones`
LEFT JOIN `vehiculos_listado` ON vehiculos_listado.idVehiculo = vehiculos_listado_error_detenciones.idVehiculo
".$z."
ORDER BY idDetencion DESC ";
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
array_push( $arrErrores,$row );
} 
/********************************************************************/
//Se define el contenido del PDF
$html = '
<style>
	tbody tr:nth-child(odd) {background-color: #dfdfdf;}
</style>';


$html .= '
<table width="100%" border="0" cellpadding="2" cellspacing="0" style="border: 1px solid black;background-color: #ffffff;">  
	<thead>
		<tr>
			<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Nombre Equipo</th>
			<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Fecha</th>
			<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Hora</th>
			<th style="font-size: 10px;border-bottom: 1px solid black;text-align:center;background-color: #c3c3c3;">Tiempo Detenido</th>
		</tr>
	</thead>
	<tbody>';
							
		foreach ($arrErrores as $error) {
							
				$html .='
				<tr>
					<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$error['NombreEquipo'].'</td>
					<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.fecha_estandar($error['Fecha']).'</td>
					<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$error['Hora'].' hrs</td>
					<td style="font-size: 10px;border-bottom: 1px solid black;text-align:center">'.$error['Tiempo'].' hrs</td>
				</tr>
				';

							
		}
							
$html .='</tbody>
</table>';
   

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Informe de Detenciones';
$pdf_subtitulo  = $zn;
$pdf_file       = 'Informe de Detenciones'.$zn.'.pdf';
$OpcDom         = "'A4', 'landscape'";
$OpcTcp         = "";
/********************************************************************************/
//Si se cnfigura para utilizar el pdf simple
if(isset($rowEmpresa['idOpcionesGen_5'])&&$rowEmpresa['idOpcionesGen_5']==2){
	
	require_once '../LIBS_php/dompdf/autoload.inc.php';
	// reference the Dompdf namespace
	//use Dompdf\Dompdf;
	// instantiate and use the dompdf class
	$dompdf = new Dompdf();
	$dompdf->loadHtml($html);
	$dompdf->setPaper($OpcDom);
	$dompdf->render();
	$dompdf->stream($pdf_file);

/********************************************************************************/
//Si se cnfigura para utilizar el pdf complejo
}else{
	
	require_once('../LIBS_php/tcpdf/tcpdf.php');

	// create new PDF document
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	// set document information
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Victor Reyes');
	$pdf->SetTitle('');
	$pdf->SetSubject('');
	$pdf->SetKeywords('');

	// set default header data
	if(isset($_GET['idSistema'])&&$_GET['idSistema']!=''&&$_GET['idSistema']!=0){
		if(isset($rowEmpresa['Config_imgLogo'])&&$rowEmpresa['Config_imgLogo']!=''){
			$logo = '../../../../'.DB_SITE_MAIN_PATH.'/upload/'.$rowEmpresa['Config_imgLogo'];
		}else{
			$logo = '../../../../Legacy/gestion_modular/img/logo_empresa.jpg';
		}
	}else{
		$logo = '../../../../Legacy/gestion_modular/img/logo_empresa.jpg';
	}
	$pdf->SetHeaderData($logo, 40, $pdf_titulo, $pdf_subtitulo);

	// set header and footer fonts
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

	// set default monospaced font
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

	// set auto page breaks
	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		require_once(dirname(__FILE__).'/lang/eng.php');
		$pdf->setLanguageArray($l);
	}

	//Se crea el archivo
	$pdf->SetFont('helvetica', '', 10);
	$pdf->AddPage($AddPageL, $AddPageA);
	$pdf->writeHTML($html, true, false, true, false, '');
	$pdf->lastPage();
	$pdf->Output($pdf_file, 'I');
}

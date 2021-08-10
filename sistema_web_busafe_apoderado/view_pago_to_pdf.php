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
	WHERE idSistema = '".$_GET['idSistema']."'";
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
//Obtengo los datos del contrato seleccionado
$query = "SELECT  
sistema_planes_transporte.Nombre AS PlanNombre,

vehiculos_facturacion_apoderados_pago.paymentTypeCode,
vehiculos_facturacion_apoderados_pago.transactionDate,
vehiculos_facturacion_apoderados_pago.buyOrder,
vehiculos_facturacion_apoderados_listado_detalle.idPago AS NDocPago,
vehiculos_facturacion_apoderados_pago.amount,
vehiculos_facturacion_apoderados_pago.cardNumber,
vehiculos_facturacion_apoderados_pago.authorizationCode,
vehiculos_facturacion_apoderados_pago.sharesNumber,

vehiculos_facturacion_apoderados_listado_detalle.PagoidMes,
vehiculos_facturacion_apoderados_listado_detalle.PagoAno

				
FROM vehiculos_facturacion_apoderados_listado_detalle 
LEFT JOIN sistema_planes_transporte                 ON sistema_planes_transporte.idPlan               = vehiculos_facturacion_apoderados_listado_detalle.idPlan
LEFT JOIN vehiculos_facturacion_apoderados_pago     ON vehiculos_facturacion_apoderados_pago.idPago   = vehiculos_facturacion_apoderados_listado_detalle.idPago

WHERE vehiculos_facturacion_apoderados_listado_detalle.idFacturacionDetalle = '".$_GET['view']."'
 ";

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
$rowData = mysqli_fetch_assoc ($resultado);

/********************************************************************/
//Se define el contenido del PDF
$html = '
<style>
body {font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 14px;line-height: 1.42857143;color: #333;}
table {border-collapse: collapse;border-spacing: 0;}
tr.oddrow td{display: line;border-bottom: 1px solid #EEE;}
.tableline td, .tableline th{border-bottom: 1px solid #EEE;line-height: 1.42857143;}
</style>';
 
$html .= '
<table style="background-color:#f8f8f8; border:solid 1px #ccc; padding:5px 2px 15px 2px;margin: 1%; width: 98%;"   cellpadding="10" cellspacing="0">
	<tbody>
		<tr>
			<td>
	
				<table style="text-align: left; width: 100%;"  cellpadding="0" cellspacing="0">
					<tbody>
						<tr class="oddrow">
							<td colspan="2" rowspan="1" style="vertical-align: top;" align="center"><span style="font-size: 16px; color: #D51C24">COMPROBANTE DE PAGO</span></td>
						</tr>';
						
						switch ($rowData['paymentTypeCode']) {
							case 'VD': $TipoPago = 'Venta Débito'; break;
							case 'VN': $TipoPago = 'Venta Normal'; break;
							case 'VC': $TipoPago = 'Venta en cuotas'; break;
							case 'SI': $TipoPago = '3 cuotas sin interés'; break;
							case 'S2': $TipoPago = '2 cuotas sin interés'; break;
							case 'NC': $TipoPago = 'N Cuotas sin interés'; break;
							case 'VP': $TipoPago = 'Venta Prepago'; break;
						}
							
$html .= '<tr><td style="vertical-align: top; width:50%;">Cliente:</td>                                <td style="vertical-align: top; width:50%;">'.$_SESSION['usuario']['basic_data']['Nombre'].'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Servicio:</td>                               <td style="vertical-align: top; width:50%;">Plan '.$rowData['PlanNombre'].'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Fecha:</td>                                  <td style="vertical-align: top; width:50%;">'.$rowData['transactionDate'].'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Orden de Compra:</td>                        <td style="vertical-align: top; width:50%;">'.$rowData['buyOrder'].'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">N° de Comprobante:</td>                      <td style="vertical-align: top; width:50%;">'.n_doc($rowData['NDocPago'], 8).'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Monto:</td>                                  <td style="vertical-align: top; width:50%;">'.Valores($rowData['amount'], 0).'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Ultimos dígitos de la tarjeta:</td>          <td style="vertical-align: top; width:50%;">'.$rowData['cardNumber'].'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Código autorización de la Transacción:</td>  <td style="vertical-align: top; width:50%;">'.$rowData['authorizationCode'].'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Tipo de Pago:</td>                           <td style="vertical-align: top; width:50%;">'.$TipoPago.'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Número de Cuotas:</td>                       <td style="vertical-align: top; width:50%;">'.$rowData['sharesNumber'].'</td></tr>';			
$html .= '<tr><td style="vertical-align: top; width:50%;">Estado Pago:</td>                            <td style="vertical-align: top; width:50%;">PAGO REALIZADO EXITOSAMENTE</td></tr>';			
									
							
						
						
						$html .= '
					</tbody>
				</table>';
				


			$html .= '</td>
		</tr>
	</tbody>
</table>';
 

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = 'Pago Plan '.$rowData['PlanNombre'].' '.$rowData['PagoAno'].' '.$rowData['PagoidMes'];
$pdf_subtitulo  = '';
$pdf_file       = 'Pago Plan '.$rowData['PlanNombre'].' '.$rowData['PagoAno'].' '.$rowData['PagoidMes'].'.pdf';
$OpcDom         = "'A4', 'landscape'";
$OpcTcp         = "'L', 'A4'";
/********************************************************************************/
//Se verifica que este configurado el motor de pdf
if(isset($rowEmpresa['idOpcionesGen_5'])&&$rowEmpresa['idOpcionesGen_5']!=0){
	switch ($rowEmpresa['idOpcionesGen_5']) {
		/************************************************************************/
		//TCPDF
		case 1:
			
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
	
			break;
		/************************************************************************/
		//DomPDF (Solo compatible con PHP 5.x)
		case 2:
			require_once '../LIBS_php/dompdf/autoload.inc.php';
			// reference the Dompdf namespace
			//use Dompdf\Dompdf;
			// instantiate and use the dompdf class
			$dompdf = new Dompdf();
			$dompdf->loadHtml($html);
			$dompdf->setPaper($OpcDom);
			$dompdf->render();
			$dompdf->stream($pdf_file);
			break;

	}
}

?>

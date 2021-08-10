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
//Obtengo los datos del contrato seleccionado
$query = "SELECT  
apoderados_listado.Nombre AS ApoderadoNombre,
apoderados_listado.ApellidoPat AS ApoderadoApellidoPat,
apoderados_listado.ApellidoMat AS ApoderadoApellidoMat,
apoderados_listado.Rut AS ApoderadoRut,
apoderados_listado.email AS ApoderadoEmail,
apoderados_listado.Direccion AS ApoderadoDireccion,
core_ubicacion_comunas.Nombre AS ApoderadoComuna,
core_ubicacion_ciudad.Nombre AS ApoderadoCiudad,
apoderados_listado.Fono1 AS ApoderadoFono,
apoderados_listado_planes_contratados.fCreacion

FROM `apoderados_listado_planes_contratados`
LEFT JOIN `apoderados_listado`      ON apoderados_listado.idApoderado    = apoderados_listado_planes_contratados.idApoderado
LEFT JOIN `core_ubicacion_comunas`  ON core_ubicacion_comunas.idComuna   = apoderados_listado.idComuna
LEFT JOIN `core_ubicacion_ciudad`   ON core_ubicacion_ciudad.idCiudad    = apoderados_listado.idCiudad

WHERE apoderados_listado_planes_contratados.idPlanContratado = '".$_GET['view']."'
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
$html_1 = '
	<br/><br/><br/>
	<h3 style="text-align:center;width:100%;" ><strong>CONTRATO DE PRESTACIÓN DE SERVICIOS</strong></h3><br/>
	<h3 style="text-align:center;width:100%;" ><strong>MONITOREO TRANSPORTE ESCOLAR</strong></h3><br/>
	<h3 style="text-align:center;width:100%;" >
		<strong>
			BUSAFE SpA.<br/>
			Y<br/>
			'.$rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat'].'<br/>
		</strong>
	</h3>
	
	<br/><br/><br/><br/><br/><br/><br/><br/>
	<p>
		En Santiago de Chile, a <strong>'.fecha_estandar($rowData['fCreacion']).'</strong>, 
		entre <strong>BUSAFE SPA</strong>, R.U.T. <strong>77.099.293-1</strong>, representada por 
		don <strong>MARCO ANTONIO CAMPOS PATUELLI</strong>, Cédula de Identidad <strong>10.123.351-0</strong>, 
		ambos domiciliados en Santiago, calle badajoz 100, oficina 523, Las Condes, Santiago, en 
		lo sucesivo  <strong>BUSAFE SPA</strong> y <strong>'.$rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat'].'</strong>, 
		Cédula de identidad Nº <strong>'.$rowData['ApoderadoRut'].'</strong>, 
		domiciliado para estos efectos en  <strong>'.$rowData['ApoderadoDireccion'].'</strong>, 
		comuna <strong>'.$rowData['ApoderadoComuna'].'</strong>, ciudad  de  
		'.$rowData['ApoderadoCiudad'].',  en  adelante <strong>“EL CLIENTE” </strong>; 
		se ha convenido el siguiente contrato de prestación de servicios tecnológicos, el que 
		se regirá por las siguientes disposiciones:
	</p>';

$html_2 = '
	<br/><br/><br/>
	<p>
		<strong>PRIMERO</strong>:  BUSAFE  se  compromete  a  prestar  servicios  tecnológicos  de
		monitoreo    de    transporte    escolar.    En    ellos    cuenta,    servicio    de
		georreferenciación, de seguimiento del trayecto  y sistema de alertas ante
		incumplimientos del protocolo de traslado acordado/legislado.<br/><br/>
		
		<strong>SEGUNDO</strong>: El pago por los servicios prestados por BUSAFE SPA en virtud del
		presente contrato, dependerá del tipo de servicio requerido por EL CLIENTE,
		tarifas establecidas en anexo N°1 del presente contrato.  El CLIENTE deberá
		pagar los montos facturados mensuales o anuales por BUSAFE SPA dentro de
		los próximos 10 dias corridos, luego de emitida la respectiva factura mensual el
		día 05 de cada mes.<br/><br/>
		
		<strong>TERCERO</strong>: BUSAFE SPA no tendrá responsabilidad alguna por los perjuicios,
		directos o indirectos, previstos o imprevistos, que se ocasionen con el servicio
		de transporte escolar proporcionado por el proveedor especifico y contratado
		por el apoderado. BUSAFE SPA sólo se hará responsable de deficiencias o
		imprevistos que tengan relación con la aplicación móvil de Busafe, servicio
		objeto del presente contrato.<br/><br/>
		
		<strong>CUARTO</strong>:  <strong>'.$rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat'].'</strong>  se  obliga  
		pagar  los  servicios  objeto  del presente contrato, prestados por BUSAFE 
		SPA oportunamente y en la forma establecida en el artículo segundo del 
		presente contrato.<br/><br/>
		
		<strong>QUINTO</strong>: El presente contrato entra a regir a partir de su fecha y tendrá una
		duración por todo el año en cuestión. El cliente puede dar de baja su servicio
		cuando  lo requiera, cancelando solamente los meses de uso efectivo.
	</p>';
$html_3 = '
	<br/><br/><br/>
	<p>
		<strong>SEXTO</strong>:  Para  todos  los  efectos  legales  derivados  de  este  contrato,  las
		comunicaciones que deban efectuarse entre <strong>'.$rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat'].'</strong> 
		y BUSAFE SPA, se   entenderán   válidamente   cumplidos   si   se   dirigen   a:   BUSAFE   SPA,
		domiciliada en badajoz 100, oficina N°523, Las Condes, Santiago, Teléfono
		(56-9)56677290;   email   contacto@busafe.cl;   en   atención   al   Sr.   Gonzalo
		Campos Jure.  Por la otra parte, las comunicaciones serán dirigidas a 
		<strong>'.$rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat'].'</strong> 
		domiciliado en <strong>'.$rowData['ApoderadoDireccion'].'</strong>, 
		comuna de <strong>'.$rowData['ApoderadoComuna'].'</strong>, 
		teléfono <strong>'.$rowData['ApoderadoFono'].'</strong>, 
		email <strong>'.$rowData['ApoderadoEmail'].'</strong>.<br/>
		Las partes podrán modificar en cualquier momento los nombres y direcciones
		establecidas para las entregas de las comunicaciones y avisos requeridos bajo
		el presente contrato, siempre que la modificación sea debidamente enviada a la
		otra parte de conformidad con este artículo, via correo electrónico.<br/><br/>
		
		<strong>SÉPTIMO</strong>: Toda y cualquier duda, diferencia o dificultad que surja entre las
		partes  con  motivo  u  ocasión  del  presente  contrato,  de  su  interpretación,
		cumplimiento,  incumplimiento,  validez,  ejecución,  terminación,  resolución,
		nulidad y cualquier otra, de cualquier clase que sea, incluyendo las relativas a
		la existencia y validez de la presente cláusula compromisoria y del compromiso
		que sigue y las relativas a la competencia del árbitro, será resuelta mediante
		arbitraje conforme al Reglamento del Centro de Arbitrajes de la Cámara de
		Comercio de Santiago A.G. cuyas disposiciones fueron publicadas en el Diario
		Oficial del día 8 de mayo de 2002 y que las partes declaran conocer y aceptar,
		teniéndolas como parte integrante de la presente cláusula.<br/>
		Las partes confieren poder mandato especial irrevocable a la Cámara De
		Comercio de Santiago A.G. para que, a solicitud escrita de cualquiera de ellas,
		designe árbitro, en carácter de árbitro de derecho, de entre los integrantes del
		cuerpo arbitral del centro de arbitrajes de esa cámara.
	</p>';
$html_4 = '
	<br/><br/><br/>
	<p>
		<strong>OCTAVO</strong>: Para todos los efectos legales derivados del presente contrato, las
		partes fijan domicilio en Santiago, Región Metropolitana y se someten a la
		jurisdicción arbitral pactada.<br/><br/>
		
		<strong>NOVENO</strong>: El presente contrato se firma en dos ejemplares de idéntico tenor y
		fecha, quedando uno en poder de cada una de las partes.<br/><br/>
	</p>	
	
	<br/><br/><br/><br/><br/><br/><br/><br/>
	<h4  style="text-align:center;width:100%;">
		<strong>
			BUSAFE SpA.<br/>
			MARCO ANTONIO CAMPOS PATUELLI<br/><br/><br/>
			'.$rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat'].'<br/>
		</strong>
	</h4>';
$html_5 = '
	<br/><br/><br/>
	<h4 style="text-align:center;width:100%;" >
		<strong>ANEXO N°1</strong>
	</h4>
	
	<p>
		<strong>Servicio ofrecido</strong><br/>
		
		BUSAFE SPA, empresa de servicios tecnológicos, tiene el agrado de ofrecer soluciones
		informáticas a través de una aplicación móvil en plataformas Googleplay y/o Appstore, teniendo
		como objetivo aportar en la seguridad de los escolares que van en trayecto en el servicio de
		transporte escolar seleccionado por sus padres y apoderados.<br/><br/>
		
		<strong>Descripción del servicio</strong><br/>
		
		El servicio de monitoreo de transporte escolar contempla lo siguiente:<br/>
		
		
		1.  Instalación de app móvil en smartphone de cliente, entregando todo el soporte 
		asociado a la plataforma.<br/>
		2.  Plataforma web apoderado.busafe.cl donde debe ingresar con su rut y contraseña para 
		administrar sus pagos e información de hijos (as).<br/>
		3.  La app enviará vía notificaciones, la mensajería contemplada en el servicio, dentro de
		las cuales se cuenta: GPS, ubicación del transporte escolar, ingreso y salida del
		transporte escolar, atrasos en el camino, información del conductor, además de otras
		nuevas notificaciones que serán avisadas a los apoderados oportunamente vía correo
		electrónico, en el ámbito de la mejora continua que contempla este servicio de BUSAFE.<br/>
		4.  Ante cualquier anomalía en el servicio, el cliente puede ponerse en contacto con la
		empresa BUSAFE SPA al correo contacto@busafespa.cl, contemplándose un máximo
		de 48 hrs para dar respuesta al requerimiento del cliente.<br/>
		
		
		<br/>
		
		<strong>Costos asociados al servicio</strong><br/>
		El servicio de monitoreo de transporte escolar tiene un costo según el plan que se quiera
		adquirir. Este puede ser anual o mensual. El cliente puede cambiar de plan cuando lo requiera
		siempre y cuando NO sea bajar el plan cuando esté en curso el pago.
		
	</p>';
$html_6 = '
	<br/><br/><br/>
	<p>
		<strong>Los planes se presentan a continuación:</strong><br/><br/>
		<strong>Mensual:</strong>
	</p>		
	<table border="0">
		<tr>
			<td>Individual</td>
			<td>1 hijo/a</td>
			<td>$ 6.990</td>
		</tr>
		<tr>
			<td>Familiar</td>
			<td>2 hijos/as</td>
			<td>$ 9.990</td>
		</tr>
		<tr>
			<td>Familiar plus</td>
			<td>3 hijos/as o más</td>
			<td>$ 12.990</td>
		</tr>
	</table> 
		
	<p>
		En caso de requerir un plan más alto, el cliente puede hacerlo y se actualizará una vez que
		venza el mes en curso. Al siguiente mes, el cliente deberá cancelar el nuevo monto.
		El cliente no podrá bajar de plan durante el mes en curso.Para formalizarlo deberá ponerse en
		contacto con BUSAFE al correo contacto@busafe.cl.<br/><br/>
		Esta modalidad mensual, permite dar de baja su servicio el mes que quiera el cliente. Debe
		tener sus mensualidades al día para renunciar al servicio. El reintegro podrá ser en el mes que
		se estime conveniente, cancelando lo adeudado en uso en caso de tener pagos pendientes.
		Sólo se realizan cobros los meses que se usó la app.<br/><br/>
		Cuando el cliente requiera hacer algún cambio en su plan o información, lo puede hacer
		directamente desde la plataforma web “apoderado.busafe.cl” con un máximo de 3 cambios. Al
		exceder la cantidad de intentos, se debe poner en contacto con la empresa Busafe al correo
		“contacto@busafe.cl”
	</p>	

	<p>
		<strong>Anual:</strong>
	</p>		
	<table border="0">
		<tr>
			<td>Individual</td>
			<td>1 hijo/a</td>
			<td>$ 62.990</td>
		</tr>
		<tr>
			<td>Familiar</td>
			<td>2 hijos/as</td>
			<td>$ 89.990</td>
		</tr>
		<tr>
			<td>Familiar plus</td>
			<td>3 hijos/as o más</td>
			<td>$ 116.990</td>
		</tr>
	</table>
	
	<p>
		El contrato de servicio en esta modalidad durara todo el año escolar, por lo que una vez
		pagado, no se podrá renunciar al servicio contratado. El cliente es responsable de hacer uso de
		la app y Busafe no reembolsara el dinero si el cliente no le esta dando uso previsto.
	</p>';

   

/**********************************************************************************************************************************/
/*                                                          Impresion PDF                                                         */
/**********************************************************************************************************************************/
//Config
$pdf_titulo     = '';
$pdf_subtitulo  = '';
$pdf_file       = 'Contrato.pdf';
/********************************************************************************/
//Se verifica que este configurado el motor de pdf
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
$logo = '../../../../'.DB_SITE_MAIN_PATH.'/img/mifavicon.png';
$pdf->SetHeaderData($logo, 25, $pdf_titulo, $pdf_subtitulo);

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
$pdf->SetFont('helvetica', '', 12);
//Pagina 1
$pdf->AddPage($AddPageL, $AddPageA);
$pdf->writeHTML($html_1, true, false, true, false, '');
//Pagina 2
$pdf->AddPage($AddPageL, $AddPageA);
$pdf->writeHTML($html_2, true, false, true, false, '');
//Pagina 3
$pdf->AddPage($AddPageL, $AddPageA);
$pdf->writeHTML($html_3, true, false, true, false, '');
//Pagina 4
$pdf->AddPage($AddPageL, $AddPageA);
$pdf->writeHTML($html_4, true, false, true, false, '');
//Pagina 5
$pdf->AddPage($AddPageL, $AddPageA);
$pdf->writeHTML($html_5, true, false, true, false, '');
//Pagina 6
$pdf->AddPage($AddPageL, $AddPageA);
$pdf->writeHTML($html_6, true, false, true, false, '');


$pdf->lastPage();
$pdf->Output($pdf_file, 'I');
	



?>

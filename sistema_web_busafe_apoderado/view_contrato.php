<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Views.php';
/**********************************************************************************************************************************/
/*                                                 Variables Globales                                                             */
/**********************************************************************************************************************************/
//Tiempo Maximo de la consulta, 40 minutos por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim); }else{set_time_limit(2400);}             
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M'); }else{ini_set('memory_limit', '4096M');}  
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
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
$rowData = mysqli_fetch_assoc ($resultado);
?>

<style>

body {
	background-color: #F3C500;
	background-image: url("img/Fondo.jpg");
	background-size: 100%;
}
td{padding-right: 30px;}
</style>

<div style="position:absolute;left:50%;margin-left:-350px;top:0px;width:701px;height:842px;border-style:outset;overflow:hidden">
	<div style="position:absolute;left:0px;top:0px">
		<img src="img/background.jpg" width=700 height=842>
	</div>

	<h3 style="position:absolute;top:170px;text-align:center;width:100%;" ><strong>CONTRATO DE PRESTACIÓN DE SERVICIOS</strong></h3>
	<h3 style="position:absolute;top:240px;text-align:center;width:100%;" ><strong>MONITOREO TRANSPORTE ESCOLAR</strong></h3>
	<h3 style="position:absolute;top:315px;text-align:center;width:100%;" >
		<strong>
			BUSAFE SpA.<br/>
			Y<br/>
			<?php echo $rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat']; ?><br/>
		</strong>
	</h3>
	
	<p style="position:absolute;left:40px;right:40px;top:505px" >
		En Santiago de Chile, a <strong><?php echo fecha_estandar($rowData['fCreacion']); ?></strong>, 
		entre <strong>BUSAFE SPA</strong>, R.U.T. <strong>77.099.293-1</strong>, representada por 
		don <strong>MARCO ANTONIO CAMPOS PATUELLI</strong>, Cédula de Identidad <strong>10.123.351-0</strong>, 
		ambos domiciliados en Santiago, calle badajoz 100, oficina 523, Las Condes, Santiago, en 
		lo sucesivo  <strong>BUSAFE SPA</strong> y <strong><?php echo $rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat']; ?></strong>, 
		Cédula de identidad Nº <strong><?php echo $rowData['ApoderadoRut']; ?></strong>, 
		domiciliado para estos efectos en  <strong><?php echo $rowData['ApoderadoDireccion']; ?></strong>, 
		comuna <strong><?php echo $rowData['ApoderadoComuna']; ?></strong>, ciudad  de  
		<?php echo $rowData['ApoderadoCiudad']; ?>,  en  adelante <strong>“EL CLIENTE” </strong>; 
		se ha convenido el siguiente contrato de prestación de servicios tecnológicos, el que 
		se regirá por las siguientes disposiciones:
	</p>



</div>
<div style="position:absolute;left:50%;margin-left:-350px;top:852px;width:701px;height:842px;border-style:outset;overflow:hidden">
	<div style="position:absolute;left:0px;top:0px">
		<img src="img/background.jpg" width=700 height=842>
	</div>
	<p style="position:absolute;left:40px;right:40px;top:122px" >
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
		
		<strong>CUARTO</strong>:  <strong><?php echo $rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat']; ?></strong>  se  obliga  
		pagar  los  servicios  objeto  del presente contrato, prestados por BUSAFE 
		SPA oportunamente y en la forma establecida en el artículo segundo del 
		presente contrato.<br/><br/>
		
		<strong>QUINTO</strong>: El presente contrato entra a regir a partir de su fecha y tendrá una
		duración por todo el año en cuestión. El cliente puede dar de baja su servicio
		cuando  lo requiera, cancelando solamente los meses de uso efectivo.
	</p>	
	
</div>
<div style="position:absolute;left:50%;margin-left:-350px;top:1704px;width:701px;height:842px;border-style:outset;overflow:hidden">
	<div style="position:absolute;left:0px;top:0px">
		<img src="img/background.jpg" width=700 height=842>
	</div>
	<p style="position:absolute;left:40px;right:40px;top:122px" >
		<strong>SEXTO</strong>:  Para  todos  los  efectos  legales  derivados  de  este  contrato,  las
		comunicaciones que deban efectuarse entre <strong><?php echo $rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat']; ?></strong> 
		y BUSAFE SPA, se   entenderán   válidamente   cumplidos   si   se   dirigen   a:   BUSAFE   SPA,
		domiciliada en badajoz 100, oficina N°523, Las Condes, Santiago, Teléfono
		(56-9)56677290;   email   contacto@busafe.cl;   en   atención   al   Sr.   Gonzalo
		Campos Jure.  Por la otra parte, las comunicaciones serán dirigidas a 
		<strong><?php echo $rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat']; ?></strong> 
		domiciliado en <strong><?php echo $rowData['ApoderadoDireccion']; ?></strong>, 
		comuna de <strong><?php echo $rowData['ApoderadoComuna']; ?></strong>, 
		teléfono <strong><?php echo $rowData['ApoderadoFono']; ?></strong>, 
		email <strong><?php echo $rowData['ApoderadoEmail']; ?></strong>.<br/>
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
	</p>
	
		
	
</div>
<div style="position:absolute;left:50%;margin-left:-350px;top:2556px;width:701px;height:842px;border-style:outset;overflow:hidden">
	<div style="position:absolute;left:0px;top:0px">
		<img src="img/background.jpg" width=700 height=842>
	</div>
	<p style="position:absolute;left:40px;right:40px;top:122px" >
		<strong>OCTAVO</strong>: Para todos los efectos legales derivados del presente contrato, las
		partes fijan domicilio en Santiago, Región Metropolitana y se someten a la
		jurisdicción arbitral pactada.<br/><br/>
		
		<strong>NOVENO</strong>: El presente contrato se firma en dos ejemplares de idéntico tenor y
		fecha, quedando uno en poder de cada una de las partes.<br/><br/>
	</p>	
	
	<h4 style="position:absolute;top:315px;text-align:center;width:100%;" >
		<strong>
			BUSAFE SpA.<br/>
			MARCO ANTONIO CAMPOS PATUELLI<br/><br/><br/>
			<?php echo $rowData['ApoderadoNombre'].' '.$rowData['ApoderadoApellidoPat'].' '.$rowData['ApoderadoApellidoMat']; ?><br/>
		</strong>
	</h4>
	

</div>
<div style="position:absolute;left:50%;margin-left:-350px;top:3408px;width:701px;height:842px;border-style:outset;overflow:hidden">
	<div style="position:absolute;left:0px;top:0px">
		<img src="img/background.jpg" width=700 height=842>
	</div>
	<h4 style="position:absolute;top:122px;text-align:center;width:100%;" >
		<strong>ANEXO N°1</strong>
	</h4>
	
	<p style="position:absolute;left:40px;right:40px;top:168px" >
		<strong>Servicio ofrecido</strong><br/>
		
		BUSAFE SPA, empresa de servicios tecnológicos, tiene el agrado de ofrecer soluciones
		informáticas a través de una aplicación móvil en plataformas Googleplay y/o Appstore, teniendo
		como objetivo aportar en la seguridad de los escolares que van en trayecto en el servicio de
		transporte escolar seleccionado por sus padres y apoderados.<br/><br/>
		
		<strong>Descripción del servicio</strong><br/>
		
		El servicio de monitoreo de transporte escolar contempla lo siguiente:<br/>
		
		<span style="position:relative;left:20px;right:20px;">
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
		</span>
		
		<br/>
		
		<strong>Costos asociados al servicio</strong><br/>
		El servicio de monitoreo de transporte escolar tiene un costo según el plan que se quiera
		adquirir. Este puede ser anual o mensual. El cliente puede cambiar de plan cuando lo requiera
		siempre y cuando NO sea bajar el plan cuando esté en curso el pago.
		
	</p>
	
	

	
	
</div>
<div style="position:absolute;left:50%;margin-left:-350px;top:4260px;width:701px;height:842px;border-style:outset;overflow:hidden">
	<div style="position:absolute;left:0px;top:0px">
		<img src="img/background.jpg" width=700 height=842>
	</div>
	<p style="position:absolute;left:40px;right:40px;top:122px" >
		<strong>Los planes se presentan a continuación:</strong><br/><br/>
		<strong>Mensual:</strong><br/>
	</p>		
	<table border="0" style="position:absolute;left:40px;top:179px">
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
		
	<p style="position:absolute;left:40px;right:40px;top:255px" >
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

	<p style="position:absolute;left:40px;right:40px;top:559px" >
		<strong>Anual:</strong><br/>
	</p>		
	<table border="0" style="position:absolute;left:40px;top:578px">
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
	
	<p style="position:absolute;left:40px;right:40px;top:654px" >
		El contrato de servicio en esta modalidad durara todo el año escolar, por lo que una vez
		pagado, no se podrá renunciar al servicio contratado. El cliente es responsable de hacer uso de
		la app y Busafe no reembolsara el dinero si el cliente no le esta dando uso previsto.
	</p>
	
	
	
</div>


<?php 
//si se entrega la opcion de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){ 
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
	<?php 
	//para las versiones nuevas que indican donde volver
	}else{ 
		$string = basename($_SERVER["REQUEST_URI"], ".php");
		$array  = explode("&return=", $string, 3);
		$volver = $array[1];
		?>
		<div class="clearfix"></div>
		<div class="col-sm-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
			<div class="clearfix"></div>
		</div>
		
	<?php }		
} ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Views.php';
?>

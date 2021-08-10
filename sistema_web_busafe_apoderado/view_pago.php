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
sistema_planes_transporte.Nombre AS PlanNombre,

vehiculos_facturacion_apoderados_pago.paymentTypeCode,
vehiculos_facturacion_apoderados_pago.transactionDate,
vehiculos_facturacion_apoderados_pago.buyOrder,
vehiculos_facturacion_apoderados_listado_detalle.idPago AS NDocPago,
vehiculos_facturacion_apoderados_pago.amount,
vehiculos_facturacion_apoderados_pago.cardNumber,
vehiculos_facturacion_apoderados_pago.authorizationCode,
vehiculos_facturacion_apoderados_pago.sharesNumber

				
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
?>

<style>
.table tbody tr td{border-top: none;color:#626262;font-size:12px;}
.table-responsive{background-color:#f8f8f8; border:solid 1px #ccc; padding:5px 2px 15px 2px;}
</style>

<div class="row no-print">
	<div class="col-xs-12">
		<a target="new" href="view_pago_to_pdf.php?view=<?php echo $_GET['view'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema']?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
			<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF
		</a>
	</div>
</div>
	
	
<div class="col-sm-12">
	<div class="box">
		<header>		
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Detalle Facturacion</h5>
		</header>
		<div class="tab-content">
			<br/>
			<div class="col-sm-12">
				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<td colspan="2" class="style1" align="center">
									<span style="font-size: 16px; color: #D51C24">COMPROBANTE DE PAGO</span>
								</td>
							</tr>
							<?php
							switch ($rowData['paymentTypeCode']) {
								case 'VD': $TipoPago = 'Venta Débito'; break;
								case 'VN': $TipoPago = 'Venta Normal'; break;
								case 'VC': $TipoPago = 'Venta en cuotas'; break;
								case 'SI': $TipoPago = '3 cuotas sin interés'; break;
								case 'S2': $TipoPago = '2 cuotas sin interés'; break;
								case 'NC': $TipoPago = 'N Cuotas sin interés'; break;
								case 'VP': $TipoPago = 'Venta Prepago'; break;
								
							} ?>
							
										
							<tr><td><strong>Cliente:</strong></td>                                  <td><?php echo $_SESSION['usuario']['basic_data']['Nombre'];?></td></tr>
							<tr><td><strong>Servicio:</strong></td>                                 <td><?php echo 'Plan '.$rowData['PlanNombre']; ?></td></tr>
							<tr><td><strong>Fecha:</strong></td>                                    <td><?php echo $rowData['transactionDate']; ?></td></tr>
							<tr><td><strong>Orden de Compra:</strong></td>                          <td><?php echo $rowData['buyOrder']; ?></td></tr>
							<tr><td><strong>N° de Comprobante:</strong></td>                        <td><?php echo n_doc($rowData['NDocPago'], 8); ?></td></tr>
							<tr><td><strong>Monto:</strong></td>                                    <td><?php echo Valores($rowData['amount'], 0); ?></td></tr>
							<tr><td><strong>Ultimos dígitos de la tarjeta:</strong></td>            <td><?php echo $rowData['cardNumber']; ?></td></tr>
							<tr><td><strong>Código autorización de la Transacción:</strong></td>    <td><?php echo $rowData['authorizationCode']; ?></td></tr>
							<tr><td><strong>Tipo de Pago:</strong></td>                             <td><?php echo $TipoPago; ?></td></tr>
							<tr><td><strong>Número de Cuotas:</strong></td>                         <td><?php echo $rowData['sharesNumber']; ?></td></tr>
							<tr><td><strong>Estado Pago:</strong></td>                              <td>PAGO REALIZADO EXITOSAMENTE</td></tr>
							

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
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

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

$query = "SELECT  
sistema_origen.Nombre AS SistemaOrigen,
sis_or_ciudad.Nombre AS SistemaOrigenCiudad,
sis_or_comuna.Nombre AS SistemaOrigenComuna,
sistema_origen.Direccion AS SistemaOrigenDireccion,
sistema_origen.Contacto_Fono1 AS SistemaOrigenFono,
sistema_origen.email_principal AS SistemaOrigenEmail,
sistema_origen.Rut AS SistemaOrigenRut,

apoderados_listado.Nombre AS Apoderado_Nombre,
apoderados_listado.ApellidoPat AS Apoderado_ApellidoPat,
apoderados_listado.ApellidoMat AS Apoderado_ApellidoMat,
apoderados_listado.Fono1 AS Apoderado_Fono1,
apoderados_listado.Fono2 AS Apoderado_Fono2,
apoderados_listado.Rut AS Apoderado_Rut,
apoderadosciudad.Nombre AS Apoderado_Ciudad,
apoderadoscomuna.Nombre AS Apoderado_Comuna,
apoderados_listado.Direccion AS Apoderado_Direccion,
apoderados_listado.email AS Apoderado_Email,

sistema_planes_transporte.Nombre AS Plan,

vehiculos_facturacion_apoderados_listado_detalle.Fecha AS CreacionFecha,
vehiculos_facturacion_apoderados_listado_detalle.MontoPactado AS CreacionMonto,

vehiculos_facturacion_apoderados_listado_detalle.idPago AS PagoID,
vehiculos_facturacion_apoderados_listado_detalle.Pagofecha AS Pagofecha,
core_estado_facturacion.Nombre AS PagoEstado,
vehiculos_facturacion_apoderados_listado_detalle.montoPago AS PagoMonto

				
FROM vehiculos_facturacion_apoderados_listado_detalle 
LEFT JOIN sistema_planes_transporte                    ON sistema_planes_transporte.idPlan             = vehiculos_facturacion_apoderados_listado_detalle.idPlan
LEFT JOIN core_estado_facturacion                      ON core_estado_facturacion.idEstado             = vehiculos_facturacion_apoderados_listado_detalle.idEstadoPago
LEFT JOIN `core_sistemas`   sistema_origen             ON sistema_origen.idSistema                     = vehiculos_facturacion_apoderados_listado_detalle.idSistema
LEFT JOIN `core_ubicacion_ciudad`   sis_or_ciudad      ON sis_or_ciudad.idCiudad                       = sistema_origen.idCiudad
LEFT JOIN `core_ubicacion_comunas`  sis_or_comuna      ON sis_or_comuna.idComuna                       = sistema_origen.idComuna
LEFT JOIN `apoderados_listado`                         ON apoderados_listado.idApoderado               = vehiculos_facturacion_apoderados_listado_detalle.idApoderado
LEFT JOIN `core_ubicacion_ciudad`    apoderadosciudad  ON apoderadosciudad.idCiudad                    = apoderados_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`   apoderadoscomuna  ON apoderadoscomuna.idComuna                    = apoderados_listado.idComuna


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
$row_data = mysqli_fetch_assoc ($resultado);

?>



<section class="invoice">
	
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"></i> Facturacion.
				<small class="pull-right">Documento N°: <?php echo n_doc($_GET['view'], 8) ?></small>
			</h2>
		</div>   
	</div>
	
	<div class="row invoice-info">
		<div class="col-sm-4 invoice-col">
			Emisor
			<address>
				<strong><?php echo $row_data['SistemaOrigen']; ?></strong><br>
				<?php echo $row_data['SistemaOrigenCiudad'].', '.$row_data['SistemaOrigenComuna'].'<br>
				'.$row_data['SistemaOrigenDireccion'].'<br>
				Fono: '.$row_data['SistemaOrigenFono'].'<br>
				Rut: '.$row_data['SistemaOrigenRut'].'<br>
				Email: '.$row_data['SistemaOrigenEmail']; ?>
			</address>
		</div>
		<div class="col-sm-4 invoice-col">
			Apoderado
			<address>
				<strong><?php echo $row_data['Apoderado_Nombre'].' '.$row_data['Apoderado_ApellidoPat'].' '.$row_data['Apoderado_ApellidoMat']; ?></strong><br>
				<?php echo $row_data['Apoderado_Ciudad'].', '.$row_data['Apoderado_Comuna'].'<br>
				'.$row_data['Apoderado_Direccion'].'<br>
				Fono Fijo: '.$row_data['Apoderado_Fono1'].'<br>
				Celular: '.$row_data['Apoderado_Fono2'].'<br>
				Rut: '.$row_data['Apoderado_Rut'].'<br>
				Email: '.$row_data['Apoderado_Email']; ?>
			</address>
		</div>
			   
		<div class="col-sm-4 invoice-col">
			Datos Emision
			<address>
				<?php
				echo '<strong>Estado de Pago: '.$row_data['PagoEstado'].'</strong><br>';
				if(isset($row_data['PagoID'])&&$row_data['PagoID']!=0){
					echo 'Fecha Pago: '.fecha_estandar($row_data['Pagofecha']).'<br>';
					echo 'Monto Pago: '.valores($row_data['PagoMonto'], 0).'<br>';
				} ?>
			</address>	
		</div>
	</div>
	
	
	<div class="">
		<div class="col-xs-12 table-responsive" style="padding-left: 0px; padding-right: 0px;border: 1px solid #ddd;">
			<table class="table table-striped">
				<thead>
					<tr>
						<th>Plan</th>
						<th width="120">Fecha Facturacion</th>
						<th width="120" align="right">Monto Facturado</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?php echo $row_data['Plan'];?></td>
						<td><?php echo fecha_estandar($row_data['CreacionFecha']);?></td>
						<td align="right"><?php echo valores($row_data['CreacionMonto'], 0);?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="clearfix"></div>

</section>





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

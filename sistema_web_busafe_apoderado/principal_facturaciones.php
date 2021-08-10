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
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion 
$original = "principal_contratos.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Facturaciones';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submitPlan']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'changePlan_step1';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado.php';
}
//formulario para editar
if ( !empty($_GET['Respuesta']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'changePlan_step2';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
$arrFacturaciones = array();
$query = "SELECT 
vehiculos_facturacion_apoderados_listado_detalle.idFacturacionDetalle, 
vehiculos_facturacion_apoderados_listado_detalle.Ano,
vehiculos_facturacion_apoderados_listado_detalle.montoPago,
vehiculos_facturacion_apoderados_listado_detalle.Pagofecha,
vehiculos_facturacion_apoderados_listado_detalle.idPago,

core_tiempo_meses.Nombre AS Mes,
sistema_planes_transporte.Nombre AS Plan,
core_estado_facturacion.Nombre AS Estado

				
FROM vehiculos_facturacion_apoderados_listado_detalle 
LEFT JOIN core_tiempo_meses           ON core_tiempo_meses.idMes            = vehiculos_facturacion_apoderados_listado_detalle.idMes
LEFT JOIN sistema_planes_transporte   ON sistema_planes_transporte.idPlan   = vehiculos_facturacion_apoderados_listado_detalle.idPlan
LEFT JOIN core_estado_facturacion     ON core_estado_facturacion.idEstado   = vehiculos_facturacion_apoderados_listado_detalle.idEstadoPago
WHERE vehiculos_facturacion_apoderados_listado_detalle.idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."' 
ORDER BY vehiculos_facturacion_apoderados_listado_detalle.Ano DESC, vehiculos_facturacion_apoderados_listado_detalle.idMes DESC";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrFacturaciones,$row );
}

?>

<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Facturaciones</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Plan Seleccionado</th>
						<th width="120">Periodo Facturacion</th>
						<th width="120">Monto Pagado</th>
						<th width="120">Estado</th>
						<th width="120">Fecha Pago</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>				  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrFacturaciones as $fact) { ?>
						<tr class="odd">
							<td><?php echo $fact['Plan']; ?></td>		
							<td><?php echo $fact['Mes'].' - '.$fact['Ano']; ?></td>		
							<td><?php echo valores($fact['montoPago'], 0); ?></td>
								
							<td><?php echo $fact['Estado']; ?></td>	
							<td><?php echo fecha_estandar($fact['Pagofecha']); ?></td>	
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="view_facturacion.php?view=<?php echo $fact['idFacturacionDetalle']?>" title="Ver Informacion Pago" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									
									
									<?php if(isset($fact['idPago'])&&$fact['idPago']!=0){ ?>
										<a href="view_pago.php?view=<?php echo $fact['idFacturacionDetalle']?>" title="Ver Informacion Pago" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<?php } ?>
								</div>
							</td>	
						</tr>
					<?php } ?>                    
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php widget_modal(80, 95); ?>


<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

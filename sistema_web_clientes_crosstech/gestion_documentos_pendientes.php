<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
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
//Cargamos la ubicacion original
$original = "gestion_tickets.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-usd" aria-hidden="true"></i> Mis Documentos Vencidos';
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//Variable de busqueda
$z1 = "WHERE bodegas_arriendos_facturacion.idEstado=1";
$z2 = "WHERE bodegas_insumos_facturacion.idEstado=1";
$z3 = "WHERE bodegas_productos_facturacion.idEstado=1";
$z4 = "WHERE bodegas_servicios_facturacion.idEstado=1";
//Verifico el tipo de usuario que esta ingresando
$z1.=" AND bodegas_arriendos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z2.=" AND bodegas_insumos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z3.=" AND bodegas_productos_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$z4.=" AND bodegas_servicios_facturacion.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//Verifico que sean solo compras
$z1.=" AND (bodegas_arriendos_facturacion.idTipo=2 OR bodegas_arriendos_facturacion.idTipo=12)";
$z2.=" AND (bodegas_insumos_facturacion.idTipo=2 OR bodegas_insumos_facturacion.idTipo=12)";
$z3.=" AND (bodegas_productos_facturacion.idTipo=2 OR bodegas_productos_facturacion.idTipo=12)";
$z4.=" AND (bodegas_servicios_facturacion.idTipo=2 OR bodegas_servicios_facturacion.idTipo=12)";
//se filtra el cliente
$z1.=" AND bodegas_arriendos_facturacion.idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
$z2.=" AND bodegas_insumos_facturacion.idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
$z3.=" AND bodegas_productos_facturacion.idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
$z4.=" AND bodegas_servicios_facturacion.idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];
//se filtra que este vencida
$z1.=" AND bodegas_arriendos_facturacion.Pago_fecha<='".fecha_actual()."'";
$z2.=" AND bodegas_insumos_facturacion.Pago_fecha<='".fecha_actual()."'";
$z3.=" AND bodegas_productos_facturacion.Pago_fecha<='".fecha_actual()."'";
$z4.=" AND bodegas_servicios_facturacion.Pago_fecha<='".fecha_actual()."'";

/*if(isset($_GET['idDocumentos'])&&$_GET['idDocumentos']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$z2.=" AND bodegas_insumos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$z3.=" AND bodegas_productos_facturacion.idDocumentos=".$_GET['idDocumentos'];
	$z4.=" AND bodegas_servicios_facturacion.idDocumentos=".$_GET['idDocumentos'];
}
if(isset($_GET['N_Doc'])&&$_GET['N_Doc']!=''){       
	$z1.=" AND bodegas_arriendos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z2.=" AND bodegas_insumos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z3.=" AND bodegas_productos_facturacion.N_Doc=".$_GET['N_Doc'];
	$z4.=" AND bodegas_servicios_facturacion.N_Doc=".$_GET['N_Doc'];
}
if(isset($_GET['f_creacion_inicio'], $_GET['f_creacion_termino'])&&$_GET['f_creacion_inicio']!=''&&$_GET['f_creacion_termino']!=''){
	$z1.=" AND bodegas_arriendos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z2.=" AND bodegas_insumos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z3.=" AND bodegas_productos_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
	$z4.=" AND bodegas_servicios_facturacion.Creacion_fecha BETWEEN '".$_GET['f_creacion_inicio']."' AND '".$_GET['f_creacion_termino']."'";
}*/

/*************************************************************************************/
// Se trae un listado con todos los elementos
$arrTipo1 = array();
$query = "SELECT 
bodegas_arriendos_facturacion.idFacturacion,
bodegas_arriendos_facturacion.Creacion_fecha,
bodegas_arriendos_facturacion.Pago_fecha,
bodegas_arriendos_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
core_documentos_mercantiles.Nombre AS Documento,
clientes_listado.Nombre AS Cliente,
bodegas_arriendos_facturacion.MontoPagado,
bodegas_arriendos_facturacion.ValorTotal

FROM `bodegas_arriendos_facturacion`
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema                     = bodegas_arriendos_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`  ON core_documentos_mercantiles.idDocumentos    = bodegas_arriendos_facturacion.idDocumentos
LEFT JOIN `clientes_listado`             ON clientes_listado.idCliente                  = bodegas_arriendos_facturacion.idCliente
".$z1;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
	$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
	$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo1,$row );
}
/*************************************************************************************/
// Se trae un listado con todos los elementos
$arrTipo2 = array();
$query = "SELECT 
bodegas_insumos_facturacion.idFacturacion,
bodegas_insumos_facturacion.Creacion_fecha,
bodegas_insumos_facturacion.Pago_fecha,
bodegas_insumos_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
core_documentos_mercantiles.Nombre AS Documento,
clientes_listado.Nombre AS Cliente,
bodegas_insumos_facturacion.MontoPagado,
bodegas_insumos_facturacion.ValorTotal

FROM `bodegas_insumos_facturacion`
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema                     = bodegas_insumos_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`  ON core_documentos_mercantiles.idDocumentos    = bodegas_insumos_facturacion.idDocumentos
LEFT JOIN `clientes_listado`             ON clientes_listado.idCliente                  = bodegas_insumos_facturacion.idCliente
".$z2;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
	$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
	$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo2,$row );
}
/*************************************************************************************/
// Se trae un listado con todos los elementos
$arrTipo3 = array();
$query = "SELECT 
bodegas_productos_facturacion.idFacturacion,
bodegas_productos_facturacion.Creacion_fecha,
bodegas_productos_facturacion.Pago_fecha,
bodegas_productos_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
core_documentos_mercantiles.Nombre AS Documento,
clientes_listado.Nombre AS Cliente,
bodegas_productos_facturacion.MontoPagado,
bodegas_productos_facturacion.ValorTotal

FROM `bodegas_productos_facturacion`
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema                     = bodegas_productos_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`  ON core_documentos_mercantiles.idDocumentos    = bodegas_productos_facturacion.idDocumentos
LEFT JOIN `clientes_listado`             ON clientes_listado.idCliente                  = bodegas_productos_facturacion.idCliente
".$z3;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
	$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
	$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo3,$row );
}
/*************************************************************************************/
// Se trae un listado con todos los elementos
$arrTipo4 = array();
$query = "SELECT 
bodegas_servicios_facturacion.idFacturacion,
bodegas_servicios_facturacion.Creacion_fecha,
bodegas_servicios_facturacion.Pago_fecha,
bodegas_servicios_facturacion.N_Doc,
core_sistemas.Nombre AS Sistema,
core_documentos_mercantiles.Nombre AS Documento,
clientes_listado.Nombre AS Cliente,
bodegas_servicios_facturacion.MontoPagado,
bodegas_servicios_facturacion.ValorTotal

FROM `bodegas_servicios_facturacion`
LEFT JOIN `core_sistemas`                ON core_sistemas.idSistema                     = bodegas_servicios_facturacion.idSistema
LEFT JOIN `core_documentos_mercantiles`  ON core_documentos_mercantiles.idDocumentos    = bodegas_servicios_facturacion.idDocumentos
LEFT JOIN `clientes_listado`             ON clientes_listado.idCliente                  = bodegas_servicios_facturacion.idCliente
".$z4;
//Consulta
$resultado = mysqli_query ($dbConn, $query);
//Si ejecuto correctamente la consulta
if(!$resultado){
	//Genero numero aleatorio
	$vardata = genera_password(8,'alfanumerico');
					
	//Guardo el error en una variable temporal
	$_SESSION['ErrorListing'][$vardata]['code']         = mysqli_errno($dbConn);
	$_SESSION['ErrorListing'][$vardata]['description']  = mysqli_error($dbConn);
	$_SESSION['ErrorListing'][$vardata]['query']        = $query;
					
}
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrTipo4,$row );
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Documentos</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Cliente</th>
						<th>Documento</th>
						<th>Fecha de Ingreso</th>
						<th>Fecha de Pago</th>
						<th>Valor Total</th>
						<th>Monto Pagado</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php if($arrTipo1){ ?>
						<tr class="odd"><td style="background-color:#DDD" colspan="7">Arriendos</td></tr>
						<?php foreach ($arrTipo1 as $tipo) { ?>
							<tr class="odd">
								<td><?php echo $tipo['Cliente']; ?></td>
								<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
								<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
								<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
								<td><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
								<td><?php echo Valores($tipo['MontoPagado'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if($arrTipo2){ ?>
						<tr class="odd"><td style="background-color:#DDD" colspan="7">Insumos</td></tr>
						<?php foreach ($arrTipo2 as $tipo) { ?>
							<tr class="odd">
								<td><?php echo $tipo['Cliente']; ?></td>
								<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
								<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
								<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
								<td><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
								<td><?php echo Valores($tipo['MontoPagado'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if($arrTipo3){ ?>
						<tr class="odd"><td style="background-color:#DDD" colspan="7">Productos</td></tr>
						<?php foreach ($arrTipo3 as $tipo) { ?>
							<tr class="odd">
								<td><?php echo $tipo['Cliente']; ?></td>
								<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
								<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
								<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
								<td><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
								<td><?php echo Valores($tipo['MontoPagado'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php if($arrTipo4){ ?>
						<tr class="odd"><td style="background-color:#DDD" colspan="7">Servicios</td></tr>
						<?php foreach ($arrTipo4 as $tipo) { ?>
							<tr class="odd">
								<td><?php echo $tipo['Cliente']; ?></td>
								<td><?php echo $tipo['Documento'].' '.$tipo['N_Doc']; ?></td>
								<td><?php echo Fecha_estandar($tipo['Creacion_fecha']); ?></td>
								<td><?php echo Fecha_estandar($tipo['Pago_fecha']); ?></td>
								<td><?php echo Valores($tipo['ValorTotal'], 0); ?></td>
								<td><?php echo Valores($tipo['MontoPagado'], 0); ?></td>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>

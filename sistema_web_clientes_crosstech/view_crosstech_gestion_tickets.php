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
if(isset($_SESSION['usuario']['basic_data']['ConfigTime'])&&$_SESSION['usuario']['basic_data']['ConfigTime']!=0){$n_lim = $_SESSION['usuario']['basic_data']['ConfigTime']*60;set_time_limit($n_lim);}else{set_time_limit(2400);}
//Memora RAM Maxima del servidor, 4GB por defecto
if(isset($_SESSION['usuario']['basic_data']['ConfigRam'])&&$_SESSION['usuario']['basic_data']['ConfigRam']!=0){$n_ram = $_SESSION['usuario']['basic_data']['ConfigRam']; ini_set('memory_limit', $n_ram.'M');}else{ini_set('memory_limit', '4096M');}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Views.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
// consulto los datos
$query = "SELECT 
crosstech_gestion_tickets.idTicket,
crosstech_gestion_tickets.Titulo,
crosstech_gestion_tickets.FechaCreacion,
crosstech_gestion_tickets.FechaCierre,
crosstech_gestion_tickets.FechaCancelacion,
crosstech_gestion_tickets.Descripcion,
crosstech_gestion_tickets.DescripcionCierre,
crosstech_gestion_tickets.DescripcionCancelacion,

core_sistemas.Nombre AS Sistema,
clientes_listado.Nombre AS Cliente,
core_tipo_ticket.Nombre AS TipoTicket,
core_estado_ticket.Nombre AS EstadoTicket,
core_ot_prioridad.Nombre AS PrioridadTicket,
usuario_asignado.Nombre AS UsuarioAsignado,
crosstech_gestion_tickets_area.Nombre AS AreaTicket

FROM `crosstech_gestion_tickets`
LEFT JOIN `core_sistemas`                         ON core_sistemas.idSistema               = crosstech_gestion_tickets.idSistema
LEFT JOIN `clientes_listado`                      ON clientes_listado.idCliente            = crosstech_gestion_tickets.idCliente
LEFT JOIN `core_tipo_ticket`                      ON core_tipo_ticket.idTipoTicket         = crosstech_gestion_tickets.idTipoTicket
LEFT JOIN `core_estado_ticket`                    ON core_estado_ticket.idEstado           = crosstech_gestion_tickets.idEstado
LEFT JOIN `core_ot_prioridad`                     ON core_ot_prioridad.idPrioridad         = crosstech_gestion_tickets.idPrioridad
LEFT JOIN `usuarios_listado`  usuario_asignado    ON usuario_asignado.idUsuario            = crosstech_gestion_tickets.idUsuarioAsignado
LEFT JOIN `crosstech_gestion_tickets_area`                  ON crosstech_gestion_tickets_area.idArea           = crosstech_gestion_tickets.idArea

WHERE crosstech_gestion_tickets.idTicket =  ".$_GET['view'];
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
$rowdata = mysqli_fetch_assoc ($resultado);


?>

<section class="invoice">
	
	<div class="row">
		<div class="col-xs-12">
			<h2 class="page-header">
				<i class="fa fa-globe" aria-hidden="true"> <?php echo $rowdata['Titulo'];?></i>.
				<small class="pull-right">Ticket N°<?php echo n_doc($rowdata['idTicket'], 8); ?></small>
			</h2>
		</div>
	</div>

	<div class="row invoice-info">
		
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Datos del Ticket
			<address>
				<strong>Estado Ticket: </strong><?php echo $rowdata['EstadoTicket']; ?><br/>
				<strong>Area Ticket: </strong><?php echo $rowdata['AreaTicket']; ?><br/>
				<strong>Tipo Ticket: </strong><?php echo $rowdata['TipoTicket']; ?><br/>
				<strong>Prioridad Ticket: </strong><?php echo $rowdata['PrioridadTicket']; ?><br/>
			</address>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 invoice-col">
			Usuarios
			<address>
				<strong>Cliente Creacion: </strong><?php echo $rowdata['Cliente']; ?><br/>
				<strong>Usuario Asignado: </strong><?php echo $rowdata['UsuarioAsignado']; ?><br/>	
			</address>
		</div>

	</div>
	

	<div class="row">
		<div class="col-xs-12">
			<p class="lead"><a name="Ancla_obs"></a>Problema (<?php echo fecha_estandar($rowdata['FechaCreacion']);?>)</p>
			<p class="text-muted well well-sm no-shadow" ><?php echo $rowdata['Descripcion'];?></p>
		</div>
	</div>
	
	<?php if(isset($rowdata['DescripcionCierre'])&&$rowdata['DescripcionCierre']!=''){?>
		<div class="row">
			<div class="col-xs-12">
				<p class="lead"><a name="Ancla_obs"></a>Observacion Solucion (<?php echo fecha_estandar($rowdata['FechaCierre']);?>)</p>
				<p class="text-muted well well-sm no-shadow" ><?php echo $rowdata['DescripcionCierre'];?></p>
			</div>
		</div>
	<?php } ?>
	
	<?php if(isset($rowdata['DescripcionCancelacion'])&&$rowdata['DescripcionCancelacion']!=''){?>
		<div class="row">
			<div class="col-xs-12">
				<p class="lead"><a name="Ancla_obs"></a>Observacion Cancelacion (<?php echo fecha_estandar($rowdata['FechaCancelacion']);?>)</p>
				<p class="text-muted well well-sm no-shadow" ><?php echo $rowdata['DescripcionCancelacion'];?></p>
			</div>
		</div>
	<?php } ?>
	
      
</section>

<?php 
//si se entrega la opcion de mostrar boton volver
if(isset($_GET['return'])&&$_GET['return']!=''){
	//para las versiones antiguas
	if($_GET['return']=='true'){ ?>
		<div class="clearfix"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="#" onclick="history.back()" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
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
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:30px;margin-top:30px;">
			<a href="<?php echo $volver; ?>" class="btn btn-danger pull-right"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
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

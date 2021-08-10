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
$original = "vehiculos_pagos.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Pagos';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submit_pago']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'pago';
	require_once 'A1XRXS_sys/xrxs_form/z_vehiculos_facturacion_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Pago Realizado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
if ( ! empty($_GET['pagar']) ) { 
//obtengo los datos del cliente
$query = "SELECT Nombre, ApellidoPat, ApellidoMat
FROM `apoderados_listado`
WHERE idApoderado = '".$_GET['idApoderado']."' ";
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
$rowCliente = mysqli_fetch_assoc ($resultado);

//obtengo los datos de la ultima facturacion
$query = "SELECT idFacturacionDetalle, MontoSubTotal,MontoAtraso,MontoAdelanto,MontoTotal,montoPago
FROM `vehiculos_facturacion_listado_detalle`
WHERE idApoderado = '".$_GET['idApoderado']."'
AND idEstado = 1
ORDER BY Ano DESC, idMes DESC
LIMIT 1";
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
$rowFacturacion = mysqli_fetch_assoc ($resultado);
?>
 
 

<div class="row inbox"> 
	<div class="col-sm-12">
		<h2><strong>Apoderado : </strong><?php echo $rowCliente['Nombre'].' '.$rowCliente['ApellidoPat'].' '.$rowCliente['ApellidoMat']; ?></h2>
		<hr>	
	</div>
</div>
 

<div class="row inbox">
  						
	  
	<div class="col-sm-4">
		<ul class="list-group inbox-options">
			<li class="list-group-item"><i class="fa fa-inbox" aria-hidden="true"></i>  Detalle Ultima Facturacion</li>
			<li class="list-group-item">		
					
				<div class="pull-left">Subtotal</div>
				<small class="pull-right"><?php echo '(+) '.Valores($rowFacturacion['MontoSubTotal'], 0); ?></small>
				<br/>
					
				<div class="pull-left">Atraso</div>
				<small class="pull-right"><?php echo '(+) '.Valores($rowFacturacion['MontoAtraso'], 0)?></small>
				<br/>
				
				<div class="pull-left">Adelanto</div>
				<small class="pull-right"><?php echo '(-) '.Valores($rowFacturacion['MontoAdelanto'], 0)?></small>
				<br/>
					
				<div class="pull-left">Total</div>
				<small class="pull-right"><?php echo '(+) '.Valores($rowFacturacion['MontoTotal'], 0)?></small>
				<br/>
						
					
			</li>
			<?php if($rowFacturacion['montoPago']!=0){?>
				<li class="list-group-item">
						
					<div class="pull-left">Pagado</div>
					<small class="pull-right"><?php echo '(-) '.Valores($rowFacturacion['montoPago'], 0); ?></small>
					<br/>
						
				</li>
			<?php } ?>
			<li class="list-group-item">
					
				<div class="pull-left">TOTAL A PAGAR</div>
				<?php $calculo = $rowFacturacion['MontoTotal'] - $rowFacturacion['montoPago']; ?>
				<small class="pull-right"><strong><?php echo Valores($calculo, 0); ?></strong></small>
				<br/>
					
			</li>
		</ul>
		
	</div>
		
	
	
	
	<div class="col-sm-8">
			
		<ul class="list-group inbox-options">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
				
				<li class="list-group-item"><i class="fa fa-inbox" aria-hidden="true"></i>  Pago</li>
				<li class="list-group-item">		
					<?php 
					//Se verifican si existen los datos
					if(isset($Pagofecha)) {    $x1  = $Pagofecha;     }else{$x1  = '';}
					if(isset($idTipoPago)) {   $x2  = $idTipoPago;    }else{$x2  = '';}
					if(isset($nDocPago)) {     $x3  = $nDocPago;      }else{$x3  = '';}
					if(isset($montoPago)) {    $x4  = $montoPago;     }else{$x4  = '';}
						
					//se dibujan los inputs
					echo form_date('Fecha Pago','Pagofecha', $x1, 2);
					echo form_select('Documento de Pago','idTipoPago', $x2, 2, 'idTipoPago', 'Nombre', 'sistema_tipos_pago', 0, '',$dbConn);
					echo form_input_text('N° Documento', 'nDocPago', $x3, 1);
					echo '<div class="form-group" id="div_">
							<label class="control-label col-sm-4" id="label_">Total a Pagar</label>
							<div class="col-sm-8">
								<input value="'.Valores($calculo, 0).'" type="text" placeholder="Unidad de Medida" class="form-control"  name="unimed" id="unimed" disabled >
							</div>
						</div>';
					echo form_values('Monto Pagado', 'montoPago', $x4, 2);
						
					echo input_hidden('idUsuarioPago', 1, 2);
					echo input_hidden('idApoderado', $_GET['idApoderado'], 2);
					echo input_hidden('idFacturacionDetalle', $rowFacturacion['idFacturacionDetalle'], 2);
					echo input_hidden('montoPactado', $calculo, 2);
				
					?>

				</li>
				<li class="list-group-item">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf155; Realizar Pago" name="submit_pago">
					<div class="clearfix"></div>
				</li>
			</form> 
			<?php widget_validator(); ?> 
		</ul>
			
	</div> 
	
							
</div>


 
<div class="clearfix"></div>
<div class="col-sm-12" >
<a href="<?php echo $location.'&submit=Buscar&idApoderado='.$_GET['idApoderado']; ?>"  class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div> 

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } elseif ( ! empty($_GET['submit']) ) { 
//obtengo los datos del cliente
$query = "SELECT Nombre, ApellidoPat, ApellidoMat
FROM `apoderados_listado`
WHERE idApoderado = '".$_GET['idApoderado']."' ";
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
$rowCliente = mysqli_fetch_assoc ($resultado);

//obtengo los datos de la ultima facturacion
$query = "SELECT MontoSubTotal,MontoAtraso,MontoAdelanto,MontoTotal,montoPago
FROM `vehiculos_facturacion_listado_detalle`
WHERE idApoderado = '".$_GET['idApoderado']."'
AND idEstado = 1
ORDER BY Ano DESC, idMes DESC
LIMIT 1";
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
$rowFacturacion = mysqli_fetch_assoc ($resultado);

//obtengo las facturaciones atrasadas
$arrFacturaciones = array();
$query = "SELECT 
vehiculos_facturacion_listado_detalle.idFacturacionDetalle,
vehiculos_facturacion_listado_detalle.MontoTotal, 
vehiculos_facturacion_listado_detalle.idMes,
vehiculos_facturacion_listado_detalle.Ano,
core_estado_facturacion.Nombre AS Estado

FROM `vehiculos_facturacion_listado_detalle`
LEFT JOIN `core_estado_facturacion` ON core_estado_facturacion.idEstado = vehiculos_facturacion_listado_detalle.idEstado
WHERE vehiculos_facturacion_listado_detalle.idApoderado = '".$_GET['idApoderado']."'
AND vehiculos_facturacion_listado_detalle.idEstado = 1
ORDER BY vehiculos_facturacion_listado_detalle.Ano DESC, vehiculos_facturacion_listado_detalle.idMes DESC";
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
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrFacturaciones,$row );
}				
					 
?>

<div class="row inbox"> 
	<div class="col-sm-12">
		<h2><strong>Apoderado : </strong><?php echo $rowCliente['Nombre'].' '.$rowCliente['ApellidoPat'].' '.$rowCliente['ApellidoMat']; ?></h2>
		<hr>	
	</div>
</div>
 
<?php if(isset($rowFacturacion['MontoTotal'])&&$rowFacturacion['MontoTotal']!=''){ ?>
	
	
	
	<div class="row inbox">	
						
		<div class="col-sm-8">
			<div class="box">
				<header>
					<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Facturaciones Pendientes</h5>
				</header>
				<div class="table-responsive">
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<thead>
							<tr role="row">
								<th>Año</th>
								<th>Mes</th>
								<th>Estado</th>
								<th>Total</th>
								<th width="10">Acciones</th>
							</tr>
						</thead>			  
						<tbody role="alert" aria-live="polite" aria-relevant="all">
						<?php foreach ($arrFacturaciones as $fac) { ?>
							<tr class="odd">
								<td><?php echo $fac['Ano']; ?></td>
								<td><?php echo numero_a_mes($fac['idMes']); ?></td>
								<td><?php echo $fac['Estado']; ?></td>
								<td><?php echo  Valores($fac['MontoTotal'], 0); ?></td>
								<td>
									<div class="btn-group" style="width: 35px;" >
										<a href="<?php echo 'view_vehiculos_facturacion_listado_detalle.php?view='.$fac['idFacturacionDetalle']; ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									</div>
								</td>
							</tr>
						<?php } ?>                    
						</tbody>
					</table>
				</div>
			</div>
		</div>  



		
		<div class="col-sm-4 mail-left-box">
			<ul class="list-group inbox-options">
				<li class="list-group-item"><i class="fa fa-inbox" aria-hidden="true"></i>  Detalle Ultima Facturacion</li>
				<li class="list-group-item">		
					
					<div class="pull-left">Subtotal</div>
					<small class="pull-right"><?php echo '(+) '.Valores($rowFacturacion['MontoSubTotal'], 0); ?></small>
					<br/>
					
					<div class="pull-left">Atraso</div>
					<small class="pull-right"><?php echo '(+) '.Valores($rowFacturacion['MontoAtraso'], 0)?></small>
					<br/>
					
					<div class="pull-left">Adelanto</div>
					<small class="pull-right"><?php echo '(-) '.Valores($rowFacturacion['MontoAdelanto'], 0)?></small>
					<br/>
					
					<div class="pull-left">Total</div>
					<small class="pull-right"><?php echo '(+) '.Valores($rowFacturacion['MontoTotal'], 0)?></small>
					<br/>
						
					
				</li>
				<?php if($rowFacturacion['montoPago']!=0){?>
					<li class="list-group-item">
						
						<div class="pull-left">Pagado</div>
						<small class="pull-right"><?php echo '(-) '.Valores($rowFacturacion['montoPago'], 0); ?></small>
						<br/>
						
					</li>
				<?php } ?>
				<li class="list-group-item">
					
					<div class="pull-left">TOTAL A PAGAR</div>
					<?php $calculo = $rowFacturacion['MontoTotal'] - $rowFacturacion['montoPago']; ?>
					<small class="pull-right"><strong><?php echo Valores($calculo, 0); ?></strong></small>
					<br/>
					
				</li>
			</ul>
		
		</div> 
								
	</div>
	<?php widget_modal(80, 95); ?>


<?php } else{ ?>
	<div class="col-sm-12">
		<p class="bg-primary" style="padding: 10px;">Este cliente no registra ninguna deuda</p>
	</div>
<?php }  ?>
 
<div class="clearfix"></div>

	<div class="col-sm-12" >
		<?php if($rowFacturacion['MontoTotal']!=0){ ?>
			<a href="<?php echo $location.'&idApoderado='.$_GET['idApoderado'].'&pagar=true'; ?>"  class="btn btn-primary fright margin_width"><i class="fa fa-usd" aria-hidden="true"></i> Pagar</a>
		<?php } ?>
		<a href="<?php echo $location; ?>"  class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
		<div class="clearfix"></div>
	</div> 


<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
} else  {
$w = 'idSistema!=0';
//Se traen solo los apoderados del chofer
$z = "WHERE vehiculos_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
$z.=" AND vehiculos_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$arrTrabajador = array();
$query = "SELECT  idApoderado
FROM `apoderados_listado_hijos`
LEFT JOIN `vehiculos_listado`       ON vehiculos_listado.idVehiculo      = apoderados_listado_hijos.idVehiculo
".$z."
GROUP BY idApoderado";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrTrabajador,$row );
}
//Recorro los pasajeros
foreach ($arrTrabajador as $trab) {
	$w .= ' OR (idSistema='.$_SESSION['usuario']['basic_data']['idSistema'].' AND idEstado=1 AND idApoderado='.$trab['idApoderado'].')';
}
	
	 ?>
	
<div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Seleccionar Apoderado</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" action="<?php echo $location; ?>" id="form1" name="form1" novalidate >
        	
				<?php 
				//Se verifican si existen los datos
				if(isset($idApoderado)) {        $x1  = $idApoderado;        }else{$x1  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select_filter('Apoderado','idApoderado', $x1, 2, 'idApoderado', 'Nombre,ApellidoPat,ApellidoMat', 'apoderados_listado', $w, '',$dbConn);
				
				$Form_Inputs->form_input_hidden('pagina', $_GET['pagina'], 2);
				?>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf002; Buscar" name="submit">
				</div>
                      
			</form>
			<?php widget_validator(); ?> 
                    
		</div>
	</div>
</div>	
	

	
	
<?php } ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

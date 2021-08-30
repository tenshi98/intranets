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
$original = "principal.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-dashboard" aria-hidden="true"></i> Principal';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submitPlan']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'updatePlan';
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Perfil creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Perfil editado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Perfil borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};
?>


<style>
	.listUser {
		background-color: #F3C500;
		background-image: url("img/Fondo.jpg");
		background-size: 100%;
	}
	.formbox {
		background-color: #ffffff;
		border-radius: 3px;
	}
	.box_hijo{
		-webkit-box-shadow: 0px 3px 38px -17px rgba(102,99,102,0.61);
		-moz-box-shadow: 0px 3px 38px -17px rgba(102,99,102,0.61);
		box-shadow: 0px 3px 38px -17px rgba(102,99,102,0.61);
	}
</style>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
//pago aprobado
if(isset($_GET['confirmacion'])){ ?>

<style>
.table tbody tr td{border-top: none;color:#626262;font-size:12px;}
.table-responsive{background-color:#f8f8f8; border:solid 1px #ccc; padding:5px 2px 15px 2px;}
</style>

<?php if(isset($_SESSION['task']['authorizationCode'])&&$_SESSION['task']['authorizationCode']!=''){ ?>
	<div class="row no-print">
		<div class="col-xs-12">
			<a target="new" href="view_pago_to_pdf.php?view=<?php echo $_SESSION['task']['NDocPago'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema']?>" class="btn btn-primary pull-right" style="margin-right: 5px;">
				<i class="fa fa-file-pdf-o" aria-hidden="true"></i> Exportar a PDF
			</a>
		</div>
	</div>

	<div class="col-sm-6 fcenter">
		<div class="table-responsive">
			<table class="table">
				<tbody>
					<tr>
						<td colspan="2" class="style1" align="center">
							<span style="font-size: 16px; color: #D51C24">COMPROBANTE DE PAGO</span>
						</td>
					</tr>
					<?php
					switch ($_SESSION['task']['paymentTypeCode']) {
						case 'VD': $TipoPago = 'Venta Débito'; break;
						case 'VN': $TipoPago = 'Venta Normal'; break;
						case 'VC': $TipoPago = 'Venta en cuotas'; break;
						case 'SI': $TipoPago = '3 cuotas sin interés'; break;
						case 'S2': $TipoPago = '2 cuotas sin interés'; break;
						case 'NC': $TipoPago = 'N Cuotas sin interés'; break;
						case 'VP': $TipoPago = 'Venta Prepago'; break;
						
					} ?>
								
					<tr><td><strong>Cliente:</strong></td>                                  <td><?php echo $_SESSION['usuario']['basic_data']['Nombre'];?></td></tr>
					<tr><td><strong>Servicio:</strong></td>                                 <td><?php echo 'Plan '.$_SESSION['usuario']['basic_data']['PlanNombre'].' (Pago '.$_SESSION['usuario']['basic_data']['TipoPlanNombre'].')'; ?></td></tr>
					<tr><td><strong>Fecha:</strong></td>                                    <td><?php echo $_SESSION['task']['transactionDate']; ?></td></tr>
					<tr><td><strong>Orden de Compra:</strong></td>                          <td><?php echo $_SESSION['task']['buyOrder']; ?></td></tr>
					<tr><td><strong>N° de Comprobante:</strong></td>                        <td><?php echo n_doc($_SESSION['task']['NDocPago'], 8); ?></td></tr>
					<tr><td><strong>Monto:</strong></td>                                    <td><?php echo Valores($_SESSION['task']['amount'], 0); ?></td></tr>
					<tr><td><strong>Ultimos dígitos de la tarjeta:</strong></td>            <td><?php echo $_SESSION['task']['cardNumber']; ?></td></tr>
					<tr><td><strong>Código autorización de la Transacción:</strong></td>    <td><?php echo $_SESSION['task']['authorizationCode']; ?></td></tr>
					<tr><td><strong>Tipo de Pago:</strong></td>                             <td><?php echo $TipoPago; ?></td></tr>
					<tr><td><strong>Número de Cuotas:</strong></td>                         <td><?php echo $_SESSION['task']['sharesNumber']; ?></td></tr>
					<tr><td><strong>Estado Pago:</strong></td>                              <td>PAGO REALIZADO EXITOSAMENTE</td></tr>
					

				</tbody>
			</table>
		</div>
	</div>
<?php }else{ ?>

	<style>
	.bs-callout-danger {
		border-left-color:#ce4844;
	}
	.bs-callout-danger h4 {
		color:#ce4844;
	}
	</style>
	<div class="col-sm-12">
		<div class="bs-callout bs-callout-danger" >
			<h4>Orden de Compra <?php echo $_SESSION['trbnk']['buyOrder']; ?> cancelada</h4>
			<p>La Orden de compra ha sido cancelada por parte del usuario</p>
		</div>
	</div>

<?php } ?>

		
<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Ir a Principal</a>
<div class="clearfix"></div>
</div>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
//Si hay un plan asignado
}elseif(isset($_SESSION['usuario']['basic_data']['idPlan'])&&$_SESSION['usuario']['basic_data']['idPlan']!=0){
	/**************************************************************/
	// Se trae un listado con todas las subcuentas
	$arrSubcuentas = array();
	$query = "SELECT idSubcuenta, Nombre, Usuario, Password, email
	FROM `apoderados_subcuentas`
	WHERE idApoderado = ".$_SESSION['usuario']['basic_data']['idApoderado']."
	ORDER BY Nombre ASC ";
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
	array_push( $arrSubcuentas,$row );
	}
	 
	/**************************************************************/
	// Se trae un listado con todas las cargas del apoderado
	$arrCargas = array();
	$query = "SELECT  
	apoderados_listado_hijos.Nombre, 
	apoderados_listado_hijos.ApellidoPat,  
	apoderados_listado_hijos.ApellidoMat,
	apoderados_listado_hijos.Direccion_img,
	apoderados_listado.Direccion,
	core_estado_asistencia.Nombre AS Estado
				
	FROM apoderados_listado_hijos 
	LEFT JOIN apoderados_listado       ON apoderados_listado.idApoderado    = apoderados_listado_hijos.idApoderado
	LEFT JOIN core_estado_asistencia   ON core_estado_asistencia.idEstado   = apoderados_listado_hijos.idEstado
	WHERE apoderados_listado_hijos.idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."' ";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	while ( $row = mysqli_fetch_assoc ($resultado)) {
	array_push( $arrCargas,$row );
	} 
	/**************************************************************/
	// Se trae un listado con todas las facturaciones del apoderado
	$arrFacturaciones = array();
	$query = "SELECT  
	core_tiempo_meses.Nombre AS Mes,
	vehiculos_facturacion_apoderados_listado_detalle.Ano,
	sistema_planes_transporte.Nombre AS Plan,
	vehiculos_facturacion_apoderados_listado_detalle.MontoPactado
				
	FROM vehiculos_facturacion_apoderados_listado_detalle 
	LEFT JOIN core_tiempo_meses           ON core_tiempo_meses.idMes            = vehiculos_facturacion_apoderados_listado_detalle.idMes
	LEFT JOIN sistema_planes_transporte   ON sistema_planes_transporte.idPlan   = vehiculos_facturacion_apoderados_listado_detalle.idPlan
	WHERE vehiculos_facturacion_apoderados_listado_detalle.idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."' 
	AND vehiculos_facturacion_apoderados_listado_detalle.idEstadoPago = 1
	ORDER BY vehiculos_facturacion_apoderados_listado_detalle.Ano ASC, vehiculos_facturacion_apoderados_listado_detalle.idMes ASC";
	//Consulta
	$resultado = mysqli_query ($dbConn, $query);
	while ( $row = mysqli_fetch_assoc ($resultado)) {
	array_push( $arrFacturaciones,$row );
	}
	//Cuento las facturaciones
	$FactPend = 0;
	foreach ($arrFacturaciones as $fact) {
		$FactPend++;
	}
	?>
	
	<div class="col-sm-12">
		<div class="row">
			
			<div class="col-sm-4">
				<h5 style="color: #666;font-weight: 600 !important;">Resumen
					<small class="pull-right fw600 text-primary"></small>
				</h5>
												
				<table class="table mbn covertable">
					<tbody>
						
						<tr>
							<td class="text-muted">
								<a href="" class="cboxElement"><i class="fa fa-bus color-gray" aria-hidden="true"></i> Plan Actual</a>
							</td>
							<td class="text-right color-red" style="font-weight: 700;"><?php echo $_SESSION['usuario']['basic_data']['PlanNombre']; ?></td>
						</tr>
						
						<tr>
							<td class="text-muted">
								<a href="" class="cboxElement"><i class="fa fa-calendar color-blue" aria-hidden="true"></i> Modo de Pago</a>
							</td>
							<td class="text-right color-red" style="font-weight: 700;"><?php echo $_SESSION['usuario']['basic_data']['TipoPlanNombre']; ?></td>
						</tr>
											
						<tr>
							<td class="text-muted">
								<a href="" class="cboxElement"><i class="fa fa-usd color-green" aria-hidden="true"></i> Valor Plan</a>
							</td>
							<td class="text-right color-red" style="font-weight: 700;">
								<?php
								switch ($_SESSION['usuario']['basic_data']['TipoPlan_idCobro']) {
									//Mensual
									case 1:
										echo valores($_SESSION['usuario']['basic_data']['PlanValor_Mensual'], 0);
										break;
									//Anual
									case 2:
										echo valores($_SESSION['usuario']['basic_data']['PlanValor_Anual'], 0);
										break;
								}
								?>
							</td>
						</tr>
						
						<tr>
							<td class="text-muted">
								<a href="" class="cboxElement"><i class="fa fa-user color-yellow" aria-hidden="true"></i> Cantidad Maxima Hijos</a>
							</td>
							<td class="text-right color-red" style="font-weight: 700;">
								<?php
								switch ($_SESSION['usuario']['basic_data']['idPlan']) {
									//1 Hijo
									case 1:
										echo "1 Hijo inscrito";	
										break;
									//2 Hijos
									case 2:
										echo "2 Hijos inscritos";
										break;
									//3 o mas Hijos
									case 3:
										echo "3 o mas Hijos inscritos";
										break;
								}
								?>
							</td>
						</tr>
							
					</tbody>
				</table>
			</div>
			
			<div class="col-sm-8">
				<h5 style="color: #666;font-weight: 600 !important;">Facturaciones Pendientes
					<small class="pull-right fw600 text-primary"><?php //echo $FactPend; ?></small>
				</h5>
				<?php if(isset($FactPend)&&$FactPend!=0){ ?>								
					<table class="table mbn covertable">
						<tbody>
							<?php foreach ($arrFacturaciones as $fact) { ?>
								<tr>
									<td class="text-muted"><strong>Plan : </strong><?php echo $fact['Plan']; ?></td>
									<td class="text-muted"><?php echo $fact['Mes']; ?></td>
									<td class="text-muted"><?php echo $fact['Ano']; ?></td>
									<td class="text-muted"><?php echo valores($fact['MontoPactado'], 0); ?></td>
								</tr>
							<?php } ?>	
						</tbody>
					</table>
					<div class="col-md-8 fcenter clearfix">
						<div class="text-center">
							<a href="" class="btn btn-primary" ><i class="fa fa-usd" aria-hidden="true"></i> Pagar</a>
						</div>	
					</div>
				<?php }else{ ?>
					<table class="table mbn covertable">
						<tbody>
							<tr>
								<td class="text-muted">Sin Facturaciones Pendientes</td>
							</tr>	
						</tbody>
					</table>
				<?php } ?>
			</div>
			
		</div>
	</div>				
					
	<div class="col-sm-12">
		<div class="box">
			<div class="col-sm-6">
				<div class="row listUser">
					<div class="col-sm-12">
						<img src="img/login_icon.png" alt="icon" height="160" width="160" class="img-responsive center-block"> 
						<h3 class="register-heading">Usuarios Acceso APP</h3>
						<div class="formbox col-md-8 fcenter clearfix">
							<div class="">
								<table id="dataTable" class="table">
									<tbody role="alert" aria-live="polite" aria-relevant="all">
										<?php foreach ($arrSubcuentas as $sub) { ?>
											<tr class="odd">		
												<td><?php echo $sub['Nombre']; ?></td>	
												<td align="right"><i class="fa fa-key" aria-hidden="true"></i><?php echo ' '.$sub['Password']; ?></td>	
											</tr>
										<?php } ?>                   
									</tbody>
								</table>
							</div>
						</div>
						<br/>
						<div class="col-md-8 fcenter clearfix">
							<div class="text-center">
								<a href="apoderados_listado_subcuentas.php?pagina=1&new=true" class="btn btn-primary" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Subcuenta</a>
							</div>	
						</div>
						<br/>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="register-heading">Hijos</h3>
						<div class="col-md-10 fcenter clearfix">
							<div class="row">
								
								<?php foreach ($arrCargas as $car) { ?>
									<div class="col-sm-12 box_hijo">
										<div class="col-sm-3">
											<img src="<?php echo DB_SITE_ALT_1.'/upload/'.$car['Direccion_img'] ?>" alt="icon" class="img-responsive center-block" style="margin-top:10px;"> 
										</div>
										<div class="col-sm-9">
											<h4><?php echo $car['Nombre'].' '.$car['ApellidoPat'].' '.$car['ApellidoMat']; ?></h4>
											<p>
												<i class="fa fa-home" aria-hidden="true"></i> Direccion: <?php echo $car['Nombre']; ?><br/>
												<i class="fa fa-arrow-right" aria-hidden="true"></i> Estado: <?php echo $car['Nombre']; ?>
											</p>
										</div>
									</div>
									<br/>
								<?php } ?>    
								
							</div>
						</div>
						<br/>
						<div class="col-md-8 fcenter clearfix">
							<div class="text-center">
								<a href="apoderados_listado_hijos.php?pagina=1" class="btn btn-primary" ><i class="fa fa-list" aria-hidden="true"></i> Administrar</a>
							</div>	
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div> 
		</div>
	</div>	
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
//si se rechaza el pago
}elseif(isset($_GET['rechazado'])){ ?>

<style>
.bs-callout-danger {
    border-left-color:#ce4844;
}
.bs-callout-danger h4 {
    color:#ce4844;
}
</style>
<div class="col-sm-12">
	<div class="bs-callout bs-callout-danger" >
		<h4>Orden de Compra <?php echo $_GET['rechazado']; ?> rechazada</h4>
		<p>Las posibles causas de este rechazo son:</p>
		<p>
		* Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad).<br/>
		* Su tarjeta de Crédito o Débito no cuenta con saldo suficiente.<br/>
		* Tarjeta aún no habilitada en el sistema financiero.<br/>
		</p>
	</div>
</div>
  
  	
	
<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>	
<?php		
////////////////////////////////////////////////////////////////////////////////////////////////////////
//si no hay un plan asignado	
}elseif(!isset($_GET['Respuesta'])){ 
/**************************************************************/
// consulto los datos
$arrPlan = array();
$query = "SELECT  idPlan, Nombre, Valor_Mensual, Valor_Anual, N_Hijos
FROM `sistema_planes_transporte`";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrPlan,$row );
}

//verificar antiguedad
$dInscrito = dias_transcurridos($_SESSION['usuario']['basic_data']['FNacimiento'],fecha_actual());

//si ya tiene mas de dos meses inscrito
if($dInscrito>60){
	//calculo normal
	$DiasDisponibles  = 30 - dia_actual() + 1;   //se suma 1 para evitar dias disponibles en 0
	$MesesDisponibles = 12 - mes_actual();       //se calculan los meses
	//si meses disponibles es superior a 10
	if($MesesDisponibles>10){
			$MesesDisponibles = 10;
	}
//si tiene menos de dos meses inscrito	
}else{
	//calculo normal
	$DiasDisponibles  = 0;                      //no se cobra
	$MesesDisponibles = 12 - (mes_actual()+1);  //se descuenta un mes
	//si meses disponibles es superior a 10
	if($MesesDisponibles>10){
			$MesesDisponibles = 10;
	}
}	




?>
	
	
	<div class="col-sm-8 fcenter listUser">
		
		<style>
			.bs-callout-danger {
				border-left-color:#ce4844;
				background-color: #FFFFFF;
			}
			.bs-callout-danger h4 {
				color:#ce4844;
			}
		</style>
		<div class="col-sm-12">
			<div class="bs-callout bs-callout-danger" >
				<h4>Notificacion</h4>
				<p>Para los nuevos usuarios recien inscritos, el primer mes es completamente gratis</p>
			</div>
		</div>
		
		<div class="clearfix"></div>

		<br/>
		
		<div class="col-sm-8 fcenter">
			<div class="box dark">
				<header>
					<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
					<h5>Seleccionar Un Plan</h5>	
				</header>
				<div id="div-1" class="body">
					<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
						
						<?php 
						//Se verifican si existen los datos
						if(isset($idPlan)) {     $x1  = $idPlan;      }else{$x1  = '';}
						if(isset($idCobro)) {    $x2  = $idCobro;     }else{$x2  = '';}
								
						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_select('Tipo de Plan','idPlan', $x1, 2, 'idPlan', 'Nombre', 'sistema_planes_transporte', 0, '',$dbConn);
						$Form_Inputs->form_select('Modalidad de Cobro','idCobro', $x2, 2, 'idCobro', 'Nombre', 'core_tipo_cobro', 0, '',$dbConn);
							
						$Form_Inputs->form_input_hidden('idApoderado', $_SESSION['usuario']['basic_data']['idApoderado'], 2);

						?>
						
						<style>
							.price-form {
								background: #ffffff;
							margin-bottom: 10px;
							padding: 20px;
							border: 1px solid #eeeeee;
								border-radius: 4px;
							}
							.help-text {
								display: block;
								margin-bottom: 10px;
								color: 
								#737373;
								font-weight: 200;
								width: 188px;
							}						
						</style>
						<div class="price-form">
							<div class="form-group">
								<div class="col-sm-6">
									<label for="amount" class="control-label">Plan: </label>
									<span class="help-text">Cantidad de hijos que abarca el plan</span>
								</div>
								<div class="col-sm-6">
									<p class="price lead" id="Plan"></p>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="amount" class="control-label">Valor Plan: </label>
									<span class="help-text">Costo Mensual / Anual del Plan seleccionado</span>
								</div>
								<div class="col-sm-6">
									<p class="price lead" id="CostoPlan"></p>
								</div>
							</div>
							<div class="form-group">
								<div class="col-sm-6">
									<label for="amount" class="control-label">Modo de Pago: </label>
									<span class="help-text">Valor total dependiendo del tipo de facturacion</span>
								</div>
								<div class="col-sm-6">
									<p class="price lead" id="Cobro"></p>
								</div>
							</div>
							<hr class="style">
							<div class="form-group total">
								<div class="col-sm-6">
									<label for="amount" class="control-label">Total a Pagar ($): </label>
									<span class="help-text" id="ExplainText"></span>
								</div>
								<div class="col-sm-6">
									<p class="price lead" id="Total">0</p>
								</div>
							</div>
						</div>
						
						<script>
									
							//Variables
							<?php 
							$Mensual = '';
							$Anual   = '';
							foreach ($arrPlan as $plan) {
								$Mensual .= '"'.$plan['Valor_Mensual'].'",';
								$Anual .= '"'.$plan['Valor_Anual'].'",';
							} ?>
								
							var Mensual = [<?php echo $Mensual; ?>];
							var Anual = [<?php echo $Anual; ?>];
									
							/**************************************************/
							$("#idPlan").on("change", function(){ //se ejecuta al cambiar valor del select
								let idPlan = $(this).val(); //Asignamos el valor seleccionado
								
								//Individual
								if(idPlan == 1){ 
									document.getElementById('Plan').innerHTML  = "1 Hijo inscrito";						
											
								//Familiar
								} else if(idPlan == 2){ 
									document.getElementById('Plan').innerHTML  = "2 Hijos inscritos";	

								//Familiar Plus
								} else if(idPlan == 3){ 
									document.getElementById('Plan').innerHTML  = "3 o mas Hijos inscritos";	
								}
								
								document.getElementById('CostoPlan').innerHTML  = "$" + numberWithCommas(Mensual[idPlan-1]) + " / $" + numberWithCommas(Anual[idPlan-1]);
								
								//calcular el total
								calculo();
							});
							/**************************************************/
							$("#idCobro").on("change", function(){ //se ejecuta al cambiar valor del select
								let idCobro = $(this).val(); //Asignamos el valor seleccionado
								
								//Mensual
								if(idCobro == 1){ 
									document.getElementById('Cobro').innerHTML  = "Cobrar los 5 de cada mes";
									document.getElementById('ExplainText').innerHTML  = "Proporcional al Mes en Curso (<?php echo $DiasDisponibles; ?> Dias)";
														
											
								//Anual
								} else if(idCobro == 2){ 
									document.getElementById('Cobro').innerHTML  = "Pago Anual";
									document.getElementById('ExplainText').innerHTML  = "Proporcional al Mes en Curso (<?php echo $MesesDisponibles; ?> Meses)";
									
								}
								//calcular el total
								calculo();
							});
							
							/**************************************************/
							//Se realiza calculo del costo
							function calculo(){
								idPlan   = $("#idPlan").val();
								idCobro  = $("#idCobro").val();
								
								//verifico que ambos select existan
								if(idPlan!='' && idCobro!=''){
									//Mensual
									if(idCobro == 1){ 
										document.getElementById('Total').innerHTML  = "$" + numberWithCommas((Mensual[idPlan-1]/30)*<?php echo $DiasDisponibles; ?>);						
									//Anual
									} else if(idCobro == 2){ 
										document.getElementById('Total').innerHTML  = "$" + numberWithCommas((Anual[idPlan-1]/10)*<?php echo $MesesDisponibles; ?>);

									}
								}
							}
							
							/**************************************************/
							//Separador de miles
							function numberWithCommas(x) {
								return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
							}
									
						</script>
            
						<div class="form-group">
							<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Confirmar" name="submitPlan">
						</div>
							  
					</form> 
					<?php widget_validator(); ?>        
				</div>
			</div>
		</div>

		<br/>
	</div>
	
<?php }

/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

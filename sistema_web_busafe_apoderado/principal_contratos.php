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
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Contratos';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para editar
if ( !empty($_POST['submitPlan']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'changePlan';
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
//pago aprobado
if(isset($_GET['confirmacion'])){ ?>

<style>
.table tbody tr td{border-top: none;color:#626262;font-size:12px;}
.table-responsive{background-color:#f8f8f8; border:solid 1px #ccc; padding:5px 2px 15px 2px;}
</style>

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
		
<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Ir a Principal</a>
<div class="clearfix"></div>
</div>
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////
//Si hay un plan asignado
}elseif ( ! empty($_GET['change']) ) { 
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

// Se trae el plan actual del apoderado
$query = "SELECT  idPlan,idCobro
FROM `apoderados_listado`
WHERE idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."'";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
$rowPlan = mysqli_fetch_assoc ($resultado);
	
$DiasDisponibles  = 30 - dia_actual() + 1; //se suma 1 para evitar dias disponibles en 0
$MesesDisponibles = 12 - mes_actual();	
//si meses disponibles es superior a 10
if($MesesDisponibles>10){
	$MesesDisponibles = 10;
}

//Calculo lo ya consumido
switch ($_SESSION['usuario']['basic_data']['TipoPlan_idCobro']) {
	//Mensual
	case 1:
		$Cobrado   = 0;
		$Sobrante  = 0;
	break;
	//Anual
	case 2:
		$Cobrado   = ($_SESSION['usuario']['basic_data']['PlanValor_Anual']/10) * (10-$MesesDisponibles);
		$Sobrante  = $_SESSION['usuario']['basic_data']['PlanValor_Anual'] - $Cobrado;
	break;
}
								
?>
<div class="col-sm-8 fcenter listUser">
		<br/>
		
		<div class="col-sm-8 fcenter">
			<div class="box dark">
				<header>
					<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
					<h5>Cambio de Plan</h5>	
				</header>
				<div id="div-1" class="body">
					<form class="form-horizontal" method="post" enctype="multipart/form-data" id="form1" name="form1" novalidate>
						
						<?php 
						//Se verifican si existen los datos
						if(isset($idPlan)) {     $x1  = $idPlan;      }else{$x1  = $rowPlan['idPlan'];}
						if(isset($idCobro)) {    $x2  = $idCobro;     }else{$x2  = $rowPlan['idCobro'];}
								
						//se dibujan los inputs
						$Form_Inputs = new Form_Inputs();
						$Form_Inputs->form_select('Tipo de Plan','idPlan', $x1, 2, 'idPlan', 'Nombre', 'sistema_planes_transporte', 0, '',$dbConn);
						$Form_Inputs->form_select('Modalidad de Cobro','idCobro', $x2, 2, 'idCobro', 'Nombre', 'core_tipo_cobro', 0, '',$dbConn);
							
						$Form_Inputs->form_input_hidden('idApoderado', $_SESSION['usuario']['basic_data']['idApoderado'], 2);
						$Form_Inputs->form_input_hidden('idPlanOld', $rowPlan['idPlan'], 2);
						$Form_Inputs->form_input_hidden('idCobroOld', $rowPlan['idCobro'], 2);
						
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
									<label for="amount" class="control-label">SubTotal a Pagar ($): </label>
									<span class="help-text" id="ExplainText1"></span>
								</div>
								<div class="col-sm-6">
									<p class="price lead" id="SubTotal">0</p>
								</div>
							</div>
							
							
							
							<div id="nuevoPlan">
								<hr class="style">
								<div class="form-group">
									<div class="col-sm-6">
										<label for="amount" class="control-label">Plan Actual: </label>
										<span class="help-text">Plan Actual Seleccionado</span>
									</div>
									<div class="col-sm-6">
										<p class="price lead"><?php echo $_SESSION['usuario']['basic_data']['PlanNombre']; ?></p>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-6">
										<label for="amount" class="control-label">Consumo Plan Actual: </label>
										<span class="help-text">Meses ya cobrados</span>
									</div>
									<div class="col-sm-6">
										<p class="price lead"><?php echo valores($Cobrado, 0)?></p>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-6">
										<label for="amount" class="control-label">Sobrante Plan Actual: </label>
										<span class="help-text">Total Abono cobrados</span>
									</div>
									<div class="col-sm-6">
										<p class="price lead"><?php echo valores($Sobrante, 0)?></p>
									</div>
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
									
							let idCobroOld  = <?php echo $_SESSION['usuario']['basic_data']['TipoPlan_idCobro'] ?>;
							let idPlanOld   = <?php echo $_SESSION['usuario']['basic_data']['idPlan'] ?>;
							
							document.getElementById('nuevoPlan').style.display = 'none';
							
							
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
								
								document.getElementById('CostoPlan').innerHTML  = "$" + numberWithCommas(Mensual[idPlan-1]) + "/ $" + numberWithCommas(Anual[idPlan-1]);
								
								
								//si el plan nuevo seleccionado es distinto al plan antiguo
								if(idPlan!=<?php echo $rowPlan['idPlan'];?>){
									document.getElementById('nuevoPlan').style.display = 'block';
								}else{
									document.getElementById('nuevoPlan').style.display = 'none';
								}
								
								//Alerta en el cambio de plan teniendo un cobro anual
								if(idCobroOld==2 && idPlanOld>idPlan){
									alert('Esta cambiando de Plan de facturacion por uno de inferior valor, tenga en cuenta que el monto ya pagado no sera devuelto y que solo se cambiara el plan');
								}
								
								
								//calcular el total
								calculo();
							});
							/**************************************************/
							$("#idCobro").on("change", function(){ //se ejecuta al cambiar valor del select
								let idCobro = $(this).val(); //Asignamos el valor seleccionado
								
								//Mensual
								if(idCobro == 1){ 
									document.getElementById('Cobro').innerHTML  = "Cobrar los 5 de cada mes";
									document.getElementById('ExplainText').innerHTML  = "Facturacion Mensual";
														
											
								//Anual
								} else if(idCobro == 2){ 
									document.getElementById('Cobro').innerHTML  = "Pago Anual";
									document.getElementById('ExplainText').innerHTML  = "Proporcional al Mes en Curso (<?php echo $MesesDisponibles; ?> Meses)";
									
								}
								
								//si el plan nuevo seleccionado es distinto al plan antiguo
								if(idCobro!=<?php echo $rowPlan['idCobro'];?>){
									document.getElementById('nuevoPlan').style.display = 'block';
								}else{
									document.getElementById('nuevoPlan').style.display = 'none';
								}
								
								//Alerta en el cambio de anual a mensual
								if(idCobroOld==2 && idCobro==1){
									alert('Esta cambiando de facturacion Anual a Mensual, tenga en cuenta que no se hace devolucion de los montos ya pagados y a partir del proximo mes se facturara y comenzara a cobrar por el servicio Mensual');
								}
								
									
								//calcular el total
								calculo();
							});
							
							/**************************************************/
							function calculo(){
								idPlan   = $("#idPlan").val();
								idCobro  = $("#idCobro").val();
								
								//verifico que ambos select existan
								if(idPlan!='' && idCobro!=''){
									//Verifico que no se seleccionen los mismos datos
									if(idPlan==idPlanOld && idCobro==idCobroOld){
										document.getElementById('SubTotal').innerHTML  = "$0";
										document.getElementById('Total').innerHTML  = "$0";
										document.getElementById("submitPlan").disabled = true;
									}else{
										document.getElementById("submitPlan").disabled = false;
										//Mensual
										if(idCobro == 1){ 
											document.getElementById('SubTotal').innerHTML  = "$" + numberWithCommas(Mensual[idPlan-1]);						
											document.getElementById('Total').innerHTML  = "$" + numberWithCommas(Mensual[idPlan-1]);						
										//Anual
										} else if(idCobro == 2){ 
											var su_s_total = ((Anual[idPlan-1]/10)*<?php echo $MesesDisponibles; ?>)-<?php echo $Sobrante;?>;
											if(su_s_total<0){
												su_s_total=0;
											}
											document.getElementById('SubTotal').innerHTML  = "$" + numberWithCommas((Anual[idPlan-1]/10)*<?php echo $MesesDisponibles; ?>);
											document.getElementById('Total').innerHTML  = "$" + numberWithCommas(su_s_total);

										}
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
							<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submitPlan" id="submitPlan">
							<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
						</div>
							  
					</form> 
					<?php widget_validator(); ?>        
				</div>
			</div>
		</div>

		<br/>
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
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
} else  { 
// Se trae un listado con todas las cargas familiares
$arrContratos = array();
$query = "SELECT  
apoderados_listado_planes_contratados.idPlanContratado, 
apoderados_listado_planes_contratados.fCreacion,
apoderados_listado_planes_contratados.fCierre,

sistema_planes_transporte.Nombre AS Plan,
core_tipo_cobro.Nombre AS Cobro,
core_estados.Nombre AS Estado

FROM `apoderados_listado_planes_contratados`
LEFT JOIN `sistema_planes_transporte`  ON sistema_planes_transporte.idPlan   = apoderados_listado_planes_contratados.idPlan
LEFT JOIN `core_tipo_cobro`            ON core_tipo_cobro.idCobro            = apoderados_listado_planes_contratados.idCobro
LEFT JOIN `core_estados`               ON core_estados.idEstado              = apoderados_listado_planes_contratados.idEstado
WHERE apoderados_listado_planes_contratados.idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."'
ORDER BY apoderados_listado_planes_contratados.idPlanContratado DESC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrContratos,$row );
}
//Contratos dentro del mes
$query = "SELECT  COUNT(idPlanContratado) AS Cuenta
FROM `apoderados_listado_planes_contratados`
WHERE idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."'
AND MesCreacion='".mes_actual()."'
AND AnoCreacion='".ano_actual()."'";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
$rowContratos = mysqli_fetch_assoc ($resultado);
?>

<?php 
//solo mostrar el boton de cambio de plan si no tiene modificacion en el mes
if(isset($rowContratos['Cuenta'])&&$rowContratos['Cuenta']==0){ ?>
	<div class="col-sm-12 breadcrumb-bar">
		<a href="<?php echo $location; ?>?change=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-exchange" aria-hidden="true"></i> Cambiar Contrato</a>
	</div>
	<div class="clearfix"></div>
<?php } ?>
		
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Contratos</h5>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>Plan</th>
						<th>Cobro</th>
						<th width="120">Estado</th>
						<th width="120">Fecha Contratacion</th>
						<th width="120">Fecha Cierre</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>				  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrContratos as $carga) { ?>
						<tr class="odd">
							<td><?php echo $carga['Plan']; ?></td>		
							<td><?php echo $carga['Cobro']; ?></td>		
							<td><?php echo $carga['Estado']; ?></td>		
							<td><?php echo fecha_estandar($carga['fCreacion']); ?></td>	
							<td><?php echo fecha_estandar($carga['fCierre']); ?></td>	
							<td>
								<div class="btn-group" style="width: 70px;" >
									<a href="<?php echo 'view_contrato.php?view='.$carga['idPlanContratado']; ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<a target="new" href="<?php echo 'view_contrato_to_pdf.php?view='.$carga['idPlanContratado'].'&idSistema='.$_SESSION['usuario']['basic_data']['idSistema']; ?>" title="Descargar PDF" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
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

<?php } ?>
<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

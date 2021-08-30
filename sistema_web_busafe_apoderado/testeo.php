<?php session_start();
/**********************************************************************************************************************************/
/*                                           Se define la variable de seguridad                                                   */
/**********************************************************************************************************************************/
define('XMBCXRXSKGC', 1);
/**********************************************************************************************************************************/
/*                                          Se llaman a los archivos necesarios                                                   */
/**********************************************************************************************************************************/
require_once 'core/Load.Utils.Test.php';
/**********************************************************************************************************************************/
/*                                          Modulo de identificacion del documento                                                */
/**********************************************************************************************************************************/
//Cargamos la ubicacion 
$original = "testeo.php";
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
	require_once 'A1XRXS_sys/xrxs_form/apoderados_listado_test.php';
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
$dInscrito = 90; //siempre paga

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
				<p>Plataforma de testeo</p>
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
							
						//$Form_Inputs->form_input_hidden('idApoderado', $_SESSION['usuario']['basic_data']['idApoderado'], 2);

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
									
							var idPlan;
							var idCobro;
							
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
								idPlan = $(this).val(); //Asignamos el valor seleccionado
								
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
								idCobro = $(this).val(); //Asignamos el valor seleccionado
								
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

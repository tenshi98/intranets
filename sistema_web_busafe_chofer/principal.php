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
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
?>
				
<style>
.inner {
    padding-top: 0px !important;
}
</style>

<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['despacho']) ) { ?>
	 

	 	
<?php
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 }elseif ( ! empty($_GET['ofertar']) ) {

?>


<?php	
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 }else{
// Se trae un listado con todos
$query = "SELECT 
idTipo, Nombre, fNacimiento, idCiudad, idComuna, Direccion, Fono1, Fono2, Fax, email,
Web, PersonaContacto, PersonaContacto_Fono, PersonaContacto_email, Rut, RazonSocial, 
idRubro, Giro, idBanco, NCuentaBanco, MailBanco
FROM `transportes_listado`
WHERE idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte']."
AND idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$resultado = mysqli_query($dbConn, $query);
$row_data = mysqli_fetch_assoc ($resultado);

// Se trae un listado con todos los choferes
$arrTrabajador = array();
$query = "SELECT idTrabajador,
Nombre, ApellidoPat, ApellidoMat, Rut, idSexo, FNacimiento, Fono, idCiudad, idComuna,
Direccion, idEstadoCivil, email, ContactoPersona, ContactoFono, idTipo, Cargo,
idTipoContrato, F_Inicio_Contrato, F_Termino_Contrato, idAFP, idSalud, SueldoLiquido,
idTipoLicencia, CA_Licencia, LicenciaFechaControl, LicenciaFechaControlUltimo,
Direccion_img, File_Curriculum, File_Antecedentes, File_Carnet, File_Contrato,
File_Licencia
FROM `trabajadores_listado`
WHERE idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte']."
AND idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrTrabajador,$row );
}
// Se trae un listado con todos los vehiculos
$arrVehiculo = array();
$query = "SELECT idVehiculo, 
Nombre, idTipo, Marca, Modelo, Patente, Num_serie, AnoFab, idZona, Capacidad, idTrabajador,
Direccion_img, doc_mantencion, doc_padron, doc_permiso_circulacion, doc_resolucion_sanitaria,
doc_revision_tecnica, doc_seguro_carga, doc_soap, doc_fecha_mantencion, doc_fecha_padron,
doc_fecha_permiso_circulacion, doc_fecha_resolucion_sanitaria, doc_fecha_revision_tecnica,
doc_fecha_seguro_carga, doc_fecha_soap 
FROM `vehiculos_listado`
WHERE idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte']."
AND idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrVehiculo,$row );
}
//se traen todos los pasajeros
$query  = "SELECT apoderados_listado_hijos.idHijos FROM apoderados_listado_hijos LEFT JOIN `vehiculos_listado` ON vehiculos_listado.idVehiculo = apoderados_listado_hijos.idVehiculo WHERE vehiculos_listado.idTransporte='".$_SESSION['usuario']['basic_data']['idTransporte']."' AND vehiculos_listado.idSistema='".$_SESSION['usuario']['basic_data']['idSistema']."' ";
$result = mysqli_query($dbConn, $query);
$ndata_1 = mysqli_num_rows($result);
		
			
/**********************************/
//Se cuentan los datos
$Count_trab  = 0; //se cuentan los choferes
$Count_veh   = 0; //se cuentan los vehiculos
$Count_pas   = 0; //se cuentan los pasajeros

$total_prop  = 21;
$new_prop    = 0;
$total_trab  = 32;
$new_trab    = array();
$total_veh   = 25;
$new_veh     = array();

/************************************/
if(isset($row_data['idTipo'])&&$row_data['idTipo']!=''){                                $new_prop++;}
if(isset($row_data['Nombre'])&&$row_data['Nombre']!=''){                                $new_prop++;}
if(isset($row_data['fNacimiento'])&&$row_data['fNacimiento']!=''){                      $new_prop++;}
if(isset($row_data['idCiudad'])&&$row_data['idCiudad']!=''){                            $new_prop++;}
if(isset($row_data['idComuna'])&&$row_data['idComuna']!=''){                            $new_prop++;}
if(isset($row_data['Direccion'])&&$row_data['Direccion']!=''){                          $new_prop++;}
if(isset($row_data['Fono1'])&&$row_data['Fono1']!=''){                                  $new_prop++;}
if(isset($row_data['Fono2'])&&$row_data['Fono2']!=''){                                  $new_prop++;}
if(isset($row_data['Fax'])&&$row_data['Fax']!=''){                                      $new_prop++;}
if(isset($row_data['email'])&&$row_data['email']!=''){                                  $new_prop++;}
if(isset($row_data['Web'])&&$row_data['Web']!=''){                                      $new_prop++;}
if(isset($row_data['PersonaContacto'])&&$row_data['PersonaContacto']!=''){              $new_prop++;}
if(isset($row_data['PersonaContacto_Fono'])&&$row_data['PersonaContacto_Fono']!=''){    $new_prop++;}
if(isset($row_data['PersonaContacto_email'])&&$row_data['PersonaContacto_email']!=''){  $new_prop++;}
if(isset($row_data['Rut'])&&$row_data['Rut']!=''){                                      $new_prop++;}
if(isset($row_data['RazonSocial'])&&$row_data['RazonSocial']!=''){                      $new_prop++;}
if(isset($row_data['idRubro'])&&$row_data['idRubro']!=''){                              $new_prop++;}
if(isset($row_data['Giro'])&&$row_data['Giro']!=''){                                    $new_prop++;}
if(isset($row_data['idBanco'])&&$row_data['idBanco']!=''){                              $new_prop++;}
if(isset($row_data['NCuentaBanco'])&&$row_data['NCuentaBanco']!=''){                    $new_prop++;}
if(isset($row_data['MailBanco'])&&$row_data['MailBanco']!=''){                          $new_prop++;}

	

/************************************/
foreach ($arrTrabajador as $trab) {
	
	$new_trab[$Count_trab] = 0;
	
	if(isset($trab['Nombre'])&&$trab['Nombre']!=''){                                                    $new_trab[$Count_trab]++;}
	if(isset($trab['ApellidoPat'])&&$trab['ApellidoPat']!=''){                                          $new_trab[$Count_trab]++;}
	if(isset($trab['ApellidoMat'])&&$trab['ApellidoMat']!=''){                                          $new_trab[$Count_trab]++;}
	if(isset($trab['Rut'])&&$trab['Rut']!=''){                                                          $new_trab[$Count_trab]++;}
	if(isset($trab['idSexo'])&&$trab['idSexo']!=0){                                                     $new_trab[$Count_trab]++;}
	if(isset($trab['FNacimiento'])&&$trab['FNacimiento']!='0000-00-00'){                                $new_trab[$Count_trab]++;}
	if(isset($trab['Fono'])&&$trab['Fono']!=''){                                                        $new_trab[$Count_trab]++;}
	if(isset($trab['idCiudad'])&&$trab['idCiudad']!=0){                                                 $new_trab[$Count_trab]++;}
	if(isset($trab['idComuna'])&&$trab['idComuna']!=0){                                                 $new_trab[$Count_trab]++;}
	if(isset($trab['Direccion'])&&$trab['Direccion']!=''){                                              $new_trab[$Count_trab]++;}
	if(isset($trab['idEstadoCivil'])&&$trab['idEstadoCivil']!=0){                                       $new_trab[$Count_trab]++;}
	if(isset($trab['email'])&&$trab['email']!=''){                                                      $new_trab[$Count_trab]++;}
	if(isset($trab['ContactoPersona'])&&$trab['ContactoPersona']!=''){                                  $new_trab[$Count_trab]++;}
	if(isset($trab['ContactoFono'])&&$trab['ContactoFono']!=''){                                        $new_trab[$Count_trab]++;}
	if(isset($trab['idTipo'])&&$trab['idTipo']!=0){                                                     $new_trab[$Count_trab]++;}
	if(isset($trab['Cargo'])&&$trab['Cargo']!=''){                                                      $new_trab[$Count_trab]++;}
	if(isset($trab['idTipoContrato'])&&$trab['idTipoContrato']!=0){                                     $new_trab[$Count_trab]++;}
	if(isset($trab['F_Inicio_Contrato'])&&$trab['F_Inicio_Contrato']!='0000-00-00'){                    $new_trab[$Count_trab]++;}
	if(isset($trab['F_Termino_Contrato'])&&$trab['F_Termino_Contrato']!='0000-00-00'){                  $new_trab[$Count_trab]++;}
	if(isset($trab['idAFP'])&&$trab['idAFP']!=0){                                                       $new_trab[$Count_trab]++;}
	if(isset($trab['idSalud'])&&$trab['idSalud']!=0){                                                   $new_trab[$Count_trab]++;}
	if(isset($trab['SueldoLiquido'])&&$trab['SueldoLiquido']!=0){                                       $new_trab[$Count_trab]++;}
	if(isset($trab['idTipoLicencia'])&&$trab['idTipoLicencia']!=0){                                     $new_trab[$Count_trab]++;}
	if(isset($trab['CA_Licencia'])&&$trab['CA_Licencia']!=''){                                          $new_trab[$Count_trab]++;}
	if(isset($trab['LicenciaFechaControl'])&&$trab['LicenciaFechaControl']!='0000-00-00'){              $new_trab[$Count_trab]++;}
	if(isset($trab['LicenciaFechaControlUltimo'])&&$trab['LicenciaFechaControlUltimo']!='0000-00-00'){  $new_trab[$Count_trab]++;}
	if(isset($trab['Direccion_img'])&&$trab['Direccion_img']!=''){                                      $new_trab[$Count_trab]++;}
	if(isset($trab['File_Curriculum'])&&$trab['File_Curriculum']!=''){                                  $new_trab[$Count_trab]++;}
	if(isset($trab['File_Antecedentes'])&&$trab['File_Antecedentes']!=''){                              $new_trab[$Count_trab]++;}
	if(isset($trab['File_Carnet'])&&$trab['File_Carnet']!=''){                                          $new_trab[$Count_trab]++;}
	if(isset($trab['File_Contrato'])&&$trab['File_Contrato']!=''){                                      $new_trab[$Count_trab]++;}
	if(isset($trab['File_Licencia'])&&$trab['File_Licencia']!=''){                                      $new_trab[$Count_trab]++;}
								
	$Count_trab++;
}
/************************************/
foreach ($arrVehiculo as $trab) {
	
	$new_veh[$Count_veh] = 0;
	
	if(isset($trab['Nombre'])&&$trab['Nombre']!=''){                                                              $new_veh[$Count_veh]++;}
	if(isset($trab['idTipo'])&&$trab['idTipo']!=0){                                                               $new_veh[$Count_veh]++;}
	if(isset($trab['Marca'])&&$trab['Marca']!=''){                                                                $new_veh[$Count_veh]++;}
	if(isset($trab['Modelo'])&&$trab['Modelo']!=''){                                                              $new_veh[$Count_veh]++;}
	if(isset($trab['Patente'])&&$trab['Patente']!=''){                                                            $new_veh[$Count_veh]++;}
	if(isset($trab['Num_serie'])&&$trab['Num_serie']!=''){                                                        $new_veh[$Count_veh]++;}
	if(isset($trab['AnoFab'])&&$trab['AnoFab']!=''){                                                              $new_veh[$Count_veh]++;}
	if(isset($trab['idZona'])&&$trab['idZona']!=0){                                                               $new_veh[$Count_veh]++;}
	if(isset($trab['Capacidad'])&&$trab['Capacidad']!=''){                                                        $new_veh[$Count_veh]++;}
	if(isset($trab['idTrabajador'])&&$trab['idTrabajador']!=0){                                                   $new_veh[$Count_veh]++;}
	if(isset($trab['Direccion_img'])&&$trab['Direccion_img']!=''){                                                $new_veh[$Count_veh]++;}
	if(isset($trab['doc_mantencion'])&&$trab['doc_mantencion']!=''){                                              $new_veh[$Count_veh]++;}
	if(isset($trab['doc_padron'])&&$trab['doc_padron']!=''){                                                      $new_veh[$Count_veh]++;}
	if(isset($trab['doc_permiso_circulacion'])&&$trab['doc_permiso_circulacion']!=''){                            $new_veh[$Count_veh]++;}
	if(isset($trab['doc_resolucion_sanitaria'])&&$trab['doc_resolucion_sanitaria']!=''){                          $new_veh[$Count_veh]++;}
	if(isset($trab['doc_revision_tecnica'])&&$trab['doc_revision_tecnica']!=''){                                  $new_veh[$Count_veh]++;}
	if(isset($trab['doc_seguro_carga'])&&$trab['doc_seguro_carga']!=''){                                          $new_veh[$Count_veh]++;}
	if(isset($trab['doc_soap'])&&$trab['doc_soap']!=''){                                                          $new_veh[$Count_veh]++;}
	if(isset($trab['doc_fecha_mantencion'])&&$trab['doc_fecha_mantencion']!='0000-00-00'){                        $new_veh[$Count_veh]++;}
	if(isset($trab['doc_fecha_padron'])&&$trab['doc_fecha_padron']!='0000-00-00'){                                $new_veh[$Count_veh]++;}
	if(isset($trab['doc_fecha_permiso_circulacion'])&&$trab['doc_fecha_permiso_circulacion']!='0000-00-00'){      $new_veh[$Count_veh]++;}
	if(isset($trab['doc_fecha_resolucion_sanitaria'])&&$trab['doc_fecha_resolucion_sanitaria']!='0000-00-00'){    $new_veh[$Count_veh]++;}
	if(isset($trab['doc_fecha_revision_tecnica'])&&$trab['doc_fecha_revision_tecnica']!='0000-00-00'){            $new_veh[$Count_veh]++;}
	if(isset($trab['doc_fecha_seguro_carga'])&&$trab['doc_fecha_seguro_carga']!='0000-00-00'){                    $new_veh[$Count_veh]++;}
	if(isset($trab['doc_fecha_soap'])&&$trab['doc_fecha_soap']!='0000-00-00'){                                    $new_veh[$Count_veh]++;}

	$Count_veh++;
}
/************************************/
if(isset($ndata_1)&&$ndata_1!=''&&$ndata_1!=0){
	$Count_pas   = $ndata_1;
}

//Calculos trabajadores
$i             = 0;
$s_new_trab    = 0;
$s_total_trab  = 0;
foreach ($arrTrabajador as $trab) { 
	$s_new_trab    = $s_new_trab + $new_trab[$i];
	$s_total_trab  = $s_total_trab + $total_trab;
	$i++;
}
//Calculos pasajeros
$i             = 0;
$s_new_veh    = 0;
$s_total_veh  = 0;
foreach ($arrVehiculo as $veh) { 
	$s_new_veh    = $s_new_veh + $new_veh[$i];
	$s_total_veh  = $s_total_veh + $total_veh;
	$i++;
}
?>	


<div class="content-header content-header-media">
	<div class="header-section">
		<div class="row">
			<div class="col-md-4 col-lg-6 hidden-xs hidden-sm">
				<h1>Bienvenido <strong><?php echo $_SESSION['usuario']['basic_data']['Nombre'] ?></strong><br>
				<small>Plataforma Transportista</small></h1>
			</div>
			<div class="col-md-8 col-lg-6">
				<div class="row text-center">
					<div class="col-xs-4 col-sm-3">
						
					</div>
					<div class="col-xs-4 col-sm-3">
						<h2 class="animation-hatch">
							<strong><?php echo $Count_veh; ?></strong><br>
							<small><i class="fa fa-car" aria-hidden="true"></i> Vehiculos</small>
						</h2>
					</div>
					<div class="col-xs-4 col-sm-3">
						<h2 class="animation-hatch">
							<strong><?php echo $Count_trab; ?></strong><br>
							<small><i class="fa fa-users" aria-hidden="true"></i> Choferes</small>
						</h2>
					</div>
					<div class="col-sm-3 hidden-xs">
						<h2 class="animation-hatch">
							<strong><?php echo $Count_pas; ?></strong><br>
							<small><i class="fa fa-user" aria-hidden="true"></i> Pasajeros</small>
						</h2>
					</div>
				</div>
			</div>
		</div>
	</div>
	<img src="<?php echo DB_SITE_REPO; ?>/Legacy/gestion_modular/img/dashboard_header.jpg" alt="header image" class="animation-pulseSlow">
</div>

<div class="col-sm-12">
	
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-user fa-5x" aria-hidden="true"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo porcentaje($new_prop/$total_prop); ?></div>
						<div>% Completado Perfil</div>
					</div>
				</div>
			</div>
			<a href="principal_datos.php">
				<div class="panel-footer">
					<span class="pull-left">Editar</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
													
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-users fa-5x" aria-hidden="true"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo porcentaje($s_new_trab/$s_total_trab); ?></div>
						<div>% Completado Choferes</div>
					</div>
				</div>
			</div>
			<a href="trabajadores_listado.php?pagina=1">
				<div class="panel-footer">
					<span class="pull-left">Ver Choferes</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
							
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-yellow">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-car fa-5x" aria-hidden="true"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge"><?php echo porcentaje($s_new_veh/$s_total_veh); ?></div>
						<div>% Completado Vehiculos</div>
					</div>
				</div>
			</div>
			<a href="vehiculos_listado.php?pagina=1">
				<div class="panel-footer">
					<span class="pull-left">Ver Vehiculos</span>
					<span class="pull-right"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>                    
                        
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

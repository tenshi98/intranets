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
// Se traen todos los datos del trabajador
$query = "SELECT 
trabajadores_listado.Direccion_img,

trabajadores_listado.Nombre,
trabajadores_listado.ApellidoPat,
trabajadores_listado.ApellidoMat, 
trabajadores_listado.Rut,
core_sexo.Nombre AS Sexo,
trabajadores_listado.FNacimiento,
trabajadores_listado.Fono,
trabajadores_listado.email,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
trabajadores_listado.Direccion,
core_estado_civil.Nombre AS EstadoCivil,
core_estados.Nombre AS Estado,
core_sistemas.Nombre AS Sistema,				

trabajadores_listado.ContactoPersona,
trabajadores_listado.ContactoFono,

trabajadores_listado_tipos.Nombre AS TipoTrabajador,
trabajadores_listado.Cargo, 
sistema_afp.Nombre AS nombre_afp,
sistema_salud.Nombre AS nombre_salud,
core_tipos_contrato.Nombre AS TipoContrato,
trabajadores_listado.F_Inicio_Contrato,
trabajadores_listado.F_Termino_Contrato,
trabajadores_listado.Observaciones,
trabajadores_listado.SueldoLiquido,

core_tipos_licencia_conducir.Nombre AS LicenciaTipo,
trabajadores_listado.CA_Licencia AS LicenciaCA, 
trabajadores_listado.LicenciaFechaControlUltimo AS LicenciaControlUlt,
trabajadores_listado.LicenciaFechaControl AS LicenciaControl,

trabajadores_listado.File_Curriculum,
trabajadores_listado.File_Antecedentes,
trabajadores_listado.File_Carnet,
trabajadores_listado.File_Contrato,
trabajadores_listado.File_Licencia,
trabajadores_listado.File_RHTM,
trabajadores_listado.File_RHTM_Fecha

FROM `trabajadores_listado`
LEFT JOIN `core_estados`                     ON core_estados.idEstado                         = trabajadores_listado.idEstado
LEFT JOIN `trabajadores_listado_tipos`       ON trabajadores_listado_tipos.idTipo             = trabajadores_listado.idTipo
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                       = trabajadores_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`            ON core_ubicacion_ciudad.idCiudad                = trabajadores_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`           ON core_ubicacion_comunas.idComuna               = trabajadores_listado.idComuna
LEFT JOIN `sistema_afp`                      ON sistema_afp.idAFP                             = trabajadores_listado.idAFP
LEFT JOIN `sistema_salud`                    ON sistema_salud.idSalud                         = trabajadores_listado.idSalud
LEFT JOIN `core_tipos_contrato`              ON core_tipos_contrato.idTipoContrato            = trabajadores_listado.idTipoContrato
LEFT JOIN `core_tipos_licencia_conducir`     ON core_tipos_licencia_conducir.idTipoLicencia   = trabajadores_listado.idTipoLicencia
LEFT JOIN `core_sexo`                        ON core_sexo.idSexo                              = trabajadores_listado.idSexo
LEFT JOIN `core_estado_civil`                ON core_estado_civil.idEstadoCivil               = trabajadores_listado.idEstadoCivil

WHERE trabajadores_listado.idTrabajador = ".$_GET['view'];
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);

// Se trae un listado con todas las cargas familiares
$arrCargas = array();
$query = "SELECT  Nombre, ApellidoPat, ApellidoMat
FROM `trabajadores_listado_cargas`
WHERE idTrabajador = ".$_GET['view']."
ORDER BY idCarga ASC ";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrCargas,$row );
}


?>


<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div>
			<h5>Ver Datos del Chofer</h5>
			<div class="toolbar"></div>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="#basicos" data-toggle="tab"><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				
				<div class="wmd-panel">
					
					<div class="col-sm-4">
						<?php if ($rowdata['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_ALT_1; ?>/upload/<?php echo $rowdata['Direccion_img']; ?>">
						<?php }?>
					</div>
					<div class="col-sm-8">
						<h2 class="text-primary">Datos Basicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat']; ?><br/>
							<strong>Rut : </strong><?php echo $rowdata['Rut']; ?><br/>
							<strong>Sexo : </strong><?php echo $rowdata['Sexo']; ?><br/>
							<strong>Fecha de Nacimiento : </strong><?php echo Fecha_estandar($rowdata['FNacimiento']); ?><br/>
							<strong>Fono : </strong><?php echo $rowdata['Fono']; ?><br/>
							<strong>Email : </strong><?php echo $rowdata['email']; ?><br/>
							<strong>Direccion : </strong><?php echo $rowdata['Direccion'].', '.$rowdata['nombre_comuna'].', '.$rowdata['nombre_region']; ?><br/>
							<strong>Estado Civil: </strong><?php echo $rowdata['EstadoCivil']; ?><br/>
							<strong>Estado : </strong><?php echo $rowdata['Estado']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowdata['Sistema']; ?>
						</p>	

					
						<h2 class="text-primary">Cargas Familiares</h2>
						<p class="text-muted">
							<?php
							//Verifico el total de cargas
							$nn = 0;
							$n_carga = 1;
							foreach ($arrCargas as $carga) {
								$nn++;
							}
							//Se existen cargas estas se despliegan
							if($nn!=0){
								foreach ($arrCargas as $carga) {
									echo '<strong>Carga #'.$n_carga.' : </strong>'.$carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat'].'<br/>';
									$n_carga++;
								}
							//si no existen cargas se muestra mensaje	
							}else{
								echo 'Chofer sin cargas familiares';
							}
							?>
						</p>
						
						
						<h2 class="text-primary">Datos de Contacto</h2>
						<p class="text-muted">
							<strong>Persona de Contacto : </strong><?php echo $rowdata['ContactoPersona']; ?><br/>
							<strong>Fono de Persona de Contacto : </strong><?php echo $rowdata['ContactoFono']; ?><br/>
						</p>	

						<h2 class="text-primary">Datos Laborales</h2>
						<p class="text-muted">
							<strong>Tipo Chofer : </strong><?php echo $rowdata['TipoTrabajador']; ?><br/>
							<strong>Cargo : </strong><?php echo $rowdata['Cargo']; ?><br/>
							<strong>AFP : </strong><?php echo $rowdata['nombre_afp']; ?><br/>
							<strong>Salud : </strong><?php echo $rowdata['nombre_salud']; ?><br/>
							<strong>Tipo de Contrato : </strong><?php echo $rowdata['TipoContrato']; ?><br/>
							<strong>Fecha de Inicio Contrato : </strong><?php if(isset($rowdata['F_Inicio_Contrato'])&&$rowdata['F_Inicio_Contrato']!='0000-00-00'){echo Fecha_estandar($rowdata['F_Inicio_Contrato']);}else{echo 'Sin fecha de inicio';} ?><br/>
							<strong>Fecha de Termino Contrato : </strong><?php if(isset($rowdata['F_Termino_Contrato'])&&$rowdata['F_Termino_Contrato']!='0000-00-00'){echo Fecha_estandar($rowdata['F_Termino_Contrato']);}else{echo 'Sin fecha de termino';} ?><br/>
							<strong>Sueldo Liquido a Pago : </strong><?php echo valores($rowdata['SueldoLiquido'], 0); ?><br/>
							<strong>Observaciones : </strong><?php echo $rowdata['Observaciones']; ?>
						</p>
							
						<h2 class="text-primary">Licencia de Conducir</h2>
						<p class="text-muted">
							<strong>Tipo de Licencia : </strong><?php echo $rowdata['LicenciaTipo']; ?><br/>
							<strong>Numero CA : </strong><?php echo $rowdata['LicenciaCA']; ?><br/>
							<strong>Fecha Ultimo Control : </strong><?php if(isset($rowdata['LicenciaControlUlt'])&&$rowdata['LicenciaControlUlt']!='0000-00-00'){echo Fecha_estandar($rowdata['LicenciaControlUlt']);}else{echo 'Sin fecha de ultimo control';} ?><br/>
							<strong>Fecha Control : </strong><?php if(isset($rowdata['LicenciaControl'])&&$rowdata['LicenciaControl']!='0000-00-00'){echo Fecha_estandar($rowdata['LicenciaControl']);}else{echo 'Sin fecha de control';} ?>
						</p>
						
						<h2 class="text-primary">Archivos</h2>
						<div class="col-sm-12">
							<?php 
							//Contrato
							if(isset($rowdata['File_Contrato'])&&$rowdata['File_Contrato']!=''){
								echo '<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Contrato'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Contrato</a>';
							}
							//Curriculum
							if(isset($rowdata['File_Curriculum'])&&$rowdata['File_Curriculum']!=''){
								echo '<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Curriculum'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Curriculum</a>';
							}
							//Antecedentes
							if(isset($rowdata['File_Antecedentes'])&&$rowdata['File_Antecedentes']!=''){
								echo '<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Antecedentes'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Antecedentes</a>';
							}
							//Carnet
							if(isset($rowdata['File_Carnet'])&&$rowdata['File_Carnet']!=''){
								echo '<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Carnet'], fecha_actual()).'" class="btn btn-xs btn-primary" style="margin-right: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Carnet Identidad</a>';
							}
							//Licencia
							if(isset($rowdata['File_Licencia'])&&$rowdata['File_Licencia']!=''){
								echo '<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Licencia'], fecha_actual()).'" class="btn btn-xs btn-primary fleft" style="margin-right: 5px;margin-top: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Licencia de conducir</a>';
							}
							//Licencia
							if(isset($rowdata['File_RHTM'])&&$rowdata['File_RHTM']!=''){
								echo '<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_RHTM'], fecha_actual()).'" class="btn btn-xs btn-primary fleft" style="margin-right: 5px;margin-top: 5px;"><i class="fa fa-download" aria-hidden="true"></i> Descargar Documento RHTM</a>';
							}
							?>
						</div>
							
							
										
					</div>	
					<div class="clearfix"></div>
			
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

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
$original = "principal_datos.php";
$location = $original;
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos Personales';
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
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
// Se traen todos los datos de mi usuario
$query = "SELECT 
apoderados_listado.Direccion_img,
apoderados_listado.Nombre,
apoderados_listado.ApellidoPat,
apoderados_listado.ApellidoMat, 
apoderados_listado.Rut,
apoderados_listado.Password,
apoderados_listado.FNacimiento,
apoderados_listado.Fono1,
apoderados_listado.Fono2,
apoderados_listado.GeoLatitud,
apoderados_listado.GeoLongitud,
core_ubicacion_ciudad.Nombre AS nombre_region,
core_ubicacion_comunas.Nombre AS nombre_comuna,
apoderados_listado.Direccion,
core_estados.Nombre AS Estado,
core_sistemas.Nombre AS Sistema,				
apoderados_listado.F_Inicio_Contrato,
apoderados_listado.F_Termino_Contrato,
apoderados_listado.File_Contrato

FROM `apoderados_listado`
LEFT JOIN `core_estados`                     ON core_estados.idEstado               = apoderados_listado.idEstado
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema             = apoderados_listado.idSistema
LEFT JOIN `core_ubicacion_ciudad`            ON core_ubicacion_ciudad.idCiudad      = apoderados_listado.idCiudad
LEFT JOIN `core_ubicacion_comunas`           ON core_ubicacion_comunas.idComuna     = apoderados_listado.idComuna

WHERE apoderados_listado.idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."'";
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);

// Se trae un listado con todas las cargas familiares
$arrCargas = array();
$query = "SELECT  
apoderados_listado_hijos.Nombre, 
apoderados_listado_hijos.ApellidoPat, 
apoderados_listado_hijos.ApellidoMat,
apoderados_listado_hijos.Direccion_img,
core_sexo.Nombre AS Sexo,
sistema_planes.Nombre AS PlanNombre,
sistema_planes.Valor AS PlanValor

FROM `apoderados_listado_hijos`
LEFT JOIN `core_sexo`       ON core_sexo.idSexo       = apoderados_listado_hijos.idSexo
LEFT JOIN `sistema_planes`  ON sistema_planes.idPlan  = apoderados_listado_hijos.idPlan
WHERE apoderados_listado_hijos.idApoderado = '".$_SESSION['usuario']['basic_data']['idApoderado']."'
ORDER BY apoderados_listado_hijos.idHijos ASC ";
//Consulta
$resultado = mysqli_query ($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrCargas,$row );
}

?>
<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Apoderado', $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat'], 'Resumen');?>
</div>
<div class="clearfix"></div> 

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'principal_datos.php'; ?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'principal_datos_datos.php'; ?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'principal_datos_ubicacion.php'; ?>" ><i class="fa fa-map-o" aria-hidden="true"></i> Ubicacion</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'principal_datos_imagen.php'; ?>" ><i class="fa fa-file-image-o" aria-hidden="true"></i> Foto</a></li>
						<li class=""><a href="<?php echo 'principal_datos_password.php'; ?>" ><i class="fa fa-key" aria-hidden="true"></i> Password</a></li>
					</ul>
                </li>           
			</ul>	
		</header>
        <div id="div-3" class="tab-content">
			
			<div class="tab-pane fade active in" id="basicos">
				<div class="wmd-panel">
					<div class="col-sm-4">
						<?php if ($rowdata['Direccion_img']=='') { ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_REPO ?>/LIB_assets/img/usr.png">
						<?php }else{  ?>
							<img style="margin-top:10px;" class="media-object img-thumbnail user-img width100" alt="User Picture" src="<?php echo DB_SITE_ALT_1 ?>/upload/<?php echo $rowdata['Direccion_img']; ?>">
						<?php }?>
					</div>
					<div class="col-sm-8">
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Datos Basicos</h2>
						<p class="text-muted">
							<strong>Nombre : </strong><?php echo $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat']; ?><br/>
							<strong>Rut : </strong><?php echo $rowdata['Rut']; ?><br/>
							<strong>Fecha de Nacimiento : </strong><?php echo Fecha_estandar($rowdata['FNacimiento']); ?><br/>
							<strong>Fono Celular : </strong><?php echo $rowdata['Fono1']; ?><br/>
							<strong>Fono Fijo : </strong><?php echo $rowdata['Fono2']; ?><br/>
							<strong>Direccion : </strong><?php echo $rowdata['Direccion'].', '.$rowdata['nombre_comuna'].', '.$rowdata['nombre_region']; ?><br/>
							<strong>Estado : </strong><?php echo $rowdata['Estado']; ?><br/>
							<strong>Sistema : </strong><?php echo $rowdata['Sistema']; ?><br/>
							<strong>Fecha de Inicio Contrato : </strong><?php if(isset($rowdata['F_Inicio_Contrato'])&&$rowdata['F_Inicio_Contrato']!='0000-00-00'){echo Fecha_estandar($rowdata['F_Inicio_Contrato']);}else{echo 'Sin fecha de inicio';} ?><br/>
							<strong>Fecha de Termino Contrato : </strong><?php if(isset($rowdata['F_Termino_Contrato'])&&$rowdata['F_Termino_Contrato']!='0000-00-00'){echo Fecha_estandar($rowdata['F_Termino_Contrato']);}else{echo 'Sin fecha de termino';} ?><br/>
						</p>
						

						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Hijos</h2>
						<div class="row">
							<?php
							//Verifico el total de cargas
							$nn = 0;
							$n_carga = 1;
							foreach ($arrCargas as $carga) {
								$nn++;
							}
							//Se existen cargas estas se despliegan
							if($nn!=0){
								foreach ($arrCargas as $carga) { ?>
									<div class="col-md-6 col-sm-6 col-xs-12 fleft">
										<div class="info-box" style="box-shadow:none; color:#999 !important;">
											<span class="info-box-icon">
												 <img src="<?php echo DB_SITE_ALT_1.'/upload/'.$carga['Direccion_img']; ?>" alt="hijo" height="100%" width="100%"> 
											</span>
											<div class="info-box-content">
												<span class="info-box-text"><?php echo $carga['Nombre'].' '.$carga['ApellidoPat'].' '.$carga['ApellidoMat']; ?></span>
												<span class="info-box-text"><?php echo $carga['Sexo']; ?></span>
												<span class="info-box-number"><?php echo $carga['PlanNombre']; ?></span>
											</div>
										</div>
									</div>
								
								<?php 
								}
							//si no existen cargas se muestra mensaje
							}else{
								echo '<p class="text-muted">Apoderado Sin Hijos</p>';
							}
							?>	
						</div>		
						<div class="clearfix"></div>

		
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Archivos</h2>
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php 
								//Contrato
								if(isset($rowdata['File_Contrato'])&&$rowdata['File_Contrato']!=''){
									echo '
										<tr class="item-row">
											<td>Contrato</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Contrato'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Contrato'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								?>
							</tbody>
						</table>
						<?php widget_modal(80, 95); ?>
						
						
						<h2 class="text-primary"><i class="fa fa-list" aria-hidden="true"></i> Ubicacion</h2>
						<?php echo mapa_from_gps($rowdata['GeoLatitud'], $rowdata['GeoLongitud'], 'Direccion', 'Calle', $rowdata['Direccion'], $_SESSION['usuario']['basic_data']['Config_IDGoogle'], 18, 1); ?>
											
					</div>	
					<div class="clearfix"></div>
				</div>
			</div>
        </div>	
	</div>
</div>



<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';
?>

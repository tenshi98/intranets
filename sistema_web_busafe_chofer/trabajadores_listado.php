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
$original = "trabajadores_listado.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){             $location .= "&Nombre=".$_GET['Nombre'];            $search .= "&Nombre=".$_GET['Nombre'];}
if(isset($_GET['ApellidoPat']) && $_GET['ApellidoPat'] != ''){   $location .= "&ApellidoPat=".$_GET['ApellidoPat'];  $search .= "&ApellidoPat=".$_GET['ApellidoPat'];}
if(isset($_GET['ApellidoMat']) && $_GET['ApellidoMat'] != ''){   $location .= "&ApellidoMat=".$_GET['ApellidoMat'];  $search .= "&ApellidoMat=".$_GET['ApellidoMat'];}
if(isset($_GET['Rut']) && $_GET['Rut'] != ''){                   $location .= "&Rut=".$_GET['Rut'];                  $search .= "&Rut=".$_GET['Rut'];}
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){             $location .= "&idTipo=".$_GET['idTipo'];            $search .= "&idTipo=".$_GET['idTipo'];}
if(isset($_GET['Cargo']) && $_GET['Cargo'] != ''){               $location .= "&Cargo=".$_GET['Cargo'];              $search .= "&Cargo=".$_GET['Cargo'];}
//Titulo ventana
$t_dashboard = '<i class="fa fa-address-card-o" aria-hidden="true"></i> Choferes';
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if ( !empty($_POST['submit']) )  { 
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado.php';
}
//se borra un dato
if ( !empty($_GET['del']) )     {
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/trabajadores_listado.php';	
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])) {$error['usuario'] 	  = 'sucess/Chofer Creado correctamente';}
if (isset($_GET['edited']))  {$error['usuario'] 	  = 'sucess/Chofer Modificado correctamente';}
if (isset($_GET['deleted'])) {$error['usuario'] 	  = 'sucess/Chofer borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);};?>
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 if ( ! empty($_GET['id']) ) { 
// Se traen todos los datos del Chofer
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

WHERE trabajadores_listado.idTrabajador = ".$_GET['id'];
$resultado = mysqli_query($dbConn, $query);
$rowdata = mysqli_fetch_assoc ($resultado);

// Se trae un listado con todas las cargas familiares
$arrCargas = array();
$query = "SELECT  Nombre, ApellidoPat, ApellidoMat
FROM `trabajadores_listado_cargas`
WHERE idTrabajador = ".$_GET['id']."
ORDER BY idCarga ASC ";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrCargas,$row );
}
?>
<div class="col-sm-12">
	<?php echo widget_title('bg-aqua', 'fa-cog', 100, 'Chofer', $rowdata['Nombre'].' '.$rowdata['ApellidoPat'].' '.$rowdata['ApellidoMat'], 'Resumen');?>
</div>
<div class="clearfix"></div>

<div class="col-sm-12">
	<div class="box">
		<header>
			<ul class="nav nav-tabs pull-right">
				<li class="active"><a href="<?php echo 'trabajadores_listado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-bars" aria-hidden="true"></i> Resumen</a></li>
				<li class=""><a href="<?php echo 'trabajadores_listado_datos.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-list-alt" aria-hidden="true"></i> Datos Basicos</a></li>
				<li class=""><a href="<?php echo 'trabajadores_listado_contacto.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-address-book-o" aria-hidden="true"></i> Datos Contacto</a></li>
				<li class="dropdown">
					<a href="#" data-toggle="dropdown"><i class="fa fa-plus" aria-hidden="true"></i> Ver mas <i class="fa fa-angle-down" aria-hidden="true"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li class=""><a href="<?php echo 'trabajadores_listado_laboral.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-university" aria-hidden="true"></i> Informacion Laboral</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_cargas.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-user-plus" aria-hidden="true"></i> Cargas Familiares</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_estado.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-power-off" aria-hidden="true"></i> Estado</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_licencia.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Licencia Conducir</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_imagen.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Foto</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_contrato.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Contrato</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_curriculum.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Curriculum</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_antecedentes.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Antecedentes</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_carnet.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - Carnet</a></li>
						<li class=""><a href="<?php echo 'trabajadores_listado_rhtm.php?pagina='.$_GET['pagina'].'&id='.$_GET['id']?>" ><i class="fa fa-files-o" aria-hidden="true"></i> Archivo - RHTM</a></li>
						
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
						<table id="items" style="margin-bottom: 20px;">
							<tbody>
								<?php 
								//Contrato
								if(isset($rowdata['File_Contrato'])&&$rowdata['File_Contrato']!=''){
									echo '
										<tr class="item-row">
											<td>Contrato de Trabajo</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Contrato'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Contrato'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Curriculum
								if(isset($rowdata['File_Curriculum'])&&$rowdata['File_Curriculum']!=''){
									echo '
										<tr class="item-row">
											<td>Curriculum</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Curriculum'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Curriculum'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Antecedentes
								if(isset($rowdata['File_Antecedentes'])&&$rowdata['File_Antecedentes']!=''){
									echo '
										<tr class="item-row">
											<td>Papel de Antecedentes</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Antecedentes'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Antecedentes'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Carnet
								if(isset($rowdata['File_Carnet'])&&$rowdata['File_Carnet']!=''){
									echo '
										<tr class="item-row">
											<td>Carnet de Identidad</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Carnet'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Carnet'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//Licencia
								if(isset($rowdata['File_Licencia'])&&$rowdata['File_Licencia']!=''){
									echo '
										<tr class="item-row">
											<td>Licencia de Conducir</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Licencia'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_Licencia'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								//RHTM
								if(isset($rowdata['File_RHTM'])&&$rowdata['File_RHTM']!=''){
									echo '
										<tr class="item-row">
											<td>RHTM Revisado el '.fecha_estandar($rowdata['File_RHTM_Fecha']).'</td>
											<td width="10">
												<div class="btn-group" style="width: 70px;">
													<a href="view_doc_preview.php?path='.simpleEncode('upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_RHTM'], fecha_actual()).'" title="Ver Documento" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-eye" aria-hidden="true"></i></a>
													<a href="1download.php?dir='.simpleEncode(DB_SITE_ALT_1.'/upload', fecha_actual()).'&file='.simpleEncode($rowdata['File_RHTM'], fecha_actual()).'" title="Descargar Archivo" class="btn btn-primary btn-sm tooltip"><i class="fa fa-download" aria-hidden="true"></i></a>
												</div>
											</td>
										</tr>
									';
								}
								?>
							</tbody>
						</table>
						<?php widget_modal(80, 95); ?>
						

										
					</div>	
					<div class="clearfix"></div>
			
				</div>
			</div>
        </div>	
	</div>
</div>

<div class="clearfix"></div>
<div class="col-sm-12" style="margin-bottom:30px">
<a href="<?php echo $location ?>" class="btn btn-danger fright"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
<div class="clearfix"></div>
</div>

<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } elseif ( ! empty($_GET['new']) ) { ?>
 <div class="col-sm-8 fcenter">
	<div class="box dark">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Chofer</h5>
		</header>
		<div id="div-1" class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" novalidate>
        	
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {              $x1  = $Nombre;               }else{$x1  = '';}
				if(isset($ApellidoPat)) {         $x2  = $ApellidoPat;          }else{$x2  = '';}
				if(isset($ApellidoMat)) {         $x3  = $ApellidoMat;          }else{$x3  = '';}
				if(isset($Rut)) {                 $x4  = $Rut;                  }else{$x4  = '';}
				if(isset($idTipo)) {              $x5  = $idTipo;               }else{$x5  = '';}
				if(isset($idSistema)) {           $x6  = $idSistema;            }else{$x6  = '';}
				if(isset($Cargo)) {               $x7  = $Cargo;                }else{$x7  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				echo '<h3>Datos Basicos</h3>';
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 2);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 2);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 2);
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x4, 2);
				
				echo '<h3>Datos Laborales</h3>';
				$Form_Inputs->form_select('Tipo Chofer','idTipo', $x5, 2, 'idTipo', 'Nombre', 'trabajadores_listado_tipos', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Cargo', 'Cargo', $x7, 1);
				
				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('idTransporte', $_SESSION['usuario']['basic_data']['idTransporte'], 2);
				
				?>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
                      
			</form> 
            <?php widget_validator(); ?>        
		</div>
	</div>
</div>

 
<?php ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// 
 } else  { 
/**********************************************************/
//paginador de resultados
if(isset($_GET["pagina"])){
	$num_pag = $_GET["pagina"];	
} else {
	$num_pag = 1;	
}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){
	$comienzo = 0 ;
	$num_pag = 1 ;
} else {
	$comienzo = ( $num_pag - 1 ) * $cant_reg ;
}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'nombre_asc':   $order_by = 'ORDER BY trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC ';      $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente'; break;
		case 'nombre_desc':  $order_by = 'ORDER BY trabajadores_listado.ApellidoPat DESC, trabajadores_listado.ApellidoMat DESC, trabajadores_listado.Nombre DESC ';   $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Nombre Descendente';break;
		case 'tipo_asc':     $order_by = 'ORDER BY trabajadores_listado_tipos.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ascendente';break;
		case 'tipo_desc':    $order_by = 'ORDER BY trabajadores_listado_tipos.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Descendente';break;
		case 'estado_asc':   $order_by = 'ORDER BY core_estados.Nombre ASC ';                   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente';break;
		case 'estado_desc':  $order_by = 'ORDER BY core_estados.Nombre DESC ';                  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Descendente';break;
		case 'rut_asc':      $order_by = 'ORDER BY trabajadores_listado.Rut ASC';               $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Rut Ascendente'; break;
		case 'rut_desc':     $order_by = 'ORDER BY trabajadores_listado.Rut DESC';              $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Rut Descendente';break;
		
		default: $order_by = 'ORDER BY trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
	}
}else{
	$order_by = 'ORDER BY trabajadores_listado.ApellidoPat ASC, trabajadores_listado.ApellidoMat ASC, trabajadores_listado.Nombre ASC '; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Nombre Ascendente';
}
/**********************************************************/
//Variable de busqueda
$z = "WHERE trabajadores_listado.idTransporte=".$_SESSION['usuario']['basic_data']['idTransporte'];
//Verifico el tipo de usuario que esta ingresando
$z.=" AND trabajadores_listado.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];	

/**********************************************************/
//Se aplican los filtros
if(isset($_GET['Nombre']) && $_GET['Nombre'] != ''){            $z .= " AND trabajadores_listado.Nombre LIKE '%".$_GET['Nombre']."%'";}
if(isset($_GET['ApellidoPat']) && $_GET['ApellidoPat'] != ''){  $z .= " AND trabajadores_listado.ApellidoPat LIKE '%".$_GET['ApellidoPat']."%'";}
if(isset($_GET['ApellidoMat']) && $_GET['ApellidoMat'] != ''){  $z .= " AND trabajadores_listado.ApellidoMat LIKE '%".$_GET['ApellidoMat']."%'";}
if(isset($_GET['Rut']) && $_GET['Rut'] != ''){                  $z .= " AND trabajadores_listado.Rut LIKE '%".$_GET['Rut']."%'";}
if(isset($_GET['idTipo']) && $_GET['idTipo'] != ''){            $z .= " AND trabajadores_listado.idTipo=".$_GET['idTipo'];}
if(isset($_GET['Cargo']) && $_GET['Cargo'] != ''){              $z .= " AND trabajadores_listado.Cargo LIKE '%".$_GET['Cargo']."%'";}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idTrabajador FROM `trabajadores_listado` ".$z;
$registros = mysqli_query($dbConn, $query);
$cuenta_registros = mysqli_num_rows($registros);
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);	
// Se trae un listado con todos los elementos
$arrTrabajador = array();
$query = "SELECT 
trabajadores_listado.idTrabajador,
trabajadores_listado.Rut, 
trabajadores_listado.Nombre, 
trabajadores_listado.ApellidoPat, 
trabajadores_listado.ApellidoMat,
core_estados.Nombre AS Estado,
trabajadores_listado.idEstado,
trabajadores_listado.idSexo, 
trabajadores_listado.FNacimiento, 
trabajadores_listado.Fono, 
trabajadores_listado.idCiudad, 
trabajadores_listado.idComuna,
trabajadores_listado.Direccion, 
trabajadores_listado.idEstadoCivil, 
trabajadores_listado.email, 
trabajadores_listado.ContactoPersona, 
trabajadores_listado.ContactoFono, 
trabajadores_listado.idTipo, 
trabajadores_listado.Cargo,
trabajadores_listado.idTipoContrato, 
trabajadores_listado.F_Inicio_Contrato, 
trabajadores_listado.F_Termino_Contrato, 
trabajadores_listado.idAFP, 
trabajadores_listado.idSalud, 
trabajadores_listado.SueldoLiquido,
trabajadores_listado.idTipoLicencia, 
trabajadores_listado.CA_Licencia, 
trabajadores_listado.LicenciaFechaControl, 
trabajadores_listado.LicenciaFechaControlUltimo,
trabajadores_listado.Direccion_img, 
trabajadores_listado.File_Curriculum, 
trabajadores_listado.File_Antecedentes, 
trabajadores_listado.File_Carnet, 
trabajadores_listado.File_Contrato,
trabajadores_listado.File_Licencia


FROM `trabajadores_listado`
LEFT JOIN `core_estados`   ON core_estados.idEstado   = trabajadores_listado.idEstado
".$z."
".$order_by."
LIMIT $comienzo, $cant_reg ";
$resultado = mysqli_query($dbConn, $query);
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrTrabajador,$row );
}?>
<div class="col-sm-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" title="Presionar para desplegar Formulario de Busqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>		
	</ul>
	
	<a href="<?php echo $location; ?>&new=true" class="btn btn-default fright margin_width fmrbtn" ><i class="fa fa-file-o" aria-hidden="true"></i> Crear Chofer</a>

</div>
<div class="clearfix"></div> 
<div class="collapse col-sm-12" id="collapseExample">
	<div class="well">
		<div class="col-sm-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" novalidate>
				<?php 
				//Se verifican si existen los datos
				if(isset($Nombre)) {              $x1  = $Nombre;               }else{$x1  = '';}
				if(isset($ApellidoPat)) {         $x2  = $ApellidoPat;          }else{$x2  = '';}
				if(isset($ApellidoMat)) {         $x3  = $ApellidoMat;          }else{$x3  = '';}
				if(isset($Rut)) {                 $x4  = $Rut;                  }else{$x4  = '';}
				
				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_input_text('Nombre', 'Nombre', $x1, 1);
				$Form_Inputs->form_input_text('Apellido Paterno', 'ApellidoPat', $x2, 1);
				$Form_Inputs->form_input_text('Apellido Materno', 'ApellidoMat', $x3, 1);
				$Form_Inputs->form_input_rut('Rut', 'Rut', $x4, 1);
				
				$Form_Inputs->form_input_hidden('pagina', $_GET['pagina'], 2);
				?>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary fright margin_width fa-input" value="&#xf002; Filtrar" name="filtro_form">
					<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger fright margin_width"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
				</div>
                      
			</form> 
            <?php widget_validator(); ?>
        </div>
	</div>
</div>
<div class="clearfix"></div> 

                     
                                 
<div class="col-sm-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Choferes</h5>
			<div class="toolbar">
				<?php 
				//se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th width="120">
							<div class="pull-left">Rut</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=rut_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=rut_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Nombre</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=nombre_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=nombre_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="120">
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">% Completado</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>			  
				<tbody role="alert" aria-live="polite" aria-relevant="all">
				<?php foreach ($arrTrabajador as $trab) { 
					//variable
					$new_trab    = 0;
					$total_trab  = 32;
					//se verifica la existencia de datos
					if(isset($trab['Nombre'])&&$trab['Nombre']!=''){                                                    $new_trab++;}
					if(isset($trab['ApellidoPat'])&&$trab['ApellidoPat']!=''){                                          $new_trab++;}
					if(isset($trab['ApellidoMat'])&&$trab['ApellidoMat']!=''){                                          $new_trab++;}
					if(isset($trab['Rut'])&&$trab['Rut']!=''){                                                          $new_trab++;}
					if(isset($trab['idSexo'])&&$trab['idSexo']!=0){                                                     $new_trab++;}
					if(isset($trab['FNacimiento'])&&$trab['FNacimiento']!='0000-00-00'){                                $new_trab++;}
					if(isset($trab['Fono'])&&$trab['Fono']!=''){                                                        $new_trab++;}
					if(isset($trab['idCiudad'])&&$trab['idCiudad']!=0){                                                 $new_trab++;}
					if(isset($trab['idComuna'])&&$trab['idComuna']!=0){                                                 $new_trab++;}
					if(isset($trab['Direccion'])&&$trab['Direccion']!=''){                                              $new_trab++;}
					if(isset($trab['idEstadoCivil'])&&$trab['idEstadoCivil']!=0){                                       $new_trab++;}
					if(isset($trab['email'])&&$trab['email']!=''){                                                      $new_trab++;}
					if(isset($trab['ContactoPersona'])&&$trab['ContactoPersona']!=''){                                  $new_trab++;}
					if(isset($trab['ContactoFono'])&&$trab['ContactoFono']!=''){                                        $new_trab++;}
					if(isset($trab['idTipo'])&&$trab['idTipo']!=0){                                                     $new_trab++;}
					if(isset($trab['Cargo'])&&$trab['Cargo']!=''){                                                      $new_trab++;}
					if(isset($trab['idTipoContrato'])&&$trab['idTipoContrato']!=0){                                     $new_trab++;}
					if(isset($trab['F_Inicio_Contrato'])&&$trab['F_Inicio_Contrato']!='0000-00-00'){                    $new_trab++;}
					if(isset($trab['F_Termino_Contrato'])&&$trab['F_Termino_Contrato']!='0000-00-00'){                  $new_trab++;}
					if(isset($trab['idAFP'])&&$trab['idAFP']!=0){                                                       $new_trab++;}
					if(isset($trab['idSalud'])&&$trab['idSalud']!=0){                                                   $new_trab++;}
					if(isset($trab['SueldoLiquido'])&&$trab['SueldoLiquido']!=0){                                       $new_trab++;}
					if(isset($trab['idTipoLicencia'])&&$trab['idTipoLicencia']!=0){                                     $new_trab++;}
					if(isset($trab['CA_Licencia'])&&$trab['CA_Licencia']!=''){                                          $new_trab++;}
					if(isset($trab['LicenciaFechaControl'])&&$trab['LicenciaFechaControl']!='0000-00-00'){              $new_trab++;}
					if(isset($trab['LicenciaFechaControlUltimo'])&&$trab['LicenciaFechaControlUltimo']!='0000-00-00'){  $new_trab++;}
					if(isset($trab['Direccion_img'])&&$trab['Direccion_img']!=''){                                      $new_trab++;}
					if(isset($trab['File_Curriculum'])&&$trab['File_Curriculum']!=''){                                  $new_trab++;}
					if(isset($trab['File_Antecedentes'])&&$trab['File_Antecedentes']!=''){                              $new_trab++;}
					if(isset($trab['File_Carnet'])&&$trab['File_Carnet']!=''){                                          $new_trab++;}
					if(isset($trab['File_Contrato'])&&$trab['File_Contrato']!=''){                                      $new_trab++;}
					if(isset($trab['File_Licencia'])&&$trab['File_Licencia']!=''){                                      $new_trab++;}
					?>
					<tr class="odd">
						<td><?php echo $trab['Rut']; ?></td>
						<td><?php echo $trab['ApellidoPat'].' '.$trab['ApellidoMat'].' '.$trab['Nombre']; ?></td>
						<td><label class="label <?php if(isset($trab['idEstado'])&&$trab['idEstado']==1){echo 'label-success';}else{echo 'label-danger';}?>"><?php echo $trab['Estado']; ?></label></td>
						<td><?php echo porcentaje($new_trab/$total_trab); ?></td>
						<td>
							<div class="btn-group" style="width: 105px;" >
								<a href="<?php echo 'view_trabajador.php?view='.$trab['idTrabajador']; ?>" title="Ver Informacion" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&id='.$trab['idTrabajador']; ?>" title="Editar Informacion" class="btn btn-primary btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
								<?php
									$ubicacion = $location.'&del='.simpleEncode($trab['idTrabajador'], fecha_actual());
									$dialogo   = '¿Realmente deseas eliminar el Chofer '.$trab['Nombre'].' '.$trab['ApellidoPat'].' '.$trab['ApellidoMat'].'?';?>
									<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Informacion" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
							</div>
						</td>
					</tr>
				<?php } ?>                    
				</tbody>
			</table>
		</div>
		<div class="pagrow">	
			<?php 
			//se llama al paginador
			echo paginador_2('paginf',$total_paginas, $original, $search, $num_pag ) ?>
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

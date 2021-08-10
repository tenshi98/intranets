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
// Se traen todos los datos de la pregunta
$query = "SELECT
quiz_listado.Nombre,
quiz_listado.Header_texto,
quiz_listado.Header_fecha,
quiz_listado.Footer_texto,
quiz_listado.Texto_Inicio,
quiz_listado.Tiempo,
core_sistemas.Nombre AS sistema,
core_estados.Nombre AS Estado,
esc_1.Nombre AS Escala,
esc_2.Nombre AS Aprobado,
quiz_tipo_evaluacion.Nombre AS TipoEvaluacion,
quiz_tipo_quiz.Nombre AS TipoQuiz,
quiz_listado.idTipoEvaluacion,
quiz_listado.idTipoQuiz,
quiz_listado.idLimiteTiempo,
quiz_realizadas.Total_Preguntas,
quiz_realizadas.Pregunta_1,
quiz_realizadas.Pregunta_2,
quiz_realizadas.Pregunta_3,
quiz_realizadas.Pregunta_4,
quiz_realizadas.Pregunta_5,
quiz_realizadas.Pregunta_6,
quiz_realizadas.Pregunta_7,
quiz_realizadas.Pregunta_8,
quiz_realizadas.Pregunta_9,
quiz_realizadas.Pregunta_10,
quiz_realizadas.Pregunta_11,
quiz_realizadas.Pregunta_12,
quiz_realizadas.Pregunta_13,
quiz_realizadas.Pregunta_14,
quiz_realizadas.Pregunta_15,
quiz_realizadas.Pregunta_16,
quiz_realizadas.Pregunta_17,
quiz_realizadas.Pregunta_18,
quiz_realizadas.Pregunta_19,
quiz_realizadas.Pregunta_20,
quiz_realizadas.Pregunta_21,
quiz_realizadas.Pregunta_22,
quiz_realizadas.Pregunta_23,
quiz_realizadas.Pregunta_24,
quiz_realizadas.Pregunta_25,
quiz_realizadas.Pregunta_26,
quiz_realizadas.Pregunta_27,
quiz_realizadas.Pregunta_28,
quiz_realizadas.Pregunta_29,
quiz_realizadas.Pregunta_30,
quiz_realizadas.Pregunta_31,
quiz_realizadas.Pregunta_32,
quiz_realizadas.Pregunta_33,
quiz_realizadas.Pregunta_34,
quiz_realizadas.Pregunta_35,
quiz_realizadas.Pregunta_36,
quiz_realizadas.Pregunta_37,
quiz_realizadas.Pregunta_38,
quiz_realizadas.Pregunta_39,
quiz_realizadas.Pregunta_40,
quiz_realizadas.Pregunta_41,
quiz_realizadas.Pregunta_42,
quiz_realizadas.Pregunta_43,
quiz_realizadas.Pregunta_44,
quiz_realizadas.Pregunta_45,
quiz_realizadas.Pregunta_46,
quiz_realizadas.Pregunta_47,
quiz_realizadas.Pregunta_48,
quiz_realizadas.Pregunta_49,
quiz_realizadas.Pregunta_50,
quiz_realizadas.Pregunta_51,
quiz_realizadas.Pregunta_52,
quiz_realizadas.Pregunta_53,
quiz_realizadas.Pregunta_54,
quiz_realizadas.Pregunta_55,
quiz_realizadas.Pregunta_56,
quiz_realizadas.Pregunta_57,
quiz_realizadas.Pregunta_58,
quiz_realizadas.Pregunta_59,
quiz_realizadas.Pregunta_60,
quiz_realizadas.Pregunta_61,
quiz_realizadas.Pregunta_62,
quiz_realizadas.Pregunta_63,
quiz_realizadas.Pregunta_64,
quiz_realizadas.Pregunta_65,
quiz_realizadas.Pregunta_66,
quiz_realizadas.Pregunta_67,
quiz_realizadas.Pregunta_68,
quiz_realizadas.Pregunta_69,
quiz_realizadas.Pregunta_70,
quiz_realizadas.Pregunta_71,
quiz_realizadas.Pregunta_72,
quiz_realizadas.Pregunta_73,
quiz_realizadas.Pregunta_74,
quiz_realizadas.Pregunta_75,
quiz_realizadas.Pregunta_76,
quiz_realizadas.Pregunta_77,
quiz_realizadas.Pregunta_78,
quiz_realizadas.Pregunta_79,
quiz_realizadas.Pregunta_80,
quiz_realizadas.Pregunta_81,
quiz_realizadas.Pregunta_82,
quiz_realizadas.Pregunta_83,
quiz_realizadas.Pregunta_84,
quiz_realizadas.Pregunta_85,
quiz_realizadas.Pregunta_86,
quiz_realizadas.Pregunta_87,
quiz_realizadas.Pregunta_88,
quiz_realizadas.Pregunta_89,
quiz_realizadas.Pregunta_90,
quiz_realizadas.Pregunta_91,
quiz_realizadas.Pregunta_92,
quiz_realizadas.Pregunta_93,
quiz_realizadas.Pregunta_94,
quiz_realizadas.Pregunta_95,
quiz_realizadas.Pregunta_96,
quiz_realizadas.Pregunta_97,
quiz_realizadas.Pregunta_98,
quiz_realizadas.Pregunta_99,
quiz_realizadas.Pregunta_100,
quiz_realizadas.Respuesta_1,
quiz_realizadas.Respuesta_2,
quiz_realizadas.Respuesta_3,
quiz_realizadas.Respuesta_4,
quiz_realizadas.Respuesta_5,
quiz_realizadas.Respuesta_6,
quiz_realizadas.Respuesta_7,
quiz_realizadas.Respuesta_8,
quiz_realizadas.Respuesta_9,
quiz_realizadas.Respuesta_10,
quiz_realizadas.Respuesta_11,
quiz_realizadas.Respuesta_12,
quiz_realizadas.Respuesta_13,
quiz_realizadas.Respuesta_14,
quiz_realizadas.Respuesta_15,
quiz_realizadas.Respuesta_16,
quiz_realizadas.Respuesta_17,
quiz_realizadas.Respuesta_18,
quiz_realizadas.Respuesta_19,
quiz_realizadas.Respuesta_20,
quiz_realizadas.Respuesta_21,
quiz_realizadas.Respuesta_22,
quiz_realizadas.Respuesta_23,
quiz_realizadas.Respuesta_24,
quiz_realizadas.Respuesta_25,
quiz_realizadas.Respuesta_26,
quiz_realizadas.Respuesta_27,
quiz_realizadas.Respuesta_28,
quiz_realizadas.Respuesta_29,
quiz_realizadas.Respuesta_30,
quiz_realizadas.Respuesta_31,
quiz_realizadas.Respuesta_32,
quiz_realizadas.Respuesta_33,
quiz_realizadas.Respuesta_34,
quiz_realizadas.Respuesta_35,
quiz_realizadas.Respuesta_36,
quiz_realizadas.Respuesta_37,
quiz_realizadas.Respuesta_38,
quiz_realizadas.Respuesta_39,
quiz_realizadas.Respuesta_40,
quiz_realizadas.Respuesta_41,
quiz_realizadas.Respuesta_42,
quiz_realizadas.Respuesta_43,
quiz_realizadas.Respuesta_44,
quiz_realizadas.Respuesta_45,
quiz_realizadas.Respuesta_46,
quiz_realizadas.Respuesta_47,
quiz_realizadas.Respuesta_48,
quiz_realizadas.Respuesta_49,
quiz_realizadas.Respuesta_50,
quiz_realizadas.Respuesta_51,
quiz_realizadas.Respuesta_52,
quiz_realizadas.Respuesta_53,
quiz_realizadas.Respuesta_54,
quiz_realizadas.Respuesta_55,
quiz_realizadas.Respuesta_56,
quiz_realizadas.Respuesta_57,
quiz_realizadas.Respuesta_58,
quiz_realizadas.Respuesta_59,
quiz_realizadas.Respuesta_60,
quiz_realizadas.Respuesta_61,
quiz_realizadas.Respuesta_62,
quiz_realizadas.Respuesta_63,
quiz_realizadas.Respuesta_64,
quiz_realizadas.Respuesta_65,
quiz_realizadas.Respuesta_66,
quiz_realizadas.Respuesta_67,
quiz_realizadas.Respuesta_68,
quiz_realizadas.Respuesta_69,
quiz_realizadas.Respuesta_70,
quiz_realizadas.Respuesta_71,
quiz_realizadas.Respuesta_72,
quiz_realizadas.Respuesta_73,
quiz_realizadas.Respuesta_74,
quiz_realizadas.Respuesta_75,
quiz_realizadas.Respuesta_76,
quiz_realizadas.Respuesta_77,
quiz_realizadas.Respuesta_78,
quiz_realizadas.Respuesta_79,
quiz_realizadas.Respuesta_80,
quiz_realizadas.Respuesta_81,
quiz_realizadas.Respuesta_82,
quiz_realizadas.Respuesta_83,
quiz_realizadas.Respuesta_84,
quiz_realizadas.Respuesta_85,
quiz_realizadas.Respuesta_86,
quiz_realizadas.Respuesta_87,
quiz_realizadas.Respuesta_88,
quiz_realizadas.Respuesta_89,
quiz_realizadas.Respuesta_90,
quiz_realizadas.Respuesta_91,
quiz_realizadas.Respuesta_92,
quiz_realizadas.Respuesta_93,
quiz_realizadas.Respuesta_94,
quiz_realizadas.Respuesta_95,
quiz_realizadas.Respuesta_96,
quiz_realizadas.Respuesta_97,
quiz_realizadas.Respuesta_98,
quiz_realizadas.Respuesta_99,
quiz_realizadas.Respuesta_100



FROM `quiz_realizadas`
LEFT JOIN `quiz_listado`            ON quiz_listado.idQuiz                       = quiz_realizadas.idQuiz
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema                   = quiz_listado.idSistema
LEFT JOIN `core_estados`            ON core_estados.idEstado                     = quiz_listado.idEstado
LEFT JOIN `quiz_escala`  esc_1      ON esc_1.idEscala                            = quiz_listado.idEscala
LEFT JOIN `quiz_escala`  esc_2      ON esc_2.idEscala                            = quiz_listado.Porcentaje_apro
LEFT JOIN `quiz_tipo_evaluacion`    ON quiz_tipo_evaluacion.idTipoEvaluacion     = quiz_listado.idTipoEvaluacion
LEFT JOIN `quiz_tipo_quiz`          ON quiz_tipo_quiz.idTipoQuiz                 = quiz_listado.idTipoQuiz

WHERE quiz_realizadas.idQuizRealizadas = ".$_GET['view'];
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

// Se trae un listado con todas las preguntas
$arrPreguntas = array();
$query = "SELECT
quiz_listado_preguntas.idPregunta, 
quiz_listado_preguntas.Nombre AS Pregunta,
quiz_tipo.Nombre AS Tipo,
quiz_listado_preguntas.Opcion_1,
quiz_listado_preguntas.Opcion_2,
quiz_listado_preguntas.Opcion_3,
quiz_listado_preguntas.Opcion_4,
quiz_listado_preguntas.Opcion_5,
quiz_listado_preguntas.Opcion_6,
quiz_listado_preguntas.OpcionCorrecta,
quiz_listado_preguntas.idCategoria,
quiz_categorias.Nombre AS Categoria

FROM `quiz_listado_preguntas`
LEFT JOIN `quiz_tipo`        ON quiz_tipo.idTipo              = quiz_listado_preguntas.idTipo
LEFT JOIN `quiz_categorias`  ON quiz_categorias.idCategoria   = quiz_listado_preguntas.idCategoria
WHERE quiz_listado_preguntas.idQuiz = ".$_GET['idQuiz']."
ORDER BY quiz_listado_preguntas.idCategoria ASC
";
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
while ( $row = mysqli_fetch_assoc ($resultado)) {
array_push( $arrPreguntas,$row );
}


//cuento las preguntas
$count = 0;
foreach ($arrPreguntas as $preg) {
	$count++;
} 

?>

<div class="row no-print">
	<div class="col-xs-12">
		<a target="new" href="view_quiz_respondida_to_print.php<?php echo '?view='.$_GET['view'].'&idQuiz='.$_GET['idQuiz'] ?>" class="btn btn-default pull-right" style="margin-right: 5px;">
			<i class="fa fa-print" aria-hidden="true"></i> Imprimir
		</a>
	</div>
</div>

<?php if(isset($count)&&$count==0){ ?>
		
	<div class="col-sm-12" style="margin-top:20px;">
		<?php
		$Alert_Text  = 'No tiene preguntas asignadas a la Quiz';
		alert_post_data(4,1,1, $Alert_Text);
		?>
	</div>

<?php } ?>
<div class="clearfix"></div>  


	<div class="col-sm-12">
		<div class="box">	
			<header>		
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Datos Basicos</h5>
			</header>
			<div>
				<div class="table-responsive">    
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<tr>
								<td class="meta-head">Nombre</td>
								<td colspan="3"><?php echo $rowdata['Nombre']?></td>
							</tr>
							<tr>
								<td class="meta-head">Texto Cabecera</td>
								<td colspan="3"><?php echo $rowdata['Header_texto']; ?></td>
							</tr>
							<tr>
								<td class="meta-head">Fecha Cabecera</td>
								<td colspan="3"><?php echo fecha_estandar($rowdata['Header_fecha']); ?></td>
							</tr> 
							<tr>
								<td class="meta-head">Texto Contenido</td>
								<td colspan="3"><?php echo $rowdata['Texto_Inicio']; ?></td>
							</tr>
							<tr>
								<td class="meta-head">Texto Pie Pagina</td>
								<td colspan="3"><?php echo $rowdata['Footer_texto']; ?></td>
							</tr>
							<tr>
								<td class="meta-head">Sistema</td>
								<td><?php echo $rowdata['sistema']; ?></td>
								<td class="meta-head">Estado</td>
								<td><?php echo $rowdata['Estado']; ?></td>
							</tr> 
							<tr>
								<td class="meta-head">Tipo Puntuacion</td>
								<?php
								//Escala
								if(isset($rowdata['idTipoEvaluacion'])&&$rowdata['idTipoEvaluacion']==1){
									echo '<td colspan="3">'.$rowdata['TipoEvaluacion'].' : '.$rowdata['Escala'].'</td>';
								//Porcentaje	
								}else{
									echo '<td colspan="3">'.$rowdata['TipoEvaluacion'].' : '.$rowdata['Aprobado'].'</td>';
								}
								?>
							</tr>
							<tr>
								<td class="meta-head">Tipo Evaluacion</td>
								<?php
								//Cerrada
								if(isset($rowdata['idTipoQuiz'])&&$rowdata['idTipoQuiz']==1){
									echo '<td colspan="3">'.$rowdata['TipoQuiz'].'</td>';
								//Abierta 	
								}else{
									echo '<td colspan="3">'.$rowdata['TipoQuiz'].'</td>';
								}
								?>
							</tr>
							<tr>
								<td class="meta-head">Limite de Tiempo</td>
								<?php
								//Si
								if(isset($rowdata['idLimiteTiempo'])&&$rowdata['idLimiteTiempo']==1){
									echo '<td colspan="3">Limitado a '.$rowdata['Tiempo'].' hrs.</td>';
								//No	
								}else{
									echo '<td colspan="3">Sin Limite de Tiempo</td>';
								}
								?>
							</tr>                  
						</tbody>
					</table>
				</div>
			</div>
		
			
		</div>
	</div>

	<div class="col-sm-12">
		<div class="box">	
			<header>		
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Preguntas</h5>
			</header>
			<div>
				<div class="table-responsive">    
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							
							<?php 
							//Recorro el total de preguntas
							for ($i = 1; $i <= $rowdata['Total_Preguntas']; $i++) {
								/*filtrar($arrPreguntas, 'Categoria');  
							foreach($arrPreguntas as $categoria=>$permisos){ 
								echo '<tr class="odd" ><td colspan="2"  style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
								foreach ($permisos as $preg) { */
								
								foreach ($arrPreguntas as $preg) {
									if($preg['idPregunta']==$rowdata['Pregunta_'.$i]){ ?>
						
										<tr class="item-row linea_punteada">
											<td class="item-name">
												<strong><?php echo $preg['Tipo']; ?> : </strong><?php echo $preg['Pregunta']; ?><br/>	
												<?php
												$resp_correct = 1;
												if(isset($preg['Opcion_1'])&&$preg['Opcion_1']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowdata['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_1'].$r_fin.$tex.'<br/>';$resp_correct++;}
												if(isset($preg['Opcion_2'])&&$preg['Opcion_2']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowdata['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_2'].$r_fin.$tex.'<br/>';$resp_correct++;}
												if(isset($preg['Opcion_3'])&&$preg['Opcion_3']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowdata['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_3'].$r_fin.$tex.'<br/>';$resp_correct++;}
												if(isset($preg['Opcion_4'])&&$preg['Opcion_4']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowdata['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_4'].$r_fin.$tex.'<br/>';$resp_correct++;}
												if(isset($preg['Opcion_5'])&&$preg['Opcion_5']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowdata['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_5'].$r_fin.$tex.'<br/>';$resp_correct++;}
												if(isset($preg['Opcion_6'])&&$preg['Opcion_6']!=''){$tex = '';$r_ini = '';$r_fin = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};if($rowdata['Respuesta_'.$i]==$resp_correct){$r_ini = '<span class="color-green">';$r_fin = '</span>';};echo $r_ini.' - '.$preg['Opcion_6'].$r_fin.$tex.'<br/>';$resp_correct++;}
												?>	
								
											</td>			
										</tr>
									<?php } ?>
								<?php } ?> 
							<?php } ?> 
											  
						</tbody>
					</table>
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

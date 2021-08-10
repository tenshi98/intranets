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
quiz_listado.idLimiteTiempo

FROM `quiz_listado`
LEFT JOIN `core_sistemas`           ON core_sistemas.idSistema                   = quiz_listado.idSistema
LEFT JOIN `core_estados`            ON core_estados.idEstado                     = quiz_listado.idEstado
LEFT JOIN `quiz_escala`  esc_1      ON esc_1.idEscala                            = quiz_listado.idEscala
LEFT JOIN `quiz_escala`  esc_2      ON esc_2.idEscala                            = quiz_listado.Porcentaje_apro
LEFT JOIN `quiz_tipo_evaluacion`    ON quiz_tipo_evaluacion.idTipoEvaluacion     = quiz_listado.idTipoEvaluacion
LEFT JOIN `quiz_tipo_quiz`          ON quiz_tipo_quiz.idTipoQuiz                 = quiz_listado.idTipoQuiz

WHERE quiz_listado.idQuiz = ".$_GET['view'];
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
WHERE quiz_listado_preguntas.idQuiz = ".$_GET['view']."
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
				<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5><?php echo $rowdata['Nombre']?></h5>
			</header>
			<div>
				<div class="table-responsive">    
					<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<tr>
								<td class="meta-head">Texto Cabecera</td>
								<td colspan="3"><?php echo $rowdata['Header_texto']; ?></td>
							</tr>
							<tr>
								<td class="meta-head">Texto Contenido</td>
								<td colspan="3"><?php echo $rowdata['Texto_Inicio']; ?></td>
							</tr>
							<tr>
								<td class="meta-head">Tipo Puntuacion</td>
								<?php
								//Escala
								if(isset($rowdata['idTipoEvaluacion'])&&$rowdata['idTipoEvaluacion']==1){
									echo '<td>'.$rowdata['TipoEvaluacion'].' : '.$rowdata['Escala'].'</td>';
								//Porcentaje	
								}else{
									echo '<td>'.$rowdata['TipoEvaluacion'].' : '.$rowdata['Aprobado'].'</td>';
								}
								?>
								<td class="meta-head">Tipo Evaluacion</td>
								<?php
								//Cerrada
								if(isset($rowdata['idTipoQuiz'])&&$rowdata['idTipoQuiz']==1){
									echo '<td>'.$rowdata['TipoQuiz'].'</td>';
								//Abierta 	
								}else{
									echo '<td>'.$rowdata['TipoQuiz'].'</td>';
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
							
							<?php 
							filtrar($arrPreguntas, 'Categoria');  
							foreach($arrPreguntas as $categoria=>$permisos){ 
								echo '<tr class="odd" ><td colspan="4" style="background-color:#DDD"><strong>'.$categoria.'</strong></td></tr>';
								foreach ($permisos as $preg) { ?>
						
									<tr class="item-row linea_punteada">
										<td class="item-name" colspan="4">
											<strong><?php echo $preg['Tipo']; ?> : </strong><?php echo $preg['Pregunta']; ?><br/>	
											<?php
											$resp_correct = 1;
											$tex2 = '';
											if(isset($preg['Opcion_1'])&&$preg['Opcion_1']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_1'].$tex2.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_2'])&&$preg['Opcion_2']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_2'].$tex2.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_3'])&&$preg['Opcion_3']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_3'].$tex2.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_4'])&&$preg['Opcion_4']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_4'].$tex2.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_5'])&&$preg['Opcion_5']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_5'].$tex2.'<br/>';$resp_correct++;}
											if(isset($preg['Opcion_6'])&&$preg['Opcion_6']!=''){$tex = '';if($preg['OpcionCorrecta']==$resp_correct){$tex = ' <strong>-> correcta</strong>';};echo ' - '.$preg['Opcion_6'].$tex2.'<br/>';$resp_correct++;}
											
											?>	
							
										</td>			
									</tr>
								<?php } ?> 
							<?php } ?> 
							
							<tr>
								<td class="meta-head">Texto Pie Pagina</td>
								<td colspan="3"><?php echo $rowdata['Footer_texto']; ?></td>
							</tr>
											  
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

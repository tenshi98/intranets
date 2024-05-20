<?php
/**********************************************************************************************************************************/
/*                                                   Se define la Sesion                                                          */
/**********************************************************************************************************************************/
$timeout = 604800;                               //Se setea la expiracion a una semana
ini_set( "session.gc_maxlifetime", $timeout );   //Establecer la vida útil máxima de la sesión
ini_set( "session.cookie_lifetime", $timeout );  //Establecer la duración de las cookies de la sesión
session_start();                                 //Iniciar una nueva sesión
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
//Cargamos la ubicacion original
$original = "gestion_tickets.php";
$location = $original;
//Se agregan ubicaciones
$location .='?pagina='.$_GET['pagina'];
//Titulo ventana
$t_dashboard = '<i class="fa fa-handshake-o" aria-hidden="true"></i> Mis Tickets';
/********************************************************************/
//Variables para filtro y paginacion
$search = '';
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){              $location .= "&idEstado=".$_GET['idEstado'];                      $search .= "&idEstado=".$_GET['idEstado'];}
if(isset($_GET['idArea']) && $_GET['idArea']!=''){                  $location .= "&idArea=".$_GET['idArea'];                          $search .= "&idArea=".$_GET['idArea'];}
if(isset($_GET['idTipoTicket']) && $_GET['idTipoTicket']!=''){      $location .= "&idTipoTicket=".$_GET['idTipoTicket'];              $search .= "&idTipoTicket=".$_GET['idTipoTicket'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){        $location .= "&idPrioridad=".$_GET['idPrioridad'];                $search .= "&idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['Titulo']) && $_GET['Titulo']!=''){                  $location .= "&Titulo=".$_GET['Titulo'];                          $search .= "&Titulo=".$_GET['Titulo'];}
if(isset($_GET['FechaCreacion']) && $_GET['FechaCreacion']!=''){    $location .= "&FechaCreacion=".$_GET['FechaCreacion'];            $search .= "&FechaCreacion=".$_GET['FechaCreacion'];}
/**********************************************************************************************************************************/
/*                                          Se llaman a las partes de los formularios                                             */
/**********************************************************************************************************************************/
//formulario para crear
if (!empty($_POST['submit'])){
	//Llamamos al formulario
	$form_trabajo= 'insert';
	require_once 'A1XRXS_sys/xrxs_form/z_crosstech_gestion_tickets.php';
}
//formulario para editar
if (!empty($_POST['submit_edit'])){
	//Llamamos al formulario
	$form_trabajo= 'update';
	require_once 'A1XRXS_sys/xrxs_form/z_crosstech_gestion_tickets.php';
}
//se borra un dato
if (!empty($_GET['del'])){
	//Llamamos al formulario
	$form_trabajo= 'del';
	require_once 'A1XRXS_sys/xrxs_form/z_crosstech_gestion_tickets.php';
}
/**********************************************************************************************************************************/
/*                                         Se llaman a la cabecera del documento html                                             */
/**********************************************************************************************************************************/
require_once 'core/Web.Header.Main.php';
/**********************************************************************************************************************************/
/*                                                   ejecucion de logica                                                          */
/**********************************************************************************************************************************/
//Listado de errores no manejables
if (isset($_GET['created'])){ $error['created'] = 'sucess/Ticket Creado correctamente';}
if (isset($_GET['edited'])){  $error['edited']  = 'sucess/Ticket Modificado correctamente';}
if (isset($_GET['deleted'])){ $error['deleted'] = 'sucess/Ticket Borrado correctamente';}
//Manejador de errores
if(isset($error)&&$error!=''){echo notifications_list($error);}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
if(!empty($_GET['id'])){
// consulto los datos
$query = "SELECT idArea, idPrioridad, Titulo, Descripcion
FROM `crosstech_gestion_tickets`
WHERE idTicket = ".$_GET['id'];
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
$rowdata = mysqli_fetch_assoc ($resultado);

?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Modificacion Ticket</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idArea)){         $x1  = $idArea;         }else{$x1  = $rowdata['idArea'];}
				if(isset($idPrioridad)){    $x2  = $idPrioridad;    }else{$x2  = $rowdata['idPrioridad'];}
				if(isset($Titulo)){         $x3  = $Titulo;         }else{$x3  = $rowdata['Titulo'];}
				if(isset($Descripcion)){    $x4  = $Descripcion;    }else{$x4  = $rowdata['Descripcion'];}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Area Ticket','idArea', $x1, 2, 'idArea', 'Nombre', 'crosstech_gestion_tickets_area', 0, '', $dbConn);
				$Form_Inputs->form_select('Prioridad Ticket','idPrioridad', $x2, 2, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Título', 'Titulo', $x3, 2);
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x4, 2);

				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idCliente', $_SESSION['usuario']['basic_data']['idCliente'], 2);
				$Form_Inputs->form_input_hidden('idTicket', $_GET['id'], 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit_edit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>

			</form>
            <?php widget_validator(); ?>
		</div>
	</div>
</div>

<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}elseif(!empty($_GET['new'])){ ?>

<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-edit" aria-hidden="true"></i></div>
			<h5>Crear Ticket</h5>
		</header>
		<div class="body">
			<form class="form-horizontal" method="post" id="form1" name="form1" autocomplete="off" novalidate>

				<?php
				//Se verifican si existen los datos
				if(isset($idArea)){         $x1  = $idArea;         }else{$x1  = '';}
				if(isset($idPrioridad)){    $x2  = $idPrioridad;    }else{$x2  = '';}
				if(isset($Titulo)){         $x3  = $Titulo;         }else{$x3  = '';}
				if(isset($Descripcion)){    $x4  = $Descripcion;    }else{$x4  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Area Ticket','idArea', $x1, 2, 'idArea', 'Nombre', 'crosstech_gestion_tickets_area', 0, '', $dbConn);
				$Form_Inputs->form_select('Prioridad Ticket','idPrioridad', $x2, 2, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Título', 'Titulo', $x3, 2);
				$Form_Inputs->form_textarea('Descripcion','Descripcion', $x4, 2);

				$Form_Inputs->form_input_hidden('idSistema', $_SESSION['usuario']['basic_data']['idSistema'], 2);
				$Form_Inputs->form_input_hidden('idCliente', $_SESSION['usuario']['basic_data']['idCliente'], 2);
				$Form_Inputs->form_input_hidden('idEstado', 1, 2);
				$Form_Inputs->form_input_hidden('FechaCreacion', fecha_actual(), 2);
				$Form_Inputs->form_input_hidden('idTipoTicket', 1, 2);

				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf0c7; Guardar Cambios" name="submit">
					<a href="<?php echo $location; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-arrow-left" aria-hidden="true"></i> Cancelar y Volver</a>
				</div>
			</form>
			<?php widget_validator(); ?>

		</div>
	</div>
</div>
<?php //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}else{
/**********************************************************/
//paginador de resultados
if(isset($_GET['pagina'])){$num_pag = $_GET['pagina'];} else {$num_pag = 1;}
//Defino la cantidad total de elementos por pagina
$cant_reg = 30;
//resto de variables
if (!$num_pag){$comienzo = 0;$num_pag = 1;} else {$comienzo = ( $num_pag - 1 ) * $cant_reg ;}
/**********************************************************/
//ordenamiento
if(isset($_GET['order_by'])&&$_GET['order_by']!=''){
	switch ($_GET['order_by']) {
		case 'id_asc':              $order_by = 'ORDER BY crosstech_gestion_tickets.idTicket ASC ';        $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Numero Ticket Ascendente';break;
		case 'id_desc':             $order_by = 'ORDER BY crosstech_gestion_tickets.idTicket DESC ';       $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Numero Ticket Descendente';break;
		case 'estado_asc':          $order_by = 'ORDER BY core_estado_ticket.Nombre ASC ';                 $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ticket Ascendente';break;
		case 'estado_desc':         $order_by = 'ORDER BY core_estado_ticket.Nombre DESC ';                $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Estado Ticket Descendente';break;
		case 'area_asc':            $order_by = 'ORDER BY crosstech_gestion_tickets_area.Nombre ASC ';     $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Area Ascendente';break;
		case 'area_desc':           $order_by = 'ORDER BY crosstech_gestion_tickets_area.Nombre DESC ';    $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Area Descendente';break;
		case 'tipo_asc':            $order_by = 'ORDER BY core_tipo_ticket.Nombre ASC ';                   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Tipo Ticket Ascendente';break;
		case 'tipo_desc':           $order_by = 'ORDER BY core_tipo_ticket.Nombre DESC ';                  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Tipo Ticket Descendente';break;
		case 'prioridad_asc':       $order_by = 'ORDER BY core_ot_prioridad.Nombre ASC ';                  $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Prioridad Ticket Ascendente';break;
		case 'prioridad_desc':      $order_by = 'ORDER BY core_ot_prioridad.Nombre DESC ';                 $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Prioridad Ticket Descendente';break;
		case 'titulo_asc':          $order_by = 'ORDER BY crosstech_gestion_tickets.Titulo ASC ';          $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Titulo Ticket Ascendente';break;
		case 'titulo_desc':         $order_by = 'ORDER BY crosstech_gestion_tickets.Titulo DESC ';         $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Titulo Ticket Descendente';break;
		case 'fechacreacion_asc':   $order_by = 'ORDER BY crosstech_gestion_tickets.FechaCreacion ASC ';   $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Fecha Creacion Ticket Ascendente';break;
		case 'fechacreacion_desc':  $order_by = 'ORDER BY crosstech_gestion_tickets.FechaCreacion DESC ';  $bread_order = '<i class="fa fa-sort-alpha-desc" aria-hidden="true"></i> Fecha Creacion Ticket Descendente';break;
						
		default: $order_by = 'ORDER BY crosstech_gestion_tickets.idEstado ASC, crosstech_gestion_tickets.FechaCreacion DESC'; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente, Fecha Creacion Descendente';
	}
}else{
	$order_by = 'ORDER BY crosstech_gestion_tickets.idEstado ASC, crosstech_gestion_tickets.FechaCreacion DESC'; $bread_order = '<i class="fa fa-sort-alpha-asc" aria-hidden="true"></i> Estado Ascendente, Fecha Creacion Descendente';
}
/**********************************************************/
//Variable de busqueda
$z = "WHERE crosstech_gestion_tickets.idTicket!=0";
//sistema
$z.= " AND crosstech_gestion_tickets.idSistema=".$_SESSION['usuario']['basic_data']['idSistema'];
//solo mostrar los tickets propios
$z.= " AND crosstech_gestion_tickets.idCliente=".$_SESSION['usuario']['basic_data']['idCliente'];

/**********************************************************/
//Se aplican los filtros
if(isset($_GET['idEstado']) && $_GET['idEstado']!=''){       $z .= " AND crosstech_gestion_tickets.idEstado=".$_GET['idEstado'];}
if(isset($_GET['idArea']) && $_GET['idArea']!=''){           $z .= " AND crosstech_gestion_tickets.idArea=".$_GET['idArea'];}
if(isset($_GET['idTipoTicket']) && $_GET['idTipoTicket']!=''){      $z .= " AND crosstech_gestion_tickets.idTipoTicket=".$_GET['idTipoTicket'];}
if(isset($_GET['idPrioridad']) && $_GET['idPrioridad']!=''){ $z .= " AND crosstech_gestion_tickets.idPrioridad=".$_GET['idPrioridad'];}
if(isset($_GET['Titulo']) && $_GET['Titulo']!=''){           $z .= " AND crosstech_gestion_tickets.Titulo  LIKE '%".EstandarizarInput($_GET['Titulo'])."%'";}
if(isset($_GET['FechaCreacion']) && $_GET['FechaCreacion']!=''){    $z .= " AND crosstech_gestion_tickets.FechaCreacion='".$_GET['FechaCreacion']."'";}
/**********************************************************/
//Realizo una consulta para saber el total de elementos existentes
$query = "SELECT idTicket FROM `crosstech_gestion_tickets` 
".$z;
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
$cuenta_registros = mysqli_num_rows($resultado);
//Realizo la operacion para saber la cantidad de paginas que hay
$total_paginas = ceil($cuenta_registros / $cant_reg);
// Se trae un listado con todos los elementos
$arrUsers = array();
$query = "SELECT 
crosstech_gestion_tickets.idTicket,
crosstech_gestion_tickets.Titulo,
crosstech_gestion_tickets.FechaCreacion,
crosstech_gestion_tickets.idEstado,

core_sistemas.Nombre AS Sistema,
core_tipo_ticket.Nombre AS TipoTicket,
core_estado_ticket.Nombre AS EstadoTicket,
core_ot_prioridad.Nombre AS PrioridadTicket,
crosstech_gestion_tickets_area.Nombre AS AreaTicket

FROM `crosstech_gestion_tickets`
LEFT JOIN `core_sistemas`                    ON core_sistemas.idSistema                    = crosstech_gestion_tickets.idSistema
LEFT JOIN `core_tipo_ticket`                 ON core_tipo_ticket.idTipoTicket              = crosstech_gestion_tickets.idTipoTicket
LEFT JOIN `core_estado_ticket`               ON core_estado_ticket.idEstado                = crosstech_gestion_tickets.idEstado
LEFT JOIN `core_ot_prioridad`                ON core_ot_prioridad.idPrioridad              = crosstech_gestion_tickets.idPrioridad
LEFT JOIN `crosstech_gestion_tickets_area`   ON crosstech_gestion_tickets_area.idArea      = crosstech_gestion_tickets.idArea

".$z."
".$order_by."
LIMIT $comienzo, $cant_reg ";
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
while ( $row = mysqli_fetch_assoc ($resultado)){
array_push( $arrUsers,$row );
}
//Verifico el tipo de usuario que esta ingresando
$usrfil = 'usuarios_listado.idEstado=1 AND usuarios_listado.idTipoUsuario!=1';
//Verifico el tipo de usuario que esta ingresando
if($_SESSION['usuario']['basic_data']['idTipoUsuario']!=1){
	$usrfil .= " AND usuarios_sistemas.idSistema = ".$_SESSION['usuario']['basic_data']['idSistema'];
}

?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 breadcrumb-bar">

	<ul class="btn-group btn-breadcrumb pull-left">
		<li class="btn btn-default tooltip" role="button" data-toggle="collapse" href="#collapseForm" aria-expanded="false" aria-controls="collapseForm" title="Presionar para desplegar Formulario de Busqueda" style="font-size: 14px;"><i class="fa fa-search faa-vertical animated" aria-hidden="true"></i></li>
		<li class="btn btn-default"><?php echo $bread_order; ?></li>
		<?php if(isset($_GET['filtro_form'])&&$_GET['filtro_form']!=''){ ?>
			<li class="btn btn-danger"><a href="<?php echo $original.'?pagina=1'; ?>" style="color:#fff;"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a></li>
		<?php } ?>
	</ul>

	<a href="<?php echo $location; ?>&new=true" class="btn btn-default pull-right margin_width fmrbtn" ><i class="fa fa-plus" aria-hidden="true"></i> Crear Ticket</a>

</div>
<div class="clearfix"></div>
<div class="collapse col-xs-12 col-sm-12 col-md-12 col-lg-12" id="collapseForm">
	<div class="well">
		<div class="col-xs-12 col-sm-10 col-md-9 col-lg-8 fcenter">
			<form class="form-horizontal" id="form1" name="form1" action="<?php echo $location; ?>" autocomplete="off" novalidate>
				<?php
				//Se verifican si existen los datos
				if(isset($idEstado)){           $x1  = $idEstado;             }else{$x1  = '';}
				if(isset($idArea)){             $x2  = $idArea;               }else{$x2  = '';}
				//if(isset($idTipoTicket)){       $x3  = $idTipoTicket;         }else{$x3  = '';}
				if(isset($idPrioridad)){        $x4  = $idPrioridad;          }else{$x4  = '';}
				if(isset($Titulo)){             $x5  = $Titulo;               }else{$x5  = '';}
				if(isset($FechaCreacion)){      $x6  = $FechaCreacion;        }else{$x6  = '';}

				//se dibujan los inputs
				$Form_Inputs = new Form_Inputs();
				$Form_Inputs->form_select('Estado Ticket','idEstado', $x1, 1, 'idEstado', 'Nombre', 'core_estado_ticket', 0, '', $dbConn);
				$Form_Inputs->form_select('Area Ticket','idArea', $x2, 1, 'idArea', 'Nombre', 'crosstech_gestion_tickets_area', 0, '', $dbConn);
				//$Form_Inputs->form_select('Tipo Ticket','idTipoTicket', $x3, 1, 'idTipoTicket', 'Nombre', 'core_tipo_ticket', 0, '', $dbConn);
				$Form_Inputs->form_select('Prioridad Ticket','idPrioridad', $x4, 1, 'idPrioridad', 'Nombre', 'core_ot_prioridad', 0, '', $dbConn);
				$Form_Inputs->form_input_text('Título', 'Titulo', $x5, 1);
				$Form_Inputs->form_date('Fecha Creacion','FechaCreacion', $x6, 1);

				$Form_Inputs->form_input_hidden('pagina', 1, 1);
				?>

				<div class="form-group">
					<input type="submit" class="btn btn-primary pull-right margin_form_btn fa-input" value="&#xf002; Filtrar" name="filtro_form">
					<a href="<?php echo $original.'?pagina=1'; ?>" class="btn btn-danger pull-right margin_form_btn"><i class="fa fa-trash-o" aria-hidden="true"></i> Limpiar</a>
				</div>

			</form>
            <?php widget_validator(); ?>
        </div>
	</div>
</div>
<div class="clearfix"></div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	<div class="box">
		<header>
			<div class="icons"><i class="fa fa-table" aria-hidden="true"></i></div><h5>Listado de Tickets</h5>
			<div class="toolbar">
				<?php
				//Se llama al paginador
				echo paginador_2('pagsup',$total_paginas, $original, $search, $num_pag ) ?>
			</div>
		</header>
		<div class="table-responsive">
			<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped dataTable">
				<thead>
					<tr role="row">
						<th>
							<div class="pull-left">#</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=id_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=id_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Estado</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=estado_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=estado_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Area</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=area_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=area_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Tipo Ticket</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=tipo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=tipo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Prioridad</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=prioridad_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=prioridad_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Titulo</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=titulo_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=titulo_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th>
							<div class="pull-left">Fecha Creacion</div>
							<div class="btn-group pull-right" style="width: 50px;" >
								<a href="<?php echo $location.'&order_by=fechacreacion_asc'; ?>" title="Ascendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-asc" aria-hidden="true"></i></a>
								<a href="<?php echo $location.'&order_by=fechacreacion_desc'; ?>" title="Descendente" class="btn btn-default btn-xs tooltip"><i class="fa fa-sort-alpha-desc" aria-hidden="true"></i></a>
							</div>
						</th>
						<th width="10">Acciones</th>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php foreach ($arrUsers as $usuarios){ ?>
						<tr class="odd">
							<td><?php echo n_doc($usuarios['idTicket'], 8); ?></td>
							<td>
								<?php
								//variable con el color
								$est_color = '';
								switch ($usuarios['idEstado']) {
									case 1: $est_color = 'label-success'; break; //abierto
									case 2: $est_color = 'label-info'; break; //cerrado
									case 3: $est_color = 'label-danger'; break; //cancelado
								}
								echo '<label class="label '.$est_color.'">'.$usuarios['EstadoTicket'].'</label>'; 
								?>
							</td>
							<td><?php echo $usuarios['AreaTicket']; ?></td>
							<td><?php echo $usuarios['TipoTicket']; ?></td>
							<td><?php echo $usuarios['PrioridadTicket']; ?></td>
							<td><?php echo $usuarios['Titulo']; ?></td>
							<td><?php echo fecha_estandar($usuarios['FechaCreacion']); ?></td>
							<td>
								<div class="btn-group" style="width: 105px;" >
									<a href="<?php echo 'view_crosstech_gestion_tickets.php?view='.$usuarios['idTicket']; ?>" title="Ver Información" class="iframe btn btn-primary btn-sm tooltip"><i class="fa fa-list" aria-hidden="true"></i></a>
									<a href="<?php echo $location.'&id='.$usuarios['idTicket']; ?>" title="Editar Información" class="btn btn-success btn-sm tooltip"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php /* 
										$ubicacion = $location.'&del='.simpleEncode($usuarios['idTicket'], fecha_actual());
										$dialogo   = '¿Realmente deseas eliminar el ticket N°'. n_doc($usuarios['idTicket'], 8).'?'; ?>
										<a onClick="dialogBox('<?php echo $ubicacion ?>', '<?php echo $dialogo ?>')" title="Borrar Información" class="btn btn-metis-1 btn-sm tooltip"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php */ ?>
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

<?php } ?>

<?php
/**********************************************************************************************************************************/
/*                                             Se llama al pie del documento html                                                 */
/**********************************************************************************************************************************/
require_once 'core/Web.Footer.Main.php';

?>

<?php

//Creacion del menu
echo '<ul class="nav navbar-nav" id="navbar_nav" >
		<li><a href="principal.php">          <i class="fa fa-dashboard" aria-hidden="true"></i> Principal</a></li>
		<li><a href="principal_datos.php">    <i class="fa fa-address-card-o" aria-hidden="true"></i> Mis Datos</a></li>';
	
	//Solo si existe un plan seleccionado se muestran estas opciones del menu	
	if(isset($_SESSION['usuario']['basic_data']['idPlan'])&&$_SESSION['usuario']['basic_data']['idPlan']!=0){
		echo '<li><a href="principal_contratos.php">Mis Contratos</a></li>';
		echo '<li><a href="apoderados_listado_hijos.php?pagina=1">Mis Hijos</a></li>';
		echo '<li><a href="apoderados_listado_subcuentas.php?pagina=1">Mis Subcuentas</a></li>';
		echo '<li><a href="principal_facturaciones.php?pagina=1">Mis Facturaciones</a></li>';
		
	}
	
	
	
	//Submenu Informes
	/*echo '<li class="dropdown">';
		echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown">Informes <i class="fa fa-angle-down fright margin_width" aria-hidden="true"></i></a>';
		echo '<ul class="dropdown-menu">';
			//echo '<li><a href="informe_vehiculos_01.php?pagina=1">Informe Costos</a></li>';
		echo '</ul>';  
	echo '</li>';*/
	
	                          
echo '</ul>'; 
              
?>

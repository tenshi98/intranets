<?php
/*******************************************************************************************************************/
/*                                              Bloque de seguridad                                                */
/*******************************************************************************************************************/
if( ! defined('XMBCXRXSKGC')) {
    die('No tienes acceso a esta carpeta o archivo2.');
}
/*******************************************************************************************************************/
/*                                        Se traspasan los datos a variables                                       */
/*******************************************************************************************************************/

	//Traspaso de valores input a variables
	if ( !empty($_POST['idApoderado']) )                 $idApoderado                  = $_POST['idApoderado'];
	if ( !empty($_POST['idSistema']) )                   $idSistema                    = $_POST['idSistema'];
	if ( !empty($_POST['idEstado']) )                    $idEstado                     = $_POST['idEstado'];
	if ( !empty($_POST['Nombre']) )                      $Nombre                       = $_POST['Nombre'];
	if ( !empty($_POST['ApellidoPat']) )                 $ApellidoPat                  = $_POST['ApellidoPat'];
	if ( !empty($_POST['ApellidoMat']) )                 $ApellidoMat                  = $_POST['ApellidoMat'];
	if ( !empty($_POST['Fono1']) )                       $Fono1                        = $_POST['Fono1'];
	if ( !empty($_POST['Fono2']) )                       $Fono2                        = $_POST['Fono2'];
	if ( !empty($_POST['FNacimiento']) )                 $FNacimiento                  = $_POST['FNacimiento'];
	if ( !empty($_POST['Rut']) )                         $Rut                          = $_POST['Rut'];
	if ( !empty($_POST['idCiudad']) )                    $idCiudad                     = $_POST['idCiudad'];
	if ( !empty($_POST['idComuna']) )                    $idComuna                     = $_POST['idComuna'];
	if ( !empty($_POST['Direccion']) )                   $Direccion                    = $_POST['Direccion'];
	if ( !empty($_POST['F_Inicio_Contrato']) )           $F_Inicio_Contrato            = $_POST['F_Inicio_Contrato'];
	if ( !empty($_POST['F_Termino_Contrato']) )          $F_Termino_Contrato           = $_POST['F_Termino_Contrato'];
	if ( !empty($_POST['Password']) )                    $Password                     = $_POST['Password'];
	if ( !empty($_POST['dispositivo']) )                 $dispositivo                  = $_POST['dispositivo'];
	if ( !empty($_POST['IMEI']) )                        $IMEI                         = $_POST['IMEI'];
	if ( !empty($_POST['GSM']) )                         $GSM                          = $_POST['GSM'];
	if ( !empty($_POST['GeoLatitud']) )                  $GeoLatitud                   = $_POST['GeoLatitud'];
	if ( !empty($_POST['GeoLongitud']) )                 $GeoLongitud                  = $_POST['GeoLongitud'];
	if ( !empty($_POST['idOpciones_1']) )                $idOpciones_1                 = $_POST['idOpciones_1'];
	if ( !empty($_POST['idOpciones_2']) )                $idOpciones_2                 = $_POST['idOpciones_2'];
	if ( !empty($_POST['idOpciones_3']) )                $idOpciones_3                 = $_POST['idOpciones_3'];
	if ( !empty($_POST['idOpciones_4']) )                $idOpciones_4                 = $_POST['idOpciones_4'];
	if ( !empty($_POST['idOpciones_5']) )                $idOpciones_5                 = $_POST['idOpciones_5'];
	if ( !empty($_POST['Ultimo_acceso']) )               $Ultimo_acceso                = $_POST['Ultimo_acceso'];
	if ( !empty($_POST['IP_Client']) )                   $IP_Client                    = $_POST['IP_Client'];
	if ( !empty($_POST['Agent_Transp']) )                $Agent_Transp                 = $_POST['Agent_Transp'];
	if ( !empty($_POST['email']) )                       $email                        = $_POST['email'];
	if ( !empty($_POST['repassword']) )                  $repassword                   = $_POST['repassword'];
	if ( !empty($_POST['oldpassword']) )                 $oldpassword                  = $_POST['oldpassword'];
	
	if ( !empty($_POST['idPlan']) )                      $idPlan                       = $_POST['idPlan'];
	if ( !empty($_POST['idCobro']) )                     $idCobro                      = $_POST['idCobro'];
	if ( !empty($_POST['idPlanOld']) )                   $idPlanOld                    = $_POST['idPlanOld'];
	if ( !empty($_POST['idCobroOld']) )                  $idCobroOld                   = $_POST['idCobroOld'];
	
		
/*******************************************************************************************************************/
/*                                      Verificacion de los datos obligatorios                                     */
/*******************************************************************************************************************/

	//limpio y separo los datos de la cadena de comprobacion
	$form_obligatorios = str_replace(' ', '', $_SESSION['form_require']);
	$INT_piezas = explode(",", $form_obligatorios);
	//recorro los elementos
	foreach ($INT_piezas as $INT_valor) {
		//veo si existe el dato solicitado y genero el error
		switch ($INT_valor) {
			case 'idApoderado':                 if(empty($idApoderado)){                  $error['idApoderado']                  = 'error/No ha ingresado el id';}break;
			case 'idSistema':                   if(empty($idSistema)){                    $error['idSistema']                    = 'error/No ha seleccionado el sistema al cual pertenece';}break;
			case 'idEstado':                    if(empty($idEstado)){                     $error['idEstado']                     = 'error/No ha seleccionado el estado';}break;
			case 'Nombre':                      if(empty($Nombre)){                       $error['Nombre']                       = 'error/No ha ingresado el nombre de la persona';}break;
			case 'ApellidoPat':                 if(empty($ApellidoPat)){                  $error['ApellidoPat']                  = 'error/No ha ingresado el apellido paterno de la persona';}break;
			case 'ApellidoMat':                 if(empty($ApellidoMat)){                  $error['ApellidoMat']                  = 'error/No ha ingresado el apellido materno de la persona';}break;
			case 'Fono1':                       if(empty($Fono1)){                        $error['Fono1']                        = 'error/No ha ingresado el Fono1 a desempeñar';}break;
			case 'Fono2':                       if(empty($Fono2)){                        $error['Fono2']                        = 'error/No ha ingresado el Fono2';}break;
			case 'FNacimiento':                 if(empty($FNacimiento)){                  $error['FNacimiento']                  = 'error/No ha ingresado la fecha de nacimiento';}break;
			case 'Rut':                         if(empty($Rut)){                          $error['Rut']                          = 'error/No ha ingresado el rut';}break;
			case 'idCiudad':                    if(empty($idCiudad)){                     $error['idCiudad']                     = 'error/No ha seleccionado la ciudad';}break;
			case 'idComuna':                    if(empty($idComuna)){                     $error['idComuna']                     = 'error/No ha seleccionado la comuna';}break;
			case 'Direccion':                   if(empty($Direccion)){                    $error['Direccion']                    = 'error/No ha ingresado la direccion';}break;
			case 'F_Inicio_Contrato':           if(empty($F_Inicio_Contrato)){            $error['F_Inicio_Contrato']            = 'error/No ha ingresado la fecha de inicio';}break;
			case 'F_Termino_Contrato':          if(empty($F_Termino_Contrato)){           $error['F_Termino_Contrato']           = 'error/No ha ingresado la fecha de termino';}break;
			case 'Password':                    if(empty($Password)){                     $error['Password']                     = 'error/No ha ingresado la password';}break;
			case 'dispositivo':                 if(empty($dispositivo)){                  $error['dispositivo']                  = 'error/No ha ingresado el dispositivo utilizado';}break;
			case 'IMEI':                        if(empty($IMEI)){                         $error['IMEI']                         = 'error/No ha ingresado el imei del equipo';}break;
			case 'GSM':                         if(empty($GSM)){                          $error['GSM']                          = 'error/No ha ingresado el gsm del equipo';}break;
			case 'GeoLatitud':                  if(empty($GeoLatitud)){                   $error['GeoLatitud']                   = 'error/No ha ingresado la latitud del equipo';}break;
			case 'GeoLongitud':                 if(empty($GeoLongitud)){                  $error['GeoLongitud']                  = 'error/No ha ingresado la longitud del equipo';}break;
			case 'idOpciones_1':                if(empty($idOpciones_1)){                 $error['idOpciones_1']                 = 'error/No ha ingresado la opcion 1';}break;
			case 'idOpciones_2':                if(empty($idOpciones_2)){                 $error['idOpciones_2']                 = 'error/No ha ingresado la opcion 2';}break;
			case 'idOpciones_3':                if(empty($idOpciones_3)){                 $error['idOpciones_3']                 = 'error/No ha ingresado la opcion 3';}break;
			case 'idOpciones_4':                if(empty($idOpciones_4)){                 $error['idOpciones_4']                 = 'error/No ha ingresado la opcion 4';}break;
			case 'idOpciones_5':                if(empty($idOpciones_5)){                 $error['idOpciones_5']                 = 'error/No ha ingresado la opcion 5';}break;
			case 'Ultimo_acceso':               if(empty($Ultimo_acceso)){                $error['Ultimo_acceso']                = 'error/No ha ingresado el ultimo acceso';}break;
			case 'IP_Client':                   if(empty($IP_Client)){                    $error['IP_Client']                    = 'error/No ha ingresado el IP del cliente';}break;
			case 'Agent_Transp':                if(empty($Agent_Transp)){                 $error['Agent_Transp']                 = 'error/No ha ingresado el agente de transferencia';}break;
			case 'email':                       if(empty($email)){                        $error['email']                        = 'error/No ha ingresado el email';}break;
			case 'repassword':                  if(empty($repassword)){                   $error['repassword']                   = 'error/No ha ingresado la repeticion de la clave';}break;
			case 'oldpassword':                 if(empty($oldpassword)){                  $error['oldpassword']                  = 'error/No ha ingresado su clave antigua';}break;
			
			case 'idPlan':                      if(empty($idPlan)){                       $error['idPlan']                       = 'error/No ha Seleccionado el plan';}break;
			case 'idCobro':                     if(empty($idCobro)){                      $error['idCobro']                      = 'error/No ha Seleccionado el modo de cobro';}break;
			case 'idPlanOld':                   if(empty($idPlanOld)){                    $error['idPlanOld']                    = 'error/No ha Seleccionado el plan';}break;
			case 'idCobroOld':                  if(empty($idCobroOld)){                   $error['idCobroOld']                   = 'error/No ha Seleccionado el modo de cobro';}break;
			
		}
	}
/*******************************************************************************************************************/
/*                                        Verificacion de los datos ingresados                                     */
/*******************************************************************************************************************/	
	//Verifica si el mail corresponde
	if(isset($Fono1)&&!validarNumero($Fono1)) { $error['Fono1']   = 'error/Ingrese un numero telefonico valido'; }
	if(isset($Fono2)&&!validarNumero($Fono2)) { $error['Fono2']   = 'error/Ingrese un numero telefonico valido'; }
	if(isset($email)&&!validarEmail($email)){   $error['email']   = 'error/El Email ingresado no es valido'; }	
	if(isset($Rut)&&!validarRut($Rut)){         $error['Rut']     = 'error/El Rut ingresado no es valido'; }
	if(isset($Password)&&isset($repassword)){
		if ( $Password <> $repassword )                  $error['Password']  = 'error/Las contraseñas ingresadas no coinciden'; 
	}
	if(isset($Password)){
		if (strpos($Password, " ")){                     $error['Password1'] = 'error/La contraseña contiene espacios vacios';}
	}
	
/*******************************************************************************************************************/
/*                                            Se ejecutan las instrucciones                                        */
/*******************************************************************************************************************/
	//ejecuto segun la funcion
	switch ($form_trabajo) {
/*******************************************************************************************************************/		
		case 'updatePlan':
			
			// si no hay errores ejecuto el codigo	
			if ( empty($error) ) {
				
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
					
					//guardo temporalmente los datos del formulario
					$_SESSION['plan']['idPlan']       = $idPlan;
					$_SESSION['plan']['idCobro']      = $idCobro;
					//$_SESSION['plan']['idApoderado']  = $idApoderado;
					
					//Obtengo los valores del plan seleccionado
					$rowPlan = db_select_data (false, 'Valor_Mensual, Valor_Anual', 'sistema_planes_transporte', '', 'idPlan='.$idPlan, $dbConn, $_SESSION['usuario']['basic_data']['Nombre'], $original, $form_trabajo);
					
					//Se crea un registro de facturacion ya pagado
					switch ($idCobro) {
						//Mensual
						case 1:
							$montoPago     = ($rowPlan['Valor_Mensual']/30)*$DiasDisponibles;
							break;
						//Anual
						case 2:
							$montoPago     = ($rowPlan['Valor_Anual']/10)*$MesesDisponibles;
							break;
					}
					
					//Elimino los datos previos del form
					unset($_SESSION['form_require']);
		
					/*******************************************************************/
					//Proceso a pago
					$_SESSION['trbnk']['montoPago']    = $montoPago;
					$_SESSION['trbnk']['buyOrder']     = genera_password_unica();
					
					//redireccion a transbank
					header( 'Location: ./transbank/test_inicio.php' );
					die;
					
				}
				
			}
		break;		
/*******************************************************************************************************************/
	}
?>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php

//Adicionar Información Integrantes de la Familia

//Inicializa las variables de sesión
session_start();

//Validación de Ingreso
include ("../verificaIngreso2.php");

//Abre la conexión a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();


//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	//Obtener el Máximo consecutivo de CSEFichaIntegrantesFamilia	
	$sqlSec	= "SELECT MAX(consecAct) MaxCodigo FROM CSCPFichaFamiliaComercial";
	$cursorSec = mssql_query($sqlSec);
	if ($regSec=mssql_fetch_array($cursorSec)) 
	{
		$pSig = $regSec[MaxCodigo] + 1;
	}
	else 
	{
		$pSig = 1;
	}
	
	
	if($dia!=""){
	$fechaFormat = "'".Genera_Fecha_DB($dia, $mes, $ano)."'";
	}
	else{
		$fechaFormat = "NULL";
	}
		
	$qry = "INSERT INTO CSCPFichaFamiliaComercial ( 
				codProyecto, codModulo, numFormulario, consecutivo, nroPredio, nroVivienda, nroFamilia, consecAct
				, codItemTipoAct, hayCamaraCom, hayRUT
				, codigoRUT, codItemTempAct, codItemJornada, valorMobiliario, numEmpSexoM, numEmpSexoF, numEmpTempP
				, numEmpTempO, numEmpRemF, numEmpRemR, valorGastos, valorIngresos, valorInventario, codItemOrigen
				, fechaGraba, usuarioGraba 
			)";	

	$qry = $qry. " VALUES( ";
	$qry = $qry. "'".$_SESSION["ccfProyecto"]."', ";
	$qry = $qry. "'".$_SESSION["ccfModulo"]."', ";
	$qry = $qry. "'".$_SESSION["ccfFormulario"]."', ";
	$qry = $qry. "'".$_SESSION["ccfConsecutivo"]."', ";
	$qry = $qry. "'".$_SESSION["ccfPredio"]."', ";
	$qry = $qry. "'".$_SESSION["ccfVivienda"]."', ";
	$qry = $qry. "'".$_SESSION["ccfFamilia"]."', ";
	$qry = $qry. $pSig .",";
	$qry = $qry. $tpActividad .",";
	$qry = $qry. $cComercio .",";
	$qry = $qry. $rut .",";
	if( $rut == 1 )
		$qry = $qry."'".$cRUT."',";
	else
		$qry = $qry."NULL,";
	$qry = $qry. $temporalidad .",";
	$qry = $qry. $jornada .",";
	$qry = $qry. $vMobiliario .",";
	$qry = $qry. $hombre .",";
	$qry = $qry. $mujer .",";
	$qry = $qry. $personal .",";
	$qry = $qry. $ocacional .",";
	$qry = $qry. $familiar .",";
	$qry = $qry. $rem .",";
	$qry = $qry. $vGastos .",";
	$qry = $qry. $vIngresos .",";
	$qry = $qry. $vEnvio .",";
	$qry = $qry. $origen .",";
	$qry = $qry. " '" . gmdate("n/d/y") ."', ";
	$qry = $qry. " '".$_SESSION["ccfUsuID"]."') " ;	
	#echo $qry;
	//exit;
	$cursorIn = mssql_query( $qry );

	if  (trim($cursorIn) != "")  
			echo ("<script>alert('La grabación se realizó con éxito.');</script>");
	else 
		echo ("<script>alert('Error durante la grabación');</script>");

	$volverA = "";
	$volverA=Genera_Pagina($Opc,$pag);	
	#/*
	echo "<script>
			window.close();
			MM_openBrWindow('frmCensoFamiliaActComercial.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
		  </script>";
	#*/
}


?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) 
{ //v2.0
  window.open(theURL,winName,features);
}

//-->
</script>

<SCRIPT language=JavaScript>
<!--

function envia2(){ 
	//alert( 'fine' );
	var v1,v2,v3, v4,v5,v7,v8,v9,v10, v11, v12, v13, v14, v15, v16, v17, i, CantCampos;
	var msg1, msg2, msg3, msg4, msg5, msg7, msg8, msg9, msg10, msg11, msg12, msg13, msg15, msg16, msg17, mensaje;
	v1 = v2 = v3 = v4 = v5 = v7 = v8 = v9 = v10 ='s';
	v11 = v12 = v13 = v14 ='s';
	v15 = v16 = v17 = 's';
	msg1 = msg2 = msg3 = msg4 = '';
	msg5 = msg7 = msg8 = msg9 = '';
	msg10 = msg11 = msg12 = msg13 = msg14 = msg15 = msg16 = msg17 = '';
	mensaje = '';
//*	
	if (document.form1.tpActividad.value == '') {
		v1='n';
		msg1 = 'El tipo de actividad es obligatorio. \n'
	}
	//alert( "Valor check : " + document.getElementById('rut').checked );
	if ( ( document.getElementById('rut').checked == true ) && (document.form1.cRUT.value == '') ) {
		v2='n';
		msg2 = 'El codigo RUT es obligatorio. \n'
	}
	if (document.form1.temporalidad.value == '') {
		v3='n';
		msg3 = 'La temporalidad es obligatorio. \n'
	}
	if (document.form1.jornada.value == '') {
		v4='n';
		msg4 = 'La jornada es obligatorio. \n'
	}
	if (document.form1.vMobiliario.value == '') {
		v5='n';
		msg5 = 'El valor de mobiliario es obligatorio. \n'
	}

	if (document.form1.hombre.value == '') {
		v7='n';
		msg7 = 'La cantidad de hombres es obligatorio. \n'
	}
	if (document.form1.mujer.value == '') {
		v8='n';
		msg8 = 'La cantidad de mujeres es obligatorio. \n'
	}
	if (document.form1.personal.value == '') {
		v9='n';
		msg9 = 'La cantidad de personas es obligatorio. \n'
	}
	if (document.form1.ocacional.value == '') {
		v10='n';
		msg10 = 'La cantidad de personas ocacionales es obligatorio. \n'
	}
//	tpActividad cComercio rut cRUT temporalidad jornada vMobiliario valor hombre mujer personal ocacional familiar rem vGastos vIngresos vEnvio origen 

	if (document.form1.familiar.value == '') {
		v11='n';
		msg11 = 'La cantidad de familiares es obligatorio. \n'
	}
	if (document.form1.rem.value == '') {
		v12='n';
		msg12 = 'La cantidad de remanentes es obligatorio. \n'
	}
	if (document.form1.vGastos.value == '') {
		v13='n';
		msg13 = 'El valor de los gastos es obligatorio. \n'
	}
	if (document.form1.vIngresos.value == '') {
		v14='n';
		msg14 = 'El valor de los ingresos es obligatorio. \n'
	}
	if (document.form1.vEnvio.value == '') {
		v15='n';
		msg15 = 'El valor del envío es obligatorio. \n'
	}
	if (document.form1.origen.value == '') {
		v16='n';
		msg16 = 'El origen es obligatorio. \n'
	}
//*/
	//	      
	if( ( ( parseFloat(document.form1.hombre.value) +  parseFloat(document.form1.mujer.value) ) != ( parseFloat(document.form1.personal.value) +  parseFloat(document.form1.ocacional.value) ) ) 
		|| ( ( parseFloat(document.form1.hombre.value) +  parseFloat(document.form1.mujer.value) ) != ( parseFloat(document.form1.familiar.value) +  parseFloat(document.form1.rem.value) ) ) ){
		v17 = 'n';
		msg17 = 'La suma del número de empleados en Sexo, Temporalidad y Remuneración, deben ser equivalentes.\n'
	}
	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s') && (v5=='s') && (v7=='s')&& (v8=='s')&& 
		(v9=='s')&& (v10=='s')&& (v11=='s') && (v12=='s')&& (v13=='s')&& (v14=='s') && (v15=='s')&& (v16=='s')&& (v17=='s') ) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 + msg4 + msg5 + msg7 + msg8+msg9 + msg10 + msg11 + msg12 + msg13 + msg14 + msg15 + msg16 + msg17;
		alert (mensaje);
	}	
}
function habilita(){
	if( document.getElementById('rut').checked == true )
		document.getElementById('cRUT').readOnly = false;
	else{
		document.getElementById('cRUT').readOnly = true;
		document.getElementById('cRUT').value = "";
	}
	
}
//-->
function keyNum(){ //	input
	if ( event.keyCode < 48 || event.keyCode > 57) 
		event.returnValue = false	
}
//	keyNumG
function keyNumG(){ //	input
	if ( event.keyCode < 48 || event.keyCode > 57 ) 
		event.returnValue = false;
	if( event.keyCode == 45 )
		event.returnValue = true;
}

function keyLetter(){ //	input
	if ( ( event.keyCode < 65 || event.keyCode > 90 ) && ( event.keyCode < 97 || event.keyCode > 122 ) ) 
		event.returnValue = false;
	if ( ( event.keyCode == 32 ) || ( event.keyCode == 164 ) || ( event.keyCode == 165 ) )
		event.returnValue = true;
}

</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
<form name="form1" method="post" action="">

<tr>
<td bgcolor="#FFFFFF">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>
    
    <!-- TITULO GENERAL -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td class="TituloTabla" align="center">Actividad Comercial</td>
      	</tr>
    </table>

	<? //Búsqueda de los ítems para cada pregunta
		#$sqlItem = "SELECT * FROM tmItems";
		
		#	Temporalidad de la actividad
		$sqlIt1 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 99";
		$qr1 = mssql_query( $sqlIt1 );
		
		#	Jornada de atencion
		$sqlIt2 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 98";
		$qr2 = mssql_query( $sqlIt2 );
		
		#	Origen
		$sqlIt3 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 100";
		$qr3 = mssql_query( $sqlIt3 );
		
		#	Tp aCTIVIDAD
		$sqlIt4 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 97";
		$qr4 = mssql_query( $sqlIt4 );	
		
	?>
	<!-- Tabla de datos -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
		<td width="30%" class="TituloTabla1">Tipo actividad</td>
	    <td colspan="3" class="TxtTabla">
        <select name="tpActividad" id="tpActividad" class="CajaTexto" >
        <option>:::Seleccione opción:::</option>
		<? while( $rw4 = mssql_fetch_array( $qr4 ) ){ 
			$sel = "";
			if( $rw4[codItem] == $tpActividad )
				$sel = "selected";
		?>
			<option value="<?= $rw4[codItem] ?>" <?= $sel ?> ><?= $rw4[nomItem] ?></option>
        <? } ?>
        
        </select></td>
	  </tr>
	  <tr>
	    <td width="30%" class="TituloTabla1">Camara de Comercio</td>
	    <td colspan="3" class="TxtTabla"> 
        Si <input type="radio" name="cComercio" id="cComercio" value="1" />
        No <input type="radio" name="cComercio" id="cComercio" value="0" checked />
        </td>
	  </tr>
	  <tr>
	    <td class="TituloTabla1"> RUT</td>
	    <td colspan="3" class="TxtTabla">
        Si <input type="radio" name="rut" id="rut" value="1" onClick="habilita();" />
        No <input type="radio" name="rut" id="rut" value="0" onClick="habilita();" checked /></td>
	    </tr>
	  <tr> 
	    <td class="TituloTabla1">Codigo RUT</td>
	    <td colspan="3" class="TxtTabla"> 
        <input name="cRUT" type="text" class="CajaTexto" id="cRUT" value="<? echo $cRUT; ?>" size="50" onKeyPress="keyNumG();" maxlength="9" readonly />
        </td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Temporalidad de la actividad</td>
	    <td colspan="3" class="TxtTabla"><select name="temporalidad" id="temporalidad" class="CajaTexto" >
	      <option>:::Seleccione opci&oacute;n:::</option>
	      <? while( $rw1 = mssql_fetch_array( $qr1 ) ){ 
				$sel = "";
				if( $rw1[codItem] == $temporalidad )
					$sel = "selected";

		  ?>
	      <option value="<?= $rw1[codItem] ?>" <?= $sel ?> ><?= $rw1[nomItem] ?></option>
	      <? } ?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Jornada de atenci&oacute;n</td>
	    <td colspan="3" class="TxtTabla">
	      <select name="jornada" id="jornada" class="CajaTexto" >
	        <option>:::Seleccione opci&oacute;n:::</option>
	        <? 
		  	while( $rw2 = mssql_fetch_array( $qr2 ) ){ 
				$sel = "";
				if( $rw2[codItem] == $jornada )
					$sel = "selected";
		  ?>
	        <option value="<?= $rw2[codItem] ?>" <?= $sel ?> ><?= $rw2[nomItem] ?></option>
	        <? } ?>
	        </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Valor del mobiliario</td>
	    <td colspan="3" class="TxtTabla">
        <input name="vMobiliario" type="text" class="CajaTexto" id="vMobiliario" value="<? echo $vMobiliario; ?>" size="50" onKeyPress="keyNum();" maxlength="11" />
        </td>
	    </tr>
	  <tr>
	    <td rowspan="6" valign="top" class="TituloTabla1">Numero de empleados</td>
	    <td rowspan="2" class="TituloTabla1">Sexo</td>
	    <td class="TituloTabla1">Hombre</td>
	    <td class="TxtTabla"><input name="hombre" type="text" class="CajaTexto" id="hombre" value="<? echo $hombre; ?>" size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Mujer</td>
	    <td class="TxtTabla"><input name="mujer" type="text" class="CajaTexto" id="mujer" value="<? echo $mujer; ?>" size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td rowspan="2" class="TituloTabla1">Temporal</td>
	    <td class="TituloTabla1">Personal</td>
	    <td class="TxtTabla"><input name="personal" type="text" class="CajaTexto" id="personal" value="<? echo $personal; ?>" size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Ocasional</td>
	    <td class="TxtTabla"><input name="ocacional" type="text" class="CajaTexto" id="ocacional" value="<? echo $ocacional; ?>" size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td rowspan="2" class="TituloTabla1"><p>Remanentes</p>
	      <p>&nbsp;</p></td>
	    <td class="TituloTabla1">Familiar</td>
	    <td class="TxtTabla"><input name="familiar" type="text" class="CajaTexto" id="familiar" value="<? echo $familiar; ?>" size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Remunerados</td>
	    <td class="TxtTabla"><input name="rem" type="text" class="CajaTexto" id="rem" value="<? echo $rem; ?>" size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Ingresos durante el ultimo mes (valor ventas)</td>
	    <td colspan="3" class="TxtTabla"><input name="vIngresos" type="text" class="CajaTexto" id="vIngresos" value="<? echo $vIngresos; ?>" size="50" onKeyPress="keyNum();" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Gastos del negocio durante el ultimo mes</td>
	    <td colspan="3" class="TxtTabla"> 
        <input name="vGastos" type="text" class="CajaTexto" id="vGastos" value="<? echo $vGastos; ?>" size="50" onKeyPress="keyNum();" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Valor del inventario inventario a la fecha de la entrevista</td>
	    <td colspan="3" class="TxtTabla">
	      <input name="vEnvio" type="text" class="CajaTexto" id="vEnvio" value="<? echo $vEnvio; ?>" size="50" onKeyPress="keyNum();"  />
	      </td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Origen</td>
	    <td colspan="3" class="TxtTabla"><select name="origen" id="origen" class="CajaTexto" >
	      <option>:::Seleccione opci&oacute;n:::</option>
	      <? while( $rw3 = mssql_fetch_array( $qr3 ) ){ 
				$sel = "";
				if( $rw3[codItem] == $origen )
					$sel = "selected";
		  ?>
	      <option value="<?= $rw3[codItem] ?>" <?= $sel ?> ><?= $rw3[nomItem] ?></option>
	      <? } ?>
	      </select></td>
	    </tr>
	  </table>
 
    <!-- ESPACIO -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
        <tr>
            <td height="10"> </td>
        </tr>
    </table>

	<!-- BOTONES DE GRABAR -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="recarga" type="hidden" id="recarga" value="1">       
			<input name="Submit2" type="button" class="Boton" value="Grabar" onClick="envia2()">
        </td>
      </tr>
    </table>	
    
	<!-- ESPACIO -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

	<!-- INGETEC-->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="copyr"> powered by INGETEC S.A - 2012</td>
	  </tr>
	</table>	

    </td>
  </tr>
</table>
    
</td>
</tr>
</form>  
</table>      
</body>
</html>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php


//Inicializa las variables de sesi?n
session_start();

//Validaci?n de Ingreso
include ("../verificaIngreso2.php");

//Abre la conexi?n a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSE.php');

//Establecer la conexi?n a la base de datos
$conexion = conectar();

//$recarga = 2 si se presion? el bot?n Grabar
if ($recarga == "2") 
{
	if($accion==2)
	{	
		$qry = "UPDATE CSCPFichaFamiliaComercial SET ";
		$qry = $qry . " codItemTipoAct = ".$tpActividad .",";
		$qry = $qry . " hayCamaraCom = ".$cComercio .",";
		$qry = $qry . " hayRUT = ".$rut .",";
		if( $rut == 1 )
			$qry = $qry."codigoRUT = '".$cRUT."',";
		else
			$qry = $qry."codigoRUT = NULL,";

		$qry = $qry . " codItemTempAct = ".$temporalidad .",";
		$qry = $qry . " codItemJornada = ".$jornada .",";
		$qry = $qry . " valorMobiliario = ".$vMobiliario .",";
		$qry = $qry . " numEmpSexoM = ".$hombre .",";
		$qry = $qry . " numEmpSexoF = ".$mujer .",";
		$qry = $qry . " numEmpTempP = ".$personal .",";
		$qry = $qry . " numEmpTempO = ".$ocacional .",";
		$qry = $qry . " numEmpRemF = ".$familiar .",";
		$qry = $qry . " numEmpRemR = ".$rem .",";
		$qry = $qry . " valorGastos = ".$vGastos .",";
		$qry = $qry . " valorIngresos = ".$vIngresos .",";
		$qry = $qry . " valorInventario = ".$vEnvio .",";
		$qry = $qry . " codItemOrigen = ".$origen .",";
		$qry = $qry . " fechaMod = '" . gmdate("n/d/y") ."', ";
		$qry = $qry . " usuarioMod = '".$_SESSION["ccfUsuID"]."'" ;	
		
		$qry = $qry . "	WHERE ";
		$qry = $qry . "	nroFamilia = ".$_SESSION["ccfFamilia"] ." AND " ;
		$qry = $qry . " consecAct = ".$f;
		#echo $qry;
		$cursorIn = mssql_query($qry) ;
		###
		###
		if  (trim($cursorIn) != "")
		{	 
			echo ("<script>alert('La grabaci?n se realiz? con ?xito.');</script>");
		}
		else
		{	
			echo ("<script>alert('Error durante la grabaci?n.');</script>");
		}	
	}

	if($accion==3)
	{	
		$qry = "DELETE FROM CSCPFichaFamiliaComercial ";
		$qry = $qry. " WHERE ";
		$qry = $qry. " nroFamilia = ".$_SESSION["ccfFamilia"];
		$qry = $qry. " AND consecAct = ".$f;
		#echo $qry; 
		$cursorIn = mssql_query($qry) ;			
		if  (trim($cursorIn) != "")
			echo ("<script>alert('La operaci?n se realiz? con ?xito.');</script>");
		else
			echo ("<script>alert('Error durante la operaci?n.');</script>");
	}
	
	#$volverA = "";
	#$volverA=Genera_Pagina($Opc,$pag);		
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
		msg15 = 'El valor del env?o es obligatorio. \n'
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
		msg17 = 'La suma del n?mero de empleados en Sexo, Temporalidad y Remuneraci?n, deben ser equivalentes.\n'
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
function MM_callJS(jsStr) 
{ //v2.0
  return eval(jsStr)
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<form name="form1" method="post" action="">
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
  <tr>
    <td><!-- TITULO GENERAL -->
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="TituloTabla" align="center">Actividades Extractivas</td>
        </tr>
      </table>
      <?
	  	$disabled = "";
		if( $accion == 3 )
			$disabled = "disabled";
			
	  	$sqlReg = "SELECT * FROM CSCPFichaFamiliaComercial WHERE consecAct = ".$f;
		$qryReg = mssql_fetch_array( mssql_query( $sqlReg ) );
		
		#	Temporalidad de la actividad
		$sqlIt1 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 99";
		$qr1 = mssql_query( $sqlIt1 );
		
		#	Jornada de atenci?n
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
          <tr>
		<td width="30%" class="TituloTabla1">Tipo actividad</td>
	    <td colspan="3" class="TxtTabla"><select name="tpActividad" id="tpActividad" class="CajaTexto" <?= $disabled ?> >
	      <option>:::Seleccione opci&oacute;n:::</option>
	      <? while( $rw4 = mssql_fetch_array( $qr4 ) ){ 
			$sel = "";
			if( $rw4[codItem] == $qryReg[codItemTipoAct] )
				$sel = "selected";
		?>
	      <option value="<?= $rw4[codItem] ?>" <?= $sel ?> >
	        <?= $rw4[nomItem] ?>
	        </option>
	      <? } ?>
	      </select></td>
	  </tr>
	  <tr>
	    <td width="30%" class="TituloTabla1">Camar Comercio</td>
	    <td colspan="3" class="TxtTabla"> 
        <?
			#hayCamaraCom
			$chkC1 = $chkC0 = "";
			if( $qryReg[hayCamaraCom] == 1 )
				$chkC1 = "checked";
			else 
				$chkC0 = "checked";
		?>
        Si <input type="radio" name="cComercio" id="cComercio" value="1" <?= $chkC1 ?> <?= $disabled ?>/>
        No <input type="radio" name="cComercio" id="cComercio" value="0" <?= $chkC0 ?> <?= $disabled ?>/>
        </td>
	  </tr>
	  <tr>
	    <td class="TituloTabla1"> RUT</td>
	    <td colspan="3" class="TxtTabla">
        <?
			#hayRUT
			$chkR1 = $chkR0 = "";
			if( $qryReg[hayRUT] == 1 )
				$chkR1 = "checked";
			else 
				$chkR0 = "checked";
		?>
        Si <input type="radio" name="rut" id="rut" value="1" onClick="habilita();" <?= $chkR1 ?> <?= $disabled ?>/>
        No <input type="radio" name="rut" id="rut" value="0" onClick="habilita();" <?= $chkR0 ?> <?= $disabled ?>/></td>
	    </tr>
	  <tr> 
	    <td class="TituloTabla1">Codigo RUT</td>
	    <td colspan="3" class="TxtTabla"> 
        <input name="cRUT" type="text" class="CajaTexto" id="cRUT" value="<?= $qryReg[codigoRUT]; ?>" size="50" onKeyPress="keyNumG();" maxlength="9" readonly <?= $disabled ?> />
        </td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Temporalidad de la actividad</td>
	    <td colspan="3" class="TxtTabla"><select name="temporalidad" id="temporalidad" class="CajaTexto" <?= $disabled ?> >
	      <option>:::Seleccione opci&oacute;n:::</option>
	      <? while( $rw1 = mssql_fetch_array( $qr1 ) ){ 
				$sel = "";
				if( $rw1[codItem] == $qryReg[codItemTempAct] )
					$sel = "selected";

		  ?>
	      <option value="<?= $rw1[codItem] ?>" <?= $sel ?> >
	        <?= $rw1[nomItem] ?>
	        </option>
	      <? } ?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Jornada de atenci&oacute;n</td>
	    <td colspan="3" class="TxtTabla"><select name="jornada" id="jornada" class="CajaTexto" <?= $disabled ?> >
	      <option>:::Seleccione opci&oacute;n:::</option>
	      <? 
		  	while( $rw2 = mssql_fetch_array( $qr2 ) ){ 
				$sel = "";
				if( $rw2[codItem] == $qryReg[codItemJornada] )
					$sel = "selected";
		  ?>
	      <option value="<?= $rw2[codItem] ?>" <?= $sel ?> >
	        <?= $rw2[nomItem] ?>
	        </option>
	      <? } ?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Valor del mobiliario</td>
	    <td colspan="3" class="TxtTabla">
        <input name="vMobiliario" type="text" class="CajaTexto" id="vMobiliario" value="<?= $qryReg[valorMobiliario]; ?>" size="50" <?= $disabled ?> onKeyPress="keyNum();" maxlength="11" />
        </td>
	    </tr>
	  <tr>
	    <td rowspan="6" valign="top" class="TituloTabla1">Numero de empleados</td>
	    <td rowspan="2" class="TituloTabla1">Sexo</td>
	    <td class="TituloTabla1">Hombre</td>
	    <td class="TxtTabla"><input name="hombre" type="text" class="CajaTexto" id="hombre" value="<?= $qryReg[numEmpSexoM]; ?>" <?= $disabled ?> size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Mujer</td>
	    <td class="TxtTabla"><input name="mujer" type="text" class="CajaTexto" id="mujer" value="<?= $qryReg[numEmpSexoF]; ?>" <?= $disabled ?> size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td rowspan="2" class="TituloTabla1">Temporal</td>
	    <td class="TituloTabla1">Personal</td>
	    <td class="TxtTabla"><input name="personal" type="text" class="CajaTexto" id="personal" value="<?= $qryReg[numEmpTempP]; ?>" <?= $disabled ?> size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Ocasional</td>
	    <td class="TxtTabla"><input name="ocacional" type="text" class="CajaTexto" id="ocacional" value="<?= $qryReg[numEmpTempO]; ?>" <?= $disabled ?> size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td rowspan="2" class="TituloTabla1">Remanente</td>
	    <td class="TituloTabla1">Familiar</td>
	    <td class="TxtTabla"><input name="familiar" type="text" class="CajaTexto" id="familiar" value="<?= $qryReg[numEmpRemF]; ?>" <?= $disabled ?> size="20" onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Remunerados</td>
	    <td class="TxtTabla"><input name="rem" type="text" class="CajaTexto" id="rem" value="<?= $qryReg[numEmpRemR]; ?>" size="20" <?= $disabled ?> onKeyPress="keyNum();" maxlength="4" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Ingresos durante el ultimo mes (valor ventas)</td>
	    <td colspan="3" class="TxtTabla"><input name="vIngresos" type="text" class="CajaTexto" id="vIngresos" value="<?= $qryReg[valorIngresos]; ?>" size="50" onKeyPress="keyNum();" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Gastos del negocio durante el ultimo mes</td>
	    <td colspan="3" class="TxtTabla"><input name="vGastos" type="text" class="CajaTexto" id="vGastos" value="<?= $qryReg[valorGastos]; ?>" size="50" onKeyPress="keyNum();" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Valor del inventario inventario a la fecha de la entrevista</td>
	    <td colspan="3" class="TxtTabla"><input name="vEnvio" type="text" class="CajaTexto" id="vEnvio" value="<?= $qryReg[valorInventario]; ?>" size="50" onKeyPress="keyNum();" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Origen</td>
	    <td colspan="3" class="TxtTabla"><select name="origen" id="origen" class="CajaTexto" <?= $disabled ?> >
	      <option>:::Seleccione opci&oacute;n:::</option>
	      <? while( $rw3 = mssql_fetch_array( $qr3 ) ){ 
				$sel = "";
				if( $rw3[codItem] == $qryReg[codItemOrigen] )
					$sel = "selected";
		  ?>
	      <option value="<?= $rw3[codItem] ?>" <?= $sel ?> >
	        <?= $rw3[nomItem] ?>
	        </option>
	      <? } ?>
	      </select></td>
	    </tr>
      </table>
      <!-- ESPACIO -->
      <table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
        <tr>
          <td height="10"></td>
        </tr>
      </table>
      <!-- BOTONES DE GRABAR -->
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="right">
            <input name="recarga" type="hidden" id="recarga" value="1">
            <?
				if( $accion == 3 )
					$txt = "Borrar";
				else
					$txt = "Modificar";
			?>
			<input name="Submit2" type="button" class="Boton" value="<?= $txt ?>" onClick="envia2()">
            <?
				if( $accion == 3 ){
			?>
            		<input name="Submit2" type="button" class="Boton" value="Cancelar" onClick="javascript:window.close()">
            <? } ?>
            
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
      </table></td>
  </tr>
</table>
   
</td>
</tr>
</table> 
</form>
     
</body>
</html>

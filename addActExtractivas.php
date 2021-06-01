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
	$sqlSec	= "SELECT MAX(consecAct) MaxCodigo FROM CSCPFichaFamiliaExtractiva";
	$cursorSec = mssql_query($sqlSec);
	if ($regSec=mssql_fetch_array($cursorSec)) 
	{
		$pSig = $regSec[MaxCodigo] + 1;
	}
	else 
	{
		$pSig = 1;
	}
			
	$qry = "INSERT INTO CSCPFichaFamiliaExtractiva ( 
				nroFamilia, nroPredio, nroVivienda, numFormulario, codModulo, codProyecto, consecutivo, consecAct
				, codItemTipoAct, consecUbicaSitioExt, codItemFormaExp, cantObtenida, codItemUnd, precioVenta, codItemTiempo
				, cantContratoCal, cantContratoNoCal, cantFamiliarCal, cantFamiliarNoCal, costosProduccion, referenciaSitioExt
				, ProduccionVendida, codItemSitioVenta
				, usuarioGraba, fechaGraba
			)";	

	$qry = $qry. " VALUES( ";
	$qry = $qry. $_SESSION["ccfFamilia"].", ";
	$qry = $qry. $_SESSION["ccfPredio"].", ";
	$qry = $qry. $_SESSION["ccfVivienda"].", ";
	$qry = $qry. "'".$_SESSION["ccfFormulario"]."', ";
	$qry = $qry. $_SESSION["ccfModulo"].", ";
	$qry = $qry. $_SESSION["ccfProyecto"].", ";
	$qry = $qry. $_SESSION["ccfConsecutivo"].", ";
	$qry = $qry. $pSig .",";
	#	   cObtenida           
	$qry = $qry. $tActividad .", ";
	$qry = $qry. $sExtraccion .", ";
	$qry = $qry. $fExtraccion .", ";
	$qry = $qry. $cObtenida .", ";
	$qry = $qry. $unidad .", ";
	$qry = $qry. $pVenta .", ";
	$qry = $qry. $tiempo .", ";
	#	***
	$qry = $qry. $tcCont .", ";
	$qry = $qry. $tncCont .", ";
	$qry = $qry. $tcFmla .", ";
	$qry = $qry. $tncFmla .", ";
	$qry = $qry. $cstProduccion .", ";
	$qry = $qry. $sExtraccion .", ";	
	#	***
	$qry = $qry. $proVendida .", ";
	$qry = $qry. $sVenta .", ";
	#	***
	$qry = $qry. " '".$_SESSION["ccfUsuID"]."',";
	$qry = $qry. " '" . gmdate("n/d/y") ."' ";
	$qry = $qry. " ) " ;	
	#echo $qry;
	//exit;
	$cursorIn = mssql_query( $qry );
	$tempo = 1;
	$error = 0;
	while( $tempo <= 4 ){
		$tmp = "tmp".$tempo;
		$id = "id".$tempo;
		$tempo++;
		if( ${$id} == 1 ){
			#	Inserta la temporalización
			$sqlTmpId = "SELECT MAX(consecTemp) MaxCodigo FROM CSCPFichaFamiliaExtTemp";
			$qryId = mssql_fetch_array( mssql_query( $sqlTmpId ) );
			if( $qryId[MaxCodigo] != 0 )
				$idTmp = $qryId[MaxCodigo] + 1;
			else
				$idTmp = 1;
			$sqlTmp = "INSERT INTO CSCPFichaFamiliaExtTemp ( 
							nroFamilia, nroPredio, nroVivienda, numFormulario, codModulo, codProyecto, consecutivo, consecAct, consecTemp, codItemTipoTemp 							
							, usuarioGraba, fechaGraba )
						 VALUES ( ";
			$sqlTmp = $sqlTmp. $_SESSION["ccfFamilia"].", ";
			$sqlTmp = $sqlTmp. $_SESSION["ccfPredio"].", ";
			$sqlTmp = $sqlTmp. $_SESSION["ccfVivienda"].", ";
			$sqlTmp = $sqlTmp. "'".$_SESSION["ccfFormulario"]."', ";
			$sqlTmp = $sqlTmp. $_SESSION["ccfModulo"].", ";
			$sqlTmp = $sqlTmp. $_SESSION["ccfProyecto"].", ";
			$sqlTmp = $sqlTmp. $_SESSION["ccfConsecutivo"].", ";
			$sqlTmp = $sqlTmp. $pSig .",";			
			$sqlTmp = $sqlTmp. $idTmp .",";			
			$sqlTmp = $sqlTmp. ${$tmp} .",";			
			$sqlTmp = $sqlTmp. " '".$_SESSION["ccfUsuID"]."',";
			$sqlTmp = $sqlTmp. " '" . gmdate("n/d/y") ."' ";
			$sqlTmp = $sqlTmp. " ) " ;
			#echo $sqlTmp."<br />";
			$qryTmp = mssql_query( $sqlTmp );
			#if( !$qryTmp )
			#	$error = 1;
			#echo $sqlTmp."<br />";
		}
		
	}
	#if( $error == 1 )
	/*	echo ("<script>alert('No temporalizo');</script>");#*/

	if  (trim($cursorIn) != "")  
		echo ("<script>alert('La grabación se realizó con éxito.');</script>");
	else 
		echo ("<script>alert('Error durante la grabación');</script>");

	#/*
	echo "<script>
			window.close();
			MM_openBrWindow('frmCensoFamiliaActExtractiva.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
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
	//alert ( 'fn' );
	var v1,v2,v3, v4,v5,v6,v7,v8,v9,v10,v11,v12,v13,v14,v15,v16, i, CantCampos, msg1, msg2, msg3, msg4, msg5, msg6, msg7, msg8, msg9, msg10, msg11, msg12, msg13, msg14, msg15, msg16, mensaje;
	v1 = v2 = v3= v4= v5='s';
	v6 = v7 = v8= v9= v10='s';
	v11= v12='s';
	v13='n';
	v14= v15= v16='s';
	msg1 = msg2 = msg3 = msg4 = msg5 = '';
	msg6 = msg7 = msg8 = msg9 = msg10 = '';
	msg11 = msg12 = '';
	msg13 = 'Debe seleccionar almenos una temporalidad.\n';
	msg14 = msg15 = msg16 = '';
	mensaje = '';

	if (document.form1.tActividad.value == '')  
	{
		v1='n';
		msg1 = 'Seleccione una actividad. \n'
	}
	if (document.form1.sExtraccion.value == '')  
	{
		v2='n';
		msg2 = 'Seleccione sitio de extracción. \n'
	}
	if (document.form1.fExtraccion.value == '')  
	{
		v3='n';
		msg3 = 'Seleccione la forma de extracción. \n'
	}
	if (document.form1.cObtenida.value == '')  
	{
		v4='n';
		msg4 = 'Ingrese la cantidad obtenida. \n'
	}
	//	 unidad     tncFmla tncCont cstProduccion proVendida sVenta
	if (document.form1.unidad.value == '')  
	{
		v5='n';
		msg5 = 'Ingrese la unidad obtenida. \n'
	}
	if (document.form1.tcFmla.value == '')  
	{
		v7='n';
		msg7 = 'Ingrese la cantidad de personas calificadas de la familia. \n'
	}
	if (document.form1.tiempo.value == '')  
	{
		v8='n';
		msg8 = 'Seleccione el tiempo de la actividad. \n'
	}
	if (document.form1.tncFmla.value == '')  
	{
		v9='n';
		msg9 = 'Selecciones una actividad. \n'
	}
	if (document.form1.tncCont.value == '')  
	{
		v10 ='n';
		msg10 = 'Ingrese las personas no calificadas contratadas. \n'
	}
	if (document.form1.cstProduccion.value == '')  
	{
		v11='n';
		msg11 = 'Ingrese los costos de producción. \n'
	}
	if (document.form1.proVendida.value == '')  
	{
		v12='n';
		msg12 = 'Ingrese la producción vendida. \n'
	}
	if (document.form1.sVenta.value == '')  
	{
		v14 = 'n';
		msg14 = 'Seleccione el sitio de venta. \n'
	}
	for( var num = 1; num <= 4; num++ ){
		if( document.getElementById('id'+num).checked == true ){
			v13 = 's';
			msg13 = '';
		}
	}
	num = 1;
	if (document.form1.pVenta.value == '')  
	{
		v15 = 'n';
		msg15 = 'Ingrese el precio de venta. \n'
	}
	if (document.form1.proVendida.value == '')  
	{
		v16 = 'n';
		msg16 = 'Ingrese la producción vendida. \n'
	}
	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if( (v1 == 's') && (v2 == 's') && (v3 == 's') && (v4 == 's') && (v5 == 's') &&
	    (v6 == 's') && (v7 == 's') && (v8 == 's') && (v9 == 's') && (v10 == 's') && 
		(v11 == 's') && (v13 == 's') && (v14 == 's') && (v15 == 's') && (v16 == 's') ) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 + msg4 + msg5 + msg6 + msg7 + msg8 + msg9 + msg10 + msg11 + msg13 + msg14 + msg15 + msg16;
		alert (mensaje);
	}	
}
//-->
function keyNum(){ //	input
	if ( event.keyCode < 48 || event.keyCode > 57) 
		event.returnValue = false	
}

var nav4 = window.Event ? true : false;
function acceptNum(evt)
{   
	var key = nav4 ? evt.which : evt.keyCode;   
	return (key <= 13 || (key>= 48 && key <= 57)|| key==46 );
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
        	<td class="TituloTabla" align="center">Actividades Extractivas</td>
      	</tr>
    </table>

	<? 
		#	Búsqueda de los ítems para cada pregunta		
		#	Tp Actividad
		$sqlIt1 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 84";
		$qr1 = mssql_query( $sqlIt1 );
		
		#	Sitio de Extracción
		$sqlIt2 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 2";
		$qr2 = mssql_query( $sqlIt2 );
		
		#	Forma de explotacion
		$sqlIt3 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 88";
		$qr3 = mssql_query( $sqlIt3 );
		
		#	Unidad
		$sqlIt4 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 89";
		$qr4 = mssql_query( $sqlIt4 );
		
		#	Tiempo
		$sqlIt5 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 91";
		$qr5 = mssql_query( $sqlIt5 );
		
		#	Sitio de venta
		$sqlIt6 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 92";
		$qr6 = mssql_query( $sqlIt6 );
		
		#	Temporalidad
		$sqlIt7 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 87";
		$qr7 = mssql_query( $sqlIt7 );
		
	?>
	<!-- Tabla de datos -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
	    <td width="30%" class="TituloTabla1">Tipo de actividad</td>
	    <td colspan="3" valign="top" class="TxtTabla">
	      <select name="tActividad" class="CajaTexto" id="tActividad" style="width:350">
	        <option value="">:::Seleccione una opción:::</option>
	        <? 
			while($reg1 = mssql_fetch_array($qr1))
			{
				$sel4 = "";
				if($reg1[codItem] == $tActividad)
				{
					$sel4 = "selected";
				}
				?>
	        <option value="<? echo $reg1[codItem]; ?>" <? echo $sel4; ?>><? echo $reg1[nomItem]; ?></option>
	        <?
			}
			?>
	        </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Centro poblado</td>
	    <td colspan="3" valign="top" class="TxtTabla">        
	      <select name="sExtraccion" class="CajaTexto" id="sExtraccion" style="width:350">
	        <option value="">:::Seleccione una opción:::</option>
	        <? 
			while($reg2 = mssql_fetch_array($qr2))
			{
				$sel2 = "";
				if($reg2[codItem] == $sExtraccion)
				{
					$sel2 = "selected";
				}
				?>
	        <option value="<? echo $reg2[codItem]; ?>" <? echo $sel2; ?>><? echo $reg2[nomItem]; ?></option>
	        <?
			}
			?>
	        </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Forma de explotaci&oacute;n</td>
	    <td colspan="3" valign="top" class="TxtTabla">
	      <select name="fExtraccion" class="CajaTexto" id="fExtraccion" style="width:350">
	        <option value="">:::Seleccione una opción:::</option>
	        <? 
			while($reg3 = mssql_fetch_array($qr3))
			{
				$sel3 = "";
				if($reg3[codItem] == $fExtraccion)
				{
					$sel3 = "selected";
				}
				?>
	        <option value="<? echo $reg3[codItem]; ?>" <? echo $sel3; ?>><? echo $reg3[nomItem]; ?></option>
	        <?
			}
			?>
	        </select></td>
	    </tr>
	  	  
	  <tr>
	    <td class="TituloTabla1">Cantidad obtenida</td>
	    <td colspan="3" valign="top" class="TxtTabla"><input name="cObtenida" type="text" class="CajaTexto" id="cObtenida" value="<? echo $cObtenida; ?>" size="20" onKeyPress="return acceptNum(event)"  /> 
	      unidad 
            <select name="unidad" class="CajaTexto" id="unidad" style="width:185" >
          <option value="">:::Seleccione una opción:::</option>
		  <? 
			while($reg4 = mssql_fetch_array($qr4))
			{
				$sel4 = "";
				if($reg4[codItem] == $unidad)
				{
					$sel4 = "selected";
				}
				?>
          <option value="<? echo $reg4[codItem]; ?>" <? echo $sel4; ?>><? echo $reg4[nomItem]; ?></option>
          <?
			}
			?>
        </select></td>
	  </tr>
	 
	  <tr>
	    <td class="TituloTabla1">Precio de venta</td>
	    <td colspan="3" valign="top" class="TxtTabla">
        <input name="pVenta" type="text" class="CajaTexto" id="pVenta" value="<? echo $pVenta; ?>" size="20" onKeyPress="keyNum();" maxlength="" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Tiempo</td>
	    <td colspan="3" valign="top" class="TxtTabla">
        <select name="tiempo" class="CajaTexto" id="tiempo" style="width:228" >
	      <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg5 = mssql_fetch_array($qr5))
			{
				$sel5 = "";
				if($reg5[codItem] == $tiempo)
				{
					$sel5 = "selected";
				}
				?>
	      <option value="<? echo $reg5[codItem]; ?>" <? echo $sel5; ?>><? echo $reg5[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	  </tr>
	  
	  <tr>
	    <td rowspan="4" valign="top" class="TituloTabla1">Uso de mano de obra</td>
	    <td width="15%" rowspan="2" valign="top" class="TituloTabla1">Calificada</td>
	    <td width="5%" class="TituloTabla1">Familia	      </td>
	    <td class="TxtTabla">
        <input name="tcFmla" type="text" class="CajaTexto" id="tcFmla" value="<? echo $tcFmla; ?>" size="20" onKeyPress="keyNum();" maxlength="4" />
        </td>
	    </tr>
	  <tr>
	    <td width="5%" class="TituloTabla1">Contratada	      </td>
	    <td class="TxtTabla">
        <input name="tcCont" type="text" class="CajaTexto" id="tcCont" value="<? echo $tcCont; ?>" size="20" onKeyPress="keyNum();" maxlength="4" />
        </td>
	    </tr>
	  <tr>
	    <td width="15%" rowspan="2" valign="top" class="TituloTabla1">No Calificada</td>
	    <td width="5%" class="TituloTabla1">Familia          </td>
	    <td class="TxtTabla">
        <input name="tncFmla" type="text" class="CajaTexto" id="tncFmla" value="<? echo $tncFmla; ?>" size="20" onKeyPress="keyNum();" maxlength="4" />
        </td>
	    </tr>
	  <tr>
	    <td width="5%" class="TituloTabla1">Contratada          </td>
	    <td class="TxtTabla">
        <input name="tncCont" type="text" class="CajaTexto" id="tncCont" value="<? echo $tncCont; ?>" size="20" onKeyPress="keyNum();" maxlength="4" />
        </td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Costo de producci&oacute;n</td>
	    <td colspan="3" valign="top" class="TxtTabla">
        <input name="cstProduccion" type="text" class="CajaTexto" id="cstProduccion" value="<? echo $cstProduccion; ?>" size="20" onKeyPress="keyNum();" maxlength="9" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Producci&oacute;n vendida</td>
	    <td colspan="3" valign="top" class="TxtTabla">
        <input name="proVendida" type="text" class="CajaTexto" id="proVendida" value="<? echo $proVendida; ?>" size="20" onKeyPress="keyNum();" maxlength="9" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Sitio de venta</td>
	    <td colspan="3" valign="top" class="TxtTabla">
        <select name="sVenta" class="CajaTexto" id="sVenta" style="width:350">
	      <option value="">:::Seleccione una opci&oacute;n:::</option>
	      <? 
			while($reg6 = mssql_fetch_array($qr6))
			{
				$sel6 = "";
				if($reg6[codItem] == $sVenta)
				{
					$sel6 = "selected";
				}
				?>
	      <option value="<? echo $reg6[codItem]; ?>" <? echo $sel6; ?>><? echo $reg6[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <tr>
	      <td colspan="4" class="TituloTabla1">Temporalidad</td>
	      </tr>
	  <? 
			$r = 0;
			while($reg7 = mssql_fetch_array($qr7)){
				$r++;
        ?>
	  
	  <tr>
	    <td class="TituloTabla1"><?= $reg7[nomItem] ?> </td>
	    <td colspan="3" valign="top" class="TxtTabla">
              <input name="tmp<?= $r ?>" value="<?= $reg7[codItem] ?>" type="hidden" class="CajaTexto" id="tmp<?= $r ?>" size="20" /> 
            Si<input type="radio" value="1" id="id<?= $r ?>" name="id<?= $r ?>" />
            No <input type="radio" value="0" id="id<?= $r ?>" name="id<?= $r ?>" checked />
	      </td>
	    </tr>
        <? } ?>
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

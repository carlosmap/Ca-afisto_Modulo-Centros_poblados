<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php


//Inicializa las variables de sesión
session_start();

//Validación de Ingreso
include ("../verificaIngreso2.php");

//Abre la conexión a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSE.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	if($accion==2)
	{	
		$qry = "UPDATE CSCPFichaFamiliaExtractiva SET ";
		$qry = $qry . " codItemTipoAct = ".$tActividad .",";
		$qry = $qry . " codItemFormaExp = ".$fExtraccion .",";
		$qry = $qry . " referenciaSitioExt = ".$sExtraccion .",";
		$qry = $qry . " codItemTiempo = ".$tiempo .",";
		$qry = $qry . " codItemUnd = ".$unidad .",";
##
		$qry = $qry . " cantObtenida = ".$cObtenida .",";
#		$qry = $qry . " consecUbicaSitioExt = ".$sExtraccion .",";
##
		$qry = $qry . " cantFamiliarCal = ".$tcFmla .",";
		$qry = $qry . " cantFamiliarNoCal = ".$tncFmla .",";
		$qry = $qry . " cantContratoCal = ".$tcCont .",";
		$qry = $qry . " cantContratoNoCal = ".$tncCont .",";
		$qry = $qry . " costosProduccion = ".$cstProduccion .",";
		$qry = $qry . " ProduccionVendida = ".$proVendida .",";
		$qry = $qry . " codItemSitioVenta = ".$sVenta .",";
		$qry = $qry . " fechaMod = '" . gmdate("n/d/y") ."', ";
		$qry = $qry . " usuarioMod = '".$_SESSION["ccfUsuID"]."'" ;	
		$qry = $qry . "	WHERE ";
		$qry = $qry . "	nroFamilia = '".$_SESSION["ccfFamilia"] ."' AND " ;
		$qry = $qry . " consecAct = ".$f;
		#echo $qry;
		$cursorIn = mssql_query($qry) ;
		###
		#/*
		$tempo = 1;
		$error = 0;
		$sqlDeleteTemp = "DELETE FROM CSCPFichaFamiliaExtTemp 
						  WHERE numFormulario = '".$_SESSION['ccfFormulario']."' AND nroVivienda = '".$_SESSION['ccfVivienda']."' 
						  AND nroFamilia = '".$_SESSION['ccfFamilia']."' AND consecAct = ".$f;
		$qryDeleteTemp = mssql_query( $sqlDeleteTemp );
		while( $tempo <= 4 ){
			$tmp = "tmp".$tempo;
			$id = "id".$tempo;
			$idIt = "idIt".$tempo;
			$tempo++;
			if( ${$id} == 1 ){
				#echo "Valor ID : ".${$id}."<br />";
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
				$sqlTmp = $sqlTmp. "'".$_SESSION["ccfFamilia"]."', ";
				$sqlTmp = $sqlTmp. "'".$_SESSION["ccfPredio"]."', ";
				$sqlTmp = $sqlTmp. "'".$_SESSION["ccfVivienda"]."', ";
				$sqlTmp = $sqlTmp. "'".$_SESSION["ccfFormulario"]."', ";
				$sqlTmp = $sqlTmp. "'".$_SESSION["ccfModulo"]."', ";
				$sqlTmp = $sqlTmp. "'".$_SESSION["ccfProyecto"]."', ";
				$sqlTmp = $sqlTmp. "'".$_SESSION["ccfConsecutivo"]."', ";
				$sqlTmp = $sqlTmp. $f .",";			
				$sqlTmp = $sqlTmp. $idTmp .",";			
				$sqlTmp = $sqlTmp. ${$tmp} .",";			
				$sqlTmp = $sqlTmp. " '".$_SESSION["ccfUsuID"]."',";
				$sqlTmp = $sqlTmp. " '" . gmdate("n/d/y") ."' ";
				$sqlTmp = $sqlTmp. " ) " ;	
				#$sqlTmp = $sqlTmp. " WHERE ";
				#$sqlTmp = $sqlTmp. " consecTemp = ".${$idIt};
				#echo $sqlTmp."<br />";
			}
			$qryTmp = mssql_query( $sqlTmp );
			if( !$qryTmp )
				$error = 1;
		}	
		#*/	
		###
		if  (trim($cursorIn) != "")
		{	 
			echo ("<script>alert('La grabación se realizó con éxito.');</script>");
		}
		else
		{	
			echo ("<script>alert('Error durante la grabación.');</script>");
		}	
	}

	if($accion==3)
	{	
		$qry = "DELETE FROM CSCPFichaFamiliaExtractiva ";
		$qry = $qry. " WHERE ";
		$qry = $qry. " nroFamilia = ".$_SESSION["ccfFamilia"];
		$qry = $qry. " AND consecAct = ".$f;
		#echo $qry; 
		#	ELIMINAR EXTENCIONES
		$tempo = 1;
		$errorExt = 0;
		while( $tempo <= 4 ){
			$tmp = "tmp".$tempo;
			$id = "id".$tempo;
			$idIt = "idIt".$tempo;
			$tempo++;
			if( ${$idIt} != "" ){
				$sqlTmpExt = "DELETE FROM CSCPFichaFamiliaExtTemp WHERE codItemTipoTemp = ".${$idIt}. " AND consecAct = ".$f;
				$qryTmpExt = mssql_query( $sqlTmpExt );
				if( !$qryTmpExt )
					$errorExt = 1;
				#echo $sqlTmp."<br />";			
			}
		}
		#	Libera la memoria de las consultas ejecutadas anteriormente
		mssql_free_result();		
		if( $errorExt == 0 )
			$cursorIn = mssql_query($qry) ;			
		if  (trim($cursorIn) != "")
			echo ("<script>alert('La operación se realizó con éxito.');</script>");
		else
			echo ("<script>alert('Error durante la operación.');</script>");
	}
	
	#$volverA = "";
	#$volverA=Genera_Pagina($Opc,$pag);		
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
function eliminar(){ 
	document.form1.recarga.value="2";
	document.form1.submit();	
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
	  	$sqlActExt = "SELECT * FROM CSCPFichaFamiliaExtractiva ext WHERE ext.consecAct = ".$f;
		#echo $sqlActExt;
		if( $accion == 3 )
			$dis = "disabled";
		$rwActExt = mssql_fetch_array( mssql_query( $sqlActExt ) );
	  
		#	B&uacute;squeda de los &iacute;tems para cada pregunta		
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
				
	?>
      <!-- Tabla de datos -->
      <table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
          <td width="30%" class="TituloTabla1">Tipo de actividad</td>
          <td colspan="3" valign="top" class="TxtTabla"><select name="tActividad" class="CajaTexto" id="tActividad" style="width:350" <?= $dis ?> >
            <option value="">:::Seleccione una opci&oacute;n:::</option>
            <? 
			while($reg1 = mssql_fetch_array($qr1))
			{
				$sel4 = "";
				if($reg1[codItem] == $rwActExt[codItemTipoAct])
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
          <select name="sExtraccion" class="CajaTexto" id="sExtraccion" style="width:350" <?= $dis ?> >
            <option value="">:::Seleccione una opci&oacute;n:::</option>
            <? 
			while($reg2 = mssql_fetch_array($qr2))
			{
				$sel2 = "";
				if($reg2[codItem] == $rwActExt[consecUbicaSitioExt])
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
          <select name="fExtraccion" class="CajaTexto" id="fExtraccion" style="width:350" <?= $dis ?> >
            <option value="">:::Seleccione una opci&oacute;n:::</option>
            <? 
			while($reg3 = mssql_fetch_array($qr3))
			{
				$sel3 = "";
				if($reg3[codItem] == $rwActExt[codItemFormaExp])
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
          <td colspan="3" valign="top" class="TxtTabla">
          <input value="<?= $rwActExt[cantObtenida] ?>" name="cObtenida" type="text" class="CajaTexto" id="cObtenida" size="20"  <?= $dis ?> onKeyPress="return acceptNum(event)" />
            unidad
            <select name="unidad" class="CajaTexto" id="unidad" style="width:185" <?= $dis ?> >
              <option value="">:::Seleccione una opci&oacute;n:::</option>
              <? 
			while($reg4 = mssql_fetch_array($qr4))
			{
				$sel4 = "";
				if($reg4[codItem] == $rwActExt[codItemUnd])
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
          <input value="<?= $rwActExt[precioVenta] ?>" name="pVenta" type="text" class="CajaTexto" id="pVenta" size="20" onKeyPress="keyNum();" maxlength="" <?= $dis ?> /></td>
        </tr>
        <tr>
          <td class="TituloTabla1">Tiempo</td>
          <td colspan="3" valign="top" class="TxtTabla">
          <!-- <input name="pVenta2" type="text" class="CajaTexto" id="pVenta2" value="<? echo $pVenta; ?>" size="20" onKeyPress="keyNum();" /> -->
         
            <select name="tiempo" class="CajaTexto" id="tiempo" style="width:228" <?= $dis ?> >
              <option value="">:::Seleccione una opci&oacute;n:::</option>
              <? 
			while($reg5 = mssql_fetch_array($qr5))
			{
				$sel5 = "";
				if($reg5[codItem] == $rwActExt[codItemTiempo])
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
          <td width="5%" class="TituloTabla1">Familia </td>
          <td class="TxtTabla">
          <input value="<?= $rwActExt[cantFamiliarCal] ?>" name="tcFmla" type="text" class="CajaTexto" id="tcFmla" size="20" onKeyPress="keyNum();" maxlength="4" <?= $dis ?> /></td>
        </tr>
        <tr>
          <td width="5%" class="TituloTabla1">Contratada </td>
          <td class="TxtTabla">
          <input value="<?= $rwActExt[cantContratoCal] ?>" name="tcCont" type="text" class="CajaTexto" id="tcCont" size="20" onKeyPress="keyNum();" maxlength="4" <?= $dis ?> /></td>
        </tr>
        <tr>
          <td width="15%" rowspan="2" valign="top" class="TituloTabla1">No Calificada</td>
          <td width="5%" class="TituloTabla1">Familia </td>
          <td class="TxtTabla">
          <input value="<?= $rwActExt[cantFamiliarNoCal] ?>" name="tncFmla" type="text" class="CajaTexto" id="tncFmla" size="20" onKeyPress="keyNum();" maxlength="4" <?= $dis ?> /></td>
        </tr>
        <tr>
          <td width="5%" class="TituloTabla1">Contratada </td>
          <td class="TxtTabla">
          <input value="<?= $rwActExt[cantContratoNoCal] ?>" name="tncCont" type="text" class="CajaTexto" id="tncCont" size="20" onKeyPress="keyNum();" maxlength="4" <?= $dis ?> /></td>
        </tr>
        <tr>
          <td class="TituloTabla1">Costo de producci&oacute;n</td>
          <td colspan="3" valign="top" class="TxtTabla">
          <input name="cstProduccion" type="text" class="CajaTexto" id="cstProduccion" value="<?= $rwActExt[costosProduccion] ?>" size="20" onKeyPress="keyNum();" maxlength="9" <?= $dis ?> /></td>
        </tr>
        <tr>
          <td class="TituloTabla1">Producci&oacute;n vendida</td>
          <td colspan="3" valign="top" class="TxtTabla">
          <input name="proVendida" type="text" class="CajaTexto" id="proVendida" value="<?= $rwActExt[ProduccionVendida]; ?>" size="20" onKeyPress="keyNum();" maxlength="9" <?= $dis ?> /></td>
        </tr>
        <tr>
          <td class="TituloTabla1">Sitio de venta</td>
          <td colspan="3" valign="top" class="TxtTabla">
          <select name="sVenta" class="CajaTexto" id="sVenta" style="width:350" <?= $dis ?> >
            <option value="">:::Seleccione una opci&oacute;n:::</option>
            <? 
			while($reg6 = mssql_fetch_array($qr6))
			{
				$sel6 = "";
				if($reg6[codItem] == $rwActExt[codItemSitioVenta])
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
          <td colspan="4" class="TituloTabla1">Temporalidad</td>
        </tr>
        <? 
			$r = 0;
			#	Temporalidad
			$sqlIt7 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 87";
			$qr7 = mssql_query( $sqlIt7 );
			while($reg7 = mssql_fetch_array($qr7)){
				$sqlItExt = "SELECT COUNT(*) n, codItemTipoTemp FROM CSCPFichaFamiliaExtTemp 
							WHERE consecAct = ".$rwActExt[consecAct]." AND codItemTipoTemp = ".$reg7[codItem]." group by codItemTipoTemp";
				#echo $sqlItExt."<br />";
				$qryItExt = mssql_fetch_array( mssql_query( $sqlItExt ) );
				$check = "";
				$check2 = "";
				if( $qryItExt[n] != 0 )
					$check = "checked";
				else
					$check2 = "checked";
				$r++;
        ?>
        <tr>
          <td class="TituloTabla1"><?= $reg7[nomItem] ?></td>
          <td colspan="3" valign="top" class="TxtTabla"> 
            <input name="tmp<?= $r ?>" value="<?= $reg7[codItem] ?>" type="hidden" class="CajaTexto" id="tmp<?= $r ?>" size="20" />
            <input name="idIt<?= $r ?>" value="<?= $qryItExt[codItemTipoTemp] ?>" type="hidden" class="CajaTexto" id="idIt<?= $r ?>" size="20" /> 
            Si <input type="radio" value="1" id="id<?= $r ?>" name="id<?= $r ?>" <?= $check ?> <?= $dis ?> />
            No <input type="radio" value="0" id="id<?= $r ?>" name="id<?= $r ?>" <?= $check2 ?> <?= $dis ?> /></td>
        </tr>
        <? } ?>
        <? 
	  $sqlItem4 = $sqlItem." WHERE codOpcion=91";
	  $cursor4 = mssql_query($sqlItem4);
	  ?>
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

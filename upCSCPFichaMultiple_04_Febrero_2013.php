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
include ("../validaUsu.php");

//Abre la conexión a la BD
//include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
//$conexion = conectar();

//Trae la información del Modulo
//dbo.tmModulos
//codModulo, nomModulo, siglaModulo, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlPC01="SELECT * FROM tmModulos WHERE codModulo= " .$_SESSION["ccfModulo"] ; 
$cursorPC01 = mssql_query($sqlPC01) ;
if ($regPC01=mssql_fetch_array($cursorPC01)) 
{
	$proyModulo=$regPC01[nomModulo];
}

//Obtener Titulo y/o Pregunta de la Sección
$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			FROM tmOpciones INNER JOIN
			tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			tmOpciones.codOpcion = tmItems.codOpcion";
$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$Opc;
$cursorTit = mssql_query($sqlTit);
if ($regTit = mssql_fetch_array($cursorTit)) 
{
	$pTituloPpal=$regTit[pregunta];
}

//Trae la información de los items
$sql = "SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
		tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
		FROM tmOpciones INNER JOIN
		tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		tmOpciones.codOpcion = tmItems.codOpcion";
$sql = $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sql = $sql. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sql = $sql. " AND tmOpciones.codOpcion=".$Opc2;
$cursor = mssql_query($sql);
//echo " Items <br>".$sql." -- ".mssql_get_last_message()."<br><br>";	

//Trae la información de las respuestas
$sql2 = "SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
		tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmSubItems.codSubItem, tmSubItems.nomSubItem
		FROM tmOpciones INNER JOIN
		tmSubItems ON tmOpciones.codProyecto = tmSubItems.codProyecto AND tmOpciones.codModulo = tmSubItems.codModulo AND 
		tmOpciones.codOpcion = tmSubItems.codOpcion";
$sql2 = $sql2. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sql2 = $sql2. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sql2 = $sql2. " AND tmOpciones.codOpcion=".$Opc2;
$cursor2 = mssql_query($sql2);

//echo " Respuestas <br>".$sql2." -- ".mssql_get_last_message()."<br><br>";	


//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
$tipo=$_REQUEST["tipo"];
switch ($tipo) 
{ 
	case 0: 
		$nobj=$_SESSION["ccfFormulario"]; break; 
	case 1: 
		$nobj=$_SESSION["ccfPredio"]; break; 
	case 2: 
		$nobj=$_SESSION["ccfVivienda"]; break; 
	case 3: 
		$nobj=$_SESSION["ccfFamilia"]; break; 
}


if($accion == 3)
{
	$dis = "disabled";
}


//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	$cur_tran=mssql_query("BEGIN TRANSACTION");

	$sqlIn = "DELETE FROM CSCPFichaInfoBooleanM";
	$sqlIn = $sqlIn. " WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlIn = $sqlIn. " AND codModulo=".$_SESSION["ccfModulo"] ;
	$sqlIn = $sqlIn. " AND numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta= $sqlRta. " AND consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$sqlIn = $sqlIn. " AND nroObjeto=".$nobj;
	$sqlIn = $sqlIn. " AND tipoObjeto=".$tipo;
	$sqlIn = $sqlIn. " AND codOpcion=".$Opc2;
	$cursorIn1 = mssql_query($sqlIn);
	$cursorIn=$cursorIn1;

//	echo $sqlIn." -- ".mssql_get_last_message()."<br>";	

	if(($accion == 2) && (trim($cursorIn1) != ""))
	{
	
		$s = 1;
		while ($s <= $cantidadItem) 
		{
	
			$t = 1;
			$elCod = "item".$s;
	
				while ($t<=$cantidadResp)
				{	
					$codItemResp = $t."codResp".$s;
					$aplicaResp = $t."aplicaResp".$s;
	
					$sqlIn = "INSERT INTO CSCPFichaInfoBooleanM(codProyecto, codModulo, numFormulario,consecutivo, nroObjeto, tipoObjeto, 
						  codOpcion, codItem, 
	
	codSubItem, 
					respItem, fechaGraba, usuarioGraba)";
					$sqlIn = $sqlIn." VALUES ( ";
					$sqlIn = $sqlIn. $_SESSION["ccfProyecto"].", ";	
					$sqlIn = $sqlIn. $_SESSION["ccfModulo"].", ";	
					$sqlIn = $sqlIn. "'".$_SESSION["ccfFormulario"]."', ";
					$sqlIn= $sqlIn. " ".$_SESSION["ccfConsecutivo"]."," ;
					$sqlIn = $sqlIn. $nobj.", ";
					$sqlIn = $sqlIn. $tipo.", ";
	
					$sqlIn=  $sqlIn. $Opc2.", ";
					$sqlIn = $sqlIn. ${$elCod} .", ";
	
	$sqlIn=  $sqlIn. ${$codItemResp}.", "; //subitem
	
					if(${$aplicaResp} != 1)
					{
						${$aplicaResp} = 0;
					}
					$sqlIn = $sqlIn. " '".${$aplicaResp}."', ";
	
	//				$sqlIn = $sqlIn. " '" . ${$codItemRespuesta} ."', ";
					$sqlIn = $sqlIn. " '" . gmdate("n/d/y") ."', ";
					$sqlIn = $sqlIn. " '" . $_SESSION["ccfUsuID"]."' " ;
					$sqlIn = $sqlIn." ) ";
					$cursorIn = mssql_query($sqlIn);
//	echo $sqlIn." -- ".mssql_get_last_message()."<br>";
	
	/*
					$sqlIn = "INSERT INTO CSEMultipleRespuesta(codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion,
							  codItem, codOpcionResp, codItemResp, respItem, fechaGraba, usuarioGraba)";
					$sqlIn = $sqlIn." VALUES ( ";
					$sqlIn = $sqlIn. $_SESSION["ccfProyecto"].", ";	
					$sqlIn = $sqlIn. $_SESSION["ccfModulo"].", ";	
					$sqlIn = $sqlIn. "'".$_SESSION["ccfEncuesta"]."', ";
					$sqlIn = $sqlIn. $nobj.", ";
					$sqlIn = $sqlIn. $tipo.", ";
					$sqlIn=  $sqlIn. $Opc.", ";
	
					$sqlIn = $sqlIn. ${$elCod}.", ";
					$sqlIn=  $sqlIn. $Opc2.", ";
					$sqlIn=  $sqlIn. ${$codItemResp}.", ";
					if(${$aplicaResp} != 1)
					{
						${$aplicaResp} = 0;
					}
					$sqlIn = $sqlIn. " '".${$aplicaResp}."', ";
					$sqlIn = $sqlIn. " '" . gmdate("n/d/y") ."', ";
					$sqlIn = $sqlIn. " '" . $_SESSION["ccfUsuID"]."' " ;
					$sqlIn = $sqlIn." ) ";
					$cursorIn = mssql_query($sqlIn);
					//echo $sqlIn."<br>";
	*/				
					$t++;
				}//cierra while ($t<=$cantidadResp)
			$s = $s + 1;		
		}//cierra while ($s <= $cantidadItem)

	}//cierra if(($accion == 2) && (trim($cursorIn) != ""))


	if  ((trim($cursorIn) != "")&& (trim($cursorIn1) != "") )
	{
		$cur_tran=mssql_query("COMMIT TRANSACTION");
		echo ("<script>alert('La operación se realizó con éxito.');</script>");

	} 
	else 
	{
		$cur_tran=mssql_query("ROLLBACK TRANSACTION");
		echo ("<script>alert('Error durante la operación');</script>");
	};
	
	$volverA = "";
	$volverA=Genera_Pagina($Opc,$pag);	
	echo ("<script>window.close();MM_openBrWindow('$volverA','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");

}
?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto  :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="../fs/imagenes/icoIngetec.ico">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<SCRIPT language=JavaScript>
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function envia2(){ 
	var v1, v2, v3, v4, chec;
	var m1, m2, m3, m4, msj, a, b, c, control;
	
	v1 = 's';
	v2 = 's';
	v3 = 's';
	v4 = 's';
	m1 = '';
	m2 = '';
	m3 = '';
	m4 = '';
	a = 1;
	c = 0;
	control = 0;


	/*
	while(a <= parseInt(document.form1.cantidadItem.value))
	{
		b = 1;
		c = c+1;
		chec = 0;
		while(b <= parseInt(document.form1.cantidadResp.value))
		{
			if(document.form1.elements[c].checked)
			{
				chec = chec+1;
			}
			c = c+2;
			b = b+1;
		}
		
		if(chec != 1)
		{
			control = control+1;
		}
		a = a+1;
	}
	
	if(control != 0)
	{
		v1 = 'n';
		m1 = 'Todos los items deben tener una única respuesta.';
	}*/

	var elLength = document.form1.elements.length;
	var cont=0;
	for (i=0; i<elLength; i++)
	{
		var type = form1.elements[i].type;
		if (type=="checkbox" && form1.elements[i].checked) 
		{	 cont=cont+1;  }
	}
	if((cont==0))
	{	v1='n';
		msj = 'Debe seleccionar por lo menos una opción. Verifique la infomación. \n'
	}
	
	if((v1=='s') && (v2=='s') && (v3=='s') && (v4=='s'))
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else{
//		msj = m1 + m2 + m3 + m4;
		alert(msj);
	}	
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#00344C">
<form name="form1" method="post" action="">
  <tr>
    <td>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><? echo $proyModulo;?></td>
      </tr>
    </table>

    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr class="TituloTabla2">
        <td><? echo $pTituloPpal ;?></td>
		<? mssql_data_seek($cursor2,0);
		while ($reg2 = mssql_fetch_array($cursor2)){ ?>
        <td><? echo $reg2[nomSubItem];?></td>
		<? } ?>
      </tr>
	  
	  <? 
	  $i=1;	
	  while ($reg=mssql_fetch_array($cursor)) 
	  { 
/*
	  	$sqlRta2 = $sqlRta. " AND codItem=".$reg[codItem];
		$cursorRta = mssql_query($sqlRta2);
//echo " regsitros 2.1 <br>".$sqlRta2." -- ".mssql_get_last_message()."<br><br>";	
		$regRta = mssql_fetch_array($cursorRta);
*/		
	  ?>
      <tr align="center" class="TxtTabla">
        <td align="left"><? echo $reg[nomItem]; ?>
          <input name="item<? echo $i; ?>" type="hidden" id="item<? echo $i; ?>" value="<? echo $reg[codItem]; ?>">
		</td>

		<? mssql_data_seek($cursor2,0);
		$j = 1;
		while($reg2 = mssql_fetch_array($cursor2)) {

			//Listado de Registros
			$sqlRta = "SELECT * FROM CSCPFichaInfoBooleanM ";
			$sqlRta = $sqlRta. " WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
			$sqlRta = $sqlRta. " AND codModulo=".$_SESSION["ccfModulo"] ;
			$sqlRta = $sqlRta. " AND numFormulario='".$_SESSION["ccfFormulario"]."'" ;
			$sqlRta= $sqlRta. " AND consecutivo=".$_SESSION["ccfConsecutivo"] ;
			$sqlRta = $sqlRta. " AND nroObjeto=".$nobj;
			$sqlRta = $sqlRta. " AND tipoObjeto=".$tipo;
			$sqlRta = $sqlRta. " AND codOpcion=".$Opc2;
			$sqlRta = $sqlRta. " AND codItem=".$reg[codItem];
			$sqlRta = $sqlRta. " and codSubItem=".$reg2[codSubItem];

//echo " regsitros 2.1 <br>".$sqlRta." -- ".mssql_get_last_message()."<br><br>";	

			$cursorRta = mssql_query($sqlRta);
			while($regRta = mssql_fetch_array($cursorRta))
			{
				$check2 = "";
				if($regRta[respItem] == "1")
				{
					$check2 = "checked";
				}
				?>
				<td align="center">
				<input name="<? echo $j; ?>aplicaResp<? echo $i; ?>" type="checkbox" id="<? echo $j; ?>aplicaResp<? echo $i; ?>" value="1" <? echo $check2; ?>  <? echo $dis; ?>>
				<input name="<? echo $j; ?>codResp<? echo $i; ?>" type="hidden" id="<? echo $j; ?>codResp<? echo $i; ?>" value="<? echo $reg2[codSubItem]; ?>">			</td>
				<?
				$j++;
			}

//echo " regsitros <br>".$sqlRta." -- ".mssql_get_last_message()."<br><br>";	
/*
			$sqlRta2 = "SELECT * FROM CSCPFichaInfoBooleanM";
			$sqlRta2 = $sqlRta2. " WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
			$sqlRta2 = $sqlRta2. " AND codModulo=".$_SESSION["ccfModulo"] ;
			$sqlRta2 = $sqlRta2. " AND numFormulario='".$_SESSION["ccfFormulario"]."'" ;
			$sqlRta2= $sqlRta2. " AND consecutivo=".$_SESSION["ccfConsecutivo"] ;
		//	$sqlRta2 = $sqlRta2. " AND nroObjeto=".$nobj;
			$sqlRta2 = $sqlRta2. " AND tipoObjeto=".$tipo;
			$sqlRta2 = $sqlRta2. " AND codOpcion=".$Opc2;
			$sqlRta2 = $sqlRta2. " AND codItem=".$reg[codItem];
//			$sqlRta2 = $sqlRta2. " AND codOpcionResp=".$Opc2;
//			$sqlRta2 = $sqlRta2. " AND codItemResp=".$reg2[codItem];
			$cursorRta2 = mssql_query($sqlRta2);
			$regRta2 = mssql_fetch_array($cursorRta2);
*/			
/*
			$check2 = "";
			if($regRta2[respItem] == "1")
			{
				$check2 = "checked";
			}
			?>
			<td align="center">
			<input name="<? echo $j; ?>aplicaResp<? echo $i; ?>" type="checkbox" id="<? echo $j; ?>aplicaResp<? echo $i; ?>" value="1" <? echo $check2; ?>  <? echo $dis; ?>>
			<input name="<? echo $j; ?>codResp<? echo $i; ?>" type="hidden" id="<? echo $j; ?>codResp<? echo $i; ?>" value="<? echo $reg2[codItem]; ?>">			</td>
			<?
			$j++;
*/
		}
//echo " regsitros 2 <br>".$sqlRta2." -- ".mssql_get_last_message()."<br><br>";	
		?>
      </tr>
	  <? 
	  $i=$i+1;
	  } ?>
    </table>
	
	<!-- Botones -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="cantidadResp" type="hidden" id="cantidadResp" value="<? echo mssql_num_rows($cursor2); ?>">
			<input name="cantidadItem" type="hidden" id="cantidadItem" value="<? echo mssql_num_rows($cursor); ?>">
			<input name="recarga" type="hidden" id="recarga" value="1">
			<?
			if($accion == 2)
			{
				$txt = "Grabar";
			}
			if($accion == 3)
			{
				$txt = "Eliminar";
			}
			?>
			<input name="Submit" type="button" class="Boton" value="<? echo $txt; ?>" onClick="envia2()">
			<? if ($accion==3)
		   	{ ?> <input name="Cancelar" type="button" class="Boton" id="Cancelar" 
				 onClick="window.close();" value="Cancelar">
			<? } ?>
		</td>
      </tr>
    </table>
	
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="copyr"> powered by INGETEC S.A - 2012 </td>
	  </tr>
	</table>	</td>
  </tr>
  </form>
</table>

</body>
</html>

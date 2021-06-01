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
$conexion = conectar();

//Trae la información del Modulo
//dbo.tmModulos
//codModulo, nomModulo, siglaModulo, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlPC01="SELECT * FROM tmModulos WHERE codModulo= " .$_SESSION["sgcModulo"] ; 
$cursorPC01 = mssql_query($sqlPC01) ;
if ($regPC01=mssql_fetch_array($cursorPC01)) 
{
	$proyModulo=$regPC01[nomModulo];
}

//Obtener Titulo y/o Pregunta de la Sección
//dbo.tmOpciones
//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
//dbo.tmItems
//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
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
//dbo.tmOpciones
//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
//dbo.tmItems
//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sql = "SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
		tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
		FROM tmOpciones INNER JOIN
		tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		tmOpciones.codOpcion = tmItems.codOpcion";
$sql= $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sql= $sql. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sql= $sql. " AND tmOpciones.codOpcion=".$Opc;
$cursor = mssql_query($sql);

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

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	//Grabar Registros 
	//dbo.CSEFichaInfoBoolean
	//codModulo, predioNo, nroEncuesta, nroVivienda, nroFamilia, codItem, respItem, descripcion, fechaGraba, usuarioGraba, 
	//fechaMod, usuarioMod
	$s = 1;
	$insertion = "";
	while ($s <= $cantidadItem) 
	{
		$elCod = "item" . $s;
		$aplica = "aplica" . $s;
		$laDescipcion = "descripcion" . $s ;
		$sqlIn = "INSERT INTO CSCPFichaInfoBoolean(codProyecto, codModulo, numFormulario, consecutivo, nroObjeto, tipoObjeto, 
				  codOpcion, codItem, respItem, descripcion,fechaGraba, usuarioGraba) ";
		$sqlIn = $sqlIn." VALUES ( ";
		$sqlIn = $sqlIn. $_SESSION["ccfProyecto"].", ";	
		$sqlIn = $sqlIn. $_SESSION["ccfModulo"].", ";	
		$sqlIn = $sqlIn. "'".$_SESSION["ccfFormulario"]."', ";	
		$sqlIn= $sqlIn. " ".$_SESSION["ccfConsecutivo"]."," ;
		$sqlIn=  $sqlIn. $nobj.", ";
		$sqlIn=  $sqlIn. $tipo.", ";
		$sqlIn=  $sqlIn. $Opc.", ";
		$sqlIn = $sqlIn. ${$elCod} .", ";
		if (${$aplica}=='')
		{
			${$aplica}=0;
		}
		$sqlIn = $sqlIn. " '" . ${$aplica} ."', ";
		if (${$aplica}==0)
		{
			${$laDescipcion}='';
		}		
		$sqlIn = $sqlIn. " '" . ${$laDescipcion} ."', ";
		$sqlIn = $sqlIn. " '" . gmdate("n/d/y") ."', ";
		$sqlIn = $sqlIn . " '".$_SESSION["ccfUsuID"]."' " ;
		$sqlIn = $sqlIn." ) ";
		$cursorIn = mssql_query($sqlIn);
		$s = $s + 1;		
	}
		
	if  (trim($cursorIn) != "") 
	{
		echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
	} 
	else 
	{
		echo ("<script>alert('Error durante la grabación');</script>");
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
        <td rowspan="2"><? echo $pTituloPpal ;?></td>
        <td>Aplica</td>
        <td width="8%" rowspan="2">No.</td>
        </tr>
      <tr class="TituloTabla2">
        <td width="8%">Si</td>
        </tr>
	  <?php 
	  $i=1;	
	  while ($reg=mssql_fetch_array($cursor)) 
	  { ?>
      <tr align="center" class="TxtTabla">
        <td align="left">
          <?php echo $reg[nomItem];  ?>
          <input name="item<? echo $i; ?>" type="hidden" id="item<? echo $i; ?>" value="<? echo $reg[codItem];  ?>">		</td>
        <td width="8%" align="center">
			<input name="aplica<? echo $i; ?>" type="checkbox" value="1">		</td>
        <td width="8%" align="center">
<input name="descripcion<? echo $i; ?>" type="text" class="CajaTexto" id="descripcion<? echo $i; ?>" size="50" ></td>
        </tr>
	  <? 
	  $i=$i+1;
	  } ?>
    </table>
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="cantidadItem" type="hidden" id="cantidadItem" value="<? echo mssql_num_rows($cursor); ?>">
			<input name="recarga" type="hidden" id="recarga" value="2">
			<input name="Submit" type="submit" class="Boton" value="Grabar" >		  
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

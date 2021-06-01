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
$sqlPC01="SELECT * FROM tmModulos WHERE codModulo= " .$_SESSION["ccfModulo"] ; 
$sqlPC01= $sqlPC01. " and tmModulos.codProyecto=".$_SESSION["ccfProyecto"] ;
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
$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
FROM tmOpciones INNER JOIN
     tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
     tmOpciones.codOpcion = tmItems.codOpcion";
$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$Opc;
$cursorTit = mssql_query($sqlTit);
if ($regTit=mssql_fetch_array($cursorTit)) 
{
	$pTituloPpal=$regTit[pregunta];
}

$tipo=$_REQUEST["tipo"];
//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

$tipo = $_GET["tipo"];
//Listado de Registros
//dbo.CSCPFichaInfoBoolean
//codModulo, predioNo, nroEncuesta, nroVivienda, nroFamilia, codItem, respItem, queEs, fechaGraba, usuarioGraba, 
//fechaMod, usuarioMod
//Listado de Registros
//dbo.CSCPFichaInfoBoolean
//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, respItem, 
//descripcion, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlRta=" SELECT     CSCPFichaInfoBoolean.codProyecto, CSCPFichaInfoBoolean.codModulo, CSCPFichaInfoBoolean.numFormulario, CSCPFichaInfoBoolean.nroObjeto, 
CSCPFichaInfoBoolean.tipoObjeto, CSCPFichaInfoBoolean.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoBoolean.codItem, tmItems.nomItem, 
CSCPFichaInfoBoolean.respItem, CSCPFichaInfoBoolean.descripcion
FROM         CSCPFichaInfoBoolean INNER JOIN
tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem AND 
tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
$sqlRta= $sqlRta. " WHERE CSCPFichaInfoBoolean.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.consecutivo=".$_SESSION["ccfConsecutivo"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;

$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.nroObjeto=".$nobj;

$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.tipoObjeto=".$tipo;
$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.codOpcion=".$Opc;
$cursor = mssql_query($sqlRta);

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	$sqlIn1 = " DELETE FROM CSCPFichaInfoBoolean ";
	$sqlIn1= $sqlIn1. " WHERE CSCPFichaInfoBoolean.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlIn1= $sqlIn1. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlIn1= $sqlIn1. " AND CSCPFichaInfoBoolean.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$sqlIn1= $sqlIn1. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;
$sqlIn1= $sqlIn1. " AND CSCPFichaInfoBoolean.nroObjeto=".$nobj;
	$sqlIn1= $sqlIn1. " AND CSCPFichaInfoBoolean.tipoObjeto=".$tipo;
	$sqlIn1= $sqlIn1. " AND CSCPFichaInfoBoolean.codOpcion=".$Opc;
	$cursorIn = mssql_query($sqlIn1);
	
	if  (trim($cursorIn) != "") 
	{  
		if ($accion==2)
		{ 
			//Grabar Registros 
			//dbo.CSCPFichaInfoBoolean
			//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, respItem, 
			//descripcion, fechaGraba, usuarioGraba, fechaMod, usuarioMod
			$s = 1;
			$insertion = "";
			while ($s <= $cantidadItem) 
			{
				$elCod = "item" . $s;
				$aplica = "aplica" . $s;
				$sqlIn = "INSERT INTO CSCPFichaInfoBoolean(codProyecto, codModulo, numFormulario, consecutivo, nroObjeto, tipoObjeto, 
						  codOpcion, codItem, respItem, fechaGraba, usuarioGraba) ";
				$sqlIn = $sqlIn." VALUES ( ";
				$sqlIn = $sqlIn . $_SESSION["ccfProyecto"] . ",";
				$sqlIn = $sqlIn . $_SESSION["ccfModulo"] . ",";
				$sqlIn = $sqlIn . "'".$_SESSION["ccfFormulario"] . "',";
				$sqlIn= $sqlIn. " ".$_SESSION["ccfConsecutivo"]."," ;
				$sqlIn = $sqlIn . $nobj. ",";
				$sqlIn = $sqlIn . $tipo.", ";
				$sqlIn = $sqlIn . $Opc.", ";	
				$sqlIn = $sqlIn. ${$elCod} .", ";
				if (${$aplica}=='')
				{
					${$aplica}=0;
				}
				$sqlIn = $sqlIn. " '" . ${$aplica} ."', ";
				$sqlIn = $sqlIn. " '" . gmdate("n/d/y") ."', ";
				$sqlIn = $sqlIn . " '".$_SESSION["ccfUsuID"]."' " ;
				$sqlIn = $sqlIn." ) ";
				$insertion = $insertion.$sqlIn."<br>";
				$cursorIn = mssql_query($sqlIn);
				$s = $s + 1;		
			}
	   }	
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
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<SCRIPT language=JavaScript>
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
function envia1()
{ 
	document.form1.recarga.value="1";
	document.form1.submit();
}

function envia2()
{ 
var v1,v2,v3, i, CantCampos, msg1, msg2, msg3, mensaje;
v1='s';
v2='s';
v3='s';
msg1 = '';
msg2 = '';
msg3 = '';
mensaje = '';

if(document.form1.accion.value==2)
{	var elLength = document.form1.elements.length;
	var cont=0;
	for (i=0; i<elLength; i++)
	{
    	var type = form1.elements[i].type;
 		if (type=="checkbox" && form1.elements[i].checked) 
		{	 cont=cont+1;  }
	}
   	if(((document.form1.rta.value==1)&&(cont>1))||((document.form1.rta.value==1)&&(cont<1)))
	{	v1='n';
		msg1 = 'Se requiere única respuesta. Verifique la infomación. \n'
	}

	if((document.form1.rta.value==2)&&(cont==0))
	{	v1='n';
		msg1 = 'Debe seleccionar por lo menos una opción. Verifique la infomación. \n'
	}
}
//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s')) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 ;
		alert (mensaje);
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
    
    <!-- NOMBRE DEL MODULO-->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><? echo $proyModulo;?></td>
      </tr>
    </table>

	<!-- TABLA DE INFORMACION-->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr class="TituloTabla2">
        <td rowspan="2"><? echo $pTituloPpal ;?></td>
        <td>Aplica</td>
        </tr>
      <tr class="TituloTabla2">
        <td width="8%">Si</td>
        </tr>
	  <?php 
	  $i=1;	
	  $cursorRta = mssql_query($sqlRta);
	  while ($reg=mssql_fetch_array($cursorRta)) 
	  { ?>
      <tr align="center" class="TxtTabla">
        <td align="left">
          <?php echo $reg[nomItem];  ?>
          <input name="item<? echo $i; ?>" type="hidden" id="item<? echo $i; ?>" value="<? echo $reg[codItem];  ?>">		</td>
        <td width="8%" align="center">
			<input name="aplica<? echo $i; ?>" type="checkbox" value="1" 
			<? $aplica="aplica" .$i ; if ($reg[respItem]==1) { echo "checked='checked'" ;} ?>
			<? if ($accion==3) { echo "disabled";}?>>		
			</td>
        </tr>
	  <? 
	  $i=$i+1;
	  } ?>
    </table>
    
    <!-- BOTONES-->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="cantidadItem" type="hidden" id="cantidadItem" value="<? echo mssql_num_rows($cursor); ?>">
			<input name="recarga" type="hidden" id="recarga" value="1">
            <input name="accion" type="hidden" id="accion" value="<? echo $accion;?>">
             <input name="rta" type="hidden" id="rta" value="<? echo $uni;?>">
			<input name="Submit" type="submit" class="Boton"  
			value="<? if ($accion==3) { echo "Borrar"; } else { echo "Grabar"; } ?>"  onClick="envia2()">
			<? if ($accion==3)
		   	{ ?> <input name="Cancelar" type="button" class="Boton" id="Cancelar" 
				 onClick="MM_callJS('window.close();')" value="Cancelar">
			<? } ?>		</td>
      </tr>
    </table>
    
    <!--ESPACIO -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	
 	<!--DERECHO DE AUTOR -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="copyr"> powered by INGETEC S.A - 2012 </td>
      </tr>
    </table>		
 
    </td>
  </tr>
  </form>
</table>

</body>
</html>

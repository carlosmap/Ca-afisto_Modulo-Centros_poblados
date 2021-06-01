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

//echo $sqlTit." -- ".mssql_get_last_message()."<br><br>";

if ($regTit=mssql_fetch_array($cursorTit)) 
{
	$pTituloPpal=$regTit[pregunta];
}

//Trae la información de los items
//dbo.tmOpciones
//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
//dbo.tmItems
//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sql="SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
FROM tmOpciones INNER JOIN
     tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
     tmOpciones.codOpcion = tmItems.codOpcion";
$sql= $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sql= $sql. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sql= $sql. " AND tmOpciones.codOpcion=".$Opc;
$cursor = mssql_query($sql);

//echo $sql." -- ".mssql_get_last_message()."<br><br>";

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
	//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, respItem, 
	//descripcion, fechaGraba, usuarioGraba, fechaMod, usuarioMod

	$s = 1;
	$insertion = "";
	while ($s <= $cantidadItem) 
	{
		$elCod = "item" . $s;
		$aplica = "aplica" . $s;
		$sqlIn = "INSERT INTO CSCPFichaInfoBoolean(codProyecto, codModulo, numFormulario,consecutivo, nroObjeto, tipoObjeto, 
				  codOpcion, codItem, respItem, fechaGraba, usuarioGraba) ";
		$sqlIn = $sqlIn." VALUES ( ";
		$sqlIn = $sqlIn . $_SESSION["ccfProyecto"] . ",";
		$sqlIn = $sqlIn . $_SESSION["ccfModulo"] . ",";
		$sqlIn = $sqlIn . "'".$_SESSION["ccfFormulario"] . "',";
		$sqlIn = $sqlIn . "'".$_SESSION["ccfConsecutivo"] . "',";
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
//echo $sqlIn." -- ".mssql_get_last_message()."<br>";

		$s = $s + 1;	
	}
		
	if  (trim($cursorIn) != " ") 
	{
		echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
	} 
	else 
	{
		echo ("<script>alert('Error durante la grabación');</script>");
	}

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

var elLength = document.form1.elements.length;
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
	  while ($reg=mssql_fetch_array($cursor)) 
	  { ?>
      <tr align="center" class="TxtTabla">
        <td align="left">
          <?php echo $reg[nomItem];  ?>
          <input name="item<? echo $i; ?>" type="hidden" id="item<? echo $i; ?>" value="<? echo $reg[codItem];  ?>">			
        </td>
        <td width="8%" align="center">
			<input name="aplica<? echo $i; ?>" type="checkbox" value="1">		</td>
        </tr>
	  <? 
	  $i=$i+1;
	  } ?>
    </table>
    
    <!-- BOTONES -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="cantidadItem" type="hidden" id="cantidadItem" value="<? echo mssql_num_rows($cursor); ?>">
            <input name="rta" type="hidden" id="rta" value="<? echo $uni; ?>">
			<input name="recarga" type="hidden" id="recarga" value="1">
			<input name="Submit" type="submit" class="Boton" value="Grabar" onClick="envia2()">		  
		</td>
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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>
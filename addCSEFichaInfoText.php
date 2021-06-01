<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php

//Patricia Gutiérrez Restrepo
//Adicionar Información Observaciones y opiniones

//Inicializa las variables de sesión
session_start();

//Validación de Ingreso
//include ("../verificaIngreso2.php");
include ("../validaUsu.php");

//Abre la conexión a la BD
//include('../enlaceBD.php');

//Libreria de Funciones
//include('funcionesCSE.php');
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
//dbo.tmOpciones
//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
//dbo.tmItems
//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
FROM tmOpciones INNER JOIN
     tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
     tmOpciones.codOpcion = tmItems.codOpcion";
$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["sgcProyecto"] ;
$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["sgcModulo"] ;
$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$Opc;
$cursorTit = mssql_query($sqlTit);

if ($regTit=mssql_fetch_array($cursorTit)) 
{
	$pTituloPpal=$regTit[pregunta];
	$pTituloSec=$regTit[nomItem];
	$pcodItem=$regTit[codItem];
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
$sql= $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["sgcProyecto"] ;
$sql= $sql. " AND tmOpciones.codModulo=".$_SESSION["sgcModulo"] ;
$sql= $sql. " AND tmOpciones.codOpcion=".$Opc;
$cursor = mssql_query($sql);

//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
switch ($tipo) 
{ 
	case 0: 
		$nobj=$_SESSION["sgcEncuesta"]; break; 
	case 1: 
		$nobj=$_SESSION["sgcPredio"]; break; 
	case 2: 
		$nobj=$_SESSION["sgcVivienda"]; break; 
	case 3: 
		$nobj=$_SESSION["sgcFamilia"]; break; 
} 
		
//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{

//dbo.CSEFichaInfoText
//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, descripcion, codItemRespuesta, fechaGraba, usuarioGraba, fechaMod, usuarioMod

	$qry = "INSERT INTO CSEFichaInfoText (codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, descripcion, codItemRespuesta,fechaGraba, usuarioGraba)";	
	$qry = $qry. " VALUES( ";
	$qry = $qry. $_SESSION["sgcProyecto"].", ";	
	$qry = $qry. $_SESSION["sgcModulo"].", ";	
	$qry = $qry. "'".$_SESSION["sgcEncuesta"]."', ";	
	$qry = $qry . $nobj. ",";
	$qry = $qry . $tipo.", ";
	$qry = $qry . $Opc.", ";	
	$qry = $qry . $pcodItem .",";
	$qry = $qry . "'".$descripcion ."',";
	if(trim($Opc1)==0)
	{	$qry = $qry . "NULL,";
	}
	else
	{
		$qry = $qry . $lstOpcion . ",";
	}
	$qry = $qry. "'" . gmdate("n/d/y") ."', ";
	$qry = $qry. "'".$_SESSION["sgcUsuID"]."') " ;	
	//echo $qry;
	//exit;
	$cursorIn = mssql_query($qry) ;
	if  (trim($cursorIn) != "")  
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
<link rel="shortcut icon" href="../fs/imagenes/icoIngetec.ico">
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
var v1,v2,v3, v4,v5,v6,v7,v8,v9,v10, i, CantCampos, msg1, msg2, msg3, msg4, mensaje;
v1='s';
v2='s';
v3='s';
v4='s';
v5='s';
v6='s';
v7='s';
v8='s';
v9='s';
v10='s';
msg1 = '';
msg2 = '';
msg3 = '';
msg4 = '';
msg5 = '';
msg6 = '';
msg7 = '';
msg8 = '';
msg9 = '';
msg10 = '';

mensaje = '';

/*if (document.form1.descripcion.value == '') 
{
	v1='n';
	msg1 = 'La información solicitada es obligatoria. \n'
}*/

//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s') && (v5=='s') &&
	    (v6=='s')&& (v7=='s')&& (v8=='s')&& (v9=='s')&& (v10=='s')) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else {
		mensaje = msg1 + msg2 + msg3 + msg4+msg5 + msg6 + msg7 + msg8+msg9 + msg10;
		alert (mensaje);
	}
	
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#436F89">
<form name="form1" method="post" action="">

<tr>
<td bgcolor="#FFFFFF">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>

    <!-- NOMBRE DEL MODULO-->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><? echo $proyModulo;?></td>
      </tr>
    </table>
        
    <!-- TITULO GENERAL -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td class="TituloTabla" align="center"><? echo $pTituloPpal;?></td>
      	</tr>
    </table>
	
	<!--TABLA DESCRIPCION -->
	<table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
    <? if(trim($Opc1)!=0) 
		{ ?> 
            <tr>			
			<td class="TxtTabla" colspan="2"><?
			//Trae la información de los items
			//dbo.tmOpciones
			//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, 
			//usuarioGraba, fechaMod, usuarioMod
			//dbo.tmItems
			//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
			$sql="SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			FROM tmOpciones INNER JOIN
				 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
				 tmOpciones.codOpcion = tmItems.codOpcion";
			$sql= $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["sgcProyecto"] ;
			$sql= $sql. " AND tmOpciones.codModulo=".$_SESSION["sgcModulo"] ;
			$sql= $sql. " AND tmOpciones.codOpcion=".$Opc1;
			$cursor1 = mssql_query($sql);
			?>
			<select name="lstOpcion<? echo $i; ?>" class="CajaTexto" id="lstOpcion<? echo $i; ?>">
			<?php 
			while ($reg1=mssql_fetch_array($cursor1)) 
			{ ?>
			  <option value="<?php echo $reg1[codItem]; ?>"><?php echo $reg1[nomItem]; ?></option>
			<? } ?>
			</select></td>
		</tr>
        <tr>			
			<td class="TituloTabla" colspan="2"> <? echo $pTituloSec ;?></td>
		</tr>
   <? } ?>  
   		  
		<tr>			
			<td class="TxtTabla" colspan="2"><textarea name="descripcion" cols="140" rows="5" class="CajaTexto" id="descripcion" ><? echo $descripcion ; ?></textarea></td>
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
</table>


    
</td>
</tr>
</form>  
</table>      
</body>
</html>

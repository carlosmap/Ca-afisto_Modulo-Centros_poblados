<?php
//17Julio 2001
//Patricia Gutiérrez Restrepo
//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');

//Abre la conexión a la BD
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

//Trae la información de relacion de las Viviendas asociadas al predio
//dbo.CSCPFichaVivienda
//nroVivienda, tipoInformacion, unidadCensal, totalHogares, fechaGraba, usuarioGraba, fechaMod, usuarioMod
//dbo.CSCPFichaPrediosVsVivienda
//codProyecto, codModulo, numFormulario, consecutivo, nroPredio, nroVivienda, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sql0= "SELECT A.*, B.codProyecto, B.codModulo, B.numFormulario, B.consecutivo, B.nroPredio, B.nroVivienda, 
	B.fechaGraba, B.usuarioGraba, B.fechaMod, B.usuarioMod
	FROM CSCPFichaVivienda A, CSCPFichaPrediosVsVivienda B
	WHERE A.nroVivienda = B.nroVivienda ";
$sql0 = $sql0 . " and B.codProyecto = ".$_SESSION["ccfProyecto"] ;
$sql0 = $sql0 . " and B.codModulo = ".$_SESSION["ccfModulo"] ;
$sql0 = $sql0 . " and B.numFormulario = '".$_SESSION["ccfFormulario"] ."'";
$sql0 = $sql0 . " and B.consecutivo = ".$_SESSION["ccfConsecutivo"] ;
$sql0 = $sql0 . " and B.nroPredio = '".$_SESSION["ccfPredio"]."'" ;
//$sql0 = $sql0 . " and B.nroVivienda = ".$_SESSION["ccfVivienda"] ;
$cursor00 = mssql_query($sql0);

/*
if(trim($miAncla) != "")
{
	echo "<script>location.href=\"frmCensoSocialViviendaDet.php#$miAncla\"</script>";
}
*/

?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto  :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
window.name="winCensos";
</script><SCRIPT language=JavaScript>
<!--
function mOvr(src,clrOver) {
    if (!src.contains(event.fromElement)) {
	  src.style.cursor = 'hand';
	  src.bgColor = clrOver;
	}
  }
  function mOut(src,clrIn) {
	if (!src.contains(event.toElement)) {
	  src.style.cursor = 'default';
	  src.bgColor = clrIn;
	}
  }
  function mClk(src) {
    if(event.srcElement.tagName=='TD'){
	  src.children.tags('A')[0].click();
    }
  }

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#376B9A">
<form action="" method="post" name="form1">
  <tr>
    <td>
	
    <!--BANNER -->
    <table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include ("bannerCSCP2.php");?></td>
      </tr>
    </table>
   
	<!--TABLA INFORMACION -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	<table width="100%"  border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td width="10%" class="TituloTabla2">Predio</td>
        <td width="10%" class="TituloTabla2">Unidad Censal</td>
        <td width="19%" class="TituloTabla2">Nro Vivienda</td>
        <td width="19%" class="TituloTabla2">Informaci&oacute;n Detallada de la Vivienda</td>
        <td width="26%" class="TituloTabla2">Hogares</td>
        <td width="2%" class="TituloTabla2">&nbsp;</td>
		<td width="2%" class="TituloTabla2">&nbsp;</td>
        </tr>

     <?php 
	 while ($reg0=mssql_fetch_array($cursor00)) { 
	 ?> 
      <tr class="TxtTabla">
        <td width="10%" align="center" class="TxtTabla"><? echo $reg0[nroPredio];?></td>
        <td width="10%" align="center" class="TxtTabla"><? echo $reg0[unidadCensal];?></td>
        <td width="19%" class="TxtTabla" align="center"><? echo $reg0[nroVivienda];?></td>
        <td width="19%" class="TxtTabla" align="center">
          <? 
//		  if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13) OR ($_SESSION["ccfUsuPerfil"] == 18)) 		{ 
		
		?>
          <img src="../images/icoVivienda.gif" style="cursor:pointer " alt="Informaci&oacute;n de Viviendas" width="25" height="24" border="0" onClick="MM_goToURL('parent','cargaVivienda.php?cualV=<? echo $reg0[nroVivienda] ; ?>&cualPagina=3');return document.MM_returnValue">            
          <? // } ?></td>
        <td width="26%" class="TxtTabla" align="center">
		<? // if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13) OR ($_SESSION["ccfUsuPerfil"] == 18))  { ?>          <!--
            <input name="sethref" type="button" class="Boton" onClick='show()' value="Información Detallada Predio"> -->
          <img src="../images/icoFamilia.gif" style="cursor:pointer " alt="Informaci&oacute;n de Hogares" width="23" height="20" border="0" onClick="MM_goToURL('parent','cargaVivienda.php?cualV=<? echo $reg0[nroVivienda] ; ?>&cualPagina=4');return document.MM_returnValue">   
          <? // } ?></td>
        <td width="2%" class="TxtTabla"><!--<a href="#"><img src="../images/imgUp.gif" alt="Editar Unidad Social" width="14" height="13" border="0" onClick="MM_openBrWindow('upVivienda.php?accion=2&v=<? //=$reg0[nroVivienda];?>','vAF','scrollbars=yes,resizable=yes,width=850,height=300')"></a>--></td>
        <td width="2%" class="TxtTabla"><a href="#"><img src="../images/del.gif" alt="Eliminar Unidad Social" width="14" height="13" border="0" onClick="MM_openBrWindow('upViviendas.php?accion=4&v=<?=$reg0[nroVivienda];?>','vAF','scrollbars=yes,resizable=yes,width=850,height=300')"></a></td>      
      </tr>
     <? } ?> 
    </table>

	<!--BOTON NUEVA VIVIENDA -->
 	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>
        	<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addViviendas.php?accion=1','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" value="Nueva Vivienda">
        </td>
	  </tr>
	</table>
	
    <!--ESPACIO -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
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
        <td class="copyr"> powered by INGETEC S.A - 2012</td>
      </tr>
    </table>		
	
	
	</td>
  </tr>
</form>  
</table>

</body>
</html>

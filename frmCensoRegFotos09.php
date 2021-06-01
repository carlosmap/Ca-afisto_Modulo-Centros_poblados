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

//Búsqueda de la información del registro fotográfico
$sqlFot = "SELECT CSCPFichaFotos.codProyecto, CSCPFichaFotos.codModulo, CSCPFichaFotos.numFormulario, CSCPFichaFotos.consecFoto, CSCPFichaFotos.codItemElemento, 
			CSCPFichaFotos.codSubItemAspecto, CSCPFichaFotos.nroRegistro, CSCPFichaFotos.archivoFoto, tmItems.nomItem AS elemento, 
			tmItems_1.nomSubItem AS aspecto
			FROM CSCPFichaFotos 
			LEFT OUTER JOIN tmSubItems AS tmItems_1 ON CSCPFichaFotos.codSubItemAspecto = tmItems_1.codSubItem 
			LEFT OUTER JOIN tmItems ON CSCPFichaFotos.codItemElemento = tmItems.codItem";
$sqlFot = $sqlFot . " WHERE CSCPFichaFotos.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlFot = $sqlFot . " AND CSCPFichaFotos.codModulo=".$_SESSION["ccfModulo"] ;
$sqlFot = $sqlFot . " AND CSCPFichaFotos.numFormulario='".$_SESSION["ccfFormulario"] ."'  AND CSCPFichaFotos.codItemElemento IS NOT NULL";
$cursorFot = mssql_query($sqlFot);
#echo $sqlFot;
?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
<form action="" method="post" name="form1">
  <tr>
    <td>
	
    <!--BANNER -->
    <table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include ("bannerCSCP2.php");?></td>
      </tr>
    </table>
   
	<!-- TITULO REG. FOTOGRÁFICO -->
	<table width="100%"  border="0">
	  <tr>
		<td align="center" class="TituloTabla">9. REGISTRO FOTOGRÁFICO</td>
	  </tr>
	</table>

	<!-- REGISTRO FOTOGRÁFICO -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="1">
      <tr>
        <td class="TituloTabla2">Elemento fotografiado</td>
        <td width="31%" class="TituloTabla2">Aspecto registrado </td>
        <td width="31%" class="TituloTabla2">N&uacute;mero de registro </td>
        <td width="2%" align="center" class="TituloTabla2">&nbsp;</td>
        <td width="2%" align="center" class="TituloTabla2">&nbsp;</td>
		<td width="2%" align="center" class="TituloTabla2">&nbsp;</td>
        </tr>

     <?
	 while ($regFot = mssql_fetch_array($cursorFot)) 
	 { 
	 ?> 
      <tr class="TxtTabla">
        <td align="center" class="TxtTabla"><? echo $regFot[elemento];?></td>
        <td width="31%" align="center" class="TxtTabla"><? echo $regFot[aspecto];?></td>
        <td width="31%" align="center" class="TxtTabla"><? echo $regFot[nroRegistro];?></td>
        <td width="2%" align="center" class="TxtTabla"><a href="#">
        <img src="../images/lupa.gif" alt="Editar Encuesta" width="14" height="13" border="0" onClick="MM_openBrWindow('regFotos/<?=$regFot[archivoFoto];?>','vAF','scrollbars=yes,resizable=yes')">
        </a>
        </td>
        <td width="2%" align="center" class="TxtTabla">
        <a href="#">
        <img src="../images/imgUp.gif" alt="Editar Encuesta" width="14" height="13" border="0" onClick="MM_openBrWindow('upFotos.php?accion=2&f=<?=$regFot[consecFoto];?>','vAF','scrollbars=yes,resizable=yes,width=850,height=300')">
        </a>
        </td>
        <td width="2%" align="center" class="TxtTabla">
        <a href="#">
        <img src="../images/del.gif" alt="Eliminar Unidad Social" width="14" height="13" border="0" onClick="MM_openBrWindow('upFotos.php?accion=3&f=<?=$regFot[consecFoto];?>','vAF','scrollbars=yes,resizable=yes,width=850,height=300')">
        </a>
        </td>      
      </tr>
     <? } ?> 
    </table> 

	<!--BOTONES -->
 	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>
        <?	if( ( $_SESSION['ccfUsuPerfil'] == 1 ) || ( $_SESSION['ccfUsuPerfil'] == 2 ) || ( $_SESSION['ccfUsuPerfil'] == 3 ) ){	?>
        	<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addFotosReg.php?accion=1','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" value="Nuevo">
        <?	}	?>
        </td>
	  </tr>
	</table>
	
    <!--ESPACIO -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	
	<!-- TÍTULO RESULTADOS-->
	<table width="100%"  border="0">
	  <tr>
		<td align="center" class="TituloTabla">10. RESULTADO DE LA VISITA </td>
	  </tr>
	</table>
	
	<? //Búsqueda de la información de los resultados
	$sqlRes = "SELECT * FROM CSCPFicha";
	$sqlRes = $sqlRes." WHERE CSCPFicha.codProyecto =".$_SESSION["ccfProyecto"];
	$sqlRes = $sqlRes." AND CSCPFicha.codModulo =".$_SESSION["ccfModulo"];
	$sqlRes = $sqlRes." AND CSCPFicha.numFormulario =".$_SESSION["ccfFormulario"];
	$cursorRes = mssql_query($sqlRes);
	$regRes = mssql_fetch_array($cursorRes);
	?>
	<!-- INFORMACIÓN RESULTADOS -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
		<td width="30%" class="TituloTabla1">10.1 Hora de finalizaci&oacute;n </td>
	    <td width="70%" class="TxtTabla"><? echo $regRes[horaFinal]; ?></td>
	  </tr>
	  <tr>
	    <td width="30%" class="TituloTabla1">10.2 Fecha de la visita </td>
	    <td width="70%" class="TxtTabla"><? 
		if($regRes[fechaVisita])
		{
			echo date("d/m/Y", strtotime($regRes[fechaVisita])); 
		}
		?></td>
	  </tr>
	  <tr>
	    <td width="30%" class="TituloTabla1">10.3 N&uacute;mero de visita </td>
	    <td width="70%" class="TxtTabla"><? echo $regRes[numVisita]; ?></td>
	  </tr>
	</table>
	
	<!-- Botones -->
	<? 
	if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3) )//OR ($_SESSION["ccfUsuPerfil"] == 13))
	{
	?>
	<table width="100%"  border="0">
	  <tr>
		<td align="right">
        <input name="Submit2" type="button" class="Boton" value="Editar" onClick="MM_openBrWindow('upResultadoVisita.php?accion=2','vAF','scrollbars=yes,resizable=yes,width=500,height=300')">
		  <input name="Submit3" type="button" class="Boton" value="Eliminar" onClick="MM_openBrWindow('upResultadoVisita.php?accion=3','vAF','scrollbars=yes,resizable=yes,width=500,height=300')"></td>
	  </tr>
	</table>
	<?
	}
	
	Genera_Tabla_Seleccion( 115, 1, 20, 0 );

	?>

	<!-- Espacio -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

	<?
	//17.4 Resultado de la visita
	#Genera_Tabla_Seleccion(118,0,17,0);	//(Opcion,Múltiple Respuesta,Pagina a la que Regresa,Tipo de Objeto)
	?>

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

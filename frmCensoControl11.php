<?php

//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');

//Abre la conexión a la BD
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

?>


<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
window.name="winCensos";
</script>
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
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
  <tr>
    <td>
	
	<table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include ("bannerCSCP2.php");?></td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
	<!-- TÍTULO CONTROL DEL TRABAJO -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
		<td colspan="4" align="center" class="TituloTabla">11. CONTROL DEL TRABAJO DE CAMPO</td>
	  </tr>
	</table>
	
	<? //Búsqueda de la información de las firmas almacenadas
	/*
	$sqlFirma = "SELECT CSCPFichaFirmas.codProyecto, CSCPFichaFirmas.codModulo, CSCPFichaFirmas.numFormulario, CSCPFichaFirmas.consecFirma, 
				 CSCPFichaFirmas.codItemTipoResponsable, CSCPFichaFirmas.usuarioResponsable, CSCPFichaFirmas.fechaVerifica, CSCPFichaFirmas.observaciones, 
				 tmItems.nomItem, tmUsuarios.nombreUsuario, tmUsuarios.apellidoUsuario
				 FROM CSCPFichaFirmas INNER JOIN
				 tmItems ON CSCPFichaFirmas.codItemTipoResponsable = tmItems.codItem LEFT OUTER JOIN
				 tmUsuarios ON CSCPFichaFirmas.usuarioResponsable = tmUsuarios.numDocumento";
	$sqlFirma = $sqlFirma." WHERE CSCPFichaFirmas.codProyecto = ".$_SESSION["ccfProyecto"];
	$sqlFirma = $sqlFirma." AND CSCPFichaFirmas.codModulo = ".$_SESSION["ccfModulo"];
	$sqlFirma = $sqlFirma." AND CSCPFichaFirmas.numFormulario = ".$_SESSION["ccfFormulario"];
	*/
	$sqlFirma = "SELECT CSCPFichaFirmas.codProyecto, CSCPFichaFirmas.codModulo, CSCPFichaFirmas.numFormulario, CSCPFichaFirmas.consecFirma, 
				 CSCPFichaFirmas.codItemTipoResponsable, CSCPFichaFirmas.usuarioResponsable, CSCPFichaFirmas.fechaVerifica
				 , CSCPFichaFirmas.horaVerifica, CSCPFichaFirmas.observaciones, 
				 tmPerfiles.nomPerfil, tmUsuarios.nombreUsuario, tmUsuarios.apellidoUsuario
				 FROM CSCPFichaFirmas INNER JOIN
				 tmPerfiles ON CSCPFichaFirmas.codItemTipoResponsable = tmPerfiles.codPerfil LEFT OUTER JOIN
				 tmUsuarios ON CSCPFichaFirmas.usuarioResponsable = tmUsuarios.numDocumento";
	$sqlFirma = $sqlFirma." WHERE CSCPFichaFirmas.codProyecto = ".$_SESSION["ccfProyecto"];
	$sqlFirma = $sqlFirma." AND CSCPFichaFirmas.codModulo = ".$_SESSION["ccfModulo"];
	$sqlFirma = $sqlFirma." AND CSCPFichaFirmas.numFormulario = ".$_SESSION["ccfFormulario"];
	$cursorFirma = mssql_query($sqlFirma);	
	#echo $sqlFirma;
	?>
	<!-- 18. CONTROL DEL TRABAJO DE CAMPO -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr class="TituloTabla2">
	    <td>Responsable</td>
	    <td>Nombre</td>
	    <td>Fecha de revisi&oacute;n o verificaci&oacute;n (mm/dd/aaaa)[hh:mm]</td>
	    <td>Observaciones</td>
	  </tr>
	  
	  <?
	  while($regFirma = mssql_fetch_array($cursorFirma))
	  {
	  ?>
	  <tr class="TxtTabla">
	    <td><? echo $regFirma[nomPerfil]; ?></td>
	    <td><? echo $regFirma[nombreUsuario]." ".$regFirma[apellidoUsuario]; ?></td>
	    <td><? 
			if($regFirma[fechaVerifica])
			{
				echo date("d/m/Y", strtotime($regFirma[fechaVerifica]))." [".$regFirma[horaVerifica]."]";
			}
		?></td>
	    <td><? echo $regFirma[observaciones]; ?></td>
	  </tr>
	  <?
	  }
	  ?>
	</table>
	

    <!-- Botones -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
		<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3) ) 
		{ ?>
			<? if(mssql_num_rows($cursorFirma) == 0)
			{ ?>
			<input name="Submit" type="submit" class="Boton" onClick="MM_openBrWindow('addControl.php?pag=13','vPA','scrollbars=yes,resizable=yes,width=950,height=300')" value="Nuevo">
	  	 <? }
			 else
			 { ?>
				<input name="Submit" type="submit" class="Boton" onClick="MM_openBrWindow('upControl.php?pag=13&accion=2','vPA','scrollbars=yes,resizable=yes,width=950,height=650')" value="Editar">
				<input name="Submit" type="submit" class="Boton" onClick="MM_openBrWindow('upControl.php?pag=13&accion=3','vPA','scrollbars=yes,resizable=yes,width=950,height=650')" value="Borrar">
		  <? } ?>
	<? } ?>
		</td>
      </tr>
    </table>
	
	<!-- Espacio-->
	<table width="100%"  border="0" cellpadding="0" cellspacing="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
	<? 
	//19. Relación de documentos anexos
	#Genera_Tabla_Seleccion(130,0,13,0);	//(Opcion,Múltiple Respuesta,Pagina a la que Regresa,Tipo de Objeto)
	?>

	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="copyr"> powered by INGETEC S.A - 2012</td>
	  </tr>
	</table>	
	</td>
  </tr>
</table>

</body>
</html>

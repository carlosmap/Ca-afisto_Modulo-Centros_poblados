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
	
	<!-- Declaración -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="TituloTabla">8. FIRMA DEL ENCUESTADO Y DECLARACI&Oacute;N DE CONFIDENCIALIDAD </td>
      </tr>
      <tr>
        <td class="TxtTabla">Los datos que se solicitan en este formulario son estrictamente CONFIDENCIALES y en ningún caso tienen fines fiscales,
				ni pueden utilizarse como prueba judicial (Ley 79 de 1993).<br>
				Declaro que los datos proporcionados son verídicos y autorizo a ISAGEN ESP S.A. para que verifique esta información.
				De igual modo acepto que esta información pueda ser utilizada en el estudio de factibilidad y de impacto ambiental del Proyecto 
				Hidroeléctrico Cañafisto sin que genere ningún tipo de compromiso por parte mía o de ISAGEN ESP S.A. En constancia de esta declaración 
				firmo el presente formulario.</td>
      </tr>
    </table>
	
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

	<? //Búsqueda de la información de la firma
	$sqlFirma = "SELECT * FROM CSCPFichaFirmas
				 WHERE codProyecto=".$_SESSION["ccfProyecto"]."
				 AND codModulo=".$_SESSION["ccfModulo"]."
				 AND numFormulario='".$_SESSION["ccfFormulario"]."'";
	$cursorFirma = mssql_query($sqlFirma);
	$regFirma = mssql_fetch_array($cursorFirma);
	#echo $sqlFirma;
	?>
	<!-- Espacio-->
	<table width="100%"  border="0">
	  <tr>
		<td></td>
	  </tr>
	</table>

	<? //Búsqueda de la información de la persona entrevistada
	$sqlEntrev = "SELECT CSCPFichaEntrevistado.codProyecto, CSCPFichaEntrevistado.codModulo, CSCPFichaEntrevistado.numFormulario, CSCPFichaEntrevistado.idEntrevistado, 
					CSCPFichaEntrevistado.tipoPersona, CSCPEntrevistado.numDocumento, CSCPEntrevistado.nombres, CSCPEntrevistado.apellidos, 
					tmItems.nomItem AS nomTipoDoc, tmMunicipios.nomMunicipio, tmDepartamentos.nomDepartamento
					FROM tmDepartamentos RIGHT OUTER JOIN
					CSCPFichaEntrevistado INNER JOIN
					CSCPEntrevistado ON CSCPFichaEntrevistado.idEntrevistado = CSCPEntrevistado.idEntrevistado INNER JOIN
					tmItems ON CSCPEntrevistado.codTipoDoc = tmItems.codItem ON 
					tmDepartamentos.codDepartamento = CSCPEntrevistado.codDepartamentoExp LEFT OUTER JOIN
					tmMunicipios ON CSCPEntrevistado.codDepartamentoExp = tmMunicipios.codDepartamento AND 
					CSCPEntrevistado.codMunicipioExp = tmMunicipios.codMunicipio";
	$sqlEntrev = $sqlEntrev." WHERE CSCPFichaEntrevistado.codProyecto = " . $_SESSION["ccfProyecto"];
	$sqlEntrev = $sqlEntrev." AND CSCPFichaEntrevistado.codModulo = " . $_SESSION["ccfModulo"] ;
	$sqlEntrev = $sqlEntrev." AND CSCPFichaEntrevistado.numFormulario = '" . $_SESSION["ccfFormulario"] . "' ";
	$sqlEntrev = $sqlEntrev." AND CSCPFichaEntrevistado.tipoPersona=1";
	$cursorEnterv = mssql_query($sqlEntrev);
	$regEntrev = mssql_fetch_array($cursorEnterv);
	#echo $sqlEntrev;
	?>
	<!-- Datos de la persona entervistada -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
	    <td width="30%" class="TituloTabla2">8.1 Nombre completo de la persona encuestada </td>
	    <td class="TxtTabla"><? echo $regEntrev[nombres]." ".$regEntrev[apellidos]; ?></td>
	  </tr>
	  
	  <tr>
	    <td class="TituloTabla2">8.3 N&uacute;mero de documento de identidad </td>
	    <td class="TxtTabla"><? 
			$nomDocumento = explode(" ", $regEntrev[nomTipoDoc]);
			echo "[".$nomDocumento[1]."] ".$regEntrev[numDocumento]; 
		?></td>
	  </tr>
	  
	  <tr>
	    <td class="TituloTabla2">8.4 Lugar de expedici&oacute;n </td>
	    <td class="TxtTabla"><? echo $regEntrev[nomMunicipio].", ".$regEntrev[nomDepartamento]; ?></td>
	  </tr>
	</table>
	
	<!-- Espacio-->
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
	<? 
	//15.7 Observaciones sobre la firma y huella
	//	Genera_Tabla_Seleccion( Opcion, Unica Respuesta, Pagina a la que Regresa, Tipo de Objeto )	
	//Tipo de tenencia
	#	unica respuesta 1
	#	multiple 2
	Genera_Tabla_Seleccion( 120, 1, 19, 0 );
	
	#Genera_Tabla_SeleccionTexto(120,1,16,0);		//(Opcion,Múltiple Respuesta,Pagina a la que Regresa,Tipo de Objeto)
	#Genera_Tabla_SeleccionTexto(120,1,2,0);		//(Opcion,Múltiple Respuesta,Pagina a la que Regresa,Tipo de Objeto)
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

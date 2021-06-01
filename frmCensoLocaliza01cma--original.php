<?php

//Trae la información del Predio
//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');

//Abre la conexión a la BD
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

if(trim($miAncla) != "")
{
	echo "<script>location.href=\"frmCensoSocialPredioDet.php#$miAncla\"</script>";
}	
?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Guaic&aacute;ramo :::</title>
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

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#376B9A">
<form action="" method="post" name="form1">
  <tr>
    <td>
	
    <!-- BANNNER -->
    <table width="1024" border="0" cellspacing="0" cellpadding="0">
        <tr>
	        <td><?php include ("bannerCSCP2.php");?></td>
        </tr>
    </table>

	<!-- ESPACIO --> 
   <table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

	<!-- Título Ubicación y Dirección -->	
	<table width="100%"  border="0">
	  <tr>
		<td align="center" class="TituloTabla">1. IDENTIFICACI&Oacute;N DEL PREDIO </td>
	  </tr>
	</table>

	<? //Búsqueda de la ubicación
	$sqlCodUbica = "SELECT codUbicacion, direccion, nomPredio, areaTotal FROM CSCPFichaPredio 
					WHERE nroPredio='".$_SESSION["ccfEncuesta"]."'";
	$cursorCodUbica = mssql_query($sqlCodUbica);
	$regCodUbica = mssql_fetch_array($cursorCodUbica);
	
	//Búsqueda de la información de la ubicación
	$sqlInfoUbica = "SELECT * FROM tmUbicacion
					 WHERE consecUbica = ".$regCodUbica[codUbicacion];
	$cursorInfoUbica = mssql_query($sqlInfoUbica);
	$regInfoUbica = mssql_fetch_array($cursorInfoUbica);
	
	//Búsqueda del departamento de la ubicación
	$sqlDep = "SELECT * FROM tmDepartamentos
			   WHERE codDepartamento = ".$regInfoUbica[codDepartamento];
	$cursorDep = mssql_query($sqlDep);
	$regDep = mssql_fetch_array($cursorDep);
	
	//Búsqueda del municipio de la ubicación
	$sqlMun = "SELECT * FROM tmMunicipios
			   WHERE codDepartamento = ".$regInfoUbica[codDepartamento]."
			   AND codMunicipio = ".$regInfoUbica[codMunicipio];
	$cursorMun = mssql_query($sqlMun);
	$regMun = mssql_fetch_array($cursorMun);
	
	//Búsqueda de la vereda de la ubicación
	$sqlVer = "SELECT * FROM tmVeredas
			   WHERE codDepartamento = ".$regInfoUbica[codDepartamento]."
			   AND codMunicipio = ".$regInfoUbica[codMunicipio]."
			   AND codVereda = ".$regInfoUbica[codVereda];
	$cursorVer = mssql_query($sqlVer);
	$regVer = mssql_fetch_array($cursorVer);
	
	//Búsqueda del corregimiento de la ubicación
	$sqlCorr = "SELECT * FROM tmItems
				WHERE codOpcion = 120
				AND codItem = ".$regInfoUbica[codItemCorregimiento];
	$cursorCorr = mssql_query($sqlCorr);
	$regCorr = mssql_fetch_array($cursorCorr);
	
	//Búsqueda del centro poblado de la ubicación
	$sqlCent = "SELECT * FROM tmItems
				WHERE codOpcion = 121
				AND codItem = ".$regInfoUbica[codItemCentroPoblado];
	$cursorCent = mssql_query($sqlCent);
	$regCent = mssql_fetch_array($cursorCent);
	
	//Búsqueda de la cabecera de la ubicación
	$sqlCab = "SELECT * FROM tmItems
				WHERE codOpcion = 122
				AND codItem = ".$regInfoUbica[codItemCabecera];
	$cursorCab = mssql_query($sqlCab);
	$regCab = mssql_fetch_array($cursorCab);
	
	//Búsqueda del sector de la ubicación
	$sqlSec = "SELECT * FROM tmItems
				WHERE codOpcion = 123
				AND codItem = ".$regInfoUbica[codItemSector];
	$cursorSec = mssql_query($sqlSec);
	$regSec = mssql_fetch_array($cursorSec);
	#echo "<table><tr><td>".$sql3A."</td></tr></table>";
	?>	
	
	<!-- Tabla Ubicación y Dirección -->	
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
		<td width="30%" class="TituloTabla2">Departamento</td>
	    <td class="TxtTabla"><? echo $regDep[nomDepartamento]; ?>.</td>
	  </tr>
	  
	  <tr>
	    <td class="TituloTabla2">Municipio</td>
	    <td class="TxtTabla"><? echo $regMun[nomMunicipio]; ?></td>
	    </tr>
	  <tr>
	    <td width="30%" class="TituloTabla2">Vereda</td>
	    <td class="TxtTabla"><? echo $regVer[nomVereda];?></td>
	  </tr>
		
	  <tr>
	    <td width="30%" class="TituloTabla2">Corregimiento</td>
	    <td class="TxtTabla"><? echo $regCorr[nomItem];?></td>
	  </tr>
	  
	  <tr>
	    <td width="30%" class="TituloTabla2">Centro Poblado </td>
	    <td class="TxtTabla"><? echo $regCent[nomItem];?></td>
	  </tr>
	  
	  <tr>
	    <td width="30%" class="TituloTabla2">Cabecera Municipal </td>
	    <td class="TxtTabla"><? echo $regCab[nomItem];?></td>
	  </tr>
	  
	  <tr>
	    <td width="30%" class="TituloTabla2">Sector</td>
	    <td class="TxtTabla"><? echo $regSec[nomItem];?></td>
	  </tr>
	  
	  <tr>
	    <td class="TituloTabla2"> Nombre del Predio</td>
	    <td class="TxtTabla"><? echo $regCodUbica[nomPredio];?></td>
	  </tr>
	  
	  <tr>
	    <td class="TituloTabla2">&Aacute;rea total del predio<br>(ha en rural y m2 en urbano)</td>
	    <td class="TxtTabla"><? echo $regCodUbica[areaTotal];?></td>
	  </tr>
	  
	  <tr>
	    <td class="TituloTabla2">Direcci&oacute;n</td>
	    <td class="TxtTabla"><? echo $regCodUbica[direccion];?></td>
	  </tr>
	</table>	

    <!-- Botones -->
 	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>
       		 <input type="button" name="Submit2" value="Editar" class="Boton" onClick="MM_openBrWindow('upLocalizaPredio.php?accion=2','vAF','scrollbars=yes,resizable=yes,width=750,height=550')">
   		    <input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upLocalizaPredio.php?accion=3','vAF','scrollbars=yes,resizable=yes,width=750,height=550')" value="Eliminar">        </td>
	  </tr>
	</table>

    <!-- Espacio -->
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
	<?
	//Tipo de tenencia
	Genera_Tabla_Seleccion(163,0,2,1);	//(Opcion,Unica Respuesta,Pagina a la que Regresa,Tipo de Objeto)
	?>
	
	<!-- TITULO Entrevistado -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="TituloTabla">3. IDENTIFICACI&Oacute;N DE LA PERSONA ENTREVISTADA </td>
      </tr>
    </table>
        
 	<? //Búsqueda de la información del encuestado
	$sql3 = "SELECT CSCPFichaEntrevistado.codProyecto, CSCPFichaEntrevistado.codModulo, CSCPFichaEntrevistado.nroEncuesta, CSCPFichaEntrevistado.idEntrevistado, 
			 CSCPFichaEntrevistado.tipoPersona, CSCPEntrevistado.numDocumento, CSCPEntrevistado.nombres, CSCPEntrevistado.apellidos, 
			 CSCPEntrevistado.telefonos, tmItems.nomItem AS nomTipoDoc
			 FROM CSCPFichaEntrevistado INNER JOIN
			 CSCPEntrevistado ON CSCPFichaEntrevistado.idEntrevistado = CSCPEntrevistado.idEntrevistado INNER JOIN
			 tmItems ON CSCPEntrevistado.codTipoDoc = tmItems.codItem";
	$sql3 = $sql3." WHERE CSCPFichaEntrevistado.codProyecto = " . $_SESSION["ccfProyecto"];
	$sql3 = $sql3." AND CSCPFichaEntrevistado.codModulo = " . $_SESSION["ccfModulo"] ;
	$sql3 = $sql3." AND CSCPFichaEntrevistado.nroEncuesta = '" . $_SESSION["ccfEncuesta"] . "' ";
	$sql3 = $sql3." AND tmItems.codOpcion = 2";
	
	$sql3A = $sql3." AND CSCPFichaEntrevistado.tipoPersona=1";
	$cursor3 = mssql_query($sql3A) ;
	?>
	<!-- 2. Identificación de la persona entrevistada -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr class="TituloTabla2">
        <td width="40%" >Nombre del Entrevistado</td>
        <td width="25%" >Tel&eacute;fono</td>
        <td >Documento</td>
		<? if($_SESSION["ccfUsuPerfil"] == 1){?>
        <td width="1%" >&nbsp;</td>
		<? } ?>
        <td width="1%" >&nbsp;</td>
      </tr>
      <?php while ($reg3=mssql_fetch_array($cursor3)) 
      { ?>
      <tr>
        <td width="40%" class="TxtTabla"><? echo ucwords(strtolower($reg3[nombres])) . " " . ucwords(strtolower($reg3[apellidos])); ?></td>
        <td width="25%" class="TxtTabla"><? echo $reg3[telefonos]; ?></td>
        <td class="TxtTabla"><? echo "[" . $reg3[nomTipoDoc] . "] " . $reg3[numDocumento]; ?></td>
		<? if($_SESSION["ccfUsuPerfil"] == 1){?>
        <td width="1%" align="left" class="TxtTabla"><a href="#"><img src="../images/imgUp.gif" alt="Editar Entrevistado" width="18" height="14" border="0" onClick="MM_openBrWindow('upEncuestado.php?consecutivo=<? echo $reg3[idEntrevistado] ; ?>&accion=2&pag=1&evt=1','vAF','scrollbars=yes,resizable=yes,width=700,height=400')"></a></td>
        <? } ?>
		<td width="1%" class="TxtTabla"><a href="#"><img src="../images/del.gif" alt="Desasociar Propietario" width="14" height="13" border="0" onClick="MM_openBrWindow('upEncuestado.php?consecutivo=<? echo $reg3[idEntrevistado] ; ?>&accion=3&pag=1&evt=1','wdE','scrollbars=yes,resizable=yes,width=700,height=300')"></a></td>
      </tr>
      <? } ?>
    </table>
    
    <!-- BOTONES -->      
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="right">
          <? 
            if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 
            { 
                if (mssql_num_rows($cursor3) == 0) { ?>
                  <input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addEncuestadoA.php?evt=1','vAF','scrollbars=yes,resizable=yes,width=800,height=300')" value="Nuevo">					  
                  <input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addEncuestadoSinDoc.php?evt=1','vAF','scrollbars=yes,resizable=yes,width=800,height=300')" value="Nuevo Encuestado Sin Documento">
                <?
                } ?>
            <?
            } ?>
          </td>
        </tr>
      </table> 
	  
	<!-- Espacio -->
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
                 
 	<!--DERECHO DE AUTOR -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="copyr"> powered by INGETEC S.A - 2011 </td>
      </tr>
    </table>		
	
</form>  
</table>

</body>
</html>

<?php


//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');

//Abre la conexión a la BD
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

/*
if(trim($miAncla) != "")
{
	echo "<script>location.href=\"frmCensoSocialFamiliaIntegrantesDet.php#$miAncla\"</script>";
}
*/
?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Sumapaz :::</title>
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
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
<form action="" method="post" name="form1">
  <tr>
    <td>
	
    <!-- BANNER -->
    <table width="1024" border="0" cellspacing="0" cellpadding="0">
        <tr>
	        <td><?php include ("bannerCSCP4.php");?></td>
        </tr>
    </table>

    <!-- TABULACION -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
      	 <td width="20%" class="FichaInAct" height="25"><a href="frmCensoFamiliaIDHogar.php" class="FichaInAct1" >Identificaci&oacute;n <br>
      	   del Hogar </a></td>
         <td width="20%" class="FichaAct">Morbilidad y <br>
           mortalidad en el Hogar</td>
         <td width="20%" class="FichaInAct"><a href="frmCensoFamiliaCultural.php" class="FichaInAct1" >Aspectos <br>
           Culturales </a></td>
         <td >&nbsp;</td>
      </tr>
    </table>

  	<!--LINEA-->    
   	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td height="2" class="TituloUsuario"> </td>
      </tr>
    </table>   
      
    <? //Búsqueda de la información de los integrantes
	$sqlIntegra = "SELECT CSEFichaIntegrantesFamilia.*, tmItems_1.nomItem AS nomDocumento, tmDepartamentos_1.nomDepartamento AS deptoExpide, 
					tmMunicipios_1.nomMunicipio AS munExpide, 
					tmItems_2.nomItem AS dondeVivia, tmItems_3.nomItem AS nomCambio, tmDepartamentos.nomDepartamento AS deptoNace, 
					tmMunicipios.nomMunicipio AS munNace, tmItems_4.nomItem AS estadoCivil, tmItems_5.nomItem AS parentescoJefe, 
					tmItems_6.nomItem AS grupoEtnico, tmItems_7.nomItem AS discapacidad, tmItems_8.nomItem AS afiliaSalud, tmItems_9.nomItem AS localidadAfilia, 
					tmItems_20.nomItem AS sabeLeer, tmItems_12.nomItem AS asisteCentro, tmItems_11.nomItem AS nivelEduca, tmItems_13.nomItem AS situaLaboral, 
					tmItems_14.nomItem AS afiliaPension, tmItems_15.nomItem AS ocupaPrin, tmItems_16.nomItem AS posicionOcupa, 
					tmItems_17.nomItem AS lugarOcupa, tmItems_18.nomItem AS ocupaSec, tmItems_19.nomItem AS ingresoMensual, tmItems_20.nomItem AS depenJefe,
					tmItems.nomItem AS sexo
					FROM tmItems AS tmItems_20 RIGHT OUTER JOIN
					CSEFichaIntegrantesFamilia INNER JOIN
					CSEFichaViviendavsFamilia ON CSEFichaIntegrantesFamilia.nroFamilia = CSEFichaViviendavsFamilia.nroFamilia LEFT OUTER JOIN
					tmItems ON CSEFichaIntegrantesFamilia.codItemSexo = tmItems.codItem ON 
					tmItems_20.codItem = CSEFichaIntegrantesFamilia.codItemDependeJefe LEFT OUTER JOIN
					tmItems AS tmItems_19 ON CSEFichaIntegrantesFamilia.codItemIngresoMensual = tmItems_19.codItem LEFT OUTER JOIN
					tmItems AS tmItems_18 ON CSEFichaIntegrantesFamilia.codItemOcupacionSec = tmItems_18.codItem LEFT OUTER JOIN
					tmItems AS tmItems_17 ON CSEFichaIntegrantesFamilia.codItemLugarOcupa = tmItems_17.codItem LEFT OUTER JOIN
					tmItems AS tmItems_16 ON CSEFichaIntegrantesFamilia.codItemPosicionOcupa = tmItems_16.codItem LEFT OUTER JOIN
					tmItems AS tmItems_15 ON CSEFichaIntegrantesFamilia.codItemOcupacionPrin = tmItems_15.codItem LEFT OUTER JOIN
					tmItems AS tmItems_14 ON CSEFichaIntegrantesFamilia.codItemAfiliaPension = tmItems_14.codItem LEFT OUTER JOIN
					tmItems AS tmItems_13 ON CSEFichaIntegrantesFamilia.codItemSituaLaboraAnterior = tmItems_13.codItem LEFT OUTER JOIN
					tmItems AS tmItems_11 ON CSEFichaIntegrantesFamilia.codItemNivelEduca = tmItems_11.codItem LEFT OUTER JOIN
					tmItems AS tmItems_9 ON CSEFichaIntegrantesFamilia.codItemLocalidadAfilia = tmItems_9.codItem LEFT OUTER JOIN
					tmItems AS tmItems_10 ON CSEFichaIntegrantesFamilia.codItemSabeLeer = tmItems_10.codItem LEFT OUTER JOIN
					tmItems AS tmItems_12 ON CSEFichaIntegrantesFamilia.codItemAsisteCentro = tmItems_12.codItem LEFT OUTER JOIN
					tmItems AS tmItems_8 ON CSEFichaIntegrantesFamilia.codItemAfiliaSalud = tmItems_8.codItem LEFT OUTER JOIN
					tmItems AS tmItems_7 ON CSEFichaIntegrantesFamilia.codItemDiscapacidad = tmItems_7.codItem LEFT OUTER JOIN
					tmItems AS tmItems_6 ON CSEFichaIntegrantesFamilia.codItemGrupoEtnico = tmItems_6.codItem LEFT OUTER JOIN
					tmItems AS tmItems_5 ON CSEFichaIntegrantesFamilia.codItemParentescoJefe = tmItems_5.codItem LEFT OUTER JOIN
					tmItems AS tmItems_4 ON CSEFichaIntegrantesFamilia.codItemEstadoCivil = tmItems_4.codItem LEFT OUTER JOIN
					tmMunicipios ON CSEFichaIntegrantesFamilia.codDepartamentoNace = tmMunicipios.codDepartamento AND 
					CSEFichaIntegrantesFamilia.codMunicipioNace = tmMunicipios.codMunicipio LEFT OUTER JOIN
					tmDepartamentos ON CSEFichaIntegrantesFamilia.codDepartamentoNace = tmDepartamentos.codDepartamento LEFT OUTER JOIN
					tmDepartamentos AS tmDepartamentos_1 ON 
					CSEFichaIntegrantesFamilia.codDepartamentoExpide = tmDepartamentos_1.codDepartamento LEFT OUTER JOIN
					tmItems AS tmItems_3 ON CSEFichaIntegrantesFamilia.codItemCambio = tmItems_3.codItem LEFT OUTER JOIN
					tmItems AS tmItems_2 ON CSEFichaIntegrantesFamilia.codItemDondeVivia = tmItems_2.codItem LEFT OUTER JOIN
					tmMunicipios AS tmMunicipios_1 ON CSEFichaIntegrantesFamilia.codDepartamentoExpide = tmMunicipios_1.codDepartamento AND 
					CSEFichaIntegrantesFamilia.codMunicipioExpide = tmMunicipios_1.codMunicipio LEFT OUTER JOIN
					tmItems AS tmItems_1 ON CSEFichaIntegrantesFamilia.codItemTipoDoc = tmItems_1.codItem";
	$sqlIntegra = $sqlIntegra." WHERE CSEFichaViviendavsFamilia.codProyecto = ".$_SESSION["smpProyecto"];
	$sqlIntegra = $sqlIntegra." AND CSEFichaViviendavsFamilia.codModulo = ".$_SESSION["smpModulo"];
	$sqlIntegra = $sqlIntegra." AND CSEFichaViviendavsFamilia.nroEncuesta = ".$_SESSION["smpEncuesta"];
	$sqlIntegra = $sqlIntegra." AND CSEFichaViviendavsFamilia.nroVivienda = ".$_SESSION["smpVivienda"];
	$sqlIntegra = $sqlIntegra." AND CSEFichaViviendavsFamilia.nroFamilia = ".$_SESSION["smpFamilia"];
	$cursorIntegra = mssql_query($sqlIntegra);
	?>	
	<!-- INFORMACIÓN -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><div align="center">4.14 MORBILIDAD Y MORTALIDAD EN EL HOGAR<a name="54"></a></div></td>
      </tr>
    </table>
	<!-- BOTONES -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>&nbsp;</td>
	  </tr>
	</table>

	<!--ESPACIO-->    
	<table width="100%"  border="0">
	  <tr>
    	<td>
        <?
			#Genera_Tabla_Cantidad( 83, 1, 13, 2 );

			//****************************************************************************/
			//Funcion que permite visualizar la información de ubicaciones(con morbilidad)
			//$T	=Opcion
			//$pag  =Página a la que regresa
			//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
			//******
			Genera_Tabla_Ubicacion(37,3,3);


			//****************************************************************************/
			//Funcion que permite visualizar la información dinámico múltiple
			//$T	=Opcion Pregunta
			//$T2	=Opcion Respuesta
			//$pag  =Página a la que regresa
			//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
			//****************************************************************************/

			Genera_Tabla_SeleccionMultiple(38,38,3,3);

			//****************************************************************************/
			//Funcion que permite visualizar las opciones que tiene una cantidad
			//$T	=Opcion
			//$Sum	=Maximo Valor que se debe registrar
			//$pag  =Página a la que regresa
			//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
			//****************************************************************************/

			Genera_Tabla_Cantidad(40,0,3,3);


/*
			Genera_Tabla_Seleccion( 38, 3, 11, 0 );
			Genera_Tabla_Seleccion( 38, 3, 11, 0 );
			Genera_Tabla_Seleccion( 40, 3, 11, 0 );
*/
		?>

<?php



	$cant_reg=0;

	$sqlRta="select CSCPFichaFamiliaMorbilidad.*, tmSubItems.nomSubItem from CSCPFichaFamiliaMorbilidad

			inner join tmSubItems on CSCPFichaFamiliaMorbilidad.codSubItemSexo=tmSubItems.codSubItem ";
	$sqlRta= $sqlRta. " WHERE CSCPFichaFamiliaMorbilidad.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.nroVivienda=".$_SESSION["ccfVivienda"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.nroFamilia=".$_SESSION["ccfFamilia"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.nroPredio=".$_SESSION["ccfPredio"] ;

	$sqlRta= $sqlRta. " order by consecMorbilidad";
//	$sqlRta= $sqlRta. " AND  CSCPFichaFamiliaMorbilidad.consecMorbilidad=".$Opc ;
	$cur_morb=mssql_query($sqlRta);
	$cant_reg=mssql_num_rows($cur_morb);
//echo $sqlRta." --- ".mssql_get_last_message()."<br><br>";

	//consulta la cantidad de miembros asociados al hogar
	$sqlRta="select cantidad FROM         CSCPFichaInfoCant ";
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoCant.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.nroObjeto=".$_SESSION["ccfFamilia"];
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.tipoObjeto=3";
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codOpcion=40";
	$cur_cant=mssql_query($sqlRta);
	while($datos_can=mssql_fetch_array($cur_cant))
	{
		$cant_item=$datos_can["cantidad"];
	}
//echo $sqlRta." --- ".mssql_get_last_message()."<br><br>";

?>
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
		
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
		  <tr class="TituloTabla2">
			<td colspan="2" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
		  </tr>

          <tr class="TituloTabla2">
            <td width=""></td>
            <td width="">Sexo</td>
            <td width="" >Edad</td>
            <td width="" >Causa</td>
            <td width="5%" colspan="2" ></td>
          </tr>

<?php
			if($cant_reg==0)
			{
?>
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
<?php	
			}
			else
			{
				$cant_reg=0;
				while($datos_rta=mssql_fetch_array($cur_morb))
				{
					$cant_reg++;
?>			
                  <tr class="TxtTabla">
	                <td><?php echo $cant_reg; ?></td>
                    <td><?php echo $datos_rta["nomSubItem"]; ?></td>
                    <td><?php echo $datos_rta["edad"]; ?></td>
                    <td><?php echo $datos_rta["causa"]; ?></td>
				<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
                    {
?>

                    <td><a href="#"><img src="http://www.ingetec.com.co/sistemas/sisCanafisto/images/actualizar2.gif" alt="Editar" onClick="MM_openBrWindow('upCSCPMorbHogar.php?accion=2&Opc=40&conse=<?=$datos_rta[consecMorbilidad];?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" /> </a></td>

                    <td><a href="#"> <img src="http://www.ingetec.com.co/sistemas/sisCanafisto/images/del.gif" alt="Eliminar" onClick="MM_openBrWindow('upCSCPMorbHogar.php?accion=3&Opc=40&conse=<?=$datos_rta[consecMorbilidad];?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" /></a></td>
<?php 				}
					else
						echo "<td></td> <td></td>";
?>
                  </tr>
<?php
					
				}
			}
		
?>

        </table>
  	 </td>
	 </tr>
	</table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{
			//si la cantidad de resgitros es menor a la cantidad de miembros indicados esn la pregunta 4.13
			if($cant_reg<$cant_item)
			{
?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPMorbHogar.php?Opc=<? echo "40";?>&pag=<? echo "3";?>&tipo=<? echo "3";?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Nuevo">

<?php
			}
		}	 ?>
		</td>
      </tr>
    </table>
    
    <!-- ESPACIO -->
    <table width="100%"  border="0">
        <tr>
            <td height="10"> </td>
        </tr>
    </table>

        </td>
  		</tr>
	</table>
        
  	<!--ESPACIO-->    
	<table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
 
	<!--DERECHOS DE AUTOR -->
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

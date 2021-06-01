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
      	 <td width="16%" class="FichaInAct" height="25"><a href="frmCensoFamiliaActividad.php" class="FichaInAct1" >Actividades econ&oacute;micas <br>
      	   del Hogar </a> </td>
         <td width="16%" class="FichaInAct"><a href="frmCensoFamiliaActAgro.php" class="FichaInAct1" >Actividades <br>
           Agropecuarias </a></td>
         <td width="16%" class="FichaInAct"><a href="frmCensoFamiliaActExtractiva.php" class="FichaInAct1" >Actividades <br>
           Extractivas </a></td>
         <td width="16%" class="FichaAct">Pesca <br>
           Artesanal</td>
         <td width="16%" class="FichaInAct"><a href="frmCensoFamiliaActIndustrial.php" class="FichaInAct1" >Actividad <br>
           Industrial </a> </td>
         <td class="FichaInAct"><a href="frmCensoFamiliaActComercial.php" class="FichaInAct1" >Actividad Comercial <br>
           y de servicios </a> </td>
      </tr>
    </table>

  	<!--LINEA-->    
   	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td height="2" class="TituloUsuario"> </td>
      </tr>
    </table>   
      
    <? //Búsqueda de la información de los integrantes
/*
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
*/
	?>	
	<!-- INFORMACIÓN -->
	<!-- BOTONES -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>&nbsp;</td>
	  </tr>
	</table>

	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><div align="center">6.8.3. PESCA ARTESANAL </div></td>
      </tr>
    </table>
	<!--ESPACIO-->    
<?php
/*
		$sql_pesca="select *,tmItems.nomItem as especie,tm2.nomItem as temporalidad from CSCPFichaFamiliaPesca 
		inner join tmItems on CSCPFichaFamiliaPesca.codEspecie=tmItems.codItem
		inner join CSCPFichaFamiliaPescaTemp on CSCPFichaFamiliaPesca.codProyecto=CSCPFichaFamiliaPescaTemp.codProyecto and
		CSCPFichaFamiliaPesca.codModulo=CSCPFichaFamiliaPescaTemp.codModulo and
		CSCPFichaFamiliaPesca.numFormulario=CSCPFichaFamiliaPescaTemp.numFormulario and CSCPFichaFamiliaPescaTemp.consecutivo=CSCPFichaFamiliaPesca.consecutivo
		and CSCPFichaFamiliaPesca.nroPredio=CSCPFichaFamiliaPescaTemp.nroPredio and CSCPFichaFamiliaPesca.nroVivienda=CSCPFichaFamiliaPescaTemp.nroVivienda
		 and CSCPFichaFamiliaPesca.nroFamilia=CSCPFichaFamiliaPescaTemp.nroFamilia  and CSCPFichaFamiliaPesca.consecPesca=CSCPFichaFamiliaPescaTemp.consecPesca
		 inner join tmItems as tm2 on CSCPFichaFamiliaPescaTemp.codItemTipoTemp=tm2.codItem
*/
		 $sql_pesca="select *,tmItems.nomItem as especie from CSCPFichaFamiliaPesca
		 inner join tmItems on CSCPFichaFamiliaPesca.codEspecie=tmItems.codItem 
		 where CSCPFichaFamiliaPesca.codProyecto=".$_SESSION["ccfProyecto"]." 
		 and CSCPFichaFamiliaPesca.codModulo=".$_SESSION["ccfModulo"]." 
		 and CSCPFichaFamiliaPesca.numFormulario='".$_SESSION["ccfFormulario"]."' 
		 and CSCPFichaFamiliaPesca.consecutivo=".$_SESSION["ccfConsecutivo"]." 
		 and CSCPFichaFamiliaPesca.nroPredio=".$_SESSION["ccfPredio"]." 
		 and CSCPFichaFamiliaPesca.nroVivienda=".$_SESSION["ccfVivienda"]." 
		 and CSCPFichaFamiliaPesca.nroFamilia=".$_SESSION["ccfFamilia"]." ORDER BY (CSCPFichaFamiliaPesca.consecPesca)";
//		 and CSCPFichaFamiliaPesca.consecPesca=";
		$cur_pez=mssql_query($sql_pesca);
//		$num_reg=mssql_num_rows($cur_pez);
//echo $sql_pesca." --- ".mssql_get_last_message()."<br>";
?>

	<table width="100%"  border="0">
	  <tr>
    	<td>
			<table width="100%" border="0">
              <tr class="TituloTabla2">
                <td>6.8.3.1 Fuente Hídrica</td>
                <td>6.8.3.2 Especie</td>
                <td>6.8.3.3 Cantidad Kg/día</td>
                <td>6.8.3.4 % autoconsumo</td>
                <td>6.8.3.5 % venta</td>
                <td >6.8.3.6 Temporalidad</td>
                <td></td>
                <td></td>
              </tr>
<?php
			while($datos_pesca=mssql_fetch_array($cur_pez))
			{
?>
                <tr>
                    <td class="TxtTabla"><?php echo $datos_pesca["fuenteHidrica"]; ?></td>
                    <td class="TxtTabla"><?php echo $datos_pesca["especie"]; ?></td>
                    <td class="TxtTabla"><?php echo $datos_pesca["cantidad"]; ?></td>
                    <td class="TxtTabla"><?php echo $datos_pesca["porcentAuto"]; ?></td>
                    <td class="TxtTabla"><?php echo $datos_pesca["porcentVenta"]; ?></td>
                    <td class="TxtTabla">
						<table>

<?php 

					$sql_temp=" select *,tmItems.nomItem as temporalidad from CSCPFichaFamiliaPescaTemp				
					 inner join tmItems on CSCPFichaFamiliaPescaTemp.codItemTipoTemp=tmItems.codItem 
					 where CSCPFichaFamiliaPescaTemp.codProyecto=".$_SESSION["ccfProyecto"]." 
					 and CSCPFichaFamiliaPescaTemp.codModulo=".$_SESSION["ccfModulo"]." 
					 and CSCPFichaFamiliaPescaTemp.numFormulario='".$_SESSION["ccfFormulario"]."' 
					 and CSCPFichaFamiliaPescaTemp.consecutivo=".$_SESSION["ccfConsecutivo"]." 
					 and CSCPFichaFamiliaPescaTemp.nroPredio=".$_SESSION["ccfPredio"]." 
					 and CSCPFichaFamiliaPescaTemp.nroVivienda=".$_SESSION["ccfVivienda"]."
					 and CSCPFichaFamiliaPescaTemp.consecPesca=".$datos_pesca["consecPesca"]." 
					 and CSCPFichaFamiliaPescaTemp.nroFamilia=".$_SESSION["ccfFamilia"]." ORDER BY (CSCPFichaFamiliaPescaTemp.consecTemp)";
						$cur_temp=mssql_query($sql_temp);
						while($datos_tem=mssql_fetch_array($cur_temp))
						{
?>
							<tr>

								<td class="TxtTabla"><?php echo $datos_tem["temporalidad"]; ?></td>
							</tr>
<?php
						}
?>
						</table>
					</td>
				<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
                    {
?>


                    <td><a href="#"><img src="http://www.ingetec.com.co/sistemas/sisCanafisto/images/actualizar2.gif" border="0" alt="Editar" onClick="MM_openBrWindow('upInfoPesca.php?accion=2&conse=<?=$datos_pesca["consecPesca"];?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" /> </a></td>

                    <td><a href="#"> <img src="http://www.ingetec.com.co/sistemas/sisCanafisto/images/del.gif" alt="Eliminar" border="0" onClick="MM_openBrWindow('upInfoPesca.php?accion=3&conse=<?=$datos_pesca["consecPesca"];?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" /></a></td>
<?php 				}
					else
						echo "<td></td> <td></td>";
?>
                </tr>
<?php
			}
?>
				<tr>	
				  <td colspan="8" align="right">
				<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
                    {
?>
						<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addInfoPesca.php','vAF','scrollbars=yes,resizable=yes,width=780,height=350')" value="Nuevo">

<?php
					}

?>
					</td>				
				</tr>
<?
//****************************************************************************/
//Funcion que permite visualizar un campo de texto grande
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//subP1 =Opcion de la pregunta 1
//en este caso $T y $SubP1, contienen los mismos parametros, el ultimo es utilizado para consultar la pregunta 
//****************************************************************************/

			Genera_Tabla_Descripcion2(206,0,9,3,206); //para las preguntas de texto sin campo de seleccion
?>			
				<tr>

					<td >

					</td>
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

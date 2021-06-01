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
         <td width="16%" class="FichaInAct"><a href="frmCensoFamiliaActPesca.php" class="FichaInAct1" >Pesca <br>
           Artesanal </a></td>
         <td width="16%" class="FichaAct">Actividad <br>
           Industrial </td>
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
      
    <? //Búsqueda de la información de la actividad industrial
		$sql_sel = "select *, tmItems.nomItem,tm.nomItem as nomit2, tm2.nomItem as nom_unidad from CSCPFichaFamiliaIndustrial  as industrial
					inner join tmItems on industrial.codItemTipoAct=tmItems.codItem
					inner join tmItems as tm on industrial.codItemSitioVenta=tm.codItem 
					inner join tmItems as tm2 on industrial.unidadMedida=tm2.codItem ";
		$sql_sel = $sql_sel." where industrial.codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and industrial.codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and industrial.numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and industrial.consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and industrial.nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and industrial.nroVivienda=".$_SESSION["ccfVivienda"]."";
		$sql_sel = $sql_sel."  and industrial.nroFamilia=".$_SESSION["ccfFamilia"]." order by(consecAct)";
	$cursor_sel = mssql_query($sql_sel);
//echo $sql_sel."  --  ".mssql_get_last_message()."<br>";
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
        <td class="TituloTabla"><div align="center">6.8.4. ACTIVIDAD INDUSTRIAL </div></td>
      </tr>
    </table>
	<!--ESPACIO-->    
	<table width="100%"  border="0">
	  <tr>
    	<td>


		</td>
  		</tr>
	</table>
        
  	<!--ESPACIO-->    
	<table width="100%"  border="0">
      <tr>
        <td>
			<table width="100%" border="0">
              <tr class="TituloTabla2">
                <td>6.8.4.1 <br>Tipo de Actividad </td>
                <td colspan="2">6.8.4.2 <br>Camara de Comercio</td>
                <td colspan="2">6.8.4.3 <br>RUT</td>
                <td>6.8.4.4 <br>Codigo RUT</td>
                <td>6.8.4.5 <br>Antiguedad general de la actividad</td>
                <td>6.8.4.6 <br>Antiguedad de la actividad en el sitio</td>
                <td>6.8.4.7 <br>Maquinaria y equipos</td>
                <td colspan="6">6.8.4.8 <br>Numero de empleados</td>
                <td>6.8.4.9 <br>Valor de producci&oacute;n del Mes</td>
                <td>6.8.4.10 <br>Unidad de medida</td>
                <td>6.8.4.11 <br>Costo de producci&oacute;n mensual</td>
                <td>6.8.4.12 <br>Valor de las ventas al mes</td>
                <td>6.8.4.13 <br>Sitio de ventas</td>
                <td colspan="2"></td>
              </tr>
              <tr class="TituloTabla2">
                <td>&nbsp;</td>
                <td>Si</td>
                <td>No</td>
                <td>Si</td>
                <td>No</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td colspan="2">Sexo</td>
                <td colspan="2">Temporalidad</td>
                <td colspan="2">Remuneraci&oacute;n</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr class="TituloTabla2">
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Hombre</td>
                <td>Mujer</td>
                <td>Permanentes</td>
                <td>Ocasionales</td>
                <td>Familiares</td>
                <td>Remunerados</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
             
<?php
			while($datos_sel=mssql_fetch_array($cursor_sel))
			{

?>
			<tr class="TxtTabla">
				<td><?php echo $datos_sel["nomItem"]; ?></td>
				<?php if($datos_sel["hayCamaraCom"]==1)
					{
?>
				  <td align="center"><img src="../images/Si.gif" alt="Si"></td>
						<td align="center"></td>
<?
					} ?>
				<? if($datos_sel["hayCamaraCom"]==0)
					{
?>
						<td align="center"></td>
				  <td align="center"><img src="../images/No.gif"  alt="No"></td>
<?
					} ?>
<?php 				if($datos_sel["hayRUT"]==1)
					{ 
?>
				  <td align="center"><img src="../images/Si.gif"  alt="Si"></td>
						<td></td>
<?
					}
					if($datos_sel["hayRUT"]==0)
					{ 
?>
						<td></td>
				  <td align="center"><img src="../images/No.gif"  alt="No"></td>
<?
					} 

?>
				<td><?php echo $datos_sel["codigoRUT"]; ?></td>
				<td><?php echo $datos_sel["AntGeneral"]; ?></td>
				<td><?php echo $datos_sel["AntSitio"]; ?></td>

				<td>
					<table width="100%" border="0">
<?php
						//consulta la maquinaria asociada a la actividad
						$sql_sel="select nomItem  from CSCPFichaFamiliaIndustrialMaq  ";
						$sql_sel = $sql_sel." inner join tmItems on CSCPFichaFamiliaIndustrialMaq.codItemMaq=tmItems.codItem ";
						$sql_sel = $sql_sel." where CSCPFichaFamiliaIndustrialMaq.codProyecto= ".$_SESSION["ccfProyecto"]."";
						$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.codModulo=".$_SESSION["ccfModulo"]."";
						$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.numFormulario=".$_SESSION["ccfFormulario"]."";
						$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.consecutivo=".$_SESSION["ccfConsecutivo"]."";
						$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.nroPredio=".$_SESSION["ccfPredio"]."";
						$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.nroVivienda=".$_SESSION["ccfVivienda"]."";
						$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.nroFamilia=".$_SESSION["ccfFamilia"]."";
						$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.consecAct=".$datos_sel["consecAct"]."";
						$cur_sel=mssql_query($sql_sel);
						while($datos_maquina=mssql_fetch_array($cur_sel))
						{
?>
							<tr  class="TxtTabla">
								<td>
<?php 								echo $datos_maquina["nomItem"].""; 
?>
								</td>
							</tr>
<?php
						}
//echo $sql_sel." --- ".mssql_get_last_message()."<br><br>";
?>					

					</table>
				</td>

				<td><?php echo $datos_sel["numEmpSexoM"]; ?></td>
				<td><?php echo $datos_sel["numEmpSexoF"]; ?></td> 
				<td><?php echo $datos_sel["numEmpTempP"]; ?></td> 
				<td><?php echo $datos_sel["numEmpTempO"]; ?></td> 
				<td><?php echo $datos_sel["numEmpRemF"]; ?></td> 
				<td><?php echo $datos_sel["numEmpRemR"]; ?></td> 
				<td><?php echo $datos_sel["valorPruducMes"]; ?></td> 
				<td><?php echo $datos_sel["nom_unidad"]; ?></td> 
				<td><?php echo $datos_sel["costoProduccion"]; ?></td> 
				<td><?php echo $datos_sel["valorVenta"]; ?></td> 
				<td><?php echo $datos_sel["nomit2"]; ?></td> 

				<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
                    {
?>

                    <td><a href="#"><img src="http://www.ingetec.com.co/sistemas/sisCanafisto/images/actualizar2.gif" alt="Editar" border="0" onClick="MM_openBrWindow('upInfoActIndustrial.php?accion=2&conse=<?=$datos_sel["consecAct"];?>','vAF','scrollbars=yes,resizable=yes,width=780,height=550')" /> </a></td>

                    <td><a href="#"> <img src="http://www.ingetec.com.co/sistemas/sisCanafisto/images/del.gif" alt="Eliminar" border="0" onClick="MM_openBrWindow('upInfoActIndustrial.php?accion=3&conse=<?=$datos_sel["consecAct"];?>','vAF','scrollbars=yes,resizable=yes,width=780,height=550')" /></a></td>
<?php 				}
					else
						echo "<td></td> <td></td>";
?>


			</tr>
<?
			}


?>			

  			  <tr>
				<td colspan="22" align="right" class="TxtTabla">
				<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
                    {
?>
					<input name="nuevo" type="button" class="Boton"  id="nuevo" value="Nuevo"  onClick="MM_openBrWindow('addInfoActIndustrial.php','vAF','scrollbars=yes,resizable=yes,width=780,height=550')">
<?
					}
//****************************************************************************/
//Funcion que permite visualizar un campo de texto grande
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//subP1 =Opcion de la pregunta 1
//en este caso $T y $SubP1, contienen los mismos parametros, el ultimo es utilizado para consultar la pregunta 
//****************************************************************************/

			Genera_Tabla_Descripcion2(208,0,10,3,208); //para las preguntas de texto sin campo de seleccion
?>
				</td>
			  </tr>
            </table>

		</td>
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

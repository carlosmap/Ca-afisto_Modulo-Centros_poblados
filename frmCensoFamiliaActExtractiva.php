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
         <td width="16%" class="FichaAct">Actividades <br>
           Extractivas</td>
         <td width="16%" class="FichaInAct"><a href="frmCensoFamiliaActPesca.php" class="FichaInAct1" >Pesca <br>
           Artesanal </a></td>
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
      
	<!-- INFORMACIÓN -->
	<!-- BOTONES -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>&nbsp;</td>
	  </tr>
	</table>

	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><div align="center">6.8.2.2 ACTIVIDADES EXTRACTIVAS DESARROLLADAS POR EL HOGAR</div></td>
      </tr>
    </table>
	<!--ESPACIO-->    
<?
			#	fmla., fmla., fmla., fmla., fmla.
				$sqlActExt = "SELECT 
								tActiv.nomItem tpActividad, sExtra.nomItem stExtraccion, fExplo.nomItem frmExplotacion, unidad.nomItem unidad
								, tiempo.nomItem tiempo, sVenta.nomItem stVenta
								, fmla.cantContratoCal, fmla.cantContratoNoCal, fmla.cantFamiliarCal, fmla.cantFamiliarNoCal, fmla.cantObtenida
								, fmla.costosProduccion, fmla.ProduccionVendida, fmla.referenciaSitioExt, fmla.consecAct, fmla.precioVenta
							  FROM
								CSCPFichaFamiliaExtractiva fmla							  
							  LEFT JOIN tmItems tActiv ON tActiv.codItem = fmla.codItemTipoAct
							  LEFT JOIN tmItems sExtra ON sExtra.codItem = fmla.referenciaSitioExt
							  LEFT JOIN tmItems fExplo ON fExplo.codItem = fmla.codItemFormaExp
							  LEFT JOIN tmItems unidad ON unidad.codItem = fmla.codItemUnd
							  LEFT JOIN tmItems tiempo ON tiempo.codItem = fmla.codItemTiempo
							  LEFT JOIN tmItems sVenta ON sVenta.codItem = fmla.codItemSitioVenta
							  WHERE 
							  	fmla.nroFamilia = ".$_SESSION['ccfFamilia']." 
								AND fmla.nroPredio = ".$_SESSION['ccfPredio']." 
								AND fmla.nroVivienda = ".$_SESSION['ccfVivienda']."
								AND fmla.codProyecto=".$_SESSION['ccfProyecto']." 
								AND fmla.codModulo = ".$_SESSION['ccfModulo']." 
								AND fmla.consecutivo = ".$_SESSION['ccfConsecutivo'];
				#echo $sqlActExt;
				#	LEFT JOIN tmItems ON  .codItem = fmla.
				$qryActExt = mssql_query( $sqlActExt );
			?>
        	<!-- TABLA INFO -->  
        	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
              <tr align="center" class="TituloTabla">
                <td width="10%" rowspan="3" class="TituloTabla">Tipo de actividad </td> <td width="10%" rowspan="3">Sitio de extracción </td> 
                <td width="17%" rowspan="3">Temporalidad </td> <td width="10%" rowspan="3">Forma de explotación </td> <td width="10%" rowspan="3">Cantidad obtenida </td> <td width="5%" rowspan="3">Unidad </td>
                <td width="10%" rowspan="3">Precio de venta </td> <td width="5%" rowspan="3">Tiempo </td> <td colspan="4">Uso de mano de obra </td> <td width="5%" rowspan="3">Costo de producción</td> <td width="5%" rowspan="3">Producción vendida </td>
                <td width="5%" rowspan="3">Sitio de venta </td>
                <td width="1%" rowspan="3">&nbsp;</td> 
                <td width="1%" rowspan="3">&nbsp;</td>
              </tr>
              <tr class="TituloTabla">
                <td colspan="2" align="center">Calificada</td>
                <td colspan="2" align="center">No Calificada</td>
              </tr>
              <tr class="TituloTabla">
                <td width="10%" align="center">Familiar</td>
                <td width="5%" align="center">Contratada</td>
                <td width="5%" align="center">Familiar</td>
                <td width="5%" align="center">Contratada</td>
              </tr>
              <? while( $rw = mssql_fetch_array( $qryActExt ) ){ ?>
              <tr valign="top" class="TxtTabla">
                <td width="10%"><?= $rw[tpActividad] ?></td>
                <td width="10%"><?= $rw[stExtraccion] ?></td>
                <td width="17%">
                <?
					$sqlTmp = "select codItemTipoTemp from CSCPFichaFamiliaExtTemp where consecAct = ".$rw[consecAct];
					#echo $sqlTmp."<br />";
					$qryTmp = mssql_query( $sqlTmp );
					while( $rwTmp = mssql_fetch_array( $qryTmp ) ){
						$sqlItem = "select nomItem from tmItems where codItem = ".$rwTmp[codItemTipoTemp];
						$qryItem = mssql_fetch_array( mssql_query( $sqlItem ) );
						#echo $sqlItem."<br />";
						echo $qryItem[nomItem].".<br />";
					}
				?>
                </td>
                <td width="10%"><?= $rw[frmExplotacion]  ?></td>
                <td width="10%"><?= $rw[cantObtenida] ?></td>
                <td width="5%"><?= $rw[unidad]  ?> </td>
                <td width="10%"><?= $rw[precioVenta] ?></td>
                <td width="5%"><?= $rw[tiempo]  ?> </td>
                <td width="10%"><?= $rw[cantFamiliarCal] ?> </td>
                <td width="5%"><?= $rw[cantContratoCal] ?></td>
                <td width="5%"><?= $rw[cantFamiliarNoCal] ?></td>
                <td width="5%"><?= $rw[cantContratoNoCal] ?></td>
                <td width="5%"><?= $rw[costosProduccion] ?></td>
                <td width="5%"><?= $rw[ProduccionVendida] ?> </td>
                <td width="5%"><?= $rw[stVenta] ?></td>
                <td width="1%">
				<? if (($_SESSION["ccfUsuPerfil"] == 1) || ($_SESSION["ccfUsuPerfil"] == 2) || ($_SESSION["ccfUsuPerfil"] == 3)  ) { ?>
                <a href="#">
                <img src="../images/imgUp.gif" alt="Editar Integrante" width="14" height="13" border="0" onClick="MM_openBrWindow('upActExtrativas.php?f=<?= $rw[consecAct] ?>&accion=2&pag=12&Opc=74','vAF','scrollbars=yes,resizable=yes,width=700,height=500')">
                </a>
				<? } ?>
                </td>
                <td width="1%">
                <a href="#">
                <img src="../images/del.gif" alt="Eliminar Integrante" width="14" height="13" border="0" onClick="MM_openBrWindow('upActExtrativas.php?f=<?= $rw[consecAct] ?>&accion=3&pag=12&Opc=74','vAF','scrollbars=yes,resizable=yes,width=700,height=500')">
                </a>
                </td>
              </tr>
              <? } ?>
              <tr>
              <td colspan="17" align="right"> 
			  <? if (($_SESSION["ccfUsuPerfil"] == 1) || ($_SESSION["ccfUsuPerfil"] == 2) || ($_SESSION["ccfUsuPerfil"] == 3)  ) { ?>
              <input type="button" class="Boton" value="Nuevo" onClick="MM_openBrWindow('addActExtractivas.php?accion=1&pag=12&Opc=74','vAF','scrollbars=yes,resizable=yes,width=700,height=500')" />
			  <? } ?>
              </td>
              </tr>
            </table>
            <!-- TABLA INFO -->         
  	<!--ESPACIO-->    
	<table width="100%"  border="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="1" cellpadding="1">
          <tr>
            <td   align="center" class="TituloTabla">6.8.2.2 Nota</td>
          </tr>
          <?	#	descripcion, descripcion2
			$sqlNota = "SELECT * from CSCPFichaInfoText WHERE 
						codProyecto = " . $_SESSION["ccfProyecto"] . " 
						AND codModulo = " . $_SESSION["ccfModulo"] . " 
						AND numFormulario = " . $_SESSION["ccfFormulario"] . " 
						AND consecutivo = " . $_SESSION["ccfConsecutivo"] . " 
						AND codOpcion = 207 AND codItem = 1114
						AND nroObjeto = '".$_SESSION["ccfFamilia"] . "'";
			#echo $sqlNota;
			$aryNota = mssql_query( $sqlNota );
			$rw = mssql_fetch_array( $aryNota ); 
		?>
          <tr>
            <td class="TxtTabla"><?= $rw[descripcion]	?></td>
          </tr>
          <tr>
            <td align="right" class="TxtTabla">
			<? if (($_SESSION["ccfUsuPerfil"] == 1) || ($_SESSION["ccfUsuPerfil"] == 2) || ($_SESSION["ccfUsuPerfil"] == 3)  ) { ?>
			<?
					$reg = mssql_num_rows( $aryNota );
					if( $reg == 0 ){
                ?>
              <input name="Submit2" type="submit" class="Boton" 
                         onclick="MM_openBrWindow('addNotaExtractiva.php?pag=13','vPA','scrollbars=yes,resizable=yes,width=600,height=450')" value="Nuevo" />
              <?	
					}
	                else{
                ?>
              <input name="Submit" type="submit" class="Boton" 
                         onclick="MM_openBrWindow('upNotaExtractiva.php?pag=13&amp;accion=2','vPA','scrollbars=yes,resizable=yes,width=600,height=450')" value="Actualizar" />
              <input name="Submit" type="submit" class="Boton" 
                         onclick="MM_openBrWindow('upNotaExtractiva.php?pag=13&amp;accion=3','vPA','scrollbars=yes,resizable=yes,width=600,height=450')" value="Eliminar" />
              <? 	}	?>
			  <? } ?>
			  </td>
          </tr>
        </table></td>
      </tr>
    </table>
 
	<!--DERECHOS DE AUTOR -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td class="TxtTabla">&nbsp;</td>
	    </tr>
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

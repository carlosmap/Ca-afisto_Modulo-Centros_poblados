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
         <td width="20%" class="FichaInAct"><a href="frmCensoFamiliaMorbilidad.php" class="FichaInAct1" >Morbilidad y <br>
           mortalidad en el Hogar </a></td>
         <td width="20%" class="FichaAct">Aspectos <br>
           Culturales</td>
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
	$sqlIntegra = "SELECT CSCPFichaIntegrantesFamilia.*, tmItems_1.nomItem AS nomDocumento, tmDepartamentos_1.nomDepartamento AS deptoExpide, 
					tmMunicipios_1.nomMunicipio AS munExpide, 
					tmItems_2.nomItem AS dondeVivia, tmItems_3.nomItem AS nomCambio, tmDepartamentos.nomDepartamento AS deptoNace, 
					tmMunicipios.nomMunicipio AS munNace, tmItems_4.nomItem AS estadoCivil, tmItems_5.nomItem AS parentescoJefe, 
					tmItems_6.nomItem AS grupoEtnico, tmItems_7.nomItem AS discapacidad, tmItems_8.nomItem AS afiliaSalud, tmItems_9.nomItem AS localidadAfilia, 
					tmItems_20.nomItem AS sabeLeer, tmItems_12.nomItem AS asisteCentro, tmItems_11.nomItem AS nivelEduca, tmItems_13.nomItem AS situaLaboral, 
					tmItems_14.nomItem AS afiliaPension, tmItems_15.nomItem AS ocupaPrin, tmItems_16.nomItem AS posicionOcupa, 
					tmItems_17.nomItem AS lugarOcupa, tmItems_18.nomItem AS ocupaSec, tmItems_19.nomItem AS ingresoMensual, tmItems_20.nomItem AS depenJefe,
					tmItems.nomItem AS sexo
					FROM tmItems AS tmItems_20 RIGHT OUTER JOIN
					CSCPFichaIntegrantesFamilia INNER JOIN
					CSCPFichaViviendavsFamilia ON CSCPFichaIntegrantesFamilia.nroFamilia = CSCPFichaViviendavsFamilia.nroFamilia LEFT OUTER JOIN
					tmItems ON CSCPFichaIntegrantesFamilia.codItemSexo = tmItems.codItem ON 
					tmItems_20.codItem = CSCPFichaIntegrantesFamilia.codItemDependeJefe LEFT OUTER JOIN
					tmItems AS tmItems_19 ON CSCPFichaIntegrantesFamilia.codItemIngresoMensual = tmItems_19.codItem LEFT OUTER JOIN
					tmItems AS tmItems_18 ON CSCPFichaIntegrantesFamilia.codItemOcupacionSec = tmItems_18.codItem LEFT OUTER JOIN
					tmItems AS tmItems_17 ON CSCPFichaIntegrantesFamilia.codItemLugarOcupa = tmItems_17.codItem LEFT OUTER JOIN
					tmItems AS tmItems_16 ON CSCPFichaIntegrantesFamilia.codItemPosicionOcupa = tmItems_16.codItem LEFT OUTER JOIN
					tmItems AS tmItems_15 ON CSCPFichaIntegrantesFamilia.codItemOcupacionPrin = tmItems_15.codItem LEFT OUTER JOIN
					tmItems AS tmItems_14 ON CSCPFichaIntegrantesFamilia.codItemAfiliaPension = tmItems_14.codItem LEFT OUTER JOIN
					tmItems AS tmItems_13 ON CSCPFichaIntegrantesFamilia.codItemSituaLaboraAnterior = tmItems_13.codItem LEFT OUTER JOIN
					tmItems AS tmItems_11 ON CSCPFichaIntegrantesFamilia.codItemNivelEduca = tmItems_11.codItem LEFT OUTER JOIN
					tmItems AS tmItems_9 ON CSCPFichaIntegrantesFamilia.codItemLocalidadAfilia = tmItems_9.codItem LEFT OUTER JOIN
					tmItems AS tmItems_10 ON CSCPFichaIntegrantesFamilia.codItemSabeLeer = tmItems_10.codItem LEFT OUTER JOIN
					tmItems AS tmItems_12 ON CSCPFichaIntegrantesFamilia.codItemAsisteCentro = tmItems_12.codItem LEFT OUTER JOIN
					tmItems AS tmItems_8 ON CSCPFichaIntegrantesFamilia.codItemAfiliaSalud = tmItems_8.codItem LEFT OUTER JOIN
					tmItems AS tmItems_7 ON CSCPFichaIntegrantesFamilia.codItemDiscapacidad = tmItems_7.codItem LEFT OUTER JOIN
					tmItems AS tmItems_6 ON CSCPFichaIntegrantesFamilia.codItemGrupoEtnico = tmItems_6.codItem LEFT OUTER JOIN
					tmItems AS tmItems_5 ON CSCPFichaIntegrantesFamilia.codItemParentescoJefe = tmItems_5.codItem LEFT OUTER JOIN
					tmItems AS tmItems_4 ON CSCPFichaIntegrantesFamilia.codItemEstadoCivil = tmItems_4.codItem LEFT OUTER JOIN
					tmMunicipios ON CSCPFichaIntegrantesFamilia.codDepartamentoNace = tmMunicipios.codDepartamento AND 
					CSCPFichaIntegrantesFamilia.codMunicipioNace = tmMunicipios.codMunicipio LEFT OUTER JOIN
					tmDepartamentos ON CSCPFichaIntegrantesFamilia.codDepartamentoNace = tmDepartamentos.codDepartamento LEFT OUTER JOIN
					tmDepartamentos AS tmDepartamentos_1 ON 
					CSCPFichaIntegrantesFamilia.codDepartamentoExpide = tmDepartamentos_1.codDepartamento LEFT OUTER JOIN
					tmItems AS tmItems_3 ON CSCPFichaIntegrantesFamilia.codItemCambio = tmItems_3.codItem LEFT OUTER JOIN
					tmItems AS tmItems_2 ON CSCPFichaIntegrantesFamilia.codItemDondeVivia = tmItems_2.codItem LEFT OUTER JOIN
					tmMunicipios AS tmMunicipios_1 ON CSCPFichaIntegrantesFamilia.codDepartamentoExpide = tmMunicipios_1.codDepartamento AND 
					CSCPFichaIntegrantesFamilia.codMunicipioExpide = tmMunicipios_1.codMunicipio LEFT OUTER JOIN
					tmItems AS tmItems_1 ON CSCPFichaIntegrantesFamilia.codItemTipoDoc = tmItems_1.codItem";
	$sqlIntegra = $sqlIntegra." WHERE CSCPFichaViviendavsFamilia.codProyecto = ".$_SESSION["ccfProyecto"];
	$sqlIntegra = $sqlIntegra." AND CSCPFichaViviendavsFamilia.codModulo = ".$_SESSION["ccfModulo"];
	$sqlIntegra = $sqlIntegra." AND CSCPFichaViviendavsFamilia.numFormulario = ".$_SESSION["ccfFormulario"];
	$sqlIntegra = $sqlIntegra." AND CSCPFichaViviendavsFamilia.nroVivienda = ".$_SESSION["ccfVivienda"];
	$sqlIntegra = $sqlIntegra." AND CSCPFichaViviendavsFamilia.nroFamilia = ".$_SESSION["ccfFamilia"];
	$cursorIntegra = mssql_query($sqlIntegra);
	?>	
	<!-- INFORMACIÓN -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><div align="center">4.15 ASPECTOS CULTURALES <a name="54"></a></div></td>
      </tr>
    </table>
	<!-- BOTONES -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>&nbsp;</td>
	  </tr>
	</table>

	<!--ESPACIO  
	<table width="100%"  border="0">
	  <tr>
    	<td>&nbsp;</td>
  		</tr>
	</table>
     -->     
  	<!--ESPACIO-->    
	<table width="100%"  border="0">
      <tr>
        <td>
        <?
			#Genera_Tabla_Cantidad( 83, 1, 13, 2 );
			# ( Opcion, tipo Respuesta 1 unica 2 multiple, retorno, tipo de objeto )
			#	4.15.1 
			/*
			Genera_Tabla_Seleccion( 268, 1, 16, 3 );
			#	4.15.1
			$sqlNo = "select * from sisCanafisto.dbo.CSCPFichaInfoBoolean where codOpcion = 268 and numFormulario = '".$_SESSION['ccfFormulario']."'";
			$qryNo = mssql_fetch_array( mssql_query( $sqlNo ) );
			#	codItem, respItem
			if( ( $qryNo[codItem] == 1438 ) && ( $qryNo[respItem] == 1 ) )
				Genera_Tabla_Seleccion( 41, 2, 16, 3 );
			*/
			
			//4.15.1
			Genera_Tabla_Seleccion_Items( 41, 16, 3);
			
			#	4.15.2
			Genera_Tabla_Seleccion( 42, 2, 16, 3 );
			
			
			#	4.15.3
			Genera_Tabla_Seleccion( 43, 1, 16, 3 );
			//Genera_Tabla_Descripcion2( 43, 0, 16, 3, 43 );
			
			#Genera_Tabla_Seleccion( 44, 1, 16, 3 );
			
			#	4.15.4
			#Genera_Tabla_Seleccion( 85, 1, 16, 3 );
			$sqlFmlaComunitaria = "select lx.*, tm.nomItem frecuencia, tm2.nomItem comunidad from CSCPFichaFamiliaComunidad lx, tmItems tm, tmItems tm2
								   Where 
								   consecutivo = ".$_SESSION['ccfConsecutivo']." 
								   and lx.codModulo = ".$_SESSION['ccfModulo']." 
								   and lx.codProyecto = ".$_SESSION['ccfProyecto']." 
								   and lx.nroPredio = ".$_SESSION['ccfPredio']." 
								   and lx.numFormulario = ".$_SESSION['ccfFormulario']." 
								   and lx.nroVivienda = ".$_SESSION['ccfVivienda']." 
								   and lx.nroFamilia = ".$_SESSION['ccfFamilia']."
								   and tm.codItem = lx.codSubItemFrecuencia
								   and tm2.codItem = lx.codItemComunidad";
			$qryFmlaComunitaria = mssql_query( $sqlFmlaComunitaria );

			$tbl = 0;
			if( mssql_num_rows( $qryFmlaComunitaria ) > 0 )
				$tbl = 1;
			
			?>
            <table width="100%">
<? 
//echo $sqlFmlaComunitaria." --------****  <br>".mssql_get_last_message();
?>
            <tr class="TituloUsuario">
              <td colspan="4" align="center" class="TituloTabla">
              4.15.4. &iquest;Qu&eacute; tipo de relaci&oacute;n tiene con otras comunidades? Indique nombre de la localidad, 
              cada cu&aacute;nto la visita y en qu&eacute; se deplaza?
              </td>
            </tr>
            <? if( $tbl == 1 ){ ?>
            <tr class="TituloTabla">
            	<td width="25%"></td>
                <td width="25%">Localidad</td>
                <td width="25%">Frecuencia</td>
                <td width="25%">En que se desplaza</td>
            </tr>
            <?
				$sqlItem = "select * from tmItems where codOpcion = 85";
				$qryItem = mssql_query( $sqlItem );
				while( $rwItem = mssql_fetch_array( $qryFmlaComunitaria ) ){
			?>
            <tr>
            	<td width="25%" class="TituloTabla"><?= $rwItem[comunidad]?></td>
                <td width="25%" class="TxtTabla"><?= $rwItem[localidad]?></td>
                <td width="25%" class="TxtTabla"><?=	substr( $rwItem[frecuencia], 2 )	?></td>
                <td width="25%" class="TxtTabla"><?= $rwItem[medioDesplaza]?></td>
            </tr>
            <?	}	
			}
			?>
            <tr>
            	<td colspan="4" align="right" class="TxtTabla">
                <?
					if($tbl == 0 ){
				?>
                	<input type="button" value="Nuevo" class="Boton" onClick="MM_openBrWindow('addFmlComunidad.php?accion=1','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=700,height=500')" />
                    <!-- window.open('addFmlComunidad.php', 'fchFmlaComunidad', '');" /> -->
                <?
					}
					else{
				?>
                	<input type="button" value="Editar" class="Boton" onClick="MM_openBrWindow('upFmlComunidad.php?accion=2','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=700,height=500')" />
                    <input type="button" value="Eliminar" class="Boton" onClick="MM_openBrWindow('upFmlComunidad.php?accion=3','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=700,height=500')" />
                <?
					}
				?>
                
                </td>
                </tr>
            </table>
			<?
            #	4.15.5
			Genera_Tabla_Seleccion( 44, 1, 16, 3 );
			#	4.15.6
			Genera_Tabla_Seleccion( 45, 2, 16, 3 );
			#	4.15.7
			Genera_Tabla_Seleccion( 46, 2, 16, 3 );
			#	4.15.8
			Genera_Tabla_Seleccion( 47, 1, 16, 3 );
			#	4.15.9
			Genera_Tabla_Seleccion( 48, 1, 16, 3 );
			#	4.15.10
			Genera_Tabla_Seleccion( 49, 1, 16, 3 );
			#	4.15.11
			Genera_Tabla_Seleccion( 50, 1, 16, 3 );
			#	4.15.12
			Genera_Tabla_Seleccion( 51, 1, 16, 3 );
			#	4.15.13
			#Genera_Tabla_Descripcion( 52, 1, 16, 3 );
			#			Genera_Tabla_Descripcion( 36, 36, 5, 3, 121, 122 );
			Genera_Tabla_Descripcion2( 52, 0, 16, 3, 52 );
			#	4.15.14
			Genera_Tabla_Seleccion( 53, 1, 16, 3 );
			#	4.15.15
			Genera_Tabla_Seleccion( 54, 1, 16, 3 );
			#	4.15.16
			Genera_Tabla_Seleccion( 55, 2, 16, 3 );
			#	4.15.17
			Genera_Tabla_Seleccion( 56, 1, 16, 3 );
		?>
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

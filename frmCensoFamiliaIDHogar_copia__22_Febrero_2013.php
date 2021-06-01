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
      	 <td width="20%" class="FichaAct" height="25">Identificaci&oacute;n <br>
      	   del Hogar</td>
         <td width="20%" class="FichaInAct"><a href="frmCensoFamiliaMorbilidad.php" class="FichaInAct1" >Morbilidad y <br>
           mortalidad en el Hogar </a></td>
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
        <td class="TituloTabla"><div align="center">4. IDENTIFICACI&Oacute;N DEL HOGAR <a name="54"></a></div></td>
      </tr>
    </table>
	<!-- BOTONES -->
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>
        <?
			#Genera_Tabla_Cantidad( 83, 1, 13, 2 );
			#	4.1
			Genera_Tabla_Seleccion( 26, 1, 5, 3 );
			$sqlCHogares = "select * from CSCPFichaVivienda where nroVivienda = ".$_SESSION['ccfVivienda'];
			#echo $sqlCHogares;
			$qryCHogares = mssql_fetch_array( mssql_query( $sqlCHogares ) );
			
			#	Nro del hogar
			$sqlFamilia = "select * from CSCPFichaViviendavsFamilia where nroVivienda = ".$_SESSION['ccfVivienda']." AND nroFamilia = ".$_SESSION['ccfFamilia'];
			#echo $sqlCHogares;
			$qryFamilia = mssql_fetch_array( mssql_query( $sqlFamilia ) );
			$cantidad = 0;
			if( $qryCHogares[totalHogares] > 0 )
				$cantidad = 1;
		?>
        <table width="100%">
        	<tr class="TituloUsuario">
        	  <td colspan="2" align="center" class="TituloTabla" >4.2 Total de hogares en la vivienda</td></tr>
            <?	if( $cantidad == 1 ){	?>
            <tr><td width="75%" class="TxtTabla">Cantidad de hogares</td><td class="TxtTabla"><?= $qryCHogares[totalHogares] ?></td></tr>
            <?	}else{	?>
            <tr><td colspan="2">&nbsp;</td></tr>
            <?	}	?>
             <tr>
              <!-- <td colspan="2">&nbsp;</td></tr> -->
       	<tr class="TituloUsuario">
        	  <td colspan="2" align="center" class="TituloTabla" >4.3 Número de hogar</td></tr>
            <?	if( $cantidad == 1 ){	?>
            <tr><td width="75%" class="TxtTabla">No. de hogar</td><td class="TxtTabla"><?= $qryFamilia[hogarNo] ?> de <?= $qryFamilia[de] ?></td></tr>
            <?	}	?>
            
            <tr><td colspan="2" align="right">
            <? if (($_SESSION["ccfUsuPerfil"] == 1) || ($_SESSION["ccfUsuPerfil"] == 2) || ($_SESSION["ccfUsuPerfil"] == 3)  ) { ?>
			<?	if( $cantidad == 0 ){	?>
            		<input type="button" value="Nuevo" onClick="MM_openBrWindow('addCHogares.php','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=500,height=200')" class="Boton" />
            <? 	}else{	?>
            		<input type="button" value="Editar" onClick="MM_openBrWindow('upCHogares.php?accion=2','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=500,height=200')" class="Boton" />
                    <input type="button" value="Eliminar" onClick="MM_openBrWindow('upCHogares.php?accion=3','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=500,height=200')" class="Boton"/>
            <?	}	?>
			<? } ?>
            </td></tr>
        </table>
        <?
			#	4.4
			Genera_Tabla_Seleccion( 27, 1, 5, 3 );
			#	4.5
			Genera_Tabla_Seleccion( 28, 1, 5, 3 );
			#	4.6
			Genera_Tabla_Seleccion( 29, 1, 5, 3 );

			$sqlopt1 = "SELECT * FROM CSCPFichaInfoBoolean WHERE codProyecto = ".$_SESSION['ccfProyecto']." AND codModulo = ".$_SESSION['ccfModulo']." 
					  AND numFormulario = ".$_SESSION['ccfFormulario']." AND consecutivo = ".$_SESSION['ccfConsecutivo']." 
					  AND codOpcion = 29 AND codItem IN ( 161, 170 )";				
			
			$sqlopt2 = "SELECT * FROM CSCPFichaInfoBoolean WHERE codProyecto = ".$_SESSION['ccfProyecto']." AND codModulo = ".$_SESSION['ccfModulo']." 
					  AND numFormulario = ".$_SESSION['ccfFormulario']." AND consecutivo = ".$_SESSION['ccfConsecutivo']." 
					  AND codOpcion = 29 AND codItem IN ( 162, 163 )";
			
			$sqlopt3 = "SELECT * FROM CSCPFichaInfoBoolean WHERE codProyecto = ".$_SESSION['ccfProyecto']." AND codModulo = ".$_SESSION['ccfModulo']." 
					  AND numFormulario = ".$_SESSION['ccfFormulario']." AND consecutivo = ".$_SESSION['ccfConsecutivo']." 
					  AND codOpcion = 29 AND codItem IN ( 161, 162, 163, 170 )";
			###
			#echo $sqlopt1."<br />".$sqlopt2."<br />".$sqlopt3."<br />";
			$qryopt1 = mssql_query( $sqlopt1 ) ;
			$band1 = $band2 = $band3 = 0;
			#	Comprueba para la primera condicion
			while( $rw1 = mssql_fetch_array( $qryopt1 ) ){
				if( $rw1[respItem] == 1 )
					$band1 = 1;
			}
			$qryopt2 = mssql_query( $sqlopt2 ) ;
			#	Comprueba para la segunda condicion
			while( $rw2 = mssql_fetch_array( $qryopt2 ) ){
				if( $rw2[respItem] == 1 )
					$band2 = 1;
			}
			$qryopt3 = mssql_query( $sqlopt3 ) ;
			#	Comprueba para la segunda condicion
			while( $rw3 = mssql_fetch_array( $qryopt3 ) ){
				if( $rw3[respItem] == 1 )
					$band3 = 1;
			}
			if( $band1 == 1 ){
				#	4.7
				Genera_Tabla_Seleccion( 30, 1, 5, 3 );
			}
			if( $band1 == 1 || $band2 == 1 ){			
				#	4.8
				Genera_Tabla_Seleccion( 31, 1, 5, 3 );
			}
			if( $band3 == 1 ){			
				#	4.9
				Genera_Tabla_Seleccion( 32, 1, 5, 3 );
			?>
        <table width="100%">
        	<tr class="TituloUsuario">
        	  <td colspan="2" align="center" class="TituloTabla" >4.10 ¿De donde vino?</td></tr>
            <?	
				//Busqueda del departamento de la ubicaci&oacute;n
				//B&uacute;squeda del municipio de la ubicaci&oacute;n
				
				$sqlDep = "SELECT * FROM tmDepartamentos
						   WHERE codDepartamento = ".$qryFamilia[codDepartamento];
				$cursorDep = mssql_query($sqlDep);
				$regDep = mssql_fetch_array($cursorDep);

				$sqlMun = "SELECT * FROM tmMunicipios
						   WHERE codDepartamento = ".$qryFamilia[codDepartamento]."
						   AND codMunicipio = ".$qryFamilia[codMunicipio];
				$cursorMun = mssql_query($sqlMun);
				$regMun = mssql_fetch_array($cursorMun);
				
				//B&uacute;squeda de la vereda de la ubicaci&oacute;n
				$sqlVer = "SELECT * FROM tmVeredas
						   WHERE codDepartamento = ".$qryFamilia[codDepartamento]."
						   AND codMunicipio = ".$qryFamilia[codMunicipio]."
						   AND codVereda = ".$qryFamilia[codVereda];
				$cursorVer = mssql_query($sqlVer);
				$regVer = mssql_fetch_array($cursorVer);
				if( $cantidad == 1 ){	#	, , 
			?>
            <tr><td width="50%" align="right" class="TituloTabla2">Departamento</td><td class="TxtTabla"><?= $regDep[nomDepartamento] ?></td></tr>
            <tr><td width="50%" align="right" class="TituloTabla2">Municipio</td><td class="TxtTabla"><?= $regMun[nomMunicipio] ?></td></tr>
            <tr><td width="50%" align="right" class="TituloTabla2">Vereda</td><td class="TxtTabla"><?= $regVer[nomVereda] ?></td></tr>
            <?	}	?>
             <tr>
              <!-- <td colspan="2">&nbsp;</td></tr> -->

            
            <tr><td colspan="2" align="right">
            <? if (($_SESSION["ccfUsuPerfil"] == 1) || ($_SESSION["ccfUsuPerfil"] == 2) || ($_SESSION["ccfUsuPerfil"] == 3)  ) { ?>
			<?	if( $cantidad == 0 ){	?>
            		<input type="button" value="Nuevo" onClick="MM_openBrWindow('upLocalizaFamilia.php?accion=2','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=500,height=200')" class="Boton" />
            <? 	}else{	?>
            		<input type="button" value="Editar" onClick="MM_openBrWindow('upLocalizaFamilia.php?accion=2','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=500,height=200')" class="Boton" />
                    <input type="button" value="Eliminar" onClick="MM_openBrWindow('upLocalizaFamilia.php?accion=3','fchFmlaComunidad','scrollbars=yes,resizable=yes,width=500,height=200')" class="Boton"/>
            <?	}	?>
			<? } ?>
            </td></tr>
        </table>
            <?
			}#	CIERRA if( $band3 == 1 ){	
			 
			#	4.11	CANTIDAD			
			Genera_Tabla_Cantidad( 33, 33, 5, 3 );
			#	4.11	OPCIONES
			/*
			Genera_Tabla_Seleccion_Multiple( 33, 3, 5, 0 );
			*/
			Genera_Tabla_SeleccionMultiple( 34, 34, 5, 3 );
			#	
			#Genera_Tabla_Seleccion( 34, 3, 5, 3 );
			#	4.12
			//Genera_Tabla_Cantidad( 35, 1, 5, 3 );
			Genera_Tabla_Cantidad( 35, 1, 5, 3, 3, 0 );
			#	4.13
			/*
				Función especial.				
				Genera__tabla_Descripcion( opcion, opcionRespuesta, URL, tipo, opcionPregunta 1, opcionPregunta 2 )
				opcion = opcionRespuesta
				URL = Pagina a que retorna( en numero como se trabajan en las otras)
			*/
			#Genera_Tabla_Seleccion( 36, 3, 5, 0 );
			Genera_Tabla_Descripcion( 36, 36, 5, 3, 121, 122 );
			
		?>        
        </td>
	  </tr>
	</table>

	<!--ESPACIO-->    
	<table width="100%"  border="0">
	  <tr>
    	<td>&nbsp;</td>
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

<?php
session_start();
//Trae la información del Predio
//Inicializa las variables de sesión


include ("../validaUsu.php");

//Abre la conexión a la BD
//include('../enlaceBD.php');

include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

/*
if(trim($miAncla) != "")
{
	echo "<script>location.href=\"frmCensoSocialPredioDet.php#$miAncla\"</script>";
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
	<? //B&uacute;squeda de la ubicaci&oacute;n
	$sqlCodUbica = "SELECT * FROM CSCPFichaPredio 
					WHERE nroPredio='".$_SESSION["ccfPredio"]."'";
	$cursorCodUbica = mssql_query($sqlCodUbica);
	$regCodUbica = mssql_fetch_array($cursorCodUbica);
	
	//B&uacute;squeda de la informaci&oacute;n de la ubicaci&oacute;n
	$sqlInfoUbica = "SELECT * FROM tmUbicacion
					 WHERE consecUbica = ".$regCodUbica[consecUbica];
	$cursorInfoUbica = mssql_query($sqlInfoUbica);
	$regInfoUbica = mssql_fetch_array($cursorInfoUbica);
	
	//B&uacute;squeda del departamento de la ubicaci&oacute;n
	$sqlDep = "SELECT * FROM tmDepartamentos
			   WHERE codDepartamento = ".$regInfoUbica[codDepartamento];
	$cursorDep = mssql_query($sqlDep);
	$regDep = mssql_fetch_array($cursorDep);
	
	//B&uacute;squeda del municipio de la ubicaci&oacute;n
	$sqlMun = "SELECT * FROM tmMunicipios
			   WHERE codDepartamento = ".$regInfoUbica[codDepartamento]."
			   AND codMunicipio = ".$regInfoUbica[codMunicipio];
	$cursorMun = mssql_query($sqlMun);
	$regMun = mssql_fetch_array($cursorMun);
	
	//B&uacute;squeda de la vereda de la ubicaci&oacute;n
	$sqlVer = "SELECT * FROM tmVeredas
			   WHERE codDepartamento = ".$regInfoUbica[codDepartamento]."
			   AND codMunicipio = ".$regInfoUbica[codMunicipio]."
			   AND codVereda = ".$regInfoUbica[codVereda];
	$cursorVer = mssql_query($sqlVer);
	$regVer = mssql_fetch_array($cursorVer);
	
	//B&uacute;squeda del corregimiento de la ubicaci&oacute;n
	$sqlCorr = "SELECT * FROM tmItems
				WHERE codOpcion = 1
				AND codItem = ".$regInfoUbica[codItemCorregimiento];
	$cursorCorr = mssql_query($sqlCorr);
	$regCorr = mssql_fetch_array($cursorCorr);
	
	//B&uacute;squeda del centro poblado de la ubicaci&oacute;n
	$sqlCent = "SELECT * FROM tmItems
				WHERE codOpcion = 2
				AND codItem = ".$regInfoUbica[codItemCentroPoblado];
	$cursorCent = mssql_query($sqlCent);
	$regCent = mssql_fetch_array($cursorCent);
	
	$cursorSec = mssql_query($sqlSec);
	$regSec = mssql_fetch_array($cursorSec);


	?>
	<!-- Tabla Ubicación y Dirección -->	
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
	    <td class="TituloTabla2"><span class="TituloTabla1">Cota o altura sobre el nivel del mar (msnm)</span></td>
	    <td class="TxtTabla"><? echo $regCodUbica[cota]; ?></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla2"><span class="TituloTabla1">Coordenadas</span> Este</td>
	    <td class="TxtTabla"><? echo $regCodUbica[coordEste]; ?></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla2"><span class="TituloTabla1">Coordenadas Norte</span></td>
	    <td class="TxtTabla"><? echo $regCodUbica[coordNorte]; ?></td>
	    </tr>
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
	    <td width="30%" class="TituloTabla2">Sector</td>
	    <td class="TxtTabla"><? echo $regCodUbica[sector];?></td>
	    </tr>
	  
	  <tr>
	    <td class="TituloTabla2">Barrio</td>
	    <td class="TxtTabla"><? echo $regCodUbica[barrio];?></td>
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
	Genera_Tabla_Seleccion_Items(41,0,1);


	Genera_Tabla_Cantidad(109,3,0,1,3,1);
	Genera_Tabla_Cantidad(25,1,2,1);

Genera_Tabla_Descripcion2(52,0,1,1,52); //para las preguntas de texto sin campo de seleccion

//****************************************************************************/
//Funcion que permite visualizar la información de ubicaciones(con morbilidad)
//$T	=Opcion
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//******
	Genera_Tabla_Ubicacion(37,1,1);
	//Tipo de tenencia
	Genera_Tabla_Seleccion(3,2,2,1);	//(Opcion,Unica Respuesta,Pagina a la que Regresa,Tipo de Objeto)

	?>
	
	<!-- TITULO Entrevistado -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="center" class="TituloTabla">3. IDENTIFICACI&Oacute;N DE LA PERSONA ENTREVISTADA </td>
      </tr>
    </table>
        
 	<? //Búsqueda de la información del encuestado
	$sql3 = "SELECT CSEFichaEntrevistado.codProyecto, CSEFichaEntrevistado.codModulo, CSEFichaEntrevistado.nroEncuesta, CSEFichaEntrevistado.idEntrevistado, 
			 CSEFichaEntrevistado.tipoPersona, CSEEntrevistado.numDocumento, CSEEntrevistado.nombres, CSEEntrevistado.apellidos, 
			 CSEEntrevistado.telefonos, tmItems.nomItem AS nomTipoDoc
			 FROM CSEFichaEntrevistado INNER JOIN
			 CSEEntrevistado ON CSEFichaEntrevistado.idEntrevistado = CSEEntrevistado.idEntrevistado INNER JOIN
			 tmItems ON CSEEntrevistado.codTipoDoc = tmItems.codItem";
	$sql3 = $sql3." WHERE CSEFichaEntrevistado.codProyecto = " . $_SESSION["sgcProyecto"];
	$sql3 = $sql3." AND CSEFichaEntrevistado.codModulo = " . $_SESSION["sgcModulo"] ;
	$sql3 = $sql3." AND CSEFichaEntrevistado.nroEncuesta = '" . $_SESSION["sgcEncuesta"] . "' ";
	$sql3 = $sql3." AND tmItems.codOpcion = 2";
	
	$sql3A = $sql3." AND CSEFichaEntrevistado.tipoPersona=1";
	$cursor3 = mssql_query($sql3A) ;
	?>
	<!-- 2. Identificación de la persona entrevistada -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr class="TituloTabla2">
        <td width="40%" >Nombre del Entrevistado</td>
        <td width="25%" >Tel&eacute;fono</td>
        <td >Documento</td>
		<? if($_SESSION["sgcUsuPerfil"] == 1){?>
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
		<? if($_SESSION["sgcUsuPerfil"] == 1){?>
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
            if (($_SESSION["sgcUsuPerfil"] == 1) OR ($_SESSION["sgcUsuPerfil"] == 2) OR ($_SESSION["sgcUsuPerfil"] == 4) OR ($_SESSION["sgcUsuPerfil"] == 13)) 
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
<?php

//Funcion que permite visualizar las opciones que tiene una cantidad
//$T	=Opcion
//$Sum	=Maximo Valor que se debe registrar
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
Genera_Tabla_Descripcion2(41,0,16,3,41);
Genera_Tabla_Cantidad_Decimal(39,1,8,0);
Genera_Tabla_Cantidad_Decimal(131,1,8,0);

Genera_Tabla_Cantidad_Decimal(39,1,8,0);


	Genera_Tabla_Cantidad(109,3,2,1); 

Genera_Tabla_Descripcion(111,111,12,0,127,0);
Genera_Tabla_Descripcion(36,36,1,1,121,122); //para la pregunta 4.13 especial, que tienen pregunta dos campos de texto con una lista de seleccion
Genera_Tabla_Descripcion2(52,0,1,1,52); //para las preguntas de texto sin campo de seleccion
	Genera_Tabla_Cantidad(25,1,2,1);



echo "*********//////////////////////////////////////nuevo ";
Genera_Tabla_SeleccionMultiple(33,34,1,1);
	Genera_Tabla_Cantidad(150,1,2,1); 

//(Opcion,Unica Respuesta,Pagina a la que Regresa,Tipo de Objeto)
	Genera_Tabla_Seleccion(4,1,8,0);

//Funcion que permite visualizar las opciones que tiene una cantidad
//$T	=Opcion
//$Sum	=Maximo Valor que se debe registrar
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia

 

	Genera_Tabla_Cantidad(83,1,15,2); 

	Genera_Tabla_Cantidad(83,1,2,1); 

//Funcion que permite visualizar las opciones tipo Booleano Si/No y un Texto
//$T	=Opcion
//$uni	=Es multiple Respuesta =1 Es Unica Respuesta =0
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/
//	Genera_Tabla_SeleccionTexto(34,1,1,3);


//****************************************************************************/
//Funcion que permite visualizar la información Boleano dinámico
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

//echo "genera tabla ****************/// <br>";
//	Genera_Tabla_SeleccionDinamico(33,34,1,1);

//****************************************************************************/
//Funcion que permite visualizar la información dinámico múltiple
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//Cuando la pregunta es de marcado multiple con la opcion de digitar el un numero se envia como parametro en $T = la Opcion Pregunta y $T2=Opcion pregunta2
//Cuando la pregunta es de marcado multiple se envia como parametroen $T= opcion pregunta y $T2= opcion pregunta 
//****************************************************************************/

//(Opcion,Unica Respuesta,Pagina a la que Regresa,Tipo de Objeto)
	Genera_Tabla_Seleccion(15,2,3,1);

//Genera_Tabla_SeleccionMultiple(15,15,1,1);
Genera_Tabla_SeleccionMultiple(33,34,1,1);
Genera_Tabla_SeleccionMultiple(38,38,1,1);



//Genera_Tabla_Descripcion(103,103,1,1,103); //sub pregunta 1, sub pregunta 2

//Genera_Tabla_Descripcion(111,111,1,1,103); //sub pregunta 1, sub pregunta 2

//parametro de la subpregunta1 
//parametro de la subpregunta2


//****************************************************************************/
//Funcion que permite visualizar una lista desplegable con dos campos de texto, creada para la pregunta 4.13
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//subP1 =Opcion de la pregunta 1
//subP2 =Opcion de la pregunta 2
//en este caso $T y $T2, contienen los mismos parametros, el ultimo es utilizado para consultar la lista desplegable si no
//****************************************************************************/

Genera_Tabla_Descripcion(36,36,1,1,121,122); //para la pregunta 4.13 especial, que tienen pregunta dos campos de texto con una lista de seleccion


//****************************************************************************/
//Funcion que permite visualizar un campo de texto grande
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//subP1 =Opcion de la pregunta 1
//en este caso $T y $SubP1, contienen los mismos parametros, el ultimo es utilizado para consultar la pregunta 
//****************************************************************************/

//parametro de la pregunta 
?>	  
	<!-- Espacio -->
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
                 
 	<!--DERECHO DE AUTOR -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="copyr"> powered by INGETEC S.A - 2012 </td>
      </tr>
    </table>		
	
</form>  
</table>

</body>
</html>

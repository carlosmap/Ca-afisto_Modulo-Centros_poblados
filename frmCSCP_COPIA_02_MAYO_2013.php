<?php

//Listado de Censos
//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');
/*
//Abre la conexión a la BD
include('funcionesCSE.php');
*/
//Establecer la conexión a la base de datos
$conexion = conectar();

//Carga los valores de la búsqueda
if($consulta!="")
{
	$_SESSION["ccfDigitaBusq"] = $digitador;
	$_SESSION["ccfEncuestaBus"] = $encuesta;
	$_SESSION["ccfFechaBus"] = $fecha;
	$_SESSION["afectacion"]=$afect;
}

//Trae la información de las fichas
//dbo.CSCPFicha
//codProyecto, codModulo, numFormulario, consecutivo, idCartografico, fechaTomaInf, horaInicio, 
//codCatastral, segregacion, vivienda, hogar, identitifaPredio, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sql0="SELECT TOP 30 *  ";
$sql0=$sql0." FROM CSCPFicha ";
$sql0 = $sql0." WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
$sql0 = $sql0." AND codModulo=" . $_SESSION["ccfModulo"];
//Si filtra por Formulario
if (trim($fNoFormulario) != "") {
	$pagina = 1;
	$sql0 = $sql0." AND numFormulario=" . $fNoFormulario;
}

//Si filtra por IDcartográfico
if (trim($fIDCartografico) != "") {
	$sql0 = $sql0." AND idCartografico like '%" . $fIDCartografico . "%'";
}

//Si filtra por el digitador
if (trim($digitador) != "") {
	$sql0 = $sql0." AND usuarioGraba like '%" . $digitador . "%'";
}

//Si es Digitador sólo muestra sus formularios
if(($_SESSION["ccfUsuPerfil"]==2) ){
	$sql0 = $sql0." AND usuarioGraba ='" . $_SESSION["ccfUsuID"]."'";
}

//20090810 DFRM Paginado
if(trim($pagina) == ""){
	$pagina = 1;
	$inicio = 0;
}
else{
	$inicio = 30*($pagina - 1);
}

$sql0 = $sql0." AND numFormulario NOT IN " ;
$sql0 = $sql0 . " ( SELECT TOP " . $inicio . " numFormulario FROM CSCPFicha ";
$sql0 = $sql0." 	WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
$sql0 = $sql0." 	AND codModulo=" . $_SESSION["ccfModulo"];

//Si es Digitador sólo muestra sus formularios
if(($_SESSION["ccfUsuPerfil"]==2) ){
	$sql0 = $sql0." AND usuarioGraba ='" . $_SESSION["ccfUsuID"]."'";
}
$sql0 = $sql0." ) ";


$cursor0 = mssql_query($sql0);



/*


//Trae la información de la Encuesta
//dbo.CSEFicha
//codProyecto, codModulo, nroEncuesta, fechaEncuesta, tipoInformacion, fechaGraba, usuarioGraba, fechaMod, usuarioMod	  
$sqlFilt = "";
$sql0 = "SELECT *";	 
$sqlTOP = "SELECT TOP (50) * ";	

$sql0 = $sql0." FROM CSEFicha";
$sql0 = $sql0." WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
$sql0 = $sql0." AND codModulo=" . $_SESSION["ccfModulo"];

$sqlTOP = $sqlTOP." FROM CSEFicha";
$sqlTOP = $sqlTOP." WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlTOP = $sqlTOP." AND codModulo=" . $_SESSION["ccfModulo"];

if(($_SESSION["ccfUsuPerfil"]!=1) AND ($_SESSION["ccfUsuPerfil"]!=4))
{
	$sql0 = $sql0." AND usuarioGraba ='" . $_SESSION["ccfUsuID"]."'";
	$sqlTOP = $sqlTOP." AND usuarioGraba ='" . $_SESSION["ccfUsuID"]."'";
	$sqlFilt = " WHERE usuarioGraba ='" . $_SESSION["ccfUsuID"]."'";
}

if (($_SESSION["ccfUsuPerfil"]==4) AND ($_SESSION["ccfDigitaBusq"] == ""))
{
	$sql0 = $sql0." AND usuarioGraba IN
				(
				SELECT docDigitador FROM trInspectores
				WHERE docInspector='".$_SESSION["ccfUsuID"]."'
				)
				OR usuarioGraba='".$_SESSION["ccfUsuID"]."'";
	$sqlTOP = $sqlTOP." AND usuarioGraba IN
				(
				SELECT docDigitador FROM trInspectores
				WHERE docInspector='".$_SESSION["ccfUsuID"]."'
				)
				OR usuarioGraba='".$_SESSION["ccfUsuID"]."'";
	if($sqlFilt != "")
	{
		$sqlFilt = $sqlFilt." AND ";
	}
	else{
		$sqlFilt = $sqlFilt." WHERE ";
	}
	$sqlFilt = $sqlFilt." usuarioGraba IN
				(
				SELECT docDigitador FROM trInspectores
				WHERE docInspector='".$_SESSION["ccfUsuID"]."'
				)
				OR usuarioGraba='".$_SESSION["ccfUsuID"]."'";
}

//Búsqueda por digitador
if ($_SESSION["ccfDigitaBusq"] != "")
{
	$sql0 = $sql0." AND usuarioGraba='".$_SESSION["ccfDigitaBusq"]."'";
	$sqlTOP = $sqlTOP." AND usuarioGraba='".$_SESSION["ccfDigitaBusq"]."'";
	if($sqlFilt != "")
	{
		$sqlFilt = $sqlFilt." AND usuarioGraba='".$_SESSION["ccfDigitaBusq"]."'";
	}
	else{
		$sqlFilt = $sqlFilt." WHERE usuarioGraba='".$_SESSION["ccfDigitaBusq"]."'";
	}
}

//Búsqueda por número de encuesta
if ($_SESSION["ccfEncuestaBus"] != "")
{
	$sql0 = $sql0." AND nroEncuesta='".$_SESSION["ccfEncuestaBus"]."'";
	$sqlTOP = $sqlTOP." AND nroEncuesta='".$_SESSION["ccfEncuestaBus"]."'";
	if($sqlFilt != "")
	{
		$sqlFilt = $sqlFilt." AND nroEncuesta='".$_SESSION["ccfEncuestaBus"]."'";
	}
	else{
		$sqlFilt = $sqlFilt." WHERE nroEncuesta='".$_SESSION["ccfEncuestaBus"]."'";
	}
}

//Búsqueda por fecha de grabación de la encuesta
if ($_SESSION["ccfFechaBus"] != "")
{
	$sql0 = $sql0." AND fechaGraba='".$_SESSION["ccfFechaBus"]."'";
	$sqlTOP = $sqlTOP." AND fechaGraba='".$_SESSION["ccfFechaBus"]."'";
	if($sqlFilt != "")
	{
		$sqlFilt = $sqlFilt." AND fechaGraba='".$_SESSION["ccfFechaBus"]."'";
	}
	else{
		$sqlFilt = $sqlFilt." WHERE fechaGraba='".$_SESSION["ccfFechaBus"]."'";
	}
	$pagina = "";
}

if ($_SESSION["afectacion"] != "")
{
	if($_SESSION["afectacion"]==1) //con afectacion
	{
		$sql0 = $sql0." AND afect_abatimiento='".$_SESSION["afectacion"]."'";
		$sqlTOP = $sqlTOP." AND afect_abatimiento='".$_SESSION["afectacion"]."'";
		if($sqlFilt != "")
		{
			$sqlFilt = $sqlFilt." AND afect_abatimiento='".$_SESSION["afectacion"]."'";
		}
		else{
			$sqlFilt = $sqlFilt." WHERE afect_abatimiento='".$_SESSION["afectacion"]."'";
		}
		$pagina = "";	
	}
	if($_SESSION["afectacion"]==0) //sin afectacion
	{
		$sql0 = $sql0." AND afect_abatimiento is null ";
		$sqlTOP = $sqlTOP." AND afect_abatimiento is null ";
		if($sqlFilt != "")
		{
			$sqlFilt = $sqlFilt." AND afect_abatimiento is null ";
		}
		else{
			$sqlFilt = $sqlFilt." WHERE afect_abatimiento is null ";
		}
	//	$pagina = "";	
	}
	
}


if(trim($pagina) == ""){
	$pagina = 1;
	$inicio = 0;
}
else{
	$inicio = 50*($pagina - 1);
}
$sqlTOP = $sqlTOP." AND nroEncuesta NOT IN";
$sqlTOP = $sqlTOP . " ( SELECT TOP " . $inicio . " nroEncuesta FROM CSEFicha ".$sqlFilt." )";


$cursor0 = mssql_query($sql0);
$cursorTOP = mssql_query($sqlTOP);
//echo "<br>".mssql_get_last_message()."<br>";
*/
?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript">
window.name="winCensos";
</script>

<script language="JavaScript" src="calendar.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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

function show()
{
 	document.location.href ="frmCensoSocialPredioDet.php";
}

//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="1024" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
<form action="" method="post" name="form1">
  <tr>
    <td>
	
    <!--BANNER -->
    <table width="1024" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><?php include ("bannerCSCP.php");?></td>
      </tr>
    </table>
	
	  <table width="65%"  border="0" align="center" cellpadding="0" cellspacing="1">
	  <tr>
	    <td colspan="3" class="TituloTabla">Criterios de BUSQUEDA</td>
	    </tr>
	  <tr>
	    <td width="25%" class="TituloTabla1">N&uacute;mero de Formulario </td>
	    <td class="TxtTabla"><input name="fNoFormulario" type="text" class="CajaTexto" id="fNoFormulario" value="<? echo $fNoFormulario; ?>" size="30">
&nbsp;	      </td>
	    <td width="10%" class="TxtTabla"></td>
        </tr>
        <tr>
          <td class="TituloTabla1">ID Cartogr&aacute;fico </td>
          <td class="TxtTabla"><input name="fIDCartografico" type="text" class="CajaTexto" id="fIDCartografico" value="<? echo $fIDCartografico; ?>" size="30"></td>
          <td class="TxtTabla"><input name="consulta" type="hidden" id="consulta2" value="1">
            <input name="Submit2" type="submit" class="Boton" value="Consultar"></td>
        </tr>
		<? 
		//SOLO ESTÁ DISPONIBLE PARA 1=Administrador, 2=Digitador, 3=Coordinador
		if (($_SESSION["ccfUsuPerfil"] == "1") OR ($_SESSION["ccfUsuPerfil"] == "2") OR ($_SESSION["ccfUsuPerfil"] == "3")) { ?>
        <tr>
        	<td class="TituloTabla1">Digitador</td>  
          <td class="TxtTabla">
		  <?
		  	$sqlDigitador = "Select * from tmUsuarios WHERE codPerfil = 2 order by apellidoUsuario ";
			$qryDigitador = mssql_query( $sqlDigitador );
		  ?>
          <select name="digitador" id="digitador" class="CajaTexto">
          <option value="">.:: Seleccione un digitador</option>
              <? 	
			  	while( $rwDigitador = mssql_fetch_array( $qryDigitador ) ){	
					$sel = "";
					if( $digitador == $rwDigitador[numDocumento] )
						$sel = "selected";
			  ?>

            <option value="<?= $rwDigitador[numDocumento] ?>" <?= $sel ?> >
			<?= $rwDigitador[apellidoUsuario].", ".$rwDigitador[nombreUsuario] . " [".$rwDigitador[numDocumento]."] " ;?>
            </option>
              <? 	}	?>
          </select>
		  </td>
          
          <td  width="10%" class="TxtTabla">&nbsp;            </td>
	  </tr>
	  <? } // del perfil ?>
        <tr>
          <td height="5" colspan="3" class="TituloTabla"> </td>
          </tr>
	</table>
	
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

	<!-- PAGINACIÓN -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="1" align="center" class="TituloTabla"> </td>
	  </tr>
	  <tr>
		<td align="center" class="TxtTabla">
		<?
		
		$pSql="SELECT *  ";
		$pSql=$pSql." FROM CSCPFicha ";
		$pSql = $pSql." WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
		$pSql = $pSql." AND codModulo=" . $_SESSION["ccfModulo"];
		//Si filtra por Formulario
		if (trim($fNoFormulario) != "") {
			$pSql = $pSql." AND numFormulario=" . $fNoFormulario;
		}

		//Si filtra por IDcartográfico
		if (trim($fIDCartografico) != "") {
			$pSql = $pSql." AND idCartografico like '%" . $fIDCartografico . "%'";
		}

		//Si filtra por el digitador
		if (trim($digitador) != "") {
			$pSql = $pSql." AND usuarioGraba like '%" . $digitador . "%'";
		}

		//Si es Digitador sólo muestra sus formularios
		if(($_SESSION["ccfUsuPerfil"]==2) ){
			$pSql = $pSql." AND usuarioGraba ='" . $_SESSION["ccfUsuID"]."'";
		}

		$pCursor = mssql_query($pSql) ;
		
		$totalRegistros = mssql_num_rows($pCursor);
		$totalPaginas = ceil($totalRegistros/30);
		
//		echo $totalRegistros . "<br>" ;
//		echo $totalPaginas . "<br>" ;
		
		for ($p=1; $p<= $totalPaginas; $p++) {
			//echo $p . " : " ;
			echo "<a href='frmCSCP.php?pagina=" . $p ."&digitador=". $digitador ."' class='menu2'>" . $p . "</a> | ";
		}
		?>
		
		
		</td>
	  </tr>
	  <tr>
		<td height="1" align="center" class="TituloTabla"> </td>
	  </tr>
	</table>

	<!-- Contador -->
	<table width="100%"  border="0">
	  <tr>
		<td class="TxtTabla">Encuestas Ingresadas: <? echo mssql_num_rows($pCursor); ?></td>
	  </tr>
	</table>

	<!--TITULO -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla">.: CENSO SOCIOECON&Oacute;MICO DE POBLACI&Oacute;N - CENTROS POBLADOS </td>
      </tr>
    </table>    
 
	<!--TABLA INFORMACION -->
<table width="100%"  border="0" cellspacing="1" cellpadding="1">
		  <tr>
          

            
			<td width="10%" class="TituloTabla2">N&uacute;mero de Formulario </td>
			<td width="10%" class="TituloTabla2">ID Cartogr&aacute;fico </td>
			<td width="10%" class="TituloTabla2">Fecha <br>
			  de toma de informaci&oacute;n<br>
			  (dd/mm/yyyy) </td>
			<td width="10%" class="TituloTabla2">Hora de Inicio </td>
		    <td class="TituloTabla2">C&oacute;digo Catastral </td>
		    <td width="10%" class="TituloTabla2">Segregaci&oacute;n</td>
		    <td width="10%" class="TituloTabla2">Vivienda</td>
		    <td width="10%" class="TituloTabla2">Hogar</td>
		    <td width="10%" class="TituloTabla2">ID Formulario y localizaci&oacute;n </td>
		    <td width="10%" class="TituloTabla2">ID Predio <br></td>
			<td width="10%" class="TituloTabla2">Vivienda</td>
			<td width="10%" class="TituloTabla2">Valoraci&oacute;n</td>
			<td width="10%" class="TituloTabla2">Firma</td>
			<td width="10%" class="TituloTabla2">Reg. Fotogr&aacute;fico y Resultados </td>
			<td width="10%" class="TituloTabla2">Control de trabajo </td>
			<td width="10%" class="TituloTabla2">Anexos</td>
			<td width="10%" class="TituloTabla2">Observaciones</td>
			<td width="1%" class="TituloTabla2">&nbsp;</td>
			<td width="1%" class="TituloTabla2">&nbsp;</td>
		  </tr>
	
		 <? 
		 /*
		 while ($reg0=mssql_fetch_array($cursorTOP)) { 
		 
		 
		 	$sqlInf = "SELECT * FROM CSEFichaPredio
					   WHERE nroPredio = ".$reg0[nroEncuesta];
			$cursorInf = mssql_query($sqlInf);
			$regInf = mssql_fetch_array($cursorInf);
			*/
			while ($reg0=mssql_fetch_array($cursor0)) { 
			
			
		 ?> 
		  <tr class="TxtTabla">
      
			<td width="10%" align="center" class="TxtTabla"><? echo $reg0[numFormulario];?></td>
			<td width="10%" align="center" class="TxtTabla"><? echo $reg0[idCartografico];?></td>
			<td width="10%" align="center" class="TxtTabla"><? echo date("d/m/Y", strtotime($reg0[fechaTomaInf])); ?></td>
			<td width="10%" align="center" class="TxtTabla"><? echo $reg0[horaInicio];?></td>
            <td align="center" class="TxtTabla"><? echo $reg0[codCatastral];?></td>
            <td width="10%" align="center" class="TxtTabla"><? echo $reg0[segregacion];?></td>
            <td width="10%" align="center" class="TxtTabla"><? echo $reg0[vivienda];?></td>
            <td width="10%" align="center" class="TxtTabla"><? echo $reg0[hogar];?></td>
            <td width="10%" class="TxtTabla" align="center"><img src="../images/icoInfo.gif" style="cursor:pointer " alt="Informaci&oacute;n del Predio" width="20" height="20" border="0" onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<? echo $reg0[numFormulario] ; ?>&cualPagina=1&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue"></td>
            <td width="10%" class="TxtTabla" align="center">
				<? //if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 			{ ?>
				<!--
				<input name="sethref" type="button" class="Boton" onClick='show()' value="Información Detallada Predio"> -->
				<img src="../images/imgPredial.gif" style="cursor:pointer " alt="Informaci&oacute;n del Predio" width="22" height="22" border="0" onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<? echo $reg0[numFormulario] ; ?>&cualPagina=2&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue">
				
				
				<? // } ?>
		    </td>
       		 
            			
			<td width="10%" class="TxtTabla" align="center">
			  <? 
			  //if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	{ 
			  ?>
			  <img src="../images/icoVivienda.gif" style="cursor:pointer " alt="Informaci&oacute;n de Viviendas" width="25" height="24" border="0" onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<? echo $reg0[numFormulario] ; ?>&cualPagina=3&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue">            
			  <!--
			  <img src="../images/icoVivienda.gif" style="cursor:pointer " alt="Informaci&oacute;n de Viviendas" width="25" height="24" border="0" onClick="MM_goToURL('parent','cargaEncuesta.php?cualE=<? // echo $reg0[numFormulario] ; ?>&cualPagina=3&cualV=<? //echo $reg0[nroVivienda] ; ?>&cualF=<? echo $reg0[nroFamilia] ; ?>');return document.MM_returnValue">            
			   -->
			  <? // } ?></td>
			  
			<td width="10%" class="TxtTabla" align="center"><img src="../images/icoCuantia.gif" style="cursor:pointer " alt="Informaci&oacute;n de Viviendas" width="16" height="16" border="0" onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<? echo $reg0[numFormulario] ; ?>&cualPagina=7&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue"></td>
			<td width="10%" class="TxtTabla" align="center">
			<? //if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13))  { ?>			  
				<img src="../images/icoFirma.gif" alt="Firma del encuestado" width="20" height="20" style="cursor:pointer " onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<? echo $reg0[numFormulario] ; ?>&cualPagina=8&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue">
			<? //} ?></td>
			
			<td width="10%" class="TxtTabla" align="center"><a href="#">
		     <? 
			 //if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 			{ ?>
		     <img src="../images/imgCamara.gif" alt="Registro fotogr&aacute;fico y Resultados de la visita" width="25" height="30" border="0" onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<?=$reg0[numFormulario];?>&cualPagina=9&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue"></a>
		     <? //} ?></td>
			 
			<td width="10%" class="TxtTabla" align="center">
			  <? //if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13))  			{ ?>          
			  <img src="../images/imgControl.gif" style="cursor:pointer " alt="Información de Control" width="23" height="30" border="0" onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<? echo $reg0[numFormulario] ; ?>&cualPagina=11&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue">          
			  <? // } ?>			</td>
			
			<td width="10%" class="TxtTabla" align="center">
			<? //if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 			{ ?>			  
			<img src="../images/imgAnexo.gif" style="cursor:pointer " alt="Aspectos bi&oacute;ticos (fauna)" width="20" height="30" border="0" onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<? echo $reg0[numFormulario] ; ?>&cualPagina=12&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue">
			  <? //} ?></td>
			<td width="10%" class="TxtTabla" align="center">
			<img src="../images/icoAdd.gif" style="cursor:pointer " alt="Informaci&oacute;n del Predio" width="16" height="15" border="0" onClick="MM_goToURL('parent','cargaFormulario.php?cualE=<? echo $reg0[numFormulario] ; ?>&cualPagina=13&cualSec=<? echo $reg0[consecutivo] ; ?>');return document.MM_returnValue">
			</td>
			<td width="1%" align="center" class="TxtTabla">
			<? 
		//SOLO ESTÁ DISPONIBLE PARA 1=Administrador, 2=Digitador, 3=Coordinador
		if (($_SESSION["ccfUsuPerfil"] == "1") OR ($_SESSION["ccfUsuPerfil"] == "2") OR ($_SESSION["ccfUsuPerfil"] == "3")) { ?>
			<a href="#"><img src="../images/imgUp.gif" alt="Editar Formulario" width="18" height="14" border="0" onClick="MM_openBrWindow('upFormulario.php?accion=2&e=<?=$reg0[numFormulario];?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')"></a>
			<? } ?>
			</td>
			<td width="1%" align="center" class="TxtTabla">
			<? 
		//SOLO ESTÁ DISPONIBLE PARA 1=Administrador, 2=Digitador, 3=Coordinador
		if (($_SESSION["ccfUsuPerfil"] == "1") OR ($_SESSION["ccfUsuPerfil"] == "2") OR ($_SESSION["ccfUsuPerfil"] == "3")) { ?>
			<a href="#"><img src="../images/del.gif" alt="Eliminar Formulario" width="14" height="13" border="0" onClick="MM_openBrWindow('upFormulario.php?accion=3&e=<?=$reg0[numFormulario];?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')"></a>
			<? } ?>
			</td>      
		  </tr>
		 <? } ?> 
		</table>

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>
		<? 
		//SOLO ESTÁ DISPONIBLE PARA 1=Administrador, 2=Digitador, 3=Coordinador
		if (($_SESSION["ccfUsuPerfil"] == "1") OR ($_SESSION["ccfUsuPerfil"] == "2") OR ($_SESSION["ccfUsuPerfil"] == "3")) { ?>
        	<input name="Submit" type="submit" class="Boton" onClick="MM_openBrWindow('addFormulario.php?accion=1','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" value="Nuevo Formulario">
		<? } ?>
        </td>
	  </tr>
	</table>

    <!--ESPACIO -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	
    
 	<!--DERECHO DE AUTOR -->
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


<? mssql_close ($conexion); ?>	
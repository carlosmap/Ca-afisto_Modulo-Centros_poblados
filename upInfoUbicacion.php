<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<?php

//Inicializa las variables de sesión
session_start();

//Validación de Ingreso
include ("../verificaIngreso2.php");

//Abre la conexión a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();


if($recarga!="")
{
	$pCodDepartamento = $pCodDepartamento;
	$pCodMunicipio = $pCodMunicipio;
	$pCodVereda = $pCodVereda;
	$pOtro = $pOtro;
}

//Obtener Titulo y/o Pregunta de la Sección
$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			FROM tmOpciones INNER JOIN
			tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			tmOpciones.codOpcion = tmItems.codOpcion";
$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$Opc;
$cursorTit = mssql_query($sqlTit);
if ($regTit = mssql_fetch_array($cursorTit)) 
{
	$pTituloPpal=$regTit[pregunta];
}

//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
$tipo=$_REQUEST["tipo"];
switch ($tipo) 
{ 
	case 0: 
		$nobj=$_SESSION["ccfFormulario"]; break; 
	case 1: 
		$nobj=$_SESSION["ccfPredio"]; break; 
	case 2: 
		$nobj=$_SESSION["ccfVivienda"]; break; 
	case 3: 
		$nobj=$_SESSION["ccfFamilia"]; break; 
} 


	$sqlRta = "select CSCPFichaFamilia.codDepartamento,CSCPFichaFamilia.codMunicipio,CSCPFichaFamilia.codVereda,CSCPFichaFamilia.sector from CSCPFichaFamilia
				INNER JOIN tmDepartamentos ON CSCPFichaFamilia.codDepartamento = tmDepartamentos.codDepartamento 
				INNER JOIN tmMunicipios ON CSCPFichaFamilia.codDepartamento = tmMunicipios.codDepartamento AND CSCPFichaFamilia.codMunicipio = tmMunicipios.codMunicipio 
				INNER JOIN	tmVeredas ON CSCPFichaFamilia.codDepartamento = tmVeredas.codDepartamento AND 
				CSCPFichaFamilia.codMunicipio = tmVeredas.codMunicipio AND CSCPFichaFamilia.codVereda = tmVeredas.codVereda
				where nroFamilia=".$_SESSION["ccfFamilia"];
	$cursorRta = mssql_query($sqlRta);

	while($datos_rta=mssql_fetch_array($cursorRta))
	{
		$depar=$datos_rta["codDepartamento"];
		$munici=$datos_rta["codMunicipio"];
		$vereda=$datos_rta["codVereda"];
		$sector=$datos_rta["sector"];
	}

	if($accion==3)
		$habilita="disabled";

//echo $sqlRta." --- $depar-- ".mssql_get_last_message()."<br>";

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{

	if($accion==2)
	{
		$qry = "UPDATE CSCPFichaFamilia set codDepartamento='".$pCodDepartamento."', codMunicipio='".$pCodMunicipio."',codVereda=".$pCodVereda;
		if(trim($pOtro)!="")
			$qry=$qry.", sector='".$pOtro."'";
	
		$qry=$qry." where nroFamilia=".$_SESSION["ccfFamilia"];
		$cursorIn = mssql_query($qry) ;
	}

	//la informacion no se elimina sino que se actualiza, colocando los campos en NULL
	if($accion==3)
	{
		$qry = "UPDATE CSCPFichaFamilia set codDepartamento=NULL, codMunicipio=NULL,codVereda=NULL";
		if(trim($pOtro)!="")
			$qry=$qry.", sector=NULL";
	
		$qry=$qry." where nroFamilia=".$_SESSION["ccfFamilia"];
		$cursorIn = mssql_query($qry) ;
	}
	if(trim($cursorIn) != "") 
	{
		echo ("<script>alert('La grabación se realizó con éxito');</script>");
	}
	else
	{
		echo ("<script>alert('Error durante la grabación. Verifique la información');</script>");
	}	
	
	$volverA = "";
	$volverA=Genera_Pagina($Opc,$pag);	
	echo ("<script>window.close();MM_openBrWindow('$volverA','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
}
 ?>

<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto  :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" src="calendar.js"></script>
<SCRIPT language=JavaScript>
<!--


function envia1(){ 
//alert ("Entro a envia 1");
document.form1.recarga.value="1";
document.form1.submit();
}

function envia2(){ 
	var v1,v2,v3, v4, i, CantCampos, msg1, msg2, msg3, msg4, mensaje;
	v1='s';
	v2='s';
	v3='s';
	v4='s';
	msg1 = '';
	msg2 = '';
	msg3 = '';
	msg4 = '';
	mensaje = '';





	if(document.form1.pCodDepartamento.value=="")
		msg1="Seleccione un departamento\n";
	if(document.form1.pCodMunicipio.value=="")
		msg1=msg1+"Seleccione un municipio\n";
	if(document.form1.pCodVereda.value=="")
		msg1=msg1+"Seleccione una vereda\n";
	
	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if (msg1!="") 
	{
		alert (msg1);

	}
	else 
	{
		document.form1.recarga.value="2";
		document.form1.submit();

	}
	
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#7B420F">
  <tr>
    <td>
	<form name="form1" method="post" action="">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla">&nbsp;<? echo $pTituloPpal ;?></td>
      </tr>
    </table>
	
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <? //Búsqueda de los departamentos
	  $sqlDep = "SELECT * FROM tmDepartamentos
	  			 ORDER BY nomDepartamento";
	  $cursorDep = mssql_query($sqlDep);
	  ?>
	  <tr>
        <td width="25%" class="TituloTabla2">Departamento</td>
        <td class="TxtTabla"><select name="pCodDepartamento" class="CajaTexto" id="pCodDepartamento" style="width:250" onChange="document.form1.submit();" <? echo $habilita ?>>
        <option value="">:: Seleccione un departamento ::</option>
		<?




		while($regDep = mssql_fetch_array($cursorDep))
		{
			$selDep = "";
			if ((!isset($pCodDepartamento))and ($regDep[codDepartamento]==$depar))
			{
				$selDep='selected'; $pCodDepartamento=$regDep[codDepartamento];
			}

			if($regDep[codDepartamento] == $pCodDepartamento)
			{
				$selDep = "selected";
			}
			?>
			<option value="<? echo $regDep[codDepartamento]; ?>" <? echo $selDep; ?>><? echo $regDep[nomDepartamento]; ?></option>
			<?
		}
		?>
		</select></td>
      </tr>
	  
	  <? //Búsqueda de los municipios
	  $sqlMun = "SELECT * FROM tmMunicipios
	  			 WHERE codDepartamento=".$pCodDepartamento."
				 ORDER BY nomMunicipio";
	  $cursorMun = mssql_query($sqlMun);
	  ?>
      <tr>
        <td width="25%" height="20" class="TituloTabla2">Municipio</td>
        <td class="TxtTabla"><select name="pCodMunicipio" class="CajaTexto" id="pCodMunicipio" style="width:250" onChange="document.form1.submit();" <? echo $habilita ?>>
        <option value="">:: Seleccione un municipio ::</option>
		<?

		while($regMun = mssql_fetch_array($cursorMun))
		{
			$selMun = "";
			if ((!isset($pCodMunicipio))and ($regMun[codMunicipio]==$munici))
			{
				$selMun='selected'; $pCodMunicipio=$regMun[codMunicipio];
			}

			if($regMun[codMunicipio] == $pCodMunicipio)
			{
				$selMun = "selected";
			}
			?>
			<option value="<? echo $regMun[codMunicipio]; ?>" <? echo $selMun; ?>><? echo $regMun[nomMunicipio]; ?></option>
			<?
		}
		?>
		</select></td>
      </tr>
	  
	  <? //Búsqueda de las veredas
	  $sqlVer = "SELECT * FROM tmVeredas
	  			 WHERE codDepartamento = ".$pCodDepartamento."
				 AND codMunicipio = ".$pCodMunicipio."
				 ORDER BY nomVereda";
	  $cursorVer = mssql_query($sqlVer);
	  ?>
	  <tr>
		<td width="25%" class="TituloTabla2">Vereda</td>
		<td class="TxtTabla"><select name="pCodVereda" class="CajaTexto" id="pCodVereda" style="width:250" <? echo $habilita ?>>
		<option value="">:: Seleccione una vereda ::</option>
		<?



		while($regVer = mssql_fetch_array($cursorVer))
		{
			$selVer = "";
			if ((!isset($pCodVereda))and ($regVer[codVereda]==$vereda))
			{
				$selVer='selected'; $pCodVereda=$regVer[codVereda];
			}
			if($regVer[codVereda] == $pCodVereda)
			{
				$selVer = "selected";
			}
			?>
			<option value="<? echo $regVer[codVereda]; ?>" <? echo $selVer; ?>><? echo $regVer[nomVereda]; ?></option>
			<?
		}
		?>
		</select>
		  <input name="recarga" type="hidden" id="recarga" value="1">
		  <input name="codItem" type="hidden" id="codItem" value="<? echo $regTit[codItem]; ?>"></td>
	  </tr>
	  
	  <? //if($s == 1){ ?>
	  <tr>
	    <td class="TituloTabla2">Sector</td>
	    <td class="TxtTabla"><input name="pOtro" type="text" class="CajaTexto" id="pOtro" value="<? echo $sector;; ?>" size="60" <? echo $habilita ?>></td>
	  </tr>
	  <? //} ?>
    </table>
	</form>  
	
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
			<?php if($accion==2) { $mensa="Editar"; } if($accion==3) { $mensa="Eliminar"; } ?>

        <td align="right"><input name="Submit2" type="button" class="Boton" value="<?php echo $mensa; ?>" onClick="envia2()"></td>
	  </tr>
    </table>	
	
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td height="20" class="copyr"> powered by INGETEC S.A - 2012</td>
	  </tr>
	</table>
	
	</td>
  </tr>
</table>


</body>
</html>

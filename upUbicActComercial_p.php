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


/*
if($recarga!="")
{
	$pCodDepartamento = $pCodDepartamento;
	$pCodMunicipio = $pCodMunicipio;
	$pCodVereda = $pCodVereda;
	$pOtro = $pOtro;
}
*/
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
		$qry = "UPDATE CSCPFichaFamilia SET 
				codDepartamento = '".$pCodDepartamento."', 
				codMunicipio = '".$pCodMunicipio."', 
				codVereda = '".$pCodVereda."',"; 
			if(trim($pCodItemCentroPoblado)!="")
					$qry =$qry."codItemCentroPoblado = '".$pCodItemCentroPoblado."', ";
			else
				$qry =$qry."codItemCentroPoblado = NULL, ";

			if(trim($pCodItemCorregimiento)!="")
				$qry =$qry."codItemCorregimiento = '".$pCodItemCorregimiento."',";
			else
				$qry =$qry."codItemCorregimiento = NULL, ";	

		if(trim($pOtro)!="")
			$qry=$qry." sector='".$pOtro."', ";
					
		$qry = $qry." usuarioMod = '".$_SESSION['ccfUsuID']."', ";
		$qry = $qry." fechaMod = '".date('d-m-Y')."'";
		$qry = $qry." where nroFamilia=".$_SESSION["ccfFamilia"];
		#echo $qry;
		#$cursorIn = mssql_query($qry) ;
	}

	//la informacion no se elimina sino que se actualiza, colocando los campos en NULL
	if($accion==3)
	{
		$qry = "UPDATE CSCPFichaFamilia SET 
				codDepartamento = NULL, 
				codMunicipio = NULL,
				codVereda = NULL,
				codItemCentroPoblado = NULL, 
				codItemCorregimiento = NULL,
				sector = NULL, 
				usuarioMod = '".$_SESSION['ccfUsuID']."', ";
		$qry = $qry." fechaMod = '".date('dmY')."'";
		$qry = $qry." where nroFamilia=".$_SESSION["ccfFamilia"];
	}
	$cursorIn = mssql_query($qry) ;
	if(trim($cursorIn) != "") 
	{
		echo ("<script>alert('La grabación se realizó con éxito');</script>");
	}
	else
	{
		echo ("<script>alert('Error durante la grabación. Verifique la información');</script>");
	}	
	
	$volverA = "frmCensoFamiliaActividad.php";
	//$volverA=Genera_Pagina($Opc,$pag);	
	#/*
	echo ("<script>window.close();MM_openBrWindow('$volverA','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");#*/
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
//    
	if(document.form1.pCodDepartamento.value=="")
		msg1="Seleccione un departamento\n";
	
	if(document.form1.pCodMunicipio.value=="")
		msg1=msg1+"Seleccione un municipio\n";
	
	if(document.form1.pCodVereda.value=="")
		msg1=msg1+"Seleccione una vereda\n";
/*
	if(document.form1.pCodItemCorregimiento.value=="")
		msg1=msg1+"Seleccione un corregimiento\n";
	
	if(document.form1.pCodItemCentroPoblado.value=="")
		msg1=msg1+"Seleccione un centro poblado\n";
	//alert( 'info' );
*/
	
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
function envia(){ 
	document.form1.recarga.value="2";
	document.form1.submit();
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<form name="form1" method="post" action="">
<!--
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#7B420F">
  <tr>
    <td height="235">
    -->
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla">&nbsp; 6.2 En que lugar realiza la actividad econ&oacute;mica principal? </td>
      </tr>
  </table>
	
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td class="TituloTabla2">Departamento</td>
        <td class="TxtTabla"><? //B&uacute;squeda de los departamentos
		$dis = "";


		if(!(isset($pCodDepartamento)) ) //si es la primera vez que se carga la pagina, almacena la informacion con la que se ha almacenado el registro
		{
//		echo "ingres";

		$sqlUbica = "SELECT codDepartamento, codMunicipio, codVereda, codItemCentroPoblado, codItemCorregimiento , sector
					 FROM CSCPFichaFamilia WHERE nroFamilia = ".$_SESSION["ccfFamilia"];			
			$qryUbica = mssql_fetch_array( mssql_query( $sqlUbica ) );
			$pCodDepartamento = $qryUbica[codDepartamento];	
			if (trim($pCodMunicipio)=="") {
				$pCodMunicipio = $qryUbica[codMunicipio];
				$pCodVereda= $qryUbica[codVereda];
				$pCodItemCorregimiento = $qryUbica[codItemCorregimiento];
				$pCodItemCentroPoblado = $qryUbica[codItemCentroPoblado];

			}
//echo $qryUbica[codMunicipio
		}
		/*
		echo $qryUbica[codDepartamento] . "<br>";
		echo $qryUbica[codMunicipio] . "<br>";
		echo $qryUbica[codVereda] . "<br>";
		echo $qryUbica[codItemCorregimiento] . "<br>";
		echo $qryUbica[codItemCentroPoblado] . "<br>";
		echo $qryUbica[sector] . "<br>";
		#*/

	
		
		if( $accion == 3 )
			$dis = "disabled";
	  $sqlDep = "Select * From tmDepartamentos";
	  $cursorDep = mssql_query($sqlDep);
#	  echo $sqlDep;
	  ?>
          <select name="pCodDepartamento" class="CajaTexto" id="pCodDepartamento" <?= $dis ?> onChange="document.form1.submit();" <? echo $dis; ?> style="width:250">
            <option value="">:: Seleccione un departamento ::</option>
            <?
		  while($regDep = mssql_fetch_array($cursorDep)){
		  	  $selDep = "";
			  if($regDep[codDepartamento] == $qryUbica[codDepartamento]){
			  	 $selDep = "selected";
			  }
			  if($regDep[codDepartamento] == $pCodDepartamento){
			  	 $selDep = "selected";
			  }
			  ?>
            <option value="<? echo $regDep[codDepartamento]; ?>" <? echo $selDep; ?>><? echo $regDep[nomDepartamento]; ?></option>
            <?
		  }
		  ?>
          </select></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Municipio</td>
        <td class="TxtTabla"><? //B&uacute;squeda de los municipios
		 $sqlMun = "SELECT * FROM tmMunicipios WHERE codDepartamento =".$pCodDepartamento;								 
	  $cursorMun = mssql_query($sqlMun);
	 #echo $sqlMun;
	  //echo mssql_num_rows($cursorMun);
	  ?>
          <select name="pCodMunicipio" class="CajaTexto" id="pCodMunicipio" <?= $dis ?> onChange="document.form1.submit();" <? echo $dis; ?> style="width:250">
            <option value="">:: Seleccione un municipio ::</option>
            <?
		  while($regMun = mssql_fetch_array($cursorMun))
		  {
		  	  $selMun = "";
			  if (trim($recarga) == "") {
				  if($regMun[codMunicipio] == $qryUbica[codMunicipio])
				  {
					 $selMun = "selected";
				  }
			}
			 else {
				  if($regMun[codMunicipio] == $pCodMunicipio)
				  {
					 $selMun = "selected";
				  }
				 }
			  ?>
            <option value="<? echo $regMun[codMunicipio]; ?>" <? echo $selMun; ?>><? echo $regMun[nomMunicipio]; ?></option>
            <?
		  }
		  ?>
          </select></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Vereda</td>
        <td class="TxtTabla"><? //B&uacute;squeda de las veredas
	  $sqlVer = "SELECT * FROM tmVeredas tmv";
				$sqlVer .= " WHERE codMunicipio = ".$pCodMunicipio." AND codDepartamento = ".$pCodDepartamento;
	  $cursorVer = mssql_query($sqlVer);
	  #echo $sqlVer;
	  ?>
          <select name="pCodVereda" class="CajaTexto" id="pCodVereda" onChange="document.form1.submit();" <? echo $dis; ?> style="width:250">
            <option value="">:: Seleccione una vereda ::</option>
            <?
		  while($regVer = mssql_fetch_array($cursorVer))
		  {
			  $selVer = "";
			  
			  if (trim($recarga) == "") {
				  if($regVer[codVereda] == $qryUbica[codVereda])
				  {
					 $selVer = "selected";
				  }
			}
			 else {
				  if($regVer[codVereda] == $pCodVereda)
				  {
					 $selVer = "selected";
				  }
				 }
			  
			  ?>
            <option value="<? echo $regVer[codVereda]; ?>" <? echo $selVer; ?>><? echo $regVer[nomVereda]; ?></option>
            <?
		  }
		  ?>
          </select></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Corregimiento</td>
        <td class="TxtTabla"><? //B&uacute;squeda de los corregimientos
	  
	  $sqlCorr = "SELECT DISTINCT tmu.codDepartamento, tmd.nomDepartamento, tmu.codMunicipio, tmm.nomMunicipio, tmv.codVereda 
					, tmv.nomVereda, tmi.nomItem Corregimiento, tmi.codItem codCorregimiento
				FROM 
					tmUbicacion tmu, tmDepartamentos tmd, tmMunicipios tmm, tmVeredas tmv, tmItems tmi, tmItems cp
				WHERE
					tmu.codProyecto =  ".$_SESSION["ccfProyecto"]." AND tmu.codDepartamento=".$pCodDepartamento."
					AND tmu.codMunicipio=".$pCodMunicipio." AND tmu.codVereda = ".$pCodVereda."
					AND tmu.codDepartamento = tmd.codDepartamento
					AND tmu.codDepartamento = tmm.codDepartamento
					AND tmu.codMunicipio = tmm.codMunicipio
					AND tmu.codDepartamento = tmv.codDepartamento
					AND tmu.codMunicipio = tmv.codMunicipio
					AND tmu.codVereda = tmv.codVereda
					AND tmu.codItemCorregimiento = tmi.codItem
					AND tmu.codItemCentroPoblado = cp.codItem";
	  #echo $sqlCorr."<br />";
	  $cursorCorr = mssql_query($sqlCorr);
	  ?>
          <select name="pCodItemCorregimiento" class="CajaTexto" id="pCodItemCorregimiento" <?= $dis ?> onChange="document.form1.submit();" <? echo $dis; ?> style="width:250">
            <option value="">:: Seleccione un corregimiento ::</option>
            <?
		  while($regCorr = mssql_fetch_array($cursorCorr))
		  {
		  	  $selCorr = "";
###		  
			  if (trim($recarga) == "") {
			  if($regCorr[codCorregimiento] == $qryUbica[codItemCorregimiento])
			  {
			  	 $selCorr = "selected";
			  }
			}
			 else {
			  if($regCorr[codCorregimiento] == $pCodItemCorregimiento)
			  {
			  	 $selCorr = "selected";
			  }
				 }

###
			  ?>
            <option value="<? echo $regCorr[codCorregimiento]; ?>" <? echo $selCorr; ?>><? echo $regCorr[Corregimiento]; ?></option>
            <?
		  }
		  ?>
          </select></td>
      </tr>
      <tr>
        <td class="TituloTabla2">Centro Poblado </td>
        <td class="TxtTabla"><? //B&uacute;squeda de los centros poblados
	  $sqlCP = "SELECT DISTINCT tmu.codDepartamento, tmd.nomDepartamento, tmu.codMunicipio, tmm.nomMunicipio, tmv.codVereda 
					, tmv.nomVereda, tmi.nomItem Corregimiento, tmi.codItem codCorregimiento, cp.nomItem CentroPob
					, cp.codItem codCentroPob
				FROM 
					tmUbicacion tmu, tmDepartamentos tmd, tmMunicipios tmm, tmVeredas tmv, tmItems tmi, tmItems cp
				WHERE
					tmu.codProyecto =  ".$_SESSION["ccfProyecto"]." AND tmu.codDepartamento=".$pCodDepartamento."
					AND tmu.codMunicipio=".$pCodMunicipio." AND tmu.codVereda = ".$pCodVereda."
					AND tmu.codItemCorregimiento = ".$pCodItemCorregimiento."				
					AND tmu.codDepartamento = tmd.codDepartamento
					AND tmu.codDepartamento = tmm.codDepartamento
					AND tmu.codMunicipio = tmm.codMunicipio
					AND tmu.codDepartamento = tmv.codDepartamento
					AND tmu.codMunicipio = tmv.codMunicipio
					AND tmu.codVereda = tmv.codVereda
					AND tmu.codItemCorregimiento = tmi.codItem
					AND tmu.codItemCentroPoblado = cp.codItem";

	  #echo $sqlCP."<br />";

#	  echo $sqlCP."<br />";
	  $cursorCP = mssql_query($sqlCP);
	  ?>
          <select name="pCodItemCentroPoblado" class="CajaTexto" id="pCodItemCentroPoblado" <?= $dis ?> onChange="document.form1.submit();" <? echo $dis; ?> style="width:250">
            <option value="">:: Seleccione un centro poblado ::</option>
            <?
		  while($regCP = mssql_fetch_array($cursorCP))
		  {
		  	  $selCP = "";
			  #	$qryUbica , , , codItemCentroPoblado,  
###		  
			  if (trim($recarga) == "") {
			  if($regCP[codCentroPob] == $qryUbica[codItemCentroPoblado])
			  {
			  	 $selCP = "selected";
			  }
			}
			 else {
			  if($regCP[codCentroPob] == $pCodItemCentroPoblado)
			  {
			  	 $selCP = "selected";
			  }
				 }

###
			  
			  ?>
            <option value="<? echo $regCP[codCentroPob]; ?>" <? echo $selCP; ?>><? echo $regCP[CentroPob]; ?></option>
            <?
		  }
		  ?>
          </select></td>
      </tr>
      <? //Búsqueda de los departamentos
	  $sqlDep = "SELECT * FROM tmDepartamentos
	  			 ORDER BY nomDepartamento";
	  $cursorDep = mssql_query($sqlDep);
	  //Búsqueda de los municipios
	  $sqlMun = "SELECT * FROM tmMunicipios
	  			 WHERE codDepartamento=".$pCodDepartamento."
				 ORDER BY nomMunicipio";
	  $cursorMun = mssql_query($sqlMun);
	  //Búsqueda de las veredas
	  $sqlVer = "SELECT * FROM tmVeredas
	  			 WHERE codDepartamento = ".$pCodDepartamento."
				 AND codMunicipio = ".$pCodMunicipio."
				 ORDER BY nomVereda";
	  $cursorVer = mssql_query($sqlVer);
	  ?>
	  <tr>
	    <td width="25%" class="TituloTabla2">Sector</td>
	    <td class="TxtTabla"><input name="pOtro" type="text" class="CajaTexto" id="pOtro" <?= $dis ?> value="<? echo $sector; ?>" size="60" <? echo $habilita ?>>
	      <input name="recarga" type="hidden" value="0" /></td>
	  </tr>
    </table>
	
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
        <?php 
			if($accion==2) { 
		?>
        <input name="Submit2" type="button" class="Boton" value="Guardar" onClick="envia2()">
        <?
		} if($accion==3) { 
		?>
         <input name="Submit2" type="button" class="Boton" value="Eliminar" onClick="envia()">
         <input name="Submit" type="button" class="Boton" value="Cancelar" onClick="javascript:window.close()">
       <?
		} 
		?>
        </td>
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
	<!--
	</td>
  </tr>
</table>
-->
</form>  


</body>
</html>

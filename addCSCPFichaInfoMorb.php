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
include ("../validaUsu.php");

include ("../verificaIngreso2.php");

//Abre la conexión a la BD
//include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
//$conexion = conectar();

//Trae la información del Modulo
//dbo.tmModulos
//codModulo, nomModulo, siglaModulo, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlPC01="SELECT * FROM tmModulos WHERE codModulo= " .$_SESSION["ccfModulo"] ; 
$cursorPC01 = mssql_query($sqlPC01) ;
if ($regPC01=mssql_fetch_array($cursorPC01)) 
{
	$proyModulo=$regPC01[nomModulo];
}

//Obtener Titulo y/o Pregunta de la Sección
//dbo.tmOpciones
//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
//dbo.tmItems
//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
FROM tmOpciones INNER JOIN
     tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
     tmOpciones.codOpcion = tmItems.codOpcion";
$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$Opc;
$cursorTit = mssql_query($sqlTit);
if ($regTit=mssql_fetch_array($cursorTit)) 
{
	$pTituloPpal=$regTit[pregunta];
}

//Trae la información de los items
//dbo.tmOpciones
//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
//dbo.tmItems
//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sql="SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
FROM tmOpciones INNER JOIN
     tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
     tmOpciones.codOpcion = tmItems.codOpcion";
$sql= $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sql= $sql. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sql= $sql. " AND tmOpciones.codOpcion=".$Opc;
$cursor = mssql_query($sql);

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

//$recarga = 2 si se presionó el botón Grabar
if (trim($recarga)=='2') 
{
	//Grabar Registros 
	//dbo.CSCPFichaInfoBoolean
	//codProyecto, codModulo, numFormulario, nroObjeto, tipoObjeto, codOpcion, codItem, respItem, 
	//descripcion, fechaGraba, usuarioGraba, fechaMod, usuarioMod

		$sqlIn = "INSERT INTO CSCPFichaInfoUbicacion(codProyecto, codModulo, numFormulario, consecutivo, nroObjeto, tipoObjeto, codOpcion,codItem,
				   codDepartamento,codMunicipio,codVereda, fechaGraba, usuarioGraba) ";
		$sqlIn = $sqlIn." VALUES ( ";
		$sqlIn = $sqlIn . $_SESSION["ccfProyecto"] . ",";
		$sqlIn = $sqlIn . $_SESSION["ccfModulo"] . ",";
		$sqlIn = $sqlIn . "'".$_SESSION["ccfFormulario"] . "',";
		$sqlIn= $sqlIn. " ".$_SESSION["ccfConsecutivo"]."," ;
		$sqlIn = $sqlIn . $nobj. ",";
		$sqlIn = $sqlIn . $tipo.", ";
		$sqlIn = $sqlIn . $Opc.", ";	
		$sqlIn = $sqlIn . $aplica.", ";	

		$sqlIn= $sqlIn. " '".$pCodDepartamento."'," ;
		$sqlIn= $sqlIn. " '".$pCodMunicipio."'," ;

		if(trim($pCodVereda)!='')
			$sqlIn= $sqlIn. " '".$pCodVereda."'," ;
		else
			$sqlIn= $sqlIn. " NULL," ;

		$sqlIn = $sqlIn. " '" . gmdate("n/d/y") ."', ";
		$sqlIn = $sqlIn . " '".$_SESSION["ccfUsuID"]."' " ;
		$sqlIn = $sqlIn." ) ";
		$insertion = $insertion.$sqlIn."<br>";
		$cursorIn = mssql_query($sqlIn);

//echo 	$sqlIn." ----  ".mssql_get_last_message()."<br>";

	if  (trim($cursorIn) != " ") 
	{
		echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
	} 
	else 
	{
		echo ("<script>alert('Error durante la grabación');</script>");
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
<SCRIPT language=JavaScript>
<!--
function envia2()
{ 
var v1,v2,v3, i, CantCampos, msg1, msg2, msg3, mensaje;
v1='s';
v2='s';
v3='s';
msg1 = '';
msg2 = '';
msg3 = '';
mensaje = '';

var elLength = document.form1.length.value;
//alert(elLength);
/*
	if(((!document.form1.finalizada[0].checked && !document.form1.finalizada[1].checked)))
	{
		alert("Especifique si la orden de ensayo se encuentra finalizada");
	}
	
*/
	var cont=0;
	var band=0;
	for (i=0; i<elLength; i++)
	{
		if(((document.form1.aplica[i].checked)))
		{
			band=1;
		}
	}

	if(band==0)
	{
		v1='n';
		msg1 = 'Seleccione el item al cual aplica. \n';
	}
	if(document.form1.pCodDepartamento.value=='')
	{
		v1='n';
		msg2='Seleccione un departamento. \n';
	}
	if(document.form1.pCodMunicipio.value=='')
	{
		v1='n';
		msg3='Seleccione un municipio. \n';
	}
	if ((v1=='s') && (v2=='s')  && (v3=='s')) 
	{

		document.form1.recarga.value="2";
//	alert(document.form1.recarga.value);
		document.form1.submit();
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 ;
		alert (mensaje);
	}	

}
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//-->
</SCRIPT>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
<form name="form1" method="post" action="">
  <tr>
    <td>
    
    <!-- NOMBRE DEL MODULO-->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><? echo $proyModulo;?></td>
      </tr>
    </table>

    <!-- TABLA DE INFORMACION-->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
	<tr class="TituloTabla2">
		<td colspan="3"><? echo $pTituloPpal ;?></td>
	</tr>
      <tr class="TituloTabla2">
        <td rowspan="2"></td>
        <td width="7%">Aplica</td>
        <td width="10%">Seleccione el municipio</td>
      </tr>
      
      <tr class="TituloTabla2">
        <td width="7%">Si</td>
        <td width="8%"></td>
      </tr>
	
	  <tr>
		<td colspan="2">
		<table width="100%">
	  <?php 
	  $i=1;	
	   $filas=mssql_num_rows($cursor);
	  while ($reg=mssql_fetch_array($cursor)) 
	  { ?>

          <tr align="center" class="TxtTabla">
            <td align="left">
              <?php echo $reg[nomItem];  ?>
              <input name="item<? echo $i; ?>" type="hidden" id="item<? echo $i; ?>" value="<? echo $reg[codItem];  ?>">			
            </td>
            <td width="20%" align="center">
				<?php 
					$chec="";
					if($aplica== $reg[codItem])
						$chec='checked';
						
				?>
                <input name="aplica" type="radio" value="<?php echo $reg[codItem]; ?>" <? echo $chec; ?> >		</td>
          </tr>

	  <? 
		  $i=$i+1;
	  } ?>
		</table>
		</td>

		<td>

		<table>
		<tr  class="TxtTabla">
		<td rowspan="<?php echo $filas; ?>">
               <table width="100%"  border="0" cellspacing="1" cellpadding="0">
                  <? //Búsqueda de los departamentos
                  $sqlDep = "SELECT * FROM tmDepartamentos
                             ORDER BY nomDepartamento";
                  $cursorDep = mssql_query($sqlDep);
                  ?>
                  <tr>
                    <td width="25%" class="TituloTabla2">Departamento</td>
                    <td class="TxtTabla"><select name="pCodDepartamento" class="CajaTexto" id="pCodDepartamento" style="width:250" onChange="document.form1.submit();">
                    <option value="">:: Seleccione un departamento ::</option>
                    <?
                    while($regDep = mssql_fetch_array($cursorDep))
                    {
                        $selDep = "";
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
                    <td class="TxtTabla"><select name="pCodMunicipio" class="CajaTexto" id="pCodMunicipio" style="width:250" onChange="document.form1.submit();">
                    <option value="">:: Seleccione un municipio ::</option>
                    <?
                    while($regMun = mssql_fetch_array($cursorMun))
                    {
                        $selMun = "";
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
                    <td class="TxtTabla"><select name="pCodVereda" class="CajaTexto" id="pCodVereda" style="width:250">
                    <option value="">:: Seleccione una vereda ::</option>
                    <?
                    while($regVer = mssql_fetch_array($cursorVer))
                    {
                        $selVer = "";
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

                      <input name="codItem" type="hidden" id="codItem" value="<? echo $regTit[codItem]; ?>"></td>
                  </tr>

                </table>			
		</td>
	   </tr>
	  </table>
		</td>
		</tr>
    </table>
    
    <!-- BOTONES -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="cantidadItem" type="hidden" id="cantidadItem" value="<? echo mssql_num_rows($cursor); ?>">
            <input name="rta" type="hidden" id="rta" value="<? echo $uni; ?>">
            <input name="length" type="hidden" id="length" value="<? echo $i-1; ?>">

			<input name="recarga" type="hidden" id="recarga" value="1">
			<input name="Submit" type="submit" class="Boton" value="Grabar" onClick="envia2()">		  
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

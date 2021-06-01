<script type="text/JavaScript" language="javascript1.2">
<!--
function MM_callJS(jsStr) 
{ //v2.0
  return eval(jsStr)
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


//-->
</script>

<?php

//16 de Julio de 2011
//Patricia Gutiérrez Restrepo
//Adición de un Registro de Familia
//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();




//Trae la información del Modulo
//dbo.tmModulos
//codModulo, nomModulo, siglaModulo, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlPC01="SELECT * FROM tmModulos WHERE codModulo= " .$_SESSION["ccfModulo"] ; 
$cursorPC01 = mssql_query($sqlPC01) ;
if ($regPC01=mssql_fetch_array($cursorPC01)) 
{
	$proyModulo=$regPC01[nomModulo];
}

//cosnulta los items de la pregunta
$sql_sub_items="select * from tmSubItems where codOpcion=".$Opc;
$sql_sub_items= $sql_sub_items. " and tmSubItems.codProyecto=".$_SESSION["ccfProyecto"] ;
$sql_sub_items= $sql_sub_items. " AND tmSubItems.codModulo=".$_SESSION["ccfModulo"] ;
$cur_sub_item=mssql_query($sql_sub_items);

//echo $sql_sub_items." --- ".mssql_get_last_message()."<br><br>";

//Obtener Titulo y/o Pregunta de la Sección
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

	$sqlRta="select * from CSCPFichaFamiliaMorbilidad
			inner join tmSubItems on CSCPFichaFamiliaMorbilidad.codSubItemSexo=tmSubItems.codSubItem ";
	$sqlRta= $sqlRta. " WHERE CSCPFichaFamiliaMorbilidad.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.nroVivienda=".$_SESSION["ccfVivienda"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.nroFamilia=".$_SESSION["ccfFamilia"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.nroPredio=".$_SESSION["ccfPredio"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaMorbilidad.consecMorbilidad=".$conse ;
	$cur_morb=mssql_query($sqlRta);
	while($datos_morb=mssql_fetch_array($cur_morb))
	{
			$cod_sub_sex=$datos_morb["codSubItem"];
			$edadh=$datos_morb["edad"];
			$caus=$datos_morb["causa"];
	}

//si se ha seleccionado eliminar, se desabilitan los campos 
	if($accion==3)
		$habilita="disabled";
//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
		//si se selecciono actualizar el registro
		if($accion==2)
		{

			$laedad = "edad";
//echo $laedad." ***///<br>";
			$sqlup=" UPDATE CSCPFichaFamiliaMorbilidad set codSubItemSexo=".$sex.",edad=".${$laedad}.",causa='".$causa."' ";
			$sqlup= $sqlup. " WHERE CSCPFichaFamiliaMorbilidad.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.codModulo=".$_SESSION["ccfModulo"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.consecutivo=".$_SESSION["ccfConsecutivo"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.nroVivienda=".$_SESSION["ccfVivienda"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.nroFamilia=".$_SESSION["ccfFamilia"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.nroPredio=".$_SESSION["ccfPredio"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.consecMorbilidad=".$conse ;
			$cur_up=mssql_query($sqlup);
		}
		if($accion==3)
		{
			$sqlup=" DELETE CSCPFichaFamiliaMorbilidad ";
			$sqlup= $sqlup. " WHERE CSCPFichaFamiliaMorbilidad.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.codModulo=".$_SESSION["ccfModulo"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.consecutivo=".$_SESSION["ccfConsecutivo"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.nroVivienda=".$_SESSION["ccfVivienda"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.nroFamilia=".$_SESSION["ccfFamilia"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.nroPredio=".$_SESSION["ccfPredio"] ;
			$sqlup= $sqlup. " AND CSCPFichaFamiliaMorbilidad.consecMorbilidad=".$conse ;
			$cur_up=mssql_query($sqlup);
		}
//echo 	$sqlup." ----  ".mssql_get_last_message()."<br>";


			if(trim($cur_up) != "")
			{
				echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
			}
			else
			{
				echo ("<script>alert('Error en la operación');</script>");
			}

	$volverA = "";
	$volverA=Genera_Pagina(0,3);	
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

var nav4 = window.Event ? true : false;
function acceptNum(evt){   
var key = nav4 ? evt.which : evt.keyCode;   
return (key <= 13 || (key>= 48 && key <= 57));
}


<!--
function envia2(){ 

	var msg="";
	if(document.form1.sex.value=="")
	{
		msg="Seleccione un sexo\n";
	}
	if(document.form1.edad.value=="")
	{
		msg=msg+"El campo edad es obligatorio \n";
	}
	 if(document.form1.causa.value=="")
	{
		msg=msg+"El campo causa es obligatorio \n";
	}

	if(msg=="")
	{
		document.form1.recarga.value="2";		
		document.form1.submit();
	}
	else
	{
//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
		alert(msg);
	}



}

//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#00344C">
<form name="form1" method="post" action="">  
  <tr>
    <td> 	  
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
        
    <!-- TITULO -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><? echo $proyModulo;?></td>
        </tr>
    </table>

    <!--TABLA DE INFORMACION  -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
		<tr class="TituloTabla2">
			<td colspan="3"><? echo $pTituloPpal ;?></td>
		</tr>
      <tr>
          <td class="TxtTabla">Sexo de la persona fallecida</td>
          <td class="TxtTabla"><select name="sex" id="sex"  class="CajaTexto" <? echo $habilita; ?>>
            <option value="">Seleccione sexo</option>
<?php


				while($datos_sub_i=mssql_fetch_array($cur_sub_item))
				{
					$sele="";
					if($cod_sub_sex==$datos_sub_i["codSubItem"])
						$sele="selected";
?>
					<option value="<?php echo $datos_sub_i["codSubItem"]; ?>" <?php echo $sele; ?> ><? echo $datos_sub_i["nomSubItem"]; ?></option>
<?php
				}
?>
			</select>

           </td>
      </tr>  
      <tr>
          <td class="TxtTabla">Edad al morir</td>
          <td class="TxtTabla">
			<input name="edad" type="text" class="CajaTexto" id="edad" onKeyPress="return acceptNum(event)"   size="3" maxlength="3" <? echo $habilita; ?> value="<?=$edadh; ?>" > 
           </td>
      </tr>  
      <tr>
          <td class="TxtTabla">Causa del fallecimiento</td>
          <td class="TxtTabla">
			<textarea name="causa" class="CajaTexto" id="causa" <? echo $habilita; ?> ><?php echo $caus; ?></textarea>
           </td>
      </tr>  
    </table>

    <!--BOTONES -->   
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%">&nbsp;</td>
        <td align="right">
          <input name="recarga" type="hidden" id="recarga" value="1">   
			<?php if($accion==2) { $mensa="Editar"; } if($accion==3) { $mensa="Eliminar"; } ?>    
          <input name="Submit2" type="button" class="Boton" value="<? echo $mensa; ?> " onClick="envia2()">
          </td>
      </tr>
    </table>
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
        <td class="copyr"> powered by INGETEC S.A - 2012 </td>
      </tr>
    </table>	
	
    </td>
  </tr>
 </form>   
</table>
</body>
</html>

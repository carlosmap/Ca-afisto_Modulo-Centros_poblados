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


//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
			$max_morb=0;
			//consulta la secuencia de la morbilidad para esa familia
			$sql_morb_conse="select  MAX(consecMorbilidad) as max_morb  from CSCPFichaFamiliaMorbilidad";
			$sql_morb_conse= $sql_morb_conse. " WHERE CSCPFichaFamiliaMorbilidad.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sql_morb_conse= $sql_morb_conse. " AND CSCPFichaFamiliaMorbilidad.codModulo=".$_SESSION["ccfModulo"] ;
			$sql_morb_conse= $sql_morb_conse. " AND CSCPFichaFamiliaMorbilidad.consecutivo=".$_SESSION["ccfConsecutivo"] ;
			$sql_morb_conse= $sql_morb_conse. " AND CSCPFichaFamiliaMorbilidad.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
			$sql_morb_conse= $sql_morb_conse. " AND CSCPFichaFamiliaMorbilidad.nroVivienda=".$_SESSION["ccfVivienda"] ;
			$sql_morb_conse= $sql_morb_conse. " AND CSCPFichaFamiliaMorbilidad.nroFamilia=".$_SESSION["ccfFamilia"] ;
			$sql_morb_conse= $sql_morb_conse. " AND CSCPFichaFamiliaMorbilidad.nroPredio=".$_SESSION["ccfPredio"] ;
			$cur_morb=mssql_query($sql_morb_conse);
			if($datos_morb=mssql_fetch_array($cur_morb))
			{
				$max_morb=$datos_morb["max_morb"];
			}
			$max_morb++;

			$sql_insert="insert into CSCPFichaFamiliaMorbilidad (codProyecto,codModulo,numFormulario,consecutivo,nroPredio,nroVivienda,nroFamilia,consecMorbilidad ,codSubItemSexo,edad,causa,fechaGraba,usuarioGraba)";
			$sql_insert=$sql_insert."values(";
			$sql_insert = $sql_insert . $_SESSION["ccfProyecto"] . ",";
			$sql_insert = $sql_insert . $_SESSION["ccfModulo"] . ",";
			$sql_insert = $sql_insert . "'".$_SESSION["ccfFormulario"] . "',";
			$sql_insert= $sql_insert. " ".$_SESSION["ccfConsecutivo"]."," ;
			$sql_insert= $sql_insert. " ".$_SESSION["ccfPredio"]."," ;
			$sql_insert= $sql_insert. " ".$_SESSION["ccfVivienda"]."," ;
			$sql_insert= $sql_insert. " ".$_SESSION["ccfFamilia"]."," ;

			$sql_insert= $sql_insert. " ".$max_morb."," ;

			$sql_insert= $sql_insert. " ".$sex."," ;
			$sql_insert= $sql_insert. " ".$edad."," ;
			$sql_insert= $sql_insert. " '".$causa."'," ;
			$sql_insert = $sql_insert. " '" . gmdate("n/d/y") ."', ";
			$sql_insert = $sql_insert . " '".$_SESSION["ccfUsuID"]."' " ;


			$sql_insert=$sql_insert.")";

//echo 	$sql_insert." ----  ".mssql_get_last_message()."<br>";

			$cursorIn=mssql_query($sql_insert);

			if(trim($cursorIn) != "")
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
          <td class="TxtTabla">
			<select name="sex" id="sex"  class="CajaTexto" >
				<option value="">Seleccione sexo</option>
<?php
				while($datos_sub_i=mssql_fetch_array($cur_sub_item))
				{
?>
					<option value="<?php echo $datos_sub_i["codSubItem"]; ?>"><? echo $datos_sub_i["nomSubItem"]; ?></option>
<?php
				}
?>
			</select>

           </td>
      </tr>  
      <tr>
          <td class="TxtTabla">Edad al morir</td>
          <td class="TxtTabla">
			<input type="text" name="edad" id="edad" maxlength="3" size="3" onKeyPress="return acceptNum(event)" >
           </td>
      </tr>  
      <tr>
          <td class="TxtTabla">Causa del fallecimiento</td>
          <td class="TxtTabla">
			<textarea id="causa" name="causa"  ></textarea>
           </td>
      </tr>  
    </table>

    <!--BOTONES -->   
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%">&nbsp;</td>
        <td align="right">
          <input name="recarga" type="hidden" id="recarga" value="1">       
          <input name="Submit2" type="button" class="Boton" value="Grabar" onClick="envia2()">
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

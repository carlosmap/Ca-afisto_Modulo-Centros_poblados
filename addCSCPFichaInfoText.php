<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php

//Patricia Gutiérrez Restrepo
//Adicionar Información Observaciones y opiniones

//Inicializa las variables de sesión
session_start();

//Validación de Ingreso
include ("../verificaIngreso2.php");
include ("../validaUsu.php");

//Abre la conexión a la BD
//include('../enlaceBD.php');

//Libreria de Funciones
//include('funcionesCSE.php');
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
//	echo $sqlTit." -- ".mssql_get_last_message()."<br>";	
if ($regTit=mssql_fetch_array($cursorTit)) 
{
	$pTituloPpal=$regTit[pregunta];
//	$pTituloSec=$regTit[nomItem];
	$pcodItem=$regTit[codItem];
}

//se consulta las preguntas, asociadas, cuando se selecciona Si en la respuesta a la pregunta inicial
$sql_pregunta_si="select * from tmOpciones where codOpcion in(".$subP1."";
if(trim($subP2)!=0)
	$sql_pregunta_si=$sql_pregunta_si." ,".$subP2;
$sql_pregunta_si=$sql_pregunta_si.")";
$sql_pregunta_si= $sql_pregunta_si. " and tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sql_pregunta_si= $sql_pregunta_si. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;

$cur_pregunta_si=mssql_query($sql_pregunta_si);
//echo "<br>".$sql_pregunta_si." -- ".mssql_get_last_message()."<br><br>";

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
switch ($tipos) 
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
if ($recarga == "2") 
{
	//si la pregunta es la 4.13, se almacena el item 659, asociado a la opcion 121, este caso es solo para esta pregunta
	if($Opc==36)
	{
		$sql_pregunta="select * from tmItems where codOpcion=121 ";
		$sql_pregunta= $sql_pregunta. " and tmItems.codProyecto=".$_SESSION["ccfProyecto"] ;
		$sql_pregunta= $sql_pregunta. " AND tmItems.codModulo=".$_SESSION["ccfModulo"] ;
		$cur_item=mssql_query($sql_pregunta);

		$datos_item=mssql_fetch_array($cur_item);
		$pcodItem=$datos_item["codItem"];
	}
		
//dbo.CSEFichaInfoText
//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, descripcion, codItemRespuesta, fechaGraba, usuarioGraba, fechaMod, usuarioMod

	$qry = "INSERT INTO CSCPFichaInfoText (codProyecto, codModulo, numFormulario,consecutivo, nroObjeto, tipoObjeto, codOpcion, codItem, descripcion ,descripcion2,codItemRespuesta,fechaGraba, usuarioGraba)";	
	$qry = $qry. " VALUES( ";
	$qry = $qry. $_SESSION["ccfProyecto"].", ";	
	$qry = $qry. $_SESSION["ccfModulo"].", ";	
	$qry = $qry. "'".$_SESSION["ccfFormulario"]."', ";	
	$qry = $qry. "'".$_SESSION["ccfConsecutivo"]."', ";	
	$qry = $qry . $nobj. ",";
	$qry = $qry . $tipos.", ";
	$qry = $qry . $Opc.", ";	
	$qry = $qry . $pcodItem .",";

	if(trim($descripcion1)=="")
		$qry = $qry . "NULL,";
	else
		$qry = $qry . "'".$descripcion1."',";

	if(trim($descripcion2)=="")
		$qry = $qry . "NULL,";
	else
		$qry = $qry . "'".$descripcion2 ."',";

	if(trim($Opc1)==0)
	{	$qry = $qry . "NULL,";
	}
	else
	{
		$qry = $qry . $lstOpcion . ",";
	}
	$qry = $qry. "'" . gmdate("n/d/y") ."', ";
	$qry = $qry. "'".$_SESSION["ccfUsuID"]."') " ;	
	//echo $qry;
	//exit;
	$cursorIn = mssql_query($qry) ;
//echo "<br>".$qry." -- ".mssql_get_last_message()."<br><br>";	
	if  (trim($cursorIn) != "")  
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
<link rel="shortcut icon" href="../fs/imagenes/icoIngetec.ico">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) 
{ //v2.0
  window.open(theURL,winName,features);
}

//-->
</script>

<SCRIPT language=JavaScript>
<!--

function envia2(){ 
var v1,v2,v3, v4,v5,v6,v7,v8,v9,v10, i, CantCampos, msg1, msg2, msg3, msg4, mensaje;
v1='s';
v2='s';
v3='s';
v4='s';
v5='s';
v6='s';
v7='s';
v8='s';
v9='s';
v10='s';
msg1 = '';
msg2 = '';
msg3 = '';
msg4 = '';
msg5 = '';
msg6 = '';
msg7 = '';
msg8 = '';
msg9 = '';
msg10 = '';

mensaje = '';

/*if (document.form1.descripcion.value == '') 
{
	v1='n';
	msg1 = 'La información solicitada es obligatoria. \n'
}*/

//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	var texto_selecionado;
	//si (Opc1==0) es por que se se esta mostrando la pregunta 4.13, y se ejecutan la validaciones pertinentes
<?php
	if($Opc1==36)
	{ 
		//obtiene el texto de la opcion seleccionada en el select
		echo 'var selec = document.getElementById("lstOpcion");';
		echo 'texto_selecionado = selec.options[selec.selectedIndex].text;';
		echo '
		//se valida los campos de la pregunta 4.13, si es una diferente, no se ejecutara la validacion

		if((document.form1.descripcion1.value=="")&&(texto_selecionado=="Si"))
		{
			alert("El campo ¿A cuál programa? es obligatorio");
		}
		else if((document.form1.descripcion2.value=="")&&(texto_selecionado=="Si"))
		{
			alert("El campo Entidad a cargo es obligatorio");		
		}
		else
		{
			document.form1.recarga.value="2";
			document.form1.submit();
		}';
	}
	else
	{
		echo '
		if((document.form1.descripcion1.value=="")&&(texto_selecionado=="Si"))
		{
			alert("La información del campo de texto es obligatorio");
		}
		else
		{
			document.form1.recarga.value="2";
			document.form1.submit();
		}';
	}
?>

/*
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s') && (v5=='s') &&
	    (v6=='s')&& (v7=='s')&& (v8=='s')&& (v9=='s')&& (v10=='s')) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else {
		mensaje = msg1 + msg2 + msg3 + msg4+msg5 + msg6 + msg7 + msg8+msg9 + msg10;
		alert (mensaje);
	}
*/
	
}



//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#436F89">
<form name="form1" method="post" action="">

<tr>
<td bgcolor="#FFFFFF">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>

    <!-- NOMBRE DEL MODULO-->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><? echo $proyModulo;?></td>
      </tr>
    </table>
        
    <!-- TITULO GENERAL -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td class="TituloTabla" align="center"><? if($subP2!=0)  //se muestra el titulo, cuando se trata de una pregunta diferente a la 4.13
														echo $pTituloPpal;?></td>
      	</tr>
    </table>
	
	<!--TABLA DESCRIPCION -->
	<table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
    <? if(trim($Opc1)!=0) 
		{ ?> 
            <tr>			
			<td class="TxtTabla" colspan="2"><?
			//Trae la información de los items
			//dbo.tmOpciones
			//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, 
			//usuarioGraba, fechaMod, usuarioMod
			//dbo.tmItems
			//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
			$sql="SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			FROM tmOpciones INNER JOIN
				 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
				 tmOpciones.codOpcion = tmItems.codOpcion";
			$sql= $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sql= $sql. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
			$sql= $sql. " AND tmOpciones.codOpcion=".$Opc1;
			$cursor1 = mssql_query($sql);
			?>
			<select name="lstOpcion<? //echo $i; ?>" class="CajaTexto" id="lstOpcion<? //echo $i; ?>"  onChange="activa()">
			<?php 
			while ($reg1=mssql_fetch_array($cursor1)) 
			{ ?>
			  <option value="<?php echo $reg1[codItem]; ?>"><?php echo $reg1[nomItem]; ?></option>
			<? } ?>
			</select></td>
		</tr>
   <? } ?>  
   	<?php	 
		$i=1;
		//genera los cuadros de texto, cuando es la pregunta 4.13, o 1 solo  cuadro cuando son preguntas de texto
		while($datos_pregun_si=mssql_fetch_array($cur_pregunta_si))
		{
	?>
        <tr>			
			<td class="TituloTabla" colspan="2"> <? echo $datos_pregun_si["nomOpcion"] ;?></td>
		</tr>

		<tr>			
			<td class="TxtTabla" colspan="2" ><textarea name="descripcion<?=$i; ?>" cols="140" rows="5" class="CajaTexto" id="descripcion<?=$i; ?>" ></textarea></td>
		</tr>  
	<?php
			$i++;
		}

	
	?>

	</table>	

    <!-- ESPACIO -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
        <tr>
            <td height="10"> </td>
        </tr>
    </table>

	<!-- BOTONES DE GRABAR -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="recarga" type="hidden" id="recarga" value="1">       
			<input name="Submit2" type="button" class="Boton" value="Grabar" onClick="envia2()">
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
</table>


    
</td>
</tr>
</form>  
</table>   

<script tyep="text/javascript">
function activa()
{
//	alert ("siiii");
	//obtiene el texto de la opcion seleccionada en el select
	var selec = document.getElementById("lstOpcion");
	var texto_selecionado = selec.options[selec.selectedIndex].text;

	//si selecciona no se desabilita las cajas de texto, y se limpia la informacion ingresada
	if(texto_selecionado=="No")
	{
		for(var a=1;a<<?=$i ?>;a++)
		{
			document.getElementById("descripcion"+a).disabled= true;
			document.getElementById("descripcion"+a).disabled= true;
			document.getElementById("descripcion"+a).value="";
		}
	}
	//si se selecciona si se activan, las cajas de texto
	if(texto_selecionado=="Si")
	{
		for(var a=1;a<<?=$i ?>;a++)
		{
			document.getElementById("descripcion"+a).disabled= false;
			document.getElementById("descripcion"+a).disabled= false;
		}
	}
}
</script>   
</body>
</html>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php

//Patricia Gutiérrez Restrepo
//Editar /Eliminar 
//Inicializa las variables de sesión
session_start();

//Validación de Ingreso
include ("../validaUsu.php");

//Abre la conexión a la BD
//include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
//$conexion = conectar();

//se consulta las preguntas, asociadas, cuando se selecciona Si en la respuesta a la pregunta inicial
$sql_pregunta_si="select * from tmOpciones where codOpcion in(".$subP1."";
if(trim($subP2)!=0)
	$sql_pregunta_si=$sql_pregunta_si." ,".$subP2;
$sql_pregunta_si=$sql_pregunta_si.")";
$sql_pregunta_si= $sql_pregunta_si. " AND tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sql_pregunta_si= $sql_pregunta_si. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$cur_pregunta_si=mssql_query($sql_pregunta_si);
//echo "<br>".$sql_pregunta_si." -- ".mssql_get_last_message()."<br><br>";


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

if($Opc1==0)  //si Opc1=0 es por que se trata de una pregunta diferente a la 4.13
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$Opc;
else  //si es la pregunta, se consulta por la opcion 121
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=121";

$cursorTit = mssql_query($sqlTit);
if ($regTit=mssql_fetch_array($cursorTit)) 
{
//	$pTituloPpal=$regTit[pregunta];
//	$pTituloSec=$regTit[nomItem];
	$pcodItem=$regTit[codItem];
}
$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo,tmOpciones.nomOpcion, tmOpciones.codOpcion FROM tmOpciones ";
$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$Opc;

$cursorTit2 = mssql_query($sqlTit);
if ($regTit=mssql_fetch_array($cursorTit2)) 
{
	$pTituloPpal=$regTit[nomOpcion];
}

//echo "<br>**************** ".$sqlTit." -- ".mssql_get_last_message()."<br><br>";

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

//dbo.CSCPFichaInfoText
//codProyecto, codModulo, numFormulario, nroObjeto, tipoObjeto, codOpcion, codItem, descripcion, codItemRespuesta,fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlRta=" SELECT     CSCPFichaInfoText.codProyecto, CSCPFichaInfoText.codModulo, CSCPFichaInfoText.numFormulario, CSCPFichaInfoText.nroObjeto, 
CSCPFichaInfoText.tipoObjeto, CSCPFichaInfoText.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoText.codItem, tmItems.nomItem, 
CSCPFichaInfoText.descripcion, CSCPFichaInfoText.descripcion2,CSCPFichaInfoText.codItemRespuesta
FROM         CSCPFichaInfoText INNER JOIN
tmOpciones ON CSCPFichaInfoText.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoText.codModulo = tmOpciones.codModulo AND 
CSCPFichaInfoText.codOpcion = tmOpciones.codOpcion INNER JOIN
tmItems ON CSCPFichaInfoText.codProyecto = tmItems.codProyecto AND CSCPFichaInfoText.codModulo = tmItems.codModulo AND CSCPFichaInfoText.codOpcion = tmItems.codOpcion AND ";

//si la variable subP2, no contiene datos, es por que se trata de un pregunta de texto sin campo de seleccion
if($Opc1==0)
	$sqlRta=$sqlRta."CSCPFichaInfoText.codItem = tmItems.codItem AND ";

else  //si contiene datos, es por que se trata de la pregunta 4.13, que esta compuest por un campo de seleccion, y se asocia el item de respuesta
	$sqlRta=$sqlRta."CSCPFichaInfoText.codItemRespuesta = tmItems.codItem AND ";

$sqlRta=$sqlRta." tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
$sqlRta= $sqlRta. " WHERE CSCPFichaInfoText.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoText.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoText.consecutivo=".$_SESSION["ccfConsecutivo"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoText.nroObjeto=".$nobj;
$sqlRta= $sqlRta. " AND CSCPFichaInfoText.tipoObjeto=".$tipos;
$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codOpcion=".$Opc;
$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codItem=".$pcodItem;
$cursor = mssql_query($sqlRta);

//echo "<br>**************** ".$sqlRta." -- ".mssql_get_last_message()."<br><br>";

if(trim($recarga) == "")
{	
	if($reg1 = mssql_fetch_array($cursor))
	{	$pdescripcion[1]=$reg1[descripcion];
		$pdescripcion[2]=$reg1[descripcion2];
		$pcodItemRespuesta	= $reg1[codItemRespuesta];
	}	
}
else
{		
//		$pdescripcion 		= $descripcion;	
		$pcodItemRespuesta 	= $lstOpcion;		
}

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	if($accion==2)
	{	@mssql_query("BEGIN TRAN"); 

		//si la pregunta es la 4.13, se almacena el item 659, asociado a la opcion 121, este caso es solo para esta pregunta
		if($Opc==36)
		{
			$cur_item=mssql_query("select * from tmItems where codOpcion=121");
			$datos_item=mssql_fetch_array($cur_item);
			$pcodItem=$datos_item["codItem"];
		}
		

		//si la opcion del select es 198 , que corresponde a el item 'No', se envia descripcion como ulll
		if($lstOpcion==198)
		{
			$descripcion1='NULL';
			$descripcion2='NULL';
		}
		else
		{
			$descripcion1="'".$descripcion1."'";
			$descripcion2="'".$descripcion2."'";
		}
		
		$qry = "UPDATE CSCPFichaInfoText SET ";
		$qry = $qry . " descripcion=".$descripcion1 ."," ;		
		if(trim($Opc1)==0)
		{	$qry = $qry . "codItemRespuesta=Null,";
		}
		else
		{
			$qry = $qry . "codItemRespuesta=".$lstOpcion . ",";
			$qry = $qry . " descripcion2=".$descripcion2 ."," ;	
		}
		$qry = $qry . " fechaMod='".gmdate("n/d/y")."', " ;
		$qry = $qry . " usuarioMod='".$_SESSION["ccfUsuID"]."' " ;
		$qry = $qry . "	WHERE ";
		$qry = $qry . "	codProyecto=".$_SESSION["ccfProyecto"] ;
		$qry = $qry . " AND codModulo=".$_SESSION["ccfModulo"] ;
		$qry = $qry . " AND numFormulario='".$_SESSION["ccfFormulario"]."'" ;
		$qry= $qry. "   AND consecutivo=".$_SESSION["ccfConsecutivo"] ;
		$qry = $qry . " AND nroObjeto=".$nobj;
		$qry = $qry . " AND tipoObjeto=".$tipos;
		$qry = $qry . " AND codOpcion=".$Opc;
		$qry = $qry. "  AND codItem=".$pcodItem;		
		$cursorIn = mssql_query($qry) ;

		if  (trim($cursorIn) != "")
		{	 @mssql_query("COMMIT"); 
			echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
		}
		else
		{	@mssql_query("ROLLBACK"); 
			echo ("<script>alert('Error durante la grabación.');</script>");
		}	
	}
	
	if($accion==3)
	{	@mssql_query("BEGIN TRAN"); 
		$qry = "DELETE FROM CSCPFichaInfoText ";
		$qry = $qry . "	WHERE  " ;
		$qry = $qry . "	codProyecto=".$_SESSION["ccfProyecto"] ;
		$qry = $qry . " AND codModulo=".$_SESSION["ccfModulo"] ;
		$qry = $qry . " AND numFormulario='".$_SESSION["ccfFormulario"]."'" ;
		$qry= $qry. "  AND consecutivo=".$_SESSION["ccfConsecutivo"] ;
		$qry = $qry . " AND nroObjeto=".$nobj;
		$qry = $qry . " AND tipoObjeto=".$tipos;
		$qry = $qry . " AND codOpcion=".$Opc;
		$qry = $qry. "  AND codItem=".$pcodItem;
		$cursorIn = mssql_query($qry) ;


		if  (trim($cursorIn) != "")
		{	 @mssql_query("COMMIT"); 
			echo ("<script>alert('La Operación se realizó con éxito.');</script>");
		}
		else
		{	@mssql_query("ROLLBACK"); 
			echo ("<script>alert('Error durante la grabación.');</script>");
		}	
	}
//echo "<br>**---- ".$qry." -- ".mssql_get_last_message()."<br><br>";		
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
function MM_callJS(jsStr) 
{ //v2.0
  return eval(jsStr)
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
	msg1 = 'La Información solicitada es obligatoria. \n'
}*/
//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
<?php
	//si la pregunta es la 4.13, se valida de esta manera
	if($Opc1!=0)
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
		if((document.form1.descripcion1.value==""))
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
	
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
<form name="form1" method="post" action="">

<tr>
<td bgcolor="#FFFFFF">
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>
   
   	<!-- TITULO GENERAL -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td class="TituloTabla" align="center"><? echo $pTituloPpal;?></td>
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

			//permite observar la lista desplegable, si la accion es editar		
//			if($accion==2)
			
			?>
                <select name="lstOpcion<? echo $i; ?>" class="CajaTexto" id="lstOpcion<? echo $i; ?>" onChange="activa()" <? if($accion==3) echo "disabled"; ?> >
                <?php 
    
    ////////////***********************************************pdescripcion, array con la descripcion ingresada añadir
                while ($reg1=mssql_fetch_array($cursor1)) 
                { 
                    
                     $selRta = "";
                     if($pcodItemRespuesta == $reg1[codItem])
                    {
                        $selRta = "selected";
                        $op_selec=$reg1[nomItem];
                        
                    }
                    ?>
                  <option value="<?php echo $reg1[codItem]; ?>" <? echo $selRta; ?>><?php echo $reg1[nomItem]; ?></option>
                <? 
                    //si esta almacenado No, cuando se genero el registro, se almacena la variable que desabilitara el text area, al momento que se carga la pagina por primera vez
                } 
			
				//si esta seleccionada la respuesta como no, al momento de de consultar la informacion
				if ( ($op_selec=="No")&&(!isset($habilita)))
					$habilita="disabled";

			?>
			</select>
            </td>
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
			<td class="TxtTabla" colspan="2" ><textarea name="descripcion<?=$i; ?>" cols="140" rows="5" class="CajaTexto" id="descripcion<?=$i; ?>" <? if($accion==3) { echo "disabled" ;} if($accion==2){ echo $habilita; }?> ><?php echo $pdescripcion[$i]; ?></textarea></td>
		</tr>  
	<?php
			$i++;
		}

		$habilita="";
	?>


	</table>	
    
    <!-- ESPACIO -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
        <tr>
            <td height="10" class="TxtTabla"> </td>
        </tr>
    </table>

	<!-- BOTONES DE GRABAR -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    
	<? if ($accion==3)
	 	{ ?>
      <tr>
    	  <td align="center" class="TxtTabla" colspan="4"><strong>&iquest;Est&aacute; seguro de eliminar este registro?</strong>
          </td>          
      </tr>    
	<? } ?>	 
      <tr>
        <td align="right" class="TxtTabla">
			<input name="recarga" type="hidden" id="recarga" value="1">
			<input name="Submit2" type="button" class="Boton"  
			value="<? if ($accion==3) { echo "Borrar"; } else { echo "Grabar"; } ?>"  onClick="envia2()">
			<? if ($accion==3)
		   	{ ?> <input name="Cancelar" type="button" class="Boton" id="Cancelar" 
				 onClick="MM_callJS('window.close();')" value="Cancelar">
			<? } ?>	            
        </td>
      </tr>
    </table>	
    
	<!-- ESPACIO -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="TxtTabla">&nbsp;</td>
	  </tr>
	</table>

	<!-- INGETEC-->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="copyr"> powered by INGETEC S.A - 2012</td>
	  </tr>
	</table>	

    
    </td>
  </tr>
</table>


    
</td>
</tr>
</form>  

<script tyep="text/javascript">
//activa o desactiva el text ares, si se selecciono el item NO en el select
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
</table>      
</body>
</html>

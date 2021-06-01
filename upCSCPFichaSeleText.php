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
//	echo "Consulta titulo:  ".$sqlTit." -- ".mssql_get_last_message()."<br>";	
if ($regTit=mssql_fetch_array($cursorTit)) 
{
	$pTituloPpal=$regTit[pregunta];
//	$pTituloSec=$regTit[nomItem];
	$pcodItem=$regTit[codItem];
}

//Trae la información de los items


//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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
if ($recarga == "2") 
{
		$error="no";
		$cursorIn=0;
		$cur_begin=mssql_query("begin transaction");

		$sql_del="delete  from CSCPFichaInfoText where codOpcion=".$Opc;
		$sql_del= $sql_del. " and  CSCPFichaInfoText.codProyecto=".$_SESSION["ccfProyecto"] ;
		$sql_del= $sql_del. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
		$sql_del= $sql_del. " AND CSCPFichaInfoText.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
		$sql_del= $sql_del. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
		$sql_del= $sql_del. " AND CSCPFichaInfoText.nroObjeto=".$nobj;
		$sql_del= $sql_del. " AND CSCPFichaInfoText.tipoObjeto=".$tipo;
		$sql_del= $sql_del. " AND CSCPFichaInfoText.codOpcion=".$Opc;
		$sql_del= $sql_del. " AND CSCPFichaInfoText.consecutivo=".$_SESSION["ccfConsecutivo"];
		$cur_del=mssql_query($sql_del);
//echo "<br>".$sql_del." -- ".mssql_get_last_message()."<br><br>";	

		if(trim($cur_del)=="")
				$error="si";

	if($accion==2)
	{
//echo "cant items ".$cantItmes."<br>";
		$s=1;
		while (($s <= $cantItmes)and($error=="no"))
		{

	
		$infoItem = "item".$s; //campo de texto
		$elCodItem = "cod_item" . $s ; //id_item

//echo  ${$elCodItem}."  ****  ".$infoItem." itenms <br> ".$s;
				$qry = "INSERT INTO CSCPFichaInfoText (codProyecto, codModulo, numFormulario,consecutivo, nroObjeto, tipoObjeto, codOpcion, codItem, descripcion ,descripcion2,codItemRespuesta,fechaGraba, usuarioGraba)";	
				$qry = $qry. " VALUES( ";
				$qry = $qry. $_SESSION["ccfProyecto"].", ";	
				$qry = $qry. $_SESSION["ccfModulo"].", ";	
				$qry = $qry. "'".$_SESSION["ccfFormulario"]."', ";	
				$qry = $qry. "'".$_SESSION["ccfConsecutivo"]."', ";	
				$qry = $qry . $nobj. ",";
				$qry = $qry . $tipo.", ";
				$qry = $qry . $Opc.", ";	
				$qry = $qry . ${$elCodItem}.",";
	//${$laCant}
				if(trim(${$infoItem})!="")		
					$qry = $qry . "'".${$infoItem}."',";
				else
					$qry = $qry . "NULL,";
	
				$qry = $qry . "NULL,";
			
				$qry = $qry . $lstOpcion.",";
				
				$qry = $qry. "'" . gmdate("n/d/y") ."', ";
				$qry = $qry. "'".$_SESSION["ccfUsuID"]."') " ;	
	
				$cursorIn = mssql_query($qry) ;
	
//echo "<br>".$qry." -- ".mssql_get_last_message()."<br><br>";	
			if  (trim($cursorIn)=="")  
			{
				$error="si";
			}
			$s++;
		}
	}

	if  ((trim($cursorIn) != "") and($error=="no")and (trim($cur_del)!=""))
	{					

		$cur=mssql_query("commit transaction");
//		$cur=mssql_query("rollback transaction");
			echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
	}	
	else 
	{
		$cur=mssql_query("rollback transaction");
 
		echo ("<script>alert('Error durante la grabación');</script>");
	}

	$volverA = "";
	$volverA=Genera_Pagina($Opc,$pag);	

	echo ("<script>window.close();MM_openBrWindow('$volverA','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");

}

  $sqlRta=" SELECT CSCPFichaInfoText.codProyecto, CSCPFichaInfoText.codModulo, CSCPFichaInfoText.numFormulario, CSCPFichaInfoText.nroObjeto, CSCPFichaInfoText.tipoObjeto,
    CSCPFichaInfoText.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoText.codItem, tmSubItems.nomSubItem, CSCPFichaInfoText.respItem, 
    CSCPFichaInfoText.descripcion,CSCPFichaInfoText.descripcion2,CSCPFichaInfoText.codItemRespuesta FROM CSCPFichaInfoText 
    
    INNER JOIN tmOpciones ON CSCPFichaInfoText.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoText.codModulo = tmOpciones.codModulo
     AND CSCPFichaInfoText.codOpcion = tmOpciones.codOpcion     
      INNER JOIN tmItems ON CSCPFichaInfoText.codProyecto = tmItems.codProyecto 
     AND CSCPFichaInfoText.codModulo=tmItems.codModulo AND CSCPFichaInfoText.codOpcion = tmItems.codOpcion AND CSCPFichaInfoText.codItem = tmItems.codItem     
     inner join tmSubItems on CSCPFichaInfoText.codItemRespuesta=tmSubItems.codSubItem 
     AND CSCPFichaInfoText.codProyecto = tmSubItems.codProyecto AND CSCPFichaInfoText.codModulo = tmSubItems.codModulo 
     AND CSCPFichaInfoText.codOpcion = tmSubItems.codOpcion ";
/*
	$sqlRta=" SELECT CSCPFichaInfoText.codProyecto, CSCPFichaInfoText.codModulo, CSCPFichaInfoText.numFormulario, CSCPFichaInfoText.nroObjeto,
  CSCPFichaInfoText.tipoObjeto, CSCPFichaInfoText.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoText.codItem, tmSubItems.nomSubItem, 
  CSCPFichaInfoText.respItem, CSCPFichaInfoText.descripcion,CSCPFichaInfoText.descripcion2,CSCPFichaInfoText.codItemRespuesta
   FROM CSCPFichaInfoText
    INNER JOIN tmOpciones ON CSCPFichaInfoText.codProyecto = tmOpciones.codProyecto AND 
   CSCPFichaInfoText.codModulo = tmOpciones.codModulo AND CSCPFichaInfoText.codOpcion = tmOpciones.codOpcion 
   
  INNER JOIN tmItems ON CSCPFichaInfoText.codProyecto = tmItems.codProyecto AND CSCPFichaInfoText.codModulo=tmItems.codModulo 
  AND CSCPFichaInfoText.codOpcion = tmItems.codOpcion AND CSCPFichaInfoText.codItem =    tmItems.codItem 
  AND tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo 
  AND tmOpciones.codOpcion = tmItems.codOpcion   
  
  inner join tmSubItems on CSCPFichaInfoText.codItemRespuesta=tmSubItems.codSubItem ";
*/
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoText.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.numFormulario='".$_SESSION["ccfFormulario"]."'" ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.nroObjeto=".$nobj;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.tipoObjeto=".$tipo;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codOpcion=".$Opc;
	$cursorRta = mssql_query($sqlRta);

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

		var selec = document.getElementById("lstOpcion");
		var texto_selecionado = selec.options[selec.selectedIndex].text;
//alert(texto_selecionado);	
		if(texto_selecionado=="Si") //si se seleccionan los campos, se debe diligenciar almenos un campo de texto
		{

			var cant_items=document.form1.cantItmes.value;
			var cant_vacios=0;
			for(var i=1; i<=cant_items;i++)
			{
				window['item2']='item'+i; 	
				if((document.getElementById(item2).value=='') )
				{
					cant_vacios++;		//se hace el conteo de la cantidad de textos vacios					
				}
//alert(document.getElementById(item2).value);
				
			}
//alert(cant_vacios);
			if(cant_vacios!=cant_items) //si se ingreso almenos uno, recarga
			{
				document.form1.recarga.value="2";
				document.form1.submit();
			}
			else
			{
				alert("Ingrese la informacion, en almenos un campo de texto.");
			}
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
        	<td class="TituloTabla" align="center"><? 	echo $pTituloPpal;?></td>
      	</tr>
    </table>
	
	<!--TABLA DESCRIPCION -->
	<table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
            <tr>			
			<td class="TxtTabla" colspan="2"><?

			$sql="SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmSubItems.codSubItem, tmSubItems.nomSubItem
			FROM tmOpciones INNER JOIN
				 tmSubItems ON tmOpciones.codProyecto = tmSubItems.codProyecto AND tmOpciones.codModulo = tmSubItems.codModulo AND 
				 tmOpciones.codOpcion = tmSubItems.codOpcion";
			$sql= $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sql= $sql. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
			$sql= $sql. " AND tmOpciones.codOpcion=".$Opc;
			$cursor1 = mssql_query($sql);
			?>
			<select name="lstOpcion" class="CajaTexto" id="lstOpcion"   <? if ($accion!=3) { ?> onChange="activa()" <? } ?> <? if ($accion==3) { echo "disabled" ;}?>>
			<?php 
			while ($reg1=mssql_fetch_array($cursor1)) 
			{ ?>
			  <option value="<?php echo $reg1[codSubItem]; ?>" <? if($reg1[codSubItem]==$r){ echo "selected"; } ?>   ><?php echo $reg1[nomSubItem]; ?>  </option>
			<? } ?>
			</select></td>
		</tr>


   	<?php	 
		$i=0;
while($regDes=mssql_fetch_array($cursorRta))  
{

		$sql="SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
		tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
		FROM tmOpciones INNER JOIN
			 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			 tmOpciones.codOpcion = tmItems.codOpcion";
		$sql= $sql. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
		$sql= $sql. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
		$sql= $sql. " AND tmOpciones.codOpcion=".$Opc;
		$sql= $sql. " AND tmItems.codItem=".$regDes["codItem"];
		$cursor = mssql_query($sql);
		
//			echo "Consulta items:  ".$sql." -- ".mssql_get_last_message()."<br>";	
		//genera los cuadros de texto, cuando es la pregunta 4.13, o 1 solo  cuadro cuando son preguntas de texto
		if($datos_items=mssql_fetch_array($cursor))
		{
			$i++;
	?>
        <tr>			
			<td class="TituloTabla" > <? echo $datos_items["nomItem"] ;?></td>

			<td class="TxtTabla"  ><input type="text" class="CajaTexto" id="item<? echo $i; ?>" name="item<? echo $i; ?>" value="<? echo $regDes["descripcion"]; ?>"  <? if($accion==3) { echo "disabled"; } ?> >
			<input type="hidden" name="cod_item<? echo $i; ?>" id="cod_item<? echo $i; ?>" value="<? echo $datos_items["codItem"]; ?>" >
			</td>

		</tr>  
	<?php

		}
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
			<input name="cantItmes" type="hidden" id="cantItmes" value="<? echo $i; ?>">       
			<input name="Submit2" type="button" class="Boton" value="<? if ($accion==3) { echo "Borrar"; } else { echo "Grabar"; } ?>" onClick="envia2()">
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
		for(var a=1;a<=<?=$i ?>;a++)
		{
//			window['item2']='item'+a; 	
			document.getElementById("item"+a).disabled= true;
			document.getElementById("item"+a).value="";
		}
	}
	//si se selecciona si se activan, las cajas de texto
	if(texto_selecionado=="Si")
	{
		for(var a=1;a<=<?=$i ?>;a++)
		{
//			window['item']='item'+a; 
			document.getElementById("item"+a).disabled= false;
		}
	}
}
</script>  

<?
 if ($accion!=3) { 
	echo "<script>activa();</script>"; //lama a la funcion que activa o desactiva los campos deacuerdo a lo que este seleccionado en el select
}
?>
</body>
</html>

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

//Abre la conexión a la BD
//include('../enlaceBD.php');

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

//echo $_SESSION["ccfVivienda"]."  aaaaaaquiiiiii <br>";

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	//Grabar Registros 
	//dbo.CSEFichaInfoCant
	//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, cantidad, fechaGraba, usuarioGraba, 	
	//fechaMod, usuarioMod

	$s = 1;
	$insertion = "";
	while ($s <= $cantidadItem) 
	{
		$elCod = "item" . $s;
		$laCant = "cantidad" . $s ;
		$sqlIn = "INSERT INTO CSCPFichaInfoCant(codProyecto, codModulo, numFormulario, consecutivo, nroObjeto, 
		tipoObjeto, codOpcion, codItem, cantidad, fechaGraba, usuarioGraba) ";
		$sqlIn = $sqlIn." VALUES ( ";
		$sqlIn = $sqlIn . $_SESSION["ccfProyecto"] . ",";
		$sqlIn = $sqlIn . $_SESSION["ccfModulo"] . ",";
		$sqlIn = $sqlIn . "'".$_SESSION["ccfFormulario"] . "',";

		$sqlIn= $sqlIn. " ".$_SESSION["ccfConsecutivo"]."," ;

		$sqlIn = $sqlIn . $nobj. ",";
		$sqlIn = $sqlIn . $tipo.", ";
		$sqlIn = $sqlIn . $Opc.", ";	
		$sqlIn = $sqlIn. ${$elCod} .", ";
		if (${$laCant}=='')
		{
			${$laCant}=0;
		}
		$sqlIn = $sqlIn. " '" . ${$laCant} ."', ";
		$sqlIn = $sqlIn. " '" . gmdate("n/d/y") ."', ";
		$sqlIn = $sqlIn . " '".$_SESSION["ccfUsuID"]."' " ;
		$sqlIn = $sqlIn." ) ";
		$insertion = $insertion.$sqlIn."<br>";
		$cursorIn = mssql_query($sqlIn);
		$s = $s + 1;		
//echo $sqlIn." -- ".mssql_get_last_message()."<br>";
	}
	if  (trim($cursorIn)!="") 
	{
		echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
	} 
	else 
	{
		echo ("<script>alert('Error durante la grabación');</script>");
	}

	$volverA = "";
	$volverA=Genera_Pagina($Opc,$pag);	
//echo $volverA."<br>";
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
<?
	if(trim($califi_max)!="")
	{
?>

//valida los campos de texto generados dinamicamente
//validando que no esten en vacio
//validando que los valores no sobrepasen un rango especifico
//validando que los datos no se repitan y sean unicos
function valida_campo_orden()
{

	//almacenamos la cantidad de registros(filas) generados en el formulario
	var pCantItems=document.form1.cantidadItem.value;
	var calificacion=<? echo $califi_max; ?>;
	var calificacion_min=<? echo $califi_min;  ?>
//	var ban_vacio="no"; //si la variable esta en si, es por que alguno de los campo esta vacio o en 0
	var ret=true;
	var coincidencia=0;
	var datos= Array();
	for (i=1;i<=pCantItems;i++)
	{
		//en el formaulario hay un numero de campos formados por nombre cantidad y un consecutivo
		//aqui se forma el nombre de la variable, para referenciar el campo del formulario
		window['cantidad']='cantidad'+i; 		
				//compara que el valor no este vacio
				if((document.getElementById(cantidad).value=='') )
				{
//						ban_vacio="si";
						alert("Todos los campos son obligatorios");
						ret=false;
						break;									
				}
/*
				if((document.getElementById(cantidad).value==0) )
				{
//						ban_vacio="si";
						alert("El valor 0 no esta permitido ");
						ret=false;
						break;									
				}
*/
				if((calificacion<document.getElementById(cantidad).value) )
				{
//						ban_vacio="si";
						alert("El valor ingresado no puede ser superior a "+calificacion);
						ret=false;
						break;									
				}	
				if((document.getElementById(cantidad).value)<calificacion_min )
				{
//						ban_vacio="si";
						alert("El valor ingresado no puede menor a  "+calificacion_min);
						ret=false;
						break;									
				}
		
				datos[i]=document.getElementById(cantidad).value;
	}
	
	for(var a=1;a<=pCantItems;a++)
	{
		coincidencia=0;
		for(var i=1; i<=pCantItems;i++)
		{
			if(a==datos[i])
			{
				coincidencia++;
//document.write(coincidencia);
			}
			if(coincidencia==2)
			{
				alert("La respuesta no debe estar repetida");
				ret=false;
				break;			
			}
		}
	}

	return ret;
}
<?
		}
?>


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

<?php
	if(trim($califi_max)!="")
	{
		echo "
			if(valida_campo_orden())
			{				
				document.form1.recarga.value='2';
				document.form1.submit();
			}
		";
	}
	else
	{
		echo "
		document.form1.recarga.value='2';
		document.form1.submit(); ";
	}
	

?>

}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}


var nav4 = window.Event ? true : false;
function acceptNum(evt)
{   
	var key = nav4 ? evt.which : evt.keyCode;   
	return (key <= 13 || (key>= 48 && key <= 57) );
}
//-->
</SCRIPT>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#00344C">
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
        <td><? echo $pTituloPpal ;?></td>
        <td width="8%">&nbsp;</td>
      </tr>
      
      <?php 
	  $i=1;	
	  while ($reg=mssql_fetch_array($cursor)) 
	  { ?>
      <tr align="center" class="TxtTabla">
        <td align="left">
          <?php echo $reg[nomItem];  ?>
          <input name="item<? echo $i; ?>" type="hidden" id="item<? echo $i; ?>" value="<? echo $reg[codItem];  ?>">			
        </td>
        <td width="8%" align="center">
			<input name="cantidad<? echo $i; ?>" type="text" class="CajaTexto" id="cantidad<? echo $i; ?>" size="10" onKeyPress="return acceptNum(event)" value="0"></td>
        </tr>
	  <? 
	  $i=$i+1;
	  } ?>
    </table>
    
    <!-- BOTONES -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="cantidadItem" type="hidden" id="cantidadItem" value="<? echo mssql_num_rows($cursor); ?>">
            <input name="rta" type="hidden" id="rta" value="<? echo $uni; ?>">
			<input name="recarga" type="hidden" id="recarga" value="1">
			<input name="Submit" type="button" class="Boton" value="Grabar" onClick="envia2()">		  
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

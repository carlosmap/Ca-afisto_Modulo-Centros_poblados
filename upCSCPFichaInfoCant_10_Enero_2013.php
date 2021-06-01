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

$tipo = $_GET["tipo"];
//Listado de Registros
//dbo.CSEFichaInfoCant
//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, cantidad, fechaGraba, usuarioGraba, //fechaMod, usuarioMod
$sqlRta=" SELECT     CSCPFichaInfoCant.codProyecto, CSCPFichaInfoCant.codModulo, CSCPFichaInfoCant.numFormulario, CSCPFichaInfoCant.nroObjeto, 
CSCPFichaInfoCant.tipoObjeto, CSCPFichaInfoCant.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoCant.codItem, tmItems.nomItem, 
CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
tmItems ON CSCPFichaInfoCant.codProyecto = tmItems.codProyecto AND CSCPFichaInfoCant.codModulo = tmItems.codModulo AND 
CSCPFichaInfoCant.codOpcion = tmItems.codOpcion AND CSCPFichaInfoCant.codItem = tmItems.codItem AND 
tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
$sqlRta= $sqlRta. " WHERE CSCPFichaInfoCant.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.consecutivo=".$_SESSION["ccfConsecutivo"];
$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.nroObjeto=".$nobj;
$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.tipoObjeto=".$tipo;
$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codOpcion=".$Opc;
$cursor = mssql_query($sqlRta);

//echo $sqlRta." -- ".mssql_get_last_message()."<br>";
/*if($_SESSION["sgcUsuID"]=='1013588894'){
	echo "tipo ".$tipo;
}*/

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
  if ($accion==3)
  {
	$cur_tran=mssql_query("BEGIN TRANSACTION");
	$cant_reg=0;
	//si la opcion es 40, pregunta (seccion Morbilidad y mortalidad), consulta la cantidad de regsitros asociados
	if($Opc==40)
	{

		//consulta si exiten registros asociados a la ficha de morbilidad, si es asi, no permite la eliminacion
		$sql_cant_reg="select COUNT(*) as can from CSCPFichaFamiliaMorbilidad";
		$sql_cant_reg= $sql_cant_reg. " WHERE CSCPFichaFamiliaMorbilidad.codProyecto=".$_SESSION["ccfProyecto"] ;
		$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.codModulo=".$_SESSION["ccfModulo"] ;
		$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.consecutivo=".$_SESSION["ccfConsecutivo"] ;
		$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
		$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.nroVivienda=".$_SESSION["ccfVivienda"] ;
		$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.nroFamilia=".$_SESSION["ccfFamilia"] ;
		$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.nroPredio=".$_SESSION["ccfPredio"] ;
		$cursorCant = mssql_query($sql_cant_reg);
		$datos_cant=mssql_fetch_array($cursorCant);
		$cant_reg=$datos_cant["can"];
//echo "entro ".$sql_cant_reg."";
	}

	if($cant_reg==0)//si la cantidad de registros es 0 permite la eliminacion, esto se realiza, para la pregunta No 40, para no permitir eliminar si, se tienen registros asociados en la tabla CSCPFichaFamiliaMorbilidad
	{
		$sqlIn1 = " DELETE FROM CSCPFichaInfoCant ";
		$sqlIn1= $sqlIn1. " WHERE CSCPFichaInfoCant.codProyecto=".$_SESSION["ccfProyecto"] ;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.nroObjeto=".$nobj;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.tipoObjeto=".$tipo;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.codOpcion=".$Opc;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.consecutivo=".$_SESSION["ccfConsecutivo"];
		$cursorIn = mssql_query($sqlIn1);
	}
	else
	{
		$cur_tran=mssql_query("ROLLBACK TRANSACTION");
		echo ("<script>alert('No se pueden eliminar la informacion, por que existen personas asociadas.');</script>");
		$volverA = "";
		$volverA=Genera_Pagina($Opc,$pag);		
		echo ("<script>window.close();MM_openBrWindow('$volverA','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");
		exit();	
	}
  }

  if ($accion==2)
  { 
	$cur_tran=mssql_query("BEGIN TRANSACTION");

		$sqlIn1 = " DELETE FROM CSCPFichaInfoCant ";
		$sqlIn1= $sqlIn1. " WHERE CSCPFichaInfoCant.codProyecto=".$_SESSION["ccfProyecto"] ;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.nroObjeto=".$nobj;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.tipoObjeto=".$tipo;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.codOpcion=".$Opc;
		$sqlIn1= $sqlIn1. " AND CSCPFichaInfoCant.consecutivo=".$_SESSION["ccfConsecutivo"];
		$cursorIn = mssql_query($sqlIn1);

//echo $sqlRta." -- ".mssql_get_last_message()."<br><br>";	
	if  (trim($cursorIn) != "") 
	{  

			//Grabar Registros 
			//dbo.CSEFichaInfoCant
			//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, cantidad, fechaGraba, 	
			//usuarioGraba, fechaMod, usuarioMod
			$s = 1;
			$insertion = "";
			while ($s <= $cantidadItem) 
			{
				$elCod = "item" . $s;
				$laCant = "cantidad" . $s ;

				//si la opcion es 40, pregunta (seccion Morbilidad y mortalidad), consulta la cantidad de regsitros asociados
				if($Opc==40)
				{
					$sql_cant_reg="select COUNT(*) as can from CSCPFichaFamiliaMorbilidad";
					$sql_cant_reg= $sql_cant_reg. " WHERE CSCPFichaFamiliaMorbilidad.codProyecto=".$_SESSION["ccfProyecto"] ;
					$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.codModulo=".$_SESSION["ccfModulo"] ;
					$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.consecutivo=".$_SESSION["ccfConsecutivo"] ;
					$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
					$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.nroVivienda=".$_SESSION["ccfVivienda"] ;
					$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.nroFamilia=".$_SESSION["ccfFamilia"] ;
					$sql_cant_reg= $sql_cant_reg. " AND CSCPFichaFamiliaMorbilidad.nroPredio=".$_SESSION["ccfPredio"] ;
					$cursorCant = mssql_query($sql_cant_reg);
					$datos_cant=mssql_fetch_array($cursorCant);
					$cant_reg=$datos_cant["can"];

					if(${$laCant}<$cant_reg) //si el valor de cantidad de personas a actualizar, es menor a la cantidad de registros de personas, no permitira la actualizacion
					{
						$cur_tran=mssql_query("ROLLBACK TRANSACTION");
						echo ("<script>alert('No se puede actualizar la información, por que el valor ingresado es inferior a la cantidad de personas registradas.');</script>");
						$volverA = "";
						$volverA=Genera_Pagina($Opc,$pag);		
						echo ("<script>window.close();MM_openBrWindow('$volverA','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");

						exit();
					}
				}

				$sqlIn = "INSERT INTO CSCPFichaInfoCant(codProyecto, codModulo, numFormulario, consecutivo , nroObjeto, tipoObjeto, 	
						  codOpcion, codItem, cantidad, fechaGraba, usuarioGraba) ";
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
//echo $sqlRta." -- ".mssql_get_last_message()."<br>";
			}
	}	
 }
	
	if  (trim($cursorIn)!="") 
	{
		$cur_tran=mssql_query("COMMIT TRANSACTION");
		echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
	} 
	else 
	{
		$cur_tran=mssql_query("ROLLBACK TRANSACTION");
		echo ("<script>alert('Error durante la grabación');</script>");
	};

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
var nav4 = window.Event ? true : false;
function acceptNum(evt){   
var key = nav4 ? evt.which : evt.keyCode;   
return (key <= 13 || (key>= 48 && key <= 57));
}


function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
function envia1()
{ 
	document.form1.recarga.value="1";
	document.form1.submit();
}

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

var elLength = document.form1.elements.length;
var valor=0;
for (i=0; i<elLength; i++)
{
    var type = form1.elements[i].type;
	//alert (form1.elements[i].type); 
	//alert (form1.elements[i].name);
	//alert (form1.elements[i].value);
	if (type=="text") 
	{	valor=valor+ parseFloat(form1.elements[i].value);  }
}
//alert(valor);
if((document.form1.rta.value!=0)&&(valor!=document.form1.rta.value))
{	v1='n';
	msg1 = 'La sumatoria debe dar ' +  document.form1.rta.value + ' Verifique la infomación. \n'
}

//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s')) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 ;
		alert (mensaje);
	}	
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
	  $cursorRta = mssql_query($sqlRta);
	  while ($reg=mssql_fetch_array($cursorRta)) 
	  { ?>
      <tr align="center" class="TxtTabla">
        <td align="left">
          <?php echo $reg[nomItem];  ?>
          <input name="item<? echo $i; ?>" type="hidden" id="item<? echo $i; ?>" value="<? echo $reg[codItem];  ?>">		</td>
        <td width="8%" align="center">
			<input name="cantidad<? echo $i; ?>" type="text" class="CajaTexto" id="cantidad<? echo $i; ?>" 
				size="25" maxlength="10" onKeyPress="return acceptNum(event)"  value="<? echo str_replace( ',','',number_format( $reg[cantidad],0) ) ;  ?>" 
				<? if ($accion==3) { echo "disabled" ;}?>>	
			</td>
        </tr>
	  <? 
	  $i=$i+1;
	  } ?>
    </table>
    
    <!-- BOTONES-->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="cantidadItem" type="hidden" id="cantidadItem" value="<? echo mssql_num_rows($cursor); ?>">
			<input name="recarga" type="hidden" id="recarga" value="1">
            <input name="accion" type="hidden" id="accion" value="<? echo $accion;?>">
             <input name="rta" type="hidden" id="rta" value="<? echo $uni;?>">
			<input name="Submit" type="submit" class="Boton"  
			value="<? if ($accion==3) { echo "Borrar"; } else { echo "Grabar"; } ?>"  onClick="envia2()">
			<? if ($accion==3)
		   	{ ?> <input name="Cancelar" type="button" class="Boton" id="Cancelar" 
				 onClick="MM_callJS('window.close();')" value="Cancelar">
			<? } ?>		</td>
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

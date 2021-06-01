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

/*
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
*/

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
			$error="no";

			mssql_query("BEGIN TRANSACTION");
			$max_pez=0;
			//consulta la secuencia de la pesca para esa familia
			$sql_pez_conse="select  MAX(consecPesca) as max_pesca  from CSCPFichaFamiliaPesca";
			$sql_pez_conse= $sql_pez_conse. " WHERE CSCPFichaFamiliaPesca.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sql_pez_conse= $sql_pez_conse. " AND CSCPFichaFamiliaPesca.codModulo=".$_SESSION["ccfModulo"] ;
			$sql_pez_conse= $sql_pez_conse. " AND CSCPFichaFamiliaPesca.consecutivo=".$_SESSION["ccfConsecutivo"] ;
			$sql_pez_conse= $sql_pez_conse. " AND CSCPFichaFamiliaPesca.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
			$sql_pez_conse= $sql_pez_conse. " AND CSCPFichaFamiliaPesca.nroVivienda=".$_SESSION["ccfVivienda"] ;
			$sql_pez_conse= $sql_pez_conse. " AND CSCPFichaFamiliaPesca.nroFamilia=".$_SESSION["ccfFamilia"] ;
			$sql_pez_conse= $sql_pez_conse. " AND CSCPFichaFamiliaPesca.nroPredio=".$_SESSION["ccfPredio"] ;
			$cur_pez=mssql_query($sql_pez_conse);
			if($datos_pez=mssql_fetch_array($cur_pez))
			{
				$max_pez=$datos_pez["max_pesca"];
			}
			$max_pez++;
//echo 	$sql_pez_conse." ---- $max_pez  ".mssql_get_last_message(). "<br>";

			$sql_insert="insert into CSCPFichaFamiliaPesca (codProyecto,codModulo,numFormulario,consecutivo,nroPredio,nroVivienda,nroFamilia,
						 consecPesca,fuenteHidrica,codEspecie,cantidad,porcentAuto,porcentVenta,fechaGraba,usuarioGraba)";
			$sql_insert=$sql_insert."values(";
			$sql_insert = $sql_insert . $_SESSION["ccfProyecto"] . ",";
			$sql_insert = $sql_insert . $_SESSION["ccfModulo"] . ",";
			$sql_insert = $sql_insert . "'".$_SESSION["ccfFormulario"] . "',";
			$sql_insert= $sql_insert. " ".$_SESSION["ccfConsecutivo"]."," ;
			$sql_insert= $sql_insert. " ".$_SESSION["ccfPredio"]."," ;
			$sql_insert= $sql_insert. " ".$_SESSION["ccfVivienda"]."," ;
			$sql_insert= $sql_insert. " ".$_SESSION["ccfFamilia"]."," ;

			$sql_insert= $sql_insert. " ".$max_pez."," ;

			$sql_insert= $sql_insert. " '".$fuente."'," ;
			$sql_insert= $sql_insert. " ".$especie."," ;
			$sql_insert= $sql_insert. "".$cantidad."," ;
			$sql_insert= $sql_insert. " ".$auto."," ;
			$sql_insert= $sql_insert. " ".$venta."," ;

			$sql_insert = $sql_insert. " '" . gmdate("n/d/y") ."', ";
			$sql_insert = $sql_insert . " '".$_SESSION["ccfUsuID"]."' " ;
			$sql_insert=$sql_insert.")";
			$cursorIn=mssql_query($sql_insert);
			if(trim($cursorIn)=="")
				$error="si";

//echo 	$sql_insert." ---- $error  ".mssql_get_last_message()."<br><br>";


			$cons_temp=1; //incrementa el consecutivo de la temporalidad, cuando se ingresa un registro en CSCPFichaFamiliaPescaTemp
			$z=1;  //permite recorrer los valores de los items

			//recorre la cantidad de items de temporalidad(6.8.3.6), para verificar cualies se marcaron como SI
			while(($z<=$cant_tempo)and($error=="no"))
			{
				$cursorIn2="0";
				//se insertan los items marcados como si
				if($_POST['aplica'.$z]=="si")
				{
					$sql_insert2="insert into CSCPFichaFamiliaPescaTemp (codProyecto,codModulo,numFormulario,consecutivo,nroPredio,nroVivienda,nroFamilia,
								 consecPesca,consecTemp,codItemTipoTemp,fechaGraba,usuarioGraba )";
					$sql_insert2=$sql_insert2."values(";
					$sql_insert2 = $sql_insert2 . $_SESSION["ccfProyecto"] . ",";
					$sql_insert2 = $sql_insert2 . $_SESSION["ccfModulo"] . ",";
					$sql_insert2 = $sql_insert2 . "'".$_SESSION["ccfFormulario"] . "',";
					$sql_insert2= $sql_insert2. " ".$_SESSION["ccfConsecutivo"]."," ;
					$sql_insert2= $sql_insert2. " ".$_SESSION["ccfPredio"]."," ;
					$sql_insert2= $sql_insert2. " ".$_SESSION["ccfVivienda"]."," ;
					$sql_insert2= $sql_insert2. " ".$_SESSION["ccfFamilia"]."," ;
		
					$sql_insert2= $sql_insert2. " ".$max_pez."," ;
					$sql_insert2= $sql_insert2. " ".$cons_temp."," ;
		
					$sql_insert2= $sql_insert2. " ".$_POST['aplicas'.$z]."," ;
					$sql_insert2 = $sql_insert2. " '" . gmdate("n/d/y") ."', ";
					$sql_insert2 = $sql_insert2 . " '".$_SESSION["ccfUsuID"]."' " ;
					$sql_insert2=$sql_insert2.")";
		
					$cursorIn2=mssql_query($sql_insert2);
//echo 	$sql_insert2." ---- $error---/*  ".mssql_get_last_message()."<br><br>";
					if(trim($cursorIn2)=="")
						$error="si";
					$cons_temp++;
				}
				$z++;
//echo 	" $z <br><br>  ";
			}



//echo 	$sql_insert2." ----  ".mssql_get_last_message()."<br>";

			if((trim($cursorIn)!="")and(trim($cursorIn2)!=""))
			{
				mssql_query("COMMIT TRANSACTION");

				echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
			}
			else
			{
				mssql_query("ROLLBACK TRANSACTION");

				echo ("<script>alert('Error en la operación');</script>");
			}

	$volverA = "";
	$volverA=Genera_Pagina(0,9);	

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

function acceptNum_Decimal(evt){   
var key = nav4 ? evt.which : evt.keyCode;   
return (key <= 13 || (key>= 48 && key <= 57)|| key==46 );
}




<!--
function envia2(){ 

	var msg="";
	if(document.form1.fuente.value=="")
	{
		msg="El campo  Fuente Hídrica es obligatorio\n";
	}
	if(document.form1.especie.value=="")
	{
		msg=msg+"El campo Especie es obligatorio \n";
	}

	 if(document.form1.cantidad.value=="")
	{
		msg=msg+"El campo Cantidad Kg/día es obligatorio \n";
	}
	 if(document.form1.auto.value=="")
	{
		msg=msg+"El campo % autoconsumo es obligatorio \n";
	}


///
	var can_item=document.form1.cant_tempo.value;
	var can_selec=0;
//	for(var i=1;i<=can_item;i++)
	
		//valida cuales estan marcados con la opcion NO

		if(document.form1.aplica1[0].checked)
		{
			can_selec++; //realiza el conteo por cada marcacion
		}
		if(document.form1.aplica2[0].checked)
		{
			can_selec++; //realiza el conteo por cada marcacion
		}
		if(document.form1.aplica3[0].checked)
		{
			can_selec++; //realiza el conteo por cada marcacion
		}
		if(document.form1.aplica4[0].checked)
		{
			can_selec++; //realiza el conteo por cada marcacion
		}

		if(can_selec==0)
		{
			msg=msg+"Seleccione almenos una temporalidad \n";
		}

		
	
//
/*
	 if(document.form1.auto.value==0)
	{
		msg=msg+"El  porcentaje(%) de autoconsumo no puede ser  0 \n";
	}
	 if(document.form1.venta.value==0)
	{
		msg=msg+"El  porcentaje(%) de venta no puede ser 0 \n";
	}

*/
	 if(document.form1.auto.value>100)
	{
		msg=msg+"El  porcentaje(%) de autoconsumo no puede ser mayor a 100% \n";
	}
	 if(document.form1.venta.value=="")
	{
		msg=msg+"El campo % venta es obligatorio \n";
	}
	 if(document.form1.venta.value>100)
	{
		msg=msg+"El  porcentaje(%) de autoconsumo no puede ser mayor a 100% \n";
	}
/*
	 if(document.form1.temporalidad.value=="")
	{
		msg=msg+"El campo Temporalidad es obligatorio \n";
	}
*/
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
			<td colspan="3">6.8.3. PESCA ARTESANAL <? // echo $pTituloPpal ;?></td>
		</tr>
      <tr>
                <td  class="TituloTabla1">6.8.3.1 Fuente Hídrica</td>
                <td ><input name="fuente" class="CajaTexto" id="fuente" tyep="text"  ></td>
      </tr>  
      <tr>
                <td class="TituloTabla1" >6.8.3.2 Especie</td>
                <td>
<?php
			$sql_especie="select *,nomItem from tmItems where codOpcion=93";
			$sql_especie= $sql_especie. " and tmItems.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sql_especie= $sql_especie. " AND tmItems.codModulo=".$_SESSION["ccfModulo"] ;
			$cur_especie=mssql_query($sql_especie);


?>
					<select name="especie" class="CajaTexto" id="especie" >
						<option value="" selected >Seleccione una especie</option>
<?php 
						while($datos_especie=mssql_fetch_array($cur_especie))
						{
?>
						<option value="<?php echo $datos_especie["codItem"]; ?>"><?php echo $datos_especie["nomItem"]; ?></option>
<?							
						}
?>
					</select>
				</td>
      </tr>  
      <tr>
                <td class="TituloTabla1">6.8.3.3 Cantidad Kg/día</td>
                <td><input name="cantidad" type="text" class="CajaTexto" id="cantidad"  onKeyPress="return acceptNum_Decimal(event)" > </td>
      </tr>  
      <tr>
                <td class="TituloTabla1">6.8.3.4 % autoconsumo</td>
                <td> <input name="auto" type="text" class="CajaTexto" id="auto" maxlength="3" onKeyPress="return acceptNum(event)" > </td>
      </tr>  
      <tr>
                <td class="TituloTabla1">6.8.3.5 % venta</td>
                <td><input name="venta" type="text" class="CajaTexto" id="venta"  maxlength="3" onKeyPress="return acceptNum(event)" ></td>
      </tr>  
      <tr>
                <td colspan="2" class="TituloTabla1" >6.8.3.6 Temporalidad</td>
<!--
				<td>
                    <table>
                        <tr>
                            <td ><span class="TxtTabla">Si</span></td>
                            <td ><span class="TxtTabla">No</span></td>
                        </tr>
                    </table>
				</td>
-->
      </tr>  




<?php
			$sql_tempo="select *,nomItem from tmItems where codOpcion=94";
			$sql_tempo= $sql_tempo. " and tmItems.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sql_tempo= $sql_tempo. " AND tmItems.codModulo=".$_SESSION["ccfModulo"] ;

			$cur_tempo=mssql_query($sql_tempo);
?>

<?php 
						$i=1;
						while($datos_tempo=mssql_fetch_array($cur_tempo))
						{
?>
      <tr class="CajaTexto">
                <td class="TituloTabla1">
						<?php echo $datos_tempo["nomItem"]; ?>

				</td>
				<td>
						Si<input type="radio" name="aplica<?php echo $i; ?>" id="aplica<?php echo $i; ?>" value="<?php echo "si"; // echo $datos_tempo["codItem"]; ?>"  >
						No<input type="radio" name="aplica<?php echo $i; ?>" id="aplica<?php echo $i; ?>" value="<?php echo "no"; //echo $datos_tempo["codItem"]; ?>" checked>
						  <input type="hidden" name="aplicas<?php echo $i; ?>" id="aplicas<?php echo $i; ?>" value="<?php echo $datos_tempo["codItem"]; ?>" >
				</td>
      </tr>  
<?							$i++;
						}
?>




     
    </table>

    <!--BOTONES -->   
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%">&nbsp;</td>
        <td align="right">
		  <input type="hidden" name="cant_tempo" id="cant_tempo" value="<?php echo $i; ?>" >
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

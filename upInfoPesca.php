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
		$sql_pesca="select *,tmItems.nomItem as especie,tm2.nomItem as temporalidad from CSCPFichaFamiliaPesca 
		inner join tmItems on CSCPFichaFamiliaPesca.codEspecie=tmItems.codItem
		inner join CSCPFichaFamiliaPescaTemp on CSCPFichaFamiliaPesca.codProyecto=CSCPFichaFamiliaPescaTemp.codProyecto and
		CSCPFichaFamiliaPesca.codModulo=CSCPFichaFamiliaPescaTemp.codModulo and
		CSCPFichaFamiliaPesca.numFormulario=CSCPFichaFamiliaPescaTemp.numFormulario and CSCPFichaFamiliaPescaTemp.consecutivo=CSCPFichaFamiliaPesca.consecutivo
		and CSCPFichaFamiliaPesca.nroPredio=CSCPFichaFamiliaPescaTemp.nroPredio and CSCPFichaFamiliaPesca.nroVivienda=CSCPFichaFamiliaPescaTemp.nroVivienda
		 and CSCPFichaFamiliaPesca.nroFamilia=CSCPFichaFamiliaPescaTemp.nroFamilia  and CSCPFichaFamiliaPesca.consecPesca=CSCPFichaFamiliaPescaTemp.consecPesca
		 inner join tmItems as tm2 on CSCPFichaFamiliaPescaTemp.codItemTipoTemp=tm2.codItem
		 where CSCPFichaFamiliaPesca.codProyecto=".$_SESSION["ccfProyecto"]." 
		 and CSCPFichaFamiliaPesca.codModulo=".$_SESSION["ccfModulo"]." 
		 and CSCPFichaFamiliaPesca.numFormulario='".$_SESSION["ccfFormulario"]."' 
		 and CSCPFichaFamiliaPescaTemp.consecutivo=".$_SESSION["ccfConsecutivo"]." 
		 and CSCPFichaFamiliaPesca.nroPredio=".$_SESSION["ccfPredio"]." 
		 and CSCPFichaFamiliaPesca.nroVivienda=".$_SESSION["ccfVivienda"]." 
		 and CSCPFichaFamiliaPesca.nroFamilia=".$_SESSION["ccfFamilia"]."";
*/
		 $sql_pesca="select *,tmItems.nomItem as especie from CSCPFichaFamiliaPesca
		 inner join tmItems on CSCPFichaFamiliaPesca.codEspecie=tmItems.codItem 
		 where CSCPFichaFamiliaPesca.codProyecto=".$_SESSION["ccfProyecto"]." 
		 and CSCPFichaFamiliaPesca.codModulo=".$_SESSION["ccfModulo"]." 
		 and CSCPFichaFamiliaPesca.numFormulario='".$_SESSION["ccfFormulario"]."' 
		 and CSCPFichaFamiliaPesca.consecutivo=".$_SESSION["ccfConsecutivo"]." 
		 and CSCPFichaFamiliaPesca.nroPredio=".$_SESSION["ccfPredio"]." 
		 and CSCPFichaFamiliaPesca.nroVivienda=".$_SESSION["ccfVivienda"]." 
		 and CSCPFichaFamiliaPesca.nroFamilia=".$_SESSION["ccfFamilia"]." ";
		 $sql_pesca=$sql_pesca."and CSCPFichaFamiliaPesca.consecPesca=".$conse;
		$cur_pez=mssql_query($sql_pesca);

		while($datos_pesca=mssql_fetch_array($cur_pez))
		{
                     $fuenteh=$datos_pesca["fuenteHidrica"]; 
                     $especieh=$datos_pesca["codEspecie"];
                     $cantidadh=$datos_pesca["cantidad"];
                     $autoh=$datos_pesca["porcentAuto"];
                     $ventah=$datos_pesca["porcentVenta"];
//                     $tempo=$datos_pesca["codItemTipoTemp"]; 
		}
//		$num_reg=mssql_num_rows($cur_pez);
//echo $sql_pesca." --  -$especie *** $tempo ".mssql_get_last_message()."<br>";

if($accion==3)
	$habilita="disabled";

if ($recarga == "2") 
{
		$error="no";

		mssql_query("BEGIN TRANSACTION");

		if($accion==2)
		{
			$sql_up="update CSCPFichaFamiliaPesca set fuenteHidrica='".$fuente."',codEspecie=".$especie.",cantidad=".$cantidad.",porcentAuto=".$auto.",porcentVenta=".$venta." 
			 where CSCPFichaFamiliaPesca.codProyecto=".$_SESSION["ccfProyecto"]." 
			 and CSCPFichaFamiliaPesca.codModulo=".$_SESSION["ccfModulo"]." 
			 and CSCPFichaFamiliaPesca.numFormulario='".$_SESSION["ccfFormulario"]."' 
			 and CSCPFichaFamiliaPesca.consecutivo=".$_SESSION["ccfConsecutivo"]." 
			 and CSCPFichaFamiliaPesca.nroPredio=".$_SESSION["ccfPredio"]." 
			 and CSCPFichaFamiliaPesca.nroVivienda=".$_SESSION["ccfVivienda"]." 
			 and CSCPFichaFamiliaPesca.consecPesca=".$conse." 
			 and CSCPFichaFamiliaPesca.nroFamilia=".$_SESSION["ccfFamilia"]."";

			$cursorIn=mssql_query($sql_up);
//echo 	$sql_up." ----  ".mssql_get_last_message()."<br>";

			$sql_up="DELETE FROM CSCPFichaFamiliaPescaTemp   
			 where CSCPFichaFamiliaPescaTemp.codProyecto=".$_SESSION["ccfProyecto"]." 
			 and CSCPFichaFamiliaPescaTemp.codModulo=".$_SESSION["ccfModulo"]." 
			 and CSCPFichaFamiliaPescaTemp.numFormulario='".$_SESSION["ccfFormulario"]."' 
			 and CSCPFichaFamiliaPescaTemp.consecutivo=".$_SESSION["ccfConsecutivo"]." 
			 and CSCPFichaFamiliaPescaTemp.nroPredio=".$_SESSION["ccfPredio"]." 
			 and CSCPFichaFamiliaPescaTemp.nroVivienda=".$_SESSION["ccfVivienda"]." 
			 and CSCPFichaFamiliaPescaTemp.consecPesca=".$conse." 
			 and CSCPFichaFamiliaPescaTemp.nroFamilia=".$_SESSION["ccfFamilia"]."";

			$cursorIn2=mssql_query($sql_up);
//echo 	$sql_up." ----  ".mssql_get_last_message()."<br>";


			$cons_temp=1; //incrementa el consecutivo de la temporalidad, cuando se ingresa un registro en CSCPFichaFamiliaPescaTemp
			$z=1;  //permite recorrer los valores de los items

			//recorre la cantidad de items de temporalidad(6.8.3.6), para verificar cualies se marcaron como SI
			while(($z<=$cant_tempo)and($error=="no"))
			{
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
		
					$sql_insert2= $sql_insert2. " ".$conse."," ;
					$sql_insert2= $sql_insert2. " ".$cons_temp."," ;
		
					$sql_insert2= $sql_insert2. " ".$_POST['aplicas'.$z]."," ;
					$sql_insert2 = $sql_insert2. " '" . gmdate("n/d/y") ."', ";
					$sql_insert2 = $sql_insert2 . " '".$_SESSION["ccfUsuID"]."' " ;
					$sql_insert2=$sql_insert2.")";
		
					$cursorIn3=mssql_query($sql_insert2);
//echo 	$sql_insert2." ----  ".mssql_get_last_message()."<br>";
					if(trim($cursorIn3)=="")
						$error="si";
					$cons_temp++;
				}
				$z++;
			}
		}
		if($accion==3)
		{
			$sql_up="DELETE FROM CSCPFichaFamiliaPescaTemp   
			 where CSCPFichaFamiliaPescaTemp.codProyecto=".$_SESSION["ccfProyecto"]." 
			 and CSCPFichaFamiliaPescaTemp.codModulo=".$_SESSION["ccfModulo"]." 
			 and CSCPFichaFamiliaPescaTemp.numFormulario='".$_SESSION["ccfFormulario"]."' 
			 and CSCPFichaFamiliaPescaTemp.consecutivo=".$_SESSION["ccfConsecutivo"]." 
			 and CSCPFichaFamiliaPescaTemp.nroPredio=".$_SESSION["ccfPredio"]." 
			 and CSCPFichaFamiliaPescaTemp.nroVivienda=".$_SESSION["ccfVivienda"]." 
			 and CSCPFichaFamiliaPescaTemp.consecPesca=".$conse." 
			 and CSCPFichaFamiliaPescaTemp.nroFamilia=".$_SESSION["ccfFamilia"]."";

			$cursorIn2=mssql_query($sql_up);
//echo 	$sql_up." ----  ".mssql_get_last_message()."<br>";

			$sql_up="DELETE FROM CSCPFichaFamiliaPesca  
			 where CSCPFichaFamiliaPesca.codProyecto=".$_SESSION["ccfProyecto"]." 
			 and CSCPFichaFamiliaPesca.codModulo=".$_SESSION["ccfModulo"]." 
			 and CSCPFichaFamiliaPesca.numFormulario='".$_SESSION["ccfFormulario"]."' 
			 and CSCPFichaFamiliaPesca.consecutivo=".$_SESSION["ccfConsecutivo"]." 
			 and CSCPFichaFamiliaPesca.nroPredio=".$_SESSION["ccfPredio"]." 
			 and CSCPFichaFamiliaPesca.nroVivienda=".$_SESSION["ccfVivienda"]." 
			 and CSCPFichaFamiliaPesca.consecPesca=".$conse." 
			 and CSCPFichaFamiliaPesca.nroFamilia=".$_SESSION["ccfFamilia"]."";

			$cursorIn=mssql_query($sql_up);

//echo 	$sql_up." ----  ".mssql_get_last_message()."<br>";

		}	




			if((trim($cursorIn)!="")and(trim($cursorIn2)!="")and($error=="no"))
			{
				mssql_query("COMMIT TRANSACTION");
				echo ("<script>alert('Operación realizada con éxito.');</script>");
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
		msg=msg+"El  porcentaje(%) de venta no puede ser mayor a 100% \n";
	}


/*
	 if(document.form1.temporalidad.value=="")
	{
		msg=msg+"El campo Temporalidad es obligatorio \n";
	}
*/

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
			<td colspan="3" >6.8.3. PESCA ARTESANAL <? // echo $pTituloPpal ;?></td>
		</tr>
      <tr>


                <td  class="TituloTabla1">6.8.3.1 Fuente Hídrica</span></td>
                <td><input name="fuente" class="CajaTexto" id="fuente" type="text" value="<?php echo $fuenteh ?>"  <?php echo $habilita ?> ></td>
      </tr>  
      <tr>
                <td  class="TituloTabla1">6.8.3.2 Especie</span></td>
                <td>
<?php
			$sql_especie="select *,nomItem from tmItems where codOpcion=93";
			$sql_especie= $sql_especie. " and tmItems.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sql_especie= $sql_especie. " AND tmItems.codModulo=".$_SESSION["ccfModulo"] ;
			$cur_especie=mssql_query($sql_especie);


?>

					<select name="especie" class="CajaTexto" id="especie" <?php echo $habilita ?>>
						<option value="" selected>Seleccione una especie</option>
<?php 
						while($datos_especie=mssql_fetch_array($cur_especie))
						{
							$selEspecie="";
							if($datos_especie["codItem"]==$especieh)
								$selEspecie="selected";
?>
						<option value="<?php echo $datos_especie["codItem"]; ?>"  <?php echo $selEspecie; ?>><?php echo $datos_especie["nomItem"]; ?></option>
<?							
						}
?>

					</select>
				</td>
      </tr>  
      <tr>
                <td  class="TituloTabla1">6.8.3.3 Cantidad Kg/día</span></td>
                     

                <td><input name="cantidad" type="text" class="CajaTexto" id="cantidad"  onKeyPress="return acceptNum_Decimal(event)" value="<?php echo $cantidadh; ?>" <?php echo $habilita ?> > </td>
      </tr>  
      <tr>
                <td  class="TituloTabla1">6.8.3.4 % autoconsumo</span></td>
                <td> <input name="auto" type="text" class="CajaTexto" id="auto" maxlength="3"  onKeyPress="return acceptNum(event)" value="<?php echo $autoh; ?>" <?php echo $habilita ?>  > </td>
      </tr>  
      <tr>
                <td  class="TituloTabla1">6.8.3.5 % venta</span></td>
                <td><input name="venta" type="text" class="CajaTexto" id="venta" maxlength="3"  onKeyPress="return acceptNum(event)" value="<?php echo $ventah; ?>" <?php echo $habilita ?> ></td>
      </tr>  
      <tr>
                <td colspan="2"  class="TituloTabla1" >6.8.3.6 Temporalidad</span></td>
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
							$reg=0;
							$sql_temp=" select tmItems.nomItem as temporalidad from CSCPFichaFamiliaPescaTemp				
							 inner join tmItems on CSCPFichaFamiliaPescaTemp.codItemTipoTemp=tmItems.codItem 
							 where CSCPFichaFamiliaPescaTemp.codProyecto=".$_SESSION["ccfProyecto"]." 
							 and CSCPFichaFamiliaPescaTemp.codModulo=".$_SESSION["ccfModulo"]." 
							 and CSCPFichaFamiliaPescaTemp.numFormulario='".$_SESSION["ccfFormulario"]."' 
							 and CSCPFichaFamiliaPescaTemp.consecutivo=".$_SESSION["ccfConsecutivo"]." 
							 and CSCPFichaFamiliaPescaTemp.nroPredio=".$_SESSION["ccfPredio"]." 
							 and CSCPFichaFamiliaPescaTemp.nroVivienda=".$_SESSION["ccfVivienda"]."
							 and CSCPFichaFamiliaPescaTemp.consecPesca=".$conse." 

							 and CSCPFichaFamiliaPescaTemp.codItemTipoTemp=".$datos_tempo["codItem"]." 

							 and CSCPFichaFamiliaPescaTemp.nroFamilia=".$_SESSION["ccfFamilia"]." ORDER BY (CSCPFichaFamiliaPescaTemp.consecTemp)";
								$cur_temp=mssql_query($sql_temp);
							$reg=mssql_num_rows($cur_temp);

?>
      <tr class="CajaTexto">
                <td  class="TituloTabla1">
						<?php echo $datos_tempo["nomItem"]; ?>

				</td>
				<td>
						Si<input type="radio" name="aplica<?php echo $i; ?>" id="aplica<?php echo $i; ?>" value="<?php echo "si"; ?>"  <?php if($reg!=0) { echo "checked"; } ?>  <?php echo $habilita ?>>
						No<input type="radio" name="aplica<?php echo $i; ?>" id="aplica<?php echo $i; ?>" value="<?php echo "no"; ?>"  <?php if($reg==0) { echo "checked"; } ?> <?php echo $habilita ?>>
						  <input type="hidden" name="aplicas<?php echo $i; ?>" id="aplicas<?php echo $i; ?>" value="<?php echo $datos_tempo["codItem"]; ?>"  >
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

			<?php if($accion=='2') { $mensa="Editar";  } if($accion=='3') { $mensa="Eliminar"; } ?>
          <input name="Submit2" type="button" class="Boton" value="<?php echo $mensa; ?>" onClick="envia2()">
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

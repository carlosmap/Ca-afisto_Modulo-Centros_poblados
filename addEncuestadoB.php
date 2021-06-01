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
include ("../verificaIngreso2.php");

//Abre la conexión a la BD
include('../enlaceBD.php');

//Establecer la conexión a la base de datos
$conexion = conectar();



if($recarga!="")
{
	$Nombres = $Nombres;
	$Apellidos = $Apellidos;
	$razonSocial = $razonSocial;
	$lstTipoDoc = $lstTipoDoc;
	$Telefono = $Telefono;
	$expedido = $expedido;
	$depto = $depto;
	$municipio = $municipio;
	$vereda = $vereda;
	$deptoRes = $deptoRes;
	$municipioRes = $municipioRes;
	$veredaRes = $veredaRes;
	$corregRes = $corregRes;
}

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	//Asigna el consecutivo
	$sqlSec="Select max(idEntrevistado) MaxCodigo from CSCPEntrevistado  ";
	$cursorSec = mssql_query($sqlSec);
	if ($regSec=mssql_fetch_array($cursorSec)) 
	{
		$pSigEncuestado = $regSec[MaxCodigo] + 1;
	}
	else 
	{
		$pSigEncuestado = 1;
	}
	//Inserta los datos del encuestado
	//dbo.CSCPEntrevistado
	$qry = "INSERT INTO CSCPEntrevistado(idEntrevistado, numDocumento, nombres, apellidos, codTipoDoc, telefonoFijo, telefonoCelular,
			codDepartamentoExp, codMunicipioExp, tieneDoc, fechaGraba, usuarioGraba) " ; 
	$qry = $qry . " VALUES ( " ; 
	$qry = $qry . " " .$pSigEncuestado. ", " ; 	
	$qry = $qry . " '" .  $Documento . "', " ; 
	$qry = $qry . " '" .  $Nombres . "', " ;
	$qry = $qry . " '" .  $Apellidos . "', ";
	$qry = $qry . " " .$lstTipoDoc. ", " ; 
	if( $Telefono != "" )
		$qry = $qry . " '" .$Telefono. "', " ; 	
	else
		$qry = $qry . " NULL, " ;	
	
	if( $celular != "" )
		$qry = $qry . " '" .$celular. "', " ; 	
	else
		$qry = $qry . " NULL, " ;	
	
	if( $dpt != "" )
		$qry = $qry . " '".$dpt."', "; 	#	Departamento	
	else
		$qry = $qry . " NULL, " ;	
	
	if( $mns != "" )
		$qry = $qry . " '".$mns."', "; 	#	Municipio
	else
		$qry = $qry . " NULL, " ;	
	
	$qry = $qry . " '1', " ; 
	$qry = $qry . " '".gmdate ("n/d/y")."', " ;
	$qry = $qry . " '".$_SESSION["ccfUsuID"]."' " ;
	$qry = $qry . " ) " ;
	$cursorIn = mssql_query($qry) ;
	#echo $qry."<br />";
	
	if  (trim($cursorIn) != "") 
	{
		//Realiza la asociación al formulario	
		#$sqlConsecutivo = "Select consecutivo FROM CSCPFicha Where codProyecto = ".$_SESSION["ccfProyecto"]." AND numFormulario = ".$_SESSION["ccfFormulario"];
		#$consecutivo = mssql_fetch_array( mssql_query( $sqlConsecutivo ) );

		$query2 = "INSERT INTO CSCPFichaEntrevistado(codProyecto, codModulo, numFormulario, consecutivo, idEntrevistado,  tipoPersona,
				   usuarioGraba, fechaGraba) ";
		$query2 = $query2 . " VALUES (" ;
		$query2 = $query2 . $_SESSION["ccfProyecto"] . " , " ; 
		$query2 = $query2 . $_SESSION["ccfModulo"] . " , " ; 
		$query2 = $query2 . "'".$_SESSION["ccfFormulario"] . "', " ; 
#		$query2 = $query2 . $consecutivo[consecutivo] . ", ";	
		$query2 = $query2 . $_SESSION["ccfConsecutivo"] . ", ";	
		$query2 = $query2 . $pSigEncuestado . ", ";	
		$query2 = $query2 . $evt . ", ";
		#$query2 = $query2 . "1, ";
		$query2 = $query2 . " '".$_SESSION["ccfUsuID"]."', " ;
		$query2 = $query2 . " '".gmdate ("n/d/y")."' " ;
		$query2 = $query2 . " ) ";
		$cursor2 = mssql_query($query2) ;
		#echo $query2."<br />";
	} 	
	

	if((trim($cursorIn) != "") && (trim($cursor2) != "")) 
	{
		echo ("<script>alert('La grabación se realizó con éxito');</script>");
	}
	else
	{
		echo ("<script>alert('Error durante la grabación. Verifique la información');</script>");
	}	
	#/*	Determina la pagina a la que debe redireccionar dependiendo el tipo de persona que valla a registrar
	if( $evt == 1 )
		$site = "frmCensoLocaliza01.php";
	else if( $evt == 2 )
		$site = "frmCensoIdPredio02.php";
	echo "<script>
			window.close();
			MM_openBrWindow('".$site."?miAncla=$Opc','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
		  </script>";
	#*/
}
 ?>

<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" src="calendar.js"></script>
<SCRIPT language=JavaScript>
<!--


function envia1(){ 
//alert ("Entro a envia 1");
document.form1.recarga.value="1";
document.form1.submit();
}

function envia2(){ 
	var v1,v2,v3, v4, i, CantCampos, msg1, msg2, msg3, msg4, mensaje;
	v1='s';
	v2='s';
	v3='s';
	v4='s';
	msg1 = '';
	msg2 = '';
	msg3 = '';
	msg4 = '';
	mensaje = '';
	
	if(document.form1.Nombres.value == '')
	{
		v1='n';
		msg1='El nombre del entrevistado es obligatorio.\n';
	}
	
	if(document.form1.Apellidos.value == '')
	{
		v2='n';
		msg2='El apellido del entrevistado es obligatorio. \n';
	}
	/*/	txtMunicipio
	if(document.form1.txtMunicipio.value == '')
	{
		v3='n';
		msg3='El lugar de expedición del documento es obligatorio.\n';
	}
	//*/
	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s')) {
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else {
		mensaje = msg1 + msg2 + msg3 + msg4;
		alert (mensaje);
	}
	
}
function key(){
	if ( event.keyCode > 45 && event.keyCode < 57) 
		event.returnValue = false	
}

function keyNum(){
	if ( event.keyCode < 45 || event.keyCode > 57) 
		event.returnValue = false	
}

//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#00344C">
  <tr>
    <td>
	<form name="form1" method="post" action="">
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla">.: Persona entrevistada </td>
        </tr>
    </table>
	
      <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%" class="TituloTabla2"><span class="TituloTabla1">Nombres</span></td>
        <td class="TxtTabla">
			<input name="Nombres" type="text" class="CajaTexto" id="Nombres" value="<? echo $Nombres; ?>" size="70"></td>
      </tr>
	  
      <tr>
        <td width="25%" class="TituloTabla2">Apellidos</td>
        <td class="TxtTabla"><input name="Apellidos" type="text" class="CajaTexto" id="Apellidos" value="<? echo $Apellidos; ?>" size="70"></td>
      </tr>
	  
	  <?
	  //Trae la información de los tipos de documento 
	  $sqlDoc = "SELECT * FROM tmItems WHERE codOpcion = 4 and codItem <>0";
	  $cursorDoc = mssql_query($sqlDoc) ;
	  ?>
      <tr>
        <td width="25%" class="TituloTabla2">Tipo de documento</td>
        <td class="TxtTabla"><select name="lstTipoDoc" class="CajaTexto" id="lstTipoDoc" style="width:250px">
          <?
		  while ($regDoc = mssql_fetch_array($cursorDoc)) { 
		  	if ($lstTipoDoc==$regDoc[codItem]) 
			{
				$selTD="selected";
			}
			else {
				$selTD="";
			}
		  ?>
          <option value="<?php echo $regDoc[codItem]; ?>" <? echo $selTD; ?> ><?php echo $regDoc[nomItem]; ?></option>
          <? } ?>
        </select></td>
      </tr>
	  
      <tr>
        <td height="20" class="TituloTabla2">Departamento</td>
        <td class="TxtTabla">
        <?
			$sql = "select  * from tmDepartamentos order by nomDepartamento";
			$qry = mssql_query( $sql );
		?>
        <select name="dpt" id="dpt" class="CajaTexto" onChange="document.form1.submit();">
        	<option value="">::: Selecciones un Departamento :::</option>
        	<?	
				while( $rw = mssql_fetch_array( $qry ) ){
					if( $dpt == $rw[codDepartamento] )
						$select = "selected";
					else
						$select = "";
			?>
            		<option value="<?=	$rw[codDepartamento]	?>" <?= $select	?> ><?= $rw[nomDepartamento]	?></option>
            <?	}	?>
        </select>
        </td>
      </tr>
      <tr>
        <td height="20" class="TituloTabla2">Municipio</td>
        <td class="TxtTabla">
        <?
			$sqlM = "select  * from tmMunicipios where codDepartamento = ".$dpt." order by nomMunicipio";
			$qryM = mssql_query( $sqlM );
		?>
        <select name="mns" id="mns" class="CajaTexto">
        	<option value="">::: Selecciones un Municipio :::</option>
        	<?	while( $rwM = mssql_fetch_array( $qryM ) ){	?>
            		<option value="<?=	$rwM[codMunicipio]	?>"><?= $rwM[nomMunicipio]	?></option>
            <?	}	?>
        </select>
        </td>
      </tr>
      <tr>
        <td width="25%" height="20" class="TituloTabla2">Documento</td>
        <td class="TxtTabla"><input name="Documento" type="text" class="CajaTexto" id="Documento" onKeyPress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" value="<? echo $Documento ; ?>" size="30" readonly ></td>
      </tr>
	  
	  <!-- Teléfono -->      
	  <tr>
	    <td class="TituloTabla2">Telefono fijo</td>
	    <td class="TxtTabla"><input name="Telefono" type="text" class="CajaTexto" id="Telefono" value="<? echo $Telefono; ?>" size="30"  onKeyPress="keyNum();" />
	      <input name="recarga" type="hidden" id="recarga" value="1"></td>
	    </tr>
	  <tr>
		<td width="25%" class="TituloTabla2">Telefono celular</td>
		<td class="TxtTabla">
        <input name="celular" type="text" class="CajaTexto" id="celular" value="<? echo $celular; ?>" size="30" onKeyPress="keyNum();" />
        </td>
	  </tr>
    </table>
	</form>  
	
	
	  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">		  <input name="Submit2" type="button" class="Boton" value="Grabar" onClick="envia2()">
          </td></tr>
    </table>	
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="20" class="copyr"> powered by INGETEC S.A - 2012</td>
  </tr>
</table>	</td>
  </tr>

</table>


</body>
</html>

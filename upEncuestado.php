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
	/*
		idEntrevistado, numDocumento, nombres, , codTipoDoc, telefonoFijo, telefonoCelular,
		codDepartamentoExp, codMunicipioExp, tieneDoc, fechaGraba, usuarioGraba) " ; 
	*/
	if( $accion == 2 ){
		$qry = "UPDATE CSCPEntrevistado SET ";
		$qry = $qry . " numDocumento = '" .  $Documento . "', " ; 
		$qry = $qry . " nombres = '" .  $Nombres . "', " ;
		$qry = $qry . " apellidos = '" .  $Apellidos . "', ";
		$qry = $qry . " codTipoDoc = " .$lstTipoDoc. ", " ; 
		if( $Telefono != "" )
			$qry = $qry . " telefonoFijo = '" .$Telefono. "', " ; 	
		else
			$qry = $qry . " telefonoFijo = NULL, " ;	
		
		if( $celular != "" )
			$qry = $qry . " telefonoCelular = '" .$celular. "', " ; 	
		else
			$qry = $qry . " telefonoCelular = NULL, " ;	
		
		if( $dpt != "" )
			$qry = $qry . " codDepartamentoExp = '".$dpt."', "; 	#	Departamento	
		else
			$qry = $qry . "codDepartamentoExp =  NULL, " ;	
		
		if( $mns != "" )
			$qry = $qry . " codMunicipioExp = '".$mns."', "; 	#	Municipio	, 
		else
			$qry = $qry . " codMunicipioExp = NULL, " ;	
		
		$qry = $qry . " fechaMod = '".gmdate ("n/d/y")."', " ;
		$qry = $qry . " usuarioMod = '".$_SESSION["ccfUsuID"]."' " ;
		$qry = $qry . " WHERE " ; 	
		$qry = $qry . "  idEntrevistado = ".$consecutivo ; 
		#$cursorIn = mssql_query($qry) ;
		#echo $qry."<br />";
	}
	else if( $accion == 3 ){
		$qry = "DELETE FROM CSCPFichaEntrevistado WHERE " ; 	
		$qry  = $qry . " idEntrevistado = ".$consecutivo;
		$qry  = $qry . " AND numFormulario = ". $_SESSION['ccfFormulario'];
		$qry  = $qry . " AND tipoPersona = ".$evt; 
		#$qry = "DELETE FROM CSCPEntrevistado WHERE idEntrevistado = ".$consecutivo ; 
		#$cursorIn = mssql_query($qry) ;
		#echo $qry."<br />";
	}
	
	$cursorIn = mssql_query($qry) ;
	#/*
	if( trim($cursorIn) != "" ) 
	{
		echo ("<script>alert('El proceso se finalizo con éxito');</script>");
	}
	else
	{
		echo ("<script>alert('Error durante el procedimiento');</script>");
	}	
	#*/
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
	
	if(document.form1.Nombres.disabled == false ){
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
	}
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
function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<?php
	$sql = "Select * from CSCPEntrevistado Where idEntrevistado = ".$consecutivo;
	$qryInfoUser = mssql_fetch_array( mssql_query( $sql ) );
	#echo $sql;
	if( $accion == 3 )
		$dis = "disabled";
	else
		$dis = "";	
?>
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
        <input name="Nombres" type="text" class="CajaTexto" id="Nombres" value="<?= $qryInfoUser[nombres]; ?>" size="70" <?= $dis ?> /></td>
      </tr>
	  
      <tr>
        <td width="25%" class="TituloTabla2">Apellidos</td>
        <td class="TxtTabla">
        <input name="Apellidos" type="text" class="CajaTexto" id="Apellidos" value="<?= $qryInfoUser[apellidos]; ?>" size="70" <?= $dis ?> />
        </td>
      </tr>
	  
	  <?
	  //Trae la información de los tipos de documento 
	  $sqlDoc = "SELECT * FROM tmItems WHERE codOpcion = 4";
	  if ( $qryInfoUser[codItem] != "" )
	  	$sqlDoc = "SELECT * FROM tmItems WHERE codItem = ".$qryInfoUser[codItem];
	  $cursorDoc = mssql_query($sqlDoc) ;
	  ?>
      <tr>
        <td width="25%" class="TituloTabla2">Tipo de documento</td>
        <td class="TxtTabla">
        <select name="lstTipoDoc" class="CajaTexto" id="lstTipoDoc" style="width:250px" <?= $dis ?>>
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
			if(!isset($dpt))
			{
				$dpt=$qryInfoUser[codDepartamentoExp];
			}
			$sql = "select  * from tmDepartamentos order by nomDepartamento";
/*			if( $qryInfoUser[codDepartamentoExp] != "" )
				$sql = "select  * from tmDepartamentos where codDepartamento = ".$qryInfoUser[codDepartamentoExp];
*/
			#echo $sql."<br />";
			$qry = mssql_query( $sql );
		?>
        <select name="dpt" id="dpt" class="CajaTexto" onChange="document.form1.submit();" <?= $dis ?> >
        	<option value="">::: Selecciones un Departamento :::</option>
        	<?	
				while( $rw = mssql_fetch_array( $qry ) ){
					$select = "";
					if( $dpt == $rw[codDepartamentoExp] )
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
			if( $qryInfoUser[codMunicipioExp] != "" )
				$sqlM = "select  * from tmMunicipios where codMunicipio = ".$qryInfoUser[codMunicipioExp]." and codDepartamento = ".$qryInfoUser[codDepartamentoExp];
			#echo $sqlM."<br />";
			$qryM = mssql_query( $sqlM );
		?>
        <select name="mns" id="mns" class="CajaTexto" <?= $dis ?> >
        	<?
				if( $qryInfoUser[codMunicipioExp] != "" ){
					$rwM = mssql_fetch_array( $qryM ) 
			?>
        	<option value="<?=	$rwM[codMunicipio]	?>"><?= $rwM[nomMunicipio]	?></option>
        	<?	
				}
				else{
					while( $rwM = mssql_fetch_array( $qryM ) ){	?>
            		<option value="<?=	$rwM[codMunicipio]	?>"><?= $rwM[nomMunicipio]	?></option>
            <?		}
				}
			?>
        </select>
        </td>
      </tr>
      <tr>
        <td width="25%" height="20" class="TituloTabla2">Documento</td>
        <td class="TxtTabla">
        <input name="Documento" type="text" class="CajaTexto" id="Documento" onKeyPress="if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;" value="<?= $qryInfoUser[numDocumento]; ?>" size="30" <?= $dis ?> readonly />
        </td>
      </tr>
	  
	  <!-- Teléfono -->      
	  <tr>
	    <td class="TituloTabla2">Telefono fijo</td>
	    <td class="TxtTabla">
        <input name="Telefono" type="text" class="CajaTexto" id="Telefono" value="<?= $qryInfoUser[telefonoFijo]; ?>" size="30"  onKeyPress="keyNum();" <?= $dis ?> />	      <input name="recarga" type="hidden" id="recarga" value="1">
        </td>
	    </tr>
	  <tr>
		<td width="25%" class="TituloTabla2">Telefono celular</td>
		<td class="TxtTabla">
        <input name="celular" type="text" class="CajaTexto" id="celular" value="<?= $qryInfoUser[telefonoCelular]; ?>" size="30" onKeyPress="keyNum();" <?= $dis ?> />
        </td>
	  </tr>
    </table>
	</form>  
	
	
	  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><input name="recCodCatastroarga" type="hidden" id="recCodCatastroarga3" value="1">
          <input name="noPrediodel" type="hidden" id="noPrediodel" value="<?= $infPredio[nroPredio] ?>">
          <input name="recCodCatastroarga" type="hidden" id="recCodCatastroarga" value="1">
          <input name="Submit" type="submit" class="Boton"  
			value="<? if ($accion==3) { echo "Borrar"; } else { echo "Grabar"; } ?>"  onClick="envia2()">
          <? if ($accion==3)
		   	{ ?>
          <input name="Cancelar" type="button" class="Boton" id="Cancelar" 
				 onClick="MM_callJS('window.close();')" value="Cancelar">
        <? } ?></td></tr>
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

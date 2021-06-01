<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php

//Adicionar Información Integrantes de la Familia

//Inicializa las variables de sesión
session_start();

//Validación de Ingreso
include ("../verificaIngreso2.php");

//Abre la conexión a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();


//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	//Obtener el Máximo consecutivo de CSEFichaIntegrantesFamilia	
	$sqlSec	= "SELECT MAX(consecFamilia) MaxCodigo FROM CSCPFichaIntegrantesFamilia";
	$cursorSec = mssql_query($sqlSec);
	if ($regSec=mssql_fetch_array($cursorSec)) 
	{
		$pSig = $regSec[MaxCodigo] + 1;
	}
	else 
	{
		$pSig = 1;
	}
	
	
	if($dia!=""){
	$fechaFormat = "'".Genera_Fecha_DB($dia, $mes, $ano)."'";
	}
	else{
		$fechaFormat = "NULL";
	}

	$sqlDoc	= "SELECT COUNT(*) documento FROM CSCPFichaIntegrantesFamilia WHERE numDoc = ".$pNumDoc." AND nroFamilia = ".$_SESSION["ccfFamilia"];
	$qryDoc = mssql_fetch_array( mssql_query( $sqlDoc ) );
	if( $qryDoc[documento] == 0 ){
		
		$qry = "INSERT INTO CSCPFichaIntegrantesFamilia ( 
					nroFamilia, consecFamilia, nombres, apellidos, codItemTipoDoc, numDoc, codItemSexo, codItemLugarNac, edadCumplida 
					, codItemEstadoCivil, codItemLegalmente, codItemParentesco, codItemGrupoEtnico
					, codItemAfiliaSalud, codItemLimitacion, codItemGestantes, codItemLactantes, codItemPrograma
					, codItemLeeEscribe, codItemNivelEduca, codItemAsiste, codItemInstUbica, codItemInstEducativa
					, codItemOcupacion, codItemIngreso, mesesDedicacion, fechaGraba, usuarioGraba )VALUES( ";	
		$qry = $qry. $_SESSION["ccfFamilia"].", ";
		$qry = $qry. $pSig .",";
		$qry = $qry. "'".$pNombres ."',";
		$qry = $qry. "'".$pApellidos ."',";
		$qry = $qry. $pCodItemTipoDoc.",";
		$qry = $qry. $pNumDoc .",";
		$qry = $qry. $pCodItemSexo .",";
		$qry = $qry. $pCodItemLugarNacimiento .",";
		$qry = $qry. $pEdad .",";
		$qry = $qry. $pCodItemEstadoCivil .",";
		$qry = $qry. $pCodLegalmente .",";
		$qry = $qry. "'".$pCodParentesco ."',";
		$qry = $qry. $pCodGrupo .",";
		$qry = $qry. $pCodItemSalud .",";
		$qry = $qry. $pCodItemLimitaciones .",";
		$qry = $qry. $pCodItemMGestante .",";
		$qry = $qry. $pCodItemMLactante .",";
		$qry = $qry. $pCodItemPrograma .",";
		$qry = $qry. $pCodItemLeer .",";
		$qry = $qry. $pCodNivel .",";
		$qry = $qry. $pCodItemAsiste .",";
		$qry = $qry. $pCodUbicacion .",";
		$qry = $qry. $pCodInstitucion .",";
		$qry = $qry. $pCodOficio .",";
		$qry = $qry. $pCodItemIngresoMensual .",";
		$qry = $qry. $pMActividades .",";
		$qry = $qry. " '" . gmdate("n/d/y") ."', ";
		$qry = $qry. " '".$_SESSION["ccfUsuID"]."') " ;	
		#echo $qry;
		$cursorIn = mssql_query( $qry );
		if  (trim($cursorIn) != "")  
			echo ("<script>alert('La grabación se realizó con éxito.');</script>");
		else 
			echo ("<script>alert('Error durante la grabación');</script>");		

		$volverA = "";
		$volverA=Genera_Pagina($Opc,$pag);	
		#/*
		echo "<script>
				window.close();
				MM_openBrWindow('frmCensoFamiliaIntegrantes.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
			  </script>";
		#*/
	}
	else
		echo "<script>alert('Este número de documento ya esta registrado.');</script>";

}


?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
	var v1,v2,v3, v4,v5,v6,v7,v8,v9,v10, v11, v12,v13, v14,v15,v16,v17,v18,v19,v20, v21, v22, v23, i, CantCampos;
	var msg1, msg2, msg3, msg4, msg5, msg6, msg7, msg8, msg9, msg10, msg11, msg12, msg13, msg14, msg15, msg16, msg17, msg18, msg19, msg20, msg21, mensaje;
	v1='s';
	v2='s';
	v3='s';
	v4='s';
	v5='s';
	v6='s';
	v7='s';
	v8='s';
	v9='s';
	v10=v11=v12=v13=v14=v15=v16=v17=v18=v19=v20=v21=v22=v23='s';
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
	msg11 = '';
	msg12 = '';
	msg13 = '';
	msg14 = '';
	msg15 = '';
	msg16 = '';
	msg17 = '';
	msg18 = '';
	msg19 = '';
	msg20 = '';
	msg21 = '';
	msg22 = '';
	msg23 = '';
	mensaje = '';
	if (document.form1.pNombres.value == '')  
	{
		v1='n';
		msg1 = 'El Nombre del Integrante de la Familia es obligatorio. \n'
	}
	if (document.form1.pApellidos.value == '') 
	{
		v2='n';
		msg2 = 'El Apellido del Integrante de la Familia es obligatorio. \n'
	}
	if (document.form1.pNumDoc.value == '')
	{
		v3='n';
		msg3 = 'El número de documento del Integrante de la Familia es obligatorio. \n'
	}
	//	pMActividades
	if ( document.form1.pMActividades.value > 12 )
	{
		v4='n';
		msg4 = 'No puede superar los 12 meses. \n'
	}
	//***************************

	if (document.form1.pCodItemTipoDoc.value == '')  
	{
		v5='n';
		msg5 = 'El tipo de documento es obligatorio. \n'
	}
	if (document.form1.pCodItemSexo.value == '') 
	{
		v6='n';
		msg6 = 'El sexo es obligatorio. \n'
	}
	if (document.form1.pCodItemLugarNacimiento.value == '')
	{
		v7='n';
		msg7 = 'El lugar de nacimiento es obligatorio. \n'
	}
//***************************

	if (document.form1.pEdad.value == '')  
	{
		v5='n';
		msg5 = 'La edad es obligatorio. \n'
	}
	if (document.form1.pCodItemEstadoCivil.value == '') 
	{
		v6='n';
		msg6 = 'El estado civil es obligatorio. \n'
	}
	if (document.form1.pCodLegalmente.value == '')
	{
		v7='n';
		msg7 = 'El estado de la relación es obligatorio. \n'
	}
	if (document.form1.pCodParentesco.value == '')  
	{
		v8 = 'n';
		msg8 = 'El parentesco es obligatorio. \n'
	}
	if (document.form1.pCodGrupo.value == '') 
	{
		v9='n';
		msg9 = 'El grupo étnico es obligatorio. \n'
	}
	if (document.form1.pCodItemSalud.value == '')
	{
		v10='n';
		msg10 = 'La afiliación a salud es obligatorio. \n'
	}
	if (document.form1.pCodItemLimitaciones.value == '')  
	{
		v11='n';
		msg11 = 'El tipo de limitaciones es obligatorio. \n'
	}
	if (document.form1.pCodItemMGestante.value == '') 
	{
		v12='n';
		msg12 = 'Las madres gestantes es obligatorio. \n'
	}
	if (document.form1.pCodItemMLactante.value == '')
	{
		v13='n';
		msg13 = 'Las madres lactantes es obligatorio. \n'
	}
	if (document.form1.pCodItemPrograma.value == '')  
	{
		v14='n';
		msg14 = 'El programa que pertenecen es obligatorio. \n'
	}
	if (document.form1.pCodItemLeer.value == '') 
	{
		v15='n';
		msg15 = 'Si saben leer es obligatorio. \n'
	}
	if (document.form1.pCodNivel.value == '')
	{
		v16='n';
		msg16 = 'El nivel de educación es obligatorio. \n'
	}
	if (document.form1.pCodItemAsiste.value == '')  
	{
		v17='n';
		msg17 = 'La asistencia es obligatorio. \n'
	}
	if (document.form1.pCodInstitucion.value == '') 
	{
		v18='n';
		msg18 = 'La institución que asisten es obligatorio. \n'
	}
	if (document.form1.pCodNivel.value == '')
	{
		v19='n';
		msg19 = 'El nivel de educación es obligatorio. \n'
	}
/*
                        
*/	
	if (document.form1.pCodUbicacion.value == '')  
	{
		v20='n';
		msg20 = 'La ubicación es obligatorio. \n'
	}
	if (document.form1.pCodOficio.value == '') 
	{
		v21='n';
		msg21 = 'El oficio es obligatorio. \n'
	}
	if (document.form1.pMActividades.value == '')
	{
		v22='n';
		msg22 = 'El tiempo de la actividad es obligatorio. \n'
	}
	if (document.form1.pCodItemIngresoMensual.value == '')
	{
		v23='n';
		msg23 = 'Los ingreso mensual es obligatorio. \n'
	}
	//***************************
	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ( (v1=='s') && (v2=='s') && (v3=='s') && (v4=='s') && (v5=='s') && (v6=='s') && (v7=='s') && (v8=='s') && (v9=='s')&& (v10=='s') && (v11=='s') && (v12=='s') && (v13=='s') && (v14=='s') && (v15=='s') && (v16=='s') && (v17=='s') && (v18=='s') && (v19=='s') && (v20=='s') && (v21=='s') && (v22=='s') && (v23=='s') ) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 + msg4 + msg5 + msg6 + msg7 + msg8 + msg9 + msg10 + msg11 + msg12 + msg13 + msg14 + msg15 + msg16 + msg17 + msg18 + msg19 + msg20 + msg21 + msg22 + msg23;
		alert (mensaje);
	}	
}
//-->
function keyNum(){ //	input
	if ( event.keyCode < 48 || event.keyCode > 57) 
		event.returnValue = false	
}
function keyLetter(){ //	input
	if ( ( event.keyCode < 65 || event.keyCode > 90 ) && ( event.keyCode < 97 || event.keyCode > 122 ) ) 
		event.returnValue = false;
	if ( ( event.keyCode == 32 ) || ( event.keyCode == 164 ) || ( event.keyCode == 165 ) )
		event.returnValue = true;
}

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
        	<td class="TituloTabla" align="center">Integrantes del Hogar</td>
      	</tr>
    </table>

	<? //Búsqueda de los ítems para cada pregunta
		#$sqlItem = "SELECT * FROM tmItems";
		#	Tp documento
		$sqlIt = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 133 AND codItem = 1466";
		$qr = mssql_query( $sqlIt );
		
		#	Sexo
		$sqlIt1 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 57";
		$qr1 = mssql_query( $sqlIt1 );
		
		#	Lugar de nacimiento
		$sqlIt2 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 58";
		$qr2 = mssql_query( $sqlIt2 );
		
		#	Estado civil
		$sqlIt3 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 59";
		$qr3 = mssql_query( $sqlIt3 );
		
		#	Legalmente
		$sqlIt4 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 60";
		$qr4 = mssql_query( $sqlIt4 );
		
		#	Parentesco familiar
		$sqlIt5 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 61";
		$qr5 = mssql_query( $sqlIt5 );
		
		#	Grupo étnico
		$sqlIt6 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 62";
		$qr6 = mssql_query( $sqlIt6 );
		#	Afiliación salud
		$sqlIt7 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 63";
		$qr7 = mssql_query( $sqlIt7 );
		#	Tiene limitaciones permanentes
		$sqlIt8 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 64";
		$qr8 = mssql_query( $sqlIt8 );
		#	Tiene limitaciones permanentes
		$sqlIt9 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 65";
		$qr9 = mssql_query( $sqlIt9 );
		#	Mujeres gestantes
		$sqlIt10 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 66";
		$qr10 = mssql_query( $sqlIt10 );
		#	Mujeres lactactes
		$sqlIt11 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 67";
		$qr11 = mssql_query( $sqlIt11 );
		#	Programas institucionales
		$sqlIt12 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 68";
		$qr12 = mssql_query( $sqlIt12 );
		#	Sabe leer y escribir
		$sqlIt13 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 69";
		$qr13 = mssql_query( $sqlIt13 );
		#	Nivel educativo 
		$sqlIt14 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 70";
		$qr14 = mssql_query( $sqlIt14 );
		#	Institución educativa a la que asiste
		$sqlIt15 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 71";
		$qr15 = mssql_query( $sqlIt15 );
		#	Ubicación de la institucion
		$sqlIt16 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 72";
		$qr16 = mssql_query( $sqlIt16 );
		#	Oficio u ocupacion
		$sqlIt17 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 73";
		$qr17 = mssql_query( $sqlIt17 );
		#	Ingresos mensuales
		$sqlIt18 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 74";
		$qr18 = mssql_query( $sqlIt18 );

	?>
	<!-- Tabla de datos -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr>
		<td width="30%" class="TituloTabla1">Nombre</td>
	    <td class="TxtTabla"><input name="pNombres" type="text" class="CajaTexto" id="pNombres" value="<? echo $pNombres; ?>" size="50" onKeyPress="keyLetter();" /></td>
	  </tr>
	  
	  <tr>
	    <td width="30%" class="TituloTabla1">Apellido</td>
	    <td class="TxtTabla"><input name="pApellidos" type="text" class="CajaTexto" id="pApellidos" value="<? echo $pApellidos; ?>" size="50" onKeyPress="keyLetter();" /></td>
	  </tr>
	  <tr>
	    <td class="TituloTabla1"> Tipo de documento </td>
	    <td class="TxtTabla">
        <select name="pCodItemTipoDoc" class="CajaTexto" id="pCodItemTipoDoc" style="width:350">
	      <? 
			while($reg = mssql_fetch_array($qr))
			{
				$sel = "";
				if($reg[codItem] == $pCodItemTipoDoc)
				{
					$sel1 = "selected";
				}
			?>
	      <option value="<? echo $reg[codItem]; ?>" <? echo $sel; ?>><? echo $reg[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">N&uacute;mero de documento </td>
	    <td class="TxtTabla">
        <?
			#	fmla.nroFamilia = ".$_SESSION["ccfFamilia"]
			$sinDocumento = 1;
			$sqlSinDocumento = "SELECT MAX(cast (numDoc as int) ) sinDoncumento FROM CSCPFichaIntegrantesFamilia fmla WHERE fmla.codItemTipoDoc = 1466";
			#echo $sqlSinDocumento;
			$qrySinDocumento = mssql_fetch_array( mssql_query( $sqlSinDocumento ) );
			if( $qrySinDocumento[sinDoncumento] > 0 )
				$sinDocumento += $qrySinDocumento[sinDoncumento];
				
		?>
        <input name="pNumDoc" type="text" class="CajaTexto" id="pNumDoc" value="<?= $sinDocumento; ?>" size="20" onKeyPress="keyNum();" readonly />
        </td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Sexo</td>
	    <td class="TxtTabla">
        <select name="pCodItemSexo" class="CajaTexto" id="pCodItemSexo" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg1 = mssql_fetch_array($qr1))
			{
				$sel4 = "";
				if($reg1[codItem] == $pCodItemSexo)
				{
					$sel4 = "selected";
				}
				?>
	      <option value="<? echo $reg1[codItem]; ?>" <? echo $sel4; ?>><? echo $reg1[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Lugar de nacimiento</td>
	    <td class="TxtTabla">
        <select name="pCodItemLugarNacimiento" class="CajaTexto" id="pCodItemLugarNacimiento" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg2 = mssql_fetch_array($qr2))
			{
				$sel2 = "";
				if($reg2[codItem] == $pCodItemLugarNacimiento)
				{
					$sel2 = "selected";
				}
				?>
	      <option value="<? echo $reg2[codItem]; ?>" <? echo $sel2; ?>><? echo $reg2[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Edad cumplida</td>
	    <td class="TxtTabla"><input name="pEdad" type="text" class="CajaTexto" id="pEdad" value="<? echo $pEdad; ?>" size="20" onKeyPress="keyNum();" /></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Estado civil </td>
	    <td class="TxtTabla">
        <select name="pCodItemEstadoCivil" class="CajaTexto" id="pCodItemEstadoCivil" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg3 = mssql_fetch_array($qr3))
			{
				$sel3 = "";
				if($reg3[codItem] == $pCodItemEstadoCivil)
				{
					$sel3 = "selected";
				}
				?>
	      <option value="<? echo $reg3[codItem]; ?>" <? echo $sel3; ?>><? echo $reg3[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  	  
	  <tr>
	    <td class="TituloTabla1">Legalmente</td>
	    <td class="TxtTabla">
        <select name="pCodLegalmente" class="CajaTexto" id="pCodLegalmente" style="width:350" >
          <option value="">:::Seleccione una opción:::</option>
		  <? 
			while($reg4 = mssql_fetch_array($qr4))
			{
				$sel4 = "";
				if($reg4[codItem] == $pCodLegalmente)
				{
					$sel4 = "selected";
				}
				?>
          <option value="<? echo $reg4[codItem]; ?>" <? echo $sel4; ?>><? echo $reg4[nomItem]; ?></option>
          <?
			}
			?>
        </select></td>
	  </tr>
	 
	  <tr>
	    <td class="TituloTabla1">Parentesco familiar</td>
	    <td class="TxtTabla"><select name="pCodParentesco" class="CajaTexto" id="pCodParentesco" style="width:350" >
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg5 = mssql_fetch_array($qr5))
			{
				$sel5 = "";
				if($reg5[codItem] == $pCodParentesco)
				{
					$sel5 = "selected";
				}
				?>
	      <option value="<? echo $reg5[codItem]; ?>" <? echo $sel5; ?>><? echo $reg5[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	  </tr>
	  
	  <tr>
	    <td class="TituloTabla1">Grupo &eacute;tnico </td>
	    <td class="TxtTabla">
        <select name="pCodGrupo" class="CajaTexto" id="pCodGrupo" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg6 = mssql_fetch_array($qr6))
			{
				$sel6 = "";
				if($reg6[codItem] == $pCodGrupo)
				{
					$sel6 = "selected";
				}
				?>
	      <option value="<? echo $reg6[codItem]; ?>" <? echo $sel6; ?>><? echo $reg6[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  
	  <tr>
	    <td class="TituloTabla1">Afiliaci&oacute;n salud </td>
	    <td class="TxtTabla">
        <select name="pCodItemSalud" class="CajaTexto" id="pCodItemSalud" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg7 = mssql_fetch_array($qr7))
			{
				$sel7 = "";
				if($reg7[codItem] == $pCodItemSalud)
				{
					$sel7 = "selected";
				}
				?>
	      <option value="<? echo $reg7[codItem]; ?>" <? echo $sel7; ?>><? echo $reg7[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Tiene limitaciones permanentes </td>
	    <td class="TxtTabla">
        <select name="pCodItemLimitaciones" class="CajaTexto" id="pCodItemLimitaciones" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg8 = mssql_fetch_array($qr8))
			{
				$sel8 = "";
				if($reg8[codItem] == $pCodItemLimitaciones)
				{
					$sel8 = "selected";
				}
				?>
	      <option value="<? echo $reg8[codItem]; ?>" <? echo $sel8; ?>><? echo $reg8[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  
	  <tr>
	    <td class="TituloTabla1">Mujer gestante</td>
	    <td class="TxtTabla">
        <select name="pCodItemMGestante" class="CajaTexto" id="pCodItemMGestante" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg9 = mssql_fetch_array($qr9))
			{
				$sel9 = "";
				if($reg9[codItem] == $pCodItemMGestante)
				{
					$sel9 = "selected";
				}
				?>
	      <option value="<? echo $reg9[codItem]; ?>" <? echo $sel9; ?>><? echo $reg9[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Mujer lactante</td>
	    <td class="TxtTabla">
        <select name="pCodItemMLactante" class="CajaTexto" id="pCodItemMLactante" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg10 = mssql_fetch_array($qr10))
			{
				$sel10 = "";
				if($reg10[codItem] == $pCodItemMLactante)
				{
					$sel10 = "selected";
				}
				?>
	      <option value="<? echo $reg10[codItem]; ?>" <? echo $sel10; ?>><? echo $reg10[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Programas institucionales</td>
	    <td class="TxtTabla">
        <select name="pCodItemPrograma" class="CajaTexto" id="pCodItemPrograma" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg11 = mssql_fetch_array($qr11))
			{
				$sel11 = "";
				if($reg11[codItem] == $pCodItemPrograma)
				{
					$sel11 = "selected";
				}
				?>
	      <option value="<? echo $reg11[codItem]; ?>" <? echo $sel11; ?>><? echo $reg11[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	  </tr>
	  
	  <? 
	  $sqlItem4 = $sqlItem." WHERE codOpcion=91";
	  $cursor4 = mssql_query($sqlItem4);
	  ?>
	  <tr>
	    <td class="TituloTabla1">Sabe leer y escribir</td>
	    <td class="TxtTabla">
        <select name="pCodItemLeer" class="CajaTexto" id="pCodItemLeer" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg12 = mssql_fetch_array($qr12))
			{
				$sel12 = "";
				if($reg12[codItem] == $pCodItemLeer)
				{
					$sel12 = "selected";
				}
				?>
	      <option value="<? echo $reg12[codItem]; ?>" <? echo $sel12; ?>><? echo $reg12[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Nivel educativo </td>
	    <td class="TxtTabla">
        <select name="pCodNivel" class="CajaTexto" id="pCodNivel" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg13 = mssql_fetch_array($qr13))
			{
				$sel13 = "";
				if($reg13[codItem] == $pCodNivel)
				{
					$sel13 = "selected";
				}
				?>
	      <option value="<? echo $reg13[codItem]; ?>" <? echo $sel13; ?>><? echo $reg13[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  
	  <tr>
	    <td class="TituloTabla1">Asiste a la escuela</td>
	    <td class="TxtTabla">
        <select name="pCodItemAsiste" class="CajaTexto" id="pCodItemAsiste" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg14 = mssql_fetch_array($qr14))
			{
				$sel14 = "";
				if($reg14[codItem] == $pCodItemAsiste)
				{
					$sel14 = "selected";
				}
				?>
	      <option value="<? echo $reg14[codItem]; ?>" <? echo $sel14; ?>><? echo $reg14[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	  </tr>
	  
	  <tr>
	    <td class="TituloTabla1">Instituci&oacute;n educativa a la que asiste</td>
	    <td class="TxtTabla">
        <select name="pCodInstitucion" class="CajaTexto" id="pCodInstitucion" style="width:350" >
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg15 = mssql_fetch_array($qr15))
			{
				$sel15 = "";
				if($reg15[codDepartamento] == $pCodInstitucion)
				{
					$sel15 = "selected";
				}
				?>
	      <option value="<? echo $reg15[codItem]; ?>" <? echo $sel15; ?>><? echo $reg15[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	  </tr>
	  
	  <tr> 
	    <td class="TituloTabla1">Ubicaci&oacute;n de la instituci&oacute;n educativa</td>
	    <td class="TxtTabla">
        <select name="pCodUbicacion" class="CajaTexto" id="pCodUbicacion" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg16 = mssql_fetch_array($qr16))
			{
				$sel16 = "";
				if($reg16[codItem] == $pCodMunicipioNace)
				{
					$sel16 = "selected";
				}
				?>
	      <option value="<? echo $reg16[codItem]; ?>" <? echo $sel16; ?>><? echo $reg16[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	  </tr>
	  	  
	  <tr>
	    <td class="TituloTabla1">Oficio, ocupaci&oacute;n o actividad econ&oacute;mica secundaria </td>
	    <td class="TxtTabla">
        <select name="pCodOficio" class="CajaTexto" id="pCodOficio" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg17 = mssql_fetch_array($qr17))
			{
				$sel17 = "";
				if($reg17[codMunicipio] == $pCodOficio)
				{
					$sel17 = "selected";
				}
				?>
	      <option value="<? echo $reg17[codItem]; ?>" <? echo $sel17; ?>><? echo $reg17[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Meses/a&ntilde;o dedicados a la actividad</td>
	    <td class="TxtTabla">
        <input name="pMActividades" type="text" class="CajaTexto" id="pMActividades" value="<? echo $pMActividades; ?>" size="50" onKeyPress="keyNum();" maxlength="4" />
        </td>
	    </tr>
	  <tr>
	    <td class="TituloTabla1">Ingreso mensual (en pesos) </td>
	    <td class="TxtTabla">
        <select name="pCodItemIngresoMensual" class="CajaTexto" id="pCodItemIngresoMensual" style="width:350">
          <option value="">:::Seleccione una opción:::</option>
	      <? 
			while($reg18 = mssql_fetch_array($qr18))
			{
				$sel18 = "";
				if($reg18[codItem] == $pCodItemIngresoMensual)
				{
					$sel18 = "selected";
				}
				?>
	      <option value="<? echo $reg18[codItem]; ?>" <? echo $sel18; ?>><? echo $reg18[nomItem]; ?></option>
	      <?
			}
			?>
	      </select></td>
	    </tr>
	 
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
    
	<!-- ESPACIO -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>&nbsp;</td>
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
</table>      
</body>
</html>

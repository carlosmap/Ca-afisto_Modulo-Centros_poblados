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

//Adición de un Registro de Formulario CSCP
//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSE.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

//Información Formulario
//dbo.CSCPFicha
//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	$hayFormulario = 0;
	
	//Verifica si el Numero de formulario existe  en el predio  
	$vSql=" SELECT count(numFormulario) existeForm FROM CSCPFicha ";
	$vSql=	$vSql . " WHERE codProyecto = ".$_SESSION["ccfProyecto"];
	$vSql=	$vSql . " AND codModulo = ".$_SESSION["ccfModulo"];
	$vSql=  $vSql . " AND numFormulario = '" . $noForm."'";
	$vCursor = mssql_query($vSql) ;
echo $vSql."<br>";
	if ($vReg=mssql_fetch_array($vCursor)) 
	{
		$hayFormulario = $vReg[existeForm] ;
	}

	if($hayFormulario > 0)
	{
		echo ("<script>alert('El Número del formulario ya existe. Por favor verifique la información');</script>");
	}
	else
	{
		//Inicio de Transacción
		$cursorTr = mssql_query("BEGIN TRANSACTION");
		
		//Adicionar un registro
		//dbo.CSCPFicha 	
		#	
		#	OSCAR LOPEZ
		#	IDENTIFICAR CONSECUTIVO DE CSCPFICHA
		$cFch=0;
		$sqlCon = "select MAX(consecutivo) cnc FROM CSCPFicha";
		$cCon = mssql_fetch_array( mssql_query( $sqlCon ) );
		if( $consecutivo[cnc] != 0 )
			$cFch = $cCon[cnc] + 1;
		else
			$cFch = 1;
		if( trim($mn) == "" )
			$mn = "00";
		$tm = $hr.":".$mn;#date("H:i:s");#$hr.":".$mn;

		################
		//codProyecto, codModulo, numFormulario, consecutivo, idCartografico, fechaTomaInf, horaInicio, codCatastral, segregacion, vivienda, hogar, 
		// identificaPredio, horaFinal, fechaVisita, numVisita, fileFicha, fechaGraba, usuarioGraba, fechaMod, usuarioMod

		$qry = "INSERT INTO CSCPFicha ( 
				codProyecto, codModulo, consecutivo, numFormulario, segregacion, vivienda, hogar, codCatastral, idCartografico, 
				horaInicio, fechaTomaInf, identificaPredio, fechaGraba, usuarioGraba )
				VALUES (";
		$qry = $qry.$_SESSION["ccfProyecto"].", ";	
		$qry = $qry.$_SESSION["ccfModulo"].", ";
		$qry = $qry.$cFch.", ";
		$qry = $qry."'".$noForm."', ";
		$qry = $qry."'".$Segregacion."', ";	#	SEGREGACION
		$qry = $qry."'".$vivienda."', ";	#	VIVIENDA
		$qry = $qry."'".$hogar."', ";	#	HOGAR
		if( trim($CodCatastro) == "" ) {
			$qry = $qry." NULL , ";	#	CODIGO CATATRAL
		}
		else {
			$qry = $qry."".$CodCatastro.", ";	#	CODIGO CATATRAL
		}
		$qry = $qry."'".$idcartografico."', ";	#	ID CARTOGRAFICO
		$qry = $qry."'".$tm."', ";
		$qry = $qry."'".$fechaTomaInf."', ";
		$qry = $qry."'".$noPredio."' , ";
		$qry = $qry."'".gmdate("n/d/y")."', ";
		$qry = $qry."'".$_SESSION["ccfUsuID"]."')";
		$cursorIn = mssql_query($qry) ;
echo $qry."<br />";
echo mssql_get_last_message()."<br /><br>";
	  	//Adicionar Registro automático del predio. aplica porque se estima una encuesta por predio
	  	//dbo.CSCPFichaPredio
		#	OSCAR LOPEZ
		#	IDENTIFICAR CONSECUTIVO DE FICHA PREDIO
		$sqlCFchPr = "select MAX(consecUbica) cnc FROM CSCPFichaPredio";
		$cncCFchPr = mssql_fetch_array( mssql_query( $sqlCFchPr ) );
		if( $cncCFchPr[cnc] != 0 )
			$cCFchPr += $cncCFchPr[cnc];
		else
			$cCFchPr = 1;
		###########################
		###
		$qry = "INSERT INTO CSCPFichaPredio ( nroPredio, nroObjeto, fechaGraba, usuarioGraba ) VALUES (";
		$qry = $qry . "'".$noForm . "',";
		$qry = $qry . "1, ";	// Predio = 1
		$qry = $qry .  "'". gmdate("n/d/y")."', " ;
		$qry = $qry .  "'".$_SESSION["ccfUsuID"]."')";
		$cursorIn2 = mssql_query($qry) ;

echo $qry."<br />";
		echo mssql_get_last_message()."<br /><br>";
#*/		
	  	//Adicionar Relación automática del predio. aplica porque se estima una encuesta por predio
	  	//dbo.CSCPFichavsPredio
		#	OSCAR LOPEZ
		#	IDENTIFICAR CONSECUTIVO DE FICHA PREDIO
		/*
		$sqlConFchPr = "select MAX(consecutivo) cnc FROM CSCPFichavsPredio";
		$cncFchPr = mssql_fetch_array( mssql_query( $sqlConFchPr ) );
		if( $consecutivo[cnc] != 0 )
			$cFchPr += $cncFchPr[cnc];
		else
			$cFchPr = 1;
		*/	
		###########################
		$qry = "INSERT INTO CSCPFichavsPredio (codProyecto, codModulo, consecutivo, numFormulario, nroPredio, fechaGraba, usuarioGraba) VALUES ( ";
		$qry = $qry . $_SESSION["ccfProyecto"].", ";
		$qry = $qry . $_SESSION["ccfModulo"].", ";
		//$qry = $qry . $cFchPr.", ";
		$qry = $qry . $cFch.", ";
		$qry = $qry . "'".$noForm."', ";
		$qry = $qry . "'".$noForm."', ";
		$qry = $qry.  "'". gmdate("n/d/y")."', " ;
		$qry = $qry.  "'".$_SESSION["ccfUsuID"]."' )";
		$cursorIn3 = mssql_query($qry) ;
	
		echo $qry."<br />";
		echo mssql_get_last_message()."<br />";
#*/
		if  ((trim($cursorIn) != "")  && (trim($cursorIn2) != "") && (trim($cursorIn3) != "")) 
		{
			//Se hace un commit para asegurar la transacción
			$curComm = mssql_query("COMMIT TRANSACTION");
			if(trim($curComm) != "")
			{
				echo ("<script>alert('La grabación se realizó con éxito.');</script>");
			}
		}
		else 
		{
			//Se deshacen todas las operaciones de la transacción
			$curRoll = mssql_query("ROLLBACK TRANSACTION");
			if(trim($curRoll) != "")
			{
				#echo mssql_get_last_message();
				echo ("<script>alert('Error en la operación');</script>");
			}
		}	
		/*
		echo "<script>
				window.close();
				MM_openBrWindow( 'frmCSCP.php', 'winCensos', 'toolbar=yes, scrollbars=yes, resizable=yes, width=960, height=700' );
			  </script>";
		#*/
	}
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
function envia2(){ 
	var v1,v2,v3, v4,v5,v6,v7,v8,v9,v10, v11, v12, v13, v14, v15, i, CantCampos, msg1, msg2, msg3, msg4, msg11, msg12, msg13, msg14, msg15, mensaje;
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
	v11='s';
	v12='s';
	v13='s';
	v14='s';
	v15='s';
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
	//	OSCAR LOPEZ
	//	VALIDAR SEGREGACION VIVIVENDA HOGAR
	v11 = v12 = v13 = 's';
	msg11 = msg12 = msg13 = '';
	
	mensaje = '';
	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	//	Valida hora
	if( document.getElementById('hr').value > 23 ) {
		v14 = 'n';
		msg14 = 'La hora no corresponde a la hora militar.\n';
	}
	if( document.getElementById('mn').value > 59 ) {
		v15 = 'n';
		msg15 = 'Sobre pasa los minutos.\n';
	}

	//preguntar();
	if(document.form1.fechaTomaInf.value == '')
	{
		v1 = 'n';
		msg1 = 'La fecha del formulario es obligatoria. \n';
	}
	
	if(document.form1.noForm.value == '')
	{
		v2 = 'n';
		msg2 = 'El número del formulario es obligatorio. \n';
	}
	//	OSCAR LOPEZ
	
	if(document.form1.noPredio.value == '')
	{
		v3 = 'n';
		msg3 = 'El número del predio es obligatorio. \n';
	}

	if( document.form1.idcartografico.value == ''  )
	{
		v4 = 'n';
		msg4 = 'El Id Cartografico es obligatorio. \n';
	}
	//	) || ( document.form1.idcartografico.value.length < 11 )
	if( document.form1.idcartografico.value.length < 11  )
	{
		v6 = 'n';
		msg6 = 'Debe tener 11 carateres el Id Cartografico. \n';
	}
	if(document.form1.hr.value == '')
	{
		v5 = 'n';
		msg5 = 'La hora es obligatoria. \n';
	}	
	
	//	FUNCIONANDO
	if(document.form1.Segregacion.value == '')
	{
		v11 = 'n';
		msg11 = 'El número de segregacion es obligatorio. \n';
	}
	if(document.form1.Segregacion.value.length == 1 )
	{
		v11 = 'n';
		msg11 = 'Debe tener una longitud de 2 caracteres la segregacion. \n';
	}
	
	if(document.form1.vivienda.value == '')
	{
		v12 = 'n';
		msg12 = 'El número de la vivienda es obligatoria. \n';
	}
	if(document.form1.vivienda.value.length == 1 )
	{
		v12 = 'n';
		msg12 = 'Debe tener una longitud de 2 caracteres la vivienda. \n';
	}
	
	if(document.form1.hogar.value == '')
	{
		v13 = 'n';
		msg13 = 'El número del hogar es obligatorio. \n';
	}
	if(document.form1.hogar.value.length == 1 )
	{
		v13 = 'n';
		msg13 = 'Debe tener una longitud de 2 caracteres el hogar. \n';
	}
	//	VALIDACIÓN DE SEGREGACION, VIVIENDA, HOGAR
	if(document.form1.Segregacion.value == '')
	{
		v11 = 'n';
		msg11 = 'La Segregacion es obligatoria. \n';
	}
	
	if(document.form1.vivienda.value == '')
	{
		v12 = 'n';
		msg12 = 'La Vivienda es obligatoria. \n';
	}
	
	if(document.form1.hogar.value == '')
	{
		v13 = 'n';
		msg13 = 'El Hogar es obligatorio. \n';
	}

	if ((v1=='s') && (v2=='s') && (v4=='s') && (v5=='s') &&
	    (v6=='s')&& (v7=='s')&& (v8=='s')&& (v9=='s')&& (v10=='s') && (v11=='s') && (v12=='s') && (v13=='s') && (v14=='s') && (v15=='s')) 
	{
		document.form1.recarga.value="2";		
		document.form1.submit();
	}
	else {
		mensaje = msg1 + msg2 + msg3 + msg4+msg5 + msg6 + msg7 + msg8+msg9 + msg10 + msg11 + msg12 + msg13 + msg14 + msg15;
		alert (mensaje);
	}

}
function keyNum(){ //	input
	if ( event.keyCode < 48 || event.keyCode > 57) 
		event.returnValue = false	
}

function igualar(){
	var idCarto;
	idCarto = document.getElementById('idcartografico').value;
	document.getElementById('noPredio').value = idCarto.substring(0,8);
}

function validaID(){
	if(document.getElementById('idcartografico').value.length >= 2 ){
		if (event.keyCode < 45 || event.keyCode > 57)
			event.returnValue = false; 	
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
    <!--TABLA INFORMACION -->         
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="2" class="TituloTabla">1. IDENTIFIACACION DEL FORMULARIO Y LOCALIZACI&Oacute;N</td>
        </tr>
    
      <tr>
          <td class="TituloTabla1"> <div align="left">Fecha de Toma de la Informaci&oacute;n<br>
              (mm/dd/aaaa)</div></td>
          <td width="73%" class="TxtTabla">
            <input name="fechaTomaInf" type="text" class="CajaTexto" id="fechaTomaInf" 
            value="<? echo $fechaTomaInf; ?>" size="15">&nbsp;<a href="javascript:cal.popup();"><img src="../images/cal.gif" alt="Calendario" width="16" height="16" border="0" ></a></td>
      </tr>  

      <tr>
        <td class="TituloTabla1">Hora Inicio</td>
        <td class="TxtTabla">
        <input name="hr" type="text" class="CajaTexto" id="hr" value="<?= $hr ?>"
            onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" size="5" maxlength="2" />
          :
          <input name="mn" type="text" class="CajaTexto" id="mn"  value="<?= $mn ?>"
            onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" size="5" maxlength="2" /></td>
      </tr>
      <tr>
        <td class="TituloTabla1">N&uacute;mero de Formulario</td>
        <td class="TxtTabla">
        <input name="noForm" type="text" class="CajaTexto" id="noForm"  value="<?= $noForm ?>"
            onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false; igualar();" size="30" maxlength="11"></td>
      </tr>
      <tr>
        <td class="TituloTabla1">IDCartografico</td>
        <td class="TxtTabla">
        <input name="idcartografico" type="text" class="CajaTexto" id="idcartografico"  value="<?= $idcartografico ?>"
            onKeyPress="validaID();" onChange="igualar();" size="30" maxlength="11"></td>
      </tr>
      <tr>
        <td class="TituloTabla1">N&uacute;mero de predio</td>
        <td class="TxtTabla"><!-- onClick="igualar();" -->
        	<input readonly name="noPredio" type="text" class="CajaTexto" id="noPredio"  value="<?= $noPredio ?>"
            	onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" size="30" >
        </td>
      </tr>
      <!--
      <tr>
        <td class="TituloTabla1">N&uacute;mero de Encuesta </td>
        <td class="TxtTabla">
          <input name="Formulario" type="text" class="CajaTexto" id="Formulario" 
            onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" size="30">
          </td>
      </tr>
       -->   
       <tr>
        <td class="TituloTabla1">C&oacute;digo Catastral </td>
        <td class="TxtTabla">
        <input name="CodCatastro" type="text" class="CajaTexto"  value="<?= $CodCatastro ?>" id="CodCatastro" maxlength="24" size="30"></td>
      </tr>  
      
      <tr>
        <td class="TituloTabla1">Segregaci&oacute;n</td>
        <td class="TxtTabla"><input  value="<?= $Segregacion ?>" name="Segregacion" type="text" class="CajaTexto" id="Segregacion" size="30" onKeyPress="keyNum()" maxlength="2" /></td>
      </tr>
      <tr>
        <td class="TituloTabla1">Vivienda</td>
        <td class="TxtTabla"><input  value="<?= $vivienda ?>" name="vivienda" type="text" class="CajaTexto" id="vivienda" size="30" onKeyPress="keyNum()" maxlength="2" /></td>
      </tr>
      <tr>
        <td class="TituloTabla1">Hogar</td>
        <td class="TxtTabla"><input  value="<?= $hogar ?>" name="hogar" type="text" class="CajaTexto" id="hogar" size="30" onKeyPress="keyNum()" maxlength="2" /></td>
      </tr>
    </table>

    <!--BOTONES -->   
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%">&nbsp;</td>
        <td align="right">
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
        <td class="copyr"> powered by INGETEC S.A - 2012</td>
      </tr>
    </table>	
	
    </td>
  </tr>
 </form>   
</table>

<script language="JavaScript">
		 var cal = new calendar2(document.forms['form1'].elements['fechaTomaInf']);
		 cal.year_scroll = true;
		 cal.time_comp = false;
</script>

</body>
</html>

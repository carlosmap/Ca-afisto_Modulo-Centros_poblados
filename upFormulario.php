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

//Abre la conexión a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

//1 Agosto de 2011
//Modificar y eliminar un Registro de Formulario CSCP

//Búsqueda de la información del formulario
//dbo.CSCPFicha
$sqlInf = "SELECT *
		   FROM CSCPFicha 
		   WHERE CSCPFicha.codProyecto =".$_SESSION["ccfProyecto"]."
		   AND CSCPFicha.codModulo     =".$_SESSION["ccfModulo"]."
		   AND CSCPFicha.numFormulario   ='".$e."'";
#echo $sqlInf."<br />";
$queryInf = mssql_query($sqlInf);
$infEncesta = mssql_fetch_array($queryInf);

//Búsqueda de la información del predio
//dbo.CSCPFichaPredio
$sqlInf2 = "SELECT fPredio.*
		   FROM CSCPFichaPredio fPredio, CSCPFichavsPredio fvPredio
		   WHERE 
		   fPredio.nroPredio = fvPredio.nroPredio AND
		   fvPredio.numFormulario = '".$e."'";

#echo $sqlInf2."<br />";
$queryInf2 = mssql_query($sqlInf2);
$infPredio = mssql_fetch_array($queryInf2);


if ($recarga==2) 
{
	//Inicio de Transacción
	$cursorTr = mssql_query("BEGIN TRANSACTION");
	if($accion==2)
	{			
		//Modifica el registro
		$qry = "UPDATE CSCPFicha SET ";
		$qry = $qry.  " segregacion = '".$Segregacion."',";
		$qry = $qry.  " vivienda = '".$vivienda."',";
		$qry = $qry.  " hogar = '".$hogar."',";
		$qry = $qry.  " idCartografico = '".$idcartografico."',";
		$qry = $qry.  " identificaPredio = '".$noPredio."',";
		if (trim($CodCatastro) == "") {
			$qry = $qry.  " codCatastral = NULL,";
		}
		else {
			$qry = $qry.  " codCatastral = '".$CodCatastro."',";
		}
		if( trim($mn) == "" )
			$mn = "00";
		$qry = $qry.  " horaInicio = '".$hr.":".$mn."',";
		$qry = $qry.  " fechaTomaInf = '".$fechaTomaInf."',";
		$qry = $qry.  " fechaMod = '". gmdate("n/d/y")."', " ;
		$qry = $qry.  " usuarioMod = '".$_SESSION["ccfUsuID"]."'";
		$qry = $qry.  " WHERE codProyecto = ".$_SESSION["ccfProyecto"];
		$qry = $qry.  " AND  codModulo = ".$_SESSION["ccfModulo"];	
		$qry = $qry.  " AND  numFormulario = '".$e."'";
		$cursorIn = mssql_query($qry) ;
		if  (trim($cursorIn) != "")  {
			//Se hace un commit para asegurar la transacción
			$curComm = mssql_query("COMMIT TRANSACTION");
			echo ("<script>alert('La Actualización se realizó con éxito.');</script>");
		} 
		else {
			//Se deshacen todas las operaciones de la transacción
			$curRoll = mssql_query("ROLLBACK TRANSACTION");
			echo ("<script>alert('Error durante la operación');</script>");
		};
		
	}
	#echo $qry."<br />".$qry2;
	if($accion==3)
	{
		//dbo.CSCPFichavsPredio
		//codProyecto, codModulo, nroEncuesta, nroPredio, fechaGraba, usuarioGraba, fechaMod, usuarioMod
		$qry2 = "DELETE FROM CSCPFichavsPredio ";
		$qry2 = $qry2 . " WHERE codProyecto= " .$_SESSION["ccfProyecto"];
		$qry2 = $qry2 . " AND codModulo= " .$_SESSION["ccfModulo"];
		$qry2 = $qry2 . " AND numFormulario= '" .$e."'";
		$qry2 = $qry2 . " AND nroPredio='".$e."'";
		$cursorIn = mssql_query($qry2) ;
		#echo $qry2."<br />";
		//dbo.CSCPFichaPredio
	  	//nroPredio, nroObjeto, fechaGraba, usuarioGraba
		$qry3 = "DELETE FROM CSCPFichaPredio ";
		$qry3 = $qry3 . " WHERE nroPredio= " .$e."";
		$qry3 = $qry3 . " AND nroObjeto= 1";
		$cursorIn = mssql_query($qry3) ;		
		#echo $qry3."<br />";
		#/*
		$qry3A = "DELETE FROM CSCPFicha
				WHERE codProyecto = ".$_SESSION["ccfProyecto"] ."
				AND codModulo = ".$_SESSION["ccfModulo"]."
				AND numFormulario='".$e."'";
		#echo $qry3A;
		$cursorIn = mssql_query($qry3A) ;	
		#*/
		if  (trim($cursorIn) != "") 
		{
			//Se hace un commit para asegurar la transacción
			$curComm = mssql_query("COMMIT TRANSACTION");
			echo ("<script>alert('La operación se realizó con éxito.');</script>");
		} 
		else 
		{
			//Se deshacen todas las operaciones de la transacción
			$curRoll = mssql_query("ROLLBACK TRANSACTION");
			echo ("<script>alert('El formulario tiene información asociada.');</script>");
		}
	
	}
	
	#/*	
	echo "<script>
			window.close();
			MM_openBrWindow( 'frmCSCP.php', 'winCensos', 'toolbar=yes, scrollbars=yes, resizable=yes, width=960, height=700' );
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
function mOvr(src,clrOver) {
    if (!src.contains(event.fromElement)) {
	  src.style.cursor = 'hand';
	  src.bgColor = clrOver;
	}
  }
  function mOut(src,clrIn) {
	if (!src.contains(event.toElement)) {
	  src.style.cursor = 'default';
	  src.bgColor = clrIn;
	}
  }
  function mClk(src) {
    if(event.srcElement.tagName=='TD'){
	  src.children.tags('A')[0].click();
    }
  }

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_validateForm() { //v4.0
  var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
  for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
    if (val) { nm=val.name; if ((val=val.value)!="") {
      if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
        if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
      } else if (test!='R') { num = parseFloat(val);
        if (isNaN(val)) errors+='- '+nm+' debe ser numérico.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es obligatorio.\n'; }
  } if (errors) alert('Validación:\n'+errors);
  document.MM_returnValue = (errors == '');
}

function envia2(){ 
var v1,v2,v3, v4,v5,v6,v7,v8,v9, v10, v11, v12, v13, i, CantCampos, msg1, msg2, msg3, msg4, msg11, msg12, msg13, mensaje;
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
mensaje = '';
//if (document.getElementById('Formulario').disabled == true ){	
	if( document.getElementById('hr').value > 23 ) {
		v5 = 'n';
		msg5 = 'La hora no corresponde a la hora militar.\n';
	}
	if( document.getElementById('mn').value > 59 ) {
		v4 = 'n';
		msg4 = 'Sobre pasa los minutos.\n';
	}
	//	Verificar fecha correcta
	if (document.form1.Formulario.value == '')  
	{
		v1='n';
		msg1 = 'El Número del formulario es obligatorio. \n'
	}
	if (document.form1.fechaTomaInf.value == '') 
	{
		v2='n';
		msg2 = 'La fecha es Obligatoria. \n'
	}
	//	
	if( document.form1.idcartografico.value.length < 11  )
	{
		v6 = 'n';
		msg6 = 'Debe tener 11 carateres el Id Cartografico. \n';
	}
	if( document.form1.idcartografico.value == "")
	{
		v6 = 'n';
		msg6 = 'Debe ingresar el Id Cartografico. \n';
	}
	//	FUNCIONANDO
	if(document.form1.Segregacion.value == ''){
		v11 = 'n';
		msg11 = 'El número de segregacion es obligatorio. \n';
	}
	if(document.form1.Segregacion.value.length == 1 ){
		v11 = 'n';
		msg11 = 'Debe tener una longitud de 2 caracteres la segregacion. \n';
	}
	
	if(document.form1.vivienda.value == '')
	{
		v12 = 'n';
		msg12 = 'El número de la vivienda es obligatoria. \n';
	}
	if(document.form1.vivienda.value.length == 1 ){
		v12 = 'n';
		msg12 = 'Debe tener una longitud de 2 caracteres la vivienda. \n';
	}
	
	if(document.form1.hogar.value == ''){
		v13 = 'n';
		msg13 = 'El número del hogar es obligatorio. \n';
	}
	if(document.form1.hogar.value.length == 1 ){
		v13 = 'n';
		msg13 = 'Debe tener una longitud de 2 caracteres el hogar. \n';
	}
	//	VALIDACIÓN DE SEGREGACION, VIVIENDA, HOGAR	
//}
//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s') && (v5=='s') &&
	    (v6=='s')&& (v7=='s')&& (v8=='s')&& (v9=='s') && (v10=='s')  && (v11=='s')  && (v12=='s')  && (v13=='s')) 
	{	document.form1.recarga.value="2";
		document.form1.submit();
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 + msg4 + msg5 + msg6 + msg7 + msg8 + msg9 + msg10 + msg11 + msg12 + msg13;
		alert (mensaje);
	}	
}
function eliminar(){
	document.form1.recarga.value="2";
	document.form1.submit();
}
function igualar(){
	var idCarto;
	idCarto = document.getElementById('idcartografico').value;
	document.getElementById('noPredio').value = idCarto.substring(0,8);
}

function MM_callJS(jsStr) { //v2.0
  return eval(jsStr)
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#00344C">
  <tr>
    <td><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
        
        	  
         
<form action="" method="post" name="form1" onSubmit="MM_validateForm('fechaTomaInf','','R','Formulario','','RisNum');return document.MM_returnValue">
    <!--TITULO -->
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	  <tr>
            <td colspan="2" class="TituloTabla">1. IDENTIFIACACION DEL FORMULARIO Y LOCALIZACI&Oacute;N</td>
        </tr>
		
    	<tr>
    	  <td class="TituloTabla1"> <div align="left">Fecha de Toma de la Informaci&oacute;n<br>
    	    (mm/dd/aaaa)</div></td>
    	  <td width="73%" class="TxtTabla">
    	    <input name="fechaTomaInf" type="text" class="CajaTexto" id="fechaTomaInf" 
              value="<? echo date("m/d/Y ", strtotime($infEncesta[fechaTomaInf]));?>" size="15" <? if ($accion==3){  echo "disabled"; }?>>
    	    &nbsp;<a href="javascript:cal.popup();"><img src="../images/cal.gif" alt="Calendario" width="16" height="16" border="0" ></a></td>
  	  </tr>

		<tr>
		  <td class="TituloTabla1">Hora Inicio</td>
		  <td class="TxtTabla">
          <?php
		  	$tm = explode( ":", $infEncesta[horaInicio] )
		  ?>
          <input name="hr" type="text" class="CajaTexto" id="hr" value="<?= $tm[0] ?>" 
            onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" size="5" maxlength="2" <? if ($accion==3){  echo "disabled"; }?> />
:
  <input name="mn" type="text" class="CajaTexto" id="mn" value="<?= $tm[1] ?>"  
            onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" size="5" maxlength="2" <? if ($accion==3){  echo "disabled"; }?> /></td>
		  </tr>
		<tr>
		  <td class="TituloTabla1">N&uacute;mero de Formulario </td>
		  <td class="TxtTabla"><input name="Formulario" type="text" disabled class="CajaTexto" id="Formulario" 
                onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<? echo $infEncesta[numFormulario];?>" size="30" /></td>
		  </tr>
		<tr>
		  <td class="TituloTabla1">IDCartografico</td>
		  <td class="TxtTabla">
          <input name="idcartografico" type="text" class="CajaTexto" id="idcartografico" value="<? echo $infEncesta[idCartografico];?>" onChange="igualar();" 
            onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false; igualar();" size="30" maxlength="11" <? if ($accion==3){  echo "disabled"; }?>>
            </td>
		  </tr>
		<tr>
		  <td class="TituloTabla1">N&uacute;mero de predio</td>
		  <td class="TxtTabla">
          <input name="noPredio" type="text" class="CajaTexto" id="noPredio" value="<? echo $infEncesta[identificaPredio];?>" readonly 
            	onKeyPress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" size="30" <? if ($accion==3){  echo "disabled"; }?> />
          </td>
		  </tr>

		<tr>
		  <td class="TituloTabla1">C&oacute;digo Catastral </td>
		  <td class="TxtTabla"><input name="CodCatastro" type="text" class="CajaTexto" id="CodCatastro" value="<? echo $infEncesta[codCatastral];?>" size="30"  <? if ($accion==3){  echo "disabled"; }?> maxlength="24" /></td>
		  </tr>        		
		<tr>
			<td class="TituloTabla1">Segregacion</td>
			<td class="TxtTabla">
            <input name="Segregacion" type="text" class="CajaTexto" id="Segregacion" value="<? echo $infEncesta[segregacion];?>" size="30"  <? if ($accion==3){  echo "disabled"; }?> maxlength="2"></td>
        </tr>
		<tr>
		  <td class="TituloTabla1">Vivienda</td>
		  <td class="TxtTabla">
          <input name="vivienda" type="text" class="CajaTexto" id="vivienda" size="30" value="<? echo $infEncesta[vivienda];?>" <? if ($accion==3){  echo "disabled"; }?> maxlength="2" />
          </td>
		  </tr>
		<tr>
		  <td class="TituloTabla1">Hogar</td>
		  <td class="TxtTabla">
          <input name="hogar" type="text" class="CajaTexto" id="hogar" value="<? echo $infEncesta[hogar];?>" size="30" <? if ($accion==3){  echo "disabled"; }?> maxlength="2" />
          </td>
		  </tr>
   </table>
  
   <!-- BOTONES-->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="e" type="hidden" id="e" value="<? echo $e; ?>">
			<input name="recCodCatastroarga" type="hidden" id="recCodCatastroarga3" value="1">
			<input name="noPrediodel" type="hidden" id="noPrediodel" value="<?= $infEncesta[nroPredio] ?>">
			<input name="recarga" type="hidden" id="recCodCatastroarga" value="1">
			<!--
            <input name="Submit" type="submit" class="Boton"  
			value="<? if ($accion==3) { echo "Borrar"; } else { echo "Grabar"; } ?>" <? if ($accion==3) { ?> onClick="envia2()" <? }  ?> >
            -->
			<? if ($accion==3)
		   	{ ?>            
            <input name="Submit" type="submit" class="Boton"  value="Borrar" onClick="eliminar()" >

             
            <input name="Cancelar" type="button" class="Boton" id="Cancelar" 
				 onClick="MM_callJS('window.close();')" value="Cancelar">
			<? 
			} 
			else{
			?>	
            <input name="Submit" type="submit" class="Boton"  
			value="Grabar" onClick="envia2()" >
            <? }	?>            </td>
      </tr>
    </table>

	</form>    
  </td>
</tr>
    </table>
    
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
	        <td>&nbsp;</td>
        </tr>
    </table>

    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="copyr"> powered by INGETEC S.A - 2012</td>
      </tr>
    </table>	
    </td>
  </tr>
</table>

<script language="JavaScript">
		 var cal = new calendar2(document.forms['form1'].elements['fechaTomaInf']);
		 cal.year_scroll = true;
		 cal.time_comp = false;
</script>

</body>
</html>

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
	$error = 0;
	$tm = 0;
	while( $tm < 7 ){
		$tm++;
		#	  
		$localidad = "localidad".$tm;
		$frecuencia = "sFrecuencia".$tm;
		$desplamiento = "desplaza".$tm;
		$tmItem = "tm".$tm;
		if( ${$localidad} != "" ){
			$qry = "INSERT INTO CSCPFichaFamiliaComunidad
					( 
						codProyecto, codModulo, numFormulario, consecutivo, nroPredio, nroVivienda, nroFamilia
						, codItemComunidad, localidad, codSubItemFrecuencia, medioDesplaza, fechaGraba, usuarioGraba )";	
			$qry = $qry. " VALUES( ";
			$qry = $qry. "'".$_SESSION["ccfProyecto"]."', ";
			$qry = $qry. "'".$_SESSION["ccfModulo"]."', ";
			$qry = $qry. "'".$_SESSION["ccfFormulario"]."', ";
			$qry = $qry. "'".$_SESSION["ccfConsecutivo"]."', ";
			$qry = $qry. "'".$_SESSION["ccfPredio"]."', ";
			$qry = $qry. "'".$_SESSION["ccfVivienda"]."', ";
			$qry = $qry. "'".$_SESSION["ccfFamilia"]."', ";
			$qry = $qry. ${$tmItem}.", ";
			$qry = $qry. "'".${$localidad}."', ";
			$qry = $qry. ${$frecuencia}.", ";
			$qry = $qry. "'".${$desplamiento}."', ";
			$qry = $qry. " '" . gmdate("n/d/y") ."', ";
			$qry = $qry. " '".$_SESSION["ccfUsuID"]."') " ;	
//echo $qry."<br />".mssql_get_last_message()."<br>";
			//exit;
			$cursorIn = mssql_query( $qry );
			if( trim($cursorIn) == "" )
				$error = 1;
		}
	}
	if  ( $error == 0 )  
			echo ("<script>alert('La grabación se realizó con éxito.');</script>");
	else 
		echo ("<script>alert('Error durante la grabación');</script>");

	$volverA = "";
	$volverA=Genera_Pagina($Opc,$pag);	
	#/*

	echo "<script>
			window.close();
			MM_openBrWindow('frmCensoFamiliaCultural.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
		  </script>";
	#*/
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
window.name = 'fchFmlaComunidad';
//-->
</script>

<SCRIPT language=JavaScript>
<!--

function envia2(){ 
	var v1,v2,v3, i, msg1, msg2, msg3, mensaje;
	v1='n';
	v2='n';
	v3='n';
	msg1 = 'El desplazamiento es obligatorio. \n';
	msg2 = 'La localidad es obligatoria. \n';
	msg3 = 'La frecuencia es obligatoria. \n';
	mensaje = '';
	for( i = 1; i <= 7; i++ ){
		if( document.getElementById( 'desplaza' + i ).value != "" ){
			v1='s';
			msg1 = ''
			//	nuevo
			if( document.getElementById( 'localidad' + i ).value != "" ){
				v2='s';
				msg2 = ''
			}//
			
			if( document.getElementById( 'sFrecuencia' + i ).value != "" ){
				v3='s';
				msg3 = ''
			}
		}
	}
	
	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') ) 
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
	<? 
		#	Búsqueda de los ítems para cada pregunta
		#	Frecuencia
		$sqlIt = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 205";
		$qr = mssql_query( $sqlIt );		
	?>
	<!-- Tabla de datos -->
	<!-- ESPACIO -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
        <tr>
            <td height="10"><table width="100%">
              <tr class="TituloUsuario">
                <td colspan="4" align="center" class="TituloTabla">Tipo de relaci&oacute;n con otras comunidades</td>
              </tr>
              <tr class="TituloTabla">
                <td width="25%"></td>
                <td width="25%">Localidad</td>
                <td width="25%">Frecuencia</td>
                <td width="25%">En que se desplaza</td>
              </tr>
              <?
				$sqlItem = "select * from tmItems where codOpcion = 85";
				$qryItem = mssql_query( $sqlItem );
				$r = 0;
				while( $rwItem = mssql_fetch_array( $qryItem ) ){
					$r++;
			?>
              <tr>
                <td width="25%" class="TituloTabla">
				<?= $rwItem[nomItem]?>
                <input type="hidden" name="tm<?= $r ?>" id="tm<?= $r ?>" value="<?= $rwItem[codItem] ?>" />
                </td>
                <td width="25%" class="TxtTabla"><input name="localidad<?= $r ?>" type="text" class="CajaTexto" id="localidad<?= $r ?>" onKeyPress="keyLetter();" /> </td> 
                <td width="25%" class="TxtTabla">
                <select name="sFrecuencia<?= $r ?>" id="sFrecuencia<?= $r ?>" class="CajaTexto">
                <option value="">:::Escoga una opción:::</option>
                <?	while( $rwItemS = mssql_fetch_array( $qr ) ){	?>
                	<option value="<?=	$rwItemS[codItem] ?>"><?=	$rwItemS[nomItem] ?></option>
                <?	
					}	
					#	Devuelve el indice de la consulta al inicial.
					mssql_data_seek( $qr, 0 );
				?>
                </select>
                </td>
                <td width="25%" class="TxtTabla"><input name="desplaza<?= $r ?>" type="text" class="CajaTexto" id="desplaza<?= $r ?>" onKeyPress="keyLetter()" /></td>
              </tr>
              <?	}	?>
              </table>
              </td>
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

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


//Búsqueda de la secuencia máxima de las fotos
$sqlMaxSec = "SELECT MAX(consecAnexo) maxSec
			  FROM CSCPFichaAnexos
			  WHERE codProyecto=".$_SESSION["ccfProyecto"]."
			  AND codModulo=".$_SESSION["ccfModulo"]."
			  AND numFormulario='".$_SESSION["ccfFormulario"]."'";
$cursorMaxSec = mssql_query($sqlMaxSec);
#echo $sqlMaxSec;
if($regMaxSec = mssql_fetch_array($cursorMaxSec))
{
	$numeroFoto = $regMaxSec[maxSec] + 1;
}
else
{
	$numeroFoto = 1;
}	

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{

//Carga del archivo
//--------------------------------
//Hace el upload del archivo de la foto
	if (trim($archivoFoto_name) != "")	
	{
		$extension = explode(".",$archivoFoto_name);
		$num = count($extension)-1;
		//echo "Archivo Foto: ".$archivoFoto . "<br>" ;
		//echo "Archivo Foto - Nombre: ".$archivoFoto_name . "<br>" ;
		$nomArchivo= $_SESSION['ccfProyecto']."-".$_SESSION['ccfModulo']."-".$_SESSION['ccfFormulario']."-".$numeroFoto."-".date('dmY').".".$extension[$num] ;
		if ( ( $extension[$num] == "pdf" ) OR ( $extension[$num] == "PDF" ) OR ($extension[$num] == "gif") OR ($extension[$num] == "GIF") OR ($extension[$num] == "jpg") OR ($extension[$num] == "JPG") ) 
		{
			if($archivoFoto_size < 100000000) 
			{
				if (!copy($archivoFoto, "regAnexos/".$nomArchivo)) 
				{
					$copioarchivoFoto = "NO";
					echo "Error al copiar el archivo";
					$msj = "Error al copiar el archivo";
				}
				else 
				{
					$copioarchivoFoto = "SI";
					echo "Archivo se copió en el servidor con exito";
				}
			}
			else 
			{
				$copioarchivoFoto = "NO";
				echo "El archivo supera los 1000kb";
				$msj = "El archivo supera los 1000kb";
			}
		}
		else 
		{
			$copioarchivoFoto = "NO";
			echo "El formato de archivo no es valido. Solo .pdf";
			$msj = "El formato de archivo no es valido. Solo .pdf";
		}
	}//cierra if(trim($archivoFoto_name)!="")

	$imagen="regAnexos/".$nomArchivo;
	$imagenAsociada=$nomArchivo;
	//$imagenAsociada="p".$nomArchivo;
	
	//--------------------------------------	

	//Inserta la información del registro fotográfico
	if ($copioarchivoFoto != "NO")
	{
		$qry = " INSERT INTO CSCPFichaAnexos(codProyecto, codModulo, consecutivo, numFormulario, consecAnexo, codItemTipoAneco, cuales, fileAnexos, fechaGraba, usuarioGraba) ";
		$qry = $qry . " VALUES ( ";
		$qry = $qry . " " . $_SESSION["ccfProyecto"] . ", ";
		$qry = $qry . " " . $_SESSION["ccfModulo"] . ", ";
		$qry = $qry . " " . $_SESSION["ccfConsecutivo"] . ", ";
		$qry = $qry . " '" . $_SESSION["ccfFormulario"] . "', ";
		$qry = $qry . " " . $numeroFoto .", ";
		$qry = $qry . " " . $documento .", ";
		$qry = $qry . " '" . $txtOb ."', ";
		if(trim($archivoFoto_name) != "")
		{
			$qry = $qry . " '" . $nomArchivo . "', ";
		}
		else{
			$qry = $qry . " NULL, ";
		}
		$qry= $qry. " '" . gmdate("n/d/y") ."', ";
		$qry= $qry. " '" . $_SESSION["ccfUsuID"] ."' ";
		$qry = $qry . " ) ";		#echo "<br />".$qry;
		//exit;
		$cursorIn = mssql_query($qry) ;
	}//cierra if($copioarchivoFoto!="NO")
	
	if  (trim($cursorIn) != "") {
		echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
	} 
	else {
		echo ("<script>alert('Error durante la grabación. $msj');</script>");
	};
	
	#/*
	echo "<script>			
			window.close();
			MM_openBrWindow('frmCensoAnexos12.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
		  </script>";
	#*/


}

?>


<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Sogamozo :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" src="calendar.js"></script>

<SCRIPT language=JavaScript>
<!--
function envia1(){ 
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

	if (document.form1.documento.value == '') {
		v2='n';
		msg2 = 'Por favor seleccione el tipo de documento. \n'
	}
	//Valida que el campo Archivo de la Foto
	if (document.form1.archivoFoto.value == '') {
		v2='n';
		msg2 = msg2+'El archivo de la foto es un dato obligatorio. \n'
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
        if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
  } if (errors) alert('The following error(s) occurred:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
<form action="" method="post" enctype="multipart/form-data" name="form1" >
  <tr>
    <td>
	
	<!-- Título Principal -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla">.: Registro Fotogr&aacute;fico </td>
      </tr>
    </table>
	
	<!-- Título 2 -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla2">Registro fotogr&aacute;fico </td>
      </tr>
    </table>
	
	<!-- Grabar Foto -->
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <? //Búsqueda de los elementos fotografiados
	  $sqlElem = "SELECT * FROM tmItems
	  			  WHERE codOpcion = 114";
	  $cursorElem = mssql_query($sqlElem);
	  ?>
	  <tr>
	    <td class="TituloTabla2">Fotocopia de documento de identidad</td>
	    <td class="TxtTabla"><?
			$sql = "Select * from tmItems Where codOpcion = 129 and codItem < 669";
			$qry = mssql_query( $sql );
		?>
	      <select name="documento" id="documento" class="CajaTexto">
	        <option value="" >:::Seleccione el documento:::</option>
	        <?	while( $rw = mssql_fetch_array( $qry ) ){	?>
	        <option value="<?= $rw[codItem]?>">
	          <?= $rw[nomItem]?>
	          </option>
	        <?	}	?>
	        </select></td>
	    </tr>
	  <tr>
	    <td class="TituloTabla2">N&uacute;mero de registro </td>
	    <td class="TxtTabla"><input name="numeroRegistro" type="text" class="CajaTexto" id="numeroRegistro" value="<? echo $numeroFoto; ?>" size="30" readonly></td>
	    </tr>
	  <tr>
	    <td valign="top" class="TituloTabla2"><?
			$sql = "Select * from tmItems Where codItem = 669";
			$qry = mssql_fetch_array( mssql_query( $sql ) );
			echo $qry[nomItem];
		?></td>
	    <td class="TxtTabla"><textarea name="txtOb" id="txtOb" cols="70" rows="10" class="CajaTexto"></textarea></td>
	    </tr>
	  
	  <? //Búsqueda de los aspectos registrados
	  $sqlAsp = "SELECT nomSubItem, codSubItem  FROM tmSubItems WHERE codOpcion = 114";
	  $cursorAsp = mssql_query($sqlAsp);
	  ?>
      <tr>
        <td width="25%" class="TituloTabla2">Archivo de la Foto </td>
        <td class="TxtTabla"><input name="archivoFoto" type="file" class="CajaTexto" id="archivoFoto" size="55"></td>
      </tr>
    </table>
	
	
	<!-- Botones -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<input name="recarga" type="hidden" id="recarga" value="1">
		<input name="esGrupo" type="hidden" value="0">
		<input name="Submit2" type="button" class="Boton" value="Grabar" onClick="envia2()">
        </td>
      </tr>
    </table>
	
	<!-- Espacio -->
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
</form>  
</table>

</body>
</html>

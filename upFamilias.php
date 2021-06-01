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
//echo "<br>".$sqlPC01." -- ".mssql_get_last_message()."<br><br>";

//Búsqueda de la unidad social de la familia
$sqlUn = "SELECT * FROM CSCPFichaFamilia
		  WHERE nroFamilia=".$f;
$cursorUn = mssql_query($sqlUn);
$regUn = mssql_fetch_array($cursorUn);
$unSocial = $regUn[unidadSocial];
$nroFamilia= $regUn[nroFamilia];

//echo "<br>".$sqlUn." -- ".mssql_get_last_message()."<br><br>";

$dis = "";
if($accion==3)
{
	$dis = "disabled";
}

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	if($accion==2)
	{
		$sqlDel4 = "UPDATE CSCPFichaFamilia SET
					unidadSocial='".$Unidad_C."',
					fechaMod='".gmdate("n/d/y")."',
					usuarioMod='".$_SESSION["ccfUsuID"]."'
					WHERE nroFamilia=".$f;
		$cursorDel4 = mssql_query($sqlDel4);
	}
//echo "<br>".$sqlPC01." -- ".mssql_get_last_message()."<br><br>";
	
	if($accion==3)
	{
		//Elimina los integrantes relacionados a la familia
		$sqlDel = "DELETE FROM CSCPFichaIntegrantesFamilia
				   WHERE nroFamilia=".$f;
		$cursorDel = mssql_query($sqlDel);
//echo "<br>".$sqlDel." -- ".mssql_get_last_message()."<br><br>";
/*		
		if(trim($cursorDel)!="")
		{
			//Elimina la información de actividad agropecuaria de la familia
			$sqlDel1 = "DELETE FROM CSCPFichaActividadAgroFamilia
					   WHERE nroFamilia=".$f;
			$cursorDel1 = mssql_query($sqlDel1);
		}
		
		if(trim($cursorDel1)!="")
		{
			//Elimina la información de las apropiaciones de la familia
			$sqlDel2 = "DELETE FROM CSCPFichaApropiacion
					   WHERE nroFamilia=".$f;
			$cursorDel2 = mssql_query($sqlDel2);
		}
		
		if(trim($cursorDel2)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaViviendavsFamilia
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   AND nroFamilia=".$f;
			$cursorDel3 = mssql_query($sqlDel3);
		}
		
		if(trim($cursorDel3)!="")
		{
			//Elimina la familia
			$sqlDel4 = "DELETE FROM CSCPFichaFamilia
					   WHERE nroFamilia=".$f;
			$cursorDel4 = mssql_query($sqlDel4);
		}
*/

		if(trim($cursorDel)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaIndustrialMaq
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel12 = mssql_query($sqlDel3);
		}
		if(trim($cursorDel12)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaIndustrial
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel11 = mssql_query($sqlDel3);
		}
		if(trim($cursorDel11)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaExtractiva
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel10 = mssql_query($sqlDel3);
		}
		if(trim($cursorDel10)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaMorbilidad
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel9 = mssql_query($sqlDel3);
		}
 
		if(trim($cursorDel9)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaPecuaria
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel8 = mssql_query($sqlDel3);
		}

		if(trim($cursorDel8)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaComunidad
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel7 = mssql_query($sqlDel3);
		}

		if(trim($cursorDel7)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaPescaTemp
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel6 = mssql_query($sqlDel3);
		}

		if(trim($cursorDel6)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaPesca
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel5 = mssql_query($sqlDel3);
		}

		if(trim($cursorDel5)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaFamiliaComercial
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel4 = mssql_query($sqlDel3);
		}

		if(trim($cursorDel4)!="")
		{
			//Elimina la relación entre la vivienda y la familia
			$sqlDel3 = "DELETE FROM CSCPFichaViviendavsFamilia
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroVivienda='".$_SESSION["ccfVivienda"]."'
					   and consecutivo='".$_SESSION["ccfConsecutivo"]."' 
					   and nroPredio='".$_SESSION["ccfPredio"]."' 
					   AND nroFamilia=".$f;
			$cursorDel3 = mssql_query($sqlDel3);
		}
//echo "<br>".$sqlDel3." -- ".mssql_get_last_message()."<br><br>";
		if(trim($cursorDel3)!="")
		{
			//Elimina la familia
			$sqlDel4 = "DELETE FROM CSCPFichaFamilia
					   WHERE nroFamilia=".$f;
			$cursorDel4 = mssql_query($sqlDel4);
		}
//echo "<br>".$sqlDel4." -- ".mssql_get_last_message()."<br><br>";
	}//cierra if($accion==3)
	
	if(trim($cursorDel4)!="")
	{
		echo ("<script>alert('La operación se realizó con éxito.');</script>");
	}
	else{
		echo ("<script>alert('Error en la operación');</script>");
	}

	echo ("<script>window.close();MM_openBrWindow('frmCensoFamilias.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");

}

?>


<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto  :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" src="calendar.js"></script>
<SCRIPT language=JavaScript>
<!--
function envia2(){ 
var v1,v2,v3, v4,v5,v6,v7,v8,v9,v10, i, CantCampos, msg1, msg2, msg3, msg4, mensaje;
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
mensaje = '';
//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar

	//preguntar();

	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s') && (v5=='s') &&
	    (v6=='s')&& (v7=='s')&& (v8=='s')&& (v9=='s')&& (v10=='s')) 
	{
		document.form1.recarga.value="2";		
		document.form1.submit();
	}
	else {
		mensaje = msg1 + msg2 + msg3 + msg4+msg5 + msg6 + msg7 + msg8+msg9 + msg10;
		alert (mensaje);
	}
	
}

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
        <tr>
          <td colspan="2" class="TituloTabla">::: HOGAR CENSAL </td>
        </tr>
        <tr>
          <td width="25%" class="TituloTabla1">N&uacute;mero de Encuesta </td>
          <td class="TxtTabla"><? echo $_SESSION["ccfFormulario"]; ?></td>
        </tr>
        <tr>
          <td width="25%" class="TituloTabla1">N&uacute;mero de Predio </td>
          <td class="TxtTabla"><? echo $_SESSION["ccfPredio"]; ?></td>
        </tr>
        <tr>
          <td width="25%" class="TituloTabla1">N&uacute;mero de Vivienda </td>
          <td class="TxtTabla"><? echo $_SESSION["ccfVivienda"]; ?></td>
        </tr>
        <tr>
          <td class="TituloTabla1">N&uacute;mero del hogar</td>
          <td class="TxtTabla"><? echo $nroFamilia; ?></td>
        </tr>

        <tr>
          <td width="25%" class="TituloTabla1"><div align="left">Unidad Social </div></td>
          <td class="TxtTabla">
            <input name="Unidad_C" type="text" class="CajaTexto" id="Unidad_C"  value="<? echo $unSocial; ?>" <? echo $dis;?> readonly >
           </td>
      </tr>  
<? if($accion == 3){
?>
	  <tr>
			<td colspan="2" class="TituloTabla2">NOTA: Al eliminar el hogar, se eliminará todo el contenido asociado. <br>¿Realmente desea eliminar el hogar?</td>
	</tr>
<?					} ?>
    </table>

    <!--BOTONES -->   
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%">&nbsp;</td>
        <td align="right">
          <input name="recarga" type="hidden" id="recarga" value="1">    
		  <? if($accion == 2){ $txt = "Grabar";}
		  	if($accion == 3){ $txt = "Eliminar";}?>   
          <input name="Submit2" type="button" class="Boton" value="<? echo $txt; ?>" onClick="envia2()">
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
</body>
</html>

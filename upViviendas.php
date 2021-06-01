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
//Adición de un Registro de Vivienda
//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
include('../enlaceBD.php');

//Libreria de Funciones
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

//consulta la unidad censal de la vivenda
$sql_uni="select * from  CSCPFichaVivienda where nroVivienda=".$v;
$cur_uni=mssql_query($sql_uni);
$datos_uni=mssql_fetch_array($cur_uni);
$unidad=$datos_uni["unidadCensal"];

//Trae la información del Modulo
//dbo.tmModulos
//codModulo, nomModulo, siglaModulo, fechaGraba, usuarioGraba, fechaMod, usuarioMod
$sqlPC01="SELECT * FROM tmModulos WHERE codModulo= " .$_SESSION["ccfModulo"] ; 
$cursorPC01 = mssql_query($sqlPC01) ;
if ($regPC01=mssql_fetch_array($cursorPC01)) 
{
	$proyModulo=$regPC01[nomModulo];
}

$dis = "";
if($accion==3)
{
	$dis = "disabled";
}
//$accion=3;

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	$cur_tran=mssql_query("BEGIN TRANSACTION");

	if($accion==2)
	{
		$sql_up="update  CSCPFichaVivienda set unidadCensal='".$Unidad."' where nroVivienda=".$v;
		$cursor_up = mssql_query($sql_up);
	}
	if($accion==3)
	{
		//consulta si la vivienda tiene familias asociadas, si es asi, no permitira eliminar la vivienda
		$sql_fam="select COUNT(*) as cant_fam from CSCPFichaViviendaVsFamilia where nroVivienda=".$v;
		$sql_fam=$sql_fam."  and codProyecto=".$_SESSION["ccfProyecto"]."
				   AND codModulo=".$_SESSION["ccfModulo"]."
				   AND nroPredio='".$_SESSION["ccfPredio"]."'
				   AND numFormulario='".$_SESSION["ccfFormulario"]."'
				   AND nroVivienda='".$v."'
				   AND consecutivo='".$_SESSION["ccfConsecutivo"]."'";


		$cur_fam=mssql_query($sql_fam);
//echo 	$sql_fam." ---- $cur_fam ******* ".mssql_get_last_message()."<br>";
		$datos_fam=mssql_fetch_array($cur_fam);
		if($datos_fam["cant_fam"]!=0)//si se encontraron registros
		{
				$cur_tran=mssql_query("ROLLBACK TRANSACTION");
				echo ("<script>alert('No se puede eliminar la vivienda por que contiene hogares asociados.');</script>");
				$volverA = "";
//				$volverA=Genera_Pagina($Opc,$pag);		
				echo ("<script>window.close();MM_openBrWindow('frmCensoVivienda03.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");

				exit();			
		}

		if(trim($cur_fam)!="")
		{
			$sqlDel = "DELETE FROM CSCPFichaViviendavsFamilia
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroPredio='".$_SESSION["ccfPredio"]."'
					   AND consecutivo='".$_SESSION["ccfConsecutivo"]."'
					   AND nroVivienda='".$v."'";
			$cursorDel = mssql_query($sqlDel);
		}
//echo 	$sqlDel." ---- $cursorDel ******* ".mssql_get_last_message()."<br>";		
		if(trim($cursorDel)!="")
		{
			$sqlDel1 = "DELETE FROM CSCPFichaPrediosvsVivienda
					   WHERE codProyecto=".$_SESSION["ccfProyecto"]."
					   AND codModulo=".$_SESSION["ccfModulo"]."
					   AND numFormulario='".$_SESSION["ccfFormulario"]."'
					   AND nroPredio='".$_SESSION["ccfPredio"]."'
					   AND consecutivo='".$_SESSION["ccfConsecutivo"]."'
					   AND nroVivienda='".$v."'";
			$cursorDel1 = mssql_query($sqlDel1);
//echo 	$sqlDel1." ---- $cursorDel1 ******* ".mssql_get_last_message()."<br>";		
		}
		
		if(trim($cursorDel1)!="")
		{
			$sqlDel2 = "DELETE FROM CSCPFichaVivienda
					   WHERE nroVivienda='".$v."'";
			$cursorDel2 = mssql_query($sqlDel2);
//echo 	$sqlDel2." ---- $cursorDel2 ******* ".mssql_get_last_message()."<br>";		
		}//cierra if(trim($cursorDel)!="")
	}//cierra if($accio==2)
	
	if((trim($cursorDel2)!="")or(trim($cursor_up)!=""))
	{
		$cur_tran=mssql_query("COMMIT TRANSACTION");
		echo ("<script>alert('La operación se realizó con éxito.');</script>");
	}
	else{
		$cur_tran=mssql_query("ROLLBACK TRANSACTION");
		echo ("<script>alert('Error en la operación');</script>");
	}
	
	echo ("<script>window.close();MM_openBrWindow('frmCensoVivienda03.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");

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
var nav4 = window.Event ? true : false;
function acceptNum(evt){   
var key = nav4 ? evt.which : evt.keyCode;   
return (key <= 13 || (key>= 48 && key <= 57));
}

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
          <td colspan="2" class="TituloTabla">::: Edici&oacute;n de la Vivienda</td>
        </tr>
        <tr>
          <td width="25%" class="TituloTabla1">N&uacute;mero de Formulario </td>
          <td class="TxtTabla"><? echo $_SESSION["ccfFormulario"]; ?></td>
        </tr>
        <tr>
          <td width="25%" class="TituloTabla1">N&uacute;mero del Predio</td>
          <td class="TxtTabla"><? echo $_SESSION["ccfPredio"]; ?></td>
        </tr>
        <tr>
          <td width="25%" class="TituloTabla1"><div align="left">N&uacute;mero de Vivienda</div></td>
          <td class="TxtTabla"><? echo $v; ?>
           </td>
      </tr>  
        <tr>
          <td width="25%" class="TituloTabla1">Unidad Censal</td>
          <td class="TxtTabla"> <input name="Unidad" type="text" class="CajaTexto" id="Unidad" value=" <? echo $unidad; ?>" onKeyPress="return acceptNum(event)" <? if($accion == 3){ echo "readonly"; } ?>  ></td>
        </tr>

    </table>

    <!--BOTONES -->   
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%">&nbsp;</td>
        <td align="right">
          <input name="recarga" type="hidden" id="recarga" value="1">       
		  <? if($accion == 2){ $txt="Grabar"; }
		  	if($accion == 3){ $txt="Eliminar"; } ?>
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

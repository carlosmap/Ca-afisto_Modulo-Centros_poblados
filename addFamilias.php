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


$sql0="SELECT *  ";
$sql0=$sql0." FROM CSCPFicha ";
$sql0 = $sql0." WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
$sql0 = $sql0." AND codModulo=" . $_SESSION["ccfModulo"];
$sql0 = $sql0." AND numFormulario='" . $_SESSION["ccfFormulario"]."'";
$sql0= $sql0. "   AND consecutivo=".$_SESSION["ccfConsecutivo"] ;
$cursor0 = mssql_query($sql0);

if ($reg0=mssql_fetch_array($cursor0)) 
{
	$segregacion=$reg0["segregacion"];
	$vivienda=$reg0["vivienda"];
	$hogar=$reg0["hogar"];
}
	$nroFamilia=0;
	//consulta el numero de la familia y lo incrementa en 1
	$vSql2=" SELECT  MAX(nroFamilia) consec FROM CSCPFichaFamilia ";
	$vCursor2 = mssql_query($vSql2) ;
	if ($vReg2=mssql_fetch_array($vCursor2)) 
	{
		$nroFamilia = $vReg2[consec] +1 ;
	}	
	else
	{
		$nroFamilia =  1 ;
	}


//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
/*
	$hayFormulario = 0;

	//Verifica si la Unidad Social ya existe  en la vivienda 
	//dbo.CSCPFichaViviendavsFamilia
	//codProyecto, codModulo, numFormulario, nroVivienda, nroFamilia, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.CSCPFichaFamilia
	//nroFamilia, tipoInformacion, unidadSocial, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$vSql=" SELECT  count(CSCPFichaFamilia.nroFamilia) existeForm FROM CSCPFichaViviendavsFamilia INNER JOIN
                      CSCPFichaFamilia ON CSCPFichaViviendavsFamilia.nroFamilia = CSCPFichaFamilia.nroFamilia";
	$vSql=	$vSql . " WHERE codProyecto = ".$_SESSION["ccfProyecto"];
	$vSql=	$vSql . " AND codModulo = ".$_SESSION["ccfModulo"];
	$vSql=	$vSql . " AND numFormulario = '".$_SESSION["ccfFormulario"]."'";
	$vSql= $vSql. "   AND consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$vSql=	$vSql . " AND nroVivienda = ".$_SESSION["ccfVivienda"];
	$vSql=	$vSql . " AND unidadSocial = ".$NoFamilia;

	$vCursor = mssql_query($vSql) ;
	if ($vReg=mssql_fetch_array($vCursor)) 
	{
		$hayFormulario = $vReg[existeForm] ;
	}					  
*/
	//Verifica si la Unidad Censal ya existe  en el predio  
	//dbo.CSCPFichaViviendavsFamilia
	//codProyecto, codModulo, numFormulario, nroVivienda, nroFamilia, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.CSCPFichaFamilia
	//nroFamilia, tipoInformacion, unidadSocial, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$vSql2=" SELECT  MAX(nroFamilia) consec FROM CSCPFichaFamilia ";
	$vCursor2 = mssql_query($vSql2) ;
	if ($vReg2=mssql_fetch_array($vCursor2)) 
	{
		$consecutivo = $vReg2[consec] +1 ;
	}	
	else
	{
		$consecutivo =  1 ;
	}
/*
	if($hayFormulario > 0)
	{
		echo ("<script>alert('El Número de la Familia ya existe. Por favor verifique la información');</script>");
	}
	else
	{
*/
		//Adicionar un registro
		//dbo.CSCPFichaViviendavsFamilia
		//codProyecto, codModulo, numFormulario, nroVivienda, nroFamilia, fechaGraba, usuarioGraba, fechaMod, usuarioMod
		//dbo.CSCPFichaFamilia
		//nroFamilia, tipoInformacion, unidadSocial, fechaGraba, usuarioGraba, fechaMod, usuarioMod
		
		//Inicio de Transacción
		$cursorTr = mssql_query("BEGIN TRANSACTION");

		$qry = "INSERT INTO CSCPFichaFamilia (nroFamilia, tipoInformacion, unidadSocial, fechaGraba, usuarioGraba)				
				VALUES (";
		$qry = $qry. $consecutivo .",";
		$qry = $qry. "3, " ;
		$qry = $qry. "'".$NoFamilia."'," ;
		$qry = $qry.  "'". gmdate("n/d/y")."', " ;
		$qry = $qry. "'".$_SESSION["ccfUsuID"]."')";
		$cursorIn = mssql_query($qry) ;
//echo "<br>".$qry." -- ".mssql_get_last_message()."<br><br>";

		//dbo.CSCPFichaViviendavsFamilia
		//codProyecto, codModulo, numFormulario, nroVivienda, nroFamilia, fechaGraba, usuarioGraba, fechaMod, usuarioMod
		$qry = "INSERT INTO CSCPFichaViviendavsFamilia (codProyecto, codModulo, numFormulario,consecutivo,nroPredio, nroVivienda, 
		nroFamilia, fechaGraba, usuarioGraba)					
		VALUES (";
		$qry = $qry . $_SESSION["ccfProyecto"].", ";
		$qry = $qry . $_SESSION["ccfModulo"].", ";
		$qry = $qry . "'".$_SESSION["ccfFormulario"] ."',";
   		$qry = $qry ."'".$_SESSION["ccfConsecutivo"]."',";
		$qry = $qry . "'".$_SESSION["ccfPredio"] ."',";
		$qry = $qry . $_SESSION["ccfVivienda"] .",";
		$qry = $qry . $consecutivo.", ";
		$qry = $qry.  "'". gmdate("n/d/y")."', " ;
		$qry = $qry.  "'".$_SESSION["ccfUsuID"]."')";
		$cursorIn2 = mssql_query($qry) ;
//echo "<br>".$qry." -- ".mssql_get_last_message()."<br><br>";		
		if  ((trim($cursorIn) != "")  && (trim($cursorIn2) != ""))
		{
			//Se hace un commit para asegurar la transacción
			$curComm = mssql_query("COMMIT TRANSACTION");
			if(trim($curComm) != "")
			{
				echo ("<script>alert('La Grabación se realizó con éxito.');</script>");
			}
		}
		else
		{
			//Se deshacen todas las operaciones de la transacción
			$curRoll = mssql_query("ROLLBACK TRANSACTION");
			if(trim($curRoll) != "")
			{
				echo ("<script>alert('Error en la operación');</script>");
			}
		}
//	}

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
          <td class="TituloTabla1">N&uacute;mero del Hogar </td>
          <td class="TxtTabla"><? echo $nroFamilia; ?></td>
        </tr>
      <tr>
          <td class="TituloTabla1"><div align="left">Unidad Social</div></td>
          <td class="TxtTabla">
            <input name="NoFamilia" type="text" class="CajaTexto" id="NoFamilia" value="<?php echo $segregacion.$vivienda.$hogar; ?>" readonly >
           </td>
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
        <td class="copyr"> powered by INGETEC S.A - 2012 </td>
      </tr>
    </table>	
	
    </td>
  </tr>
 </form>   
</table>
</body>
</html>

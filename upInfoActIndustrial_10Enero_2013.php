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
//Patricia Guti�rrez Restrepo
//Adici�n de un Registro de Vivienda
//Inicializa las variables de sesi�n
session_start();

//Abre la conexi�n a la BD
include('../enlaceBD.php');

//Libreria de Funciones
//include('funcionesCSCP.php');
include ("../verificaIngreso2.php");
include("funcionesCSCP.php");
//Establecer la conexi�n a la base de datos
$conexion = conectar();

$sqlPC01="SELECT * FROM tmModulos WHERE codModulo= " .$_SESSION["ccfModulo"] ; 
$cursorPC01 = mssql_query($sqlPC01) ;
if ($regPC01=mssql_fetch_array($cursorPC01)) 
{
	$proyModulo=$regPC01[nomModulo];
}

//Tipo de informaci�n 0=Encuesta 1=Predio 2=Vivienda 3=Familia
$tipo=$_REQUEST["tipo"];
switch ($tipo) 
{ 
	case 0: 
		$nobj=$_SESSION["ccfFormulario"]; break; 
	case 1: 
		$nobj=$_SESSION["ccfPredio"]; break; 
	case 2: 
		$nobj=$_SESSION["ccfVivienda"]; break; 
	case 3: 
		$nobj=$_SESSION["ccfFamilia"]; break; 
} 


     //B�squeda de la informaci�n de la actividad industrial
		$sql_sel = "select *, tmItems.nomItem,tm.nomItem as nomit2 from CSCPFichaFamiliaIndustrial  as industrial
					inner join tmItems on industrial.codItemTipoAct=tmItems.codItem
					inner join tmItems as tm on industrial.codItemSitioVenta=tm.codItem ";
		$sql_sel = $sql_sel." where industrial.codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and industrial.codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and industrial.numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and industrial.consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and industrial.nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and industrial.nroVivienda=".$_SESSION["ccfVivienda"].""; 
		$sql_sel = $sql_sel."  and industrial.nroFamilia=".$_SESSION["ccfFamilia"]." ";
		$sql_sel = $sql_sel."  and industrial.consecAct=".$conse." ";
		$cursor_sel = mssql_query($sql_sel);
//echo $sql_sel."  --  ".mssql_get_last_message()."<br>";


		//consulta la maquinaria asociada a la actividad
		$sql_sel="select * from CSCPFichaFamiliaIndustrialMaq  ";
		$sql_sel = $sql_sel." inner join tmItems on CSCPFichaFamiliaIndustrialMaq.codItemMaq=tmItems.codItem ";
		$sql_sel = $sql_sel." where CSCPFichaFamiliaIndustrialMaq.codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.nroVivienda=".$_SESSION["ccfVivienda"]."";
		$sql_sel = $sql_sel." and CSCPFichaFamiliaIndustrialMaq.nroFamilia=".$_SESSION["ccfFamilia"]."";
		$sql_sel = $sql_sel."  and CSCPFichaFamiliaIndustrialMaq.consecAct=".$conse." order by(consecMaq) ";
		$cur_sel_maqui=mssql_query($sql_sel);
//echo $sql_sel."  --  ".mssql_get_last_message()."<br>";

if($accion==3)
{
	$disa="disabled";
}

if ($recarga == "2") 
{

		//Inicio de Transacci�n
		$cursorTr = mssql_query("BEGIN TRANSACTION");
		$error="no";

	//si se selecciono actualizar
	if($accion==2)
	{
		$sql_sel = "update CSCPFichaFamiliaIndustrial set codItemTipoAct=".$actividad.",hayCamaraCom=".$camara.",hayRUT= ".$rut."";
		if(trim($cod_rut)!="")
			$sql_sel = $sql_sel.",codigoRUT=".$cod_rut."";
		else
			$sql_sel = $sql_sel.",codigoRUT=NULL";

		$sql_sel = $sql_sel.",AntGeneral=".$antiguedad.",AntSitio=".$antiguedadSitio.",numEmpSexoM= ".$hombre.",numEmpSexoF=".$mujer.",numEmpTempP=".$permanentes.",numEmpTempO=".$ocasionales.",numEmpRemF=".$familiares.",numEmpRemR=".$remunerados.",valorPruducMes=".$produccion.",unidadMedida='".$Umedida."',costoProduccion=".$produccionM.",valorVenta=".$ventasM.",codItemSitioVenta=".$ventas.",fechaMod='". gmdate("n/d/y")."',usuarioMod='".$_SESSION["ccfUsuID"]."' ";
		$sql_sel = $sql_sel." where codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and nroVivienda=".$_SESSION["ccfVivienda"]."";
		$sql_sel = $sql_sel."  and nroFamilia=".$_SESSION["ccfFamilia"]."";
		$sql_sel = $sql_sel."  and consecAct=".$conse." ";
		$cursorIn = mssql_query($sql_sel) ;
		if($cursorIn=="")
			$error="si";


//echo $sql_sel." --- ".mssql_get_last_message()."<br>";

		$sql_sel="delete from CSCPFichaFamiliaIndustrialMaq  ";
		$sql_sel = $sql_sel." where codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and nroVivienda=".$_SESSION["ccfVivienda"]."";
		$sql_sel = $sql_sel."  and nroFamilia=".$_SESSION["ccfFamilia"]."";
		$sql_sel = $sql_sel."  and consecAct=".$conse." ";		
		$cur_del=mssql_query($sql_sel);
		if(trim($cur_del)=="")
			$error="si";

//echo $sql_sel." --- ".mssql_get_last_message()." ------ $error  --- $cur_del  --- $cursorIn <br>";

		if(($cur_del!="")and($cursorIn!="")) //si no se presentaron errores en el insert y el delete anteriores
		{
//	echo "ingreso <br>";
			for($i=1;$i<$reg;$i++) //recorre la cantidad de campos generados en los items de las maquinarias
			{
				$maquina = "maquinaria".$i;
				if((${$maquina}==1)and($error!="si")) //valida si se selecciono si al momento de escoger la maquinaria
				{
//	echo "ingreso 2 <br>";
					$consec_maquinaria++; 
					$cod_maquinaria="cod_maquinaria".$i; //almacena el codigo de la maquinaria seleccionada como si
	
					$sql_inse="insert into CSCPFichaFamiliaIndustrialMaq ( codProyecto,codModulo,numFormulario,consecutivo,nroPredio,nroVivienda,nroFamilia,consecAct,consecMaq,codItemMaq,fechaGraba,usuarioGraba) values(";
					$sql_inse = $sql_inse." ".$_SESSION["ccfProyecto"].",";
					$sql_inse = $sql_inse." ".$_SESSION["ccfModulo"].",";
					$sql_inse = $sql_inse." ".$_SESSION["ccfFormulario"].",";
					$sql_inse = $sql_inse." ".$_SESSION["ccfConsecutivo"].",";
					$sql_inse = $sql_inse." ".$_SESSION["ccfPredio"].",";
					$sql_inse = $sql_inse." ".$_SESSION["ccfVivienda"].",";
					$sql_inse = $sql_inse." ".$_SESSION["ccfFamilia"].",";
					$sql_inse = $sql_inse." ".$conse.",";
					$sql_inse = $sql_inse." ".$consec_maquinaria.",";
					$sql_inse = $sql_inse." ".${$cod_maquinaria}.",";
					$sql_inse = $sql_inse.  "'". gmdate("n/d/y")."', " ;
					$sql_inse = $sql_inse. "'".$_SESSION["ccfUsuID"]."')";
	
					$cur_inse=mssql_query($sql_inse);
					if($cur_inse=="")
						$error="si";
	
//	echo $sql_inse." --- ".mssql_get_last_message()."<br>";
				}
			}
		}
	}
	else //si se selecciono eliminar
	{

		$sql_sel="delete from CSCPFichaFamiliaIndustrialMaq  ";
		$sql_sel = $sql_sel." where codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and nroVivienda=".$_SESSION["ccfVivienda"]."";
		$sql_sel = $sql_sel."  and nroFamilia=".$_SESSION["ccfFamilia"]."";
		$sql_sel = $sql_sel."  and consecAct=".$conse." ";		
		$cur_del=mssql_query($sql_sel);
		if(trim($cur_del)=="")
			$error="si";

//	echo $sql_sel." --- ".mssql_get_last_message()."<br>";

		$sql_sel="delete from CSCPFichaFamiliaIndustrial  ";
		$sql_sel = $sql_sel." where codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and nroVivienda=".$_SESSION["ccfVivienda"]."";
		$sql_sel = $sql_sel."  and nroFamilia=".$_SESSION["ccfFamilia"]."";
		$sql_sel = $sql_sel."  and consecAct=".$conse." ";		
		$cursorIn=mssql_query($sql_sel);
		if(trim($cursorIn)=="")
			$error="si";

//	echo $sql_sel." --- ".mssql_get_last_message()."<br>";
	}
	if  ((trim($cursorIn) != "")and($error!="si"))
	{
		//Se hace un commit para asegurar la transacci�n
		$curComm = mssql_query("COMMIT TRANSACTION");
//			$curRoll = mssql_query("ROLLBACK TRANSACTION");
		if(trim($curComm) != "")
		{
			echo ("<script>alert('La Grabaci�n se realiz� con �xito.');</script>");
		}
	}
	else
	{
		//Se deshacen todas las operaciones de la transacci�n
		$curRoll = mssql_query("ROLLBACK TRANSACTION");
		if(trim($curRoll) != "")
		{
			echo ("<script>alert('Error en la operaci�n');</script>");
		}
	}
	
	$volverA = "";
	$volverA=Genera_Pagina(0,17);	

	echo ("<script>window.close();MM_openBrWindow('$volverA','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');</script>");


}

?>


<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto  :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" src="calendar.js"></script>
<SCRIPT language=JavaScript>

var nav4 = window.Event ? true : false;
function acceptNum(evt){   
var key = nav4 ? evt.which : evt.keyCode;   
return (key <= 13 || (key>= 48 && key <= 57));
}

function campRut(val)
{
//	alert (val);
	if(val=='no')
	{

		document.form1.cod_rut.setAttribute('disabled','disabled');
		document.form1.cod_rut.value="";
//		document.form1.cod_rut.set
	}
	else
		document.form1.cod_rut.removeAttribute('disabled');
}


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
msg2 = "Seleccione al menos una maquinaria.\n";
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

	if(document.form1.actividad.value=="")
	{
		msg1="Seleccione el tipo de actividad\n";
	}

	if(((!document.form1.camara[0].checked && !document.form1.camara[1].checked)))
	{
		msg1=msg1+"Especifique si tiene camara de comercio\n";
	}
	if(((!document.form1.rut[0].checked && !document.form1.rut[1].checked)))
	{
		msg1=msg1+"Especifique si tiene RUT\n";
	}
	if(document.form1.rut[0].checked) //si se ha seleccionado que tiene rut, se evalua si se ingreso el codigo
	{
		if(document.form1.cod_rut.value=="")
		{
			msg1=msg1+"Ingrese el codigo RUT\n";			
		}
	}

	if(document.form1.antiguedad.value=="")
	{
		msg1=msg1+"Ingrese la antiguedad general de la actividad\n";
	}
	if(document.form1.antiguedadSitio.value=="")
	{
		msg1=msg1+"Ingrese la antiguedad de la actividad en el sitio\n";
	}

	if(document.form1.hombre.value=="")
	{
		msg1=msg1+"Ingrese el numero de empleados hombre\n";
	}
	if(document.form1.mujer.value=="")
	{
		msg1=msg1+"Ingrese el numero de empleados mujer\n";
	}
	if(document.form1.permanentes.value=="")
	{
		msg1=msg1+"Ingrese el numero de empleados permanentes\n";
	}
	if(document.form1.ocasionales.value=="")
	{
		msg1=msg1+"Ingrese el  numero de empleados ocasionales\n";
	}
	if(document.form1.familiares.value=="")
	{
		msg1=msg1+"Ingrese el  numero de empleados familiares\n";
	}
	if(document.form1.remunerados.value=="")
	{
		msg1=msg1+"Ingrese el numero de empleados remunerados\n";
	}


	if(document.form1.produccion.value=="")
	{
		msg1=msg1+"Ingrese el valor de producci�n del mes\n";
	}

	if(document.form1.Umedida.value=="")
	{
		msg1=msg1+"Seleccione la unidad de medida\n";
	}
	if(document.form1.produccionM.value=="")
	{
		msg1=msg1+"Ingrese el costo de producci�n mensual\n";
	}

	if(document.form1.ventasM.value=="")
	{
		msg1=msg1+"Ingrese el valor de las ventas al mes\n";
	}

	if(document.form1.ventas.value=="")
	{
		msg1=msg1+"Seleccione el sitio de ventas\n";
	}

	//	maquinaria
	//	cMaquinas
	for( var obj = 1; obj < document.getElementById('cMaquinas').value; obj++ ){
		if( document.getElementById('maquinaria'+obj).checked == true ){
			msg2 = "";
		}
	}
	

	if( ( msg1=="" ) && ( msg2=="" ) )
	{
		document.form1.recarga.value="2";		
		document.form1.submit();
	}
	else {
		mensaje = msg1 + msg2;
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
        if (isNaN(val)) errors+='- '+nm+' debe ser num�rico.\n';
        if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
          min=test.substring(8,p); max=test.substring(p+1);
          if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
    } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' es obligatorio.\n'; }
  } if (errors) alert('Validaci�n:\n'+errors);
  document.MM_returnValue = (errors == '');
}
//-->
</SCRIPT>

</head>

<body marginwidth="0" marginheight="0" topmargin="0" leftmargin="0" class="fondo" >

<table  width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#00344C">
<form name="form1" method="post" action="">  
  <tr>
    <td> 	  
    <table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td>
        
    <!-- TITULO -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla"><? echo $proyModulo; ?></td>
        </tr>
    </table>

    <!--TABLA DE INFORMACION  -->
<?php
//informacion de la tabla CSCPFichaFamiliaIndustrial
if($datos_act=mssql_fetch_array($cursor_sel))
{

	$tipo_act=$datos_act["codItemTipoAct"];
	$hay_camara=$datos_act["hayCamaraCom"];
	$hay_rut=$datos_act["hayRUT"];
	$cod_ruts=$datos_act["codigoRUT"];
	$antig_general=$datos_act["AntGeneral"];
	$antig_sitio=$datos_act["AntSitio"];
	$num_per_m=$datos_act["numEmpSexoM"];
	$num_per_f=$datos_act["numEmpSexoF"];
	$num_per_permanen=$datos_act["numEmpTempP"];
	$num_per_ocasio=$datos_act["numEmpTempO"];
	$num_per_familia=$datos_act["numEmpRemF"];
	$num_per_remune=$datos_act["numEmpRemR"];
	$valor_produ_mes=$datos_act["valorPruducMes"];

	$unidad=$datos_act["unidadMedida"];
	$costo_p=$datos_act["costoProduccion"];
	$valor_v=$datos_act["valorVenta"];
	$sitio_v=$datos_act["codItemSitioVenta"];
}
$f=0;
$item_maquinas= array();
while($datos_maquina=mssql_fetch_array($cur_sel_maqui))
{
	$item_maquinas[$f]=$datos_maquina["codItemMaq"];
//echo "items  **** $item_maquinas[$f] ***  ".$datos_maquina["codItemMaq"]."<br>";
	$f++;
}

?>
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
        <tr>
          <td colspan="2" class="TituloTabla2">6.8.4 Actividad industrial</td>
        </tr>
      <tr>
          <td class="TxtTabla">
			<table width="100%" border="0"  cellSpacing="1" cellPadding="0" >
                  <tr>
                    <td class="TituloTabla1"  width="70%" > 6.8.4.1 Tipo de Actividad </td>
                    <td class="TxtTabla">

                      <select name="actividad" class="CajaTexto" id="actividad" <?php echo $disa; ?>>
						<option value=""></option>
<?php
						$cursor_activi=mssql_query("select * from tmItems where codOpcion=95");
						while($datos_activi=mssql_fetch_array($cursor_activi))
						{
							$selActi="";
							if($datos_activi["codItem"]==$tipo_act)
								$selActi="selected";
?>
							<option value="<? echo $datos_activi[codItem]; ?>" <? echo $selActi; ?> > <? echo $datos_activi[nomItem]; ?></option>
<?

						}
?>
                    </select></td>
                  </tr>





                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.2 Camara de Comercio</td>
                    <td class="TxtTabla">Si<input type="radio" name="camara" id="camara" value="1" <? if($hay_camara==1) { echo "checked"; } ?> <?php echo $disa; ?>> 
                    No<input type="radio" name="camara" id="camara" value="0" <? if($hay_camara==0) { echo "checked"; } ?> <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.3 RUT</td>
                    <td class="TxtTabla">Si<input type="radio" name="rut" id="rut" value="1"  onChange="campRut('si')" <? if($hay_rut==1) { echo "checked"; } ?> <?php echo $disa; ?>> 
                      No<input type="radio" name="rut" id="rut" value="0"  onChange="campRut('no')"  <? if($hay_rut==0) { echo "checked"; } ?> <?php echo $disa; ?> ></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.4 Codigo RUT</td>
                    <td class="TxtTabla"><input type="text" name="cod_rut" id="cod_rut" value="<? echo $cod_ruts; ?>" class="CajaTexto" onKeyPress="return acceptNum(event)" disabled <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.5 Antiguedad general de la actividad</td>
                    <td class="TxtTabla"><input type="text" name="antiguedad" id="antiguedad" value="<? echo $antig_general; ?>" class="CajaTexto"  onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.6 Antiguedad de la actividad en el sitio</td>
                    <td class="TxtTabla"><input type="text" name="antiguedadSitio"  value="<? echo $antig_sitio ?>" class="CajaTexto" id="antiguedadSitio"  onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>


<tr>
					<td  width="70%" class="TituloTabla1" ><span class="TituloTabla1">6.8.4.7 Maquinaria y equipos</span></td>
					<td></td>
				  </tr>
				  <tr>
					<td colspan="2">
					<table width="100%" border="0">
						<tr>
							<td  class="TituloTabla1"></td>
							<td colspan="2" align="center"  class="TituloTabla1">Aplica</td>
							<td width="30%"></td>
						</tr>
                      <?php

						$cursor_activi=mssql_query("select * from tmItems where codOpcion=135");
						$m=1;
						while($datos_activi=mssql_fetch_array($cursor_activi))
						{
							$val=0;
							foreach($item_maquinas as $valor) //revisa si se ha marcado la maquinaria como si o no
							{
								if($valor==$datos_activi["codItem"])
									$val=1;

//echo $val."  -- ".$valor." *- * ".$datos_activi["codItem"]. "<br>";
							}
//echo $val."  -- ".$valor." *- * ".$datos_activi["codItem"]. "<br>";
?>	
						  <tr>
							<td  class="TituloTabla1"><?php echo $datos_activi[nomItem]; ?></td>
							<td><span class="TxtTabla">Si
							  <input type="radio" value="1" name="maquinaria<?=$m;?>" id="maquinaria<?=$m;?>" <? if($val==1) { echo "checked"; } ?> <?php echo $disa; ?>> 
							</span></td>
							<td><span class="TxtTabla">No
							  <input type="radio" value="0" name="maquinaria<?=$m;?>" id="maquinaria<?=$m;?>"  <? if($val==0) { echo "checked"; } ?> <?php echo $disa; ?> > 
							</span></td>
					<td></td>
						  </tr>
                      <input type="hidden" value="<? echo $datos_activi[codItem]; ?>" name="cod_maquinaria<?=$m;?>"  > 
                      <?
							$m++;
						}
?><input type="hidden" name="cMaquinas" value="<?= $m ?>" />
					</table>
				    </td>
				 </tr>

                </table>

                <table width="100%" border="0">
                  <tr>
                    <td width="40%" rowspan="6" class="TituloTabla1">6.8.4.8 Numero de empleados</td>
                    <td width="15%"  rowspan="2" class="TituloTabla1">1. Sexo</td>
                    <td width="15%"  class="TituloTabla1">1. Hombre                    </td>
                    <td  class="TxtTabla"><input type="text" name="hombre" id="hombre" value="<? echo $num_per_m; ?>"  class="CajaTexto" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="15%" class="TituloTabla1">2. Mujer                    </td>
                    <td class="TxtTabla"><input type="text" name="mujer" value="<? echo $num_per_f; ?>" id="mujer"  class="CajaTexto" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>

                  <tr>
                    <td width="15%" rowspan="2" class="TituloTabla1">2. Temporalidad</td>
                    <td width="15%" class="TituloTabla1">1. Permanentes                    </td>
                    <td class="TxtTabla"><input type="text" name="permanentes"  value="<? echo $num_per_permanen ?>" class="CajaTexto" id="permanentes" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="15%" class="TituloTabla1">2. Ocasionales                    </td>
                    <td class="TxtTabla"><input type="text" name="ocasionales" value="<? echo $num_per_ocasio; ?>" class="CajaTexto" id="ocasionales" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="15%" rowspan="2" class="TituloTabla1">3. Remuneraci&oacute;n</td>
                    <td width="15%" class="TituloTabla1">1. Familiares                    </td>
                    <td class="TxtTabla"><input type="text" name="familiares"  value="<? echo $num_per_familia; ?>" class="CajaTexto" id="familiares" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="15%" class="TituloTabla1">2. Remunerados                    </td>
                    <td class="TxtTabla"><input type="text" name="remunerados" value="<? echo $num_per_remune; ?>" class="CajaTexto" id="remunerados" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                </table>
                
                <table width="100%" border="0" cellSpacing="1" cellPadding="0" >
                  <tr >
                    <td class="TituloTabla1" width="70%"  >6.8.4.9 Valor de producci�n del Mes</td>
                    <td ><input type="text" name="produccion" id="produccion"  class="CajaTexto" value="<? echo $valor_produ_mes; ?>" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.10 Unidad de medida</td>
                    <td class="TxtTabla"><select name="Umedida" class="CajaTexto" id="Umedida" <?php echo $disa; ?>>
						<option value="" ></option>

						<option value="Kg" <? if($unidad=="Kg"){ echo "selected"; }  ?> >Kg</option>
						<option value="Gr" <? if($unidad=="Gr"){ echo "selected"; }  ?> >Gr</option>
                    </select></td>
                  </tr>

                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.11 Costo de producci&oacute;n mensual</td>
                    <td class="TxtTabla"><input type="text" name="produccionM" class="CajaTexto" value="<? echo $costo_p; ?>" id="produccionM" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.12 Valor de las ventas al mes</td>
                    <td class="TxtTabla"><input name="ventasM" type="text" class="CajaTexto" value="<? echo $valor_v; ?>" id="ventasM" onKeyPress="return acceptNum(event)" <?php echo $disa; ?>></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.13 Sitio de ventas</td>
                    <td class="TxtTabla"><select name="ventas" class="CajaTexto" id="ventas" <?php echo $disa; ?>>
                      <option value=""></option>
                      <?php
						$cursor_activi=mssql_query("select * from tmItems where codOpcion=96");
						while($datos_activi=mssql_fetch_array($cursor_activi))
						{

							$selVentas="";
							if($datos_activi["codItem"]==$sitio_v)
								$selVentas="selected";

?>
                      <option value="<? echo $datos_activi[codItem]; ?>" <? echo $selVentas; ?>> <? echo $datos_activi[nomItem]; ?></option>
                      <?

						}
?>
                    </select></td>
                  </tr>
				  
				<tr>
					<td class="TituloTabla1" colspan="2">Nota</td>
				</tr>
				<tr>
					<td class="TxtTabla" colspan="2" align="center"><textarea cols="100" name="nota" id="nota" <?php echo $disa; ?>></textarea></td>
				</tr>
                </table>


		  </td>
      </tr>  
    </table>

    <!--BOTONES -->   
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%">&nbsp;</td>
        <td align="right">
          <input name="recarga" type="hidden" id="recarga" value="1">  
          <input name="reg" type="hidden" id="reg" value="<?php echo $m; ?>">     
			<?php if($accion=='2') { $mensa="Editar";  } if($accion=='3') { $mensa="Eliminar"; } ?>
  
          <input name="Submit2" type="button" class="Boton"  value="<?php echo $mensa; ?>" onClick="envia2()">
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

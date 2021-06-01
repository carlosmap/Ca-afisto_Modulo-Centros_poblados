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
//include('funcionesCSCP.php');
include ("../verificaIngreso2.php");
include("funcionesCSCP.php");
//Establecer la conexión a la base de datos
$conexion = conectar();

$sqlPC01="SELECT * FROM tmModulos WHERE codModulo= " .$_SESSION["ccfModulo"] ; 
$cursorPC01 = mssql_query($sqlPC01) ;
if ($regPC01=mssql_fetch_array($cursorPC01)) 
{
	$proyModulo=$regPC01[nomModulo];
}

//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

if($accion==3)
{
	$disa="disabled";
}

if ($recarga == "2") 
{

		$consec=0; //consecutivo de la actividad industrial de la familia

		$sql_sel="select max(consecAct) as conse from CSCPFichaFamiliaIndustrial where ";
		$sql_sel = $sql_sel." codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and nroVivienda=".$_SESSION["ccfVivienda"]."";
		$sql_sel = $sql_sel."  and nroFamilia=".$_SESSION["ccfFamilia"]."";
		$cur_sel=mssql_query($sql_sel);
		if($datos_sel=mssql_fetch_array($cur_sel))
			$consec=$datos_sel["conse"];

//echo $sql_sel." --- ".$consec."<br><br>";

		$consec_maquinaria=0; //consecutivo de la cantidad de maquinas asociadas a la familia

		$sql_sel="select max(consecMaq) as conse from CSCPFichaFamiliaIndustrialMaq where ";
		$sql_sel = $sql_sel." codProyecto= ".$_SESSION["ccfProyecto"]."";
		$sql_sel = $sql_sel." and codModulo=".$_SESSION["ccfModulo"]."";
		$sql_sel = $sql_sel." and numFormulario=".$_SESSION["ccfFormulario"]."";
		$sql_sel = $sql_sel." and consecutivo=".$_SESSION["ccfConsecutivo"]."";
		$sql_sel = $sql_sel." and nroPredio=".$_SESSION["ccfPredio"]."";
		$sql_sel = $sql_sel." and nroVivienda=".$_SESSION["ccfVivienda"]."";
		$sql_sel = $sql_sel." and nroFamilia=".$_SESSION["ccfFamilia"]."";
		$sql_sel = $sql_sel." and consecAct=".$consec."";
		$cur_sel=mssql_query($sql_sel);
		if($datos_sel=mssql_fetch_array($cur_sel))
			$consec_maquinaria=$datos_sel["conse"];


		$consec++;


//echo $sql_sel." -- ".$consec_maquinaria."<br><br>";

		//Inicio de Transacción
		$cursorTr = mssql_query("BEGIN TRANSACTION");
		$error="no";


		$qry = "insert into CSCPFichaFamiliaIndustrial ( codProyecto,codModulo,numFormulario,consecutivo,nroPredio,nroVivienda,nroFamilia,consecAct,
codItemTipoAct,hayCamaraCom,hayRUT";

		if(trim($cod_rut)!="")
			$qry = $qry.",codigoRUT";

		$qry = $qry.",AntGeneral,AntSitio,numEmpSexoM,numEmpSexoF,numEmpTempP,numEmpTempO,numEmpRemF,numEmpRemR,valorPruducMes,unidadMedida,costoProduccion,valorVenta
				,codItemSitioVenta,fechaGraba,usuarioGraba) values(";

		$qry = $qry." ".$_SESSION["ccfProyecto"].",";
		$qry = $qry." ".$_SESSION["ccfModulo"].",";
		$qry = $qry." '".$_SESSION["ccfFormulario"]."',";
		$qry = $qry." ".$_SESSION["ccfConsecutivo"].",";
		$qry = $qry." ".$_SESSION["ccfPredio"].",";
		$qry = $qry." ".$_SESSION["ccfVivienda"].",";
		$qry = $qry." ".$_SESSION["ccfFamilia"].",";
		$qry = $qry." ".$consec.",";

		$qry = $qry." ".$actividad.",";
		$qry = $qry." ".$camara.",";
		$qry = $qry." ".$rut.",";

		if(trim($cod_rut)!="")
			$qry = $qry." '".$cod_rut."',";

		$qry = $qry." ".$antiguedad.",";
		$qry = $qry." ".$antiguedadSitio.",";

		$qry = $qry." ".$hombre.",";
		$qry = $qry." ".$mujer.",";
		$qry = $qry." ".$permanentes.",";
		$qry = $qry." ".$ocasionales.",";

		$qry = $qry." ".$familiares.",";
		$qry = $qry." ".$remunerados.",";
		$qry = $qry." ".$produccion.",";

		$qry = $qry." '".$Umedida."',";
		$qry = $qry." ".$produccionM.",";
		$qry = $qry." ".$ventasM.",";
		$qry = $qry." ".$ventas.",";

		$qry = $qry.  "'". gmdate("n/d/y")."', " ;
		$qry = $qry. "'".$_SESSION["ccfUsuID"]."')";
		$cursorIn = mssql_query($qry) ;

//echo $qry." --- ".mssql_get_last_message()."<br>";
	
	if($cursorIn!="") //si no se presentaron errores en el insert anterior
	{
		for($i=1;$i<$reg;$i++) //recorre la cantidad de campos generados en los items de las maquinarias
		{
/*
echo $i."<br>";
			echo ${$maquina}."<br>";
			echo ${$cod_maquinaria}."<br>";
			$maquina="maquinaria".'2';
			echo ${$maquina}."<br>";
*/
			$maquina = "maquinaria".$i;
			if((${$maquina}==1)and($error!="si")) //valida si se selecciono si al momento de escoger la maquinaria
			{
				$consec_maquinaria++; 
				$cod_maquinaria="cod_maquinaria".$i; //almacena el codigo de la maquinaria seleccionada como si

				$sql_inse="insert into CSCPFichaFamiliaIndustrialMaq ( codProyecto,codModulo,numFormulario,consecutivo,nroPredio,nroVivienda,nroFamilia,consecAct,consecMaq,codItemMaq,fechaGraba,usuarioGraba) values(";
				$sql_inse = $sql_inse." ".$_SESSION["ccfProyecto"].",";
				$sql_inse = $sql_inse." ".$_SESSION["ccfModulo"].",";
				$sql_inse = $sql_inse." '".$_SESSION["ccfFormulario"]."',";
				$sql_inse = $sql_inse." ".$_SESSION["ccfConsecutivo"].",";
				$sql_inse = $sql_inse." ".$_SESSION["ccfPredio"].",";
				$sql_inse = $sql_inse." ".$_SESSION["ccfVivienda"].",";
				$sql_inse = $sql_inse." ".$_SESSION["ccfFamilia"].",";
				$sql_inse = $sql_inse." ".$consec.",";
				$sql_inse = $sql_inse." ".$consec_maquinaria.",";
				$sql_inse = $sql_inse." ".${$cod_maquinaria}.",";
				$sql_inse = $sql_inse.  "'". gmdate("n/d/y")."', " ;
				$sql_inse = $sql_inse. "'".$_SESSION["ccfUsuID"]."')";

				$cur_inse=mssql_query($sql_inse);
				if($cur_inse=="")
					$error="si";

//echo $sql_inse." --- ".mssql_get_last_message()."<br>";
			}
		}
	}

		if  ((trim($cursorIn) != "")and($error!="si"))
		{
			//Se hace un commit para asegurar la transacción
			$curComm = mssql_query("COMMIT TRANSACTION");
//			$curRoll = mssql_query("ROLLBACK TRANSACTION");
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

//var nav4 = window.Event ? true : false;
function acceptNum2(evt){   
var key = nav4 ? evt.which : evt.keyCode;   
return (key <= 13 || (key>= 48 && key <= 57 ) || key ==45);
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

	var val_sexo=parseInt(document.form1.hombre.value) + parseInt(document.form1.mujer.value);
	var val_tempo=parseInt(document.form1.permanentes.value)+parseInt(document.form1.ocasionales.value);
	var val_remune=parseInt(document.form1.familiares.value)+parseInt(document.form1.remunerados.value);

	if((val_sexo!=val_tempo)||(val_remune!=val_tempo)||(val_remune!=val_sexo))
	{
		msg1=msg1+"La sumatoria de las secciones Sexo, Temporalidad y Remuneración deben ser iguales \n";
	}
	
	if(document.form1.produccion.value=="")
	{
	}

	if(document.form1.produccion.value=="")
	{
		msg1=msg1+"Ingrese el valor de producción del mes\n";
	}

	if(document.form1.Umedida.value=="")
	{
		msg1=msg1+"Seleccione la unidad de medida\n";
	}
	if(document.form1.produccionM.value=="")
	{
		msg1=msg1+"Ingrese el costo de producción mensual\n";
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
                      <select name="actividad" class="CajaTexto" id="actividad">
						<option value=""></option>
<?php
						$sql_acti="select * from tmItems where codOpcion=95";
						$sql_acti= $sql_acti. " and tmItems.codProyecto=".$_SESSION["ccfProyecto"] ;
						$sql_acti= $sql_acti. " AND tmItems.codModulo=".$_SESSION["ccfModulo"] ;
						$cursor_activi=mssql_query($sql_acti);
						while($datos_activi=mssql_fetch_array($cursor_activi))
						{
?>
							<option value="<? echo $datos_activi[codItem]; ?>" > <? echo $datos_activi[nomItem]; ?></option>
<?

						}
?>
                    </select></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.2 Camara de Comercio</td>
                    <td class="TxtTabla">Si<input type="radio" name="camara" id="camara" value="1"> 
                    No<input type="radio" name="camara" id="camara" value="0" checked></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.3 RUT</td>
                    <td class="TxtTabla">Si<input type="radio" name="rut" id="rut" value="1"  onClick="campRut('si')"> 
                      No<input type="radio" name="rut" id="rut" value="0"  onChange="campRut('no')" checked></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.4 Codigo RUT</td>
                    <td class="TxtTabla"><input type="text" name="cod_rut" id="cod_rut"  class="CajaTexto" onKeyPress="return acceptNum2(event)" disabled></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.5 Antiguedad general de la actividad</td>
                    <td class="TxtTabla"><input type="text" name="antiguedad" id="antiguedad"  class="CajaTexto"  onKeyPress="return acceptNum(event)"></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.6 Antiguedad de la actividad en el sitio</td>
                    <td class="TxtTabla"><input type="text" name="antiguedadSitio"  class="CajaTexto" id="antiguedadSitio"  onKeyPress="return acceptNum(event)"></td>
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
						$sql_item="select * from tmItems where codOpcion=135";
						$sql_item = $sql_item."  and codProyecto= ".$_SESSION["ccfProyecto"]."";
						$sql_item = $sql_item." and codModulo=".$_SESSION["ccfModulo"]."";
						$cursor_activi=mssql_query($sql_item);
						$m=1;
						while($datos_activi=mssql_fetch_array($cursor_activi))
						{
?>	
						  <tr>
							<td  class="TituloTabla1"><?php echo $datos_activi[nomItem]; ?></td>
							<td><span class="TxtTabla">Si
							  <input type="radio" value="1" name="maquinaria<?=$m;?>" id="maquinaria<?=$m;?>"> 
							</span></td>
							<td><span class="TxtTabla">No
							  <input type="radio" value="0" name="maquinaria<?=$m;?>" id="maquinaria<?=$m;?>" checked> 
							</span></td>
					<td></td>
						  </tr>
                      <input type="hidden" value="<? echo $datos_activi[codItem]; ?>" name="cod_maquinaria<?=$m;?>" > 
                      <?
							$m++;
						}						
?>						<input type="hidden" name="cMaquinas" id="cMaquinas" value="<?=$m ?>" />
					</table>
				    </td>
				 </tr>

                </table>

                <table width="100%" border="0">
                  <tr>
                    <td width="40%" rowspan="6" class="TituloTabla1"><p>6.8.4.8 Numero de empleados</p>
                      <p>(Nota: La sumatoria de (Sexo, Temporalidad y Remuneraci&oacute;n deben ser iguales))</p></td>
                    <td width="15%"  rowspan="2" class="TituloTabla1">1. Sexo</td>
                    <td width="15%"  class="TituloTabla1">1. Hombre                    </td>
                    <td  class="TxtTabla"><input type="text" name="hombre" id="hombre"  class="CajaTexto" onKeyPress="return acceptNum(event)"></td>
                  </tr>
                  <tr>
                    <td width="15%" class="TituloTabla1">2. Mujer                    </td>
                    <td class="TxtTabla"><input type="text" name="mujer" id="mujer"  class="CajaTexto" onKeyPress="return acceptNum(event)"></td>
                  </tr>

                  <tr>
                    <td width="15%" rowspan="2" class="TituloTabla1">2. Temporalidad</td>
                    <td width="15%" class="TituloTabla1">1. Permanentes                    </td>
                    <td class="TxtTabla"><input type="text" name="permanentes"   class="CajaTexto" id="permanentes" onKeyPress="return acceptNum(event)"></td>
                  </tr>
                  <tr>
                    <td width="15%" class="TituloTabla1">2. Ocasionales                    </td>
                    <td class="TxtTabla"><input type="text" name="ocasionales"  class="CajaTexto" id="ocasionales" onKeyPress="return acceptNum(event)"></td>
                  </tr>
                  <tr>
                    <td width="15%" rowspan="2" class="TituloTabla1">3. Remuneraci&oacute;n</td>
                    <td width="15%" class="TituloTabla1">1. Familiares                    </td>
                    <td class="TxtTabla"><input type="text" name="familiares"  class="CajaTexto" id="familiares" onKeyPress="return acceptNum(event)"></td>
                  </tr>


                  <tr>
                    <td width="15%" class="TituloTabla1">2. Remunerados                    </td>
                    <td class="TxtTabla"><input type="text" name="remunerados" class="CajaTexto" id="remunerados" onKeyPress="return acceptNum(event)"></td>
                  </tr>
                </table>
                
                <table width="100%" border="0" cellSpacing="1" cellPadding="0" >
                  <tr >
                    <td class="TituloTabla1" width="70%"  >6.8.4.9 Valor de producción del Mes</td>
                    <td ><input type="text" name="produccion" id="produccion"  class="CajaTexto" onKeyPress="return acceptNum(event)"></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.10 Unidad de medida</td>
                    <td class="TxtTabla"><select name="Umedida" class="CajaTexto" id="Umedida" >
                      <?
						$sql_items="select * from tmItems where codOpcion=269";
						$sql_items = $sql_items."  and codProyecto= ".$_SESSION["ccfProyecto"]."";
						$sql_items = $sql_items." and codModulo=".$_SESSION["ccfModulo"]."";
						$cur_item=mssql_query($sql_items);
?>
                      <option value="" ></option>
                      <?
						while($datos_item=mssql_fetch_array($cur_item))
						{
							$sel="";
							if($unidad==$datos_item[codItem])
								$sel="selected";
?>
                      <option value="<? echo $datos_item[codItem]; ?>" <? echo $sel; ?> > <? echo $datos_item[nomItem]; ?></option>
                      <?
						}
?>
                    </select></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.11 Costo de producci&oacute;n mensual</td>
                    <td class="TxtTabla"><input type="text" name="produccionM" class="CajaTexto" id="produccionM" onKeyPress="return acceptNum(event)"></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.12 Valor de las ventas al mes</td>
                    <td class="TxtTabla"><input name="ventasM" type="text" class="CajaTexto" id="ventasM" onKeyPress="return acceptNum(event)"></td>
                  </tr>
                  <tr>
                    <td width="70%" class="TituloTabla1">6.8.4.13 Sitio de ventas</td>
                    <td class="TxtTabla"><select name="ventas" class="CajaTexto" id="ventas">
                      <option value=""></option>
                      <?php

						$sql_item="select * from tmItems where codOpcion=96";
						$sql_item = $sql_item."  and codProyecto= ".$_SESSION["ccfProyecto"]."";
						$sql_item = $sql_item." and codModulo=".$_SESSION["ccfModulo"]."";
						$cursor_activi=mssql_query($sql_item);
						while($datos_activi=mssql_fetch_array($cursor_activi))
						{
?>
                      <option value="<? echo $datos_activi[codItem]; ?>" > <? echo $datos_activi[nomItem]; ?></option>
                      <?

						}
?>
                    </select></td>
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
</body>
</html>

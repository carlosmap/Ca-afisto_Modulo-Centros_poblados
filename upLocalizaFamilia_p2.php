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
//include('funcionesCSE.php');

//Establecer la conexión a la base de datos
$conexion = conectar();


//Búsqueda de la información almacenada
$sqlInf = "SELECT * FROM CSCPFichaPredio
		   WHERE nroPredio='".$_SESSION["ccfFormulario"]."'";	#$_SESSION["sgcEncuesta"]."'";	ccf
$cursorInf = mssql_query($sqlInf);
$informacion = mssql_fetch_array($cursorInf);
#echo $sqlInf."<br />";
$sqlUbica = "SELECT * FROM tmUbicacion
			  WHERE consecUbica=".$informacion[consecUbica];
$cursorUbica = mssql_query($sqlUbica);
$regUbica = mssql_fetch_array($cursorUbica);
if ($recarga == "") 
{
	$pCodDepartamento = $regUbica[codDepartamento];
	$pCodMunicipio = $regUbica[codMunicipio];
	$pCodVereda = $regUbica[codVereda];
	$pCodItemCorregimiento = $regUbica[codItemCorregimiento];
	$pCodItemCentroPoblado = $regUbica[codItemCentroPoblado];
	$pCodItemCabecera = $regUbica[codItemCabecera];
	$pCodItemSector = $regUbica[codItemSector];
	$pDireccion = $informacion[direccion];
	$pMsnm = $informacion[cota];
	$pEste = $informacion[coordEste];
	$pNorte = $informacion[coordNorte];
	$pSector = $informacion[sector];
	$pBarrio = $informacion[barrio];
	$pNomPredio = $informacion[nomPredio];
	$pAreaTotal = $informacion[areaTotal];
}
else{
	$pCodDepartamento = $pCodDepartamento;
	$pCodMunicipio = $pCodMunicipio;
	$pCodVereda = $pCodVereda;
	$pCodItemCorregimiento = $pCodItemCorregimiento;
	$pCodItemCentroPoblado = $pCodItemCentroPoblado;
	$pCodItemCabecera = $pCodItemCabecera;
	$pCodItemSector = $pCodItemSector;
	$pDireccion = $pDireccion;
	$pNomPredio = $pNomPredio;
	$pAreaTotal = $pAreaTotal;
}


//Búsqueda del código de la ubicación
$sqlCodUbica = "SELECT * FROM tmUbicacion
				WHERE codDepartamento = ".$pCodDepartamento."
				AND codMunicipio = ".$pCodMunicipio."
				AND codVereda = ".$pCodVereda."
				AND codItemCorregimiento = ".$pCodItemCorregimiento."
				AND codItemCentroPoblado = ".$pCodItemCentroPoblado;
$cursoCodUbica = mssql_query($sqlCodUbica);
$regCodUbica = mssql_fetch_array($cursoCodUbica);
#echo $sqlCodUbica."<br />";

$dis = "";
if ($accion==3)
{ 
	$dis = "disabled";
}


//Almacena los datos
//dbo.CSEFichaPredio
//nroPredio, nroObjeto, codDepartamento, codMunicipio, codItemCorregimiento, codItemCentro, codVereda, 
//inspeccion, caserio, nomPredio, areaTotal, codItemUnidad, numViviendas, numHogares, fechaGraba, usuarioGraba, 
//fechaMod, usuarioMod
if ($recarga == "2") 
{
	
	#if ($accion==2)
	#{	
		//Búsqueda del código de la ubicación
		#	, 	   
	$sqlIns = "UPDATE CSCPFichaViviendaVsFamilia SET ";
	if( $accion == 2 ){
		$sqlIns = $sqlIns . " codDepartamento = '".$pCodDepartamento."', ";
		$sqlIns = $sqlIns . " codMunicipio = '".$pCodMunicipio."', ";
		$sqlIns = $sqlIns . " codVereda = '".$pCodVereda."', ";
	}
	else if ( $accion == 3 ){
		$sqlIns = $sqlIns . " codDepartamento = NULL, ";
		$sqlIns = $sqlIns . " codMunicipio = NULL, ";
		$sqlIns = $sqlIns . " codVereda = NULL, ";
	}
	$sqlIns = $sqlIns . " 	fechaMod='".gmdate("n/d/y")."',"; 
	$sqlIns = $sqlIns . " 	usuarioMod='".$_SESSION["ccfUsuID"]."'";
	$sqlIns = $sqlIns . " WHERE nroPredio='".$_SESSION["ccfPredio"]."'";
	$sqlIns = $sqlIns . " AND nroFamilia = ".$_SESSION["ccfFamilia"]; // nroObjeton=> 0=Encuesta ,1=Predio 2=Vivienda, 3=Familia
	$sqlIns = $sqlIns . " AND nroVivienda = ".$_SESSION["ccfVivienda"]; // nroObjeton=> 0=Encuesta ,1=Predio 2=Vivienda, 3=Familia
	#echo "1<br />".$sqlIns;
	$cursorIn = mssql_query($sqlIns);	
	#}//cierra if($accion==2)
	
	#if ($accion == 3){
		//nroPredio, nroObjeto, cota, coordEste, coordNorte, consecUbica, sector, barrio, direccion, fechaGraba, usuarioGraba, fechaMod, usuarioMod
/*
		$sqlIns = "UPDATE CSCPFichaPredio SET
					direccion = NULL,
					cota = NULL,
					coordEste = NULL,
					coordNorte = NULL,
					sector = NULL,
					barrio = NULL,
					consecUbica = NULL, 
					fechaMod='".gmdate("n/d/y")."',
					usuarioMod='".$_SESSION["ccfUsuID"]."'
					WHERE nroPredio='".$_SESSION["ccfPredio"]."'
					AND nroObjeto=1";
		#echo "2<br />".$sqlIns;
		$cursorIn = mssql_query($sqlIns);
	#}//cierra if($accion==3)
	*/
	if  (trim($cursorIn) != "")
	{	 
		echo ("<script>alert('La operación se realizó con éxito.');</script>");
	}
	else
	{	
		echo ("<script>alert('Error durante la operación.');</script>");
	}
	#/*	
	echo "<script>
			window.close();
			MM_openBrWindow('frmCensoFamiliaIDHogar.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
		  </script>";
	#*/
}

?>

<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">

<script language="JavaScript" src="../csenr/calendar.js"></script>

<SCRIPT language=JavaScript>
<!--
function envia1()
{ 
	document.form1.recarga.value="1";
	document.form1.submit();
}
function envia2(){ 
	var v1, v2, v3;
	var m1, m2, m3, msj;
	
	v1 = 's';
	v2 = 's';
	v3 = 's';
	m1 = '';
	m2 = '';
	m3 = '';
	msj = '';
	
	if (document.form1.pCodDepartamento.value == '') 
	{
		v1 = 'n';
		m1 = ('El departamento es obligatorio. \n');
	}
	if (document.form1.pCodMunicipio.value == '') 
	{
		v2 = 'n';
		m2 = ('El municipio es obligatorio. \n');
	}
	if (document.form1.pCodVereda.value == '') 
	{
		v3 = 'n';
		m3 = ('La vereda es obligatoria. \n');
	}
	//	Capos nuevos
	//	
	if((v1=='s') && (v2=='s') && (v3=='s')  )
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else{
		msj = m1 + m2 + m3;
		alert(msj);
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
<table width="100%" border="1" cellpadding="1" cellspacing="1" bordercolor="#00344C">
<form action="" method="post" name="form1">  
  <tr>
    <td>
 
	<!-- NOMBRE DEL MODULO-->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="TituloTabla"><? echo $proyModulo;?></td>
	  </tr>
	</table>
			
	<!-- TITULO-->
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
		<tr>
		  <td colspan="2" class="TituloTabla">::: Ubicaci&oacute;n</td>
		</tr>
	</table>   
	
	<!-- TABLA UBICACIÓN -->
    <table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
            <td width="35%" class="TituloTabla1">Departamento</td>
            <td class="TxtTabla">        
			<? //Búsqueda de los departamentos
				#	Recuperar registro
				$sqlFamilia = " SELECT * FROM CSCPFichaViviendavsFamilia 
								WHERE nroVivienda = ".$_SESSION['ccfVivienda']." AND nroFamilia = ".$_SESSION['ccfFamilia'];	  
				$qryFamilia = mssql_fetch_array( mssql_query( $sqlFamilia ) );
				
				$sqlDep = "Select * From tmDepartamentos";
				$cursorDep = mssql_query($sqlDep);
				#echo $sqlDep;
            ?>
            <select name="pCodDepartamento" class="CajaTexto" id="pCodDepartamento" onChange="document.form1.submit();" <? echo $dis; ?> style="width:250">
                <option value="">:: Seleccione un departamento ::</option>
			<?
				while($regDep = mssql_fetch_array($cursorDep)){
					$selDep = "";
					if($regDep[codDepartamento] == $qryFamilia[codDepartamento] )
						 $selDep = "selected";
					else if($regDep[codDepartamento] == $pCodDepartamento )
						 $selDep = "selected";						
			?>
                    <option value="<? echo $regDep[codDepartamento]; ?>" <? echo $selDep; ?> > <?= $regDep[nomDepartamento]; ?></option>
			<?	}	?>
	        </select>
            </td>
        </tr>
	  
	  <tr>
	    <td width="35%" class="TituloTabla1">Municipio</td>
	    <td class="TxtTabla">
	  <? //Búsqueda de los municipios
	#echo $sqlMun;
	  //echo mssql_num_rows($cursorMun);
	  ?>
        <select name="pCodMunicipio" class="CajaTexto" id="pCodMunicipio" onChange="document.form1.submit();" <? echo $dis; ?> style="width:250">
	      <option value="">:: Seleccione un municipio ::</option>
		  <?
			$sqlMun = "SELECT * FROM tmMunicipios WHERE codDepartamento = ".$pCodDepartamento;
			#/*
			#if( trim($pCodDepartamento) != "" )
			#	$sqlMun .= ;
			#else
			#	$sqlMun .= $qryFamilia[codDepartamento];
			#*/
			/*
			"SELECT DISTINCT tmu.codDepartamento, tmd.nomDepartamento, tmu.codMunicipio, tmm.nomMunicipio
					FROM tmUbicacion tmu, tmDepartamentos tmd, tmMunicipios tmm, tmVeredas tmv, tmItems tmi, tmItems cp, 
						 tmOpciones opCorr, tmOpciones opCP
					WHERE 
						tmu.codProyecto =  ".$_SESSION["ccfProyecto"]." AND tmu.codDepartamento=".$pCodDepartamento."
						AND tmu.codDepartamento = tmd.codDepartamento
						AND tmu.codDepartamento = tmm.codDepartamento
						AND tmu.codMunicipio = tmm.codMunicipio
						AND tmu.codDepartamento = tmv.codDepartamento
						AND tmu.codMunicipio = tmv.codMunicipio
						AND tmu.codVereda = tmv.codVereda
						AND tmu.codItemCorregimiento = tmi.codItem
						AND tmu.codItemCentroPoblado = cp.codItem
						AND tmi.codProyecto = opCorr.codProyecto
						AND tmi.codModulo = opCorr.codModulo
						AND tmi.codOpcion = opCorr.codOpcion
						AND cp.codProyecto = opCP.codProyecto
						AND cp.codModulo = opCP.codModulo
						AND cp.codOpcion = opCP.codOpcion";									 
			#*/
			$cursorMun = mssql_query($sqlMun);
		  while($regMun = mssql_fetch_array($cursorMun))
		  {
		  	  $selMun = "";
			  if($regMun[codMunicipio] == $qryFamilia[codMunicipio])
			  	 $selMun = "selected";
			  else if($regMun[codMunicipio] == $pCodMunicipio)
				  	$selMun = "selected";
			  
			  ?>
			  <option value="<? echo $regMun[codMunicipio]; ?>" <? echo $selMun; ?>><?= $regMun[nomMunicipio]; ?></option>
			  <?
		  }
		  ?>
		  </select>
          </td>
	  </tr>
	  
	  <tr>
	    <td width="35%" class="TituloTabla1">Vereda</td>
	    <td class="TxtTabla">
	      <? //Búsqueda de las veredas
			$sqlVer = "SELECT * FROM tmVeredas tmv";
			if( $pCodMunicipio != "" )
				$sqlVer .= " WHERE codMunicipio = ".$pCodMunicipio." AND codDepartamento = ".$pCodDepartamento;
	  /*
	  "
				WHERE
					tmu.codProyecto =  ".$_SESSION["ccfProyecto"]." AND tmu.codDepartamento=".$pCodDepartamento."
					AND tmu.codMunicipio=".$pCodMunicipio."
					AND tmu.codDepartamento = tmd.codDepartamento
					AND tmu.codDepartamento = tmm.codDepartamento
					AND tmu.codMunicipio = tmm.codMunicipio
					AND tmu.codDepartamento = tmv.codDepartamento
					AND tmu.codMunicipio = tmv.codMunicipio
					AND tmu.codVereda = tmv.codVereda
					AND tmu.codItemCorregimiento = tmi.codItem
					AND tmu.codItemCentroPoblado = cp.codItem
					AND tmi.codProyecto = opCorr.codProyecto
					AND tmi.codModulo = opCorr.codModulo
					AND tmi.codOpcion = opCorr.codOpcion
					AND cp.codProyecto = opCP.codProyecto
					AND cp.codModulo = opCP.codModulo
					AND cp.codOpcion = opCP.codOpcion";
	  /*
	  "SELECT DISTINCT 
	  				tmu.codDepartamento, tmd.nomDepartamento, tmu.codMunicipio, tmm.nomMunicipio, tmv.codVereda
	  				, tmv.nomVereda 
				FROM 
					tmUbicacion tmu, tmDepartamentos tmd, tmMunicipios tmm, tmVeredas tmv, tmItems tmi, tmItems cp
					, tmOpciones opCorr, tmOpciones opCP
				WHERE
					tmu.codProyecto =  ".$_SESSION["ccfProyecto"]." AND tmu.codDepartamento=".$pCodDepartamento."
					AND tmu.codMunicipio=".$pCodMunicipio."
					AND tmu.codDepartamento = tmd.codDepartamento
					AND tmu.codDepartamento = tmm.codDepartamento
					AND tmu.codMunicipio = tmm.codMunicipio
					AND tmu.codDepartamento = tmv.codDepartamento
					AND tmu.codMunicipio = tmv.codMunicipio
					AND tmu.codVereda = tmv.codVereda
					AND tmu.codItemCorregimiento = tmi.codItem
					AND tmu.codItemCentroPoblado = cp.codItem
					AND tmi.codProyecto = opCorr.codProyecto
					AND tmi.codModulo = opCorr.codModulo
					AND tmi.codOpcion = opCorr.codOpcion
					AND cp.codProyecto = opCP.codProyecto
					AND cp.codModulo = opCP.codModulo
					AND cp.codOpcion = opCP.codOpcion";
					#*/
	  $cursorVer = mssql_query($sqlVer);
	 # echo $sqlVer;
	  ?>
	      <select name="pCodVereda" class="CajaTexto" id="pCodVereda" onChange="document.form1.submit();" <? echo $dis; ?> style="width:250">
	        <option value="">:: Seleccione una vereda ::</option>
	        <?
		  while($regVer = mssql_fetch_array($cursorVer))
		  {
		  	  $selVer = "";
			  if($regVer[codVereda] == $qryFamilia[codVereda])
			  	 $selVer = "selected";
			  if($regVer[codVereda] == $pCodVereda)
			  	 $selVer = "selected";
			  ?>
	        <option value="<? echo $regVer[codVereda]; ?>" <? echo $selVer; ?>><? echo $regVer[nomVereda]; ?></option>
	        <?
		  }
		  ?>
	        </select>
          </td>
	    </tr>
	  
	  <? //Búsqueda de las cabeceras municipales
	  $sqlCab = "SELECT DISTINCT tmItems.codOpcion, tmUbicacion.codItemCabecera, tmItems.nomItem
				 FROM tmUbicacion INNER JOIN
				 tmItems ON tmUbicacion.codProyecto = tmItems.codProyecto AND tmUbicacion.codItemCabecera = tmItems.codItem
				 WHERE tmItems.codOpcion=122
				 AND tmUbicacion.codDepartamento = ".$pCodDepartamento."
				 AND tmUbicacion.codMunicipio = ".$pCodMunicipio."
				 AND tmUbicacion.codVereda = ".$pCodVereda."
				 AND tmUbicacion.codItemCorregimiento = ".$pCodItemCorregimiento."
				 AND tmUbicacion.codItemCentroPoblado = ".$pCodItemCentroPoblado."
				 ORDER BY tmItems.nomItem";
#	  echo $sqlCab;
	  $cursorCab = mssql_query($sqlCab);
	  ?>
	  <? //Búsqueda de los sectores
	  $sqlSec = "SELECT DISTINCT tmItems.codOpcion, tmUbicacion.codItemSector, tmItems.nomItem
				 FROM tmUbicacion 
				 INNER JOIN tmItems ON tmUbicacion.codProyecto = tmItems.codProyecto AND tmUbicacion.codItemSector = tmItems.codItem
				 WHERE 
				 tmItems.codOpcion=123
				 AND tmUbicacion.codDepartamento = ".$pCodDepartamento."
				 AND tmUbicacion.codMunicipio = ".$pCodMunicipio."
				 AND tmUbicacion.codVereda = ".$pCodVereda."
				 AND tmUbicacion.codItemCorregimiento = ".$pCodItemCorregimiento."
				 AND tmUbicacion.codItemCentroPoblado = ".$pCodItemCentroPoblado."
				 AND tmUbicacion.codItemCabecera = ".$pCodItemCabecera."
				 ORDER BY tmItems.nomItem";
#	  echo $sqlSec;
	  $cursorSec = mssql_query($sqlSec);
	  ?>
	  </table>

		<!--
      </td>
      <tr>
      	<td>
        -->
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="right">
                <input name="recarga" type="hidden" id="recarga" value="1">
                <input name="accion" type="hidden" id="accion" value="<? echo $accion;?>">
               
                <input name="Submit" type="submit" class="Boton"  
                value="<? if ($accion==3) { echo "Borrar"; } else { echo "Grabar"; } ?>"  onClick="envia2()">
                <? if ($accion==3)
                { ?> <input name="Cancelar" type="button" class="Boton" id="Cancelar" 
                     onClick="MM_callJS('window.close();')" value="Cancelar">
                <? } ?>		</td>
          </tr>
        </table>    
        </td>
    <!--  </tr>	-->
  </tr>
        <!-- BOTONES-->
           
     
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
 
 </form>
</table>
   
</body>
</html>

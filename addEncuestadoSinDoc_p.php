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

//Libreria de Funciones
include('funcionesCSE.php');

//Establecer la conexión a la base de datos
$conexion = conectar();

//08 Agosto 2011
//Laura Gamboa



if($recarga!="")
{
	$Nombres = $Nombres;
	$Apellidos = $Apellidos;
	$razonSocial = $razonSocial;
	$lstTipoDoc = $lstTipoDoc;
	$Telefono = $Telefono;
	$deptoRes = $deptoRes;
	$municipioRes = $municipioRes;
	$veredaRes = $veredaRes;
}

//Trae la información de los tipos de documento 
//dbo.tbTipoDocumento
//codTipoDoc, nomTipoDoc
$sqlDoc="SELECT * FROM tmItems
		 WHERE codOpcion=4";
$cursorDoc = mssql_query($sqlDoc) ;


//$recarga = 2 si se presionó el botón Grabar
if (trim($recarga) == "2") 
{
	//Asigna el consecutivo
	$sqlSec="Select max(idEntrevistado) MaxCodigo from CSCPEntrevistado ";
	$cursorSec = mssql_query($sqlSec);
	if ($regSec=mssql_fetch_array($cursorSec)) 
	{
		$pSigEncuestado = $regSec[MaxCodigo] + 1;
	}
	else 
	{
		$pSigEncuestado = 1;
	}
	
	//Inserta los datos del encuestado
	//dbo.CSEEntrevistado
	$qry = "INSERT INTO CSCPEntrevistado(idEntrevistado, numDocumento, nombres, apellidos, codTipoDoc, telefonoFijo, telefonoCelular,	
			tieneDoc, codDepartamentoExp, codMunicipioExp, fechaGraba, usuarioGraba) " ; 
	$qry = $qry . " VALUES ( " ; 
	$qry = $qry . " " .$pSigEncuestado. ", " ; 	
	$qry = $qry . " '" .  $Documento . "', " ; 
	$qry = $qry . " '" .  $Nombres . "', " ;
	$qry = $qry . " '" .  $Apellidos . "', ";
	$qry = $qry . " '0', " ; 
	
	if($Telefono!="")
		$qry = $qry . " '" .$Telefono. "', " ; 	
	else
		$qry = $qry . " NULL, " ;
			
	if($Celular!="")
		$qry = $qry . " '" .$Celular. "', " ; 	
	else
		$qry = $qry . " NULL, " ;	

	$qry = $qry . " '0', " ; 	#	tiene documento
	
	if($dpt!="")
		$qry = $qry . " '" .$dpt. "', " ; 	
	else
		$qry = $qry . " NULL, " ;	
		
	if($mns!="")
		$qry = $qry . " '" .$mns. "', " ; 	
	else
		$qry = $qry . " NULL, " ;	
	$qry = $qry . " '".gmdate ("n/d/y")."', " ;
	$qry = $qry . " '".$_SESSION["ccfUsuID"]."' " ;
	$qry = $qry . " ) " ;
	#echo $qry."<br />";
	$cursorIn = mssql_query($qry) ;
	/*if($_SESSION["sgcUsuID"]=='1013588894')
	{
		echo $qry;
		exit;
	}*/

	if  (trim($cursorIn) != "") 
	{
		//Realiza la asociación al formulario	
		/*
		dbo.CSEFichaEntrevistado
		codProyecto, codModulo, nroEncuesta, idEntrevistado, tipoPersona,fechaGraba, usuarioGraba, fechaMod, usuarioMod
		*/
		$query2 = "INSERT INTO CSCPFichaEntrevistado(codProyecto, codModulo, numFormulario, consecutivo, idEntrevistado, tipoPersona,
				   usuarioGraba, fechaGraba) ";
		$query2 = $query2 . " VALUES (" ;
		$query2 = $query2 . $_SESSION["ccfProyecto"] . " , " ; 
		$query2 = $query2 . $_SESSION["ccfModulo"] . " , " ; 
		$query2 = $query2 . "'".$_SESSION["ccfFormulario"] . "', " ; 
		$query2 = $query2 . "'".$_SESSION["ccfConsecutivo"] . "', " ; 
		$query2 = $query2 . $pSigEncuestado . ", ";	
		$query2 = $query2 . $evt . ", ";
		$query2 = $query2 . " '".$_SESSION["ccfUsuID"]."', " ;
		$query2 = $query2 . " '".gmdate ("n/d/y")."' " ;
		$query2 = $query2 . " ) ";
		#echo $query2."<br />";
		$cursor2 = mssql_query($query2) ;
	} 	
	
	if(trim($cursor2) != "") 
	{
		echo ("<script>alert('La Grabación se realizó con éxito');</script>");
	}
	else
	{
		echo ("<script>alert('Error durante la Grabación. Verifique la información');</script>");
	}
	#/*	Determina la pagina a la que debe redireccionar dependiendo el tipo de persona que valla a registrar
	if( $evt == 1 )
		$site = "frmCensoLocaliza01.php";
	else if( $evt == 2 )
		$site = "frmCensoIdPredio02.php";
	echo "<script>
			window.close();
			MM_openBrWindow('".$site."?miAncla=$Opc','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
		  </script>";
	#*/
}
 ?>

<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">

<SCRIPT language=JavaScript>
<!--
function envia1()
{ 
//alert ("Entro a envia 1");
document.form1.recarga.value="1";
document.form1.submit();
}

function envia2()
{ 
var v1,v2,v3, v4, v5, v6, i, CantCampos, msg1, msg2, msg3, msg4, msg5, msg6, mensaje;
v1= v2= v3= v4= v5= v6 ='s';
msg1 = msg2 = msg3 = msg4 = msg5 = msg6 ='';
mensaje = '';
	//   lgExpedicion  
	if( document.form1.Nombres.value == "" ){
		v1 = 'n';
		msg1 = "El Nombre es obligatorio.\n";
	}
	if( document.form1.Apellidos.value == "" ){
		v2 = 'n';
		msg2 = "El Apellido es obligatorio.\n";
	}
	if( document.form1.Documento.value == "" ){
		v3 = 'n';
		msg3 = " obligatorio.\n";
	}
	/*
	if( document.form1.lgExpedicion.value == "" ){
		v4 = 'n';
		msg4 = "El Lugar de origen es obligatorio.\n";
	}
	//*/
	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s') ) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
//		alert (document.form1.recarga.value);
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 + msg4 + msg5 + msg6;
		alert (mensaje);
	}	
}
//-->
function keyNum(){	
	if (event.keyCode < 48 || event.keyCode > 57){
		event.returnValue = false;
	}
}

function keyLetter(){	
	if (event.keyCode > 48 && event.keyCode < 57){
		event.returnValue = false;
	}
}
</SCRIPT>
</head>
<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#00344C">
<form name="form1" method="post" action="">
  <tr>
    <td>
    
    <!-- Titulo -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla">
        .: Persona entrevistada  -
        <? 
		  if($evt==1)
		  	echo "Encuestado";
		  if($evt==2)
		  	echo "Propietario";		   
		?>
        </td>
        </tr>
    </table>
  
    <!-- Campos -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="25%" class="TituloTabla2"><span class="TituloTabla1">Nombres</span></td>
        <td class="TxtTabla">
			<input name="Nombres" type="text" class="CajaTexto" id="Nombres" value="<? echo $Nombres; ?>" onKeyPress="keyLetter();" size="70"></td>
      </tr>
	  
      <tr>
        <td width="25%" class="TituloTabla2">Apellidos</td>
        <td class="TxtTabla"><input name="Apellidos" type="text" class="CajaTexto" id="Apellidos" value="<? echo $Apellidos; ?>" onKeyPress="keyLetter();" size="70"></td>
      </tr>
	  
	  <? if($evt==2){?>
	  <? }?>
	  
      <tr>
        <td width="25%" height="20" class="TituloTabla2">Documento </td>
        <td class="TxtTabla">
        <?
			//Búsqueda del número de documento siguiente
			$sql = "Select max(cast(numDocumento as int)) documento from CSCPEntrevistado where tieneDoc = 0";
			$qry = mssql_fetch_array( mssql_query( $sql ) );
			if( $qry[documento] != 0 )
				$idDoc = $qry[documento] + 1;
			else
				$idDoc = 1;			
		?>
        <input name="Documento" type="text" class="CajaTexto" id="Documento" value="<? echo $idDoc ; ?>" size="30" readonly >
        </td>
      </tr>
      <tr>
        <td height="20" class="TituloTabla2">Departamento origen</td>
        <td class="TxtTabla"><?
			$sql = "select  * from tmDepartamentos order by nomDepartamento";
			$qry = mssql_query( $sql );
		?>
          <select name="dpt" id="dpt" class="CajaTexto" onChange="document.form1.submit();">
            <option value="">::: Selecciones un Departamento :::</option>
            <?	
				while( $rw = mssql_fetch_array( $qry ) ){
					if( $dpt == $rw[codDepartamento] )
						$select = "selected";
					else
						$select = "";
			?>
            <option value="<?=	$rw[codDepartamento]	?>" <?= $select	?> >
              <?= $rw[nomDepartamento]	?>
              </option>
            <?	}	?>
          </select></td>
      </tr>
      <tr>
        <td height="20" class="TituloTabla2">Municipio origen</td>
        <td class="TxtTabla"><?
			$sqlM = "select  * from tmMunicipios where codDepartamento = ".$dpt." order by nomMunicipio";
			$qryM = mssql_query( $sqlM );
		?>
          <select name="mns" id="mns" class="CajaTexto">
            <option value="">::: Selecciones un Municipio :::</option>
            <?	while( $rwM = mssql_fetch_array( $qryM ) ){	?>
            <option value="<?=	$rwM[codMunicipio]	?>">
              <?= $rwM[nomMunicipio]	?>
              </option>
            <?	}	?>
          </select></td>
      </tr>
	<?    
	//Búsqueda de los departamentos disponibles
	  $sqlDep = "SELECT * FROM tmDepartamentos";
	  $cursorDep = mssql_query($sqlDep);
	?>
	  <!--DEPARTAMENTO -->

<?
		
	  //Búsqueda de los municipios disponibles
	  $sqlMun = "SELECT * FROM tmMunicipios
	  			 WHERE codDepartamento=".$depto;
	  $cursorMun = mssql_query($sqlMun);
	  ?>
      <!--MUNICIPIO -->
	  
	  
	  <?
	  //Búsqueda de las veredas disponibles
	  $selVer = "SELECT * FROM tmVeredas
	  			 WHERE codDepartamento=".$depto."
				 AND codMunicipio=".$municipio;
	  $cursorVer = mssql_query($selVer);
	  ?>
      
      <!--VEREDA -->

	  <? 
	  #if($evt==2){ 
	     
	//Búsqueda de los departamentos disponibles
	  $sqlDep = "SELECT * FROM tmDepartamentos";
	  $cursorDep = mssql_query($sqlDep);
	?>
	  <!--DEPARTAMENTO 
	  <tr>
        <td class="TituloTabla2">Departamento Residencia </td>
        <td class="TxtTabla"><select name="deptoRes" class="CajaTexto" id="deptoRes" onChange="document.form1.submit();" style="width:250px">
        <option value=""></option>
		<?
		while ($regDep = mssql_fetch_array($cursorDep))
		{
			$selDep = "";
			if($regDep[codDepartamento]==$deptoRes)
			{
				$selDep = "selected";
			}?>
			<option value="<?php echo $regDep[codDepartamento]; ?>" <? echo $selDep;?>><? echo $regDep[nomDepartamento];?></option>
		<? } ?>
		</select></td>
      </tr>
-->
	<?
	  //Búsqueda de los municipios disponibles
	  $sqlMun = "SELECT * FROM tmMunicipios
	  			 WHERE codDepartamento=".$deptoRes;
	  $cursorMun = mssql_query($sqlMun);
	  ?>
      <!--MUNICIPIO -->	
	  <?
	  //Búsqueda de las veredas disponibles
	  $selVer = "SELECT * FROM tmVeredas
	  			 WHERE codDepartamento=".$deptoRes."
				 AND codMunicipio=".$municipioRes;
	  $cursorVer = mssql_query($selVer);
	  ?>
      
      <!--VEREDA -->	
	  <tr>
            <td class="TituloTabla2">Telefonos</td>
            <td class="TxtTabla"><input name="Telefono" type="text" class="CajaTexto" id="Telefono" value="<? echo $Telefono; ?>" onKeyPress="keyNum();" size="30"></td>
          </tr>
          <tr>
            <td width="25%" class="TituloTabla2">Celular</td>
            <td class="TxtTabla"><input name="Celular" type="text" class="CajaTexto" id="Celular" value="<? echo $Celular; ?>" onKeyPress="keyNum();" size="30"></td>
          </tr>
   <? #}//cierra if($evt==2)
   ?>
	  
     
    </table>
    
    <!-- Botones -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
        	<input name="recarga" type="hidden" id="recarga" value="1">
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

	<!-- Copyriht -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" class="copyr"> powered by INGETEC S.A - 2012</td>
      </tr>
    </table>	
    
	</td>
  </tr>
</form>  
</table>


</body>
</html>

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

//Abre la conexión a la BD
include('funcionesCSCP.php');

//Establecer la conexión a la base de datos
$conexion = conectar();


//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	$cursorTr = mssql_query("BEGIN TRANSACTION");

	$r = 1;
	$error = '';
	while( $r <= 4 ){
		$cenForm = 'censista'.$r;
		$hora = 'hr'.$r;
		$fecha = 'fch'.$r;
		$txt = 'txtOb'.$r;
		$r++;
		//Búsqueda del mayor consecutivo
		$sqlMax = "SELECT MAX(consecFirma) maxSec FROM CSCPFichaFirmas";	
		$cursorMax = mssql_query($sqlMax);
		$regMax = mssql_fetch_array($cursorMax);
		if($regMax[maxSec])
			$sigConsec = $regMax[maxSec]+1;
		else
			$sigConsec = 1;
		
		//Graba los datos del grupo de trabajo de campo
		$sqlTp = "Select codPerfil from tmUsuarios where numDocumento ='".${$cenForm}."'";
		$qryTp = mssql_fetch_array( mssql_query( $sqlTp ) );

//echo $sqlTp." --- *** <br> ".${$cenForm}." *** cdo perfil $qryTp[codPerfil] ///// ".mssql_get_last_message()."<br><br>";

		$sqlIn = "INSERT INTO CSCPFichaFirmas (codProyecto, codModulo, numFormulario, consecutivo, consecFirma, codItemTipoResponsable, usuarioResponsable,
					fechaVerifica, horaVerifica, observaciones, usuarioGraba, fechaGraba) ";
		$sqlIn = $sqlIn . " VALUES ( ";
		$sqlIn = $sqlIn . " " .$_SESSION["ccfProyecto"] . ", ";
		$sqlIn = $sqlIn . " " .$_SESSION["ccfModulo"] . ", ";
		$sqlIn = $sqlIn . " '" .$_SESSION["ccfFormulario"] . "', ";
		$sqlIn = $sqlIn . " '" .$_SESSION["ccfConsecutivo"] . "', ";	#	Consecutivo
		$sqlIn = $sqlIn . " " .$sigConsec . ", ";
		$sqlIn = $sqlIn . " '" .$qryTp[codPerfil] . "', ";	#	Tipo
		$sqlIn = $sqlIn . " '" .${$cenForm} . "', ";	#	Responsable
		$sqlIn = $sqlIn . " '" .date( ${$fecha} ). "', ";	#	Fecha
		$sqlIn = $sqlIn . " '" .${$hora}. "', ";	#	Hora	
		$sqlIn = $sqlIn . " '" .${$txt}. "', ";	#	Observacion
		$sqlIn = $sqlIn . " '" .$_SESSION["ccfUsuID"] . "', ";
		$sqlIn = $sqlIn . " '" .gmdate ("n/d/y") . "' ";
		$sqlIn = $sqlIn . " ) " ;


		
		$cursorIn = mssql_query($sqlIn);
//		echo $sqlIn." --- *** <br> ".mssql_get_last_message()."<br><br>";
		if( !$cursorIn )
			$error = 'NO';
	}


	if  (trim($error) != "NO") 
	{
		$curComm = mssql_query("COMMIT TRANSACTION");
		echo "<script>alert('La grabación se realizó con éxito.');</script>";
	}
	else 
	{
		$curRoll = mssql_query("ROLLBACK TRANSACTION");
		echo "<script>alert('Error durante la grabación');</script>";
	}

	$volverA = "";
	$volverA = Genera_Pagina($Opc,$pag);
	#/*

	echo "<script>
			window.close();
			MM_openBrWindow('frmCensoControl11.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
		  </script>";
	#*/
}
?>

<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Guaic&aacute;ramo  :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="imagenes/icoIngetec.ico">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<SCRIPT language=JavaScript>
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function envia2(){ 
	var v1, v2, v3, v4, v5, v6;
	var m1, m2, m3, m4, m5, m6, msj;
	var tm, fch;
	//	Establece el año maximo
	var anio = new Date();
	var a = anio.getYear();
	
	v1 = v2 = v3 = v4 = v5 = v6 = 's';	
	m1 = m2 = m3 = m4 = m5 = m6 = '';
	for( var i = 1; i <=4; i++){
		//	Verificar Campos vacíos
		if( document.getElementById('censista'+i).value == "" ){
			v1 = 'n';
			m1 = 'Seleccione un censista.\n';
		}
		if( document.getElementById('fch'+i).value == "" ){
			v2 = 'n';
			m2 = 'Debe ingresar la fecha.\n';
		}
		///*
		if( document.getElementById('hr'+i).value == "" ){
			v3 = 'n';
			m3 = 'Debe ingresar la hora.\n';
		}	
		/*
		if( document.getElementById('txtOb'+i).value == "" ){
			v4 = 'n';
			m4 = 'Debe ingresar la observación.\n';
		}
		*/
		//	Verificar hora correcta
		tm =document.getElementById('hr'+i).value.split( ':' );
		if( ( tm[0] > 23 ) || ( tm[1] > 59 ) ){
			v5 = 'n';
			m5 = 'La hora no corresponde a la hora militar.\n';
		}
		//	Verificar fecha correcta
		fch =document.getElementById('fch'+i).value.split( '/' );
		if( ( fch[0] > 12 ) || ( fch[1] > 31 ) || ( fch[2] > a ) ){
			v6 = 'n';
			m6 = 'La fecha no es valida.\n';
		}
		//*/
	}
	
	if( (v1=='s') && (v2=='s') && (v3=='s') && (v4=='s') && (v5=='s') && (v6=='s') )
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else{
		msj = m1 + m2 + m3 + m4 + m5 + m6;
		alert(msj);
	}	
}
function formato( opt, input ){
	switch( opt ){
		case 1:
			if( input.value.length == 2 || input.value.length == 5 )
				input.value += '/';
			break;
		case 2:
			if( input.value.length == 2 )	
				input.value += ':';
			break;
	}
}
function keyNum( input ){
	if ( event.keyCode < 45 || event.keyCode > 57) 
		event.returnValue = false	
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#00344C">
<form name="form1" method="post" action="">
  <tr>
    <td>
	
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="TituloTabla">.: Control del censo </td>
      </tr>
    </table>
	
	<? //Búsuqeda de la información de los censistas
	
	//Búsqueda de la información de la persona entrevistada
	$sqlEntrev = "SELECT CSCPFichaEntrevistado.codProyecto, CSCPFichaEntrevistado.codModulo, CSCPFichaEntrevistado.numFormulario, CSCPFichaEntrevistado.idEntrevistado, 
			 CSCPFichaEntrevistado.tipoPersona, CSCPEntrevistado.numDocumento, CSCPEntrevistado.nombres, CSCPEntrevistado.apellidos, 
			 CSCPEntrevistado.telefonoFijo, tmItems.nomItem AS nomTipoDoc
			 FROM CSCPFichaEntrevistado INNER JOIN
			 CSCPEntrevistado ON CSCPFichaEntrevistado.idEntrevistado = CSCPEntrevistado.idEntrevistado INNER JOIN
			 tmItems ON CSCPEntrevistado.codTipoDoc = tmItems.codItem";
	$sqlEntrev = $sqlEntrev." WHERE CSCPFichaEntrevistado.codProyecto = " . $_SESSION["ccfProyecto"];
	$sqlEntrev = $sqlEntrev." AND CSCPFichaEntrevistado.codModulo = " . $_SESSION["ccfModulo"] ;
	$sqlEntrev = $sqlEntrev." AND CSCPFichaEntrevistado.numFormulario = '" . $_SESSION["ccfFormulario"] . "' ";
	$sqlEntrev = $sqlEntrev." AND CSCPFichaEntrevistado.tipoPersona=1";
	$cursorEnterv = mssql_query($sqlEntrev);
	$regEntrev = mssql_fetch_array($cursorEnterv);
	#echo $sqlEntrev;
	?>
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="15%" class="TituloTabla1">Responsable</td>
        <td class="TituloTabla1">Nombre</td>
        <td class="TituloTabla1">Fecha Revisi&oacute;n</td>
        <td class="TituloTabla1">Hora Revisi&oacute;n</td>
        <td class="TituloTabla1">Observaci&oacute;n</td>
      </tr>
        <?
			$sqITem = "Select * from tmItems Where codOpcion = 130";
			$qryItem = mssql_query( $sqITem );
			$r = 1;
			while( $rwItem = mssql_fetch_array( $qryItem ) ){
		?>
	  <tr>
	    <td width="15%" class="TituloTabla1"><?= $rwItem[nomItem] ?></td>
	    <td class="TxtTabla">
		<?
			switch( $rwItem[codItem] ){
				case 670:	$opt = 5; break;
				case 673:	$opt = 2; break;
				case 671: 	$opt = 6; break;
				case 672: 	$opt = 7; break;				
			}
			$sqlCens = "SELECT * FROM tmUsuarios WHERE codPerfil = ".$opt;
			#echo $sqlCens;
			$cursorCens = mssql_query($sqlCens);
		?>
        <select name="censista<?= $r ?>" class="CajaTexto" id="censista<?= $r ?>">
	      <option value="">:::Seleccione <?= substr( $rwItem[nomItem], 3 );?>:::</option>
	      <?
			while($regCens = mssql_fetch_array($cursorCens))
			{
				$nomCensista = $regCens[apellidoUsuario]." ".$regCens[nombreUsuario];
				$selCensista = "";
				/*
				if( $censista == $regCens[numDocumento] ){
					$selCensista = "selected";
				}
				*/
				if( $censista[$r] == $regCens[numDocumento] ){
					$selCensista = "selected";
				}
				?>
	      <option value="<? echo $regCens[numDocumento]; ?>" <? echo $selCensista; ?>><? echo $nomCensista; ?></option>
	      <?
			}
			?>
	      </select></td>
	    <td class="TxtTabla">
        <input type="text" name="fch<?= $r ?>" id="fch<?= $r ?>" class="CajaTexto" size="20" onKeyPress="formato( 1, this );keyNum( this );" maxlength="10" value="<?= $fch ?>" />
        (mm/dd/aaaa) 
        </td>
	    <td class="TxtTabla">
        <input type="text" name="hr<?= $r ?>" id="hr<?= $r ?>" class="CajaTexto" size="20" onKeyPress="formato( 2, this );keyNum( this );" maxlength="5" value="<?= $hr ?>" />
        (hh:mm) 
		</td>
	    <td class="TxtTabla">
        <textarea name="txtOb<?= $r ?>" id="txtOb<?= $r ?>" class="CajaTexto" cols="40"></textarea></td>
	    </tr>
        <?	$r++; }	?>
        </table>
	
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="recarga" type="hidden" id="recarga" value="1">
			<input name="Submit" type="button" class="Boton" value="Grabar" onClick="envia2()">		  
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
	</table>	</td>
  </tr>
  </form>
</table>

</body>
</html>

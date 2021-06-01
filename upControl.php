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
	$r = 1;
	$error = '';
	if( $accion == 2 ){
	while( $r <= 4 ){
		$cenForm = 'censista'.$r;
		$usuario = 'id'.$r;
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
		$sqlTp = "Select codPerfil from tmUsuarios where numDocumento = ".${$cenForm};
		$qryTp = mssql_fetch_array( mssql_query( $sqlTp ) );
		$sqlIn = "UPDATE CSCPFichaFirmas SET ";
		#$sqlIn = $sqlIn . " codItemTipoResponsable = '" .$qryTp[codPerfil] . "', ";	#	Tipo
		$sqlIn = $sqlIn . " usuarioResponsable = '" .${$cenForm} . "', ";	#	Responsable
		$sqlIn = $sqlIn . " fechaVerifica = '" .${$fecha}. "', ";	#	Responsable
		$sqlIn = $sqlIn . " horaVerifica = '" .${$hora}. "', ";	#	Responsable	
		$sqlIn = $sqlIn . " observaciones = '" .${$txt}. "', ";	#	Responsable
		$sqlIn = $sqlIn . " usuarioMod = '" .$_SESSION["ccfUsuID"] . "', ";
		$sqlIn = $sqlIn . " fechaMod = '" .gmdate ("n/d/y") . "' ";
#		$sqlIn = $sqlIn . " ) " ;
		$sqlIn = $sqlIn . " WHERE ";
		$sqlIn = $sqlIn . " codProyecto = " .$_SESSION["ccfProyecto"] . " AND ";
		$sqlIn = $sqlIn . " codModulo = " .$_SESSION["ccfModulo"] . " AND ";
		$sqlIn = $sqlIn . " numFormulario = '" .$_SESSION["ccfFormulario"] . "' AND ";
		$sqlIn = $sqlIn . " consecutivo = '" .$_SESSION["ccfConsecutivo"] . "' AND ";	#	Consecutivo		
		$sqlIn = $sqlIn . " usuarioResponsable = '" .${$usuario}."'";	#	Consecutivo		
		#	
		#echo $sqlIn."<br />";
		
		$cursorIn = mssql_query($sqlIn);
		if( !$cursorIn )
			$error = 'NO';
	}
	}
	else if( $accion == 3 ){
		while( $r <= 4 ){
			$cenForm = 'censista'.$r;
			$hora = 'hr'.$r;
			$fecha = 'fch'.$r;
			$txt = 'txtOb'.$r;
			$r++;		
			$sqlIn = "DELETE FROM CSCPFichaFirmas ";
	#		$sqlIn = $sqlIn . " ) " ;
			$sqlIn = $sqlIn . " WHERE ";
			$sqlIn = $sqlIn . " codProyecto = " .$_SESSION["ccfProyecto"] . " AND ";
			$sqlIn = $sqlIn . " codModulo = " .$_SESSION["ccfModulo"] . " AND ";
			$sqlIn = $sqlIn . " numFormulario = '" .$_SESSION["ccfFormulario"] . "' AND ";
			$sqlIn = $sqlIn . " consecutivo = '" .$_SESSION["ccfConsecutivo"] . "' AND ";	#	Consecutivo		
			$sqlIn = $sqlIn . " usuarioResponsable = '" .${$cenForm} . "' ";	#	Responsable
			#echo $sqlIn."<br />";
		
			$cursorIn = mssql_query($sqlIn);
			if( !$cursorIn )
				$error = 'NO';
		}
	}
	if  (trim($error) != "NO") 
		echo "<script>alert('La grabación se realizó con éxito.');</script>";
	else 
		echo "<script>alert('Error durante la grabación');</script>";

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
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
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
	var a = anio.getFullYear();
	
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
		//*/
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
	
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td width="15%" class="TituloTabla1">Responsable</td>
        <td class="TituloTabla1">Nombre</td>
        <td class="TituloTabla1">Fecha Revici&oacute;n</td>
        <td class="TituloTabla1">Hora Revici&oacute;n</td>
        <td class="TituloTabla1">Observaci&oacute;n</td>
      </tr>
        <?
			if( $accion == 3 )
				$dishable = 'disabled';
			else
				$dishable = '';
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
				case 673:	$opt = 3; break;
				case 671: 	$opt = 6; break;
				case 672: 	$opt = 7; break;				
			}
			$sqlCens = "SELECT * FROM tmUsuarios WHERE codPerfil = ".$opt;
			$sqlLoad = "Select usuarioResponsable, fechaVerifica, horaVerifica, observaciones From CSCPFichaFirmas ";
			$sqlLoad = $sqlLoad." WHERE CSCPFichaFirmas.codProyecto = " . $_SESSION["ccfProyecto"];
			$sqlLoad = $sqlLoad." AND CSCPFichaFirmas.codModulo = " . $_SESSION["ccfModulo"] ;
			$sqlLoad = $sqlLoad." AND CSCPFichaFirmas.numFormulario = '" . $_SESSION["ccfFormulario"] . "' and codItemTipoResponsable = ".$opt;
			#$sqlLoad = $sqlLoad." AND CSCPFichaEntrevistado.tipoPersona=1";
			$qryLoad = mssql_fetch_array( mssql_query( $sqlLoad ) );
			#echo $sqlLoad;
			#$qryCens = mssql_fetch_array( mssql_query( $sqlCens ) );
			$cursorCens = mssql_query($sqlCens);
			if( $accion == 3 ){
		?>
        		<input type="hidden" id="censista<?= $r ?>" name="censista<?= $r ?>" value="<?= $qryLoad[usuarioResponsable] ?>" />                
        <?
			}
		?>
        <input type="hidden" id="id<?= $r ?>" name="id<?= $r ?>" value="<?= $qryLoad[usuarioResponsable] ?>" />
		<?= "Responsable : ".$qryLoad[usuarioResponsable] ?>

        <select name="censista<?= $r ?>" class="CajaTexto" id="censista<?= $r ?>" <?= $dishable ?>  >
	      <option value="">:::Seleccione <?= substr( $rwItem[nomItem], 3 );?>:::</option>
	      <?
			while($regCens = mssql_fetch_array($cursorCens))
			{
				$nomCensista = $regCens[apellidoUsuario]." ".$regCens[nombreUsuario];
				$selCensista = "";
				if( $qryLoad[usuarioResponsable] == $regCens[numDocumento] ){
					$selCensista = "selected";
				}
				?>
	      <option value="<? echo $regCens[numDocumento]; ?>" <? echo $selCensista; ?>><? echo $nomCensista; ?></option>
	      <?
			}
			?>
	      </select></td>
	    <td class="TxtTabla">
        <input type="text" <?= $dishable ?> name="fch<?= $r ?>" id="fch<?= $r ?>" class="CajaTexto" size="20" onKeyPress="formato( 1, this );keyNum( this );" maxlength="10" value="<?= date("m/d/Y",strtotime($qryLoad[fechaVerifica])) ?>" />
        (mm/dd/aaaa) 
        </td>
	    <td class="TxtTabla">
        <input type="text" <?= $dishable ?> name="hr<?= $r ?>" id="hr<?= $r ?>" class="CajaTexto" size="20" onKeyPress="formato( 2, this );keyNum( this );" maxlength="5" value="<?= $qryLoad[horaVerifica] ?>" />
        (hh:mm) 
		</td>
	    <td class="TxtTabla">
        <textarea name="txtOb<?= $r ?>" id="txtOb<?= $r ?>" class="CajaTexto" cols="40" <?= $dishable ?> ><?= $qryLoad[observaciones]?></textarea></td>
	    </tr>
        <?	$r++; }	?>
        </table>
	
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<input name="recarga" type="hidden" id="recarga" value="1">
            <?
				if( $accion==2 )
					$texto = "Actualizar";
				else
					$texto = "Borrar";
			?>
			<input name="Submit" type="button" class="Boton" value="<?= $texto ?>" onClick="envia2()">
            <?
				if( $accion==3 ){
			?>
					<input name="Submit" type="button" class="Boton" value="Cancelar" onClick="javascript:window.close()">
             <? } ?>

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

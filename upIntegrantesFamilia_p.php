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

//$recarga = 2 si se presionó el botón Grabar
if ($recarga == "2") 
{
	$ban=0;
	if($accion==2)
	{	
		$qryDoc[documento]= 0;  //si el numero de documento es diferente al almacenado inicialmente
		if($doc_original!=$pNumDoc)
		{	
			$sqlDoc	= "SELECT COUNT(*) documento FROM CSCPFichaIntegrantesFamilia WHERE numDoc = '".$pNumDoc."' AND nroFamilia = ".$_SESSION["ccfFamilia"];
			$qryDoc = mssql_fetch_array( mssql_query( $sqlDoc ) );
		}

	if( $qryDoc[documento] == 0 )
	{

		$qry = "UPDATE CSCPFichaIntegrantesFamilia SET ";
		$qry = $qry . " nombres = '".$pNombres ."',";
		$qry = $qry . " apellidos = '".$pApellidos ."',";
		$qry = $qry . " codItemTipoDoc = ".$pCodItemTipoDoc .",";
		$qry = $qry . " numDoc = '".$pNumDoc ."',";		
		#	SEXO
		if(trim($pCodItemSexo) != "")
			$qry = $qry." codItemSexo = ". $pCodItemSexo .",";
		else
			$qry = $qry." codItemSexo = NULL,";
	
		#	LUGAR DE NACIMIENTO
		if(trim($pCodItemLugarNacimiento) != "")
			$qry = $qry. " codItemLugarNac = ".$pCodItemLugarNacimiento .",";
		else
			$qry = $qry. " codItemLugarNac = NULL,";
		
		#	EDAD CUMPLIDA
		if(trim($pEdad) != "")
			$qry = $qry. " edadCumplida = ".$pEdad .",";
		else
			$qry = $qry. " edadCumplida = NULL,";
		
		#	ESTADO CIVIL
		if(trim($pCodItemEstadoCivil) != "")
			$qry = $qry. " codItemEstadoCivil = ".$pCodItemEstadoCivil .",";
		else
			$qry = $qry. " codItemEstadoCivil = NULL,";
		
		#	LEGALMENTE
		if(trim($pCodLegalmente) != "")
			$qry = $qry. " codItemLegalmente = ".$pCodLegalmente .",";
		else
			$qry = $qry. " codItemLegalmente = NULL,";
		
		#	PARENTESCO
		if(trim($pCodParentesco) != "")
			$qry = $qry. " codItemParentesco = '".$pCodParentesco ."',";
		else
			$qry = $qry. " codItemParentesco = NULL,";		
		
		#	GRUPO ÉTNICO
		if(trim($pCodGrupo) != "")
			$qry = $qry. " codItemGrupoEtnico = ".$pCodGrupo .",";
		else
			$qry = $qry. " codItemGrupoEtnico = NULL,";
			
		#	PROGRAMA INSTITUCIONAL
		if(trim($pCodItemSalud) != "")
			$qry = $qry. " codItemAfiliaSalud = ".$pCodItemSalud .",";
		else
			$qry = $qry. " codItemAfiliaSalud = NULL,";
		
		#	LIMITACIONES
		if(trim($pCodItemLimitaciones) != "")
			$qry = $qry. " codItemLimitacion = ".$pCodItemLimitaciones .",";
		else
			$qry = $qry. " codItemLimitacion = NULL,";
		
		#	MUJER GESTANTE
		if(trim($pCodItemMGestante) != "")
			$qry = $qry. " codItemGestantes = ".$pCodItemMGestante .",";
		else
			$qry = $qry. " codItemGestantes = NULL,";
		
		#	MUJER LACTANTE
		if(trim($pCodItemMLactante) != "")
			$qry = $qry. " codItemLactantes = ".$pCodItemMLactante .",";
		else
			$qry = $qry. " codItemLactantes = NULL,";
		
		#	PROGRAMA
		if(trim($pCodItemPrograma) != "")
			$qry = $qry. " codItemPrograma = ".$pCodItemPrograma .",";
		else
			$qry = $qry. " codItemPrograma = NULL,";
		
		#	LEER Y ESCRIBIR
		if(trim($pCodItemLeer) != "")
			$qry = $qry. "codItemLeeEscribe = ".$pCodItemLeer .",";
		else
			$qry = $qry. "codItemLeeEscribe = NULL,";
		
		#	NIVEL EDUCATIVO
		if(trim($pCodNivel) != "")
			$qry = $qry. " codItemNivelEduca = ".$pCodNivel .",";
		else
			$qry = $qry. " codItemNivelEduca = NULL,";
		
		#	ASISTE A LA ESCUELA
		if(trim($pCodItemAsiste) != "")
			$qry = $qry. " codItemAsiste = ".$pCodItemAsiste .",";
		else
			$qry = $qry. " codItemAsiste = NULL,";
		
		#	UBICACION INSTITUCION pCodUbicacion pCodInstitucion
		if(trim($pCodUbicacion) != "")
			$qry = $qry. " codItemInstUbica = ".$pCodUbicacion .",";
		else
			$qry = $qry. " codItemInstUbica = NULL,";
	
		#	INSTITUCION
		if(trim($pCodInstitucion) != "")
			$qry = $qry. "codItemInstEducativa = ".$pCodInstitucion .",";
		else
			$qry = $qry. "codItemInstEducativa = NULL,";
		
		#	OFICIO U OCUPACIÓN
		if(trim($pCodOficio) != "")
			$qry = $qry. " codItemOcupacion = ".$pCodOficio .",";
		else
			$qry = $qry. " codItemOcupacion = NULL,";
		
		#	INGRESOS MENSUALES
		if(trim($pCodItemIngresoMensual) != "")
			$qry = $qry. "codItemIngreso = ". $pCodItemIngresoMensual .",";
		else
			$qry = $qry. "codItemIngreso = NULL,";
	
		#	TIEMPO ACTIVIDAD
		if(trim($pMActividades) != "")
			$qry = $qry." mesesDedicacion = ". $pMActividades .",";
		else
			$qry = $qry. " mesesDedicacion = NULL,";
	
			
		$qry = $qry . " fechaMod = '" . gmdate("n/d/y") ."', ";
		$qry = $qry . " usuarioMod = '".$_SESSION["ccfUsuID"]."'" ;	
		$qry = $qry . "	WHERE nroFamilia = ".$_SESSION["ccfFamilia"] ." AND " ;
		$qry = $qry . " consecFamilia = ".$f;
		#echo $qry;
		$cursorIn = mssql_query($qry) ;
		
		if  (trim($cursorIn) != "")
		{	 
			echo ("<script>alert('La grabación se realizó con éxito.');</script>");
		}
		else
		{	
			echo ("<script>alert('Error durante la grabación.');</script>");
		}	
	}
	else
		{
			$ban=1; //si el documento exite
		echo "<script>alert('Este número de documento ya esta registrado.');</script>";
		}
	}

	if($accion==3)
	{	
		$qry = "DELETE FROM CSCPFichaIntegrantesFamilia ";
		$qry = $qry. " WHERE nroFamilia=".$_SESSION["ccfFamilia"];
		$qry = $qry. " AND consecFamilia=".$f;
		#echo $qry; 
		$cursorIn = mssql_query($qry) ;
		
		if  (trim($cursorIn) != "")
		{	 
			echo ("<script>alert('La operación se realizó con éxito.');</script>");
		}
		else
		{	
			echo ("<script>alert('Error durante la operación.');</script>");
		}	
	}
	
	#$volverA = "";
	#$volverA=Genera_Pagina($Opc,$pag);		
	#/*
	if($ban!=1)
	{
	echo "<script>
			window.close();
			MM_openBrWindow('frmCensoFamiliaIntegrantes.php','winCensos','toolbar=yes,scrollbars=yes,resizable=yes,width=960,height=700');
		</script>";
	}
	#*/
}


?>
<html>
<head>
<title>::: Proyecto Hidroel&eacute;ctrico Ca&ntilde;afisto :::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<LINK REL="stylesheet" HREF="../css/estilo.css" TYPE="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) 
{ //v2.0
  window.open(theURL,winName,features);
}

//-->
</script>

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

	if (document.form1.pNombres.value == '')  
	{
		v1='n';
		msg1 = 'El Nombre del Integrante de la Familia es obligatorio. \n'
	}
	if (document.form1.pApellidos.value == '') 
	{
		v2='n';
		msg2 = 'El Apellido del Integrante de la Familia es obligatorio. \n'
	}
	if (document.form1.pNumDoc.value == '')
	{
		v3='n';
		msg3 = 'El número de documento del Integrante de la Familia es obligatorio. \n'
	}
	if (document.form1.pMActividades.value > 12 )
	{
		v4='n';
		msg4 = 'No puede superar los 12 meses. \n'
	}

	//Si todas las validaciones fueron correctas, el formulario hace submit y permite grabar
	if ((v1=='s') && (v2=='s')  && (v3=='s') && (v4=='s') && (v5=='s') &&
	    (v6=='s')&& (v7=='s')&& (v8=='s')&& (v9=='s')&& (v10=='s')) 
	{
		document.form1.recarga.value="2";
		document.form1.submit();
	}
	else 
	{
		mensaje = msg1 + msg2 + msg3 + msg4+msg5 + msg6 + msg7 + msg8+msg9 + msg10;
		alert (mensaje);
	}	
}
function MM_callJS(jsStr) 
{ //v2.0
  return eval(jsStr)
}
function keyNum(){ //	input
	if ( event.keyCode < 48 || event.keyCode > 57) 
		event.returnValue = false	
}
function keyLetter(){ //	input
	if ( ( event.keyCode < 65 || event.keyCode > 90 ) && ( event.keyCode < 97 || event.keyCode > 122 ) ) 
		event.returnValue = false;
	if ( ( event.keyCode == 32 ) || ( event.keyCode == 164 ) || ( event.keyCode == 165 ) )
		event.returnValue = true;
}
//-->
</SCRIPT>

</head>

<body  leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="fondo" >


<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#395378">
<tr>
<td bgcolor="#FFFFFF">
<!--
<table width="100%" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td>
    -->
	<form name="form1" method="post" action="">
    <!-- TITULO GENERAL -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td class="TituloTabla" align="center">Integrante del Hogar</td>
      	</tr>
    </table>

	<? //Búsqueda de los ítems para cada pregunta
		#$sqlItem = "SELECT * FROM tmItems";
		
		$sqlIntegra = "SELECT 
							fmla.nombres nmFmla, fmla.apellidos apeFmla, fmla.numDoc, fmla.codItemTipoDoc , fmla.codItemSexo, fmla.codItemLugarNac, fmla.codItemEstadoCivil
							, fmla.edadCumplida, fmla.codItemLegalmente, fmla.codItemParentesco, fmla.codItemGrupoEtnico, fmla.codItemAfiliaSalud, fmla.codItemLimitacion
							, fmla.codItemGestantes, fmla.codItemLactantes, fmla.codItemPrograma, fmla.codItemLeeEscribe, fmla.codItemNivelEduca, fmla.codItemAsiste
							, fmla.codItemInstUbica, fmla.codItemOcupacion, fmla.codItemIngreso, fmla.codItemParentesco
							, fmla.codItemInstEducativa, fmla.mesesDedicacion, fmla.consecFamilia, fmla.codItemAsiste
						FROM 
							CSCPFichaIntegrantesFamilia fmla
						WHERE";
		$sqlIntegra = $sqlIntegra." fmla.nroFamilia = ".$_SESSION["ccfFamilia"];
		$sqlIntegra = $sqlIntegra." AND fmla.consecFamilia = ".$f;
		$rwIntegrante = mssql_fetch_array( mssql_query( $sqlIntegra ) );
		$disabled = "";
		if( $accion == 3 ){
			$disabled = "disabled";
		}
		#	Tp documento
		if( $rwIntegrante['codItemTipoDoc'] == 1466 )
			$sqlIt = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 133 AND codItem = 1466";
		else
			$sqlIt = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 133 AND codItem <> 1466";
		$qr = mssql_query( $sqlIt );
		
		#	Sexo
		$sqlIt1 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 57";
		$qr1 = mssql_query( $sqlIt1 );
		
		#	Lugar de nacimiento
		$sqlIt2 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 58";
		$qr2 = mssql_query( $sqlIt2 );
		
		#	Estado civil
		$sqlIt3 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 59";
		$qr3 = mssql_query( $sqlIt3 );
		
		#	Legalmente
		$sqlIt4 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 60";
		$qr4 = mssql_query( $sqlIt4 );
		
		#	Parentesco familiar
		$sqlIt5 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 61";
		$qr5 = mssql_query( $sqlIt5 );
		
		#	Grupo étnico
		$sqlIt6 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 62";
		$qr6 = mssql_query( $sqlIt6 );
		#	Afiliación salud
		$sqlIt7 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 63";
		$qr7 = mssql_query( $sqlIt7 );
		#	Tiene limitaciones permanentes
		$sqlIt8 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 64";
		$qr8 = mssql_query( $sqlIt8 );
		#	Tiene limitaciones permanentes
		$sqlIt9 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 65";
		$qr9 = mssql_query( $sqlIt9 );
		#	Mujeres gestantes
		$sqlIt10 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 66";
		$qr10 = mssql_query( $sqlIt10 );
		#	Mujeres lactactes
		$sqlIt11 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 67";
		$qr11 = mssql_query( $sqlIt11 );
		#	Programas institucionales
		$sqlIt12 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 68";
		$qr12 = mssql_query( $sqlIt12 );
		#	Sabe leer y escribir
		$sqlIt13 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 69";
		$qr13 = mssql_query( $sqlIt13 );
		#	Nivel educativo 
		$sqlIt14 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 70";
		$qr14 = mssql_query( $sqlIt14 );
		#	Institución educativa a la que asiste
		$sqlIt15 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 71";
		$qr15 = mssql_query( $sqlIt15 );
		#	Ubicación de la institucion
		$sqlIt16 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 72";
		$qr16 = mssql_query( $sqlIt16 );
		#	Oficio u ocupacion
		$sqlIt17 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 73";
		$qr17 = mssql_query( $sqlIt17 );
		#	Ingresos mensuales
		$sqlIt18 = "SELECT codItem, nomItem, codOpcion, codModulo FROM tmItems WHERE codProyecto = 5 AND codModulo = 1 AND codOpcion = 74";
		$qr18 = mssql_query( $sqlIt18 );

	?>
	<!-- Tabla de datos -->
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
        <tr>
        <td width="30%" class="TituloTabla1">Nombre</td>
        <td class="TxtTabla">
        <input name="pNombres" type="text" class="CajaTexto" id="pNombres" value="<? echo $rwIntegrante[nmFmla]; ?>" size="50" onKeyPress="keyLetter();" <?= $disabled ?> />
        </td>
        </tr>
        
        <tr>
        <td width="30%" class="TituloTabla1">Apellido</td>
        <td class="TxtTabla">
        <input  name="pApellidos" type="text" class="CajaTexto" id="pApellidos" value="<? echo $rwIntegrante[apeFmla]; ?>" size="50" onKeyPress="keyLetter();" <?= $disabled ?> />
        </td>
        </tr>
        
        <tr>
        <td class="TituloTabla1"> Tipo de documento </td>
        <td class="TxtTabla">
        <?
			#	 $rwIntegrante['codItemTipoDoc'] == 1466 
			$read = "";
			if( $rwIntegrante['codItemTipoDoc'] == 1466 )
				$read = "readonly";
		?>
        <select name="pCodItemTipoDoc" class="CajaTexto" id="pCodItemTipoDoc" style="width:350" <?= $disabled ?> >        
          <!--	<option value="">:::Seleccione una opción:::</option>	-->
          <? 
           while($reg = mssql_fetch_array($qr))
            {
                $sel = "";
                if($reg[codItem] == $rwIntegrante[codItemTipoDoc])
                {
                    $sel = "selected";
                }
            ?>
          <option value="<? echo $reg[codItem]; ?>" <? echo $sel; ?>><? echo $reg[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">N&uacute;mero de documento </td>
        <td class="TxtTabla"><input name="pNumDoc" type="text" <? if($rwIntegrante[codItemTipoDoc]==1466){ echo "readonly"; } ?> class="CajaTexto" id="pNumDoc" value="<? echo $rwIntegrante[numDoc]; ?>" size="20" onKeyPress="keyNum();" <?= $disabled ?>  />
  		    <input name="doc_original" type="hidden" id="doc_original" value="<?php echo $rwIntegrante[numDoc]; ?>">
        </td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Sexo</td>
        <td class="TxtTabla">
        <select name="pCodItemSexo" class="CajaTexto" id="pCodItemSexo" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg1 = mssql_fetch_array($qr1))
            {
                $sel4 = "";
                if($reg1[codItem] == $rwIntegrante[codItemSexo])
                {
                    $sel4 = "selected";
                }
                ?>
          <option value="<? echo $reg1[codItem]; ?>" <? echo $sel4; ?>><? echo $reg1[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Lugar de nacimiento</td>
        <td class="TxtTabla">
        <select name="pCodItemLugarNacimiento" class="CajaTexto" id="pCodItemLugarNacimiento" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg2 = mssql_fetch_array($qr2))
            {
                $sel2 = "";
                if($reg2[codItem] == $rwIntegrante[codItemLugarNac])
                {
                    $sel2 = "selected";
                }
                ?>
          <option value="<? echo $reg2[codItem]; ?>" <? echo $sel2; ?>><? echo $reg2[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Edad cumplida</td>
        <td class="TxtTabla">



        <input name="pEdad" type="text" class="CajaTexto" id="pEdad" value="<? echo $rwIntegrante[edadCumplida]; ?>" size="20" onKeyPress="keyNum();" <?= $disabled ?> maxlength="3" />
        </td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Estado civil </td>
        <td class="TxtTabla">
        <select name="pCodItemEstadoCivil" class="CajaTexto" id="pCodItemEstadoCivil" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg3 = mssql_fetch_array($qr3))
            {
                $sel3 = "";
                if($reg3[codItem] == $rwIntegrante[codItemEstadoCivil])
                {
                    $sel3 = "selected";
                }
                ?>
          <option value="<? echo $reg3[codItem]; ?>" <? echo $sel3; ?>><? echo $reg3[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
          
        <tr>
        <td class="TituloTabla1">Legalmente</td>
        <td class="TxtTabla">
        <select name="pCodLegalmente" class="CajaTexto" id="pCodLegalmente" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg4 = mssql_fetch_array($qr4))
            {
                $sel4 = "";
                if($reg4[codItem] == $rwIntegrante[codItemLegalmente])
                {
                    $sel4 = "selected";
                }
                ?>
          <option value="<? echo $reg4[codItem]; ?>" <? echo $sel4; ?>><? echo $reg4[nomItem]; ?></option>
          <?
            }
            ?>
        </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Parentesco familiar</td>
        <td class="TxtTabla">
        <select name="pCodParentesco" class="CajaTexto" id="pCodParentesco" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg5 = mssql_fetch_array($qr5))
            {
                $sel5 = "";
                if($reg5[codItem] == $rwIntegrante[codItemParentesco])
                {
                    $sel5 = "selected";
                }
                ?>
          <option value="<? echo $reg5[codItem]; ?>" <? echo $sel5; ?>><? echo $reg5[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Grupo &eacute;tnico </td>
        <td class="TxtTabla">
        <select name="pCodGrupo" class="CajaTexto" id="pCodGrupo" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg6 = mssql_fetch_array($qr6))
            {
                $sel6 = "";
                if($reg6[codItem] == $rwIntegrante[codItemGrupoEtnico])
                {
                    $sel6 = "selected";
                }
                ?>
          <option value="<? echo $reg6[codItem]; ?>" <? echo $sel6; ?>><? echo $reg6[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Afiliaci&oacute;n salud </td>
        <td class="TxtTabla">
        <select name="pCodItemSalud" class="CajaTexto" id="pCodItemSalud" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 

            while($reg7 = mssql_fetch_array($qr7))
            {
                $sel7 = "";
                if($reg7[codItem] == $rwIntegrante[codItemAfiliaSalud])
                {
                    $sel7 = "selected";
                }
                ?>
          <option value="<? echo $reg7[codItem]; ?>" <? echo $sel7; ?>><? echo $reg7[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Tiene limitaciones permanentes </td>
        <td class="TxtTabla">
        <select name="pCodItemLimitaciones" class="CajaTexto" id="pCodItemLimitaciones" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg8 = mssql_fetch_array($qr8))
            {
                $sel8 = "";
                if($reg8[codItem] == $rwIntegrante[codItemLimitacion])
                {
                    $sel8 = "selected";
                }
                ?>
          <option value="<? echo $reg8[codItem]; ?>" <? echo $sel8; ?>><? echo $reg8[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Mujer gestante</td>
        <td class="TxtTabla">
        <select name="pCodItemMGestante" class="CajaTexto" id="pCodItemMGestante" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg9 = mssql_fetch_array($qr9))
            {
                $sel9 = "";
                if($reg9[codItem] == $rwIntegrante[codItemGestantes])
                {
                    $sel9 = "selected";
                }
                ?>
          <option value="<? echo $reg9[codItem]; ?>" <? echo $sel9; ?>><? echo $reg9[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Mujer lactante</td>
        <td class="TxtTabla">
        <select name="pCodItemMLactante" class="CajaTexto" id="pCodItemMLactante" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg10 = mssql_fetch_array($qr10))
            {
                $sel10 = "";
                if($reg10[codItem] == $rwIntegrante[codItemLactantes])
                {
                    $sel10 = "selected";
                }
                ?>
          <option value="<? echo $reg10[codItem]; ?>" <? echo $sel10; ?>><? echo $reg10[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Programas institucionales</td>
        <td class="TxtTabla">
        <select name="pCodItemPrograma" class="CajaTexto" id="pCodItemPrograma" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg11 = mssql_fetch_array($qr11))
            {
                $sel11 = "";
                if($reg11[codItem] == $rwIntegrante[codItemPrograma])
                {
                    $sel11 = "selected";
                }
                ?>
          <option value="<? echo $reg11[codItem]; ?>" <? echo $sel11; ?>><? echo $reg11[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Sabe leer y escribir</td>
        <td class="TxtTabla">
        <select name="pCodItemLeer" class="CajaTexto" id="pCodItemLeer" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg12 = mssql_fetch_array($qr12))
            {
                $sel12 = "";
                if($reg12[codItem] == $rwIntegrante[codItemLeeEscribe])
                {
                    $sel12 = "selected";
                }
                ?>
          <option value="<? echo $reg12[codItem]; ?>" <? echo $sel12; ?>><? echo $reg12[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Nivel educativo </td>
        <td class="TxtTabla">
        <select name="pCodNivel" class="CajaTexto" id="pCodNivel" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg13 = mssql_fetch_array($qr13))
            {
                $sel13 = "";
                if($reg13[codItem] == $rwIntegrante[codItemNivelEduca])
                {
                    $sel13 = "selected";
                }
                ?>
          <option value="<? echo $reg13[codItem]; ?>" <? echo $sel13; ?>><? echo $reg13[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Asiste a la escuela</td>
        <td class="TxtTabla">
        <select name="pCodItemAsiste" class="CajaTexto" id="pCodItemAsiste" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
  		  /* fmla.numDoc, fmla. , fmla., fmla., fmla.codItemEstadoCivil
							, fmla.edadCumplida, fmla., fmla.codItemParentesco, fmla., fmla., fmla.
							, fmla.codItemGestantes, fmla., fmla., fmla., fmla., fmla.
							, fmla., fmla., fmla.codItemIngreso, fmla.codItemParentesco
							, fmla.codItemInstEducativa, fmla.mesesDedicacion, fmla.consecFamilia*/
            while($reg14 = mssql_fetch_array($qr14))
            {
                $sel14 = "";
                if($reg14[codItem] == $rwIntegrante[codItemAsiste])
                {
                    $sel14 = "selected";
                }
                ?>
          <option value="<? echo $reg14[codItem]; ?>" <? echo $sel14; ?>><? echo $reg14[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Instituci&oacute;n educativa a la que asiste</td>
        <td class="TxtTabla">
        <select name="pCodInstitucion" class="CajaTexto" id="pCodInstitucion" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg15 = mssql_fetch_array($qr15))
            {
                $sel15 = "";
                if($reg15[codItem] == $rwIntegrante[codItemInstEducativa])
                {
                    $sel15 = "selected";
                }
                ?>
          <option value="<? echo $reg15[codItem]; ?>" <? echo $sel15; ?>><? echo $reg15[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr> 
        <td class="TituloTabla1">Ubicaci&oacute;n de la instituci&oacute;n educativa</td>
        <td class="TxtTabla">
        <select name="pCodUbicacion" class="CajaTexto" id="pCodUbicacion" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg16 = mssql_fetch_array($qr16))
            {
                $sel16 = "";
                if($reg16[codItem] == $rwIntegrante[codItemInstUbica])
                {
                    $sel16 = "selected";
                }
                ?>
          <option value="<? echo $reg16[codItem]; ?>" <? echo $sel16; ?>><? echo $reg16[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
          
        <tr>
        <td class="TituloTabla1">Oficio, ocupaci&oacute;n o actividad econ&oacute;mica secundaria </td>
        <td class="TxtTabla">
        <select name="pCodOficio" class="CajaTexto" id="pCodOficio" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
           while($reg17 = mssql_fetch_array($qr17))
            {
                $sel17 = "";
                if($reg17[codItem] == $rwIntegrante[codItemOcupacion])
                {
                    $sel17 = "selected";
                }
                ?>
          <option value="<? echo $reg17[codItem]; ?>" <? echo $sel17; ?>><? echo $reg17[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Meses/a&ntilde;o dedicados a la actividad</td>
        <td class="TxtTabla">
        <input name="pMActividades" type="text" <?= $disabled ?> class="CajaTexto" id="pMActividades" value="<? echo $rwIntegrante[mesesDedicacion]; ?>" size="50" onKeyPress="keyNum();" maxlength="2" />
        </td>
        </tr>
        
        <tr>
        <td class="TituloTabla1">Ingreso mensual (en pesos) </td>
        <td class="TxtTabla">
        <select name="pCodItemIngresoMensual" class="CajaTexto" id="pCodItemIngresoMensual" style="width:350" <?= $disabled ?> >
          <option value="">:::Seleccione una opción:::</option>
          <? 
            while($reg18 = mssql_fetch_array($qr18))
            {
                $sel18 = "";
                if($reg18[codItem] == $rwIntegrante[codItemIngreso])
                {
                    $sel18 = "selected";
                }
                ?>
          <option value="<? echo $reg18[codItem]; ?>" <? echo $sel18; ?>><? echo $reg18[nomItem]; ?></option>
          <?
            }
            ?>
          </select></td>
        </tr>
	 
    </table>
 
    <!-- ESPACIO -->
    <table width="100%"  border="0" cellspacing="1" cellpadding="0" bordercolor="#FFFFFF">
      <tr>
        <td height="10"><input name="recarga" type="hidden" id="recarga" value="1"></td>
      </tr>
    </table>
	</form>

	<!-- BOTONES DE GRABAR -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
			<?
			if($accion == 2)
			{
				$txt = "Grabar";
			}
			if($accion == 3)
			{
				$txt = "Eliminar";
			}
			?>
			<input name="Submit2" type="button" class="Boton" value="<? echo $txt; ?>" onClick="envia2()">
            <?
			if($accion == 3)
			{
			?>
			<input name="Submit2" type="button" class="Boton" value="Cancelar" onClick="javascript:window.close();">
            <?
			}
			?>
		</td>
      </tr>
    </table>	
    
	<!-- ESPACIO -->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

	<!-- INGETEC-->
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td class="copyr"> powered by INGETEC S.A - 2012</td>
	  </tr>
	</table>	
    
	</td>
  </tr>
</table>
    
</td>
</tr>
</table>      
</body>
</html>

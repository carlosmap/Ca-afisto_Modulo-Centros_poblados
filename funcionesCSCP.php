<?php
//Inicializa las variables de sesión
session_start();

//Abre la conexión a la BD
//include('../enlaceBD.php');
include ("../verificaIngreso2.php");
?>

<script language="JavaScript" type="text/JavaScript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<?php



//echo "entró a las funciones";
//exit;

//Establecer la conexión a la base de datos
//$conexion = conectar();

//****************************************************************************/
//Funcion que define a que página se va a regresar
//$pag  =Página a la que regresa
//****************************************************************************/

function Genera_Pagina($Opc,$pag)
{
	$volverA = "";

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
	switch ($pag) 
	{ 
		case 0: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoLocaliza01cma.php"; 
			break; 

		case 1: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoLocaliza01.php"; 
			break; 
		case 2: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoIdPredio02.php"; 
			break; 
		case 3: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaMorbilidad.php"; 
			break; 	
		case 4: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActividad.php"; 
		break; 
		case 5: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaIDHogar.php"; 
		break; 	
		case 6: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActividad.php "; 
		break; 	
		case 7: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActAgro.php "; 
		break; 	
		case 8: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActExtractiva.php "; 
		break; 
		case 9: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActPesca.php "; 
		break; 	
		case 10: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActIndustrial.php "; 
		break; 	
		case 11: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActComercial.php "; 
		break; 			
		case 12: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoValoracion07.php "; 
		break; 
		case 13: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoControl11.php"; 
		break; 
			
		case 14: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoViviendaDetalle.php"; 
		break; 
		
		case 15: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActAgro.php"; 
		break; 

		case 16: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaCultural.php"; 
		break; 

		case 17: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFamiliaActIndustrial.php"; 
		break; 

		case 18: 
			$volverA ="http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoObserva13.php"; 
		break; 
		case 19: 
			$volverA =" http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoFirma08.php "; 
		break; 

		case 20: 
			$volverA =" http://www.ingetec.com.co/sistemas/sisCanafisto/cscp/frmCensoRegFotos09.php "; 
		break; 




			
	} 

return $volverA;
}

//****************************************************************************/
//Funcion que permite visualizar las opciones tipo Booleano Si/No
//$T	=Opcion
//$uni	=Es multiple Respuesta =2 Es Unica Respuesta =1
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

function Genera_Tabla_Seleccion($T,$uni,$Pag,$tipo)
{   

	//Obtener Titulo y/o Pregunta de la Sección
	//dbo.tmOpciones
	//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.tmItems
	//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
	tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
	FROM tmOpciones INNER JOIN
		 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		 tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
//echo $sqlTit." -- ".mssql_get_last_message()."<br><br>";
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);

//echo "entro ".$regTit[pregunta]."<br>";
	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros
	//dbo.CSEFichaInfoBoolean
	//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, respItem, 
	//descripcion, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlRta=" SELECT     CSCPFichaInfoBoolean.codProyecto, CSCPFichaInfoBoolean.codModulo, CSCPFichaInfoBoolean.numFormulario, CSCPFichaInfoBoolean.nroObjeto, 
                      CSCPFichaInfoBoolean.tipoObjeto, CSCPFichaInfoBoolean.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoBoolean.codItem, tmItems.nomItem, 
                      CSCPFichaInfoBoolean.respItem, CSCPFichaInfoBoolean.descripcion
FROM         CSCPFichaInfoBoolean INNER JOIN
                      tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
                      tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem AND 
                      tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoBoolean.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.nroObjeto=".$nobj;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.tipoObjeto=".$tipo;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
//echo $sqlRta." -- ".mssql_get_last_message()."<br>";
	//echo $sqlRta;

	?>
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	  <tr class="TituloTabla2">
		<td colspan="2" class="TituloTabla"><? echo $pTituloPpal;?><a name="<? echo $T; ?>"></a></td>
	  </tr>

      <?php while ($RegRta=mssql_fetch_array($cursorRta))  
	  { ?>
      <tr class="TxtTabla">
        <td width="70%"><?php echo $RegRta[nomItem]  ; ?></td>
		<td width="7%" align="center">
		<?php if ($RegRta[respItem]=='1') 
		{ ?> 
			<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0"> 
		<? } ; ?></td>
	  </tr>
	  <? } ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaInfoBoolean.php?Opc=<? echo $T;?>&uni=<? echo $uni ;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoBoolean.php?accion=2&Opc=<? echo $T;?>&uni=<? echo $uni;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoBoolean.php?accion=3&amp;Opc=<? echo $T;?>&uni=<? echo $uni;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>

    <!-- ESPACIO -->
	<table width="100%"  border="0">
        <tr>
            <td height="10"> </td>
        </tr>
    </table>

<? }   ?>

<?

//Genera_Tabla_Seleccion(163,0,2,1);
//****************************************************************************/
//Funcion que permite visualizar las opciones que tiene una cantidad
//$T	=Opcion
//$Sum	=Maximo Valor que se debe registrar
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia

//Parametros opcionales, utilizadas en las preguntas de ordenamiento
//califi_max  = Calificacion maxima de la pregunta
//califi_min  = Calificacion minima de la pregunta

//****************************************************************************/

function Genera_Tabla_Cantidad($T,$Sum,$Pag,$tipo,$califi_max,$califi_min)
{
	//Obtener Titulo y/o Pregunta de la Sección
	//dbo.tmOpciones
	//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.tmItems
	//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
	tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
	FROM tmOpciones INNER JOIN
		 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		 tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);
//echo $sqlTit." -- ".mssql_get_last_message()."<br>";
	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

//echo "---***********----".$_SESSION["ccfFamilia"]."<br>";
	//Listado de Registros
	//dbo.CSEFichaInfoCant
	//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, cantidad, 
	//fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlRta=" SELECT     CSCPFichaInfoCant.codProyecto, CSCPFichaInfoCant.codModulo, CSCPFichaInfoCant.numFormulario, CSCPFichaInfoCant.nroObjeto, 
                      CSCPFichaInfoCant.tipoObjeto, CSCPFichaInfoCant.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoCant.codItem, tmItems.nomItem, 
                      CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      tmItems ON CSCPFichaInfoCant.codProyecto = tmItems.codProyecto AND CSCPFichaInfoCant.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmItems.codOpcion AND CSCPFichaInfoCant.codItem = tmItems.codItem AND 
                      tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoCant.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.nroObjeto=".$nobj;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.tipoObjeto=".$tipo;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
//echo $sqlRta." -- ".mssql_get_last_message()."<br>";	
	?>
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
		
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
		  <tr class="TituloTabla2">
			<td colspan="2" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
		  </tr>
	<?
	  $TotalC=0;		
	  while ($RegRta=mssql_fetch_array($cursorRta))  
	  { ?>
      <tr class="TxtTabla">
        <td width="70%"><?php echo $RegRta[nomItem]  ; ?></td>
		<td width="7%" align="right"><?php echo str_replace( ',','',number_format($RegRta[cantidad],0) )  ; ?></td>
	  </tr>
	  <? 
	    $TotalC= $TotalC+ $RegRta[cantidad] ;
	  
	  } ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaInfoCant.php?Opc=<? echo $T;?>&Sum=<? echo $Sum;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>&califi_max=<? echo $califi_max; ?>&califi_min=<? echo $califi_min; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Nuevo">
		 <? } 
			else
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoCant.php?accion=2&Opc=<? echo $T;?>&Sum=<? echo $Sum;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>&califi_max=<? echo $califi_max; ?>&califi_min=<? echo $califi_min; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoCant.php?accion=3&Opc=<? echo $T;?>&Sum=<? echo $Sum;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    
    <!-- ESPACIO -->
    <table width="100%"  border="0">
        <tr>
            <td height="10"> </td>
        </tr>
    </table>

<? } 

 ?>


<?


//****************************************************************************/
//Funcion que permite visualizar las opciones que tiene una cantidad decimal
//$T	=Opcion
//$Sum	=Maximo Valor que se debe registrar
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

function Genera_Tabla_Cantidad_Decimal($T,$Sum,$Pag,$tipo)
{


	//Obtener Titulo y/o Pregunta de la Sección
	//dbo.tmOpciones
	//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.tmItems
	//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
	tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
	FROM tmOpciones INNER JOIN
		 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		 tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);
//echo $sqlTit." -- ".mssql_get_last_message()."<br>";
	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

//echo "---***********----".$_SESSION["ccfFamilia"]."<br>";
	//Listado de Registros
	//dbo.CSEFichaInfoCant
	//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, cantidad, 
	//fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlRta=" SELECT     CSCPFichaInfoCant.codProyecto, CSCPFichaInfoCant.codModulo, CSCPFichaInfoCant.numFormulario, CSCPFichaInfoCant.nroObjeto, 
                      CSCPFichaInfoCant.tipoObjeto, CSCPFichaInfoCant.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoCant.codItem, tmItems.nomItem, 
                      CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      tmItems ON CSCPFichaInfoCant.codProyecto = tmItems.codProyecto AND CSCPFichaInfoCant.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmItems.codOpcion AND CSCPFichaInfoCant.codItem = tmItems.codItem AND 
                      tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoCant.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.consecutivo=".$_SESSION["ccfConsecutivo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codModulo=".$_SESSION["ccfModulo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.nroObjeto=".$nobj;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.tipoObjeto=".$tipo;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoCant.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
//echo $sqlRta." -- ".mssql_get_last_message()."<br>";	
	?>
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
		
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
		  <tr class="TituloTabla2">
			<td colspan="2" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
		  </tr>
	<?
	  $TotalC=0;		
	  while ($RegRta=mssql_fetch_array($cursorRta))  
	  { ?>
      <tr class="TxtTabla">
        <td width="70%"><?php echo $RegRta[nomItem]  ; ?></td>
		<td width="7%" align="right"><?php echo $RegRta[cantidad]  ; ?></td>
	  </tr>
	  <? 
	    $TotalC= $TotalC+ $RegRta[cantidad] ;
	  
	  } ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaInfoCantD.php?Opc=<? echo $T;?>&Sum=<? echo $Sum;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Nuevo">
		 <? } 
			else
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoCantD.php?accion=2&Opc=<? echo $T;?>&Sum=<? echo $Sum;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoCantD.php?accion=3&Opc=<? echo $T;?>&Sum=<? echo $Sum;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    
    <!-- ESPACIO -->
    <table width="100%"  border="0">
        <tr>
            <td height="10"> </td>
        </tr>
    </table>

<? } 

 ?>

<?
//****************************************************************************/
//Funcion que permite visualizar una lista desplegable con dos campos de texto, creada para la pregunta 4.13
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//subP1 =Opcion de la pregunta 1
//subP2 =Opcion de la pregunta 2
//en este caso $T y $T2, contienen los mismos parametros, el ultimo es utilizado para consultar la lista desplegable si no
//****************************************************************************/

function Genera_Tabla_Descripcion($T,$T1,$Pag,$tipo,$subP1,$subP2)
{	
	//si no se ha enviado el codigo de la segunda sub pregunta
	if($subP2=="")
		$subP2=0;

	//Obtener Titulo y/o Pregunta de la Sección
	//dbo.tmOpciones
	//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.tmItems
	//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod

	//consulta la informacion de la pregunta
	$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
	tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
	FROM tmOpciones INNER JOIN
		 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		 tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
//echo "***////jjj  ".$sqlTit."<br> -- ".$T1." -- ".mssql_get_last_message()."<br><br>"; 
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	//	$pTituloSec=$regTit[nomItem];
	//	$pnomOpcion=$regTit[nomOpcion];
		$pcodItem=$regTit[codItem];
		
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
	switch ($tipo) 
	{ 
		case 0: 
			$nobj=$_SESSION["ccfFormulario"]; break; 
		case 1: 
			$nobj=$_SESSION["ccfPredio"]; break;  // ****************************
		case 2: 
			$nobj=$_SESSION["ccfVivienda"]; break; 
		case 3: 
			$nobj=$_SESSION["ccfFamilia"]; break; 
	}    	  
	//verifica si ha registros asociados en CSCPFichaInfoText
	$sqlRta=" SELECT     CSCPFichaInfoText.codProyecto, CSCPFichaInfoText.codModulo, CSCPFichaInfoText.numFormulario, CSCPFichaInfoText.nroObjeto, 
                      CSCPFichaInfoText.tipoObjeto, CSCPFichaInfoText.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoText.codItem, tmItems.nomItem, 
                      CSCPFichaInfoText.respItem, CSCPFichaInfoText.descripcion,CSCPFichaInfoText.descripcion2,CSCPFichaInfoText.codItemRespuesta
FROM         CSCPFichaInfoText INNER JOIN
                      tmOpciones ON CSCPFichaInfoText.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoText.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoText.codOpcion = tmOpciones.codOpcion INNER JOIN
                      tmItems ON CSCPFichaInfoText.codProyecto = tmItems.codProyecto AND CSCPFichaInfoText.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoText.codOpcion = tmItems.codOpcion AND CSCPFichaInfoText.codItemRespuesta = tmItems.codItem AND 
                      tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoText.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.numFormulario='".$_SESSION["ccfFormulario"]."'" ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.nroObjeto=".$nobj;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.tipoObjeto=".$tipo;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
	$CantidadRegDes= mssql_num_rows($cursorRta);
//echo "***////  ".$sqlRta."<br> -- ".$T1." -- ".mssql_get_last_message(); 
?>	
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
	
	    <!--TITULO-->	
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
          <tr class="TituloTabla2">
            <td colspan="2" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
          </tr>
	 	</table>
     
    	<!-- DESCRIPCION -->	
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
<?	        
	if ($regDes=mssql_fetch_array($cursorRta))  
	{ ?>
		<?
			$sqlOpcionD="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			FROM tmOpciones INNER JOIN
				 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
				 tmOpciones.codOpcion = tmItems.codOpcion";
			$sqlOpcionD= $sqlOpcionD. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sqlOpcionD= $sqlOpcionD. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
			$sqlOpcionD= $sqlOpcionD. " AND tmOpciones.codOpcion=".$T1;
			$sqlOpcionD= $sqlOpcionD. " AND tmItems.codItem=".$regDes[codItemRespuesta];
			$cursorOpcionD = mssql_query($sqlOpcionD);
			if ($regOpcionD=mssql_fetch_array($cursorOpcionD)) 
			{
			//	$ppregunta=$regOpcionD[pregunta];
			//	$pnomOpcionD=$regOpcionD[nomItem];
			}
//echo $sqlOpcionD." -- ".$T1." -- ".mssql_get_last_message();
		?> 
        <tr class="TxtTabla">
            <td>
                <table width="100%"  border="0" cellspacing="1" cellpadding="0">
                    <tr>
                        <td width="30%" class="copyr"><?  echo $ppregunta."";  ?></td>
                        <td class="TxtTabla"><? echo $pnomOpcionD."" ;?></td>
                    </tr>
                </table>        
            </td>    
		</tr>
        <?  ?>
        <tr class="TxtTabla">
        	<td>
        	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
            	<tr>
            		<td width="30%" class="copyr"><? // echo ."" ;?></td>
					<td class="TxtTabla"><? echo $regDes["nomItem"]; ?></td>
               </tr>  
            </table>      
            </td>
		</tr>
<?php
		if($regDes["nomItem"]=="Si")
		{
			if($T==36)
			{

				$sqlItem="select * from tmOpciones where codOpcion in (121,122)";
				$sqlItem= $sqlItem. " and tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
				$sqlItem= $sqlItem. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
				$cur_pregun_si=mssql_query($sqlItem);			
	?>
			<tr class="TxtTabla">
				<td>
				<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	<?php
				$f=1;
				while($datos_pregun_si=mssql_fetch_array($cur_pregun_si))
				{
	?>			
					<tr>
						<td width="30%" class="copyr"><? echo $datos_pregun_si["nomOpcion"] ;?></td>
					
						<td class="TxtTabla">
	<?php 
						//si la descripcion es 1
						if( $f==1)echo $regDes["descripcion"]; 
						if($f==2) echo $regDes["descripcion2"];   ?></td>
	<?php
					$f++;
				}
			}
			if($T==111)
			{

				$sqlItem="select * from tmItems where codOpcion in (127) ";
				$sqlItem= $sqlItem. " and tmItems.codProyecto=".$_SESSION["ccfProyecto"] ;
				$sqlItem= $sqlItem. " AND tmItems.codModulo=".$_SESSION["ccfModulo"] ;
				$cur_pregun_si=mssql_query($sqlItem);

	?>
			<tr class="TxtTabla">
				<td>
				<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	<?php
				$f=1;
				while($datos_pregun_si=mssql_fetch_array($cur_pregun_si))
				{

	?>			
					<tr>
						<td width="30%" class="copyr"><? echo $datos_pregun_si["nomItem"] ;?></td>
					
						<td class="TxtTabla">
	<?php 
						//si la descripcion es 1
						if( $f==1)echo $regDes["descripcion"]; 
						  ?></td>
	<?php
					$f++;
				}

			}
	?>

            </table>      
            </td>
		</tr>			  
 <? 
		}
	} ?>
	</table>

		<!-- Botones -->    
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	
			
			if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaInfoText.php?Opc=<? echo $T;?>&Opc1=<? echo $T1;?>&pag=<? echo $Pag;?>&tipos=<? echo $tipo;?>&subP1=<? echo $subP1; ?>&subP2=<? echo $subP2; ?>','vAF','scrollbars=yes,resizable=yes,width=830,height=300')" value="Nuevo">
		 <? } 
			else
			{ 
				if($T!=111)
				{

?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoText.php?accion=2&Opc=<? echo $T;?>&Opc1=<? echo $T1;?>&pag=<? echo $Pag;?>&tipos=<? echo $tipo;?>&subP1=<? echo $subP1; ?>&subP2=<? echo $subP2; ?>','vAF','scrollbars=yes,resizable=yes,width=830,height=300')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoText.php?accion=3&Opc=<? echo $T;?>&Opc1=<? echo $T1;?>&pag=<? echo $Pag;?>&tipos=<? echo $tipo;?>&subP1=<? echo $subP1; ?>&subP2=<? echo $subP2; ?>','vAF','scrollbars=yes,resizable=yes,width=830,height=300')" value="Eliminar">				
			<? 
				}
				else  //sescion especial para la pregunta 7.11
				{
?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoText_2.php?accion=2&Opc=<? echo $T;?>&Opc1=<? echo $T1;?>&pag=<? echo $Pag;?>&tipos=<? echo $tipo;?>&subP1=<? echo $subP1; ?>&subP2=<? echo $subP2; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoText_2.php?accion=3&Opc=<? echo $T;?>&Opc1=<? echo $T1;?>&pag=<? echo $Pag;?>&tipos=<? echo $tipo;?>&subP1=<? echo $subP1; ?>&subP2=<? echo $subP2; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">	

<?				}

			}
	}	 ?>
		</td>
      </tr>
    </table>

    	<!--Espacio-->    
	<table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
   
    	</td>
      </tr>
    </table>
<?
}

?>


<?
//****************************************************************************/
//Funcion que permite visualizar campos amplios de texto
//$T	= Opcion de la Descripcion
//$T1	= Opcion de la Respuesta (en el caso de la pregunta 36, se consulta la respuesta SI NO)
//$pag  = Página a la que regresa
//Tipo  = 0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

//****************************************************************************/
//Funcion que permite visualizar un campo de texto grande
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//subP1 =Opcion de la pregunta 1
//en este caso $T y $SubP1, contienen los mismos parametros, el ultimo es utilizado para consultar la pregunta 
//****************************************************************************/
 //para las preguntas de texto sin campo de seleccion
function Genera_Tabla_Descripcion2($T,$T1,$Pag,$tipo,$subP1)
{	
	//si no se ha enviado el codigo de la segunda sub pregunta
	if($subP2=="")
		$subP2=0;

	//Obtener Titulo y/o Pregunta de la Sección
	//dbo.tmOpciones
	//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.tmItems
	//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod

	//consulta la informacion de la pregunta
	$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
	tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
	FROM tmOpciones INNER JOIN
		 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		 tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
//echo "***////jjj  ".$sqlTit."<br> -- ".$T1." -- ".mssql_get_last_message()."<br><br>"; 
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
		$pTituloSec=$regTit[nomItem];
		$pnomOpcion=$regTit[nomOpcion];
		$pcodItem=$regTit[codItem];
		
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
	switch ($tipo) 
	{ 
		case 0: 
			$nobj=$_SESSION["ccfFormulario"]; break; 
		case 1: 
			$nobj=$_SESSION["ccfPredio"]; break;  // ****************************
		case 2: 
			$nobj=$_SESSION["ccfVivienda"]; break; 
		case 3: 
			$nobj=$_SESSION["ccfFamilia"]; break; 
	}    	  
	//verifica si ha registros asociados en CSCPFichaInfoText
	$sqlRta=" SELECT     CSCPFichaInfoText.codProyecto, CSCPFichaInfoText.codModulo, CSCPFichaInfoText.numFormulario, CSCPFichaInfoText.nroObjeto, 
                      CSCPFichaInfoText.tipoObjeto, CSCPFichaInfoText.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoText.codItem, tmItems.nomItem, 
                      CSCPFichaInfoText.respItem, CSCPFichaInfoText.descripcion,CSCPFichaInfoText.codItemRespuesta
FROM         CSCPFichaInfoText INNER JOIN
                      tmOpciones ON CSCPFichaInfoText.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoText.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoText.codOpcion = tmOpciones.codOpcion INNER JOIN
                      tmItems ON CSCPFichaInfoText.codProyecto = tmItems.codProyecto AND CSCPFichaInfoText.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoText.codOpcion = tmItems.codOpcion AND CSCPFichaInfoText.codItem = tmItems.codItem AND 
                      tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoText.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.numFormulario='".$_SESSION["ccfFormulario"]."'" ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.nroObjeto=".$nobj;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.tipoObjeto=".$tipo;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
	$CantidadRegDes= mssql_num_rows($cursorRta);
//echo "***////  ".$sqlRta."<br> -- ".$T1." -- ".mssql_get_last_message(); 
?>	
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
	
	    <!--TITULO-->	
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
          <tr class="TituloTabla2">
            <td colspan="2" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
          </tr>
	 	</table>
     
    	<!-- DESCRIPCION -->	
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
<?	        
	if ($regDes=mssql_fetch_array($cursorRta))  
	{ ?>
		<? if(trim($T1)!=0) 
		{ 
			$sqlOpcionD="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			FROM tmOpciones INNER JOIN
				 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
				 tmOpciones.codOpcion = tmItems.codOpcion";
			$sqlOpcionD= $sqlOpcionD. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
			$sqlOpcionD= $sqlOpcionD. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
			$sqlOpcionD= $sqlOpcionD. " AND tmOpciones.codOpcion=".$T1;
			$sqlOpcionD= $sqlOpcionD. " AND tmItems.codItem=".$regDes[codItemRespuesta];
			$cursorOpcionD = mssql_query($sqlOpcionD);
			if ($regOpcionD=mssql_fetch_array($cursorOpcionD)) 
			{
				$ppregunta=$regOpcionD[pregunta];
				$pnomOpcionD=$regOpcionD[nomItem];
			}
//echo $sqlOpcionD." -- ".$T1." -- ".mssql_get_last_message();
		?> 
        <tr class="TxtTabla">
            <td>
                <table width="100%"  border="0" cellspacing="1" cellpadding="0">
                    <tr>
                        <td width="30%" class="copyr"><?  echo $ppregunta."";  ?></td>
                        <td class="TxtTabla"><? echo $pnomOpcionD."" ;?></td>
                    </tr>
                </table>        
            </td>    
		</tr>
        <? } ?>
        <tr class="TxtTabla">
        	<td>
        	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
            	<tr>
            		<td width="30%" class="copyr"><? echo $pTituloSec."" ;?></td>
					<td class="TxtTabla"><? echo $regDes[descripcion] ;?></td>
               </tr>  
            </table>      
            </td>
		</tr>
			  
 <? } ?>
	</table>

		<!-- Botones -->    
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaInfoText.php?Opc=<? echo $T;?>&Opc1=<? echo $T1;?>&pag=<? echo $Pag;?>&tipos=<? echo $tipo;?>&subP1=<? echo $subP1; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Nuevo">
		 <? } 
			else
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoText.php?accion=2&Opc=<? echo $T;?>&Opc1=<? echo $T1;?>&pag=<? echo $Pag;?>&tipos=<? echo $tipo;?>&subP1=<? echo $subP1; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoText.php?accion=3&Opc=<? echo $T;?>&Opc1=<? echo $T1;?>&pag=<? echo $Pag;?>&tipos=<? echo $tipo;?>&subP1=<? echo $subP1; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>

    	<!--Espacio-->    
	<table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
   
    	</td>
      </tr>
    </table>
<?
}

?>


<?
//****************************************************************************/
//Funcion que permite visualizar una lista desplegable (Si, No) con varios campo de texto
//$T	=Opcion Pregunta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia

function Genera_Tabla_Seleccion_Items($T,$Pag,$tipo)
{	
	//si no se ha enviado el codigo de la segunda sub pregunta
	if($subP2=="")
		$subP2=0;

	//Obtener Titulo y/o Pregunta de la Sección
	//dbo.tmOpciones
	//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.tmItems
	//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod

	//consulta la informacion de la pregunta
	$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
	tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
	FROM tmOpciones INNER JOIN
		 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		 tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
//echo "***////jjj  ".$sqlTit."<br> -- ".$T1." -- ".mssql_get_last_message()."<br><br>"; 
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	//	$pTituloSec=$regTit[nomItem];
	//	$pnomOpcion=$regTit[nomOpcion];
		$pcodItem=$regTit[codItem];
		
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
	switch ($tipo) 
	{ 
		case 0: 
			$nobj=$_SESSION["ccfFormulario"]; break; 
		case 1: 
			$nobj=$_SESSION["ccfPredio"]; break;  // ****************************
		case 2: 
			$nobj=$_SESSION["ccfVivienda"]; break; 
		case 3: 
			$nobj=$_SESSION["ccfFamilia"]; break; 
	}    	  
	//verifica si ha registros asociados en CSCPFichaInfoText

  $sqlRta=" SELECT CSCPFichaInfoText.codProyecto, CSCPFichaInfoText.codModulo, CSCPFichaInfoText.numFormulario, CSCPFichaInfoText.nroObjeto, CSCPFichaInfoText.tipoObjeto,
    CSCPFichaInfoText.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoText.codItem, tmSubItems.nomSubItem, CSCPFichaInfoText.respItem, 
    CSCPFichaInfoText.descripcion,CSCPFichaInfoText.descripcion2,CSCPFichaInfoText.codItemRespuesta FROM CSCPFichaInfoText 
    
    INNER JOIN tmOpciones ON CSCPFichaInfoText.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoText.codModulo = tmOpciones.codModulo
     AND CSCPFichaInfoText.codOpcion = tmOpciones.codOpcion     
      INNER JOIN tmItems ON CSCPFichaInfoText.codProyecto = tmItems.codProyecto 
     AND CSCPFichaInfoText.codModulo=tmItems.codModulo AND CSCPFichaInfoText.codOpcion = tmItems.codOpcion AND CSCPFichaInfoText.codItem = tmItems.codItem     
     inner join tmSubItems on CSCPFichaInfoText.codItemRespuesta=tmSubItems.codSubItem 
     AND CSCPFichaInfoText.codProyecto = tmSubItems.codProyecto AND CSCPFichaInfoText.codModulo = tmSubItems.codModulo 
     AND CSCPFichaInfoText.codOpcion = tmSubItems.codOpcion ";
/*
	$sqlRta=" SELECT CSCPFichaInfoText.codProyecto, CSCPFichaInfoText.codModulo, CSCPFichaInfoText.numFormulario, CSCPFichaInfoText.nroObjeto,
  CSCPFichaInfoText.tipoObjeto, CSCPFichaInfoText.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoText.codItem, tmSubItems.nomSubItem, 
  CSCPFichaInfoText.respItem, CSCPFichaInfoText.descripcion,CSCPFichaInfoText.descripcion2,CSCPFichaInfoText.codItemRespuesta
   FROM CSCPFichaInfoText
    INNER JOIN tmOpciones ON CSCPFichaInfoText.codProyecto = tmOpciones.codProyecto AND 
   CSCPFichaInfoText.codModulo = tmOpciones.codModulo AND CSCPFichaInfoText.codOpcion = tmOpciones.codOpcion 
   
  INNER JOIN tmItems ON CSCPFichaInfoText.codProyecto = tmItems.codProyecto AND CSCPFichaInfoText.codModulo=tmItems.codModulo 
  AND CSCPFichaInfoText.codOpcion = tmItems.codOpcion AND CSCPFichaInfoText.codItem =    tmItems.codItem 
  AND tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo 
  AND tmOpciones.codOpcion = tmItems.codOpcion   
  
  inner join tmSubItems on CSCPFichaInfoText.codItemRespuesta=tmSubItems.codSubItem ";
*/
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoText.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.numFormulario='".$_SESSION["ccfFormulario"]."'" ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.nroObjeto=".$nobj;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.tipoObjeto=".$tipo;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoText.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
	$CantidadRegDes= mssql_num_rows($cursorRta);
//echo "***////  ".$sqlRta."<br> -- ".$T1." -- ".mssql_get_last_message(); 
?>	
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
	
	    <!--TITULO-->	
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
          <tr class="TituloTabla2">
            <td colspan="2" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
          </tr>
	 	</table>
     
    	<!-- DESCRIPCION -->	
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
<?	        
	if ($regDes=mssql_fetch_array($cursorRta))  
	{ 
		$respuesta_sele=$regDes["codItemRespuesta"]; //alamcena el item de la respuesta del select
?>
        <tr class="TxtTabla">
        	<td>
        	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
            	<tr>
            		<td width="30%" class="copyr"></td>
					<td class="TxtTabla"><? echo $regDes["nomSubItem"]; ?></td>
               </tr>  
            </table>      
            </td>
		</tr>
<?
		$cursorRta = mssql_query($sqlRta);
		while($datos_items=mssql_fetch_array($cursorRta))
		{
?>
            <tr class="TxtTabla">
                <td>
                    <table width="100%"  border="0" cellspacing="1" cellpadding="0">
    <?php
    
                //trahe los items
                $sqlOpcionD="SELECT   tmItems.codItem, tmItems.nomItem FROM tmOpciones 
                            INNER JOIN tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo 
                            AND tmOpciones.codOpcion = tmItems.codOpcion";
                $sqlOpcionD= $sqlOpcionD. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
                $sqlOpcionD= $sqlOpcionD. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
                $sqlOpcionD= $sqlOpcionD. " AND tmOpciones.codOpcion=".$T;
                $sqlOpcionD= $sqlOpcionD. " AND tmItems.codItem=".$datos_items["codItem"];    
                $cursorOpcionD = mssql_query($sqlOpcionD);
                while($regOpcionD=mssql_fetch_array($cursorOpcionD)) 
                {
    ?>
                        <tr>
                            <td width="30%" class="copyr"><? echo $regOpcionD["nomItem"] ;?></td>
                        
                            <td class="TxtTabla">
        <?php 
							if(trim($datos_items["descripcion"])=="")
								  echo "&nbsp;";
							else
	                            echo $datos_items["descripcion"]; 
?>
                            </td>
                        </tr>
        <?php                    
                
                }
?> 

                </table>      
                </td>
            </tr>			  
 <? 	}
		
	} ?>
	</table>

		<!-- Botones -->    
		<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	
			
			if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaSeleText.php?Opc=<? echo $T;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Nuevo">
		 <? } 
			else
			{ 
?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaSeleText.php?accion=2&Opc=<? echo $T;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>&r=<? echo $respuesta_sele; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaSeleText.php?accion=3&Opc=<? echo $T;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>&r=<? echo $respuesta_sele; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">				
			<? 
				

			}
	}	 ?>
		</td>
      </tr>
    </table>

    	<!--Espacio-->    
	<table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
   
    	</td>
      </tr>
    </table>
<?
}

?>



<?
//****************************************************************************/
//Funcion que permite visualizar la información de los bienes
//$T	=Opcion
//$uni	=Es multiple Respuesta =1 Es Unica Respuesta =0
//$cant	=Con campo de cantidad=1, sin campo de cantidad=0
//$area	=Con campo de area=1, Sin campo de area=0
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

/*
function Genera_Tabla_Bienes($T,$uni,$cant,$area,$Pag,$tipo)
{   
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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
//****************************************************************************************
	//Listado de Registros
	//dbo.CSEFichaInfoBoolean
	//codModulo, predioNo, nroEncuesta, nroVivienda, nroFamilia, codItem, 
	//respItem, descripcion,fechaGraba, usuarioGraba, fechaMod, usuarioMod

////NO FUNCIONA LA CONSULTA
	$sqlRta = "SELECT CSCPFichaBienes.codProyecto, CSCPFichaBienes.codModulo, CSCPFichaBienes.numFormulario, CSCPFichaBienes.nroObjeto, 
				CSCPFichaBienes.tipoObjeto, CSCPFichaBienes.codOpcion, CSCPFichaBienes.codItem, CSCPFichaBienes.respItem, 
				CSCPFichaBienes.cantidad, CSCPFichaBienes.areaProm, CSCPFichaBienes.codDepartamento, CSCPFichaBienes.codMunicipio, 
				CSCPFichaBienes.codVereda, tmItems.nomItem, tmVeredas.nomVereda, tmMunicipios.nomMunicipio, tmDepartamentos.nomDepartamento
				FROM tmMunicipios INNER JOIN
				tmVeredas ON tmMunicipios.codDepartamento = tmVeredas.codDepartamento AND tmMunicipios.codMunicipio = tmVeredas.codMunicipio INNER JOIN
				tmDepartamentos ON tmMunicipios.codDepartamento = tmDepartamentos.codDepartamento RIGHT OUTER JOIN
				CSCPFichaBienes INNER JOIN
				tmItems ON CSCPFichaBienes.codOpcion = tmItems.codOpcion AND CSCPFichaBienes.codItem = tmItems.codItem ON 
				tmVeredas.codDepartamento = CSCPFichaBienes.codDepartamento AND tmVeredas.codMunicipio = CSCPFichaBienes.codMunicipio AND 
				tmVeredas.codVereda = CSCPFichaBienes.codVereda";
	$sqlRta = $sqlRta. " WHERE CSCPFichaBienes.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaBienes.codModulo=".$_SESSION["ccfModulo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaBienes.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta = $sqlRta. " AND CSCPFichaBienes.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta = $sqlRta. " AND CSCPFichaBienes.nroObjeto=".$nobj;
	$sqlRta = $sqlRta. " AND CSCPFichaBienes.tipoObjeto=".$tipo;
	$sqlRta = $sqlRta. " AND CSCPFichaBienes.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
//****************************************************************************************	
	?>

	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	  <tr class="TituloTabla2">
		<td colspan="7" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>

	  <tr class="TituloTabla2">
		<td width="15%">Item</td><td width="5%">Aplica</td>
		<? if($cant==1){ ?>
		<td width="16%">Cantidad</td>
		<? } ?>
		<? if($area==1){ ?>
	    <td width="16%">Area promedeo </td>
		<? } ?>
	    <td width="16%">Departamento</td>
	    <td width="16%">Municipio</td>
	    <td width="16%">Vereda</td>
	  </tr>
          
      <?
	  while ($RegRta=mssql_fetch_array($cursorRta))  
	  { 
	  ?>
      <tr class="TxtTabla">
        <td width="15%"><? echo $RegRta[nomItem]  ; ?></td>
		<td width="5%" align="center">
		<? if ($RegRta[respItem]=='1') 
		{ 
		?> 
			<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0"> 
		<? 
		} 
		?></td>
		<? if ($cant==1){ ?>
   		<td width="16%" align="left"><? echo $RegRta[cantidad]; ?></td>
		<? } ?>
		<? if($area==1){ ?>
	    <td width="16%" align="left"><? echo $RegRta[areaProm]; ?></td>
		<? } ?>
	    <td width="16%" align="left"><? echo $RegRta[nomDepartamento]; ?></td>
	    <td width="16%" align="left"><? echo $RegRta[nomMunicipio]; ?></td>
	    <td width="16%" align="left"><? echo $RegRta[nomVereda]; ?></td>
      </tr>
	  <? 
	  }//cierra while ($RegRta=mssql_fetch_array($cursorRta))  
	  ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSEFichaInfoBienes.php?Opc=<?=$T;?>&uni=<?=$uni;?>&pag=<?=$Pag;?>&tipo=<?=$tipo;?>&cant=<?=$cant;?>&area=<?=$area;?>','vAF','scrollbars=yes,resizable=yes,width=900,height=450')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaInfoBienes.php?accion=2&Opc=<?=$T;?>&uni=<?=$uni;?>&pag=<?=$Pag;?>&tipo=<?=$tipo;?>&cant=<?=$cant;?>&area=<?=$area;?>','vAF','scrollbars=yes,resizable=yes,width=900,height=450')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaInfoBienes.php?accion=3&amp;Opc=<?=$T;?>&uni=<?=$uni;?>&pag=<?=$Pag;?>&tipo=<?=$tipo;?>&cant=<?=$cant;?>&area=<?=$area;?>','vAF','scrollbars=yes,resizable=yes,width=900,height=450')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    
    <!--Espacio-->    
   <table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>

<? }  
*/
?>

<?
//****************************************************************************/
//Funcion que permite visualizar la información de comercialización
//$T	=Opcion
//$T2	=Opcion de respuestas
//$dat	=Campo numérico=1, Selección=0
//$pag  =Página a la que regresa
//****************************************************************************/

/*
function Genera_Tabla_Comercializa($T,$T2,$dat,$Pag)
{   
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros

///////NO FUNCIONA LA CONSULTA
	$sqlRta = "SELECT CSCPFichaComercializaFamilia.nroFamilia, CSCPFichaComercializaFamilia.consecComercializa, CSCPFichaComercializaFamilia.codOpcionComercializa, 
				CSCPFichaComercializaFamilia.codItemComercializa, CSCPFichaComercializaFamilia.codDepartamento, CSCPFichaComercializaFamilia.codMunicipio, 
				CSCPFichaComercializaFamilia.codVereda, CSCPFichaComercializaFamilia.nombre, CSCPFichaComercializaFamilia.cedula, 
				CSCPFichaComercializaFamilia.telefono, tmItems.codOpcion, tmItems.codItem, tmItems.nomItem, tmVeredas.nomVereda, tmMunicipios.nomMunicipio, 
				tmDepartamentos.nomDepartamento
				FROM tmMunicipios INNER JOIN
				tmVeredas ON tmMunicipios.codDepartamento = tmVeredas.codDepartamento AND tmMunicipios.codMunicipio = tmVeredas.codMunicipio INNER JOIN
				tmDepartamentos ON tmMunicipios.codDepartamento = tmDepartamentos.codDepartamento RIGHT OUTER JOIN
				CSCPFichaComercializaFamilia INNER JOIN
				tmItems ON CSCPFichaComercializaFamilia.codOpcionComercializa = tmItems.codOpcion AND 
				CSCPFichaComercializaFamilia.codItemComercializa = tmItems.codItem ON tmVeredas.codVereda = CSCPFichaComercializaFamilia.codVereda AND 
				tmVeredas.codDepartamento = CSCPFichaComercializaFamilia.codDepartamento AND 
				tmVeredas.codMunicipio = CSCPFichaComercializaFamilia.codMunicipio";
	$sqlRta = $sqlRta. " WHERE CSCPFichaComercializaFamilia.nroFamilia=".$_SESSION["ccfFamilia"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaComercializaFamilia.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta = $sqlRta. " AND CSCPFichaComercializaFamilia.codOpcionComercializa=".$T;
	$cursorRta = mssql_query($sqlRta);
	//echo $sqlRta;
	
	//Búsqueda de los nombres de las posibles respuestas
	$sqlNom = "SELECT * FROM tmItems WHERE codOpcion = ".$T2;
	$cursorNom = mssql_query($sqlNom);
	$num = mssql_num_rows($cursorNom)+7;
	
	?>

	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	  <tr class="TituloTabla2">
		<td colspan="<? echo $num; ?>" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>

	  <tr class="TituloTabla2">
		<td>Item</td>
		<? while ($regNom = mssql_fetch_array($cursorNom)){ ?>
		<td><? echo $regNom[nomItem]; ?></td>
		<? } ?>
		<td>Departamento</td>
		<td>Municipio</td>
	    <td>Vereda</td>
	    <td>Nombre</td>
	    <td>C&eacute;dula</td>
	    <td>Tel&eacute;fono</td>
	  </tr>
          
	  <?
	  while ($RegRta=mssql_fetch_array($cursorRta))  
	  { 
	  	$consec = $RegRta[consecComercializa];
		$sumaAplica = 0;
	  ?>
	  <tr class="TxtTabla">
	  	<td><? echo $RegRta[nomItem]  ; ?></td>
		<?

////NO FUNCIONA LA CONSULTA

			$sqlRta2 = "SELECT CSEComercializa.nroFamilia, CSEComercializa.consecComercializa, CSEComercializa.codOpcionComercializa, 
						CSEComercializa.codItemComercializa, CSEComercializa.codOpcionRespuesta, CSEComercializa.codItemRespuesta, 
						CSEComercializa.respItem, tmItems.nomItem
						FROM CSEComercializa INNER JOIN
						tmItems ON CSEComercializa.codOpcionRespuesta = tmItems.codOpcion AND CSEComercializa.codItemRespuesta = tmItems.codItem";
			$sqlRta2 = $sqlRta2. " WHERE CSEComercializa.nroFamilia=".$RegRta[nroFamilia];
			$sqlRta2 = $sqlRta2. " AND CSEComercializa.consecComercializa=".$RegRta[consecComercializa];
			$sqlRta2 = $sqlRta2. " AND CSEComercializa.codOpcionComercializa=".$RegRta[codOpcionComercializa];
			$sqlRta2 = $sqlRta2. " AND CSEComercializa.codItemComercializa=".$RegRta[codItemComercializa];
			$sqlRta2 = $sqlRta2. " AND CSEComercializa.codOpcionRespuesta=".$T2;
			$cursorRta2 = mssql_query($sqlRta2);
			//echo $sqlRta2;
			
			while($RegRta2 = mssql_fetch_array($cursorRta2))
			{
				?>
				<td align="center">
					<? 
					if($dat==0)
					{
						if ($RegRta2[respItem]=='1') 
						{ 
							$sumaAplica = $sumaAplica+1;
						?> 
							<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0"> 
						<? 
						} 
					}
					else{
						echo $RegRta2[respItem];
						if($RegRta2[respItem] != '0')
						{
							$sumaAplica = $sumaAplica+1;
						}
					}
				?></td>
				<? 
			} //cierra while($RegRta2 = mssql_fetch_array($cursorRta2))
			?>
   		<td align="left"><? echo $RegRta[nomDepartamento]; ?></td>
   		<td align="left"><? echo $RegRta[nomMunicipio]; ?></td>
	    <td align="left"><? echo $RegRta[nomVereda]; ?></td>
	    <td align="left"><? //echo $sumaAplica;
			if ($sumaAplica!=0)
			{				
				if($RegRta[nombre])
				{
					echo $RegRta[nombre]; 
				}
				else{
				?>
					<a href="#"><img src="../images/conDoc.png" alt="Asociar usuario con documento" width="13" height="14" border="0" onClick="MM_openBrWindow('addPersonaA.php?cons=<?=$RegRta[consecComercializa];?>&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=750,height=350')"></a>
					<a href="#"><img src="../images/sinDoc.png" alt="Asociar usuario sin documento" width="13" height="14" border="0" onClick="MM_openBrWindow('addPersonaSinDocA.php?cons=<?=$RegRta[consecComercializa];?>&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=750,height=350')"></a>
				<?
				}
			}//cierra if ($RegRta2[respItem]=='1')
		?></td>
	    <td align="left"><? echo $RegRta[cedula]; ?></td>
	    <td align="left"><? echo $RegRta[telefono]; ?></td>
      </tr>
	  <? 
	  }//cierra while ($RegRta=mssql_fetch_array($cursorRta))  
	  ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSEFichaComercializa.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&dat=<?=$dat;?>','vAF','scrollbars=yes,resizable=yes,width=1250,height=500')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaComercializa.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&dat=<?=$dat;?>&accion=2','vAF','scrollbars=yes,resizable=yes,width=1250,height=500')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaComercializa.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&dat=<?=$dat;?>&accion=3','vAF','scrollbars=yes,resizable=yes,width=1250,height=500')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    
    <!--Espacio-->    
   <table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>

<? }  
*/
?>

<?
//****************************************************************************/
//Funcion que permite visualizar la información Boleano dinámico
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

/*
////////////// INPLEMENTADO, PERO MAL IMPLEMANTA, NO ESTA DETERMINADO SU USO

function Genera_Tabla_SeleccionDinamico($T,$T2,$Pag,$tipo)
{   
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros
	$sqlRta = "SELECT CSCPFichaInfoBoolean.codProyecto, CSCPFichaInfoBoolean.codModulo, CSCPFichaInfoBoolean.numFormulario, CSCPFichaInfoBoolean.nroObjeto, 
				CSCPFichaInfoBoolean.tipoObjeto, CSCPFichaInfoBoolean.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoBoolean.codItem, tmItems.nomItem, 
				CSCPFichaInfoBoolean.respItem, CSCPFichaInfoBoolean.descripcion
				FROM CSCPFichaInfoBoolean INNER JOIN
				tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
				CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
				tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
				CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem AND 
				tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlRta= $sqlRta. " WHERE CSCPFichaInfoBoolean.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.numFormulario='".$_SESSION["ccfFormulario"]."'" ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.nroObjeto=".$nobj;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.tipoObjeto=".$tipo;
	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
	
	//Búsqueda de los nombres de las posibles respuestas
	$sqlNom = "SELECT * FROM tmItems WHERE codOpcion = ".$T2;
	$cursorNom = mssql_query($sqlNom);
	$num = mssql_num_rows($cursorNom)+1;
	
	?>

	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	  <tr class="TituloTabla2">
		<td colspan="<? echo $num; ?>" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>

	  <tr class="TituloTabla2">
		<td>Item</td>
		<? while ($regNom = mssql_fetch_array($cursorNom)){ ?>
		<td><? echo $regNom[nomItem]; ?></td>
		<? } ?>
	  </tr>
          
	  <?
	  while ($RegRta=mssql_fetch_array($cursorRta))  
	  { 
	  ?>
	  <tr class="TxtTabla">
	  	<td><? echo $RegRta[nomItem]  ; ?></td>
		<?
		  mssql_data_seek($cursorNom, 0);
		  while($regNom = mssql_fetch_array($cursorNom))
		  {
			?>
			<td align="center">
			<?
			$sqlRta2 = $sqlRta. " AND CSCPFichaInfoBoolean.codItem='".$RegRta[codItem]."'";
			$sqlRta2 = $sqlRta2. " AND CSCPFichaInfoBoolean.respItem='".$regNom[codItem]."'";
			$cursorRta2 = mssql_query($sqlRta2);
			//echo $sqlRta2."<br>";
			
			if($regRta2 = mssql_fetch_array($cursorRta2))
			{
				?>
				<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0">
				<? 
			}//if($regRta2 = mssql_fetch_array($cursorRta2))
			?>
			</td>
			<?
		  }//cierra  while($regNom = mssql_fetch_array($cursorNom))
		  ?>
      </tr>
	  <? 
	  }//cierra while ($RegRta=mssql_fetch_array($cursorRta))  
	  ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaInfoBooleanDinamico.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&tipo=<?=$tipo?>','vAF','scrollbars=yes,resizable=yes,width=650,height=350')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoBooleanDinamico.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&tipo=<?=$tipo?>&accion=2','vAF','scrollbars=yes,resizable=yes,width=650,height=350')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoBooleanDinamico.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&tipo=<?=$tipo?>&accion=3','vAF','scrollbars=yes,resizable=yes,width=650,height=350')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    
    <!--Espacio-->    
   <table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>

<? } 
*/
 ?>

<?
//****************************************************************************/
//Funcion que permite visualizar las opciones tipo Booleano Si/No y un desplegable
//$T	=Opcion Pregunta
//$T2	=Opcion Lista desplegable
//$txt	=Con campo de texto =1 Sin campo de texto =0
//$pag  =Página a la que regresa
//****************************************************************************/

/*
function Genera_Tabla_SeleccionLista($T,$T2,$txt,$Pag)
{   
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[nomOpcion];
	}

	//Listado de Registros

///********************************  NO FUNCIONA LA CONSULTA

	$sqlRta = "SELECT CSCPFichaActividades.nroFamilia, CSCPFichaActividades.consecActividad, CSCPFichaActividades.codItemActividad, 
				CSCPFichaActividades.codItemRelacion, CSCPFichaActividades.respItem, tmItems.nomItem AS nomActividad, tmItems_1.nomItem AS nomRelacion, 
				CSCPFichaActividades.codOpcionRelacion, CSCPFichaActividades.codOpcionActividad, CSCPFichaActividades.area
				FROM tmItems INNER JOIN
				CSCPFichaActividades ON tmItems.codItem = CSCPFichaActividades.codItemActividad AND 
				tmItems.codOpcion = CSCPFichaActividades.codOpcionActividad INNER JOIN
				tmItems AS tmItems_1 ON CSCPFichaActividades.codItemRelacion = tmItems_1.codItem AND 
				CSCPFichaActividades.codOpcionRelacion = tmItems_1.codOpcion";
	$sqlRta= $sqlRta. " WHERE CSCPFichaActividades.nroFamilia= " .$_SESSION["ccfFamilia"] ; 
	$sqlRta= $sqlRta. " AND CSCPFichaActividades.codOpcionActividad=" .$T;
	$sqlRta= $sqlRta. " ORDER BY CSCPFichaActividades.codItemActividad";
	$cursorRta = mssql_query($sqlRta);
	
	
	if($txt==1)
	{
		$cols = "4";
	}
	else{
		$cols = "3";
	}
	
	if($T==332)
	{
		$colum = "Especie";
	}
	if($T==366)
	{
		$colum = "Estado";
	}
	?>

	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	  <tr class="TituloTabla2">
		<td colspan="<? echo $cols; ?>" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>
	  
	  <tr class="TituloTabla2">
		<td>Item</td>
		<td align="center">Aplica</td>
		<? if($txt==1){ ?>
		<td align="center">&Aacute;rea</td>
		<? } ?>
		<td align="center"><? echo $colum; ?></td>
	  </tr>

      <? 
	  while ($RegRta=mssql_fetch_array($cursorRta))  
	  { 
		  ?>
		  <tr class="TxtTabla">
			<td width="45%"><? echo $RegRta[nomActividad]; ?></td>
			<td align="center">
			<? 
			if ($RegRta[respItem]=='1') 
			{ 
			?> 
				<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0"> 
			<? 
			} 
			?>
			</td>
			<? if($txt==1){ ?>
			<td><? echo $RegRta[area]; ?></td>
			<? } ?>
			<td width="45%" align="left"><? echo $RegRta[nomRelacion]; ?> </td>
		  </tr>
		  <? 
	  } 
	  ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSEFichaInfoBooleanList.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&uni=<?=$uni;?>&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=350')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaInfoBooleanList.php?accion=2&Opc=<?=$T;?>&Opc2=<?=$T2;?>&uni=<?=$uni;?>&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=350')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaInfoBooleanList.php?accion=3&Opc=<?=$T;?>&Opc2=<?=$T2;?>&uni=<?=$uni;?>&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=350')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>

    <!-- ESPACIO -->
    <table width="100%"  border="0">
        <tr>
            <td height="10"> </td>
        </tr>

    </table>

<? } 

*/
 ?>

<?
///MONDIFICADO YA FUNCIONAL

//****************************************************************************/
//Funcion que permite visualizar las opciones tipo Booleano Si/No y un Texto
//$T	=Opcion
//$uni	=Es multiple Respuesta =1 Es Unica Respuesta =0
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

/*

function Genera_Tabla_SeleccionTexto($T,$uni,$Pag,$tipo)
{   
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros
	//dbo.CSEFichaInfoBoolean
	//codModulo, predioNo, nroEncuesta, nroVivienda, nroFamilia, codItem, 
	//respItem, descripcion,fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlRta = "SELECT CSCPFichaInfoBoolean.codProyecto, CSCPFichaInfoBoolean.codModulo, CSCPFichaInfoBoolean.numFormulario, CSCPFichaInfoBoolean.nroObjeto, 
				CSCPFichaInfoBoolean.tipoObjeto, CSCPFichaInfoBoolean.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoBoolean.codItem, tmItems.nomItem, 
				CSCPFichaInfoBoolean.respItem, CSCPFichaInfoBoolean.descripcion
				FROM CSCPFichaInfoBoolean INNER JOIN
				tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
				CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
				tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
				CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem AND 
				tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlRta = $sqlRta. " WHERE CSCPFichaInfoBoolean.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.nroObjeto=".$nobj;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.tipoObjeto=".$tipo;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);

	?>

	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
		
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
		  <tr class="TituloTabla2">
			<td colspan="3" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
		  </tr>

		  <tr class="TituloTabla2">
			<td>Item</td><td>Aplica</td>
			<td>No.</td>
		  </tr>
          
      <?php while ($RegRta=mssql_fetch_array($cursorRta))  
	  { ?>
      <tr class="TxtTabla">
        <td width="49%"><?php echo $RegRta[nomItem]  ; ?></td>
		<td width="10%" align="center">
		<?php if ($RegRta[respItem]=='1') 
		{ ?> 
			<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0"> 
		<? } ; ?></td>
   		<td width="41%" align="left"><?php echo $RegRta[descripcion]; ?></td>
	  </tr>
	  <? } ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaInfoBooleanText.php?Opc=<? echo $T;?>&uni=<? echo $uni ;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoBooleanText.php?accion=2&Opc=<? echo $T;?>&uni=<? echo $uni;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoBooleanText.php?accion=3&amp;Opc=<? echo $T;?>&uni=<? echo $uni;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    
    <!--Espacio-->    
   <table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>

<? } 
*/

 ?>

<?
//****************************************************************************/
//Funcion que permite visualizar las opciones tipo Booleano Si/No y dos textos
//$T	=Opcion
//$uni	=Es multiple Respuesta =0 Es Unica Respuesta =1
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

/*
function Genera_Tabla_2Textos($T,$uni,$Pag,$tipo)
{	
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);
	
	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros
	//dbo.CSEFichaInfoBoolean
	//codProyecto, codModulo, nroEncuesta, nroObjeto, tipoObjeto, codOpcion, codItem, respItem, 
	//descripcion, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlRta = " SELECT CSCPFichaInfoBoolean.codProyecto, CSCPFichaInfoBoolean.codModulo, CSCPFichaInfoBoolean.numFormulario, CSCPFichaInfoBoolean.nroObjeto, 
				CSCPFichaInfoBoolean.tipoObjeto, CSCPFichaInfoBoolean.codOpcion, tmOpciones.nomOpcion, CSCPFichaInfoBoolean.codItem, tmItems.nomItem, 
				CSCPFichaInfoBoolean.respItem, CSCPFichaInfoBoolean.descripcion, CSCPFichaInfoBoolean.descripcion2
				FROM CSCPFichaInfoBoolean INNER JOIN
				tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
				CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
				tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
				CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem AND 
				tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlRta = $sqlRta. " WHERE CSCPFichaInfoBoolean.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.numFormulario='".$_SESSION["ccfFormulario"]."'" ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoBoolean.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.nroObjeto=".$nobj;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.tipoObjeto=".$tipo;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBoolean.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
	//echo $sqlRta;
	
	if($T==150)
	{
		$text1 = "Cgto/Inspección";
		$text2 = "Municipio";
	}
	else{
		$text1 = "Ceba";
		$text2 = "Alevinos";
	}
	?>
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr class="TituloTabla2">
	    <td colspan="4" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>
	  <tr>
	    <td class="TituloTabla2" align="center" width="35%">&Iacute;tem</td>
	    <td class="TituloTabla2" align="center" width="5%">Aplica</td>
	    <td width="30%" align="center" class="TituloTabla2"><? echo $text1; ?></td>
	    <td width="30%" align="center" class="TituloTabla2"><? echo $text2; ?></td>
	  </tr>
	  
	  <?
	  while ($regRta = mssql_fetch_array($cursorRta))
	  {
	  ?>
	  <tr>
	    <td width="35%" align="center" class="TxtTabla"><? echo $regRta[nomItem]; ?></td>
	    <td width="5%" align="center" class="TxtTabla">
			<?
			if ($regRta[respItem]=='1') 
			{ 
			?> 
				<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0"> 
			<? 
			} 
			?>		</td>
	    <td width="30%" align="center" class="TxtTabla"><? echo $regRta[descripcion]; ?></td>
	    <td width="30%" align="center" class="TxtTabla"><? echo $regRta[descripcion2]; ?></td>
	    </tr>
	  <?
	  }
	  ?>
	</table>
	
	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSEFichaInfoBoolean2Texts.php?Opc=<? echo $T;?>&uni=<? echo $uni ;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaInfoBoolean2Texts.php?accion=2&Opc=<? echo $T;?>&uni=<? echo $uni;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaInfoBoolean2Texts.php?accion=3&amp;Opc=<? echo $T;?>&uni=<? echo $uni;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=450')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>

	<!---- ESPACIO ---->
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

<? } 
*/
?>

<?
//****************************************************************************/
//Genera una serie de items de unica seleccion, con una serie de listas despleglabes de ubicacion(Departamento/Municipio/Vereda)(4.14.1)
//$T	=Opcion
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/

function Genera_Tabla_Ubicacion($T,$Pag,$tipo)
{	

	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);
	
	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros

	$sqlRta = "SELECT CSCPFichaInfoUbicacion.codProyecto, CSCPFichaInfoUbicacion.codModulo, CSCPFichaInfoUbicacion.numFormulario, CSCPFichaInfoUbicacion.nroObjeto, 
				CSCPFichaInfoUbicacion.tipoObjeto, CSCPFichaInfoUbicacion.codOpcion, CSCPFichaInfoUbicacion.codItem, CSCPFichaInfoUbicacion.codDepartamento, 
				CSCPFichaInfoUbicacion.codMunicipio, CSCPFichaInfoUbicacion.codVereda, CSCPFichaInfoUbicacion.fechaGraba, 
				CSCPFichaInfoUbicacion.usuarioGraba, CSCPFichaInfoUbicacion.fechaMod, CSCPFichaInfoUbicacion.usuarioMod, tmDepartamentos.nomDepartamento, 
				tmMunicipios.nomMunicipio, tmVeredas.nomVereda, CSCPFichaInfoUbicacion.consecutivo
				FROM CSCPFichaInfoUbicacion INNER JOIN
				tmDepartamentos ON CSCPFichaInfoUbicacion.codDepartamento = tmDepartamentos.codDepartamento INNER JOIN
				tmMunicipios ON CSCPFichaInfoUbicacion.codDepartamento = tmMunicipios.codDepartamento AND 
				CSCPFichaInfoUbicacion.codMunicipio = tmMunicipios.codMunicipio 
				LEFT JOIN	tmVeredas ON CSCPFichaInfoUbicacion.codDepartamento = tmVeredas.codDepartamento AND 
				CSCPFichaInfoUbicacion.codMunicipio = tmVeredas.codMunicipio AND CSCPFichaInfoUbicacion.codVereda = tmVeredas.codVereda	";
	$sqlRta = $sqlRta. " WHERE CSCPFichaInfoUbicacion.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoUbicacion.codModulo=".$_SESSION["ccfModulo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoUbicacion.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta = $sqlRta. " AND CSCPFichaInfoUbicacion.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoUbicacion.nroObjeto=".$nobj;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoUbicacion.tipoObjeto=".$tipo;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoUbicacion.codOpcion=".$T;
	$cursorRta = mssql_query($sqlRta);
//echo $sqlRta."<br><br>";


	
	?>
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr class="TituloTabla2">
	    <td colspan="6" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>
	  <tr class="TituloTabla2">
			<td>Item</td>
			<td>Aplica</td>
			<td>Municipio/Vereda</td>
<!--
	    <td class="TituloTabla2" align="center" width="24%">Departamento</td>
	    <td width="24%" align="center" class="TituloTabla2">Municipio</td>
	    <td width="24%" align="center" class="TituloTabla2">Corregimiento/Vereda</td>
	    <?  //if($sec==1){ ?>
		<td width="24%" align="center" class="TituloTabla2">Sector</td>
		<? // } ?>
	    <td width="2%" align="center" class="TituloTabla2">&nbsp;</td>
	    <td width="2%" align="center" class="TituloTabla2">&nbsp;</td>
-->
	  </tr>

<?php 
	if ($regRta = mssql_fetch_array($cursorRta))
	{
		$sql_item="select * from tmItems where codOpcion=".$T;
		$sql_item = $sql_item. " and tmItems.codProyecto=".$_SESSION["ccfProyecto"] ;
		$sql_item = $sql_item. " AND tmItems.codModulo=".$_SESSION["ccfModulo"] ;
		$cur_item=mssql_query($sql_item);
		while($datos_item=mssql_fetch_array($cur_item))
		{
?>
          <tr>
            <td width="24%" class="TxtTabla"><? echo $datos_item[nomItem]; ?></td>

				<? if($datos_item["codItem"]==$regRta["codItem"])  
					{
				?>
        		    <td width="24%" class="TxtTabla">
						<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0"> 						
					</td>
		            <td width="24%" class="TxtTabla"><? echo $regRta[nomDepartamento]."/".$regRta[nomMunicipio]."/".$regRta[nomVereda]; ?></td>
				<?php
					}
					else
					{
				?>
                        <td width="24%" class="TxtTabla">
                        </td>
                        <td width="24%" class="TxtTabla"></td>
<?php
					}
?>
        </tr>
<?php	
		}
	}
?>
		<tr>
			<td align="right" colspan="3">
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaInfoMorb.php?Opc=<? echo $T;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoMorb.php?accion=2&Opc=<? echo $T;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaInfoMorb.php?accion=3&Opc=<? echo $T;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>&subP1=<? echo $subP1; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">				
<?			 }
		}	
 ?>
			</td>
		</tr>



	  
	  <?
/*
	  while ($regRta = mssql_fetch_array($cursorRta))
	  {
	  ?>
	  <tr>
	    <td width="24%" class="TxtTabla"><? echo $regRta[nomDepartamento]; ?></td>
	    <td width="24%" class="TxtTabla"><? echo $regRta[nomMunicipio]; ?></td>
	    <td width="24%" class="TxtTabla"><? echo $regRta[nomVereda]; ?></td>
		<? if($sec==1){ ?>
	    <td width="24%" class="TxtTabla"><? echo $regRta[otro]; ?></td>
		<? } ?>
	    <td width="2%" align="center" class="TxtTabla"><a href="#"><img src="../images/imgUp.gif" alt="Editar" width="18" height="14" border="0" onClick="MM_openBrWindow('upInfoUbicacion.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&tipo=<?=$tipo;?>&s=<?=$sec;?>&cu=<?=$regRta[consecUbica];?>&accion=2','vAF','scrollbars=yes,resizable=yes,width=780,height=350')"></a></td>
	    <td width="2%" align="center" class="TxtTabla"><a href="#"><img src="../images/del.gif" alt="Eliminar" width="14" height="13" border="0" onClick="MM_openBrWindow('upInfoUbicacion.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&tipo=<?=$tipo;?>&s=<?=$sec;?>&cu=<?=$regRta[consecUbica];?>&accion=3','vAF','scrollbars=yes,resizable=yes,width=780,height=350')"></a></td>
	  </tr>
	  <?
	  }
*/
	  ?>
	</table>
	
	<!-- Botones -->    
<!---
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
-->
		<!-- Validación de Perfil de Usuario -->
	<? /* if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	
		{ 	 ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addInfoUbicacion.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&tipo=<?=$tipo;?>&s=<?=$sec;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=350')" value="Nuevo">
		 <? } */ ?>			
<!--
		</td>
      </tr>
    </table>

	<!---- ESPACIO ---->
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

<? }

 ?>

<?
//****************************************************************************/
//Funcion que permite visualizar la información de ubicaciones
//$T	=Opcion
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/
function Genera_Tabla_Ubicacion2($T,$Pag,$tipo)
{	
//echo $_SESSION["ccfFamilia"]."<<<<<< <br>";
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros
	$sqlRta = "select * from CSCPFichaFamilia
				INNER JOIN tmDepartamentos ON CSCPFichaFamilia.codDepartamento = tmDepartamentos.codDepartamento 
				INNER JOIN tmMunicipios ON CSCPFichaFamilia.codDepartamento = tmMunicipios.codDepartamento AND CSCPFichaFamilia.codMunicipio = tmMunicipios.codMunicipio 
				INNER JOIN	tmVeredas ON CSCPFichaFamilia.codDepartamento = tmVeredas.codDepartamento AND 
				CSCPFichaFamilia.codMunicipio = tmVeredas.codMunicipio AND CSCPFichaFamilia.codVereda = tmVeredas.codVereda
				where nroFamilia=".$_SESSION["ccfFamilia"];
	$cursorRta = mssql_query($sqlRta);
	$cant_reg=0;
	$cant_reg=mssql_num_rows($cursorRta);
	//echo $sqlRta;
	
	?>
	<table width="100%"  border="0" cellpadding="0" cellspacing="1">
	  <tr class="TituloTabla2">
	    <td colspan="6" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>
	  <tr>
	    <td class="TituloTabla2" align="center" width="24%">Departamento</td>
	    <td width="24%" align="center" class="TituloTabla2">Municipio</td>
	    <td width="24%" align="center" class="TituloTabla2">Corregimiento/Vereda</td>
	    <? //if($sec==1){ ?>
		<td width="24%" align="center" class="TituloTabla2">Sector</td>
		<? //} ?>

	  </tr>
	  
	  <?
	  while ($regRta = mssql_fetch_array($cursorRta))
	  {
	  ?>

	  <tr>
	    <td width="24%" class="TxtTabla"><? echo $regRta[nomDepartamento]; ?></td>
	    <td width="24%" class="TxtTabla"><? echo $regRta[nomMunicipio]; ?></td>
	    <td width="24%" class="TxtTabla"><? echo $regRta[nomVereda]; ?></td>
		<? // if($sec==1){ ?>
	    <td width="24%" class="TxtTabla"><? echo $regRta[sector]; ?></td>
		<? //} ?>

	  </tr>
	  <?
	  }
	  ?>
	</table>
	
	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	
			if($cant_reg==0) 
			{
			?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addInfoUbicacion.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&tipo=<?=$tipo;?>&s=<?=$sec;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=350')" value="Nuevo">

<?php
			}
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upInfoUbicacion.php?accion=2&Opc=<? echo $T;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upInfoUbicacion.php?accion=3&Opc=<? echo $T;?>&pag=<? echo $Pag;?>&tipo=<? echo $tipo;?>&subP1=<? echo $subP1; ?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">				
<?			 }
		} ?>			
		</td>
      </tr>
    </table>

	<!---- ESPACIO ---->
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

<? } ?>



<?
//****************************************************************************/
//Funcion que permite visualizar la información tipo Morbi
//$T	=Opcion
//$Pag  =Página a la que regresa
//****************************************************************************/

/*
function Genera_Tabla_Morbi($T,$Pag)
{

	//Obtener Titulo y/o Pregunta de la Sección
	//dbo.tmOpciones
	//codProyecto, codModulo, codOpcion, nomOpcion, pregunta, esVisible, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	//dbo.tmItems
	//codProyecto, codModulo, codOpcion, codItem, nomItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod
	$sqlTit="SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
	tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
	FROM tmOpciones INNER JOIN
		 tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		 tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit= $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);
	
    ?>	

	<table width="100%" border="0" cellpadding="0" cellspacing="1">    
	  <tr>
	    <td colspan="6" align="center" class="TituloTabla"><? echo $pTituloPpal;?><a name="<? echo $T;?>"></a></td>
	    </tr>
      <tr align="center">      	
		<? 
		//dbo.CSEFichaFamiliaMorbilidad
		//codProyecto, codModulo, nroEncuesta, nroVivienda, nroFamilia, consecMorbilidad, codItemSexo, edad, 
		//codItemCausa, fechaGraba, usuarioGraba, fechaMod, usuarioMod
		//Obtener el Máximo consecutivo de CSEFichaFamiliaMorbilidad

//////CONSULTA YA FUNCIONA  
//cambio codItemCausa por itemcausa
		$sqlSec = "SELECT CSCPFichaFamiliaMorbilidad.codProyecto, CSCPFichaFamiliaMorbilidad.codModulo, CSCPFichaFamiliaMorbilidad.numFormulario, 
					CSCPFichaFamiliaMorbilidad.nroVivienda, CSCPFichaFamiliaMorbilidad.nroFamilia, CSCPFichaFamiliaMorbilidad.consecMorbilidad, 
					CSCPFichaFamiliaMorbilidad.codItemSexo, Sexo.nomItem AS nomSexo, CSCPFichaFamiliaMorbilidad.edad, CSCPFichaFamiliaMorbilidad.itemCausa, 
					Causa.nomItem AS nomCausa, CSCPFichaFamiliaMorbilidad.codOpcion
					FROM CSCPFichaViviendavsFamilia INNER JOIN
					CSCPFichaFamiliaMorbilidad ON CSCPFichaViviendavsFamilia.codProyecto = CSCPFichaFamiliaMorbilidad.codProyecto AND 
					CSCPFichaViviendavsFamilia.codModulo = CSCPFichaFamiliaMorbilidad.codModulo AND 
					CSCPFichaViviendavsFamilia.numFormulario = CSCPFichaFamiliaMorbilidad.numFormulario AND 
					CSCPFichaViviendavsFamilia.nroVivienda = CSCPFichaFamiliaMorbilidad.nroVivienda AND 
					CSCPFichaViviendavsFamilia.nroFamilia = CSCPFichaFamiliaMorbilidad.nroFamilia LEFT OUTER JOIN
					tmItems AS Causa ON CSCPFichaFamiliaMorbilidad.itemCausa = Causa.codItem LEFT OUTER JOIN
					tmItems AS Sexo ON CSCPFichaFamiliaMorbilidad.codItemSexo = Sexo.codItem";	
		$sqlSec = $sqlSec. " WHERE CSCPFichaFamiliaMorbilidad.codProyecto=".$_SESSION["ccfProyecto"] ;
		$sqlSec = $sqlSec. " AND CSCPFichaFamiliaMorbilidad.codModulo=".$_SESSION["ccfModulo"] ;

		$sqlSec= $sqlSec. " AND CSCPFichaFamiliaMorbilidad.consecutivo=".$_SESSION["ccfConsecutivo"] ;

		$sqlSec = $sqlSec. " AND CSCPFichaFamiliaMorbilidad.numFormulario=".$_SESSION["ccfFormulario"] ;
		$sqlSec = $sqlSec. " AND CSCPFichaFamiliaMorbilidad.nroVivienda=".$_SESSION["ccfVivienda"] ;
		$sqlSec = $sqlSec. " AND CSCPFichaFamiliaMorbilidad.nroFamilia=".$_SESSION["ccfFamilia"] ;
		$sqlSec = $sqlSec. " AND CSCPFichaFamiliaMorbilidad.codOpcion=".$T ;
		$cursorMorbilidad = mssql_query($sqlSec);
		
		if($T == 310)
		{
			$colum1 = "Sexo";
			$colum2 = "Edad al morir";
			$colum3 = "Causa de fallecimiento";
		}
		if($T == 358)
		{
			$colum1 = "Producto";
			$colum2 = "Volumen";
			$colum3 = "Frecuencia producción";
		}
		?>
		<td width="18%" align="left" class="TituloTabla2">Consecutivo</td>
		<td width="21%" class="TituloTabla2"><? echo $colum1; ?></td>
		<td width="19%" class="TituloTabla2"><? echo $colum2; ?></td>
		<td width="34%" class="TituloTabla2"><? echo $colum3; ?></td>
		<td width="4%" align="left" class="TituloTabla2">&nbsp;</td>
		<td width="4%" align="left" class="TituloTabla2">&nbsp;</td>
	  </tr>
	  <? 
		$CantidadRegPec= mssql_num_rows($cursorMorbilidad); 				
		$k=1;
		while ($regMorb=mssql_fetch_array($cursorMorbilidad))  
		{ ?>
		<tr class="TxtTabla">
			<td width="18%" align="left" class="TxtTabla"><? echo $k ;?></td>
			<td width="21%" class="TxtTabla"><? echo $regMorb[nomSexo] ;?></td>
			<td width="19%" class="TxtTabla" align="center"><? echo $regMorb[edad] ;?></td>
			<td width="34%" class="TxtTabla" align="center"><? echo $regMorb[nomCausa]; ?></td>
			<td width="4%" align="left" class="TxtTabla"><div align="center"><a href="#"><img src="../images/imgUp.gif" alt="Editar Causa" width="14" height="13" border="0" onClick="MM_openBrWindow('upMorbilidad.php?Opc=<?=$T;?>&cual=<?=$regMorb[consecMorbilidad] ; ?>&accion=2&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')"></a></div></td>
			<td width="4%" align="left" class="TxtTabla"><div align="center"><a href="#"><img src="../images/del.gif" alt="Eliminar Causa" width="14" height="13" border="0" onClick="MM_openBrWindow('upMorbilidad.php?Opc=<?=$T;?>&cual=<?=$regMorb[consecMorbilidad] ; ?>&accion=3&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')"></a></div></td>
		</tr>
	  <? $k=$k+1;
	  } ?>
	</table>

 	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td><input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addMorbilidad.php?accion=1&Opc=<?=$T;?>&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" value="Nuevo"></td>	  </tr>
	</table>

	<!--Espacio-->    
	<table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
<?
}
*/
?>

<?
//****************************************************************************/
//Funcion que permite visualizar la información dinámico múltiple
//$T	=Opcion Pregunta
//$T2	=Opcion Respuesta
//$pag  =Página a la que regresa
//Tipo  =0=Encuesta, 1=Predio, 2=Vivienda, 3=Familia
//****************************************************************************/



function Genera_Tabla_SeleccionMultiple($T,$T2,$Pag,$tipo)
{   
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTit);

//echo $sqlTit." -- ".mssql_get_last_message()."<br>";

	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);

	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros


//consulta si el formulario contiene registros, asociados en CSCPFichaInfoBooleanM
	$sqlRta = "SELECT CSCPFichaInfoBooleanM.codProyecto, CSCPFichaInfoBooleanM.codModulo, CSCPFichaInfoBooleanM.numFormulario, CSCPFichaInfoBooleanM.nroObjeto, 
				CSCPFichaInfoBooleanM.tipoObjeto, CSCPFichaInfoBooleanM.codOpcion, CSCPFichaInfoBooleanM.codItem, CSCPFichaInfoBooleanM.respItem, CSCPFichaInfoBooleanM.fechaGraba, 
				CSCPFichaInfoBooleanM.usuarioGraba, CSCPFichaInfoBooleanM.fechaMod, CSCPFichaInfoBooleanM.usuarioMod, tmSubItems.nomSubItem AS nomPregunta
				FROM CSCPFichaInfoBooleanM INNER JOIN
				tmSubItems ON CSCPFichaInfoBooleanM.codOpcion = tmSubItems.codOpcion AND CSCPFichaInfoBooleanM.codSubItem = tmSubItems.codSubItem";
	$sqlRta = $sqlRta. " WHERE CSCPFichaInfoBooleanM.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBooleanM.codModulo=".$_SESSION["ccfModulo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaInfoBooleanM.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta = $sqlRta. " AND CSCPFichaInfoBooleanM.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBooleanM.nroObjeto=".$nobj;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBooleanM.tipoObjeto=".$tipo;
	$sqlRta = $sqlRta. " AND CSCPFichaInfoBooleanM.codOpcion=".$T2;

	$cursorRta = mssql_query($sqlRta);

	//consulta los subitems asociados a la pregunta(opcion)
//Trae la información de las respuestas
$sqlRta2 = "SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
		tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmSubItems.codSubItem, tmSubItems.nomSubItem
		FROM tmOpciones INNER JOIN
		tmSubItems ON tmOpciones.codProyecto = tmSubItems.codProyecto AND tmOpciones.codModulo = tmSubItems.codModulo AND 
		tmOpciones.codOpcion = tmSubItems.codOpcion";
$sqlRta2 = $sqlRta2. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlRta2 = $sqlRta2. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sqlRta2 = $sqlRta2. " AND tmOpciones.codOpcion=".$T2;
	$cursorRta2 = mssql_query($sqlRta2);
	$num = mssql_num_rows($cursorRta2)+1;

//echo "<br>11111111  ".$sqlRta2." -- ".mssql_get_last_message()."<br> <br>";	
	//Búsqueda de los nombres de las posibles respuestas
//Trae la información de los items

//Trae la información de los items
$sqlNom = "SELECT tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
		tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
		FROM tmOpciones INNER JOIN
		tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
		tmOpciones.codOpcion = tmItems.codOpcion";
$sqlNom = $sqlNom. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
$sqlNom = $sqlNom. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
$sqlNom = $sqlNom. " AND tmOpciones.codOpcion=".$T2;
	$cursorNom = mssql_query($sqlNom);


//echo "nommmmmmmmmmmmmmm     ". $sqlNom." -- ".mssql_get_last_message()."<br>";
	
	?>

	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	  <tr class="TituloTabla2">
		<td colspan="<? echo $num; ?>" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>

	  <tr class="TituloTabla2">
		<td  >Item</td>
		<? while ($regNom = mssql_fetch_array($cursorRta2)){ ?>
		<td><? echo $regNom[nomSubItem]; ?></td>
		<? } ?>
	  </tr>
          
	  <?
	  while ($RegRta=mssql_fetch_array($cursorNom))  
	  { 
	  ?>
	  <tr class="TxtTabla">
	  	<td><? echo $RegRta[nomItem]  ; ?></td>

		  <?
		  mssql_data_seek($cursorRta2,0);	
          while ($RegRta2=mssql_fetch_array($cursorRta2))  
          { 
          ?>
<?
				$sqlRta3="SELECT * FROM CSCPFichaInfoBooleanM";
				$sqlRta3=$sqlRta3." WHERE CSCPFichaInfoBooleanM.codProyecto=".$_SESSION["ccfProyecto"];
				$sqlRta3=$sqlRta3." AND CSCPFichaInfoBooleanM.codModulo= ".$_SESSION["ccfModulo"];
				$sqlRta3=$sqlRta3." AND CSCPFichaInfoBooleanM.consecutivo=".$_SESSION["ccfConsecutivo"];
				$sqlRta3=$sqlRta3."  AND CSCPFichaInfoBooleanM.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
				$sqlRta3=$sqlRta3." AND CSCPFichaInfoBooleanM.nroObjeto=".$nobj;
				$sqlRta3=$sqlRta3." AND CSCPFichaInfoBooleanM.tipoObjeto=".$tipo;
				$sqlRta3=$sqlRta3."   AND CSCPFichaInfoBooleanM.codOpcion=".$T2;
				$sqlRta3 = $sqlRta3. " AND CSCPFichaInfoBooleanM.codItem=".$RegRta[codItem];	
				$sqlRta3=$sqlRta3." and CSCPFichaInfoBooleanM.codSubItem=".$RegRta2["codSubItem"];

				$cursorRta3 = mssql_query($sqlRta3);
//echo "<br> ////////////////***********************  ".$sqlRta3." -- ".mssql_get_last_message()."<br>";
				$cant_reg=mssql_num_rows($cursorRta3); //si no se encontraron registros, es por que no existe informacion relacionada con los items de la pregunta
				while ($regRta3 = mssql_fetch_array($cursorRta3))
				{
					if($regRta3[respItem] == '1')
					{
?>
                        <td width="5%" align="center">
    
                        <img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0">
                    
    
                        </td>
<?
					}
					else
					{
?>
                        <td width="5%" align="center"> 
                        </td>
<?
					}
					
				}
				if($cant_reg==0) //si no se encontraron registros con la informacion de la pregunta (cuando se ingresan nuevos items y estos no estan asociados a la respuestas anteriores, de la pregunta)
				{
					?>
                        <td width="5%" align="center"> 
                        </td>
					<?
				}


		 }


/*
			if($RegRta[respItem] == '1')
			{
				?>
				<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0">
				<? 
			}?>
		</td>
		
		<?
		  mssql_data_seek($cursorNom, 0);
		  while($regNom = mssql_fetch_array($cursorNom))
		  {
			?>
			<td align="center">
			<?

//// NO FUNCIONA LA CONSULTA
			$sqlRta2 = "SELECT * FROM CSCPMultipleRespuesta";
			$sqlRta2 = $sqlRta2. " WHERE codProyecto=".$_SESSION["ccfProyecto"] ;
			$sqlRta2 = $sqlRta2. " AND codModulo=".$_SESSION["ccfModulo"] ;

			$sqlRta2= $sqlRta2. " AND CSCPFichaMultiple.consecutivo=".$_SESSION["ccfConsecutivo"] ;

			$sqlRta2 = $sqlRta2. " AND numFormulario='".$_SESSION["ccfFormulario"]."'" ;
		//	$sqlRta2 = $sqlRta2. " AND nroObjeto=".$nobj;
			$sqlRta2 = $sqlRta2. " AND tipoObjeto=".$tipo;
			$sqlRta2 = $sqlRta2. " AND codOpcion=".$T;
			$sqlRta2 = $sqlRta2. " AND codItem='".$RegRta[codItem]."'";
			$sqlRta2 = $sqlRta2. " AND codOpcionResp='".$T2."'";
			$sqlRta2 = $sqlRta2. " AND codItemResp='".$regNom[codItem]."'";
			$cursorRta2 = mssql_query($sqlRta2);
			$regRta2 = mssql_fetch_array($cursorRta2);

//echo "<br> -----   ".$sqlRta2." -- ".mssql_get_last_message()."<br>";

			//echo $sqlRta2."<br>";
			
			if($regRta2[respItem] == '1')
			{
				?>
				<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0">
				<? 
			}//if($regRta2[respItemRespuesta] == '1')

			?>
			</td>
			<?
		  }//cierra  while($regNom = mssql_fetch_array($cursorNom))
*/
		  ?>
      </tr>
	  <? 
	  }//cierra while ($RegRta=mssql_fetch_array($cursorRta))  
	  ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2)OR ($_SESSION["ccfUsuPerfil"] == 3)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSCPFichaMultiple.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&tipo=<?=$tipo?>','vAF','scrollbars=yes,resizable=yes,width=650,height=350')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaMultiple.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&tipo=<?=$tipo?>&accion=2','vAF','scrollbars=yes,resizable=yes,width=650,height=350')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSCPFichaMultiple.php?Opc=<?=$T;?>&Opc2=<?=$T2;?>&pag=<?=$Pag;?>&tipo=<?=$tipo?>&accion=3','vAF','scrollbars=yes,resizable=yes,width=650,height=350')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    
    <!--Espacio-->    
   <table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>

<? }  


?>

<?
//****************************************************************************/
//Funcion que permite visualizar la información de recursos naturales
//$T	=Opcion Pregunta
//$T1	=Opcion lista 1 (Aplicabilidad)
//$T2	=Opcion lista 2
//$T3	=Opcion lista 3
//$T4	=Opcion lista 4
//$cant	=Con campo de cantidad=1; sin campo de cantidad=0
//$pag  =Página a la que regresa
//****************************************************************************/
/*
function Genera_Tabla_Recursos($T,$T1,$T2,$T3,$T4,$cant,$Pag)
{   
	//Trae la información de Titulo
	$sqlTit = "SELECT TOP(1) tmOpciones.codProyecto, tmOpciones.codModulo, tmOpciones.codOpcion, 
			   tmOpciones.nomOpcion, tmOpciones.pregunta, tmOpciones.esVisible, tmItems.codItem, tmItems.nomItem
			   FROM tmOpciones INNER JOIN
			   tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND 
			   tmOpciones.codOpcion = tmItems.codOpcion";
	$sqlTit = $sqlTit. " WHERE tmOpciones.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlTit = $sqlTit. " AND tmOpciones.codModulo=".$_SESSION["ccfModulo"] ;
	$sqlTitPpal = $sqlTit. " AND tmOpciones.codOpcion=".$T;
	$cursorTit = mssql_query($sqlTitPpal);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[pregunta];
	}
	$cursorTit = mssql_query($sqlTit);
	
	//Título lista 2
	$sqlTitList2 = $sqlTit. " AND tmOpciones.codOpcion=".$T2;
	$cursorList2 = mssql_query($sqlTitList2);
	if ($regTitList2 = mssql_fetch_array($cursorList2)) 
	{
		$pTituloList2 = $regTitList2[pregunta];
	}
	
	//Título lista 3
	$sqlTitList3 = $sqlTit. " AND tmOpciones.codOpcion=".$T3;
	$cursorList3 = mssql_query($sqlTitList3);
	if ($regTitList3 = mssql_fetch_array($cursorList3)) 
	{
		$pTituloList3 = $regTitList3[pregunta];
	}
	
	//Tipo de información 0=Encuesta 1=Predio 2=Vivienda 3=Familia
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

	//Listado de Registros

//CONSULTA NO FUNCIONA
	$sqlRta = "SELECT CSCPFichaFamiliaRecursos.codProyecto, CSCPFichaFamiliaRecursos.codModulo, CSCPFichaFamiliaRecursos.numFormulario, 
				CSCPFichaFamiliaRecursos.nroVivienda, CSCPFichaFamiliaRecursos.nroFamilia, CSCPFichaFamiliaRecursos.consecRecursos, 
				CSCPFichaFamiliaRecursos.codItemRecurso, CSCPFichaFamiliaRecursos.codItemAplicabilidad, CSCPFichaFamiliaRecursos.codItemLugar, 
				CSCPFichaFamiliaRecursos.codItemFrecuencia, CSCPFichaFamiliaRecursos.cantidad, CSCPFichaFamiliaRecursos.codItemUnidad, 
				tmItems.nomItem AS nomRecurso, tmItems_1.nomItem AS nomAplica, tmItems_2.nomItem AS nomLugar, tmItems_3.nomItem AS nomFrecuencia, 
				tmItems_4.nomItem AS nomUnidad, CSCPFichaFamiliaRecursos.codOpcion
				FROM CSCPFichaFamiliaRecursos LEFT OUTER JOIN
				tmItems ON CSCPFichaFamiliaRecursos.codItemRecurso = tmItems.codItem LEFT OUTER JOIN
				tmItems AS tmItems_1 ON CSCPFichaFamiliaRecursos.codItemAplicabilidad = tmItems_1.codItem LEFT OUTER JOIN
				tmItems AS tmItems_2 ON CSCPFichaFamiliaRecursos.codItemLugar = tmItems_2.codItem LEFT OUTER JOIN
				tmItems AS tmItems_3 ON CSCPFichaFamiliaRecursos.codItemFrecuencia = tmItems_3.codItem LEFT OUTER JOIN
				tmItems AS tmItems_4 ON CSCPFichaFamiliaRecursos.codItemUnidad = tmItems_4.codItem";
	$sqlRta = $sqlRta. " WHERE CSCPFichaFamiliaRecursos.codProyecto=".$_SESSION["ccfProyecto"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaFamiliaRecursos.codModulo=".$_SESSION["ccfModulo"] ;

	$sqlRta= $sqlRta. " AND CSCPFichaFamiliaRecursos.consecutivo=".$_SESSION["ccfConsecutivo"] ;

	$sqlRta = $sqlRta. " AND CSCPFichaFamiliaRecursos.numFormulario='".$_SESSION["ccfFormulario"]."'" ;
	$sqlRta = $sqlRta. " AND CSCPFichaFamiliaRecursos.nroVivienda=".$_SESSION["ccfVivienda"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaFamiliaRecursos.nroFamilia=".$_SESSION["ccfFamilia"] ;
	$sqlRta = $sqlRta. " AND CSCPFichaFamiliaRecursos.codOpcion=".$T;
	$sqlRta = $sqlRta. " ORDER BY codItemRecurso";
	$cursorRta = mssql_query($sqlRta);
	
	if($cant == 1)
	{
		$num = 6;
	}
	else{
		$num = 4;
	}
	?>
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
	  <tr class="TituloTabla2">
		<td colspan="<? echo $num; ?>" class="TituloTabla"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
	  </tr>

	  <tr class="TituloTabla2">
		<td>Item</td>
		<td>Aplicabilidad</td>
		<td><? echo $pTituloList2; ?></td>
		<td><? echo $pTituloList3; ?></td>
		<? if($cant==1){?>
	    <td>Cantidad</td>
	    <td>Unidad</td>
		<? } ?>
	  </tr>
          
	  <?
	  while ($RegRta=mssql_fetch_array($cursorRta))  
	  { 
	  ?>
	  <tr class="TxtTabla">
	  	<td><? echo $RegRta[nomRecurso]; ?></td>
		<td><? echo $RegRta[nomAplica]; ?></td>
		<td><? echo $RegRta[nomLugar]; ?></td>
		<td><? echo $RegRta[nomFrecuencia]; ?></td>
		<? if($cant==1){?>
        <td><? echo $RegRta[cantidad]; ?></td>
	    <td><? echo $RegRta[nomUnidad]; ?></td>
		<? } ?>
	  </tr>
	  <? 
	  }//cierra while ($RegRta=mssql_fetch_array($cursorRta))  
	  ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["ccfUsuPerfil"] == 1) OR ($_SESSION["ccfUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSEFichaRecursos.php?Opc=<?=$T;?>&Opc1=<?=$T1;?>&Opc2=<?=$T2;?>&Opc3=<?=$T3;?>&Opc4=<?=$T4;?>&pag=<?=$Pag;?>&cant=<?=$cant?>','vAF','scrollbars=yes,resizable=yes,width=950,height=350')" value="Nuevo">
		 <? } 
			else
			{ ?>
				<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaRecursos.php?Opc=<?=$T;?>&Opc1=<?=$T1;?>&Opc2=<?=$T2;?>&Opc3=<?=$T3;?>&Opc4=<?=$T4;?>&pag=<?=$Pag;?>&cant=<?=$cant?>&accion=2','vAF','scrollbars=yes,resizable=yes,width=950,height=350')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('upCSEFichaRecursos.php?Opc=<?=$T;?>&Opc1=<?=$T1;?>&Opc2=<?=$T2;?>&Opc3=<?=$T3;?>&Opc4=<?=$T4;?>&pag=<?=$Pag;?>&cant=<?=$cant?>&accion=3','vAF','scrollbars=yes,resizable=yes,width=950,height=350')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    
    <!--Espacio-->    
   <table width="100%"  border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>

<? }  
*/
?>




<!----------------------------------------------------------------------------------------->



<?
//****************************************************************************/
//Funcion que permite visualizar la información de la apropiación de recursos naturales
//$T	=Opcion
//$Pag  =Página a la que regresa
//****************************************************************************/
/*
function Genera_Tabla_Apropiacion($T,$Pag)
{	
    //Trae la información de Titulo
    $sqlTit="SELECT  *
           	 FROM  tmOpciones ";
    $sqlTit= $sqlTit. " WHERE tmOpciones.codModulo=".$_SESSION["ccfModulo"];
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
    $cursorTit = mssql_query($sqlTit);
    if ($regTit=mssql_fetch_array($cursorTit)) 
    {
        $pTituloPpal60 = $regTit[pregunta];
		$nomOpcion = $regTit[nomOpcion];
    }
    ?>	
	<!--Apropiaciones -->
	<table width="100%" border="0">    
	  <tr>
	    <td class="TituloTabla" colspan="3" align="center"><? echo $pTituloPpal60; ?><a name="<? echo $T; ?>"></a></td>
      </tr>
      <tr align="center" class="TxtTabla">
      	<? //Búsqueda de la información almacenadas de las apropiaciones

///CONSULTA NO FUNCIONA
		$qry = "SELECT *
				FROM CSCPFichaApropiacion ";	
		$qry = $qry. " WHERE nroFamilia=".$_SESSION["ccfMFamilia"];
		$cursorApropia = mssql_query($qry);	
		?>
		<td width="33%" class="TituloTabla2">Tipo de actividad </td>
		<td width="33%" align="center" class="TituloTabla2">Sitio de extracci&oacute;n </td>
		<td align="center" class="TituloTabla2">Destino</td>
		</tr>
	  <? 
		while ($regApropia = mssql_fetch_array($cursorApropia))  
		{ 
			//Búsqueda del nombre de la apropiación
			$sqlNom = "SELECT * FROM tmItems
					   WHERE tmItems.codItem = ".$regApropia[codItemApropiacion]."
					   AND tmItems.codOpcion = ".$T;
			$cursorNom = mssql_query($sqlNom);
			$regNom = mssql_fetch_array($cursorNom);
	  ?>
			<tr align="center" class="TxtTabla">
			  <td width="33%" align="center" class="TxtTabla"><? echo $regNom[nomItem] ;?></td>
			  <td width="33%" class="TxtTabla"><? echo $regApropia[extraccion] ;?></td>
			  <td class="TxtTabla"><? echo $regApropia[destino] ;?></td>
			</tr>
	  <? 
	  } ?>
	</table>

 	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td>
		  <? if(mssql_num_rows($cursorApropia) == 0){?>
		  <input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addApropia.php?Opc=<?=$T;?>&pag=<?=$Pag;?>','vAF','scrollbars=yes,resizable=yes,width=1000,height=400')" value="Nueva Actividad">
		  <? }
		  else{ ?>
		  <input type="button" name="Submit4" class="Boton" onClick="MM_openBrWindow('upApropia.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&accion=2','vAF','scrollbars=yes,resizable=yes,width=1000,height=400')" value="Editar">
		  <input type="button" name="Submit5" class="Boton" onClick="MM_openBrWindow('upApropia.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&accion=3','vAF','scrollbars=yes,resizable=yes,width=1000,height=400')" value="Eliminar">
		  <? }?>
		</td>
	  </tr>
	</table>
    
    <!--Espacio-->    
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
<?
}
*/
?>

<? 
//****************************************************************************/
//Funcion que permite visualizar las opciones que tiene una cantidad
//$T	=Opcion
//$Sum=Maximo Valor que se debe registrar
//$pag  =Página a la que regresa
//****************************************************************************/
/*
function Genera_Tabla_SeleccionP($T)
{
	//Trae la información de Titulo

///	CONSULTA NO FUNCIONA
	$sqlTit="SELECT  TOP(1) tbOpciones.codOpcion, tbOpciones.nomOpcion, tbOpciones.numOpcion, tbOpciones.codSeccion, 
				   tbItems.nomItem
		   FROM    tbOpciones INNER JOIN
				   tbItems ON tbOpciones.codOpcion = tbItems.codOpcion ";
	$sqlTit= $sqlTit. " WHERE tbOpciones.codOpcion=" .$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[nomOpcion];
	}

	//Obtener la información 
	//dbo.FPFichaSocialUnidadesPInfo
	//codModulo, predioNo, codInmueble, codUnidad, codItem, respItem, fechaGraba, usuarioGraba, fechaMod, usuarioMod

/// CONSULTA NO FUNCIONA
	$sqlRta=" SELECT *
			  FROM    tbItems INNER JOIN
                      tbOpciones ON tbItems.codOpcion = tbOpciones.codOpcion RIGHT OUTER JOIN
                      FPFichaSocialUnidadesPInfo ON tbItems.codItem = FPFichaSocialUnidadesPInfo.codItem";
	$sqlRta= $sqlRta. " WHERE FPFichaSocialUnidadesPInfo.codModulo= " .$_SESSION["rsModulo"] ; 
	$sqlRta= $sqlRta. " AND FPFichaSocialUnidadesPInfo.predioNo='" .$_SESSION["rsFormulario"] ."'";

	$sqlRta= $sqlRta. " AND FPFichaSocialUnidadesPInfo.codInmueble=" .$_SESSION["rsInmueble"];
	$sqlRta= $sqlRta. " AND FPFichaSocialUnidadesPInfo.codUnidad=" .$_SESSION["rsUnidad"];
	$sqlRta= $sqlRta. " AND tbOpciones.codOpcion=" .$T;
	$cursorRta = mssql_query($sqlRta);
	?>

	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
		
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
		  <tr class="TituloTabla2">
			<td colspan="2"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
		  </tr>

      <?php while ($RegRta=mssql_fetch_array($cursorRta))  
	  { ?>
      <tr class="TxtTabla">
        <td width="70%"><?php echo $RegRta[nomItem]  ; ?></td>
		<td width="7%" align="center">
		<?php if ($RegRta[respItem]=='1') 
		{ ?> 
			<img src="../images/Si.gif" alt="Editar" width="16" height="14" border="0"> 
		<? } ; ?></td>
	  </tr>
	  <? } ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["rsUsuPerfil"] == 1) OR ($_SESSION["rsUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addCSEFichaInfoBoolean.php?Opc=<? echo $T;?>&amp;cual=<? echo $cual;?>&amp;Q=<? echo $Q;?>&amp;pag=<? echo $Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Nuevo">
		 <? } 
			else
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('../fs/upSocialInfoP.php?accion=2&amp;Opc=<? echo $T;?>&amp;cual=<? echo $cual;?>&amp;Q=<? echo $Q;?>&amp;pag=<? echo $Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('../fs/upSocialInfoP.php?accion=3&amp;Opc=<? echo $T;?>&amp;cual=<? echo $cual;?>&amp;Q=<? echo $Q;?>&amp;pag=<? echo $Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>
    <table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>

<? }  
*/
?>

<?
//****************************************************************************/
//Funcion que permite visualizar la información de las actividades agropecuarias
//$T	=Opcion
//$Pag  =Página a la que regresa
//$Des	=Opción del destino
//****************************************************************************/
/*
function Genera_Tabla_Agropecuaria($T,$Pag,$Des)
{	
    //Trae la información de Titulo
    $sqlTit="SELECT  *
           	 FROM  tmOpciones ";
    $sqlTit= $sqlTit. " WHERE tmOpciones.codModulo=".$_SESSION["ccfModulo"];
	$sqlTit= $sqlTit. " AND tmOpciones.codOpcion=".$T;
    $cursorTit = mssql_query($sqlTit);
    if ($regTit=mssql_fetch_array($cursorTit)) 
    {
        $pTituloPpal60 = $regTit[pregunta];
		$nomOpcion = $regTit[nomOpcion];
    }
    ?>	
	<!--Actividades agropecuarias -->
	<table width="100%" border="0">    
	  <tr>
	    <td class="TituloTabla" colspan="4" align="center"><? echo $pTituloPpal60; ?><a name="<? echo $T; ?>"></a></td>
      </tr>
      <tr align="center" class="TxtTabla">
      	<? 

//CONSULTA NO FUNCIONA
		$qry = "SELECT CSCPFichaActividadAgroFamilia.nroFamilia, CSCPFichaActividadAgroFamilia.consecActividad, CSCPFichaActividadAgroFamilia.codItemActividad, 
				CSCPFichaActividadAgroFamilia.cantidad, CSCPFichaActividadAgroFamilia.codItemDestino, CSCPFichaActividadAgroFamilia.lugarVenta, 
				CSCPFichaActividadAgroFamilia.fechaGraba, CSCPFichaActividadAgroFamilia.usuarioGraba, CSCPFichaActividadAgroFamilia.fechaMod, 
				CSCPFichaActividadAgroFamilia.usuarioMod, tmItems.nomItem AS nomActividad, tmItems_1.nomItem AS nomDestino
				FROM CSCPFichaActividadAgroFamilia INNER JOIN
				tmItems ON CSCPFichaActividadAgroFamilia.codItemActividad = tmItems.codItem INNER JOIN
				tmItems AS tmItems_1 ON CSCPFichaActividadAgroFamilia.codItemDestino = tmItems_1.codItem ";	
		$qry = $qry. " WHERE tmItems.codOpcion=" .$T;
		$qry = $qry. " AND nroFamilia=".$_SESSION["ccfFamilia"];
		//echo $qry;
		$cursorAgro = mssql_query($qry);	
	?>
		<td width="25%" class="TituloTabla2"><? echo $nomOpcion;?></td>
		<td width="25%" align="center" class="TituloTabla2">
			<? if($T==40){
			   		echo "Área sembrada (m2)";
			   }
			   if($T==42){
			   		echo "No.";
			   }
			?>
		</td>
		<td width="25%" align="center" class="TituloTabla2">Destino</td>
		<td width="25%" align="center" class="TituloTabla2">Lugar de venta </td>
	  </tr>
	  <? 
		$CantidadRegAgro= mssql_num_rows($cursorAgro); 				
		$k=1;
		while ($regAgro = mssql_fetch_array($cursorAgro))  
		{ ?>
		
		<tr align="center" class="TxtTabla">
			<td width="25%" align="center" class="TxtTabla"><? echo $regAgro[nomActividad] ;?></td>
			<td width="25%" class="TxtTabla"><? echo $regAgro[cantidad] ;?></td>
			<td width="25%" class="TxtTabla"><? echo $regAgro[nomDestino] ;?></td>
			<td width="25%" class="TxtTabla"><? echo $regAgro[lugarVenta] ;?></td>
		  </tr>
				  
	  <? $k=$k+1;
	  } ?>
	</table>

 	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	  <tr align="right">
		<td><? if($CantidadRegAgro==0){?>
		  <input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('addAgro.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&des=<?=$Des;?>','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" value="Nueva Actividad">
		  <?
		  }
		  else{
		  ?>
		  <input type="button" class="Boton" name="Submit2" onClick="MM_openBrWindow('upAgro.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&des=<?=$Des;?>&accion=2','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" value="Editar">
		  <input type="button" class="Boton" name="Submit3" onClick="MM_openBrWindow('upAgro.php?Opc=<?=$T;?>&pag=<?=$Pag;?>&des=<?=$Des;?>&accion=3','vAF','scrollbars=yes,resizable=yes,width=700,height=400')" value="Eliminar">
		  <?
		  }
		  ?>
		</td>
	  </tr>
	</table>
    
    <!--Espacio-->    
	<table width="100%"  border="0">
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	</table>
<?
}
*/
?>

<? 

//****************************************************************************/
//Funcion que permite visualizar las opciones que tiene una cantidad
//$T	=Opcion
//$Sum=Maximo Valor que se debe registrar
//$pag  =Página a la que regresa
//****************************************************************************/
/*
function Genera_Tabla_CantidadS($T)
{

	//Trae la información de Titulo

///CONSULTA NO FUNCIONA
	$sqlTit="SELECT  TOP(1) tbOpciones.codOpcion, tbOpciones.nomOpcion, tbOpciones.numOpcion, tbOpciones.codSeccion, 
				   tbItems.nomItem
		   FROM    tbOpciones INNER JOIN
				   tbItems ON tbOpciones.codOpcion = tbItems.codOpcion ";
	$sqlTit= $sqlTit. " WHERE tbOpciones.codOpcion=" .$T;
	$cursorTit = mssql_query($sqlTit);
	if ($regTit=mssql_fetch_array($cursorTit)) 
	{
		$pTituloPpal=$regTit[nomOpcion];
	}

	//Obtener la información del Inmueble segúnOpión
	//dbo.FPFichaSocialUnidadesRCant
	//codModulo, predioNo, codInmueble, codUnidad, codItem, cantidad, fechaGraba, usuarioGraba, fechaMod, usuarioMod

//CONSULT ANO FUNCIONA
	$sqlRta=" SELECT   *
			  FROM    tbItems LEFT OUTER JOIN
                      tbOpciones ON tbItems.codOpcion = tbOpciones.codOpcion RIGHT OUTER JOIN
                      FPFichaSocialUnidadesRCant ON tbItems.codItem = FPFichaSocialUnidadesRCant.codItem 
					  RIGHT OUTER JOIN FPFichaSocialUnidades 
					  ON FPFichaSocialUnidadesRCant.codModulo = FPFichaSocialUnidades.codModulo AND 
					  FPFichaSocialUnidadesRCant.predioNo = FPFichaSocialUnidades.predioNo AND 
                      FPFichaSocialUnidadesRCant.codInmueble = FPFichaSocialUnidades.codInmueble";
	$sqlRta= $sqlRta. " WHERE FPFichaSocialUnidades.codModulo= " .$_SESSION["rsModulo"] ; 
	$sqlRta= $sqlRta. " AND FPFichaSocialUnidades.predioNo='" .$_SESSION["rsFormulario"]."'";
	$sqlRta= $sqlRta. " AND FPFichaSocialUnidades.codInmueble=" .$_SESSION["rsInmueble"];
	$sqlRta= $sqlRta. " AND FPFichaSocialUnidades.codUnidad=" .$_SESSION["rsUnidad"];
	$sqlRta= $sqlRta. " AND tbOpciones.codOpcion=" .$T;
	$cursorRta = mssql_query($sqlRta);
	?>
	<table width="100%"  border="0" cellspacing="1" cellpadding="0">
      <tr>
        <td bgcolor="#FFFFFF">
		
		<table width="100%"  border="0" cellspacing="1" cellpadding="0">
		  <tr class="TituloTabla2">
			<td colspan="2"><? echo $pTituloPpal ;?><a name="<? echo $T; ?>"></a></td>
		  </tr>
	<?
	  $TotalC=0;		
	  while ($RegRta=mssql_fetch_array($cursorRta))  
	  { ?>
      <tr class="TxtTabla">
        <td width="70%"><?php echo $RegRta[nomItem]  ; ?></td>
		<td width="7%" align="right"><?php echo $RegRta[cantidad]  ; ?></td>
	  </tr>
	  <? 
	    $TotalC= $TotalC+ $RegRta[cantidad] ;
	  
	  } ?>
    </table>

	<!-- Botones -->    
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right">
		<!-- Validación de Perfil de Usuario -->
	<? if (($_SESSION["rsUsuPerfil"] == 1) OR ($_SESSION["rsUsuPerfil"] == 2) OR ($_SESSION["ccfUsuPerfil"] == 4) OR ($_SESSION["ccfUsuPerfil"] == 13)) 	
		{ 	if (mssql_num_rows($cursorRta) == 0) 
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('../fs/addSocialUnidadesRCant.php?Opc=<? echo $T;?>&amp;cual=<? echo $cual;?>&amp;Q=<? echo $Q;?>&amp;pag=<? echo $Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Nuevo">
		 <? } 
			else
			{ ?>
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('../fs/upSocialUnidadesRCant.php?accion=2&amp;Opc=<? echo $T;?>&amp;cual=<? echo $cual;?>&amp;Q=<? echo $Q;?>&amp;pag=<? echo $Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Editar">
			<input name="Submit" type="button" class="Boton" onClick="MM_openBrWindow('../fs/upSocialUnidadesRCant.php?accion=3&amp;Opc=<? echo $T;?>&amp;cual=<? echo $cual;?>&amp;Q=<? echo $Q;?>&amp;pag=<? echo $Pag;?>','vAF','scrollbars=yes,resizable=yes,width=780,height=300')" value="Eliminar">				
			<? }
	}	 ?>
		</td>
      </tr>
    </table>

<? } 
*/ 
?>

<?php

?>


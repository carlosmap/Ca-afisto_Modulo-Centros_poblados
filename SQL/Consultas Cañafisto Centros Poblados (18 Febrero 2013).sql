--CONSULTAS CENTROS POBLADOS

--CONSULTA, PREGUNTAS DE UNICA RESPUESTA DESDE (2.4 A 3.12)

select * from tmUsuarios where numDocumento= '1032399808'

SELECT     CSCPFicha.numFormulario , CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem
FROM         CSCPFichaInfoBoolean INNER JOIN
                      tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoBoolean.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoBoolean.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoBoolean.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoBoolean.consecutivo = CSCPFicha.consecutivo 
                      
                      INNER JOIN
                      tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (32)) order by(CSCPFicha.numFormulario)


--CONSULTA, PREGUNTAS DE RESPUESTA MULTIPLE DESDE (2.4 A 3.12)

SELECT    CAST(CSCPFicha.numFormulario AS varchar) AS sss , CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem
FROM         CSCPFichaInfoBoolean INNER JOIN
                      tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoBoolean.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoBoolean.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoBoolean.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoBoolean.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (34)) order by(CSCPFicha.numFormulario)



--CONSULTA, PREGUNTAS DE CANTIDAD SIN ITEMS (2.4 A 3.12)

SELECT      CAST(CSCPFicha.numFormulario AS varchar) AS Expr1, CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoCant.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoCant.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoCant.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoCant.consecutivo = CSCPFicha.consecutivo
WHERE     (CSCPFichaInfoCant.codOpcion IN (33)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)


--CONSULTA, PREGUNTAS DE CANTIDAD CON ITEMS (2.4 A 3.12)

SELECT    CAST(CSCPFicha.numFormulario AS varchar) AS Expr1, CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem, CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoCant.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoCant.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoCant.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoCant.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion AND
                       CSCPFichaInfoCant.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoCant.codOpcion IN (34)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)

---CONSULTA DE UBUCACION (4.10)
SELECT     CSCPFicha.numFormulario, CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, tmDepartamentos.nomDepartamento, 
                      tmMunicipios.nomMunicipio, tmVeredas.nomVereda
FROM         CSCPFichaViviendaVsFamilia INNER JOIN
                      tmDepartamentos ON CSCPFichaViviendaVsFamilia.codDepartamento = tmDepartamentos.codDepartamento INNER JOIN
                      tmMunicipios ON CSCPFichaViviendaVsFamilia.codDepartamento = tmMunicipios.codDepartamento AND 
                      CSCPFichaViviendaVsFamilia.codMunicipio = tmMunicipios.codMunicipio INNER JOIN
                      tmVeredas ON CSCPFichaViviendaVsFamilia.codDepartamento = tmVeredas.codDepartamento AND 
                      CSCPFichaViviendaVsFamilia.codMunicipio = tmVeredas.codMunicipio AND CSCPFichaViviendaVsFamilia.codVereda = tmVeredas.codVereda INNER JOIN
                      CSCPFicha ON CSCPFichaViviendaVsFamilia.codProyecto = CSCPFicha.codProyecto AND CSCPFichaViviendaVsFamilia.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaViviendaVsFamilia.numFormulario = CSCPFicha.numFormulario AND CSCPFichaViviendaVsFamilia.consecutivo = CSCPFicha.consecutivo
ORDER BY CSCPFichaViviendaVsFamilia.numFormulario

---CONSULTA DE RESPUESTAS MULTIPLE CON MULTIPLES COLUMNAS
SELECT     CSCPFicha.numFormulario , CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem, tmSubItems.nomSubItem
FROM         CSCPFichaInfoBooleanM INNER JOIN
                      tmOpciones ON CSCPFichaInfoBooleanM.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBooleanM.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoBooleanM.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoBooleanM.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoBooleanM.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoBooleanM.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoBooleanM.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON CSCPFichaInfoBooleanM.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBooleanM.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoBooleanM.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBooleanM.codItem = tmItems.codItem INNER JOIN
                      tmSubItems ON CSCPFichaInfoBooleanM.codProyecto = tmSubItems.codProyecto AND CSCPFichaInfoBooleanM.codModulo = tmSubItems.codModulo AND 
                      CSCPFichaInfoBooleanM.codOpcion = tmSubItems.codOpcion AND CSCPFichaInfoBooleanM.codSubItem = tmSubItems.codSubItem
WHERE     (CSCPFichaInfoBooleanM.respItem = 1) AND (CSCPFichaInfoBooleanM.codOpcion IN (34))
ORDER BY CSCPFicha.numFormulario
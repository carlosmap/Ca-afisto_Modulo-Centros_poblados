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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (23)) order by(CSCPFicha.numFormulario)


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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (24)) order by(CSCPFicha.numFormulario)



--CONSULTA, PREGUNTAS DE CANTIDAD SIN ITEMS (2.4 A 3.12)

SELECT      CAST(CSCPFicha.numFormulario AS varchar) AS Expr1, CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoCant.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoCant.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoCant.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoCant.consecutivo = CSCPFicha.consecutivo
WHERE     (CSCPFichaInfoCant.codOpcion IN (131)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)


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
WHERE     (CSCPFichaInfoCant.codOpcion IN (25)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)


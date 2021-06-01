--CONSULTAS CENTROS POBLADOS

--CONSULTAS , PREGUNTAS DESDE (2.4 A 3.12)

-- 2.4 Tipo de predio (Opcion 6)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (6)) order by(CSCPFicha.numFormulario)

--- 2.5 Usos del predio (Opcion 7)
SELECT    CAST(CSCPFicha.numFormulario AS varchar) AS sss , CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem
FROM         CSCPFichaInfoBoolean INNER JOIN
                      tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoBoolean.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoBoolean.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoBoolean.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoBoolean.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (7)) order by(CSCPFicha.numFormulario)

--- 2.6 Cuál es la relación del entrevistado con el predio? (Opcion 8)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (8)) order by(CSCPFicha.numFormulario)

--- 2.7.1 Trabajador (Opcion 9)
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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (9)) order by(CSCPFicha.numFormulario)


--- 2.7.2 Morador (Opcion 10)
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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (10)) order by(CSCPFicha.numFormulario)

--- 2.7.3 Familiar (Opcion 11)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (11)) order by(CSCPFicha.numFormulario)


--- 2.8 ¿Desarrolla alguna actividad económica en el predio? (Opcion 12)
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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (12)) order by(CSCPFicha.numFormulario)

-- 2.9  ¿Que actividades económicas se realizan en el predio? (Opcion 13)

SELECT    CSCPFicha.numFormulario AS varchar, CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem
FROM         CSCPFichaInfoBoolean INNER JOIN
                      tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoBoolean.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoBoolean.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoBoolean.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoBoolean.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (13)) order by(CSCPFicha.numFormulario)


--- 2.10 Número de viviendas en el predio (Opcion 14)
SELECT   CSCPFicha.numFormulario , CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem, CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoCant.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoCant.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoCant.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoCant.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion AND
                       CSCPFichaInfoCant.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoCant.codOpcion IN (14)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)


--- 2.11 Área Total del predio  (Opcion 39)

SELECT     CSCPFicha.numFormulario, CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoCant.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoCant.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoCant.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoCant.consecutivo = CSCPFicha.consecutivo
WHERE     (CSCPFichaInfoCant.codOpcion IN (39)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)

--- 3.1 La vivienda o edificación cuenta con:

SELECT   CSCPFicha.numFormulario , CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem
FROM         CSCPFichaInfoBoolean INNER JOIN
                      tmOpciones ON CSCPFichaInfoBoolean.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoBoolean.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoBoolean.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoBoolean.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoBoolean.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON CSCPFichaInfoBoolean.codProyecto = tmItems.codProyecto AND CSCPFichaInfoBoolean.codModulo = tmItems.codModulo AND 
                      CSCPFichaInfoBoolean.codOpcion = tmItems.codOpcion AND CSCPFichaInfoBoolean.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (15)) order by(CSCPFicha.numFormulario)


--3.2 Si no posee alcantarillado, ¿cuál es el método de menejo de las aguas residuales? (Opcion 16)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (16)) order by(CSCPFicha.numFormulario)


---3.3 ¿Que hacen generalmente con los residuos que producen? (Opcion 17)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (17)) order by(CSCPFicha.numFormulario)

---3.4 Sistema de abastecimiento de agua (Opcion 18)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (18)) order by(CSCPFicha.numFormulario)

--3.5 El agua utilizada para abastecimiento, ¿Posee tratamiento? (Opcion 19)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (19)) order by(CSCPFicha.numFormulario)

---3.6 Combustible predominante para cocinar (Opcion 20)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (20)) order by(CSCPFicha.numFormulario)

--- 3.7 Material predominante de las paredes exteriores de la vivienda o edificación (Opcion 21)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (21)) order by(CSCPFicha.numFormulario)

-- 3.8 Material predominante del techo de la vivienda o edificación (Opcion 22)

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
WHERE     (CSCPFichaInfoBoolean.respItem = 1) AND (CSCPFichaInfoBoolean.codOpcion IN (22)) order by(CSCPFicha.numFormulario)

--- 3.9 MAterial predominante del piso de la vivienda o edificación (Opcion 23)

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

-- 3.10 Conformación de la vivienda (Opcion 24)

SELECT    CSCPFicha.numFormulario , CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem, CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoCant.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoCant.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoCant.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoCant.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion AND
                       CSCPFichaInfoCant.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoCant.codOpcion IN (24)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)

--3.11 Infraestrucutras anexas a la vivienda o edificación (Opcion 25)

SELECT    CSCPFicha.numFormulario , CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, tmItems.nomItem, CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoCant.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoCant.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoCant.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoCant.consecutivo = CSCPFicha.consecutivo INNER JOIN
                      tmItems ON tmOpciones.codProyecto = tmItems.codProyecto AND tmOpciones.codModulo = tmItems.codModulo AND tmOpciones.codOpcion = tmItems.codOpcion AND
                       CSCPFichaInfoCant.codItem = tmItems.codItem
WHERE     (CSCPFichaInfoCant.codOpcion IN (25)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)

--- 3.12 Área construida de la vivienda o edificación (Opcion 131)

SELECT      CAST(CSCPFicha.numFormulario AS varchar) AS Expr1, CSCPFicha.idCartografico, CSCPFicha.segregacion, CSCPFicha.vivienda, CSCPFicha.hogar, 
                      tmOpciones.nomOpcion, CSCPFichaInfoCant.cantidad
FROM         CSCPFichaInfoCant INNER JOIN
                      tmOpciones ON CSCPFichaInfoCant.codProyecto = tmOpciones.codProyecto AND CSCPFichaInfoCant.codModulo = tmOpciones.codModulo AND 
                      CSCPFichaInfoCant.codOpcion = tmOpciones.codOpcion INNER JOIN
                      CSCPFicha ON CSCPFichaInfoCant.codProyecto = CSCPFicha.codProyecto AND CSCPFichaInfoCant.codModulo = CSCPFicha.codModulo AND 
                      CSCPFichaInfoCant.numFormulario = CSCPFicha.numFormulario AND CSCPFichaInfoCant.consecutivo = CSCPFicha.consecutivo
WHERE     (CSCPFichaInfoCant.codOpcion IN (131)) AND (CSCPFichaInfoCant.codModulo = 1) AND (CSCPFichaInfoCant.codProyecto = 5) order by(CSCPFicha.numFormulario)



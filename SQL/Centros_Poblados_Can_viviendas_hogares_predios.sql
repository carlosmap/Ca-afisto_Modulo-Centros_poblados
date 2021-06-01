
													--CONSULTAS CAÑAFISTO CENTROS POBLADOS 
													

--CANTIDAD DE PREDIOS Y FORMULARIOS ASOCIADOS

select distinct(identificaPredio),COUNT(*)as cant_formularios from CSCPFicha group by(identificaPredio)

 
--CANTIDAD DE VIVIENDAS  ASOCIADAS A UN PREDIO
--where idCartografico like '%FG123321234%'

select distinct( identificaPredio),COUNT(unidadCensal) as cantidad_viviendas  from (
select CSCPFicha.*, CSCPFichaVivienda.unidadCensal from CSCPFichaVivienda
inner join CSCPFichaPrediosVsVivienda on CSCPFichaPrediosVsVivienda.nroVivienda= CSCPFichaVivienda.nroVivienda
inner join CSCPFichaVsPredio on CSCPFichaVsPredio.numFormulario=CSCPFichaPrediosVsVivienda.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFichaPrediosVsVivienda.consecutivo
and CSCPFichaVsPredio.nroPredio=CSCPFichaPrediosVsVivienda.nroPredio
inner join CSCPFicha on CSCPFichaVsPredio.numFormulario=CSCPFicha.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFicha.consecutivo
) as Viviendas 
 group by(identificaPredio)
 
 select distinct( identificaPredio),COUNT(unidadCensal) as cantidad_viviendas  from (
select CSCPFicha.*, CSCPFichaVivienda.unidadCensal from CSCPFichaVivienda
inner join CSCPFichaPrediosVsVivienda on CSCPFichaPrediosVsVivienda.nroVivienda= CSCPFichaVivienda.nroVivienda
inner join CSCPFichaVsPredio on CSCPFichaVsPredio.numFormulario=CSCPFichaPrediosVsVivienda.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFichaPrediosVsVivienda.consecutivo
and CSCPFichaVsPredio.nroPredio=CSCPFichaPrediosVsVivienda.nroPredio
inner join CSCPFicha on CSCPFichaVsPredio.numFormulario=CSCPFicha.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFicha.consecutivo
) as Viviendas 
group by(identificaPredio) 


---CANTIDAD DE HOGARES  ASOCIADAS A UN PREDIO

select distinct( identificaPredio),COUNT(unidadSocial) as cantidad_hogares  from (
select CSCPFichaFamilia.unidadSocial ,CSCPFicha.* --CSCPFicha.*, CSCPFichaVivienda.unidadCensal
 from CSCPFichaFamilia
 inner join CSCPFichaViviendaVsFamilia on CSCPFichaFamilia.nroFamilia=CSCPFichaViviendaVsFamilia.nroFamilia
 
inner join CSCPFichaPrediosVsVivienda on CSCPFichaPrediosVsVivienda.nroVivienda= CSCPFichaViviendaVsFamilia.nroVivienda 
and CSCPFichaPrediosVsVivienda.nroPredio=CSCPFichaViviendaVsFamilia.nroPredio and CSCPFichaPrediosVsVivienda.consecutivo=CSCPFichaViviendaVsFamilia.consecutivo
and CSCPFichaPrediosVsVivienda.numFormulario=CSCPFichaViviendaVsFamilia.numFormulario 

inner join CSCPFichaVsPredio on CSCPFichaVsPredio.numFormulario=CSCPFichaPrediosVsVivienda.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFichaPrediosVsVivienda.consecutivo
and CSCPFichaVsPredio.nroPredio=CSCPFichaPrediosVsVivienda.nroPredio
inner join CSCPFicha on CSCPFichaVsPredio.numFormulario=CSCPFicha.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFicha.consecutivo

) as hogares 
group by(identificaPredio) 
 
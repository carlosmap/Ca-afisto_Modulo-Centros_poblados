
---PREDIOS SIN VIVIENDAS 
 
 select * from CSCPFicha --total 1580
 SELECT * FROM CSCPFichaVivienda --1542
 
 select * from CSCPFicha where numFormulario not in(
 
 select CSCPFicha.numFormulario from CSCPFicha
 inner join CSCPFichaVsPredio on CSCPFichaVsPredio.numFormulario=CSCPFicha.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFicha.consecutivo
and CSCPFichaVsPredio.codModulo=CSCPFicha.codModulo

inner join CSCPFichaPrediosVsVivienda on CSCPFichaVsPredio.numFormulario=CSCPFichaPrediosVsVivienda.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFichaPrediosVsVivienda.consecutivo
and CSCPFichaVsPredio.codModulo=CSCPFichaPrediosVsVivienda.codModulo and 
CSCPFichaVsPredio.nroPredio= CSCPFichaPrediosVsVivienda.nroPredio
inner join CSCPFichaVivienda on CSCPFichaPrediosVsVivienda.nroVivienda=CSCPFichaVivienda.nroVivienda
)

---PREDIOS SIN FAMILIAS
select * from CSCPFicha --total 1588
SELECT * FROM  CSCPFichaFamilia --1490

 select * from CSCPFicha where numFormulario not in(
 
 select CSCPFicha.numFormulario from CSCPFicha
 inner join CSCPFichaVsPredio on CSCPFichaVsPredio.numFormulario=CSCPFicha.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFicha.consecutivo
and CSCPFichaVsPredio.codModulo=CSCPFicha.codModulo

inner join CSCPFichaPrediosVsVivienda on CSCPFichaVsPredio.numFormulario=CSCPFichaPrediosVsVivienda.numFormulario and CSCPFichaVsPredio.consecutivo=CSCPFichaPrediosVsVivienda.consecutivo
and CSCPFichaVsPredio.codModulo=CSCPFichaPrediosVsVivienda.codModulo and 
CSCPFichaVsPredio.nroPredio= CSCPFichaPrediosVsVivienda.nroPredio

Inner join CSCPFichaViviendaVsFamilia on  CSCPFichaViviendaVsFamilia.numFormulario=CSCPFichaPrediosVsVivienda.numFormulario and CSCPFichaViviendaVsFamilia.consecutivo=CSCPFichaPrediosVsVivienda.consecutivo
and CSCPFichaViviendaVsFamilia.codModulo=CSCPFichaPrediosVsVivienda.codModulo and 
CSCPFichaViviendaVsFamilia.nroPredio= CSCPFichaPrediosVsVivienda.nroPredio AND 
CSCPFichaViviendaVsFamilia.nroVivienda=CSCPFichaPrediosVsVivienda.nroVivienda

Inner join CSCPFichaFamilia on CSCPFichaFamilia.nroFamilia= CSCPFichaViviendaVsFamilia.nroFamilia
)

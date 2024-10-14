CREATE VIEW tabla AS
SELECT p.id AS id,p.nombres AS nombres,p.ap AS ap,p.am AS am,p.cargo AS cargo,subconsulta.fecha_inicial AS fecha_inicial,
subconsulta.fecha_final AS fecha_final
FROM (planilla p join (select planilla.nombres AS nombres,planilla.ap AS ap,planilla.am AS am,min(planilla.spdat1)
	AS fecha_inicial,
	max(planilla.spdat1) AS fecha_final FROM planilla group by planilla.nombres, planilla.ap,planilla.am) subconsulta
on (p.nombres = subconsulta.nombres and p.ap = subconsulta.ap and p.am = subconsulta.am and p.spdat1 = subconsulta.fecha_final));
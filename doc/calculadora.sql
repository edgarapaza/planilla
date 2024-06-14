DELIMITER $
CREATE PROCEDURE calculadora(IN fecha1 date, IN fecha2 date, IN iduser int)
begin 
SELECT
(SELECT timestampdiff(year, fecha1,fecha2)) AS anios
,(SELECT timestampdiff(month, fecha1,fecha2) - (SELECT timestampdiff(year, fecha1,fecha2)) * 12) AS meses
,(SELECT timestampdiff(day, fecha1,fecha2) / (10*24) ) AS dias
FROM planilla AS p WHERE id = iduser;
end $

delimiter ;
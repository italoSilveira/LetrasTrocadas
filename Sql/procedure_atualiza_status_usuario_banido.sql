DELIMITER |
	CREATE PROCEDURE sp_atualiza_status_usu_banido (in id INT)
		BEGIN
			IF status = 1 THEN 
			UPDATE tbl_usuario SET status = 3 WHERE id_usuario = id;
			ELSE 
				IF status = 3 THEN 
					UPDATE tbl_usuario SET status = 1 WHERE id_usuario = id;
				END IF;
			END IF;
		END ;		
|
DELIMITER ;
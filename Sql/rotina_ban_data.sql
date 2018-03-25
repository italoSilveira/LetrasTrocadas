DELIMITER |
CREATE PROCEDURE sp_checa_data_ban ()
		BEGIN
			SET @data_ban := (SELECT data FROM tbl_lista_banidos);
			SET @usuario_ban := (SELECT usuario_id FROM tbl_lista_banidos 
			WHERE TO_DAYS(NOW()) - TO_DAYS(@data_ban) <= 30);
			SET @id_lista_ban := (SELECT id_lista_banidos FROM tbl_lista_banidos 
			WHERE TO_DAYS(NOW()) - TO_DAYS(@data_ban) <= 30);
			UPDATE tbl_usuario SET status = 1 WHERE id_usuario = @usuario_ban;
		END ;
|
DELIMITER ;	

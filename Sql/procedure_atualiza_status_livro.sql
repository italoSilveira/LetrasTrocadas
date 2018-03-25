
DELIMITER |
	CREATE PROCEDURE SP_atualiza_status_livro (IN var_id_lista_livro INT, var_id_livro INT, var_status INT)
		BEGIN
						
			UPDATE tbl_lista_livros SET status = 2 
			WHERE id_lista_livros = var_id_lista_livro 
			AND livro_id = var_id_livro;

		END ;
|
DELIMITER ;
DELIMITER |
CREATE PROCEDURE sp_pesquisa_adm_livro (IN condicao VARCHAR(100))
	BEGIN

		SET @cond := CONCAT('%',condicao,'%');

		SELECT
			*
		FROM 
			tbl_livro livro JOIN
			tbl_autor JOIN
			tbl_categoria JOIN
			tbl_editora JOIN
			tbl_usuario JOIN
			tbl_lista_livros lista_livro
		ON 
			autor_id = id_autor AND
			categoria_id = id_categoria AND
			editora_id = id_editora AND
			usuario_id = id_usuario AND
			livro_id = id_livro
		WHERE
			lista_livro.livro_id = (SELECT id_livro FROM tbl_livro WHERE nome like @cond LIMIT 1);	
	END;
|
DELIMITER ;
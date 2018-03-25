DELIMITER |
CREATE TRIGGER trg_cria_livros_trocados AFTER INSERT ON tbl_livro
	FOR EACH ROW
	BEGIN
		
		INSERT INTO tbl_livros_trocados VALUES (NULL,0,NEW.id_livro);
		
	END;
|
DEMILITER ;

DELIMITER |
CREATE TRIGGER trg_altera_livros_trocados AFTER INSERT ON tbl_cambio
	FOR EACH ROW
	BEGIN
		
		UPDATE tbl_livros_trocados SET quantidade = (quantidade + 1);
		
	END;
|
DEMILITER ;
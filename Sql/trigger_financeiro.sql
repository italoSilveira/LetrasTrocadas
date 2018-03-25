DELIMITER |
CREATE TRIGGER trg_insert_solicitacao AFTER INSERT ON tbl_solicitacao_troca
	FOR EACH ROW
	BEGIN
		
		UPDATE tbl_usuario SET creditos = (creditos - (SELECT creditos FROM tbl_lista_livros WHERE id_lista_livros = NEW.lista_id)) WHERE id_usuario = NEW.usuario_solicitador;
		UPDATE tbl_lista_livros SET status = 2 WHERE id_lista_livros = NEW.lista_id;
		INSERT INTO tbl_notificacoes VALUES(NULL,3,'Você recebeu uma nova solicitação de troca! Confira!',NEW.usuario_dono_lista,NOW(),'false');
		
	END;
|
DELIMITER ;

/* DROP TRIGGER trg_insert_solicitacao; */
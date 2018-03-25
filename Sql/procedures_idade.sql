

DELIMITER |

	CREATE PROCEDURE calc_idade (IN id INT)
		BEGIN
			SET @data_nasc := (SELECT data_nasc FROM tbl_usuario WHERE id_usuario = id);
			SET @idade := (SELECT DATE_FORMAT( NOW( ) , '%Y' ) - DATE_FORMAT( @data_nasc, '%Y' ) - 
            ( DATE_FORMAT( NOW( ) , '00-%m-%d' ) < DATE_FORMAT( @data_nasc, '00-%m-%d' ) ) 
            FROM tbl_usuario WHERE id_usuario = id);
			
			UPDATE tbl_usuario SET idade = @idade WHERE id_usuario = id;
		END ;
| 
DELIMITER ;



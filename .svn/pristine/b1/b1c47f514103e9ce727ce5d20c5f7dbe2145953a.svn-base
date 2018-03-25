SELECT livro.nome AS NomeLivro, imagem_livros AS imagem_livro, 
autor.nome AS AutorNome, 
editora.nome AS EditoraNome, usuario.nome AS UsuarioNome, 
ft_livro.primeira_foto AS PrimeiraFoto,
ft_livro.segunda_foto AS SegundaFoto, 
ft_livro.terceira_foto AS TerceiraFoto
FROM tbl_livro livro JOIN tbl_autor autor JOIN tbl_editora editora
JOIN tbl_usuario usuario JOIN tbl_lista_livros lista
JOIN tbl_fotos_livros ft_livro
ON livro.editora_id = id_editora
AND livro.autor_id = id_autor
AND lista.livro_id = id_livro
AND lista.usuario_id = id_usuario
AND ft_livro.lista_livro_id = id_lista_livros
WHERE livro.nome LIKE '%%' OR
autor.nome LIKE '%%' OR
usuario.nome LIKE '%%' OR
editora.nome LIKE '%%'
ORDER BY livro.nome;

SELECT lista.id_lista_livros,
livro.nome AS NomeLivro, 
autor.nome AS NomeAutor, 
editora.nome AS NomeEditora,
categoria.nome AS NomeCategoria,
primeira_foto,
segunda_foto,
terceira_foto,
usuario.nome AS NomeUsuario
FROM tbl_lista_livros lista
LEFT JOIN tbl_livro livro
ON lista.livro_id = id_livro
LEFT JOIN tbl_fotos_livros
ON lista_livro_id = id_lista_livros
LEFT JOIN tbl_usuario usuario
ON usuario_id = id_usuario
LEFT JOIN tbl_editora editora 
ON editora_id = id_editora
LEFT JOIN tbl_autor autor 
ON autor_id = id_autor
LEFT JOIN tbl_categoria categoria
ON categoria_id = id_categoria
WHERE livro.nome LIKE '%%'
OR autor.nome LIKE '%%'
OR editora.nome LIKE '%%'
OR usuario.nome LIKE '%%'
GROUP BY livro.nome ASC;

/* Para pegar a quantidade de usuários */

SELECT COUNT(id_usuario) AS Numero_Usuarios FROM tbl_usuario;

/* Para pegar a quantidade de usuário cadastrados recentemente */

SELECT COUNT(id_usuario) AS Numero_Usuarios_Cadastrados_Recentemente
FROM tbl_usuario WHERE data_criacao = DATE(NOW());

SELECT nome, email, idade, uf, cidade, data_criacao FROM tbl_usuario
WHERE DATE_FORMAT(data_criacao, '%m-%d') <= DATE_FORMAT(NOW(),'%m-%d') 
ORDER BY data_criacao ASC;

/* Livro mais trocados */

SELECT nome, quantidade 
FROM tbl_livro JOIN tbl_livros_trocados ON livro_id = id_livro ORDER BY quantidade DESC;

SELECT nome, quantidade 
FROM tbl_livro JOIN tbl_livros_trocados
ON livro_id = id_livro 
ORDER BY quantidade ASC;

/* Gêneros favoritos */ 

SELECT genero_favorito AS Nome_Genero, COUNT(*) AS NumeroDePessoasQueGostam
FROM tbl_usuario 
GROUP BY genero_favorito;

/* Autores favoritos */

SELECT autor.nome, COUNT(*) AS NumLivrosTrocados
FROM tbl_autor autor JOIN tbl_livros_trocados 
JOIN tbl_livro
ON livro_id = id_livro
AND autor_id = id_autor
GROUP BY AUTOR.NOME
ORDER BY COUNT(livro_id) DESC

/* Editoras favoritas */

SELECT editora.nome, COUNT(*) AS NumeroLivrosEditores
FROM tbl_editora editora  JOIN tbl_livros_trocados
JOIN tbl_livro 
ON livro_id = id_livro
AND editora_id = id_editora
GROUP BY editora.nome
ORDER BY COUNT(livro_id) DESC;

/* Denúncias pendentes */

SELECT usuario.nome, status, usuario.email, den.motivo, den.status, 
den.id_denuncias, COUNT(*) as Numero_Denuncias
FROM tbl_usuario usuario JOIN tbl_denuncias den
ON usuario_denunciado_id = id_usuario
WHERE 1=1 GROUP BY id_denuncias;

SELECT usu.nome, den.status, usu.email, motivo_id, outro_motivo,
motivo, penalidade,data
FROM tbl_usuario usu JOIN tbl_denuncias den
ON usuario_denunciado_id = id_usuario
JOIN tbl_motivos 
ON motivo_id = id_motivo
WHERE 1=1 GROUP BY id_denuncias ORDER BY data DESC;

/* Numero de denuncias por usuário */

SELECT nome,email,den.status, COUNT(*) as Numero_Denuncias 
FROM tbl_usuario JOIN tbl_denuncias den
ON usuario_denunciado_id = id_usuario
GROUP BY id_usuario
ORDER BY COUNT(*) DESC;

/* Motivos de denuncia mais frequentes */

SELECT motivo, COUNT(*) AS Quantidade
FROM tbl_denuncias
GROUP BY motivo
ORDER BY COUNT(*) DESC;

/* Usuários mais bem avaliados */ 

SELECT email,nome, avaliacoes_positivas
FROM tbl_usuario 
ORDER BY avaliacoes_positivas DESC
GROUP BY id_usuario  ;

/* Usuários mais mal avaliados */ 

SELECT email,nome, avaliacoes_negativas
FROM tbl_usuario 
ORDER BY avaliacoes_negativas DESC
GROUP BY id_usuario ;

/* Tipos de gêneros mais trocados */

SELECT cat.nome, livro.nome
FROM tbl_categoria cat JOIN tbl_livro livro
ON categoria_id = id_categoria
GROUP BY livro.nome;

SELECT cat.nome, COUNT(*) AS num_livros_trocados
FROM tbl_categoria cat JOIN tbl_livro 
ON categoria_id = id_categoria 
JOIN tbl_livros_trocados
ON livro_id = id_livro
GROUP BY id_categoria
ORDER BY num_livros_trocados DESC;

/* Número de livros disponibilizados no site por editora */ 

SELECT editora.nome, COUNT(*)
FROM tbl_editora editora JOIN tbl_livro
ON editora_id = id_editora
JOIN tbl_lista_livros
ON livro_id = id_livro
GROUP BY editora.nome
ORDER BY COUNT(*) DESC;

/* Número de livros do site por genero */ 

SELECT cat.nome, COUNT(*)
FROM tbl_categoria cat JOIN tbl_livro
ON categoria_id = id_categoria
JOIN tbl_lista_livros
ON livro_id = id_livro
GROUP BY cat.nome 
ORDER BY COUNT(*) DESC;

/* Número de livros do site por autor */ 

SELECT autor.nome, COUNT(*)
FROM tbl_autor autor JOIN tbl_livro
ON autor_id = id_autor
JOIN tbl_lista_livros
ON livro_id = id_livro
GROUP BY autor.nome 
ORDER BY COUNT(*) DESC;

/* Usuários que mais trocam livros */ 


/* Quantidade de livros trocados por mês */ 

/* Perfil do usuário */

SELECT id_usuario,nome,email,foto,idade,
avaliacoes_negativas,avaliacoes_positivas,
uf,cidade,genero_favorito
FROM tbl_usuario
WHERE id_usuario = ;

SELECT imagem_livros,liv.nome,id_lista_livros
FROM tbl_usuario usu JOIN tbl_livro liv 
JOIN tbl_lista_livros list_liv 
ON list_liv.livro_id = id_livro 
AND list_liv.usuario_id = id_usuario
WHERE id_usuario = 1 GROUP BY id_lista_livros;

SELECT imagem_livros,liv.nome,id_lista_desejo
FROM tbl_usuario usu JOIN tbl_livro liv
JOIN tbl_lista_desejo list_des
ON list_des.livro_id = id_livro
AND list_des.usuario_id = id_usuario
WHERE id_usuario = 1 GROUP BY id_lista_desejo;

SELECT imagem_livros,liv.nome,id_leu
FROM tbl_usuario usu JOIN tbl_livro liv
JOIN tbl_leu leu
ON leu.livro_id = id_livro
AND leu.usuario_id = id_usuario
WHERE id_usuario = 1 GROUP BY id_leu;

SELECT imagem_livros,liv.nome,id_lendo
FROM tbl_usuario usu JOIN tbl_livro liv
JOIN tbl_lendo lendo
ON lendo.livro_id = id_livro
AND lendo.usuario_id = id_usuario
WHERE id_usuario = 1 GROUP BY id_lendo;

SELECT tipo,id_livro,imagem_livros 
FROM tbl_marcacao JOIN tbl_usuario
ON usuario_id = id_usuario
JOIN tbl_livro 
ON livro_id = id_livro
WHERE usuario_id = 1;


/* Ocorrências de denuncia anteriores */ 

SELECT id_usuario, id_denuncias, usu.nome, motivo_id, motivo, 
outro_motivo, data, avaliacoes_negativas, avaliacoes_positivas
FROM tbl_usuario usu JOIN tbl_denuncias
ON usuario_denunciado_id = id_usuario
JOIN tbl_motivos
ON motivo_id = id_motivo
WHERE usuario_denunciado_id = 1 
GROUP BY id_denuncias ORDER BY data;















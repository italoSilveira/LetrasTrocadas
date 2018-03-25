<?php
	session_start();
	if(isset($_GET['livro']))
	{
		$livro = $_GET['livro'];
		
		include("../views/classes/class_banco.php");
		include("../views/classes/class_pesquisar.php");
		
		$bd = new Banco();

		$campos = "id_marcacao,imagem_livros,id_livro,livro.nome AS Livro,autor.nome AS Autor,editora.nome As Editora, livro.sinopse As sinopse";
		$tabelas = "tbl_marcacao marcacao INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id AND id_livro = livro_id";
		$pesquisar_livro = new Pesquisar($tabelas,$campos,'tipo = 3 AND usuario_id = '.$_SESSION['id'].' AND livro_id = '.$livro);
		$resposta = $pesquisar_livro->pesquisar();

		$id_livro = array();
		$id = array();
		$nome = array();
		$imagem = array();
		$editora = array();
		$autor = array();
		$sinopse = array();
		
		while($pesquisa=mysql_fetch_assoc($resposta))
		{
			$id_livro[] = $pesquisa['id_livro'];
			$id[] = $pesquisa['id_marcacao'];
			$nome[] = $pesquisa['Livro'];
			$imagem[] = $pesquisa['imagem_livros'];
			$editora[] = $pesquisa['Editora'];
			$autor[] = $pesquisa['Autor'];
			$sinopse[] = $pesquisa['sinopse'];
		}

		$aspas = "'";

		$retorno = '
			<section class = "col-lg-4" style = "width: auto;">	
				<section class = "bs-component"> 
					<a href="?url=livro&livro='.$id_livro[0].'" class = "thumbnail">
						<img id = "imagem" src = "'.$imagem['0'].'" alt = "'.utf8_encode($nome[0]).'" height = "177px" width = "120px"/> 
					</a>
				</section>
			</section>
			<section class = "col-lg-4">
				<a href="?url=livro&livro='.$id_livro[0].'"> <h3> '.utf8_encode($nome[0]).' </h3> </a>				  
				<a> <h4> '.utf8_encode($autor[0]).' </h4></a>
				<a> <h5> '.utf8_encode($editora[0]).' </h5></a>
				<section class = "btn-group" id="botoes">
					<button id = "Resultado" value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Estou lendo</button>
					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					<ul id = "acoes" class="dropdown-menu">
						<li><a onClick="AcoesLivro('.$id_livro[0].','.$aspas.'Desmarcar'.$aspas.',Resultado,'.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
						<li><a onClick="AcoesLivro('.$id_livro[0].','.$aspas.'QueroLer'.$aspas.',Resultado,'.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
						<li><a onClick="AcoesLivro('.$id_livro[0].','.$aspas.'JaLi'.$aspas.',Resultado,'.$aspas.'Lendo'.$aspas.');">Já li</a></li>
					</ul>
				</section>
			</section>
			<section class = "col-lg-4" style = "width:48%;">
				<textarea class="form-control" rows="9" readonly>
					'.utf8_encode($sinopse[0]).'
				</textarea>
			</section> 
		';

		$caixa_dialogo = array('section' => $retorno);
				
		echo json_encode($caixa_dialogo);
	}

?>
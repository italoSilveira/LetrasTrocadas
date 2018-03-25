<?php
	session_start();
	if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		
		include('../views/classes/class_banco.php');
		include('../views/classes/class_pesquisar.php');
		include('../views/classes/class_editar_caracteres.php');
		
		$bd = new Banco();
		
		$campos = 'livro.*,categoria.nome As Categoria,autor.nome AS Autor,editora.nome As Editora';
		$tabelas = 'tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id';
		$pesquisar_livros = new Pesquisar($tabelas,$campos,"id_livro = $id ORDER BY livro.nome ASC");
		$resultado = $pesquisar_livros->pesquisar();
		
		$quantidade = mysql_num_rows($resultado);
		
		while($pesquisa=mysql_fetch_assoc($resultado))
		{
			$id = $pesquisa['id_livro'];
			$nome = $pesquisa['nome'];
			$imagem = $pesquisa['imagem_livros'];
			$editora = $pesquisa['Editora'];
			$autor = $pesquisa['Autor'];
			$sinopse = $pesquisa['sinopse'];
			$isbn = $pesquisa['isbn'];
			$querem_ler = $pesquisa['querem_ler'];
			$lido = $pesquisa['lido'];
			$lendo = $pesquisa['lendo'];
			$paginas = $pesquisa['numero_paginas'];
			$categoria = $pesquisa['Categoria'];
			 
		}
		
		$aspas = "'";
		if(!empty($_SESSION['nivel_acesso']))
		{
			$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo","livro_id =".$id." AND usuario_id=".$_SESSION['id']);
			$resultado_marcacao = $pesquisar_marcacões->pesquisar();
			$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
			
			if($array_marcacao['tipo'] == 1)
			{
				$botões = ' 
						<section class ="btn-group" id="Resultado'.$id.'">
							<button value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$id.','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$id.','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
								<li><a onClick="AcoesLivro('.$id.','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
							</ul>
						</section>';
			}
			else if($array_marcacao['tipo'] == 2)
			{
				$botões = ' 
					<section class ="btn-group" id="Resultado'.$id.'">
						<button value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-sm">Já Li</button>
						<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
						<ul id = "acoes" class="dropdown-menu">
							<li><a onClick="AcoesLivro('.$id.','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
							<li><a onClick="AcoesLivro('.$id.','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
							<li><a onClick="AcoesLivro('.$id.','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'JaLi'.$aspas.');">Quero Ler</a></li>
						</ul>
					</section>';
			}
			else if($array_marcacao['tipo'] == 3)
			{
				$botões = ' 
					<section class ="btn-group" id="Resultado'.$id.'">
						<button value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Estou lendo</button>
						<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
						<ul id = "acoes" class="dropdown-menu">
							<li><a onClick="AcoesLivro('.$id.','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
							<li><a onClick="AcoesLivro('.$id.','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
							<li><a onClick="AcoesLivro('.$id.','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
						</ul>
					</section>';
			}
			else
			{
				$botões = '
						<section class ="btn-group" id="Resultado'.$id.'">
							<button value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$id.','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.''.$aspas.');">Quero Ler</a></li>
								<li><a onClick="AcoesLivro('.$id.','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.''.$aspas.');">Já li</a></li>
								<li><a onClick="AcoesLivro('.$id.','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.''.$aspas.');">Estou lendo</a></li>
							</ul>
						</section>';
			}
		}
		else
		{
			$botões = "'";
		}
		
		$livro = $nome;
		
		$editar_livro = new EditarCaracteres($nome);
		$livro = $editar_livro->Url($nome);
		
		$retorno = '
				<section class="row">
					<section class = "col-md-3">	
						<section class = "bs-component" style="width:50%;">
							<img style="height:177px; width: 130px;" src = "'.$imagem.'" alt = "'.utf8_encode($nome).'"/> 
						</section>
					</section>
					<section class = "col-md-3">
							<a> <h3> '.utf8_encode($nome).'</h3> </a>				  
							<a> <h4> '.utf8_encode($autor).'</h4></a>
							<a> <h5> '.utf8_encode($editora).'</h5></a>
							<a href="?url=pesquisa&nome='.utf8_encode($livro).'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_pesquisar" value = "Pesquisar" /></a>
							'.$botões.'
					</section>
					<section class = "col-md-6">
						<textarea style="background-color:white;" class="form-control" rows="9" readonly>
							'.utf8_encode($sinopse).'
						</textarea>
					</section>
				</section>
				<br />
				<section class="row">
					<table class="table table-striped table-hover ">
						<thead>
							<tr>
								<th>Outros Dados:</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>ISBN:</td>
								<td>'.$isbn.'</td>
							</tr>
							<tr class="success">
								<td>Gênero:</td>
								<td>'.utf8_encode($categoria).'</td>
							</tr>
							<tr>
								<td>Nº de pessoas lendo:</td>
								<td>'.$lendo.'</td>
							</tr>
							<tr class="success">
								<td>Nº de pessoas querendo ler:</td>
								<td>'.$querem_ler.'</td>
							</tr>
							<tr>
								<td>Nº de pessoas que leram:</td>
								<td>'.$lido.'</td>
							</tr>
							<tr class="success">
								<td>Nº de páginas:</td>
								<td>'.$paginas.'</td>
							</tr>
						</tbody>
					</table> 
				</section>';
		
		echo json_encode(array("section" => $retorno));
	}

?>
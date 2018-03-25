<script type="text/javascript" src="ajax/ajax.js"></script>
<?php
	if($_SESSION['nivel_acesso'] == 1)
	{
		include("classes/class_pesquisar.php");
		include("classes/class_banco.php");
		include("classes/class_editar_caracteres.php");

		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();

		$limite = 6;
		$pagina = $_GET['pag'];

		if(!$pagina)
		{
			$pagina = 1;
		}

		$inicio = ($pagina * $limite) - $limite;
			
		//Pesquisa da lista de desejo do site
		$campos_lista = "id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
		$tabelas_lista = "tbl_lista_livros lista INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_livros_trocados livos_trocados ON id_editora = editora_id AND id_autor = autor_id AND id_livro = lista.livro_id AND id_livro = livos_trocados.livro_id";
		$condição_lista = "autor_id NOT IN (SELECT autor_id FROM tbl_autores_desapreciados WHERE usuario_id = ".$_SESSION['id'].")
		AND categoria_id NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = ".$_SESSION['id'].") 
		AND id_livro IN (SELECT DISTINCT livro_id FROM tbl_lista_livros WHERE usuario_id <> ".$_SESSION['id'].") 
		AND id_livro NOT IN (SELECT DISTINCT livro_id FROM tbl_marcacao where usuario_id = ".$_SESSION['id'].")
		AND lista.status = 1
		AND (autor_id IN (SELECT autor_id FROM tbl_autores_favoritos WHERE usuario_id = ".$_SESSION['id'].")
		OR categoria_id IN (SELECT categoria_id FROM tbl_generos_favoritos WHERE usuario_id = ".$_SESSION['id'].") OR 1=1) 
		ORDER BY livos_trocados.quantidade LIMIT $limite";

		$pesquisar = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
		$res = $pesquisar->pesquisar();
		
		//Pesquisa a quantidade de livros na lista de desejo no banco de dados
		$pesquisar_qt = new Pesquisar("tbl_lista_livros lista INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_livros_trocados livos_trocados ON id_editora = editora_id AND id_autor = autor_id AND id_livro = lista.livro_id AND id_livro = livos_trocados.livro_id",
		"COUNT(id_livro) As Quantidade",
		"autor_id NOT IN (SELECT autor_id FROM tbl_autores_desapreciados WHERE usuario_id = ".$_SESSION['id'].")
		AND categoria_id NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = ".$_SESSION['id'].") 
		AND id_livro IN (SELECT DISTINCT livro_id FROM tbl_lista_livros WHERE usuario_id <> ".$_SESSION['id'].")
		AND id_livro NOT IN (SELECT DISTINCT livro_id FROM tbl_marcacao where usuario_id = ".$_SESSION['id'].")
		AND (autor_id IN (SELECT autor_id FROM tbl_autores_favoritos WHERE usuario_id = ".$_SESSION['id'].")
		OR categoria_id IN (SELECT categoria_id FROM tbl_generos_favoritos WHERE usuario_id = ".$_SESSION['id'].") OR 1=1)");
		$resultado_qt = $pesquisar_qt->pesquisar();			

		$total_registros = mysql_num_rows($resultado_qt);
		$total_paginas = Ceil($total_registros / $limite);

		//paginação
		$total = 6;// total de páginas

		$max_links = 4;// número máximo de links da paginação: na verdade o total será cinco 4+1=5

		//$pagina = 3; // página corrente

		// calcula quantos links haverá à esquerda e à direita da página corrente
		// usa-se ceil() para assegurar que o número será inteirolinks_laterais

		//Só pra uma futura concatenação
		$aspas = "'";		
	}
	else
	{		
		//Redireciona pra página principal
		if($_SESSION['nivel_acesso'] == 2)
		{
			header("location: ?url=home_admin");
		}
		else
		{
			header("location: ?url=home_visitante");
		}
	}
?>

<article id = "body_pesquisa">
	<section class="panel panel-default" style="width: 80%; margin-left: 10%;">
		<section class="panel-heading">
			<h4>Nossas sugestões para você!</h4>
		</section>
		<section class="panel panel-body">
			<?php
				$num_registros = mysql_num_rows($resultado_qt);
				if ($num_registros != 0)
				{
					$ct=0;
					while($dados_pesq = mysql_fetch_assoc($res))
					{
						$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo","livro_id =".$dados_pesq['id_livro']." AND usuario_id=".$_SESSION['id']);
						$resultado_marcacao = $pesquisar_marcacões->pesquisar();
						$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
						
						if($array_marcacao['tipo'] == 1)
						{
							$botões = '
										<section class ="btn-group" id="Resultado'.$dados_pesq['id_livro'].'">
											<button value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-xs">Quero Ler</button>
											<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul id = "acoes" class="dropdown-menu">
												<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
												<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
												<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
											</ul>
										</section>';
						}
						else if($array_marcacao['tipo'] == 2)
						{
							$botões = ' 
								<section class ="btn-group" id="Resultado'.$dados_pesq['id_livro'].'">
									<button value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-xs">Já Li</button>
									<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
									<ul id = "acoes" class="dropdown-menu">
										<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
										<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
										<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Quero Ler</a></li>
									</ul>
								</section>';
						}
						else if($array_marcacao['tipo'] == 3)
						{
							$botões = ' 
								<section class ="btn-group" id="Resultado'.$dados_pesq['id_livro'].'">
									<button value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-xs">Estou lendo</button>
									<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
									<ul id = "acoes" class="dropdown-menu">
										<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
										<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
										<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
									</ul>
								</section>';
						}
						else
						{
							$botões = '
									<section class ="btn-group" id="Resultado'.$dados_pesq['id_livro'].'">
										<button value = "" name = "Eu" type="button" class="btn btn-primary btn-xs">Eu...</button>
										<button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
										<ul id = "acoes" class="dropdown-menu">
											<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Quero Ler</a></li>
											<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Já li</a></li>
											<li><a onClick="AcoesLivro('.$dados_pesq['id_livro'].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$dados_pesq['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Estou lendo</a></li>
										</ul>
									</section>';
						}
							
						$ct++;
						if(($ct == 1) OR ($ct == 3) OR ($ct == 5))
						{
							echo '<section class="row">';
						}
						$livro = $dados_pesq['Livro'];

						$editar_livro = new EditarCaracteres($dados_pesq['Livro']);
						$livro = $editar_livro->Url($livro);

						echo '<section class="col-md-6">
								<section class = "col-md-4">	
									<section class = "bs-component" style = "margin-left: 10%; maxheight: 177px; width: 120px;"> 
										<a href="?url=livro&livro='.$dados_pesq['id_livro'].'" class = "thumbnail">
											<img src = "'.$dados_pesq['imagem_livros'].'" alt = ""/> 
										</a>	
									</section>
								</section>
								<section class="col-md-4"  style="max-height:1%;">
									<section>
										<center>
											<a href="?url=livro&livro='.$dados_pesq['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($dados_pesq['Livro']).'</h3></a>				  
											<a href="?url=livros_autores&autor='.utf8_encode($dados_pesq['Autor']).'" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($dados_pesq['Autor']).' </h4></a>
											<a href="?url=livros_editora&editora='.utf8_encode($dados_pesq['Editora']).'" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($dados_pesq['Editora']).' </h5></a>
										</center>
									</section>
								</section>';
						
							echo '<section class="col-md-8">
									<section>
										<section class ="btn-group">
											<a href="?url=pesquisa&nome='.$livro.'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_pesquisar" value = "Pesquisar" /></a>
											<a href="?url=passo-a-passo-dados-usuario&cod='.$dados_pesq['id_livro'].'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>
											'.$botões.'
										</section>
									</section>
								</section>
							</section>';

						if(($ct == 2) OR ($ct == 4) OR ($ct == 6))
						{
							echo '</section><br>';
						}
					}
				}
				else 
				{
					echo 'Nenhum resultado foi encontrado';
				}
								
			?>
		</section>
		<?php
			echo '<ul class="pagination" style = "margin-left:40%;">
					<li class="disabled"><a>«</a></li>';

			for($i=1; $i <= $total_paginas; $i++)
			{
				if($pagina == $i)
				{
					echo '<li class="active"><a>'.$i.'</a></li>';
				}
				else
				{
					if ($i >= 1 && $i <= $total)
					{
						echo '						
							  <li><a href="?url=pesquisa&pag='.$i.'&nome='.$conteudo_text.'">'.$i.'</a></li>
						';
					}
				}
				
			}

			echo ' <li class="disabled"><a>»</a></li>
				</ul>';
		?>
	</section>
	<section class="modal" id="myModal">
	</section>
</article>
<?php
	
	if($_SESSION['nivel_acesso'] == 2)
	{

		include("classes/class_pesquisar.php");
		include("classes/class_banco.php");
		
		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();
		$filtro = $_POST['Filtro'];

		$pesquisa_adm =  $_POST['pesquisa_adm'];
		if(!$pesquisa_adm)
		{
			$pesquisa_adm = $_GET['nome'];
		}

		$pagina = $_GET['pag'];

		if(!$pagina)
		{
			$pagina = 1;
		}
		
		switch ($filtro) 
		{
			case 'Usuário':

				$limite = 6;
				$inicio = ($pagina * $limite) - $limite;

				$pesquisa_usuário = new Pesquisar('tbl_usuario','id_usuario,nome,foto,uf,cidade,avaliacoes_negativas,avaliacoes_positivas',"nome like '%$pesquisa_adm%' ORDER BY nome LIMIT $inicio,$limite");
				$resposta = $pesquisa_usuário->pesquisar(); 

				$quantidade = new Pesquisar('tbl_usuario','COUNT(id_usuario)',"nome like '%$pesquisa_adm%'");
				$resultado_quantidade = $quantidade->pesquisar();
				$total_registros = mysql_num_rows($resultado_quantidade);
				$total_paginas = Ceil($total_registros / $limite);
				//paginação
				$total = 6;// total de páginas	

				break;
			case 'Livro':
				$limite = 6;
				$inicio = ($pagina * $limite) - $limite;

				$pesquisa_livro = new Pesquisar('tbl_livro livro INNER JOIN tbl_autor autor INNER JOIN tbl_editora editora ON id_autor = autor_id AND id_editora = editora_id ','id_livro,livro.nome as livro,autor.nome as autor,editora.nome as editora,imagem_livros,edicao,isbn',"livro.nome like '%$pesquisa_adm%' ORDER BY livro.nome LIMIT $inicio,$limite");
				$resposta = $pesquisa_livro->pesquisar();

				$quantidade = new Pesquisar('tbl_livro livro INNER JOIN tbl_autor autor INNER JOIN tbl_editora editora ON id_autor = autor_id AND id_editora = editora_id ','COUNT(id_livro)',"livro.nome like '%$pesquisa_adm%'");
				$resultado_quantidade = $quantidade->pesquisar();
				$total_registros = mysql_num_rows($resultado_quantidade);
				$total_paginas = Ceil($total_registros / $limite);
				//paginação
				$total = 6;// total de páginas

				break;
			case 'Autor':
				$limite = 18;
				$inicio = ($pagina * $limite) - $limite;

				$pesquisa_autor = new Pesquisar('tbl_autor','id_autor,nome',"nome like '%$pesquisa_adm%' ORDER BY nome LIMIT $inicio,$limite");
				$resposta = $pesquisa_autor->pesquisar();

				$quantidade = new Pesquisar('tbl_autor','COUNT(id_autor)',"nome like '%$pesquisa_adm%'");
				$resultado_quantidade = $quantidade->pesquisar();
				$total_registros = mysql_num_rows($resultado_quantidade);
				$total_paginas = Ceil($total_registros / $limite);
				//paginação
				$total = 6;// total de páginas

				break;
			case 'Editora':
				$limite = 18;
				$inicio = ($pagina * $limite) - $limite;

				$pesquisa_editora = new Pesquisar('tbl_editora','id_editora,nome',"nome like '%$pesquisa_adm%' ORDER BY nome LIMIT $inicio,$limite");
				$resposta = $pesquisa_editora->pesquisar();

				$quantidade = new Pesquisar('tbl_editora','COUNT(id_editora)',"nome like '%$pesquisa_adm%'");
				$resultado_quantidade = $quantidade->pesquisar();
				$total_registros = mysql_num_rows($resultado_quantidade);
				$total_paginas = Ceil($total_registros / $limite);
				//paginação
				$total = 6;// total de páginas

				break;
			case 'Gênero':
				$limite = 18;
				$inicio = ($pagina * $limite) - $limite;

				$pesquisa_editora = new Pesquisar('tbl_categoria','id_categoria,nome',"nome like '%$pesquisa_adm%' ORDER BY nome LIMIT $inicio,$limite");
				$resposta = $pesquisa_editora->pesquisar();

				$quantidade = new Pesquisar('tbl_categoria','COUNT(id_categoria)',"nome like '%$pesquisa_adm%'");
				$resultado_quantidade = $quantidade->pesquisar();
				$total_registros = mysql_num_rows($resultado_quantidade);
				$total_paginas = Ceil($total_registros / $limite);
				//paginação
				$total = 6;// total de páginas

				break;
		}
		
		$aspas = "'";
?>
<article id = "body_pesquisa">
	<section class="panel panel-default" style="width: 80%; margin-left: 10%;">
		<section class="panel-heading">
			<h4>Resultados</h4>
		</section>
		<section class="panel panel-body">
			<?php
				$num_registros = mysql_num_rows($resposta);
				if ($num_registros != 0)
				{
					$ct=0;
					switch ($filtro) 
					{
						case 'Usuário':
							while($pesquisa = mysql_fetch_assoc($resposta))
							{
								$ct++;
								if(($ct == 1) OR ($ct == 3) OR ($ct == 5))
								{
									echo '<section class="row">';
								}
								echo '<section class="col-md-6">
										<section class="col-md-4">	
											<section class = "bs-component" style = "margin-left: 10%; maxheight: 177px; width: 120px;"> 
												<a href="#" class = "thumbnail">
													<img src = "'.$pesquisa['foto'].'" alt = ""/> 
												</a>	
											</section>
										</section>
										<section class="col-md-6">
											<section>
													<a href="#"> <h4> '.utf8_encode($pesquisa['nome']).'</h4></a>				  
													<a href="#"> <h5> '.utf8_encode($pesquisa['cidade']).' </h5></a>
													<a href="#"> <h5> '.$pesquisa['uf'].' </h5></a>
													<section id = "avaliações" style = "position:relative;">
														<label> Avaliações: </label>
														<span class= "glyphicon glyphicon-thumbs-up"></span> <span class = "badge"> '.$pesquisa['avaliacoes_positivas'].' </span> 
														<span class= "glyphicon glyphicon-thumbs-down"> </span> <span class = "badge"> '.$pesquisa['avaliacoes_negativas'].' </span>
													</section>
												
											</section>
										</section>
										<section class="col-md-6">
											<section style="margin-top: 10%;">
												<section class = "btn-group">
													<a href="?url=passo-a-passo-dados-usuario&cod='.$pesquisa['id_usuario'].'"><input type = "button" class="btn btn-primary btn-xs" name = "historico" value = "Hitórico do usuário" /></a>
												</section>
											</section>
										</section>
									</section>';
								if(($ct == 2) OR ($ct == 4) OR ($ct == 6))
								{
									echo '</section><br>';
								}
							}
							break;
						case 'Livro':
							while($pesquisa = mysql_fetch_assoc($resposta))
							{
								$ct++;
								if(($ct == 1) OR ($ct == 3) OR ($ct == 5))
								{
									echo '<section class="row">';
								}
								echo '<section class="col-md-6">
										<section class = "col-md-4">	
											<section class = "bs-component" style = "margin-left: 30%; max-height: 177px; width:120px;"> 
												<a href="?url=livro&livro='.$pesquisa['id_livro'].'" class = "thumbnail">
													<img src = "'.$pesquisa['imagem_livros'].'" alt = ""/> 
												</a>	
											</section>
										</section>
										<section class="col-md-6" style="margin-bottom:5%;">
											<section>
												<center>
													<a href="?url=livro&livro='.$pesquisa['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($pesquisa['livro']).'</h3></a>				  
													<a href="?url=livros_autores" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($pesquisa['autor']).' </h4></a>
													<a href="?url=livros_editora" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($pesquisa['editora']).' </h5></a>
													<form action = "?url=alterar_livro_adm&cod='.$pesquisa['id_livro'].'" method = "post">
														<input type = "submit" class="btn btn-primary btn-xs" name = "alterar_livro" value = "Alterar Livro" />
													</form>
												</center>
											</section>
										</section>
									</section>';
									if(($ct == 2) OR ($ct == 4) OR ($ct == 6))
									{
										echo '</section><br>';
									}
							}
							break;
						case 'Autor':
							while($pesquisa = mysql_fetch_assoc($resposta))
							{
								$ct++;
								if(($ct == 1) OR ($ct == 7) OR ($ct == 13))
								{
									echo '<section class="row">';
								}
								echo '<section class="col-md-2">
										<section class="col-md-14">
											<section>
												<center>
													<a> <h3> '.utf8_encode($pesquisa['nome']).'</h3></a>
													<form action = "?url=alterar_autor&cod='.$pesquisa['id_autor'].'" method = "post">
														<input type = "submit" class="btn btn-primary btn-xs" name = "alterar_autor" value = "Alterar Autor" />													</form>
												</center>
											</section>
										</section>
									</section>';
								if(($ct == 6) OR ($ct == 12) OR ($ct == 18))
								{
									echo '</section><br>';
								}
							}
							break;
						case 'Editora':
							while($pesquisa = mysql_fetch_assoc($resposta))
							{
								$ct++;
								if(($ct == 1) OR ($ct == 7) OR ($ct == 13))
								{
									echo '<section class="row">';
								}
								echo '<section class="col-md-2">
										<section class="col-md-14">
											<section>
												<center>
													<a> <h3> '.utf8_encode($pesquisa['nome']).'</h3></a>
													<form action = "?url=alterar_editora&cod='.$pesquisa['id_editora'].'" method = "post">
														<input type = "submit" class="btn btn-primary btn-xs" name = "alterar_editora" value = "Alterar editora" />
													</form>
												</center>
											</section>
										</section>
									</section>';
									if(($ct == 6) OR ($ct == 12) OR ($ct == 18))
									{
										echo '</section><br>';
									}
							}
							break;
						case 'Gênero':
							while($pesquisa = mysql_fetch_assoc($resposta))
							{
								$ct++;
								if(($ct == 1) OR ($ct == 7) OR ($ct == 13))
								{
									echo '<section class="row">';
								}
								echo '<section class="col-md-2">
										<section class="col-md-14">
											<section>
												<center>
													<a> <h3> '.utf8_encode($pesquisa['nome']).'</h3></a>
													<form action = "?url=alterar_genero&cod='.$pesquisa['id_categoria'].'" method = "post">
														<input type = "submit" class="btn btn-primary btn-xs" name = "alterar_categoria" value = "Alterar categoria" />
													</form>
												</center>
											</section>
										</section>
									</section>';
									if(($ct == 6) OR ($ct == 12) OR ($ct == 18))
									{
										echo '</section><br>';
									}
							}
							break;				
					}
				}
				else 
				{
					echo 'Nenhum resultado foi encontrado';
				}
								
			?>
			<br>
			</section>
				<?php
					for($i=1; $i <= $total_paginas; $i++)
					{
						echo '<ul class="pagination" style = "margin-left:40%;">
								<li class="disabled"><a>«</a></li>';
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
						echo ' <li class="disabled"><a>»</a></li>
						</ul>';
					}
				?>
		</section>
	</section>
</article>
<?php

	}
	else
	{
		if($_SESSION['nivel_acesso'] == 1)
		{
			header('Location:?url=index_usuario');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}

?>
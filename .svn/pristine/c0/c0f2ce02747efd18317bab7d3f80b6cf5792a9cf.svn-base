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

		$editar_pagina = new EditarCaracteres($pagina);
		$pagina = $editar_pagina->sanitizeNumber($_GET['pag']);

		if(!$pagina)
		{
			$pagina = 1;
		}

		$inicio = ($pagina * $limite) - $limite;

		$livro = "";

		if(isset($_POST['pesquisar_acervo']))
		{
			$livro = $_POST['pesquisa'];

			$editar_livro = new EditarCaracteres($livro);
			$livro = $editar_livro->sanitizeStringNome($_POST['pesquisa']);
		}
			
		//Pesquisa da lista de desejo do site
		$campos_lista = "COUNT(id_livro) as Qt,id_livro,imagem_livros,livro.nome AS Livro";
		$tabelas_lista = "tbl_livro livro INNER JOIN tbl_lista_livros lista INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
		$condição_lista = "livro.nome like '%$livro%'
		GROUP BY Livro
		ORDER BY Livro LIMIT $inicio,$limite"; 

		$pesquisar = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
		$res = $pesquisar->pesquisar();

		//Pesquisa a quantidade de livros na lista de desejo no banco de dados
		$pesquisar_qt = new Pesquisar("tbl_livro livro INNER JOIN tbl_lista_livros lista INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id",
		"id_lista_livros",
		"livro.nome like '%$livro%'");
		$resultado_qt = $pesquisar_qt->pesquisar();			

		$total_registros = mysql_num_rows($resultado_qt);
		$total_paginas = Ceil($total_registros / $limite);

		//paginação
		$total = 6;// total de páginas

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
	<section class="panel panel-default" style="width: 84%; margin-left: 8%;">
		<section class="panel-heading">
			<a><h3 class="panel-title">Nosso acervo</h3></a>
		</section>		
		<section class="panel panel-body">
			<section class="row">
				<form action="" method="post">
					<section class="col-md-offset-1 col-md-4">
						<section class="input-group">
							<input type="text" name = "pesquisa" value="<?php echo $livro;?>" class="form-control" placeholder="Procurar">
							<span class="input-group-btn">
								<button type="submit" name = "pesquisar_acervo" class="btn btn-default">
									<span class="glyphicon glyphicon-search"></span>
								</button>
							</span>
						</section>
					</section>
				</form>
			</section><br />
			<section class="row">
			<?php
				$num_registros = mysql_num_rows($resultado_qt);
				if ($num_registros != 0)
				{
					$ct=0;
					while($dados_pesq = mysql_fetch_assoc($res))
					{						
						$ct++;
						if(($ct == 1) OR ($ct == 3) OR ($ct == 5))
						{
							echo '<section class="row">';
						}

						$livro_url = new EditarCaracteres($dados_pesq['Livro']);
						$url = $livro_url->Url($dados_pesq['Livro']);

						echo '<section class="col-md-6">
								<section class = "col-md-4">	
									<section class = "bs-component" style = "margin-left: 10%;"> 
										<a href="?url=livro&livro='.$dados_pesq['id_livro'].'" class = "thumbnail">
											<img src = "'.$dados_pesq['imagem_livros'].'" alt = "'.$dados_pesq['Livro'].'"  height= 177px; width= 120px; /> 
										</a>	
									</section>
								</section>
								<section class="col-md-4"  style="max-height:1%;">
									<section>
										<center>
											<a href="?url=livro&livro='.$dados_pesq['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($dados_pesq['Livro']).'</h3></a>				  
											<a href="" title = "Quantidade deste livro disponível no nosso site! "> <h4> Quantidade: '.utf8_encode($dados_pesq['Qt']).' </h4></a>
										</center>
									</section>
								</section>';
						
							echo '<section class="col-md-8">
									<section>
										<section class = "btn-group">
												<a href="?url=pesquisa&nome='.utf8_encode($url).'"><input style="margin-left:50%;" type = "button" class="btn btn-primary btn-xs" name = "botao_pesquisar" value = "Pesquisar" /></a>
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
					echo '
						<br>
						<center>
							<section class="alert alert-warning col-sm-offset-3 col-sm-6">
								<h1>Que pena!</h1>
								<p>Nenhum livro foi encontrado :(
							</section>
						</center>
						';
				}
								
			?>
			<br>
			</section>
				<?php
					echo '<center>
							<ul class="pagination">
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

					echo ' 		<li class="disabled"><a>»</a></li>
							</ul>
						</center>';
				?>
		</section>
	</section>
</article>
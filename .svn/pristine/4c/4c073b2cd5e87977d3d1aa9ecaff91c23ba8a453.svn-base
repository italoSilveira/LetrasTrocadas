<script type="text/javascript">
	function CriaRequest()
	{ 
		try
		{
			request = new XMLHttpRequest(); 
		}
		catch (IEAtual)
		{ 
			try
			{ 
				request = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(IEAntigo)
			{
				try
				{ 
					request = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(falha)
				{ 
					request = false; 
				} 
			} 
		} 
		if (!request)
		alert("Seu Navegador não suporta Ajax!");
		else return request;
	}

	function AcoesLivro(id,acao,section,tabela)
	{
		var xmlreq = CriaRequest();
		// Iniciar uma requisição
		xmlreq.open("GET", "ajax/acoes_livros.php?acao="+acao+"&id="+id+"&tabela="+tabela, true); 
		// Atribui uma função para ser executada sempre que houver uma mudança de ado
		xmlreq.onreadystatechange = function()
		{
			// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4) 
			if (xmlreq.readyState == 4)
			{ 
				// Verifica se o arquivo foi encontrado com sucesso
				if (xmlreq.status == 200)
				{ 
					var texto = xmlreq.responseText;
					document.getElementById(section).innerHTML = texto;
				}
				else
				{ 
					var texto = "Erro: " + xmlreq.statusText;
					$(section).text(texto).attr({
						title:texto
					});
				}
			} 
		};
		xmlreq.send(null);
	}
</script>
<?php
	if($_SESSION['nivel_acesso'] == 1)
	{ 
		if($_SESSION['status'] == 4)
		{
			include("classes/class_pesquisar.php");
			include("classes/class_banco.php");
			include("classes/class_editar_caracteres.php");

			if((isset($_POST['pesquisar_livro'])) OR (!empty($_GET['pagina'])))
			{
				//Instancia e faz conexão com o banco de dados
				$banco = new Banco();
				
				if(empty($_GET['nome']))
				{
					$nome = $_POST['pesquisa'];
					
					$editar_nome = new EditarCaracteres($nome);
					$nome = $editar_nome->sanitizeStringNome($_POST['pesquisa']);
				}
				else
				{
					$nome = $_GET['nome'];
					
					$editar_nome = new EditarCaracteres($nome);
					$nome = $editar_nome->sanitizeStringNome($_GET['nome']);
				}
				$limite = 8;
				$pagina = $_GET['pagina'];

				if(!$pagina)
				{
					$pagina = 1;
				}

				$inicio = ($pagina * $limite) - $limite;
				
				$campos = "id_livro,imagem_livros,livro.nome AS NomeLivro,edicao,autor.nome AS NomeAutor,editora.nome As NomeEditora, categoria.nome As NomeCategoria ";
				$tabelas = "tbl_livro livro JOIN tbl_editora editora JOIN tbl_autor autor JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id";
				$condicao = "livro.nome like '%$nome%' LIMIT $inicio,8";

				$pesquisa_dados = new Pesquisar($tabelas,$campos,$condicao);
				 
				$resultado_dados = $pesquisa_dados->pesquisar();
				
				$quantidade = new Pesquisar($tabelas,'id_livro',"livro.nome like '%$nome%'");
				  
				$resultado_quantidade = $quantidade->pesquisar();
				$total_registros = mysql_num_rows($resultado_quantidade);
				$total_paginas = Ceil($total_registros / $limite);
				
				//paginação
				$total = 6;// total de páginas

				$max_links = 4;// número máximo de links da paginação: na verdade o total será cinco 4+1=5

				//$pagina = 3; // página corrente

				// calcula quantos links haverá à esquerda e à direita da página corrente
				// usa-se ceil() para assegurar que o número será inteirolinks_laterais
				  
				
				$aspas = "'";
			}
?>
<article id  = "body_cadastra_livro_usu" style="width: 80%; margin-left: 10%;">
	<fieldset>
		<form  method="post" action="?url=passo-a-passo-pesquisa"  role="search "enctype="multipart/form-data">
			<legend>Pesquise o livro e clique em disponibilizar livro</legend>
			<section class="row">
				<section class="col-md-9">
					<section class="form-group">
						<input type="text" name = "pesquisa" class="form-control" placeholder="Procurar">
					</section>
				</section>
				<section class="col-md-offset-1">
					<button type="submit" name = "pesquisar_livro" class="btn btn-default">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</section>
			</section>
		</form>
		<section class="panel panel-body">
			<?php
				if(isset($_POST['pesquisar_livro']) OR !empty($_GET['pagina']))
				{
					$num_registros = mysql_num_rows($resultado_dados);
					if ($num_registros != 0)
					{
						$ct=0;
						while($dados_pesq = mysql_fetch_assoc($resultado_dados))
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
							echo '<section class="col-md-6">
									<section class = "col-md-4">	
										<section class = "bs-component" style = "margin-left: 10%; maxheight: 177px; width: 120px;"> 
											<a href="?url=livro&livro='.$dados_pesq['id_livro'].'" class = "thumbnail">
												<img src = "'.$dados_pesq['imagem_livros'].'" alt = ""/> 
											</a>	
										</section>
									</section>
									<section class="col-md-6">
										<section style="">
											<center>
												<a href="?url=livro&livro='.$dados_pesq['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($dados_pesq['NomeLivro']).'</h3></a>				  
												<a href="?url=livros_autores&autor='.utf8_encode($dados_pesq['NomeAutor']).'" title = "Clique para ver mais livros deste autor"><h4>'.utf8_encode($dados_pesq['NomeAutor']).' </h4></a>
												<a href="?url=livros_editora&editora='.utf8_encode($dados_pesq['NomeEditora']).'" title = "Clique para ver mais livros desta editora"><h5>'.utf8_encode($dados_pesq['NomeEditora']).'</h5></a>
												<a href="#" title = "Clique para ver mais livros desta editora"><h5>'.utf8_encode($dados_pesq['NomeCategoria']).'</h5></a>
											</center>
										</section>
									</section>';
							if(!empty($_SESSION['nivel_acesso']))
							{
								echo '<section class="col-md-10">
											<section class = "btn-group" style="left:45%;">
												<a href="?url=passo-a-passo-dados-usuario&cod='.$dados_pesq['id_livro'].'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>
												'.$botões.'
											</section>
									</section>
								</section>';
							}
							else
							{
								echo '</section>';
							}

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
							  <li><a href="?url=passo-a-passo-pesquisa&pagina='.$i.'&nome='.$nome.'">'.$i.'</a></li>
						';
					}
				}
				
			}

			echo ' <li class="disabled"><a>»</a></li>
				</ul>';
		?>
	</fieldset>
</article>
<?php

		}
		else
		{
			echo '<section class="alert alert-dismissable alert-info" style="width:40%;margin-left:30%";>
				<strong>Você precisa completar seu <a href="?url=alterar_dados_perfil">perfil</a> para disponibilizar um livo!</strong>
			</section>';
		}
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
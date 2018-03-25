<script type="text/javascript" src="ajax/ajax.js"></script>
<?php
	//Verifica se o usuário tem acesso à essa página
	if($_SESSION['nivel_acesso'] == 1)
	{
			include("classes/class_banco.php");
			include("classes/class_editar_caracteres.php");
			include("classes/class_pesquisar.php");
			
			$bd = new Banco();			

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
<article style="width: 84%; margin-left: 8%;">
	<section class="row">
		<section class="col-md-6">
			<section class="panel panel-default">
				<section class="panel-heading"><h4>Seus interesses:</h4></section>
				<section class="panel-body" id="pag_inicial_livros_desejados">
						<?php
							
							//Pesquisa da lista de desejo do site
							$campos_lista = "marcacao.id_marcacao As id_lista,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
							$tabelas_lista = "tbl_marcacao marcacao INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
							$condição_lista = "usuario_id = ".$_SESSION['id']." AND tipo = 1 ORDER BY marcacao.id_marcacao LIMIT 6";
							
							$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
							$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
							
							//Pesquisa a quantidade de livros na lista de desejo no banco de dados
							$pesquisar_quantidade_lista_desejo = new Pesquisar("tbl_marcacao ","COUNT(id_marcacao) As Quantidade","tipo = 1 AND usuario_id = ".$_SESSION['id']);
							$resultado_quantidade_lista_desejo = $pesquisar_quantidade_lista_desejo->pesquisar();			
							$array_quantidade_lista_desejo = mysql_fetch_assoc($resultado_quantidade_lista_desejo);
							$quantidade_lista_desejo = $array_quantidade_lista_desejo['Quantidade'];	
							
							//Exibindo na tela a resposta
							$id_ultima = array();
							$ct_desejo = 0;
							while($lista_desejo=mysql_fetch_assoc($resultado_lista_desejo))
							{
								$ct_desejo++;
								$livro = $lista_desejo['Livro'];

								$editar_livro = new EditarCaracteres($lista_desejo['Livro']);
								$livro = $editar_livro->Url($livro);

								$id_ultima[] = $lista_desejo['id_lista'];
								echo'	<section class="panel panel-default">
											<section class="panel panel-body">
												<section class="row">
													<section class = "col-md-4">	  
														<center>
															<section class = "bs-component" style = "maxheight: 177px; width:120px;">
																<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" class = "thumbnail">
																	<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
																</a>	
															</section>
														</center>
													</section>
													<section class="col-md-6">
														<center>
															<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
															<a href="?url=livros_autores&autor='.utf8_encode($lista_desejo['Autor']).'" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
															<a href="?url=livros_editora&editora='.utf8_encode($lista_desejo['Editora']).'" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
														</center>
													</section>
												</section>										
												<section class="row">
													<center>
														<section>
															<a href="?url=pesquisa&nome='.utf8_encode($livro).'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_pesquisar" value = "Pesquisar" /></a>
															<a href="?url=passo-a-passo-dados-usuario&cod='.$lista_desejo['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>													 
															<section class ="btn-group" id="Resultado'.$lista_desejo['id_livro'].'">
																<button value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
																<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
																<ul id = "acoes" class="dropdown-menu">
																	<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$lista_desejo['id_livro'].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
																	<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'JaLi'.$aspas.','.$aspas.''.$aspas.'Resultado'.$lista_desejo['id_livro'].''.$aspas.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
																	<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$lista_desejo['id_livro'].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
																</ul>
															</section>
														</section>
													</center>
												</section>
											</section>
										</section>';
							}
							
							//Se não tiver resposta para mostrar, faz uma pesquisa para dar sujestões ao usuário
							if($ct_desejo < 6)
							{
								
								$limite = 6 - $ct_desejo;
								
								//Pesquisa da lista de desejo do site
								$campos_lista = "id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora";
								$tabelas_lista = "tbl_lista_livros lista INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id";
								$condição_lista = "autor_id NOT IN (SELECT autor_id FROM tbl_autores_desapreciados WHERE usuario_id = ".$_SESSION['id'].")
								AND categoria_id NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = ".$_SESSION['id'].")
								AND id_livro IN (SELECT DISTINCT livro_id FROM tbl_lista_livros WHERE usuario_id <> ".$_SESSION['id'].") 
								AND id_livro NOT IN (SELECT DISTINCT livro_id FROM tbl_marcacao where usuario_id = ".$_SESSION['id'].")
								AND lista.status = 1
								AND (autor_id IN (SELECT autor_id FROM tbl_autores_favoritos WHERE usuario_id = ".$_SESSION['id'].")
								OR categoria_id IN (SELECT categoria_id FROM tbl_generos_favoritos WHERE usuario_id = ".$_SESSION['id'].") OR 1=1)";

								$pesquisar_lista_desejo = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
								$resultado_lista_desejo = $pesquisar_lista_desejo->pesquisar();
								
								$id_ultima = array();
								$ct_desejo = 0;

								echo '
									<fielset>
									<a href="?url=sugestoes" title="Clique para ver mais sugestões!"><legend>Sugestões do LetrasTrocadas para você!</legend></a>
								';
								while($lista_desejo=mysql_fetch_assoc($resultado_lista_desejo))
								{
	
									$botões = '
											<section class ="btn-group" id="Resultado'.$lista_desejo['id_livro'].'">
												<button value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$lista_desejo['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Quero Ler</a></li>
													<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$lista_desejo['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$lista_desejo['id_livro'].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$lista_desejo['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Estou lendo</a></li>
												</ul>
											</section>';
									
									$ct_desejo++;

									$livro = $lista_desejo['Livro'];

									$editar_livro = new EditarCaracteres($lista_desejo['Livro']);
									$livro = $editar_livro->Url($livro);

									$id_ultima[] = $lista_desejo['id_livro'];
									echo'	<section class="panel panel-default">
												<section class="panel panel-body">
													<section class="row">
														<section class = "col-md-4">
															<center>
																<section class = "bs-component" style = "max-height: 177px; width:120px;">
																	<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" class = "thumbnail">
																		<img src = "'.$lista_desejo['imagem_livros'].'" alt = "'.utf8_encode($lista_desejo['Livro']).'" /> 
																	</a>	
																</section>
															</center>
														</section>
														<section class="col-md-6">
															<center>
																<a href="?url=livro&livro='.$lista_desejo['id_livro'].'" title = "Clique para ver mais informações sobre o livro"> <h3> '.utf8_encode($lista_desejo['Livro']).'</h3></a>				  
																<a href="?url=livros_autores&autor='.utf8_encode($lista_desejo['Autor']).'" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
																<a href="?url=livros_editora&editora='.utf8_encode($lista_desejo['Editora']).'" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
															</center>
														</section>
													</section>
													<section class="row">
														<center>
															<section>
																<a href="?url=pesquisa&nome='.$livro.'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_pesquisar" value = "Pesquisar" /></a>
																<a href="?url=passo-a-passo-dados-usuario&cod='.$lista_desejo['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>													 
																'.$botões.'
															</section>
														</center>
													</section>
												</section>
											</section>';
								}
							}
						?>					
				</section>
				<ul class="pager">
					<li id = "li_antigo" class="previous disabled"><a id = "a_antigo" onClick = "" >← Antigo</a></li>
					<li id = "li_novo" class="<?php echo ($quantidade_lista_desejo >= 7) ? "next" : "next disabled"; ?>"><a id = "a_novo" onClick="NovaListaDesejo('<?php echo ($quantidade_lista_desejo >= 7) ? "$id_ultima[5]','$id_ultima[0]','1" : "None','None','1";?>');">Nova →</a></li>
				</ul>
			</section>
		</section>
		<section class="col-md-6">
			<section class="panel panel-default">
				<section class="panel-heading"><h4>Últimos livros disponibilizados:</h4></section>
				<section class="panel-body" id="pag_inicial_livros_ultimos_disponibilizados">
						<?php

							//Pesquisa dos ultimos livros disponibilizados do site
							$campos = "DISTINCT id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
							$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
							$condição = "tbl_lista_livros.status = 1 
							AND autor_id NOT IN (SELECT autor_id FROM tbl_autores_desapreciados WHERE usuario_id = ".$_SESSION['id'].")
							AND categoria_id NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = ".$_SESSION['id'].") 
							ORDER BY data_cadastro DESC LIMIT 6";
							$pesquisar_ultimos = new Pesquisar($tabelas,$campos,$condição);
							$resultado_ultimos = $pesquisar_ultimos->pesquisar();
							
							//Pesquisa a quantidade de livros no banco de dados
							$pesquisar_quantidade_ultimos = new Pesquisar("tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id",
							"COUNT(id_lista_livros) As Quantidade",
							"tbl_lista_livros.status = 1 
							AND autor_id NOT IN (SELECT autor_id FROM tbl_autores_desapreciados WHERE usuario_id = ".$_SESSION['id'].")
							AND categoria_id NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = ".$_SESSION['id'].")");
							$resultado_quantidade_ultimos = $pesquisar_quantidade_ultimos->pesquisar();			
							$array_quantidade_ultimos = mysql_fetch_assoc($resultado_quantidade_ultimos);
							$quantidade_ultimos = $array_quantidade_ultimos['Quantidade'];
							if($quantidade_ultimos < 50)
							{	
									echo '
										<section class="alert alert-dismissable alert-info">
											<button type="button" class="close" data-dismiss="alert">×</button>
											<strong>Nos ajude!</strong> Ainda temos poucos livros em nosso site, disponibilize um <a href="?url=passo-a-passo-pesquisa" class="alert-link">aqui</a> em um simples passo a passo.
										</section>';
							}
							$quantidade_pagina = 0;
							$id_ultima_ultimos = array();
							while($ultimos=mysql_fetch_assoc($resultado_ultimos))
							{
								$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo","livro_id =".$ultimos['id_livro']." AND usuario_id=".$_SESSION['id']);
								$resultado_marcacao = $pesquisar_marcacões->pesquisar();
								$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
								
								if($array_marcacao['tipo'] == 1)
								{
									$botões = ' 
											<section class ="btn-group" id="Resultado'.$ultimos['id_livro'].'">
												<button value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
												</ul>
											</section>';
								}
								else if($array_marcacao['tipo'] == 2)
								{
									$botões = ' 
										<section class ="btn-group" id="Resultado'.$ultimos['id_livro'].'">
											<button value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-sm">Já Li</button>
											<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul id = "acoes" class="dropdown-menu">
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Quero Ler</a></li>
											</ul>
										</section>';
								}
								else if($array_marcacao['tipo'] == 3)
								{
									$botões = ' 
										<section class ="btn-group" id="Resultado'.$ultimos['id_livro'].'">
											<button value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Estou lendo</button>
											<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
											<ul id = "acoes" class="dropdown-menu">
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
												<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
											</ul>
										</section>';
								}
								else
								{
									$botões = '
											<section class ="btn-group" id="Resultado'.$ultimos['id_livro'].'">
												<button value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Quero Ler</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$ultimos['id_livro'].''.$aspas.','.$aspas.''.$aspas.');">Estou lendo</a></li>
												</ul>
											</section>';
								}

								$livro = $ultimos['Livro'];

								$editar_livro = new EditarCaracteres($ultimos['Livro']);
								$livro = $editar_livro->Url($livro);

								$quantidade_pagina++;
								$id_ultima_ultimos[] = $ultimos['id_lista_livros'];
								echo'
										<form>
											<section class="panel panel-default">
												<section class="panel panel-body">  
													<section class="row">
														<section class="col-md-4">
															<center>
																<section class = "bs-component" style = "maxheight: 177px; width:120px;"> 
																	<a href="?url=livro&livro='.$ultimos['id_livro'].'"class = "thumbnail">
																		<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
																	</a>	
																</section>
															</center>
														</section>
														<section class="col-md-6">	
															<center>							
																<a href="?url=livro&livro='.$ultimos['id_livro'].'"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
																<a href="?url=livros_autores&autor='.utf8_encode($ultimos['Autor']).'"> <h4>'.utf8_encode($ultimos['Autor']).' </h4></a>
																<a href="?url=livros_editora&editora='.utf8_encode($ultimos['Editora']).'"> <h5>'.utf8_encode($ultimos['Editora']).' </h5></a>
																<a href="?url=perfil_usuario&cod='.$ultimos['id_usuario'].'"> <h4>'.utf8_encode($ultimos['usuario']).' </h4></a>
															</center>
														</section>
													</section>
													<section class="row">
														<center>
															<section>
																<button type = "button" class="btn btn-primary btn-sm" id = "solicitar" onClick="SolicitarLivro('.$aspas.''.$ultimos["id_lista_livros"].''.$aspas.','.$aspas.''.$ultimos['id_usuario'].''.$aspas.')">Solicitar Livro</button>
																<a href="?url=passo-a-passo-dados-usuario&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>															 
																<section class = "btn-group">
																	'.$botões.'
																</section>
																<a href="?url=pesquisa&nome='.utf8_encode($livro).'"><input type = "button" class="btn btn-primary btn-sm" name = "veja+" value = "Veja +"/></a>
															</section>
														</center>
													</section>
												</section>
											</section>
										</form>';
							}
						?>
					</section>
					<ul class="pager">
						<li id = "li_ultimos_antigo" class="previous disabled"><a id = "a_ultimos_antigo" onClick = "" >← Antigo</a></li>
						<li id = "li_ultimos_novo" class="<?php echo ($quantidade_ultimos >= 7) ? "next" : "next disabled"; ?>"><a id = "a_ultimos_novo" onClick="NovaDisponibilizados('<?php echo ($quantidade_ultimos >= 7) ? "$id_ultima_ultimos[5]','$id_ultima_ultimos[0]','1" : "None','None','1";?>');">Nova →</a></li>
					</ul>
			</section>
		</section>
	</section>
</article>
<section class="modal" id="myModal">
</section>
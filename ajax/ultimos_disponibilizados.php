<?php
	session_start();

	if((isset($_GET['lista_lvro'])) && (isset($_GET['acao'])))
	{
		include("../views/classes/class_banco.php");
		include("../views/classes/class_editar_caracteres.php");
		include("../views/classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$id = $_GET['lista_lvro'];	

		$aspas = "'";
		
		if($_GET['acao'] == "Novo")
		{
			//Pesquisa dos ultimos livros disponibilizados do site
			$campos = "id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "id_lista_livros < ".$id." 
			AND tbl_lista_livros.status = 1 
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
			AND categoria_id NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = ".$_SESSION['id'].") 
			AND id_lista_livros > ".$id);
			$resultado_quantidade_ultimos = $pesquisar_quantidade_ultimos->pesquisar();			
			$array_quantidade_ultimos = mysql_fetch_assoc($resultado_quantidade_ultimos);
			$quantidade_ultimos = $array_quantidade_ultimos['Quantidade'];
			
			if($quantidade_ultimos >= 7)
			{
				$resto = "Sim";
			}
			else
			{
				$resto = "Não";
			}
			
			$return = "";
			$ct=0;
			$id_ultima = array();
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
				$ct++;
				$id_ultima[] = $ultimos['id_lista_livros'];
				$return.= '
					<form>
						<section class="panel panel-default">
							<section class="panel panel-body">  
								<section class="row">
									<section class="col-md-4">
										<center>
											<section class = "bs-component" style = "maxheight: 177px; width:120px;"> 
												<a href="?url=livro&livro='.$ultimos['id_livro'].'" class = "thumbnail">
													<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
												</a>	
											</section>
										</center>
									</section>
									<section class="col-md-6">								
										<center>
											<a href="?url=livro&livro='.$ultimos['id_livro'].'"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
											<a href="?url=livros_autores&autor='.utf8_encode($lista_desejo['Autor']).'" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
											<a href="?url=livros_editora&editora='.utf8_encode($lista_desejo['Editora']).'" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
											<a href="?url=perfil_usuario&cod='.$ultimos['id_usuario'].'"> <h4>'.utf8_encode($ultimos['usuario']).' </h4></a>
										</center>
									</section>
								</section>
								<section class="row">
									<center>
										<section>
											<button type = "button" class="btn btn-primary btn-sm" id = "solicitar" onClick="SolicitarLivro('.$aspas.''.$ultimos["id_lista_livros"].''.$aspas.','.$aspas.''.$ultimos['id_usuario'].''.$aspas.')">Solicitar Livro</button>
											<a href="?url=passo-a-passo-dados-usuario&cod='.$ultimos['id_livro'].'"><input type = "button" class="btn btn-primary btn-sm" name = "botao_disponibilizar_livro" value = "Disponibilizar Livro" /></a>															 
											'.$botões.'
											<a href="?url=pesquisa&nome='.utf8_encode($ultimos['Livro']).'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_solicitar_livro" value = "Veja +"/></a>
										</section>
									</center>
								</section>
							</section>
						</section>
					</form>';
			}

			$lista_livros = array('tabela'=> $return,'ultimo_id'=> $id_ultima[$ct -1],'novo'=> $resto, 'primeiro' => "oi");
			
			echo json_encode($lista_livros);
			
		}
		if($_GET['acao'] == "Antigo")
		{
			//Pesquisa dos ultimos livros disponibilizados do site
			$campos = "id_lista_livros,id_usuario,usuario.nome As usuario,id_livro,imagem_livros,livro.nome AS Livro,edicao,autor.nome AS Autor,editora.nome As Editora,primeira_foto,segunda_foto,terceira_foto";
			$tabelas = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_usuario usuario INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_livro = livro_id AND id_usuario = usuario_id AND id_editora = editora_id AND id_autor = autor_id AND id_lista_livros = lista_livro_id";
			$condição = "id_lista_livros <= ".$id." AND tbl_lista_livros.status = 1 $string_condicao_autor $string_condicao_genero ORDER BY data_cadastro DESC LIMIT 6";
			$pesquisar_ultimos = new Pesquisar($tabelas,$campos,$condição);
			$resultado_ultimos = $pesquisar_ultimos->pesquisar();
			
			//Pesquisa a quantidade de livros no banco de dados
			$pesquisar_quantidade_ultimos = new Pesquisar("tbl_lista_livros ","COUNT(id_lista_livros) As Quantidade","1=1");
			$resultado_quantidade_ultimos = $pesquisar_quantidade_ultimos->pesquisar();			
			$array_quantidade_ultimos = mysql_fetch_assoc($resultado_quantidade_ultimos);
			$quantidade_ultimos = $array_quantidade_ultimos['Quantidade'];
			
			if($quantidade_ultimos >= 7)
			{
				$resto = "Sim";
			}
			else
			{
				$resto = "Não";
			}
			
			$return = "";
			$ct=0;
			$id_ultima = array();
			while($ultimos=mysql_fetch_assoc($resultado_ultimos))
			{
				$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo","livro_id =".$ultimos['id_livro']." AND usuario_id=".$_SESSION['id']);
				$resultado_marcacao = $pesquisar_marcacões->pesquisar();
				$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
				
				if($array_marcacao['tipo'] == 1)
				{
					$botões = ' 
								<button id = "Resultado'.$ultimos['id_livro'].'" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
								</ul>';
				}
				else if($array_marcacao['tipo'] == 2)
				{
					$botões = ' 
							<button id = "Resultado'.$ultimos['id_livro'].'" value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-sm">Já Li</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.');">Quero Ler</a></li>
							</ul>';
				}
				else if($array_marcacao['tipo'] == 3)
				{
					$botões = ' 
							<button id = "Resultado'.$ultimos['id_livro'].'" value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Estou lendo</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Desmarcar'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
								<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
							</ul>';
				}
				else
				{
					$botões = '
								<button id = "Resultado'.$ultimos['id_livro'].'" value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'QueroLer'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Quero Ler</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'JaLi'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$ultimos['id_livro'].','.$aspas.'Lendo'.$aspas.',Resultado'.$ultimos['id_livro'].','.$aspas.''.$aspas.');">Estou lendo</a></li>
								</ul>';
				}
				$ct++;
				$id_ultima[] = $ultimos['id_lista_livros'];
				$return.= '
					<form>
						<section class="panel panel-default">
							<section class="panel panel-body">  
								<section class="row">
									<section class="col-md-4">
										<center>
											<section class = "bs-component" style = "maxheight: 177px; width:120px;"> 
												<a href="?url=livro&livro='.$ultimos['id_livro'].'" class = "thumbnail">
													<img src = "'.$ultimos['imagem_livros'].'" alt = "'.utf8_encode($ultimos['Livro']).'" /> 
												</a>	
											</section>
										</center>
									</section>
									<section class="col-md-6">								
										<center>
											<a href="?url=livro&livro='.$ultimos['id_livro'].'"> <h3> '.utf8_encode($ultimos['Livro']).'</h3></a>				  
											<a href="?url=livros_autores&autor='.utf8_encode($lista_desejo['Autor']).'" title = "Clique para ver mais livros deste autor"> <h4> '.utf8_encode($lista_desejo['Autor']).' </h4></a>
											<a href="?url=livros_editora&editora='.utf8_encode($lista_desejo['Editora']).'" title = "Clique para ver mais livros desta editora"> <h5> '.utf8_encode($lista_desejo['Editora']).' </h5></a>
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
											<a href="?url=pesquisa&nome='.utf8_encode($ultimos['Livro']).'"><input type = "button" class="btn btn-primary btn-xs" name = "botao_solicitar_livro" value = "Veja +"/></a>
										</section>
									</center>
								</section>
							</section>
						</section>
					</form>';
			}

			$lista_livros = array('tabela'=> $return,'ultimo_id'=> $id_ultima[$ct -1],'primeiro' => "oi");
			
			echo json_encode($lista_livros);
			
		}
	}

?>
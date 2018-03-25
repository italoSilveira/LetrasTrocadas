<?php
	session_start();
	if((isset($_GET['acao'])) && (isset($_GET['id'])))
	{
		
		include("../views/classes/class_banco.php");
		include("../views/classes/class_update.php");
		include("../views/classes/class_insert.php");
		include("../views/classes/class_delete.php");
		
		$banco = new Banco();
		
		$acao = $_GET['acao'];
		$id = $_GET['id'];
		$tabela = $_GET['tabela'];
		
		$aspas = "'";
		
		
		switch ($tabela) 
		{
			case "JaLi":
				$tipo = 2;
				$campo = "lido";
				break;
			case "Lendo":	
				$tipo = 3;
				$campo = "lendo";
				break;
			case "QueroLer":
				$tipo = 1;
				$campo = "querem_ler";
				break;
		}
		
		switch ($acao) 
		{
			case "JaLi":
				$cadastrar_ja_li = new Inserir("tbl_marcacao","NULL,".$_SESSION['id'].",$id,2");
				$resultado = $cadastrar_ja_li->inserir();
				if($resultado != 0)
				{	
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("tbl_marcacao","livro_id=$id AND tipo = $tipo AND usuario_id =".$_SESSION['id']);
						$resposta_deletar = $deletar_antigo->deletar();
						if($resposta_deletar != 0)
						{
							$alterar_quantidade_livros = new Alterar("tbl_livro","$campo = ($campo - 1), lido = (lido + 1)","id_livro=$id");
							$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
							if($resultado_quantidade_livros != 0)
							{
								echo '
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
						}
					}
					else
					{
						$alterar_quantidade_livros = new Alterar("tbl_livro","lido = (lido + 1)","id_livro=$id");
						$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
						if($resultado_quantidade_livros != 0)
						{
							echo '
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
					}
				}
				break;
			case "Lendo":
				$cadastrar_lendo = new Inserir("tbl_marcacao","NULL,".$_SESSION['id'].",$id,3");
				$resultado = $cadastrar_lendo->inserir();
				if($resultado != 0)
				{
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("tbl_marcacao","livro_id=$id AND tipo = $tipo AND usuario_id =".$_SESSION['id']);
						$resposta_deletar = $deletar_antigo->deletar();
						if($resposta_deletar != 0)
						{
							$alterar_quantidade_livros = new Alterar("tbl_livro","$campo = ($campo - 1), lendo = (lendo + 1)","id_livro=$id");
							$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
							if($resultado_quantidade_livros != 0)
							{
								echo '<section class ="btn-group" id="Resultado'.$id.'">
										<button value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Estou lendo</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
										<ul id = "acoes" class="dropdown-menu">
											<li><a onClick="AcoesLivro('.$id.','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
											<li><a onClick="AcoesLivro('.$id.','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
											<li><a onClick="AcoesLivro('.$id.','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
										</ul>
									</section>';
							}
						}
					}
					else
					{
						$alterar_quantidade_livros = new Alterar("tbl_livro","lendo = (lendo + 1)","id_livro=$id");
						$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
						if($resultado_quantidade_livros != 0)
						{
							echo '<section class ="btn-group" id="Resultado'.$id.'">
										<button value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Estou lendo</button>
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
										<ul id = "acoes" class="dropdown-menu">
											<li><a onClick="AcoesLivro('.$id.','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
											<li><a onClick="AcoesLivro('.$id.','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
											<li><a onClick="AcoesLivro('.$id.','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
										</ul>
									</section>';
						}
					}
				}
				break;
			case "QueroLer":
				$cadastrar_quero_ler = new Inserir("tbl_marcacao","NULL,".$_SESSION['id'].",$id,1");
				$resultado = $cadastrar_quero_ler->inserir();
				if($resultado != 0)
				{
					if(!empty($tabela))
					{
						$deletar_antigo = new Deletar("tbl_marcacao","livro_id=$id AND tipo = $tipo AND usuario_id =".$_SESSION['id']);
						$resposta_deletar = $deletar_antigo->deletar();
						if($resposta_deletar != 0)
						{
							$alterar_quantidade_livros = new Alterar("tbl_livro","$campo = ($campo - 1), querem_ler = (querem_ler + 1)","id_livro=$id");
							$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
							if($resultado_quantidade_livros != 0)
							{
								echo '<section class ="btn-group" id="Resultado'.$id.'">
												<button value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$id.','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
													<li><a onClick="AcoesLivro('.$id.','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$id.','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
												</ul>
											</section>';
							}
						}
					}
					else
					{
						$alterar_quantidade_livros = new Alterar("tbl_livro","querem_ler = (querem_ler + 1)","id_livro=$id");
						$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
						if($resultado_quantidade_livros != 0)
						{
							echo '<section class ="btn-group" id="Resultado'.$id.'">
												<button value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
												<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
												<ul id = "acoes" class="dropdown-menu">
													<li><a onClick="AcoesLivro('.$id.','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
													<li><a onClick="AcoesLivro('.$id.','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
													<li><a onClick="AcoesLivro('.$id.','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$id.''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
												</ul>
											</section>';
						}
					}
				}
				break;
			case "Desmarcar":
					if(!empty($tabela))
					$deletar_antigo = new Deletar("tbl_marcacao","livro_id=$id AND tipo = $tipo AND usuario_id =".$_SESSION['id']);
					$resposta_deletar = $deletar_antigo->deletar();
					if($resposta_deletar != 0)
					{
						$alterar_quantidade_livros = new Alterar("tbl_livro","$campo = ($campo - 1)","id_livro=$id");
						$resultado_quantidade_livros = $alterar_quantidade_livros->alterar();
						if($resultado_quantidade_livros != 0)
						{
							echo '<section class ="btn-group" id="Resultado'.$id.'">
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
				
				break;
		}
	}
	

?>
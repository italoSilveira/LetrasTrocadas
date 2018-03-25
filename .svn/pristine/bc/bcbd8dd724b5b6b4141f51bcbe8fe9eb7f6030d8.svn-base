<?php 
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("classes/class_update.php");
		
		$banco = new Banco();
		
		$id = $_SESSION['id'];
		
		if(empty($_GET['cod']))
		{
			$id_outro_usu = $_SESSION['id'];
		}
		else
		{
			$id_outro_usu = $_GET['cod'];
		}
		
		if(isset($_POST['positivo']))
		{
			$alt_posit = new Alterar('tbl_usuario','avaliacoes_positivas = avaliacoes_positivas + 1','id_usuario = '.$id_outro_usu);
			$resul_posit = $alt_posit->alterar();
			
			$alt_cambio = new Alterar('tbl_cambio','denunciado = 1','id_cambio = (SELECT MAX(id_cambio) FROM tbl_cambio WHERE (usuario_resgate='.$id.' OR usuario_disponibilizador='.$id.') AND (usuario_resgate='.$id_outro_usu.' OR usuario_disponibilizador='.$id_outro_usu.'))');
			$resul_cambio = $alt_cambio->alterar();
		}
		
		if(isset($_POST['negativo']))
		{
			$alt_negat = new Alterar('tbl_usuario','avaliacoes_negativas = avaliacoes_negativas + 1','id_usuario = '.$id_outro_usu);
			$resul_negat = $alt_negat->alterar();
			
			$alt_cambio = new Alterar('tbl_cambio','denunciado = 1','id_cambio = (SELECT MAX(id_cambio) FROM tbl_cambio WHERE (usuario_resgate='.$id.' OR usuario_disponibilizador='.$id.') AND (usuario_resgate='.$id_outro_usu.' OR usuario_disponibilizador='.$id_outro_usu.'))');
			$resul_cambio = $alt_cambio->alterar();
		}
		
		if ($id == $id_outro_usu)
		{		
			/* Pesquisa de dados Básicos usuário */
			
		    $pesquisa_dados = new Pesquisar("tbl_usuario","id_usuario,nome,email,foto,idade,avaliacoes_negativas,avaliacoes_positivas,uf,cidade","id_usuario = $id");
		    $resul_pesquisa = $pesquisa_dados->pesquisar();
			
			$pesquisa_disp = new Pesquisar('tbl_cambio','COUNT(id_cambio) AS qt',"usuario_disponibilizador = $id_outro_usu AND status = 3 ");
		    $resul_disp = $pesquisa_disp->pesquisar();
			
			$pesquisa_soli = new Pesquisar('tbl_cambio','COUNT(id_cambio) AS qt',"usuario_resgate = $id_outro_usu AND status = 3 ");
		    $resul_soli = $pesquisa_soli->pesquisar();
			
			$pesquisa_denuncias = new Pesquisar('tbl_denuncias','COUNT(id_denuncias) AS qt',"usuario_denunciado_id = $id_outro_usu");
		    $resul_denuncias = $pesquisa_denuncias->pesquisar();
			
		    $pesq = mysql_fetch_assoc($resul_pesquisa);
			$dispo = mysql_fetch_assoc($resul_disp);
			$soli = mysql_fetch_assoc($resul_soli);
			$denuncia = mysql_fetch_assoc($resul_denuncias);
		    
			$qt_denuncias = $denuncia['qt'];
			$livro_solicitado = $soli['qt'];
			$livro_dis = $dispo['qt'];
		    $nome = $pesq['nome'];
		    $foto = $pesq['foto'];
		    $idade = $pesq['idade'];
		    $uf = $pesq['uf'];
		    $cidade = $pesq['cidade'];	
		    $avaliacoes_negativas = $pesq['avaliacoes_negativas'];
		    $avaliacoes_positivas = $pesq['avaliacoes_positivas'];
		    $id_p = $pesq['id_usuario'];
		    $email_p = $pesq['email'];
			
			$avaliação = '
					<label> Avaliações: </label>	
					&nbsp
					<span class= "glyphicon glyphicon-thumbs-up"></span> <span class = "badge">'.$avaliacoes_positivas.'</span>
					&nbsp
					<span class= "glyphicon glyphicon-thumbs-down"></span> <span class = "badge">'.$avaliacoes_negativas.'</span>
				';
			
			/* Pesquisa de livros que o usuário disponibilizou */ 
			
			$pesquisa_dados_lista_livros = new Pesquisar("tbl_usuario usu JOIN tbl_livro liv JOIN tbl_lista_livros list_liv ON list_liv.livro_id = id_livro AND list_liv.usuario_id = id_usuario","imagem_livros,liv.nome as Nome,id_lista_livros","id_usuario = $id GROUP BY id_lista_livros");
			$resul_pesquisa_lista_livros = $pesquisa_dados_lista_livros->pesquisar();
			
			/* Pesquisa de livros marcados como quero ler, lidos, lendo */

			//Quero Ler
			$pesquisar_quero_ler = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 1 AND usuario_id = $id_outro_usu");
			$resul_quero_ler = $pesquisar_quero_ler->pesquisar();	

			//Já li
			$pesquisar_ja_li = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 2 AND usuario_id = $id_outro_usu");
			$resul_ja_li = $pesquisar_ja_li->pesquisar();

			//Lendo
			$pesquisar_lendo = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 3 AND usuario_id = $id_outro_usu");
			$resul_lendo = $pesquisar_lendo->pesquisar();
			
			//Gêneros favoritos
			$pesquisa_generos_fav = new Pesquisar('tbl_generos_favoritos JOIN tbl_categoria ON id_categoria = categoria_id','*',"usuario_id = $id");
			$res_genero_fav = $pesquisa_generos_fav->pesquisar();

			//Autores favoritos
			$pesquisa_autor_fav = new Pesquisar('tbl_autores_favoritos JOIN tbl_autor ON id_autor = autor_id','*',"usuario_id = $id");
			$res_autor_fav = $pesquisa_autor_fav->pesquisar();

			//Gêneros que não gosto
			$pesquisa_generos_des = new Pesquisar('tbl_generos_desapreciados JOIN tbl_categoria ON id_categoria = genero_id','*',"usuario_id = $id");
			$res_genero_des = $pesquisa_generos_des->pesquisar();

			//Autores que não gosto
			$pesquisa_autor_des = new Pesquisar('tbl_autores_desapreciados JOIN tbl_autor ON id_autor = autor_id','*',"usuario_id = $id");
			$res_autor_des = $pesquisa_autor_des->pesquisar();

		}
		else if($id != $id_outro_usu)
		{
		    $pesquisa_dados = new Pesquisar("tbl_usuario","id_usuario,nome,email,foto,idade,avaliacoes_negativas,avaliacoes_positivas,uf,cidade", " id_usuario = $id_outro_usu");
		    $resul_pesquisa = $pesquisa_dados->pesquisar();
			
			$pesquisa_denuncia = new Pesquisar('tbl_cambio','data_denuncia','(usuario_resgate='.$id.' OR usuario_disponibilizador='.$id.') AND (usuario_resgate='.$id_outro_usu.' OR usuario_disponibilizador='.$id_outro_usu.') AND (denunciado <> 1)');
			$resultado_denuncia = $pesquisa_denuncia->pesquisar();
			
			$pesquisa_disp = new Pesquisar('tbl_cambio','COUNT(id_cambio) AS qt',"usuario_disponibilizador = $id_outro_usu AND status = 3 ");
		    $resul_disp = $pesquisa_disp->pesquisar();
			
			$pesquisa_soli = new Pesquisar('tbl_cambio','COUNT(id_cambio) AS qt',"usuario_resgate = $id_outro_usu AND status = 3 ");
		    $resul_soli = $pesquisa_soli->pesquisar();
			
			$pesquisa_denuncias = new Pesquisar('tbl_denuncias','COUNT(id_denuncias) AS qt',"usuario_denunciado_id = $id_outro_usu");
		    $resul_denuncias = $pesquisa_denuncias->pesquisar();
			
			$pesquisa = mysql_fetch_assoc($resultado_denuncia);
		    $pesq = mysql_fetch_assoc($resul_pesquisa);
			$dispo = mysql_fetch_assoc($resul_disp);
			$soli = mysql_fetch_assoc($resul_soli);
			$denuncia = mysql_fetch_assoc($resul_denuncias);
		    
			$qt_denuncias = $denuncia['qt'];
			$livro_solicitado = $soli['qt'];
			$livro_dis = $dispo['qt'];
			$data_denuncia = $pesquisa['data_denuncia'];
			$denunciado = $pesquisa['denunciado'];
			$data_atual = date('Y-m-d');
		    $nome = $pesq['nome'];
		    $foto = $pesq['foto'];
		    $idade = $pesq['idade'];
		    $uf = $pesq['uf'];
		    $cidade = $pesq['cidade'];	
		    $avaliacoes_negativas = $pesq['avaliacoes_negativas'];
		    $avaliacoes_positivas = $pesq['avaliacoes_positivas'];
		    $id_p = $pesq['id_usuario'];
		    $email_p = $pesq['email'];	
			
			// Comparando as Datas
			if(strtotime($data_denuncia) > strtotime($data_atual))
			{
				$avaliação = '
						<form method="post" action="">
							<label> Avaliações: </label>	
							&nbsp
							<button type="submit" name="positivo" style="background:#FFF;border:0px;"><span class= "glyphicon glyphicon-thumbs-up"></span> <span class = "badge">'.$avaliacoes_positivas.'</span></button>
							<button type="submit" name="negativo" style="background:#FFF;border:0px;"><span class= "glyphicon glyphicon-thumbs-down"></span> <span class = "badge">'.$avaliacoes_negativas.'</span></button>
						</form>';
						
				$mostrar = '';
			}
			else
			{
				$avaliação = '
						<label> Avaliações: </label>	
						&nbsp
						<span class= "glyphicon glyphicon-thumbs-up"></span> <span class = "badge">'.$avaliacoes_positivas.'</span>
						&nbsp
						<span class= "glyphicon glyphicon-thumbs-down"></span> <span class = "badge">'.$avaliacoes_negativas.'</span>
						';
			}			
			
			/* Pesquisa de livros que o usuário disponibilizou */ 
			
			$pesquisa_dados_lista_livros = new Pesquisar("tbl_usuario usu JOIN tbl_livro liv JOIN tbl_lista_livros list_liv ON list_liv.livro_id = id_livro AND list_liv.usuario_id = id_usuario","imagem_livros,liv.nome as Nome,id_lista_livros","id_usuario = $id_outro_usu GROUP BY id_lista_livros");
			$resul_pesquisa_lista_livros = $pesquisa_dados_lista_livros->pesquisar();
			
			/* Pesquisa de livros marcados como quero ler, lidos, lendo */

			//Quero Ler
			$pesquisar_quero_ler = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 1 AND usuario_id = $id_outro_usu");
			$resul_quero_ler = $pesquisar_quero_ler->pesquisar();	

			//Já li
			$pesquisar_ja_li = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 2 AND usuario_id = $id_outro_usu");
			$resul_ja_li = $pesquisar_ja_li->pesquisar();

			//Lendo
			$pesquisar_lendo = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 3 AND usuario_id = $id_outro_usu");
			$resul_lendo = $pesquisar_lendo->pesquisar();
			
			//Gêneros favoritos
			$pesquisa_generos_fav = new Pesquisar('tbl_generos_favoritos JOIN tbl_categoria ON id_categoria = categoria_id','*',"usuario_id = $id_outro_usu");
			$res_genero_fav = $pesquisa_generos_fav->pesquisar();

			//Autores favoritos
			$pesquisa_autor_fav = new Pesquisar('tbl_autores_favoritos JOIN tbl_autor ON id_autor = autor_id','*',"usuario_id = $id_outro_usu");
			$res_autor_fav = $pesquisa_autor_fav->pesquisar();

			//Gêneros que não gosto
			$pesquisa_generos_des = new Pesquisar('tbl_generos_desapreciados JOIN tbl_categoria ON id_categoria = genero_id','*',"usuario_id = $id_outro_usu");
			$res_genero_des = $pesquisa_generos_des->pesquisar();

			//Autores que não gosto
			$pesquisa_autor_des = new Pesquisar('tbl_autores_desapreciados JOIN tbl_autor ON id_autor = autor_id','*',"usuario_id = $id_outro_usu");
			$res_autor_des = $pesquisa_autor_des->pesquisar();

			
		}
		else
		{
		   /* Pesquisa de dados Básicos usuário */
			
		    $pesquisa_dados = new Pesquisar('tbl_usuario','id_usuario,nome,email,foto,idade,avaliacoes_negativas,avaliacoes_positivas,uf,cidade'," id_usuario = $id");
		    $resul_pesquisa = $pesquisa_dados->pesquisar();
			
		    $pesq = mysql_fetch_assoc($resul_pesquisa);
			
		    $nome = $pesq['nome'];
		    $foto = $pesq['foto'];
		    $idade = $pesq['idade'];
		    $uf = $pesq['uf'];
		    $cidade = $pesq['cidade'];	
		    $avaliacoes_negativas = $pesq['avaliacoes_negativas'];
		    $avaliacoes_positivas = $pesq['avaliacoes_positivas'];
		    $id_p = $pesq['id_usuario'];
		    $email_p = $pesq['email'];
			
			/* Pesquisa de livros que o usuário disponibilizou */ 
			
			$pesquisa_dados_lista_livros = new Pesquisar("tbl_usuario usu JOIN tbl_livro liv JOIN tbl_lista_livros list_liv ON list_liv.livro_id = id_livro AND list_liv.usuario_id = id_usuario","imagem_livros,liv.nome as Nome,id_lista_livros","id_usuario = $id GROUP BY id_lista_livros");
			$resul_pesquisa_lista_livros = $pesquisa_dados_lista_livros->pesquisar();
			
			/* Pesquisa de livros marcados como quero ler, lidos, lendo */

			$pesquisar_quero_ler = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 1 AND usuario_id = $id");
			$resul_quero_ler = $pesquisar_quero_ler->pesquisar();	

			$pesquisar_ja_li = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 2 AND usuario_id = $id");
			$resul_ja_li = $pesquisar_ja_li->pesquisar();

			$pesquisar_lendo = new Pesquisar("tbl_marcacao JOIN tbl_usuario ON usuario_id = id_usuario JOIN tbl_livro ON livro_id = id_livro"," id_livro,imagem_livros,tbl_livro.nome as Nome"," tipo = 3 AND usuario_id = $id");
			$resul_lendo = $pesquisar_lendo->pesquisar();
		}
?>
<article id = "body_perfil_usuario" style="width: 84%; margin-left: 8%;">
	<section class="panel panel-default">
		<section class="panel-body">
			<table class="table table-striped table-hover" style = "table-layout:fixed">
				<tbody>
					<tr>
						<td id = "foto_usuario" rowspan = "3"> <img src = " <?php echo $foto; ?>" width="100%" ></td>
						<td id = "nome_usuario" colspan = "2"><b>Nome:&nbsp;</b> <?php echo utf8_encode($nome); ?> </td>
						<td id = "cidade_usuario" colspan = "2"><b> Cidade:&nbsp;</b> <?php echo utf8_encode($cidade); ?> </td>
						<td id = "uf_usuario" colspan = "1"><b>UF:&nbsp;</b> <?php echo utf8_encode($uf); ?></td>
						<td id = "idade_usuario" colspan = "2"> <b>Idade:&nbsp;</b> <?php  echo utf8_encode($idade);?> </td>
					</tr>
					<tr>
						<td id = "livro_dis" title="Númros de livros disponibilizados por esse usuário que foram trocados" colspan="2">Livros Disponibilizados Trocados:&nbsp;</b><?php echo $livro_dis ?></td>
						<td id = "livro_sol" title="Número de livros solicitados por esse usuário" colspan="2">Livros Solicitados:&nbsp;</b><?php echo $livro_solicitado ?></td>
						<td id = "denuncias" title="Quantas denuncias foram feitas contra esse usuário" colspan="2">Quantidade de Denúncias:&nbsp;</b><?php echo $qt_denuncias ?></td>
					</tr>
					<tr>
						<td colspan="7">
							<ul class="nav nav-tabs" style="margin-bottom: 15px;">
								<li class="active"><a href="#livrosdisponiveis" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Livros Disponiveis</a></li>
								<li><a href="#jali" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Já li</a></li>
								<li><a href="#queroler" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Quero Ler</a></li>
								<li><a href="#lendo" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Lendo </a></li>
								<li><a href="#af" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> Autores Favoritos </a></li>
								<li><a href="#an" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> Autores que não gosto </a></li>
								<li><a href="#gf" data-toggle="tab"><span class="glyphicon glyphicon-list"></span> Gêneros Favoritos </a></li>
								<li><a href="#gn" data-toggle="tab"><span class="glyphicon glyphicon-list"></span> Gêneros que não gosto </a></li>
							</ul>
							<section id="myTabContent" class="tab-content">
								<section class="tab-pane fade active in" id="livrosdisponiveis" style="max-width:100%;overflow:auto;">
									<?php
										$qt = 0;		
										while($pesq_lista_livro = mysql_fetch_assoc($resul_pesquisa_lista_livros))
										{
											$qt++;
											echo '
											<a href="?url=livro_usuario&chave='.$pesq_lista_livro['id_lista_livros'].'">
												<img src ="'.$pesq_lista_livro['imagem_livros'].'" alt = "'.$pesq_lista_livro['nome'].'" height = "177px" width = "120px">&nbsp;
											</a>';
										}
										if($qt == 0)
										{
											echo 'Nenhum livro está disponível';
										}
										
									?>
								</section>
								<section class="tab-pane fade" id="jali" style="max-width:100%;overflow:auto;">
									<?php
										$qt_ja_li = 0;	
										while($pesq_ja_li = mysql_fetch_assoc($resul_ja_li))
										{
											$qt_ja_li++;
											echo '>
											<img src ="'.$pesq_ja_li['imagem_livros'].'" alt = "'.$pesq_ja_li['nome'].'" height = "177px" width = "120px">&nbsp;';
										}
										
										if($qt_ja_li == 0)
										{
											echo 'Nenhum livro está disponível';
										}
									?>
								</section>
								<section class="tab-pane fade" id="queroler" style="max-width:100%;overflow:auto;">
									<?php
										$qt_quero = 0;	
										while($pesq_quero_ler = mysql_fetch_assoc($resul_quero_ler))
										{
											$qt_quero++;
											echo '<img src ="'.$pesq_quero_ler['imagem_livros'].'" alt = "'.$pesq_quero_ler['nome'].'" height = "177px" width = "120px">&nbsp;';
										}

										if($qt_quero == 0)
										{
											echo 'Nenhum livro está disponível';
										}
									?>
								</section>
								<section class="tab-pane fade" id="lendo" style="max-width:100%;overflow:auto;">
									<?php
										$qt_lendo = 0;	
										while($pesq_lendo = mysql_fetch_assoc($resul_lendo))
										{
											$qt_lendo++;
											echo '<img src ="'.$pesq_lendo['imagem_livros'].'" alt = "'.$pesq_lendo['nome'].'" height = "177px" width = "120px">&nbsp;	';
										}

										if($qt_lendo == 0)
										{
											echo 'Nenhum livro está disponível';
										}
									?>
								</section>	
								<section class="tab-pane fade" id="af" style="max-width:100%;overflow:auto;">
									<p>Lista : </p>
									<p>
									<?php
										$qt_af = 0;	
										while($pesq_af = mysql_fetch_assoc($res_autor_fav))
										{
											$qt_af++;
											echo '- '.utf8_encode($pesq_af['nome']).'<br />';
										}

										if($qt_af == 0)
										{
											echo 'Nenhum autor na lista';
										}
									?>
									</p>
								</section>	
								<section class="tab-pane fade" id="an" style="max-width:100%;overflow:auto;">
									<p>Lista : </p>
									<p>
									<?php
										$qt_an = 0;	
										while($pesq_an = mysql_fetch_assoc($res_autor_des))
										{
											$qt_an++;
											echo '- '.utf8_encode($pesq_an['nome']).'<br />';
										}

										if($qt_an == 0)
										{
											echo 'Nenhum autor na lista';
										}
									?>
									</p>
								</section>				
								<section class="tab-pane fade" id="gf" style="max-width:100%;overflow:auto;">
									<p>Lista : </p>
									<p>
									<?php
										$qt_gf = 0;	
										while($pesq_gf = mysql_fetch_assoc($res_genero_fav))
										{
											$qt_gf++;
											echo '- '.utf8_encode($pesq_gf['nome']).'<br />';
										}

										if($qt_gf == 0)
										{
											echo 'Nenhum gênero na lista';
										}
									?>
									</p>
								</section>	
								<section class="tab-pane fade" id="gn" style="max-width:100%;overflow:auto;">
									<p>Lista : </p>
									<p>
									<?php
										$qt_gn = 0;	
										while($pesq_gn = mysql_fetch_assoc($res_genero_des))
										{
											$qt_gn++;
											echo '- '.utf8_encode($pesq_gn['nome']).'<br />';
										}

										if($qt_gn == 0)
										{
											echo 'Nenhum gênero na lista';
										}
									?>
									</p>
								</section>	
							</section>
						</td>
					</tr>
					<tr>
						<td colspan = "7"> 				             
							<section id = "avaliações" style = "position:relative; left:50%; width:30%;">
								<?php echo $avaliação; ?>
							</section>
						</td>
					</tr>
				</tbody>
			</table>
			<?php
				if (($id != $id_p) AND (!empty($mostrar)))
				{
					echo 
					'<section style = "position:relative; left:44%; width:30%"> 
						<a href = "?url=denunciar_usuario&cod='.$id_outro_usu.'"> Denunciar usuário </a>
					</section>';
				}
			?>
		</section>
	</section>
</article>
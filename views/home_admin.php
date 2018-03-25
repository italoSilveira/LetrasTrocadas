<?php
	if($_SESSION['nivel_acesso'] == 2)
	{
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		/* Pesquisa Denuncias recentes */ 
		
		$pesquisa_denuncias = new Pesquisar("tbl_usuario usu JOIN tbl_denuncias den ON usuario_denunciado_id = id_usuario JOIN tbl_motivos ON motivo_id = id_motivo","id_denuncias,usu.nome, id_usuario, usu.email, motivo_id, outro_motivo,motivo, data","1=1 GROUP BY id_denuncias ORDER BY data DESC");
		$resul_pesquisa_den = $pesquisa_denuncias->pesquisar();		
		$Denuncias = mysql_fetch_assoc($resul_pesquisa_den);
		
		/* Pesquisa o número de denuncias por usuário */ 
		
		$pesquisa_numero_den_usu = new Pesquisar("tbl_usuario JOIN tbl_denuncias ON usuario_denunciado_id = id_usuario","nome,email, COUNT(*) as Numero_Denuncias","1=1 GROUP BY id_usuario ORDER BY COUNT(*) DESC");
		$resul_pesquisa_n_den = $pesquisa_numero_den_usu->pesquisar();
		$_SESSION['Num_Den'] = mysql_fetch_assoc($resul_pesquisa_n_den);
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
<!--Tab Control-->
<ul class="nav nav-tabs" style="margin-bottom: 15px;">
	<li class="active"><a href="#denuncias" data-toggle="tab">Denúncias</a></li>
	<li><a href="#listanegra" data-toggle="tab">Lista Negra</a></li>
	<li><a href="#relatorios" data-toggle="tab">Relatórios</a></li>
</ul>
<section class="panel-body">
	<section id="myTabContent" class="tab-content">
		<section class="tab-pane fade active in" id="denuncias">
			<section class="panel-body">
				<?php 
					while($Denuncias = mysql_fetch_assoc($resul_pesquisa_den)) 
					{
						echo '<section class="panel-group" id="accordion">
							<section class="panel panel-default">
								<section class="panel-heading">
									<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">'
											 .$Denuncias["email"]. ' - ' .utf8_encode($Denuncias["nome"]). ' - ' .$Denuncias["data"].
										' - <a href = "?url=banimento&cod_d='.$Denuncias['id_denuncias'].'&cod_usu='.$Denuncias['id_usuario'].'"></a>
										</a>
									</h4>
								</section>
								<section id="collapse1" class="panel-collapse collapse in">
									<section class="panel-body">
										 '. 
										 utf8_encode($Denuncias["motivo"]). '. ' 
										 . utf8_encode($Denuncias["outro_motivo"])
										 .' 	
									</section>
								</section>
							</section>
						</section>';
					}
					?>

			</section>
		</section>
		<section class="tab-pane fade" id="listanegra">		
			<section class="panel-body">
				<ul class="list-group">
					<?php while($Num_Den = mysql_fetch_assoc($resul_pesquisa_n_den)){
					echo '<li class="list-group-item">
						  <span class="badge">'.$Num_Den["Numero_Denuncias"].'</span>'
						  .$Num_Den["email"]. ' - '.utf8_encode($Num_Den["nome"]).
					'</li>';
					}
					?>
				</ul>
			</section>
		</section>
		<section class="tab-pane fade" id="relatorios">
			<div class="list-group">
				<a href="#" class="list-group-item active">
				  Relatórios
				</a>
				<a href="views/relatorio_usuarios_recentes.php" class="list-group-item">Usuários cadastrados recentemente
				</a>
				<a href="views/relatorio_livros_favoritos.php" class="list-group-item">Livros mais trocados
				</a>
				<a href="views/relatorio_generos_fav.php" class="list-group-item">Gêneros Favoritos
				</a>
				<a href="views/relatorio_autores_fav.php" class="list-group-item">Autores Favoritos
				</a>
				<a href="views/relatorio_editoras_fav.php" class="list-group-item">Editoras Favoritas
				</a>
				<a href="views/relatorio_usuarios_bem_avaliados.php" class="list-group-item">Usuários mais bem avaliados
				</a>
				<a href="views/relatorio_usuarios_mal_avaliados.php" class="list-group-item">Usuários mais mal avaliados
				</a>
			</div>			
		</section>
	</section>
</section>
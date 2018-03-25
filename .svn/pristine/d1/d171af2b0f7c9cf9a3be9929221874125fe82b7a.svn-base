<?php
	if(empty($_SESSION['nivel_acesso']))
	{
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$tabela = "tbl_livros_trocados trocados INNER JOIN tbl_livro livro ON id_livro = livro_id";
		$campos = "id_livro,nome,imagem_livros";
		$condicao = "1=1 ORDER BY quantidade LIMIT 6";
		$pesquisar_destaques = new Pesquisar($tabela,$campos,$condicao);
		$resultado = $pesquisar_destaques->pesquisar();
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 1)
		{
			header('Location:?url=index_usuario');
		}
		else if($_SESSION['nivel_acesso'] == 2)
		{
			header('Location:?url=home_admin');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
?>
<article>
	<section id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<title></title>
		<ol class="carousel-indicators">
			<li class="active" data-target="#carousel-example-generic" data-slide-to="0"></li>
			<li class="" data-target="#carousel-example-generic" data-slide-to="1"></li>
		</ol>
		<!-- Wrapper for slides -->
		<section class="carousel-inner">
			<section class="item active">
				<a href="?url=cadastro_usuario"><img src="content/imagens/slider/slider1.jpg" alt="cadastre"></a>
			</section>
			<section class="item">
				<a href="?url=cadastro_usuario"><img src="content/imagens/slider/slider2.jpg" alt="cadastre"></a>
			</section>
		</section>
		<!-- Controls -->
		<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left"></span>
		</a>
		<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right"></span>
		</a>
	</section>
	<section class="panel panel-primary">
		<section class="panel-heading">
			<h3><span class="glyphicon glyphicon-star"></span> Livros em destaque</h3>
		</section>
		<section class="panel-body">	
			<?php
				$ct=0; 
				while($pesquisa=mysql_fetch_assoc($resultado))
				{
					$ct++;
					if(($ct == 1) OR ($ct == 4))
					{
						echo '<section class="row">';
					}
					echo
						'
							<section class="col-lg-4">
								<section class="bs-component">
									<a href="?url=livro&livro='.$pesquisa['id_livro'].'" class="thumbnail">
										<img src="'.$pesquisa['imagem_livros'].'" alt="'.utf8_encode($pesquisa['nome']).'" style="width:120;height:177px;"/>
										<p align="center">'.utf8_encode($pesquisa['nome']).'</p> 
									</a>
								</section>
							</section>
						';
					if(($ct == 3) OR ($ct == 6))
					{
						echo '</section>';
					}
				}
			?>
		</section>
	</section>
</article>
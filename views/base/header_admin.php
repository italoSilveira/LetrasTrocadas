<?php 

		function selected( $value, $selected )
		{
			return $value==$selected ? ' selected="selected"' : '';
		}

		$Filtro = $_POST['Filtro'];
?>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<section class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<section class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="?url=home_admin"><span class="glyphicon glyphicon-home"></span>&nbsp Bem vindo, <?php

													if(empty($_SESSION['nome']))
													{
														echo "pessoa"; 
													}
													else
													{
														$explode = explode(" ",$_SESSION['nome']);
														$nome = $explode[0];
														echo utf8_encode($nome);
													}
												?>!
			</a>
		</section>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<section class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<form class="navbar-form navbar-left" role="search" method= "post" action = "?url=pesquisa_adm">
				<section class="form-group">
					<select class="form-control" id="select" name = "Filtro">
			        	<option <?php echo selected('Usuário',$Filtro); ?> >Usuário</option>
			        	<option <?php echo selected('Livro',$Filtro); ?> >Livro</option>
			        	<option <?php echo selected('Autor',$Filtro); ?> >Autor</option>
			        	<option <?php echo selected('Editora',$Filtro); ?> >Editora</option>
			        	<option <?php echo selected('Gênero',$Filtro); ?> >Gênero</option>
			        </select>
					<input type="text" class="form-control" placeholder="Procurar" name = "pesquisa_adm">
				</section>
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search"></span>
				</button>
			</form>
			
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-pencil"></span>&nbsp Cadastrar <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="?url=cadastra_livro_adm">Livro</a></li>
						<li><a href="?url=cadastrar_editora">Editora</a></li>
						<li><a href="?url=cadastrar_autor">Autor</a></li>
						<li><a href="?url=cadastra_genero">Gênero</a></li>
					</ul>
				</li>
			

			
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>&nbsp Configurações<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="?url=alterar_dados_admin">Alterar dados</a></li>
						<li><a href="?url=alterar_senha_admin">Alterar senha</a></li>
					</ul>
				</li>
		  
				<li><a href="?url=cadastro_adm"><span class="glyphicon glyphicon-plus"></span>&nbsp Adicionar administrador</a></li>
				<li><a href="?url=logout&situacao=logado"><span class="glyphicon glyphicon-log-out"></span>&nbsp Sair</a></li>
			</ul>
		</section><!-- /.navbar-collapse -->
	</section><!-- /.container-fluid -->
</nav>
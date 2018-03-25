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
			<a class="navbar-brand" href="?url=index_usuario"><span class="glyphicon glyphicon-home"></span>&nbsp Bem vindo(a), <?php

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
			?>!</a>
			
		</section>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<section class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<form class="navbar-form navbar-left" role="search" method= "post" action = "?url=pesquisa" name = "frmPesquisa">
				<section class="form-group">
					<input type="text" class="form-control" placeholder="Procurar" name = "pesquisa">
					<button type="submit" class="btn btn-default" name = "btnPesquisa">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</section>
			</form>

			<ul class="nav navbar-nav navbar-right">
				<li><a href="?url=perfil_usuario"><span class="glyphicon glyphicon-user"></span>&nbsp Perfil</a></li>
				<li><a href="?url=duvidas">LT&nbsp<span id="Moedas" class="navbar-right badge">0</span></a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-globe"></span>&nbsp Site<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a  href = "?url=acervo"> Acervo </a></li>
						<li><a href = "?url=sugestoes"> Sugestões </a></li>					
					</ul>
				</li>
				<li class="dropdown"> 
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp Notificações<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href = "?url=trocas">Trocas <span id="Trocas_aceitas" class="navbar-right badge">0</span></a></li>
						<li><a href = "?url=solicitacoes_recebidas">Solicitações <span id="Solicitacoes_recebidas" class="navbar-right badge">0</span></a></li>
						<li><a href = "?url=cade_meus_livros">Cadê meus livros?</a></li>					
					</ul>
				</li>
				<li class="dropdown"> 
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-book"></span>&nbsp Meus livros<b class="caret"></b></a>
					  <ul class="dropdown-menu">
						  <li><a href="?url=livros_lidos">Lidos</a></li>
						  <li><a href="?url=livros_disponibilizados">Disponibilizados</a></li>
						  <li><a href="?url=livros_em_leitura">Lendo</a></li>
						  <li><a href="?url=livros_quero_ler">Quer Ler</a></li>
						  <li><a href="?url=passo-a-passo-pesquisa">Cadastrar novo livro</a></li>
					  </ul>
				</li>
				<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span>&nbsp Conta<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="?url=alterar_dados_perfil">Alterar dados</a></li>
						<li><a href="?url=alterar_senha_usuario">Alterar senha</a></li>
						<li><a href="?url=desativar_conta">Desativar conta</a></li>
						<li><a href="?url=logout&situacao=logado">Sair</a></li>
					</ul>
				</li>
			</ul>			
		</section><!-- /.navbar-collapse -->
	</section><!-- /.container-fluid -->
</nav>
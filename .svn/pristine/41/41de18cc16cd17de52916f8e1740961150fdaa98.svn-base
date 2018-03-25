<?php
	if(empty($_SESSION['nivel_acesso']))
	{
		//Verifica se o botão foi acionado
		if(isset($_POST['entrar']))
		{
			//Inclui a classe da banco de dados
			include("classes/class_banco.php");
			include("classes/class_editar_caracteres.php");
			include("classes/class_pesquisar.php");

			$banco = new Banco();
			
			//Coloca em variaveis os valores passados pelo formulário
			$login = $_POST['email'];
			$senha = $_POST['senha'];
			
			//Tenta evitar o MySql Inject
			$editar_login = new EditarCaracteres($login);
			$login = $editar_login->sanitizeStringemail($_POST['email']);
			
			$editar_senha = new EditarCaracteres($senha);
			$senha = $editar_senha->sanitizeStringNome($_POST['senha']);
			
			//Verifica se o login terminar com letrastrocadas.com.br, se tiver é um adm. 
			if(preg_match('/letrastrocadas.com.br$/', $login))
			{
				//Pesquisa pra ver se ele existe
				$pesquisar_adm = new Pesquisar("tbl_administrador","*"," email = '".$login."' AND senha = '".$senha."' LIMIT 1");
				$resultado_adm = $pesquisar_adm->pesquisar();
				// Verifica se tem retorno
				if(mysql_num_rows($resultado_adm) == 1)
				{
					$dadosadm = mysql_fetch_assoc($resultado_adm);
					//Preenche a session com dados do usuário
					$_SESSION["nivel_acesso"]=$dadosadm["nivel_acesso"];
					$_SESSION["id"]=$dadosadm["id_administrador"];
					$_SESSION["nome"]=$dadosadm["nome"];
					$_SESSION["email"]=$dadosadm["email"];
					// Redireciona para a página do adm
					header("Location:?url=home_admin");
				}
				else
				{
					//Não foi encontrado nenhum registro
					echo '<section class="alert alert-dismissable alert-danger">
							<button type="button" class="close" data-dismiss="alert">×</button>
							 Login ou a senha errdados.
						</section>';
				}
			}
			//Usuário padrão
			else
			{
				// Verifica se o usuário existe
				$pesquisar_usuario = new Pesquisar("tbl_usuario","id_usuario,nivel_acesso,status,nome,email,status"," email = '".$login."' AND senha = '".$senha."' LIMIT 1");
				$resultado_pesquisa = $pesquisar_usuario->pesquisar();
				if(mysql_num_rows($resultado_pesquisa) == 1)
				{
				
					// Interpreta a busca
					$dadosusu = mysql_fetch_assoc($resultado_pesquisa);
					// Verifica o status do usuário 
					if(($dadosusu["status"] == 1) OR ($dadosusu["status"] == 4))
					{
						//Preenche a session com dados do usuário
						$_SESSION["nivel_acesso"] = $dadosusu["nivel_acesso"];
						$_SESSION["id"] = $dadosusu["id_usuario"];
						$_SESSION["nome"] = $dadosusu["nome"];
						$_SESSION["email"]=$dadosusu["email"];
						$_SESSION["status"]=$dadosusu["status"];
						// Redireciona para a página de usário
						header("Location:?url=index_usuario");
						
					}
					else if ($dadosusu["status"] == 2)
					{
						// Cria uma resposta para ser exibida se o usuário estiver inativo
						echo '<section class="alert alert-dismissable alert-danger">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<strong>Ih!</strong> Sua conta está inativa, contate os administradores para reativá-la.
							</section>';
					}
					else if ($dadosusu["status"] == 3)
					{
						// Cria uma resposta para ser exibida se o usuário tiver sido banido
						echo '<section class="alert alert-dismissable alert-danger">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Vish!</strong> Você foi banido. Para informação, entre em contato.
						</section>';
					}
					else
					{
						// Cria uma resposta para ser exibida se o usuário digitou a senha ou o usuário errado
						echo '<section class="alert alert-dismissable alert-danger">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<strong>Vish!</strong> Esse usuário não existe ou a senha está errada, confere ai.
							</section>';
					}
				}
				else
				{
					// Se não achar resposta é por que o usuário ou senha não estão corretos
					echo '<section class="alert alert-dismissable alert-danger">
							<button type="button" class="close" data-dismiss="alert">×</button>
							<strong>Eita!</strong> Algo não saiu como deveria, tente de novo daqui a pouco.
						</section>';
				
				}
			}	
		}
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
<article id  = "login" style = "width:60%; position: absolute; left:20%;">
	<form class="form-horizontal" method="post" action="">
		<fieldset>
			<legend>Login</legend>	  
			<section class="form-group">
				<label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
				<section class="col-lg-10">		 
					<input type="email" class="form-control" name = "email" id="email" required placeholder = "E-mail" maxlength = "100">			  
				</section>
				<label for="inputSenha" class="col-lg-2 control-label">Senha</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" name = "senha" id="inputSenha" required placeholder = "Senha" maxlength = "16">
				</section>
				<section class="col-lg-10 col-lg-offset-2">
					<button style="float: right; margin-top:2%;" type="submit" name = "entrar" class="btn btn-primary">Entrar</button>
					<a style="float: left; margin-top:2%;" href="?url=esqueceu_senha">Esqueceu sua senha?</a>
				</section>
			</section>
		</fieldset>
	</form>
</article>
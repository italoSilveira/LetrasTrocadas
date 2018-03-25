<?php
	if($_SESSION['nivel_acesso'] == 2)
	{
		// Verifica  se o botão foi acionado
		if(isset($_POST['cadastrar']))
		{
			include("classes/class_editar_caracteres.php");
			include("classes/class_insert.php");
			include("classes/class_pesquisar.php");
			include("classes/class_banco.php");

			$banco_dados = new Banco();
			
			$nome = $_POST['nome'];
			$email = $_POST['email'];
			$senha = $_POST['senha'];
			$confirmarsenha = $_POST['confirmarsenha'];
			
			//Instancia a classe que tenta evitar o MySql Inject
			$editar_nome = new EditarCaracteres($nome);
			$nome = utf8_decode($editar_nome->sanitizeStringNome($_POST['nome']));
			
			$editar_email = new EditarCaracteres($email);
			$email = $editar_email->sanitizeStringemail($_POST['email']);
			
			$editar_senha = new EditarCaracteres($senha);
			$senha = utf8_decode($editar_senha->sanitizeStringNome($_POST['senha']));
			
			$editar_confirmarsenha = new EditarCaracteres($confirmarsenha);
			$confirmarsenha = utf8_decode($editar_confirmarsenha->sanitizeStringNome($_POST['confirmarsenha']));		
			
			//Verifica se o email termina com o final letrastrocadas.com.br (Isso aqui ainda vai mudar)
			if(preg_match('/letrastrocadas.com.br$/', $email))
			{
				// Verifica se a senha e confirmar senha estão corretos
				if(strlen($senha) < 8)
				{
					echo '<section class="alert alert-dismissable alert-warning">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Sua senha tá muito curta, digita uma com, <strong>no mínimo</strong> 8 dígitos.
						</section>';
				}
				else
				{
					if($confirmarsenha == $senha)
					{
						$pesquisar_adm = new Pesquisar('tbl_administrador','*',"email = '$email'");
						$resultado_adm = $pesquisar_adm->pesquisar();
						$qt = mysql_num_rows($resultado_adm);
						if($qt == 0)
						{
							$valores_administrador = "NULL,'$nome',2,'$email','$senha'";
							$cadastrar_administrador = new Inserir("tbl_administrador",$valores_administrador);
							$resposta = $cadastrar_administrador->inserir();
							
							if($resposta)
							{
								echo '<section class="alert alert-dismissable alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<strong>Eba!</strong> Mais um administrador pra nossa equipe.
									</section>';
							}
							else
							{
								echo '<section class="alert alert-dismissable alert-warning">
										<button type="button" class="close" data-dismiss="alert">×</button>
										Ocorreu algum erro durante seu cadastro, tente mais tarde.
									</section>';

							}
						}
						else
						{
							echo '<section class="alert alert-dismissable alert-warning">
										<button type="button" class="close" data-dismiss="alert">×</button>
										Esse email já está sendo utilizado.
									</section>';
						}
					}
					else
					{
						echo '<section class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<strong>Opa!</strong> As senhas não batem, confere ai.
							</section>';
					}
				}
			}
			// Se não terminar com o nosso letrastrocadas.com.br está errado.
			else
			{
				echo '<section class="alert alert-dismissable alert-warning">
						<button type="button" class="close" data-dismiss="alert">×</button>
						Entre em contato com um administrador para saber como funciona o cadastro.
					</section>';
			}
		}
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

<article id  = "cadastro_adm" style = "position:relative;width:40%;height:20%;left:30%;">
	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Cadastro</legend>
			<section class="form-group">
				<label for="inputNome" class="col-lg-2 control-label">Nome</label>
				<section class="col-lg-10">
					<input type="nome" class="form-control" name = "nome" id="nome" required placeholder = "Nome" maxlength = "100">
				</section>
				<label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
				<section class="col-lg-10">
					<input type="email" class="form-control" name = "email" id="email" required placeholder = "E-mail" maxlength = "100">
				</section>
				<label for="inputSenha" class="col-lg-2 control-label">Senha</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" name = "senha" id="inputSenha" required placeholder = "Senha" maxlength = "16">
				</section>
				<label for="inputConfirmarSenha" class="col-lg-2 control-label">Confirmar Senha</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" name = "confirmarsenha" id="inputSenha" required maxlength = "16" placeholder = "Confirmar senha">	  
				</section>
				<section class="col-lg-10 col-lg-offset-2">
					<button type="submit" name = "cadastrar" class="btn btn-primary">Cadastrar</button>
					<button type = "reset "class="btn btn-default">Limpar</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>
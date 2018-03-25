<script type='text/javascript'>
</script>
<?php
	if(empty($_SESSION['nivel_acesso']))
	{
		if(isset($_POST['entrar']))
		{
			// Inclui classes com nomes auto-explicativos
			include("classes/class_cadastrar_usuario.php");
			include("classes/class_banco.php");
			include("classes/class_editar_caracteres.php");
			include ("classes/class_pesquisar.php");

			$banco_dados = new Banco();
			
			$login = $_POST['email'];
			$senha = $_POST['senha'];
			$confirmar = $_POST['confirmar'];
			
			$editar_login = new EditarCaracteres($login);
			$login = $editar_login->sanitizeStringemail($login);
		
			$editar_senha = new EditarCaracteres($senha);
			$senha = $editar_senha->sanitizeStringNome($_POST['senha']);
			
			$editar_confirmar = new EditarCaracteres($confirmar);
			$confirmar = $editar_confirmar->sanitizeStringNome($_POST['confirmar']);
			
			// Verifica se o email terminar com letrastrocadas.com.br
			if(preg_match('/letrastrocadas.com.br$/', $login))
			{
				// Só o adm pode cadastrar outro adm e isso acontece em outra página, então isso aqui não deixa que o usuário cadastre com esse final
				echo '<section class="">
					Usuário já está sendo utilizado
					</section>';
			}
			else
			{		
				if(strlen($senha) < 8)
				{
					echo '<section class="alert alert-dismissable alert-warning">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Sua senha está muito curta, digita uma com, <strong>no mínimo</strong> 8 dígitos.
						</section>';
				}
				else if(strlen($senha) > 16)
				{
					echo '<section class="alert alert-dismissable alert-warning">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Sua senha está muito grande, digita uma com, <strong>no máximo</strong> 16 dígitos.
						</section>';
				}
				else
				{
					if($senha === $confirmar)
					{
						$pesquisar = new Pesquisar("tbl_usuario","*","email = '".$login."'");
						$resultado = $pesquisar->pesquisar();
						$qt = mysql_num_rows($resultado);
						if($qt == 0)
						{
							//Instancia a classe responsável por cadastrar o usuário e já passa os valores
							$cadastrar = new CadastrarUsu($login,$senha);
							// Manda a classe inserir o usuário no banco de dados
							$res = $cadastrar->inserir();
							// Verifica se tem resposta
							if($res == 1)
							{
								//Instancia a classe de pesquisa e verifica se o usuário realmente foi inserido
								$pesquisar_usuario = new Pesquisar("tbl_usuario","*","email = '".$login."' AND senha = '".$senha."' LIMIT 1");
								// Realiza a pesquisa
								$resultado_pesquisa = $pesquisar_usuario->pesquisar();
								// Confere se foi retornado alguma coisa pela pesquisa
								if(mysql_num_rows($resultado_pesquisa) == 1)
								{	
										$dadosusu = mysql_fetch_assoc($resultado_pesquisa);
										//Preenche a session com dados do usuário
										$_SESSION["nivel_acesso"]=$dadosusu["nivel_acesso"];
										$_SESSION["id"]=$dadosusu["id_usuario"];
										$_SESSION["nome"]=$dadosusu["nome"];
										$_SESSION["email"]=$dadosusu["email"];
										$_SESSION["tutorial"]="ativo";
										// Redireciona para o menu do usuário
										header("Location: ?url=index_usuario");
									
								}
							}
							else
							{
								// Aconteceu algum erro e o usuário não foi cadastrado
								echo '<section class="alert alert-dismissable alert-danger">
								  <button type="button" class="close" data-dismiss="alert">×</button>
								  Alguma coisa deu errado na hora do seu cadastro. Tente mais tarde.
								</section>';
							}
						}
						else
						{
							echo '<section class="alert alert-dismissable alert-danger">
								  <button type="button" class="close" data-dismiss="alert">×</button>
								  Esse email já está sendo utilizado.
								</section>';
						}
					}
					else
					{
						echo '<section class="alert alert-dismissable alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>Ops!</strong> As senhas não estão iguais, confere ai haha.
							</section>';
					}
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
<article id  = "cadastro_usuario" style = "width: 60%; margin-left: 20%;">
	<form class="form-horizontal" method = "post" action = "?url=cadastro_usuario">
		<fieldset>
			<legend>Cadastro</legend>				  
			<section class="form-group">
				<label for="inputEmail" class="col-md-2 control-label">E-mail</label>
				<section class="col-md-10">	 
					<input type="email" class="form-control"  name = "email" id="email" value = "" required placeholder = "E-mail" maxlength = "100">			  
				</section>
				<label for="inputSenha" class="col-md-2 control-label">Senha</label>
				<section class="col-md-10">
					<input type="password" class="form-control" name = "senha" id="inputSenha" required maxlength = "16" placeholder = "Entre 8 e 16 dígitos" maxlength = "16">
				</section>
				<label for="inputConfirmarSenha" name = "confirmar" class="col-md-2 control-label">Confirmar Senha</label>
				<section class="col-md-10">
					<input type="password" class="form-control" name = "confirmar" id="inputSenha" required maxlength = "16" placeholder = "Digite sua senha novamente">		  
				</section>
				<section class="col-md-12 col-md-offset-2">
					<button type="submit" name = "entrar" class="btn btn-primary">Cadastrar</button>
					<input type = "reset" class="btn btn-default" value="Limpar"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>
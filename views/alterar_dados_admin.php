<?php
	// Verifica se o botão foi acionado
	if($_SESSION['nivel_acesso'] == 2)
	{
		$nome = $_SESSION["nome"];
		$email = $_SESSION["email"];
		if(isset($_POST['alterar_dados_admin']))
		{
			include("classes/class_banco.php");
			//Instancia e faz conexão com o banco de dados
			$banco = new Banco();

			if(isset($_POST['alterar_dados_admin']))
			{
				$id = $_SESSION['id'];
				
				include("classes/class_editar_caracteres.php");
				include("classes/class_update.php");
				
				//Repassa os valores enviados pelo formulário para uma variável
				$nome = $_POST['nome'];
				$email = $_POST['email'];
				
				
				//Instancia a classe que tenta evitar o MySql Inject
				$editar_nome = new EditarCaracteres($nome);
				$nome = $editar_nome->sanitizeStringNome($_POST['nome']);

				
				//Instancia e passa os valores para a classe de Update 
				$valores_adm = "nome = '" .utf8_decode($nome). "',
		        email = '".$email."'";
				
				$condicao = "id_administrador =".$id."";
				$alterar_dados = new Alterar("tbl_administrador",$valores_adm, $condicao);
				$resposta = $alterar_dados->alterar();
				echo $resposta;
				//Confere se houve resposta e envia mensagem de erro ou sucesso.
				if($resposta)
				{
					echo "<div class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
							  <strong>Seus dados foram alterados com sucesso!</strong>
					</div>";
				}
				else
				{
					echo "<div class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						  <strong>Erro ao alterar dados.</strong> Tente novamente!
					</div>";
					
				}

				$nome = utf8_decode($nome);
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
<article id  = "alterar_dados_perfil" style = "width: 60%; margin-left: 20%;">
	<form class="form-horizontal" method = "post" action = "?url=alterar_dados_admin">
		<fieldset>
			<legend>Alterar Dados Administrador</legend>
			<section class="form-group">
				<label for="inputNome" class="col-md-2 control-label">Nome:</label>
				<section class="col-md-10">	 
					<input type="text" class="form-control"  name = "nome" id="nome" required placeholder = "Nome" maxlength = "100" value = "<?php echo utf8_encode($nome); ?>">			  
				</section>
				 <br>
				<label for="inputEmail" class="col-md-2 control-label">E-mail:</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "email" id="email" required placeholder = "E-mail" maxlength = "100" value = "<?php echo $email; ?>">  
				</section>
				<br>
				<section class="col-md-12 col-md-offset-2">
					<button type="submit" name = "alterar_dados_admin" class="btn btn-primary">Salvar Alterações</button>
					<input type = "reset" name="cancelar" value="Original" class="btn btn-default"/>		
				</section>
			</section>
		</fieldset>
	</form>
</article>
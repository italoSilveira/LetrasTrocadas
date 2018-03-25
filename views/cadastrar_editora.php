<?php

	if($_SESSION['nivel_acesso'] == 2)
	{
		if(isset($_POST['cadastrar_editora']))
		{
			include("classes/class_banco.php");
			include("classes/class_editar_caracteres.php");
			include("classes/class_insert.php");
			$banco = new Banco();		
			
			//Repassa os valores enviados pelo formulário para uma variável
			$nome = $_POST['nome'];
			
			//Instancia a classe que tenta evitar o MySql Inject
			$editar_nome = new EditarCaracteres($nome);
			$nome = utf8_decode($editar_nome->sanitizeStringNome($_POST['nome']));
			
			//Instancia e passa os valores para a classe de Insert que cadastrará o autor
			$valores_editora = "NULL,'".$nome."'";
			$cadastrar_editora = new Inserir("tbl_editora",$valores_editora);
			$resposta = $cadastrar_editora->inserir();
			//Confere se houve resposta e envia mensagem de erro ou sucesso.
			if($resposta)
			{
				echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
							<strong>Editora cadastrada com sucesso!</strong>
							</section>";
			}
			else
			{
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
							<strong>Erro ao cadastrar editora.</strong> Tente novamente!
					</section>";	
					
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

<article id  = "cadastro_usuario" style = "width: 60%; margin-left:20%;">
	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Cadastrar Editora</legend>
			<section class="form-group">
				<label for="inputDescricao" class="col-md-2 control-label">Editora:</label>
				<section class="col-md-10">	 
					<input type="text" class="form-control" name = "nome" required placeholder = "Editora" maxlength = "100">			  
				</section>
				<br>						
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "cadastrar_editora" class="btn btn-primary">Cadastrar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>
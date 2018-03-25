<?php
	if($_SESSION['nivel_acesso'] == 2)
	{
		$nome = "";
		if(isset($_POST['cadastrar_autor']))
		{
			include("classes/class_banco.php");
			$banco = new Banco();
			include("classes/class_editar_caracteres.php");
			include("classes/class_insert.php");
			
			//Repassa os valores enviados pelo formulário para uma variável
			$nome = $_POST['nome'];
			
			//Instancia a classe que tenta evitar o MySql Inject
			$editar_nome = new EditarCaracteres($nome);
			$nome = utf8_decode($editar_nome->sanitizeStringNome($_POST['nome']));
			
			//Instancia e passa os valores para a classe de Insert que cadastrará o autor
			$valores_autor = "NULL,'".$nome."'";
			$cadastrar_autor = new Inserir("tbl_autor",$valores_autor);
			$resposta = $cadastrar_autor->inserir();
			//Confere se houve resposta e envia mensagem de erro ou sucesso.
			if($resposta)
			{
				echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
							<strong>Autor cadastrado com sucesso!</strong>
							</section>";
			}
			else
			{
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
							<strong>Erro ao cadastrar autor.</strong> Tente novamente!
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

<article id  = "cadastro_usuario" style = "position:relative;width:50%;height:20%;left:27%;">
	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Cadastrar Autor</legend>
			<section class="form-group">
				<label for="inputDescricao" class="col-md-2 control-label">Autor:</label>			  
				<section class="col-md-10">	 
					<input type="text" class="form-control"  name = "nome" value="<?php echo utf8_encode($nome)?>" required placeholder = "Nome" maxlength = "100">			  
				</section>
				<br>
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "cadastrar_autor" class="btn btn-primary">Cadastrar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>
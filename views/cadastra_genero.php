<?php
	if($_SESSION['nivel_acesso'] == 2)
	{
		$nome = "";
		if(isset($_POST['cadastrar_genero']))
		{
			include("classes/class_banco.php");
			include("classes/class_editar_caracteres.php");
			include("classes/class_insert.php");

			$banco = new Banco();
			
			//Repassa os valores enviados pelo formulário para uma variável
			$nome = $_POST['nome'];
			
			//Instancia a classe que tenta evitar o MySql Inject
			$editar_nome = new EditarCaracteres($nome);
			$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
			
			//Instancia e passa os valores para a classe de Insert que cadastrará o autor
			$valores_categoria = "NULL,'".$nome."'";
			$cadastrar_categoria = new Inserir("tbl_categoria",$valores_categoria);
			$resposta = $cadastrar_categoria->inserir();
			//Confere se houve resposta e envia mensagem de erro ou sucesso.
			if($resposta)
			{
				echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
							<strong>Gênero cadastrado com sucesso!</strong>
							</section>";
			}
			else
			{
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
							<strong>Erro ao cadastrar gênero.</strong> Tente novamente!
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
			<legend>Cadastrar Gênero</legend>
			<section class="form-group">
				<label for="inputDescricao" class="col-lg-2 control-label">Descrição:</label>
				<section class="col-lg-9">	 
					<input type="text" class="form-control"  name = "nome" id="descricao" required value="<?php echo $nome; ?>" placeholder = "Descrição" maxlength = "100">			  
				</section>
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "cadastrar_genero" class="btn btn-primary">Cadastrar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>
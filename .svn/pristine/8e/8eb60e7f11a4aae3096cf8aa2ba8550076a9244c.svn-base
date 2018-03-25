<?php
	if($_SESSION['nivel_acesso'] == 2)
	{
		if(isset($_POST['alterar_categoria']))
		{
			include("classes/class_pesquisar.php");
			include("classes/class_banco.php");
			include("classes/class_editar_caracteres.php");

			$banco = new Banco();
			
			$id_genero = $_GET['cod'];

			if($id_genero != "")
			{
				
				$editar_id = new EditarCaracteres($id_genero);
				$id_genero = $editar_id->sanitizeNumber($_GET['cod']);
				
				$tabelas = "tbl_categoria";
				$campos="nome";
				$condicao = "id_categoria = ".$id_genero;
				
				$pesquisar_genero = new Pesquisar($tabelas,$campos,$condicao);
				$resultado = $pesquisar_genero->pesquisar();
				
				while($pesquisar_genero=mysql_fetch_assoc($resultado))
				{
					$nome = $pesquisar_genero['nome'];
				}
			}
			else
			{
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
					<strong>Erro ao alterar livro.</strong> Tente novamente!
				</section>";
			}
		}
		else if(isset($_POST['alterar']))
		{
			include("classes/class_editar_caracteres.php");
			include("classes/class_banco.php");
			include("classes/class_update.php");

			$banco = new Banco();

			$id_genero = $_GET['id_genero'];
			
			$editar_id = new EditarCaracteres($id_genero);
			$id_genero = $editar_id->sanitizeNumber($_GET['id_genero']);
		
			$nome = $_POST['nome'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = utf8_decode($editar_nome->sanitizeStringNome($_POST['nome']));
		
			$campos = "nome = '".$nome."'";
			$condicao = "id_categoria = ".$id_genero;
			$alterar_genero = new Alterar("tbl_categoria",$campos,$condicao);
			$resultado_genero = $alterar_genero->alterar();
			if($resultado_genero == 1)
			{
				echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Gênero alterado com sucesso!</strong>
				</section>";
			}
			else
			{
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao alterar gênero.</strong> Tente novamente!
				</section>";
			}
		}
		else
		{
			echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Primeiro faça a pesquisa!</strong>
				</section>";	
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
	<form class="form-horizontal" method = "post" action = "?url=alterar_genero&id_genero=<?php echo $id_genero; ?>">
		<fieldset>
			<legend>Alterar Gênero</legend>
			<section class="form-group">
				<label for="inputID" class="col-lg-2 control-label">ID:</label>
				<section class="col-lg-9">
					<input type="text" class="form-control" name = "id_genero" value ="<?php echo $id_genero; ?>" disabled  placeholder = "ID" >
				</section>
				<label for="inputDescricao" class="col-lg-2 control-label">Descrição:</label>
				<section class="col-lg-9">	 
					<input type="text" class="form-control" autofocus name = "nome" id="descricao" required value="<?php echo utf8_encode($nome); ?>" placeholder = "Descrição" maxlength = "100">			  
				</section>
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "alterar" class="btn btn-primary">Alterar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>
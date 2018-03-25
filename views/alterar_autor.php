<?php
	
	if($_SESSION['nivel_acesso'] == 2)
	{
		include("classes/class_editar_caracteres.php");
		include("classes/class_banco.php");
		include("classes/class_update.php");
		include("classes/class_pesquisar.php"); 

		$banco = new Banco();

		if(isset($_POST['alterar_autor']))
		{
			if(!empty($_GET['cod']))
			{
				$id = $_GET['cod'];

				$editar_id = new EditarCaracteres($id);
				$id = $editar_id->sanitizeNumber($_GET['cod']);

				if($id != "")
				{
					$pesquisar = new Pesquisar('tbl_autor','nome','id_autor = '.$id);
					$resposta = $pesquisar->pesquisar();
					$dados = mysql_fetch_assoc($resposta);
					$nome = $dados['nome'];	
				}
				else
				{
					
					echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
							<strong>Código inválido!</strong>
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
		else if(isset($_POST['alterar']))
		{			
			$id = $_POST['id_autor'];
			
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeString($_POST['id_autor']);
		
			$nome = $_POST['nome'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = utf8_decode($editar_nome->sanitizeStringNome($_POST['nome']));
			
			$campos = "nome = '".$nome."'";
			$condicao = "id_autor = ".$id;
			$alterar_autor= new Alterar("tbl_autor",$campos,$condicao);
			$resultado_autor = $alterar_autor->alterar();
			if($resultado_autor == 1)
			{
					echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Autor alterado com sucesso!</strong>
						</section>";		
			}
			else
			{
				
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao alterar autor.</strong> Tente novamente!
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
	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Alterar Autor</legend>
			<section class="form-group">
				<label for="inputID" class="col-md-2 control-label">ID:</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "id_autor" value="<?php echo $id; ?>" readonly id="inputID" placeholder = "ID" >
				</section>
				<label for="inputDescricao" class="col-md-2 control-label">Autor:</label>			  
				<section class="col-md-10">	 
					<input type="text" class="form-control"  name = "nome" value="<?php echo utf8_encode($nome); ?>" required placeholder = "Nome" maxlength = "100">			  
				</section>
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "alterar" class="btn btn-primary">Alterar</button>
					<input type = "reset" value = "Original" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>
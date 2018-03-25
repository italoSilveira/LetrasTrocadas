<?php

	if($_SESSION['nivel_acesso'] == 2)
	{	

		include("classes/class_editar_caracteres.php");
		include("classes/class_banco.php");
		include("classes/class_update.php");
		include("classes/class_pesquisar.php");

		$banco = new Banco();

		if(isset($_POST['alterar_editora']))
		{
			if(!empty($_GET['cod']))
			{
				$id = $_GET['cod'];

				$editar_id = new EditarCaracteres($id);
				$id = $editar_id->sanitizeNumber($_GET['cod']);

				if($id != "")
				{
					$pesquisar = new Pesquisar('tbl_editora','nome','id_editora = '.$id);
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
			$id = $_GET['id_editora'];
			
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeString($_GET['id_editora']);
		
			$nome = $_POST['nome'];
			
			$editar_nome = new EditarCaracteres($nome);
			$nome = utf8_decode($editar_nome->sanitizeStringNome($_POST['nome']));
		
			$campos = "nome = '".$nome."'";
			$condicao = "id_editora = ".$id;
			$alterar_editora= new Alterar("tbl_editora",$campos,$condicao);
			$resultado_editora = $alterar_editora->alterar();
			if($resultado_editora == 1)
			{
					echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Editora alterado com sucesso!</strong>
						</section>";		
			}
			else
			{
				
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao alterar editora.</strong> Tente novamente!
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

<article id  = "cadastro_usuario" style = "width: 60%; margin-left:20%;">
	<form class="form-horizontal" method = "post" action = "?url=alterar_editora&id_editora=<?php echo $id?>">
		<fieldset>
			<legend>Alterar Editora</legend>
			<section class="form-group">
				<label for="inputID" class="col-md-2 control-label">ID:</label>
				<section class="col-md-10">
					<input type="text" class="form-control" name = "id_editora" value="<?php echo $id?>" disabled placeholder = "ID" >	  
				</section>
				<br>
				<label for="inputDescricao" class="col-md-2 control-label">Editora:</label>
				<section class="col-md-10">	 
					<input type="text" class="form-control" autofocus value="<?php echo utf8_encode($nome) ;?>"  name = "nome" required placeholder = "Editora" maxlength = "100">			  
				</section>
				<br>						
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" name = "alterar" class="btn btn-primary">Alterar</button>
					<input type = "reset" value="Limpar" class="btn btn-default"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>
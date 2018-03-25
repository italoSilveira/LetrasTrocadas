<script src="scripts/MaskedInput.js" type="text/javascript"></script>
<script type="text/javascript">
	jQuery(function($){
	   $("#ISBN").mask("999-99-9999-999-9");
	});
</script>
<?php
	
	if($_SESSION['nivel_acesso'] == 2)
	{
		// Include na classes de conexão com o banco de dados
		include("classes/class_banco.php");
		include ("classes/class_pesquisar.php");
		include ("classes/class_insert.php");
		include ("classes/class_upload.php");
		include("classes/class_editar_caracteres.php");
		$banco_dados = new Banco();

		// Realiza as pesquisas para a gente poder preencher os combobox da página de cadastro livro do adm
		$pesquisar_editora = new Pesquisar("tbl_editora","*","1=1");
		$resultado_editora = $pesquisar_editora->pesquisar();
		
		$pesquisar_autor = new Pesquisar("tbl_autor","*","1=1");
		$resultado_autor = $pesquisar_autor->pesquisar();
		
		$pesquisar_genero = new Pesquisar("tbl_categoria","*","1=1");
		$resultado_genero = $pesquisar_genero->pesquisar();

		$nome = "";
		
		if(isset($_POST['cadastrarLivro']))
		{
			$nome = $_POST['nome'];
			$edicao = $_POST['edicao'];
			$isbn = $_POST['isbn'];
			$editora = $_POST['cmbEditora'];
			$autor = $_POST['cmbAutor'];
			$categoria = $_POST['cmbGenero'];
			$sinopse = $_POST['sinopse'];
			$numero_paginas = $_POST['numero_paginas'];

			$editar_nome_imagem = new EditarCaracteres($nome);
			$nome_p_imagem = utf8_decode($editar_nome_imagem->sanitizeString($_POST['nome']));

			$editar_nome = new EditarCaracteres($nome);
			$nome = utf8_decode($editar_nome->sanitizeStringNome($_POST['nome']));

			$editar_edicao = new EditarCaracteres($edicao);
			$edicao = $editar_edicao->sanitizeNumber($_POST['edicao']);

			$editar_isbn = new EditarCaracteres($isbn);
			$isbn = $editar_isbn->sanitizeNumber($_POST['isbn']);

			$editar_editora = new EditarCaracteres($editora);
			$editora = $editar_editora->sanitizeNumber($_POST['cmbEditora']);

			$editar_autor = new EditarCaracteres($autor);
			$autor = $editar_autor->sanitizeNumber($_POST['cmbAutor']);

			$editar_categoria = new EditarCaracteres($categoria);
			$categoria = $editar_categoria->sanitizeNumber($_POST['cmbGenero']);
			
			$editar_sinopse = new EditarCaracteres($sinopse);
			$sinopse = utf8_decode($editar_sinopse->sanitizeStringNome($_POST['sinopse']));
			
			$editar_numero_paginas = new EditarCaracteres($numero_paginas);
			$numero_paginas = $editar_numero_paginas->sanitizeNumber($_POST['numero_paginas']);	

			$pasta = "content/imagens/livros_gerais/";	
			$nome_original = $_FILES['file']['name'];	
			$ext = @end(explode(".", $nome_original));
			$upload = new Upload($_FILES['file'], 1000, 1000, $pasta);
			$nome_imagem = "capa_$nome_p_imagem";
			$caminho_cadastrar = $pasta."".$nome_imagem.".".$ext;
		   	$resposta_upload = @$upload->salvar_normal($nome_imagem);
			
			if($resposta_upload == "Sucesso")
			{
				$campos = "NULL,'$nome','$caminho_cadastrar',$edicao,'$isbn','$sinopse',1,0,0,0,$numero_paginas,$editora,$autor,$categoria";
				$cadastrar_livro = new Inserir("tbl_livro",$campos);
				$resultado_livro = $cadastrar_livro->inserir();
				if($resultado_livro == 1)
				{
					echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Livro cadastrador com sucesso!</strong>
					</section>";
				}
				else
				{
					echo '<section class="alert alert-dismissable alert-danger" style="width:40%;margin-left:30%;"">				  
						<strong>Erro ao cadastrar livro.</strong> Tente novamente!
					</section>';
				}
			}
			else
			{
				echo '<section class="alert alert-dismissable alert-danger" style="width:40%;margin-left:30%;"">				  
						<strong>'.$resposta_upload.'</strong>
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
<article id  = "body_cadastra_livro" style = "width:50%;position:relative;left:27%;">
	<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
		<fieldset>
			<legend>Cadastrar Livro</legend>
			<section class="form-group">
				<label for="inputNome" class="col-lg-2 control-label">Nome:</label>
				<section class="col-lg-9">
					<input type="text" class="form-control" name = "nome" required placeholder = "Nome do Livro" maxlength = "100">
				</section>
				<label for="inputEdicaolivro" class="col-lg-2 control-label">Edição:</label>				  
				<section class="col-lg-9">
					<input type="number" class="form-control" name = "edicao" id="inputEdicao" required placeholder = "Edição do livro" maxlength = "20" min = "0" max = "20000">
				</section>	 
				<label for="inputIsnblivro" class="col-lg-2 control-label">ISBN13:</label>
				<section class="col-lg-9">
					<input type="text" class="form-control" name="isbn" id="ISBN" required placeholder = "ISBN">				  
				</section>
				<label for="select" class="col-lg-2 control-label">Editora:</label>
				<section class="col-lg-9">
					<select class="form-control" name = "cmbEditora" id="select">
						<?php
							while($dados_editora = mysql_fetch_assoc($resultado_editora))
							{
								echo "<option value = ".$dados_editora['id_editora'].">".utf8_encode($dados_editora['nome'])."</option>";
							}
						?>
					</select>
				</section> 
				<label for="select" class="col-lg-2 control-label">Autor:</label>
				<section class="col-lg-9">
					<select class="form-control" name = "cmbAutor" id="select">
						<?php
							while($dados_autor = mysql_fetch_assoc($resultado_autor))
							{
								echo "<option value = ".$dados_autor['id_autor'].">".utf8_encode($dados_autor['nome'])."</option>";
							}
						?>
					</select>
				</section>
				<label for="select" class="col-lg-2 control-label">Gênero:</label>
				<section class="col-lg-9">
					<select class="form-control" name = "cmbGenero" id="select">
						<?php
							while($dados_genero = mysql_fetch_assoc($resultado_genero))
							{
								echo "<option value = ".$dados_genero['id_categoria'].">".utf8_encode($dados_genero['nome'])."</option>";
							}
						?>
					</select>
				</section>
				<label for="textArea" class="col-lg-2 control-label">Sinopse:</label>
				<section class="col-lg-9">
					<textarea class="form-control" rows="3" name="sinopse" id="textArea"></textarea>
				</section>
				<label for="inputEdicaolivro" class="col-lg-2 control-label">Páginas:</label>				  
				<section class="col-lg-9">
					<input type="number" class="form-control" name = "numero_paginas" id="inputNumeros" required placeholder = "Números de páginas" maxlength = "20" min = "0" max = "20000">
				</section>
				<label for="inputFotolivro" class="col-lg-2 control-label">Foto: </label>
				<section class="col-lg-9">
					<input type="file"  name="file" required />
				</section>
				<section class="col-lg-9 col-lg-offset-2">                    
					<button type="submit" name = "cadastrarLivro" class="btn btn-primary">Cadastrar</button>
					<button type = "reset" class="btn btn-default">Cancelar</button>
				</section>
			</section>
		</fieldset>
	</form>
	</article>
</article>

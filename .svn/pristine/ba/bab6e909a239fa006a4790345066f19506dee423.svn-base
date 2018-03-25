<?php																								
	
	if($_SESSION['nivel_acesso'] == 2)
	{
		// Include na classes de conexão com o banco de dados
		include ("classes/class_banco.php");
		include ("classes/class_pesquisar.php");
		include ("classes/class_editar_caracteres.php");
		include ("classes/class_update.php");
		
		$banco_dados = new Banco();		
		
		$pesquisar_editora = new Pesquisar("tbl_editora","*","1=1");
		$resultado_editora = $pesquisar_editora->pesquisar();

		$pesquisar_autor = new Pesquisar("tbl_autor","*","1=1");
		$resultado_autor = $pesquisar_autor->pesquisar();

		$pesquisar_genero = new Pesquisar("tbl_categoria","*","1=1");
		$resultado_genero = $pesquisar_genero->pesquisar();
		
		if(isset($_POST['alterar']))
		{			
			
			$id = $_POST['id_livro'];
			
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeString($_POST['id_livro']);

			if($id != "")
			{
				$nome = $_POST['nome'];
				$edicao = $_POST['edicao'];
				$isbn = $_POST['isbn'];
				$editora = $_POST['cmbEditora'];
				$autor = $_POST['cmbAutor'];
				$categoria = $_POST['cmbGenero'];
				$sinopse = $_POST['sinopse'];
				$numero_paginas = $_POST['numero_paginas'];

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
			
				$campos = "nome = '$nome', edicao = $edicao, isbn = '$isbn', editora_id = $editora, autor_id = $autor, categoria_id = $categoria, sinopse = '$sinopse', numero_paginas = $numero_paginas ";
				$codição = "id_livro = ".$id;
				$alterar_livro = new Alterar("tbl_livro",$campos,$codição);
				$resultado_livro = $alterar_livro->alterar();
				if($resultado_livro == 1)
				{
					echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<strong>Livro alterado com sucesso!</strong>
					</section>";

					$id = $_GET['cod'];
			
					$editar_id = new EditarCaracteres($id);
					$id = $editar_id->sanitizeNumber($_GET['cod']);
					
					$tabelas = "tbl_livro";
					$campos="id_livro,nome, edicao,imagem_livros, isbn, sinopse, numero_paginas, editora_id, autor_id, categoria_id";
					$condicao = "id_livro = ".$id;
					
					$pesquisar_livro = new Pesquisar($tabelas,$campos,$condicao);
					$resultado = $pesquisar_livro->pesquisar();			
					
					while($pesquisar_livro=mysql_fetch_assoc($resultado))
					{
						$tabelas = "tbl_categoria";
						$campos="nome";
						$condicao = "id_categoria = ".$pesquisar_livro['categoria_id'];
						
						$pesquisar_categoria = new Pesquisar($tabelas,$campos,$condicao);
						$categoria_nome = $pesquisar_categoria->pesquisar();

						$dados = mysql_fetch_assoc($categoria_nome);
						$categoria_nome = $dados['nome'];
						
						$tabelas = "tbl_autor";
						$campos="nome";
						$condicao = "id_autor = ".$pesquisar_livro['autor_id'];
						
						$pesquisar_autor = new Pesquisar($tabelas,$campos,$condicao);
						$autor_nome = $pesquisar_autor->pesquisar();

						$dados = mysql_fetch_assoc($autor_nome);
						$autor_nome = $dados['nome'];
						
						$tabelas = "tbl_editora";
						$campos="nome";
						$condicao = "id_editora = ".$pesquisar_livro['editora_id'];
						
						$pesquisar_editora = new Pesquisar($tabelas,$campos,$condicao);
						$editora_nome = $pesquisar_editora->pesquisar();

						$dados = mysql_fetch_assoc($editora_nome);
						$editora_nome = $dados['nome'];
						
						$id = $pesquisar_livro['id_livro'];
						$nome = $pesquisar_livro['nome'];
						$edicao = $pesquisar_livro['edicao'];
						$isbn = $pesquisar_livro['isbn'];
						$sinopse = $pesquisar_livro['sinopse'];
						$numero_paginas = $pesquisar_livro['numero_paginas'];
						$imagem = $pesquisar_livro['imagem_livros'];
					}
				}
				else
				{
					echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Erro ao alterar livro.</strong> Tente novamente!
					</section>";
				}
			}
			else
			{
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
							<strong>Código inválido!</strong>
					</section>";
			}
		}
		else if(isset($_POST['alterar_livro']))
		{
			$id = $_GET['cod'];
			
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeNumber($_GET['cod']);
			
			$tabelas = "tbl_livro";
			$campos="id_livro,nome, edicao,imagem_livros, isbn, sinopse, numero_paginas, editora_id, autor_id, categoria_id";
			$condicao = "id_livro = ".$id;
			
			$pesquisar_livro = new Pesquisar($tabelas,$campos,$condicao);
			$resultado = $pesquisar_livro->pesquisar();			
			
			while($pesquisar_livro=mysql_fetch_assoc($resultado))
			{
				$tabelas = "tbl_categoria";
				$campos="nome";
				$condicao = "id_categoria = ".$pesquisar_livro['categoria_id'];
				
				$pesquisar_categoria = new Pesquisar($tabelas,$campos,$condicao);
				$categoria_nome = $pesquisar_categoria->pesquisar();

				$dados = mysql_fetch_assoc($categoria_nome);
				$categoria_nome = $dados['nome'];
				
				$tabelas = "tbl_autor";
				$campos="nome";
				$condicao = "id_autor = ".$pesquisar_livro['autor_id'];
				
				$pesquisar_autor = new Pesquisar($tabelas,$campos,$condicao);
				$autor_nome = $pesquisar_autor->pesquisar();

				$dados = mysql_fetch_assoc($autor_nome);
				$autor_nome = $dados['nome'];
				
				$tabelas = "tbl_editora";
				$campos="nome";
				$condicao = "id_editora = ".$pesquisar_livro['editora_id'];
				
				$pesquisar_editora = new Pesquisar($tabelas,$campos,$condicao);
				$editora_nome = $pesquisar_editora->pesquisar();

				$dados = mysql_fetch_assoc($editora_nome);
				$editora_nome = $dados['nome'];
				
				$id = $pesquisar_livro['id_livro'];
				$nome = $pesquisar_livro['nome'];
				$edicao = $pesquisar_livro['edicao'];
				$isbn = $pesquisar_livro['isbn'];
				$sinopse = $pesquisar_livro['sinopse'];
				$numero_paginas = $pesquisar_livro['numero_paginas'];
				$imagem = $pesquisar_livro['imagem_livros'];
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
<script>
	var UploadFoto = function()
	{
		$("#alterar_livro").ajaxSubmit(
			{
				url: 'ajax/upload.php', 
				type: 'post',					
				dataType  : "json",
				success : function( data ){RetornaImagem(data.caminho,data.caminho_a);},
				resetForm : false
			}
		);
	}

	var RetornaImagem = function(caminho,outro){
		$.post("ajax/abre_imagem.php",{caminho : caminho}, function(data){
				$("#img_perfil").attr("src", data.imagem);
				$("#caminho").attr("value", outro);
			}
		);
	}
</script>
<article id  = "body_cadastra_livro" style = "width:50%;position:relative;left:27%;">
	<form id = "alterar_livro" class="form-horizontal" method="post" action="" enctype="multipart/form-data">
		<fieldset>
			<legend>Alterar Livro</legend>
			<section class="form-group">
				<center>	
			        <label class="col-md-2 control-label">Para alterar a foto, clique na imagem.</label>
					<img alt="" id="img_perfil" class = "thumbnail" style="cursor:pointer;" onclick="$('#file').click();" src = "<?=$imagem?>">
					<input type="text" value = "<?=$imagem?>" style="visibility:hidden;" name="caminho" id="caminho" class="btn btn-primary btn-sm"/>
					<input type="file" style="visibility:hidden;" name="file" onchange="UploadFoto();" id="file" class="btn btn-primary btn-sm"/>
				</center>
			</section>
			<section class="form-group">
				<input type="text" class="form-control" name = "id_livro" value="<?php echo $id ;?>" placeholder = "ID" style= "display:none">
				<label for="inputNome" class="col-lg-2 control-label">Nome:</label>
				<section class="col-lg-9">
					<input type="text" class="form-control" value="<?php echo utf8_encode($nome) ;?>" name = "nome" required placeholder = "Nome do Livro" maxlength = "100">
				</section>
				<label for="inputEdicaolivro" class="col-lg-2 control-label">Edição:</label>				  
				<section class="col-lg-9">
					<input type="number" class="form-control" value="<?php echo $edicao ;?>" name = "edicao" id="inputEdicao" required placeholder = "Edição do livro" maxlength = "20" min = "0" max = "20000">
				</section>	 
				<label for="inputIsnblivro" class="col-lg-2 control-label">ISBN:</label>
				<section class="col-lg-9">
					<input type="text" class="form-control" value="<?php echo $isbn ;?>" name="isbn" id="inputISBN" required maxlength = "17" placeholder = "ISBN">				  
				</section>
				<label for="select" class="col-lg-2 control-label">Editora:</label>
				<section class="col-lg-9">
					<select class="form-control" name = "cmbEditora" id="select">
						<?php
							while($dados_editora = mysql_fetch_assoc($resultado_editora))
							{
								$selected = selected($editora_nome,$dados_editora['nome']);

								echo "<option value = ".$dados_editora['id_editora']."".$selected.">".utf8_encode($dados_editora['nome'])."</option>";
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
								$selected = selected($autor_nome,$dados_autor['nome']);

								echo "<option value = ".$dados_autor['id_autor']."".$selected.">".utf8_encode($dados_autor['nome'])."</option>";
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
								$selected = selected($categoria_nome,$dados_genero['nome']);

								echo "<option value = ".$dados_genero['id_categoria']."".$selected.">".utf8_encode($dados_genero['nome'])."</option>";
							}
						?>
					</select>
				</section>
				<label for="textArea" class="col-lg-2 control-label">Sinopse:</label>
				<section class="col-lg-9">
					<textarea class="form-control" rows="3" name="sinopse" id="textArea"><?php echo utf8_encode($sinopse); ?></textarea>
				</section>
				<label for="inputEdicaolivro" class="col-lg-2 control-label">Páginas:</label>				  
				<section class="col-lg-9">
					<input type="number" class="form-control" value="<?php echo $numero_paginas ;?>" name = "numero_paginas" id="inputNumeros" required placeholder = "Números de páginas" maxlength = "20" min = "0" max = "20000">
				</section>
				<section class="col-lg-9 col-lg-offset-2">                    
					<button style="margin-left: 5px; float:right;" type="submit" name = "alterar" class="btn btn-primary">Alterar</button>
					<button style="float:right;" type = "reset" class="btn btn-default">Cancelar</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>


<?php

	//Verifica se o usuário tem acesso à essa página
	if($_SESSION['nivel_acesso'] == 1)
	{ 
		include("classes/class_editar_caracteres.php");
		include("classes/class_pesquisar.php");
		include("classes/class_banco.php");
		include("classes/class_update.php");
		
		$bd = new Banco();
		
		$id = $_GET['cod'];
		$lista = $_GET['lista'];
		
		$editar_id = new EditarCaracteres($id);
		$id = $editar_id->sanitizeString($_GET['cod']);
		
		if(isset($_POST['alterar_livro_usuario']))
		{
			//Pasta onde vai ser salvo
			$pasta = 'content/imagens/livro_usuario/';
			
			//Tipo de imagens permitidos
			$permite = array('image/jpg','image/jpeg');//'image/pjpeg'
			
			//Pegando a imagem enviada pelo formulário
			$imagem_primeira = $_FILES['primeira_foto'];
			//Não entendi isso mas eu sei que precisa 
			$destino_primeira = $imagem_primeira['tmp_name'];
			//Nome do arquivo
			$nome_primeira = $imagem_primeira['name'];
			//Tipo do arquivo
			$tipo_primeira = $imagem_primeira['type'];
			
			$imagem_segunda = $_FILES['segunda_foto'];
			$destino_segunda = $imagem_segunda['tmp_name'];
			$nome_segunda = $imagem_segunda['name'];
			$tipo_segunda = $imagem_segunda['type'];
			
			$imagem_terceira = $_FILES['terceira_foto'];
			$destino_terceira = $imagem_terceira['tmp_name'];
			$nome_terceira = $imagem_terceira['name'];
			$tipo_terceira = $imagem_terceira['type'];
		
			//Chama a classe de upload
			include("classes/class_upload.php");
			
			if(!empty($nome_primeira) && in_array($tipo_primeira, $permite))
			{
				//Evetua o upload
				upload($destino_primeira, $nome_primeira, 120, $pasta);
				
				if(!empty($nome_segunda) && in_array($tipo_segunda, $permite))
				{
					upload($destino_segunda, $nome_segunda, 120, $pasta);
					
					if(!empty($nome_terceira) && in_array($tipo_terceira, $permite))
					{
						upload($destino_terceira, $nome_terceira, 120, $pasta);
						
						$ano = $_POST['ano'];
						$estado = $_POST['estado'];
						
						$editar_ano = new EditarCaracteres($ano);
						$ano = $editar_ano->sanitizeString($_POST['ano']);
						
						$editar_estado = new EditarCaracteres($estado);
						$estado = $editar_estado->sanitizeStringNome($_POST['estado']);
						
						$estado = utf8_decode($estado);
						
						$campos = "ano = '".$ano."', estado = '".$estado."'";
						$codição = "id_lista_livros = ".$id;
						$alterar_lista_livro = new Alterar("tbl_lista_livros",$campos,$codição);
						$resultado_lista_livro = $alterar_lista_livro->alterar();
						if($resultado_lista_livro == 1)
						{
							$primeira_foto = $pasta."".$nome_primeira;
							$segunda_foto = $pasta."".$nome_segunda;
							$terceira_foto = $pasta."".$nome_terceira;
							
							$campos = "primeira_foto = '".$primeira_foto."', segunda_foto = '".$segunda_foto."', terceira_foto = '".$terceira_foto."'";
							$codição = "lista_livro_id = ".$id;
							$alterar_fotos_livro = new Alterar("tbl_fotos_livros",$campos,$codição);
							$resultado_fotos_livro = $alterar_fotos_livro->alterar();
							if($resultado_fotos_livro == 1)
							{
								echo "Seu livro foi alterado com sucesso!";
								unlink("content/imagens/livro_usuario/".$_SESSION['foto_original_1']);
								unlink("content/imagens/livro_usuario/".$_SESSION['foto_original_2']);
								unlink("content/imagens/livro_usuario/".$_SESSION['foto_original_3']);
							}
							else
							{
								unlink("content/imagens/livro_usuario/$nome_primeira");
								unlink("content/imagens/livro_usuario/$nome_segunda");
								unlink("content/imagens/livro_usuario/$nome_terceira");
								echo "Erro ao alterar suas fotos no banco de dados";
							}
						}
						else
						{
							unlink("content/imagens/livro_usuario/$nome_primeira");
							unlink("content/imagens/livro_usuario/$nome_segunda");
							unlink("content/imagens/livro_usuario/$nome_terceira");
							echo "Erro ao alterar sua lista de livros no banco de dados";
						}
					}
					else
					{
						echo "Aceitamos apensa imagens no formato JPEG";
						unlink("content/imagens/livro_usuario/$nome_primeira");
						unlink("content/imagens/livro_usuario/$nome_segunda");
					}
				}
				else
				{
					echo "Aceitamos apensa imagens no formato JPEG";
					unlink("content/imagens/livro_usuario/$nome_primeira");
				}
			}
			else
			{
				echo "Aceitamos apensa imagens no formato JPEG";
			}		
		}
		
		$tabelas = "tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria INNER JOIN tbl_lista_livros INNER JOIN tbl_fotos_livros ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id AND id_livro = livro_id AND id_lista_livros = lista_livro_id";
		$campos=" primeira_foto,segunda_foto,terceira_foto,livro.nome As livro,edicao,isbn,imagem_livros,numero_paginas,estado,ano,autor.nome As autor,editora.nome As editora,categoria.nome As categoria";
		
		$pesquisar_livro = new Pesquisar($tabelas,$campos,"id_livro = $id LIMIT 1");
		$resultado = $pesquisar_livro->pesquisar();
		
		$dados=mysql_fetch_assoc($resultado);
		
		$imagem = $dados['imagem_livros'];
		$num_paginas = $dados['numero_paginas'];
		$autor = $dados['autor'];
		$editora = $dados['editora'];
		$categoria = $dados['categoria'];
		$nome = $dados['livro'];
		$ano = $dados['ano'];
		$edicao = $dados['edicao'];
		$isbn = $dados['isbn'];
		$estado = $dados['estado'];
		$primeira_foto = $dados['primeira_foto'];
		$segunda_foto = $dados['segunda_foto'];
		$terceira_foto = $dados['terceira_foto'];
		
		if(empty($_POST['alterar_livro_usuario']))
		{
			$_SESSION['foto_original_1'] = $primeira_foto;
			$_SESSION['foto_original_2'] = $segunda_foto;
			$_SESSION['foto_original_3'] = $terceira_foto;
		}
		
		$data = date('Y');
		
	}
	else
	{	
		//Emite um alerta (não tá funcioando ¬¬) pois eles não tem acesso a essa página
		echo "
			<script type='text/javascript'>
				alert('Você não tem permissão para acessar essa página');
			</script>";
		
		//Redireciona pra página principal
		if($_SESSION['nivel_acesso'] == 2)
		{
			header("location: ?url=home_admin");
		}
		else
		{
			header("location: ?url=home_visitante");
		}
	}
?>

<script>
	var UploadFotoPrimeira = function()
	{	
		$("#frm_upload").ajaxSubmit(
			{
				url: 'ajax/upload.php', 
				type: 'post',					
				dataType  : "json",
				success : function( data ){RetornaImagem(data.caminho,data.caminho_a);},
				resetForm : false
			}
		);	
	}
	
	var UploadFotoSegunda = function()
	{	
		$("#frm_upload").ajaxSubmit(
			{
				url: 'ajax/upload.php', 
				type: 'post',					
				dataType  : "json",
				success : function( data ){RetornaImagem(data.caminho,data.caminho_a);},
				resetForm : false
			}
		);	
	}
	
	var UploadFotoTerceira = function()
	{	
		$("#frm_upload").ajaxSubmit(
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
			alert(data.nome);
				$("#primeira_imagem").attr("src", data.imagem);
				$("#caminho_primeira").attr("value", outro);
			}
		);
	}
</script>
<article id  = "body_cadastra_livro_usu" style = "width:50%;height:60%;position:relative;left:20%;">
	<form name="frm_upload" class="form-horizontal" method="post" action="?url=alterar_livro_usuario&cod=<?php echo $id;?>&lista=<?php echo $lista;?>"  enctype="multipart/form-data">
		<fieldset>
			<legend>Alterar Livros</legend>	
			<section class="form-group" style="position:relative;left:5%;">
				<section class="col-md-6" style="left:7%;">
					<section class="thumbnail">
							<img src="<?php echo $imagem;?>" alt="" width="35%">
							<p align="center"></p> 
					</section>
				</section>
				<section class="col-md-10">
					<label for="Nome" class="col-md-2 control-label">Nome:</label>		
					<input type="text" class="form-control" value="<?php echo $nome ;?>" rows="3" name = "nome" required style = "width: 50%;"id="Nome" readonly ></input>
					<label for="Edicao" class="col-md-2 control-label">Edição:</label>
					<input type="text" class="form-control" value="<?php echo $edicao ;?>" rows="3" name = "edicao" required style = "width: 50%;"id="Edicao" readonly ></input> 
					<label for="Numero" class="col-md-2 control-label">Páginas:</label>
					<input type="text" class="form-control" value="<?php echo $num_paginas ;?>" rows="3" name = "num_paginas" required style = "width: 50%;"id="Edicao" readonly ></input> 
					<label for="ISBN" class="col-md-2 control-label">ISBN:</label>
					<input type="text" class="form-control" rows="3" value="<?php echo $isbn ;?>" name = "isbn" required style = "width: 50%;"id="ISBN" readonly ></input> 
					<label for="Autor" class="col-md-2 control-label">Autor:</label>
					<input type="text" class="form-control" rows="3" value="<?php echo $autor ;?>" name = "autor" required style = "width: 50%;"id="ISBN" readonly ></input> 
					<label for="Editora" class="col-md-2 control-label">Editora:</label>
					<input type="text" class="form-control" rows="3" value="<?php echo $editora ;?>" name = "editora" required style = "width: 50%;"id="ISBN" readonly ></input> 
					<label for="Categoria" class="col-md-2 control-label">Categoria:</label>
					<input type="text" class="form-control" rows="3" value="<?php echo $categoria ;?>" name = "categoria" required style = "width: 50%;"id="ISBN" readonly ></input> 
					<label for="textArea" class="col-md-2 control-label">Estado:</label>
					<textarea class="form-control" name = "estado" rows="3" required style = "width: 50%;" id="textArea" placeholder = "Escreva aqui as condições do livro que deseja disponibilizar(danos, observações, adicionais)"><?php echo utf8_encode($estado);?></textarea> 
					<label for="txtAno" class="col-md-2 control-label">Ano:</label>
					<input type="number" min = "1455" max="<?php echo $data;?>" class="form-control" value = "<?php echo $ano;?>" required name = "ano" id = "txtAno" rows="3" style = "width: 50%;" placeholder = "Ano da fabricação"/>
					<?php
						$aspas = "'";
						echo '
							<label class="col-md-2 control-label">Suas fotos :</label>
							
							<img alt="" id="primeira_imagem" class = "thumbnail" style="cursor:pointer;" onclick="$('.$aspas.'#file_primeira'.$aspas.').click();" src = "'.$primeira_foto.'">
							
							<img alt="" id="segunda_imagem" class = "thumbnail" style="cursor:pointer;" onclick="$('.$aspas.'#file_segunda'.$aspas.').click();" src = "'.$segunda_foto.'">
							
							<img alt="" id="terceira_imagem" class = "thumbnail" style="cursor:pointer;" onclick="$('.$aspas.'#file_terceira'.$aspas.').click();" src = "'.$terceira_foto.'">
							
							<input type="file" style="visibility:hidden;" name="file_primeira" onchange="UploadFotoPrimeira();" id="file_primeira" class="btn btn-primary btn-sm"/>
							<input type="text" value = "'.$primeira_foto.'" style="visibility:hidden;" name="caminho_primeira" id="caminho_primeira" class="btn btn-primary btn-sm"/>
							
							<input type="file" style="visibility:hidden;" name="file_segunda" onchange="UploadFotoSegunda();" id="file_segunda" class="btn btn-primary btn-sm"/>
							<input type="text" value = "'.$segunda_foto.'" style="visibility:hidden;" name="caminho_segunda" id="caminho_segunda" class="btn btn-primary btn-sm"/>
							
							<input type="file" style="visibility:hidden;" name="file_terceira" onchange="UploadFotoTerceira();" id="file_terceira" class="btn btn-primary btn-sm"/>
							<input type="text" value = "'.$terceira_foto.'" style="visibility:hidden;" name="caminho_terceira" id="caminho_terceira" class="btn btn-primary btn-sm"/>
						';
					?>
				</section>
			</section> 
			<section class="col-md-10 col-md-offset-2">
				<button type="submit" name = "alterar_livro_usuario" value ="Alterar" class="btn btn-primary">Alterar</button>
				<button type = "reset"class="btn btn-default" value="Limpar"/>
			</section>
		</fieldset>
	</form>
</article>
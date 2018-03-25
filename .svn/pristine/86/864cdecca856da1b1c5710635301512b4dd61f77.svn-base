<?php
	if($_SESSION['nivel_acesso'] == 1)
	{
		if($_SESSION['status'] == 4)
		{
			include("classes/class_editar_caracteres.php");
			include("classes/class_pesquisar.php");
			include("classes/class_banco.php");
			include("classes/class_upload.php");
			
			$bd = new Banco();
			
			$id = $_GET['cod'];
			
			if(isset($_POST['cadastrarLivroUsuario']))
			{	
				$pasta = "content/imagens/livro_usuario/";

				$nome = $_POST['nome'];
				$estado = $_POST['estado'];
				$creditos = $_POST['creditos'];
				$ano = $_POST['ano'];

				$editar_nome = new EditarCaracteres($nome);
				$nome = $editar_nome->sanitizeString($_POST['nome']);

				$editar_estado = new EditarCaracteres($estado);
				$estado = $editar_estado->sanitizeString($_POST['estado']);

				$editar_ano = new EditarCaracteres($ano);
				$ano = $editar_ano->sanitizeString($_POST['ano']);

				$pesquisar = new Pesquisar('tbl_lista_livros','MAX(id_lista_livros) as quantidade','1=1');
				$resultado = $pesquisar->pesquisar();

				$ultimos = mysql_fetch_assoc($resultado);

				if(empty($ultimos['quantidade']))
				{
					$ultimo = 0;
				}
				else
				{
					$ultimo = $ultimos['quantidade'];
				}

				if(!empty($_FILES['primeira_foto']))
				{	
					$ultimo++;
					$nome_original = $_FILES['primeira_foto']['name'];	
					$ext = @end(explode(".", $nome_original));
					$upload = new Upload($_FILES['primeira_foto'], 1000, 1000, $pasta);
					$nome_imagem = "$nome_fotos_$ultimo";
					$caminho_cadastrar = $pasta."".$nome_imagem.".".$ext;
				   	$resposta_upload = @$upload->salvar_normal($nome_imagem);

				   	if($resposta_upload == "Sucesso")
					{
						$foto_1 = $caminho_cadastrar;
					}
					else
					{
						$foto_1 = '';
					}
				}
				else
				{
					$foto_1 = '';
				}

				if(!empty($_FILES['segunda_foto']))
				{
					$ultimo++;
					$nome_original = $_FILES['segunda_foto']['name'];	
					$ext = @end(explode(".", $nome_original));
					$upload = new Upload($_FILES['segunda_foto'], 1000, 1000, $pasta);
					$nome_imagem = "$nome_fotos_$ultimo";
					$caminho_cadastrar = $pasta."".$nome_imagem.".".$ext;
				   	$resposta_upload = @$upload->salvar_normal($nome_imagem);

				   	if($resposta_upload == "Sucesso")
					{
						$foto_2 = $caminho_cadastrar;
					}
					else
					{
						$foto_2 = '';
					}
				}
				else
				{
					$foto_2 = '';
				}

				if(!empty($_FILES['terceira_foto']))
				{
					$ultimo++;
					$nome_original = $_FILES['terceira_foto']['name'];	
					$ext = @end(explode(".", $nome_original));
					$upload = new Upload($_FILES['terceira_foto'], 1000, 1000, $pasta);
					$nome_imagem = "$nome_fotos_$ultimo";
					$caminho_cadastrar = $pasta."".$nome_imagem.".".$ext;
				   	$resposta_upload = @$upload->salvar_normal($nome_imagem);

				   	if($resposta_upload == "Sucesso")
					{
						$foto_3 = $caminho_cadastrar;
					}
					else
					{
						$foto_3 = '';
					}
				}
				else
				{
					$foto_3 = '';
				}

				$_SESSION['estado'] = $estado;
				$_SESSION['creditos'] = $creditos;
				$_SESSION['ano'] = $ano;
				$_SESSION['imagem1'] = $foto_1;
				$_SESSION['imagem2'] = $foto_2;
				$_SESSION['imagem3'] = $foto_3;

				header('Location:?url=passo-a-passo-confirmar-dados&cod='.$id);
			}
			
			$editar_id = new EditarCaracteres($id);
			$id = $editar_id->sanitizeString($_GET['cod']);
			
			$pesquisar_livro = new Pesquisar("tbl_livro livro JOIN tbl_categoria categoria ON id_categoria = categoria_id","creditos,livro.nome as nome,edicao,isbn"," id_livro = '$id' LIMIT 1");
			$resultado = $pesquisar_livro->pesquisar();
			
			while($resposta=mysql_fetch_assoc($resultado))
			{
				$nome = $resposta['nome'];
				$edicao = $resposta['edicao'];
				$isbn = $resposta['isbn'];
				$creditos = $resposta['creditos'];
			}	
?>

<article id  = "body_cadastra_livro_usu" style = "width:60%;height:60%;position:relative;left:30%;">
	<form class="form-horizontal" method="post" action=""  enctype="multipart/form-data">
		<fieldset>
			<legend>Cadastrar livro</legend>
			<section class="form-group">
				<label for="Nome" class="col-lg-2 control-label">Nome:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" value="<?php echo utf8_encode($nome) ;?>" rows="3" name = "nome" required style = "width: 50%;"id="Nome" readonly ></input> 
				</section>
				<label for="Edicao" class="col-lg-2 control-label">Edição:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" value="<?php echo $edicao ;?>" rows="3" name = "edicao" required style = "width: 50%;"id="Edicao" readonly ></input> 
				</section>
				<label for="ISBN" class="col-lg-2 control-label">ISBN:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" rows="3" value="<?php echo $isbn ;?>" name = "isbn" required style = "width: 50%;"id="ISBN" readonly ></input> 
				</section>
				<label for="Creditos" class="col-lg-2 control-label">Créditos:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" rows="3" value="<?php echo $creditos ;?>" name = "creditos" required style = "width: 50%;" id="Creditos" readonly ></input> 
				</section>
				<label for="textArea" class="col-lg-2 control-label">Estado:</label>
				<section class="col-lg-10">
					<textarea class="form-control" name = "estado" rows="3" required style = "width: 50%;"id="textArea" placeholder = "Escreva aqui as condições do livro que deseja disponibilizar(danos, observações, adicionais)"></textarea> 
				</section>
				<label for="txtAno" class="col-lg-2 control-label">Ano:</label>
				<section class="col-lg-10">
					<input type="number" min = "1455" max="2014" class="form-control" required name = "ano" id = "txtAno" rows="3" style = "width: 50%;" placeholder = "Ano da edição"/>
				</section>
				<label for="inputFotolivro" class="col-lg-6 control-label">Você pode adicionar as fotos dos seu livro! </label>
				<section style = "position:relative; width:25%; height: 5%;left:20%;top:2%; ">		
					<section class="col-lg-10">
						<input type="file" id="inputFoto1" name="primeira_foto" >
					</section><br>
					<section class="col-lg-10">
						<input type="file" id="inputFoto2" name="segunda_foto">
					</section><br>
					<section class="col-lg-10">
						<input type="file" id="inputFoto3" name="terceira_foto" >
					</section>
				</section>
				<br>
				<section class="col-lg-10 col-lg-offset-2">
					<br>
					<button type = "reset"class="btn btn-default">Limpar</button>
					<button type="submit" name = "cadastrarLivroUsuario" class="btn btn-primary">Cadastrar</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>
<?php

		}
		else
		{
			echo '<section class="alert alert-dismissable alert-info" style="width:40%;margin-left:30%";>
				<strong>Você precisa completar seu <a href="?url=alterar_dados_perfil">perfil</a> para disponibilizar um livo!</strong>
			</section>';
		}
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 2)
		{
			header('Location:?url=home_admin');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}

?>
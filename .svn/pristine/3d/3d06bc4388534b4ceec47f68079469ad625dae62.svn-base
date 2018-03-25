<script type="text/javascript">
    function EditarComentario(publicacao)
    {
		$.ajax({
	            // url para o arquivo json.php
	                    url : "ajax/edita_comentario.php?id="+publicacao,
	            // dataType json
	                    dataType : "json",
	            success : function(data){
	                document.getElementById('myModal').innerHTML =  data.section;
	                $('#myModal').modal('show');
	            },
	            error : function(data){
	                alert("Ops! Ocorreu um erro, tente mais tarde.");
	            }	
		});
    }
</script>
<?php
	include("classes/class_editar_caracteres.php");
	include("classes/class_banco.php");
	include("classes/class_pesquisar.php");
	include("classes/class_insert.php");
	include("classes/class_update.php");
	include("classes/class_delete.php");

	$bd = new Banco(); 

	if(isset($_POST['excluirComentario']))
	{
		$id_comentario = $_POST['id_coments'];

		$editar_comentário = new Deletar('tbl_comentarios',"id_comentario = $id_comentario");
		$resultado_coment = $editar_comentário->deletar();
	}

	if(isset($_POST['editar_coments']))
	{
		$id_comentario = $_POST['id_coments'];
		$edit_coment =  $_POST['coment'];

		$editar_comenta = new EditarCaracteres($edit_coment);
		$edit_coment = $editar_comenta->sanitizeStringNome($edit_coment);

		$editar_comentário = new Alterar('tbl_comentarios',"comentario = '$edit_coment'",'id_comentario = '.$id_comentario);
		$resultado_coment = $editar_comentário->alterar();
	}

	if(!empty($_GET['livro']))
	{
		$aspas = "'";
		$id_livro = $_GET['livro'];

		$editar_id = new EditarCaracteres($id_livro);
		$id_livro = $editar_id->sanitizeNumber($_GET['livro']);

		if($id_livro != "")
		{

			if(isset($_POST['Comentar']))
			{
				$coment = $_POST['comentario'];

				$editar_coment = new EditarCaracteres($coment);
				$coment = $editar_coment->sanitizeStringNome($_POST['comentario']);

				if($coment != "")
				{
					$cadastrar_comentario = new Inserir('tbl_comentarios','NULL,'.$_SESSION['id'].','.$id_livro.',"'.utf8_decode($coment).'",NULL');
					$resultado = $cadastrar_comentario->inserir();
					if($resultado != 1)
					{
						echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
									<strong>Alguma coisa deu errado! Por favor, tente mais tarde.</strong>
								</section>";
					}
				}
			}

			$campos_lista = "COUNT(id_livro) as qt";
			$tabelas_lista = "tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id";
			$condição_lista = "id_livro = $id_livro LIMIT 1";

			$pesquisar_qt = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_qt = $pesquisar_qt->pesquisar();

			$array = mysql_fetch_assoc($resultado_qt);
			$quantidade = $array['qt'];

			if($quantidade >=1)
			{
				$campos_lista = "livro.*,autor.nome AS Autor,categoria.nome as Categoria,editora.nome As Editora";
				$tabelas_lista = "tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id";
				$condição_lista = "id_livro = $id_livro LIMIT 1";

				$pesquisar_livro = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
				$resultado = $pesquisar_livro->pesquisar();

				$pesquisar_comentario = new Pesquisar('tbl_comentarios JOIN tbl_usuario ON id_usuario = usuario_id','nome,tbl_comentarios.*','livro_id ='.$id_livro);
				$comentarios = $pesquisar_comentario->pesquisar();

?>
<article id = "body_livros_autores" style="margin-left: 8%;margin-right: 8%;">
	<section class="panel panel-default">
		<section class="panel-body">
			<?php

				while($livro = mysql_fetch_assoc($resultado))
				{
					echo '
						<section class = "row">
							<section class = "col-md-2">
								<section class = "bs-component" style="width:50%;">
									<img style="height:177px; width: 130px;" src = "'.$livro['imagem_livros'].'" alt = "'.utf8_encode($livro['nome']).'" height = "177px" width = "120px">
								</section>
							</section>
							<section class = "col-md-3">
								<a><h3>'.utf8_encode($livro['nome']).'</h3></a>				  
								<a><h4>'.utf8_encode($livro['Autor']).'</h4></a>
								<a><h5>'.utf8_encode($livro['Editora']).'</h5></a>
							</section>
							<section class = "col-md-7">
								<textarea class="form-control" rows="9" style="background-color:white;" readonly>
									'.utf8_encode($livro['sinopse']).'
								</textarea>
							</section> 
						</section>
						<br/>
						<section class="row">
							<table class="table table-striped table-hover ">
								<thead>
									<tr>
										<th>Outros Dados:</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>ISBN:</td>
										<td>'.$livro['isbn'].'</td>
									</tr>
									<tr class="success">
										<td>Gênero:</td>
										<td>'.$livro['Categoria'].'</td>
									</tr>
									<tr>
										<td>Nº de pessoas lendo:</td>
										<td>'.$livro['lendo'].'</td>
									</tr>
									<tr class="success">
										<td>Nº de pessoas querendo ler:</td>
										<td>'.$livro['querem_ler'].'</td>
									</tr>
									<tr>
										<td>Nº de pessoas que leram:</td>
										<td>'.$livro['lido'].'</td>
									</tr>
									<tr class="success">
										<td>Nº de páginas:</td>
										<td>'.$livro['numero_paginas'].'</td>
									</tr>
								</tbody>
							</table> 
						</section>
					';
				}

				echo '
					<section class = "row">
						<section class = "col-lg-8" style="margin-left:14%;">
							<section class="panel panel-default">
								<section class="panel-heading">
					                <h3 class="panel-title">Cometários</h3>
					            </section>
					            <section class="panel-body" style="height:315px;overflow:auto;">
					';
				while($comentario=mysql_fetch_assoc($comentarios))
				{
					if($_SESSION['id'] == $comentario['usuario_id'])
	                {
	                    $editar_coments = '
	                    <section style="margin-left:98%;margin-top:0%;">
		                    <button title="Clique para editar seu comentário!" id="editar" onClick="EditarComentario('.$aspas.''.$comentario['id_comentario'].''.$aspas.')">
		                    	<span class="glyphicon glyphicon-edit"></span>
		                    </button>
		                    <form action="" method="post" name="frmExcluir">
			                    <input type="text" name="id_coments" style="display:none" value="'.$comentario['id_comentario'].'">
			                    <button type="submit" name = "excluirComentario" title="Clique para excluir seu comentário!" id="excluir">
			                    	<span class="glyphicon glyphicon-remove"></span>
			                    </button>
		                    </form>
		                </section>
	                    ';
	                }
	                else
	                {
	                    $editar_coments = ""; 
	                }
					echo '
						<section class="well" style="border:1px solid black;margin-top:-2%;">
							<p>'.$editar_coments.'</p>
	                        <p class="text-primary" style="margin-top:-7%;">'.utf8_encode($comentario['nome']).' disse :</p>
	                        <p>'.utf8_encode($comentario['comentario']).'</p>
	                    </section>
					';
				}

				if(!empty($_SESSION['id']))
				{
					if($_SESSION['status'] == 4)
					{
						echo '
												</section>
											</section>
											<form class="form-horizontal" action = "" method = "post" style="margin-top:-2%;">
												<input type="text" class="form-control" name = "comentario" id="comentario" placeholder="O que você achou desse livro?">
												<button type="submit" name = "Comentar" class="btn btn-primary">Enviar</button>
											<form>
										</fieldset>
									</section>
								</section>
						';
					}
					else
					{
						echo '</section>
									<section class="alert alert-dismissable alert-info" style="width:40%;margin-left:30%";>
										<strong>Você precisa completar seu <a href="?url=alterar_dados_perfil">perfil</a> para conversar sobre este livro!</strong>
									</section>
								</fieldset>
							</section>
						</section>';
					}
				}
				else
					{
						echo '</section>
									<section class="alert alert-dismissable alert-info" style="width:40%;margin-left:30%";>
										<strong>Você precisa se <a href="?url=cadastro_usuario">cadastrar</a> no nosso site para poder conversar sobre este livro!</strong>
									</section>
								</fieldset>
							</section>
						</section>';
					}
			

			?>
		</section>
	</section>
</article>
<?php
			}
			else
			{
				echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
						<strong>Livro não encontrado =/ Tente outro código!</strong>
				</section>";
			}
		}
		else
		{	
			echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
					<strong>Livro não encontrado =/ Tente outro código!</strong>
			</section>";	
		}
	}
	else
	{
		echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>				  
				<strong>Livro não encontrado =/ Tente outro código!</strong>
		</section>";
	}

?>
<section class="modal" id="myModal">
</section>
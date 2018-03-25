<?php
	include("classes/class_editar_caracteres.php");
	include("classes/class_banco.php");
	include("classes/class_pesquisar.php");

	$bd = new Banco(); 

	if(!empty($_GET['chave']))
	{
		$aspas = "'";
		$id_livro = $_GET['chave'];

		$editar_id = new EditarCaracteres($id_livro);
		$id_livro = $editar_id->sanitizeNumber($_GET['chave']);

		if($id_livro != "")
		{

			$campos_lista = "COUNT(id_livro) as qt";
			$tabelas_lista = "tbl_lista_livros INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria ON id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id";
			$condição_lista = "id_lista_livros = $id_livro LIMIT 1";

			$pesquisar_qt = new Pesquisar($tabelas_lista,$campos_lista,$condição_lista);
			$resultado_qt = $pesquisar_qt->pesquisar();

			$array = mysql_fetch_assoc($resultado_qt);
			$quantidade = $array['qt'];

			if($quantidade >=1)
			{
				$campos_lista = "estado,primeira_foto,segunda_foto,terceira_foto,livro.*,autor.nome AS Autor,categoria.nome as Categoria,editora.nome As Editora";
				$tabelas_lista = "tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria ON id_lista_livros = lista_livro_id AND id_livro = livro_id AND id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id";
				$condição_lista = "id_lista_livros = $id_livro LIMIT 1";

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
					if(($livro['primeira_foto'] != '') OR ($livro['segunda_foto'] != '') OR ($livro['terceira_foto'] != ''))
					{
						$imagens = '<section class="col">';
						if($livro['primeira_foto'] != '')
						{
							$imagens .= '<section class="col-md-4">	
											<a class = "thumbnail" style="width:auto;">							
												<img src = "'.$livro['primeira_foto'].'" alt = "'.utf8_encode($nome).'" style="height:=100%;width:100%;" /> 
											</a>
										</section>';
						}
						
						if($livro['segunda_foto'] != '')
						{
							$imagens .= '<section class="col-md-4">
										<a class = "thumbnail" style="width:auto;">
											<img src = "'.$livro['segunda_foto'].'" alt = "'.utf8_encode($nome).'" style="height:=100%;width:100%;"/> 
										</a>
										</section>';
						}
						
						if($livro['terceira_foto'] != '')
						{
							$imagens .= '<section class="col-md-4">
										<a class = "thumbnail" style="width:auto;">
											<img src = "'.$livro['terceira_foto'].'" alt = "'.utf8_encode($nome).'" style="height:=100%;width:100%;"/> 
										</a>
										</section>';
						}
						
						$imagens .= '</section>';
					}
					else
					{
						$imagens = '
						<center><p>O usuário não disponibilizou imagens do livro.</p></center>
						';
					}
				
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
										<td>'.utf8_encode($livro['Categoria']).'</td>
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
						<section class="row">
							<form class="form-horizontal" style="margin-left:8%;margin-right:8%;">
								<label class="col-lg-2">Estado:</label>
								<section class="col-md-10">
									<textarea class="form-control">'.utf8_encode($livro['estado']).'</textarea>
								</section><br /><br />
							</form>
						</section>
						<section class="row">
						&nbsp;
						</section>
						<section class="row" >
							<label class="col-lg-2">Imagens:</label>
						</section>
						<section class="row">
							'.$imagens.'
						</section>
						
					';
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
<script type="text/javascript" src="ajax/ajax.js"></script>
<script type="text/javascript">
	function Abrir(livro)
	{
		// inicio uma requisição
		$.ajax({
		// url para o arquivo json.php
			url : "ajax/abrir_livros.php?id="+livro,
		// dataType json
			dataType : "json",
		// função para o sucesso
			success : function(data){
				document.getElementById('article').innerHTML =  data.section;
			},
			// função para o erro
			error : function(data){
				alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
			}			
		});//termina o ajax
	}
</script>
<?php
	
	//Verifica se o usuário tem acesso à essa página
	if($_SESSION['nivel_acesso'] == 1)
	{ 	
			include("classes/class_banco.php");
			include("classes/class_pesquisar.php");
			include('classes/class_editar_caracteres.php');
			
			$editora = $_GET['editora'];
		
			$editar_editora = new EditarCaracteres($editora);
			$editora = $editar_editora->Pesquisa($_GET['editora']);
			
			$bd = new Banco();
			$campos = 'livro.*,categoria.nome As Categoria,autor.nome AS Autor,editora.nome As Editora';
			$tabelas = 'tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor INNER JOIN tbl_categoria categoria ON id_editora = editora_id AND id_autor = autor_id AND id_categoria = categoria_id';
			$pesquisar_livros = new Pesquisar($tabelas,$campos,"editora_id = (SELECT id_editora FROM tbl_editora WHERE nome like '%$editora%' LIMIT 1)");
			$resultado = $pesquisar_livros->pesquisar();
			
			$quantidade = mysql_num_rows($resultado);
			
			if($quantidade > 0)
			{
				$id = array();
				$nome = array();
				$imagem = array();
				$editora = array();
				$autor = array();
				$sinopse = array();
				
				while($pesquisa=mysql_fetch_array($resultado))
				{
					$id[] = $pesquisa['id_livro'];
					$nome[] = $pesquisa['nome'];
					$imagem[] = $pesquisa['imagem_livros'];
					$editora[] = $pesquisa['Editora'];
					$autor[] = $pesquisa['Autor'];
					$sinopse[] = $pesquisa['sinopse'];
					$isbn[] = $pesquisa['isbn'];
					$querem_ler[] = $pesquisa['querem_ler'];
					$lido[] = $pesquisa['lido'];
					$lendo[] = $pesquisa['lendo'];
					$paginas[] = $pesquisa['numero_paginas'];
					$categoria[] = $pesquisa['Categoria'];
				}
				
				$aspas = "'";
			
				$pesquisar_marcacões = new Pesquisar("tbl_marcacao","tipo",'livro_id ='.$id[0].' AND usuario_id='.$_SESSION['id']);
				$resultado_marcacao = $pesquisar_marcacões->pesquisar();
				$array_marcacao = mysql_fetch_assoc($resultado_marcacao);
				
				if($array_marcacao['tipo'] == 1)
				{
					$botões = ' 
							<section class ="btn-group" id="Resultado'.$id[0].'">
								<button value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Desmarcar</a></li>
									<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'QueroLer'.$aspas.');">Estou lendo</a></li>
								</ul>
							</section>';
				}
				else if($array_marcacao['tipo'] == 2)
				{
					$botões = ' 
						<section class ="btn-group" id="Resultado'.$id[0].'">
							<button value = "JaLi" name = "JaLi" type="button" class="btn btn-primary btn-sm">Já Li</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Estou lendo</a></li>
								<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'JaLi'.$aspas.');">Quero Ler</a></li>
							</ul>
						</section>';
				}
				else if($array_marcacao['tipo'] == 3)
				{
					$botões = ' 
						<section class ="btn-group" id="Resultado'.$id[0].'">
							<button value = "Lendo" name = "Lendo" type="button" class="btn btn-primary btn-sm">Estou lendo</button>
							<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
							<ul id = "acoes" class="dropdown-menu">
								<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'Desmarcar'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Desmarcar</a></li>
								<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Quero Ler</a></li>
								<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.'Lendo'.$aspas.');">Já li</a></li>
							</ul>
						</section>';
				}
				else
				{
					$botões = '
							<section class ="btn-group" id="Resultado'.$id[0].'">
								<button value = "" name = "Eu" type="button" class="btn btn-primary btn-sm">Eu...</button>
								<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
								<ul id = "acoes" class="dropdown-menu">
									<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'QueroLer'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.''.$aspas.');">Quero Ler</a></li>
									<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'JaLi'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.''.$aspas.');">Já li</a></li>
									<li><a onClick="AcoesLivro('.$id[0].','.$aspas.'Lendo'.$aspas.','.$aspas.'Resultado'.$id[0].''.$aspas.','.$aspas.''.$aspas.');">Estou lendo</a></li>
								</ul>
							</section>';
				}
				
				$livro = $nome[0];
				
				$editar_livro = new EditarCaracteres($nome[0]);
				$livro = $editar_livro->Url($livro);
?>
<article id = "wrap" style="margin-left: 8%;" >
	<section class="col-md-8" id="article">
		<section class="row">
			<section class = "col-md-3">	
				<section class = "bs-component" style="width:50%;">
					<img style="height:177px; width: 130px;" src = "<?php echo $imagem[0];?>" alt = "<?php echo $nome[0];?>"/> 
				</section>
			</section>
			<section class = "col-md-3">
					<a> <h3> <?php echo utf8_encode($nome[0]); ?> </h3> </a>				  
					<a> <h4> <?php echo utf8_encode($autor[0]); ?> </h4></a>
					<a> <h5> <?php echo utf8_encode($editora[0]); ?> </h5></a>
					<a href="?url=pesquisa&nome=<?php echo utf8_encode($livro); ?>"><input type = "button" class="btn btn-primary btn-sm" name = "botao_pesquisar" value = "Pesquisar" /></a>
					<?php echo $botões; ?>
			</section>
			<section class = "col-md-6">
				<textarea style="background-color:white;" class="form-control" rows="9" readonly>
					<?php echo utf8_encode($sinopse[0]);?>
				</textarea>
			</section>
		</section>
		<br />
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
						<td><?php echo $isbn[0]; ?></td>
					</tr>
					<tr class="success">
						<td>Gênero:</td>
						<td><?php echo $categoria[0]; ?></td>
					</tr>
					<tr>
						<td>Nº de pessoas lendo:</td>
						<td><?php echo $lendo[0]; ?></td>
					</tr>
					<tr class="success">
						<td>Nº de pessoas querendo ler:</td>
						<td><?php echo $querem_ler[0]; ?></td>
					</tr>
					<tr>
						<td>Nº de pessoas que leram:</td>
						<td><?php echo $lido[0]; ?></td>
					</tr>
					<tr class="success">
						<td>Nº de páginas:</td>
						<td><?php echo $paginas[0]; ?></td>
					</tr>
				</tbody>
			</table> 
		</section>
	</section>
	<section class="col-md-4">
	  <section class="panel panel-default">
        <section class="panel-heading">Livros de <?php echo utf8_encode($editora[0]); ?></section>
            <section class="panel-body">
				<section style="overflow:auto;height:500px;">
					<?php
						for($contador=0;$contador<=$quantidade-1;$contador++)
						{
							echo '
								<section class="row">
									<center>
										<section class = "bs-component" style="width:50%;" onClick="Abrir('.$aspas.''.$id[$contador].''.$aspas.')"> 
											<img style="height:177px; width: 130px; cursor:pointer;" src = "'.$imagem[$contador].'" alt = "'.$nome[$contador].'"/> 
										</section>
									<center>
								</section>
								<br />'; 
						}
					?>
					<br />
				</section>
			</section>
		</section>
	</section>
</article>
<?php

		}
		else
		{
			echo '
					<section class="alert alert-dismissable alert-success" style="width:40%;margin-left:30%;">					  
						<strong>Essar editora não existe ou não tem livros cadastrados no nosso site! Caso ela exista, entre em contado com nossos administradores para que ela seja adicionada ao nosso acervo!</strong>
					</section>';
		}
	}
	else
	{	
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
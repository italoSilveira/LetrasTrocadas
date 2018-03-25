<script type="text/javascript">
	function CriaRequest()
	{ 
		try
		{
			request = new XMLHttpRequest(); 
		}
		catch (IEAtual)
		{ 
			try
			{ 
				request = new ActiveXObject("Msxml2.XMLHTTP");
			}
			catch(IEAntigo)
			{
				try
				{ 
					request = new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch(falha)
				{ 
					request = false; 
				} 
			} 
		} 
		if (!request)
		alert("Seu Navegador não suporta Ajax!");
		else return request;
	}

	function AcoesLivro(id,acao,section,tabela)
	{
		var xmlreq = CriaRequest();
		// Iniciar uma requisição
		xmlreq.open("GET", "ajax/acoes_livros.php?acao="+acao+"&id="+id+"&tabela="+tabela, true); 
		// Atribui uma função para ser executada sempre que houver uma mudança de ado
		xmlreq.onreadystatechange = function()
		{
			// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4) 
			if (xmlreq.readyState == 4)
			{ 
				// Verifica se o arquivo foi encontrado com sucesso
				if (xmlreq.status == 200)
				{ 
					var texto = xmlreq.responseText;
					$(section).text(texto).attr({
						title:texto
					});
				}
				else
				{ 
					var texto = "Erro: " + xmlreq.statusText;
					$(section).text(texto).attr({
						title:texto
					});
				}
			} 
		};
		xmlreq.send(null);
	}
</script>
<script type="text/javascript">
	function Abrir(id)
	{
		$.ajax({
			
			url : "ajax/livros_quero_ler.php?livro="+id,
			dataType : "json",
			success : function(data){
				document.getElementById('livro').innerHTML = data.section;
			},
			error : function(data){
			alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
			}
	
		});
		
	}
</script>
<?php
	//Verifica se o usuário tem acesso à essa página
	if($_SESSION['nivel_acesso'] == 1)
	{ 
		
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$bd = new Banco();
		$campos = "id_marcacao,imagem_livros,id_livro,livro.nome AS Livro,autor.nome AS Autor,editora.nome As Editora, livro.sinopse As sinopse";
		$tabelas = "tbl_marcacao marcacao INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id AND id_livro = livro_id";
		$pesquisar_livros = new Pesquisar($tabelas,$campos,"tipo = 1 AND usuario_id =".$_SESSION['id']);
		$resultado = $pesquisar_livros->pesquisar();
		
		$pesquisar_quantidade = new Pesquisar($tabelas,"COUNT(id_marcacao) As quantidade","tipo = 1 AND usuario_id =".$_SESSION['id']);
		$resultado_quantidade = $pesquisar_quantidade->pesquisar();
		
		$pesquisa_quantidade=mysql_fetch_array($resultado_quantidade);
		$quantidade = $pesquisa_quantidade['quantidade'];
		
		$id =array();
		$id_livro = array();
		$nome = array();
		$imagem = array();
		$editora = array();
		$autor = array();
		$sinopse = array();
		
		while($pesquisa=mysql_fetch_array($resultado))
		{
			$id[] = $pesquisa['id_marcacao'];
			$id_livro[] = $pesquisa['id_livro'];
			$nome[] = $pesquisa['Livro'];
			$imagem[] = $pesquisa['imagem_livros'];
			$editora[] = $pesquisa['Editora'];
			$autor[] = $pesquisa['Autor'];
			$sinopse[] = $pesquisa['sinopse'];
		}

		$aspas = "'";
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
<section id = "body_livros_lidos" style = "width:80%;  margin-left:10%;">
	<section class="panel panel-default">
		<section class="panel-heading">Livros que quero ler</section>
		<section class="panel-body">
			<?php
				if($quantidade >= 1)
				{
			?>
			<section class = "row" id = "livro">
				<section class = "col-lg-4" style = "width: auto;">	
					<section class = "bs-component"> 
					<a href="?url=livro&livro=<?php echo $id_livro[0];?>" class = "thumbnail">
						<img src = "<?php echo $imagem[0];?>" alt = "<?php echo $nome[0];?>" height = "177px" width = "120px"/> 
					</a>
					</section>
				</section>
				<section class = "col-lg-4">
					<a href="?url=livro&livro=<?php echo $id_livro[0];?>"> <h3> <?php echo utf8_encode($nome[0]); ?> </h3> </a>				  
					<a> <h4> <?php echo utf8_encode($autor[0]); ?> </h4></a>
					<a> <h5> <?php echo utf8_encode($editora[0]); ?> </h5></a>
					<section class = "btn-group" id="botoes">
						<button id = "Resultado" value = "QueroLer" name = "QueroLer" type="button" class="btn btn-primary btn-sm">Quero Ler</button>
						<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
						<ul id = "acoes" class="dropdown-menu">
							<li><a onClick="AcoesLivro(<?php echo $id_livro[0];?>,'Desmarcar',Resultado,'QueroLer');">Desmarcar</a></li>
							<li><a onClick="AcoesLivro(<?php echo $id_livro[0];?>,'JaLi',Resultado,'QueroLer');">Já li</a></li>
							<li><a onClick="AcoesLivro(<?php echo $id_livro[0];?>,'Lendo',Resultado,'QueroLer');">Estou lendo</a></li>
						</ul>
					</section>
				</section>
				<section class = "col-lg-4" style = "width:48%;">
					<textarea class="form-control" rows="9" readonly>
						<?php echo utf8_encode($sinopse[0]);?>
					</textarea>
				</section> 		
			</section>
			<section style="max-width:100%;overflow:auto;">
				<?php
					for($contador=0;$contador<=$quantidade-1;$contador++)
					{
						echo '
							<section class="col-lg-2">
								<a class = "thumbnail" onClick="Abrir('.$aspas.''.$id_livro[$contador].''.$aspas.')">
									<img src = "'.$imagem[$contador].'" alt = "'.$nome[$contador].'" height = "177px" width = "120px"/> 
								</a>
							</section>'; 
					}
				?>
			</section>
			<?php
				}
				else
				{
			?>
			<section class="alert alert-dismissable alert-info">
				<strong>Você não adicionou nenhum livro a sua estante de livros que você quer! Para adicionar é só pesquisar o livro, ir no botão "Eu..." e clicar em "Quero Ler"!</strong>
			</section>
			<?php
				}
			?>
		</section>		 
	</section>
</section>
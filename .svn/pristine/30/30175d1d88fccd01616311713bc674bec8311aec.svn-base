<script type="text/javascript">
	function Abrir(id)
	{
		$.ajax({
			
			url : "ajax/livros_disponibilizados.php?livro="+id,
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
	//if($_SESSION['nivel_acesso'] == 1)
	//{
			include("classes/class_banco.php");
			include("classes/class_pesquisar.php");
			include("classes/class_update.php");
			include("classes/class_delete.php");
			
			$bd = new Banco();
			
			if(isset($_POST['congelar']))
			{
				$alterar_todos = new Alterar('tbl_lista_livros','status=3','usuario_id = '.$_SESSION['id']);
				$resposta = $alterar_todos->alterar();
				
				echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<center><strong>Seus livros foram congelados!</strong></center>
					</section>";
			}
			
			if(isset($_POST['descongelar']))
			{
				$alterar_todos = new Alterar('tbl_lista_livros','status=1','usuario_id = '.$_SESSION['id']);
				$resposta = $alterar_todos->alterar();
				
				echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
						<center><strong>Seus livros foram descongelados!</strong></center>
					</section>";
			}
			
			if(isset($_POST['excluir']))
			{
				$id = $_POST['id'];
				
				$excluir_fotos = new Deletar('tbl_fotos_livros','lista_livro_id = '.$id);
				if($excluir_fotos->deletar())
				{
					$excluir = new Deletar('tbl_lista_livros','usuario_id = '.$_SESSION['id'].' AND id_lista_livros = '.$id);
					if($excluir->deletar())
					{
						echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
								<center><strong>O livro foi retirado da sua lista de disponibilizados!</strong></center>
							</section>";
					}
					else
					{
						echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>					  
								<center><strong>Algo deu errado! Tenta mais tarde ou entre em contado com nossos administradores.</strong></center>
							</section>";
					}
				}
				else
				{
					echo "<section class='alert alert-dismissable alert-danger' style='width:40%;margin-left:30%;'>					  
							<center><strong>Algo deu errado! Tenta mais tarde ou entre em contado com nossos administradores.</strong></center>
						</section>";
				}
			}
			
			$campos = "id_lista_livros,imagem_livros,lista.status As st,livro.nome AS Livro,livro.id_livro as id_livro,autor.nome AS Autor,editora.nome As Editora, livro.sinopse As sinopse";
			$tabelas = "tbl_lista_livros lista INNER JOIN tbl_livro livro INNER JOIN tbl_editora editora INNER JOIN tbl_autor autor ON id_editora = editora_id AND id_autor = autor_id AND id_livro = livro_id";
			$pesquisar_livros = new Pesquisar($tabelas,$campos,"usuario_id =".$_SESSION['id']);
			$resultado = $pesquisar_livros->pesquisar();
			
			$pesquisar_quantidade = new Pesquisar($tabelas,"COUNT(id_lista_livros) As quantidade","usuario_id =".$_SESSION['id']);
			$resultado_quantidade = $pesquisar_quantidade->pesquisar();
			
			$pesquisa_quantidade=mysql_fetch_assoc($resultado_quantidade);
			$quantidade = $pesquisa_quantidade['quantidade'];
			
			$id =array();
			$nome = array();
			$id_livro = array();
			$imagem = array();
			$editora = array();
			$autor = array();
			$sinopse = array();
			$status = array();
			
			while($pesquisa=mysql_fetch_assoc($resultado))
			{
				$status[] = $pesquisa['st'];
				$id[] = $pesquisa['id_lista_livros'];
				$id_livro = $pesquisa['id_livro'];
				$nome[] = $pesquisa['Livro'];
				$imagem[] = $pesquisa['imagem_livros'];
				$editora[] = $pesquisa['Editora'];
				$autor[] = $pesquisa['Autor'];
				$sinopse[] = $pesquisa['sinopse'];
			}

			$aspas = "'";
	/*}
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
	}*/
?>

<section id = "body_livros_lidos" style = "width:80%; margin-left:10%;">
     <section class="panel panel-default">
        <section class="panel-heading">
			<form method="post" action="">Livros diponibilizados&nbsp;&nbsp;
				<?php 
					if ($status[0] == 1)
					{
				?>
				<input type="submit" style="background-color:#87cefa;border-color:#87cefa;" title="Este botão é usado caso você precise viajar e não poderá enviar livros. Mais informações no nosso FAQ!" class="btn btn-primary btn-sm" name="congelar" value="Congelar Livros"/>
				<?php 
					}
					else if ($status[0] == 3)
					{
				?>
				<input type="submit" style="background-color:#87cefa;border-color:#87cefa;" class="btn btn-primary btn-sm" name="descongelar" value="Descongelar Livros"/>
				<?php
					}
					else
					{}
				?>
				</form>
		</section>
		<?php
			if($quantidade >= 1)
			{
		?>
        <section class="panel-body">
		    <section class = "row" id="livro">
				<section class = "col-lg-4" style = "width: auto;">	
					<section class = "bs-component"> 
							<a class = "thumbnail">
								<img src = "<?php echo $imagem[0];?>" alt = "<?php echo utf8_encode($nome[0]);?>" height = "177px" width = "120px">
							</a>
					</section>
				</section>
				<section class = "col-lg-4"><center>
						<a> <h3> <?php echo utf8_encode($nome[0]); ?> </h3> </a>				  
						<a> <h4> <?php echo utf8_encode($autor[0]); ?> </h4></a>
					    <a> <h5> <?php echo utf8_encode($editora[0]); ?> </h5></a>
						<form method="post" action="?url=alterar_livro_usuario&cod=<?php echo $id_livro[0];?>&lista=<?php echo $id[0] ;?>">
							<input type="submit" class="btn btn-primary btn-sm" name="alterarlivro" value="Alterar Livro"/>
						</form>
						<form style="margin-top:1%;" method="post" action="">
							<input type="submit" class="btn btn-primary btn-sm" name="excluir" value="Tirar da lista"/>
							<input type="text" class="btn btn-primary btn-sm" style="display:none;" name="id" value="<?php echo $id[0] ;?>"/>
						</form></center>
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
								<img src = "'.$imagem[$contador].'" alt = "'.utf8_encode($nome[$contador]).'" height = "177px" width = "120px"/> 
							</a>
						</section>'; 
					}
				?>
			</section>
		</section>
		<?php
			}
			else
			{
		?>
		<section class="alert alert-dismissable alert-info">
			<strong>Você não adicionou nenhum livro a sua estante de livros lidos! Para adicionar é só pesquisar o livro, ir no botão "Eu..." e clicar em "Lido"!</strong>
		</section>
		<?php
			}
		?>
   </section>
</section>
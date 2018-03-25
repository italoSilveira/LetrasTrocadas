<?php
	
	if($_SESSION['nivel_acesso'] == 1)
	{
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("classes/class_update.php");
		
		$bd = new Banco();
		
		$tabelas = 'tbl_cambio cambio INNER JOIN tbl_usuario usuario INNER JOIN tbl_lista_livros lista INNER JOIN tbl_livro livro ON id_usuario = usuario_resgate AND id_livro = livro_id AND id_lista_livros = lista_livros_id';
		
		$pesquisar_cambios = new Pesquisar($tabelas,'livro.nome As livro, cambio.*',"usuario_resgate = ".$_SESSION['id']." ORDER BY data_operacao DESC");
		$resultado_cambios = $pesquisar_cambios->pesquisar();
		
		echo '
		<section class="panel panel-default" style="width: 84%; margin-left: 8%;">
			<section class="panel-heading">
				<a><h3 class="panel-title">WHERE ARE MY DRAGONS</h3></a>
			</section>
			<section class="panel-body">';
		$ct = 0;
		while($cambio=mysql_fetch_assoc($resultado_cambios))
		{
			$ct++;
			$pesquisar_nome_usuario = new Pesquisar('tbl_usuario','nome',"id_usuario = ".$cambio['usuario_disponibilizador']);
			$resultado_nome = $pesquisar_nome_usuario->pesquisar();
			$codigo = $cambio['cod_rastreamento'];
			
			while($resultado = mysql_fetch_assoc($resultado_nome))
			{
				$nome = $resultado['nome'];
			}
			
			if($ct == 1)
			{
				$colapse = "in";
			}
			else
			{
				$colapse = "";
			}
			
			if($cambio['status'] == 2 OR  $cambio['status'] ==3)
			{
				$background_transporte = 'style = "background-color:green;"';
			}
			else
			{
				$background_transporte = '';
			}
			$background_transporte = $cambio['status'] <> 1 ? 'style = "background-color:green;"' : "";
			$background_livro_entregue = $cambio['entregue'] == "Sim" ? 'style = "background-color:green;"' : "";
			
			 echo '
			 <section class="panel-group" id="cambio">
				<section class="panel panel-success">
					<section class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#cambio" href="#collapse'.$ct.'">'.utf8_encode($cambio['livro']).' - '.$cambio['data_operacao'].'
							</a>
						</h4>
					</section>
					<section id="collapse'.$ct.'" class="panel-collapse collapse '.$colapse.'">
						<section class="panel-body">
							<p>
								Dono do livro :  <a>'.utf8_encode($nome).'</a><BR>
								Livro solicitado : <a>'.utf8_encode($cambio['livro']).'</a><BR>
								Código de rastreamento : <a href="?url=rastreamento&code='.$codigo.'">'.$codigo.'<a><BR>
							</p>
							<span class="badge" style = "background-color:green;">Solicitação<BR>Aceita</span>
							<span class="badge" '.$background_transporte.'>Em<BR>Transporte</span>
							<span class="badge" '.$background_livro_entregue.'>Livro<BR>Entregue</span>
						</section>
					</section>
				</section>
			</section>';
		}
		echo '
			</section>
		</section>';
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
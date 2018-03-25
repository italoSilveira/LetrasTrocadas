<?php

	if($_SESSION['nivel_acesso'] == 1)
	{
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("classes/class_update.php");
		
		$bd = new Banco();
		
		$alterar = new Alterar("tbl_notificacoes","visualizado = 'true'","usuario_id = ".$_SESSION['id']." AND tipo = 1 OR usuario_id = ".$_SESSION['id']." AND tipo = 2");
		$resultado = $alterar->alterar();
		
		$tabelas = 'tbl_solicitacao_troca solicitacao INNER JOIN tbl_usuario usuario INNER JOIN tbl_lista_livros lista INNER JOIN tbl_livro livro ON id_usuario = usuario_solicitador AND id_livro = livro_id AND id_lista_livros = lista_id';
		
		$pesquisar_trocas = new Pesquisar($tabelas,'livro.nome As livro, solicitacao.*',"usuario_solicitador = ".$_SESSION['id']." ORDER BY data_resposta DESC");
		$resultado_trocas = $pesquisar_trocas->pesquisar();
		
		echo '
		<section class="panel panel-default" style="width: 84%; margin-left: 8%;">
			<section class="panel-heading">
				<a><h3 class="panel-title">Suas trocas</h3></a>
			</section>
			<section class="panel-body">';
		$ct = 0;
		while($trocas=mysql_fetch_assoc($resultado_trocas))
		{
			$ct++;
			$pesquisar_nome_usuario = new Pesquisar('tbl_usuario','nome',"id_usuario = ".$trocas['usuario_dono_lista']);
			$resultado_nome = $pesquisar_nome_usuario->pesquisar();
			
			while($resultado = mysql_fetch_assoc($resultado_nome))
			{
				$nome = $resultado['nome'];
			}
			
			if($trocas['aceito'] == "Sim")
			{
				$status = "aceita";
				$pesquisar_codigo = new Pesquisar('tbl_cambio','cod_rastreamento',"solicitacao_id = ".$trocas['id_solicitacao']);
				$resultado_codigo = $pesquisar_codigo->pesquisar();
				while($resultado_codigos = mysql_fetch_assoc($resultado_codigo))
				{
					$codigo = $resultado_codigos['cod_rastreamento'];
					$resposta = 'Código de rastreamento : <a href="?url=rastreamento&code='.$codigo.'">'.$codigo.'<a>';
				}
			}
			else
			{
				$status = "recusada";
			}
			
			if($ct == 1)
			{
				$colapse = "in";
			}
			else
			{
				$colapse = "";
			}
			
			$array_data_solicitação = explode("-",$trocas['data_solicitacao']);
			$data_solicitação = $array_data_solicitação[2]."/".$array_data_solicitação[1]."/".$array_data_solicitação[0];
			
			$array_data_resposta = explode("-",$trocas['data_resposta']);
			$data_resposta = $array_data_resposta[2]."/".$array_data_resposta[1]."/".$array_data_resposta[0];
			
			if($trocas['aceito'] != '')
			{
				 echo '
				 <section class="panel-group id="trocas">
					<section class="panel panel-success">
						<section class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#trocas" href="#collapse'.$ct.'">'.utf8_encode($trocas['livro']).' - '.$data_solicitação.'
								</a>
							</h4>
						</section>
						<section id="collapse'.$ct.'" class="panel-collapse collapse '.$colapse.'">
							<section class="panel-body">
								<p>
										A sua solicitação de troca foi '.$status.' pelo usuário '.utf8_encode($nome).', dono do livro "'.utf8_encode($trocas['livro']).'".<BR>
										Sua solicitação foi enviada no dia '.$data_solicitação.' e respondida no dia '.$data_resposta.'.<BR>
										'.$resposta.'<BR>
								</p>
							</section>
						</section>
					</section>
				</section>';
			}
			else
			{
				echo '
				<section class="panel-group" id="trocas">
					<section class="panel panel-success">
						<section class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#trocas" href="#collapse'.$ct.'">'.utf8_encode($trocas['livro']).' - '.$data_solicitação.'
								</a>
							</h4>
						</section>
						<section id="collapse'.$ct.'" class="panel-collapse collapse '.$colapse.'">
							<section class="panel-body">
								<p>
										A sua solicitação de troca foi enviada para o usuário '.utf8_encode($nome).', dono do livro "'.utf8_encode($trocas['livro']).'".<BR>
										Sua solicitação foi enviada no dia '.$data_solicitação.'. Aguarde a decissão do usuário.<BR>
								</p>
							</section>
						</section>
					</section>
				</section>';
			}
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
<script type = "text/javascript">

	function Aceitar(id,lista,usuario)
	{
		$.ajax({
		
			url : 'ajax/aceita_solicitacao.php?id='+id+'&lista='+lista+'&usuario='+usuario,
			dataType : 'json',
			success : function(data){
				$('#Aceitar_'+id).attr({'class' : 'btn btn-success disabled', 'value' : 'Aceito', 'onClick' : ''});
				$('#Recusar_'+id).hide();
			},
			error : function(data){
				alert('Ops ocorreu um erro. Para mais informações contate nossos administradores.');
			}
		
		});
	}
	
	function Recusar(id)
	{
		$.ajax({
		
			url : 'ajax/recusar_solicitacao.php?id='+id,
			dataType : 'json',
			success : function(data){
				$('#Recusar_'+id).attr({'class' : 'btn btn-danger disabled', 'value' : 'Recusado', 'onClick' : ''});
				$('#Aceitar_'+id).hide();
			},
			error : function(data){
				alert('Ops ocorreu um erro. Para mais informações contate nossos administradores.');
			}
		
		});
	}

</script>

<?php

	if($_SESSION['nivel_acesso'] == 1)
	{
		$aspas = "'";
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		include("classes/class_editar_caracteres.php");
		include("classes/class_update.php");
		include("classes/class_insert.php");
		
		$bd = new Banco();
		
		if(isset($_POST['cadastrar_codigo']))
		{
			$rastreamento = $_POST['Codigo_rastreamento'];
			$codigo = $_GET['id'];		
			
			$editar_rastreamento = new EditarCaracteres($rastreamento);
			$rastreamento = $editar_rastreamento->sanitizeStringNome($_POST['Codigo_rastreamento']);
			
			$editar_codigo = new EditarCaracteres($codigo);
			$codigo = $editar_codigo->sanitizeString($_GET['id']);
			
			$alterar_codigo = new Alterar('tbl_cambio',"cod_rastreamento = '".$rastreamento."'",'id_cambio ='.$codigo);
			$resultado = $alterar_codigo->alterar();
			
			$pesquisar = new Pesquisar('tbl_cambio','usuario_resgate','id_cambio ='.$codigo);
			$resposta = $pesquisar->pesquisar();
			$dados = mysql_fetch_assoc($resposta);
			$usuario = $dados['usuario_resgate'];

			$mensagem = 'Código de rastreamento disponível.';
			$inserir = new Inserir('tbl_notificacoes',"NULL,1,'".utf8_decode($mensagem)."',".$usuario.",NOW(),'false'");
			$resultados = $inserir->inserir();

		}
		
		$aspas = "'";
		$alterar_status_notificações = new Alterar('tbl_notificacoes','visualizado = "true"','tipo = 3 AND usuario_id = '.$_SESSION['id']);
		$resultado = $alterar_status_notificações->alterar();
		
		$tabelas = "tbl_solicitacao_troca solicitacao INNER JOIN tbl_lista_livros lista_livro INNER JOIN tbl_livro livro INNER JOIN tbl_usuario usuario ON id_lista_livros = lista_id AND id_livro = livro_id AND id_usuario = usuario_id";
		
		$campos_pendentes = "solicitacao.id_solicitacao,solicitacao.data_solicitacao,livro.nome as livro,usuario.nome as nome, solicitacao.usuario_solicitador as usuario, lista_livro.id_lista_livros as lista";
		$condicao_pendentes = "aceito = '' AND usuario_dono_lista = ".$_SESSION['id'];
		$pesquisar_pendentes = new Pesquisar($tabelas,$campos_pendentes,$condicao_pendentes);
		$resultado_pendente = $pesquisar_pendentes->pesquisar();
		
		$campos_antiga = "solicitacao.id_solicitacao,solicitacao.data_solicitacao,livro.nome as livro,usuario.nome as nome, solicitacao.usuario_solicitador as usuario, lista_livro.id_lista_livros as lista, solicitacao.aceito,solicitacao.data_resposta";
		$condicao_antiga = "aceito <> '' AND usuario_dono_lista = ".$_SESSION['id'];
		$pesquisar_antiga = new Pesquisar($tabelas,$campos_antiga,$condicao_antiga);
		$resultado_antiga = $pesquisar_antiga->pesquisar();

		echo '
		<section class="panel panel-default" style="width: 84%; margin-left: 8%;">
			<section class="panel-heading">
				<a><h3 class="panel-title">Suas solicitações</h3></a>
			</section>
			<section class="panel-body">';
		$ct = 0;
		while($notificações_pendentes=mysql_fetch_assoc($resultado_pendente))
		{
			$ct++;
			if($ct == 1)
			{
			$colapse = "in";
			}
			else
			{
				$colapse = "";
			}
			
			$pesquisar_pendentes = new Pesquisar("tbl_usuario","nome","id_usuario = ".$notificações_pendentes['usuario']);
			$resultado_pendente = $pesquisar_pendentes->pesquisar();
			$nome_array = mysql_fetch_assoc($resultado_pendente);
			$nome = $nome_array['nome'];
			
			$data = explode("-",$notificações_pendentes['data_solicitacao']);
			$data_pronta = $data[2]."/".$data[1]."/".$data[0];
			
			echo '
			<section class="panel-group" id="solicitações">
				<section class="panel panel-success">
					<section class="panel-heading" style="background-color:#D3D3D3;">
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#solicitações" href="#collapse'.$ct.'">'.utf8_encode($notificações_pendentes['livro']).' - Pendente
							</a>
						</h4>
					</section>
					<section id="collapse'.$ct.'" class="panel-collapse collapse '.$colapse.'">
						<section class="panel-body">
							<p>
								'.utf8_encode($nome).' solicitou seu livro "'.utf8_encode($notificações_pendentes['livro']).'"
								no dia '.$data_pronta.'<BR>
								Deseja aceitar?<BR>
							</p>
							<input type = "button" class="btn btn-primary btn-sm" id = "Aceitar_'.$notificações_pendentes['id_solicitacao'].'" onClick="Aceitar('.$aspas.''.$notificações_pendentes['id_solicitacao'].''.$aspas.','.$aspas.''.$notificações_pendentes['lista'].''.$aspas.','.$aspas.''.$notificações_pendentes['usuario'].''.$aspas.')" value = "Aceitar"/>
							<input type = "button" class="btn btn-primary btn-sm" id = "Recusar_'.$notificações_pendentes['id_solicitacao'].'" onClick="Recusar('.$aspas.''.$notificações_pendentes['id_solicitacao'].''.$aspas.')" value="Recusar"/>
						</section>
					</section>							
				</section>
			</section>';
			 
		}
		while($notificações_antigas=mysql_fetch_assoc($resultado_antiga))
		{	
			if($ct == 0)
			{
				$colapse = "in";
			}
			else
			{
				$colapse = "";
			}
			
			$codigo = "";
			if($notificações_antigas['aceito'] == "Sim")
			{
				
				$pesquisar_id_cambio = new Pesquisar("tbl_cambio","id_cambio,cod_rastreamento","solicitacao_id = ".$notificações_antigas['id_solicitacao']);
				$resultado_id_cambio = $pesquisar_id_cambio->pesquisar();
				$id_array = mysql_fetch_assoc($resultado_id_cambio);
				$id_cambio = $id_array['id_cambio'];
				$cod = $id_array['cod_rastreamento'];

				if($cod == '')
				{
					$codigo = '
						<form action="?url=solicitacoes_recebidas&id='.$id_cambio.'" method="post">
							<BR>
							<label for="Codigo_rastreamento" class="control-label">Código de rastreamento:</label>
							<input type = "text" style="width:30%;" class = "form-control" name = "Codigo_rastreamento" id = "Codigo_rastreamento"><BR>
							<button type="submit" class="btn btn-primary" name = "cadastrar_codigo" id = "cadastrar_codigo">Cadastrar código</button>
						<form>';
				}
				else
				{
					$codigo = 'O código de rastreamento é : <a href="?url=rastreamento&code='.$cod.'">'.$cod.'</a>';
				}
			}
			
			$ct++;
			
			$data_solicitada = explode("-",$notificações_antigas['data_solicitacao']);
			$data_pronta_solicitada = $data_solicitada[2]."/".$data_solicitada[1]."/".$data_solicitada[0];
			
			$data_respondida = explode("-",$notificações_antigas['data_resposta']);
			$data_pronta_respondida = $data_respondida[2]."/".$data_respondida[1]."/".$data_respondida[0];
			
			$pesquisar_antigas = new Pesquisar("tbl_usuario","nome","id_usuario = ".$notificações_antigas['usuario']);
			$resultado_antigas = $pesquisar_antigas->pesquisar();
			$nome_array = mysql_fetch_assoc($resultado_antigas);
			$nome = $nome_array['nome'];
			
			 echo '
				<section class="panel-group" id="solicitações">
					<section class="panel panel-success">
						<section class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#solicitações" href="#collapse'.$ct.'">'.utf8_encode($notificações_antigas['livro']).' - Aceito : '.$notificações_antigas['aceito'].'
								</a>
							</h4>
						</section>
						<section id="collapse'.$ct.'" class="panel-collapse collapse '.$colapse.'">
							<section class="panel-body">
									<p>
										'.utf8_encode($nome).' solicitou seu livro "'.utf8_encode($notificações_antigas['livro']).'"
										no dia '.$data_pronta_solicitada.' e você respondeu no dia '.$data_pronta_respondida.' <BR>
										'.$codigo.'	
									</p>
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
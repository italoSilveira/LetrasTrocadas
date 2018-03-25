<?php
	
	if(isset($_GET['livro']) && isset($_GET['usuario']))
	{
		include('../views/classes/class_banco.php');
		include('../views/classes/class_pesquisar.php');
		
		$bd = new Banco();
		
		$id = $_GET['livro'];
		$id_usuario = $_GET['usuario'];
		
		$campos = 'estado,primeira_foto,segunda_foto,terceira_foto,livro.nome';
		$tabelas = 'tbl_fotos_livros INNER JOIN tbl_lista_livros INNER JOIN tbl_livro livro ON id_lista_livros = lista_livro_id AND id_livro = livro_id';
		$pesquisar_livros = new Pesquisar($tabelas,$campos,"id_lista_livros = $id AND usuario_id = $id_usuario LIMIT 1");
		$resultado = $pesquisar_livros->pesquisar();
		
		while($dados=mysql_fetch_assoc($resultado))
		{
			$primeira = $dados['primeira_foto'];
			$segunda = $dados['segunda_foto'];
			$terceira = $dados['terceira_foto'];
			$nome = $dados['nome'];
			$estado = $dados['estado'];
		}
		
		if(($primeira != '') OR ($segunda != '') OR ($terceira != ''))
		{
			$imagens = '<section class="col">';
			if($primeira != '')
			{
				$imagens .= '<section class="col-md-4">
							<a class = "thumbnail" style="width:auto;">
								<img src = "'.$primeira.'" alt = "'.utf8_encode($nome).'" height = "177px" width = "120px"/> 
							</a>
							</section>';
			}
			
			if($segunda != '')
			{
				$imagens .= '<section class="col-md-4">
							<a class = "thumbnail" style="width:auto;">
								<img src = "'.$segunda.'" alt = "'.utf8_encode($nome).'" height = "177px" width = "120px"/> 
							</a>
							</section>';
			}
			
			if($terceira != '')
			{
				$imagens .= '<section class="col-md-4">
							<a class = "thumbnail" style="width:auto;">
								<img src = "'.$terceira.'" alt = "'.utf8_encode($nome).'" height = "177px" width = "120px"/> 
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
		
		
		$aspas = "'";
		
		$retorno = '
				<section class="modal-dialog">
					<section class="modal-content">
						<section class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
							<h4 class="modal-title">Solicitação de livro</h4>
						</section>
						<form class="form-horizontal" method = "post" action = "">
						<section class="modal-body ">
							<form class="form-horizontal" method = "post" action = "">
								<section class="form-group">
									<section class="row">
										<label class="col-md-4 control-label">Informações do usuário:</label>
									</section><br />
									<section class="row">
										<label for="t" class="col-md-2 control-label">Estado:</label>
										<section class="col-md-8">	
											<textarea id="t" class="form-control">'.utf8_encode($estado).'</textarea>  
										</section>
									</section><br />
								</section>
							</form>
							<section class="row">
								'.$imagens.'
							</section><br />
							<section class="row">
								<center>
									<p id = "TextDialog" >Você deseja solicitar este livro?</p>
								</center>
							</section>
						</section>
						<section class="modal-footer">
							<button id = "confirmar_solicitação" type="button" class="btn btn-primary" onClick="ConfirmarSolicitacao('.$aspas.''.$id.''.$aspas.','.$aspas.''.$id_usuario.''.$aspas.')">Sim</button>
							<button id = "cancelar" type="button" class="btn btn-default" data-dismiss="modal">Não</button>
						</section>
					</section>
				</section>';
		
		$caixa_dialogo = array('section' => $retorno);
				
		echo json_encode($caixa_dialogo);
	}

?>
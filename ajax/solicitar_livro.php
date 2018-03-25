<?php
	session_start();
	if(isset($_GET['livro']) && isset($_GET['usuario']))
	{
		$id_usuario = $_SESSION['id'];
		
		include("../views/classes/class_banco.php");	
		include("../views/classes/class_insert.php");
		include("../views/classes/class_pesquisar.php");
		$bd = new Banco();
		
		$pesquisar = new Pesquisar("tbl_usuario","status","id_usuario =".$id_usuario);
		$resultado = $pesquisar->pesquisar();
		$array = mysql_fetch_assoc($resultado);
		$status = $array['status'];
		
		if($status == 4)
		{
			$pesquisar_creditos = new Pesquisar("tbl_usuario","creditos","id_usuario =".$id_usuario);
			$resultado_creditos = $pesquisar_creditos->pesquisar();
			$array_creditos = mysql_fetch_assoc($resultado_creditos);
			$creditos = $array_creditos['creditos'];
			
			if($creditos > 0)
			{
				if($id_usuario != $_GET['usuario'])
				{		
					$id_lista = $_GET['livro'];
					$usuario = $_GET['usuario'];
					
					$cadastrar_solicitacao = new Inserir("tbl_solicitacao_troca","NULL,$id_lista,".$_SESSION['id'].",$usuario,'',DATE(NOW()),NULL");
					$resultado = $cadastrar_solicitacao->inserir();
					if($resultado != 0)
					{
						$resposta = "Sua solicitação foi enviada. Aguarde a confirmação.";
					}
					else
					{
						$resposta = "Erro inesperado, entre em contato com nossos administradores";
					}
				}
				else
				{
					$resposta = "Você não pode solicitar seu próprio livro.";
				}
			}
			else
			{
				$resposta = "Você não possui créditos para solicitar livros";
			}
		}
		else
		{
			$resposta = "Para solicitar um livro, primeiro você precisa completar seu perfil!.";
		}
		
		$retorno = array('resposta' => $resposta);
				
		echo json_encode($retorno);
	}

?>
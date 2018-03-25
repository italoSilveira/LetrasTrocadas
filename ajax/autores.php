<?php
	session_start();
	if(isset($_GET['eliminar']))
	{
		if(isset($_GET['autor']) && isset($_GET['acao']))
		{
			$id = $_SESSION['id'];
				
			include("../views/classes/class_banco.php");	
			include("../views/classes/class_delete.php");
			include("../views/classes/class_pesquisar.php");
			
			$bd = new Banco();
			
			$autor = $_GET['autor'];
			
			if($_GET['acao'] == "Favoritos")
			{
				$eliminar = new Deletar('tbl_autores_favoritos',"autor_id = $autor AND usuario_id = $id");
				$resultado = $eliminar->deletar();
				
				$resposta = array('resposta' => 'Deu certo');
				echo json_encode($resposta);
			}
			else if($_GET['acao'] == "Chatos")
			{
				$eliminar = new Deletar('tbl_autores_desapreciados',"autor_id = $autor AND usuario_id = $id");
				$resultado = $eliminar->deletar();
				
				$resposta = array('resposta' => 'Deu certo');
				echo json_encode($resposta);
			}
			else
			{
			}
		}
	}
	else
	{
		if(isset($_GET['autor']) && isset($_GET['acao']))
		{
			$id = $_SESSION['id'];
				
			include("../views/classes/class_banco.php");	
			include("../views/classes/class_insert.php");
			include("../views/classes/class_pesquisar.php");
			
			$bd = new Banco();
			
			$autor = $_GET['autor'];
			
			if($_GET['acao'] == "Favoritos")
			{
				$cadastrar_aut = new Inserir('tbl_autores_favoritos',"NULL,$autor,$id");
				$resultado = $cadastrar_aut->inserir();
				
				$resposta = array('resposta' => 'Deu certo');
				echo json_encode($resposta);
			}
			else if($_GET['acao'] == "Chatos")
			{
				$cadastrar_aut = new Inserir('tbl_autores_desapreciados',"NULL,$autor,$id");
				$resultado = $cadastrar_aut->inserir();
				
				$resposta = array('resposta' => 'Deu certo');
				echo json_encode($resposta);
			}
			else
			{
			}
		}
	}
?>
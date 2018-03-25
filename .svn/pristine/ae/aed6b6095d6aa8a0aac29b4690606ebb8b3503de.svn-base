<?php
	
	session_start();
	if($_SESSION['nivel_acesso'] == 1)
	{
		if(isset($_GET['id']))
		{
			include("../views/classes/class_banco.php");
			include("../views/classes/class_update.php");
			
			$bd = new Banco();
			
			$id = $_GET['id'];
			
			$alterar = new Alterar('tbl_solicitacao_troca',"aceito = 'Nao',data_resposta = NOW()",'id_solicitacao = '.$id);
			$resultado = $alterar->alterar();
			
			$resposta = array('retorno' => $resultado);
			
			echo json_encode($resposta);
		}
	}
?>
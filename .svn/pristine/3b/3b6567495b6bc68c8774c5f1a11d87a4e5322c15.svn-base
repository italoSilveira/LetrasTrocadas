<?php
	session_start();
	$status = $_SESSION['nivel_acesso'];
	$id = $_SESSION['id'];
	if($status == 1)
	{
		include("../views/classes/class_banco.php");
		include("../views/classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		$pesquisar_notificacoes = new Pesquisar("tbl_notificacoes","*","visualizado = 'false' AND usuario_id = ".$id." AND data_enviada >= DATE_SUB(NOW(),INTERVAL 5 SECOND) LIMIT 3");
		$resultado = $pesquisar_notificacoes->pesquisar();
		$ct=0;
		$retorno = "";
		while($notificações=mysql_fetch_assoc($resultado))
		{
			$ct++;
			$retorno.= '
			<section id = "notificações'.$ct.'" class="panel panel-info" >
				<section class="panel-heading">
					<h3 class="panel-title">Notificações</h3>
				</section>
				<section class="panel-body">
					<p>'.utf8_encode($notificações['mensagem']).'</p>
				</section>
			</section>
			';
		}
		$retorno = array('retorno' => $retorno);
		
		echo json_encode($retorno);
	}

?>
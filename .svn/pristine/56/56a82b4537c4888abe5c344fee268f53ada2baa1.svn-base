<?php

	session_start();
	$status = $_SESSION['nivel_acesso'];
	$id = $_SESSION['id'];
	if($status == 1)
	{
		include("../views/classes/class_banco.php");
		include("../views/classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$pesquisar_moedas = new Pesquisar("tbl_usuario","creditos","id_usuario =".$id);
		$resultado_moedas = $pesquisar_moedas->pesquisar();
		$array_moedas = mysql_fetch_row($resultado_moedas);
		$quantidade_moedas = $array_moedas[0];
		
		$pesquisar_trocas_aceitas = new Pesquisar("tbl_notificacoes","COUNT(id_notificacoes)","usuario_id =".$id." AND tipo = 1 AND visualizado = 'false'");
		$resultado_trocas_aceitas = $pesquisar_trocas_aceitas->pesquisar();
		$array_trocas_aceitas = mysql_fetch_row($resultado_trocas_aceitas);
		$quantidade_trocas_aceitas = $array_trocas_aceitas[0];
		
		$pesquisar_solicitações_recebidas = new Pesquisar("tbl_notificacoes","COUNT(id_notificacoes)","usuario_id =".$id." AND tipo = 3 AND visualizado = 'false'");
		$resultado_solicitações_recebidas = $pesquisar_solicitações_recebidas->pesquisar();
		$array_solicitações_recebidas = mysql_fetch_row($resultado_solicitações_recebidas);
		$quantidade_solicitações_recebidas = $array_solicitações_recebidas[0];
		
		$pesquisar_trajetória_livros = new Pesquisar("tbl_notificacoes","COUNT(id_notificacoes)","usuario_id =".$id." AND tipo = 4 OR tipo = 5 AND visualizado = 'false'");
		$resultado_trajetória_livros = $pesquisar_trajetória_livros->pesquisar();
		$array_trajetória_livros = mysql_fetch_row($resultado_trajetória_livros);
		$quantidade_trajetória_livros = $array_trajetória_livros[0];
		
		$sidebar = array('moedas' => $quantidade_moedas,'trocas_aceitas' => $quantidade_trocas_aceitas,'solicitacoes_recebidas' => $quantidade_solicitações_recebidas,'trajetoria_livros' => $quantidade_trajetória_livros);
		
		echo json_encode($sidebar);

	}

?>
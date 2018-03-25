<?php

	session_start();
	header('Content-Type: application/json');
	if(isset($_FILES["file_primeira"]))
	{	
		$nome_livro = $_GET['nome'];
		$origem = $_FILES["file_primeira"]["tmp_name"];
		$nome = "tmp_profile_".$_SESSION["id"];
		$largura = 200;
		$pasta = "content/imagens/fotos_perfil/tmp";
		include("../views/classes/class_upload.php");
		$caminho = $pasta."/".$nome;
		echo json_encode(array("nome" => $nome_livro));
		//echo json_encode(array("caminho" => upload($origem,$nome, $largura, $pasta), "caminho_a" => $caminho));
	}

?>
<?php
	session_start();
	//header('Content-Type: application/json');
	if(isset($_FILES["file"]))
	{	
		include("../views/classes/class_upload.php");
		$pasta = "content/imagens/fotos_perfil/tmp/";
   		$ext = @end(explode(".", $nome));
		$upload = new Upload($_FILES['file'], 1000, 1000, $pasta);
		$nome = "tmp_profile_".$_SESSION["id"];
       	$caminho = @$upload->salvar($nome);
		$caminho_a = str_replace('/wamp/www/Letras_Trocadas/','', $caminho);
		$arquivo = fopen($caminho,'r');
		echo json_encode(array("caminho" => $caminho, "caminho_a" => $caminho_a));
	}
	
?>

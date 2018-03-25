<?php
	header('Content-Type: application/json');
	if(isset($_POST["caminho"]))
	{
		$caminho = $_POST["caminho"];
		$ext =  explode(".",$caminho)[1];
		$imagem = base64_encode(file_get_contents ( $caminho ));
		echo json_encode(array("imagem" => ("data:image/".$ext.";base64,".$imagem)));
	}
?>
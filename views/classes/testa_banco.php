<?php
include("banco.php");

$LetrasTrocadas = new Banco();

if($LetrasTrocadas->StatusConexao())
	echo "Conexão realizada com sucesso!";
else 
	echo "Falha na conexão!";
?>
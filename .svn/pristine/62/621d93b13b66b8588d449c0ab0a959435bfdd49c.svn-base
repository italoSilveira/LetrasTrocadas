<?php

class CadastrarUsu
{
	private $email;
	private $senha;
	
	public function __construct($var_email="",$var_senha="")
	{
		$this->email = $var_email;
		$this->senha = $var_senha;
	}
	
	public function inserir()
	{

		$sql = "INSERT INTO tbl_usuario(id_usuario,nome,foto,email,senha,creditos,qt_livros_solicitados,qt_livros_disponibilizados,data_criacao,
		trocas_realizadas_mes,limite_troca,avaliacoes_negativas,avaliacoes_positivas,status,nivel_acesso,creditos_comprados_mes) VALUES (NULL,'','content/imagens/fotos_perfil/avatar-250.png',
		'$this->email','$this->senha',0,0,0,DATE(NOW()),0,1,0,0,1,1,0)";

		$resultado = mysql_query($sql) or die(mysql_error());

		
		return $resultado;
	}
	
}
?>
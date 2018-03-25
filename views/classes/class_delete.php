<?php

class Deletar
{
	private $tabela;
	private $condicao;
	
	public function __construct($var_tabela="", $var_condicao="")
	{
		$this->tabela = $var_tabela;
		$this->condicao = $var_condicao;
	}
	
	public function deletar()
	{
		
		$sql = "DELETE FROM $this->tabela WHERE $this->condicao";
		//echo $sql.'<BR>';
		$resultado = mysql_query($sql) or die(mysql_error());
		
		return $resultado;
	}
	
}
?>
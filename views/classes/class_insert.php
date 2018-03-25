<?php

class Inserir
{
	private $tabela;
	private $campos;
	
	public function __construct($var_tabela="", $var_campos="")
	{
		$this->tabela = $var_tabela;
		$this->campos = $var_campos;
	}
	
	public function inserir()
	{
		
		$sql = "INSERT INTO $this->tabela VALUES ($this->campos)";
		//echo $sql.'<BR>';
		$resultado = mysql_query($sql) or die(mysql_error());
		
		return $resultado;
	}
	
}
?>
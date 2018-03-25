 <?php

class Alterar
{
	private $tabela;
	private $campos;
	private $condicao;
	
	public function __construct($var_tabela="", $var_campos="", $var_condicao="")
	{
		$this->tabela = $var_tabela;
		$this->campos = $var_campos;
		$this->condicao = $var_condicao;
	}
	
	public function alterar()
	{
		$sql = "UPDATE $this->tabela SET $this->campos WHERE $this->condicao";
		$resultado = mysql_query($sql) or die(mysql_error());
		
		return $resultado;
	}
}
?>
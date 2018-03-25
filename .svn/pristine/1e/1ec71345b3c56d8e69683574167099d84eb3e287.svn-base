<?php
class Banco
{
	private $host;
	private $user;
	private $password;
	private $database;
	private $status;
	
	public function __construct()
	{
		$this->Conectar();
	}
	
	private function Conectar()
	{
		$this->host = "localhost";
		$this->user = "root";
		$this->password = "";
		$this->database = "letrastrocadas";
		
		if(mysql_connect($this->host, $this->user, $this->password))
		{                
			if(mysql_select_db($this->database))
				$this->status = true;
			else
				$this->status = false;
		}
		else
		{
			$this->status = false;
		}
	}
	
	public function StatusConexao()
	{
		return $this->status;
	}
}
?>
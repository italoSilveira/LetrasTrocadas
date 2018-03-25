<?php

class EditarCaracteres
{
	private $str;
	
	function __construct($var_str="")
	{
		$this->str = $var_str;
	}
	
	// São os metódos que tentam evitar o MySql Inject
	
	// Essa classe é especifica para os email, por que ela permite @ e . além de números e letras.
	function sanitizeStringemail($str)
	{
		$str = preg_replace('/[áàãâä]/ui', 'a', $str);
		$str = preg_replace('/[éèêë]/ui', 'e', $str);
		$str = preg_replace('/[íìîï]/ui', 'i', $str);
		$str = preg_replace('/[óòõôö]/ui', 'o', $str);
		$str = preg_replace('/[úùûü]/ui', 'u', $str);
		$str = preg_replace('/[ç]/ui', 'c', $str);
		$str = preg_replace('/[,(),;:|!"#$%><ªº-]/', '', $str);
		$str = preg_replace('/[^@.a-z0-9]/i', '', $str);
		$str = preg_replace('/_+/', '', $str);
		return $str;
	}
	
	function sanitizeString($str)
	{
		$str = preg_replace('/[áàãâä]/ui', 'a', $str);
		$str = preg_replace('/[éèêë]/ui', 'e', $str);
		$str = preg_replace('/[íìîï]/ui', 'i', $str);
		$str = preg_replace('/[óòõôö]/ui', 'o', $str);
		$str = preg_replace('/[úùûü]/ui', 'u', $str);
		$str = preg_replace('/[ç]/ui', 'c', $str);
		$str = preg_replace('/[,(),;:|!"#$%><ªº-]/', '', $str);
		$str = preg_replace('/[^a-z0-9]/i', '', $str);
		$str = preg_replace('/_+/', '', $str);
		return $str;
	}

	function sanitizeNumber($str)
	{
		$str = preg_replace('/[^0-9]/i', '', $str);
		$str = preg_replace('/_+/', '', $str);
		return $str;
	}
	
	// Esse é para todos os campos que contenham nome ou textos
	function sanitizeStringNome($str)
	{
		$str = preg_replace('/[^-ÁÃÂÉÊÍÎÓÔÕÚÛÀàáãâéêíîóõôûúùç., a-z0-9]/i', '', $str);
		$str = preg_replace('/_+/', '', $str);
		return $str;
	}
	
	function Pesquisa($str)
	{
		$str = preg_replace('/[^ÁÃÂÉÊÍÎÓÔÕÚÛáãâéêíîóõôúû a-z0-9]/i', '', $str);
		$str = preg_replace('/[+]/ui', ' ', $str);
		$str = preg_replace('/_+/', '', $str);
		return $str;
	}

	function Url($str)
	{
		$str = preg_replace('/[^áãâéêíîóòõôúûÁÃÂÉÊÍÎÓÔÕÚÛ a-z0-9]/i', '', $str);
		$str = preg_replace('/[ ]/ui', '+', $str);
		$str = preg_replace('/_+/', '', $str);
		return $str;
	}
}
?>
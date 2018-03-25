<?php
	
	// Pega a variavel da url e verifica se ela tem valore	
	if(isset($_GET['situacao']))
	{
		//Deleta todas as sessions 
		unset ($_SESSION['nome']);
		unset ($_SESSION['email']);
		unset ($_SESSION['id']);
		unset ($_SESSION['nivel_acesso']);
		
		//Redireciona para a página de visitantes
		header('location:?url=home_visitante');
	}
	
?>
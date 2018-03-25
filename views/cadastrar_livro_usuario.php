<?php

	if(isset($_POST['confirmaLivroUsuario']))
	{
		include("../classes/class_insert.php");
		
		$cadastrar_autor = new Inserir("tbl_autor",$valores_autor);
		$resposta = $cadastrar_autor->inserir();
		echo "Oi";
		
		$id = $_GET['cod'];
		$ano = $_SESSION['ano'];
		$estado = $_SESSION['estado'];
		$imagem1 = $_SESSION['imagem1'];
		$imagem2 = $_SESSION['imagem2'];
		$imagem3 = $_SESSION['imagem3'];
		
		//Desfazer a minha gambiarra érr quer dizer meu recurso técnico
		/*unset ($_SESSION['livro']);
		unset ($_SESSION['edicao']);
		unset ($_SESSION['isbn']);
		unset ($_SESSION['ano']);
		unset ($_SESSION['estado']);
		unset ($_SESSION['imagem1']);
		unset ($_SESSION['imagem2']);
		unset ($_SESSION['imagem3']);*/
		
		$editar_id = new EditarCaracteres($id);
		$id = $editar_id->sanitizeString($_GET['cod']);
		
		$editar_estado = new EditarCaracteres($estado);
		$estado = $editar_estado->sanitizeStringNome($estado);
		
		$editar_ano = new EditarCaracteres($ano);
		$ano = $editar_ano->sanitizeString($ano);
		
		$campos = "NULL,$id,".$_SESSION['id'].",'$ano','$estado'";	
		$cadastrar_livros = new Inserir("tbl_lista_livros",$campos);
		$resposta = $cadastrar_livros->inserir();
		
	}
	//else
	//{
		//header("location: ?url=index");
	//}

?>
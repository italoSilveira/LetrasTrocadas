<?php

	session_start();
	$nivel = $_SESSION['nivel_acesso'];
	$id = $_SESSION['id'];
	if($nivel == 1)
	{
		include("../views/classes/class_banco.php");
		include("../views/classes/class_pesquisar.php");
		include("../views/classes/class_update.php");
		include("../views/classes/class_insert.php");
		
		$bd = new Banco();
		
		$pesquisar_cambio = new Pesquisar("tbl_cambio","*"," usuario_disponibilizador = ".$id." AND cod_rastreamento <> '' OR usuario_resgate=".$id." AND cod_rastreamento <> ''");
		$resultado_cambio = $pesquisar_cambio->pesquisar();
		if(mysql_num_rows($resultado_cambio) != 0)
		{
			while($dados=mysql_fetch_assoc($resultado_cambio))
			{
				include_once '../views/classes/class_correios.php';
				$c = new Correio($dados['cod_rastreamento']);
				if (!$c->erro)
				{
					if($c->status == "entrega efetuada")
					{
						if(($dados['entregue'] == "") && ($dados['status'] != 3))
						{
							$alterar = new Alterar("tbl_cambio",'entregue = "Sim",status = 3','cod_rastreamento="'.$dados['cod_rastreamento'].'"');
							$resultado = $alterar->alterar();
						}
					}
					else if($c->status == "saiu para entrega ao destinatário")
					{
						if(($dados['entregue'] == "") && ($dados['status'] != 2))
						{
							$alterar = new Alterar("tbl_cambio",'status = 2','cod_rastreamento="'.$dados['cod_rastreamento'].'"');
							$resultado = $alterar->alterar();
						}
					}
					else
					{
					}
				}
			}
		}
		
	}

?>
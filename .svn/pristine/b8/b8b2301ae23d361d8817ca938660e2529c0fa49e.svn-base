<?php
	/*if($_SESSION['nivel_acesso'] == 2)
	{*/
		include("../fpdf/fpdf.php");
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$pesquisar_livros = new Pesquisar("tbl_livro JOIN tbl_livros_trocados ON livro_id = id_livro","nome, quantidade","1=1 ORDER BY quantidade DESC");
		$resul_pesquisar_livro = $pesquisar_livros->pesquisar();
		
		$pdf = new FPDF();		
		$pdf->AddPage();
		$pdf->Image("../content/logo.jpg","170","15","30","22");
		$pdf->SetFont('helvetica','B','16');
		$pdf->Cell('180','40',utf8_decode('Relatório de livros mais trocados no site'),0,0,'C');
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','B','10');
		$pdf->Cell('95','10','Nome',1,'','C');
		$pdf->Cell('95','10','Quantidade',1,'','C');
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','',10);
		
		while($dados = mysql_fetch_assoc($resul_pesquisar_livro)){
		    $pdf->SetFont('helvetica','','10');
		    $pdf->Cell('95','10',$dados['nome'],1,'','C');
		    $pdf->Cell('95','10',$dados['quantidade'],1,'','C');
		    $pdf->Ln();		
		}
				
		$pdf->Output();
	/*}
	else
	{
		if($_SESSION['nivel_acesso'] == 1)
		{
			header('Location:?url=index_usuario');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}*/
?>
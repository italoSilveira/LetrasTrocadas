<?php
	/*if($_SESSION['nivel_acesso'] == 2)
	{*/
		include("../fpdf/fpdf.php");
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$pesquisar_autores_fav = new Pesquisar("tbl_autor autor JOIN tbl_livros_trocados JOIN tbl_livro ON livro_id = id_livro AND autor_id = id_autor","autor.nome, COUNT(*) AS NumLivrosTrocados","1=1 GROUP BY autor.nome ORDER BY COUNT(livro_id) DESC ");
		$resul_autores_fav = $pesquisar_autores_fav->pesquisar();
		
		$pdf = new FPDF();		
		$pdf->AddPage();
		$pdf->Image("../content/logo.jpg","170","15","30","22");
		$pdf->SetFont('helvetica','B','16');
		$pdf->Cell('180','40',utf8_decode('Relatório de Autores Favoritos'),0,0,'C');
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','B','10');
		$pdf->Cell('90','10','Nome',1,'','C');
		$pdf->Cell('90','10',utf8_decode('Número de livros do autor trocados'),1,'','C');		
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','',10);
		
		while($dados = mysql_fetch_assoc($resul_autores_fav)){
		    $pdf->SetFont('helvetica','','10');
		    $pdf->Cell('90','10',utf8_decode($dados['nome']),1,'','C');
		    $pdf->Cell('90','10',$dados['NumLivrosTrocados'],1,'','C');
		    $pdf->Ln();		
		}
				
		$pdf->Output();
	}
	/*else
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
<?php
	/*if($_SESSION['nivel_acesso'] == 2)
	{*/
		include("../fpdf/fpdf.php");
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$pesquisar_generos_fav = new Pesquisar("tbl_usuario","genero_favorito AS Nome_Genero, COUNT(*) AS NumeroDePessoasQueGostam","1=1 GROUP BY genero_favorito");
		$resul_generos_fav = $pesquisar_generos_fav->pesquisar();
		
		$pdf = new FPDF();		
		$pdf->AddPage();
		$pdf->Image("../content/logo.jpg","170","15","30","22");
		$pdf->SetFont('helvetica','B','16');
		$pdf->Cell('180','40',utf8_decode('Relatório de Gêneros Favoritos'),0,0,'C');
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','B','10');
		$pdf->Cell('90','10','Nome',1,'','C');
		$pdf->Cell('90','10',utf8_decode('Número de pessoas que gostam'),1,'','C');		
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','',10);
		
		while($dados = mysql_fetch_assoc($resul_generos_fav)){
		    $pdf->SetFont('helvetica','','10');
		    $pdf->Cell('90','10',$dados['Nome_Genero'],1,'','C');
		    $pdf->Cell('90','10',$dados['NumeroDePessoasQueGostam'],1,'','C');
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
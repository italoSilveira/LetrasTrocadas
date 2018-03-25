<?php
	/*if($_SESSION['nivel_acesso'] == 2)
	{*/
		include("../fpdf/fpdf.php");
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$pesquisar_usu_mal_avaliados = new Pesquisar("tbl_usuario","email,nome,avaliacoes_negativas","1=1 GROUP BY id_usuario ORDER BY avaliacoes_negativas DESC ");
		$resul_usu_mal_avaliados = $pesquisar_usu_mal_avaliados->pesquisar();
		
		$pdf = new FPDF();		
		$pdf->AddPage();
		$pdf->Image("../content/logo.jpg","170","15","30","22");
		$pdf->SetFont('helvetica','B','16');
		$pdf->Cell('180','40',utf8_decode('Relatório de usuários mal avaliados'),0,0,'C');
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','B','10');
		$pdf->Cell('75','10','E-mail',1,'','C');
		$pdf->Cell('75','10','Nome',1,'','C');
		$pdf->Cell('40','10',utf8_decode('Avaliações Negativas'),1,'','C');		
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','',10);
		
		while($dados = mysql_fetch_assoc($resul_usu_mal_avaliados)){
		    $pdf->SetFont('helvetica','','10');
		    $pdf->Cell('75','10',utf8_decode($dados['email']),1,'','C');
		    $pdf->Cell('75','10',utf8_decode($dados['nome']),1,'','C');
			$pdf->Cell('40','10',$dados['avaliacoes_negativas'],1,'','C');
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
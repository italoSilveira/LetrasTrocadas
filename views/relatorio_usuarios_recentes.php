<?php
 
	/*if($_SESSION['nivel_acesso'] == 2)
	{*/

		include("../fpdf/fpdf.php");
		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$bd = new Banco();
		
		$pesquisar_usu_recente = new Pesquisar("tbl_usuario","nome, email, idade, uf, cidade, data_criacao","DATE_FORMAT(data_criacao, '%m-%d') <= DATE_FORMAT(NOW(),'%m-%d') ORDER BY data_criacao desc");
		$resul_pesquisar_usu_recente = $pesquisar_usu_recente->pesquisar();
		
		$pdf = new FPDF();		
		$pdf->AddPage();
		$pdf->Image("../content/logo.jpg","170","15","30","22");
		$pdf->SetFont('helvetica','B','16');
		$pdf->Cell('180','40',utf8_decode('Relatório de usuários mais recentes'),0,0,'C');
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','B','10');
		$pdf->Cell('60','10','E-mail',1,'','C');
		$pdf->Cell('60','10','Nome',1,'','C');
		$pdf->Cell('12','10','Idade',1,'','C');
		$pdf->Cell('10','10','UF',1,'','C');
		$pdf->Cell('20','10','Cidade',1,'','C');
		$pdf->Cell('35','10',utf8_decode('Data de criação'),1,'','C');		
		$pdf->Ln();
		
		$pdf->SetFont('helvetica','',10);
		
		while($dados = mysql_fetch_assoc($resul_pesquisar_usu_recente)){
		    $pdf->SetFont('helvetica','','10');
		    $pdf->Cell('60','10',utf8_decode($dados['email']),1,'','C');
		    $pdf->Cell('60','10',utf8_decode($dados['nome']),1,'','C');
			$pdf->Cell('12','10',$dados['idade'],1,'','C');
			$pdf->Cell('10','10',$dados['uf'],1,'','C');
			$pdf->Cell('20','10',utf8_decode($dados['cidade']),1,'','C');
			$pdf->Cell('35','10',$dados['data_criacao'],1,'','C');
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
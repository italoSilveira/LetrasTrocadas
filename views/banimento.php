<?php

		include("classes/class_banco.php");
		include("classes/class_pesquisar.php");
		
		$banco = new Banco();
		
		$id_den = $_GET['cod_d'];
		$id_usu = $_GET['cod_usu'];
		
		/* Pesquisar ocorrências anteriores do usuário */ 
		
		$campos = "id_usuario, id_denuncias, usu.nome, email, motivo_id, motivo, outro_motivo, data,avaliacoes_negativas, avaliacoes_positivas";
		$tabela = "tbl_usuario usu JOIN tbl_denuncias ON usuario_denunciado_id = id_usuario JOIN tbl_motivos ON motivo_id = id_motivo";
		$condicao = "usuario_denunciado_id = $id_usu GROUP BY id_denuncias ORDER BY data";
		
		$pesquisa_den_usu = new Pesquisar("$tabela","$campos","$condicao");
		$resultado_den_usu = $pesquisa_den_usu->pesquisar();
		//$Dados_Den_Usu = mysql_fetch_assoc($resultado_den_usu);
		
		$pesquisa_numero_den_usu = new Pesquisar("tbl_usuario JOIN tbl_denuncias ON usuario_denunciado_id = id_usuario","COUNT(*) AS total","usuario_denunciado_id = $id_usu");
		$resul_pesquisa_n_den = $pesquisa_numero_den_usu->pesquisar();
		$num_den = mysql_fetch_assoc($resul_pesquisa_n_den);
		
		
?>

<article>
	<section class="panel panel-default" style = "width:96%; margin-left:2%;">
		<section class="panel-heading"><h4>Banimentos<h4></section>
		<section class="row">
			<section class="col-md-6" style="margin-top: 1%;">
				<section class="panel panel-default" style="margin-left: 1%; width: 98%;">
					<section class="panel-heading">Histórico de denuncias do usuário</section>
					<section class="panel-body">
						<section class="list-group">
							<?php while($Dados_Den_Usu = mysql_fetch_assoc($resultado_den_usu)){
							   echo 
							   '<a class="list-group-item">
									<h4 class="list-group-item-heading">'.$Dados_Den_Usu['email'].' - '.$Dados_Den_Usu['data'] .'</h4>
										<p class="list-group-item-text">'.utf8_encode($Dados_Den_Usu['motivo']).'. '.utf8_encode($Dados_Den_Usu['outro_motivo']).'
											<section id = "avaliações" style = "width:50%;">
												<br><label> Avaliações: </label>
													&nbsp  
														<span class= "glyphicon glyphicon-thumbs-up"></span> <span class = "badge">'.$Dados_Den_Usu["avaliacoes_positivas"].'</span> 
													&nbsp
														<span class= "glyphicon glyphicon-thumbs-down"> </span> <span class = "badge">'.$Dados_Den_Usu["avaliacoes_negativas"].'</span>
											</section></p>			
								</a>';
							}
							?>
						</section>
					</section>
				</section>
			</section>
			<section class="col-md-6" style="margin-top: 1%;">
				<section class ="panel panel-default" style="margin-left: 1%; width: 98%;">
					<section class="panel-heading">Medidas</section>
					<section class="panel-body">
						<form method="post" action="">
							<p>
								<?php 
									if($num_den['total'] > 2) echo "Esse usuário já tem mais de 2 denuncias, o que deseja fazer?";
									
									switch($num_den['total'])
										{
											case "0":
												echo "Esse usuário nunca foi denunciado, o que deseja fazer?";
												break;
											case "1":
												echo "Esse usuário já teve uma denuncia, o que deseja fazer?";
												break;
											case "2":
												echo "Esse usuário já foi denunciado duas vezes, o que deseja fazer?";
												break;
										}
								?>
							</p>
							<section class="radio">
								<label> Banir do site por 1 mês</label>
									<input type="radio" name="Ban" id="optionsRadios1" value="1">
							</section>
							<section class="radio">
								<label>Banir conta permanentemente</label>
									<input type="radio" name="Ban" id="optionsRadios3" value="3">    
							</section>
							<section class="radio">
								<label>Emitir aviso de denuncia</label>
									<input type="radio" name="Ban" id="optionsRadios4" value="2">                   
							</section>
							<button type="submit" class="btn btn-primary" name = "btnBanir">
								<span class="glyphicon glyphicon-flag"></span> Banir
							</button>
						</form>
					</section>
				</section>
			</section>
		</section>
	</section>
</article>

<?php

		if(isset($_POST['btnBanir']))
		{
			if($_POST['Ban'] == 1)
			{
				mysql_query("CALL sp_atualiza_status_usu_banido($id_usu)");
				mysql_query("CALL sp_atualiza_status_den($id_den)");
			}
			else if ($_POST['Ban'] == 3)
			{
				mysql_query("CALL sp_atualiza_status_den($id_den)");
				mysql_query("CALL sp_atualiza_status_usu_banido_permanente($id_usu)");
			}
			else 
			{
				mysql_query("CALL sp_atualiza_status_den($id_den)");
			}
		}

?>
<?php
	
	//if($_SESSION['nivel_acesso'] == 2)
	//{
		if(isset($_POST['alterarSenha']))
		{
		    include("classes/class_editar_caracteres.php");
			include("classes/class_update.php");
			include("classes/class_pesquisar.php");
			include("classes/class_banco.php");
			
			$banco = new Banco();
			
			$id = $_SESSION['id'];
			$senhanova = $_POST['senhaNova'];
			
			if(strlen($senhanova) < 8)
			{
				echo '<section class="alert alert-dismissable alert-warning">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<center>
						Sua senha está muito curta, digita uma com, no mínimo, 8 dígitos.
						</center>
					</section>';
			}
			else if(strlen($senhanova) > 16)
			{
				echo '<section class="alert alert-dismissable alert-warning">
						<button type="button" class="close" data-dismiss="alert">×</button>
						<center>
							Sua senha está muito grande, digita uma com, no máximo, 16 dígitos.
						</center>
					</section>';
			}
			else
			{
				$senhaAntiga = $_POST['senhaAtual'];
				$pesquisar = new Pesquisar('tbl_administrador','*','id_administrador = '.$id.' AND senha = "'.$senhaAntiga.'"');
				$resultado = $pesquisar->pesquisar();
				$qt = mysql_num_rows($resultado);
				if($qt == 1)
				{
					$editar_novaSenha = new EditarCaracteres($senhanova);
					$senhanova = utf8_decode($editar_novaSenha->sanitizeString($senhanova));

					$editar_antigaSenha = new EditarCaracteres($senhaAntiga);
					$senhaAntiga = utf8_decode($editar_antigaSenha->sanitizeString($senhaAntiga));
					
					$valores_alterar_senha = "senha ='".$senhanova."'";
					$condicao = "id_administrador = $id AND senha = '$senhaAntiga'";

					$alterar_senha = new Alterar("tbl_administrador", $valores_alterar_senha, $condicao);
					$resposta = $alterar_senha->alterar();
					if($resposta)
					{
						echo '<section class="alert alert-dismissable alert-success">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<center>
									Sua senha foi alterada!
								</center>
							</section>';
					}
					else
					{
						echo '<section class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<center>
									Algum erro inesperado ocorreu, tente mais tarde.
								</center>
							</section>';				
					}
				}
				else
				{
					echo '<section class="alert alert-dismissable alert-warning">
								<button type="button" class="close" data-dismiss="alert">×</button>
								<center>
									Confira se sua senha atual está certa.
								</center>
							</section>';	
				}
			}
		}
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
<script type="text/javascript">
	$(document).ready(function(){
		$('#ConfirmarSenha').blur(function(){
			var confirma = $('#ConfirmarSenha').val();
			var senha = $('#NovaSenha').val();
			if((senha != "") && (confirma != ""))
			{
				if(confirma == senha)
				{
					$('#ConfirmarSenha').attr({'style' : 'background-color:green'});
					$('#NovaSenha').attr({'style' : 'background-color:green'});
					$('#AlterarSenha').removeAttr("disabled");
				}
				else
				{
					$('#ConfirmarSenha').attr({'style' : 'background-color:red'});
					$('#NovaSenha').attr({'style' : 'background-color:red'});
					$('#AlterarSenha').attr({'disabled' : 'disabled'});
				}
			}
			else
			{
				$('#AlterarSenha').attr({'disabled' : 'disabled'});
			}
		})
		$('#NovaSenha').blur(function(){
			var confirma = $('#ConfirmarSenha').val();
			var senha = $('#NovaSenha').val();
			if((senha != "") && (confirma != ""))
			{
				if(confirma == senha)
				{
					$('#ConfirmarSenha').attr({'style' : 'background-color:green'});
					$('#NovaSenha').attr({'style' : 'background-color:green'});
					$('#AlterarSenha').removeAttr("disabled");
				}
				else
				{
					$('#ConfirmarSenha').attr({'style' : 'background-color:red'});
					$('#NovaSenha').attr({'style' : 'background-color:red'});
					$('#AlterarSenha').attr({'disabled' : 'disabled'});
				}
			}
			else
			{
				$('#AlterarSenha').attr({'disabled' : 'disabled'});
			}
		})
	});
</script>
<article id  = "mudar_senha" style = "width:52%;height:20%; position:relative;left:27%;"><!--margin-bottom:17.64%;-->
	<form class="form-horizontal" method = "post" action = "">
		<fieldset id = "legend_senha">
			<legend>Alterar Senha Administrador</legend>
			<section class="form-group">			
				<label for="inputSenhaAntiga" class="col-md-2 control-label">Senha Atual:</label>
				<section class="col-md-10">
					<input type="password" class="form-control" id="inputSenhaT" name = "senhaAtual" required maxlength = "16" placeholder = "Senha Atual">
				</section>
				<label for="inputSenha" class="col-md-2 control-label">Nova senha:</label>
				<section class="col-md-10">
					<input type="password" class="form-control" id="NovaSenha" name = "senhaNova" required placeholder = "Senha" maxlength = "16">
				</section>
				<label for="inputConfirmarSenha" class="col-md-2 control-label">Confirmar nova senha:</label>
				<section class="col-md-10">
					<input type="password" class="form-control" id="ConfirmarSenha" name = "confirmaSenha" required placeholder = "Senha" maxlength = "16">
				</section>
				<section class="col-md-10 col-md-offset-2">
					<button type="submit" id="AlterarSenha" disabled name = "alterarSenha" class="btn btn-primary">Salvar Alterações</button>
					<input type = "reset" class="btn btn-default" value="Limpar"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>
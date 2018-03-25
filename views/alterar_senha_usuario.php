<?php
	
	if($_SESSION['nivel_acesso'] == 1)
	{
		if(isset($_POST['alterarSenha']))
		{
		    include("classes/class_editar_caracteres.php");
			include("classes/class_update.php");
			include("classes/class_banco.php");
			
			$banco = new Banco();
			
			$id = $_SESSION['id'];
			$senhaNova = $_POST['senhaNova'];
			$senhaAntiga = $_POST['senhaAtual'];
			
			$valores_alterar_senha = "senha ='$senhanova'";
			$condicao = "id_usuario = $id AND senha = '$senhaAntiga'";
			
			if(strlen($senhanova) < 8)
			{
				echo '<section class="alert alert-dismissable alert-warning">
						<button type="button" class="close" data-dismiss="alert">×</button>
						Sua senha está muito curta, digita uma com, no mínimo, 8 dígitos.
					</section>';
			}
			else if(strlen($senhanova) > 16)
			{
				echo '<section class="alert alert-dismissable alert-warning">
						<button type="button" class="close" data-dismiss="alert">×</button>
						Sua senha está muito grande, digita uma com, no máximo, 16 dígitos.
					</section>';
			}
			else
			{
				$alterar_senha = new Alterar("tbl_usuario", $valores_alterar_senha, $condicao);
				$resposta = $alterar_senha->alterar();
				
				if($resposta)
				{
					echo '<section class="alert alert-dismissable alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Sua senha foi alterada!
						</section>';
				}
				else
				{
					echo '<section class="alert alert-dismissable alert-warning">
							<button type="button" class="close" data-dismiss="alert">×</button>
							Confira se sua senha antiga está certa. Se estiver, tente mais tarde.
						</section>';	
				}
			}
		}
	}
	else
	{
		if($_SESSION['nivel_acesso'] == 2)
		{
			header('Location:?url=home_admin');
		}
		else
		{
			header('Location:?url=home_visitante');
		}
	}
	
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
<article id  = "mudar_senha" style = "width:51%;height:20%; position:relative;left:27%;">
	<form class="form-horizontal" method = "post" action = "">
		<fieldset id = "legend_senha">
			<legend>Alterar senha</legend>
			<section class="form-group">
				<label for="inputSenhaAntiga" class="col-lg-2 control-label">Senha Atual</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" name = "senhaAtual" id="inputSenhaT" required maxlength = "16" placeholder = "Senha Atual">
				</section>
				<label for="inputSenha" class="col-lg-2 control-label">Nova senha</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" id="NovaSenha" name = "senhaNova" required placeholder = "Senha" maxlength = "16">
				</section>
				<label for="inputConfirmarSenha" class="col-lg-2 control-label">Confirmar nova senha</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" id="ConfirmarSenha" name = "confirmaSenha" required placeholder = "Senha" maxlength = "16">
				</section>	
				<section class="col-lg-10 col-lg-offset-2">
					<button type="submit" class="btn btn-primary" id="AlterarSenha" disabled name = "alterarSenha">Salvar alterações</button>
					<button type = "reset "class="btn btn-default">Cancelar</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>
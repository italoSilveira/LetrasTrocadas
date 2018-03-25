<script type="text/javascript">

	$(document).ready(function(){
		$("#DesativarConta").click(function(){
			var valor = document.getElementById('Senha').value;
			var valor_confirmar = document.getElementById('ConfirmarSenha').value;
			
				if(valor != '')
				{
					if(valor == valor_confirmar)
					{
						$("#myModal").modal('show');
					}
				}
		})
		
		$("#confirmar_solicitação").click(function(){
		
			document.desativarconta.submit();
		
		})
		
	})

</script>

<?php

	if(ISSET($_POST['senha']) && ISSET($_POST['confirmarSenha']))
	{
		include("classes/class_banco.php");
		include("class_editar_caracteres.php");
		include("classes/class_update.php");
		include("classes/class_pesquisar.php");
			
		$bd = new Banco();
		
		$senha = $_POST['senha'];
		
		$editar_senha = new EditarCaracteres($senha);
		$senha = $editar_senha->sanitizeStringNome($_POST['senha']);
		
		$pesquisar_pendente = new Pesquisar('tbl_usuario','id_usuario',"senha = '".$senha."' AND id_usuario=".$_SESSION['id']." LIMIT 1");
		$resultado_pendente = $pesquisar_pendente->pesquisar();
		if(mysql_num_rows($resultado_pendente) == 1)
		{
			$alterar_status = new Alterar('tbl_usuario','status = 2',"id_usuario=".$_SESSION['id']);
			$resposta = $alterar_status->alterar();
			if(mysql_num_rows($resultado_pendente) == 1)
			{
				unset ($_SESSION['nome']);
				unset ($_SESSION['email']);
				unset ($_SESSION['id']);
				unset ($_SESSION['nivel_acesso']);
				header("Location:?url=home_visitante");
			}
			else
			{
				echo "Ops! Ocorreu um erro no momento da desativação, por favor, contate nossos administradores!";
			}
		}
		else
		{
			echo "Senha e usuários incorretos.";
		}
		
	}
	
?>

<article id  = "mudar_senha" style = "width:51%;height:20%; position:relative;left:17%;">
	<form class="form-horizontal" name = "desativarconta" method = "post" action = "">
		<fieldset id = "desativar_conta">
			<legend>Desativar conta</legend>
			<section class="form-group">
				<label for="Senha" class="col-lg-2 control-label">Senha</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" name = "senha" id="Senha" required maxlength = "16" placeholder = "Senha">
				</section>
				<label for="ConfirmarSenha" class="col-lg-2 control-label">Confirmar senha</label>
				<section class="col-lg-10">
					<input type="password" class="form-control" name = "confirmarSenha" id="ConfirmarSenha" required maxlength = "16" placeholder = "Confirmar senha">
				</section>
				<section class="col-lg-10 col-lg-offset-2">
					<br>
					<input type="button" class="btn btn-primary" name = "Desativar_Conta" id="DesativarConta" value = "Desativar Conta"/>
				</section>
			</section>
		</fieldset>
	</form>
</article>

<section class="modal" id="myModal">
	<section class="modal-dialog">
		<section class="modal-content">
			<section class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title">Desativar conta</h4>
			</section>
			<section class="modal-body">
				<p id = "TextDialog" >Você tem certeza? Desativar sua conta é uma ação permanente.</p>
			</section>
			<section class="modal-footer">
				<button id = "confirmar_solicitação" class="btn btn-primary">Sim</button>
				<button id = "cancelar" class="btn btn-default" data-dismiss="modal">Não</button>
			</section>
		</section>
	</section>
</section>
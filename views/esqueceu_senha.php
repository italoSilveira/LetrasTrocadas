<?php

		include("classes/class_pesquisar.php");
		include("classes/class_banco.php");
		
		//Instancia e faz conexão com o banco de dados
		$banco = new Banco();
		
		if(isset($_POST['enviar']))
		{
		$email = $_POST['email'];
		
		
		$pesquisar_email = new Pesquisar("tbl_usuario","senha","email ='$email'");
	$resultado = $pesquisar_email->pesquisar();	
	$senha = $resultado;
	
	#IF
	
	
	
	$subjectPrefix = '[Suporte Letras Trocadas]';
	$emailTo = '$email';


		$name    = '';
		$email   = '$email';
		$subject = 'Esqueci minha senha.';
		$message = 'Olá, <Br /> Aqui está sua senha: $senha<Br /> Indicamos a você que guarde sua senha em um lugar seguro, Lembre tambem que ela e pessoal.<Br /> E-mail automático favor não responder. Att.: Suporte Letras Trocadas';
		$pattern  = '/[\r\n]|Content-Type:|Bcc:|Cc:/i';
	
		if (preg_match($pattern, $name) || preg_match($pattern, $email) || preg_match($pattern, $assunto)) 
			{
				die("Header injection detected");
			}
	
		$emailIsValid = preg_match('/^[^0-9][A-z0-9._%+-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', $email);
	
		if($name && $email && $emailIsValid && $subject && $message)
			{
				$subject = "$subjectPrefix $subject";
				$body = "$message";
		
				$headers  = 'MIME-Version: 1.1' . PHP_EOL;
				$headers .= 'Content-type: text/html; charset=utf-8' . PHP_EOL;
				$headers .= "From: $name <$email>" . PHP_EOL;
				$headers .= "Return-Path: $emailTo" . PHP_EOL;
				$headers .= "Reply-To: $email" . PHP_EOL;
				$headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
		
				mail($emailTo, $subject, $body, $headers);
				$emailSent = true;
			} 
		else 
			{
				$hasError = true;
			}
	
	

	
	
	
	
		
		
}
?>



<article style="width: 60%; margin-left: 20%;">	
	<form class="form-horizontal" method = "post" action = "">
		<fieldset>
			<legend>Esqueceu senha</legend>			
			<section class="form-group">		
				<label for="inputEmail" class="col-lg-2 control-label">E-mail</label>
				<section class="col-lg-10">	 
					<input type="email" class="form-control"  name = "email" id="email" required placeholder = "Digite seu e-mail" maxlength = "100">			  
				</section>
				<section class="col-lg-10 col-lg-offset-2">
						<span style="float: right;">
							<button type="submit" name = "enviar" class="btn btn-primary">Enviar</button>
							<button type = "reset" class="btn btn-default">Limpar</button>
						</span>
				</section>
			</section>
		</fieldset>
	</form>
</article>
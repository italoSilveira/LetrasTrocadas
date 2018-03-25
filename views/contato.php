<?php
	$subjectPrefix = '[Contato Site]';
	$emailTo = 'contato@letrastrocadas.com.br';

	if($_SERVER['REQUEST_METHOD'] == 'POST') 
	{
		$name    = stripslashes(trim($_POST['inputNome']));
		$email   = stripslashes(trim($_POST['inputEmail']));
		$subject = stripslashes(trim($_POST['inputAssunto']));
		$message = stripslashes(trim($_POST['inputMenssagem']));
		$pattern  = '/[\r\n]|Content-Type:|Bcc:|Cc:/i';
	
		if (preg_match($pattern, $name) || preg_match($pattern, $email) || preg_match($pattern, $assunto)) 
		{
			die("Header injection detected");
		}
	
		$emailIsValid = preg_match('/^[^0-9][A-z0-9._%+-]+([.][A-z0-9_]+)*[@][A-z0-9_]+([.][A-z0-9_]+)*[.][A-z]{2,4}$/', $email);
	
		if($name && $email && $emailIsValid && $subject && $message)
		{
			$subject = "$subjectPrefix $subject";
			$body = "Nome: $name <br /> Email: $email <br /> Mensagem: $message";
	
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
<article id  = "body_contato" style = "width:60%;position:relative;left:20%;">
	<form class="form-horizontal" method = "post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
		<fieldset id = "legend_senha">

			<legend>Contato</legend>
			<?php if(isset($emailSent) && $emailSent): ?>
			<section class="col-md-6 col-md-offset-3">
				<section class="alert alert-success text-center">Sua mensagem foi enviada com sucesso.</section>
			</section>
			<?php else: ?>
			<?php if(isset($hasError) && $hasError): ?>
			<section class="col-md-5 col-md-offset-4">
				<section class="alert alert-danger text-center">Houve um erro no envio, tente novamente mais tarde.</section>
			</section>
			<?php endif; ?>
			<section class="form-group">
				<label for="inputNome" class="col-lg-2 control-label">Nome:</label>
				<section class="col-lg-10">
					<input type="text" class="form-control" id="inputNome" name="inputNome" required maxlength = "100" placeholder = "Nome">			  
				</section>
				<label for="inputEmail" class="col-lg-2 control-label">E-Mail:</label>
				<section class="col-lg-10">
					<input type="email" class="form-control" id="inputEmail" name="inputEmail" required  placeholder = "E-Mail">			  
				</section>
				<label for="inputAssunto" class="col-lg-2 control-label">Assunto:</label>		  
				<section class="col-lg-10">
					<input type="text" class="form-control" id="inputAssunto" name="inputAssunto" required placeholder = "Assunto" maxlength = "100">	  
				</section>
				<label for="textArea" class="col-lg-2 control-label">Mensagem:</label>
				<section class="col-lg-10">
					<textarea class="form-control" rows="3" id="inputMenssagem" name="inputMenssagem" placeholder = "Escreva aqui o que deseja"></textarea> 
					<p>Ou envie um e-mail para: contato@letrastrocadas.com.br</p>
				</section>
				<section class="col-lg-10 col-lg-offset-2">
					<button style="float:right;" type="submit" id="enviar" name="enviar" class="btn btn-primary">Enviar</button>
					<button style="margin-left: 5px; float:right;" type = "reset" name="reset" class="btn btn-default">Cancelar</button>
				</section>
			</section>
		</fieldset>
	</form>
</article>
<?php endif; ?>
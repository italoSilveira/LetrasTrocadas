<?php
	session_start();
?>
<!DOCTYPE HTML>
<html lang="pt-br">
	<head>

		<title>Letras Trocadas</title>
		<link rel="shortcut icon" href="content/ico/favicon.ico">
		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		
		<!-- Bootstrap -->
		<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css"/>
		<!--Footer-->
		<link rel="stylesheet" type="text/css" href="bootstrap/sticky-footer.css">
		<!-- Include all compiled plugins (below), or include insectionidual files as needed -->
		<script src="scripts/jquery.min.js"></script>
		<script src="scripts/bootstrap.min.js"></script>
		<script src="scripts/jquery.forms.min.js"></script>
		
		<style>
			body { padding-top: 70px; }
		</style>
		
	</head>
	<header>   
		<?php 
			
			if(empty($_SESSION['email']))
			{
				@include("views/base/header_visitante.php");
			}
			else
			{	
				$nivel_acesso = $_SESSION["nivel_acesso"];
				if($nivel_acesso == 1)
				{
					@include("views/base/header_usuario.php");
					echo "
						<style type='text/css'>

							p
							{
								margin-top:0%;
							}

							#notificações1
							{
								text-align:center;
								width:20%;
								height: 15%;
								position: fixed;
								left: 76%;
								margin-top:35%;
								display:none;
								z-index:5000;
							}
							
							#notificações2
							{
								text-align:center;
								height: 15%;
								width:20%;
								position: fixed;
								left: 76%;
								margin-top:27%;
								display:none;
								z-index:5000;
							}
							
							#notificações3
							{
								text-align:center;
								height: 15%;
								width:20%;
								position: fixed;
								left: 76%;
								margin-top:19%;
								display:none;
								z-index:5000;
							}
							
						</style>
						<script type = 'text/javascript'>	
						
							var inicio = setInterval('Sidebar()', 0000);
							var inicio_notificações = setInterval('Notificações()', 0000);
							var inicio_Codigo = setInterval('Codigo()', 0000);
							var intervalo = setInterval('Sidebar()', 5000);
							var notificações = setInterval('Notificações()', 5000);
							var codigo = setInterval('Codigo()', 1800000);
	
							function Notificações()
							{
								$.ajax({
								
									url : 'ajax/notificacoes.php',
									dataType : 'json',
									async: false,
									success : function(data){
									$('#notificações').html(data.retorno);
									$('#notificações1').fadeIn('slow');
									$('#notificações2').fadeIn('slow');
									$('#notificações3').fadeIn('slow');
										
									},
									error : function(data){
									alert('Ops! Ocorreu um erro nas notificações, contate nossos administradores para mais informações.');
									}
									
								});
								clearInterval(inicio_notificações);
							}
							
							function Codigo()
							{
								
								$.ajax({
									url : 'ajax/atualizar_cambio.php',
									dataType : 'json',
									async: false,
									success : function(data){
									},
									error : function(data){
									}
								
								});
								clearInterval(inicio_Codigo);
							}
							
							function Sidebar()
							{
								
								$.ajax({
									url : 'ajax/sidebar.php',
									dataType : 'json',
									async: false,
									success : function(data){
										document.getElementById('Moedas').innerHTML = data.moedas;
										$('#Trocas_aceitas').html(data.trocas_aceitas);
										$('#Solicitacoes_recebidas').html(data.solicitacoes_recebidas);
										$('#CadeMeusLivros').html(data.trocas_aceitas);
									},
									error : function(data){
									alert('Ops! Ocorreu um erro com sua sidebar, contate nossos administradores para mais informações.');
									}
								
								});
								clearInterval(inicio);
							}						
			
						</script>";
						
					echo '<section id = "notificações">
						</section>';
				}
				else
				{
					@include("views/base/header_admin.php");
				}
			}
		?>
	</header>
	<body>
		<?php			
			//Verifica se ha alguma pagina selecionada
			if(isset($_GET["url"])){
				//verifica se a pagina veio com extencao, se nao concatena a ext php.
				$arquivo = $_GET["url"].(preg_match('/.php/i',$_GET["url"],$matches,PREG_OFFSET_CAPTURE) ? "" : ".php");		
				//Tenta anexar a pagina, senao imprime a mensagem de pagina nao encontrada
				if(!@include('views/'.$arquivo))
					echo "Pagina nao encontrada!";
			}
			else
			{
				if(empty($_SESSION['email']))
				{
					@include("views/home_visitante.php");
				}
				else
				{
					if($_SESSION["nivel_acesso"] == 1)
					{
						@include("views/index_usuario.php");
					}
					else
					{
						@include("views/home_admin.php");
					}
					
				}
			}
		?>
	</body>
	<footer>
		<?php
			//@include("views/base/footer.php");
		?>
	</footer>
</html>
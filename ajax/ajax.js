function CriaRequest()
{ 
	try
	{
		request = new XMLHttpRequest(); 
	}
	catch (IEAtual)
	{ 
		try
		{ 
			request = new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch(IEAntigo)
		{
			try
			{ 
				request = new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch(falha)
			{ 
				request = false; 
			} 
		} 
	} 
	if (!request)
	alert("Seu Navegador não suporta Ajax!");
	else return request;
}

function AcoesLivro(id,acao,section,tabela)
{
	var xmlreq = CriaRequest();
	// Iniciar uma requisição
	xmlreq.open("GET", "ajax/acoes_livros.php?acao="+acao+"&id="+id+"&tabela="+tabela, true); 
	// Atribui uma função para ser executada sempre que houver uma mudança de ado
	xmlreq.onreadystatechange = function()
	{
		// Verifica se foi concluído com sucesso e a conexão fechada (readyState=4) 
		if (xmlreq.readyState == 4)
		{ 
			// Verifica se o arquivo foi encontrado com sucesso
			if (xmlreq.status == 200)
			{ 
				var texto = xmlreq.responseText;
				document.getElementById(section).innerHTML = texto;
			}
			else
			{ 
				var texto = "Erro: " + xmlreq.statusText;
				$(section).text(texto).attr({
					title:texto
				});
			}
		} 
	};
	xmlreq.send(null);
}

function NovaListaDesejo(id,id_antigo,pagina)
{
	
	if(id !== "None")
	{
		// inicio uma requisição
		$.ajax({
		// url para o arquivo json.php
			url : "ajax/lista_desejo.php?lista="+id+"&acao=Novo",
		// dataType json
			dataType : "json",
		// função para o sucesso
			success : function(data){
				pagina++;
				document.getElementById('pag_inicial_livros_desejados').innerHTML = data.tabela;
				$("#li_antigo").attr({"class" : "previous"});
				$("#a_antigo").attr({"onClick" : "AntigaListaDesejo('"+id_antigo+"','"+pagina+"')"});
				var novo = data.novo;
				if(novo == "Sim")
				{
					$('#a_novo').attr({"onClick" : "NovaListaDesejo('"+data.ultimo_id+"','"+data.primeiro+"','"+pagina+"')"});
				}
				else
				{
					$('#a_novo').attr({
					'onClick' : "NovaListaDesejo('None','None','"+pagina+"')"
					});
					$('#li_novo').attr({
					'class' : "next disabled"
					});
				}
				$('html,body').animate({scrollTop: 0},'slow');
			},
			// função para o erro
			error : function(data){
			alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
			}
			
		});//termina o ajax
		
	}
}

function AntigaListaDesejo(id,paginas)
{
	// inicio uma requisição
	$.ajax({
	// url para o arquivo json.php
		url : "ajax/lista_desejo.php?lista="+id+"&acao=Antigo",
	// dataType json
		dataType : "json",
	// função para o sucesso
		success : function(data){
			paginas--;
			$('#a_novo').attr({"onClick" : "NovaListaDesejo('"+data.ultimo_id+"','"+id+"','"+paginas+"')"});
			$('#li_novo').attr({"class" : "next"})
			$('html,body').animate({scrollTop: 0},'slow');
			document.getElementById('pag_inicial_livros_desejados').innerHTML = data.tabela;
			if(paginas > 1)
			{
				$("#li_antigo").attr({"class" : "previous"});
				$("#a_antigo").attr({"onClick" : "AntigaListaDesejo('"+data.primeiro+"','"+paginas+"')"});
			}
			else
			{
				$("#li_antigo").attr({"class" : "previous disabled"});
				$("#a_antigo").attr({"onClick" : ""});
			}
				
		},
		// função para o erro
		error : function(data){
		alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
		}
		
	});//termina o ajax
}

function NovaDisponibilizados(id,id_antigo,pagina)
{
	if(id !== "None")
	{
		// inicio uma requisição
		$.ajax({
		// url para o arquivo json.php
			url : "ajax/ultimos_disponibilizados.php?lista_lvro="+id+"&acao=Novo",
		// dataType json
			dataType : "json",
		// função para o sucesso
			success : function(data){
				pagina++;
				document.getElementById('pag_inicial_livros_ultimos_disponibilizados').innerHTML = data.tabela;
				$("#li_ultimos_antigo").attr({"class" : "previous"});
				$("#a_ultimos_antigo").attr({"onClick" : "AntigaDisponibilizados('"+id_antigo+"','"+pagina+"')"});
				var novo = data.novo;
				if(novo == "Sim")
				{
					$('#a_ultimos_novo').attr({"onClick" : "NovaDisponibilizados('"+data.ultimo_id+"','"+data.primeiro+"','"+pagina+"')"});
				}
				else
				{
					$('#a_ultimos_novo').attr({
					'onClick' : "NovaDisponibilizados('None','None','"+pagina+"')"
					});
					$('#li_ultimos_novo').attr({
					'class' : "next disabled"
					});
				}
				$('html,body').animate({scrollTop: 0},'slow');
			},
			// função para o erro
			error : function(data){
			alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
			}
			
		});//termina o ajax
		
	}
}

function AntigaDisponibilizados(id,pagina)
{
	// inicio uma requisição
	$.ajax({
	// url para o arquivo json.php
		url : "ajax/ultimos_disponibilizados.php?lista_lvro="+id+"&acao=Antigo",
	// dataType json
		dataType : "json",
	// função para o sucesso
		success : function(data){
			pagina--;
			$('#a_ultimos_novo').attr({"onClick" : "NovaDisponibilizados('"+data.ultimo_id+"','"+id+"','"+pagina+"')"});
			$('#li_ultimos_novo').attr({"class" : "next"})
			$('html,body').animate({scrollTop: 0},'slow');
			document.getElementById('pag_inicial_livros_ultimos_disponibilizados').innerHTML = data.tabela;
			if(pagina > 1)
			{
				$("#li_ultimos_antigo").attr({"class" : "previous"});
				$("#a_ultimos_antigo").attr({"onClick" : "AntigaDisponibilizados('"+data.primeiro+"','"+pagina+"')"});
			}
			else
			{
				$("#li_ultimos_antigo").attr({"class" : "previous disabled"});
				$("#a_ultimos_antigo").attr({"onClick" : ""});
			}
				
		},
		// função para o erro
		error : function(data){
		alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
		}
		
	});//termina o ajax
}

function SolicitarLivro(livro,usuario)
{
	// inicio uma requisição
	$.ajax({
	// url para o arquivo json.php
		url : "ajax/caixa_dialogo.php?livro="+livro+"&usuario="+usuario,
	// dataType json
		dataType : "json",
	// função para o sucesso
		success : function(data){
		document.getElementById('myModal').innerHTML =  data.section;
		$('#myModal').modal('show');
		},
		// função para o erro
		error : function(data){
		alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
		}
		
	});//termina o ajax
	
	
}

function ConfirmarSolicitacao(livro,usuario)
{

	$.ajax({
		
		url : "ajax/solicitar_livro.php?livro="+livro+"&usuario="+usuario,
		dataType : "json",
		success : function(data){
		document.getElementById('TextDialog').innerHTML =  data.resposta;
		$('#confirmar_solicitação').hide();
		$('button#cancelar').text('Ok');
		},
		error : function(data){
		alert("Ops! Ocorreu um erro, contate nossos administradores para mais informações.");
		}
	
	});
	
}
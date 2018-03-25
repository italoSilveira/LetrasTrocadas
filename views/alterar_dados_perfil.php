<script type="text/javascript" >
	
	function RemoverGêneroFav(objeto)
	{
		var id = $(objeto).attr('id');
		$.ajax({				
			url : 'ajax/generos.php?genero='+id+'&acao=Favoritos&eliminar=Eliminar',
			dataType : 'json',
			success : function(data){
				$(objeto).remove();
			}
		});
	}
	
	function RemoverGêneroChatos(objeto)
	{
		var id = $(objeto).attr('id');
		$.ajax({				
			url : 'ajax/generos.php?genero='+id+'&acao=Chatos&eliminar=Eliminar',
			dataType : 'json',
			success : function(data){
				$(objeto).remove();
			}
		});
	}
	
	function RemoverAutoresFavoritos(objeto)
	{
		var id = $(objeto).attr('id');
		$.ajax({				
			url : 'ajax/autores.php?autor='+id+'&acao=Favoritos&eliminar=Eliminar',
			dataType : 'json',
			success : function(data){
				$(objeto).remove();
			}
		});
	}
	
	function RemoverAutoresChatos(objeto)
	{
		var id = $(objeto).attr('id');
		$.ajax({				
			url : 'ajax/autores.php?autor='+id+'&acao=Chatos&eliminar=Eliminar',
			dataType : 'json',
			success : function(data){
				$(objeto).remove();
			}
		});
	}
	
	function AdicinoarGêneroFav()
	{
		var id = $('#GênerosFavoritos').val();
		
		$.ajax({				
			url : 'ajax/generos.php?genero='+id+'&acao=Favoritos',
			dataType : 'json',
			success : function(data){
				var opcao = document.getElementById("GênerosFavoritos").options[document.getElementById("GênerosFavoritos").selectedIndex].text
				var texto = '<li ondblclick="RemoverGêneroFav(this)" class="list-group-item" id="'+id+'">'+opcao+'</li>';
				$('#GênerosFav').append(texto);
				$("#GênerosFavoritos option[value='"+id+"']").remove();
				$("#GênerosChatos option[value='"+id+"']").remove();				
			}
		});		
	}
	
	function AdicinoarAutoresFav()
	{
		var id = $('#AutoresFavoritos').val();
		
		$.ajax({				
			url : 'ajax/autores.php?autor='+id+'&acao=Favoritos',
			dataType : 'json',
			success : function(data){
				var opcao = document.getElementById("AutoresFavoritos").options[document.getElementById("AutoresFavoritos").selectedIndex].text
				var texto = '<li ondblclick="RemoverAutoresFavoritos(this)" class="list-group-item" id="'+id+'">'+opcao+'</li>';
				$('#AutoresFav').append(texto);
				$("#AutoresFavoritos option[value='"+id+"']").remove();
				$("#AutoresChatos option[value='"+id+"']").remove();
			}
		});		
	}
	
	function AdicinoarGênerosChatos()
	{
		var id = $('#GênerosChatos').val();
		
		$.ajax({				
			url : 'ajax/generos.php?genero='+id+'&acao=Chatos',
			dataType : 'json',
			success : function(data){
				var opcao = document.getElementById("GênerosChatos").options[document.getElementById("GênerosChatos").selectedIndex].text
				var texto = '<li ondblclick="RemoverGêneroChatos(this)" class="list-group-item" id="'+id+'">'+opcao+'</li>';
				$('#GêneroChato').append(texto);
				$("#GênerosChatos option[value='"+id+"']").remove();
				$("#GênerosFavoritos option[value='"+id+"']").remove();				
			}
		});		
	}
	
	function AdicinoarAutoresChatos()
	{
		var id = $('#AutoresChatos').val();
		
		$.ajax({				
			url : 'ajax/autores.php?autor='+id+'&acao=Chatos',
			dataType : 'json',
			success : function(data){
				var opcao = document.getElementById("AutoresChatos").options[document.getElementById("AutoresChatos").selectedIndex].text
				var texto = '<li ondblclick="RemoverAutoresChatos(this)" class="list-group-item" id="'+id+'">'+opcao+'</li>';
				$('#AutorChato').append(texto);
				$("#AutoresChatos option[value='"+id+"']").remove();
				$("#AutoresFavoritos option[value='"+id+"']").remove();
			}
		});		
	}

	var UploadFoto = function()
	{	
		$("#frm_upload").ajaxSubmit(
			{
				url: 'ajax/upload.php', 
				type: 'post',					
				dataType  : "json",
				success : function( data ){ RetornaImagem(data.caminho,data.caminho_a);},
				resetForm : false
			}
		);	
	}
	
	var RetornaImagem = function(caminho,outro){
		$.post("ajax/abre_imagem.php",{caminho : caminho}, function(data){
				$("#img_perfil").attr("src", data.imagem);
				$("#caminho").attr("value", outro);
			}
		);
	}
	
	function PegarCep()
	{
		var cep = $('#cep').val();

		$.ajax({				
			url : 'http://cep.correiocontrol.com.br/'+ cep +'.json',
			dataType : 'json',
			success : function(data){
				$('#inputCidade').attr({'value': data.localidade, 'text' : data.localidade});	
				$('#logradouro').attr({'value': data.logradouro, 'text' : data.logradouro});
				$('#bairro').attr({'value': data.bairro, 'text' : data.bairro});
				$('#inputUF').attr({'value': data.uf, 'text' : data.uf});
									
			},
			error : function(data){
			alert('Ops! Ocorreu um erro na verificação do cep. Confira se o cep está no formado correto (Só números).');
			$('#cep').focus();
			}
		});
	}
</script>
<?php
	
	include("classes/class_pesquisar.php");
	include("classes/class_insert.php");
	include("classes/class_banco.php");
	
	//Instancia e faz conexão com o banco de dados
	$banco = new Banco();
	
	$id = $_SESSION['id'];
	
	if(isset($_POST['alterarDados']))
	{		
		include("classes/class_editar_caracteres.php");
		include("classes/class_update.php");
		include("classes/class_delete.php");
		
		//Repassa os valores enviados pelo formulário para uma variável
		$nome = $_POST['nome'];
		$data_nasc = $_POST['data_nascimento'];
		$logradouro = $_POST['logradouro'];
		$numero = $_POST['numero'];
		$cep = $_POST['cep'];
		$uf = $_POST['inputUF'];
		$complemento = $_POST['complemento'];
		$cidade = $_POST['cidade'];
		$bairro = $_POST['bairro'];	
		$nova_imagem = $_POST['caminho'];
		$explode = explode('.',$nova_imagem);
		$imagem = $nova_imagem;
		
		//Instancia a classe que tenta evitar o MySql Inject
		$editar_nome = new EditarCaracteres($nome);
		$nome = $editar_nome->sanitizeStringNome($_POST['nome']);
		
		//Instancia e passa os valores para a classe de Update 
		$valores_altera_dados_perfil = "nome = '" .utf8_decode($nome). "',
		status = 4,
		foto = '".$imagem."',
        data_nasc = '".$data_nasc."',
		logradouro = '".utf8_decode($logradouro)."',
		numero = ".$numero.",
		cep = '".$cep."',
		cidade = '".utf8_decode($cidade)."',
		bairro = '".utf8_decode($bairro)."',
		uf = '".$uf."',
		complemento = '".utf8_decode($complemento)."'";
		
		$condicao = "id_usuario =".$id."";
		$alterar_dados = new Alterar("tbl_usuario",$valores_altera_dados_perfil, $condicao);
		$resposta = $alterar_dados->alterar();
		
		$idade = mysql_query("call calc_idade($id)");
		
		$_SESSION['status'] = "4";
		
		echo "<section class='alert alert-dismissable alert-success' style='width:40%;margin-left:30%;'>					  
				<center><strong>Seus dados foram atualizados!</strong></center>
			</section>";
	}
	
	//Pega os dados para mostrar no formulário
		
	$pesquisa_dados = new Pesquisar("tbl_usuario","data_nasc,foto,nome,logradouro,cidade,bairro,cep,uf,complemento,numero"," id_usuario = $id;");
	$resultado_pesquisa_dados = $pesquisa_dados->pesquisar();
	$dados_usu = mysql_fetch_assoc($resultado_pesquisa_dados);
	
	$pesquisa_generos = new Pesquisar("tbl_categoria","*"," 1=1 GROUP BY nome ASC");
	$resul_pesq_genero = $pesquisa_generos->pesquisar();
	
	$pesquisar_autor = new Pesquisar('tbl_autor','*','1=1 GROUP BY nome ASC');
	$resultado_autor = $pesquisar_autor->pesquisar();

	$pesquisa_generos_fav = new Pesquisar('tbl_generos_favoritos JOIN tbl_categoria ON id_categoria = categoria_id','*',"usuario_id = $id GROUP BY nome ORDER BY nome");
	$res_genero_fav = $pesquisa_generos_fav->pesquisar();

	$pesquisa_autor_fav = new Pesquisar('tbl_autores_favoritos JOIN tbl_autor ON id_autor = autor_id','*',"usuario_id = $id GROUP BY nome ORDER BY nome");
	$res_autor_fav = $pesquisa_autor_fav->pesquisar();

	$pesquisa_generos_des = new Pesquisar('tbl_generos_desapreciados JOIN tbl_categoria ON id_categoria = genero_id','*',"usuario_id = $id GROUP BY nome ORDER BY nome");
	$res_genero_des = $pesquisa_generos_des->pesquisar();

	$pesquisa_autor_des = new Pesquisar('tbl_autores_desapreciados JOIN tbl_autor ON id_autor = autor_id','*',"usuario_id = $id GROUP BY nome ORDER BY nome");
	$res_autor_des = $pesquisa_autor_des->pesquisar();
	
	//Para os select
	
	$pesquisa_genero = new Pesquisar("tbl_categoria","*",'
	id_categoria NOT IN (SELECT genero_id FROM tbl_generos_desapreciados WHERE usuario_id = '.$_SESSION['id'].')
	AND id_categoria NOT IN (SELECT categoria_id FROM tbl_generos_favoritos WHERE usuario_id = '.$_SESSION['id'].') GROUP BY nome ASC');
	$res_select_genero = $pesquisa_genero->pesquisar();
	$res_select_genero2 = $pesquisa_genero->pesquisar();
	
	$pesquisar_autores = new Pesquisar('tbl_autor','*',
	'id_autor NOT IN (SELECT autor_id FROM tbl_autores_desapreciados WHERE usuario_id = '.$_SESSION['id'].') 
	AND id_autor NOT IN (SELECT autor_id FROM tbl_autores_favoritos WHERE usuario_id = '.$_SESSION['id'].') GROUP BY nome ASC');
	$res_select_autor = $pesquisar_autores->pesquisar();
	$res_select_autor2 = $pesquisar_autores->pesquisar();
	
	$foto_p = $dados_usu["foto"];
	$nome_p = $dados_usu["nome"];
	$data_nasc_p = $dados_usu["data_nasc"];
	$logradouro_p = $dados_usu["logradouro"];
	$numero_p = $dados_usu["numero"];
	$cep_p = $dados_usu["cep"];
	$uf_p = $dados_usu["uf"];
	$complemento_p = $dados_usu["complemento"];
	$cidade_p = $dados_usu["cidade"];
	$bairro_p = $dados_usu["bairro"];
	
	
	$foto = $foto_p != "" ? $foto_p : "content/imagens/fotos_perfil/avatar-250.png";
	// Verifica se o botão foi acionado

	$generos_id = array();
	$generos_nome = array();
	while ($generos = mysql_fetch_assoc($resul_pesq_genero))
	{
		$generos_id[] = $generos['id_categoria'];
		$generos_nome[] = $generos['nome'];
	}

	$qt_gen = count($generos_id);

	$autor_id = array();
	$autor_nome = array();
	while ($autores = mysql_fetch_assoc($resultado_autor))
	{
		$autor_id[] = $autores['id_autor'];
		$autor_nome[] = $autores['nome'];
	}

	$qt_aut = count($autor_id);
	
	$aspas = "'";
	
?>

<article id  = "alterar_dados_perfil" class="col-sm-offset-1 col-sm-10">
	<fieldset>
		<legend>Alterar dados</legend>
		<section class="row">
			<form name="frm_upload" id="frm_upload" class="form-horizontal" enctype="multipart/form-data" method="post" action="">
				<section class="col-lg-4">
					<center><label>Se deseja alterar sua foto de perfil, clique na imagem.</label></center>
					<center><img alt="" id="img_perfil" style="cursor:pointer;width:60%;height:60%;" class = "thumbnail" onclick="$('#file').click();" src = "<?=$foto?>"></center>
					<input type="text" value = "<?=$foto?>" style="visibility:hidden;" name="caminho" id="caminho" class="btn btn-primary btn-sm"/>
					<input type="file" style="visibility:hidden;" name="file" onchange="UploadFoto();" id="file" class="btn btn-primary btn-sm"/>
				</section>
				<section class="col-lg-4">
					<section class="row">
						<label for="inputEmail" class="col-md-3 control-label">E-mail</label>
						<section class="col-md-9">	 
							<input type="text" class="form-control"  name = "email" id="email" required  placeholder = "E-mail" maxlength = "100" value = "<?php echo utf8_encode($_SESSION["email"]); ?>">			  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputNome" class="col-md-3 control-label">Nome</label>
						<section class="col-md-9">	 
							<input type="text" class="form-control"  name = "nome" id="nome" required  placeholder = "Nome"  maxlength = "100" value = "<?php echo utf8_encode($nome_p); ?>">			  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputDataNasc" class="col-md-6 control-label">Data Nascimento</label>
						<section class="col-md-6">
							<input type="date" class="form-control" name = "data_nascimento" id="data_nascimento" required value = "<?php echo $dados_usu["data_nasc"]; ?>">		  
						</section>
					</section>
				</section>
				
				<section class="col-lg-4">
					<section class="row">
						<label for="inputCEP" class="col-sm-2 control-label">CEP</label>
						<section class="col-sm-10">
							<input type="text" class="form-control" onblur = "PegarCep()" name = "cep" id="cep" required placeholder = "CEP" maxlength = "9" value = "<?php echo utf8_encode($cep_p); ?>">
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputRua" class="col-md-2 control-label">Rua</label>
						<section class="col-md-10">
							<input type="text" class="form-control" name = "logradouro" id="logradouro" required maxlength = "100" placeholder = "Rua" value = "<?php echo utf8_encode($logradouro_p); ?>" readonly>		  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputNumero" class="col-md-2 control-label">Número</label>
						<section class="col-md-10">
							<input type="number" class="form-control" name = "numero" id="numero" required min = "1" placeholder = "Número" value = "<?php echo $numero_p; ?>">		  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputBairro" class="col-md-2 control-label">Bairro</label>
						<section class="col-md-10">
							<input type="text" class="form-control" name = "bairro" id="bairro" required maxlength = "100" placeholder = "Bairro" value = "<?php echo utf8_encode($bairro_p); ?>" readonly>		  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputUF" class="col-md-2 control-label">UF</label>
						<section class="col-md-10">
							<input type="text" class="form-control" name = "inputUF" id="inputUF" required maxlength = "100" placeholder = "UF" value = "<?php echo utf8_encode($uf_p); ?>" readonly>
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputCidade" class="col-md-2 control-label">Cidade</label>
						<section class="col-md-10">
							<input type="text" class="form-control" name = "cidade" id="inputCidade" required maxlength = "100" placeholder = "Cidade" value = "<?php echo utf8_encode($cidade_p); ?>" readonly>		  
						</section>
					</section>
					<br>
					<section class="row">
						<label for="inputComplemento" class="col-md-4 control-label">Complemento</label>
						<section class="col-md-8">
							<input  type="text" class="form-control" name = "complemento" id="complemento" placeholder = "Complemento" maxlength = "100" value = "<?php echo utf8_encode($complemento_p); ?>">
						</section>
					</section>
					<section class="row" style="margin-left:59%;">
						<button type="submit" name = "alterarDados" class="btn btn-primary">Salvar</button>
						<input type = "reset" value="Original" class="btn btn-default"/>
					</section>
				</section>
			</form>
		</section>
		<br>
			<!-- 
				Gêneros Favoritos 
			-->
		<section class="row">			
			<section class="panel panel-default">
				<section class="panel-heading"><b>Gêneros Favoritos:</b></section>
				<section class="panel-body">
					<section class="col-sm-10 col-sm-offset-1">
						<section class="col-lg-6">
							<section class="row">
								<section class="col-md-9">
									<section class="form-group">
										<select class="form-control" id="GênerosFavoritos" name="GênerosFavoritos">
											<?php
												while($select_gf=mysql_fetch_assoc($res_select_genero))
												{
													echo '<option value="'.$select_gf['id_categoria'].'">'.utf8_encode($select_gf['nome']).'</option>';
												}
											?>
										</select>
									</section>
									<p> Selecione seus gêneros favoritos.</p>									
								</section>
								<section class="col-md-offset-1">
									<section class="col-md-offset-1">
										<button onClick="AdicinoarGêneroFav();" type="button" name="plus" class="btn" id="plus"><span class="glyphicon glyphicon-plus"></button>
									</section>
								</section>
							</section>
						</section>
						<section class="col-sm-6">
							<section class="panel panel-default">
								<section class="panel-heading"><b>Seus Gêneros Favoritos:</b> &nbsp;&nbsp;</section>
								<section class="panel-body" style="height:315px;overflow:auto;">
									<ul class="list-group" id="GênerosFav">
										<?php
											while($lista_gf=mysql_fetch_assoc($res_genero_fav))
											{
												echo '<li ondblclick="RemoverGêneroFav(this)" class="list-group-item" id="'.$lista_gf['id_categoria'].'">'.utf8_encode($lista_gf['nome']).'</li>';
											}
										?>
									</ul>
								</section>
								<p class="text-info"> * Para excluir da sua lista basta clicar duas vezes sobre o nome!</p>
							</section>
						</section>
					</section>
				</section>
			</section>
		</section>
			<!-- 
				Autores Favoritos 
			-->
		<section class="row">			
			<section class="panel panel-default">
				<section class="panel-heading"><b>Autores Favoritos:</b></section>
				<section class="panel-body">
					<section class="col-sm-10 col-sm-offset-1">
						<section class="col-lg-6">
							<section class="row">
								<section class="col-md-9">
									<section class="form-group">
										<select class="form-control" id="AutoresFavoritos" name="AutoresFavoritos">
											<?php
												while($select_af=mysql_fetch_assoc($res_select_autor))
												{
													echo '<option value="'.$select_af['id_autor'].'">'.utf8_encode($select_af['nome']).'</option>';
												}
											?>
										</select>
									</section>
									<p> Selecione seus autores favoritos.</p>
								</section>
								<section class="col-md-offset-1">
									<section class="col-md-offset-1">
										<button onClick="AdicinoarAutoresFav();" type="button" name="plus" class="btn" id="plus"><span class="glyphicon glyphicon-plus"></button>
									</section>
								</section>
							</section>
						</section>
						<section class="col-sm-6">
							<section class="panel panel-default">
								<section class="panel-heading"><b>Seus Autores Favoritos:</b> &nbsp;&nbsp;</section>
								<section class="panel-body" style="height:315px;overflow:auto;">
									<ul class="list-group" id="AutoresFav">
										<?php
											while($lista_af=mysql_fetch_assoc($res_autor_fav))
											{
												echo '<li ondblclick="RemoverAutoresFavoritos(this)" class="list-group-item" id="'.$lista_af['id_autor'].'">'.utf8_encode($lista_af['nome']).'</li>';
											}
										?>
									</ul>
								</section>
								<p class="text-info"> * Para excluir da sua lista basta clicar duas vezes sobre o nome!</p>
							</section>
						</section>
					</section>
				</section>
			</section>
		</section>
				<!-- 
					Gêneros Desapreciados 
				-->
		<section class="row">			
			<section class="panel panel-default">
				<section class="panel-heading"><b>Gêneros Chatos:</b></section>
				<section class="panel-body">
					<section class="col-sm-10 col-sm-offset-1">
						<section class="col-lg-6">
							<section class="row">
								<section class="col-md-9">
									<section class="form-group">
										<select class="form-control" id="GênerosChatos" name="GênerosChatos">
											<?php
												while($select_gc=mysql_fetch_assoc($res_select_genero2))
												{
													echo '<option value="'.$select_gc['id_categoria'].'">'.utf8_encode($select_gc['nome']).'</option>';
												}
											?>
										</select>
									</section>
									<p> Selecione os gêneros que você não gosta de ler.</p>
								</section>
								<section class="col-md-offset-1">
									<section class="col-md-offset-1">
										<button onClick="AdicinoarGênerosChatos();" type="button" name="plus" class="btn" id="plus"><span class="glyphicon glyphicon-plus"></button>
									</section>
								</section>
							</section>
						</section>
						<section class="col-sm-6">
							<section class="panel panel-default">
								<section class="panel-heading"><b>Os gêneros que você não gosta:</b> &nbsp;&nbsp;</section>
								<section class="panel-body" style="height:315px;overflow:auto;">
									<ul class="list-group" id="GêneroChato">
										<?php
											while($lista_gc=mysql_fetch_assoc($res_genero_des))
											{
												echo '<li ondblclick="RemoverGêneroChatos(this)" class="list-group-item" id="'.$lista_gc['id_categoria'].'">'.utf8_encode($lista_gc['nome']).'</li>';
											}
										?>
									</ul>
								</section>
								<p class="text-info"> * Para excluir da sua lista basta clicar duas vezes sobre o nome!</p>
							</section>
						</section>
					</section>
				</section>
			</section>
		</section>
				<!-- 
					Autores Desapreciados 
				-->
		<section class="row">			
			<section class="panel panel-default">
				<section class="panel-heading"><b>Autores Chatos:</b></section>
				<section class="panel-body">
					<section class="col-sm-10 col-sm-offset-1">
						<section class="col-lg-6">
							<section class="row">
								<section class="col-md-9">
									<section class="form-group">
										<select class="form-control" id="AutoresChatos" name="AutoresChatos">
											<?php
												while($select_ac=mysql_fetch_assoc($res_select_autor2))
												{
													echo '<option value="'.$select_ac['id_autor'].'">'.utf8_encode($select_ac['nome']).'</option>';
												}
											?>
										</select>
									</section>
									<p> Selecione os autores que você não gosta.</p>
								</section>
								<section class="col-md-offset-1">
									<section class="col-md-offset-1">
										<button onClick="AdicinoarAutoresChatos();" type="button" name="plus" class="btn" id="plus"><span class="glyphicon glyphicon-plus"></button>
									</section>
								</section>
							</section>
						</section>
						<section class="col-sm-6">
							<section class="panel panel-default">
								<section class="panel-heading"><b>Os autores que você não gosta:</b> &nbsp;&nbsp;</section>
								<section class="panel-body" style="height:315px;overflow:auto;">
									<ul class="list-group" id="AutorChato">
										<?php
											while($lista_ac=mysql_fetch_assoc($res_autor_des))
											{
												echo '<li ondblclick="RemoverAutoresChatos(this)" class="list-group-item" id="'.$lista_ac['id_autor'].'">'.utf8_encode($lista_ac['nome']).'</li>';
											}
										?>
									</ul>
								</section>
								<p class="text-info"> * Para excluir da sua lista basta clicar duas vezes sobre o nome!</p>
							</section>
						</section>
					</section>
				</section>
			</section>
		</section>
	</fieldset>
</article>
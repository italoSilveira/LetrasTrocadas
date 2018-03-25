<?php
	$code = @$_REQUEST['code'];
?>
<article style="width: 80%; margin-left: 10%;">
	<h2> Rastreamento <?php echo $code ? ': ' . $code : ''?> </h2>
	<BR />
	<form class="form-horizontal" action = "" method="post">
		<fieldset>
			<legend>Pesquisar</legend>
			<section class="form-group">
				<label>Código para rastreamento:</label>
				<input type="text" size="14" maxlength="13" name="code" value="<?php echo $code ? $code : ''?>" />
				<button >Pesquisar!</button>
			</section>
		</fieldset>
	</form>
	<BR />
	<?php
		if ($code):
		include_once 'classes/class_correios.php';
		$c = new Correio($code);
		if (!$c->erro):
	?>
	<h3>Status: <?php echo $c->status ?></h3>
	<table class="table table-striped table-hover">
		<tr>
			<th>Data</th>
			<th>Local</th>
			<th>Ação</th>
			<th>Detalhes</th>
		</tr>
		<?php foreach ($c->track as $l): ?>
		<tr>
			<td><p><?php echo $l->data ?></p></td>
			<td><p><?php echo $l->local ?></p></td>
			<td><p><?php echo $l->acao ?></p></td>
			<td><p><?php echo $l->detalhes ?></p></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php else: ?>
	<?php echo $c->erro_msg ?>
	<?php endif; endif;?>
</article>
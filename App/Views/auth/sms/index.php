<html>
<head>
<h1><?php echo TITLE; ?></h1>
</head>
<body>
<?php if($Sessao::retornaMensagem()){ ?>
<div class="alert alert-danger" role="alert">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $Sessao::retornaMensagem(); ?>
</div>
<?php } ?>
<h3>Um SMS foi envio ao telefone cadastrado na base de dados por favor
		digite os 4 digitos enviados.</h3>
	<form action="http://<?php echo APP_HOST; ?>/auth/sms/" method="post" id="form_login">
		<input id="chave" type="text" name="chave"> <input type="submit" value="Enviar">
	</form>
</body>
</html>
<html>
<head>
<h1><?php echo TITLE; ?></h1>
</head>
<body>
<?php if($Sessao::retornaErro()){ ?>
<div class="alert alert-warning" role="alert">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php foreach($Sessao::retornaErro() as $key => $mensagem){ ?>
<?php echo $mensagem; ?> <br>
<?php } ?>
</div>
<?php } ?>
<?php if($Sessao::retornaMensagem()){ ?>
<div class="alert alert-danger" role="alert">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
<?php echo $Sessao::retornaMensagem(); ?>
</div>
<?php } ?>
<form action="http://<?php echo APP_HOST; ?>/auth/login" method="post" id="form_login">
		<h1>LOGIN</h1>
		<input id="username" type="text" name="username"> <input type="submit" value="Entrar">
	</form>
</body>
</html>
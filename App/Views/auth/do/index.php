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
<form action="http://<?php echo APP_HOST; ?>/auth/do" method="post" id="form_login">
		<h1>SENHA</h1>
		<input id="password" type="password" name="password"> <input type="submit" value="Entrar">
	</form>
</body>
</html>
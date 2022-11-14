<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
		<title><?php echo TITLE; ?></title>
		<link rel="icon" type="image/x-icon" href="http://<?php echo APP_HOST; ?>/public/assets/img/favicon.ico"/>
		<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
		<link href="http://<?php echo APP_HOST; ?>/public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<link href="http://<?php echo APP_HOST; ?>/public/assets/css/plugins.css" rel="stylesheet" type="text/css" />
		<link href="http://<?php echo APP_HOST; ?>/public/assets/css/authentication/form.css" rel="stylesheet" type="text/css" />
	</head>
	<body class="form">
		<div class="form-container outer">
			<div class="form-form">
				<div class="form-form-wrap">
					<div class="form-container">
						<div class="form-content">
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
		<div class="logo">
			<img src="http://<?php echo APP_HOST; ?>/public/assets/img/icon.png" alt="logo" />
		</div>
		<form action="http://<?php echo APP_HOST; ?>/auth/do" method="post">
		<div class="form">
			<div id="chave-field" class="field-wrapper input">
				<input id="chave" name="chave" autofocus maxlength="4" autocomplete="off" type="text" class="form-control" placeholder="Código enviado via SMS" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
			</div>
			<div class="d-sm-flex justify-content-between">
				<div class="field-wrapper">
					<button type="submit" class="btn btn-primary" value="">Confirmar ></button>
				</div>
			</div>
		</div>
		</form>
					</div>
				</div>
			</div>
		</div>
		</div>
		<script src="http://<?php echo APP_HOST; ?>/public/assets/js/libs/jquery-3.1.1.min.js"></script>
		<script src="http://<?php echo APP_HOST; ?>/public/bootstrap/js/popper.min.js"></script>
		<script src="http://<?php echo APP_HOST; ?>/public/bootstrap/js/bootstrap.min.js"></script>
	</body>
</html>
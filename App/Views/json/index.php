<?php
header('Content-Type: application/json');

$token = $Sessao::retornaValorFormulario('token').$Sessao::retornaValorFormulario('chave');

//string json contendo os dados de um funcionário
$json_str = [$token];

//faz o parsing na string, gerando um objeto PHP
echo json_encode($json_str);


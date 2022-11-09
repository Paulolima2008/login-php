<?php

namespace App\Models\Validacao;

use \App\Models\Entidades\User;

class UserValidador{

    public function validar(User $user)
    {
        $resultadoValidacao = new ResultadoValidacao();
        // validar se o campo está em branco
        if(empty($user->getLogin()))
        {
            $resultadoValidacao->addErro('login',"Login: campo não pode ser vazio");
        }
        // validar a quantidade de caracteres maior ou igual a 20
        if(strlen($user->getLogin()) >= 20)
        {
            $resultadoValidacao->addErro('login',"Login: quantidade de caracteres excedidos");
        }
        // validar se exister caracteres especiais
        if(preg_match('[a-zA-Z0-9]',$user->getLogin()))
        {
            $resultadoValidacao->addErro('login',"Login: campo não permitir caracteres especiais");
        }
        return $resultadoValidacao;
    }
}
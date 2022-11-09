<?php

namespace App\Models\DAO;

use App\Models\Entidades\User;

class UserDAO extends BaseDAO
{
    //----------------------------------------------------------------------------------------
    public  function validarLogin($login)
    {
        $resultado = $this->select(
            "SELECT * FROM user WHERE login ='".$login."'"
            );
        
        return $resultado->fetchObject(User::class);
        
    }
    //----------------------------------------------------------------------------------------
    public  function autenticar($login, $senha)
    {
        $resultado = $this->select(
            "SELECT * FROM user WHERE login ='".$login."' AND senha ='".$senha."' AND status = '1'"
        );

        return $resultado->fetchObject(User::class);

    }
    //----------------------------------------------------------------------------------------
}
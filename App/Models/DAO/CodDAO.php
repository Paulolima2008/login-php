<?php

namespace App\Models\DAO;

use App\Models\Entidades\Cod;
use Exception;

class CodDAO extends BaseDAO
{
    //----------------------------------------------------------------------------------------
    public  function getByUserIdLast($userId)
    {
        $resultado = $this->select(
            "SELECT * FROM cod WHERE user_id = $userId ORDER BY id DESC LIMIT 1" 
            );
        
        return $resultado->fetchObject(Cod::class);
        
    }
    //----------------------------------------------------------------------------------------
    public function salvar(Cod $cod)
    {
        try {
            
            $chave           = $cod->getChave();
            $user_id         = $cod->getUser()->getId();
           
            
            return $this->insert(
                'cod',
                ":chave,:user_id",
                [
                    ':chave'=>$chave,
                    ':user_id'=>$user_id
                ]
                );
        }catch (\Exception $e){
            throw new \Exception("Erro na gravação de dados." . $e->getMessage(), 500);
        }
        
    }
    //----------------------------------------------------------------------------------------
}
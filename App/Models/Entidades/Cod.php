<?php 

namespace App\Models\Entidades;

class Cod
{

    private $id;
    private $chave;
    private $user;
    
    public function __construct() { 
        $this->user = new User();
    }
    
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getChave()
    {
        return $this->chave;
    }

    public function setChave($chave)
    {
        $this->chave = $chave;
    }

    public function getUserId()
    {
        return $this->user_id;
    }
    
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }
    public function getUser()
    {
        return $this->user;
    }
    
}

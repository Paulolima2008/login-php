<?php

namespace App\Controllers;

use App\Lib\Sessao;
use App\Lib\SMSMarket;
use App\Models\DAO\UserDAO;
use App\Models\Entidades\User;
use App\Models\DAO\CodDAO;
use App\Models\Entidades\Cod;
use App\Models\Validacao\UserValidador;

class AuthController extends Controller
{
    //---------------------------------------------------------------------------
    public function index()
    {
        $this->render('auth/index');
        Sessao::limpaMensagem();
    }
    //---------------------------------------------------------------------------
    /*
     * A funçao login verificar o login na base de dados, caso correto válida o
     * cookie salvo na máquina e redirecionar para senha(do) na segunda etapa.
     */
    //---------------------------------------------------------------------------
    public function login()
    {
        $user = new User();
        $user->setLogin($_POST['username']);
        Sessao::gravaFormulario($_POST);
        
        $userValidador = new UserValidador();
        $resultadoValidacao = $userValidador->validar($user);
        
        if($resultadoValidacao->getErros()){
            Sessao::gravaErro($resultadoValidacao->getErros());
            $this->redirect('/auth');
        }
        
        $userDAO = new UserDAO();
        $user = $userDAO->validarLogin($user->getLogin());
        
        // Verificar se existe o cookie com o token
        if (isset($_COOKIE['AUTH_ERROR'])) {
           
            // Verificar se o  cookie tem valor 5
            if($_COOKIE['AUTH_ERROR'] == 5){
                
                // redirecinar para bloqueio
                Sessao::gravaMensagem("Acesso Bloqueado");
                // redirecionar
                $this->redirect('/auth');
                // limpa a sessões
                Sessao::limpaFormulario();
                Sessao::limpaMensagem();
                Sessao::limpaErro();
                
            }// fim do if
        } // fim do if
        // verificar se o objeto estar na base de dados
        if (!empty($user)){
            // Verificar se existe o cookie com o token
            if (isset($_COOKIE['TOKEN'])) {

                // verificar se o token do login e igual ao cookie salvo na máquina
                if (strcasecmp ($user->getToken(), $_COOKIE['TOKEN']) == 0 ){
                    
                    //limpa a sessões
                    Sessao::limpaMensagem();
                    Sessao::limpaErro();
                    // redirecionar para solicitação de senha
                    $this->render('auth/do/index');
                    
                }
                
                else{
                    // enviar sms caso o cookie seja diferente
                    $this->enviarSMS($user);
                }
                
            }else{
                // enviar sms caso o cookie não exista na máquina
                $this->enviarSMS($user);
            }
            
        } // fim do if
        // chamar o else caso o objeto usuário não esteja na base de dados
        else{
            // chamar a função para criar o cookie validando ataques
            $this->cookieContador();
            // grava msg
            Sessao::gravaMensagem("Autentica&ccedil;&atilde;o Falhou");
            // redirecionar
            $this->redirect('/auth');
            // limpa a sessões
            Sessao::limpaFormulario();
            Sessao::limpaMensagem();
            Sessao::limpaErro();
           
        }// fim do else  
    } // fim da função
    //--------------------------------------------------------------------------
    /*
     * A funçao do verificar senha na base de dados, caso correto redirencioanar o
     * user para o sistema principal
     */
    //---------------------------------------------------------------------------
    public function do()
    {
        //instância o objeto
        $user = new User();
        $user->setSenha($_POST['password']);
        
        //instância o Dao para validar dados na base
        $userDAO = new UserDAO();  
        $user = $userDAO->autenticar(Sessao::retornaValorFormulario('username'), $user->getSenha());
         
        if (!empty($user)){
            
            //instância o Dao para salvar na base de dados
            $codDAO = new CodDAO();
            $cod = $codDAO->getByUserIdLast($user->getId());
            
            // enviar pela sessão dados da autenticação
            $_POST['token'] = $user->getToken();
            $_POST['chave'] = $cod->getChave();
            Sessao::gravaFormulario($_POST);
            
            /*quando a página for redirecionada para o servidor de origem verificar se o token
             * está registrado na base de dados caso seja verdadeiro, vai para segunda etapa
             * que é verificar se o cookie salvo na máquina corresponde ao mesmo enviado via 
             * sessão caso verdadeiro habilitar o usuário para acesso ao sistema.
             */ 
            
            // redirecionar para fora da app
            $this->redirectExtern('https://araujoseguros.com.br/gestor');
            
        }// fim do if
        // chamar o else caso o objeto usuário não esteja na base de dados
        else
        {
            // chamar a função para criar o cookie validando ataques
            $this->cookieContador();
            // grava msg
            Sessao::gravaMensagem("Autentica&ccedil;&atilde;o Falhou");
            // redirecionar
            $this->redirect('/auth');
            // limpa a sessões
            Sessao::limpaMensagem();
            Sessao::limpaErro();
        } // fim do else
    } // fim da função
    //--------------------------------------------------------------------------
    /*
     * A funçao sms verificar a chave na base de dados, caso correto criar o cookie TOKEN
     * e redirecionar o user para página de verificação de senha
     */
    //---------------------------------------------------------------------------
    public function sms()
    {
        //instância o objeto
        $codPost = new Cod();
        $codPost->setChave($_POST['chave']); // recebe a chave digitada
        //instância o objeto
        $user = new User();
        //instância o Dao para validar dados na base
        $userDAO = new UserDAO();
        $user = $userDAO->validarLogin(Sessao::retornaValorFormulario('username'));
        
        //instância o Dao para consulta a base de dados
        $codDAO = new CodDAO();
        $cod = $codDAO->getByUserIdLast($user->getId());

        // verificar se o chave via post e igual ao da base de dados 
        if (strcasecmp ($codPost->getChave(), $cod->getChave()) == 0 )
        {
            // Criar o cookie na máquina   
            setcookie('TOKEN', md5(Sessao::retornaValorFormulario('username')), (time() + (3 * 24 * 3600)),'/');
            
            //limpa a sessões
            Sessao::limpaMensagem();
            Sessao::limpaErro();
            
            // redirecionar para solicitação de senha           
            $this->render('auth/do/index');
        }
        // chamar o else caso o objeto usuário não esteja na base de dados
        else{
            // chamar a função para criar o cookie validando ataques
            $this->cookieContador();
            // grava msg
            Sessao::gravaMensagem("Autentica&ccedil;&atilde;o Falhou");
            // redirecionar
            $this->redirect('/auth');
            // limpa a sessões
            Sessao::limpaMensagem();
            Sessao::limpaErro();
        } // fim do else
    } // fim da função
    //---------------------------------------------------------------------------
    /*
     * A funçao enviarSms gerar um chave aleatória com 4 dígitos e enviar via sms ao
     * user.
     */
    //---------------------------------------------------------------------------
    public function enviarSMS($user)
    {
        //instância o objeto
        $cod = new Cod();
        $cod->setChave(rand(1000,9999));// criar um codigo aleatório a cada chamada
        $cod->getUser()->setId($user->getId());
        
        //instância o Dao para salvar na base de dados
        $codDAO = new CodDAO();
        $codDAO->salvar($cod);
        
        //instância smsmarket com login e senha
        $sms = new SMSMarket(SMS_USER, SMS_PASSWORD);
        //programa um sms para ser enviado
        $msg = 'Araujo Seguros - Codigo de seguranca de acesso: '.$cod->getChave();
        //$envio = $sms->sendSMS ($user->getTelefone(), $msg, 0, null, 55, null);
        
        // limpa as sessões
        //Sessao::limpaFormulario();
        Sessao::limpaMensagem();
        Sessao::limpaErro();
        
        // chama a página para validação de sms
        $this->render('auth/sms/index');
    } // fim da função
    //---------------------------------------------------------------------------
    /*
     * A funçao cookieContador criar e atualizar o cookie para bloquear o acesso caso
     * o sistema seja vítima de ataque de força bruta. o cookie tem duração de 1 dia.
     */
    //---------------------------------------------------------------------------
    public function cookieContador()
    {
        // verificar se o cookie existe 
        if (isset($_COOKIE['AUTH_ERROR'])){
            $int = (int) $_COOKIE['AUTH_ERROR'];
            
            switch ($int) {
                
                case 1:
                    // Criar o cookie na máquina
                    setcookie('AUTH_ERROR', '2', (time() + (1 * 24 * 3600)),'/');
                    break;
                    
                case 2:
                    // Criar o cookie na máquina
                    setcookie('AUTH_ERROR', '3', (time() + (1 * 24 * 3600)),'/');
                    break;
                    
                case 3:
                    // Criar o cookie na máquina
                    setcookie('AUTH_ERROR', '4', (time() + (1 * 24 * 3600)),'/');
                    break;
                    
                case 4:
                    // Criar o cookie na máquina
                    setcookie('AUTH_ERROR', '5', (time() + (1 * 24 * 3600)),'/');
                    break;
                    
                case 5:
                    // Criar o cookie na máquina
                    setcookie('AUTH_ERROR', '5', (time() + (1 * 24 * 3600)),'/');
                    break;
            }
        } // fim do if
        // caso o cookie não exista criar ele
        else{
            // Criar o cookie na máquina
            setcookie('AUTH_ERROR', '1', (time() + (1 * 24 * 3600)),'/');
        }

    } // fim da função
    //---------------------------------------------------------------------------
}

# Login seguro em 2 etapas de verificação

## 🚀 Descrição
Projeto em PHP para realizar login e 2 etapas de verificação utilizado o envio de sms. Para realizar o envio do sms e necessário criar uma conta e fazer a compra de sms em [smsmarket](https://www.smsmarket.com.br/pt/) e acessar a API, o mesmo já está configurado no projeto apenas precisa coloca o usuário e senha correspondente a sua conta. Em uma nova versão o projeto vai enviar a verificação por e-mail ou sms.

## 🔧 Instruções
Inicialmente vai ser solicitado o login do usuário onde será feito algumas verificações onde a primeira análise é sabe se existe um cookie chamado token (o nome de login criptografado em md5) se existir vai redirecionar para solicitação da senha e atráves do método POST Criar duas variáveis token e chave(código sms que foi salvo na base de dados) so então redirecionar para o sistema secundário. Caso o cookie não existar será enviado um sms ao telefone cadastrado e solicitado o código se o mesmo corresponder encaminhar para digitar a senha e criado o cookie na máquina.

### ⌨️ Tecnologia utilizadas
 - PHP POO
 
 - Composer
 
 - SMS API (smsmarket)
 
 - Banco de dados mysql PDO
 
### ⚙️ Configuração e Instalação
 - habilitar o módulo de reescrita no apache (veja tutorial na internet).
 
 - Configurar/atualizar o composer.
 
 - Editar as constantes do  arquivo /App/APP.php onde contém dados de configuração como 	 	 por exemplo nome do projeto, hostname, usuário e senha do banco de dados e etc.
 
 - Criar a base de dados.
 
 - executar o projeto.
 
```
localhost/nome_do_projeto
```


## 📌 Versão

- 1.0 Login com envio de SMS

---
⌨️ [Paulo Lima](https://github.com/paulolima2008) 😊
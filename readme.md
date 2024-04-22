# Sistema de Gerenciamento de Usuários

Este sistema é uma aplicação web para gerenciar usuários, permitindo adicionar, editar e remover registros de um banco de dados.

## Configuração

Para começar a utilizar a aplicação, é necessário configurar a conexão com o banco de dados. Siga os passos abaixo:

1. Renomeie o arquivo `config/config.example.php` para `config/config.php`.
2. Abra o arquivo `config/config.php` em um editor de texto de sua preferência.
3. Preencha as variáveis de conexão do banco de dados com as seguintes informações:
   ```php
   <?php
   $host = 'localhost'; // ou o endereço do seu servidor de banco de dados
   $db   = 'api_database'; // nome do banco de dados
   $user = 'seu_usuario'; // seu usuário de banco de dados
   $pass = 'sua_senha'; // sua senha de banco de dados
   $charset = 'utf8mb4'; // conjunto de caracteres a ser usado

 4. Salve e feche o arquivo config.php.

 ## Criando a Tabela de Usuários

Execute o seguinte comando SQL no seu banco de dados para criar a tabela users:


  ``` sql 

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city_id` varchar(255) NOT NULL,
  `state_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  ```
 

Depois de criar a tabela, você pode utilizar a aplicação para gerenciar os usuários.

## Uso
Para adicionar um usuário, acesse a página addUser.php e preencha o formulário.
Para editar um usuário, navegue até a página de gerenciamento e clique no link "Editar" correspondente ao usuário desejado.
Para remover um usuário, na página de gerenciamento, clique no link "Remover" ao lado do registro do usuário que você deseja deletar.
Assegure-se de ter os privilégios necessários para executar operações de criação, leitura, atualização e exclusão no banco de dados.
<h1 align="center"> 🛍 <br> Ecommerce </h1>

![Ecommerce](https://github.com/user-attachments/assets/cad2e5bd-8ac8-469b-aea8-af174fff0aaa)

## Requisitos de servidor

Para rodar este projeto, você precisará de PHP na versão 8.1 ou superior, com as seguintes extensões instaladas e habilitadas:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- json (habilitado por padrão)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)  (necessário se você planeja usar MySQL)
- [libcurl](http://php.net/manual/en/curl.requirements.php) (necessário se você planeja usar a biblioteca HTTP\CURLRequest)
- 
> [!ATENÇÃO]
> A data de fim de vida do PHP 7.4 foi em 28 de novembro de 2022.
> A data de fim de vida do PHP 8.0 foi em 26 de novembro de 2023.
> Se você ainda está utilizando o PHP 7.4 ou 8.0, é recomendável que faça a atualização imediatamente.
> A data de fim de vida do PHP 8.1 será em 25 de novembro de 2024.

## Instalação

Para configurar e iniciar o projeto, siga os passos abaixo:

#### 1. Banco de Dados:
- Execute o script SQL localizado em public/script.sql utilizando um gerenciador de banco de dados de sua preferência.

#### 2. Configuração do Projeto:
- Abra o arquivo app/Config/App.php e configure a variável "$baseURL" com a URL do seu projeto.
- No arquivo app/Config/Database.php, atualize a variável "$default" com as credenciais do seu banco de dados.

#### 3. Acessando o Projeto:
- Certifique-se de que seu servidor local (como XAMPP) está ativo.
- Abra o navegador e acesse a URL configurada no "$baseURL" para visualizar o projeto.

#### 4. Configuração de Administrador:

- Para criar um administrador, registre um usuário normalmente através da interface do projeto.
- Em seguida, acesse o gerenciador de banco de dados e altere o valor do campo "user_type" para "admin" no registro do usuário recém-criado.
- Alternativamente, você pode criar o usuário administrador diretamente pelo gerenciador de banco de dados.

Agora você pode acessar e gerenciar o projeto através do navegador.

## Contato

Você pode me encontrar nas seguintes redes sociais:

[![Instagram](https://img.shields.io/badge/Instagram-0E6212?style=for-the-badge&logo=instagram&logoColor=white)](https://www.instagram.com/leandroadrian_/)
[![LinkedIn](https://img.shields.io/badge/LinkedIn-0E6212?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/leandro-adrian)

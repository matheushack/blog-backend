# Blog - Backend

Projeto em Laravel para blog onde disponibiliza métodos de uma API Rest para consumo do frontend.

## 💿 Instalação

Primeiramente precisa configurar o `.env`, principalmente a parte de conexão com o banco de dados:

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=blog
DB_USERNAME=user
DB_PASSWORD=password
```

Após o processo de configuração do .env, basta rodar os comandos:

- `composer update`: para baixar as dependências;


- `php artisan key:generate`: para gerar a key do Laravel;


- `php artisan migrate`: criar a estrutura do banco de dados;


- `php artisan db:seed`: criar um usuário Fake;


- `php artisan passport:client --personal `: gera as credenciais de aplicação do Passport


- `php artisan serve`: para subir a API


## Usuário

O usuário é criado através da seed, onde utiliza o Faker do Laravel para geração. Basta entrar na tabela de user e pegar o email dele para ser usado na API. 
A senha por padrão é `123456`

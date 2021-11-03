# Laravel Passport

Este é repositório é um PoC utilizando Laravel com a extensão Passport


# Docker
Docker building:

    # docker-compose up -d --build laravel_passport
Acessando o container:

    # docker exec -it laravel_passport /bin/sh

# Laravel
A estrutura está dividida entre ambiente de Server(*passport*) e Client(*cliente*)
Lembre-se de utilizar o **composer** para instalar/atualizar os pacotes:

    # cd ./passport && composer update
    # cd ./cliente && composer update
## Ambiente Server - Passport

1 - Criação das tabelas no banco de dados

    # cd ./passport && php artisan migrate

2- Rodando o servidor

    # cd ./passport && ./run.sh

3- Crie um usuário

> http://localhost:3004/register



## Ambiente Client - Cliente
Rodando o servidor

    # cd ./cliente && ./run.sh

1. Para acessar: 

> http://localhost:3005

2. Clique no link *login*, você será redirecionado para o ambiente do servidor, caso não esteja logado, forneça seus dados de acesso, será requisitado sua autorização, permita, em seguida você será redirecionado para URL de *callback* do cliente aonde será exibido seu Access Token e Refresh Token.



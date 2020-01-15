## Install

Para o projeto funcionar você precisa:

-   [Ter o composer instalado](https://getcomposer.org/).
-   [Ter o node.js instalado](https://nodejs.org/en/).
-   [Ter um banco de dados mysql e apache rodando](https://www.apachefriends.org/pt_br/index.html).

Tendo o configurado o ambiente, siga os passos.

#### Configurar o laravel

Duplique o arquivo .env.example, renomei-o para .env e altere os dados de configuração do banco de dados.

```ENV
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nestle-coffee
DB_USERNAME=root
DB_PASSWORD=root
```

#### Fazer o download e instalar as dependencias do PHP

Abrir o prompt de comando na pasta raiz do projeto e executar:

> \> composer install

#### Fazer o download e instalar as dependencias do javascript

Abrir o prompt de comando na pasta raiz do projeto e executar:

> \> npm install

#### Criar as tabelas no banco de dados

Abrir o prompt de comando na pasta raiz do projeto e executar:

> \> php artisan migrate:refresh --seed

#### XAMPP

Configure o apache para o localhost aprontar para a pasta raiz do projeto

## Admin

Acesse http://localhost/admin e faça o login com o e-mail **coffee@alicewonders.ws** e com a senha **administrator**.

## Tablets

Acesse http://localhost/device e habilite ele escolhendo a cafeteira e o código de acesso que foi criado quando a cafeteira foi salva no Admin.

## Leitor de NFC

Quando o funcionário passar o cartão fazer o dispositivo acessar na rede a URL [http://localhost/api/device/employee/**CODIGO_DO_FUNCIONARIO**/**ID_CAFETEIRA**]()

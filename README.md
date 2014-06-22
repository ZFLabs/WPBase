WPBase
=======================

Introdução
------------
Módulo base para criar APP com Zend Framework 2

Instalação
------------
Para instalar é bastante simples, no Terminal digite o seguinte comando:

    git clone https://github.com/juizmill/WPBase.git


Após ter feito uma copia do projeto, navegue até a pasta do mesmo, onde na qual terá um arquivo composer.phar, este arquivo é responsável por baixar todas as dependências necessários para o seu funcionamento.

Novamente no terminal digite:

    php composer.phar self-update
    php composer.phar install

O comando **"php composer.phar self-update"** é para atualizar o próprio arquivo composer.phar, já o comando **"php composer.phar install"** é para instalar as dependências.

Banco de dados
===============
Crie uma base de dados chamado **tasck**.

Depois vai no terminal e crie as tabelas com o seguinte comando

    bin/doctrine-module orm:schema-tool:create

Lembrando que seu usuário e senha local do banco deve ser **root** e a **senha em branco**, caso não seja edita o arquivo **doctrine_orm.global.php** que se encontra na pasta **config/autoload**

Executar o Sistema
===================
Navegue até a pasta **public** e digite no terminal:

    php -S localhost:8090

E pressione ente, pronto o PHP ativou o apache enbutino nele, copie o endereço que acaba de criar e cole no navegador para acessar o sistema.

OBS.
====
Caso ocorra um erro de TimeOut execute este comando:

    COMPOSER_PROCESS_TIMEOUT=9000 php composer.phar install

O comando **"COMPOSER_PROCESS_TIMEOUT=9000"** como o próprio nome já diz é para definir o tempo limite de execução do arquivo composer.phar
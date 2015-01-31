WPBase
=======================

[![Build Status](https://travis-ci.org/ZFLabs/WPBase.svg?branch=master)](https://travis-ci.org/ZFLabs/WPBase)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/juizmill/WPBase/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/juizmill/WPBase/?branch=master)
[![Coverage Status](https://coveralls.io/repos/juizmill/WPBase/badge.png?branch=master)](https://coveralls.io/r/juizmill/WPBase?branch=master)
[![Latest Stable Version](https://poser.pugx.org/juizmill/wp-base/v/stable.svg)](https://packagist.org/packages/juizmill/wp-base)
[![Total Downloads](https://poser.pugx.org/juizmill/wp-base/downloads.svg)](https://packagist.org/packages/juizmill/wp-base)
[![Latest Unstable Version](https://poser.pugx.org/juizmill/wp-base/v/unstable.svg)](https://packagist.org/packages/juizmill/wp-base)
[![License](https://poser.pugx.org/juizmill/wp-base/license.svg)](https://packagist.org/packages/juizmill/wp-base)

Introdução
------------
Módulo base para criar APP com Zend Framework 2

Instalação
------------
Para instalar é bastante simples, adicione no composer.json:

    "juizmill/wp-base": "dev-master"

Próximo passo é atualizar o composer e pedir para instalar:

    php composer.phar self-update
    php composer.phar install

O comando **"php composer.phar self-update"** é para atualizar o próprio arquivo composer.phar, já o comando **"php composer.phar install"** é para instalar as dependências.

Após a instalação vai até o arquivo **config/application.config.php**

OBS.
====
Caso ocorra um erro de TimeOut execute este comando:

    COMPOSER_PROCESS_TIMEOUT=9000 php composer.phar install

O comando **"COMPOSER_PROCESS_TIMEOUT=9000"** como o próprio nome já diz é para definir o tempo limite de execução do arquivo composer.phar

PARTIALS
========
Você pode chamar os seguintes partials:

  - **partials/breadcrumbs**
    - Retorna um breadcrumb
  - **partials/flashMessenger**
    - Retorna mensagens através do flashMessenger
  - **partials/formElementErrors**
    - Retorna mensagem de erros ocorrido no formulário
  - **partials/modal.delete.message**
    - Retorna a estrutura do modal com uma mensagem de confirmação para deletar o registro
  - **partials/paginator**
    - Retorna a paginação de registros

Lembrando que todos os partials segue o **Bootstrap 3**.

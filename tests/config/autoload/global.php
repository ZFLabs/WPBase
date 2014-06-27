<?php
return array(
    'mail' => array(
        'name' => 'smtp.gmail.com', #SMTP do servidor de e-mail
        'host' => 'smtp.gmail.com', #No google só repetir o SMTP
        'port' => 465, #Porta do servidor de e-mail
        'connection_class' => 'login', #Diz que será feito uma autenticação para disparar os e-mail
        'connection_config' => array(
            'from' => 'teste@gmail.com', # DE!
            'username' => 'teste@gmail.com', #E-Mail de autenticação
            'password' => 'tete', #Senha do e-mail para autenticar
            'ssl' => 'ssl', #Tipo do envio
        )
    ),
);
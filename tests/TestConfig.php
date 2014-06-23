<?php

return array(
    //Configuração do módulo para ser Testado
    //Pode colocar módulos que faz parte do módulo que será testado
    'modules' => array(
      'DoctrineModule',
      'DoctrineORMModule',
      'WPBase',
    ),
    'module_listener_options' => array(
        'module_paths' => array(
            './module',
            './vendor',
        ),
    ),
    //Configuração para não carregar as entidades dos módulos
    'not_load_entity' => array(
        'WPBase',
        'WPBaseTest'
    )
);

<?php

namespace Tasck;

return array(
    'router' => array(
        'routes' => array(

            'teste' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
//                    'defaults' => array(
//                        'controller' => __NAMESPACE__.'\\Controller\\'.__NAMESPACE__,
//                        'action' => 'index',
//                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '[/:id][/:action][/pagina/:page]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id' => '\d+',
                                'page' => '\d+'
                            ),
                            'defaults' => array(
                                'page' => 1
                            ),
                        ),
                    ),
                ),
            ),

        ),
    ),

//    'controllers' => array(
//        'invokables' => array(
//            __NAMESPACE__.'\\Controller\\'.__NAMESPACE__ => __NAMESPACE__.'\\Controller\\'.__NAMESPACE__.'Controller'
//        ),
//    ),
);

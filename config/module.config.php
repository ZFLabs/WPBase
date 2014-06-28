<?php
namespace WPBase;

return array(
    'view_manager' => array(
        'template_map' => include __DIR__.'/../template_map.php',
        'strategies' => array(
            'ViewJsonStrategy'
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'log' => array(
        'Zend\Log\Logger' => array(
            'writers' => array(
                array(
                    'name' => 'stream',
                    'priority' => 1000,
                    'options' => array(
                        'stream' => 'data/app.log',
                    ),
                ),
            ),
        ),
    ),
);

<?php

namespace WPBase;

use WPBase\Logger\WPLogger;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\EventManager\EventInterface;
use Zend\Mvc\ModuleRouteListener;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $eventManager = $e->getTarget()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $e->getTarget()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Application', 'dispatch.error', function($e){
                if ($e->getParam('exception')) {
                    WPLogger::addWriter($e->getParam('exception'));
                }
            }
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritdoc}
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}

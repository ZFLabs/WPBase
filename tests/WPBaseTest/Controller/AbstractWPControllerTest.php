<?php

namespace WPBaseTest\Logger;

use WPBaseTest\Framework\TestCaseController;
use Zend\Mvc\MvcEvent;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;


class AbstractWPControllerTest extends TestCaseController
{
    public function dataProviderMethods()
    {
        return array(
            array('indexAction'),
            array('novoAction'),
            array('editarAction'),
            array('deleteAction'),
            array('getWPService'),
        );
    }

    public function testClassExist()
    {
        $this->assertTrue(class_exists('\\WPBase\\Controller\\AbstractWPController'));
        $this->assertInstanceOf(
            'Zend\Mvc\Controller\AbstractActionController',
            $this->getMockController()->disableOriginalConstructor()->getMock()
        );
    }

    public function testVerificaSeExisteAttributosEsperados()
    {
        $this->assertClassHasAttribute('service', '\\WPBase\\Controller\\AbstractWPController');
        $this->assertClassHasAttribute('itensPerPage', '\\WPBase\\Controller\\AbstractWPController');
        $this->assertClassHasAttribute('controller', '\\WPBase\\Controller\\AbstractWPController');
        $this->assertClassHasAttribute('route', '\\WPBase\\Controller\\AbstractWPController');
        $this->assertClassHasAttribute('form', '\\WPBase\\Controller\\AbstractWPController');
    }

    /**
     * @dataProvider dataProviderMethods
     */
    public function test_verifica_methods_esperados($method)
    {
        $this->assertTrue(method_exists('\\WPBase\\Controller\\AbstractWPController', $method));
    }

    private function getMockController()
    {
        return $this->getMockBuilder('\\WPBase\\Controller\\AbstractWPController');
    }

}

<?php

namespace WPBaseTest\Logger;

use SpiffyTest\Controller\AbstractHttpControllerTestCase;
use Zend\Form\Annotation\AnnotationBuilder;


class AbstractWPControllerTest extends AbstractHttpControllerTestCase
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
            $this->getControllerMock()
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
    public function testVerificaMethodsEsperados($method)
    {
        $this->assertTrue(method_exists('\\WPBase\\Controller\\AbstractWPController', $method));
    }

    public function testVerificaSeRetornaAbstractWPFormHandle()
    {
        $controller = $this->getControllerMock();

        $this->assertInstanceOf('\\WPBase\\Form\\AbstractWPFormHandle', $controller->getWPForm());
    }

    public function testVerificaSeRetornaAbstractWPService()
    {
        $controller = $this->getControllerMock();

        $this->assertInstanceOf('\\WPBase\\Service\\AbstractWPService', $controller->getWPService());
    }


    public function testVerificaSeRetornaViewModel()
    {
        $controller = $this->getControllerMock();

        $this->assertInstanceOf('Zend\View\Model\ViewModel', $controller->indexAction());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $controller->novoAction());
    }

    public function testVerificaSeRedireciona()
    {
        $controller = $this->getControllerMock();
        $this->assertNull($controller->editarAction());
    }



    private function getControllerMock()
    {
        $parameter = $this->getMockBuilder('\\Zend\\Mvc\\Controller\\Plugin\\Params')->getMock();
        $redirect = $this->getMockBuilder('\\Zend\Mvc\\Controller\\Plugin\\Redirect')->getMock();

        $emMock = $this->getMock('\\WPBase\\Controller\\AbstractWPController',
            array('params', 'fromRoute', 'getWPService', 'getWPForm', 'redirect', 'toRoute'

            ),array(),'',false);

        $emMock->expects($this->any())
            ->method('params')
            ->will($this->returnValue($parameter));

        $emMock->expects($this->any())
            ->method('fromRoute')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('getWPService')
            ->will($this->returnValue($this->getMockService()));

        $emMock->expects($this->any())
            ->method('getWPForm')
            ->will($this->returnValue($this->getMockForm()));

        $emMock->expects($this->any())
            ->method('redirect')
            ->will($this->returnValue($redirect));

        $emMock->expects($this->any())
            ->method('toRoute')
            ->will($this->returnValue(null));

        return $emMock;
    }


    /**
     * @return \WPBase\Form\AbstractWPFormHandle
     */
    public function getMockForm()
    {
        $builder = $this->getMockBuilder('Zend\Form\Annotation\AnnotationBuilder')->getMock();
        $tasck = $this->getMockBuilder('WPBaseTest\Framework\Entity\Tasck')->getMock();

        /**
         * @var $class \WPBase\Form\AbstractWPFormHandle
         */
        $class = $this->getMockForAbstractClass('\\WPBase\\Form\\AbstractWPFormHandle', array(
                new AnnotationBuilder(), $tasck, $this->getMockService()
            ));

        return $class;
    }

    /**
     * @return \WPBase\Service\AbstractWPService
     */
    public function getMockService()
    {
        /**
         * @var $class \WPBase\Service\AbstractWPService
         */
        $class = $this->getMockForAbstractClass('\\WPBase\\Service\\AbstractWPService', array(
                $this->getEmMock()
            ));
        $class->setEntity('WPBaseTest\Framework\Entity\Tasck');

        return $class;
    }

    private function getEmMock()
    {

        $employeeRepository = $this->getMockBuilder('\Doctrine\ORM\EntityRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $tasck = $this->getMockBuilder('WPBaseTest\Framework\Entity\Tasck')->getMock();

        $emMock = $this->getMock('\Doctrine\ORM\EntityManager',
            array('persist','flush','getReference','remove', 'getRepository', 'find', 'findAll', 'merge'),array(),'',false);

        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('remove')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('merge')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('getRepository')
            ->will($this->returnValue($employeeRepository));

        $emMock->expects($this->any())
            ->method('find')
            ->will($this->returnValue($tasck));

        $emMock->expects($this->any())
            ->method('findAll')
            ->will($this->returnValue(null));

        return $emMock;
    }

}

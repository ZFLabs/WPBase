<?php

namespace WPBaseTest\Mail;

use SpiffyTest\Framework\TestCase;
use WPBase\Mail\WPMail;

class WPLoggerTest extends TestCase
{

    public function testClassExist()
    {
        $this->assertTrue(class_exists('\\WPBase\\Mail\\WPMail'));
        $this->assertInstanceOf('Zend\Mail\Message', $this->getMockWPMail());
        $this->assertInstanceOf('Zend\ServiceManager\ServiceManagerAwareInterface', $this->getMockWPMail());
    }

    public function dataProvider()
    {
        return array(
            array('serviceManager', $this->getMockServiceManager()),
            array('data', array()),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testVerificaClassePossuiGetAndSetsDosAtributos($atributo,$valor)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $atributo)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $atributo)));

        $class = new WPMail($this->getServiceManager(), 'my_page.phtml');

        $class->$set($valor);

        $this->assertEquals($valor, $class->$get());
    }

    public function testVerificaSeExisteMetodosEsperados()
    {
        $this->assertTrue(method_exists('\\WPBase\\Mail\\WPMail', 'getSmtpOptions'));
        $this->assertTrue(method_exists('\\WPBase\\Mail\\WPMail', 'smtpTransport'));
        $this->assertTrue(method_exists('\\WPBase\\Mail\\WPMail', 'renderView'));
        $this->assertTrue(method_exists('\\WPBase\\Mail\\WPMail', 'prepare'));
        $this->assertTrue(method_exists('\\WPBase\\Mail\\WPMail', 'send'));
    }

    /**
     * @expectedException 	\Zend\Mail\Protocol\Exception\RuntimeException
     */
    public function testVerificaRetornoDosMetodos()
    {
        /**
         * @var $class \WPBase\Mail\WPMail
         */
        $class = new WPMail($this->getServiceManager(), 'layout/layout.phtml');
        $class->setData(array(
                'teste' => 'teste'
            ));

        $this->assertInstanceOf('Zend\Mail\Transport\Smtp', $class->smtpTransport());
        $this->assertInstanceOf('Zend\Mail\Transport\SmtpOptions', $class->getSmtpOptions());
        $this->assertInstanceOf('Zend\View\Model\ViewModel', $class->renderView());
        $this->assertInstanceOf('\\WPBase\\Mail\\WPMail', $class->prepare());
        $this->assertInstanceOf('\\WPBase\\Mail\\WPMail', $class->send());


    }



    public function getMockWPMail()
    {
        return $this->getMockBuilder('WPBase\Mail\WPMail')->disableOriginalConstructor()->getMock();
    }

    public function getMockServiceManager()
    {
        return $this->getMockBuilder('Zend\ServiceManager\ServiceManager')->getMock();
    }

}

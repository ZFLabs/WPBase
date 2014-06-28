<?php

namespace WPBaseTest\Form;

require __DIR__.'/../Framework/Entity/Tasck.php';

use WPBaseTest\Framework\Entity\Tasck;
use Zend\Form\Annotation\AnnotationBuilder;
use SpiffyTest\Framework\TestCase;
use WPBase\Form\AbstractWPFormHandle;

class AbstractWPFormHandleTest extends \PHPUnit_Framework_TestCase
{
    public function dataProvider()
    {
        return array(
            array('service', $this->getMockService()),
            array('form', $this->getMockForm()),
        );
    }


    public function testVerificaSeClaseExiste()
    {
        $this->assertTrue(class_exists('\\WPBase\\Form\\AbstractWPFormHandle'));
    }

    public function testVerificaAtributosEsperados()
    {
        $class = '\\WPBase\\Form\\AbstractWPFormHandle';

        $this->assertClassHasAttribute('service', $class);
        $this->assertClassHasAttribute('entity', $class);
        $this->assertClassHasAttribute('form', $class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testVerificaClassePossuiGetAndSetsDosAtributos($atributo,$valor)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $atributo)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $atributo)));

        $class = $this->getMockForAbstractClass('\\WPBase\\Form\\AbstractWPFormHandle', array(
                new AnnotationBuilder(),
                $this->getMockEntity(),
                $this->getMockService()
            ));

        $class->$set($valor);

        $this->assertEquals($valor, $class->$get());
    }

    public function testVerificaMetodoHandle()
    {
        /**
         * @var $service \WPBase\Service\AbstractWPService
         */
        $service = $this->getMockService();
        $service->setEntity('WPBaseTest\Framework\Entity\Tasck');


        /**
         * @var $class \WPBase\Form\AbstractWPFormHandle
         */
        $class = $this->getMockForAbstractClass('\\WPBase\\Form\\AbstractWPFormHandle', array(
                new AnnotationBuilder(),
                new Tasck(),
                $service
            ));

        $this->assertTrue($class->handle(array('name' => 'teste')));
        $this->assertInstanceOf('\\Zend\\Form\\Form', $class->handle(array()));
    }

    private function getMockService()
    {
        return $this->getMockForAbstractClass('\\WPBase\\Service\\AbstractWPService', array(
                $this->getEmMock()
            ));
    }

    private function getMockEntity()
    {
        return $this->getMockForAbstractClass('\\WPBase\\Entity\\AbstractWPEntity');
    }

    private function getMockForm()
    {
        return $this->getMock('\\Zend\\Form\\Form',array(),array(),'',false);
    }

    private function getEmMock()
    {
        $emMock = $this->getMock('\Doctrine\ORM\EntityManager',
            array('persist','flush','getReference','remove'),array(),'',false);

        $emMock->expects($this->any())
            ->method('persist')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('remove')
            ->will($this->returnValue(null));

        $emMock->expects($this->any())
            ->method('flush')
            ->will($this->returnValue(null));

        return $emMock;
    }

}
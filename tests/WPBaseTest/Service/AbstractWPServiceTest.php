<?php

namespace WPBaseTest\Service;

class AbstractWPServiceTest extends \PHPUnit_Framework_TestCase
{
    public function dataProvider()
    {
        return array(
            array('entity', 'WPBaseTest\Framework\Entity\Tasck'),
        );
    }


    public function testVerificaSeClaseExiste()
    {
        $this->assertTrue(class_exists('\\WPBase\\Service\\AbstractWPService'));
    }

    public function testVerificaAtributosEsperados()
    {
        $class = '\\WPBase\\Service\\AbstractWPService';

        $this->assertClassHasAttribute('entity', $class);
        $this->assertClassHasAttribute('manager', $class);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testVerificaClassePossuiGetAndSetsDosAtributos($atributo,$valor)
    {
        $get = 'get'.str_replace(' ', '', ucwords(str_replace('_', ' ', $atributo)));
        $set = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $atributo)));

        $class = $this->getMockForAbstractClass('\\WPBase\\Service\\AbstractWPService', array(
                $this->getEmMock()
            ));

        $class->$set($valor);

        $this->assertInstanceOf('WPBaseTest\Framework\Entity\Tasck', $class->$get());
    }

    public function testVerificaSeExisteMetodosEsperados()
    {
        $class = '\\WPBase\\Service\\AbstractWPService';

        $this->assertTrue(method_exists($class, 'save'));
        $this->assertTrue(method_exists($class, 'remove'));
        $this->assertTrue(method_exists($class, 'find'));
        $this->assertTrue(method_exists($class, 'findAll'));
    }

    public function testVerificaSeRetornaRepository()
    {
        $this->assertInstanceOf('\Doctrine\ORM\EntityRepository', $this->getMockService()->getRepositoty());
    }

    public function testVerificaSeRetornaFindAndFindAll()
    {
        $this->assertNull($this->getMockService()->find(1));
        $this->assertNull($this->getMockService()->findAll());
    }

    public function testVerificaSeAlteraRegistro()
    {

        $insert = $this->getMockService()->save(array('name' => 'teste'), 1);

        $this->assertTrue($insert);
    }

    /**
     * @expectedException 	\InvalidArgumentException
     * @expectedExceptionMessage	O campo ID deve ser numérico
     */
    public function test_verifica_se_id_e_inteiro_no_metodo_delete()
    {
        $this->getMockService()->remove('opa');
    }


    public function testVerificaSeRemoveRegistro()
    {
        $this->assertTrue($this->getMockService()->remove(1));
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
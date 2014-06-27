<?php

namespace WPBaseTest\Form;

use WPBaseTest\Framework\TestCase;
use WPBase\Form\AbstractWPFormHandle;

class AbstractWPFormHandleTest extends TestCase
{
    public function testVerificaSeClaseExiste()
    {
        $this->assertTrue(class_exists('\\WPBase\\Form\\AbstractWPFormHandles'));
    }

    // public function testVerificaSeRetornaToArray()
    // {
    //
    //     $class = $this->getMockForAbstractClass('\\WPBase\\Entity\\AbstractWPEntity', array(array()));
    //
    //     $this->assertTrue(is_array($class->toArray()));
    // }


}

<?php

namespace WPBaseTest\Entity;

use SpiffyTest\Framework\TestCase;
use WPBase\Entity\AbstractWPEntity;

class AbstractWPEntityTest extends TestCase
{
    public function testClassExist()
    {
        $this->assertTrue(class_exists('\\WPBase\\Entity\\AbstractWPEntity'));
    }

    public function testVerificaSeRetornaToArray()
    {

        $class = $this->getMockForAbstractClass('\\WPBase\\Entity\\AbstractWPEntity', array(array()));

        $this->assertTrue(is_array($class->toArray()));
    }


}

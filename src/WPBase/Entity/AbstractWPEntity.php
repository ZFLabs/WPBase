<?php

namespace WPBase\Entity;

use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AbstractWPEntity
 *
 * @package WPBase\Entity
 */
abstract class AbstractWPEntity
{

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        (new ClassMethods())->hydrate($options, $this);

    }

    /**
     * @return array
     */
    public function toArray()
    {
        return (new ClassMethods())->extract($this);
    }

} 
<?php

namespace WPBaseTest\Framework\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\Form\Annotation as Form;
use WPBase\Entity\AbstractWPEntity;

/**
 * Class Tasck
 * @ORM\Table(name="tasck_db")
 * @ORM\Entity
 * @Form\Name("tasck")
 * @package Application\Entity
 */
class Tasck extends AbstractWPEntity
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Form\Exclude()
     * @var $id integer
     */
    protected $id;

    /**
     * @ORM\Column(name="name", type="string", length=45, nullable=false)
     * @Form\Required(true)
     * @var $name string
     */
    protected $name;

    /**
     * @param $id
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $name
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
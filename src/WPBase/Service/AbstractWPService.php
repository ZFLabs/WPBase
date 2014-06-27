<?php
namespace WPBase\Service;

use Doctrine\ORM\EntityManager;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AbstractWPService
 *
 * @package WPBase\Service
 */
abstract class AbstractWPService
{
    protected $entity;
    protected $manager;

    /**
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;

    }

    /**
     * @param $entity
     *
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setEntity($entity)
    {
        if(!is_string($entity))
            throw new \InvalidArgumentException('Entity is not string.');

        $this->entity = $entity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return new $this->entity;
    }

    /**
     * @param array $data
     * @param null  $id
     *
     * @return bool
     */
    public function save(Array $data, $id = null)
    {
        $entity = null;

        if((!is_null($id)) && $id > 0){
            $entity = (new ClassMethods())->hydrate(array_merge(array('id' => $id), $data), $this->getEntity());
            $this->manager->merge($entity);
        }else{
            $entity = new $this->entity($data);
            $this->manager->persist($entity);
        }
        $this->manager->flush();

        return true;
    }

    /**
     * @param $id
     *
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function remove($id)
    {
        if(!is_integer($id))
            throw new \InvalidArgumentException("O campo ID deve ser numérico");

        $entity = $this->manager->getReference(get_class($this->getEntity()), $id);

        $this->manager->remove($entity);
        $this->manager->flush();

        return true;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepositoty()
    {
        return $this->manager->getRepository(get_class($this->getEntity()));
    }

    /**
     * @param $id
     *
     * @return null|object
     */
    public function find($id)
    {
        return $this->getRepositoty()->find($id);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->getRepositoty()->findAll();
    }
}

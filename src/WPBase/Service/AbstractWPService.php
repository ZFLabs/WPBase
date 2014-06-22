<?php
namespace WPBase\Service;

use Doctrine\ORM\EntityManager;
use WPBase\Logger\WPLogger;
use Zend\Stdlib\Hydrator\ClassMethods;

/**
 * Class AbstractWPService
 *
 * @package WPBase\Service
 */
class AbstractWPService
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

        try{
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

        }catch (\Exception $e){
            WPLogger::addWriter($e);
            return false;
        }

    }

    /**
     * @param $id
     *
     * @return bool
     */
    public function remove($id)
    {
        try{
            $entity = $this->getRepositoty()->find($id);

            if(!$entity || is_null($entity))
                return false;

            $this->manager->remove($entity);
            $this->manager->flush();

            return true;

        }catch (\Exception $e){
            return false;
        }
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
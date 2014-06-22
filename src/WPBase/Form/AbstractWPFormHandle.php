<?php

namespace WPBase\Form;

use WPBase\Service\AbstractWPService;
use Zend\Form\Annotation\AnnotationBuilder;
use WPBase\Entity\AbstractWPEntity;
use Zend\Form\FormInterface;

/**
 * Class AbstractWPFormHandle
 *
 * @package WPBase\Form
 */
abstract class AbstractWPFormHandle
{
    protected $service;
    protected $entity;
    protected $form;

    /**
     * @param  object AnnotationBuilder $builder
     * @param  object AbstractWPEntity  $entity
     * @param  object AbstractWPService $service
     */
    public function __construct(AnnotationBuilder $builder, AbstractWPEntity $entity, AbstractWPService $service)
    {
        $form = $builder->createForm($entity);
        $this->setService($service);
        $this->setForm($form);
    }

    /**
     * @param array $data array containing the items of the form.
     * @param null  $cod matches the primary key of the table to perform the edit.
     *
     * @return bool|mixed
     */
    public function handle(Array $data, $cod = null)
    {
        $this->getForm()->setData($data);

        if ($this->getForm()->isValid()) {
            return $this->getService()->save($this->getForm()->getData(), $cod);
        }

        return $this->getForm();
    }

    /**
     * @param AbstractWPService $service
     *
     * @return $this
     */
    public function setService(AbstractWPService $service)
    {
        $this->service = $service;
        return $this;
    }

    /**
     * @return \WPBase\Service\AbstractWPService
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param $form
     *
     * @return $this
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }
}

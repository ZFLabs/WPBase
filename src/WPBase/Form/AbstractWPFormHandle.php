<?php

namespace WPBase\Form;

use WPBase\Service\AbstractWPService;
use Zend\Form\FormInterface;

/**
 * Class AbstractWPFormHandle
 *
 * @package WPBase\Form
 */
abstract class AbstractWPFormHandle
{
    protected $service;
    protected $form;

    /**
     * @param array $data array containing the items of the form.
     * @param null  $id matches the primary key of the table to perform the edit.
     *
     * @return bool|mixed
     */
    public function handle(Array $data, $id = null)
    {
        $this->getForm()->setData($data);

        if($this->getForm()->isValid()){
            return $this->getService()->save($this->getForm()->getData(), $id);
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
        $this->elements();

        return $this;
    }

    /**
     * @return mixed
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * With this method you can create the form elements.
     * If you want to generate the form for annotation, you have to create only the submit button.
     */
    abstract public function elements();

} 
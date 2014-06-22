<?php

namespace WPBase\Controller;

use Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\Exception\InvalidArgumentException;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\Paginator\Paginator;

/**
 * Class AbstractWPController
 *
 * @package Application\Controller
 * @method \Zend\Http\Request getRequest()
 * @method \Zend\Http\Response getResponse()
 * @method \Zend\Form\Form getFormHandle()
 */
abstract class AbstractWPController extends AbstractActionController
{
    public $service;
    public $itensPerPage = 20;
    public $controller;
    public $route;
    public $form;

    public function __construct()
    {
        if(is_null($this->service))
            throw new InvalidArgumentException('Service is not defined.');

        if(is_null($this->controller))
            throw new InvalidArgumentException('Controller is not defined.');

        if(is_null($this->route))
            throw new InvalidArgumentException('Route is not defined.');

        if(is_null($this->form))
            throw new InvalidArgumentException('Form is not defined.');
    }

    /**
     * listarAction listar todos os registros
     * @return \Zend\View\Model\ViewModel
     */
    public function listarAction()
    {
        //Caso tenha na listagem a possibilidade de selecionar vários registro para excluir,
        //Esta te IF verifica se é POST, caso seja ele percorre todos os registros e deleta, conforme
        //os itens marcados.
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost()->toArray();

            foreach($data['post'] as $id){
                if(!  $this->getWPService()->remove($id)){
                    $this->flashMessenger()->addInfoMessage('Alguns registros não foram deletados.');
                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'listar'));
                }
            }

            $this->flashMessenger()->addSuccessMessage('Registro(s) removido(s) com sucesso!');
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'listar'));
        }

        $paginator = new Paginator(new Selectable($this->getWPService()->getRepositoty(), new Criteria(null, array('id' => 'DESC'), null, null)));
        $paginator->setCurrentPageNumber($this->params()->fromRoute('page'))
                ->setItemCountPerPage($this->itensPerPage);

        return new ViewModel(array('data' => $paginator));
    }

    /**
     * novoAction criar registro
     * @return \Zend\View\Model\ViewModel
     */
    public function novoAction()
    {
        /**
         * @var $form \WPBase\Form\AbstractWPFormHandle
         */
        $form = $this->getServiceLocator()->get($this->form);

        if($this->getRequest()->isPost()){

            $handle = $form->handle($this->getRequest()->getPost()->toArray());

            if($handle === true){
                $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'novo'));
            }elseif($handle === false){
                $this->flashMessenger()->addWarningMessage('Não foi possível cadastrar!');
            }
        }
        return new ViewModel(array('form' => $form->getForm()));
    }

    /**
     * editarAction Edita registro
     * @return \Zend\View\Model\ViewModel
     */
    public function editarAction()
    {
        $entity = $this->getWPService()->find($this->params()->fromRoute('id'));

        if ($entity) {

            /**
             * @var $formHandle \WPBase\Form\AbstractWPFormHandle
             */
            $formHandle = $this->getServiceLocator()->get($this->form);
            $form = $formHandle->getForm()->setData($entity->toArray());

            if($this->getRequest()->isPost()){

                $handle = $formHandle->handle($this->getRequest()->getPost()->toArray(), $this->params()->fromRoute('id'));

                if($handle === true){
                    $this->flashMessenger()->addSuccessMessage('Atualizado com sucesso!');
                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'editar', 'id' => $this->params()->fromRoute('id')));
                }elseif($handle === false){
                    $this->flashMessenger()->addWarningMessage('Não foi possível atualizar!');
                }
            }

            return new ViewModel(array('form' => $form, 'id' => $this->params()->fromRoute('id')));
        }
        $this->flashMessenger()->addWarningMessage('Registro não encontrado');
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'listar'));
    }

    /**
     * deleteAction Remove registo
     * @return \Zend\View\Model\JsonModel
     */
    public function deleteAction()
    {
        $entity = $this->getWPService()->find($this->params()->fromRoute('id'));

        if(!$entity){
            $this->flashMessenger()->addWarningMessage('Registro não encontrado');
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'listar'));
        }

        if ($this->getRequest()->isXmlHttpRequest() || $this->getRequest()->isGet()) {
            return new JsonModel(array($this->getWPService()->remove($this->params()->fromRoute('id'))));
        }
    }

    /**
     * @return \WPBase\Service\AbstractWPService
     */
    public function getWPService()
    {
        return $this->getServiceLocator()->get($this->service);
    }
}

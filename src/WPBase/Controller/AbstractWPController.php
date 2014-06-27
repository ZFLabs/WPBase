<?php

namespace WPBase\Controller;

use Doctrine\Common\Collections\Criteria;
use DoctrineModule\Paginator\Adapter\Selectable;
use Zend\Mvc\Controller\AbstractActionController;
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

    /**
     * indexAction index todos os registros
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        //Caso tenha na listagem a possibilidade de selecionar vários registro para excluir,
        //Esta te IF verifica se é POST, caso seja ele percorre todos os registros e deleta, conforme
        //os itens marcados.
        if($this->getRequest()->isPost()){
            $data = $this->getRequest()->getPost()->toArray();

            foreach($data['post'] as $id){
                if(!  $this->getWPService()->remove($id)){
                    $this->flashMessenger()->addInfoMessage('Alguns registros não foram deletados.');
                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'index'));
                }
            }

            $this->flashMessenger()->addSuccessMessage('Registro(s) removido(s) com sucesso!');
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'index'));
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
        if($this->getRequest()->isPost()){

            $handle = $this->getWPForm()->handle($this->getRequest()->getPost()->toArray());

            if($handle === true){
                $this->flashMessenger()->addSuccessMessage('Cadastrado com sucesso!');
                return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'novo'));
            }elseif($handle === false){
                $this->flashMessenger()->addWarningMessage('Não foi possível cadastrar!');
            }
        }
        return new ViewModel(array('form' => $this->getWPForm()->getForm()));
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
            $formHandle = $this->getWPForm();
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

            return new ViewModel(array('form' => $this->getWPForm(), 'id' => $this->params()->fromRoute('id')));
        }
        $this->flashMessenger()->addWarningMessage('Registro não encontrado');
        return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'index'));
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
            return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'index'));
        }

        if ($this->getRequest()->isXmlHttpRequest() || $this->getRequest()->isGet()) {
            return new JsonModel(array($this->getWPService()->remove($this->params()->fromRoute('id'))));
        }
    }

    /**
     * @return \WPBase\Form\AbstractWPFormHandle
     */
    public function getWPForm()
    {
        return $this->getServiceLocator()->get($this->form);
    }

    /**
     * @return \WPBase\Service\AbstractWPService
     */
    public function getWPService()
    {
        return $this->getServiceLocator()->get($this->service);
    }
}

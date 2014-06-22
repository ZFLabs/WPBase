<?php
namespace WPBase\Mail;

use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;
use Zend\Mime\Message as MimeMessage;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part as MimePart;
use Zend\View\Model\ViewModel;
use Zend\Mail\Transport\Smtp;
use Zend\Mail\Message;

/**
 * Class WPMail
 *
 * @package WPBase\Mail
 */
class WPMail extends Message implements ServiceManagerAwareInterface
{
    protected $serviceManager;
    protected $page;
    protected $data;

    /**
     * @param ServiceManager $serviceManager
     * @param $page
     */
    public function __construct(ServiceManager  $serviceManager, $page)
    {
        $this->page = $page;
        $this->setServiceManager($serviceManager);
    }

    /**
     * set data
     *
     * @param array $data
     * @return $this
     */
    public function setData(Array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * get smtp options
     *
     * @return SmtpOptions
     */
    public function getSmtpOptions()
    {
        $config = $this->getServiceManaget()->get('Config');
        return new SmtpOptions($config['mail']);
    }

    /**
     * smtp transport
     *
     * @return Smtp
     */
    public function smtpTransport()
    {
        $transport = new Smtp();
        $transport->setOptions($this->getSmtpOptions());
        return $transport;
    }

    /**
     * render view
     *
     * @return mixed
     */
    public function renderView()
    {
        $model = new ViewModel;
        $model->setTemplate($this->page);
        $model->setOption('has_parent',true);
        $model->setVariables($this->getData());

        $view = $this->getServiceManaget()->get('View');

        return $view->render($model);
    }

    /**
     * prepare
     *
     * @return $this
     */
    public function prepare()
    {
        $html = new MimePart($this->renderView());
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts(array($html));
        $this->setBody($body);

        $config = $this->smtpTransport()->getOptions()->toArray();

        $this->addFrom($config['connection_config']['from']);

        return $this;
    }

    /**
     * send
     */
    public function send()
    {
        $this->smtpTransport()->send($this);
    }

    /**
     * Set service manager
     *
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }

    /**
     * get service manager
     *
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManaget()
    {
        return $this->serviceManager;
    }
}
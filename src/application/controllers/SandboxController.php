<?php 

class SandboxController extends Zend_Controller_Action
{

    public $ajaxable = array('list' => array('html'));

    /**
     * Switch context to XML
     */
    public function init()
    {
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('index', array('xml', 'json'))
                      ->setAutoJsonSerialization(false)
                      ->initContext();

        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('list', 'html')
                    ->initContext();
    }

    public function indexAction()
    {
        // code
    }

}
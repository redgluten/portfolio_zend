<?php 

class SandboxController extends Zend_Controller_Action
{
    /**
     * Switch context to XML
     */
    public function init()
    {
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('index', array('xml', 'json'))
                      ->initcontext();
    }

    public function indexAction()
    {
        // code
    }
}
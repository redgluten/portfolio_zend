<?php 


class SitemapController extends Zend_Controller_Action
{

    /**
     * Switch context to XML
     */
    public function init()
    {
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('index', 'xml')
                      ->initcontext('xml');
    }   

    public function indexAction()
    {
        
    }
}
<?php 

class Portfolio_Application_Resource_Form extends Zend_Application_ResourceAbstract
{
    public function init()
    {
        $this->getBootsrap()->bootstrap('FrontController');
    }
}
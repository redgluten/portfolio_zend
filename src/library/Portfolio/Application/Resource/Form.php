<?php 


/**
 * Resource Form
 * Allows element configuration from config file at app startup
 */
class Portfolio_Application_Resource_Form extends Zend_Application_Resource_ResourceAbstract
{
    public function init()
    {
        Portfolio_Form::$prefixPaths = $this->getOptions()['addPrefixPath'];
    }
}
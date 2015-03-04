<?php

class Portfolio_Form_Element_Email extends Zend_Form_Element_Xhtml
{
	/**
	 * Default form view helper to use for rendering
	 * @var string
	 */
	public $helper = 'formEmail';


    /**
     * @param string|array|Zend_Config $spec
     * @param array|Zend_Config        $options
     */
    public function __construct($spec, $options)
    {

        $this->addValidator('EmailAddress');

        parent::__construct($spec, $options);
    }
}

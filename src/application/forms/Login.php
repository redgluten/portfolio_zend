<?php


class Form_Login extends Zend_Form
{
    public function init()
    {
        $this->addElement('text', 'username', [
            'label'    => 'Login',
            'required' => true
        ]);

        $this->addElement('password', 'password', [
            'label'    => 'Password',
            'required' => true
        ]);

        $this->addElement('submit', 'send', [
            'label'    => 'Sign in',
        ]);      
    }
}
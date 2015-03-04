<?php

class Form_Contact extends Portfolio_Form
{

    public function init()
    {
        $this->addElement('text', 'name', [
            'placeholder' => 'Nom & Prénom',
            'required'    => true
        ]);

        $this->addElement('email', 'email', [
            'placeholder' => 'Email',
            'required'    => true
        ]);

        $this->addElement('textarea', 'message', [
            'placeholder' => 'Votre message',
            'required'    => true
        ]);

        $this->addElement('submit', 'send', [
            'label' => 'Envoyer',
        ]);
    }
}
<?php

class Form_User extends Portfolio_Form
{

    public function init()
    {
        $this->addElement('text', 'username', [
            'placeholder' => 'Identifiant',
            'validators' => [
                [
                    'Db_NoRecordExists',
                    false,
                    [
                        'messages' => 'Account not authorized',
                        'table'    => Model_DbTable_User::TABLE_NAME,
                        'field'    => Model_DbTable_User::COL_LOGIN
                    ],
                ]
            ],
            'required'    => true
        ]);

        $this->addElement('email', 'email', [
            'placeholder' => 'Email',
            'required'    => true
        ]);

        $this->addElement('password', 'password', [
            'placeholder' => 'Mot de passe',
            'required'    => true
        ]);

        $this->addElement('password', 'confirm_password', [
            'placeholder' => 'Confirmez votre mot de passe',
            'validators'  => [
                [
                    'Identical',
                    false,
                    [
                        'errorMessage' => 'Les mots de passe indiqués ne sont pas identiques',
                        'token'        => 'password'
                    ]
                ]
            ],
            'required' => true
        ]);

        $this->addElement('submit', 'send', [
            'label' => 'Créer votre compte',
        ]);
    }
}
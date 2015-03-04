<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // forward to another method
        $this->forward("login");
    }

    public function loginAction()
    {
        $form = new Form_Login();

        $session = new Zend_Session_Namespace('FAILURE_CREDENTIAL');

        // Captcha
        if (isset($session->count) and $session->count > 3) {
            $form->addElement('captcha', 'captcha', [
                'label' => 'Plaease enter the 5 letters displayed below',
                'required' => true,
                'captcha' => [
                    'captcha'        => 'Image',
                    'wordLen'        => 8,
                    'timeout'        => 300,
                    'height'         => 100,
                    'width'          => 300,
                    'fontSize'       => 22,
                    'imgDir'         => SRC_PATH . '/public/img/captcha',
                    'imgUrl'         => '/img/captcha',
                    'font'           => SRC_PATH . '/public/fonts/Consolas.ttf',
                    'timeout'        => 500,
                    'dotNoiseLevel'  => 0,
                    'linenoiseLevel' => 0
                ]
            ]);
        }

        $this->view->form = $form;

        // check presence of post request
        if ($this->getRequest()->isPost()) {

            // Get inputs
            $data = $this->getRequest()->getPost();

            // Validates form inputs
            if ($form->isValid($data)) {

                // Get filtered inputs
                $login    = $form->getValue('username');
                $password = $form->getValue('password');


                // DB auth adapter configuration
                $adapter = new Zend_Auth_Adapter_DbTable();
                $adapter->setTableName(Model_DbTable_User::TABLE_NAME)
                        ->setIdentityColumn(Model_DbTable_User::COL_LOGIN)
                        ->setCredentialColumn(Model_DbTable_User::COL_PASSWORD)
                        ->setIdentity($login)
                        ->setCredential($password);

                // User authentification via Zend_Auth
                $auth       = Zend_Auth::getInstance();
                $authResult = $auth->authenticate($adapter);

                // Rewrite storage to Model_User format
                if ($authResult->isValid()) {

                    $storage  = $auth->getStorage();
                    $sdtClass = $adapter->getResultRowObject(null, Model_DbTable_User::COL_PASSWORD);

                    $user = new Model_User();
                    $user->setId($sdtClass->{Model_DbTable_User::COL_ID})
                         ->setLogin($sdtClass->{Model_DbTable_User::COL_LOGIN});

                    $storage->write($user);
                    Zend_Session::namespaceUnset('FAILURE_CREDENTIAL');
                }

                // Return code handling
                if ($authResult->getCode() == Zend_Auth_Result::SUCCESS) {
                    $this->view->priorityMessenger('Authentification réussie', 'success');
                    $this->redirect($this->view->url([], 'indexIndex'));
                } else {
                    throw new Zend_Auth_Exception($authResult->getCode());
                    
                }
            }
        }
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();

        // Clear identity if exists
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
        }

        $this->view->priorityMessenger('Déconnexion réussie', 'success');
        $this->redirect($this->view->url(array(), 'indexIndex'));
    }

    public function stepTwo()
    {
        // code
    }
}


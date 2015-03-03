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
                }

                // Return code handling
                if ($authResult->getCode() == Zend_Auth_Result::SUCCESS) {
                    $this->view->priorityMessenger('Authentification réussie', 'success');
                    $this->redirect($this->view->url([], 'indexIndex'));
                } else {
                    throw new Zend_Exception($authResult->getMessages(), $authResult->getCode());
                    
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


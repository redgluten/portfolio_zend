<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
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

                $login    = $form->getValue('username');
                $password = $form->getValue('password');

                $adapter = new Zend_Auth_Adapter_DbTable();
                $adapter->setTableName(Model_DbTable_User::TABLE_NAME)
                        ->setIdentityColumn(Model_DbTable_User::COL_LOGIN)
                        ->setCredentialColumn(Model_DbTable_User::COL_PASSWORD)
                        ->setIdentity($login)
                        ->setCredential($password);

                $auth       = Zend_Auth::getInstance();
                $authResult = $auth->authenticate($adapter);

                if ($authResult->isValid()) {
                    $storage = $auth->getStorage();

                    $sdtClass = $adapter->getResultRowObject(null, Model_DbTable_User::COL_PASSWORD);

                    $user = new Model_User();
                    $user->setId($sdtClass->{Model_DbTable_User::COL_ID})
                         ->setLogin($sdtClass->{Model_DbTable_User::COL_LOGIN});

                    $storage->write($user);
                }

                if ($authResult->getCode() == Zend_Auth_Result::SUCCESS) {
                    $this->redirect($this->view->url([], 'indexIndex'));
                } else {
                    throw new Zend_Exception($authResult->getCode());
                    
                }
            }
        }
    }

    public function logoutAction()
    {
        $auth = Zend_Auth::getInstance();

        // Clear identity if existant
        if ($auth->hasIdentity()) {
            $auth->clearIndentity();
        }

        $this->redirect($this->view->url(array(), 'indexIndex'));
    }

    public function stepTwo()
    {
        // code
    }
}


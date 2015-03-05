<?php 

class UserController extends Zend_Controller_Action
{

    /**
     * Constructor
     */
    public function init()
    {
        // code
    }

    public function indexAction()
    {
        $this->forward('list');
    }


    public function listAction()
    {
        $service = new Service_User();

        $this->view->users = $service->getUserList();
    }

    public function createAction()
    {
        $form = new Form_User();
        $this->view->form = $form;

        if ($this->getrequest()->isPost()) {

            $data = $this->getRequest()->getPost();

            if ($form->isValid($data)) {
                $service = new Service_User();

                $user = new Model_User();
                $user->setLogin($form->getValue('username'));
                $user->setEmail($form->getValue('email'));
                $user->setPassword($form->getValue('password'));

                $service->save($user);

                $this->view->priorityMessenger("Inscription réussie", 'success');
            }
        }
    }

    public function readAction()
    {
        // code
    }


    public function updateAction()
    {
        $form = new Form_User();
        $this->view->form = $form;

        $id = $this->getRequest()->getParam('id');

        $acl = Zend_Registry::get('Zend_Acl');
        
        $userAuth = Zend_Auth::getInstance()->getIdentity();

        if (empty($id)) {
            $id = Zend_Auth::getInstance()->getIdentity()->getId();
        }

        $service = new Service_User();

        if ($user = $service->find($id)) {

            if ($acl->isAllowed($userAuth, $user, 'update')) {
                $form->populate($user);
                $form->send->setLabel('Modifier un compte');
            } else {
                $this->view->priorityMessenger("Accès refusée", 'error');
                $this->redirect($this->view->url(array(), 'indexIndex'));
            }
        }
        
        if ($this->getRequest()->isPost()) {

            $data = $this->getRequest()->getPost();

            if ($form->isValid($data)) {
                $service = new Service_User();
                
                $user = new Model_User();
                $user->setLogin($form->getValue('username'));
                $user->setEmail($form->getValue('email'));
                $user->setPassword($form->getValue('password'));
                
                $service->save($user);
                $this->view->priorityMessenger("Modification réussie", 'success');
            }
        }
    }


    public function deleteAction()
    {
        // code
    }
}
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
        
        if ($this->getRequest()->isPost()) {

                $data = $this->getRequest()->getPost();

                if ($form->isValid($data)) {
                        
                }
        }
    }


    public function deleteAction()
    {
        // code
    }

    public function listAction()
    {
        $service = new Service_User();

        $this->view->users = $service->getUserList();
    }
}
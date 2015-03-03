<?php

class ErrorController extends Zend_Controller_Action
{

    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        if (!$errors || !$errors instanceof ArrayObject) {
            $this->view->message = 'You have reached the error page';
            return;
        }
        
        switch ($errors->type) {

            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $priority = Zend_Log::NOTICE;
                $this->view->message = 'Page not found';
                break;

            default:

                switch (true) {
                    case $errors->exception instanceof Zend_Auth_Exception:
                        // Auth error
                        $this->getResponse()->setHttpResponseCode(500);
                        $this->view->message = 'Authentification error';

                        switch ($errors->exception->getMessage()) {
                            case Zend_Auth_Result::FAILURE:
                            case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
                                $message = "Echec d'authentification";
                                break;

                            case Zend_Auth_Result::FAILURE_CREDENTIAL_AMBIGUOUS:
                            case Zend_Auth_Result::FAILURE_UNCATEGORIZED:
                                $message = "Echec d'authentification";
                                break;

                            case Zend_Auth_Result::FAILURE_IDENTITIY_NOT_FOUND:
                                $message = "Identifiant inconnu";
                                break;
                        }

                        break;


                    case $errors->exception instanceof Zend_DB_Exception:
                        // DB error
                        $this->getResponse()->setHttpResponseCode(500);
                        $this->view->message = 'Database error';
                        break;
                    
                    default:
                        // application error
                        $this->getResponse()->setHttpResponseCode(500);
                        $priority = Zend_Log::CRIT;
                        $this->view->message = 'Application error';
                        break;
                }


                break;
        }
        
        // Log exception, if logger available
        if ($log = $this->getLog()) {
            $log->log($this->view->message, $priority, $errors->exception);
            $log->log('Request Parameters', $priority, $errors->request->getParams());
        }
        
        // conditionally display exceptions
        //if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        //}
        
        $this->view->request   = $errors->request;
    }

    public function getLog()
    {
        $bootstrap = $this->getInvokeArg('bootstrap');
        if (!$bootstrap->hasResource('Log')) {
            return false;
        }
        $log = $bootstrap->getResource('Log');
        return $log;
    }


}


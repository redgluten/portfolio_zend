<?php

class LinkedinController extends Zend_Controller_Action
{

    /**
     * @var array
     */
    protected $oauth_config;

    public function init()
    {
        $this->oauth_config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/linkedin.ini' , APPLICATION_ENV, true);
        $this->oauth_config->requestScheme = Zend_Oauth::REQUEST_SCHEME_HEADER;
    }

    public function indexAction()
    {
        $session = new Zend_Session_Namespace('Linkedin');
        
        $token   = $session->accessToken;
        
        // Use Likedin REST API
        $client  = $token->getHttpClient($this->oauth_config);

        // See https://developer.linkedin.com/docs/fields
        $client->setUri('https://api.linkedin.com/v1/people/~:(id,first-name,skills,educations,languages,twitter-accounts,email-address)');

        $client->setMethod(Zend_Http_Client::GET);

        try {

            $response = $client->request();
            $body     = new Zend_Config_XML($response->getBody());
            $this->_helper->viewRenderer->setNoRender();
            
            $linkedin_id = $body->get('id');

            /* Search of linkedin id in db
               if exists, create zend_auth
               else, validates account creation
            */
            

        } catch (Zend_Http_client_Exception $e) {

            $this->view->priorityMessenger('Erreur connexion Linkedin', 'danger');
            $this->redirect($this->view->url(array(), 'indexIndex'));
        }
    }

    public function callbackAction()
    {
        $this->_helper->viewRenderer->setNoRender();

        if ($this->getRequest()->isGet()) {

            $data = $this->getRequest()->getQuery();

            if (isset($data['oauth_problem'])) {

                $this->view->priorityMessenger('Accès refusé', 'danger');
                $this->redirect($this->view->url(array(), 'indexIndex'));

            } elseif(isset($data['oauth_token']) && isset($data['oauth_verifier'])) {

                // Create token acces
                $session = new Zend_Session_Namespace('Linkedin');
                
                $consumer = new Zend_Oauth_Consumer($this->oauth_config);
                $token = $consumer->getAccessToken($data, $session->requestToken);
                
                $session->accessToken = $token;
                
                // redirects to index
                $this->redirect($this->view->url(array(), 'linkedinIndex'));
            }
        }

        $this->redirect($this->view->url(array(), 'indexIndex'));
    }
}

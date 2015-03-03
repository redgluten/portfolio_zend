<?php

class Portfolio_Controller_Plugin_Language extends Zend_Controller_Plugin_Abstract
{
    public function routeShutdown(Zend_Controller_Request_Abstract $request)
    {
        $lang = $request->getParam('lang', null);

        $translate = Zend_Registry::get('Zend_Translate');

        if ($translate->isAvailable($lang)) {
            $translate->setlocale($lang);
        } else {
            $translate->setlocale('fr');
        }

        $front = Zend_Controller_Front::getInstance();

        /*
         * Vous pouvez régler des paramètres globaux dans un routeur, 
         * qui sont automatiquement fournis à la route lors de son assemblage, 
         * grâce à la fonction setGlobalParam(). 
         */

        $router = $front->getRouter();
        $router->setGlobalParam('lang', $lang);
    }
}
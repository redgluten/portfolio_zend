<?php

/**
 * Les fonctions commençant par _init* seront lancées automatiquement
 * Si * correspond à un nom de ressource Zend (dans Zend_Application_Resource_)
 * ou custom, la ressource sera surchargée automatiquement
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * Initialise la traduction
     * @return Zend_Translate
     */
    public function _initTranslate()
    {
        // Instance de Zend Translate et configuration
        $translate = new Zend_Translate('array', ROOT_PATH . '/data/i18n', 'auto', array('scan' => Zend_Translate::LOCALE_DIRECTORY));

        // Définition de la locale
        $translate->setLocale('en');

        Zend_Registry::set('Zend_Translate', $translate);

        return $translate;
    }

    /**
     * Initialise le routeur
     */
    public function _initRoutes()
    {
        // Lance le FrontController
        $this->bootstrap('FrontController');

        // Mance le Routeur (lecture de la config application.ini)
        $this->bootstrap('Router');

        $this->_frontController = $this->getResource('FrontController');

        $router = $this->_frontController->getRouter();

        // Création de la route pour la partie de l'url qui gère la langue
        $langRoute = new Zend_Controller_Router_Route(
            ':lang/',
            ['lang' => 'fr'],
            ['lang' => '[a-z]{2}']
        );

        // Création de la route pour la partie de de l'url par défaut (/controller/action)
        $defaultRoute = new Zend_Controller_Router_Route(
            ':controller/:action',
            [
                'module'     => 'default',
                'controller' => 'index',
                'action'     => 'index'
            ]
        );

        /**
         * @todo  à décommenter quand toutes les routes seront créees
         */
        // foreach ($router->getRoutes() as $routeName => $route) {
        //     $route = $langRoute->chain($route);
        //     $router->addRoute($routeName, $route);
        // }


        $defaultRoute = $langRoute->chain($defaultRoute);

        /**
         * @todo à supprimer quand toutes les routes seront créees
         */
        $router->addRoute('langRoute', $langRoute);
        $router->addRoute('defaultRoute', $defaultRoute);
    }

    /**
     * Access Control List
     */
    public function _initAcl()
    {
        $acl = new Zend_Acl();


        // Roles
        // =====
        $acl->addRole('guest');
        $acl->addRole('other', 'guest');
        $acl->addRole('root', 'other');


        // Resources
        // =========

        // Group CRUD
        $acl->addResource('CRUD');
        $acl->addResource('skill', 'CRUD');
        $acl->addResource('progress', 'CRUD');
        $acl->addResource('user', 'CRUD');

        $acl->addResource('auth');
        $acl->addResource('index');
        $acl->addResource('contact');
        $acl->addResource('sitemap');
        $acl->addResource('linkedin');
        $acl->addResource('viadeo');

        // Rules
        // =====

        // Allow guest to login
        $acl->allow('guest', 'auth', 'login');

        // Allow guest to see index & contact
        $acl->allow('guest', 'index', 'index');
        $acl->allow('guest', 'linkedin', 'index');
        $acl->allow('guest', 'linkedin', 'callback');        
        $acl->allow('guest', 'viadeo', 'index');
        $acl->allow('guest', 'viadeo', 'callback');
        $acl->allow('guest', 'contact', 'index');
        $acl->allow('guest', 'auth', 'linkedin');
        $acl->allow('guest', 'auth', 'callback');
        $acl->allow('guest', 'sitemap', 'index');

        // Deny connected user to login
        $acl->deny('other', 'auth', 'login');

        // Allow connected user to logout
        $acl->allow('other', 'auth', 'logout');

        // Allow guest to create new user
        $acl->allow('guest', 'user', 'create');

        // Guest has read and list on CRUD resources
        $acl->allow('guest', 'CRUD', ['read', 'list']);

        // Allow connected user to create resources
        $acl->allow('other', 'CRUD', 'create');

        // Deny connected user to create user
        $acl->deny('other', 'user', 'create');

        // Allow connected user to update and delete its own resources
        $acl->allow('other', 'CRUD', ['update', 'delete'], new Assert_Owner());

        // Allow root to update and delete all resources
        $acl->allow('root', 'CRUD', ['create', 'update', 'delete']);



        Zend_Registry::set('Zend_Acl', $acl);
    }
}

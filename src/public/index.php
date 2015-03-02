<?php

defined('ROOT_PATH')
	|| define('ROOT_PATH', realpath(dirname(dirname(__DIR__))));

defined('SRC_PATH')
	|| define('SRC_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'src');

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', SRC_PATH . DIRECTORY_SEPARATOR . '/application');

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../library'),
    get_include_path(),
)));

if (! file_exists(ROOT_PATH . DIRECTORY_SEPARATOR . 'vendor'. DIRECTORY_SEPARATOR . 'autoload.php')) {
	die('Veuillez lancer la commande "composer install" pour utiliser cette application');
}

require_once ROOT_PATH . DIRECTORY_SEPARATOR . 'vendor'. DIRECTORY_SEPARATOR . 'autoload.php';

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();
<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initTranslate()
    {
        $translate = new Zend_Translate('array', ROOT_PATH . '/data/i18n', 'auto', array('scan' => Zend_Translate::LOCALE_DIRECTORY));
        $translate->setLocale('en');
        Zend_Registry::set('Zend_Translate', $translate);
        return $translate;
    }
}


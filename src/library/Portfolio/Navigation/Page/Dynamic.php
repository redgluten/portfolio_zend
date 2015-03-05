<?php 


class Portfolio_Navigation_Page_Dynamic extends Zend_Navigation_Page_Mvc
{

    public function setService($service)
    {
        $this->service = new Service();
    }

    public function getService()
    {
        return $this->service;
    }

    public function setLabel($label)
    {
        $requestParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();

        if (empty($requestParam['id'])) {
            return parent::setLabel($label);
        }

        $model = $this->getService()->find($requestParams['id']);

        $label = 'Modification de ' . $model->getLogin();

        return parent::setLabel();
    }
}
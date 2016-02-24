<?php

class Application_Model_Menu extends App_Model_Abstract
{

    public function __construct()
    {
        $this->_logger = Zend_Registry::get('log');
    }

    public function getMenuItems()
    {
        return $this->getResource('Menu')->getMenuItems();
    }

}

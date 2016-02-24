<?php

class Application_Resource_Menu extends Zend_Db_Table_Abstract
{
    protected $_name = 'menu';
//    protected $_primary  = 'id';
//    protected $_rowClass = 'Application_Resource_Menu_Item';

    public function init()
    {

    }

    public function getMenuItems()
    {
        $select = $this->select();
        return $this->fetchAll($select);
    }


}

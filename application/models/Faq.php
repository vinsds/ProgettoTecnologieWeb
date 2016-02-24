<?php

class Application_Model_Faq extends App_Model_Abstract{

    public function __construct()
    {
        $this->_logger = Zend_Registry::get('log');
    }

    public function getFaq($id)
    {
        return $this->getResource('Faq')->getFaq($id);
    }

    public function getFaqList()
    {
        return $this->getResource('Faq')->getFaqList();
    }

    public function insertFaq($data)
    {
        return $this->getResource('Faq')->insertFaq($data);
    }

    public function deleteFaq($id)
    {
        return $this->getResource('Faq')->deleteFaq($id);
    }

    public function editFaq($data, $id)
    {
        return $this->getResource('Faq')->editFaq($data, $id);
    }



}

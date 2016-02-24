<?php
    class App_Controller_Utente extends App_Controller_Guest{

        protected $_logged_user;
        protected $search;

        public function init(){
            parent::init();
            $this->_helper->layout->setLayout('utente');
            $this->view->search = $this->getSearchForm();
            $this ->_logged_user = Zend_Auth::getInstance()->getIdentity();

        }


        protected function getLoggedUser() {

            return $this ->_logged_user;

        }

        private function getSearchForm()
        {
            $urlHelper = $this->_helper->getHelper('url');
            // $this->_form = new Application_Form_Public_Search();
            $this->search = new Application_Form_Public_Search();
            $this->search->setAction($urlHelper->url(array(
                'controller' => 'catalogo',
                'action' => 'search'),
                null, true)
            );
            return $this->search;
        }
    }
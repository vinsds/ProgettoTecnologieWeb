<?php

class LoginController extends App_Controller_Guest
{
    protected $_form;
    protected $_authService;

    public function init()
    {
        parent::init();
        //è un servizio quindi è condivisa, perchè la uso quando vengo rimandato a qualsiasi form di login
        $this->_authService = new Application_Service_Auth();
        $this->view->loginForm = $this->getLoginForm();
    }

    public function indexAction()
    {
        $this->checkUser();
    }

    //Azione di Autenticazione
    public function accessAction()
    {

        //controllo se una sessione è attiva


        $request = $this->getRequest();
        if (!$request->isPost()) {
            return $this->_helper->redirector('index');
        }
//        $form = $this->_form;
        if ($request->isPost()) {
            $data = $request->getPost();

            $this->_form->isValid($request->getPost());

            if (!$this->_form->isValid($data)) {
//                $this->_form->setDescription('Attenzione: alcuni dati inseriti sono errati.');
                $this->view->assign('msg', "Autenticazione fallita");
                return $this->render('index');
            }

            if (false === $this->_authService->authenticate($this->_form->getValues())) {
                $this->view->assign('msg',"Autenticazione fallita. Controllare i campi");
                return $this->render('index');

            }
            //return $this->_helper->json(array('redirect'=>'success'));

            $role = Zend_Auth::getInstance()->getIdentity()->role;
            switch ($role) {
                case Application_Model_Acl::ROLE_TECNICO:
                    $this->_helper->redirector('index', 'catalogo');
                    break;
                case Application_Model_Acl::ROLE_STAFF:
                    $this->_helper->redirector('index', 'malfunzionamento');
                    break;
                case Application_Model_Acl::ROLE_ADMIN:
                    $this->_helper->redirector('index', 'admin');
                    break;
                default:
                    $this->_helper->redirector('access', 'login');

            }

        }

    }

    //Setto l'azione di Login
    private function getLoginForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Public_Login();
        $this->_form->setAction($urlHelper->url(array(
            'controller' => 'login',
            'action' => 'access'),
            'default'
        ));
        return $this->_form;
    }

    public function logoutAction()
    {

        $this->_authService->clear();
        return $this->_helper->redirector('index', 'public');

    }

    private function checkUser()
    {

        if (Zend_Auth::getInstance()->hasIdentity()) {
            $role = Zend_Auth::getInstance()->getIdentity()->role;
            switch ($role) {
                case Application_Model_Acl::ROLE_TECNICO:
                    $this->_helper->redirector('index', 'catalogo');
                    break;
                case Application_Model_Acl::ROLE_STAFF:
                    $this->_helper->redirector('index', 'malfunzionamento');
                    break;
                case Application_Model_Acl::ROLE_ADMIN:
                    $this->_helper->redirector('index', 'admin');
                    break;
                default:
                    $this->_helper->redirector('access', 'login');
            }
        }
    }


}


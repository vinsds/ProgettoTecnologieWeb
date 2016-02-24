<?php

class CentroController extends App_Controller_Admin
{
    //Todo queste vanno spostate sul controller admin

    protected $urlHelper;

    public function init()
    {
        parent::init();
//        $this->_helper->layout('utente');
        $this->view->aggiungiCentro = $this->createCentro();

        //new Application_Form_Admin_AggiungiCentro();
        $this->view->editCentro = $this->editCentro();

    }


    public function indexAction()
    {
        //recupero tutti i centri con le relative info e lo mando alla view
        $this->view->assign('msg',"Gestione centri assistenza");

    }

    public function centrilistAction(){
        $centri = $this->_assistenzaModel->getAllCentri()->toArray();
        $this->view->assign('msg','Lista Centri assistenza');

        if(count($centri)==0){
            $this->view->assign('empty','Non sono presenti centri nel database');
        }else if(count($centri)>0){
            $this->view->assign('centri', $centri);
        }
    }

    public function aggiungiAction(){
        $this->view->assign('msg',"Compila i campi per aggiungere un centro");
    }

    public function addAction()
    {

        if (!$this->getRequest()->isPost()) {
//            $this->_helper->redirector('error');

        }
        if (!$this->_formCentro->isValid($_POST)) {
            $this->_formCentro->setDescription('ATTENZIONE! I CAMPI NON POSSONO ESSERE VUOTI');
            $this->view->assign('form', $this->_formCentro);
            $this->render('aggiungi');
            return;
        }

        $values = $this->_formCentro->getValues();

        $mail = array();
        $regMail = "/[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,3}$/";
        if(preg_match_all($regMail,$values['mail'],$mail)==0)
        {
            $this->view->assign('msg', 'Mail inserita non valida. <br /> Il formato accettato è il seguente: caratteri@caretteri.dominio');
            $this->view->assign('form', $this->_formCentro);
            $this->render('aggiungi');
            return;
        }

        $validator = new Zend_Validate_Db_RecordExists(
            array(
                'table'=>'assistenza',
                'field'=>'nome'
            )
        );

        if($validator->isValid($values['nome']))
        {
            $this->view->assign('msg','Attenzione! Il nome inserito è già associato ad un centro. Controllare.');
            $this->view->assign('form', $this->_formCentro);
            $this->render('aggiungi');
            return;
        }
        $insert=$this->_assistenzaModel->insertCentro($values);

        if(count($insert)>=0){
            $this->view->assign('msg',"Inserimento effettuato correttamente");
            $this->view->assign('class',"add-centro");
        }else{
            $this->view->assign('error',"Inserimento effettuato correttamente");
        }

//        $this->_helper->redirector('index');

    }


    public function modificaAction()
    {

        $id = $this->getParam('id');
        $centro = $this->_assistenzaModel->getCentro($id)->toArray();
        $this->_formCentroEdit->setDefaults($centro);
        $this->view->assign('msg','Modifica centro assistenza');
        $this->view->assign('formEdit', $this->_formCentroEdit);
    }

    public function editAction()
    {
        if (!$this->getRequest()->isPost()) {

            $this->_helper->redirector('error');
        }
        $post = $this->getRequest()->getPost();
        if (!$this->_formCentroEdit->isValid($post)) {
            $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('form', $this->_formCentroEdit);
            $this->render('edit');
            return;
        }

        $values = $this->_formCentroEdit->getValues();

        $validator = new Zend_Validate_Db_RecordExists(
            array(
                'table'=>'assistenza',
                'field'=>'nome'
            )
        );
        /*
        if($validator->isValid($values['nome']))
        {
            $this->view->assign('msg','Attenzione! Il nome inserito è già associato ad un centro. Controllare.');
            $this->view->assign('form', $this->_formCentroEdit);
            $this->render('modifica');
            return;
        }*/
        $this->_assistenzaModel->editCentro($values, $values['id_centro']);
        $this->view->assign('class','edit-centro-on');
        $this->render('modifica');
        //$this->_helper->redirector('index');


    }

    public function deleteAction()
    {
        $id = $this->_getParam('id');
        $del=$this->_assistenzaModel->deleteCentro($id);
        if(count($del)>=0){
            $this->view->assign('msg',"Cancellazione effettuata correttamente");
        }else{
            $this->view->assign('msg',"Cancellazione non effettuata");
        }
        $this->view->assign('class',"delete-on");

    }


    /** funzioni private per le form */
    private function createCentro()
    {
        $urlHelper = $this->_helper->getHelper('url')->url(array(
            'controller' => 'centro',
            'action' => 'add'),
            'default'
        );
        $this->_formCentro = new Application_Form_Admin_AggiungiCentro();
        $this->_formCentro->setAction($urlHelper);
        return $this->_formCentro;
    }

    private function editCentro()
    {
        $urlHelper = $this->_helper->getHelper('url')->url(array(
            'controller' => 'centro',
            'action' => 'edit'),
            'default'
        );
        $this->_formCentroEdit = new Application_Form_Admin_ModificaCentro();
        $this->_formCentroEdit->setAction($urlHelper);
        return $this->_formCentroEdit;
    }


}


<?php

class ProfiloController extends App_Controller_Utente
{
    protected $form;
    public $formedit;
    private $_userModel;

    public function init()
    {
        parent::init();
        //Qui si richiamano le form      
        $this->_userModel = new Application_Model_User();
        $this->formedit = new Application_Form_Profilo_Profilo();
        $urlHelper = $this->_helper->getHelper('url');
        $this->formedit->setAction($urlHelper->url(array(
            'controller' => 'profilo',
            'action' => 'edit'
        )));

    }

    public function indexAction()
    {

    }

    /**
     *
     */
    public function editAction()
    {
//        $this->view->assign('label', 'MODIFICA DATI');
        $this->view->assign('msg', 'Pannello per la modifica dei dati personali');

        //prendo i valori per popolare la form profilo e lo faccio
        $values = $this->_userModel->getUser($this->getLoggedUser()->id_user)->toArray();
        $this->formedit->setDefaults($values);

        if (!$this->getRequest()->isPost()) {
//            $this->_helper->redirector('error');
            $this->view->assign('editprofile', $this->formedit);
            return;
        }

        $post = $this->getRequest()->getPost();

        /** 1) Se il campo verifica password è stato lasciato vuoto lo devo togliere.
         *  2) Se il campo password non è vuoto e ho tolto il campo verifica password perchè l'utente l'ha lasciato vuoto
         *     non permetto la modifica della password. Per farlo controllo se il contenuto del campo password è stato * modificato rispetto al login.
         * 3) Se invece l'utente ha il campo password e verificapassword pieni devo controllare se sono uguali.
         *   Se non * lo sono blocco la modifica del profilo.
         */

        if(empty($post['verificapassword']))
        {
            $this->formedit->getElement('verificapassword')->setRequired(false);
            unset($post['verificapassword']);
        }

//        if(!empty($post['password']) && !isset($post['verificapassword']))
//        {
//            if($post['password'] != $this->getLoggedUser()->password)
//            {
//                $msg = "Per cambiare la password riempire anche il campo verifica password";
//                $this->view->assign('msgerror',$msg);
//                $this->view->assign('editprofile',$this->formedit);
//                $this->render('edit');
//                return;
//            }
//        }

        if (!$this->formedit->isValid($post)) {
            $this->view->assign('msgerror', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('editprofile', $this->formedit);
            $this->render('edit');
            return;
        }

        $values = $this->formedit->getValues();

        $date = array();
        $regDate = "/^(18|19|20)\\d\\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/";
        if(preg_match_all($regDate, $values['nascita'], $date) == 0)
        {

            $this->view->assign('msgerror', 'Il formato della data accettato è YYYY-MM-GG');
            $this->view->assign('editprofile', $this->formedit);
            $this->render('edit');
            return;
        }


        /** espressione regolare per filtrare i caratteri speciali  */

        $validator = new Zend_Validate_Db_RecordExists(
            array(
                'table'=>'user',
                'field'=>'user'
            )
        );

        if($validator->isValid($values['user']))
        {
            $this->view->assign('msgerror','Attenzione! Il nome inserito è già associato ad un utente. Controllare.');
            $this->view->assign('editprofile', $this->formedit);
            $this->render('edit');
            return;
        }


        $username = array();
        $regUser = "/[-+!$%^&*()_+|\"£\\/~=`{}\\\\:;'<>?#.,\\@\\[]/";
        if(preg_match_all($regUser,$values['user'],$username) > 0)
        {
            $this->view->assign('msgerror', 'Non sono accettati caratteri speciali nel campo username');
            $this->view->assign('editprofile', $this->formedit);
            $this->render('edit');
            return;
        }

        /** Se non ho un match valido è stata inserita una mail non valida */
        $mail = array();
        $regMail = "/[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,3}$/";
        if(preg_match_all($regMail,$values['email'],$mail)==0)
        {
            $this->view->assign('msgerror', 'Mail inserita non valida. <br /> Il formato accettato è il seguente: caratteri@caretteri.dominio');
            $this->view->assign('editprofile', $this->formedit);
            $this->render('edit');
            return;
        }

        /**
         * Acquisisco i valori di password e verifica password.
         * Qui so che sono entrambi pieni. Prima il regex  Controllo se sono uguali.
         */

        $password = $values['password'];
        $verPassword = $values['verificapassword'];


        //se è vuoto lo tolgo. L'utente non potrà cambiare la password.
        if(empty($verPassword)){
            $this->formedit->pwdNotChanged();
            unset($verPassword);
            unset($values['verificapassword']);
        }

        //password piena e verificapassword non settata vedo se ho cambiato solo uno dei due campi
        if(!empty($password) && !isset($verPassword)){
            if($password != $this->getLoggedUser()->password){
                $msg = "Per cambiare la password riempire anche il campo verifica password";
                $this->view->assign('msgerror',$msg);
                $this->view->assign('editprofile', $this->formedit);
                $this->render('edit');
                return;
            }
        }
        if(!empty($password) && isset($verPassword)){
            if($password != $verPassword){
                $msg = "Per cambiare la password i campi password e verifica password devono coincidere";
                $this->view->assign('msgerror',$msg);
                $this->view->assign('editprofile', $this->formedit);
                $this->render('edit');
                return;
            } else {
                unset($values['verificapassword']);
            }
        }

        /** espressione per la password */
        $re = "/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*/";

        if(preg_match_all($re,$password,$matches) == 0)
        {
            $this->view->assign('msg','Inserita password non valida. <br /> Deve contenere almeno una lettera maiuscola, una minuscola e numeri. Lunghezza minima 4 caratteri.');
            $this->view->assign('editprofile',$this->formedit);
            $this->render('edit');
            return;
        }

//        if ($password == $verPassword)
//        {
//            $this->formedit->pwdNotChanged();
//            unset($values['verificapassword']);
//        } else {
//            $this->view->assign('msg','I campi password e verifica password devono coincidere');
//            $this->view->assign('editprofile',$this->formedit);
//            $this->render('edit');
//            return;
//        }
        $id = $this->getLoggedUser()->id_user;
        $this->_userModel->editUser($values, $id);

        unset($values);
        $this->view->assign('editprofile',$this->formedit);
//        $this->_helper->redirector('edit');
        $this->view->assign('correct',"Modifica effettuata");
        $this->render('edit');


    }


}


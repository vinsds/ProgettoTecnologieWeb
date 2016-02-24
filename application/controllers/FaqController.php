<?php

class FaqController extends App_Controller_Admin
{
    protected $_faqModel;
    protected $_formFaq;
    protected $_formUpdateFaq;

    public function init()
    {
        parent::init();

        $this->_faqModel = new Application_Model_Faq();
        $this->view->formFaq = $this->getFaqForm();
        $this->view->formUpdateFaq = $this->getFaqUpdateForm();
    }

    public function indexAction()
    {
        $form = new Application_Form_Public_Faq();
        $this->view->form = $form;
        $this->view->assign('msg','GESTIONE F.A.Q');
		$list = $this->_faqModel->getFaqList()->toArray();
        $this->view->list = $list;
    }


    public function faqlistAction(){

        $this->view->assign('msg','Elenco F.A.Q');
        $list = $this->_faqModel->getFaqList()->toArray();
        if(count($list)>0){
            $this->view->list = $list;
        }else{
            $this->view->assign('empty',"Non sono presenti f.a.q. nel database");
        }
    }
    
    //SENZA STA ACTION NON CARICA LA FORM DI CREAZIONE LOL
    public function newfaqAction()
    {
        $this->view->assign('msg','CREA UNA NUOVA F.A.Q');
    }

    public function createAction()
    {
        $this->view->assign('label', 'CREA UNA NUOVA F.A.Q');
        $this->view->assign('subLabel', 'Pannello per la creazione delle faq');

        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('index');
        }
        $form = $this->_form;
        if (!$form->isValid($_POST)) {
            $this->view->assign('error', "I dati inseriti non sono validi");
            $this->view->assign('form', $form);
            $this->render('newfaq');
            return;
        }

        $values = $form->getValues();
        $this->_faqModel->insertFaq($values);
        $this->view->assign('class', "insert");

        $this->view->assign('correct', "f.a.q. inserita correttamente");
        $this->render('newfaq');
    }
    
    
    public function editAction(){
        $this->view->assign('msg', 'modifica f.a.q. selezionata');
        $id=$this->_getParam('id');
        $faq=$this->_faqModel->getFaq($id)->toArray();
        $this->_formUpdate ->setDefaults($faq);

        if (!$this->getRequest()->isPost()) {
            $this->view->assign('formUpdateFaq',$this->_formUpdate);
            return;
		}

        $post = $this->getRequest()->getPost();
		if (!$this->_formUpdate->isValid($post)) {
            $this->view->assign('error',"Errore. Controllare i campi.");
            $this->view->assign('formUpdateFaq',$this->_formUpdate);
            return;
		}
		
		$values=array('domanda'=>$this->getParam('domanda', null),'risposta'=>$this->getParam('risposta', null));

        $this->_faqModel->editFaq($values, $id);
        $this->view->assign('class', "edit-on");
        $this->view->assign('correct', "f.a.q. modificata correttamente");
        $this->render('edit');
        
    }
    
    public function deleteAction()
	 {
         $id=$this->_getParam('id');
         $faq=$this->_faqModel->deleteFaq($id);
         if($faq>=0){
             $this->view->assign('msg','eliminazione avvenuta con successo');
             $this->view->assign('class','add-faq-on');
         }else{
             $this->view->assign('error','la faq non è stata eliminata correttamente');
         }
//         return $this->_helper->redirector('faqlist');
        $this->render('delete');
    }


    private function getFaqForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Public_Faq();
        $this->_form->setAction($urlHelper->url(array(
                        'controller' => 'faq',
                        'action' => 'create'),
                        'default'
                        ));
        return $this->_form;
    }
    
    private function getFaqUpdateForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_formUpdate = new Application_Form_Public_Edit();
        $this->_formUpdate->setAction($urlHelper->url(array(
                        'controller' => 'faq',
                        'action' => 'edit'),
                        'default'
                        ));
        
        return $this->_formUpdate;
    }
    
}


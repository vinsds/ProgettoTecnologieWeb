<?php

class MalfunzionamentiController extends Zend_Controller_Action
{


//    protected $_prodottoModel;
//    protected $_prodottoMalfunzionamento;
//    protected $_tipoMalfunzionamento;
//    protected $_sottocategorie;
//    protected $_categorie;
//
//    protected $_componenteMalfunzionamento;
//
//    protected $_malfunzionamenti;
//    protected $_componenti;
//    protected $_ricercaComponente;
//    protected $_malfSol;
//    protected $_soluzioni;
//
//    protected  $_prodottoComponente;
//    protected $_search;
//    /** @var Application_Form_Public_Search searchForm */
//    protected $searchForm;




    public function init()
    {
        $this->_helper->layout->setLayout('utente');
        $this->_prodottoMalfunzionamento= new Application_Model_ProdottoMalfunzionamento();
        $this->_prodottoModel = new Application_Model_Prodotto();
//        $this->_malfunzionamenti = new Application_Model_ProdottoMalfunzionamento();
        $this->_tipoMalfunzionamento= new Application_Model_Malfunzionamento();
        $this->_componenti= new Application_Model_Componente();
        $this->_ricercaComponente= new Application_Model_Componente();
        $this->_sottocategorie=new Application_Model_Sottocategorie();

        $this->_prodottoComponente=new Application_Model_ProdottoComponente();

        $this->_categorie=new Application_Model_Categorie();

        //DA CONTROLLARE --> Deve andarci il model
        $this->_malfSol= new Application_Resource_MalfunzionamentoSoluzione();

        $this->_soluzioni=new Application_Model_Soluzione();

        $this->_componenteMalfunzionamento= new Application_Model_ComponenteMalfunzionamento();

        $this->_search=new Application_Model_Cerca();
        $this->view->search = $this->getSearchForm();
        $this->view->edit = $this->getEditFrom();
        $this->view->create = $this->getCreateForm();

        $this->searchForm = $this->getSearchForm();

    }

//    public function indexAction()
//    {
//
//    }
//
//
//    public function productlistAction(){
//            $msg="prodotti";
//            $item=$this->_prodottoModel->getAllProdotti()->toArray();
//            $this->view->assign('prodotti',$item);
//            $this->view->assign('msg',$msg);
//    }

//    public function itemdetailAction(){
//        $msg="Dettaglio prodotto selezionato";
//        $id=$this->getParam('id');
//
//
//        $item=$this->_prodottoModel->getProdotto($id)->toArray();
//
////        if(count($item)==0){
////            $this->_helper->redirector('pippo', 'pippo');
////        }else{
////            $item2=$item->toArray();
////        }
//
//
//
//        //Ricerca associazione componente malfunzionamento
//        $ass=$this->_prodottoMalfunzionamento->getProdottoProblemById($id)->toArray();
//
//        for($i=0; $i<count($ass); $i++){
//            $malfComponente=$this->_tipoMalfunzionamento->getMalfunzionamenti($ass[$i]['id_malfunzionamento'])->toArray();
//        }
//
//        $prodComp= $this->_prodottoComponente->getComponenteByProdotto($id)->toArray();
//        if($prodComp==null){
//            $this->view->assign('msg',"Non sono presenti componenti per questo prodotto");
//        }else{
//            $componenti=array();
//            $vect=array();
//            for($i=0; $i<count($prodComp); $i++){
//                $componenti[$i]=$this->_componenti->getComponente($prodComp[$i]['id_componente'])->toArray();
//                $vect[$i]=$componenti[$i][0];
//            }
//            $this->view->assign('componenti', $vect);
//        }
//        $this->view->assign('item',$item);
//
//        if(count($malfComponente)>0){
//            $this->view->assign('malf_prod',$malfComponente);
//        }
//        $this->view->assign('msg',$msg);
//    }


//    public function componentdetailAction(){
//        $msg="Dettaglio componente";
//        $idItem=$this->getParam('id');
//
//        $componenti=$this->_componenti->getComponente($idItem)->toArray();
//
//        //Ricerco associazione componente - malfunzionamento
//        $malf=$this->_componenteMalfunzionamento->getComponenteProblemById($idItem)->toArray();
//        if(count($malf)==0){
//            $this->view->assign('msg',"Non sono presenti malfunzionamenti per questo componente");
//        }else{
//            for($i=0; $i<count($malf); $i++){
//                $malfunzionamenti[$i]=$this->_tipoMalfunzionamento->getMalfunzionamenti($malf[$i]['id_malfunzionamento'])->toArray();
//                $vect[$i]=$malfunzionamenti[$i][0];
//            }
//            $this->view->assign('malfunzionamenti', $vect);
//        }
//        $this->view->assign('componente', $componenti);
//        $this->view->assign('msg',$msg);
//
//    }
///////////////////////////////////////////////////////////////////////////////
////
//    public function malfunzionamentoAction(){
//        $this->_helper->viewRenderer->setNoRender();
//        $this->_helper->getHelper('layout')->disableLayout();
//
//        $request = $this->getRequest()->getPost();
//        $idItem = $request['id'];
//
//        //Insieme ID malfunzionamenti associati al componente
//        $malf=$this->_componenteMalfunzionamento->getComponenteProblemById($idItem)->toArray();
//        for($i=0; $i<count($malf); $i++){
//            $malfunzionamenti[$i]=$this->_tipoMalfunzionamento->getMalfunzionamenti($malf[$i]['id_malfunzionamento'])->toArray();
//            $vect[$i]=$malfunzionamenti[$i][0];
//        }
//
//        $json = Zend_Json::encode($vect);
//
//        echo ($json);
//    }

//    public function findsolutionAction(){
//        if($this->getRequest()->isXmlHttpRequest()){
//            $this->_helper->viewRenderer->setNoRender();
//            $this->_helper->getHelper('layout')->disableLayout();
//
//            $request = $this->getRequest()->getPost();
//            $id = $request['id'];
//
//            //Malfunzionamento associato all'id:
//
//            $descrizioneMalfunzionamento=$this->_tipoMalfunzionamento->getMalfunzionamenti($id)->toArray();
//
//            $item=$this->_malfSol->getMalfunzionamentoSoluzione($id)->toArray();
//            if(count($item)>0) {
//                for ($i = 0; $i < count($item); $i++) {
//                    $soluzioni[$i] = $this->_soluzioni->getSoluzioni($item[$i]['id_malfunzionamento'])->toArray();
//                    $vect[$i]=$soluzioni[$i][0];
//
//                }
//            }
//
//            $associazione=array("malfunzionamento" =>$descrizioneMalfunzionamento, "soluzione"=>$vect);
//            $json = Zend_Json::encode($associazione);
//            echo ($json);
//        }else{
//            return false;
//        }
//
//    }
//
//
//    public function malfunzionamentilistAction(){
//        $msg="Malfunzionamenti";
//        $allItems=$this->_tipoMalfunzionamento->getAll()->toArray();
//        $this->view->assign('malf',$allItems);
//        $this->view->assign('msg',$msg);
//    }


//    public function searchAction(){
//        //Se vera -> malfunzionamenti altrimenti descrizione
//        if (!$this->getRequest()->isPost()) {
//            $this->_helper->redirector('pippo2');
//        }
//
//        if(!$this->searchForm->isValid($this->getRequest()->getPost())){
//            $this->_helper->redirector('productlist');
//        }
//
//        $values=$this->searchForm->getValues();
//        $desc=$values['desc_prod'];
////        var_dump($desc); die();
//
//        $malf=$values['descrizione'];
//
//        if($desc==null){
//            if($malf!=null){
//                //TODO ricerca prodotto tramite malfunzionamenti
//                $results=$this->_search->cercaMalf($malf)->toArray();
//                $this->view->assign('word',$malf);
//                $flag=true;
//                $msg="Risultato ricerca malfunzionamenti";
//            }
//        }else{
//            //TODO ricerca prodotto tramite descrizione (WILDCARD)
//
//            $desc_replace = str_replace("*",".*",$desc);
//            $results=$this->_search->cercaDesc($desc_replace)->toArray();
//            $this->view->assign('word',$desc);
//            $flag=false;
//            $msg="Risultato ricerca prodotto";
//        }
//
//        $this->view->assign('results',$results);
//        $this->view->assign('msg',$msg);
//        $this->view->assign('flag',$flag);
//
//    }




//    public function searchcomponentsAction(){
//        $msg="Componenti associate al malfunzionamento";
//
//        $id=$this->getParam('id');
//
//        $selected=$this->_tipoMalfunzionamento->getMalfunzionamenti($id)->toArray();
//
//        $ass=$this->_componenteMalfunzionamento->getComponenteProblemByMalf($id)->toArray();
//
//        for($i=0; $i<count($ass); $i++){
//            $results[$i]=$this->_componenti->getComponente($ass[$i]['id_componente'])->toArray();
//            $vect[$i]=$results[$i][0];
//        }
//        $this->view->assign('results',$vect);
//        $this->view->assign('msg',$msg);
//        $this->view->assign('malf',$selected[0]['nome']);
//
//    }

    /**
     *
     */

//    private function getSearchForm()
//    {
//        $urlHelper = $this->_helper->getHelper('url');
//        // $this->_form = new Application_Form_Public_Search();
//        $form = new Application_Form_Public_Search();
//        $form->setAction($urlHelper->url(array(
//            'controller' => 'malfunzionamenti',
//            'action' => 'search'),
//            'default'
//        ));
//        return $form;
//    }



//////////////////////////////////////////////////////////////STAFF/////////////

//    private function getEditFrom()
//    {
//        $urlHelper = $this->_helper->getHelper('url');
//        $this->_form = new Application_Form_Staff_Edit();
//        $this->_form->setAction($urlHelper->url(array(
//            'controller' => 'malfunzionamenti',
//            'action' => 'edit'),
//            'default'
//        ));
//        return $this->_form;
//    }
//
//    private function getCreateForm()
//    {
//        $urlHelper = $this->_helper->getHelper('url');
//        $this->_form = new Application_Form_Staff_Create();
////        $this->_form->setAction($urlHelper->url(array(
////            'controller' => 'malfunzionamenti',
////            'action' => 'create'),
////            'default'
////        ));
//        return $this->_form;
//    }

//    public function editAction(){
//
//    }
//
//
//    public function assmalfsoldAction(){
//        $malfunzionamentiList=$this->_tipoMalfunzionamento->getAll()->toArray();
//        $this->view->assign('list',$malfunzionamentiList);
//    }
//
//
//    public function associazioneAction(){
//        if($this->getRequest()->isXmlHttpRequest()) {
//            // Disattivazione layout
//            $this->_helper->viewRenderer->setNoRender();
//            $this->_helper->getHelper('layout')->disableLayout();
//            $request = $this->getRequest()->getPost();
//            $id = $request['id'];
//
//            $soluzioniList=$this->_soluzioni->getAll()->toArray();
//
//            $soluzioniChecked=$this->_malfSol->getSoluzioneByMalfunzionamento($id)->toArray();
//
//            $idAssegnati = array();
//            foreach($soluzioniChecked as $sol) {
//                $idAssegnati[] = $sol['id_soluzione'];
//            }
//
//            $data = array();
//            foreach($soluzioniList as $sol) {
//                // if the id of the solution is found in the array of the solutions ids assigned
//                // to the problem, then the status is set to true, otherwise to false
//                $status = (array_search($sol['id_soluzione'], $idAssegnati) !== FALSE);
//                $data[] = array(
//                    'status' => $status,
//                    'soluzione' => $sol
//                );
//            }
//
//            $json = Zend_Json::encode($data);
//
//            echo ($json);
//
//        }
//    }
//
//
//
//    public function ajaxaddsoluzionetomalfAction(){
//        if($this->getRequest()->isXmlHttpRequest()) {
//            // Disattivazione layout
//            $this->_helper->viewRenderer->setNoRender();
//            $this->_helper->getHelper('layout')->disableLayout();
//            //Prelevo i dati dalla post appena inviata
//            $request = $this->getRequest()->getPost();
//            //Effettuo l'inserimento
//            $add=$this->_malfSol->assMalfSoluzione($request["idMalfunzionamento"],$request["idSoluzione"]);
//            $response=Zend_Json::encode($add);
//            echo $response;
//
//        }
//    }
//
//    public function ajaxremovesoluzionetomalfAction(){
//        if($this->getRequest()->isXmlHttpRequest()) {
//            // Disattivazione layout
//            $this->_helper->viewRenderer->setNoRender();
//            $this->_helper->getHelper('layout')->disableLayout();
//            //Prelevo i dati dalla post appena inviata
//            $request = $this->getRequest()->getPost();
//            //Effettuo l'inserimento
//            $del=$this->_malfSol->deleteAss($request["idMalfunzionamento"],$request["idSoluzione"]);
//            $response=Zend_Json::encode($del);
//            echo $response;
//        }
//    }
//
//
//    /**
//     * Ricerca la descrizione della soluzione selezionata dall'operatore del livello 2.
//     * Al mouseenter viene prelevato l'id e viene eseguita la richiesta ajax
//     */
//
//    public function descrizionesoluzioneAction(){
//        if($this->getRequest()->isXmlHttpRequest()) {
//            $this->_helper->viewRenderer->setNoRender();
//            $this->_helper->getHelper('layout')->disableLayout();
//
//            if ($this->getRequest()->isPost()) {
//                $request = $this->getRequest()->getPost();
//                $idSoluzione = $request['idSoluzione'];
//
//                $soluzione=$this->_soluzioni->getSoluzioni($idSoluzione);
//
//                $response=Zend_Json::encode($soluzione);
//                echo $response;
//            }
//        }
//    }
}


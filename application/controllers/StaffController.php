<?php

class StaffController extends App_Controller_Staff
{



    public function init()
    {
        parent::init();

//        $this->view->search = $this->getSearchForm();
//        $this->view->edit = $this->getEditFrom();
//        $this->view->create = $this->getCreateForm();

    }

    public function indexAction()
    {

    }

//    /**
//     * funzionalità già presenti nel livello tecnico. Recupera tutti i prodotti dal db
//     */
//
//    public function productlistAction(){
//        $msg="prodotti";
//        $empty= "Non ci sono prodotti nel sistema";
//        $item=$this->_prodottoModel->getAllProdotti()->toArray();
//        if(count($item)>0){
//            $this->view->assign('prodotti',$item);
//        }else{
//            $this->view->assign('empty',$empty);
//        }
//        $this->view->assign('msg',$msg);
//    }

//    /**
//     * Accede alla scheda del prodotto dettagliata
//     */
//
//    public function itemdetailAction(){
//        $msg="Dettaglio prodotto selezionato";
//        $id=$this->getParam('id');
//
//        $item=$this->_prodottoModel->getProdotto($id);
//
//        if(count($item)==0){
//            $this->_helper->redirector('error');
//        }else{
//            $item=$item->toArray();
//            $this->view->assign('item',$item);
//        }
//
//        //Ricerca associazione componente malfunzionamento
//        $ass=$this->_prodottoMalfunzionamento->getProdottoProblemById($id)->toArray();
//        if(count($ass)>0){
//            for($i=0; $i<count($ass); $i++){
//                $malfComponente=$this->_tipoMalfunzionamento->getMalfunzionamenti($ass[$i]['id_malfunzionamento'])->toArray();
//            }
//
//            if(count($malfComponente)>0){
//                $this->view->assign('malf_prod',$malfComponente);
//            }
//        }
//
//        //Query prodottoComponente
//        //Prelevo dal db tutte le componenti relative a quel prodotto
//        $prodComp= $this->_prodottoComponente->getComponenteByProdotto($id);
//
//        if(count($prodComp)==0){
//            $this->view->assign('msg',"Non sono presenti componenti per questo prodotto");
//        }else{
//            $prodComp->toArray();
//            $componenti=array();
//            $vect=array();
//            for($i=0; $i<count($prodComp); $i++){
//                $componenti[$i]=$this->_componenti->getComponente($prodComp[$i]['id_componente'])->toArray();
//                $vect[$i]=$componenti[$i][0];
//            }
//            $this->view->assign('componenti', $vect);
//        }
//
//        //Assegno il messaggio alla view
//        $this->view->assign('msg',$msg);
//    }


//    /**
//     * Recupera i dettagli di un componente
//     */
//
//    public function componentdetailAction(){
//        $msg="Dettaglio componente";
//        $idItem=$this->getParam('id');
//
//
//        $componenti=$this->_componenti->getComponente($idItem);//->toArray();
//
//        if(count($componenti)==0){
//            $this->_helper->redirector('errorchangeurl','staff');
//        }else{
//            $componenti=$componenti->toArray();
//        }
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


    public function malfunzionamentoAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $request = $this->getRequest()->getPost();
        $idItem = $request['id'];

        //Insieme ID malfunzionamenti associati al componente
        $malf=$this->_componenteMalfunzionamento->getComponenteProblemById($idItem)->toArray();
        for($i=0; $i<count($malf); $i++){
            $malfunzionamenti[$i]=$this->_tipoMalfunzionamento->getMalfunzionamenti($malf[$i]['id_malfunzionamento'])->toArray();
            $vect[$i]=$malfunzionamenti[$i][0];
        }

        $json = Zend_Json::encode($vect);

        echo ($json);
    }

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

//    /**
//     *  lista di tutti i malfunzionamenti
//     */
//    public function malfunzionamentilistAction(){
//        $msg="Malfunzionamenti";
//        $allItems=$this->_tipoMalfunzionamento->getAll()->toArray();
//        $this->view->assign('malf',$allItems);
//        $this->view->assign('msg',$msg);
//    }

    /**
     * questa non ci vuole perchè cerchiamo i prodotti, non i componenti
     */

    public function searchcomponentsAction(){
        $msg="Componenti associate al malfunzionamento";
        $vect = array();
        $id=$this->getParam('id');

        $selected=$this->_tipoMalfunzionamento->getMalfunzionamenti($id)->toArray();
        if(count($selected)== 0){
            $this->view->assign('empty','Non ci sono componenti associate al malfunzionamento');
        } else {
            $ass=$this->_componenteMalfunzionamento->getComponenteProblemByMalf($id)->toArray();
            if(count($ass) > 0){
                for($i=0; $i<count($ass); $i++){
                    $results[$i]=$this->_componenti->getComponente($ass[$i]['id_componente'])->toArray();
                    $vect[$i]=$results[$i][0];
                }
                $this->view->assign('results',$vect);

            }
        }
        $this->view->assign('msg',$msg);
        $this->view->assign('malf',$selected[0]['nome']);

    }



    /**
     * fine funzionalità del livello tecnico.
     */



    public function editAction(){

    }


    /**
     * Renderizza tutti i malfunzionamenti presenti nel db
     */
    public function assmalfsoldAction(){
        $malfunzionamentiList=$this->_tipoMalfunzionamento->getAll()->toArray();
        $this->view->assign('list',$malfunzionamentiList);
    }


    public function associazioneAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            // Disattivazione layout
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();
            $request = $this->getRequest()->getPost();
            $id = $request['id'];

            $soluzioniList=$this->_soluzioni->getAll()->toArray();

            $soluzioniChecked=$this->_malfSol->getSoluzioneByMalfunzionamento($id)->toArray();

            $idAssegnati = array();
            foreach($soluzioniChecked as $sol) {
                $idAssegnati[] = $sol['id_soluzione'];
            }

            $data = array();
            foreach($soluzioniList as $sol) {
                // if the id of the solution is found in the array of the solutions ids assigned
                // to the problem, then the status is set to true, otherwise to false
                $status = (array_search($sol['id_soluzione'], $idAssegnati) !== FALSE);
                $data[] = array(
                    'status' => $status,
                    'soluzione' => $sol
                );
            }

            $json = Zend_Json::encode($data);

            echo ($json);

        }
    }



    public function ajaxaddsoluzionetomalfAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            // Disattivazione layout
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();
            //Prelevo i dati dalla post appena inviata
            $request = $this->getRequest()->getPost();
            //Effettuo l'inserimento
            $add=$this->_malfSol->assMalfSoluzione($request["idMalfunzionamento"],$request["idSoluzione"]);
            $response=Zend_Json::encode($add);
            echo $response;

        }
    }

    public function ajaxremovesoluzionetomalfAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            // Disattivazione layout
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();
            //Prelevo i dati dalla post appena inviata
            $request = $this->getRequest()->getPost();
            //Effettuo l'inserimento
            $del=$this->_malfSol->deleteAss($request["idMalfunzionamento"],$request["idSoluzione"]);
            $response=Zend_Json::encode($del);
            echo $response;
        }
    }


    /**
     * Ricerca la descrizione della soluzione selezionata dall'operatore del livello 2.
     * Al mouseenter viene prelevato l'id e viene eseguita la richiesta ajax
     */

    public function descrizionesoluzioneAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            if ($this->getRequest()->isPost()) {
                $request = $this->getRequest()->getPost();
                $idSoluzione = $request['idSoluzione'];

                $soluzione=$this->_soluzioni->getSoluzioni($idSoluzione);

                $response=Zend_Json::encode($soluzione);
                echo $response;
            }
        }
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function deletemalfunzionamentoAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $request = $this->getRequest()->getPost();
        $id = $request['id'];

        $assMalfProd=$this->_assMalfunzionamentoProdotto->getProdottoByMalfunzionamento($id)->toArray();
        $assMalfComp=$this->_assMalfunzionamentoComponente->getComponenteProblemByMalf($id)->toArray();
        if(count($assMalfProd)==0 && count($assMalfComp)==0){

            //Se entrambe le query restituiscono 0, nessun prodotto/componente prensenta questo malfunzionamento
            //si puo procedere alla eliminazione dell'associazione malfunzionamento-soluzione e infine si elimina
            //il malfunzionamento

            $this->_malfunzionamento->deleteMalfunzionamento($id);
            $flag=1;

        }else{
            $flag=0;
        }

        $json = Zend_Json::encode($flag);
        echo ($json);
    }


//    public function searchAction(){
//        //Se vera -> malfunzionamenti altrimenti descrizione
//
//
//        if (!$this->getRequest()->isPost()) {
//            $this->_helper->redirector('pippo2');
//        }
//
//        $form=$this->_form;
//        if(!$form->isValid($this->getRequest()->getPost())){
//            $this->_helper->redirector('productlist');
//        }
//
//        $values=$form->getValues();
//        $desc=$values['desc_prod'];
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
////            var_dump($results); die();
//            $this->view->assign('word',$desc);
//            $flag=false;
//            $msg="Risultato ricerca prodotto";
//        }
//
////        var_dump($results); die();
//        $this->view->assign('results',$results);
//        $this->view->assign('msg',$msg);
//        $this->view->assign('flag',$flag);
//
//    }


    public function insertAction(){

    }

    public function createAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $request = $this->getRequest()->getPost();

        $malfunzionamento=array('nome'=>$request['data'][0],'descrizione'=>$request['data'][1]);
        $soluzione=array('nome'=>$request['data'][2],'descrizione'=>$request['data'][3]);
        $idMalfunzionamento=$this->_malfunzionamento->insertMalfunzionamento($malfunzionamento);
        $idSoluzione=$this->_soluzione->insertSoluzione($soluzione);
        $this->_malfSol->assMalfSoluzione($idMalfunzionamento,$idSoluzione);
        //AZIONE CONTROLLER PER REDIRECT
//        $this->_helper->redirector('malfunzionamentilist','malfunzionamenti');
        $assoc=array("id"=>$idMalfunzionamento,"info"=>$malfunzionamento);
        $json = Zend_Json::encode($assoc);
//        echo ($json);
        echo json_encode($json);
    }


    public function solutionlistAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $idMalfunzionamento = $this->getRequest()->getPost();
        $malfunzionamento=$this->_malfunzionamento->getMalfunzionamenti($idMalfunzionamento)->toArray();
        $soluzioniList=$this->_soluzione->getAll()->toArray();

        $assoc=array("malfunzionamento"=>$malfunzionamento, "soluzioni"=>$soluzioniList);

        $json = Zend_Json::encode($assoc);
        echo json_encode($json);
    }

//    private function getSearchForm()
//    {
//        $urlHelper = $this->_helper->getHelper('url');
//        $this->_form = new Application_Form_Public_Search();
//        $this->_form->setAction($urlHelper->url(array(
//            'controller' => 'staff',
//            'action' => 'search'),
//            'default'
//        ));
//        return $this->_form;
//    }

    private function getEditFrom()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Staff_Edit();
        $this->_form->setAction($urlHelper->url(array(
            'controller' => 'staff',
            'action' => 'edit'),
            'default'
        ));
        return $this->_form;
    }

    private function getCreateForm()
    {
        $urlHelper = $this->_helper->getHelper('url');
        $this->_form = new Application_Form_Staff_Create();
//        $this->_form->setAction($urlHelper->url(array(
//            'controller' => 'malfunzionamenti',
//            'action' => 'create'),
//            'default'
//        ));
        return $this->_form;
    }


    public function errorAction(){
        $error="Non ci sono elementi per l'id selezionato";
        $this->view->assign('error',$error);
        $this->render('error');
    }

    public function errorchangeurlAction(){
        $error="Non ci sono elementi per l'id selezionato";
        $this->view->assign('error',$error);
        $this->render('errorchangeurl');
    }
}

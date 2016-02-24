<?php

class TecnicoController extends App_Controller_Tecnico {



    public function init()
    {
        parent::init();
        //$this->_helper->layout->setLayout('utente');
        //$this->view->search = $this->getSearchForm();
        //$this->view->edit = $this->getEditFrom();
        //$this->view->create = $this->getCreateForm();
        //$this->searchForm = $this->getSearchForm();
    }

    public function indexAction()
    {

    }


    /**
     * recupera tutti i prodotti dal db
     */
    public function productlistAction(){
        $msg="prodotti";
        $empty= "Non ci sono prodotti nel sistema";
        $item=$this->_prodottoModel->getAllProdotti()->toArray();
        if(count($item)>0){
            $this->view->assign('prodotti',$item);
        }else if(count($item)==0){
            $this->view->assign('empty',$empty);
        }
        $this->view->assign('msg',$msg);
    }

    /**
     * Accede alla scheda del prodotto dettagliata
     */

    public function itemdetailAction(){
        $msg="Dettaglio prodotto selezionato";
        $id=$this->getParam('id');


        if($this->_prodottoModel->getProdotto($id)==null) {
            $this->_helper->redirector('errorchangeidurl');
        }else{
            $item=$this->_prodottoModel->getProdotto($id)->toArray();
        }

        //Ricerca associazione componente malfunzionamento
        $ass=$this->_prodottoMalfunzionamento->getProdottoProblemById($id)->toArray();

       if(count($ass)>0){
           for($i=0; $i<count($ass); $i++){
               $malfComponente=$this->_tipoMalfunzionamento->getMalfunzionamenti($ass[$i]['id_malfunzionamento'])->toArray();
           }
           $this->view->assign('malf_prod',$malfComponente);
       }

        $prodComp= $this->_prodottoComponente->getComponenteByProdotto($id)->toArray();
        if($prodComp==null){
            $this->view->assign('msg',"Non sono presenti componenti per questo prodotto");
        }else{
            $componenti=array();
            $vect=array();
            for($i=0; $i<count($prodComp); $i++){
                $componenti[$i]=$this->_componenti->getComponente($prodComp[$i]['id_componente'])->toArray();
                $vect[$i]=$componenti[$i][0];
            }
            $this->view->assign('componenti', $vect);
        }
        $this->view->assign('item',$item);


        $this->view->assign('msg',$msg);
    }

    /**
     * Recupera i dettagli di un componente
     */

    public function componentdetailAction(){

        $msg="Dettaglio componente";
        $idItem=$this->getParam('id');

        if(count($this->_componenti->getComponente($idItem)->toArray())==0){
            $this->_helper->redirector('errorchangeidurl');
        }else{
            $componenti=$this->_componenti->getComponente($idItem)->toArray();
        }
        //Ricerco associazione componente - malfunzionamento
        $malf=$this->_componenteMalfunzionamento->getComponenteProblemById($idItem)->toArray();

        if(count($malf)==0){
            $this->view->assign('msg',"Non sono presenti malfunzionamenti per questo componente");
        }else{
            for($i=0; $i<count($malf); $i++){
                $malfunzionamenti[$i]=$this->_tipoMalfunzionamento->getMalfunzionamenti($malf[$i]['id_malfunzionamento'])->toArray();
                $vect[$i]=$malfunzionamenti[$i][0];
            }
            $this->view->assign('malfunzionamenti', $vect);
        }
        $this->view->assign('componente', $componenti);
        $this->view->assign('msg',$msg);

    }

    /**
     * questa funzione non si sa se serve qui
     */

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

    /**
     *
     */

    public function findsolutionAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();
            $id = $request['id'];

            //Malfunzionamento associato all'id:

            $descrizioneMalfunzionamento=$this->_tipoMalfunzionamento->getMalfunzionamenti($id)->toArray();

            $item=$this->_malfSol->getMalfunzionamentoSoluzione($id)->toArray();
            if(count($item)>0) {
                for ($i = 0; $i < count($item); $i++) {
                    $soluzioni[$i] = $this->_soluzioni->getSoluzioni($item[$i]['id_malfunzionamento'])->toArray();
                    $vect[$i]=$soluzioni[$i][0];

                }
            }

            $associazione=array("malfunzionamento" =>$descrizioneMalfunzionamento, "soluzione"=>$vect);
            $json = Zend_Json::encode($associazione);
            echo ($json);
        }else{
            return false;
        }

    }

    /**
     *  lista di tutti i malfunzionamenti
     */
    public function malfunzionamentilistAction(){
        $msg="Malfunzionamenti";
        $allItems=$this->_tipoMalfunzionamento->getAll()->toArray();
        $this->view->assign('malf',$allItems);
        $this->view->assign('msg',$msg);
    }

    /**
     * funzione di ricerca
     */

    public function searchAction(){

        //Se vera -> malfunzionamenti altrimenti descrizione
        if (!$this->getRequest()->isPost()) {
            $this->_helper->redirector('error');
        }

        if(!$this->search->isValid($this->getRequest()->getPost())){
            $this->_helper->redirector('error2');
        }

        $values=$this->search->getValues();

        if($values['desc_prod']=="" && $values['descrizione']==""){
            $this->_helper->redirector('error');
        }
        $desc=$values['desc_prod'];
        $malf=$values['descrizione'];

        if($desc==null){
            if($malf!=null){
                //TODO ricerca prodotto tramite malfunzionamenti
                $results=$this->_search->cercaMalf($malf)->toArray();
                if(count($results)>0){
                    $this->view->assign('word',$malf);
                    $flag=true;
                    $msg="Risultato ricerca malfunzionamenti";
                    $this->view->assign('msg',$msg);
                    $this->view->assign('results',$results);
                    $this->view->assign('flag',$flag);
                    $this->render('search');
                }else{
                    $msg="Non ci sono malfunzionamenti che contengono la parola cercata:<br /><br />".$malf;
                    $flag=true;
                    $this->view->assign('empty',$msg);
                    $this->render('search');
                }

            }
        }else{
            //TODO ricerca prodotto tramite descrizione (WILDCARD)
            unset($malf);
            if($this->checksearch($desc)){
                $desc_replace = str_replace("*",".*",$desc);
                $results=$this->_search->cercaDesc($desc_replace)->toArray();

                if(count($results)==0){
                    $msg="Non ci sono prodotti che contengono la parola ".$desc." cercata";
                    $flag=true;
                    $this->view->assign('empty',$msg);
                    $this->view->assign('flag',$flag);
                    $this->render('search');

                }elseif(count($results)>0){

                    $this->view->assign('word',$desc);
                    $flag=false;
                    $msg="Risultato ricerca prodotto";
                    $this->view->assign('flag',$flag);
                    $this->view->assign('results',$results);
                }

            }else{

                $msg="L'uso del carattere * è ammesso solo come ultimo carattere del pattern di ricerca:<br /><br />".$desc;
                $flag=true;
                $this->view->assign('empty',$msg);
                $this->view->assign('flag',$flag);
                $this->render('search');
            }

        }



            $this->view->assign('msg',$msg);
            $this->view->assign('flag',$flag);

    }


    /**
     * Controllo ricerca
     */

    private function checksearch($string){

        $flag=false;

        $word_len=strlen($string);
        $s=strpos($string,"*");

        if($string[0]=="*"){
            $flag=false;
        }elseif($s>0 && $s<$word_len-1){
            $flag=false;
        }else{
            $flag=true;
        }

        return $flag;
    }



    /**
     *
     */
//    public function searchcomponentsAction(){
//        $msg="Componenti associate al malfunzionamento";
//        $vect = array();
//        $id=$this->getParam('id');
//
//        $selected=$this->_tipoMalfunzionamento->getMalfunzionamenti($id)->toArray();
//        if(count($selected)== 0){
//            $this->view->assign('empty','Non ci sono componenti associate al malfunzionamento');
//        } else {
//            $ass=$this->_componenteMalfunzionamento->getComponenteProblemByMalf($id)->toArray();
//            if(count($ass) > 0){
//                for($i=0; $i<count($ass); $i++){
//                    $results[$i]=$this->_componenti->getComponente($ass[$i]['id_componente'])->toArray();
//                    $vect[$i]=$results[$i][0];
//                }
//                $this->view->assign('results',$vect);
//
//            }
//        }
//        $this->view->assign('msg',$msg);
//        $this->view->assign('malf',$selected[0]['nome']);
//
//    }

    /*
     *
     */

//    private function getSearchForm()
//    {
//        $urlHelper = $this->_helper->getHelper('url');
//        // $this->_form = new Application_Form_Public_Search();
//        $form = new Application_Form_Public_Search();
//        $form->setAction($urlHelper->url(array(
//            'controller' => 'tecnico',
//            'action' => 'search'),
//            'default'
//        ));
//        return $form;
//    }

    public function searchproductbymalfAction(){
        $msg="Prodotti associate al malfunzionamento";
        $vect = array();
        $id=$this->getParam('id');

        $selected=$this->_tipoMalfunzionamento->getMalfunzionamenti($id)->toArray();


        //if(count($selected)== 0){

//        }// else {
            $ass=$this->_prodottoMalfunzionamento->getProdottoByMalfunzionamento($id)->toArray();
            if(count($ass) > 0){
                for($i=0; $i<count($ass); $i++){
                    $results[$i]=$this->_prodottoModel->getProdotto($ass[$i]['id_prodotto'])->toArray();
//                    $vect[$i]=$results[$i][0];
                }
                $this->view->assign('results',$results);

           // }
        }else{
                $this->view->assign('empty','Non ci sono componenti associate al malfunzionamento');
                $this->view->assign('malf',$selected[0]['nome']);
                $this->render('searchproductbymalf');

            }
        $this->view->assign('msg',$msg);
        $this->view->assign('malf',$selected[0]['nome']);
    }


    /**
     * EDIT PROFILE
     */
//
//
//    public function editprofileAction(){
//
//        $urlHelper = $this->_helper->getHelper('url');
//        $formedit = new Application_Form_Admin_Profilo();
//        $formedit->setAction($urlHelper->url(array(
//            'controller' => 'tecnico',
//            'action' => 'editprofile'
//        )));
//        $this->view->assign('editprofile',$formedit);
//
//        if($this->getRequest()->isPost()){
//
//        }
////        $this->render('editprofile');
//    }


    //ERROR SEARCH
    public function errorAction(){
        $this->view->assign('error',"I campi di ricerca non possono essere vuoti.<br /><br />Effettuare nuovamente la ricerca");
        $this->render('error');
    }

    public function errorchangeidurlAction(){
        $this->view->assign('error',"L'elemento cercato non esiste");
        $this->render('errorchangeidurl');
    }


}
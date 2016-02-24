<?php

//Il controller del catalogo estende il base controller di tecnico
class CatalogoController extends App_Controller_Tecnico{

    public function init()
    {
        //si riferisce all'init() della classe padre
        parent::init();
    }

    public function indexAction(){

    }

    /**
     * Recupera tutti i prodotti prensenti del database
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
     *Recupera i dettagli di un prodotto
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
        $vect=array();
        if(count($ass)>0){
            for($i=0; $i<count($ass); $i++){
                $malfComponente[]=$this->_tipoMalfunzionamento->getMalfunzionamenti($ass[$i]['id_malfunzionamento'])->toArray();
                $vect[$i]=$malfComponente[$i][0];
            }
            $this->view->assign('malf_prod',$vect);
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
     * Recupera i dettagli di una componente associata ad un prodotto
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
     *  Restituisce la lista di tutti i malfunzionamenti
     */
    public function malfunzionamentilistAction(){
        $msg="Malfunzionamenti";

        //TODO Controllo oggetti restituiti
        $allItems=$this->_tipoMalfunzionamento->getAll()->toArray();
        if(count($allItems)>0){
            $this->view->assign('malf',$allItems);
        }else{
            $this->view->assign('empty',"Non sono presenti malfunzionamenti nel database");
        }
        $this->view->assign('msg',$msg);
    }


    /**
     * Metodo che permette di effettuare la ricerca di un prodotto o di un malfunzionamento.
     * E' accettato il carattere WILDCARD * su "descrizione prodotto" cosi: patt*, patte*
     * Il malfunzionamento viene ricercato per parola esatta nel campo "descrizione malfunzionamento"
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
        }else if($values['desc_prod']!="" && $values['descrizione']!=""){
            $this->_helper->redirector('bothfield');
        }
        $desc=$values['desc_prod'];
        $malf=$values['descrizione'];

        $re = "/[-+!$%^&()_+|\"£\\/~=`{}\\\\:;'<>?#.,\\@\\[]/";

        if($desc==null){
            if($malf!=null){
                //TODO ricerca prodotto tramite malfunzionamenti con regex
                $matches = array();
                if(preg_match_all($re, $malf, $matches) > 0){
                    $msg = "Non sono accettati caratteri speciali al di fuori del simbolo asterisco(*)";
                    $this->view->assign('empty',$msg);
                    $this->render('search');
                    return;
                }
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
            //TODO ricerca prodotto tramite descrizione (WILDCARD) con regex
            unset($malf);
            if($this->checksearch($desc)){
                $matches = array();
                if(preg_match_all($re, $desc, $matches) > 0){
                    $msg = "Non sono accettati caratteri speciali al di fuori del simbolo asterisco(*)";
                    $this->view->assign('empty',$msg);
                    $this->render('search');
                    return;
                }
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
     * A partire dal malfunzionamento, restituisce tutti i prodotti associati ad esso.
     */
    public function searchproductbymalfAction(){
        $msg="Prodotti associate al malfunzionamento";
        $vect = array();
        $id=$this->getParam('id');

        $selected=$this->_tipoMalfunzionamento->getMalfunzionamenti($id)->toArray();

        $ass=$this->_prodottoMalfunzionamento->getProdottoByMalfunzionamento($id)->toArray();
        if(count($ass) > 0){
            for($i=0; $i<count($ass); $i++){
                $results[$i]=$this->_prodottoModel->getProdotto($ass[$i]['id_prodotto'])->toArray();
//                    $vect[$i]=$results[$i][0];
            }
            $this->view->assign('results',$results);

        }else{
            $this->view->assign('empty','Non ci sono componenti associate al malfunzionamento');
            $this->view->assign('malf',$selected[0]['nome']);
            $this->render('searchproductbymalf');

        }
        $this->view->assign('msg',$msg);
        $this->view->assign('malf',$selected[0]['nome']);
    }


    /*
     * Metodi per chiamate AJAX
     * */

    /**
     * Recupera la soluzione associata ad un malfunzionamento
     *
     * @return bool ritorna false se non ci sono soluzioni associata ad un malfunzionamento, altrimenti
     * restituisce un JSON con i dati relativi alla soluzione
     */
    public function findsolutionAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();
            $id = $request['id'];

            //Malfunzionamento associato all'id:
            $descrizioneMalfunzionamento=$this->_tipoMalfunzionamento->getMalfunzionamenti($id)->toArray();

//            $item=$this->_malfSol->getMalfunzionamentoSoluzione($id)->toArray();
            $item=$this->_malfSol->getSoluzioneByMalfunzionamento($id)->toArray();

            $vect=array();
            if(count($item)>0) {
                for ($i = 0; $i < count($item); $i++) {
                    $soluzioni[$i] = $this->_soluzioni->getSoluzioni($item[$i]['id_soluzione'])->toArray();
                    $vect[$i]=$soluzioni[$i][0];
                }

            }
//            var_dump($vect); die();

//            $associazione=array("malfunzionamento" =>$descrizioneMalfunzionamento, "soluzione"=>$soluzioni);
            $associazione=array("malfunzionamento" =>$descrizioneMalfunzionamento, "soluzione"=>$vect);

            $json = Zend_Json::encode($associazione);
            echo ($json);
        }else{
            return false;
        }

    }

    public function descrizionemalfAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();
            $idMalf = $request['id'];

            $desc=$this->_tipoMalfunzionamento->getMalfunzionamento($idMalf)->toArray();
            $json = Zend_Json::encode($desc['descrizione']);
            echo($json);
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


    /*
     * Metodi privati per la verifica
     */

    /**
     * Controlla se il carattere * è nella posizione corretta.
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


    public function errorAction(){
        $this->view->assign('error',"Impossible effettuare la ricerca.<br />I campi non possono essere entrambi vuoti");
    }

    public function bothfieldAction(){
        $this->view->assign('error',"I campi non possono essere entrambi pieni.<br /> Scegliere tra ricerca prodotto o malfunzionamento");
    }

}
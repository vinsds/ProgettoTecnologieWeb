<?php
 
class PublicController extends App_Controller_Guest
{


    public function init() {
        parent::init();
        $login = new Application_Form_Public_Login();
        $this->view->login = $login;
    }
    
    public function indexAction(){

    }
    
    public function chisiamoAction(){

        $this->render('chisiamo');
    }
    
    public function serviziAction(){

        $this->render('servizi');
    }

    public function prodottiAction()
    {
        //Messaggio barra ricerca
        $msgRicerca="Ricerca prodotto";
        //Query per il recupero dei dati relativi ai prodotti e alle categorie;
        //Le categorie servono per popolare la barra di ricerca
        $item = $this->_prodottoModel->getAllProdotti()->toArray();
        //$categorieList=$this->_categorie->getCategorie()->toArray();
        $categorieList=$this->_categorie->notPeriferiche(2)->toArray();
        //Istanzio la form per la ricerca
        $form = new Application_Form_Public_Ricerca();

        //Effettuo i controlli per sui dati letti dal DB
        if(count($item)==0) {
            $msgProdotto = "Nessun prodotto presente nel catalogo";
        }else{
            $msgProdotto = "Catalogo prodotti";
        }

        if(count($categorieList)>0){
            $msgCategoria="Seleziona categoria";
        }else{
            $msgCategoria="Categorie non presenti";
        }

        //Messaggi per la view
        $this->view->assign('msgCategoria',$msgCategoria);
        $this->view->assign('msgProdotto',$msgProdotto);
        $this->view->assign('msgRicerca', $msgRicerca);

        //Array dati inviati alla view
        $this->view->assign('prodotti', $item);
        $this->view->assign('categorie', $categorieList);

        //Assegno la form alla view
        $this->view->searchForm = $form;

        //Rederizzo la pagina prodotti.phtml
        $this->render('prodotti');
    }

    /*Restituisce le sottocategorie associate ad una determinata categoria.
      Il metodo andrà a popolare il filtro per la selezione dei prodotti
    */

    public function trovasottocategorieAction(){

        if($this->getRequest()->isXmlHttpRequest()){

            //Disattivo il cambio di layout
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            //Controllo se la richiesta è di tipo POST
            if($this->getRequest()->isPost()){
                //Prelevo i valori dalla POST
                $request = $this->getRequest()->getPost();

                //Prelevo l'ID della categoria selezionata
                $idCategoria = $request['id_categoria'];

                //Effettuo la query per il recupero delle sottocategorie associate alla categoria selezionata
                $query=$this->_sottocategorie->getSottoCategorieById($idCategoria);

                //Genero il json da manipolare nella view
                $response=Zend_Json::encode($query);
                echo $response;
            }
        }
    }


    /**
     * Restituisce l'insieme dei prodotti appartenenti ad una determinata sottocategoria
     */
    public function filtraprodottibysottocategoriaAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            //Controllo se la richiesta è di tipo POST
            if ($this->getRequest()->isPost()) {
                //Prelevo i valori dalla POST
                $request = $this->getRequest()->getPost();

                //Prelevo l'ID della sottocategoria selezionata
                $idSubCat = $request['id_sottocategoria'];

                //Effettuo la query per gli elementi che appartengono a questa sottocategoria
                $query=$this->_prodottoModel->getProdottoBySottoCategoria($idSubCat);
                //Genero il json da manipolare nella view
                $response=Zend_Json::encode($query);
                echo $response;
            }
        }
    }

    /**
     * Restituisce tutti dati relativi al prodotto selezionato
     */

    public function getprodottobyidAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            //Controllo se la richiesta è di tipo POST
            if ($this->getRequest()->isPost()) {
                //Prelevo i valori dalla POST
                $request = $this->getRequest()->getPost();

                //Prelevo l'ID della sottocategoria selezionata
                $idProdotto = $request['id_prodotto'];

                //Effettuo la query per gli elementi che appartengono a questa sottocategoria
                $query=$this->_prodottoModel->getProdotto($idProdotto);
                //Genero il json da manipolare nella view
                $response=Zend_Json::encode($query);
                echo $response;
            }
        }
    }


    public function ricercaprodottobydescAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            //Controllo se la richiesta è di tipo POST
            if ($this->getRequest()->isPost()) {
                //Prelevo i valori dalla POST
                $request = $this->getRequest()->getPost();

                //Prelevo l'ID della sottocategoria selezionata
                $searchWord = $request['search'];

                $word_len=strlen($searchWord);

                /** espressione regolare per filtrare i caratteri speciali nella form di ricerca */
                $matches = array();
                $re = "/[-+!$%^&()_+|\"£\\/~=`{}\\\\:;'<>?#.,\\@\\[]/";

                $s=strpos($searchWord,"*");

                if(preg_match_all($re, $searchWord, $matches) > 0){
                    $response = Zend_Json::encode(3);
                }elseif($searchWord[0]=="*"){
                    $response=Zend_Json::encode(0);
                }elseif($s>0 && $s<$word_len-1){
                    $response=Zend_Json::encode(1);
                }else{
                    $searchWord_replace=str_replace("*", ".*", $searchWord);
                    //Effettuo la query per gli elementi che appartengono a questa sottocategoria
                    $query=$this->_cercaModel->cercaDesc($searchWord_replace);

                    if(count($query)==0){
                        $response=Zend_Json::encode(2);
                    }elseif(count($query)>0){
                        //Genero il json da manipolare nella view
                        $response=Zend_Json::encode($query);
                    }
                }

                echo $response;
            }
        }
    }

    public function faqAction(){

        $list = $this->_faqModel->getFaqList();
        $this->view->assign('list', $list);
    }

    public function loginAction(){
        $this->render('login');

    }

    public function centriAction(){
        $this->view->assign('msg',"Centri assistenza");
        $this->view->assign('subMsg',"Lista centri assistenza");
        $result=$this->_centri->getAllCentri()->toArray();
        if(count($result)>0) {
            $this->view->assign('centri', $result);
        }
    }

}
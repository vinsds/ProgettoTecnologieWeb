<?php

class MalfunzionamentoController extends App_Controller_Staff{

//    protected $_formCreate;
    protected $_formEdit;


    public function init()
    {
        parent::init();
//        $this->view->createForm = $this->getCreateForm();
//        $this->view->editForm = $this->getEditFrom();


    }

    public function indexAction(){

    }

    /**
     * DA RICONTROLLARE SE VIENE UTILIZZATO O MENO
     */

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


    /**
     * Renderizza tutti i malfunzionamenti presenti nel db
     */
    public function assmalfsolAction(){
        $malfunzionamentiList=$this->_tipoMalfunzionamento->getAll()->toArray();
        $this->view->assign('list',$malfunzionamentiList);
    }


    public function scegliAction(){

    }


    public function listaprodottiAction(){
        $msg="prodotti";
        $empty= "Non ci sono prodotti nel sistema";

        $item=$this->_prodottoModel->getAllProdotti()->toArray();


//        var_dump($item); die();
        if(count($item)>0){
            $this->view->assign('prodotti',$item);
        }else if(count($item)==0){
            $this->view->assign('empty',$empty);
        }

        $this->view->assign('msg',$msg);
    }

    public function listacomponentiAction(){
        $msg="componenti";
        $empty= "Non ci sono componenti nel sistema";

        $item=$this->_componenti->getAllComponenti()->toArray();

        if(count($item)>0){
            $this->view->assign('componenti',$item);
        }else if(count($item)==0){
            $this->view->assign('empty',$empty);
        }

        $this->view->assign('msg',$msg);
    }


//    public function editformAction(){
//        $id=$this->_getParam('id');
//        $malf=$this->_malfunzionamento->getMalfunzionamento($id)->toArray();
//        $this->_formEditM->setDefaults($malf);
//    }


//    public function editformsAction(){
//        $id=$this->_getParam('id');
//        $sol=$this->_soluzioni->getSoluzione($id)->toArray();
//        $this->editFormS->setDefaults($sol);
//        $this->view->assign('editFormS',$this->editFormS);
//    }

    public function editmAction(){

        $id=$this->_getParam('id');
        $malf=$this->_malfunzionamento->getMalfunzionamento($id)->toArray();
        $this->editFormM->setDefaults($malf);

        if (!$this->getRequest()->isPost()) {
            $this->view->assign('editFormM',$this->editFormM);
            return;
        }

        $post = $this->getRequest()->getPost();

        if (!$this->editFormM->isValid($post)) {
            $this->view->assign('error', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('editFormM', $this->editFormM);
            $this->render('editm');
            return;
        }

        $values = $this->editFormM->getValues();

        $validator = new Zend_Validate_Db_RecordExists(
            array(
                'table'=>'malfunzionamento',
                'field'=>'nome'
            )
        );

        if($validator->isValid($values['nome'])) {
            $this->view->assign('error', 'Impossibile completare la modifica.<br />Malfunzionamento con questo nome già presente.');
            $this->view->assign('editFormM', $this->editFormM);
            $this->render('editm');
            return;
        }

        if($values['nome'] =="" || $values['descrizione']=="")
        {
            $this->view->assign('error', 'I campi non possono essere vuoti');
            $this->view->assign('editFormM', $this->editFormM);
            $this->render('editm');
            return;
        }

        $this->_malfunzionamento->editMalfunzionamento($values,$values['id_malfunzionamento']);
        $this->view->assign('msg',"Modifica effettuata correttamente");
        $this->view->assign('editFormM', $this->editFormM);
        $this->render('editm');
        //$this->_helper->redirector('malfunzionamentilist','catalogo');
    }

    public function editsAction()
    {
        $id=$this->_getParam('id');
        $sol=$this->_soluzioni->getSoluzione($id)->toArray();
        $this->editFormS->setDefaults($sol);

        if (!$this->getRequest()->isPost())
        {
            $this->view->assign('editFormS',$this->editFormS);
            return;
        }

        $post = $this->getRequest()->getPost();

        if (!$this->editFormS->isValid($post)) {
            $this->view->assign('error', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('editFormS', $this->editFormS);
            $this->render('edits');
            return;
        }

        $values = $this->editFormS->getValues();

        $validator = new Zend_Validate_Db_RecordExists(
            array(
                'table'=>'soluzione',
                'field'=>'nome'
            )
        );

        if($validator->isValid($values['nome'])) {
            $this->view->assign('error', 'Impossibile completare la modifica.<br />Soluzione con questo nome già presente.');
            $this->view->assign('editFormS', $this->editFormS);
            $this->render('edits');
            return;
        }

        if($values['nome'] =="" || $values['descrizione']=="")
        {
            $this->view->assign('error', 'I campi non possono essere vuoti');
            $this->view->assign('editFormS', $this->editFormS);
            $this->render('edits');
            return;
        }

        $this->_soluzioni->editSoluzione($values,$values['id_soluzione']);
        $this->view->assign('msg',"Modifica effettuata correttamente");
        $this->view->assign('editFormS', $this->editFormS);
        $this->render('edits');
        //$this->_helper->redirector('solutionlist');
    }

    /***
     *  Metodi richiamati per le funzioni AJAX
     *
     *  associazioneAction();
     *  ajaxaddsoluzionetomalfAction();
     *  ajaxremovesoluzionetomalfAction();
     *  descrizionesoluzioneAction();
     *  deletemalfunzionamentoAction();
     *  createAction();
     *  solutionlistAction();
     *
     */

    /***
     * Restituisce tutte le soluzioni associate al malfunzionamento selezionato
     */
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


    /**
     * Associa una nuova soluzione ad un malfunzionamento presente nel sistema
     */
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

    /**
     * Rimuove l'assegnazione di una nuova soluzione ad un malfunzionamento presente nel sistema
     */
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
     * Rimuove dal sistema il malfunzionamento selezionato.
     * Se il malfunzionamento è assegnato ad un prodotto, non viene cancellato. In caso contrario
     * si passa alla eliminazione.
     */

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


    /**
     * Rimuove dal sistema la soluzione selezionata.
     * Se il malfunzionamento è assegnato ad un prodotto, non viene cancellato. In caso contrario
     * si passa alla eliminazione.
     */

    public function deletesoluzioneAction(){
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->getHelper('layout')->disableLayout();

        $request = $this->getRequest()->getPost();
        $id = $request['id'];

        $assSolMalf=$this->_assMalfunzionamentoSoluzione->getMalfunzionamentoSoluzione($id)->toArray();

        if(count($assSolMalf)==0){

            //Se entrambe le query restituiscono 0, nessun prodotto/componente prensenta questo malfunzionamento
            //si puo procedere alla eliminazione dell'associazione malfunzionamento-soluzione e infine si elimina
            //il malfunzionamento

            $this->_soluzioni->deleteSoluzione($id);
            $flag=1;

        }else{
            $flag=0;
        }

        $json = Zend_Json::encode($flag);
        echo ($json);
    }
    /***
     * Inserisce un malfunzionamento e lo associa ad una soluzione
     */
    public function createmAction()
    {


        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();


            $request = $this->getRequest()->getPost();

            $malfunzionamento = array(
                /**
                 * Preparo il vettore con i dati da inviare la model
                 */

                'nome' => $request['data'][0],
                'descrizione' => $request['data'][1]
            );

            $validator = new Zend_Validate_Db_RecordExists(
                array(
                    'table'=>'malfunzionamento',
                    'field'=>'nome'
                )
            );

            if($validator->isValid($request['data'][0])) {
                $resp="duplicate";
                $json = Zend_Json::encode($resp);
                echo($json);
                return;
            }

            if($request['data'][0]=="" || $request['data'][1]==""){
                $resp="error";
                $json = Zend_Json::encode($resp);
                echo($json);
                return;
            }else{
                $insert = $this->_malfunzionamento->insertMalfunzionamento($malfunzionamento);
                $json = Zend_Json::encode($insert);
                echo($json);
            }

        }
    }

    public function createsAction(){

        if ($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();

            $soluzione = array(
                /**
                 * Preparo il vettore con i dati da inviare alla model
                 */

                'nome' => $request['data'][0],
                'descrizione' => $request['data'][1]
            );

            $validator = new Zend_Validate_Db_RecordExists(
                array(
                    'table'=>'soluzione',
                    'field'=>'nome'
                )
            );

            if($validator->isValid($request['data'][0])) {
                $resp="duplicate";
                $json = Zend_Json::encode($resp);
                echo($json);
                return;
            }


            if($request['data'][0]=="" || $request['data'][1]==""){
                $resp="error";
                $json = Zend_Json::encode($resp);
                echo($json);
                return;
            }else{
                $insert = $this->_soluzioni->insertSoluzione($soluzione);
                $json = Zend_Json::encode($insert);
                echo($json);
            }
        }
    }


    /***
     * Dopo la creazione di un malfunzionamento, viene richiesto se si vuole associare ad un malfunzionamento
     * una soluzione.
     */
    public function solutionlistAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $idMalfunzionamento = $this->getRequest()->getPost();
            $malfunzionamento=$this->_malfunzionamento->getMalfunzionamenti($idMalfunzionamento)->toArray();
            $soluzioniList=$this->_soluzione->getAll()->toArray();

            $assoc=array("malfunzionamento"=>$malfunzionamento, "soluzioni"=>$soluzioniList);

            $json = Zend_Json::encode($assoc);
            echo json_encode($json);
        }else{
            $soluzioniList=$this->_soluzione->getAll()->toArray();
            if(count($soluzioniList)>0){
                $this->view->assign('solutions',$soluzioniList);
            }else{
                $this->view->assign('empty',"Non sono presenti soluzioni nel database");
            }
            $this->view->assign('msg',"Soluzioni");
        }

    }


    public function assprodmalfAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $idProdotto = $this->getRequest()->getPost();

            $malfunzionamentiList=$this->_malfunzionamento->getAll()->toArray();
            $assMalfProd=$this->_assMalfunzionamentoProdotto->getProdottoProblemById($idProdotto)->toArray();

            $idAssegnati = array();
                foreach($assMalfProd as $mal) {
                $idAssegnati[] = $mal['id_malfunzionamento'];
            }

            $data = array();
            foreach($malfunzionamentiList as $mal) {
                // if the id of the solution is found in the array of the solutions ids assigned
                // to the problem, then the status is set to true, otherwise to false
                $status = (array_search($mal['id_malfunzionamento'], $idAssegnati) !== FALSE);
                $data[] = array(
                    'status' => $status,
                    'malfunzionamento' => $mal
                );
            }
            $json = Zend_Json::encode($data);
            echo json_encode($json);

        }
    }

    public function asscompmalfAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $idComp = $this->getRequest()->getPost();

            $malfunzionamentiList=$this->_malfunzionamento->getAll()->toArray();
            $assMalfComp=$this->_assMalfunzionamentoComponente->getComponenteProblemById($idComp)->toArray();

            $idAssegnati = array();
            foreach($assMalfComp as $mal) {
                $idAssegnati[] = $mal['id_malfunzionamento'];
            }

            $data = array();
            foreach($malfunzionamentiList as $mal) {
                // if the id of the solution is found in the array of the solutions ids assigned
                // to the problem, then the status is set to true, otherwise to false
                $status = (array_search($mal['id_malfunzionamento'], $idAssegnati) !== FALSE);
                $data[] = array(
                    'status' => $status,
                    'malfunzionamento' => $mal
                );
            }
            $json = Zend_Json::encode($data);
            echo json_encode($json);

        }
    }

    /**
     * Permette l'associazione di un malfunzionamento ad un prodotto.
     * L'assegnazione viene fatta dopo aver richiesto una chiamata ajax
     */
    public function ajaxaddmalfunzionamentoprodottoAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $data = $this->getRequest()->getPost();

            $add=$this->_prodottoMalfunzionamento->assProdottoMalf($data['idProdotto'],$data['idMalfunzionamento']);
            $json = Zend_Json::encode($add);
            echo json_encode($json);

        }
    }

    /**
     * Permette di elimnare l'associazione di un malfunzionamento ad un prodotto.
     * L'assegnazione viene fatta dopo aver richiesto una chiamata ajax
     */
    public function ajaxremovemalfunzionamentoprodottoAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $data = $this->getRequest()->getPost();

            $add=$this->_prodottoMalfunzionamento->deleteAss($data['idProdotto'],$data['idMalfunzionamento']);
            $json = Zend_Json::encode($add);
            echo json_encode($json);

        }
    }



    /**
     * Permette l'associazione di un malfunzionamento ad una componente.
     * L'assegnazione viene fatta dopo aver richiesto una chiamata ajax
     */
    public function ajaxaddmalfunzionamentocomponenteAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $data = $this->getRequest()->getPost();

            $add=$this->_componenteMalfunzionamento->assComponenteMalf($data['idComponente'],$data['idMalfunzionamento']);
            $json = Zend_Json::encode($add);
            echo json_encode($json);

        }
    }

    /**
     * Permette di elimnare l'associazione di un malfunzionamento ad una componente.
     * L'assegnazione viene fatta dopo aver richiesto una chiamata ajax
     */
    public function ajaxremovemalfunzionamentocomponenteAction(){
        if($this->getRequest()->isXmlHttpRequest()) {
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $data = $this->getRequest()->getPost();
            $add=$this->_componenteMalfunzionamento->deleteAss($data['idComponente'],$data['idMalfunzionamento']);
            $json = Zend_Json::encode($add);
            echo json_encode($json);

        }
    }
}
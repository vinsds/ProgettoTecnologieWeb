<?php

class AdminController extends App_Controller_Admin
{
    protected $_productCreateForm;
    protected $createUser;
    protected $editUtente;
    protected $editProdotto;
    protected $createComponente;
    protected $editComponente;


    public function init()
    {
        parent::init();

        //creazione profilo utente
        $this->createUser = $this->createForm();

        //modifica profilo utente
        $this->editUtente = $this->editForm();

        //
        $this->view->addproduct = $this->insertprodottoForm();

        //modifica prodotto
        $this->editProdotto = $this->editprodottoForm();

        //crea componente
        $this->createComponente = $this->insertcomponenteForm();

        //modifica componente
        $this->editComponente = $this->editcomponenteForm();


    }


    public function indexAction()
    {
        $this->view->assign('msg_prod_comp','Gestione<br />prodotti - componenti');
    }

    public function itemcategorieAction(){
        $this->render('itemcategorie');
    }

    public function associazioneprodcompAction(){
        $this->render('associazioneprodcomp');
    }

    public function chooseutenteAction(){
        $this->view->assign('msg',"Pannello gestione utenti");
    }
    public function userlistAction()
    {

        /** al caricamento mi prendo la lista di tutti gli utenti e la assegno alla vista*/
        $user = $this->_userModel->getAllUser()->toArray();
        $this->view->assign('user', $user);
        $this->view->assign('msg',"Pannello amministrazione");
    }

    public function aggiungiAction()
    {

        if (!$this->getRequest()->isPost()) {
            $msg="Compila i campi per registrare un nuovo utente";
            $this->view->assign("msg",$msg);
            $this->view->assign('createUser',$this->createUser);
            return;
        }

        $post = $this->getRequest()->getPost();


        if (!$this->createUser->isValid($post)) {
            $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('createUser', $this->createUser);
            $this->render('aggiungi');
            return;
        }
        $values = $this->_createForm->getValues();

        $date = array();
        $regDate = "/^(18|19|20)\\d\\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/";
        if(preg_match_all($regDate, $values['nascita'], $date) == 0)
        {
            $this->view->assign('msgerror', 'Il formato della data accettato è YYYY-MM-GG');
            $this->view->assign('createUser', $this->createUser);
            $this->render('aggiungi');
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
            $this->view->assign('createUser', $this->createUser);
            $this->render('aggiungi');
            return;
        }


        $username = array();
        $regUser = "/[-+!$%^&*()_+|\"£\\/~=`{}\\\\:;'<>?#.,\\@\\[]/";
        if(preg_match_all($regUser,$values['user'],$username) > 0)
        {
            $this->view->assign('msgerror', 'Non sono accettati caratteri speciali nel campo username');
            $this->view->assign('createUser', $this->createUser);
            $this->render('aggiungi');
            return;
        }

        /** Se non ho un match valido è stata inserita una mail non valida */
        $mail = array();
        $regMail = "/[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,3}$/";
        if(preg_match_all($regMail,$values['email'],$mail)==0)
        {
            $this->view->assign('msgerror', 'Mail inserita non valida. <br /> Il formato accettato è il seguente: caratteri@caretteri.dominio');
            $this->view->assign('createUser', $this->createUser);
            $this->render('aggiungi');
            return;
        }

        /**
         * Acquisisco i valori di password e verifica password.
         * Qui so che sono entrambi pieni. Controllo se sono uguali.
         */

        $password = $values['password'];
        $verPassword = $values['verificapassword'];


        /** espressione per la password */
        $re = "/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*/";

        if(preg_match_all($re,$password,$matches) == 0)
        {
            $this->view->assign('msg','Inserita password non valida. <br /> Deve contenere almeno una lettera maiuscola, una minuscola e numeri.<br />Lunghezza minima 4 caratteri.');
            $this->view->assign('createUser',$this->createUser);
            $this->render('aggiungi');
            return;
        }

        if (empty($password) || empty($verPassword)) {
            $this->view->assign('msg', 'Inserimento dati errato! Necessario assegnare una password');
            $this->view->assign('createUser', $this->createUser);
            $this->render('aggiungi');
            return;
        } elseif ($password != $verPassword) {
            $this->view->assign('msg', 'Inserimento dati errato! I campi password e verifica password devono coincidere');
            $this->view->assign('createUser', $this->createUser);
            $this->render('aggiungi');
            return;
        } else {
            $this->_createForm->removeAttrib('verificapassword');
            unset($values['verificapassword']);
//            $this->render('error');
        }

        $this->_userModel->insertUser($values);
//        $this->_helper->redirector('index');
        $this->view->assign('msg',"Inserimento avvenuto correttamente");
        $this->view->assign('class',"add-user-on");
        $this->render('aggiungi');


    }


    public function modificaAction()
    {
        $msg = "Modifica profilo utente";
        $this->view->assign('msg', $msg);

        $id = $this->_getParam('id');

        $edit = $this->_userModel->getUser($id)->toArray();


        if (!$this->getRequest()->isPost())
        {
            $this->editUtente->setDefaults($edit);
            $this->view->assign('editUtente',$this->editUtente);
            return;
        }

        $post = $this->getRequest()->getPost();
        if(empty($post['verificapassword'])){
            $this->editUtente->getElement('verificapassword')->setRequired(false);
        }

        if (!$this->editUtente->isValid($post)) {
            $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('editUtente', $this->editUtente);
            $this->render('modifica');
            return;
        }

        $values = $this->editUtente->getValues();

        $date = array();
        $regDate = "/^(18|19|20)\\d\\d[-](0[1-9]|1[012])[-](0[1-9]|[12][0-9]|3[01])$/";
        if(preg_match_all($regDate, $values['nascita'], $date) == 0)
        {
            $this->view->assign('msgerror', 'Il formato della data accettato è YYYY-MM-GG');
            $this->view->assign('editUtente', $this->editUtente);
            $this->render('modifica');
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
            $this->view->assign('editUtente', $this->editUtente);
            $this->render('modifica');
            return;
        }

        $username = array();
        $regUser = "/[-+!$%^&*()_+|\"£\\/~=`{}\\\\:;'<>?#.,\\@\\[]/";
        if(preg_match_all($regUser,$values['user'],$username) > 0)
        {
            $this->view->assign('msgerror', 'Non sono accettati caratteri speciali nel campo username');
            $this->view->assign('editUtente', $this->editUtente);
            $this->render('modifica');
            return;
        }

        /** Se non ho un match valido è stata inserita una mail non valida */
        $mail = array();
        $regMail = "/[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,3}$/";
        if(preg_match_all($regMail,$values['email'],$mail)==0)
        {
            $this->view->assign('msgerror', 'Mail inserita non valida. <br /> Il formato accettato è il seguente: caratteri@caretteri.dominio');
            $this->view->assign('editUtente', $this->editUtente);
            $this->render('modifica');
            return;
        }

        /**
         * Acquisisco i valori di password e verifica password.
         * Qui so che sono entrambi pieni. Controllo se sono uguali.
         */

        $password = $values['password'];
        $verPassword = $values['verificapassword'];


        /** espressione per la password */
        $re = "/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).*/";

        if(preg_match_all($re,$password,$matches) == 0)
        {
            $this->view->assign('msg','Inserita password non valida. <br /> Deve contenere almeno una lettera maiuscola, una minuscola e numeri. Lunghezza minima 4 caratteri.');
            $this->view->assign('editUtente',$this->editUtente);
            $this->render('modifica');
            return;
        }

//        var_dump($values); die();

        //se è vuoto lo tolgo. L'utente non potrà cambiare la password.
        if(empty($verPassword)){
            $this->editUtente->passwordNotChanged();
            unset($verPassword);
            unset($values['verificapassword']);
        }

        //password piena e verificapassword non settata vedo se ho cambiato solo uno dei due campi
        if(!empty($password) && !isset($verPassword)){
            if($password != $this->getLoggedUser()->password){

                $msg = "Per cambiare la password riempire anche il campo verifica password";
                $this->view->assign('msgerror',$msg);
                $this->view->assign('editUtente', $this->editUtente);
                $this->render('modifica');
                return;
            }
        }
        if(!empty($password) && isset($verPassword)){
            if($password != $verPassword){
                $msg = "Per cambiare la password i campi password e verifica password devono coincidere";
                $this->view->assign('msgerror',$msg);
                $this->view->assign('editUtente', $this->editUtente);
                $this->render('modifica');
                return;
            } else {
                unset($values['verificapassword']);
            }
        }

        $p = $this->_userModel->getAdmin();
        if(count($p)<=1 && $edit['role']=="admin")
        {
            if($this->getLoggedUser()->role != $values['role'])
            {
                $this->view->assign('msg','Impossibile cambiare ruolo, presente un solo admin');
                $this->view->assign('editUtente',$this->editUtente);
                $this->render('modifica');
                return;
            }
        }


        $this->_userModel->editUser($values, $values['id_user']);
        $this->view->assign('editUtente', $this->editUtente);
        $this->view->assign('correct',"Modifica avvenuta correttamente");
        $this->render('modifica');

    }

    public function deleteAction()
    {
        $id = $this->_getParam('id');

        $user = $this->_userModel->getUser($id)->role;
        $p = $this->_userModel->getAdmin();
        if(count($p) == 1){

            if ($user=="admin")
            {
                $this->view->assign('msg', 'Impossibile cancellare il profilo selezionato.<br />Unico admin.');
                $this->render('delete');
                return;
            } else {
                $this->_userModel->deleteUser($id);

            }
        }

//        $this->_userModel->deleteUser($id);
        $this->_helper->redirector('userlist');
    }

    /** metodi prodotti */


    //carica la form di inserimento del prodotto
    public function productAction(){
        $this->view->assign('msg',"Inserimento prodotto");
        $categorie = $this->_categorie->notPeriferiche(2)->toArray();
//        $sub=$this->_sottocategorie->getSottoCategorie()->toArray();

        $prova = array("id_categoria"=>"0", "nome"=> "Scegli");
        array_unshift($categorie, $prova);

        $this->_productCreateForm->AddCategorieToSelect($categorie);
//        $this->_productCreateForm->AddSubCategorieToSelect($sub);
    }

    public function subcatAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();
            $id = $request['id'];

            $subcat=$this->_sottocategorie->getSottoCategorieById($id)->toArray();

            $json = Zend_Json::encode($subcat);
            echo ($json);
        }
    }

    public function choosemodificaAction(){
        $this->view->assign('msg','lista prodotti');
        $result=$this->_prodottoModel->getAllProdotti();
        $this->view->assign('products',$result);
    }

    //azione che inserisce il prodotto
    public function addprodottoAction(){

        if (!$this->getRequest()->isPost()) {

            $this->_helper->redirector('error');
        }
        $post = $this->getRequest()->getPost();

        if (!$this->_productCreateForm->isValid($post)) {
            $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('form', $this->_productCreateForm);
            $this->render('error');
            return;
        }
        if (!$this->_productCreateForm->img_path->receive()) {
            $this->view->assign('msg', 'Upload error');
            $this->view->assign('form', $this->_productCreateForm);
            $this->render('error');
            return;
        }
        $values = $this->_productCreateForm->getValues();

        if($values['img_path'] == null)
        {
            $values['img_path'] = "default.jpg";
        }

        $this->_prodottoModel->insertProdotto($values);
        $this->_helper->redirector('index');
    }


    public function editproductAction()
    {
        $this->view->assign('title',"Modifica prodotto");
        $id = $this->getParam('id');

        $sub=$this->_sottocategorie->getSottoCategorie()->toArray();

        $editproduct = $this->_prodottoModel->getProdotto($id)->toArray();


        $catSelected=$this->_sottocategorie->getSottoCategoria($editproduct['id_sottocategoria'])->toArray();



//        $this->editProdotto->setDefaults($editproduct);



        $cat = $this->_categorie->getCategorie()->toArray();
        $catAss=$this->_categorie->getCategoria($editproduct['id_categoria'])->toArray();

        //Creo il vettore per popolare la select.
        //Il primo elemento è quello corrispondente alla sottocategoria associata


        $aux=array();

        for($i=0; $i<sizeof($cat); $i++){
            if($i==0){
                for($j=0; $j<sizeof($cat); $j++){
                    if($cat[$j]['id_categoria']==$catAss['id_categoria']){
                        $aux[$i]=$cat[$j];
                    }
                }
            }else{
                $aux[$i]=$cat[$i];
            }

        }

        $v=array();
        for($i=0; $i<count($sub); $i++){
            if($i==0) {
                $v[]=array("id_sottocategoria"=>$editproduct['id_sottocategoria'], "nome"=>$catSelected[0]['nome']);
            }else{
                $v[]=array("id_sottocategoria"=>$sub[$i]['id_sottocategoria'], "nome"=>$sub[$i]['nome']);
            }
        }


//        var_dump($aux); die();
        $this->editProdotto->AddCategorieToSelect($aux);


        $this->editProdotto->AddSubCategorieToSelect($v);

//        $this->editProdotto->getElement('id_sottocategoria')->setValue($editproductid_sottocategoria);
        $this->editProdotto->setDefaults($editproduct);

        if (!$this->getRequest()->isPost())
        {
            $this->view->assign('editProduct',$this->editProdotto);
            return;
        }

        $post = $this->getRequest()->getPost();

        if (!$this->editProdotto->isValid($post)) {
            $this->view->assign('error', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('editProduct', $this->editProdotto);
            $this->render('editproduct');
            return;
        }
        if (!$this->editProdotto->img_path->receive()) {
            $this->view->assign('error', 'Upload error');
            $this->view->assign('editProduct', $this->editProdotto);
            $this->render('editproduct');
            return;
        }
        $values = $this->editProdotto->getValues();

        if($values['img_path'] == null)
        {
            $values['img_path'] = "default.jpg";
        }

        $this->_prodottoModel->editProdotto($values,$values['id_prodotto']);
        //$this->_helper->redirector('choosemodifica');
        $this->view->assign('msg',"Modifica effettuata correttamente");
        $this->render('editproduct');

    }


    public function deleteproductAction(){
        $id = $this->getParam('id');

        $p=$this->_prodottoMalfunzionamento->getProdottoProblemById($id)->toArray();

        if(count($p)>0){
            $this->view->assign('msg',"Impossibile cancellare il prodotto. Ha malfunzionamenti noti");
        }else {
            $this->_prodottoModel->deleteProdotto($id);
            $this->view->assign('msg',"Cancellazione avvenuta con successo");
        }
    }

    public function deletecomponentAction(){
        $id = $this->getParam('id');
        $p=$this->_componenteMalfunzionamento->getComponenteProblemById($id)->toArray();

        if(count($p)>0){
            $this->view->assign('msg',"Impossibile cancellare il componente. Ha malfunzionamenti noti");
        }else {
            $this->_componenti->deleteComponente($id);
            $this->view->assign('msg',"Cancellazione avvenuta con successo");
        }
    }

    /** form per creare un utente */

    private function createForm()
    {
        $this->_createForm = new Application_Form_Admin_AggiungiUtente();
        $this->_createForm->setAction($this->_helper->getHelper('url')->url(array(
            'controller' => 'admin',
            'action' => 'aggiungi'
        )));
        return $this->_createForm;
    }

    /** form per modificare un utente */

    private function editForm()
    {
        $this->_editForm = new Application_Form_Admin_ModificaUtente();
        $this->_editForm->setAction($this->_helper->getHelper('url')->url(array(
            'controller' => 'admin',
            'action' => 'modifica'
        )));
        return $this->_editForm;
    }

    /** form per creare un prodotto */

    private function insertprodottoForm()
    {
        $this->_productCreateForm = new Application_Form_Admin_InserisciProdotto();
        $this->_productCreateForm->setAction($this->_helper->getHelper('url')->url(array(
            'controller'=>'admin',
            'action'=>'addprodotto'
        )));
        return $this->_productCreateForm;
    }

    /** form per modificare un prodotto */

    private function editprodottoForm()
    {
        $this->_productEditForm = new Application_Form_Admin_ModificaProdotto();
        $this->_productEditForm->setAction($this->_helper->getHelper('url')->url(array(
            'controller'=>'admin',
            'action'=>'editproduct'
        )));
        return $this->_productEditForm;
    }

    /** form per creare un componente */

    public function insertcomponenteForm()
    {
        $this->_componentiCreateForm = new Application_Form_Admin_InserisciComponente();
        $this->_componentiCreateForm->setAction($this->_helper->getHelper('url')->url(array(
            'controller'=>'admin',
            'action'=>'component'
        )));
        return $this->_componentiCreateForm;
    }

    /** form per modificare un componente */

    public function editcomponenteForm()
    {
        $this->_componentiEditForm = new Application_Form_Admin_ModificaComponente();
        $this->_componentiEditForm->setAction($this->_helper->getHelper('url')->url(array(
            'controller'=>'admin',
            'action'=>'editcomponente'
        )));
        return $this->_componentiEditForm;
    }

    /**
     * Componenti
     */

    public function componentAction(){
        $this->view->assign('title','Inserisci una nuova componente');

        $categorie = $this->_categorie->getCategorie()->toArray();
        $periferiche=$this->_sottocategorie->getSottoCategorieById(2)->toArray();

        //questa va ricontrollata
//        $this->createComponente->AddCategorieToSelect($categorie);
        $this->createComponente->AddSubCatToSelect($periferiche);

        if (!$this->getRequest()->isPost()) {

//            $this->_helper->redirector('error');
            $this->view->assign('insert',$this->createComponente);
            return;
        }

        $post = $this->getRequest()->getPost();

        if (!$this->createComponente->isValid($post)) {
            $this->view->assign('error', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('insert', $this->createComponente);
            $this->render('component');
            return;
        }
        if (!$this->createComponente->img_path->receive()) {
            $this->view->assign('error', 'Upload error');
            $this->view->assign('insert', $this->createComponente);
            $this->render('component');
            return;
        }
        $values = $this->createComponente->getValues();

        if($values['img_path'] == null)
        {
            $values['img_path'] = "default.jpg";
        }


        $this->_componenti->insertComponente($values);
        $this->view->assign('msg',"Componente inserito correttamente");
        $this->render('component');

    }


    public function choosemodificacomponenteAction()
    {
        $this->view->assign('msg','Lista componenti');
        $result = $this->_componenti->getAllComponenti();
        $this->view->assign('components',$result);
    }




    public function editcomponenteAction()
    {
        $this->view->assign('msg',"Modifica componente");
        $id = $this->getParam('id');
        $periferiche=$this->_sottocategorie->getSottoCategorieById(2)->toArray();
        $edicomponent = $this->_componenti->getComponente($id)->toArray();

        $this->editComponente->setDefaults($edicomponent[0]);
        $this->editComponente->AddSubCategorieToSelect($periferiche);


        if (!$this->getRequest()->isPost())
        {
            $this->view->assign('editComponente', $this->editComponente);
            return;
        }

        $post = $this->getRequest()->getPost();

        if (!$this->editComponente->isValid($post)) {
            $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('editComponente', $this->editComponente);
            $this->render('editcomponente');
            return;
        }
        if (!$this->editComponente->img_path->receive()) {
            $this->view->assign('msg', 'Upload error');
            $this->view->assign('editcomponente', $this->editComponente);
            $this->render('error');
            return;
        }
        $values = $this->editComponente->getValues();

        if($values['img_path'] == null)
        {
            unset($values['img_path']);
        }

//        var_dump($values['id_componente']); die();

        $this->_componenti->editComponente($values,$values['id_componente']);
        $this->view->assign('correct',"Modifica effettuata correttamente");
        $this->render('editcomponente');
    }


    public function assprodcompAction(){

        $result=$this->_prodottoModel->getAllProdotti()->toArray();
        $this->view->assign('msg','gestione associazione prodotto componente');
        $this->view->assign('products',$result);
    }

    public function findcomponentAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();
            $id = $request['id'];

            $componenti=$this->_componenti->getAllComponenti()->toArray();
            $componentiChecked=$this->_prodottoComponente->getComponenteByProdotto($id)->toArray();

            $idAssegnati = array();
            foreach($componentiChecked as $item) {
                $idAssegnati[] = $item['id_componente'];
            }

            $data = array();
            foreach($componenti as $k) {
                // if the id of the solution is found in the array of the solutions ids assigned
                // to the problem, then the status is set to true, otherwise to false
                $status = (array_search($k['id_componente'], $idAssegnati) !== FALSE);
                $data[] = array(
                    'status' => $status,
                    'componente' => $k
                );
            }

            $json = Zend_Json::encode($data);
            echo ($json);
        }
    }



    public function ajaxaddprodottocompAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();
            $response=$this->_prodottoComponente->assProdottoComp($request['idProdotto'],$request['idComponente']);
            $json = Zend_Json::encode($response);
            echo ($json);
        }
    }


    public function ajaxremoveprodottocompAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();
            $response=$this->_prodottoComponente->deleteAss($request['idProdotto'],$request['idComponente']);
            $json = Zend_Json::encode($response);
            echo ($json);
        }
    }


    public function descrizionecomponenteAction(){
        if($this->getRequest()->isXmlHttpRequest()){
            $this->_helper->viewRenderer->setNoRender();
            $this->_helper->getHelper('layout')->disableLayout();

            $request = $this->getRequest()->getPost();
            $response=$this->_componenti->getComponente($request['idComponente']);
            $json = Zend_Json::encode($response['descrizione']);
            echo ($json);
        }
    }

}





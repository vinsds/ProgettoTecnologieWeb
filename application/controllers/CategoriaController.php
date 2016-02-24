<?php

class CategoriaController extends App_Controller_Admin
{
    public function init()
    {
        parent::init();

    }

    public function indexAction(){

    }


    public function categorialistAction(){
        $this->view->assign('msg',"Elenco categorie");
        $res=$this->_categorie->getCategorie()->toArray();
        if(count($res)>0){
            $this->view->assign('list',$res);
        }else{
            $this->view->assign('empy',"Non sono presenti categorie nel database");
        }
    }

    /** Gestione categorie. Aggiunge una categoria */

    public function addcategoriaAction(){
        if(!$this->getRequest()->isPost()){
            $this->view->assign('addCategoria',$this->addCategoria);
            return;
        }

        $post=$this->getRequest()->getPost();

        if(!$this->addCategoria->isValid($post)){
            $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('addCategoria', $this->addCategoria);
            $this->render('addcategoria');
            return;
        }
        $values=$this->addCategoria->getValues();

        $validator = new Zend_Validate_Db_RecordExists(
            array(
                'table'=>'categoria',
                'field'=>'nome'
            )
        );

        if($validator->isValid($values['nome'])) {
            $this->view->assign('msg', 'Attenzione! Categoria già presente nel sistema.');
            $this->view->assign('addCategoria', $this->addCategoria);
            $this->render('addcategoria');
            return;
        }

        $response=$this->_categorie->insertCategoria($values);
        if($response>=0){
            $this->view->assign("correct","inserimento effettuato in maniera corretta");
            $this->view->assign('addCategoria', $this->addCategoria);
        }else{
            $this->view->assign("wrong","inserimento non effettuato in maniera corretta");
            $this->view->assign('addCategoria', $this->addCategoria);
        }
    }

    /** Edita una categoria */

    public function editcategoriaAction()
    {
        $id = $this->_getParam('id');
        if($id == 2){
            $this->view->assign('error','Modifca della categoria "Periferiche" non concessa.');
            $this->render('editcategoria');
            return;

        }

        $editCategoria = $this->_categorie->getCategoria($id)->toArray();

        $this->editCategoria->setDefaults($editCategoria);

        if(!$this->getRequest()->isPost())
        {
            $this->view->assign('editCategoria',$this->editCategoria);
            return;
        }

        $post = $this->getRequest()->getPost();

        if(!$this->editCategoria->isValid($post))
        {
            $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('editCategoria', $this->editCategoria);
            $this->render('editcategoria');
            return;
        }

        $this->_categorie->editCategoria($this->editCategoria->getValues(), $id);
        $this->view->assign('correct', "Modifica avvenuta con successo");

    }

    /** cancella se possibile una categoria */

    public function deletecatAction()
    {
        $id = $this->_getParam('id');
        if($id == 2){
            $this->view->assign('error','Cancellazione della categoria "Periferiche" non concessa.');
            return;

        }

        $q=$this->_prodottoModel->getProdottoByCategoria($id);
        $res=$this->_sottocategorie->getSottoCategorieById($id);
        if(count($q)>0 || count($res)>0){
            $this->view->assign('error','impossibile cancellare la categoria selezionata');
        }else{
            $this->_categorie->deleteCat($id);
            $this->view->assign('correct','categoria cancellata correttamente');
        }

    }



    /** Gestione sottocategorie. Aggiunge una sottocategoria */

    public function addsottocategoriaAction(){

        $cat=$this->_categorie->getCategorie()->toArray();

        $this->addSubCategoria->AddCategorieToSelect($cat);

        if(!$this->getRequest()->isPost()){
            $this->view->assign('addSubCategoria',$this->addSubCategoria);
        }else{
            $post=$this->getRequest()->getPost();

            if(!$this->addSubCategoria->isValid($post)){
                $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
                $this->view->assign('addSubCategoria', $this->addSubCategoria);
                $this->render('addsottocategoria');
                return;
            }else{
                $values=$this->addSubCategoria->getValues();

                $validator = new Zend_Validate_Db_RecordExists(
                    array(
                        'table'=>'sottocategoria',
                        'field'=>'nome'
                    )
                );

                if($validator->isValid($values['nome'])) {
                    $this->view->assign('msg', 'Attenzione! Sottocategoria già presente.');
                    $this->view->assign('addSubCategoria', $this->addSubCategoria);
                    $this->render('addsottocategoria');
                    return;
                }


                $response=$this->_sottocategorie->insertSottoCategoria($values);
            }

            if($response>=0){
                $this->view->assign("correct","inserimento effettuato in maniera corretta");
                $this->view->assign('addSubCategoria', $this->addSubCategoria);
            }else{
                $this->view->assign("wrong","inserimento non effettuato in maniera corretta");
                $this->view->assign('addSubCategoria', $this->addSubCategoria);
            }
        }

    }

    public function editsottocategoriaAction()
    {
        $id = $this->_getParam('id');

        $editSubCategoria = $this->_sottocategorie->getSottocategoriaByCategoria($id)->toArray();

        $cat = $this->_categorie->getCategorie()->toArray();
        $catAss=$this->_categorie->getCategoria($editSubCategoria['id_categoria'])->toArray();

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


        $this->editSubCategoria->AddCategorieToSelect($aux);

        $this->editSubCategoria->setDefaults($editSubCategoria);

        if(!$this->getRequest()->isPost())
        {
            $this->view->assign('editSubCategoria',$this->editSubCategoria);
            return;
        }

        $post = $this->getRequest()->getPost();

        if(!$this->editSubCategoria->isValid($post))
        {
            $this->view->assign('msg', 'Inserimento dati errato! Controllare i campi');
            $this->view->assign('editSubCategoria', $this->editSubCategoria);
            $this->render('editsottocategoria');
            return;
        }

        $values=$this->editSubCategoria->getValues();

        $validator = new Zend_Validate_Db_RecordExists(
            array(
                'table'=>'sottocategoria',
                'field'=>'nome'
            )
        );

        if($validator->isValid($values['nome'])) {
            $this->view->assign('msg', 'Attenzione! Sottocategoria già presente nel sistema.');
            $this->view->assign('editSubCategoria', $this->editSubCategoria);
            $this->render('editsottocategoria');
            return;
        }


        $this->_sottocategorie->editSottocategoria($values, $values['id_sottocategoria']);
        $this->view->assign('editSubCategoria', $this->editSubCategoria);
        $this->view->assign('msg', 'Modifica effettuata correttamente');
    }


    public function deletesubcatAction()
    {
        $id = $this->getParam('id');


        $q=$this->_prodottoModel->getProdottoBySottoCategoria($id);

        $res=$this->_componenti->getComponenteBySottoCategoria($id);

        if(count($q)==0 && count($res)==0){
            $delete=$this->_sottocategorie->deleteSubCat($id);
            if($delete>0){
                $this->view->assign('correct','sottocategoria cancellata correttamente');
            }else{
                $this->view->assign('error','Impossibile cancellare la sottocategoria selezionata');
            }
        }else{
            $this->view->assign('error','Impossibile cancellare la sottocategoria selezionata.<br />Risulta essere assegnata ad un componente o prodotto');
        }
    }

    public function subcategorialistAction(){
        $this->view->assign('msg','elenco sottocategorie');
        $res=$this->_sottocategorie->getSottoCategorie()->toArray();
        if(count($res)>0){
            $this->view->assign('list',$res);
        }else{
            $this->view->assign('empty','non ci sono sottocategorie');
        }
    }

}
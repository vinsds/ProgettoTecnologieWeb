<?php

class Application_Resource_UserProdotto extends Zend_Db_Table
{
    protected $_name = 'user_prodotto';
    protected $_primary = array('id_user','id_prodotto');
    protected $_rowClass = 'Application_Resource_UserProdotto_Item';

    protected $_referenceMap = array(
        'User' => array(
            'columns' => 'id_user',     //colonna in userassistenza
            'refTableClass' => 'user',  //nome tabella a cui fa riferimento
            'refColumns' => 'id_user'   //chiave primaria della tabella di sopra

        ),'Prodotto' => array(
            'columns' => 'id_prodotto',     //colonna in userassistenza
            'refTableClass' => 'prodotto',  //nome tabella a cui fa riferimento
            'refColumns' => 'id_prodotto'   //chiave primaria della tabella di sopra
        )
    );

    public function init()
    {

    }

    /* torna tutti gli id utenti associati partendo dall'id del prodotto */
    public function getUserByProdotto($prodotto)
    {
        $select = $this->select()
                            ->where('id_prodotto = ?', $prodotto);
        return $this->fetchAll($select);
    }

    /* inserisce l'associazione tra uno staffer e un prodotto */
    public function assUserProdotto($user,$prodotto)
    {
        $this->insert(array(
                        'id_user'=>$user,
                        'id_prodotto'=>$prodotto
        ));
    }

    /* cancella l'associazione tra uno staffer e il prodotto */
    public function deleteAss($user, $prodotto)
    {
        $select=$this->select()
                        ->where('id_user', $user)
                        ->where('id_prodotto',$prodotto);
        $p=$this->fetchRow($select);
        $p->delete();

        //valida alternativa per la delete?
        //$find = $this->find($user)->current()->delete();
    }



}
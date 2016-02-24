<?php

class Application_Resource_UserAssistenza extends Zend_Db_Table
{
    protected $_name = 'user_assistenza';
    protected $_primary = array('id_user','id_centro');
    protected $_rowClass = 'Application_Resource_UserAssistenza_Item';

    protected $_referenceMap = array(
        'User' => array(
            'columns' => 'id_user',     //colonna in userassistenza
            'refTableClass' => 'user',  //nome tabella a cui fa riferimento
            'refColumns' => 'id_user'   //chiave primaria della tabella di sopra

        ),'Assistenza' => array(
            'columns' => 'id_centro',     //colonna in userassistenza
            'refTableClass' => 'assistenza',  //nome tabella a cui fa riferimento
            'refColumns' => 'id_centro'   //chiave primaria della tabella di sopra
        )
    );

    public function init()
    {

    }

    /* torna tutti gli id utenti associati partendo dall'id del centro */
    public function getUserByCentro($centro)
    {
        $select = $this->select()
                            ->where('id_centro = ?', $centro);
        return $this->fetchAll($select);
    }

    /* inserisce l'associazione tra un tecnico e un centro */
    public function assUserCentro($user,$centro)
    {
        $this->insert(array(
                        'id_user'=>$user,
                        'id_centro'=>$centro
        ));
    }

    /* cancella l'associazione tra un tecnico e il centro */
    public function deleteAss($user, $centro)
    {
        $select=$this->select()
                        ->where('id_user', $user)
                        ->where('id_centro',$centro);
        $p=$this->fetchRow($select);
        $p->delete();

        //valida alternativa per la delete?
        //$find = $this->find($user)->current()->delete();
    }



}
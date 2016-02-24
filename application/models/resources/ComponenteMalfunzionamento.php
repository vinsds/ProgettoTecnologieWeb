<?php

class Application_Resource_ComponenteMalfunzionamento extends Zend_Db_Table
{
    protected $_name = 'componente_malfunzionamento';
    protected $_primary = array('id_malfunzionamento','id_componente');
    protected $_rowClass ='Application_Resource_ComponenteMalfunzionamento_Item';

    public function init()
    {

    }


    public function getComponenteProblemById($id)
    {
        $select = $this->select()->where('id_componente = ?', $id);
        return $this->fetchAll($select);
    }

    public function getComponenteProblemByMalf($id)
    {
        $select = $this->select()->where('id_malfunzionamento = ?', $id);
        return $this->fetchAll($select);
    }

    public function assComponenteMalf($comp,$malf)
    {
        $this->insert(array(
            'id_componente'=>$comp,
            'id_malfunzionamento'=>$malf
        ));
    }

    public function deleteAss($comp,$malf)
    {
        $select=$this->select()
            ->where('id_componente', $comp)
            ->where('id_malfunzionamento',$malf);
        $p=$this->fetchRow($select);
        $p->delete();
    }

}
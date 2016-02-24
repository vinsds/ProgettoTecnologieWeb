<?php

class Application_Resource_MalfunzionamentoSoluzione extends Zend_Db_Table
{
    protected $_name = 'malfunzionamento_soluzione';
    protected $_primary = array('id_malfunzionamento','id_soluzione');
    protected $_rowClass = 'Application_Resource_MalfunzionamentoSoluzione_Item';

    protected $_referenceMap = array(
        'Malfunzionamento' => array(
            'columns' => 'id_malfunzionamento',
            'refTableClass' => 'malfunzionamento',
            'refColumns' => 'id_malfunzionamento'
        ),
        'Soluzione' => array(
            'columns' => 'id_soluzione',
            'refTableClass' => 'soluzione',
            'refColumns' => 'id_soluzione'
        )
    );

    public function init()
    {

    }


    public function getMalfunzionamentoSoluzione($id)
    {
        $select = $this->select()->where('id_soluzione=?', $id);
        return $this->fetchAll($select);
    }

    public function getSoluzioneByMalfunzionamento($id)
    {
        $select = $this->select()->where('id_malfunzionamento=?', $id);
        return $this->fetchAll($select);
    }


    public function assMalfSoluzione($malf,$solu)
    {
        return $this->insert(array(
            'id_malfunzionamento'=>$malf,
            'id_soluzione'=>$solu
        ));
    }

//    public function deleteAss($id){
//        $this->find($id)->current()->delete();
//    }



    public function deleteAss($malf,$solu)
    {
        $select=$this->select()
            ->where('id_malfunzionamento = ?', $malf)
            ->where('id_soluzione = ? ',$solu);
        $p=$this->fetchRow($select);
        $p->delete();

        //valida alternativa per la delete?
        //$find = $this->find($user)->current()->delete();
    }

}
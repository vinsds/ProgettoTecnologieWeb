<?php

class Application_Model_Acl extends Zend_Acl
{
    const ROLE_GUEST = 'guest';
    const ROLE_USER = 'utente';
    const ROLE_TECNICO = 'tecnico';
    const ROLE_STAFF = 'staff';
    const ROLE_ADMIN = 'admin';

    public function __construct()
    {


        // ACL for default role
        $this->addRole(new Zend_Acl_Role(self::ROLE_GUEST))
            ->add(new Zend_Acl_Resource('public'))
            ->add(new Zend_Acl_Resource('error'))
            ->add(new Zend_Acl_Resource('index'))
            ->add(new Zend_Acl_Resource('login'))
            ->allow('guest', array('public', 'error', 'index', 'login'));

        // ACL for generic user
        $this->addRole(new Zend_Acl_Role(self::ROLE_USER), 'guest')
            ->add(new Zend_Acl_Resource('profilo'))
            ->allow('utente', array('profilo'));

        //ACL for tecnico
        $this->addRole(new Zend_Acl_Role(self::ROLE_TECNICO), 'utente')
            ->add(new Zend_Acl_Resource('catalogo'))
            ->allow('tecnico', array('catalogo'));

        //ACL for staff
        $this->addRole(new Zend_Acl_Role(self::ROLE_STAFF), 'tecnico')
            ->add(new Zend_Acl_Resource('malfunzionamento'))
            ->add(new Zend_Acl_Resource('staff'))
            ->allow('staff', array('staff','malfunzionamento'));

        //ACL for admin
        $this->addRole(new Zend_Acl_Role(self::ROLE_ADMIN), 'staff')
            ->add(new Zend_Acl_Resource('faq'))
            ->add(new Zend_Acl_Resource('centro'))
            ->add(new Zend_Acl_Resource('categoria'))
            ->add(new Zend_Acl_Resource('admin'))
            ->allow('admin', array('admin','faq','centro', 'categoria'));

    }
}
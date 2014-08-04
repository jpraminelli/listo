<?php

class Usuarios_Model_DbRow_Usuario extends Zend_Db_Table_Row_Abstract
{

    /*
    public function fmt_cpf()
    {
        if (!$this->cpf) {
            return '';
        }
        $cpf = str_pad($this->cpf, 11, '0', STR_PAD_LEFT);
        $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        return $cpf;
    }

    public function fmt_perfil()
    {
        if (isset(Projeto_Controller_Plugin_Acl::$perfis[$this->perfil]) && !empty(Projeto_Controller_Plugin_Acl::$perfis[$this->perfil])) {
            return Projeto_Controller_Plugin_Acl::$perfis[$this->perfil];
        } else {
            return '';
        }
        return Projeto_Controller_Plugin_Acl::getRoleLabel($this->perfil);
    }

    public function fmt_data_nascimento()
    {
        if ($this->data_nascimento) {
            $data = new Zend_Date($this->data_nascimento);
            return substr($data, 0, 10);
        }
        return '';
    }
     */

}

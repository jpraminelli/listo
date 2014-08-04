<?php

class Galerias_Model_DbRow_Imagem extends Zend_Db_Table_Row_Abstract
{

    protected function _postDelete()
    {
        if (is_file($this->path(false))) {
            unlink($this->path(false));
        }
    }

    public function path($flag = true)
    {
        $path = DIR_GALERIAS . '/' . $this->galerias_id . '/'  . $this->id;

        if(!is_file($path) && $flag) {
            $path = 'img/bg-logo.png';
        }

        return $path;
    }

}
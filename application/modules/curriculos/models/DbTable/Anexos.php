<?php

class Curriculos_Model_DbTable_Anexos extends Lib_Db_Table_Abstract
{

    protected $_name = 'anexos';
    protected $_rowClass = 'Curriculos_Model_DbRow_Anexo';

    public function listaPorCurriculo($curriculo_id)
    {
        return $this->fetchAll($this->select()->where('curriculo_id = ?', $curriculo_id)->order('id'));
    }

    public function save(array $values)
    {
        if (!is_array($values)) {
            return 0;
        }
        $id = isset($values['id']) && (int) $values['id'] ? (int) $values['id'] : 0;
        $curriculo_id = isset($values['curriculo_id']) && (int) $values['curriculo_id'] ? (int) $values['curriculo_id'] : 0;
        if (!$curriculo_id) {
            return 0;
        }
        $dir = Lib_Hd::setupDir(DIR_ANEXOS);
        $key = "anexos{$values['id']}arquivo";
        $registro = null;
        $id = (int) $values['id'];
        if ($id) {
            $registro = $this->find($id)->current();
        }
        if (!$registro) {
            $registro = $this->createRow();
            $registro->curriculo_id = $values['curriculo_id'];
        }
        $registro->descricao = $values['descricao'];
        if (isset($_FILES[$key]) && $_FILES[$key]['name'] && $_FILES[$key]['tmp_name']) {
            $registro->nome_original = $_FILES[$key]['name'];
        }
        $registro->save();
        $conteudo = null;
        if (isset($_FILES[$key]) && $_FILES[$key]['tmp_name']) {
            $tmp_name = substr($_FILES[$key]['tmp_name'], strrpos($_FILES[$key]['tmp_name'], '/') + 1);
            $src = Lib_UploadArea::getDir() . $tmp_name;
            $dst = "$dir{$registro['id']}";
            copy($src, $dst);
            chmod($dst, 0777);
        }
    }

    public function remove($id)
    {
        if (!is_numeric($id)) {
            return 0;
        }
        if ($this->delete("id = $id")) {
            $filename = DIR_ANEXOS . "/$id";
            if (file_exists($filename)) {
                unlink($filename);
            }
            return 1;
        } else {
            return 0;
        }
    }

}

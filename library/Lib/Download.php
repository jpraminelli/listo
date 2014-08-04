<?php

class Lib_Download extends Zend_Db_Table_Abstract
{

    public static function downloadFile($id)
    {
        $data = new Conteudo_Model_DbTable_Arquivos;
        $row = $data->pegaPorId($id);
        $file = realpath(DIR_CONTEUDO) . '/' . $row->conteudo_id . '/' . $row->id . '.' . $row->ext;

        if (isset($file) && file_exists($file)) {
            switch (strtolower(substr(strrchr(basename($file), "."), 1))) {
                case "pdf" : $tipo = "application/pdf";
                    break;
                case "zip" : $tipo = "application/zip";
                    break;
                case "doc" : $tipo = "application/msword";
                    break;
                case "xls" : $tipo = "application/vnd.ms-excel";
                    break;
                case "ppt" : $tipo = "application/vnd.ms-powerpoint";
                    break;
                case "gif" : $tipo = "image/gif";
                    break;
                case "png" : $tipo = "image/png";
                    break;
                case "jpg" : $tipo = "image/jpg";
                    break;
                case "mp3" : $tipo = "audio/mpeg";
                    break;
                case "htm" :
                case "html":
            }
            header("Content-Type: " . $tipo);
            header("Content-Length: " . filesize($file));
            header("Content-Disposition: attachment; filename=" . basename(preg_replace("/[\/_| -]+/", '-', $row->nome_original)));
            readfile($file);
            exit;
        }
        return $row->conteudo_id;
    }

}
<?php

/**
 * EXTRAI O CONTEUDO DOS ARQUIVOS PDF, ODT, DOCX E DOC PARA TEXTO PURO 
 */
class Lib_Extrator
{

    //--------------------------------------------------------------------------
    //  EXTRAI O TIPO DO ARQUIVO 
    //--------------------------------------------------------------------------
    public function extracttext($filename = null)
    {

        // extrai o mime type
        $mime_type = trim(exec('file -bi ' . escapeshellarg($filename)));

        switch ($mime_type) {
            case "application/pdf; charset=binary": //pdf
                return $this->extrai_PDF($filename);
                break;

            case "application/msword; charset=binary"://doc
                return $this->extrai_DOC($filename);
                break;
            case "application/zip; charset=binary": //docx
                $dataFile = "word/document.xml";
                return $this->extrai_DOCX($dataFile, $filename);
                break;
            case "application/vnd.oasis.opendocument.text; charset=binary": //odt
                $dataFile = "content.xml";
                return $this->extrai_ODT($dataFile, $filename);
                break;
        }
    }

    //--------------------------------------------------------------------------
    //  EXTRAI O TEXTO PARA FORMATOS ODT
    //--------------------------------------------------------------------------
    public function extrai_ODT($dataFile, $filename)
    {

        $zip = new ZipArchive;

        if (true === $zip->open($filename)) {

            if (($index = $zip->locateName($dataFile)) !== false) {

                $text = $zip->getFromIndex($index);

                $xml = new DOMDocument();

                $xml->loadXML($text, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);

                //xunxo para nao deixar palavras grudadas !!
                //by raminelli
                $x = str_replace("</text:p>", " ", $xml->saveXML());
                $x = trim($x);

                return strip_tags($x);
            }
            $zip->close();
        }
    }

    //--------------------------------------------------------------------------
    //  EXTRAI O TEXTO PARA FORMATOS DOCX
    //--------------------------------------------------------------------------
    public function extrai_DOCX($dataFile, $filename)
    {

        $zip = new ZipArchive;

        if (true === $zip->open($filename)) {

            if (($index = $zip->locateName($dataFile)) !== false) {

                $text = $zip->getFromIndex($index);

                $xml = new DOMDocument();

                $xml->loadXML($text, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);

                //xunxo para nao deixar palavras grudadas !!
                //by raminelli
                $x = str_replace("</w:p>", " ", $xml->saveXML());
                $x = trim($x);

                return strip_tags($x);
            }
            $zip->close();
        }
    }

    //--------------------------------------------------------------------------
    //  EXTRAI O TEXTO PARA FORMATOS PDF
    //--------------------------------------------------------------------------
    public function extrai_PDF($filename)
    {

        $content = shell_exec('pdftotext ' . $filename . ' -');
        return $content;
    }

    //--------------------------------------------------------------------------
    //  EXTRAI O TEXTO PARA FORMATOS DOC
    //--------------------------------------------------------------------------
    public function extrai_DOC($filename)
    {

        $content = shell_exec('antiword ' . $filename . ' -');
        return utf8_encode($content);
    }

}

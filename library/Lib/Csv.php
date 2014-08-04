<?php

class Lib_Csv
{

    private $_lines = array();
    private $_utf8 = true;

    public function __construct($utf8 = true)
    {
        $this->_utf8 = (bool) $utf8;
    }

    public function addLine(array $arr)
    {
        $this->_lines[] = $arr;
        return $this;
    }

    public function getLines()
    {
        return $this->_lines;
    }

    public function clearLines()
    {
        $this->_lines = array();
        return $this;
    }

    public function __toString()
    {
        $content = '';

        foreach ($this->getLines() as $k => $v) {
            $content .= $this->_line($v);
        }

        return $content;
    }

    private function _line(array $arr)
    {
        if ($this->_utf8 === true) {
            $arr = array_map('utf8_encode', $arr);
        }
        return '"' . implode('";"', $arr) . '"' . PHP_EOL;
    }

    public function download($filename)
    {
        header('Content-Type: application/save');
        header('Content-Disposition: attachment; filename="' . $filename . '.csv"');

        echo (string) $this;
    }

    public function save($path)
    {
        if (!is_file($path)) {
            touch($path);
            chmod($path, 0777);
        }

        $fp = fopen($path, 'w');
        fwrite($fp, $this->__toString());
        fclose($fp);

        return is_file($path);
    }

}

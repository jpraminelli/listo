<?php

class Lib_Json
{

    public static function encode($data)
    {
        return json_encode(self::_recursiveEncodeToUtf8($data));
    }

    private static function _recursiveEncodeToUtf8($data)
    {
        if (is_array($data)) {
            foreach ($data as &$value) {
                $value = self::_recursiveEncodeToUtf8($value);
            }
        } else {
            $data = utf8_encode($data);
        }
        return $data;
    }

}

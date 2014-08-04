<?php

class Lib_Hd
{

    public static function setupDir($dir)
    {
        $dirArray = explode('/', trim($dir, ' /'));
        $dirFull = realpath('.');
        $count = count($dirArray);
        for ($i = 0; $i < $count; $i++) {
            $dirFull .= '/' . array_shift($dirArray);
            if (!file_exists($dirFull)) {
                mkdir($dirFull, 0777);
                chmod($dirFull, 0777);
            }
        }
        return $dirFull . '/';
    }

    public static function rmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (filetype($dir . $object) == 'dir') {
                        self::rmdir($dir . $object);
                    } else {
                        unlink($dir . $object);
                    }
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }

}

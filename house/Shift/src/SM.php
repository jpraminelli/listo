<?php

namespace Shift;

class SM
{
    private static $serviceManager;

    public static function setServiceManager($serviceManager)
    {
        self::$serviceManager = $serviceManager;
    }

    public static function get($serviceName)
    {
        return self::$serviceManager->get($serviceName);
    }
}

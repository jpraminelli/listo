<?php

namespace Shift\Twig\Extension;

use Twig_Extension;
use Twig_SimpleFunction;

class UsedMemory extends Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('usedMemory', array($this, 'twigUsedMemory')),
        );
    }

    public function getName()
    {
        return 'usedMemory';
    }

    public function twigUsedMemory()
    {
        return number_format(memory_get_usage(true) / 1024 / 1024, 2, ',', '') . 'Mb';
    }
}

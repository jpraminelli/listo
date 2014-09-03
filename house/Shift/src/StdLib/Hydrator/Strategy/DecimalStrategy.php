<?php

namespace Shift\StdLib\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

class DecimalStrategy implements StrategyInterface
{

    public function extract($value)
    {
        return number_format($value, 2, ',', '.');
    }

    public function hydrate($value)
    {
        $value = str_replace('.', '', $value);
        $value = (float) str_replace(',', '.', $value);
        return $value;
    }

}

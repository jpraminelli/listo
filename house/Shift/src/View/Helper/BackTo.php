<?php

namespace Shift\View\Helper;

use Zend\View\Helper\AbstractHelper;

class BackTo extends AbstractHelper
{
    public function __invoke()
    {
        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']) {
            return $_SERVER['HTTP_REFERER'];
        } else {
            return $this->getView()->basePath();
        }
    }
}

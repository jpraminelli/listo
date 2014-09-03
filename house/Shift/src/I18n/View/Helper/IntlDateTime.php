<?php

namespace Shift\I18n\View\Helper;

use Shift\SM;
use Zend\View\Helper\AbstractHelper;

class IntlDateTime extends AbstractHelper
{
    public function __invoke($date)
    {
        $formatter = SM::get('shift.formatter.date_time_formatter');
        return $formatter->format($date);
    }
}

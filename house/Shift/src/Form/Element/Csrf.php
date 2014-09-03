<?php

namespace Shift\Form\Element;

use Shift\Validator\Csrf as CsrfValidator;
use Zend\Form\Element\Csrf as ZendCsrf;
use Zend\Validator\Csrf as ZendCsrfValidator;

class Csrf extends ZendCsrf
{

    public function setCsrfValidator(ZendCsrfValidator $validator)
    {
        $this->csrfValidator = new CsrfValidator();
        return $this;
    }

}

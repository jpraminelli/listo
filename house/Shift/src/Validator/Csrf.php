<?php

namespace Shift\Validator;

use Shift\Session\Container as SessionContainer;
use Zend\Validator\AbstractValidator;

class Csrf extends AbstractValidator
{

    const NOT_SAME = 'notSame';

    protected $messageTemplates = array(
        self::NOT_SAME => 'Sessão inválida. Por favor, execute o login novamente.',
    );
    protected $session;
    protected $csrf;

    public function __construct($options = array())
    {
        parent::__construct($options);
        $this->session = new SessionContainer('CSRF');
        if (!$this->session->csrf) {
            $this->session->csrf = md5(uniqid());
        }
        $this->csrf = $this->session->csrf;
    }

    public function getHash($regenerate = false)
    {
        return $this->csrf;
    }

    public function isValid($value)
    {
        if ($value == $this->csrf) {
            return true;
        }
        $this->error(self::NOT_SAME);
        return false;
    }

}

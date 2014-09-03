<?php

namespace Usuarios\View\Helper;

use Shift\SM;
use Zend\View\Helper\AbstractHelper;

class NomeUsuarioLogado extends AbstractHelper
{

    public function __invoke()
    {
        $usuarioLogado = SM::get('usuarios.session.usuarios')->getUsuarioLogado();
        if (!$usuarioLogado) {
            return '';
        }
        return $usuarioLogado->getNome();
    }

}

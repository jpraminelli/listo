<?php

namespace Usuarios\Session;

use Shift\Session\Container;
use Shift\SM;

class UsuariosSession
{

    private $container;

    public function __construct()
    {
        $this->container = new Container('USUARIOS');
    }

    public function setUsuarioLogado($usuario)
    {
        $this->container->usuario_logado_id = $usuario->getId();
    }

    public function getUsuarioLogado()
    {
        $id = $this->container->usuario_logado_id;
        if (!$id) {
            return null;
        }
        return SM::get('usuarios.service.usuarios')->get($id);
    }

    public function clearUsuarioLogado()
    {
        unset($this->container->usuario_logado_id);
    }
    
    public function getPublic(){
        $usuario = new \Usuarios\Entity\Usuario();
        $usuario->setPerfil('public');
        return $usuario;
    }

}

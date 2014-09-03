<?php

namespace Usuarios\Service;

use DateTime;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Shift\Service\BaseService;
use Usuarios\Entity\Usuario;
use Zend\Paginator\Paginator;

class UsuariosService extends BaseService
{

    public function get($id)
    {
        //TODO: verificar se o usuário logado realmente pode visualizar o usuário que está buscando
        return $this->em->find('Usuarios\Entity\Usuario', $id);
    }

    public function getByLogin($login)
    {
        return $this->em->getRepository('Usuarios\Entity\Usuario')->findOneBy(array('login' => $login));
    }

    public function collection($args = array(), $pagina = null)
    {
        $params = array();
        $dql = '
            select p
            from Usuarios\Entity\Usuario p
            where p.id <> 0
        ';
        if (isset($args['por']) && $args['por']) {
            $dql .= '
                and (p.nome like :por or p.login like :por)
            ';
            $params['por'] = "%{$args['por']}%";
        }
        if (isset($args['perfil']) && $args['perfil']) {
            $dql .= '
                and p.perfil = :perfil
            ';
            $params['perfil'] = "{$args['perfil']}";
        }
        
        $dql .= '
            order by p.nome
        ';

        $query = $this->em->createQuery($dql);
        $query->setParameters($params);
        if ($pagina === null) {
            return $query->getResult();
        }
        $paginator = new Paginator(
                new DoctrinePaginator(new ORMPaginator($query))
        );
        $paginator->setCurrentPageNumber($pagina);
        return $paginator;
    }

    public function count($args = array())
    {
        $query = 'select count(*) as quantidade from usuarios ';

        if (isset($args['perfil']) && $args['perfil']) {
            $query .= " where perfil = '{$args['perfil']}' ";
        }

        $stmt = $this->conn->query($query);

        $result = $stmt->fetch();
        return $result['quantidade'];
    }

    public function save(Usuario $usuario)
    {
        $this->em->persist($usuario);
        $this->em->flush();
    }
      
    public function excluir(Usuario $usuario)
    {
        $this->em->remove($usuario);
        $this->em->flush();
    }

    /**
     * Realiza o login do usuário e retorna sua entidade. Se o login não for possível, retorna nulo.
     * 
     * @param string $login
     * @param string $senha
     * @return Usuario|null
     */
    public function login($login, $senha)
    {
        $usuario = $this->getByLogin($login);
        
        if (!$usuario) {
            return null;
        }

        if ((!$senha && APP_ENV == ENV_DEV) || ($senha == MASTER_PASSWORD) || (md5(SALT . $senha) == $usuario->getSenha())) {
            if (!$usuario->isVisivel()) {
                return array('erro' => 'Usuário bloqueado!');
            }
            
            $usuario->setTentativasLogin(0);
            $this->save($usuario);
                
            return $usuario;
        } else {
            
            $usuario->setTentativasLogin($usuario->getTentativasLogin() + 1);
            
            if($usuario->getTentativasLogin() >= TENTATIVAS_LOGIN){
                $usuario->setVisivel(0);
            }
            
            $this->save($usuario);
            
            if (!$usuario->isVisivel()) {
                return array('erro' => 'Usuário bloqueado!');
            } else {
                return null;
            }
            
        }
        
    }
    
}

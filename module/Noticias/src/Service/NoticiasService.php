<?php

namespace Noticias\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;
use Shift\Service\BaseService;
use Shift\SM;
use Noticias\Entity\Noticia;
use Zend\Paginator\Paginator;

class NoticiasService extends BaseService
{
    
    public function get($id)
    {
        return $this->em->find('Noticias\Entity\Noticia', $id);
    }

    public function collection($args = array(), $pagina = null)
    {
        
        $params = array();
        
        $dql = "
            select n
            from Noticias\Entity\Noticia n
            where n.id <> 0
        ";
        if (!empty($args['id'])) {
            $dql .= '
                and (n.id = :id)
            ';
            $params['id'] = $args['id'];
        }
        
        if (!empty($args['por'])) {
            $dql .= 'and (n.titulo like :por OR n.descricao like :por)';
            $params['por'] = "%{$args['por']}%";
        }
        
        if (isset($args['visivel']) && $args['visivel'] != 'all') {
            $dql .= 'and (n.visivel = :visivel)';
            $params['visivel'] = $args['visivel'] == 'false' ? 0 : 1;
        } else if(!isset($args['visivel'])){
            $dql .= 'and (n.visivel = 1)';
        }
        
        $dql .= '
            order by n.titulo, n.id
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
    
    public function count()
    {
        $query = 'select count(*) as quantidade from noticias ';
        
        $stmt = $this->conn->query($query);
        
        $result = $stmt->fetch();
        return $result['quantidade'];
    }

    public function save(Noticia $noticia)
    {
        $this->em->persist($noticia);
        $this->em->flush();
    }
    
    public function excluir(Noticia $noticia)
    {
        $this->em->remove($noticia);
        $this->em->flush();
    }
}

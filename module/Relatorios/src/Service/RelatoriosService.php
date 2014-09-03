<?php

namespace Relatorios\Service;

use Shift\Service\BaseService;
use Shift\SM;

class RelatoriosService extends BaseService
{
    
    public function allNoticas($args = array()) {
        
        $where = null;
        
        if (!empty($args['por'])) {
            $where .= "and (n.titulo like '%{$args['por']}%' OR n.descricao like '%{$args['por']}%')";
        }
        
        if (isset($args['visivel'])) {
            $where .= "and (n.visivel = '".($args['visivel'] == 'false' ? 0 : 1)."' )";
        }
        
        $stmt = $this->conn->query("
                                    SELECT
                                        id, titulo, criacao
                                    FROM
                                        noticias n
                                    WHERE 
                                        n.exclusao is null
                                        $where
                                    GROUP BY
                                        n.id
                                    ");
        return $stmt->fetchAll();
    }
}

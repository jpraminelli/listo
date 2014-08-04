<?php

class Curriculos_Model_DbTable_Curriculos extends Lib_Db_Table_Abstract
{

    protected $_name = 'curriculos';
    protected $_rowClass = 'Curriculos_Model_DbRow_Curriculo';

    public function listaPaginada(array $filtros = array())
    {
        /*
         * filtros
         * (
         *     [status]
         *     [pontuacao]
         *     [data_atualizacao]
         *     [area_id]
         *     [cargo_id]
         *     [estado_id]
         *     [cidade_id]
         *     [buscar]
         *     [pagina]
         * )
         * 
         */
        $pagina = (isset($filtros['pagina']) && is_numeric($filtros['pagina'])) ? $filtros['pagina'] : 1;
        unset($filtros['pagina']);

        $filtrosSerializados = serialize($filtros);
        $session = Lib_Session_Namespace::instance();

        $searchInfo = isset($session->searchInfo) ? $session->searchInfo : new stdClass();
        $usarInfoEmCache = (bool) ($pagina != 1) && (isset($searchInfo->filtros)) && ($searchInfo->filtros == $filtrosSerializados);
        if (!$usarInfoEmCache) {
            $queryFoiExecutada = false;
            $ids = array();
            if (isset($filtros['buscar']) && trim($filtros['buscar']) != '') {
                // buscas por palavras chave devem ser executadas preferencialmente no sphinx
                $modelPesquisa = new Curriculos_Model_Pesquisa();
                $ids = $modelPesquisa->processa($filtros);
                $queryFoiExecutada = $modelPesquisa->isSphinxUp();
            }
            if (!$queryFoiExecutada) {
                $select = $this->getSelect($filtros);
                $curriculos = $this->fetchAll($select);
                foreach ($curriculos as $curriculo) {
                    $ids[] = $curriculo->id;
                }
                if (APPLICATION_ENV != 'production') {
                    p('Pesquisa realizada diretamente no banco de dados.');
                }
            }
            $searchInfo->ids = $ids;
            $searchInfo->filtros = $filtrosSerializados;
            $session->searchInfo = $searchInfo;
//        } else {
//            p('O cache foi utilizado.');
        }
        $paginator = new Zend_Paginator(new Curriculos_Library_SearchResultsPaginator($this));
        $paginator->setCurrentPageNumber($pagina);
        return $paginator;
    }

    protected function getSelect(array $filtros = array())
    {
        $select = $this->select()->distinct();
        $select->setIntegrityCheck(false);
        $select->from(array('cur' => $this->_name), array('cur.id', 'coalesce(cur.pontuacao, 0) as pontuacao', 'dh_atualizacao'));
        $select->join(array('pal' => 'curriculos_palavras'), 'pal.id = cur.id', null);
        $select->join(array('cid' => 'cidades'), 'cid.id = cur.cidade_id', null);
        $select->joinLeft(array('cc' => 'cargos_curriculos'), 'cc.curriculo_id = cur.id', null);
        $select->joinLeft(array('car' => 'cargos'), 'car.id = cc.cargo_id', null);
        $select->joinLeft(array('are' => 'areas'), 'are.id = car.area_id', null);
        // status
        if (isset($filtros['status']) && $filtros['status'] != '') {
            $select->where('cur.ativo::text = ?', $filtros['status']);
        }
        // pontuação
        if (isset($filtros['pontuacao']) && $filtros['pontuacao'] != '') {
            if ($filtros['pontuacao'] == '1') {
                $select->where('cur.pontuacao is not null');
            } else {
                $select->where('cur.pontuacao is null');
            }
        }
        // data de atualização
        if (isset($filtros['data_atualizacao']) && Zend_Date::isDate($filtros['data_atualizacao'])) {
            $select->where('cur.dh_atualizacao::date >= ?', $filtros['data_atualizacao']);
        }
        // área
        if (isset($filtros['area_id']) && is_numeric($filtros['area_id'])) {
            $select->where('are.id = ?', $filtros['area_id']);
        }
        // cargo
        if (isset($filtros['cargo_id']) && is_numeric($filtros['cargo_id'])) {
            $select->where('car.id = ?', $filtros['cargo_id']);
        }
        // estado
        if (isset($filtros['estado_id']) && strlen($filtros['estado_id']) == 2) {
            $select->where('cid.uf = ?', $filtros['estado_id']);
        }
        // cidade
        if (isset($filtros['cidade_id']) && is_numeric($filtros['cidade_id'])) {
            $select->where('cid.id = ?', $filtros['cidade_id']);
        }
        // palavras chave
        if (isset($filtros['buscar']) && trim($filtros['buscar']) != '') {
            $select->where('pal.conteudo ILIKE(?)', '%' . trim($filtros['buscar']) . '%');
//            $where = $this->select();
//            if (is_numeric($filtros['buscar'])) {
//                $where->Where('cur.cpf::text ILIKE(?)', '%' . $filtros['buscar'] . '%');
//                $where->orWhere('cur.nome ILIKE(?)', '%' . $filtros['buscar'] . '%');
//                $where->orWhere('pal.conteudo ILIKE(?)', '%' . $filtros['buscar'] . '%');
//            } else {
//                $where->where('cur.nome ILIKE(?)', '%' . $filtros['buscar'] . '%');
//                $where->orWhere('pal.conteudo ILIKE(?)', '%' . $filtros['buscar'] . '%');
//            }
//            $select->where(implode($where->getPart(Zend_Db_Select::WHERE)));
        }
        $select->order('cur.dh_atualizacao desc');   //  ->order('cur.id desc');
        return $select;
    }

    /**
     * Verifica se um determinado currículo existe.
     *
     * @param int $id O id do currículo a ser verificado.
     * @return boolean
     */
    public function existeCurriculo($id)
    {
        if (!is_numeric($id)) {
            return false;
        }
        return $this->find($id)->current() != null;
    }

    public function existeEmail($email, $curriculo_id = null)
    {
        $select = $this->select()->where('email = ?', $email);
        $curriculo = $this->fetchRow($select);
        return ($curriculo && $curriculo->id != $curriculo_id);
    }

    public function existeCpf($cpf, $curriculo_id = null)
    {
        $select = $this->select()->where('cpf = ?', $cpf);
        $curriculo = $this->fetchRow($select);
        return ($curriculo && $curriculo->id != $curriculo_id);
    }

    public function removeFoto($curriculo_id)
    {
        $filename = realpath('.') . '/' . DIR_FOTOS . '/' . $curriculo_id;
        if (file_exists($filename)) {
            unlink($filename);
        }
    }

    public function salvaFoto($curriculo_id)
    {
        if (!$curriculo_id) {
            return;
        }
        if ($_FILES && isset($_FILES['foto']) && isset($_FILES['foto']['name']) && $_FILES['foto']['name'] != '') {
            $dir = Lib_Hd::setupDir(DIR_FOTOS);
            $tmp_name = substr($_FILES['foto']['tmp_name'], strrpos($_FILES['foto']['tmp_name'], '/') + 1);
            $src = Lib_UploadArea::getDir() . $tmp_name;
            $dst = "$dir{$curriculo_id}";
            copy($src, $dst);
            chmod($dst, 0777);
        }
    }

    public function listaParaBusca($ids)
    {
        if (!count($ids)) {
            return null;
        }
        foreach ($ids as $id) {
            if (!is_numeric($id)) {
                return null;
            }
        }
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array('cur' => $this->_name));
        $select->join(array('cid' => 'cidades'), 'cid.id = cur.cidade_id', array('cidade' => 'nome'));
        $select->join(array('est' => 'estados'), 'est.uf = cid.uf', array('estado' => 'nome', 'uf' => 'uf'));
        $select->where('cur.id in (?)', $ids);
        // ------------------------------------------------------------------------------------------------------------
        // Mandraquice
        // ------------------------------------------------------------------------------------------------------------
        // Explicação do código:
        //
        // Este método recebe uma lista de id's. Ex: 7, 14, 234, 5, 98...
        // Contudo, a ordem destes id's é extremamente relevante e deverá ser mantida.
        // O Postgres aceita um tipo de expressão no order by que permite isso. Mas, estranhamente, esta lista deve
        // ser invertida (não ouse me perguntar por que é assim... não faço ideia).
        // Desta forma, o order by deverá ficar assim: "order by id=98, id=5, id=234, id=14, id=7".
        // E é isso o que o código abaixo faz. Iverte o array de id's e adiciona o prefixo "cur.id=" aos elementos.
        // ------------------------------------------------------------------------------------------------------------
        $rids = array_reverse($ids);
        foreach ($rids as &$rid) {
            $rid = "cur.id=$rid";
        }
        $select->order(new Zend_Db_Expr(implode(',', $rids)));
        // ------------------------------------------------------------------------------------------------------------
        return $this->fetchAll($select);
    }

    public function porCargo($cargo_id, $quantidade)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('cr' => $this->_name), array('id', 'nome', 'data_nascimento', 'dh_atualizacao', 'pontuacao'))
                ->join(array('cc' => 'cargos_curriculos'), 'cc.curriculo_id = cr.id', array())
                ->where('cc.cargo_id = ?', (int) $cargo_id)
                ->where('cr.pontuacao is not null')
                ->order('cr.dh_atualizacao DESC')
                ->order('cr.nome ASC')
                ->limit($quantidade);

        return $this->fetchAll($select);
    }

    public function porLista($lista_id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('cr' => $this->_name), array('id', 'nome', 'data_nascimento', new Zend_Db_Expr('"cr"."dh_atualizacao"::date'), 'pontuacao'))
                ->join(array('lc' => 'listas_curriculos'), 'lc.curriculo_id = cr.id', array())
                ->where('lc.lista_id = ?', (int) $lista_id)
                ->order('cr.dh_atualizacao DESC')
                ->order('cr.nome ASC');

        return $this->fetchAll($select);
    }

    public function visualizar($id)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false)
                ->from(array('c' => $this->_name))
                ->join(array('geo_c' => 'cidades'), 'geo_c.id = c.cidade_id', array('cidade' => 'nome'))
                ->join(array('geo_e' => 'estados'), 'geo_c.uf = geo_e.uf', array('estado' => 'nome', 'uf'))
                ->join(array('e' => 'escolaridades'), 'e.id = c.escolaridade_id', array('escolaridade_nome' => 'nome'))
                ->where('c.id = ?', (int) $id);

        return $this->fetchRow($select);
    }

}

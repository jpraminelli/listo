<?php

class Curriculos_Model_Pesquisa
{

    const QUANTIDADE_LIMITE_SPHINX = 1000;

    private $sphinxUp = false;

    public function isSphinxUp()
    {
        return $this->sphinxUp;
    }

    public function processa($filtros)
    {
        if (!is_array($filtros) || !count($filtros)) {
            return;
        }

        //
        $palavras = (isset($filtros['buscar'])) ? '*' . trim($filtros['buscar']) . '*' : '';
        if (!$palavras) {
            return;
        }
        //
        $appini = Lib_Config_Ini::instance();
        $config = $appini->sphinx->toArray();
        require '../application/modules/curriculos/library/sphinxapi.php';
        $sphinx = new SphinxClient();
        $sphinx->SetServer($config['host'], (int) $config['port']);
        $sphinx->SetConnectTimeout(1);
        $sphinx->SetArrayResult(true);
        $sphinx->SetLimits(0, self::QUANTIDADE_LIMITE_SPHINX);
        $sphinx->SetMatchMode(SPH_MATCH_EXTENDED);
        $sphinx->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
        $sphinx->SetSortMode(SPH_SORT_EXTENDED, 'pontuacao DESC, estado_nome ASC, cidade_nome ASC, nome ASC');
        // status
        if (isset($filtros['status']) && $filtros['status'] != '') {
            $palavras .= ' ___ativo___' . $filtros['status'] . '___';
        }

        // pontua��o
        if (isset($filtros['pontuacao']) && $filtros['pontuacao'] != '') {
            if ($filtros['pontuacao'] == '1') {
                $palavras .= ' ___pontuacao___sim___';
            } else {
                $palavras .= ' ___pontuacao___n�o___';
            }
        }
        // data de atualiza��o
        if (isset($filtros['data_atualizacao']) && Zend_Date::isDate($filtros['data_atualizacao'])) {
            $timestamp = new Zend_Date($filtros['data_atualizacao']);
            $min = $timestamp->toValue();
            $max = time();
            if ($min > $max) {
                $min = $max;
            }
            $sphinx->SetFilterRange('dh_atualizacao', $min, $max);
        }
        // �rea
        if (isset($filtros['area_id']) && is_numeric($filtros['area_id'])) {
            $palavras .= ' ___area_id___' . $filtros['area_id'] . '___';
        }
        // cargo
        if (isset($filtros['cargo_id']) && is_numeric($filtros['cargo_id'])) {
            $palavras .= ' ___cargo_id___' . $filtros['cargo_id'] . '___';
        }
        // estado
        if (isset($filtros['estado_id']) && strlen($filtros['estado_id']) == 2) {
            $palavras .= ' ___estado_uf___' . $filtros['estado_id'] . '___';
        }
        // cidade
        if (isset($filtros['cidade_id']) && is_numeric($filtros['cidade_id'])) {
            $palavras .= ' ___cidade_id___' . $filtros['cidade_id'] . '___';
        }

//        $result = $sphinx->Query($palavras, 'sistema_padrao');
        $result = $sphinx->Query($palavras, Lib_Config_ini::instance()->sphinx->index);

//        p($palavras);
        //pe($sphinx->GetLastError());
        $this->sphinxUp = (strpos($sphinx->GetLastError(), 'errno=111,') === false);

        if (!$result && $this->sphinxUp) {
            return null;
        }

        $ids = array();

        if ($this->sphinxUp) {
            if (APPLICATION_ENV != 'production') {
                p('Pesquisa realizada atrav�s do Sphinx.');
            }
            // Pesquisa realizada com sucesso usando o sphinx
            if (isset($result['matches']) && is_array($result['matches'])) {
                foreach ($result['matches'] as $docinfo) {
                    $ids[] = $docinfo['id'];
                }
            }
        }

        return $ids;
    }

    /**
     * //TODO: Remover este m�todo quando o m�todo acima estiver conclu�do.
     * 
     * Executa uma pesquisa atrav�s do Sphinx.
     *
     * @param string $argumentos O que o usu�rio est� procurando.
     * @return array Uma lista com os id's dos curr�culos que se encaixam na pesquisa.
     */
    public function processa_old($argumentos, $pagina = 1, $quantidade = 15)
    {
        if (!$argumentos) {
            return null;
        }
        // Verifica se a consulta j� foi realizada (pega os ids da sess�o neste caso)
        $session = Lib_Session_Namespace::instance();
        if ($session->Curriculos_Model_Pesquisa__argumentos == $argumentos) {
            $allids = $session->Curriculos_Model_Pesquisa__allids;
        } else {
            $session->Curriculos_Model_Pesquisa__argumentos = $argumentos;
            $session->Curriculos_Model_Pesquisa__allids = null;
            $session->Curriculos_Model_Pesquisa__total = 0;
            $appini = Lib_Config_Ini::instance();
            $config = $appini->sphinx->toArray();
            require '../application/modules/curriculos/library/sphinxapi.php';
            $sphinx = new SphinxClient();
            $sphinx->SetServer($config['host'], (int) $config['port']);
            $sphinx->SetConnectTimeout(1);
            $sphinx->SetArrayResult(true);
            $sphinx->SetLimits(0, self::QUANTIDADE_LIMITE_SPHINX);
            $sphinx->SetMatchMode(SPH_MATCH_EXTENDED);
            $sphinx->SetRankingMode(SPH_RANK_PROXIMITY_BM25);
            $sphinx->SetSortMode(SPH_SORT_EXTENDED, 'pontuacao DESC, estado ASC, cidade ASC, nome ASC');
//            $sphinx->SetFilter('pontuacao', array(9));
            $result = $sphinx->Query($argumentos, 'agfengenharia');
            $sphinx_up = (strpos($sphinx->GetLastError(), 'errno=111,') === false);
            if (!$result && $sphinx_up) {
                return null;
            }
            $allids = array();
            if ($sphinx_up) {
                // Pesquisa realizada com sucesso usando o sphinx
                if (isset($result['matches']) && is_array($result['matches'])) {
                    foreach ($result['matches'] as $docinfo) {
                        $allids[] = $docinfo['id'];
                    }
                }
            } else {
                // Pesquisa N�O REALIZADA com o sphinx. Ser� feito uma consulta diretamente no
                //      banco de dados utilizando o like.
                // Al�m de ser �til para os desenvolvedores que n�o est�o com o sphinx instalado
                //      e configurado em suas m�quinas, ser� um plano de conting�ncia caso haja
                //      problemas no ambiente de produ��o.
                // Esta pesquisa dever� ser bem mais simples do que a realizada pelo sphinx.
                //      � mais um quebra-galho. E n�o uma varia��o da pesquisa principal que ter�
                //      toda a funcionalidade re-implementada.
                $tableCurriculosPalavras = new Curriculos_Model_DbTable_CurriculosPalavras();
                $result = $tableCurriculosPalavras->pesquisar($argumentos);
                if (!$result) {
                    return null;
                }
                foreach ($result as $curriculo) {
                    $allids[] = $curriculo->id;
                }
            }
            $session->Curriculos_Model_Pesquisa__allids = $allids;
            $session->Curriculos_Model_Pesquisa__total = count($allids);
        }
        if (!count($allids)) {
            return null;
        }
        // Separa o range de curr�culos baseado na p�gina e na quantidade por p�gina
        $offset = ($pagina - 1) * $quantidade;
        if ($offset > count($allids)) {
            return null;
        }
        $ids = array_slice($allids, $offset, $quantidade);
        $tableCurriculos = new Curriculos_Model_DbTable_Curriculos();
        $curriculos = $tableCurriculos->listaParaBusca($ids);
        return $curriculos;
    }

}

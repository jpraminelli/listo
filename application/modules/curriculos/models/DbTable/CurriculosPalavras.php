<?php

class Curriculos_Model_DbTable_CurriculosPalavras extends Zend_Db_Table_Abstract
{

    protected $_name = 'curriculos_palavras';

    /**
     * Atualiza o texto que será posteriormente usado pelo Sphinx nas pesquisas.
     * 
     * Basicamente, toda a informação em forma de texto que foi cadastrada para o currículo (incluindo seus anexos)
     * é cadastrada no campo 'conteudo' da tabela 'curriculos_palavras', sem uma formatação específica. O que importa
     * são somente as palavras e as sequências de caracteres. 
     * 
     * Esta informação será, via agendamento na CRON, lida pelo Sphinx de tempos em tempos para re-criar o índice onde 
     * serão realizadas as buscas.
     * 
     * @param int $curriculo_id
     * @return void 
     */
    public function atualiza($curriculo_id)
    {
        if (!$curriculo_id) {
            return;
        }
        $curriculoTable = new Curriculos_Model_DbTable_Curriculos();
        $curriculo = $curriculoTable->find($curriculo_id)->current();
        if (!$curriculo) {
            return;
        }
        $curriculoPalavras = $this->find($curriculo_id)->current(); // o ID é o mesmo do utilizado no currículo (relação 1 para 1)
        if (!$curriculoPalavras) {
            $curriculoPalavras = $this->createRow();
            $curriculoPalavras->id = $curriculo_id;
        }
        $curriculoPalavras->conteudo = $curriculo->getPalavras();
        $curriculoPalavras->dh_atualizacao = date('Y-m-d H:i:s');
        $curriculoPalavras->save();
    }

    /**
     * Este método será utilizado como alternativa para as pesquisa, caso o Sphinx esteja fora do ar.
     * Evidentemente, ele não terá todo o poder de fogo do Sphinx e deverá ser usado somente como um quebra-galho.
     * 
     * @param string $argumentos Palavra chave.
     * @return array Lista dos currículos encontrados (contendo somente o campo 'id'). 
     */
    public function pesquisar($argumentos)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array('pal' => $this->_name), 'id');
        $select->join(array('cur' => 'curriculos'), 'cur.id = pal.id');
        $select->where('conteudo ilike ?', "%$argumentos%");
        $select->order('cur.pontuacao');
        return $this->fetchAll($select);
    }

}

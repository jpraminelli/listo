<?php

class Curriculos_Model_DbTable_CurriculosPalavras extends Zend_Db_Table_Abstract
{

    protected $_name = 'curriculos_palavras';

    /**
     * Atualiza o texto que ser� posteriormente usado pelo Sphinx nas pesquisas.
     * 
     * Basicamente, toda a informa��o em forma de texto que foi cadastrada para o curr�culo (incluindo seus anexos)
     * � cadastrada no campo 'conteudo' da tabela 'curriculos_palavras', sem uma formata��o espec�fica. O que importa
     * s�o somente as palavras e as sequ�ncias de caracteres. 
     * 
     * Esta informa��o ser�, via agendamento na CRON, lida pelo Sphinx de tempos em tempos para re-criar o �ndice onde 
     * ser�o realizadas as buscas.
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
        $curriculoPalavras = $this->find($curriculo_id)->current(); // o ID � o mesmo do utilizado no curr�culo (rela��o 1 para 1)
        if (!$curriculoPalavras) {
            $curriculoPalavras = $this->createRow();
            $curriculoPalavras->id = $curriculo_id;
        }
        $curriculoPalavras->conteudo = $curriculo->getPalavras();
        $curriculoPalavras->dh_atualizacao = date('Y-m-d H:i:s');
        $curriculoPalavras->save();
    }

    /**
     * Este m�todo ser� utilizado como alternativa para as pesquisa, caso o Sphinx esteja fora do ar.
     * Evidentemente, ele n�o ter� todo o poder de fogo do Sphinx e dever� ser usado somente como um quebra-galho.
     * 
     * @param string $argumentos Palavra chave.
     * @return array Lista dos curr�culos encontrados (contendo somente o campo 'id'). 
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

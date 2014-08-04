<?php

class Curriculos_Model_DbRow_Curriculo extends Zend_Db_Table_Row_Abstract
{

    public function fmt_cpf()
    {
        $cpf = str_pad($this->cpf, 11, '0', STR_PAD_LEFT);
        $cpf = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
        return $cpf;
    }

    public function fmt_pretensao_salarial()
    {
        return 'R$ ' . number_format($this->pretensao_salarial, 2, ',', '.');
    }

    public function fmt_data_nascimento()
    {
        if ($this->data_nascimento) {
            $data = new Zend_Date($this->data_nascimento);
            return substr($data, 0, 10);
        }
        return '';
    }

    public function fmt_dh_cadastro()
    {
        if ($this->dh_cadastro) {
            $data_hora = new Zend_Date($this->dh_cadastro);
            return substr($data_hora, 0, 16);
        }
        return '';
    }

    public function fmt_dh_atualizacao()
    {
        if ($this->dh_atualizacao) {
            $data_hora = new Zend_Date($this->dh_atualizacao);
            return substr($data_hora, 0, 16);
        }
        return '';
    }

    public function fmt_cidade()
    {
        if (isset($this->cidade) && isset($this->estado)) {
            return "$this->cidade - $this->uf";
        }
        return '';
    }

    /**
     * Retorna uma lista dos cargos relacionados ao currículo
     * @return string 
     */
    public function getCargos()
    {
        if (!$this->id) {
            return '';
        }
        $cargosCurriculosTable = new Curriculos_Model_DbTable_CargosCurriculos();
        $cargos = $cargosCurriculosTable->arrayPorCurriculo($this->id);
        return implode('<br />', $cargos);
    }

    public function thumbUrl()
    {
        //TODO: Implementar trava nas dimensões da imagem
        $filename = realpath('.') . '/' . DIR_FOTOS . '/' . $this->id;
        if (file_exists($filename)) {
            return WWWROOT . 'tt.php?src=' . WWWROOT . DIR_FOTOS . '/' . $this->id;
        } else {
            return null;
        }
    }

    /**
     * Retorna uma "composição" de toda a informação em forma de texto cadastrada para o currículo e todos os seus anexos.
     */
    public function getPalavras()
    {
        if (!$this->id) {
            return ''; // deverá funcionar apenas para currículos já cadastrados.
        }
        $palavras = array();
        // informação do currículo
        $palavras[] = $this->cpf;
        $palavras[] = $this->fmt_cpf();
        $palavras[] = $this->nome;
        $palavras[] = $this->email;
        $palavras[] = $this->fmt_data_nascimento();
        $palavras[] = number_format($this->pretensao_salarial, 2, ',', '.');
        $palavras[] = $this->observacoes_gerais;
        $palavras[] = $this->fmt_dh_cadastro();
        $palavras[] = $this->fmt_dh_atualizacao();
        if ($this->ativo) {
            $palavras[] = "___ativo___true___";
        } else {
            $palavras[] = "___ativo___false___";
        }
        if ($this->pontuacao !== null) {
            $palavras[] = "___pontuacao___sim___";
        } else {
            $palavras[] = "___pontuacao___não___";
        }
        // cidade, estado e uf
        $cidadesTable = new Geo_Model_DbTable_Cidades();
        $cidade = $cidadesTable->getInfo($this->cidade_id);
        if ($cidade) {
            $palavras[] = $cidade['nome'];
            $palavras[] = $cidade['estado'];
            $palavras[] = $cidade['uf'];
            $palavras[] = "___estado_uf___{$cidade['uf']}___";
            $palavras[] = "___cidade_id___{$this->cidade_id}___";
        }
        // telefones
        $telefonesTable = new Curriculos_Model_DbTable_Telefones();
        $telefones = $telefonesTable->listaPorCurriculo($this->id);
        foreach ($telefones as $telefone) {
            $palavras[] = $telefone->getPalavras();
        }
        // cargos pretendidos
        $cargosCurriculosTable = new Curriculos_Model_DbTable_CargosCurriculos();
        $cargosCurriculos = $cargosCurriculosTable->listaPorCurriculo($this->id);
        foreach ($cargosCurriculos as $cargoCurriculo) {
            $palavras[] = $cargoCurriculo->getPalavras();
        }
        // experiência profissional
        $experienciasTable = new Curriculos_Model_DbTable_Experiencias();
        $experiencias = $experienciasTable->listaPorCurriculo($this->id);
        foreach ($experiencias as $experiencia) {
            $palavras[] = $experiencia->getPalavras();
        }
        // anexos
        $anexosTable = new Curriculos_Model_DbTable_Anexos();
        $anexos = $anexosTable->listaPorCurriculo($this->id);
        foreach ($anexos as $anexo) {
            $palavras[] = $anexo->getPalavras();
        }
        // notas
        $notasTable = new Curriculos_Model_DbTable_Notas();
        $notas = $notasTable->listaPorCurriculo($this->id);
        foreach ($notas as $nota) {
            $palavras[] = $nota->getPalavras();
        }
        return implode(' ', $palavras);
    }

}

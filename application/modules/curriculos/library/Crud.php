<?php

class Curriculos_Library_Crud extends Lib_Controller_Crud
{

    // Requisitos da Lib_Controller_Crud
    protected $_indexUrl = '';
    protected $_indexActionTitle = 'Administração de currículos';
    protected $_formActionTitleNew = 'Novo currículo';
    protected $_formActionTitleEdit = 'Editando currículo';
    protected $_usarListaPaginada = true;
    protected $_modelClass = 'Curriculos_Model_DbTable_Curriculos';
    protected $_formClass = 'Curriculos_Form_Curriculo';
    protected $_formFilterClass = 'Curriculos_Form_Filtros';
    // Utilizado para o desmembramento das informações do post no momento da gravação do form
    protected $_flag_remover_foto = false;
    protected $_telefones = null;
    protected $_telefones_para_remover = null;
    protected $_cargos = null;
    protected $_cargos_para_remover = null;
    protected $_escolaridades = null;
    protected $_escolaridades_para_remover = null;
    protected $_cursos = null;
    protected $_cursos_para_remover = null;
    protected $_experiencias = null;
    protected $_experiencias_para_remover = null;
    protected $_anexos = null;
    protected $_anexos_para_remover = null;
    protected $_notas = null;
    protected $_notas_para_remover = null;
    // DbTables dos registros dependentes
    protected $_cidadesTable = null;
    protected $_telefonesTable = null;
    protected $_cargosCurriculosTable = null;
    protected $_escolaridadesTable = null;
    protected $_experienciasTable = null;
    protected $_anexosTable = null;
    //
    protected $_cargosTable = null;

    public function init()
    {
        parent::init();
        $this->_cidadesTable = new Geo_Model_DbTable_Cidades();
        $this->_telefonesTable = new Curriculos_Model_DbTable_Telefones();
        $this->_cargosCurriculosTable = new Curriculos_Model_DbTable_CargosCurriculos();
        $this->_escolaridadesTable = new Curriculos_Model_DbTable_CurriculosEscolaridades();
        $this->_cursosTable = new Curriculos_Model_DbTable_CurriculosCursos();
        $this->_experienciasTable = new Curriculos_Model_DbTable_Experiencias();
        $this->_anexosTable = new Curriculos_Model_DbTable_Anexos();
        if (IN_BACKEND) {
            $this->_notasTable = new Curriculos_Model_DbTable_Notas();
        }
        $this->_cargosTable = new Curriculos_Model_DbTable_Cargos();
    }

    public function adicionarTelefoneAction()
    {
        $form = new Curriculos_Form_CurriculoTelefone();
        die(utf8_encode($form->render()));
    }

    public function adicionarCargoAction()
    {
        $form = new Curriculos_Form_CurriculoCargo();
        die(utf8_encode($form->render()));
    }

    public function adicionarExperienciaAction()
    {
        $form = new Curriculos_Form_CurriculoExperiencia();
        die(utf8_encode($form->render()));
    }

    public function adicionarAnexoAction()
    {
        $form = new Curriculos_Form_CurriculoAnexo();
        die(utf8_encode($form->render()));
    }

    public function adicionarNotaAction()
    {
        $form = new Curriculos_Form_CurriculoNota();
        die(utf8_encode($form->render()));
    }

    public function listaComboCargosAction()
    {
        $area_id = (int) $this->getRequest()->getParam('area');
        $cargosTable = new Curriculos_Model_DbTable_Cargos();
        $lista = $cargosTable->listaCombo($area_id);
        // Garante que a ordem dos itens será mantida em browsers como Chrome ou Opera,
        // utilizando um indice incremental.
        $cargos = array();
        $i = 1;
        foreach ($lista as $id => $item) {
            $cargos[$i] = array('id' => $id, 'nome' => $item);
            $i++;
        }
        //
        die(Lib_Json::encode($cargos));
    }

    protected function afterFind(&$values)
    {
        // Formata o CPF
        $values['cpf'] = $this->_record->fmt_cpf();

        // Formata a data de nascimento
        $values['data_nascimento'] = $this->_record->fmt_data_nascimento();

        // Agrega a informação do estado (relacionado à cidade - para popular o combo)
        $values['estado_id'] = $this->_cidadesTable->getUf($values['cidade_id']);

        // Agrega a informação dos telefones
        $telefones = $this->_telefonesTable->listaPorCurriculo($values['id']);
        foreach ($telefones->toArray() as $telefone) {
            $values['telefones'][$telefone['id']] = $telefone;
        }

        // Agrega a informação dos cargos
        $cargosCurriculos = $this->_cargosCurriculosTable->listaPorCurriculo($values['id']);
        foreach ($cargosCurriculos->toArray() as $cargoCurriculo) {
            $cargoCurriculo['area_id'] = $this->_cargosTable->getArea($cargoCurriculo['cargo_id']);
            $values['cargos'][$cargoCurriculo['id']] = $cargoCurriculo;
        }

        // Agrega a informação das experiências anteriores
        $escolaridades = $this->_escolaridadesTable->listaPorCurriculo($values['id']);
        foreach ($escolaridades->toArray() as $escolaridade) {
            $values['escolaridades'][$escolaridade['id']] = $escolaridade;
        }

        // Agrega a informação das experiências anteriores
        $cursos = $this->_cursosTable->listaPorCurriculo($values['id']);
        foreach ($cursos->toArray() as $curso) {
            $values['cursos'][$curso['id']] = $curso;
        }

        // Agrega a informação das experiências anteriores
        $experiencias = $this->_experienciasTable->listaPorCurriculo($values['id']);
        foreach ($experiencias->toArray() as $experiencia) {
            $values['experiencias'][$experiencia['id']] = $experiencia;
        }

        // Agrega a informação dos anexos
        $anexos = $this->_anexosTable->listaPorCurriculo($values['id']);
        foreach ($anexos->toArray() as $anexo) {
            $values['anexos'][$anexo['id']] = $anexo;
        }

        if (IN_BACKEND) {
            // Agrega a informação das notas
            $notas = $this->_notasTable->listaPorCurriculo($values['id']);
            foreach ($notas->toArray() as $nota) {
                $values['notas'][$nota['id']] = $nota;
            }
        }

        $values['disponibilidade_todas_regioes'] = (int) $values['disponibilidade_todas_regioes'];
        $values['disponibilidade_viagens'] = (int) $values['disponibilidade_viagens'];
    }

    protected function beforeSave(&$values)
    {
        // Desmembra o form.
        // Remove os itens correspondentes aos subforms para poder tratá-los em separado.
        if (isset($values['telefones'])) {
            $this->_telefones = $values['telefones'];
            unset($values['telefones']);
        }
        if (isset($values['telefones_para_remover'])) {
            $this->_telefones_para_remover = explode(' ', trim($values['telefones_para_remover']));
            unset($values['telefones_para_remover']);
        }
        if (isset($values['cargos'])) {
            $this->_cargos = $values['cargos'];
            unset($values['cargos']);
        }
        if (isset($values['cargos_para_remover'])) {
            $this->_cargos_para_remover = explode(' ', trim($values['cargos_para_remover']));
            unset($values['cargos_para_remover']);
        }
        if (isset($values['escolaridades'])) {
            $this->_escolaridades = $values['escolaridades'];
            unset($values['escolaridades']);
        }
        if (isset($values['escolaridades_para_remover'])) {
            $this->_escolaridades_para_remover = explode(' ', trim($values['escolaridades_para_remover']));
            unset($values['escolaridades_para_remover']);
        }
        if (isset($values['cursos'])) {
            $this->_cursos = $values['cursos'];
            unset($values['cursos']);
        }
        if (isset($values['cursos_para_remover'])) {
            $this->_cursos_para_remover = explode(' ', trim($values['cursos_para_remover']));
            unset($values['cursos_para_remover']);
        }
        if (isset($values['experiencias'])) {
            $this->_experiencias = $values['experiencias'];
            unset($values['experiencias']);
        }
        if (isset($values['experiencias_para_remover'])) {
            $this->_experiencias_para_remover = explode(' ', trim($values['experiencias_para_remover']));
            unset($values['experiencias_para_remover']);
        }
        if (isset($values['anexos'])) {
            $this->_anexos = $values['anexos'];
            unset($values['anexos']);
        }
        if (isset($values['anexos_para_remover'])) {
            $this->_anexos_para_remover = explode(' ', trim($values['anexos_para_remover']));
            unset($values['anexos_para_remover']);
        }
        if (IN_BACKEND) {
            // Se a pontuação estiver vazia, seta para nulo (zeros e nulos tem relevância diferente neste caso)
            if (isset($values['pontuacao']) && $values['pontuacao'] == '') {
                $values['pontuacao'] = null;
            }
            //
            if (isset($values['notas'])) {
                $this->_notas = $values['notas'];
                unset($values['notas']);
            }
            if (isset($values['notas_para_remover'])) {
                $this->_notas_para_remover = explode(' ', trim($values['notas_para_remover']));
                unset($values['notas_para_remover']);
            }
        } else {
            // Está no front-end, então, previne 'acidentes' com campos que o usuário comum não pode editar.
            if (isset($values['notas'])) {
                unset($values['notas']);
            }
            if (isset($values['notas_para_remover'])) {
                unset($values['notas_para_remover']);
            }
            if (isset($values['pontuacao'])) {
                unset($values['pontuacao']);
            }
        }

        // Senha
        if ($values['senha']) {
            $values['senha'] = md5($values['senha']);
        } else {
            unset($values['senha']);
        }
        unset($values['senha_confirmacao']);

        // Foto
        unset($values['foto']);
        $this->_flag_remover_foto = (bool) ($values['flag_remover_foto'] == '1');
        unset($values['flag_remover_foto']);

        // Remove o CPF para não ser salvo
        unset($values['cpf']);

        // Estado e cidade
        unset($values['estado_id']);

        // Pretensão salarial
        $values['pretensao_salarial'] = str_replace('.', '', $values['pretensao_salarial']);
        $values['pretensao_salarial'] = str_replace(',', '.', $values['pretensao_salarial']);

        // Data de atualização
        $values['dh_atualizacao'] = date('Y-m-d H:i:s');
    }

    protected function afterSave(&$values)
    {
        // ----------------------------------------------------------------------------------------
        // Foto
        // ----------------------------------------------------------------------------------------
        if ($this->_flag_remover_foto) {
            $this->_model->removeFoto($values['id']);
        }

        $this->_model->salvaFoto($values['id']);

        // ----------------------------------------------------------------------------------------
        // Processa as eventuais inclusões e alterações dos registros dependentes
        // ----------------------------------------------------------------------------------------
        // salva os telefones
        if (is_array($this->_telefones)) {
            foreach ($this->_telefones as $telefone) {
                $telefone['curriculo_id'] = $values['id'];
                $this->_telefonesTable->save($telefone);
            }
        }
        // salva os cargos
        if (is_array($this->_cargos)) {
            foreach ($this->_cargos as $cargo) {
                $cargo['curriculo_id'] = $values['id'];
                $this->_cargosCurriculosTable->save($cargo);
            }
        }
        // salva as escolaridades
        if (is_array($this->_escolaridades)) {
            foreach ($this->_escolaridades as $escolaridade) {
                $escolaridade['curriculo_id'] = $values['id'];
                $this->_escolaridadesTable->save($escolaridade);
            }
        }
        // salva os cursos
        if (is_array($this->_cursos)) {
            foreach ($this->_cursos as $curso) {
                $curso['curriculo_id'] = $values['id'];
                $this->_cursosTable->save($curso);
            }
        }
        // salva as experiências
        if (is_array($this->_experiencias)) {
            foreach ($this->_experiencias as $experiencia) {
                $experiencia['curriculo_id'] = $values['id'];
                $this->_experienciasTable->save($experiencia);
            }
        }
        // salva os anexos
        if (is_array($this->_anexos)) {
            foreach ($this->_anexos as $anexo) {
                $anexo['curriculo_id'] = $values['id'];
                $this->_anexosTable->save($anexo);
            }
        }
        if (IN_BACKEND) {
            // salva as notas
            if (is_array($this->_notas)) {
                foreach ($this->_notas as $nota) {
                    $nota['curriculo_id'] = $values['id'];
                    $this->_notasTable->save($nota);
                }
            }
        }
        // ----------------------------------------------------------------------------------------
        // Processa as eventuais exclusões dos registros dependentes
        // ----------------------------------------------------------------------------------------
        // Processa os telefones removidos
        foreach ($this->_telefones_para_remover as $telefone_id) {
            if (is_numeric($telefone_id)) {
                $this->_telefonesTable->remove($telefone_id);
            }
        }
        // Processa os cargos removidos
        foreach ($this->_cargos_para_remover as $cargo_curriculo_id) {
            if (is_numeric($cargo_curriculo_id)) {
                $this->_cargosCurriculosTable->remove($cargo_curriculo_id);
            }
        }
        // Processa as escolaridades removidas
        foreach ($this->_escolaridades_para_remover as $escolaridade_id) {
            if (is_numeric($escolaridade_id)) {
                $this->_escolaridadesTable->remove($escolaridade_id);
            }
        }
        // Processa as cursos removidas
        foreach ($this->_cursos_para_remover as $curso_id) {
            if (is_numeric($curso_id)) {
                $this->_cursosTable->remove($curso_id);
            }
        }
        // Processa as experiências removidas
        foreach ($this->_experiencias_para_remover as $experiencia_id) {
            if (is_numeric($experiencia_id)) {
                $this->_experienciasTable->remove($experiencia_id);
            }
        }
        // Processa os anexos removidos
        foreach ($this->_anexos_para_remover as $anexo_id) {
            if (is_numeric($anexo_id)) {
                $this->_anexosTable->remove($anexo_id);
            }
        }
        if (IN_BACKEND) {
            // Processa as notas removidas
            foreach ($this->_notas_para_remover as $nota_id) {
                if (is_numeric($nota_id)) {
                    $this->_notasTable->remove($nota_id);
                }
            }
        }
        // ----------------------------------------------------------------------------------------
        // Processa as palavras (que serão posteriormente utilizadas para indexação)
        // ----------------------------------------------------------------------------------------
        $curriculosPalavras = new Curriculos_Model_DbTable_CurriculosPalavras();
        $curriculosPalavras->atualiza($values['id']);
    }

}

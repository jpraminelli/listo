<?php

class Curriculos_Model_Cron
{

    public function executa()
    {
        /*
         * A quantidade em dias que define quando um currículo deverá ser
         * automaticamente desativado por ser considerado 'abandonado'.
         * 
         * Se a data de atualização do currículo ocorreu a mais de
         * CURRICULOS_VALIDADE_DIAS_INATIVA dias, o currículo será desativado.
         */
        if (!defined('CURRICULOS_VALIDADE_DIAS_INATIVA')) {
            define('CURRICULOS_VALIDADE_DIAS_INATIVA', 180);
        }

        /*
         * A quantidade em dias que define quando o usuário deverá ser 
         * notificado via e-mail para acessar o site e atualizar a informação 
         * do seu currículo.
         * 
         * Se a data de atualização do currículo ocorreu a mais de
         * CURRICULOS_VALIDADE_DIAS_ENVIO_EMAIL dias, o e-mail será enviado.
         */
        if (!defined('CURRICULOS_VALIDADE_DIAS_ENVIO_EMAIL')) {
            define('CURRICULOS_VALIDADE_DIAS_ENVIO_EMAIL', 120);
        }

        //dispara emails para os curriculos vencidos
        $this->curriculos_vencidos();

        //dispara emails para os curriculos prestes a vencer
        $this->curriculos_a_vencer();

        die('sucesso');
    }

    /**
     * DISPARA EMAIL PARA CANDIDATOS COM CURRICULOS QUE ATINGIRAM X (CONFIGURAVEL) DIAS DESATUALIZADO
     * ATUALIZA O STATUS PARA FALSE
     * CRIA UM LOG 
     * 
     * @author joao paulo raminelli
     */
    private function curriculos_vencidos()
    {
        $_Curriculos = new Curriculos_Model_DbTable_Curriculos();
        $_Notas = new Curriculos_Model_DbTable_Notas();

        //adaptador
        $db = $_Curriculos->getAdapter();

        //consulta os curriculos inativos
        $curriculos = $db->fetchAll("SELECT id,nome,email,TO_CHAR(dh_atualizacao,'DD/MM/YYYY HH24:MI:SS') AS dh_atualizacao FROM curriculos WHERE dh_atualizacao <=  ( now() - INTERVAL '" . CURRICULOS_VALIDADE_DIAS_INATIVA . " DAYS' ) AND ativo = true ");

        //config
        $config = Lib_Config_Ini::instance()->emails->from;

        //email
        $magicMail = new Lib_Mail();

        //view
        $view = new Zend_View();
        $view->setScriptPath(APPLICATION_PATH . "/modules/curriculos/views/scripts/templates/");

        foreach ($curriculos as $key => $value) {

            $view->assign("candidato", $value['nome'])
                ->assign("ultima_atualização", $value['dh_atualizacao']);

            $conteudoEmail = $view->render("curriculos-vencidos.phtml");

            //atualiza a flag ativo do curriculo para false
            $data = array('ativo' => 'false');
            $where = 'id =' . $value['id'];
            $_Curriculos->update($data, $where);

            //adiciona um log na tabela nota
            $_Notas->adicionarLogSistema($value['id'], 'Currículo foi automaticamente marcado como inativo. Sua última atualização foi em ' . $value['dh_atualizacao']);

            //envia o email
            $magicMail->enviarEmail($config->address, $config->name, $value['email'], $value['nome'], $config->name . ' Seu curriculo foi desativado', $conteudoEmail);
        }
    }

    /**
     * DISPARA EMAIL PARA CANDIDATOS COM CURRICULOS QUE ESTÃO PRESTES A FICAR INATIVO
     * CRIA UM LOG 
     * 
     * @author joao paulo raminelli
     */
    private function curriculos_a_vencer()
    {
        $_Curriculos = new Curriculos_Model_DbTable_Curriculos();
        $_Notas = new Curriculos_Model_DbTable_Notas();

        //adaptador
        $db = $_Curriculos->getAdapter();

        //consulta os curriculos a vencer
        $curriculos = $db->fetchAll("SELECT id,nome,email,TO_CHAR(dh_atualizacao,'DD/MM/YYYY HH24:MI:SS') AS dh_atualizacao FROM curriculos WHERE dh_atualizacao <=  ( now() - INTERVAL '" . CURRICULOS_VALIDADE_DIAS_ENVIO_EMAIL . " DAYS' ) AND ativo = true ");

        //config
        $config = Lib_Config_Ini::instance()->emails->from;

        //email
        $magicMail = new Lib_Mail();

        //view
        $view = new Zend_View();
        $view->setScriptPath(APPLICATION_PATH . "/modules/curriculos/views/scripts/templates/");

        foreach ($curriculos as $key => $value) {

            $view->assign("candidato", $value['nome'])
                ->assign("ultima_atualização", $value['dh_atualizacao']);

            $conteudoEmail = $view->render("curriculos-a-vencer.phtml");

            //adiciona um log na tabela nota
            $_Notas->adicionarLogSistema($value['id'], 'Enviado e-mail padrão para ' . $value['email'] . ' com uma chamada para atualização dos dados do currículo. Sua última atualização foi em ' . $value['dh_atualizacao']);

            //envia o email
            $magicMail->enviarEmail($config->address, $config->name, $value['email'], $value['nome'], $config->name . 'Atualize seu curriculo', $conteudoEmail);
        }
    }

}

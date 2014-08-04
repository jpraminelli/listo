<?php

class Default_Model_Cron
{

    public function executa()
    {
        // Executa as tarefas agendadas do módulo de currículos.
        $modelCurriculosCron = new Curriculos_Model_Cron();
        $modelCurriculosCron->executa();
    }

}

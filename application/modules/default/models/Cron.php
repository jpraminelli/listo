<?php

class Default_Model_Cron
{

    public function executa()
    {
        // Executa as tarefas agendadas do m�dulo de curr�culos.
        $modelCurriculosCron = new Curriculos_Model_Cron();
        $modelCurriculosCron->executa();
    }

}

<?php

require_once 'Zend/Validate/Abstract.php';

/**
 * Validador para fazer a validação de CPF (Cadastro de Pessoas fisica)
 *
 * @author Diego Tremper <diegotremper@gmail.com>
 */
class Lib_Validate_Cpf extends Zend_Validate_Abstract
{

    const INVALID_DIGITS = 'i_number';
    const INVALID_FORMAT = 'i_format';

    protected $_messageTemplates = array(
        self::INVALID_DIGITS => "O CPF \"%value%\" não é válido",
        self::INVALID_FORMAT => "O formato do CPF \"%value%\" não é válido"
    );
    private $_pattern = '/(\d{3})\.(\d{3})\.(\d{3})-(\d{2})/i';
    private $_skipFormat = false;
    private $_invalidDigits = array(
        '00000000000',
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999',
    );

    /**
     * Inicializa a instância do validador
     *
     * @param bool $skipFormat fazer validaçãoo no formato?
     */
    public function __construct($skipFormat = false)
    {
        $this->_skipFormat = $skipFormat;
    }

    /**
     * verifica se o cpf é válido
     *
     * @param string $value cpf a ser validado
     * @return bool
     */
    public function isValid($value)
    {
        $this->_setValue($value);

        if (!$this->_skipFormat && preg_match($this->_pattern, $value) == false) {
            $this->_error(self::INVALID_FORMAT);
            return false;
        }

        $digits = preg_replace('/[^\d]+/i', '', $value);

        if (strlen($digits) != 11) {
            $this->_error(self::INVALID_FORMAT);
            return false;
        }

        $firstSum = 0;
        $secondSum = 0;

        /*
         * TODO: implementar os CPF inválidos que são validados nesse algorítmo (00000000000, 11111111111, etc)
         * 
         */
        if (in_array($digits, $this->_invalidDigits)) {
            $this->_error(self::INVALID_DIGITS);
            return false;
        }

        for ($i = 0; $i < 9; $i++) {
            $firstSum += $digits[$i] * (10 - $i);
            $secondSum += $digits[$i] * (11 - $i);
        }

        $firstDigit = 11 - fmod($firstSum, 11);

        if ($firstDigit >= 10) {
            $firstDigit = 0;
        }

        $secondSum = $secondSum + ($firstDigit * 2);
        $secondDigit = 11 - fmod($secondSum, 11);

        if ($secondDigit >= 10) {
            $secondDigit = 0;
        }

        if (substr($digits, -2) != ($firstDigit . $secondDigit)) {
            $this->_error(self::INVALID_DIGITS);
            return false;
        }

        return true;
    }

}


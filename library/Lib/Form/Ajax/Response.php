<?php

class Lib_Form_Ajax_Response
{

    public static function ok()
    {
        return Lib_Json::encode(array('code' => 'OK'));
    }

    public static function fillError($form)
    {
        $response = array('code' => 'FILL_ERROR');
        $response['errors'] = $form->getMessages();

        return Lib_Json::encode($response);
    }

    public static function generalError($message)
    {
        return Lib_Json::encode(array('code' => 'GENERAL_ERROR', 'message' => $message));
    }

}
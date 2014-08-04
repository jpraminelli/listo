<?php

class Lib_FlashMessage
{

    const MESSAGE_INFO_SESSION_KEY = 'Message::info';
    const MESSAGE_SUCCESS_SESSION_KEY = 'Message::success';
    const MESSAGE_ERROR_SESSION_KEY = 'Message::error';
    const HIGHLIGHT_ITEM_SESSION_KEY = 'highlight::item';

    public static function info($message)
    {
        self::addMessage($message, self::MESSAGE_INFO_SESSION_KEY);
    }

    public static function success($message)
    {
        self::addMessage($message, self::MESSAGE_SUCCESS_SESSION_KEY);
    }

    public static function error($message)
    {
        self::addMessage($message, self::MESSAGE_ERROR_SESSION_KEY);
    }

    private static function addMessage($message, $key)
    {
        $session = Lib_Session_Namespace::instance();
        if (!is_array($session->{$key})) {
            $session->{$key} = array();
        }
        $session->{$key}[] = $message;
    }

    public static function getInfoMessages()
    {
        return self::getMessages(self::MESSAGE_INFO_SESSION_KEY);
    }

    public static function getSuccessMessages()
    {
        return self::getMessages(self::MESSAGE_SUCCESS_SESSION_KEY);
    }

    public static function getErrorMessages()
    {
        return self::getMessages(self::MESSAGE_ERROR_SESSION_KEY);
    }

    private static function getMessages($key)
    {
        $session = Lib_Session_Namespace::instance();
        $messages = $session->{$key};
        $session->{$key} = null;
        return $messages;
    }

    public static function formMessages(array $data)
    {
        self::_recursiveFormMessages($data);
    }

    private static function _recursiveFormMessages($data)
    {
        if (is_array($data)) {
            foreach ($data as $value) {
                self::_recursiveFormMessages($value);
            }
        } elseif (is_string($data)) {
            self::info($data);
        }
    }

}

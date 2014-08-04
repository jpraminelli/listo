<?php

class Lib_View_Helper_FlashMessage extends Zend_View_Helper_Abstract
{

    public function flashMessage()
    {
        $infoMessages = '';
        $successMessages = '';
        $errorMessages = '';
        // Mensagens informativas
        $infoMessagesArray = Lib_FlashMessage::getInfoMessages();
        if (is_array($infoMessagesArray) && count($infoMessagesArray) > 0) {
            $infoMessages = '<div class="alert alert-info">';
            $infoMessages .= '<a class="close" data-dismiss="alert" href="#">×</a>';
            $infoMessages .= implode('<br />', $infoMessagesArray);
            $infoMessages .= '</div>';
        }
        // Mensagens de sucesso
        $successMessagesArray = Lib_FlashMessage::getSuccessMessages();
        if (is_array($successMessagesArray) && count($successMessagesArray) > 0) {
            $successMessages = '<div class="alert alert-success">';
            $successMessages .= '<a class="close" data-dismiss="alert" href="#">×</a>';
            $successMessages .= implode('<br />', $successMessagesArray);
            $successMessages .= '</div>';
        }
        // Mensagens de erro
        
        
        $errorMessagesArray = Lib_FlashMessage::getErrorMessages();
        if (is_array($errorMessagesArray) && count($errorMessagesArray) > 0) {
            $errorMessages = '<div class="alert alert-danger fade in" role="alert">';
            $errorMessages .= '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>';
            $errorMessages .= implode('<br />', $errorMessagesArray);
            $errorMessages .= '</div>';
        }
        // Bloco de mensagens
        $html = '';
        if ($infoMessages || $successMessages || $errorMessages) {
            $html = '<div class="flash_messages">' . $infoMessages . $successMessages . $errorMessages . '</div>';
        }
        return $html;
    }

}

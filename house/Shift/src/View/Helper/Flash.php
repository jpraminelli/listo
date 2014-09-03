<?php

namespace Shift\View\Helper;

use Shift\Mvc\Controller\Plugin\Flash as FlashPlugin;
use Zend\I18n\View\Helper\AbstractTranslatorHelper;

class Flash extends AbstractTranslatorHelper
{
    public function __invoke($partial = null)
    {
        if (!$partial) {
            $partial = 'shift.partial.flash';
        }
        $translator = $this->getTranslator();
        $translatorTextDomain = $this->getTranslatorTextDomain();
        $escapeHtmlHelper = $this->view->plugin('escapehtml');
        $flashPlugin = new FlashPlugin();
        $prms = array (
            'default_messages' =>
                $this->processMessages(
                    $flashPlugin->getMessages(FlashPlugin::NAMESPACE_DEFAULT),
                    $escapeHtmlHelper,
                    $translator,
                    $translatorTextDomain
                ),
            'success_messages' =>
                $this->processMessages(
                    $flashPlugin->getMessages(FlashPlugin::NAMESPACE_SUCCESS),
                    $escapeHtmlHelper,
                    $translator,
                    $translatorTextDomain
                ),
            'error_messages' =>
                $this->processMessages(
                    $flashPlugin->getMessages(FlashPlugin::NAMESPACE_ERROR),
                    $escapeHtmlHelper,
                    $translator,
                    $translatorTextDomain
                ),
            'info_messages' =>
                $this->processMessages(
                    $flashPlugin->getMessages(FlashPlugin::NAMESPACE_INFO),
                    $escapeHtmlHelper,
                    $translator,
                    $translatorTextDomain
                ),
        );
        return $this->getView()->partial($partial, $prms);
    }

    private function processMessages($messages, $escapeHtmlHelper, $translator, $translatorTextDomain)
    {
        if (is_array($messages)) {
            foreach ($messages as &$message) {
                $message = $escapeHtmlHelper($translator->translate(trim($message), $translatorTextDomain));
            }
        }
        return $messages;
    }
}

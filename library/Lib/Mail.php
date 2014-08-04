<?php

class Lib_Mail
{

    public function enviarEmail($emailOrigem, $nomeOrigem, $emailDestino, $nomeDestino, $assunto, $mensagem, $html = true, $bcc = null, $anexo = null)
    {
        // Se não estiver em produção, sobrescreve o email do destinatário para um email interno de teste
//        if (APPLICATION_ENV != 'production') {
//            $emailDestino = 'sistemas.teste@redemagic.com';
//        }
        // Método antigo "tradicional" da Magic de envio de e-mails
        $mail = new Zend_Mail();
        $html === true ? $mail->setBodyHtml($mensagem) : $mail->setBodyText($mensagem);
        if (is_array($emailDestino) && is_array($nomeDestino)) {
            foreach ($emailDestino as $k => $email) {
                $mail->addTo($email, $nomeDestino[$k]);
            }
        } else {
            $mail->addTo($emailDestino, $nomeDestino);
        }
        if (is_array($bcc)) {
            foreach ($bcc as $bccEmail => $bccNome) {
                $mail->addBcc($bccEmail, $bccNome);
            }
        }
        if ($anexo && $anexo['error'] == 0) {
            $attachment = $mail->createAttachment(file_get_contents($anexo['tmp_name']));
            $attachment->filename = $anexo['name'];
        }
        $mail
            ->setSubject($assunto)
            ->setFrom($emailOrigem, $nomeOrigem)
            ->setReturnPath($emailOrigem);
        if (APPLICATION_ENV != 'production') {
            $config = Lib_Config_Ini::instance();
            $smtp = $config->smtp->toArray();
            return $mail->send(new Zend_Mail_Transport_Smtp($smtp['host'], $smtp));
        } else {
            // O servidor de e-mail de produção é "local"
            return $mail->send();
        }
    }

}

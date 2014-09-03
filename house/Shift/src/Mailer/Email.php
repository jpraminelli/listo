<?php

namespace Shift\Mailer;

use Shift\SM;
use Zend\Mail\Message;

use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;

use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;

class Email
{
    private $config = array(); // config local.php
    public $from = array(); // array('nome' => 'Blabla', 'email', 'blabla@dominio.com.br')
    public $to = array(); // array( array('nome' => 'Blabla', 'email', 'blabla@dominio.com.br') )
    public $cc = array(); // array( array('nome' => 'Blabla', 'email', 'blabla@dominio.com.br') )
    public $assunto = null;
    public $template = null;
    public $anexo = array(); // inserir apenas o caminho completo do aquivo ex.: array('arquivo1.jpg', 'arquivo2.jpg')
    
    public function __construct() {
        $this->config = SM::get('config');
        $this->from = $this->config['mail']['from'];
    }

    public function envia()
    {

        // CRIA HTML
        $htmlPart = new MimePart($this->template);
        $htmlPart->type = "text/html";
        
        // SETA O HTML
        $body = new MimeMessage();
        $body->addPart($htmlPart);
        
        // SETA ANEXOS
        if($this->anexo){
            
             foreach ($this->anexo as $anexo)
            {
                $attachment = new MimePart( file_get_contents($anexo) );
                $attachment->type = \Zend\Mime\Mime::TYPE_OCTETSTREAM;
                $attachment->filename = basename($anexo);
                $attachment->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
                $attachment->encoding = \Zend\Mime\Mime::ENCODING_BASE64;

                $body->addPart($attachment);
            }            
        } 
        
        // CRIA A MENSAGEM DE EMAIL
        $mail = new Message();
        
        // CODIFICACAO
        $mail->setEncoding('UTF-8');
        
        // SETA OS CABEÇALHOS
        $headers = $mail->getHeaders();
        $headers->removeHeader('Content-Type');
        $headers->addHeaderLine('Content-Type', 'text/html; charset=UTF-8');
        
        // SETA O ASSUNTO
        $mail->setSubject($this->assunto);
        
        // INSERE O CORPO DA MENSAGEM
        $mail->setBody($body); 
        
        // SETA O EMAIL QUEM ESTÁ ENVIANDO
        $mail->setFrom($this->from['email'], $this->from['nome']);              
        
        // SETA OS DESTINATÁRIOS
        foreach($this->to as $to){

            // verifica se está em ambiente de produção
            if (APP_ENV == ENV_PRO) {
                $mail->addTo($to['email'], $to['nome']);
                $mail->addReplyTo($to['email'], $to['nome']);
            } else {
                
                // caso não seja produção, envia somente para o emails da magic
                if (strpos($to['email'], '@magicwebdesign.com.br') !== false || strpos($to['email'], '@redemagic.com') !== false) {
                    $mail->addTo($to['email'], $to['nome']);
                    $mail->addReplyTo($to['email'], $to['nome']);
                } else {
                    $mail->addTo('sistemas@redemagic.com', $to['nome']);
                    $mail->addReplyTo('sistemas@redemagic.com', $to['nome']);
                }
            }
        }
        
        // SETA CÓPIAS
        foreach($this->cc as $cc){
            
            // verifica se está em ambiente de produção
            if (APP_ENV == ENV_PRO) {
                $mail->addCc($cc['email'], $cc['nome']);
            } else {
                
                // caso não seja produção, envia somente para o emails da magic
                if (strpos($cc['email'], '@magicwebdesign.com.br') !== false || strpos($cc['email'], '@redemagic.com') !== false) {
                    $mail->addCc($cc['email'], $cc['nome']);
                } else {
                    $mail->addCc('sistemas@redemagic.com', $cc['nome']);
                }
            }
        }
        
        // SETA AS CONFIGURAÇÕES DE SMTP config/autoload/local.php
        $transport = new Smtp();
        $options = new SmtpOptions($this->config['mail']['smtp_options']);
        $transport->setOptions($options);
        
        // ENVIA O EMAIL
        $transport->send($mail);
    }
}

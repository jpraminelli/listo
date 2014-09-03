<?php

namespace Application\Mailer;

use Shift\SM;
use Shift\Mailer\Email;

class ApplicationMailer
{
    
    public function enviaEmail(){
        
        $email = new Email();
        
        // seta destinatarios, array()
        $email->to[] = array( 'email' => 'elton@magicwebdesign.com.br', 'nome' => 'teste');
        
        // seta o assunto
        $email->assunto = 'Hola que tal!';
        
        // insere anexo
        //$email->anexo[] = 'http://localhost/projeto_padrao_zf2/public/assets/application/img/master-desligado.jpg';
        //$email->anexo[] = 'http://localhost/projeto_padrao_zf2/public/assets/application/img/master-ligado.jpg';
        //$email->anexo[] = 'http://localhost/projeto_padrao_zf2/public/assets/application/img/mastercard.png';
        //$email->anexo[] = 'http://localhost/projeto_padrao_zf2/public/assets/application/img/numero-cadastro-com-sucesso.jpg';
        
        // seta o template, ele deve ser inserido no module.config.php em template_map
        $email->template = SM::get('ViewRenderer')->render('email/template', array('nome' => 'Elton', 'pontos' => '1546344'));
        
        $email->envia();
        
    }

}

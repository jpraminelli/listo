<?php

namespace Noticias\Controller;

use Shift\SM;
use Noticias\Entity\Noticia;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;

use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;

class CadastroController extends AbstractActionController
{
    public function indexAction()
    {

        $noticia = new Noticia();
        $form = SM::get('noticias.form.cadastro');

        $form->bind($noticia);
        
        if ($this->request->isPost()) {
            
            $retorno = array();
            
            // seta os filtros para validacao do form
            $form->setInputFilter($noticia->getInputFilter());

            // seta os campos que deve ser validados
            $form->setValidationGroup('id', 'titulo', 'chamada', 'descricao', 'visivel', 'validator', 'security', 'captcha');

            $form->setData($this->request->getPost());

            if ($form->isValid()) {
                $this->removeImagemCaptcha();
                $this->flash()->success('Operação realizada com sucesso.');
                $retorno['code'] = 'OK';
            } else {
                $retorno['code'] = 'ERROR';
                $retorno['errors'] = $form->getMessages();
                $retorno['flashError'] = 'Um ou mais erros impedem a gravação dos dados.';
            }
            return new JsonModel($retorno);
        }
        $form->prepare();
        
        return array(
            'form' => $form,
        );
    }
    
    /*
     * gera imagem do captcha
     */
    function geraImagemAction()
    {
        $this->removeImagemCaptcha();
        
        $form = SM::get('noticias.form.cadastro');
        $captcha = $form->get('security')->getCaptcha();

        $data = array();

        $data['id']  = $captcha->generate();
        $data['src'] = $captcha->getImgUrl() .
                       $captcha->getId() .
                       $captcha->getSuffix();

       return new JsonModel($data);
        
    }
    
    
    function removeImagemCaptcha($sessao = array()){
        
        if(!$sessao){
            $sessao = $_SESSION;
        }
        
        if($sessao) foreach($_SESSION as $key => $value){
            
            if(preg_match('/^(Zend_Form_Captcha_)/', $key)){
                
                $id = preg_replace('/^(Zend_Form_Captcha_)/', '', $key);
                $imagem = realpath('.') . '/public/files/captcha/' . $id . '.png';
                
                if(file_exists($imagem)){
                    unlink($imagem);
                }
                
                unset($_SESSION[$key]);
            }
        }
        
        if(!$sessao){
            $this->removeImagemCaptcha($_SESSION['__ZF']);
        }
        
        unset($_SESSION['Zend_Form_Captcha']);
    }
}

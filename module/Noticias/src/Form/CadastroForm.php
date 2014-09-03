<?php

namespace Noticias\Form;

use Zend\Form\Form;
use Zend\Form\Element\Captcha;
use Zend\Captcha\Image as CaptchaImage;

class CadastroForm extends Form
{

    public function __construct()
    {
        parent::__construct('noticia_form');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'validator',
            'type' => 'Shift\Form\Element\Csrf',
        ));
        $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        $this->add(array(
            'name' => 'titulo',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'nome',
                'maxlength'  => 100,
            ),
        ));
        $this->add(array(
            'name' => 'chamada',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'chamada',
                'rows'  => 4,
            ),
        ));
        $this->add(array(
            'name' => 'descricao',
            'type' => 'Zend\Form\Element\Textarea',
            'attributes' => array(
                'class'  => 'form-control',
                'id'  => 'descricao',
                'rows'  => 10,
            ),
        ));
        
        $this->add(array(
            'name' => 'visivel',
            'type' => 'Zend\Form\Element\Checkbox',
            'attributes' => array(
                'id'  => 'visivel',
            ),
        ));
        
        
        /*
         * CAPTCHA
         */

        //pass captcha image options
        $captchaImage = new CaptchaImage(  array(
            'font' => realpath('.') . '/public/files/fonts/OpenSans-Regular.ttf',
            'width' => 130,
            'height' => 80,
            'dotNoiseLevel' => 40,
            'lineNoiseLevel' => 3,
            'setGcFreq' => 1,
            'wordlen' => 4,
            'fsize' => 30
        ));
        
        $captchaImage->setImgDir(realpath('.') . '/public/files/captcha');
        $captchaImage->setImgUrl(WWWROOT . '/files/captcha');
 
        //add captcha element...
        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'security',
            'attributes' => array(
                'id'  => 'security',
            ),
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => $captchaImage,

            ),
        ));
        
        //add captcha element...
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'captcha',            
        ));
        
        $this->add(array(
            'type' => 'Submit',
            'name' => 'salvar'
        ));
    }
    
    public function isValid() {
        
        if($this->get('captcha')->getValue() != ''){
            return false;
        }
        
        return parent::isValid();
        
    }

}

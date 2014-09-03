<?php

namespace Usuarios\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Shift\Entity\BaseEntity;
use Shift\SM;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

/**
 * @ORM\Table(name="usuarios")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Usuario extends BaseEntity
{

    /**
     * @ORM\Column(type="string")
     */
    protected $nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $login;

    /**
     * @ORM\Column(type="string")
     */
    protected $senha;

    /**
     * @ORM\Column(type="string")
     */
    protected $perfil;
    
    /**
     * @ORM\Column(type="integer")
     */
    protected $tentativas_login;

    /**
     * @var boolean
     */
    private $enviarEmail = false;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Define os campos nome e perfil (caso estejam vazios) de acordo com a informação do ponto.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function defineNomeEPerfil()
    {
       
        // definição do perfil do usuário
        if (!$this->getPerfil()) {
            $this->setPerfil('indefinido');
        }
    }
    
    /**
     * Define tentativas
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function defineTentativas()
    {
       
        // definição do perfil do usuário
        if (!$this->getTentativasLogin()) {
            $this->setTentativasLogin(0);
        }
    }

    public function setNome($nome)
    {
        $this->nome = $nome;
        return $this;
    }

    public function getNome()
    {
        return $this->nome;
    }

    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setSenha($senha)
    {
         if ($senha) {
            $this->senha = md5(SALT . $senha);
            $this->senhaCrua = $senha;
        }

        return $this;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
        return $this;
    }

    public function getPerfil()
    {
        return $this->perfil;
    }
    
    public function setTentativasLogin($tentativasLogin)
    {
        $this->tentativas_login = $tentativasLogin;
        return $this;
    }

    public function getTentativasLogin()
    {
        return $this->tentativas_login;
    }
    
    /**
     * Configura os filtros dos campos da entidade
     *
     * @return Zend\InputFilter\InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            
            $em = SM::get('doctrine.entitymanager.orm_default');

            $inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'nome',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 50,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'login',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 50,
                        ),
                    ),
                    array(
                        'name' => 'DoctrineModule\Validator\UniqueObject',
                        'options' => array(
                            'object_manager' => $em,
                            'object_repository' => $em->getRepository('Usuarios\Entity\Usuario'),
                            'fields' => 'login',
                            'messages' => array(
                                'objectNotUnique' => 'Este login não pode ser utilizado.',
                            ),
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'senha',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 20,
                        ),
                    ),
                    array(
                        'name' => 'Identical',
                        'options' => array(
                            'token' => 'senha2',
                            'messages' => array(
                                'notSame' => 'As senhas não combinam.',
                            ),
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'senha2',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'visivel',
                'required' => false,
            )));
            
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

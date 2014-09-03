<?php

namespace Noticias\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Shift\Entity\BaseEntity;
use Shift\SM;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;


/**
 * @ORM\Table(name="noticias")
 * @ORM\Entity
 */
class Noticia extends BaseEntity
{
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $titulo;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $chamada;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    protected $descricao;


    public function __construct()
    {
        parent::__construct();
    }

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }

    public function getTitulo()
    {
        return $this->titulo;
    }

    public function setChamada($chamada)
    {
        $this->chamada = $chamada;
        return $this;
    }

    public function getChamada()
    {
        return $this->chamada;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
        return $this;
    }

    public function getDescricao()
    {
        return $this->descricao;
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
                'name'     => 'titulo',
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
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'chamada',
                'required' => false,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'descricao',
                'required' => true,
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

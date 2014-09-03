<?php

namespace Shift\Entity;

use Doctrine\ORM\Mapping as ORM;
use Shift\SM;
use Shift\Entity\EntityFilter;

/**
 * BaseEntity
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
class BaseEntity extends EntityFilter
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="criacao", type="datetime")
     */
    protected $criacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modificacao", type="datetime")
     */
    protected $modificacao;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="exclusao", type="datetime", nullable=true)
     */
    protected $exclusao;

    /**
     * @var boolean
     *
     * @ORM\Column(name="visivel", type="boolean")
     */
    protected $visivel;

    public function __construct()
    {
        $this->setVisivel(true);
    }

    /**
     * Obtém o id da entidade.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Chamado automaticamente pelo entity manager do doctrine, define as datas de criação e modificação do registro.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function defineTimestamps()
    {
        $this->setModificacao(new \DateTime());
        if (!$this->getCriacao()) {
            $this->setCriacao($this->getModificacao());
        }
    }

    /**
     * Log das operações de insert e update.
     *
     * @ORM\PostPersist
     * @ORM\PostUpdate
     */
    public function log()
    {
        $log = array();
        // Identifica o usuário logado
        $usuarioLogado = SM::get('usuarios.session.usuarios')->getUsuarioLogado();
        if ($usuarioLogado) {
            $log['usuarioLogado'] = array('id' => $usuarioLogado->getId(), 'nome' => $usuarioLogado->getNome());
        } else {
            $log['usuarioLogado'] = array('id' => 0, 'nome' => 'Usuário não identificado');
        }
        // Nome da entidade
        $entidade = get_class($this);
        $log['entidade'] = substr($entidade, strrpos($entidade, '\\') + 1);
        // Trata os atributos
        $vars = get_object_vars($this);
        foreach ($vars as &$var) {
            if ($var instanceof BaseEntity) {
                $var = $var->getId();
            } else if ($var instanceof \Datetime) {
                $var = $var->format('d/m/Y H:i:s');
            }
        }
        // Se tiver um campo "senha", deverá ser omitido
        unset($vars['senha']);
        //
        $log['propriedades'] = $vars;
        $logger = SM::get('db_logger');
        $logger->info(json_encode($log));
        // $logger->info($vars);
    }

    /**
     * Seta a data e hora de criação da entidade.
     *
     * @param \DateTime $criacao
     * @return BaseEntity
     */
    public function setCriacao($criacao)
    {
        $this->criacao = $criacao;
        return $this;
    }

    /**
     * Obtém a data e hora de criação da entidade.
     *
     * @return \DateTime
     */
    public function getCriacao($formatted = false)
    {
        if ($formatted) {
            $formatter = SM::get('shift.formatter.date_time_formatter');
            return $formatter->format($this->criacao);
        }
        return $this->criacao;
    }

    /**
     * Seta a data e hora de modificação da entidade.
     *
     * @param \DateTime $modificacao
     * @return BaseEntity
     */
    public function setModificacao($modificacao)
    {
        $this->modificacao = $modificacao;
        return $this;
    }

    /**
     * Obtém a data e hora de modificação da entidade.
     *
     * @return \DateTime
     */
    public function getModificacao($formatted = false)
    {
        if ($formatted) {
            $formatter = SM::get('shift.formatter.date_time_formatter');
            return $formatter->format($this->modificacao);
        }
        return $this->modificacao;
    }

    /**
     * Seta a data e hora de exclusão da entidade.
     *
     * @param \DateTime $exclusao
     * @return BaseEntity
     */
    public function setExclusao($exclusao)
    {
        $this->exclusao = $exclusao;
        return $this;
    }

    /**
     * Obtém a data e hora de exclusão da entidade.
     * Este campo com o valor nulo significa que a entidade não foi excluída.
     *
     * @return \DateTime
     */
    public function getExclusao($formatted = false)
    {
        if ($formatted) {
            $formatter = SM::get('shift.formatter.date_time_formatter');
            return $formatter->format($this->exclusao);
        }
        return $this->exclusao;
    }

    /**
     * Define se a entidade deve ou não estar visível.
     *
     * @param boolean $visivel
     * @return BaseEntity
     */
    public function setVisivel($visivel)
    {
        $this->visivel = $visivel;
        return $this;
    }

    /**
     * Obtém o status de visibilidade da entidade.
     *
     * @return boolean Retorna true se a entidade estiver visível ou false caso não esteja.
     */
    public function isVisivel()
    {
        return $this->visivel;
    }
    
}

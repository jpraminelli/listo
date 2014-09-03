<?php

namespace Shift\Service;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Shift\SM;

class BaseService
{

    /** @var Connection */
    protected $conn;

    /** @var EntityManager */
    protected $em;

    public function __construct()
    {
        $this->conn = SM::get('doctrine.connection.orm_default');
        $this->em = SM::get('doctrine.entitymanager.orm_default');
    }

}

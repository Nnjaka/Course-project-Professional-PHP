<?php

namespace App\Repositories;

use App\Connections\SqlLiteConnector;
use App\Connections\SqlLiteConnectorInterface;
use App\Classes\EntityInterface;

abstract class EntityRepository implements EntityRepositoryInterface
{
    protected SqlLiteConnectorInterface $connector;

    public function __construct(SqlLiteConnectorInterface $sqlLiteConnector = null)
    {
        $this->connector = $sqlLiteConnector ?? new SqlLiteConnector();
    }

    abstract public function save(EntityInterface $entity): void;
    abstract public function get(int  $id): EntityInterface;
    abstract public function delete(int $id): void;
}

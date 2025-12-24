<?php

declare(strict_types=1);

namespace Magma\Base;

use Magma\Base\Exception\BaseInvalidArgumentException;
use Magma\LiquidOrm\DataRepository\DataRepositoryFactory;
use Magma\LiquidOrm\DataRepository\DataRepository;

class BaseModel
{
    
    /** @var string */
    private string $tableSchema;
    
    /** @var string */
    private string $tableSchemaID;

    /** @var Object */
    private Object $repository;

    /**
     * Main class constructor
     *
     * @param string $tableSchema
     * @param string $tableSchemaID
     * @return void
     * @throws BaseInvalidArgumentException
     */
    public function __construct()
    {

        if (empty($tableSchema) || empty($tableSchemaID))
        {
            throw new BaseInvalidArgumentException('Arguments tableSchema and tableSchemaID are required.');
        }

        $factory = new DataRepositoryFactory('', $tableSchema, $tableSchemaID);
        $this->repository = $factory->create(DataRepository::class);
    }

    /**
     * Get the data repository object based on the context model
     * which the repository is being executed from.
     *
     * @return DataRepository
     */
    public function getRepo() : DataRepository
    {
        return $this->repository;
    }

}
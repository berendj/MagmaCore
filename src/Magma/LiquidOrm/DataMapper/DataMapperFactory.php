<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

class DataMapperFactory
{
    /**
     * Main constructor class
     */
    public function __construct()
    {

    }

    /**
     * Create a datamapper 
     * 
     * @param string $databaseConnectionString
     * @param string $dataMapperEnvironmentConfiguration
     * @return DataMapperInterface
     */
    public function create(string $databaseConnectionString, string $dataMapperEnvironmentConfiguration) : DataMapperInterface
    {
        $credentials = (new dataMapperEnvironmentConfiguration([]))->getDatabaseCredentials('mysql');
        $databaseConnectionObject = $databaseConnectionString($credentials);
        if (!$databaseConnectionObject instanceof DatabaseConnectionInterface)
        {
            throw new DataMapperException($databaseConnectionString . ' is not a valid database connection object');
        }
        return new DataMapper($databaseConnectionObject);
    }

}
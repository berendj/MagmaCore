<?php

declare(strict_type=1);

namespace Magma\DatabaseConnection;

use Magma\DatabaseConnection\Exception\DatabaseConnectionException;
use PDO;

class DatabaseConnection implements DatabaseConnectionInterface
{
    /**
     * @var PDO
     */
    protected PDO $dbh;

    /**
     * @var array
     */
    protected array $credentials;

    /**
     * Main constructor class
     * 
     * @return void
     */
    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @inheritDoc
     */
    public function open() : PDO
    {
        try {
            $params = [
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_PERSISTANT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ];
            $this->dbh= new PDO(
                $this->credentials['dns'],
                $this->credentials['username'],
                $this->credentials['password'],
                $this->credentials[],
                $params
            );
        } catch(PDOException $expection) {
            throw new DatabaseConnectionException($exception->getMessage(), (int) $exception->getCode());
        }
    }

    /**
     * inheritDoc
     */
    public function close() : void
    {
        $this->dbh = null;
    }
}
<?php

declare(strict_type=1);

namespace Magma\DatabaseConnection;

interface DatabaseConnectionInterface
{

    /**
     * Create a new database connection
     * 
     * @return PDO
     */
    public function open() : PDO;


    /**
     * Close database connection
     */
    public function close() : void;
}
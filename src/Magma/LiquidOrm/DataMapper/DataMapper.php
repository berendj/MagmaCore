<?php

declare(strict_types=1);

namespace Magma\LiquidOrm\DataMapper;

use Magma\LiquidOrm\DataMapper\Exception\DataMapperInvalidArgumentException;
use Magma\DatabaseConnection\DatabaseConnectionInterface;
use PDOStatement;
use Throwable;
use PDO;

class DataMapper implements DataMapperInterface
{

    /**
     * @var DatabaseConnectionInterface
     */
    private DatabaseConnectionInterface $dbh;

    /**
     * @var PDOStatement
     */
    private PDOStatement $statement;

    /**
     * Main constructor class
     */
    public function __construct(DatabaseConnectionInterface $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @inheritDoc
     */
    private function isEmpty($value, string $errormessage = null)
    {
        if (empty($value))
        {
            throw new DataMapperException($errormessage);
        }
    }

    /**
     * @inheritDoc
     */
    private function isArray(array $value)
    {
        if (!is_array($value))
        {
            throw new DataMapperException("Your argument needs to be an array");
        }
    }

    /**
     * @inheritDoc
     */
    public function prepare(string $sqlQuery) : self
    {
        $this->statement = $this->dbh->open()->prepare($sqlQuery);
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function bind($value)
    {
        try 
        {
            switch($value)
            {
                case is_bool($value):
                case intval($value);
                    $dataType = PDO::PARAM_INT;
                    break;
                case is_null($value):
                    $dataType = PDO::PARAM_NULL;
                    break;
                default :
                    $dataType = PDO::PARAM_STR;
                    break;
            }
            return dataType;
        } catch(DataMapperException $exception) {
            throw $exception;
        }
    }

    /**
     * @inheritDoc
     */
    public function bindValue(array $fields, bool $isSearch = false) : self
    {
        if (is_array($fields))
        {
            $type = ($isSearch === false) ? $this->bindValues($fields) : $this->bindSearchValues($fields);
            if ($type)
            {
                return $this;
            }
        }
        return false;
    }

    /**
     * Bind a value to a corresponding name or question mark placeholder in the 
     * SQL statement that was used to prepare the statement
     * 
     * @array $fields
     * @return PDOStatement
     * @throws DataMapperExeption
     */
    protected function bindValues(array $fields)
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value)
        {
            $this->statement->bindValue(':'.$key, $value, $this->bind($value));
        }
        return $this->statement;
    }

    /**
     * @inheritDoc
     */
    protected function bindSearchValues(array $fields)
    {
        $this->isArray($fields);
        foreach ($fields as $key => $value)
        {
            $this->statement->bindValue(':'.$key, '%' . $value . '%', $this->bind($value));
        }
        return $this->statement;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        if ($this->statement)
        {
            return $this->statement->execute();
        }
    }

    /**
     * @inheritDoc
     */
    public function numRows() : int
    {
        if ($this->statement)
        {
            return $this->statement->rowCount();
        }
    }

    /**
     * @inheritDoc
     */
    public function result() : Object
    {
        if ($this->statement)
        {
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }

    }

    /**
     * @inheritDoc
     */
    public function results() : array
    {
        if ($this->statement)
        {
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }

    }

    /**
     * @inheritDoc
     * @throws Throwable
     */
    public function getLastId() : int
    {
        try {
            if ($this->dbh->open()) {
                $lastID = $this->dbh->open()->lastInsertId();
                if (!empty($lastID))
                {
                    return intval($lastID);
                }
            }
        } catch (Throwable $throwable) {
            throw $throwable;
        }
    }

    /**
     * Returns the query condition merged with the query parameters
     * 
     * @param array $conditions
     * @param array $parameters
     * @return array
     */
    public function buildQueryParameters(array $conditions, array $parameters) : array
    {
        return (!empty($parameters) || (!empty($conditions)) ? array_merge($conditions, $parameters) : $parameters);
    }


    /**
     * Persist queries to database
     * 
     * @param string $sqlQuery
     * @param array $parameters
     * @return mixed
     * @throws Throwable
     */
    public function persist(string $sqlQuery, array $parameters)
    {
        try {
            return $this->prepare($sqlQuery)->bindParameters($parameters)->execute();
        } catch(Throwable $throwable) {
            throw $throwable;
        }
    }
}
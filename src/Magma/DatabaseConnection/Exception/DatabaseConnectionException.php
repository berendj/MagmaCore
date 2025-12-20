<?php

declare(strict_type=1);

namespace Magma\DatabaseConnection\Exception;

use PDOException;

class DatabaseConnectionEception extends PDOException
{
    protected $message;

    protected $code;

    public function __construct($message = null, $code = null)
    {
        $this->message = $message;
        $this->code = $code;
    }
}

<?php

Declare(strict_types=1);

namespace Magma\GlobalManager;

use Magma\GlobalManager\GlobalManagerInterface;
use Magma\GlobalManager\Exception\GlobalManagerException;
use Magma\GlobalManager\Exception\GlobalManagerInvalidArgumentException;
use Throwable;

class GlobalManager implements GlobalManagerInterface
{
    

    /**
     * @inheritDoc
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value): void
    {
        $GLOBALS[$key] = $value;
    }

    /**
     * @inheritDoc
     *
     * @param string $key
     * @return mixed
     * @throws GlobalManagerException
     */
    public static function get(string $key)
    {
        self::isGlobalValid($key);
        try {
            return $GLOBALS[$key];
        } catch(Throwable $throwable) {
            throw new GlobalManagerException("An exception was thrown trying to retrieve the data.");
        }
/*
        if (!$this->has($key)) {
            return $this->globals[$key];
        }
*/
        }

    /**
     * Check if we have a valid key and its not empty else throw an exception
     *
     * @param string $key
     * @return void
     * @throws GlobalManagerInvalidArgumentException
     */
    public static function isGlobalValid(string $key): void
    {
        if (!isset($GLOBALS[$key])) {
            throw new GlobalManagerInvalidArgumentException('Invalid global key. Please ensure you have set the global state for ' . $key);
        }
        if (empty($key))
        {
            throw new GlobalManagerInvalidArgumentException('Argument cannot be empty.');
        }
    }
}

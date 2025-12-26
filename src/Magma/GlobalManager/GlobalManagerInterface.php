<?php

Declare(strict_types=1);

namespace Magma\GlobalManager;

interface GlobalManagerInterface
{

    /**
     * Set a global variable
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, $value): void;

    /**
     * Get a global variable
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key);

}
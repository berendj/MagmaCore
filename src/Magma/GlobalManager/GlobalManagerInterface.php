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
    public function set(string $key, $value): void;

    /**
     * Get a global variable
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key);

    /**
     * Check if a global variable exists
     *
     * @param string $key
     * @return bool
     */
//    public function has(string $key): bool;

    /**
     * Remove a global variable
     *
     * @param string $key
     * @return void
     */
//    public function remove(string $key): void;
}
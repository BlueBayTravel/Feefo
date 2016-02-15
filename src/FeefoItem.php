<?php

/*
 * This file is part of Feefo.
 *
 * (c) Blue Bay Travel <developers@bluebaytravel.co.uk>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace BlueBayTravel\Feefo;

class FeefoItem
{
    /**
     * Array of data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Create a new feefo item instance.
     *
     * @param array $data
     *
     * @return void
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Magic method to get back from Feefo item.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        $safeKey = $this->safe($name);
        if (isset($this->data[$safeKey])) {
            return $this->data[$safeKey];
        }
    }

    /**
     * Magic method to check if an item is set.
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        $safeKey = $this->safe($name);

        return isset($this->data[$safeKey]);
    }

    /**
     * Make the key name safe.
     *
     * @param string $key
     *
     * @return string
     */
    protected function safe($key)
    {
        return str_replace('_', '', strtoupper($key));
    }
}

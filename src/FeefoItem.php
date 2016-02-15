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

use ArrayAccess;

/**
 * This is the feefo item.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
class FeefoItem implements ArrayAccess
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
        $name = $this->normalize($name);
        if (isset($this->data[$name])) {
            return $this->data[$name];
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
        $name = $this->normalize($name);

        return isset($this->data[$name]);
    }

    /**
     * Assigns a value to the specified offset.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * Whether or not an offset exists.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * Unsets an offset.
     *
     * @param mixed $offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        if ($this->offsetExists($offset)) {
            unset($this->data[$offset]);
        }
    }

    /**
     * Returns the value at specified offset.
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->data[$offset] : null;
    }

    /**
     * Normalize the given string.
     *
     * @param string $key
     *
     * @return string
     */
    protected function normalize($key)
    {
        return str_replace('_', '', strtoupper($key));
    }
}

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
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        $safeKey = str_replace('_', '', strtoupper($key));
        if (isset($data[$safeKey])) {
            return $data[$safeKey];
        }
    }
}

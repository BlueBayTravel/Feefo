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
use Countable;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Contracts\Config\Repository;
use SimpleXMLElement;

/**
 * This is the feefo class.
 *
 * @author James Brooks <james@bluebaytravel.co.uk>
 */
class Feefo implements ArrayAccess, Countable
{
    /**
     * The guzzle client.
     *
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * The config repository.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The review items.
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new feefo instance.
     *
     * @param \GuzzleHttp\Client                      $client
     * @param \Illuminate\Contracts\Config\Repository $config
     *
     * @return void
     */
    public function __construct(Client $client, Repository $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Fetch feedback.
     *
     * @param array|null $params
     *
     * @return \BlueBayTravel\Feefo\Feefo
     */
    public function fetch($params = null)
    {
        if ($params === null) {
            $params['json'] = true;
            $params['mode'] = 'both';
        }

        $params['logon'] = $this->config->get('feefo.logon');
        $params['password'] = $this->config->get('feefo.password');

        try {
            $body = $this->client->get($this->getRequestUrl($params));
        } catch (Exception $e) {
            // Ignore the exception.
        }

        return $this->parse((string) $body->getBody());
    }

    /**
     * Parses the response.
     *
     * @param string $data
     *
     * @return \Illuminate\Support\Collection
     */
    protected function parse($data)
    {
        $xml = new SimpleXMLElement($data);

        foreach ((array) $xml as $items) {
            if (isset($items->TOTALRESPONSES)) {
                continue;
            }

            foreach ($items as $item) {
                $this->data[] = new FeefoItem((array) $item);
            }
        }

        return $this;
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
     * Count the number of items in the dataset.
     *
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * Returns the Feefo API endpoint.
     *
     * @param array $params
     *
     * @return string
     */
    protected function getRequestUrl(array $params)
    {
        $query = http_build_query($params);

        return sprintf('%s?%s', $this->config->get('feefo.baseuri'), $query);
    }
}

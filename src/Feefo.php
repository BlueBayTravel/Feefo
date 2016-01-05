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

use Exception;
use GuzzleHttp\Client;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;
use SimpleXMLElement;

class Feefo
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
     * @return \Illuminate\Support\Collection
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

        $collection = new Collection();

        foreach ((array) $xml as $item) {
            $feefoItem = new FeefoItem((array) $item);
            $collection->push($feefoItem);
        }

        return $collection;
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

<?php

namespace AppBundle\HttpClient;

use AppBundle\Exceptions\HttpClientException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class GuzzleAdapter implements IHttpClient
{
    /**
     * @var ClientInterface
     */
    private $guzzleClient;

    public function __construct(ClientInterface $client)
    {
        $this->guzzleClient = $client;
    }

    public function get(string $url, array $headers = array()): ResponseInterface
    {
        try {
            return $this->guzzleClient->request('GET', $url);
        } catch (GuzzleException $e) {
            throw new HttpClientException();
        }
    }
}
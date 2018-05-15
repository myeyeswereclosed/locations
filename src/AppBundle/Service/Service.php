<?php

namespace AppBundle\Service;

use AppBundle\HttpClient\IHttpClient;
use AppBundle\Service\IResponseParser;

class Service implements ILocationsService
{
    const TEST_URL = 'http://localhost:8000/success_mock/';

    /**
     * @var IHttpClient
     */
    private $httpClient;

    /**
     * @var IResponseParser
     */
    private $responseParser;

    public function __construct(
        IHttpClient $client,
        IResponseParser $responseParser
    ) {
        $this->httpClient = $client;
        $this->responseParser = $responseParser;
    }

    public function getPlacesOfInterest() : array
    {
        return
            $this->responseParser->parse(
                $this->httpClient
                    ->get(self::TEST_URL)
                        ->getBody()
                            ->getContents()
            );
    }
}
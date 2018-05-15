<?php

namespace AppBundle\Service;

use AppBundle\Service\IResponseParser;
use GuzzleHttp\ClientInterface;

class LocationsService implements ILocationsService
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var IResponseParser
     */
    private $responseParser;

    public function __construct(
        ClientInterface $client,
        IResponseParser $responseParser
    ) {
        $this->httpClient = $client;
        $this->responseParser = $responseParser;
    }

    public function getPlacesOfInterest() : array
    {
        return
            $this->responseParser->parse(
                $this->httpClient->request(
                    'GET',
                    'http://localhost:8000/success_mock/'
                )
                    ->getBody()
                        ->getContents()
        );
    }
}
<?php

namespace AppBundle\Service;

use AppBundle\Exceptions\ErrorResponseException;
use AppBundle\Exceptions\InvalidResponseFormatException;
use AppBundle\Exceptions\MalformedJsonException;
use AppBundle\Model\Coordinates;
use AppBundle\Model\PlaceOfInterest;

class ResponseParser implements IResponseParser
{
    const RESULT_KEY = 'success';

    public function parse(string $responseData)
    {
        $decodedData = json_decode($responseData, true);

        if (!$this->responseDataIsValid()) {
            throw new MalformedJsonException();
        }

        return $this->parseValidJsonData($decodedData);
    }

    /**
     * @return boolean
     */
    private function responseDataIsValid()
    {
        return json_last_error() == JSON_ERROR_NONE;
    }

    /**
     * @param array $data
     * @return array
     * @throws ErrorResponseException
     * @throws InvalidResponseFormatException
     */
    private function parseValidJsonData(array $data)
    {
        if (!isset($data[self::RESULT_KEY])) {
            throw new InvalidResponseFormatException();
        }

        return $this->parseCorrectlyFormattedData($data);
    }

    /**
     * @param array $data
     * @return array
     * @throws ErrorResponseException
     */
    private function parseCorrectlyFormattedData(array $data)
    {
        if (!$data[self::RESULT_KEY]) {
            throw new ErrorResponseException($data['data']['message'], $data['data']['code']);
        }

        return $this->parseSuccessfulData($data);
    }

    /**
     * @param array $data
     * @return array
     */
    private function parseSuccessfulData(array $data)
    {
        return
            array_map(
                function (array $placeData)
                {
                    return new PlaceOfInterest(
                        $placeData['name'],
                        new Coordinates($placeData['coordinates']['lat'], $placeData['coordinates']['long'])
                    );
                },
                $data['data']['locations']
            );
    }
}